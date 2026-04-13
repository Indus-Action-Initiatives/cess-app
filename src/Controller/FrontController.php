<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Laminas\Diactoros\UploadedFile;

class FrontController extends AppController{

	public function initialize(): void{
		parent::initialize();
		$this->viewBuilder()->setLayout('front');
		$this->checkFrontUser();
		// Load commonly used tables
		$this->Users = TableRegistry::getTableLocator()->get('Users');
		$this->UserSessions = TableRegistry::getTableLocator()->get('UserSessions');
		$this->Orders = TableRegistry::getTableLocator()->get('Orders');
		$this->Drawing = TableRegistry::getTableLocator()->get('Drawing');
		$this->Stocks = TableRegistry::getTableLocator()->get('Stocks');
		$this->LabourCessProjects = TableRegistry::getTableLocator()->get('LabourCessProjects');
		$this->ProjectStatusFlow = TableRegistry::getTableLocator()->get('ProjectStatusFlow');
		$this->ProjectPayments = TableRegistry::getTableLocator()->get('ProjectPayments');
		$this->ProjectCertificates = TableRegistry::getTableLocator()->get('ProjectCertificates');
		$this->Objections = TableRegistry::getTableLocator()->get('Objections');
		$this->ObjectionComments = TableRegistry::getTableLocator()->get('ObjectionComments');
		$this->Registers = TableRegistry::getTableLocator()->get('Registers');
	}

	public function dashboard(){
		$session = $this->getRequest()->getSession();
		$userId = $session->read("front.id");

		$allCount = $this->LabourCessProjects->find()->where(['user_id' => $userId])->count();
		$pendingCount = $this->LabourCessProjects->find()->where(['flow_id IN(1,4)', 'user_id' => $userId])->count();
		$certCount = $this->LabourCessProjects->find()->where(['flow_id' => 7, 'user_id' => $userId])->count();

		$this->set(compact('allCount', 'pendingCount', 'certCount'));
	}

