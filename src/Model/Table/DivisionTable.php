<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DivisionTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('division');
    }

    // public function validationDefault(Validator $validator): Validator
    // {
    //     $validator
    //         ->notEmptyString('div_code', 'Division code is required')
    //         ->add('div_code', 'unique', [
    //             'rule' => function ($value, $context) {
    //                 // Convert the value to lowercase for case-insensitive comparison
    //                 $value = strtolower($value);
                    
    //                 // Check if a record already exists with the same value (case-insensitive)
    //                 $existing = $this->find()
    //                     ->where(['LOWER(div_code)' => $value])
    //                     ->first();
                    
    //                 // Return true if no matching record is found
    //                 return $existing === null;
    //             },
    //             'provider' => 'table',
    //             'message' => 'Division code must be unique',
    //         ]);
        
    //     return $validator;
    // }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('div_code', 'Division code is required')
            ->add('div_code', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Division code must be unique',
            ]);
        
        return $validator;
    }
}

