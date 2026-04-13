<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class ProjectStatusFlowTable extends Table {

	public function initialize(array $config): void {

		parent::initialize($config);
		$this->setTable('labour_cess_status_flow');
		$this->addBehavior('Timestamp');

		$this->belongsTo('LabourCessProjects', [
			'foreignKey' => 'project_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
	}

}