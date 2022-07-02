<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(0);
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
        $this->data['view_path'] = $_SERVER['DOCUMENT_ROOT'] .'/irems/payroll/application/views/';

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
             
              $designation = $this->Payroll_model->get_data_array('tbl_manage_designation');

                foreach ($designation as $desi) {  
                             
                $manage_designation_info= json_decode($desi["manage_designation_info"]);
                $deprtment_id = $manage_designation_info->departmentName;
                  if($deprtment_id == $this->input->post('dept_id')){
                 				
                    $output .= '<option value="'.$desi['manage_designation_id'].'">'.$manage_designation_info->designationName.'</option>';
  
                  }
                  
                   	//else{
				  //	$output = '<option value="" disabled selected>No Designation</option>';
		  	  	//}
             

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
            
              $employee = $this->Payroll_model->get_data_array('tbl_manage_employee');

                foreach ($employee as $emp) {  
                             
                $manage_employee_info = json_decode($emp["manage_employee_info"]);
                $designation_id = $manage_employee_info->designation;
                  if($designation_id == $this->input->post('design_id')){
                 				
                    $output .= '<option value="'.$emp['manage_employee_id'].'">'.$manage_employee_info->firstName.'</option>';
  
                  }
                  
                }
            
		  	 //$q=$this->Payroll_model->fetch_employee_name($this->input->post('design_id'));
		  	  //if($q->num_rows()>0)
		  	  //{
		  	  	 // $output = '<option value="" disabled selected>Select Employee</option><option value="all">All</option>';
		 		// foreach($q->result() as $row)
				 // {
			  		 //$output .= '<option value="'.$row->id.'">'.$row->first_name.' '.$row->last_name.'</option>';
			 	// }
			 	//}else{
			 		//$output = '<option value="" disabled selected>No Employee</option>';
			 	//}
		 
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
			$this->data['department']=$this->Payroll_model->get_data_array('tbl_manage_department');
			$this->data['designation']=$this->Payroll_model->get_data_array('tbl_manage_designation');
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
				$startDate=date("Y-m-01 ", strtotime($date));
				$endDate=date("Y-m-t", strtotime($date));
               	$output='';
          
                 $department = $this->Payroll_model->get_data_array('tbl_manage_department');
                 $emp_data = $this->Payroll_model->get_data_array('tbl_manage_employee');

                 $workdays=$this->Payroll_model->get_working_days($startDate,$endDate); //count working days
                 $calender_data=$this->Payroll_model->get_calender_data($_POST['month'],$_POST['year']);
                 $output .= '
							<table id="data-table-buttons" class="table table-striped table-bordered  table-td-valign-middle">
								<thead>
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
                                         <th colspan="10" style="
    text-align: center;
">Income</th>
                                         
                                         
                                         
                                         
                                         
<th colspan="6" style="
    text-align: center;
">Deductions</th>
                                         <th></th>
                                         <th></th>
                                         
                                         
                                         
                                         
                                         
                                         
                                         <th></th>
                                         </tr>
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
                                       
										<th class="text-nowrap" title="Total Salary">Total Salary</th>
										<th class="text-nowrap">Basic <br>Salary</th>
										<th class="text-nowrap" title="House Rent Allowance">HRA</th>
										<th class="text-nowrap" title="Transportation Allowance">TA</th>
										<th class="text-nowrap" title="Children Education Allowance">CEA</th>
										<th class="text-nowrap" title="Special Allowance">SA</th>
                                        <th class="text-nowrap" title="Incentive">Incentive</th>
                                        <th class="text-nowrap" title="Conveyance">Conveyance</th>
                                        <th class="text-nowrap" title="Overtime">Overtime</th>


                                        <th class="text-nowrap">Payable <br>Salary</th>
                                        <th class="text-nowrap" title="Employee Provident Fund">EPF</th>
										<th class="text-nowrap" title="Employee State Insurance">ESI</th>
                                         <th class="text-nowrap" title="Disincentive">Disincentive</th>
										<th class="text-nowrap" title="Loan">Loan</th>
										<th class="text-nowrap" title="Loan EMI">Loan EMI</th>
                                        <th class="text-nowrap" title="Total Deduction">Total Deduction</th>
                                        
                                        
										<th class="text-nowrap" title="PF A/C">Gross Salary</th>
										<th class="text-nowrap" title="Net Salary">Net <br>Payable</th>
										<th class="text-nowrap" >Action</th>
									</tr>
								</thead>
								<tbody>';
                  $cnt = 1;
                  $sum_pf_cmp=$sum_esic_cmp=$sum_gross_salary=0;
                        foreach($emp_data as $row)
                         {
                          
                  		    $manage_employee_info= json_decode($row["manage_employee_info"]);
                            $emp_id = $row['manage_employee_id'];
                           
                            
                       		$presentdays=$this->Payroll_model->get_present_days($this->input->post('employee_id'),$startDate,$endDate); //count present days 
                       		$absentdays=$this->Payroll_model->get_absent_days($this->input->post('employee_id'),$startDate,$endDate); //count absent days 
                               
                            $leavedays=$this->Payroll_model->get_leave_days($this->input->post('employee_id'),$startDate,$endDate); //count total leave
                            
                       		$over=$this->Payroll_model->get_overtime($this->input->post('employee_id'),$startDate,$endDate); //count total overtime
                          
                             $incentive=$this->Payroll_model->get_incentive($this->input->post('employee_id'),$startDate,$endDate); //count total Incentive
                             $disincentive=$this->Payroll_model->get_disincentive($this->input->post('employee_id'),$startDate,$endDate); //count total disIncentive

                             $loan = $this->Payroll_model->get_loan($this->input->post('employee_id'),$startDate,$endDate); //count total Loan
                          
                             $conveyance=$this->Payroll_model->get_conveyance($this->input->post('employee_id'),$startDate,$endDate);//count total conveyance
                          
                          
                             // echo "<pre>";
                           // print_r($loan);
                          
                        
                          if($emp_id == $this->input->post('employee_id')){
                          
                            
                          		$pr_days = $presentdays['present_day'];
                                $sal = $manage_employee_info->finalSalary;
                                $sal_per_day = $sal / 30;
                                $month_sal = ($pr_days * $sal_per_day);
                                
                                $desig_id = $manage_employee_info->designation;
                            	$dd11 = $this->designation->get_designation_by_id($desig_id);
                            	$desig= json_decode($dd11["manage_designation_info"]);
                            	$ds = $desig->designationName;
                            
                              
                                $dept_id = $manage_employee_info->department;
                            	$dept = $this->dm->get_department_by_id($dept_id);
                            	$dept_info= json_decode($dept["manage_department_info"]);
                            	$dp = $dept_info->departmentName;
                            	
                                $bs = number_format((float)$manage_employee_info->basicSalary, 2, '.', '');
                                //$bs = round($manage_employee_info->basicSalary, 2);
                                $ns = number_format((float)$manage_employee_info->netSalary, 2, '.', '');
                                $daily = $ns/30;
                                $payable = number_format((float)$daily * $presentdays['present_day'], 2, '.', '');
                                
                               	$hra = $manage_employee_info->hra;
                               //echo  $payable;
                              //if salary greater than 20,000
                                if($payable >= 0 && $payable <= 20000){
                                 $basic = number_format((float)($payable * 40/100), 2, '.', '');
                                 $hra_per_day = number_format((float)($payable * 20/100),2, '.', '');
                                
                                $ta = $manage_employee_info->ta;
                                $ta_per_day = number_format((float)($payable * 15/100),2, '.', '');
                                
                                $cea = $manage_employee_info->cea;
                                $cea_per_day = number_format((float)($payable * 15/100),2, '.', '');
                                
                                $sa = $manage_employee_info->sa;
                                $sa_per_day = number_format((float)($payable * 10/100),2, '.', '');
                                  
                                }
                            
                                 //if salary between 20,001 & 30,000
                                if($payable >= 20001 && $payable <= 30000){ 
                                 $basic = number_format((float)($payable * 35/100), 2, '.', '');
                                $hra_per_day = number_format((float)($payable * 18/100),2, '.', '');
                                
                                $ta = $manage_employee_info->ta;
                                $ta_per_day = number_format((float)($payable * 18/100),2, '.', '');
                                
                                $cea = $manage_employee_info->cea;
                                $cea_per_day = number_format((float)($payable * 18/100),2, '.', '');
                                
                                $sa = $manage_employee_info->sa;
                                $sa_per_day = number_format((float)($payable * 11/100),2, '.', '');
                                  
                                }
                            
                            
                               //if salary between 30,001 & 40,000
                                if($payable >= 30001 && $payable <= 40000){ 
                                  
                                $basic = number_format((float)($payable * 30/100), 2, '.', '');
 
                                $hra_per_day = number_format((float)($payable * 15/100),2, '.', '');
                                
                                $ta = $manage_employee_info->ta;
                                $ta_per_day = number_format((float)($payable * 22/100),2, '.', '');
                                
                                $cea = $manage_employee_info->cea;
                                $cea_per_day = number_format((float)($payable * 22/100),2, '.', '');
                                
                                $sa = $manage_employee_info->sa;
                                $sa_per_day = number_format((float)($payable * 11/100),2, '.', '');
                                  
                                }
                            
                               //if salary between 40,001 & 50,000
                                if($payable >= 40001 && $payable <= 50000){ 
                                  
                                $basic = number_format((float)($payable * 25/100), 2, '.', '');
 
                                $hra_per_day = number_format((float)($payable * 13/100),2, '.', '');
                                
                                $ta = $manage_employee_info->ta;
                                $ta_per_day = number_format((float)($payable * 25/100),2, '.', '');
                                
                                $cea = $manage_employee_info->cea;
                                $cea_per_day = number_format((float)($payable * 25/100),2, '.', '');
                                
                                $sa = $manage_employee_info->sa;
                                $sa_per_day = number_format((float)($payable * 12/100),2, '.', '');
                                  
                                }
                            
                                
                               // $epf = $manage_employee_info->epf;
                                $epf_per_day = number_format((float)($basic * 12/100),2, '.', '');  
                                  
                             
                                
                                //$totalSalary = number_format((float)($basic + $hra_per_day + $ta_per_day + $cea_per_day + $sa_per_day),2, '.', '');

                                $monthSalry = round($month_sal, 2);
                            
                                //$esi = $manage_employee_info->esi;
                                //$loan = $manage_employee_info->loan;
                                    $extra_income = number_format((float)($over['overtime'] + $incentive['incentive'] + $conveyance['conveyance']),2, '.', '');  //calculate total extra income

                                  $grossSalary =  number_format((float)($payable + $extra_income),2, '.', ''); //cal total gross salary

                               
                                $totalesi = number_format((float)(($grossSalary - $disincentive['disincentive']) *  0.0075),2, '.', '');  //calculate total esi
                              
                                $totaldeduction = number_format((float)($epf_per_day + $loan['loan_emi'] + $disincentive['disincentive']),2, '.', '');  //calculate total deduction
                                 
                            
                                $net = number_format((float)($payable - $totaldeduction),2, '.', ''); //cal net salary


                               //$overtime = $manage_employee_info->overtime * $over;
                                
	                         $output .= '<tr>
											<td>'.$cnt++.'</td>
                                            <td>'.$manage_employee_info->firstName.' '.$manage_employee_info->lastName.'</td>
											<td>'.$manage_employee_info->employeeId.'</td>
											<td>'.$dp.'</td>
											<td>'.$ds.'</td>
											<td>'.$calender_data['total_work_days'].'</td>
											<td>'.$calender_data['paid_leavs'].'</td>
											<td>'.$presentdays['present_day'].'</td>
											<td>'.$absentdays['absent_day'].'</td>
											<td>'.$leavedays['leave_day'].'</td>
                                            
                                         <td>₹&nbsp;'.$manage_employee_info->totalSalary.'</td>


											<td>₹&nbsp;'.$basic.'</td>
											<td>₹&nbsp;'.$hra_per_day.'</td>
											<td>₹&nbsp;'.$ta_per_day.'</td>
											<td>₹&nbsp;'.$cea_per_day.'</td>
											<td>₹&nbsp;'.$sa_per_day.'</td>
                                			<td>₹&nbsp;'.$incentive['incentive'].'</td>
                                           <td>₹&nbsp;'.$conveyance['conveyance'].'</td>
											<td>₹&nbsp;'.$over['overtime'].'</td>
                                             <td>'.$payable.'</td>
											<td>₹&nbsp;'.$epf_per_day.'</td>
											<td>₹&nbsp;'.$totalesi.'</td>
                                            <td>₹&nbsp;'.$disincentive['disincentive'].'</td>
                                             <td>₹&nbsp;'.$loan['loan_amount'].'</td>

                                             <td>₹&nbsp;'.$loan['loan_emi'].'</td>
                                             <td>₹&nbsp;'.$totaldeduction.'</td>
											<td>₹&nbsp;'.$grossSalary.'</td>
									        <td>₹&nbsp;'.$net.'</td>


											<td><a href="'.base_url().'admin/payroll/single_payslip?eid='.$row['manage_employee_id'].'&month='.$_POST['month'].'&year='.$_POST['year'].'&did='.$manage_employee_info->designation.'&twd='.$calender_data['total_work_days'].'&tpd='.$presentdays['present_day'].'&loan='.$loan['loan_amount'].'&esi='.$totalesi.'&epf='.$epf_per_day.'&disincentive='.$disincentive['disincentive'].'&netSalary='.$net.'" class="btn btn-sm btn-warning" target="_blank">Show</a></td>
	                        			</tr>';
                          }
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
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
									<th>Total :- </th>
									<th>₹&nbsp;'.$net.'</th>
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
			   $did=$_GET['did'];
               	$date=$_GET['year']."-".$_GET['month']."-01";
				$startDate=date("Y-m-01", strtotime($date));
				$endDate=date("Y-m-t", strtotime($date));
                
				$this->data['employee']=$this->Payroll_model->get_employee_by_id($eid,'all','all');
                $this->data['desig']=$this->designation->get_designation_by_id($did);
                //var_dump($this->data['desig']);exit();
                //$this->data['employee']=$this->Payroll_model->get_employee_data();
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



	