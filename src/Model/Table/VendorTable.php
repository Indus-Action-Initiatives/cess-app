<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class VendorTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('vendor');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('vcode', 'Vendor code is required')
            ->add('vcode', 'unique', [
                'rule' => function ($value, $context) {
                    // Convert the value to lowercase for case-insensitive comparison
                    $value = strtolower($value);
                    
                    // Check if a record already exists with the same value (case-insensitive)
                    $existing = $this->find()
                        ->where(['LOWER(vcode)' => $value])
                        ->first();
                    
                    // Return true if no matching record is found
                    return $existing === null;
                },
                'provider' => 'table',
                'message' => 'Vendor code must be unique',
            ]);
        
        return $validator;
    }
}

