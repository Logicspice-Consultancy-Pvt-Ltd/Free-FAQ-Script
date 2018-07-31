<?php

namespace App\Controller;

class HomesController extends AppController {

    public function initialize() {
        parent::initialize();

        // Include the FlashComponent
        $this->loadComponent('Flash');

        // Load Files model
        $this->loadModel('Files');
    }

    /*
      @description: This function used for homepage
      @author: info@logicspice.com
      @version: 1.0.0
      @since: 2017-01-05
     */

    public function index() {
        $this->viewbuilder()->layout("home");
        $this->set("title_for_layout", "Welcome" . TITLE_FOR_PAGES);
        $this->loadModel("Faqs");
        $this->loadModel("Categories");
        $this->loadModel("Admins");
        $categoriesList = $this->Categories->find()->where(['Categories.status' => '1'])->order(['order_by' => 'ASC'])->all();
        $this->set('categoriesList', $categoriesList);
        $adminInfo = $this->Admins->find()->where(['Admins.id' => '1'])->first();
        $this->set('adminInfo', $adminInfo);
    }

}

?>
