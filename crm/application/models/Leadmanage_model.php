<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leadmanage_model extends CI_Model {

	public function __construct()
		{
			parent::__construct();
			$this->primary_key='l_id';
			$this->table= 'tbl_lead';
		}	
		// insert data in Database
	public function insert_data($data)	 
	  {		 
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();			
	  } 
	  public function update_data($data,$lead_id)	 
	  {		 
		$this->db->where($this->primary_key, $lead_id);
		return $this->db->update($this->table,$data);		
	  } 
	
	  // delete data in Database
	  public function delete_data($id)
	    {
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table);
		}

		 public function get_all_leads_by_status($l_status,$adv_id,$emp_id)
		   {
		   		$today=date("Y-m-d",strtotime(' + 1 day')).' 00:00:00';
		   		$this->db->select('*');
				$this->db->from($this->table);
		   		if($l_status=='TODAY'){
					$this->db->where('l_followup <=',date('Y-m-d H:i:s',strtotime($today)));
		   		}
		   		if($l_status=='FUTURE'){
					$this->db->where('l_followup >=',date('Y-m-d H:i:s',strtotime($today)));
		   		}
		   		if($l_status=='SUCCESS'){
					$this->db->where('l_status',$l_status);
		   		}
		   		if($l_status=='FAILED'){
					$this->db->where('l_status',$l_status);
		   		}
		   		if($adv_id!='0'){
					$this->db->where('l_advid',$adv_id);
		   		}

		   		if($emp_id!='0' && $emp_id!='1'){
					$this->db->where('employee_id',$emp_id);
		   		}
				$q = $this->db->get();
				//  echo $this->db->last_query();
				// exit();
				$response = $q->result_array();
				// print_r($response) ;
				// exit();		
				return $response;	
	        }
  
  
  
		 public function get_lead_count($l_advid)
		   {
					 $this->db->select('*');
					$this->db->from($this->table);
					$this->db->where('l_advid',$l_advid);
					$this->db->where('l_status','PENDING');
				    $countNum = $this->db->get()->num_rows();
				    return $countNum;		
	        }

	 public function get_single_lead_data($lead_id)
	   {
				$this->db->select('*');
				$this->db->from($this->table);
				$this->db->where($this->primary_key,$lead_id);
				$q = $this->db->get();
				return $q->row_array();		
        }

	 public function delete_adv($adv_id)
	   {
			$this->db->where('adv_id',$adv_id);
			return $this->db->delete($this->table);						
        }

       public function is_data_exist($col_name,$data)
		{
			$this->db->where($col_name,$data);
			return $this->db->get($this->table)->num_rows();
		}


}