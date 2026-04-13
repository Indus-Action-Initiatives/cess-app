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

class OfficeController extends AppController{

	public function initialize(): void{
		parent::initialize();
		$this->viewBuilder()->setLayout('office');
		$this->checkOffice();
		// Load commonly used tables
		$this->Users = TableRegistry::getTableLocator()->get('Users');
		$this->UserSessions = TableRegistry::getTableLocator()->get('UserSessions');
		$this->Offices = TableRegistry::getTableLocator()->get('Offices');
		$this->States = TableRegistry::getTableLocator()->get('States');
		$this->Districts = TableRegistry::getTableLocator()->get('Districts');
		$this->LabourCessProjects = TableRegistry::getTableLocator()->get('LabourCessProjects');
		$this->ProjectPayments = TableRegistry::getTableLocator()->get('ProjectPayments');
		$this->ProjectStatusFlow = TableRegistry::getTableLocator()->get('ProjectStatusFlow');
		$this->ProjectCertificates = TableRegistry::getTableLocator()->get('ProjectCertificates');
		$this->Objections = TableRegistry::getTableLocator()->get('Objections');
        $this->ObjectionComments = TableRegistry::getTableLocator()->get('ObjectionComments');
        $this->Queries = TableRegistry::getTableLocator()->get('Queries');
        $this->QueryComments = TableRegistry::getTableLocator()->get('QueryComments');
		$this->QueryShowCause = TableRegistry::getTableLocator()->get('QueryShowCause');
        $this->Registers = TableRegistry::getTableLocator()->get('Registers');
	}

