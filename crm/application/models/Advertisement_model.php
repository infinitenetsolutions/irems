<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertisement_model extends CI_Model {

	public function __construct()
		{
			parent::__construct();
			$this->primary_key='adv_id';
			$this->table= 'tbl_adv';
		}	
		// insert data in Database
	public function insert_data($data)	 
	  {		 
		$this->db->insert('tbl_adv',$data);
		return $this->db->insert_id();			
	  } 
	  public function update_data($data,$adv_id)	 
	  {		 
		$this->db->where($this->primary_key, $adv_id);
		return $this->db->update($this->table,$data);		
	  } 
	
	  // delete data in Database
	  public function delete_data($id)
	    {
		$this->db->where('adv_id', $id);
		$this->db->delete('tbl_adv');
		}

	public function get_all_adv_by_status($adv_status,$adv_category)
	   {
				$this->db->select('*');
				$this->db->from('tbl_adv');
				$this->db->where('adv_category',$adv_category);
				$this->db->where('adv_status',$adv_status);
				$this->db->order_by("adv_DOC", "desc");
				$q = $this->db->get();
				$response = $q->result_array();
				return $response; 		
        }

	 public function get_single_adv_data($adv_id)
	   {
				$this->db->select('*');
				$this->db->from('tbl_adv');
				$this->db->where('adv_id',$adv_id);
				$q = $this->db->get();
				return $q->row_array();		
        }

	 public function delete_adv($adv_id)
	   {
			$this->db->where('adv_id',$adv_id);
			return $this->db->delete($this->table);						
        }

	 public function get_all_adv_tbl_data()
	   {		
	   			$this->db->select('*');
				$this->db->from('tbl_adv');
				$q = $this->db->get();
				return $q->result_array();		
        }    
     public function update_adv_status($adv_id,$adv_status)
	   {		
	   		$data = array(
            	'adv_status' => $adv_status
            	);
                $this->db->where($this->primary_key, $adv_id);
            	return $this->db->update($this->table,$data);
        }    
        
}