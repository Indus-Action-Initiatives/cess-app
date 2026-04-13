<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class ReceiptTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('receipt');
        $this->belongsTo('Stocks',
        [
            'foreignKey' => 'item_code',
            'bindingKey' => 'item_code',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Vendor',
        [
            'foreignKey' => 'pur_from',        
            'bindingKey' => 'vcode',
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
