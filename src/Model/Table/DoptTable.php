<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class DoptTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('dopt');
        $this->belongsTo('Section', [
            'foreignKey' => 'section_code',
            'bindingKey' => 'section_code',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Division', [
            'foreignKey' => 'div_code',
            'bindingKey' => 'div_code',
            'joinType' => 'LEFT'
        ]);
        // $this->belongsTo('Users');
    }
}
