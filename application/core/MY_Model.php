<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *    @author spindelz
 *    @credit innosenz
 *    @version     [1]
 *    @date        2017-03-06
 *
 */

class MY_Model extends CI_Model{

    /*
		    *    Table name for query builder.
		    *    Required parameter MUST be set.
		    *    ex. $table_name = "Users";
	*/
	public $table_name = null;

	/*
		    *    Primary key for query builder.
		    *    Required parameter MUST be set.
		    *    set array('column_name' => array of attribure)
		    *    ex. var $primary_key = array('UserID' => array('auto_increment' => TRUE));
		    *    or var $primary_key = "UserID" for one primary key and auto_increment is TRUE;
	*/
    public $primary_key = null;
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');

        /*  check attribute */
        $this->_validateProperties();
    }

    protected function _setFrom(){
        $this->db->from($this->table_name);
    }

    private function _validateProperties() {
		if (!isset($this->table_name) || empty($this->table_name)) {
			throw new Exception(get_class($this) . "'s " . '$table_name' . " does not set.", 1);
		}

		if (!isset($this->primary_key) || empty($this->primary_key)) {
			throw new Exception(get_class($this) . "'s " . '$primary_key' . " does not set.", 1);
		}

		if (is_string($this->primary_key)) {
			$this->primary_key = array($this->primary_key => array('auto_increment' => true));
		} else {
			$primary_key = array();
			foreach ($this->primary_key as $key => $value) {
				if (is_string($value)) {
					$primary_key[$value] = array('auto_increment' => true);
				} else {
					$primary_key[$key] = empty($value) ? array('auto_increment' => true) : $value;
				}
			}
			$this->primary_key = $primary_key;
		}
	}
}