	public function addproject(){
		$session = $this->getRequest()->getSession();
		$userId = $session->read("front.id");

		$register = $this->Registers->find()->where(['user_id'=>$userId])->first();

		$propertyCategories = [
			'Residential Building' => 'Residential Building',
			'Non-Residential Building' => 'Non-Residential Building',
			'Mixed use Building' => 'Mixed use Building',
			'Industrial Building' => 'Industrial Building',
			'Layout' => 'Layout'
		];

		$districtsTable = TableRegistry::getTableLocator()->get('districts');
		$districts = $districtsTable->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
		])->where(['state_id'=>$register->state_id])->order(['name' => 'ASC'])->toArray();

		$this->set(compact('districts', 'propertyCategories'));
	}

	public function saveStep1(){
		$this->autoRender = false;
		$projectsTable = $this->getTableLocator()->get('LabourCessProjects');
		$data = $this->request->getData();

		// Prevent manual ID tampering
		unset($data['id']);

		// Create new entity
		$project = $projectsTable->newEmptyEntity();
		$project = $projectsTable->patchEntity($project, $data);

		// Default fields
		$project->payment_status = 0; // 1 = Active / Paid / whatever your logic
		$project->due_date = date('Y-m-d', strtotime('+1 month')); // auto one month from now

		// Save first to get project ID
		if ($projectsTable->save($project)) {
			// Generate file_name after ID is known
			$financialYear = date('y') . '-' . (date('y') + 1); // e.g., 25-26
			$project->file_name = sprintf('LUBR/%04d/%s', $project->id, $financialYear);

			$session = $this->getRequest()->getSession();
			$project->user_id =$session->read("front.id");

			// Update with generated file_name
			$projectsTable->save($project);

			$response = [
				'success' => true,
				'project_id' => $project->id,
				'file_name' => $project->file_name,
				'message' => 'Step 1 saved successfully!'
			];
			return $this->response->withType('application/json')
				->withStringBody(json_encode($response));
		}

		// Error response
		$response = [
			'success' => false,
			'errors' => $project->getErrors()
		];
		return $this->response->withType('application/json')
			->withStringBody(json_encode($response));
	}

	public function saveStep2(){
		$this->autoRender = false;
		$projectsTable = $this->getTableLocator()->get('LabourCessProjects');
		$data = $this->request->getData();
		$id = $data['project_id'] ?? null;

		if (empty($id)) {
			return $this->response->withType('application/json')->withStringBody(json_encode([
				'success' => false,
				'message' => 'Project ID missing.'
			]));
		}

		try {
			$project = $projectsTable->get($id);
		} catch (\Exception $e) {
			return $this->response->withType('application/json')->withStringBody(json_encode([
				'success' => false,
				'message' => 'Project not found.'
			]));
		}

		$project = $projectsTable->patchEntity($project, $data);

		if ($projectsTable->save($project)) {
			return $this->response->withType('application/json')->withStringBody(json_encode([
				'success' => true,
				'project_id' => $project->id,
				'message' => 'Step 2 saved successfully!'
			]));
		}

		return $this->response->withType('application/json')->withStringBody(json_encode([
			'success' => false,
			'errors' => $project->getErrors()
		]));
	}

	public function saveStep3(){
		$this->autoRender = false;
		$projectsTable = $this->getTableLocator()->get('LabourCessProjects');
		$data = $this->request->getData();
		$id = $data['project_id'] ?? null;

		if (empty($id)) {
			return $this->response->withType('application/json')->withStringBody(json_encode([
				'success' => false,
				'message' => 'Project ID missing.'
			]));
		}

		try {
			$project = $projectsTable->get($id);
		} catch (\Exception $e) {
			return $this->response->withType('application/json')->withStringBody(json_encode([
				'success' => false,
				'message' => 'Project not found.'
			]));
		}

		$project = $projectsTable->patchEntity($project, $data);

		if ($projectsTable->save($project)) {
			return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true]));
		}

		return $this->response->withType('application/json')->withStringBody(json_encode([
			'success' => false,
			'errors' => $project->getErrors()
		]));
	}

	public function saveStep4(){
		$this->request->allowMethod(['post', 'ajax']);
		$this->autoRender = false;

		$projectsTable = $this->getTableLocator()->get('LabourCessProjects');
		$data = $this->request->getData();
		$projectId = $data['project_id'] ?? null;

		// Determine create vs update
		if (!empty($projectId)) {
			try {
				$project = $projectsTable->get($projectId, [
					'contain' => ['LabourCessLabours', 'LabourCessAttachments']
				]);
			} catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
				return $this->response->withType('application/json')->withStringBody(json_encode([
					'success' => false,
					'message' => 'Project not found for ID: ' . $projectId
				]));
			}
		} else {
			$project = $projectsTable->newEmptyEntity();
		}

		// Map labour_cess_labours properly (flatten the inputs)
		if (!empty($data['labour_cess_labours']) && is_array($data['labour_cess_labours'])) {
			$labours = [];
			foreach ($data['labour_cess_labours'] as $row) {
				// Skip empty rows
				$idVal = $row['labour_id'] ?? null;
				$nameVal = $row['labour_name'] ?? null;
				if ($idVal === null && $nameVal === null) {
					continue;
				}
				$labours[] = [
					'labour_id' => $idVal,
					'labour_name' => $nameVal
				];
			}
			$data['labour_cess_labours'] = $labours;
		} else {
			$data['labour_cess_labours'] = [];
		}

		// Handle file uploads (PSR-7 UploadedFile objects)
		$attachments = [];
		$uploadFields = [
			['file' => 'drawing_pdf_file', 'desc' => 'drawing_pdf_description'],
			['file' => 'sale_deed_file', 'desc' => 'sale_deed_description'],
			['file' => 'otherdoc_file', 'desc' => 'otherdoc_description'],
			['file' => 'listoflabours_file', 'desc' => 'listoflabours_description']
		];

		foreach ($uploadFields as $f) {
				$fileObj = $this->request->getData($f['file']);
				$desc = $this->request->getData($f['desc']) ?? '';

				if ($fileObj && $fileObj->getError() === UPLOAD_ERR_OK) {
					// Get the original file extension
					$extension = pathinfo($fileObj->getClientFilename(), PATHINFO_EXTENSION);

					// Sanitize the field name
					$fieldName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $f['file']);

					// Generate timestamp + random string
					$randomStr = substr(md5(uniqid((string)mt_rand(), true)), 0, 6);

					$fileName = $projectId.'_'.$fieldName . '_' . time() . '_' . $randomStr . '.' . $extension;

					// Set upload directory
					$targetPath = WWW_ROOT.'uploads/attachments/';

					// Ensure uploads directory exists
					if (!file_exists($targetPath)) {
						mkdir($targetPath, 0755, true);
					}

					// Move uploaded file
					$fullPath = $targetPath . $fileName;
					$fileObj->moveTo($fullPath);

					// ✅ Get file type (MIME)
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$fileType = finfo_file($finfo, $fullPath);
					finfo_close($finfo);

					$attachments[] = [
						'file_type'   => $fileType,
						'description' => $desc,
						'file_name'   => $fieldName,
						'file_path'   => 'uploads/attachments/'.$fileName
					];
				}
		}


		// Attach to data for associated save
		$data['labour_cess_attachments'] = $attachments;

		// Prevent accidental manual id override on new inserts
		if (isset($data['id'])) {
			unset($data['id']);
		}

		// Patch entity (with associations)
		$project = $projectsTable->patchEntity($project, $data, [
			'associated' => ['LabourCessLabours', 'LabourCessAttachments']
		]);

		try {
			if ($projectsTable->save($project)) {
				//Save Flow Log
				$session = $this->getRequest()->getSession();
				$userId = $session->read('front.id');
				$flowTable = $this->fetchTable('ProjectStatusFlow');
				$log = $flowTable->newEntity([
					'project_id' => $projectId,
					'flow_id' => 1,
					'action_taken' => 'New Application',
					'remark' => 'New Application Created.',
					'action_by' => $userId
				]);
				$flowTable->save($log);
				return $this->response->withType('application/json')->withStringBody(json_encode([
					'success' => true,
					'message' => 'Step 4 saved successfully!',
					'project_id' => $project->id
				]));

				//return $this->redirect(['action' => 'view', $project->id]);
			}

			// Validation errors
			return $this->response->withType('application/json')->withStringBody(json_encode([
				'success' => false,
				'errors' => $project->getErrors()
			]));
		} catch (\PDOException $e) {
			// Return DB exception message (e.g. duplicate key violation)
			return $this->response->withType('application/json')->withStringBody(json_encode([
				'success' => false,
				'message' => $e->getMessage()
			]));
		}
	}

	public function changePassword(){
		$session = $this->getRequest()->getSession();
		$userId = $session->read("front.id");

		$dataToSave = $this->Users->newEmptyEntity();
		if ($this->request->is('post')) {
			$post = $this->request->getData();
			$errFlag = false;
			$msg = '';

			if (empty(trim($post['password'] ?? ''))) {
				$msg = 'Please enter your new password';
				$errFlag = true;
			} elseif (empty(trim($post['confirmpassword'] ?? ''))) {
				$msg = 'Please retype your new password';
				$errFlag = true;
			} elseif (trim($post['password']) !== trim($post['confirmpassword'])) {
				$msg = 'Passwords do not match';
				$errFlag = true;
			}

			if (!$errFlag) {
				$salt = bin2hex(random_bytes(16));
				$hashedPassword = $this->hashPasswordWithSalt($post['password'], $salt);

				$dataToSave = $this->Users->patchEntity($dataToSave, $post);
				$dataToSave->id = $userId;
				$dataToSave->password = md5($post['password']); // legacy field
				$dataToSave->password_hash = $hashedPassword;
				$dataToSave->salt = $salt;

				if ($this->Users->save($dataToSave)) {
					$this->UserSessions->deleteAll([
						'user_id' => $this->getRequest()->getSession()->read('Auth.User.users_id')
					]);
					$session->destroy();
					$this->Flash->success('Password updated successfully.');
					return $this->redirect('/users');
				} else {
					$this->Flash->warning('Error while updating password.');
					return $this->redirect('/front/changePassword');
				}
			}

			$this->Flash->warning($msg);
			return $this->redirect('/front/changePassword');
		}
	}

	public function hashPasswordWithSalt($password, $salt, $iterations = 10000){
		$toHash = $password . $salt;
		for ($i = 0; $i < $iterations; $i++) {
			$toHash = hash('sha512', $toHash);
		}
		return $toHash;
	}

	public function taskList(){
		$session = $this->getRequest()->getSession();
		$userId = $session->read("front.id");

		$pendingTasks = $this->LabourCessProjects->find()
			->where(['flow_id IN(1,4)', 'user_id' => $userId])
			->order(['id' => 'DESC'])
			->all();

		$viewTasks = $this->LabourCessProjects->find()
			->where(['user_id' => $userId])
			->order(['id' => 'DESC'])
			->all();

		$this->set(compact('pendingTasks', 'viewTasks'));
	}

	public function view($id = null){
		$decodeId = base64_decode($id);
		$session = $this->getRequest()->getSession();
		$userId = $session->read("front.id");

		$register = $this->request->getQuery('register') === 'true' || $this->request->getQuery('register') === true;

		$project = $this->LabourCessProjects->get($decodeId, [
			'where' => ['user_id' => $userId],
			'contain' => ['LabourCessLabours', 'LabourCessAttachments', 'ProjectPayments', 'Districts', 'Department']
		]);

		if (!$project) {
			$this->Flash->error('Invalid ID.');
			return $this->redirect('/front/task-list');
		}
		$regPayment = $this->ProjectPayments->find()->where(['project_id'=>$decodeId, 'payment_type'=>1])->first();
		$cessPayment = $this->ProjectPayments->find()->where(['project_id'=>$decodeId, 'payment_type'=>2])->first();
		$objections = $this->Objections->find()->where(['project_id'=>$decodeId])->contain(['Users', 'ObjectionComments'=>['Users','sort'=>['ObjectionComments.created_at'=>'ASC']]])->all();
		$conn = ConnectionManager::get('default');
		$project_status_flow = $conn->execute(
			"SELECT pl.*, u.off_name AS username
			FROM labour_cess_status_flow pl
			LEFT JOIN users u ON u.id = pl.action_by
			WHERE pl.project_id = :pid
			ORDER BY pl.id DESC",
			['pid' => $decodeId]
		)->fetchAll('assoc');
		$certificate = $this->ProjectCertificates->find()->where(['project_id'=>$decodeId])->first();
		$this->set(compact('project', 'register', 'regPayment', 'cessPayment', 'project_status_flow', 'certificate', 'objections'));
	}

	public function payment(){
		$this->autoRender = false; // we are redirecting, no view needed
		$this->ProjectPayments = $this->getTableLocator()->get('ProjectPayments');
		$registrationPayment = $this->ProjectPayments->newEmptyEntity();
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			$registrationPayment = $this->ProjectPayments->patchEntity($registrationPayment, $data);
			// Handle file upload
			$file = $data['attachment_file_path'] ?? null;
			if ($file && $file->getError() === UPLOAD_ERR_OK) {
				$filename = time() . '_' . $file->getClientFilename();
				$targetPath = WWW_ROOT . 'uploads/payment' . DS . $filename;
				$file->moveTo($targetPath);
				$registrationPayment->attachment_file_path = 'uploads/payment/' . $filename;
			}
			$registrationPayment->payment_type = 1;
			if ($this->ProjectPayments->save($registrationPayment)) {
				// Update payment_status in LabourCessProjects
				$projectId = $data['project_id'];
				$projectsTable = $this->getTableLocator()->get('LabourCessProjects');
				$projectsTable->updateAll(['payment_status' => 1, 'flow_id' => 2], ['id' => $projectId]);
				//Save Flow Log
				$session = $this->getRequest()->getSession();
				$userId = $session->read('front.id');
				$flowTable = $this->fetchTable('ProjectStatusFlow');
				$log = $flowTable->newEntity([
					'project_id' => $projectId,
					'flow_id' => 2,
					'action_taken' => 'Registration Payment',
					'remark' => 'Registration Payment Paid by User.',
					'action_by' => $userId
				]);
				$flowTable->save($log);
				$this->Flash->success(__('The registration payment has been paid.'));
				return $this->redirect(['action' => 'task-list']);
			}
			$this->Flash->error(__('Unable to complete registration payment. Please try again.'));
			return $this->redirect($this->referer());
		}
	}

	public function cessPayment(){
		$this->autoRender = false; // we are redirecting, no view needed
		$this->ProjectPayments = $this->getTableLocator()->get('ProjectPayments');
		$cessPayment = $this->ProjectPayments->newEmptyEntity();
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			$cessPayment = $this->ProjectPayments->patchEntity($cessPayment, $data);
			// Handle file upload
			$file = $data['attachment_file_path'] ?? null;
			if ($file && $file->getError() === UPLOAD_ERR_OK) {
				$filename = time() . '_' . $file->getClientFilename();
				$targetPath = WWW_ROOT . 'uploads/payment' . DS . $filename;
				$file->moveTo($targetPath);
				$cessPayment->attachment_file_path = 'uploads/payment/' . $filename;
			}
			$cessPayment->payment_type = 2;
			if ($this->ProjectPayments->save($cessPayment)) {
				// Update payment_status in LabourCessProjects
				$projectId = $data['project_id'];
				$projectsTable = $this->getTableLocator()->get('LabourCessProjects');
				$projectsTable->updateAll(['cess_pay_status' => 1, 'flow_id' => 5], ['id' => $projectId]);
				//Save Flow Log
				$session = $this->getRequest()->getSession();
				$userId = $session->read('front.id');
				$flowTable = $this->fetchTable('ProjectStatusFlow');
				$log = $flowTable->newEntity([
					'project_id' => $projectId,
					'flow_id' => 5,
					'action_taken' => 'Cess Payment',
					'remark' => 'Cess Payment Paid by User.',
					'action_by' => $userId
				]);
				$flowTable->save($log);
				$this->Flash->success(__('The cess payment has been paid.'));
				return $this->redirect(['action' => 'task-list']);
			}
			$this->Flash->error(__('Unable to complete cess payment. Please try again.'));
			return $this->redirect($this->referer());
		}
	}

	public function reCessPayment(){
		$this->autoRender = false; // we are redirecting, no view needed
		$this->ProjectPayments = $this->getTableLocator()->get('ProjectPayments');
		$recessPayment = $this->ProjectPayments->newEmptyEntity();
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			$recessPayment = $this->ProjectPayments->patchEntity($recessPayment, $data);
			// Handle file upload
			$file = $data['attachment_file_path'] ?? null;
			if ($file && $file->getError() === UPLOAD_ERR_OK) {
				$filename = time() . '_' . $file->getClientFilename();
				$targetPath = WWW_ROOT . 'uploads/payment'.DS.$filename;
				$file->moveTo($targetPath);
				$recessPayment->attachment_file_path = 'uploads/payment/' . $filename;
			}
			$recessPayment->payment_type = 3;
			if ($this->ProjectPayments->save($recessPayment)) {
				// Update payment_status in LabourCessProjects
				$projectId = $data['project_id'];
				$projectsTable = $this->getTableLocator()->get('LabourCessProjects');
				$projectsTable->updateAll(['recess_pay_status' => 1, 'flow_id' => 10], ['id' => $projectId]);
				//Save Flow Log
				$session = $this->getRequest()->getSession();
				$userId = $session->read('front.id');
				$flowTable = $this->fetchTable('ProjectStatusFlow');
				$log = $flowTable->newEntity([
					'project_id' => $projectId,
					'flow_id' => 10,
					'action_taken' => 'Cess Re-Assessment Payment',
					'remark' => 'Cess Payment Paid by User.',
					'action_by' => $userId
				]);
				$flowTable->save($log);
				$this->Flash->success(__('The cess payment has been paid.'));
				return $this->redirect(['action' => 'task-list']);
			}
			$this->Flash->error(__('Unable to complete cess payment. Please try again.'));
			return $this->redirect($this->referer());
		}
	}

	public function addObjection($id=null){
		$projectId = base64_decode($id);
		$project = $this->LabourCessProjects->find()->where(['id' => $projectId])->first();
		if (!$project) {
			$this->Flash->error('Invalid ID.');
			return $this->redirect('/front/task-list');
		}

		$objection = $this->Objections->newEmptyEntity();
		if ($this->request->is('post')) {
			$session = $this->getRequest()->getSession();
			$userId = $session->read('front.id');
			// Get and save data
			$data = $this->request->getData();
			$data['project_id'] = $projectId;
			$data['flow_id'] = 5;
			$data['user_id'] = $userId;

			// File Upload Handling
			$file = $data['attachment_file'];
			if ($file && $file->getClientFilename()) {
				$ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
				$fileName = 'obj_' . time() . '.' . $ext;
				$file->moveTo(WWW_ROOT . 'uploads/objections/' . $fileName);
				$data['attachment_file'] = $fileName;
			}

			$objection = $this->Objections->patchEntity($objection, $data);

			if ($this->Objections->save($objection)) {
				$this->Flash->success('Objection submitted.');
			} else {
				$this->Flash->error('Failed to submit objection.');
			}
		}

		return $this->redirect($this->referer());
	}

	public function addObjectionComment($objectionId){

		$comment = $this->ObjectionComments->newEmptyEntity();
		if ($this->request->is('post')) {
			$session = $this->getRequest()->getSession();
			$userId = $session->read('front.id');

			$data = $this->request->getData();
			$data['objection_id'] = $objectionId;
			$data['user_id'] = $userId;

			$file = $data['attachment_file'];
			if ($file && $file->getClientFilename()) {
				$ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
				$fileName = 'objc_' . time() . '.' . $ext;
				$file->moveTo(WWW_ROOT . 'uploads/objections/' . $fileName);
				$data['attachment_file'] = $fileName;
			} else{
				unset($data['attachment_file']);
			}

			$comment = $this->ObjectionComments->patchEntity($comment, $data);

			if ($this->ObjectionComments->save($comment)) {
				$this->Flash->success('Comment added.');
			} else {
				$this->Flash->error('Failed to add comment.');
			}
		}

		return $this->redirect($this->referer());
	}
}