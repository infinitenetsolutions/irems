<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
   {
        parent::__construct();
       $this->load->model('Login_model');

		$this->load->model('Main_model');
   }
	
	public function index()
	{
		
		$this->load->view('login');
	}
	
	
	
		
	function login()
	
	{
		        // echo "working";

		$this->form_validation->set_rules('username', 'User Name', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

	
				  $username = $this->input->post('username',TRUE);
				  $password = $this->input->post('password',TRUE);

				  // echo $username;
				  // echo $password; 
				  $validate = $this->Login_model->validate($username,$password);
				  if($validate->num_rows() > 0){
				  $data  = $validate->row_array();
				  $name  = $data['username'];
				  $level = $data['user_level'];
				  $admin_type = $data['admin_type'];
				  $permission = $data['permission'];
				  
				  $sesdata = array(
				 'username'  => $name,
				  'level'     => $level,
				  'permission' => $permission,
				  'logged_in' => TRUE
				  );

				  // echo "<pre>";
				  // print_r($sesdata); exit;

				 $this->session->set_userdata($sesdata);
				// access login for admin
				if($level === '1'){
				   redirect(base_url()."admin/main/dashboard");

				   //access login for client
				//  }elseif($level === '2'){
				//   redirect(base_url()."client/main/client_dashboard");

				// // access login for Employee
				  }
				   elseif($level === '3'){
				  redirect(base_url()."admin/main/employee_dashboard");
				  }
				  
				  
				  //permission
                 elseif($admin_type === 'subadmin'){
				  redirect(base_url()."admin/main/dashboard");
				  }
				  
                   elseif($username === '' &&  $password === ''){
                   $this->session->set_flashdata('msg',"<div style='color:red;'>Username and Password is required");
				    redirect(base_url()."");				  }

				 } 
				  
				else{
				  $this->session->set_flashdata('msg',"<div style='color:red;'>Incorrect username or password");
				  redirect(base_url()."");
				}

	    
	
	
	
	
	
	}
	
	
	
	
}