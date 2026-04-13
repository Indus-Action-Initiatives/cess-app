<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class ProjectCertificatesTable extends Table {

	public function initialize(array $config): void {

		parent::initialize($config);
		$this->setTable('project_certificates');

		$this->belongsTo('LabourCessProjects', [
			'foreignKey' => 'project_id',
		]);
	}

}