<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model {

	public function __construct()
		{
			parent::__construct();
		}	
	
	public function save_data($data)	 
	  {		 
		$this->db->insert('table_employee',$data);
		return true;				
	  } 
	  
	  
	 function get_all_employee($tbl)
	    {  
	        $this->db->from($tbl);
			$this->db->select('*');
		    $res=$this->db->get();
	        return $res->result_array();
	    }

	    function getAllEmployeeData()
	    {  
	        $this->db->from('table_employee');
			$this->db->select('*');
		    $res=$this->db->get();
	        return $res->result_array();
	    }

     function getAllEmpByStoreID()
	    {  
	        $this->db->from('tbl_manage_employee');
			$this->db->select('*');
			//$this->db->where('emp_status','Active');
		    $res=$this->db->get();
	        return $res->result_array();
	    }

	public function count_total_employee()
	{
	    
        $this->db->select('*');
        $this->db->from('table_employee');
        $id = $this->db->get()->num_rows();
        return $id;
	    
	}
	
		
	 public function get_data()
	{
		  $q = $this->db->get("table_employee");
            if($q->num_rows() > 0)
            {
                return $q->result();
            }
            return array();
    }

    public function get_employee_by_id($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('table_manage_employee');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('table_manage_employee', array('manage_employee_id' => $id));
        return $query->row_array();
    }
		
	public function update_data($tbl,$con,$data)
    {
        $this->db->where($con);
        $this->db->update($tbl,$data);
        return $this->db->affected_rows();
    }
	
	function get_data_array($tbl)
    {  
	
        $this->db->from($tbl);
		$this->db->select('*');
	    $res=$this->db->get();
        return $res->result_array();
    }
	
	public function delete_data($id)
    {
	$this->db->where('id', $id);
	$this->db->delete('table_employee');
	}

}