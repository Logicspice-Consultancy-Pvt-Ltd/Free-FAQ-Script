<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Mailer\Email;

class FaqsController extends AppController {

    public $paginate = ['limit' => 50];
    var $components = array('RequestHandler', 'PImage', 'PImageTest');

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        $action = $this->request->params['action'];
        $loggedAdminId = $this->request->session()->read('admin_id');
        if ($action != 'forgotPassword' && $action != 'logout') {
            if (!$loggedAdminId && $action != "login" && $action != 'captcha') {
                $this->redirect(['controller' => 'admins', 'action' => 'login']);
            }
        }
    }

    public function index() {
        $this->set('title', ADMIN_TITLE . 'FAQ Listing');
        $this->viewBuilder()->layout('admin');
        $this->set('faqsList', '1');

        $separator = array();
        $condition = array();

        if ($this->request->is('post')) {
            if (isset($this->request->data['action'])) {
                $idList = implode(',', $this->request->data['chkRecordId']);
                $action = $this->request->data['action'];
                if ($idList) {
                    if ($action == "Activate") {
                        $this->Faqs->updateAll(['status' => '1'], ["id IN ($idList)"]);
                        $this->Flash->success('Records are activated successfully.');
                    } elseif ($action == "Deactivate") {
                        $this->Faqs->updateAll(['status' => '0'], ["id IN ($idList)"]);
                        $this->Flash->success('Records are deactivated successfully.');
                    } elseif ($action == "Delete") {
                        $this->Faqs->deleteAll(["id IN ($idList)"]);
                        $this->Flash->success('Records are deleted successfully.');
                    }
                }
            }

            if (isset($this->request->data['Faqs']['keyword']) && $this->request->data['Faqs']['keyword'] != '') {
                $keyword = trim($this->request->data['Faqs']['keyword']);
            }
        } elseif ($this->request->params) {
            if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] != '') {
                $searchArr = $this->request->params['pass'];
                foreach ($searchArr as $val) {
                    if (strpos($val, ":") !== false) {
                        $vars = explode(":", $val);
                        ${$vars[0]} = urldecode($vars[1]);
                    }
                }
            }
        }

        if (isset($keyword) && $keyword != '') {
            $separator[] = 'keyword:' . urlencode($keyword);
            $condition[] = "(Faqs.question LIKE '%" . addslashes($keyword) . "%' OR Faqs.answer LIKE '%" . addslashes($keyword) . "%')";
            $this->set('keyword', $keyword);
        }

        $separator = implode("/", $separator);
        $this->set('separator', $separator);
        $this->paginate = ['conditions' => $condition,'contain' => ['Categories'],  'limit' => 20, 'order' => ['Faqs.id' => 'DESC']];
        $this->set('faqs', $this->paginate($this->Faqs));
        if ($this->request->is("ajax")) {
            $this->viewBuilder()->layout("");
            $this->viewBuilder()->templatePath('Element' . DS . 'Admin/Faqs');
            $this->render('index');
        }
    }

    public function activate($slug = null) {
        if ($slug != '') {
            $this->viewBuilder()->layout("");
            $this->Faqs->updateAll(['status' => '1'], ["slug" => $slug]);
            $this->set('action', '/admin/faqs/deactivate/' . $slug);
            $this->set('status', 1);
            $this->viewBuilder()->templatePath('Element' . DS . 'Admin');
            $this->render('update_status');
        }
    }

    public function deactivate($slug = null) {
        if ($slug != '') {
            $this->viewBuilder()->layout("");
            $this->Faqs->updateAll(['status' => '0'], ["slug" => $slug]);
            $this->set('action', '/admin/faqs/activate/' . $slug);
            $this->set('status', 0);
            $this->viewBuilder()->templatePath('Element' . DS . 'Admin');
            $this->render('update_status');
        }
    }

    public function delete($slug = null) {
        $this->Faqs->deleteAll(["slug" => $slug]);
        $this->Flash->success('FAQ details deleted successfully.');
        $this->redirect(['controller' => 'faqs', 'action' => 'index']);
    }

    public function add() {
        $this->set('title', ADMIN_TITLE . 'Add Faq');
        $this->viewBuilder()->layout('admin');
        $this->set('faqAdd', '1');
        $faqs = $this->Faqs->newEntity();
//        print_r($this->request->data);die;
        if ($this->request->is('post')) {
            $data = $this->Faqs->patchEntity($faqs, $this->request->data, ['validate' => 'add']);
            if (count($data->errors()) == 0) {
                $slug = $this->getSlug($this->request->data['Faqs']['question'], 'Faqs');
                $data->slug = $slug;
                $data->status = 1;

                if ($this->Faqs->save($data)) {
                    $this->Flash->success('FAQ details saved successfully.');
                    $this->redirect(['controller' => 'faqs', 'action' => 'index']);
                }
            } else {
                //$this->Flash->error('Please below listed errors.');
            }
        }
        $this->set('faqs', $faqs);
    }

    public function edit($slug = null) {
        $this->set('title', ADMIN_TITLE . 'Edit Faq');
        $this->viewBuilder()->layout('admin');
        $this->set('faqsList', '1');

        if ($slug) {
            $faqs = $this->Faqs->find()->where(['Faqs.slug' => $slug])->first();
            $uid = $faqs->id;
        }

        $faqs = $this->Faqs->get($uid);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->Faqs->patchEntity($faqs, $this->request->data, ['validate' => 'edit']);
            if (count($data->errors()) == 0) {
                if ($this->Faqs->save($data)) {
                    $this->Flash->success('FAQ details updated successfully.');
                    $this->redirect(['controller' => 'faqs', 'action' => 'index']);
                }
            }
        }
        $this->set('faqs', $faqs);
    }

    /*
      @description: This function used to upload image from CK editor
      @author: info@logicspice.com
      @version: 1.0.0
      @since: 2016-12-30
     */

    public function faqimages($slug = null) {
        $imageArray = $_FILES['upload'];
        $returnedUploadImageArray = $this->PImage->upload($imageArray, UPLOAD_PAGES_IMAGE_PATH);
        echo "<span style='font-size: 16px;  font-weight: bold;'>Copy below URL and Paste in next screen:</span> <span style='float: left; font-size: 14px; margin: 7px 0 0; width: 100%;'>" . DISPLAY_PAGES_IMAGE_PATH . $returnedUploadImageArray[0] . '</span>';
        exit;
        if (file_exists(UPLOAD_PAGES_IMAGE_PATH . $_FILES["upload"]["name"])) {
            echo $_FILES["upload"]["name"] . " already exists. ";
        } else {
            move_uploaded_file($_FILES["upload"]["tmp_name"], UPLOAD_PAGES_IMAGE_PATH . $_FILES["upload"]["name"]);
            echo "Coty below URL and Paste in next screen: " . DISPLAY_PAGES_IMAGE_PATH . $_FILES["upload"]["name"];
        }
        exit;
    }

}

?>
