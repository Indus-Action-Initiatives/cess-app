<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProjectPaymentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('project_payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always'
                ]
            ]
        ]);
        $this->belongsTo('LabourCessProjects', [
            'foreignKey' => 'project_id'
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('project_id')
            ->allowEmptyString('project_id');

        $validator
            ->scalar('payment_mode')
            ->maxLength('payment_mode', 50)
            ->requirePresence('payment_mode', 'create')
            ->notEmptyString('payment_mode');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 50)
            ->requirePresence('payment_method', 'create')
            ->notEmptyString('payment_method');

        $validator
            ->scalar('document_reference_no')
            ->maxLength('document_reference_no', 100)
            ->allowEmptyString('document_reference_no');

        $validator
            ->scalar('bank_name_branch')
            ->maxLength('bank_name_branch', 255)
            ->allowEmptyString('bank_name_branch');

        $validator
            ->date('date_of_payment')
            ->allowEmptyDate('date_of_payment');

        $validator
            ->scalar('amount_paid')
            ->maxLength('amount_paid', 50)
            ->allowEmptyString('amount_paid');

        $validator
            ->scalar('attachment_description')
            ->maxLength('attachment_description', 200)
            ->allowEmptyString('attachment_description');

        $validator
            ->scalar('attachment_file_path')
            ->maxLength('attachment_file_path', 200)
            ->allowEmptyString('attachment_file_path');

        return $validator;
    }
}
