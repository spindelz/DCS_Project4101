<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    public function __construct() {
        parent::__construct();

        $this->load->helper(array('url'));
        $this->load->library('session');
        // $this->load->library('encrypt');

        define('SITE',site_url());
        define('API_URL',site_url('api/'));

        define('ASSETS_SITE',base_url('assets'));
        define('ASSETS_CSS',base_url('assets/css'));
        define('ASSETS_IMG',base_url('assets/img'));
        define('ASSETS_JS',base_url('assets/js'));

        define('ERROR_INVALID_MODE','Error mode is invalid!!');
    }

    private function checkAuth(){
        if(!$this->session->user_logined){
            redirect(SITE.'Auth/login');
        }
    }
    
    protected function render($template = '', $page_name = '', $content = null, $data = null){
        switch($template){
            case 'normal_page':
                $this->checkAuth();
                $data_head['title'] = 'DCS-'.$page_name;
                $this->load->view('template/head', $data_head);
                $this->load->view('template/sidebar');
                $data['page_name'] = $page_name;
                $this->load->view('template/header');
                
                $this->load->view($content, $data);
                $this->load->view($content.'_js');

                $this->load->view('template/footer');
                $this->load->view('template/foot');
                break;
            case 'login':
                $data_head['title'] = 'DCS - '.$page_name;
                $this->load->view('template/head', $data_head);

                $this->load->view($content, $data);
                $this->load->view($content.'_js');
                
                $this->load->view('template/foot');
                break;
            case 'blank_page':
                $this->checkAuth();
                $this->load->view($content, $data);
                $this->load->view($content.'_js');
                break;
            default:
                $this->checkAuth();
                $this->load->view($content, $data);
                $this->load->view($content.'_js');
                break;
        }
    }

    protected function check_permission($rankID, $roleID, $userID){

        if(is_null($rankID) || is_null($userID)){
            return false;
        }

        $result = $this->permission_model->check_permission($rankID, $roleID, $userID);

        return count($result) > 0 ? true : false;

    }

    public function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    protected function format_date_sql($date){
        $str = explode('/',$date);
        return $str[2]."-".$str[1]."-".$str[0];
    }

    protected function format_date($date){
        if(!is_null($date)){
            $str = explode('-',$date);
            return $str[2]."/".$str[1]."/".$str[0];
        }else{
            return '';
        }
    }

    function js_asset($asset_name) {
        return '<script src="' . ASSETS_JS . $asset_name . '"></script>';
    }

    function url_index($index){
        $str_url = uri_string();
        $str_url = explode('/', $str_url);
        return $str_url[$index];
        
    }

}