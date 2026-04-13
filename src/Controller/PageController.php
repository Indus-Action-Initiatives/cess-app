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

class PageController extends AppController{

	public function initialize(): void {
		parent::initialize();
		$this->viewBuilder()->setLayout('page');
	}

	public function aboutUs(){
		$title = 'About Us - BOCW Cess Portal';
		$active = 'about';
		$this->set(compact('title', 'active'));
	}

	public function contactUs(){
		$title = 'Contact Us - BOCW Cess Portal';
		$active = 'contact';
		$this->set(compact('title', 'active'));
	}

	public function faqs(){
		$title = 'FAQs - BOCW Cess Portal';
		$active = 'faqs';
		$this->set(compact('title', 'active'));
	}

}