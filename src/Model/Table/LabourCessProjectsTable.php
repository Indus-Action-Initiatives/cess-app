<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class LabourCessProjectsTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('labour_cess_projects');

        $this->hasMany('LabourCessLabours', [
            'foreignKey' => 'project_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('LabourCessAttachments', [
            'foreignKey' => 'project_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('ProjectPayments', [
            'foreignKey' => 'project_id',
            'dependent' => true,
        ]);
        $this->hasMany('ProjectStatusFlow', [
            'foreignKey' => 'project_id',
            'dependent' => true,
        ]);
        $this->hasMany('ProjectCertificates', [
            'foreignKey' => 'project_id',
            'dependent' => true,
        ]);
        $this->belongsTo('Districts', ['foreignKey' => 'district_id']);
        $this->belongsTo('Department', ['className' => 'Districts', 'foreignKey' => 'department_id']);
    }

    // public function validationDefault(Validator $validator): Validator{

    //     $validator
    //         ->notEmptyString('assessment_name')
    //         ->notEmptyString('department_id')
    //         ->notEmptyString('establishment_type_id')
    //         ->notEmptyString('district_id')
    //         ->notEmptyString('property_no')
    //         ->notEmptyString('supervisor_email')
    //         ->email('supervisor_email', false, 'Please enter a valid email.')
    //         ->notEmptyString('supervisor_mobile')
    //         ->notEmptyString('stage_of_construction')
    //         ->numeric('plot_area')
    //         ->numeric('construction_area')
    //         ->numeric('total_project_cost');

    //     return $validator;
    // }
}