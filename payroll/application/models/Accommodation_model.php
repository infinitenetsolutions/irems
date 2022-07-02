<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accommodation_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->table = 'tbl_accommodation_type';
		$this->primary_key = 'accommodation_type_id';
	}
	 public function getAllData(){
		return $this->db->select('*')->from($this->table)->get()->result_array();
	}
	
}
?>