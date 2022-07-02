<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->table = 'tbl_projects';
		$this->primary_key = 'projects_id';
	}
	 public function getAllData(){
		  return $this->db->select('*')
              ->from('tbl_projects')
              ->where('status',md5("visible"))
              ->get()
              ->result_array();
	}
  
     
     public function get_projectData_byprojectId($p_id)
	   {
				$this->db->select('*');
				$this->db->from($this->table);
				$this->db->where($this->primary_key,$p_id);
				$q = $this->db->get();
				return $q->row_array();		
        }
	
	
}
?>