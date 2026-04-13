<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class ObjectionsTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);
		$this->setTable('objections');
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
		$this->hasMany('ObjectionComments', [
			'foreignKey' => 'objection_id'
		]);
	}

}