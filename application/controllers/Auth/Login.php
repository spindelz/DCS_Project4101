<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	function __construct() {
		parent::__construct();
		
	}
	
	public function index(){
		
		// page type, page name, address of view file, data
		$this->render('login', 'เข้าสู่ระบบ','Auth/login', null);
	}

}
