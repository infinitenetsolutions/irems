<link href="<?=base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet"/>
        <div id="content" class="content">

            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:;">Employee Register</a></li>
            </ol>

            <h1 class="page-header">Employee Register</h1>
            <?php if($this->session->flashdata('success')): ?>
   <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p> 
<?php endif; ?>
<?php if($this->session->flashdata('danger')): ?>
   <p class="alert alert-danger"><?php echo $this->session->flashdata('danger'); ?></p> 
<?php endif; ?>

            <form id="TypeValidation" class="form-horizontal" action="<?php echo base_url(); ?>Payroll/add_employee" method="post" enctype="multipart/form-data">
                <div class="card card-navy card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employeeCategory"><strong>Employee Type:</strong></label>
                                    <select class="form-control" name="employee_type" id="employeeCategory" style="" required="">
                                        <option value="" selected="" disabled="">Select Employee Type</option>
                                        <option value="Vendor Employee">Vendor Employee</option>
                                        <option value="On Payroll">On Payroll</option>
                                    </select>
                                </div>
                            </div>
                             <!--<div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><strong>Store Name:</strong></label>
                                    <select class="form-control" name="emp_store_name" id="emp_store_name" style="" required="">
                                        <option value="" selected="" disabled="">Select Store Name</option>
                                        <?php
                                            foreach ($store as $sRow) { 
                                             echo "<option value=".$sRow['str_id'].">".$sRow['str_name']."</option>";   
                                            }  ?>
                                    </select>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>

                <div class="panel panel-inverse" data-sortable-id="form-plugins-4">
                    <div class="panel-heading">
                        <h4 class="panel-title">Personal Details </h4>
                    </div>
                    <div class="panel-body panel-form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>First Name: </strong></label>
                                        <input class="form-control" type="text" name="first_name" id="first_name" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Last Name:</strong></label>
                                        <input class="form-control" type="text" name="last_name" id="last_name" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Employee ID:<span id="empid_msg"></span></strong></label>
                                        <input class="form-control" type="text" name="employee_id" id="employee_id" required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Mobile:</strong></label>
                                        <input class="form-control" type="number" name="mobile" id="mobile" required="true" minlength="10" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Email ID: <span id="empemail_msg"></span></strong></label>
                                            <input class="form-control" type="email" name="other_email" id="other_email">
                                        </div>
                                    </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Date of Birth:</strong></label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Select Date" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="empGender"><strong>Gender:</strong></label>
                                        <select class="form-control" name="gender" id="gender" style="">
                                            <option value="" selected="" disabled="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Employee Account Password: </strong></label>
                                            <input class="form-control" type="password" name="password" id="password">
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">

                        <div class="panel-heading">
                            <h4 class="panel-title">Work Details</h4>

                        </div>

                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="department"><strong>Department:</strong></label>
                                            <select name="department" id='department' class="form-control" class="selectpicker" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">

                                                 <option value="" selected="" disabled="">Select Department</option>
                                                <?php

                                                if(!empty($department))
                                                {
                                                    foreach($department as $value)
                                                    {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['department_name']; ?></option>
                                                <?php
                                                        }
                                                    }
                                                    else{
                                                        ?>
                                                    <option value="">No Data</option>
                                                 <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label class="control-label"><strong>Designation:</strong></label>
                                            <select class="form-control" name="designation" id="designation">
                                            <option value="" selected="" disabled="">Select Designation</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Date of Joining:</strong></label>
                                            <input type="date" class="form-control" id="date_of_hire" name="date_of_hire" placeholder="Select Date" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Source of Hire:</strong></label>
                                            <input class="form-control" name="source_of_hire" id="source_of_hire" type="text" placeholder="Job Portals,Job Agencies,Walk in Interview">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="empReportTo" class="form-group">
                                            <label for=""><strong>Reporting To:</strong></label>
                                            <select class="default-select2 form-control" name="reporting_to" id="reporting_to"><option value="">Select Employee</option></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="empStatus"><strong>Employee Status:</strong></label>
                                            <select name="emp_status" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div id="empWorkPhone" class="form-group">
                                            <label for=""><strong>Work Phone:</strong></label>
                                            <input class="form-control" type="number" name="work_phone_no" id="work_phone_no" type="text"  minlength="0" maxlength="10">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="empType"><strong>Employee Type:</strong></label>
                                            <select name="emp_type" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">
                        <div class="panel-heading">
                            <h4 class="panel-title">Contact Details</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label class="control-label"><strong>Address 1:</strong></label>
                                            <input class="form-control" type="text" name="address1" id="address1" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label class="control-label"><strong>Address 2:</strong></label>
                                            <input class="form-control" type="text" name="address2" id="address2">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country"><strong>Country:</strong></label>
                                            <select name="country" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="India">India</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state"><strong>State:</strong></label>
                                            <select name="state" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Jharkhand">Jharkhand</option>
                                                <option value="Others">Others</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city"><strong>City:</strong></label>
                                            <select name="city" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Jamshedpur">Jamshedpur</option>
                                                <option value="Others">Others</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Postal Code:</strong></label>
                                            <input class="form-control" type="number" name="postal_code" id="postal_code" required="true" minlength="6" maxlength="6">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Alternate Mobile No:</strong></label>
                                            <input class="form-control" type="number" name="other_mobile" id="other_mobile" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Driving License:</strong></label>
                                            <input class="form-control" type="text" name="driving_license" id="driving_license">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nationality"><strong>Nationality:</strong></label>
                                            <select name="nationality" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Indian">Indian</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="marital_status"><strong>Marital Status:</strong></label>
                                            <select name="marital_status" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Married">Married</option>
                                                <option value="Single">Single</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Hobbies:</strong></label>
                                            <input class="form-control" name="hobbies" id="hobbies" type="text">

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">
                        <div class="panel-heading">
                            <h4 class="panel-title">Financial Details</h4>
                        </div>         

                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="basic_salary"><strong>Basic Salary:</strong></label>
                                            <input class="form-control" name="basic_salary" id="basic_salary" type="number"  onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fooding_allowance"><strong>Fooding Allowance:</strong></label>
                                            <input class="form-control" name="fooding_allowance" id="fooding_allowance" type="number" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="hra"><strong>House Rent Allowance:</strong></label>
                                            <input class="form-control" name="hra" id="hra" onkeyup="cal();" type="number" required="true" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="hra"><strong>Mobile Allowance:</strong></label>
                                            <input class="form-control" name="mobile_allowance" id="mobile_allowance" onkeyup="cal();" type="number" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="transbortation_allowance"><strong>Transpotation Allowance:</strong></label>
                                            <input class="form-control" name="transbortation_allowance" id="transbortation_allowance" type="number" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="medical_allownce"><strong>Medical Allowance:</strong></label>
                                            <input class="form-control" name="medical_allownce" id="medical_allownce" type="number" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="accomodation"><strong>Accomodation:</strong></label>
                                            <input class="form-control" name="accomodation" id="accomodation" type="number" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Deduct from:</strong></label>
                                            <select name="cut_from" id="cut_from" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue" onkeyup="cal_pf_amount();" >
                                                <option value="basic_salary">Basic Salary</option>
                                                <option value="total_salary">Gross Salary</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for=""><strong>Employee PF Contribution (in %):</strong></label>
                                        <div class="input-group mb-3">
                                          <input class="form-control" name="pf_emp" id="pf_emp" type="number" min="1" max="100" step=".001" required onkeyup="cal_pf_amount()">
                                           <input class="form-control ml-3" name="pf_emp_amt" id="pf_emp_amt"  readonly="">
                                        </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for=""><strong>Company PF Contribution (in %):</strong></label>
                                            <div class="input-group mb-3">
                                          <input class="form-control" name="pf_cmp" id="pf_cmp" type="number" step=".001"  onkeyup="cal_pf_amount()" required >
                                        <input class="form-control ml-3" name="pf_cmp_amt" id="pf_cmp_amt"  readonly="">
                                        </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for=""><strong>Employee ESIC Contribution (in %):</strong></label>
                                            <div class="input-group mb-3">
                                          <input class="form-control" name="esic_emp" id="esic_emp" type="number" step=".001" onkeyup="cal_pf_amount()"  required >
                                        <input class="form-control ml-3" name="esic_emp_amt" id="esic_emp_amt" readonly="">
                                        </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for=""><strong>Company ESIC Contribution (in %):</strong></label>
                                            <div class="input-group mb-3">
                                          <input class="form-control" name="esic_cmp" id="esic_cmp" type="number"  step=".001" onkeyup="cal_pf_amount()" required >
                                        <input class="form-control ml-3" name="esic_cmp_amt" id="esic_cmp_amt"  readonly="">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="empTotalSalary"><strong>Total Salary:</strong></label>
                                            <input class="form-control" name="total_salary" id="total_salary" type="text" readonly >
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="empTotalSalary"><strong>Net Salary:</strong></label>
                                            <input class="form-control" name="net_salary" id="net_salary"  type="text" readonly >
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">
                        <div class="panel-heading">
                            <h4 class="panel-title">Bank Account Details</h4>
                        </div>

                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="account_holder_name"><strong>Account Holder Name:</strong></label>
                                            <input class="form-control" name="account_holder_name" id="account_holder_name" type="text" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="bank_name"><strong>Bank Name:</strong></label>
                                            <input class="form-control" name="bank_name" id="bank_name" type="text" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="account_no"><strong>Account No:</strong></label>
                                            <input class="form-control" name="account_no" id="account_no" type="text" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="branch" class="form-group">
                                            <label for=""><strong>Bank Branch:</strong></label>
                                            <input class="form-control" name="branch" id="branch" type="text">
                                        </div>
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>PF Account:</strong></label>
                                            <input class="form-control" name="pf_ac" id="pf_ac" type="text" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>ESIC Account:</strong></label>
                                            <input class="form-control" name="esic_ac" id="esic_ac" type="text" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">
                        <div class="panel-heading">
                            <h4 class="panel-title">Image Upload</h4>
                        </div>
         
                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="image"><strong>Profile Image:</strong></label>
                                            <input class="form-control" name="image" id="image" type="file" required="true">
                                        </div>
                                    </div>
                                </div><br><br><br>



                                <button type="submit" id="submit" name="submit" class="btn btn-info" style="margin-left:5px;">Register</button>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="billing_form_error_section"></div><br />

        </div>
        </form>

    </div>

    </div>

    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

    </div>
 <?php include($view_path.'admin/include/footer.php')  ?>
<script src="<?=base_url();?>assets/plugins/select2/dist/js/select2.min.js" type="text/javascript"></script>
<script language=Javascript>
 $(".default-select2").select2();
function cal() {
      var basic_salary = document.getElementById('basic_salary').value;
      var fooding_allowance = document.getElementById('fooding_allowance').value;
      var hra = document.getElementById('hra').value;
      var mobile_allowance = document.getElementById('mobile_allowance').value;
      var transbortation_allowance = document.getElementById('transbortation_allowance').value;
      var medical_allownce = document.getElementById('medical_allownce').value;
      var accomodation = document.getElementById('accomodation').value;
    var result = parseInt(basic_salary) + parseInt(hra) + parseInt(medical_allownce) +  parseInt(fooding_allowance) +  parseInt(transbortation_allowance) +  parseInt(accomodation) +  parseInt(mobile_allowance);
      if (!isNaN(result)) {
         document.getElementById('total_salary').value = result;
      }
}
</script>
<script>
$(document).ready(function(){
    
 $('#department').change(function(){
  var dept_id = $('#department').val(); 
  if(dept_id != '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>Payroll/fetch_designation",
    method:"POST",
    data:{"dept_id":dept_id},
    success:function(data)
    {
       $('#designation').html(data);
    }
   });
  }
  else
  {
   $('#designation').html('<option value="">Select Designation</option>');
  }
 });


      $('#department').change(function(){
      var dept_id = $('#department').val(); 
      if(dept_id != '')
      {
       $.ajax({
        url:"<?php echo base_url(); ?>Payroll/fetch_depart_report_employee",
        method:"POST",
        data:{"dept_id":dept_id},
        success:function(data)
        {
            console.log(data);
           $('#reporting_to').html(data);
        }
       });
      }
      else
      {
       $('#reporting_to').html('<option value="">Select Employee</option>');
      }
     });

    $('#employee_id').keyup(function(event) { 
        // alert('You released a key'); 
        //$('#empid_msg').html('You released a key');
          employee_id=$('#employee_id').val();
          //alert(employee_id);
                    $.ajax({
                          url:"<?php echo base_url();?>Payroll/employee_id_exist/",
                          method:"POST",
                          data:{"employee_id":employee_id},
                          success:function(data)
                          {
                             $('#empid_msg').html(data);
                          }
                   })
    }); 

    $('#other_email').keyup(function(event) { 
        // alert('You released a key'); 
        //$('#empid_msg').html('You released a key');
          other_email=$('#other_email').val();
          //alert(other_email);
                    $.ajax({
                          url:"<?php echo base_url();?>Payroll/employee_email_exist/",
                          method:"POST",
                          data:{"other_email":other_email},
                          success:function(data)
                          {
                             $('#empemail_msg').html(data);
                          }
                   })
    }); 

   $('#cut_from').change(function(event) { 
        cal_pf_amount();
    });

// functio for calculate pf & esic

});
function cal_pf_amount()
{
   var cut_from=$('#cut_from').val();
   var basic_salary=$('#basic_salary').val();
   var total_salary=$('#total_salary').val();
   var pf_emp_basic=0;
var esic_emp_basic=0;
   if(cut_from=='basic_salary')
   {
                if($('#pf_emp').val()!='')
                {
                    pf_emp_basic=$('#basic_salary').val()*($('#pf_emp').val())*0.01;
                    $('#pf_emp_amt').val(pf_emp_basic);
                }
                if($('#pf_cmp').val()!='')
                {      pf_cmp_basic=$('#basic_salary').val()*($('#pf_cmp').val())*0.01;
                     $('#pf_cmp_amt').val(pf_cmp_basic);        
                }
                if($('#esic_emp').val()!='')
                {    esic_emp_basic=$('#basic_salary').val()*($('#esic_emp').val())*0.01;
                        $('#esic_emp_amt').val(esic_emp_basic);  
                }
                if($('#esic_cmp').val()!='')
                {    esic_cmp_basic=$('#basic_salary').val()*($('#esic_cmp').val())*0.01;
                        $('#esic_cmp_amt').val(esic_cmp_basic);   
                }

                    cal_amt=(parseInt(pf_emp_basic) + parseInt(esic_emp_basic));
                    net_amt=parseInt($('#basic_salary').val())+parseInt($('#fooding_allowance').val())+parseInt($('#hra').val())+parseInt($('#mobile_allowance').val())+parseInt($('#transbortation_allowance').val())+parseInt($('#medical_allownce').val())+parseInt($('#accomodation').val())-cal_amt;
                 $('#net_salary').val(net_amt);   

   }
  if(cut_from=='total_salary'){
            if($('#pf_emp').val()!='')
            {
                pf_emp_basic=$('#total_salary').val()*($('#pf_emp').val())*0.01;
                $('#pf_emp_amt').val(pf_emp_basic);
            }
            if($('#pf_cmp').val()!='')
            {       pf_cmp_basic=$('#total_salary').val()*($('#pf_cmp').val())*0.01;
                 $('#pf_cmp_amt').val(pf_cmp_basic);        
            }
            if($('#esic_emp').val()!='')
            {    esic_emp_basic=$('#total_salary').val()*($('#esic_emp').val())*0.01;
                    $('#esic_emp_amt').val(esic_emp_basic);  
            }
            if($('#esic_cmp').val()!='')
            {    esic_cmp_basic=$('#total_salary').val()*($('#esic_cmp').val())*0.01;
                    $('#esic_cmp_amt').val(esic_cmp_basic);   
            }

            cal_amt=(parseInt(pf_emp_basic) + parseInt(esic_emp_basic));
                    net_amt=parseInt($('#basic_salary').val())+parseInt($('#fooding_allowance').val())+parseInt($('#hra').val())+parseInt($('#mobile_allowance').val())+parseInt($('#transbortation_allowance').val())+parseInt($('#medical_allownce').val())+parseInt($('#accomodation').val())-cal_amt;
                   
                 $('#net_salary').val(net_amt);
   }
}
</script>