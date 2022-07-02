
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

			//echo "working"; exit();
		$rememberMe = $this->input->post('rememberMe',TRUE);
		$email = $this->input->post('email',TRUE);
		$password = md5($this->input->post('password'));

		//echo $username; echo $password;
            $validate = $this->Login_model->all_user();
            //  echo "<pre>";
            // print_r($validate); 
                                //Checking If Data Is Available
                                if(count($validate) != 0){
                                    foreach($validate as $rows){
                                        //Get Admin Log In Information.  

                                        $employee_info = json_decode($rows["manage_employee_info"]);
                                        // echo "<pre>";
                                        // print_r($admin_log); 
                                         if($employee_info->email == $email){

                                          $sessionLogInfo = array(
                                                                        "email"       =>  $employee_info->email,
                                                                        "user_id"     =>  $rows['manage_employee_id']
                                                                        //"user"   =>  $employee_info->firstName
                                                                                    
                                                                      );
                                                 $session =$this->session->set_userdata($sessionLogInfo);
                                           
                                                //Add New Log Information In Log In Information
                                                 redirect("admin/leadmanage/manage_lead");		                                                    
                                            } 
                                              

                                         
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



