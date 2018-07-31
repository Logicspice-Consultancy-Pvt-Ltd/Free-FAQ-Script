<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Utility\Inflector;
use Cake\Mailer\Email;
use Cake\Controller\Component\FlashComponent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public function initialize() {
        parent::initialize();
    }

    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        return false;
    }

    public function getSlug($str, $table = 'Admins') {
        $slug = Inflector::slug($str);
        $slug = strtolower($slug);
        //$slug = 'dinesh-dhaker';
        $isRecord = $this->$table->find()->where([$table . '.slug like' => $slug . '%'])->order([$table . '.id' => 'DESC'])->first();

        if ($isRecord) {
            $oldslug = explode('-', $isRecord->slug);
            $last = array_pop($oldslug);
            $slug = $last;
            if (is_numeric($last)) {
                $last = $last + 1;
                $slug = $slug . '-' . $last;
            } else {
                $slug = $slug . '-' . $last . '-1';
            }

            return $slug . time();
        } else {
            return $slug;
        }
    }

}
