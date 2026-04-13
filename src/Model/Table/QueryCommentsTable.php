<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class QueryCommentsTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);
		$this->setTable('query_comments');
		$this->addBehavior('Timestamp');

		$this->belongsTo('Queries', [
			'foreignKey' => 'query_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('Offices', [
			'foreignKey' => 'office_id',
		]);
	}

}