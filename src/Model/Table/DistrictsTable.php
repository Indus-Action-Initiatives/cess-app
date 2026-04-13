<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class DistrictsTable extends Table {

	public function initialize(array $config): void {

		$this->belongsToMany('Offices', [
			'joinTable' => 'office_districts',
			'foreignKey' => 'district_id',
			'targetForeignKey' => 'office_id'
		]);

		$this->hasMany('LabourCessProjects', [
			'foreignKey' => 'department_id'
    ]);
	}

}
