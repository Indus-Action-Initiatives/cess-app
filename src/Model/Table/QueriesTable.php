<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class QueriesTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);
		$this->setTable('queries');
		$this->addBehavior('Timestamp');

		$this->belongsTo('LabourCessProjects', [
			'foreignKey' => 'project_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('Offices', [
			'foreignKey' => 'office_id',
		]);
		$this->hasMany('QueryComments', [
			'foreignKey' => 'query_id'
		]);
	}

}