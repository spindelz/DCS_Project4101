<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		
		// page type, page name, address of view file, data
		$this->render('normal_page', 'หน้าแรก','Home/index', null);
	}

}
