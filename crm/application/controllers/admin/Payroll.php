<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll extends CI_Controller {
    public function __construct()
   {
         parent::__construct();
		//if($this->session->userdata('user_id') == ''){
			//redirect('admin/login');
		//}
		$this->load->model('Main_model');
		$this->load->model('Admin_model');
		$this->load->model('Department_model','dm');
		$this->load->model('Designation_model','designation');
		$this->load->library('form_validation');
		$this->load->library('session');		
	    $this->load->model('Payroll_model');
	    $this->load->model('Store_model','Store');
	    //$this->data['view_path'] = $_SERVER['DOCUMENT_ROOT'].'/ateebfood/application/views/'; 
        $this->data['view_path'] = $_SERVER['DOCUMENT_ROOT'] .'/irems/crm/application/views/';

   }

	public function employee_view()	
	{	
		$this->data['page'] = 'payroll'; 
		$this->data['sub_page']='employee_view';
		$this->data['employee']=$this->Payroll_model->get_employee_data();
		$this->data['store']=$this->Store->getAllStores();
		$this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);		
		$this->load->view('admin/payroll/manage_employee',$this->data);
		// echo "<pre>";
		// print_r($data['employee']);
		// exit();
	}

	public function add_employee_view()
	{ 
		$this->data['page'] = 'payroll';
		$this->data['sub_page']='employee_register';
		$this->data['department']=$this->Payroll_model->get_data_array('tbl_department');
		$this->data['store']=$this->Store->getAllStores();
		$this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);
		$this->load->view('admin/payroll/add_employee_view',$this->data);
		// $this->load->view('admin/include/footer',$this->data);
	}

	public function edit_employee()
	{
		$this->data['page'] = 'payroll';
		$this->data['sub_page']='employee_view';
		$id=$this->uri->segment(4);
		$this->data['employee_item']=$this->Payroll_model->get_employee_by_id_edit($id);
		$this->data['department']=$this->Payroll_model->get_data_array('tbl_department');
		$this->data['designation']=$this->Payroll_model->get_data_array('tbl_designation');
		$this->data['store']=$this->Store->getAllStores();
		$this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);
		$this->load->view('admin/payroll/edit_employee',$this->data);
	}
		
	function add_employee()
	{		

		if($this->Payroll_model->is_employee_id_exist($this->input->post('employee_id'))==false){

			 $config['upload_path'] = './upload/employee/';
					$config['overwrite']=TRUE;
					$config['allowed_types'] = 'jpg|jpeg|gif|png|PNG';
					$config['max_size']    = '20000';
					$config['remove_spaces'] = FALSE;

                    $this->load->library('upload');
                    $this->upload->initialize($config);
					$this->upload->do_upload('image');
					$file_name = $this->upload->data();
					
					$new_name = $_FILES['image']['name'];
					$config['image'] = $new_name;
		    					
					$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'employee_id' => $this->input->post('employee_id'),
					'mobile' => $this->input->post('mobile'),
					'date_of_birth' => $this->input->post('date_of_birth'),
					'gender' => $this->input->post('gender'),								
					'department' => $this->input->post('department'),
					'designation' => $this->input->post('designation'),
					'reporting_to' => $this->input->post('reporting_to'),
					'date_of_hire' => $this->input->post('date_of_hire'),
					'source_of_hire' => $this->input->post('source_of_hire'),
					'emp_status' => $this->input->post('emp_status'),
					'work_phone_no' => $this->input->post('work_phone_no'),
					'emp_type' => $this->input->post('emp_type'),					
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'country' => $this->input->post('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city'),
					'basic_salary' => $this->input->post('basic_salary'),
					'pf_emp' => $this->input->post('pf_emp'),
					'pf_cmp' => $this->input->post('pf_cmp'),
					'esic_emp' => $this->input->post('esic_emp'),
					'esic_cmp' => $this->input->post('esic_cmp'),
					'cut_from' => $this->input->post('cut_from'),										
					'postal_code' => $this->input->post('postal_code'),
					'other_mobile' => $this->input->post('other_mobile'),
					'other_email' => $this->input->post('other_email'),					
					'nationality' => $this->input->post('nationality'),
					'marital_status' => $this->input->post('marital_status'),
					'driving_license' => $this->input->post('driving_license'),
					'hobbies' => $this->input->post('hobbies'),				
					'account_holder_name' => $this->input->post('account_holder_name'),
					'hra' => $this->input->post('hra'),
					'mobile_allowance' => $this->input->post('mobile_allowance'),
					'account_no' => $this->input->post('account_no'),
					'medical_allownce' => $this->input->post('medical_allownce'),
					'bank_name' => $this->input->post('bank_name'),
					'fooding_allowance' => $this->input->post('fooding_allowance'),
					'transbortation_allowance' => $this->input->post('transbortation_allowance'),
					'accomodation' => $this->input->post('accomodation'),
					'branch' => $this->input->post('branch'),	
					'total_salary' => $this->input->post('total_salary'),						
					'image' => $new_name,
					'employee_type' => $this->input->post('employee_type'),
					//'emp_store_name' => $this->input->post('emp_store_name'),
					'pf_ac' => $this->input->post('pf_ac'),	
					'esic_ac' => $this->input->post('esic_ac')
					);
                 $add=$this->Payroll_model->save_data($data);
				if($add)
				{
					 $this->session->set_flashdata('success',"Employee added successfully!");
	 			}	   

			}
		else
		{
			 $this->session->set_flashdata('danger',"Employee ID is Present");
		}
        redirect(base_url().'admin/Payroll/employee_view');           
                   

	}
	
	
	
	public function edit_employee_page()
	{		
		 $id=$this->uri->segment(4);
	     $con=array('id'=>$id);	
		if($_POST)
		{           
        $data['first_name']=$this->input->post('first_name');
        $data['last_name']=$this->input->post('last_name');
		$data['employee_id']=$this->input->post('employee_id');
		$data['mobile']=$this->input->post('mobile');
		$data['date_of_birth']=$this->input->post('date_of_birth');
		$data['gender']=$this->input->post('gender');
		//$data['email']=$this->input->post('email');
		//$data['password']=$this->input->post('password');
		$data['department']=$this->input->post('department');		
		$data['designation']=$this->input->post('designation');		
        $data['reporting_to']=$this->input->post('reporting_to');	
        $data['date_of_hire']=$this->input->post('date_of_hire');
        $data['source_of_hire']=$this->input->post('source_of_hire');
        $data['emp_status']=$this->input->post('emp_status');
		$data['work_phone_no']=$this->input->post('work_phone_no');
		$data['emp_type']=$this->input->post('emp_type');
		$data['address1']=$this->input->post('address1');
		$data['address2']=$this->input->post('address2');
		$data['country']=$this->input->post('country');
		$data['state']=$this->input->post('state');
		$data['city']=$this->input->post('city');
		$data['postal_code']=$this->input->post('postal_code');
		$data['other_mobile']=$this->input->post('other_mobile');
		$data['other_email']=$this->input->post('other_email');		
		$data['nationality']=$this->input->post('nationality');
		$data['marital_status']=$this->input->post('marital_status');
		$data['driving_license']=$this->input->post('driving_license');
		$data['hobbies']=$this->input->post('hobbies');
		$data['basic_salary']=$this->input->post('basic_salary');
		$data['pf_emp']=$this->input->post('pf_emp');
		$data['pf_cmp']=$this->input->post('pf_cmp');
		$data['esic_emp']=$this->input->post('esic_emp');
		$data['esic_cmp']=$this->input->post('esic_cmp');
		$data['cut_from']=$this->input->post('cut_from');
		$data['account_holder_name']=$this->input->post('account_holder_name');
		$data['hra']=$this->input->post('hra');
		$data['account_no']=$this->input->post('account_no');
		$data['medical_allownce']=$this->input->post('medical_allownce');
		$data['bank_name']=$this->input->post('bank_name');
		$data['fooding_allowance']=$this->input->post('fooding_allowance');
		$data['transbortation_allowance']=$this->input->post('transbortation_allowance');
		$data['accomodation']=$this->input->post('accomodation');
		$data['branch']=$this->input->post('branch');
		$data['total_salary']=$this->input->post('total_salary');
		$data['employee_type']=$this->input->post('employee_type');
		$data['emp_store_name']=$this->input->post('emp_store_name');
		$data['pf_ac']=$this->input->post('pf_ac');
		$data['esic_ac']=$this->input->post('esic_ac');
         if (!empty($_FILES['image']['name'])) {
          if($_FILES["image"]["name"]==""){
                //print_r("hello blanck");exit;
                 $this->data['status']  ="false";
                 $this->data['message'] ="Please Enter Your File Name";
                 }else{
            //Check whether user upload picture
            if(!empty($_FILES['image']['name'])){
                $config['upload_path'] = './upload/employee';
				$config['allowed_types'] = 'jpg|jpeg|gif|png|PNG';
				$config['max_size']    = '100000';
                $config['remove_spaces'] = FALSE;
                $config['file_name'] =$_FILES['image']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('image')){
                    $uploadData = $this->upload->data();
                        //$filename = './assets/uploads/gallery/';
                    $image =$uploadData['file_name'];

                }else{
                    $image = '';
                }
            }else{
                $image = '';
            } } 
        }
        if(!empty($image)){
            $data['image']=$image;
        }
	
		 	 $update=$this->Payroll_model->update_data('table_employee',$con,$data);

				if($update)
	 			{
	 				$this->session->set_flashdata('msg',"<div style='color:green;'>Employee Added</div>");
					$this->session->set_flashdata('class','green_msg');
					redirect(base_url().'admin/Payroll/employee_view');
	 			}
				
            }
            
          redirect(base_url().'admin/Payroll/employee_view');
    }

     	function fetch_designation()
		 {
		  if($this->input->post('dept_id')=='')
			  {
			   $output = '<option value="" disabled selected>Select Designation</option>';
			  }
		   else
			  {
			  	$q=$this->Payroll_model->fetch_designation_name($this->input->post('dept_id'));
			  	if($q->num_rows()>0)
		  	  	{
				  	$output = '<option value="" disabled selected>Select Designation</option><option value="all">All</option>';
				  	foreach($q->result() as $row)
					  {
					   $output .= '<option value="'.$row->id.'">'.$row->designation.'</option>';
					  }		  	  		
		  	  	}
		  	  	else{
				  	$output = '<option value="" disabled selected>No Designation</option>';
		  	  	}
			   }
		  echo  $output;
		 }

		 	function fetch_depart_employee()
			 {
			  if($this->input->post('dept_id')=='')
				  {
				   $output = '<option value="" disabled selected>Select Employee</option>';
				  }
			   else
				  {
				  	$q=$this->Payroll_model->fetch_empname_by_depart($this->input->post('dept_id'));
				  	
				  	if($q->num_rows()>0)
			  	  	{
					  	$output = '<option value="" disabled selected>Select Employee</option><option value="all">All</option><optgroup label="">';
					  	foreach($q->result_array() as $row)
						  {
						  	$departName=$this->Payroll_model->get_departname_data($row['department']);
						  	$desigName=$this->Payroll_model->get_design_data($row['designation']);
						   $output .= '<option value="'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'-'.$departName['department_name'].'-'.$desigName['designation'].'</option>';
						  }		  	  		
			  	  	}
			  	  	else{
					  	$output = '<option value="" disabled selected>No Designation</option></optgroup>';
			  	  	}
				   }
			  echo  $output;
			 }


			 function fetch_depart_report_employee()
			 {
			 	$output='';
			 	if($this->input->post('emp_id')==''){
				 	if($this->input->post('dept_id')=='') {
					   $output = '<option value="" disabled selected>Select Employee</option>';
					  }else{
					  	$q=$this->Payroll_model->fetch_empname_by_depart($this->input->post('dept_id'));
					  	if($q->num_rows()>0)
				  	  	{
						  	$output = '<option value="" disabled selected>Select Employee</option><optgroup label="Employee Name-Department-Designation">';
						  	foreach($q->result_array() as $row)
							  {
							  	$departName=$this->Payroll_model->get_departname_data($row['department']);
							  	$desigName=$this->Payroll_model->get_design_data($row['designation']);
							   $output .= '<option value="'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].' - '.$departName['department_name'].' - '.$desigName['designation'].'</option>';
							  }		  	  		
				  	  	}else{
						  	$output = '<option value="" disabled selected>No Designation</option></optgroup>';
				  	  	}
					 }
			 	}else{
				 	if($this->input->post('dept_id')=='' or $this->input->post('emp_id')=='') {
					   $output = '<option value="" disabled selected>Select Employee</option>';
					  }else{
					  	$q=$this->Payroll_model->fetch_empname_by_depart($this->input->post('dept_id'));
					  	if($q->num_rows()>0)
				  	  	{
						  	$output = '<option value="" disabled selected>Select Employee</option><optgroup label="Employee Name-Department-Designation">';
						  	foreach($q->result_array() as $row)
							  {
							  	$empData=$this->Payroll_model->get_employee_data_by_id($this->input->post('emp_id'));
							  	$departName=$this->Payroll_model->get_departname_data($row['department']);
							  	$desigName=$this->Payroll_model->get_design_data($row['designation']);
							   $output .= '<option value="'.$row['id'].'" '.($row['id']==$empData['reporting_to']?'selected':'').'>'.$row['first_name'].' '.$row['last_name'].' - '.$departName['department_name'].' - '.$desigName['designation'].'</option>';
							  }		  	  		
				  	  	}else{
						  	$output = '<option value="" disabled selected>No Designation</option></optgroup>';
				  	  	}
					 }
			 	}
			 	
			  echo  $output;
			 }

		 function fetch_employee_name()
		 {
		  if($this->input->post('design_id')=='')
		  {
		  	$output ='<option value="" disabled selected>Select Employee</option>';
		  }
		  else{
		  	 $q=$this->Payroll_model->fetch_employee_name($this->input->post('design_id'));
		  	  if($q->num_rows()>0)
		  	  {
		  	  	  $output = '<option value="" disabled selected>Select Employee</option><option value="all">All</option>';
		 		 foreach($q->result() as $row)
				  {
			  		 $output .= '<option value="'.$row->id.'">'.$row->first_name.' '.$row->last_name.'</option>';
			 	 }
			 	}else{
			 		$output = '<option value="" disabled selected>No Employee</option>';
			 	}
		 
		  }	
		  echo  $output;
		 }


	
	function delete_employee($cid)
	{
		$data=array();
		$this->Payroll_model->delete_data($cid);
		$this->session->set_userdata('msg',"<div style='color:green;'>Employee deleted successfully</div>");
		$this->session->set_userdata('class','green_msg');
		redirect(base_url().'admin/Payroll/employee_view');
	}
	 function employee_id_exist(){
	 	if($this->Payroll_model->is_employee_id_exist($_POST['employee_id'])==false){
	 		echo"<i class='fa fa-check-square text-success' style='font-size:18px;'></i>";
	 	}
	 	else{
	 		echo"<i class='fa fa-close text-danger' style='font-size:18px'></i>";
	 	}
	 }

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'admin/main');
	}
		// payslip 
		public function pay_slips()	
		{	
			$this->data['page'] = 'payroll'; 
			$this->data['sub_page']='pay_slips';
			$this->data['employee']=$this->Payroll_model->get_employee_data();
			$this->data['department']=$this->Payroll_model->get_data_array('tbl_department');
			$this->data['designation']=$this->Payroll_model->get_data_array('tbl_designation');
			$this->data['store']=$this->Store->getAllStores();
			$this->load->view('admin/include/header',$this->data);
			$this->load->view('admin/include/sidebar',$this->data);		
			$this->load->view('admin/payroll/pay_slips',$this->data);
			//$this->load->view('admin/include/footer',$this->data); 
			
		}

      public function show_payslip()
            {   
               $output='';
                 $data=$this->attendance->get_leave_report_data($_POST['employee_id'],$_POST['year'],$_POST['month']);
                 $output .= '<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                  <thead>
                  <tr>
                  <th class="text-nowrap">S No</th>
                  <th class="text-nowrap">Date</th>
                  <th class="text-nowrap">Employee Name</th>
                  <th class="text-nowrap">Comment</th>
                  </tr>
                  </thead>
                  <tbody>';
                  $cnt = 1;
                        foreach($data as $row)
                         {
                          $employee = $this->employee_model->get_employee_by_id($row['emp_id']);
                          $output .= '
                        <tr>
                        <td>'.$cnt++.'</td>
                        <td>'.$row['attendance_date'].'</td>
                        <td>'.$employee['first_name'].' '.$employee['first_name'].'</td>
                        <td><p>'.$row['comment'].'</p></td>
                        </tr>';
                         }
                  $output .= '</tbody></table>';
                        echo $output;
        }

        public function show_payslip_view()
            {   
            	$date=$_POST['year']."-".$_POST['month']."-01";
				$startDate=date("Y-m-01", strtotime($date));
				$endDate=date("Y-m-t", strtotime($date));
               	$output='';
              
                 $emp_data=$this->Payroll_model->get_employee_by_id($_POST['store_id'],$_POST['employee_id'],$_POST['department_id'],$_POST['designation_id']); 
                 $workdays=$this->Payroll_model->get_working_days($startDate,$endDate); //count working days
                  $calender_data=$this->Payroll_model->get_calender_data($_POST['month'],$_POST['year']);
                 $output .= '
							<table id="data-table-buttons" class="table table-striped table-bordered  table-td-valign-middle">
								<thead>
									<tr>
										<th class="text-nowrap">S No</th>
										<th class="text-nowrap">Employee <br>Name</th>
										<th class="text-nowrap">Employee <br>ID</th>
										<th class="text-nowrap">Department</th>
										<th class="text-nowrap">Designation</th>
										<th class="text-nowrap">Total <br>Working <br>Days</th>
										<th class="text-nowrap">Total <br>Paid <br>Leaves</th>
										<th class="text-nowrap">Total <br>Present</th>
										<th class="text-nowrap">Total <br>Absent</th>
										<th class="text-nowrap">Total <br>Leave</th>
										<th class="text-nowrap">Basic <br>Salary</th>
										<th class="text-nowrap" title="House Rent Allowance">HRA</th>
										<th class="text-nowrap" title="Fooding Allowance">FA</th>
										<th class="text-nowrap" title="Transpotation Allowance">TA</th>
										<th class="text-nowrap" title="Medical Allowance">MA</th>
										<th class="text-nowrap" title="Mobile Allowance">MA</th>
										<th class="text-nowrap" title="Accomodation">Accomodation</th>
										<th class="text-nowrap" title="PF A/C">PF A/C</th>
										<th class="text-nowrap" title="ESIC A/C">ESIC A/C</th>
										<th class="text-nowrap" title="PF Emp Contribution">PF <br>Emp <br>Contribution</th>
										<th class="text-nowrap" title="PF Cmp Contribution">PF <br>Cmp <br>Contribution</th>
										<th class="text-nowrap" title="ESIC Emp Contribution">ESIC <br>Emp<br> Contribution</th>
										<th class="text-nowrap" title="ESIC Cmp Contribution">ESIC <br>Cmp<br> Contribution</th>
										<th class="text-nowrap" title="PF & ESIC Cut From">Cut <br>From</th>
										<th class="text-nowrap" title="Gross Salary">Gross <br>Salary</th>
										<th class="text-nowrap" title="Net Salary">Net <br>Salary</th>
										<th class="text-nowrap" >Action</th>
									</tr>
								</thead>
								<tbody>';
                  $cnt = 1;
                  $sum_pf_cmp=$sum_esic_cmp=$sum_gross_salary=0;
                        foreach($emp_data as $row)
                         {
                       		$presentdays=$this->Payroll_model->get_present_days($row['id'],$startDate,$endDate); //count present days 
                       		$absentdays=$this->Payroll_model->get_absent_days($row['id'],$startDate,$endDate); //count absent days 
                       		$leavedays=$this->Payroll_model->get_leave_days($row['id'],$startDate,$endDate); 
                       		$department=$this->Payroll_model->get_departname_data($row['department']); 
                       		$designation=$this->Payroll_model->get_design_data($row['designation']);
	                         $cut_from = $row['cut_from']; 
	                         $pf_emp = (intval($row[$cut_from])*intval($row['pf_emp'])*(0.01));
	                         $pf_cmp = (intval($row[$cut_from])*intval($row['pf_cmp'])*(0.01));
	                         $esic_emp = (intval($row[$cut_from])*intval($row['esic_emp'])*(0.01));
	                         $esic_cmp = (intval($row[$cut_from])*intval($row['esic_cmp'])*(0.01));
	                         $net_salary=intval($row['total_salary'])-($pf_emp+$esic_emp);
	                          $pf_esic_cut_from=($row['cut_from']=='basic_salary')?'Basic Salary':'Gross Salary';
	                          $sum_pf_cmp=$sum_pf_cmp+$pf_cmp;
	                          $sum_esic_cmp=$sum_esic_cmp+$esic_cmp;
	                          $sum_gross_salary=$sum_gross_salary+intval($row['total_salary']);
	                         $output .= '<tr>
											<td>'.$cnt++.'</td>
											<td>'.$row['first_name'].' '.$row['last_name'].'</td>
											<td>'.$row['employee_id'].'</td>
											<td>'.$department['department_name'].'</td>
											<td>'.$designation['designation'].'</td>
											<td>'.$calender_data['total_work_days'].'</td>
											<td>'.$calender_data['paid_leavs'].'</td>
											<td>'.$presentdays['present_day'].'</td>
											<td>'.$absentdays['absent_day'].'</td>
											<td>'.$leavedays['leave_day'].'</td>
											<td>₹&nbsp;'.$row['basic_salary'].'</td>
											<td>₹&nbsp;'.$row['hra'].'</td>
											<td>₹&nbsp;'.$row['fooding_allowance'].'</td>
											<td>₹&nbsp;'.$row['transbortation_allowance'].'</td>
											<td>₹&nbsp;'.$row['medical_allownce'].'</td>
											<td>₹&nbsp;'.$row['mobile_allowance'].'</td>
											<td>₹&nbsp;'.$row['accomodation'].'</td>
											<td>'.$row['pf_ac'].'</td>
											<td>'.$row['esic_ac'].'</td>
											<td>₹&nbsp;'.$pf_emp.'</td>
											<td>₹&nbsp;'.$pf_cmp.'</td>
											<td>₹&nbsp;'.$esic_emp.'</td>
											<td>₹&nbsp;'.$esic_cmp.'</td>
											<td>'.$pf_esic_cut_from.'</td>
											<td>₹&nbsp;'.intval($row['total_salary']).'</td>
											<td>₹&nbsp;'.$net_salary.'</td>
											<td><a href="'.base_url().'admin/payroll/single_payslip?eid='.$row['id'].'&month='.$_POST['month'].'&year='.$_POST['year'].'" class="btn btn-sm btn-warning" target="_blank">Show</a></td>
	                        			</tr>';
                         }
                  $output .= '	</tbody>
								<tfoot>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th>Total :- </th>
									<th>₹&nbsp;'.$sum_pf_cmp.'</th>
									<th></th>
									<th>₹&nbsp;'.$sum_esic_cmp.'</th>
									<th></th>
									<th>₹&nbsp;'.$sum_gross_salary.'</th>
									<th></th>
								</tr>
								</tfoot>
								</table>
                  ';
                  echo $output;
        }
	
        // get academic calender input table
        
	
			
			public function single_payslip()
			{

				$eid=$_GET['eid'];
				$date=$_GET['year']."-".$_GET['month']."-01";
				$startDate=date("Y-m-01", strtotime($date));
				$endDate=date("Y-m-t", strtotime($date));
				$this->data['employee']=$this->Payroll_model->get_employee_by_id($_GET['eid'],'all','all');
				$this->load->view('admin/payroll/single_payslip',$this->data);

			}

	public function fetchAllEmployeeData()
	{
			$employee=$this->Payroll_model->getEmployeeDataByStoreName($_POST['store_id'],$_POST['status']);
			// print_r($employee);exit();

		?>
			<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
			<thead>
			<tr>
			<th class="text-nowrap">S NO</th>
			 <th class="text-nowrap">Full Name</th>
			<th class="text-nowrap">Employee ID</th>
			<th class="text-nowrap">Department</th>
			<th class="text-nowrap">Designation</th>
			<th class="text-nowrap">Date Of Hire</th>
			<th class="text-nowrap">City</th>
			<th class="text-nowrap">Status</th>
			<th class="text-nowrap">Image</th>
			<th class="text-nowrap">Action</th>
			</tr>
			</thead>
			<tbody>	
		<?php
    $sno = 1;
    if(!empty($employee))
    {
	    foreach($employee as $row)
	    {
	          $department = $this->dm->get_department_by_id($row['department']);
	          $designation = $this->designation->get_designation_by_id($row['designation']);
    ?>  

        <tr>
                      <td><?php echo $sno++; ?></td>
                      <td><?php echo $row['first_name'] .' '. $row['last_name']; ?></td>
                      <td><?php echo $row['employee_id']; ?></td>
                      <td><?php echo $department['department_name']; ?></td>
                      <td><?php echo $designation['designation']; ?></td>
                      <td><?php echo $row['date_of_hire']; ?></td>
                      <td><?php echo $row['city']; ?></td>
                      <td><?php echo $row['emp_status']; ?></td>
                     <td><img src="<?php echo base_url(); ?>upload/employee/<?php echo $row['image']; ?>" height="50px" width="50px"/></td>
                      <td>
                      <a rel="tooltip" title="Edit" class="btn btn-link btn-sm btn-warning table-action edit" href="edit_employee/<?php echo $row['id'];?>">
                      <i class="fa fa-edit"></i>
                      </a>
                      <a rel="tooltip" title="Remove" class="btn btn-link btn-sm btn-danger table-action remove" onClick="return confirm('Are you sure you want to delete?')" href="delete_employee/<?php echo $row['id'];?>">
                                             <i class="fa fa-trash"></i>            
                       </a>
                      </td>
                  
                      </tr>

                      <?php
                        } 
                    }
                    else
                    {
                    ?>
                    <tr><td colspan="10"><center><strong>NO RECORD FOUND</strong></center></td></tr>
                    <?php
                    }
                    ?>

          </tbody>
          </table>
	<?php }

}
?>