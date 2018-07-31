<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class AdminsTable extends Table {

    public function initialize(array $config) {

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->notEmpty('username', 'Username is required')
                ->notEmpty('password', 'Password is required');
        return $validator;
    }

    public function validationLeftBar(Validator $validator) {
        $validator
                ->notEmpty('leftbar', 'Option is required');
        return $validator;
    }

}

?>
