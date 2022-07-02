
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
   public function __construct()
   {
        parent::__construct();
		$this->load->model('Main_model');
		$this->load->model('Admin_model');
		$this->load->model('Login_model');
   }
   
	public function index()
	{ 	
		if($this->session->userdata('admin_session') != ''){
			redirect('admin/');
		}
		 $this->load->view('login');
	}

	public function login_user()
	{
		$rememberMe = $this->input->post('rememberMe',TRUE);
		$username = $this->input->post('username',TRUE);
		$password = $this->input->post('password',TRUE);
     	if($username === '' &&  $password === ''){
	        $this->session->set_flashdata('danger',"Username and Password is required");
		    redirect("admin/login");				  
		}else{
			$validate = $this->Login_model->validate($username,$password);
			  if(!empty($validate)){
			  $name  = $validate['username'];
			  $admin_type = $validate['admin_type'];
			  $permission = $validate['permission'];
			  $sesdata = array(
			  	"user_id"=>$validate['user_id'],
			 	'username'  => $name,
			  	'permission' => $permission,
			  	'logged_in' => TRUE
			  );
			  $session =$this->session->set_userdata($sesdata);
			  if($rememberMe == 'rememberMe'){
				  	setcookie ("admin_username",$username,time()+ (10 * 365 * 24 * 60 * 60));  
	    			setcookie ("admin_password",$password,time()+ (10 * 365 * 24 * 60 * 60));	
			  }
			 	redirect("admin");		
			}else{
			  $this->session->set_flashdata('danger',"Incorrect username or password");
			  redirect("admin/login");
			}
		}		  
	}

		public function reset_password()
			{
				$username = $this->input->post('username',TRUE);
		     	if($username === ''){
			        $this->session->set_flashdata('danger',"Username and Password is required");				  
				}else{
					$validateAc = $this->Login_model->check_account_exist($username);
					  if(!empty($validateAc) && ($validateAc=='1')){
					  	$newPassword= $this->random_strings(8);
					}
				}		  
			}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'');
	}

	function random_strings($length_of_string) 
	{
	 $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
	  return substr(str_shuffle($str_result),0, $length_of_string); 
	} 
	
}



