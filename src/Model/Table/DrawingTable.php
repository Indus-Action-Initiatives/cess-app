<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class DrawingTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('drawing');
        $this->belongsTo('Section', [
            'foreignKey' => 'section_id',
            'bindingKey' => 'section_code',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Division');
        //$this->belongsTo('Users');
        $this->belongsTo('Users', [
            'foreignKey' => 'off_empcode',
            'bindingKey' => 'off_empcode', // Ensure both tables use this key for association
        ]);
    }
}
