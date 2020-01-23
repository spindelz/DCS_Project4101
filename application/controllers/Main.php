<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		$view = null;
		$this->render('login', 'เข้าสู่ระบบ','login', $view, '');
		// page type, page name, address of view file, data, js of this page
	}

}
