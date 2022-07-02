<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model {

	public function __construct()
		{
		parent::__construct();
		// $this->table='tbl_po';
		// $this->primary_key='id';


		}




public function get_ProductOrderDetails_data($p_id,$pac_id,$start_date,$end_date,$status)
		 {

		 	return $this->db->select('*')
						->from('pro_order_link pol')
						->join('packaging pac','pac.pac_id = pol.pac_id')
						->join('product pro','pro.p_id = pol.p_id')
						->where('pol.p_id',$p_id)
						->where('pac.pac_id',$pac_id)						
						->where('pol.order_status','ACTIVE')
						->where('pol.po_status',$status)
						->where('order_doc BETWEEN "'.date('Y-m-d h:i:s',strtotime($start_date)).'" and "'.date('Y-m-d h:i:s',strtotime($end_date)).'"')
						->get()->result_array();
		 }


		 public function getAllActiveProductordersForPackaging($p_id,$pac_id,$start_date,$end_date,$status)
		 {


		 	return $this->db->select('*')
						->from('pro_order_link pol')
						->join('packaging pac','pac.pac_id = pol.pac_id')
						->join('product pro','pro.p_id = pol.p_id')
						->where('pol.p_id',$p_id)
						->where('pac.pac_id',$pac_id)						
						->where('pol.order_status','ACTIVE')
						->where('pol.po_status',$status)
						->where('order_doc BETWEEN "'.date('Y-m-d h:i:s',strtotime($start_date)).'" and "'.date('Y-m-d h:i:s',strtotime($end_date)).'"')
						->get()->result_array();
		 }


		  public function getAllActiveProductordersForPackaged($p_id,$pac_id,$start_date,$end_date,$status)
		 {


		 	return $this->db->select('*')
						->from('pac_order paco')
					    ->join('packaging pac','pac.pac_id = paco.pac_id')
					    ->where('paco.p_id',$p_id)
						->where('pac.pac_id',$pac_id)
						->where('paco.pac_order_status',$status)
						->where('pac_order_doc BETWEEN "'.date('Y-m-d h:i:s',strtotime($start_date)).'" and "'.date('Y-m-d h:i:s',strtotime($end_date)).'"')
						//->group_by('po.batch_no')
						->get()->result_array();
		 }


		  public function getAllActiveCompletedProductorders($p_id,$pac_id,$start_date,$end_date,$status)
		 {


		 	return $this->db->select('*')
						->from('pac_order paco')
					    ->join('packaging pac','pac.pac_id = paco.pac_id')
					    ->where('paco.p_id',$p_id)
						->where('pac.pac_id',$pac_id)
						->where('paco.pac_order_status',$status)
						->where('pac_order_doc BETWEEN "'.date('Y-m-d h:i:s',strtotime($start_date)).'" and "'.date('Y-m-d h:i:s',strtotime($end_date)).'"')
						//->group_by('po.batch_no')
						->get()->result_array();
		 }


		 

		  public function fetch_processdetailsbypid($p_id)
		 
		 {


			  return $this->db->select('*')
						->from('pro_process pp')
						->where('pp.p_id',$p_id)
					    // ->where('pp.process_id',$process_id)
						->where('pp.process_status','ACTIVE')
						->get()->result_array();


           }
 


        public function fetch_processlog_details($p_id,$pac_id,$batch_no)
		 
		 {

			     return $this->db->select('*')
				->from('process_log pl')
				->join('packaging pac','pac.pac_id = pl.pac_id')
				//->join('packaging pac','pac.pac_id = pl.pac_id')
				->where('pl.p_id',$p_id)
				->where('pl.batch_no',$batch_no)
				->where('pac.pac_id',$pac_id)
				->get()->row_array();

           }
 

		 public function get_InOrderDetails_data($in_id,$start_date,$end_date,$status)
		 {

				
				$this->db->select('*');
				$this->db->from('po_in_link pil');
				$this->db->join('tbl_po po','po.po_no = pil.po_no');
	            $this->db->where('ingredient_id',$in_id);
	            $this->db->where('order_status',$status);

			    $this->db->where('pol_doc BETWEEN "'.date('Y-m-d h:i:s',strtotime($start_date)).'" and "'.date('Y-m-d h:i:s',strtotime($end_date)).'"');
			    $query =  $this->db->get();
			    // echo $this->db->last_query();exit;
			    return $query->result_array();


					// $this->db->select("*");
					// $this->db->from($tbl);
					// $this->db->where('ingredient_id',$in_id);
					// $this->db->where('pol_doc BETWEEN "'.$start_date.'" and "'.$end_date.'"');
					//        //exit($this->db->last_query());
					// return $this->db->get()->result_array();
		 }


		
		public function getProductsByproductId($p_id,$psize){

		return $this->db->select('*')->from($tbl)->where('p_id',$p_id)->get()->result_array();
	}
	

     
      public function get_all_rawMaterialsItems($tbl)
	
	{

 			$query = $this->db->get($tbl);			
 			$result = $query->result_array();
			return $result;


	}


public function insert($data){

		 return $this->db->insert('packaging_attribute',$data);
		 
	}

	public function insert1($data){

		 return $this->db->insert('nutritional_facts',$data);
		 
	}


	public function getplaceholdervalues($key)
	
	{
		return $this->db->select('*')
						->from('packaging_attribute')
						->like('attr_name',$key)
						->get()->result_array();
	}


	public function getplaceholdervalues1($key)
	
	{
		return $this->db->select('*')
						->from('nutritional_facts')
						->like('nf_name',$key)
						->get()->result_array();
	}



	public function updatebyarray($data,$filterarray){

		 return $this->db->where($filterarray)->update('packaging_attribute',$data);
	}
	


		public function updatebyarray1($data,$filterarray){

		 return $this->db->where($filterarray)->update('nutritional_facts',$data);
	}

	 public function get_all_processedFoodItems($tbl)
	
	{

 			$query = $this->db->get($tbl);			
 			$result = $query->result_array();
			return $result;


	}	

	public function update($attr_id,$data){
		 return $this->db->where('attr_id',$attr_id)->update('packaging_attribute',$data);
	}

	public function update1($nf_id,$data){
		 return $this->db->where('nf_id',$nf_id)->update('nutritional_facts',$data);
	}

	public function getFilterData($data)
	{
		return $this->db->select('*')->from('packaging_attribute')->where($data)->get()->row();
	}


   public function getFilterData1($data)
	{
		return $this->db->select('*')->from('nutritional_facts')->where($data)->get()->row();
	}


	


	  public function getproductattrlist($p_id,$pac_id)
		 
		 {

			     return $this->db->select('*')
				->from('packaging_attribute pa')
			    ->join('product pro','pro.p_id = pa.p_id')
				->join('packaging pac','pac.pac_id = pa.pac_id')
				->where('pa.p_id',$p_id)
				->where('pa.pac_id',$pac_id)
				->get()->result_array();

           }



            public function getnutfact($p_id,$pac_id)
		 
		 {

			     return $this->db->select('*')
				->from('nutritional_facts nf')
			    ->join('product pro','pro.p_id = nf.p_id')
				->join('packaging pac','pac.pac_id = nf.pac_id')
				->where('nf.p_id',$p_id)
				->where('nf.pac_id',$pac_id)
				->get()->result_array();

           }



           
	
}

