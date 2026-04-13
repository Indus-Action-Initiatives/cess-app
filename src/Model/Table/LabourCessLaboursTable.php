<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class LabourCessLaboursTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('labour_cess_labours');
        $this->belongsTo('LabourCessProjects', [
            'foreignKey' => 'project_id'
        ]);
    }
}