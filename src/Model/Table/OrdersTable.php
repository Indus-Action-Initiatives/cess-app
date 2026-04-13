<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class OrdersTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('orders');
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'order_id'
        ]);
        $this->belongsTo('Section', [
            'foreignKey' => 'section_code',
            'bindingKey' => 'section_code',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Drawing', [
            'foreignKey' => 'section_code',
            'bindingKey' => 'section_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Users');
    }
}
