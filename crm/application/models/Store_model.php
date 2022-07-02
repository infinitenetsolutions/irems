<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->table = 'tbl_store';
		$this->primary_key = 'str_id';
	}
	public function insert($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}


	public function insert_data($table,$data){

		  $query = $this->db->insert($table,$data);
          return $query;
	   }

	   

	   public function insert_ingdata($table,$data){

		  $query = $this->db->insert($table,$data);
          return $query;
	   }



	   public function update_ingrednt_qty($in_id,$str_id,$data1)
	
	{

		$this->db->where('in_id',$in_id);
	    $this->db->where('str_id',$str_id);
		return  $this->db->update('store_in_link',$data1);
	}



	 public function getAllStores(){
		
		//return $this->db->select('*')->from($this->table)->get()->result_array();

			return $this->db->select('*')
			->from('tbl_store str')
			->join('tbl_store_product_link spl','spl.str_id = str.str_id')
			->group_by('str.str_name')
			->get()->result_array();

	}

	

	public function getproductlist($str_id){

			 return $this->db->select('*')
			->from('tbl_store_product_link spl')
		    ->join('packaging pac','pac.pac_id = spl.pac_id')
		    ->where('str_id',$str_id)
			->get()->result_array();
		
			

	}


	


	public function getdatabypacidandstrid($pac_id,$str_id){

			 return $this->db->select('*')
			->from('tbl_store_product_link spl')
		    //->join('packaging pac','pac.pac_id = spl.pac_id')
		    ->where('str_id',$str_id)
		     ->where('pac_id',$pac_id)
			->get()->row_array();
		
	}

	

	public function is_data_exist($tbl,$str_id,$in_id)
	{
		$this->db->where($str_id,$in_id);
		return $this->db->get($tbl)->num_rows();
	}


	public function getIngredientbypacid($pac_id){

			 return $this->db->select('*')
			->from('pro_in_link spl')
		    ->join('pro_in_link pil','pil.pac_id = spl.pac_id')
		    ->join('ingrediants in','in.in_id = pil.in_id')
		     ->where('spl.pac_id',$pac_id)
			 ->get()->row_array();
		
	}



	public function getAllProductsbystoreId($str_id){

			$qry = $this->db->select('*')
			->from('tbl_store_product_link spl')
		    ->join('packaging pac','pac.pac_id = spl.pac_id')
		    ->join('product pro','pro.p_id = pac.pac_id');
			if($str_id != 0)
			{
			$this->db->where('spl.str_id', $str_id);
			}
			return $this->db->get()->result_array();	
		
	}

	

  public function get_ingredient_by_strid($str_id,$in_id){

			$qry = $this->db->select('*')
							->from('store_in_link')
							->where('str_id', $str_id)
							->where('in_id', $in_id);
			
			return $this->db->get()->row_array();	
		
	}


	


	public function get_all_rawMaterialsItemsbystrid($str_id){

			$qry = $this->db->select('*')
			->from('store_in_link sil')
		    ->join('ingrediants in','in.in_id = sil.in_id')
		    ->join('tbl_store str','str.str_id = sil.str_id');

			if($str_id != 0)
			{
			$this->db->where('sil.str_id', $str_id);
			}
			// $this->db->select_sum('sil.qty');
			// $this->db->group_by('in.in_id');
			return $this->db->get()->result_array();	
		
	}








	
	public function gettotaLproductlink($str_id,$tbl){

			return $this->db->select('*')->from($tbl)->where('str_id',$str_id)->get()->num_rows();

       }
	

	public function getStoreById($str_id){
		return $this->db->select('*')->from($this->table)->where('str_id',$str_id)->get()->row();
	}


	public function update($str_id,$data){
		return $this->db->where('str_id',$str_id)->update($this->table,$data);
	}


	 public function is_store_name_exist($str_name)
			
			{
				$this->db->where('str_name',$str_name);
				$q=$this->db->get($this->table)->row();
				return $q;
			}





	
}
?>