<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Mailer\Email;

class AdminsController extends AppController {

    public $paginate = ['limit' => 1];
    var $components = array('RequestHandler', 'PImage');

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        $action = $this->request->params['action'];
        $loggedAdminId = $this->request->session()->read('admin_id');
        if ($action != 'forgotPassword' && $action != 'logout') { // check admin login session, direct to admin login if session not active
            if (!$loggedAdminId && $action != "login" && $action != 'captcha') {
                $this->redirect(['action' => 'login']);
            }
        }
    }
    
    //Admin login 

    public function login() {
        $this->set('title', ADMIN_TITLE . 'Admin Login');
        $this->viewBuilder()->layout('admin_login');

        $loggedAdminId = $this->request->session()->read('admin_id');
        if ($loggedAdminId) {
            $this->redirect(['action' => 'dashboard']);
        }

//         echo Configure::version(); exit;

        $admin = $this->Admins->newEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admins->patchEntity($admin, $this->request->data);
            if (count($admin->errors()) == 0) {
                $userName = $this->request->data['Admins']['username'];
                $password = $this->request->data['Admins']['password'];
                $adminInfo = $this->Admins->find()->where(['Admins.username' => $userName])->first();

                if ($adminInfo) {
                    if ($adminInfo->status == 0) {
                        $this->Flash->error('Your account got temporary disabled.');
                    } elseif (!empty($adminInfo) && crypt($password, $adminInfo->password) == $adminInfo->password) {

                        if (isset($this->request->data['Admins']['remember']) && $this->request->data['Admins']['remember'] == '1') {
                            setcookie("admin_username", $userName, time() + 60 * 60 * 24 * 100, "/");
                            setcookie("admin_password", $password, time() + 60 * 60 * 24 * 100, "/");
                        } else {
                            setcookie("admin_username", '', time() + 60 * 60 * 24 * 100, "/");
                            setcookie("admin_username", '', time() + 60 * 60 * 24 * 100, "/");
                        }
                        $this->request->session()->write('admin_id', $adminInfo->id);
                        $this->request->session()->write('admin_username', $userName);
                        $this->redirect(['action' => 'dashboard']);
//                        die;
                    } else {
                        $this->Flash->error('Invalid username or password.');
                    }
                } else {
                    $this->Flash->error('Invalid username or password.');
                }
            } else {
                $this->Flash->error('Please below listed errors.');
            }
        } else {
            if (isset($_COOKIE["admin_username"]) && isset($_COOKIE["admin_password"])) {
                $this->request->data['Admins']['username'] = $_COOKIE["admin_username"];
                $this->request->data['Admins']['password'] = $_COOKIE["admin_password"];
                $this->request->data['Admins']['remember'] = 1;
            }
        }
        $this->set('admin', $admin);
    }

        //logout admin 
    
    public function logout() {
        session_destroy();
        $this->Flash->success('Logout successfully.');
        $this->redirect(['action' => 'login']);
    }

    //admin dashboard 
    
    public function dashboard() {
        $this->set('title', ADMIN_TITLE . 'Admin Dashboard');
        $this->viewBuilder()->layout('admin');
        $this->set('dashboard', '1');
        $this->loadModel("Faqs");
        $total_faqs = $this->Faqs->find()->count();
        $this->set('total_faqs', $total_faqs);
    }

       //FAQ Chart 
    
    public function faqChart($dayCount = 2) {

        $this->loadModel("Faqs");
        switch ($dayCount) {
            case 0:
                $dayCount = 1;
                $today = date('Y-m-d') . ' 23:59:00';
                $lastday = date('Y-m-d') . ' 00:00:00';
                break;
            case 1:
                $dayCount = 1;
                $today = date('Y-m-d', strtotime("-1 day", strtotime(date('Y-m-d')))) . ' 23:59:00';
                $lastday = date('Y-m-d', strtotime("-1 day", strtotime(date('Y-m-d')))) . ' 00:00:00';
                break;
            case 2:
                $dayCount = 31;
                $today = date('Y-m-d') . ' 23:59:00';
                $lastday = date('Y-m-d', strtotime("-30 day", strtotime(date('Y-m-d')))) . ' 00:00:00';
                break;
            case 3:
                $dayCount = 365;
                $today = date('Y-m-d') . ' 23:59:00';
                $lastday = date('Y-m-d', strtotime("-365 day", strtotime(date('Y-m-d')))) . ' 00:00:00';
                break;
        }

        $catArray = array();
        $CTempArray = array();

        if ($dayCount == 365) {
            $countUserArray = $this->Faqs->find()->where(['Faqs.created <=' => $today, 'Faqs.created >=' => $lastday])->order(['created' => 'DESC'])->group(['MONTH(Faqs.created)'])->select([
                        'created',
                        'count' => $this->Faqs->find()->func()->count('*')
                    ])->toArray();
            foreach ($countUserArray as $row) {
                $CTempArray[date("Y-m", strtotime($row->created))] = $row->count;
            }

            $finalArray = array();
            $catArray = array();
            $strtotime = strtotime($lastday);
            for ($i = 0; $i <= 12; $i++) {
                $value = 0;
                $date = date('Y-m', $strtotime);
                if (array_key_exists($date, $CTempArray)) {
                    $value = $CTempArray[$date];
                }
                $finalArray[] = $value;
                $catArray[] = "'" . date('M', $strtotime) . "'";
                $strtotime = strtotime("+1month", $strtotime);
            }
        } else {

            $countUserArray = $this->Faqs->find()->where(['Faqs.created <=' => $today, 'Faqs.created >=' => $lastday])->order(['created' => 'DESC'])->group(['DAY(Faqs.created)'])->select([
                        'created',
                        'count' => $this->Faqs->find()->func()->count('*')
                    ])->toArray();
            $CTempArray = array();

            foreach ($countUserArray as $row) {
                $CTempArray[date("Y-m-d", strtotime($row->created))] = $row->count;
            }

            $finalArray = array();
            $strtotime = strtotime($lastday);
            for ($i = 0; $i < $dayCount; $i++) {
                $value = 0;
                $date = date('Y-m-d', $strtotime);
                if (array_key_exists($date, $CTempArray)) {
                    $value = $CTempArray[$date];
                }
                $datea = date('Y, m-1, d', $strtotime);
                $finalArray[] = "Date.UTC($datea), " . $value;
                $strtotime = $strtotime + 24 * 3600;
            }
        }

        $this->set('dayCount', $dayCount);
        $this->set('finalArray', "[" . implode('],[', $finalArray) . "]");
        $this->set('catArray', implode(', ', $catArray));

        $this->viewBuilder()->layout('');
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->layout(($this->request->is("ajax")) ? "" : "default");
            $this->viewBuilder()->templatePath('Element' . DS . 'Admin/chart');
            $this->render('faq_chart');
        }
    }
    
    //Side bar Configuration 

    public function leftBar() {
        $this->set('title', ADMIN_TITLE . 'Manage Sidebar');
        $this->viewBuilder()->layout('admin');
        $this->set('leftBar', '1');
        $admin = $this->Admins->newEntity();
//        print_r($this->request->data);die;
        if ($this->request->is('post')) {
            $admin = $this->Admins->patchEntity($admin, $this->request->data, ['validate' => 'leftBar']);
            if (count($admin->errors()) == 0) {
                $leftbar = $this->request->data['Admins']['leftbar'];
                $this->Admins->updateAll(['leftbar' => $leftbar], ['id' => $this->request->session()->read('admin_id')]);
                $this->Flash->success('Sidebar updated successfully.');
                $this->redirect(['action' => 'leftBar']);
            } else {
                $this->Flash->error('Please below listed errors.');
            }
        }
        $this->set('admin', $admin);
        $adminInfo = $this->Admins->find()->where(['Admins.id' => $this->request->session()->read('admin_id')])->first();
        $this->set('adminInfo', $adminInfo);
    }

}

?>