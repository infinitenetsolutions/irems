<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation extends CI_Controller {
    public function __construct()
   {
          parent::__construct();
		//if($this->session->userdata('user_id') == ''){
			//redirect('admin/login');
		//}
		$this->load->model('Main_model');
		$this->load->model('Admin_model');
		$this->load->library('form_validation');
		$this->load->library('session');
	   $this->load->model('Designation_model','designation');
   }


	public function designation_view()
	{	
		$this->data['page'] = 'payroll'; 
		$this->data['sub_page']='manage_designation';
		$this->data['department']=$this->designation->get_data_array();
		$this->data['designation']=$this->designation->get_data();
		$this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);		
		$this->load->view('admin/designation/manage_designation',$this->data);
		$this->load->view('admin/include/footer',$this->data); 
		//echo "<pre>";
		//print_r($data['designation']); exit;
	}
	
	
	
	function add_designation()
	{
		if($_POST){
		$data = array (
		'dept_id' => $this->input->post('dept_id'),
		'designation' =>  $this->input->post('designation')
		);

		$add = $this->designation->insert_data($data);
		
		if($add)
				{
				$this->session->set_flashdata('msg',"<div style='color:green;'>Designation Added Successfully!</div>");
				//$this->session->set_userdata('class','green_msg');
				redirect(base_url().'admin/designation/designation_view');
					
	 			}
		}
		$this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);	
		$this->load->view('admin/designation/manage_designation',$this->data);	
		$this->load->view('admin/include/footer',$this->data); 
	}
	
	
	public function edit_designation_view()
	{
		 $this->data['page'] = 'payroll'; 
		$this->data['sub_page']='manage_designation';
		$id=$this->uri->segment(4);
		$this->data['designation_item']=$this->designation->get_designation_by_id($id);
		$this->data['department']=$this->designation->get_data_array();
		$this->data['designation']=$this->designation->get_data();
		$this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);		
		$this->load->view('admin/designation/edit_designation_view',$this->data);
		$this->load->view('admin/include/footer',$this->data); 

	}
	
	
		public function edit_designation($d_id)
			{			
				$checkDepart = $this->designation->is_designation_exist($_POST['dept_id'],$_POST['designation']);

		    			if (empty($checkDepart)) {
		    				$update=$this->designation->update_data($d_id,$_POST);
						if($update)
			 			{
							$data['status']=true;
							$data['msg']='Designation Updated Successfully!';

			 			}
			 			else{
			 				$data['status']=false;
							$data['msg']='Unable to Updated Designation!';
			 			}	 	    	
		    					 	    }
			 			else{
			 				$data['status']=false;
							$data['msg']='Department or Designation Name Already Exit!';
			 			}	
		    					 	    		 	    
						
		            
		            echo json_encode($data);
		        }

	
	 public  function delete_designation($cid)
	{
		
		$data=array();
		$this->designation->delete_designation($cid);
		$this->session->set_flashdata('msg',"<div style='color:green;'>Designation Deleted Successfully!</div>");
		redirect(base_url().'admin/Designation/designation_view');
	} 


	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'admin/main');
	}
}