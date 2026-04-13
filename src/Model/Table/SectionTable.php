<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SectionTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('section');
        $this->belongsTo('Division');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('section_code', 'Section code is required')
            ->add('section_code', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Section code must be unique',
            ]);
        
        return $validator;
    }
}
