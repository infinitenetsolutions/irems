<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch_model extends CI_Model {

	public function __construct()
		{
		parent::__construct();


		}
		
		
// 	public function save($data)
	 
// 	  {
		 
// 		  $this->db->insert('tbl_branch',$data);
// 		  return true;
				
// 	  } 


public function count_total_branches()
	{
	    
        $this->db->select('*');
        $this->db->from('tbl_branch');
        $id = $this->db->get()->num_rows();
        return $id;
	    
	}
	
	
	  public function save_asset_category($table,$data)
	 
	  {
		 
		 $query = $this->db->insert($table, $data);
         return $query;
				
	  } 

public function save($table,$data)
	 
	  {
		 
		 $query = $this->db->insert($table, $data);
          return $query;
				
	  } 
	  
	  
	  public function save_item_change($table,$data)
	 
	  {
		 
		 $query = $this->db->insert($table, $data);
          return $query;
				
	  } 
	  
	  
	  
     function update_asset_category($tbl,$con,$data)
    {
		
        $this->db->where($con);
        $this->db->update($tbl,$data);
        //$this->db->last_query();
        return $this->db->affected_rows();
    }
	
	
	  
	  public function get_asset_category_by_id($id = 0)
    
	{
		if ($id === 0)
		{
		$query = $this->db->get('tbl_asset_category');
		return $query->result_array();
		}

		$query = $this->db->get_where('tbl_asset_category', array('id' => $id));
		return $query->row_array();
    }
	  
	  

	  
		public function get_all_asset_category($tbl)
	   
	   {
		 
	    $q = $this->db->get($tbl);
		if($q->num_rows() > 0)
		{
		return $q->result();
		}
		return array();
		
        }
	  
	  
	  public function delete_asset_category($id)
	   {
	
		$this->db->where('id', $id);
		$this->db->delete('tbl_asset_category');
		}
		
	  
	  
	  	public function save1($data)
	 
	  {
		  $this->db2->insert('tbl_branch', $data);

		 // $this->db->insert('tbl_branch',$data);
		  return true;
				
	  } 
	  
	  
	  
	  public function get_all_branch_name($tbl)
	   {
		 
		$q = $this->db->get($tbl);
		if($q->num_rows() > 0)
		{
		return $q->result();
		}
		return array();
        }
        
        
        
          public function get_all_branchess($tbl)
	   {
		 
		$q = $this->db->get($tbl);
		if($q->num_rows() > 0)
		{
		return $q->result();
		}
		return array();
        }
		
        
        public function get_data_array1($tbl)
	   {
		 
		$q = $this->db->get($tbl);
		if($q->num_rows() > 0)
		{
		return $q->result();
		}
		return array();
        }
		
        
        
        
        
		 public function get_all_change_items()
	   
	   {
		 
		$this->db->select("tbl_clients.id,tbl_clients.client_name,tbl_items_change.client_id,tbl_items_change.*");
		$this->db->from('tbl_clients');
		$this->db->join('tbl_items_change', 'tbl_items_change.client_id = tbl_clients.id');
		$query = $this->db->get();

		if($query->num_rows() != 0)
		{
		return $query->result();
		}
		else
		{
		return false;
        }
        
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
	 return  $this->db->update('tbl_branch',$data);
	 }  
	 
	 
	 
	 
	 
	  public function get_all_assets_branch_location($tbl)
	   {
	     
	    	$this->db->select('DISTINCT(branch_location), client_id, branch_name');
	    	$q = $this->db->from($tbl);
            
	    	$que = $this->db->get();
	     //$this->db->group_by("branch_location");


		if($que->num_rows() > 0)
		{
		return $que->result();
		}
		return array();
        }
	 
	 public function get_all_branches()
	   {
		 
	    $this->db->select("tbl_clients.id,tbl_clients.client_name,tbl_branch.client_id,tbl_branch.*");
		$this->db->from('tbl_clients');
		$this->db->join('tbl_branch', 'tbl_branch.client_id = tbl_clients.id');
		$query = $this->db->get();

		if($query->num_rows() != 0)
		{
		return $query->result();
		}
		else
		{
		return false;
        }
        }
	   

	
	public function get_branch_by_id($id = 0)
    
	{
		if ($id === 0)
		{
		$query = $this->db->get('tbl_branch');
		return $query->result_array();
		}

		$query = $this->db->get_where('tbl_branch', array('id' => $id));
		return $query->row_array();
    }
	
	
		public function get_asset_by_id($id = 0)
    
	{
		if ($id === 0)
		{
		$query = $this->db->get('tbl_assets');
		return $query->result_array();
		}

		$query = $this->db->get_where('tbl_assets', array('id' => $id));
		return $query->row_array();
    }
	
	
	
		
		
		public function get_data_array()
	   {
		 
		$this->db->select("tbl_clients.id,tbl_clients.client_name,tbl_branch.client_id,tbl_branch.*");
		$this->db->from('tbl_clients');
		$this->db->join('tbl_branch', 'tbl_branch.client_id = tbl_clients.id');
		$query = $this->db->get();

		if($query->num_rows() != 0)
		{
		return $query->result();
		}
		else
		{
		return false;
        }
        }
		
		
		
	public function get_all_assets()
	   {
		 
	    $this->db->select("tbl_clients.id,tbl_clients.client_name,tbl_assets.client_id,tbl_assets.*");
		$this->db->from('tbl_clients');
		$this->db->join('tbl_assets', 'tbl_assets.client_id = tbl_clients.id');
		$query = $this->db->get();

		if($query->num_rows() != 0)
		{
		return $query->result();
		}
		else
		{
		return false;
        }
        }
		
		
	
	
	
	
     function update_change_item_data($tbl,$con,$data)
    {
		
        $this->db->where($con);
        $this->db->update($tbl,$data);
        //$this->db->last_query();
        return $this->db->affected_rows();
    }
    
		
	
	
     function update_asset_data($tbl,$con,$data)
    {
		
        $this->db->where($con);
        $this->db->update($tbl,$data);
        //$this->db->last_query();
        return $this->db->affected_rows();
    }
    
		
		
	
	function update_data($tbl,$con,$data)
    {
		
        $this->db->where($con);
        $this->db->update($tbl,$data);
        //$this->db->last_query();
        return $this->db->affected_rows();
    }
    
    
    
    public function get_change_item_by_id($id = 0)
    
	{
		if ($id === 0)
		{
		$query = $this->db->get('tbl_items_change');
		return $query->result_array();
		}

		$query = $this->db->get_where('tbl_items_change', array('id' => $id));
		return $query->row_array();
    }
	
    
	
		
		public function delete_data($id)
	   {
	
		$this->db->where('id', $id);
		$this->db->delete('tbl_branch');
		}
		
		public function delete_change_item_data($id)
	   {

		$this->db->where('id', $id);
		$this->db->delete('tbl_items_change');
		}
		
		public function delete_asset_data($id)
	   {
	
		$this->db->where('id', $id);
		$this->db->delete('tbl_assets');
		}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */