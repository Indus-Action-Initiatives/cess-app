<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class HelpdeskUsersTable extends Table {

	public function initialize(array $config): void {
		$this->setTable('helpdesk_users');
		$this->hasMany('HelpdeskTickets', [
			'foreignKey' => 'helpdesk_user_id'
		]);
	}
}