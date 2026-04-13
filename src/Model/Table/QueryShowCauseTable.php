<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class QueryShowCauseTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);
		$this->setTable('query_show_cause_logs');
		$this->addBehavior('Timestamp');

		$this->belongsTo('Queries', [
			'foreignKey' => 'query_id',
		]);
		$this->belongsTo('SentByUsers', [
			'className' => 'Users',
			'foreignKey' => 'from_user_id',
		]);
	}

}