    public function dashboard()
    {
        $session = $this->getRequest()->getSession();
        $userId = $session->read('office.id');

        // 1. Fetch the office
        $office = $this->Offices->find()->where(['user_id' => $userId])->first();

        // 2. SAFETY CHECK: If no office record exists, don't crash
        if (!$office) {
            $this->Flash->error(__('Your account is not linked to an Office record. Please contact the administrator.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }

        // 3. Now it's safe to use $office->district_id
        $allCount = $this->LabourCessProjects->find()
            ->where(['flow_id !=' => 1, 'department_id' => $office->district_id])
            ->count();

        $pendingCount = $this->LabourCessProjects->find()
            ->where(['flow_id IN' => [2, 3, 4, 5, 6], 'department_id' => $office->district_id])
            ->count();

        $certCount = $this->LabourCessProjects->find()
            ->where(['flow_id' => 7, 'department_id' => $office->district_id])
            ->count();

        $this->set(compact('allCount', 'pendingCount', 'certCount'));
    }

	public function getListData($type=null){
		$session = $this->getRequest()->getSession();
		$userId = $session->read('office.id');
		$office = $this->Offices->find()->where(['user_id' => $userId])->first();

		$this->request->allowMethod(['get']);
		$queryParams = $this->request->getQuery();
		$start = isset($queryParams['start']) ? (int)$queryParams['start'] : 0;
		$length = isset($queryParams['length']) ? (int)$queryParams['length'] : 10;
		$searchValue = isset($queryParams['search']['value']) ? trim($queryParams['search']['value']) : '';

		if($type == 'all') $flow_in = 'flow_id NOT IN(1)';
		elseif($type == 'pending') $flow_in = 'flow_id NOT IN(1,7)';
		elseif($type == 'complete') $flow_in = 'flow_id IN(7)';
		$query = $this->LabourCessProjects->find()
			->where(['department_id' => $office->district_id, $flow_in])
			->order(['id' => 'DESC']);

		if (!empty($searchValue)) {
			$query->where([
				'OR' => [
					'LOWER(file_name) LIKE' => "%$searchValue%",
					'LOWER(establishment_type) LIKE' => "%$searchValue%",
					'LOWER(assessment_name) LIKE' => "%$searchValue%"
				]
			]);
		}    
		$totalRecords = $this->LabourCessProjects->find()->where(['department_id' => $office->district_id, 'flow_id !=' => 1])->count();
		$filteredRecords = $query->count();

		$projects = $query->limit($length)->offset($start)->toArray();
		$data = [];
		$i = $start + 1;
		foreach ($projects as $p) {
			if ($p->flow_id == 1) {
				$status = 'Application Created';
			} elseif ($p->flow_id == 2) {
				$status = 'Registration Fee Paid';
			} elseif ($p->flow_id == 3) {
				$status = 'Registration Verified';
			} elseif ($p->flow_id == 4) {
				$status = 'Cess Assessment';
			} elseif ($p->flow_id == 5) {
				$status = 'Cess Fee Paid';
			} elseif ($p->flow_id == 6) {
				$status = 'Cess Verified';
			} elseif ($p->flow_id == 7) {
				$status = 'Certificate Issued';
			} elseif ($p->flow_id == 8) {
                $status = 'Re-Assessment Initiated';
            } elseif ($p->flow_id == 9) {
                $status = 'Re-Assessment Completed';
            } elseif ($p->flow_id == 10) {
                $status = 'Re-Assessment Fee Paid';
            } elseif ($p->flow_id == 11) {
                $status = 'Re-Assessment Verified';
            }
			$data[] = [
				$i,
				$p->file_name,
				$p->created_at->format('d-m-Y'),
				$p->assessment_name,
				$p->establishment_type,
				$status,
				'<a href="'.webURL.'office/view/'.base64_encode((string) $p->id).'" class="btn btn-info btn-xs"><i class="far fa-edit"></i> Action</a>'
			];
			$i++;
		}

		return $this->response->withType('application/json')->withStringBody(json_encode([
			'draw' => isset($queryParams['draw']) ? (int)$queryParams['draw'] : 1,
			'recordsTotal' => $totalRecords,
			'recordsFiltered' => $filteredRecords,
			'data' => $data
		]));
	}

	public function taskList($type=null){
		$this->set(compact('type'));
	}

	public function view($id = ''){
        $session = $this->getRequest()->getSession();
        $userId = $session->read('office.id');
        $office = $this->Offices->find()->where(['user_id' => $userId])->first();

        $projectId = base64_decode($id);
        $project = $this->LabourCessProjects->get($projectId, ['where'=>['department_id'=>$office->district_id], 'contain'=>['LabourCessAttachments','LabourCessLabours','Districts','Department']]);
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }

        $regPayment = $this->ProjectPayments->find()->where(['project_id'=>$projectId, 'payment_type'=>1])->first();
        $cessPayment = $this->ProjectPayments->find()->where(['project_id'=>$projectId, 'payment_type'=>2])->first();
        $reCessPayment = $this->ProjectPayments->find()->where(['project_id'=>$projectId, 'payment_type'=>3])->first();
        $objections = $this->Objections->find()->where(['project_id'=>$projectId])->contain(['Users', 'ObjectionComments'=>['Users','sort'=>['ObjectionComments.created_at'=>'ASC']]])->all();
        $queries = $this->Queries->find()->where(['OR'=>['user_id'=>$userId, 'to_office'=>$office->id]])->contain(['Users', 'QueryComments'=>['Users','sort'=>['QueryComments.created_at'=>'ASC']]])->all();
        $showCauses = $this->QueryShowCause->find()->where(['to_user_id' => $userId])->contain(['SentByUsers'])->order(['QueryShowCause.created' => 'DESC'])->all();

        $conn = ConnectionManager::get('default');
        $project_status_flow = $conn->execute(
            "SELECT pl.*, u.off_name AS username
            FROM labour_cess_status_flow pl
            LEFT JOIN users u ON u.id = pl.action_by
            WHERE pl.project_id = :pid
            ORDER BY pl.id DESC",
            ['pid' => $projectId]
        )->fetchAll('assoc');
        $certificate = $this->ProjectCertificates->find()->where(['project_id'=>$projectId])->first();

        $propertyCategories = [
            'Residential Building' => 'Residential Building',
            'Non-Residential Building' => 'Non-Residential Building',
            'Mixed use Building' => 'Mixed use Building',
            'Industrial Building' => 'Industrial Building',
            'Layout' => 'Layout'
        ];
        $districtOffices = $this->Offices->find()->select(['id', 'display_name' => "name || ' - ' || officer_name"])->where(['district_id' => $office->district_id])->order(['name' => 'ASC'])->enableHydration(false)->all()->combine('id', 'display_name')->toArray();

        $this->set(compact('id', 'project', 'regPayment', 'cessPayment', 'reCessPayment', 'project_status_flow', 'certificate', 'objections', 'queries', 'showCauses', 'propertyCategories', 'districtOffices'));
    }

    public function regPayVerification($id = null){
        $postdata = $this->request->getData();
        $projectId = base64_decode($id);
        $project = $this->LabourCessProjects->find()->where(['id' => $projectId])->first();
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }
        if ($this->request->is(['post', 'put', 'patch'])) {
            $payment = $this->ProjectPayments->find()->where(['project_id'=>$projectId, 'payment_type'=>1])->first();
            if (!$payment) {
                $this->Flash->error('Invalid Payment.');
                return $this->redirect('/office/task-list/pending');
            }
            if($postdata['payment_status'] == 1){
                $project->flow_id = 3;
            } else{
                $project->flow_id = 2;
            }
            if($this->LabourCessProjects->save($project)){
                $payment->payment_status = $postdata['payment_status'];
                $payment->payment_remark = $postdata['payment_remark'];
                if($this->ProjectPayments->save($payment)){
                    //Flow Log 
                    $session = $this->getRequest()->getSession();
                    $userId = $session->read('office.id');
                    $logData = [
                        'project_id' => $projectId,
                        'flow_id' => $project->flow_id,
                        'action_taken' => 'Registration Payment Verification.',
                        'remark' => $postdata['payment_remark'],
                        'action_by' => $userId
                    ];
                    // File Upload Handling
                    $file = $postdata['attachment_file'];
                    if ($file && $file->getClientFilename()) {
                        $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                        $fileName = 'reg_verify_'.time().'.'.$ext;
                        $file->moveTo(WWW_ROOT.'uploads/flowfiles/'.$fileName);
                        $logData['attachment_file'] = $fileName;
                    }
                    $flowTable = $this->fetchTable('ProjectStatusFlow');
                    $log = $flowTable->newEntity($logData);
                    $flowTable->save($log);
                    $this->Flash->success(__('Payment verification saved successfully.'));
                } else{
                    $this->Flash->error(__('Failed to save payment verification.'));
                }
            } else{
                $this->Flash->error(__('Failed to save payment verification.'));
            } 
            $this->redirect('/office/view/'.$id);
        }
    }

    public function cessCalculation($id = null){
        $validator = new Validator();
        $errors = $validator->validate($this->request->getData()); 
        $postdata = $this->request->getData();
        $decodedId = base64_decode($id);

        $project = $this->LabourCessProjects->find()->where(['id' => $decodedId])->first();
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }
        if ($this->request->is(['post', 'put', 'patch'])) {
            $project->flow_id = 4;
            $project->cess_cost = $postdata['cess_cost'];
            $project->cess_remark = $postdata['cess_remark'];
            //---- Project data save
            $project->property_category = $postdata['property_category'];
            $project->plot_area = $postdata['plot_area'];
            $project->total_project_cost = $postdata['total_project_cost'];
            $project->construction_area = $postdata['construction_area'];
            $project->total_area_project_cost = $postdata['total_area_project_cost'];
            $project->max_labor_count = $postdata['max_labor_count'];
            $project->stage_of_construction = $postdata['stage_of_construction'];
            $project->estimated_start_date = $postdata['estimated_start_date'];
            $project->estimated_end_date = $postdata['estimated_end_date'];
            if($this->LabourCessProjects->save($project)){
                //Flow Log 
                $session = $this->getRequest()->getSession();
                $userId = $session->read('office.id');
                $logData = [
                    'project_id' => $decodedId,
                    'flow_id' => $project->flow_id,
                    'action_taken' => 'Cess Assessment',
                    'remark' => $postdata['cess_remark'],
                    'action_by' => $userId
                ];
                // File Upload Handling
                $file = $postdata['attachment_file'];
                if ($file && $file->getClientFilename()) {
                    $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                    $fileName = 'cess_verify_'.time().'.'.$ext;
                    $file->moveTo(WWW_ROOT.'uploads/flowfiles/'.$fileName);
                    $logData['attachment_file'] = $fileName;
                }
                $flowTable = $this->fetchTable('ProjectStatusFlow');
                $log = $flowTable->newEntity($logData);
                $flowTable->save($log);
                $this->Flash->success(__('Cess Assessment saved successfully.'));
            } else{
                $this->Flash->error(__('Failed to save Cess assessment.'));
            } 
            $this->redirect('/office/view/'.$id);
        }
    }

