<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation_model extends CI_Model {

	public function __construct()
		{
		parent::__construct();

		$this->table= 'tbl_manage_designation';
		$this->primary_key='manage_designation_id';

		}
		
	public function is_designation_exist($department_id,$department_name)
	{
		//$this->db->where('id',$department_id,'department_name',$department_name);
		$this->db->where('dept_id',$department_id);
		$this->db->where('designation',$department_name);
		$q= $this->db->get($this->table)->row();
		return $q;

	}
	
	public function insert_data($data)
	 
	  {
		 
		  $this->db->insert($this->table,$data);
           return $this->db->insert_id();
				
	  } 
	
	
	public function get_designation_by_id($id = 0)
    
	{
       //echo "working"; exit;
		if ($id === 0)
		{
		$query = $this->db->get($this->table);
		return $query->result_array();
		}

		$query = $this->db->get_where($this->table, array('manage_designation_id' => $id));
		return $query->row_array();
    }
	
	
	
		
		
		public function get_data_array()
	   {
		 
            $q = $this->db->get('tbl_department');
            if($q->num_rows() > 0)
            {
                return $q->result();
            }
            return array();
        }
		
		
		
		public function get_data()
	   {
		 
		 
		$this->db->select("tbl_designation.id,tbl_designation.dept_id,tbl_designation.designation,tbl_department
.department_name");
		$this->db->from($this->table);
		$this->db->join('tbl_department', 'tbl_designation.dept_id = tbl_department.id');
		$query = $this->db->get();

		if($query->num_rows() != 0)
		{
		return $query->result();
		}
		else
		{
		return false;
		}
		
            //$q = $this->db->get($this->table);
            //if($q->num_rows() > 0)
            //{
                //return $q->result();
            //}
            //return array();
        }
		
	
		
	
	function update_data($d_id,$data)
    {
    	 return $this->db->where($this->primary_key,$d_id)->update($this->table,$data);
        // $this->db->where($con);
        // $this->db->update($tbl,$data);
        // //$this->db->last_query();
        // return $this->db->affected_rows();
    }
    
    
	
		
		public function delete_designation($id)
	   {
	
		$this->db->where('id', $id);
		$this->db->delete($this->table);
		}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */