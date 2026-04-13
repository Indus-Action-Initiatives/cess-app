<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Http\Response;
use Cake\Http\Exception\NotFoundException;
use Cake\Controller\Component\PaginatorComponent;
use Laminas\Diactoros\UploadedFile;
use Dompdf\Dompdf;
use Dompdf\Options;

class HelpdeskController extends AppController{

	public function initialize(): void {
		parent::initialize();
		$this->viewBuilder()->setLayout('page');
		$this->usersTable = TableRegistry::getTableLocator()->get('HelpdeskUsers');
		$this->ticketsTable = TableRegistry::getTableLocator()->get('HelpdeskTickets');
		$this->commentsTable = TableRegistry::getTableLocator()->get('HelpdeskComments');
	}

	public function add(){
		$title = 'Helpdesk - BOCW Cess Portal';
		$active = 'help';
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			//--- Create/Reuse Helpdesk User ---//
			$user = $this->usersTable->find()->where(['email' => $data['email']])->first();
			if (!$user) {
				$user = $this->usersTable->newEmptyEntity();
				$user->name = $data['name'];
				$user->email = $data['email'];
				$user->mobile = $data['mobile'];
				$this->usersTable->save($user);
			}
			// Create ticket
			$ticket = $this->ticketsTable->newEmptyEntity();
			$ticket->helpdesk_user_id = $user->id;
			$ticket->subject = $data['subject'];
			$ticket->description = $data['description'];
			$ticket->priority = $data['priority'];
			$ticket->status = 'Open';
			$ticket->ticket_no = 'HD'.time().rand(100,999);
			// Handle file upload
			$file = $this->request->getData('attachment');
			if ($file && $file->getError() === UPLOAD_ERR_OK && $file->getClientFilename()) {
				$allowed = ['pdf', 'jpg', 'jpeg', 'png'];
				$ext = strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
				if (!in_array($ext, $allowed)) {
					$this->Flash->error('Only PDF, JPG, PNG files are allowed.');
					return;
				}
				$fileName = 'ticket_'.time().'_'.rand(1000,9999).'.'.$ext;
				$uploadPath = WWW_ROOT . 'uploads/helpdesk/' . $fileName;
				$file->moveTo($uploadPath);
				$ticket->attachment = $fileName;
			}
			if ($this->ticketsTable->save($ticket)) {
				return $this->redirect([
					'action' => 'success',
					$ticket->ticket_no
				]);
			}
		}
		$this->set(compact('title', 'active'));
	}

	public function success($ticketNo){
		$title = 'Helpdesk - BOCW Cess Portal';
		$active = 'help';
		$this->set(compact('title', 'active', 'ticketNo'));
	}

	// public function track(){
	// 	$title = 'Helpdesk - BOCW Cess Portal';
	// 	$active = 'help';
	// 	$ticket = null;
	// 	if ($this->request->is('post')) {
	// 		$ticketNo = trim($this->request->getData('ticket_no'));
	// 		$ticket = $this->ticketsTable->find()->where(['ticket_no' => $ticketNo])->contain(['HelpdeskUsers', 'HelpdeskComments'])->first();
	// 		if (!$ticket) {
	// 			$this->Flash->error('Invalid Ticket Number.');
	// 		}
	// 	}
	// 	$this->set(compact('title', 'active', 'ticket'));
	// }

	public function track(){
		$title = 'Helpdesk - BOCW Cess Portal';
		$active = 'track';
		$ticket = null;
		if ($this->request->is(['post', 'put'])) {
			// Case 1: Tracking by ticket number
			if ($this->request->getData('ticket_no')) {
				$ticketNo = trim($this->request->getData('ticket_no'));
				$ticket = $this->ticketsTable->find()->where(['ticket_no' => $ticketNo])->contain(['HelpdeskUsers', 'HelpdeskComments'])->first();
				if (!$ticket) {
					$this->Flash->error('Invalid Ticket Number.');
				}
			// Case 2: Public reply submission
			} elseif ($this->request->getData('reply_ticket_id')) {
				$ticketId = $this->request->getData('reply_ticket_id');
				$ticket = $this->ticketsTable->get($ticketId);
				$comment = $this->commentsTable->newEmptyEntity();
				$comment->helpdesk_ticket_id = $ticket->id;
				$comment->sender_type = 'user';
				$comment->message = $this->request->getData('message');
				// Attachment
				$file = $this->request->getData('attachment');
				if ($file && $file->getError() === UPLOAD_ERR_OK && $file->getClientFilename()) {
					$ext = strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
					$fileName = 'user_' . time() . '_' . rand(1000,9999) . '.' . $ext;
					$file->moveTo(WWW_ROOT . 'uploads/helpdesk/' . $fileName);
					$comment->attachment = $fileName;
				}
				$this->commentsTable->save($comment);
				// Update ticket status
				$ticket->status = 'Open';
				$this->ticketsTable->save($ticket);
				// Updated ticket with new added comment
				$ticket = $this->ticketsTable->get($ticketId, [
					'contain' => ['HelpdeskUsers', 'HelpdeskComments']
				]);
				$this->Flash->success('Your reply has been sent.');
			}
		}
		$this->set(compact('title', 'active', 'ticket'));
	}

}