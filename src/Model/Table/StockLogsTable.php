<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class StockLogsTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('stock_logs');
        $this->belongsTo('Vendor');
        $this->belongsTo('Stocks');
    }
}
