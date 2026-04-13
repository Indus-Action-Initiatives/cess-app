<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class OrderDetailsTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('order_details');
        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
        ]);
    }
}
