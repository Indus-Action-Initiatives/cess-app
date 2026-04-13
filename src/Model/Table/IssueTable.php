<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class IssueTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('issue');
        $this->belongsTo('Stocks',
        [
            'foreignKey' => 'item_code',
            'bindingKey' => 'item_code',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Section',
        [
            'foreignKey' => 'sec_code',        
            'bindingKey' => 'section_code',
            'joinType' => 'LEFT'
        ]);
      
        $this->belongsTo('Users',
        [
            'foreignKey' => 'user_id',        
            'bindingKey' => 'off_empcode',
            'joinType' => 'LEFT'
        ]);

        
        
    }
}
