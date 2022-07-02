<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends CI_Model {

	public function __construct()
		{
		parent::__construct();

		$this->table= 'tbl_department';
		$this->primary_key='id';
		}
		
	
	public function save($data)
	 
	  {
		 
		  $this->db->insert('tbl_department',$data);
		  return true;
				
	  } 
	
	
	public function get_department_by_id($id = 0)
    {
		if ($id === 0)
		{
		$query = $this->db->get('tbl_department');
		return $query->result_array();
		}

		$query = $this->db->get_where('tbl_department', array('id' => $id));
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
		
		
	
	function update_data($d_id,$data)
    {
		
        return $this->db->where($this->primary_key,$d_id)->update($this->table,$data);
        //$this->db->last_query();
        // return $this->db->affected_rows();
    }
    
	public function delete_data($id)
	   {
	
		$this->db->where('id', $id);
		$this->db->delete('tbl_department');
		}

	public function is_department_exist($department_name)
	{
		$this->db->where('department_name',$department_name);
		$q= $this->db->get('tbl_department')->row();
		return $q;

	}

	public function get_depart_tbl()
	   {
			$this->db->select('*');
			$this->db->from('tbl_department');
			$query = $this->db->result_array();
			return $query;

        }
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */