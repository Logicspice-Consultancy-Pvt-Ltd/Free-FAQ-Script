<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoriesTable extends Table {

    public function initialize(array $config) {

        $this->belongsTo('ParentCategories', [
            'foreignKey' => 'parent_id',
            'className' => 'Categories'
        ]);
    }

    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('name', 'Category name is required')
                ->add('name', 'custom', [
                    'rule' => function($value, $context) {
                        $name = $context['data']['name'];
                        $isRecord = $this->find()->where(['Categories.name' => $name])->first();
                        if ($isRecord) {
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'message' => 'Category name already exist, please try with other name',
                ])
                ->notEmpty('order_by', 'Order by is required')
                ->add('order_by', 'custom', [
                    'rule' => function($value, $context) {
                        $order_by = $context['data']['order_by'];
                        $isRecord = $this->find()->where(['Categories.order_by' => $order_by])->first();
                        
                        
                        if ($isRecord) {
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'message' => 'Order number already assigned, please try with other order number',
                ])

        ;
        return $validator;
    }

    public function validationEdit(Validator $validator) {
        $validator
                ->notEmpty('name', 'Category name is required')
                ->add('name', 'custom', [
                    'rule' => function($value, $context) {
                        $name = $context['data']['name'];
                        $id = $context['data']['id'];
                        $isRecord = $this->find()->where(['Categories.name' => $name, 'Categories.id <>' => $id])->first();
                        if ($isRecord) {
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'message' => 'Category name already exist, please try with other name',
                ])
                ->notEmpty('order_by', 'Order by is required')
                            
//                ->add('order_by', 'custom', [
//                    'rule' => function($value, $context) {
//                        $order_by = $context['data']['order_by'];
//                        $isRecord = $this->find()->where(['Categories.order_by' => $order_by])->first();
//                        if ($isRecord) {
//                            return false;
//                        } else {
//                            return true;
//                        }
//                    },
//                    'message' => 'Order number already assigned, please try with other order number',
//                ])
        ;
        return $validator;
    }

}

?>