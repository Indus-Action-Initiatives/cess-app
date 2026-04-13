<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class HelpdeskTicketsTable extends Table {

	public function initialize(array $config): void {
		$this->setTable('helpdesk_tickets');

		$this->belongsTo('HelpdeskUsers', [
			'foreignKey' => 'helpdesk_user_id'
		]);

		$this->hasMany('HelpdeskComments', [
			'foreignKey' => 'helpdesk_ticket_id'
		]);
	}
}