    public function cessPayVerification($id = null){
        $validator = new Validator();
        $errors = $validator->validate($this->request->getData()); 
        $postdata = $this->request->getData();
        $decodedId = base64_decode($id);

        $project = $this->LabourCessProjects->find()->where(['id' => $decodedId])->first();
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }
        if ($this->request->is(['post', 'put', 'patch'])) {
            $payment = $this->ProjectPayments->find()->where(['project_id'=>$decodedId, 'payment_type'=>2])->first();
            if (!$payment) {
                $this->Flash->error('Invalid Payment.');
                return $this->redirect('/office/task-list/pending');
            }
            if($postdata['payment_status'] == 1){
                $project->flow_id = 6;
            } else{
                $project->flow_id = 5;
            }
            if($this->LabourCessProjects->save($project)){
                $payment->payment_status = $postdata['payment_status'];
                $payment->payment_remark = $postdata['payment_remark'];
                if($this->ProjectPayments->save($payment)){
                    //Flow Log 
                    $session = $this->getRequest()->getSession();
                    $userId = $session->read('office.id');
                    $logData = [
                        'project_id' => $decodedId,
                        'flow_id' => $project->flow_id,
                        'action_taken' => 'Cess Payment Verification.',
                        'remark' => $postdata['payment_remark'],
                        'action_by' => $userId
                    ];
                    // File Upload Handling
                    $file = $postdata['attachment_file'];
                    if ($file && $file->getClientFilename()) {
                        $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                        $fileName = 'cess_verify_'.time().'.'.$ext;
                        $file->moveTo(WWW_ROOT.'uploads/flowfiles/'.$fileName);
                        $logData['attachment_file'] = $fileName;
                    }
                    $flowTable = $this->fetchTable('ProjectStatusFlow');
                    $log = $flowTable->newEntity($logData);
                    $flowTable->save($log);
                    $this->Flash->success(__('Payment verification saved successfully.'));
                } else{
                    $this->Flash->error(__('Failed to save payment verification.'));
                }
            } else{
                $this->Flash->error(__('Failed to save payment verification.'));
            } 
            $this->redirect('/office/view/'.$id);
        }
    }

    public function generateCessReceipt($id = null){
        $this->autoRender = false;
        // Fetch project using Cake ORM OR SQL
        $postdata = $this->request->getData();
        $decodedId = base64_decode($id);

        $project = $this->LabourCessProjects->find()->where(['id' => $decodedId])->first();
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }
        if ($this->request->is(['post', 'put', 'patch'])) {
            $payment = $this->ProjectPayments->find()->where(['project_id'=>$decodedId, 'payment_type'=>2])->first();
            $register = $this->Registers->find()->where(['user_id'=>$project->user_id])->contain(['States', 'Districts'])->first();
            if (!$payment) {
                $this->Flash->error('Invalid Payment.');
                return $this->redirect('/office/task-list/pending');
            }
            //Generate certificate number
            $year = date('y').'-'.(date('y')+1);
            $cf1 = sprintf("CESS/%s", $year);
            $cf2 = sprintf("3%03d%d", 0, $decodedId);
            $cert_no = sprintf("%s/%s", $cf1, $cf2);
            // Generate PDF certificate
            $html = $this->buildReceiptHtml($project, $payment, $register, $cert_no);
            $options = new Options();
            $options->set('defaultFont', 'Helvetica');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdfOutput = $dompdf->output();
            //Save PDF path
            $folder = WWW_ROOT."uploads/certificates/";
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
            $fileName = "cert_".$year.'_'.$decodedId.".pdf";
            $filePath = $folder . $fileName;
            file_put_contents($filePath, $pdfOutput);
            //Save certificate table
            $certTable = $this->fetchTable('ProjectCertificates');
            $cert = $certTable->newEntity([
                'project_id' => $decodedId,
                'cert_no' => $cert_no,
                'issue_date' => date('Y-m-d'),
                'file_path' => 'uploads/certificates/'.$fileName
            ]);
            $certTable->save($cert);
            //Update flow in Project
            $project->flow_id = 7;
            $this->LabourCessProjects->save($project);
            //Save Log
            $session = $this->getRequest()->getSession();
            $userId = $session->read('office.id');
            $flowTable = $this->fetchTable('ProjectStatusFlow');
            $log = $flowTable->newEntity([
                'project_id' => $decodedId,
                'flow_id' => $project->flow_id,
                'action_taken' => 'Cess Receipt Issued.',
                'remark' => $postdata['cert_remark'],
                'action_by' => $userId
            ]);
            $flowTable->save($log);
        }
        return $this->redirect('/office/view/'.base64_encode((string) $decodedId));
    }

    private function buildReceiptHtml($project, $payment, $register, $cert_no){
        $emp_name = empty($register->firm_name) ? $register->first_name.' '.$register->first_name : $register->firm_name;
        $reg_no = empty($register->firm_registration_no) ? 'NA' : $register->firm_registration_no;
        $reg_add = $register->communication_address.', '.$register->city.', '.$register->state->name.', '.$register->district->name;
        return "
        <style>
        body { font-family: Helvetica, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        th { text-align: left; padding: 4px; background: #f0f0f0; }
        td { padding: 6px; border: 1px solid #000; }
        .section-title { font-weight: bold; margin: 10px 0 4px; font-size: 14px; }
        .title-big { text-align:center; font-size:18px; font-weight:bold; margin-bottom:15px; }
        </style>

        <div class='title-big'>CESS PAYMENT RECEIPT / CERTIFICATE</div>

        <div class='section-title'>GOVERNMENT & CERTIFICATE DETAILS</div>
        <table>
        <tr><td>Issuing Authority</td><td>[State] BOCW Welfare Board</td></tr>
        <tr><td>Receipt/Certificate Number</td><td>{$cert_no}</td></tr>
        <tr><td>Date of Issue</td><td>".date('d-m-Y')."</td></tr>
        </table>

        <div class='section-title'>EMPLOYER / ESTABLISHMENT DETAILS</div>
        <table>
        <tr><td>Employer Name</td><td>{$emp_name}</td></tr>
        <tr><td>Registration Number</td><td>{$reg_no}</td></tr>
        <tr><td>Address</td><td>{$reg_add}</td></tr>
        <tr><td>Authorized Person Name</td><td>{$register->contact_person_name}</td></tr>
        </table>

        <div class='section-title'>PROJECT / WORK DETAILS</div>
        <table>
        <tr><td>Project ID</td><td>{$project['file_name']}</td></tr>
        <tr><td>Name of Work/Project</td><td>{$project['assessment_name']}</td></tr>
        <tr><td>Site Address</td><td>{$project['property_address']}</td></tr>
        <tr><td>Estimated Project Cost (In Rupees)</td><td>".number_format($project['total_project_cost'],2)."</td></tr>
        <tr><td>Cess Applicable Rate</td><td>1 %</td></tr>
        </table>

        <div class='section-title'>PAYMENT DETAILS</div>
        <table>
        <tr><td>Total Cess Amount Due (In Rupees)</td><td>".number_format($project['cess_cost'],2)."</td></tr>
        <tr><td>Amount Paid Now (In Rupees)</td><td>".number_format($project['cess_cost'],2)."</td></tr>
        <tr><td>Transaction / Challan No</td><td>{$payment['document_reference_no']}</td></tr>
        <tr><td>Payment Date</td><td>".$payment->date_of_payment->format('d-m-Y')."</td></tr>
        <tr><td>Payment Mode</td><td>{$payment['payment_mode']}</td></tr>
        </table>

        <div class='section-title'>VERIFICATION & STATUS</div>
        <table>
        <tr><td>Payment Status</td><td>Completed</td></tr>
        <tr><td>Remarks</td><td>{$payment['payment_remark']}</td></tr>
        </table>
        ";
    }

    public function reCessAssessment($id){
        $decodedId = base64_decode($id);
        $project = $this->LabourCessProjects->get($decodedId);
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect($this->referer());
        }
        $project->flow_id = 8;
        if($this->LabourCessProjects->save($project)){
            //Flow Log 
            $session = $this->getRequest()->getSession();
            $userId = $session->read('office.id');
            $logData = [
                'project_id' => $decodedId,
                'flow_id' => $project->flow_id,
                'action_taken' => 'Cess Re-Assessment initiated.',
                'remark' => 'Cess Re-Assessment initiated.',
                'action_by' => $userId
            ];
            $flowTable = $this->fetchTable('ProjectStatusFlow');
            $log = $flowTable->newEntity($logData);
            $flowTable->save($log);
            $this->Flash->success('Re-Assessment initiated successfully.');
        } else{
            $this->Flash->error('Something went wrong!, Please try again.');
        }
        return $this->redirect($this->referer());
    }

    public function reCessCalculation($id = null){
        $validator = new Validator();
        $errors = $validator->validate($this->request->getData()); 
        $postdata = $this->request->getData();
        $decodedId = base64_decode($id);

        $project = $this->LabourCessProjects->get($decodedId);
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }
        if ($this->request->is(['post', 'put', 'patch'])) {
            $project->flow_id = 9;
            $project->recess_cost = $postdata['recess_cost'];
            $project->recess_remark = $postdata['recess_remark'];
            //---- Project data save
            $project->property_category = $postdata['property_category'];
            $project->plot_area = $postdata['plot_area'];
            $project->total_project_cost = $postdata['total_project_cost'];
            $project->construction_area = $postdata['construction_area'];
            $project->total_area_project_cost = $postdata['total_area_project_cost'];
            $project->max_labor_count = $postdata['max_labor_count'];
            $project->stage_of_construction = $postdata['stage_of_construction'];
            $project->estimated_start_date = $postdata['estimated_start_date'];
            $project->estimated_end_date = $postdata['estimated_end_date'];
            if($this->LabourCessProjects->save($project)){
                //Flow Log 
                $session = $this->getRequest()->getSession();
                $userId = $session->read('office.id');
                $logData = [
                    'project_id' => $decodedId,
                    'flow_id' => $project->flow_id,
                    'action_taken' => 'Cess Re-Assessment',
                    'remark' => $postdata['recess_remark'],
                    'action_by' => $userId
                ];
                // File Upload Handling
                $file = $postdata['attachment_file'];
                if ($file && $file->getClientFilename()) {
                    $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                    $fileName = 'cess_verify_'.time().'.'.$ext;
                    $file->moveTo(WWW_ROOT.'uploads/flowfiles/'.$fileName);
                    $logData['attachment_file'] = $fileName;
                }
                $flowTable = $this->fetchTable('ProjectStatusFlow');
                $log = $flowTable->newEntity($logData);
                $flowTable->save($log);
                $this->Flash->success(__('Cess Re-Assessment saved successfully.'));
            } else{
                $this->Flash->error(__('Failed to save Cess assessment.'));
            }
            $this->redirect('/office/view/'.$id);
        }
    }

    public function reCessPayVerification($id = null){
        $validator = new Validator();
        $errors = $validator->validate($this->request->getData()); 
        $postdata = $this->request->getData();
        $decodedId = base64_decode($id);

        $project = $this->LabourCessProjects->get($decodedId);
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }
        if ($this->request->is(['post', 'put', 'patch'])) {
            $payment = $this->ProjectPayments->find()->where(['project_id'=>$decodedId, 'payment_type'=>3])->first();
            if (!$payment) {
                $this->Flash->error('Invalid Payment.');
                return $this->redirect('/office/task-list/pending');
            }
            if($postdata['payment_status'] == 1){
                $project->flow_id = 11;
            } else{
                $project->flow_id = 10;
            }
            if($this->LabourCessProjects->save($project)){
                $payment->payment_status = $postdata['payment_status'];
                $payment->payment_remark = $postdata['payment_remark'];
                if($this->ProjectPayments->save($payment)){
                    //Flow Log 
                    $session = $this->getRequest()->getSession();
                    $userId = $session->read('office.id');
                    $logData = [
                        'project_id' => $decodedId,
                        'flow_id' => $project->flow_id,
                        'action_taken' => 'Cess Re-Assessment Payment Verification.',
                        'remark' => $postdata['payment_remark'],
                        'action_by' => $userId
                    ];
                    // File Upload Handling
                    $file = $postdata['attachment_file'];
                    if ($file && $file->getClientFilename()) {
                        $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                        $fileName = 'cess_verify_'.time().'.'.$ext;
                        $file->moveTo(WWW_ROOT.'uploads/flowfiles/'.$fileName);
                        $logData['attachment_file'] = $fileName;
                    }
                    $flowTable = $this->fetchTable('ProjectStatusFlow');
                    $log = $flowTable->newEntity($logData);
                    $flowTable->save($log);
                    $this->Flash->success(__('Payment verification saved successfully.'));
                } else{
                    $this->Flash->error(__('Failed to save payment verification.'));
                }
            } else{
                $this->Flash->error(__('Failed to save payment verification.'));
            } 
            $this->redirect('/office/view/'.$id);
        }
    }

    public function addObjection($id=null){
        $projectId = base64_decode($id);
        $project = $this->LabourCessProjects->find()->where(['id' => $projectId])->first();
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }
        $objection = $this->Objections->newEmptyEntity();
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();
            $userId = $session->read('office.id');
            $office = $this->Offices->find()->where(['user_id' => $userId])->first();
            // Get and save data
            $data = $this->request->getData();
            $data['project_id'] = $projectId;
            $data['flow_id'] = 4;
            $data['user_id'] = $userId;
            $data['office_id'] = $office->id;
            // File Upload Handling
            $file = $data['attachment_file'];
            if ($file && $file->getClientFilename()) {
                $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                $fileName = 'obj_' . time() . '.' . $ext;
                $file->moveTo(WWW_ROOT . 'uploads/objections/' . $fileName);
                $data['attachment_file'] = $fileName;
            } else{
                unset($data['attachment_file']);
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
            $userId = $session->read('office.id');
            $office = $this->Offices->find()->where(['user_id' => $userId])->first();

            $data = $this->request->getData();
            $data['objection_id'] = $objectionId;
            $data['user_id'] = $userId;
            $data['office_id'] = $office->id;

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

    public function addQuery($id=null){
        $projectId = base64_decode($id);
        $project = $this->LabourCessProjects->find()->where(['id' => $projectId])->first();
        if (!$project) {
            $this->Flash->error('Invalid ID.');
            return $this->redirect('/office/task-list/pending');
        }
        $query = $this->Queries->newEmptyEntity();
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();
            $userId = $session->read('office.id');
            $office = $this->Offices->find()->where(['user_id' => $userId])->first();
            // Get and save data
            $data = $this->request->getData();
            $data['project_id'] = $projectId;
            $data['user_id'] = $userId;
            $data['office_id'] = $office->id;
            // File Upload Handling
            $file = $data['attachment_file'];
            if ($file && $file->getClientFilename()) {
                $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                $fileName = 'qry_' . time() . '.' . $ext;
                $file->moveTo(WWW_ROOT . 'uploads/queries/' . $fileName);
                $data['attachment_file'] = $fileName;
            } else{
                unset($data['attachment_file']);
            }
            $query = $this->Queries->patchEntity($query, $data);

            if ($this->Queries->save($query)) {
                $this->Flash->success('Query submitted.');
            } else {
                $this->Flash->error('Failed to submit query.');
            }
        }
        return $this->redirect($this->referer());
    }

    public function addQueryComment($queryId){
        $comment = $this->QueryComments->newEmptyEntity();
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();
            $userId = $session->read('office.id');
            $office = $this->Offices->find()->where(['user_id' => $userId])->first();

            $data = $this->request->getData();
            $data['query_id'] = $queryId;
            $data['user_id'] = $userId;
            $data['office_id'] = $office->id;

            $file = $data['attachment_file'];
            if ($file && $file->getClientFilename()) {
                $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                $fileName = 'objc_' . time() . '.' . $ext;
                $file->moveTo(WWW_ROOT . 'uploads/queries/' . $fileName);
                $data['attachment_file'] = $fileName;
            } else{
                unset($data['attachment_file']);
            }

            $comment = $this->QueryComments->patchEntity($comment, $data);

            if ($this->QueryComments->save($comment)) {
                $this->Flash->success('Comment added.');
            } else {
                $this->Flash->error('Failed to add comment.');
            }
        }

        return $this->redirect($this->referer());
    }

    public function closeObjection($id){
        $objection = $this->Objections->get($id);
        // Only close if currently open
        if ($objection->status != 2) {
            $objection->status = 2; // Closed status
            if ($this->Objections->save($objection)) {
                $this->Flash->success('Objection has been closed successfully.');
            } else {
                $this->Flash->error('Unable to close objection, please try again.');
            }
        } else {
            $this->Flash->info('This objection is already closed.');
        }
        return $this->redirect($this->referer());
    }

    public function closeQuery($id){
        $query = $this->Queries->get($id);
        // Only close if currently open
        if ($query->status != 2) {
            $query->status = 2; // Closed status
            if ($this->Queries->save($query)) {
                $this->Flash->success('Query has been closed successfully.');
            } else {
                $this->Flash->error('Unable to close query, please try again.');
            }
        } else {
            $this->Flash->info('This query is already closed.');
        }
        return $this->redirect($this->referer());
    }

    public function sendOfficerShowCause(){
        $session = $this->getRequest()->getSession();
        $userId = $session->read('office.id');
        if ($this->request->is('post')) {
            $queryId = $this->request->getData('query_id');
            $message = $this->request->getData('message');
            $query = $this->Queries->get($queryId);
            if ($query->officer_notice_sent) {
                $this->Flash->error('Show-cause already sent.');
                return $this->redirect($this->referer());
            }

            // Get officer user from office
            $office = $this->Offices->get($query->to_office);
            if (!$office->user_id) {
                $this->Flash->error('Officer not assigned.');
                return $this->redirect($this->referer());
            }
            // Save log
            $cause = $this->QueryShowCause->newEmptyEntity();
            $cause->query_id = $query->id;
            $cause->to_user_id = $office->user_id;
            $cause->from_user_id = $userId;
            $cause->message = $message ?: 'Manual show-cause notice issued.';
            $this->QueryShowCause->save($cause);
            // Update query
            $query->officer_notice_sent = true;
            $query->officer_notice_date = date('Y-m-d H:i:s');
            $this->Queries->save($query);
            $this->Flash->success('Show-cause notice sent to officer.');
        }
        return $this->redirect($this->referer());
    }

	public function officeIndex(){
		$search = $this->request->getQuery('search');
		$query = $this->Offices
			->find()
			->contain(['Users', 'States', 'Districts'])
			->order(['Offices.id' => 'DESC']);
		if (!empty($search)) {
			$query->where([
				'OR' => [
					'Offices.name LIKE' => "%$search%",
					'Offices.email LIKE' => "%$search%",
					'Offices.phone LIKE' => "%$search%"
				]
			]);
		}
		$offices = $this->paginate($query, ['limit' => 10]);
		$this->set(compact('offices', 'search'));
	}

	public function officeAdd(){
		$office = $this->Offices->newEmptyEntity();
		if ($this->request->is('post')) {
			$office = $this->Offices->patchEntity($office, $this->request->getData());
			if ($this->Offices->save($office)) {
				$user = $this->Users->newEmptyEntity();
				$salt = bin2hex(random_bytes(16));
				$password = 'Mole@1234';
				$hashedPassword = $this->hashPasswordWithSalt($password, $salt);
				$userData = [
					'username' => $office->email,
					'off_name' => $office->officer_name,
					'email'    => $office->email,
					'password' => md5($password),
					'password_hash' => $hashedPassword,
					'salt' => $salt,
					'status'   => 1,
					'role' => 1,
					'created' => date('Y-m-d H:i:s')
				];
				$user = $this->Users->patchEntity($user, $userData);
				if ($this->Users->save($user)) {
					$office->user_id = $user->id;
					$this->Offices->save($office);
					$this->Flash->success(__('The office and its user account have been created successfully.'));
					return $this->redirect(['action' => 'officeIndex']);
				} else {
					$this->Flash->error(__('Office saved, but failed to create user account.'));
				}
			} else {
				$this->Flash->error(__('The office could not be saved. Please try again.'));
			}
		}

		$parentOffices = $this->Offices->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
		$states = $this->States->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

		$this->set(compact('office', 'parentOffices', 'states'));
	}

	public function getByState($stateId = null){
		$this->request->allowMethod(['ajax']);
		$this->autoRender = false;

		$districts = $this->Districts->find('list', [
			'keyField' => 'id',
			'valueField' => 'name',
		])
			->where(['state_id' => $stateId])
			->order(['name' => 'ASC'])
			->toArray();

		// Return JSON
		$this->response = $this->response->withType('application/json')
				->withStringBody(json_encode($districts));
		return $this->response;
	}

	public function hashPasswordWithSalt($password, $salt, $iterations = 10000){
		$toHash = $password . $salt;
		for ($i = 0; $i < $iterations; $i++) {
			$toHash = hash('sha512', $toHash);
		}
		return $toHash;
	}

	public function officeMapping($id = null){
		$office = $this->Offices->get($id, [
			'contain' => ['Districts', 'States', 'WorkingDistricts'],
		]);
		// Only districts belonging to the same state
		$districts = $this->fetchTable('Districts')
			->find('list', ['keyField' => 'id', 'valueField' => 'name'])
			->where(['state_id' => $office->state_id])
			->order(['name' => 'ASC'])
			->toArray();

		if ($this->request->is(['post', 'put'])) {
			$data = $this->request->getData();
			$selectedDistricts = $data['district_ids'] ?? [];

			$districtEntities = $this->Offices->WorkingDistricts->find()
				->where(['id IN' => $selectedDistricts])
				->toArray();
			$office->working_districts  = $districtEntities;
			if ($this->Offices->save($office)) {
				$this->Flash->success(__('District mapping has been updated.'));
				return $this->redirect(['action' => 'officeIndex']);
			}
			$this->Flash->error(__('Unable to update district mapping.'));
		}

		$this->set(compact('office', 'districts'));
	}
}