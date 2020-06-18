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

	public $database_name = 'dcs';

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
	
	public $table_columns = null;
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');

        /*  check attribute */
		$this->_validateProperties();
		$this->_setProperties();
    }

    protected function _setFrom(){
        $this->db->from($this->table_name);
	}
	
	protected function _setColumnSelect(){
        $this->db->select('*');
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
	
	public function getAll($limit = false, $offeset = 0, $convert_display = false, $order_by = null) {
		
		if ($limit !== false) {
			$this->db->limit($limit, $offeset);
		}

		$this->_setColumnSelect();

		$this->_setFrom();

		if (!is_null($order_by)) {
			$this->db->order_by($order_by);
		}

		$results = $this->db->get()->result_array();

		if ($convert_display) {
			foreach ($results as $key => &$value) {
				$this->display_data_format($value);
			}
		}

		return $results;
	}
	
	public function getByKey($key, $convert_display = false) {
		$this->_setColumnSelect();

		$this->_setFrom();
		$this->_setFilter($key);
// echo $this->primary_key; die();
// 		$this->db->where($this->table_name . '.' . $this->primary_key, $key);

		$result = $this->db->get()->row_array();

		if ($convert_display) {
			$this->display_data_format($result);
		}

		return $result;
	}

	protected function _setFilter($key) {

		foreach ($this->primary_key as $column_name => $attributes) {
			if (is_array($key)) {
				if (!array_key_exists($column_name, $key)) {
					throw new Exception("Column : " . $column . "not found.", 1);
				}
				$this->db->where($this->table_name . '.' . $column_name, $key[$column_name]);
			} else {
				$this->db->where($this->table_name . '.' . $column_name, $key);
			}
		}
	}

	public function display_data_format(&$data) {
		foreach ($this->table_columns as $key => $column) {
			switch ($column['DATA_TYPE']) {
				case 'date':
					if ( !empty($data[$column['name']]) && array_key_exists($column['name'], $data)) {
						$data[$column['name']] = to_date_string($data[$column['name']]);
					}
					break;
				case 'datetime':
				case 'datetime2':
					if ( !empty($data[$column['name']]) && array_key_exists($column['name'], $data)) {
						$data[$column['name']] = to_datetime_string($data[$column['name']]);
					}
					break;
				case 'time':
					if ( !empty($data[$column['name']]) && array_key_exists($column['name'], $data)) {
						$data[$column['name']] = to_time_string($data[$column['name']]);
					}
					break;
				case 'decimal':
					if (  !empty($data[$column['name']]) && array_key_exists($column['name'], $data)) {
						$data[$column['name']] = to_number_string($data[$column['name']]);
					}
					break;

				default:
					# code...
					break;
			}
		}
	}

	private function _setProperties() {

		if (!isset($this->table_columns) || empty($this->table_columns)) {
			$pathFile = './assets/temp/json/table_columns_'.$this->table_name.'.json';
			if (!file_exists($pathFile))  {
				$this->table_columns = $this->_findColumns();
				$this->_SaveFileJson($this->table_columns, 'table_columns_'.$this->table_name);
			}else{
				$recoveredData = file_get_contents($pathFile);
				$Data_columns = unserialize($recoveredData);
				$this->table_columns = $Data_columns['data'];
			}
		}

		if ($this->is_translation && !isset($this->table_translation_columns)) {
			$pathFileTranslation = './assets/temp/json/table_translation_columns_'.$this->table_name.'.json';
			if (!file_exists($pathFileTranslation))  {
				$this->table_translation_columns = array_column($this->_findColumnsTranslation(), 'name');
				$this->_SaveFileJson($this->table_translation_columns, 'table_translation_columns_'.$this->table_name);
			}else{
				$recoveredData = file_get_contents($pathFileTranslation);
				$Data_columns = unserialize($recoveredData);
				$this->table_translation_columns = $Data_columns['data'];
			}
		}
	}

	public function _SaveFileJson($data, $filename) {

		$this->load->helper('file');
		$array = array('data'=>$data,'debug'=>'' ,'date_create'=>date('Y-m-d_H:i:s'));
		$serializedData = serialize($array);
		write_file('./assets/temp/json/'.$filename.'.json', $serializedData);

	}

	private function _findTable($table_name = null) {
		if (empty($table_name)) {
			$table_name = $this->table_name;
		}
		$table = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLES.TABLE_NAME = '" . $table_name . "'")->row_array();

		return $table;
	}

	private function _findColumns() {

		$this->db->select('COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH');
		$this->db->from('INFORMATION_SCHEMA.COLUMNS');
		$this->db->where('TABLE_SCHEMA', $this->database_name);
		$this->db->where('TABLE_NAME', $this->table_name);
		$columns = $this->db->get()->result_array();

		return $columns;
	}

}