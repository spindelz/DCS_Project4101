<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Users_model extends MY_Model{
    /*
     *    Set table name for query builder
     *    Required
     */
    public $table_name = 'users';

    /*
     *    Set primary key for query builder
     *    Required
     */
    public $primary_key = 'ID';

    /*
     *    Set primary key for query builder
     *     Default FALSE;
     *     ex. var $is_translation = FALSE
     */
    public $is_translation = false;

    /**
     *    Set table translation name
     *     ex. var $table_translation_name = "UsersTranslation"
     */
    public $table_translation_name = null;

    /**
     *    Set table translation name
     *    ex. var $table_columns = array('column_name' => array('display' => true, 'display_format' => '', 'max_length' => '4', 'require' => FLASE))
     */
    public $table_columns = null;

    /**
     *    Set table translation name
     *    ex. var $table_translation_columns = array('column_name' => array('display' => true, 'display_format' => '', 'max_length' => '4', 'require' => FLASE))
     */
    public $table_translation_columns = null;

    #Datatable functions
    /**
     *    [_get_datatables_query Get datatable query by criteria.]
     *    @author innosenz
     *    @date   2017-07-10
     *    @param  array      $criteria [description]
     *    @return [type]               [description]
     */
    private function _get_datatables_query($criteria = array())
    {
        $this->_setFrom();
        // $this->db->join('table','clause','left')

    	/* Insert filter here*/
    	if (array_key_exists('keyword', $criteria) && !empty($criteria['keyword'])) {
    		$this->db->like("Users.ID", $criteria['keyword']);
    	}
    }

    /**
     *    [get_datatables Get data datatable by criteriaR.]
     *    @author innosenz
     *    @date   2017-07-10
     *    @param  [type]     $criteria [description]
     *    @return [type]               [description]
     */
    public function get_datatables($criteria)
    {
    	$this->_get_datatables_query($criteria);

        $this->db->select('*');

    	/* Order */
    	$this->db->order_by($this->primary_key, 'asc');

        // if ($_POST['length'] != -1) {
        //     $this->db->limit($_POST['length'], $_POST['start']);
        // }

        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     *    [count_filtered Get count recourd that found by filter.]
     *    @author innosenz
     *    @date   2017-07-10
     *    @param  [type]     $criteria [description]
     *    @return [type]               [description]
     */
    public function count_filtered($criteria)
    {
    	$this->_get_datatables_query($criteria);
    	$results = $this->db->count_all_results();
    	return $results;
    }

    /**
     *    [count_all Get all count recourd that found by filter.]
     *    @author innosenz
     *    @date   2017-07-10
     *    @return [type]     [description]
     */
    public function count_all()
    {
    	$this->_get_datatables_query();
    	return $this->db->count_all_results();
    }

    #Datatable functions

    #Custom functions
    /**
     *    [save description]
     *    @author innosenz
     *    @date   2017-07-10
     *    @param  [type]     $data [description]
     *    @param  [type]     $lang [description]
     *    @return [type]           [description]
     */
    public function save($data, $lang)
    {

    }

    #Custom functions
    // public function getAll()
    // {
    //     $this->_setColumnSelect();
    //     $this->_setFrom();

    //     return $this->db->get()->result_array();
    // }
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
