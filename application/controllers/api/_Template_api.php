<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  This file generate from tools.
 */
 
require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class [Name] extends REST_Controller{
    /**
     *    [$default_language description]
     *    @var null
     */
    public $default_language = null;

    /**
     *    [$primary_key description]
     *    @var string
     */
    public $primary_key = '[PrimaryKey]';

    public function __construct(){
    	parent::__construct();

    	$this->load->model('[ModelName]');
    }
    /**
     *    [index_get description]
     *    @author innosenz
     *    @date        2017-05-16
     *    @description []
     *    @param int $limit  [limit per page.]
     *    @param int $offset  [Offset start record index.]
     *    @param int $lang_id [Content culture.]
     *    @return      [type]        [description]
     */
    public function index_get(){
    	$data = array();

    	$limit   = 100;
    	$offset  = 0;
    	$lang_id = 1;

    	/*Read input*/
    	extract($this->get());

    	/* Find in database*/
    	if ($this->get($this->primary_key)) {
    		$data = $this->[ModelName]->getByKey($this->get($this->primary_key), $this->get('lang_id'), $convert_display = true);
    	} else {
    		$data = $this->[ModelName]->getAll($limit, $offset, $lang_id, $convert_display = true);
    	}

    	/* Response */
    	$this->response(empty($data) ? '' : $data, parent::HTTP_OK);
    }

    /**
     *    [index_put description]
     *    @author innosenz
     *    @date        2017-05-16
     *    @description [description]
     *    @return      [type]        [description]
     */
    public function index_post(){
    	$csrf_token_name = $this->config->item('csrf_token_name');

    	/*Read input*/
    	$input = $this->post();

    	/*validation*/
    	if (array_key_exists($csrf_token_name, $input)) {
    		unset($input[$csrf_token_name]);
    	}

    	$data = $this->security->xss_clean($input);

    	$this->[ModelName]->set_data_format($data);

    	/*Save to database*/
    	$result = $this->[ModelName]->insert($data);

    	/* Response*/
    	if ($result) {
    		$this->response($result, parent::HTTP_OK);
    	} else {
    		$this->response(lang('save_failure'), parent::HTTP_BAD_REQUEST);
    	}
    }

    /**
     *    [index_post description]
     *    @author innosenz
     *    @date        2017-05-16
     *    @description [description]
     *    @return      [type]        [description]
     */
    public function index_put(){
    	$csrf_token_name = $this->config->item('csrf_token_name');

    	/*Read input*/
    	$input  = $this->put();
    	$langId = $this->put('langId');

    	/*validation*/
    	if (array_key_exists($csrf_token_name, $input)) {
    		unset($input[$csrf_token_name]);
    	}

    	if (array_key_exists('langId', $input)) {
    		unset($input['langId']);
    	}

    	$data = $this->security->xss_clean($input);

    	$this->[ModelName]->set_data_format($data);

    	/*Save to database*/
    	$result = $this->[ModelName]->update($data, $langId);
    	if ($result) {
    		$this->response($result, parent::HTTP_OK);
    	} else {
    		$this->response(lang('save_failure'), parent::HTTP_BAD_REQUEST);
    	}
    }

    /**
     *    [index_delete description]
     *    @author innosenz
     *    @date        2017-05-16
     *    @description [description]
     *    @return      [type]        [description]
     */
    public function index_delete(){
    	$result = array();

    	/*Read input*/
    	$input = $this->delete();
    	$data  = array();
    	if (array_key_exists('data', $input)) {
    		$data = $input['data'];
    	}

    	/*validation*/

    	/*Save to database*/
    	if (!empty($data)) {
    		$result = $this->[ModelName]->deleteList($data);
    	} else {
    		$result = $this->[ModelName]->delete($input);
    	}

    	if ($result) {
    		$this->response($result, parent::HTTP_OK);
    	} else {
    		$this->response(lang('delete_failure'), parent::HTTP_BAD_REQUEST);
    	}
    }

    /**
     *    [ajax_list_post description]
     *    @author innosenz
     *    @date        2017-05-16
     *    @description [description]
     *    @return      [type]        [description]
     */
    public function ajax_list_post(){
    	/* Declare variables */
    	$debug = '';
    	$list  = array();
    	$data  = array();
    	$no    = $_POST['start'];

    	/* Read input criteria*/
    	$criteria = $this->input->post('criteria');

    	/* Remember criteria */
    	$this->session->set_userdata('criteria', $criteria);

    	/* Get data. */
    	$list  = $this->[ModelName]->get_datatables($criteria);
    	$debug = $this->db->last_query();

    	/* Build table row data.  */
    	foreach ($list as &$entity) {
    		/* Build controls actions */
    		$label_no = '<label>' . ++$no . '</label>';

    		$entity["no"] = $label_no;

    		/* Custom Columns HERE */

    		$entity['[PrimaryKey]'] = $entity['[PrimaryKey]'];

    	}

    	/* Response data*/
    	$output = array(
    		"draw"            => $_POST['draw'],
    		"recordsTotal"    => $this->[ModelName]->count_all(),
    		"recordsFiltered" => $this->[ModelName]->count_filtered($criteria),
    		"data"            => $list,
    		"debug"           => $debug,
    		);
    	$this->response($output, parent::HTTP_OK);
    }

    # Custom functions

    # End Custom functions

    # Private functions

    # End Private functions
}

/* End of file example_api_user.php */
/* Location: ./application/controllers/_example/example_api_user.php */
