<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Properties_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->table = 'tbl_property_type';
		$this->primary_key = 'property_type_id';
	}
	 public function getAllData(){
		return $this->db->select('*')->from($this->table)->get()->result_array();
	}
	
}
?>