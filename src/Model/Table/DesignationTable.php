<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class DesignationTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('designation');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('dgcode', 'Designation code is required')
            ->add('dgcode', 'unique', [
                'rule' => function ($value, $context) {
                    // Convert input value to lowercase for case-insensitive check
                    $value = strtolower($value);
                    // Use the `find` method to query for case-insensitive uniqueness
                    $existing = $this->find()
                        ->where(['LOWER(dgcode)' => $value])
                        ->first();
                    // Return true if no existing record is found, false if one is found
                    return $existing === null;
                },
                'message' => 'Designation code must be unique',
            ]);
        
        return $validator;
    }
}
