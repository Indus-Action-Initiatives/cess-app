<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class HelpdeskCommentsTable extends Table {

	public function initialize(array $config): void {
		$this->setTable('helpdesk_comments');
		$this->belongsTo('HelpdeskTickets', [
			'foreignKey' => 'helpdesk_ticket_id'
		]);
	}
}