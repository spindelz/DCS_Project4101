<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  This file generate from tools.
 */

class [Name]_model extends MY_Model
{
    /*
     *    Set table name for query builder
     *    Required
     */
    public $table_name = '[TableName]';

    /*
     *    Set primary key for query builder
     *    Required
     */
    public $primary_key = [PrimaryKey];

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
    	$temp_id = $this->session->userdata('site_id');
    	$site_id = !empty($temp_id) ? $temp_id : "0";

    	$this->_setFrom();

    	/* Insert filter here*/
    	if (array_key_exists('keyword', $criteria) && !empty($criteria['keyword'])) {
    		$this->db->like("[TableName].[Column1]", $criteria['keyword']);
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

    	$this->_setColumnSelect();

    	/* Order */
    	if (isset($_POST['order'])) {
    		$order_column_index = $_POST['order']['0']['column'];
    		$order_dir          = $_POST['order']['0']['dir'];
    		$order_column       = $_POST['columns'][$order_column_index]['name'];

    		$this->db->order_by($order_column, $order_dir);
    	} else {
            $this->db->order_by('[TableName].[Column1]', 'asc');
        }

        if ($_POST['length'] != -1) {
          $this->db->limit($_POST['length'], $_POST['start']);
      }

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

}

/* End of file [Name]_model.php */
/* Location: ./application/models/[Name]_model.php */
