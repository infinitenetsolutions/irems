<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department extends CI_Controller {
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
	   $this->load->model('Department_model','department');
   }
	public function department_view()
	{	
		$this->data['page'] = 'payroll'; 
		$this->data['sub_page']='manage_department';
		$this->data['department']=$this->department->get_data_array();
		$this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);		
		$this->load->view('admin/department/manage_department',$this->data);
		$this->load->view('admin/include/footer',$this->data); 
		
	}	
	
	function add_department()
	{
		if($_POST)
		{
			if($this->department->is_department_exist($_POST['department_name'])==false)
			{
				$data = array(
					'department_name' => $this->input->post('department_name')
					);
                 $add=$this->department->save($data);
				if($add)
	 			{
					$this->session->set_flashdata('msg',"<div style='color:green;'>Department Added Successfully!</div>");
					//$this->session->set_userdata('class','green_msg');
					redirect(base_url().'admin/Department/department_view');
	 			}
			}
			else{
				 //$this->session->set_flashdata('msg', 'Data is Already Exist');
				redirect(base_url().'admin/Department/department_view');
				
			}
        }
	}
	
	
	public function edit_department_view()
	{
		
		$this->data['page'] = 'payroll'; 
		$this->data['sub_page']='manage department';
		$id=$this->uri->segment(4);
		$this->data['department_item'] = $this->department->get_department_by_id($id);
		$this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);		
		$this->load->view('admin/department/edit_department_view',$this->data);
		$this->load->view('admin/include/footer',$this->data); 
	}
	
	
		public function edit_department($d_id)
	{			$checkDepart = $this->department->is_department_exist($_POST['department_name']);
    			if (empty($checkDepart)) {
    				$update=$this->department->update_data($d_id,$_POST);
				if($update)
	 			{
					$data['status']=true;
					$data['msg']='Department Updated Successfully!';

	 			}
	 			else{
	 				$data['status']=false;
					$data['msg']='Unable to Updated!';
	 			}	 	    	
    		 }
	 			else{
	 				$data['status']=false;
					$data['msg']='Department name already exit!';
	 			}	
            echo json_encode($data);
        }
	
	 public  function delete_department($cid)
	{
		$data=array();
		$this->department->delete_data($cid);
		$this->session->set_flashdata('msg',"<div style='color:green;'>Department Deleted Successfully!</div>");
		redirect(base_url().'admin/Department/department_view');
	} 
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'admin/main');
	}



}