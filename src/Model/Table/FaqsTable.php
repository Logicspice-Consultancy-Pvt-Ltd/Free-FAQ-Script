<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FaqsTable extends Table {

    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('category_id', 'Category is required')
                ->notEmpty('question', 'Question is required')
                ->notEmpty('answer', 'Answer is required')
        ;
        return $validator;
    }

    public function validationEdit(Validator $validator) {
        $validator
                ->notEmpty('category_id', 'Category is required')
                ->notEmpty('question', 'Question is required')
                ->notEmpty('answer', 'Answer is required')
        ;
        return $validator;
    }

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Categories', [
            'className' => 'Categories',
            'foreignKey' => 'category_id',
            'propertyName' => 'categories'
        ]);
    }

}

?>