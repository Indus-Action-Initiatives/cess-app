<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class ObjectionCommentsTable extends Table {

	public function initialize(array $config): void {
    parent::initialize($config);
    $this->setTable('objection_comments');
		$this->addBehavior('Timestamp');

    $this->belongsTo('Objections', [
    	'foreignKey' => 'objection_id',
    ]);
    $this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('Offices', [
			'foreignKey' => 'office_id',
		]);
	}

}