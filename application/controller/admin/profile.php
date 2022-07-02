<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct()
   {
        parent::__construct();
		if($this->session->userdata('user_id') == ''){
			redirect('admin/login');
		}
   }
   
	public function index()
	{ 
		$this->data['page'] = 'profile'; 
		
		$this->load->view('admin/include/sidebar',$this->data);
		$this->load->view('admin/profile',$this->data);
		$this->load->view('admin/include/footer',$this->data);
	}
	
}