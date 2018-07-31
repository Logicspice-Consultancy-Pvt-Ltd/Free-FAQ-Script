<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

class CategoriesController extends AppController {

    public $paginate = ['limit' => 50, 'order' => ['Categories.name' => 'asc']];
    var $components = array('RequestHandler', 'PImage', 'PImageTest');

    //public $helpers = array('Javascript', 'Ajax');

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

        $this->set('title', ADMIN_TITLE . 'Manage Categories');
        $this->viewBuilder()->layout('admin');
        $this->set('categoryList', '1');

        $separator = array();
        $condition = array('Categories.parent_id' => 0);

        if ($this->request->is('post')) {
            if (isset($this->request->data['action'])) {
                $idList = implode(',', $this->request->data['chkRecordId']);
                $action = $this->request->data['action'];
                if ($idList) {
                    if ($action == "Activate") {
                        $this->Categories->updateAll(['status' => '1'], ["id IN ($idList)"]);
                        $this->Flash->success('Records are activated successfully.');
                    } elseif ($action == "Deactivate") {
                        $this->Categories->updateAll(['status' => '0'], ["id IN ($idList)"]);
                        $this->Flash->success('Records are deactivated successfully.');
                    } elseif ($action == "Delete") {
                        $this->Categories->deleteAll(["id IN ($idList)"]);
                        $this->Flash->success('Records are deleted successfully.');
                    }
                }
            }

            if (isset($this->request->data['Categories']['keyword']) && $this->request->data['Categories']['keyword'] != '') {
                $keyword = trim($this->request->data['Categories']['keyword']);
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
            $condition[] = "(Categories.name LIKE '%" . addslashes($keyword) . "%'  )";
            $this->set('keyword', $keyword);
        }
        //pr($condition);exit;
        $separator = implode("/", $separator);
        $this->set('separator', $separator);
        $this->paginate = ['conditions' => $condition, 'limit' => 20, 'order' => ['Categories.name' => 'ASC']];
        $this->set('categories', $this->paginate($this->Categories));
        if ($this->request->is("ajax")) {
            $this->viewBuilder()->layout(($this->request->is("ajax")) ? "" : "default");
            $this->viewBuilder()->templatePath('Element' . DS . 'Admin/Categories');
            $this->render('index');
        }
    }

    public function activatecategory($slug = null) {
        if ($slug != '') {
            $this->viewBuilder()->layout("");
            $this->Categories->updateAll(['status' => '1'], ["slug" => $slug]);
            $this->set('action', '/admin/categories/deactivatecategory/' . $slug);
            $this->set('status', 1);
            $this->viewBuilder()->templatePath('Element' . DS . 'Admin');
            $this->render('update_status');
        }
    }

    public function deactivatecategory($slug = null) {
        if ($slug != '') {
            $this->viewBuilder()->layout("");
            $this->Categories->updateAll(['status' => '0'], ["slug" => $slug]);
            $this->set('action', '/admin/categories/activatecategory/' . $slug);
            $this->set('status', 0);
            $this->viewBuilder()->templatePath('Element' . DS . 'Admin');
            $this->render('update_status');
        }
    }

    public function deletecategory($slug = null) {
        $this->Categories->deleteAll(["slug" => $slug]);
        $this->Flash->success('Category details deleted successfully.');
        $this->redirect(['controller' => 'categories', 'action' => 'index']);
    }

    public function add() {
        $this->set('title', ADMIN_TITLE . 'Add Category');
        $this->viewBuilder()->layout('admin');
        $this->set('categoryAdd', '1');
        $categories = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $data = $this->Categories->patchEntity($categories, $this->request->data, ['validate' => 'add']);

            if (count($data->errors()) == 0) {
                $slug = $this->getSlug($this->request->data['Categories']['name'] . ' ' . $this->request->data['Categories']['name'], 'Categories');
                $data->slug = $slug;
                $data->status = 1;
                $data->created = date('Y-m-d');
                $data->modified = date('Y-m-d');
                if ($this->Categories->save($data)) {
                    $this->Flash->success('Category details saved successfully.');
                    $this->redirect(['controller' => 'categories', 'action' => 'index']);
                }
            } else {
                // $this->Flash->error('Please below listed errors.');
            }
        }
        $this->set('categories', $categories);
    }

    public function edit($slug = null) {
        $this->set('title', ADMIN_TITLE . 'Edit Category');
        $this->viewBuilder()->layout('admin');
        $this->set('categoryList', '1');
        $isRecordid = '';
        if ($slug) {
            $categories1 = $this->Categories->find()->where(['Categories.slug' => $slug])->first();
            $uid = $categories1->id;
        }
        $categories = $this->Categories->get($uid);
        if ($this->request->is(['post', 'put'])) {
            $data = $this->Categories->patchEntity($categories, $this->request->data, ['validate' => 'edit']);
            if (count($data->errors()) == 0) {
                $order_by = $this->request->data['Categories']['order_by'];
//                echo $order_by;die;
                if ($order_by <> $categories1->order_by) {
                    $isRecord = $this->Categories->find()->where(['Categories.order_by' => $order_by])->first();
//                    print_r($isRecord);die;
                    $isRecordid = $isRecord->id;
                    $categories2 = $this->Categories->get($isRecordid);
                    $data1 = array();
                    $data1 = $this->Categories->patchEntity($categories2, $data1);
                    $data1->order_by = $categories1->order_by;
//                    echo '<pre>'; print_r($categories1->order_by);
                    $this->Categories->save($data1);
//                    die;
                }
                if ($this->Categories->save($data)) {
                    $this->Flash->success('Category details updated successfully.');
                    $this->redirect(['controller' => 'categories', 'action' => 'index']);
                }
            } else {
                // $this->Flash->error('Please below listed errors.');
            }
        }
        $this->set('categories', $categories);
    }

}

?>
