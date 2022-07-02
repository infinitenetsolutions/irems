<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model {

	public function __construct()
		{
		parent::__construct();
		}
		      		
	public function save_data($data)
	{		
	  $this->db->insert('tbl_clients',$data);
	  return true;		
	}
	
	
	public function save_region($data)
	{		
	  $this->db->insert('tbl_regions',$data);
	  return true;		
	}
	
	
	
	 public function get_region()
	
	{
		  $q = $this->db->get("tbl_regions");
            if($q->num_rows() > 0)
            {
                return $q->result();
            }
            return array();
			
			
	    
    }	
	
	
	public function get_region_by_id($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('tbl_regions');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('tbl_regions', array('id' => $id));
        return $query->row_array();
    }
	public function update_region($tbl,$con,$data)
    {
        $this->db->where($con);
        $this->db->update($tbl,$data);
        return $this->db->affected_rows();
    }
	
	public function count_total_clients()
	{
	    
	    
	    
        $this->db->select('*');
        $this->db->from('tbl_clients');
        $id = $this->db->get()->num_rows();
        return $id;
	    
	    
	 	
	}

	
		public function get_client_id_by_username($userName)
		
		{
		    
		 $this->db->select('*');
        $this->db->from('tbl_branch');
        $this->db->where('tbl_branch.username', $userName);
        $query = $this->db->get();
        return $query->result_array();
		    
		}
	
	public function count_total_tickets($userName)
	{
	    
	    
	    
        $this->db->select('*');
        $this->db->from('tbl_tickets');
        $this->db->where('tbl_tickets.username', $userName);
        $id = $this->db->get()->num_rows();
        return $id;
	    
	    
	 	
	}
	
	
		public function count_total_close_tickets($userName)
	{
	    
	    
	    
        $this->db->select('*');
        $this->db->from('tbl_tickets');
        $this->db->where('tbl_tickets.username', $userName);
        $this->db->where('tbl_tickets.status', 'Closed');

        $id = $this->db->get()->num_rows();
        return $id;
	    
	    
	 	
	}
	
	
	
		public function count_total_open_tickets($userName)
	{
	    
	    
	    
        $this->db->select('*');
        $this->db->from('tbl_tickets');
        $this->db->where('tbl_tickets.username', $userName);
        $this->db->where('tbl_tickets.status', 'In Progress');
        $id = $this->db->get()->num_rows();
        return $id;
	    
	    
	 	
	}
	
	
	
	

	
	public function update_status()
	 {
	     
	     $id = $_REQUEST['sid'];
	     $sval = $_REQUEST['sval'];
	     if($sval==1)
	     {
	        $status = 0; 
	     }
        else
        {
            $status = 1;
        }
	     $data = array(
	         'status' => $status
	         
	         ); 
	  $this->db->where('id',$id);
	 return  $this->db->update('tbl_clients',$data);
	 }         
	   


  public function get_all_clients()
	{
		  $q = $this->db->get("tbl_clients");
            if($q->num_rows() > 0)
            {
                return $q->result();
            }
            return array();
    }	




    public function get_data()
	{
		  $q = $this->db->get("tbl_clients");
            if($q->num_rows() > 0)
            {
                return $q->result();
            }
            return array();
    }	
	
	public function get_conference_by_id($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('tbl_clients');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('tbl_clients', array('id' => $id));
        return $query->row_array();
    }
	
	public function update_data($tbl,$con,$data)
    {
        $this->db->where($con);
        $this->db->update($tbl,$data);
        return $this->db->affected_rows();
    }
	
	public function delete_data($id)
    {
	$this->db->where('id', $id);
	$this->db->delete('tbl_clients');
	}
	
	
	public function delete_region($id)
    {
	$this->db->where('id', $id);
	$this->db->delete('tbl_regions');
	}
	

}