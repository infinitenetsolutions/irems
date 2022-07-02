        <div id="content" class="content">

            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:;">Payroll Register</a></li>
            </ol>


            <h1 class="page-header">Payroll Register</h1>

            <form id="TypeValidation" class="form-horizontal" action="<?php echo base_url(); ?>payroll/Employee/add_employee" method="post" enctype="multipart/form-data">
                <div class="card card-navy card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employeeCategory"><strong>Employee Type:</strong></label>
                                    <select class="form-control" name="employee_type" id="employeeCategory" style="">
                                        <option value="">Select Employee Type</option>
                                        <option value="Vendor Employee">Vendor Employee</option>
                                        <option value="On Payroll">On Payroll</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-inverse" data-sortable-id="form-plugins-4">

                    <div class="panel-heading">
                        <h4 class="panel-title">Personal Details</h4>
                    </div>
                    <div class="panel-body panel-form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>First Name:</strong></label>
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
                                        <label class="control-label"><strong>Employee ID:</strong></label>
                                        <input class="form-control" type="text" name="employee_id" id="employee_id" required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Mobile:</strong></label>
                                        <input class="form-control" type="number" name="mobile" id="mobile" required="true">
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
                                            <option>Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">

                        <div class="panel-heading">
                            <h4 class="panel-title">Work Details</h4>

                        </div>
                        <?php 
	$conn = mysqli_connect('localhost','root','','ateebfoods_db');
	$sel = "SELECT * from `tbl_company`";
	$run=mysqli_query($conn,$sel);
	$result=mysqli_fetch_assoc($run);
	 ?>

                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="department"><strong>Department:</strong></label>
                                            <select name="department" id='department' class="form-control" class="selectpicker" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <?php
foreach($department as $value)
{
?>
                                                <option value="<?php echo $value['department_name']; ?>"><?php echo $value['department_name']; ?></option>
                                                <?php
}
?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Date of Joining:</strong></label>
                                            <input type="date" class="form-control" id="date_of_hire" name="date_of_hire" placeholder="Select Date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="empTitle" class="form-group">
                                            <label class="control-label"><strong>Title:</strong></label>
                                            <input class="form-control" type="text" name="title" id="title" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Source of Hire:</strong></label>
                                            <input class="form-control" name="source_of_hire" id="source_of_hire" type="text" value="" required="true">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="empReportTo" class="form-group">
                                            <label for=""><strong>Reporting To:</strong></label>
                                            <input class="form-control" name="reporting_to" id="reporting_to" type="text" value="" required="true">

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
                                            <input class="form-control" name="work_phone_no" id="work_phone_no" type="text" required="true">

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
                        <?php 
		$conn = mysqli_connect('localhost','root','','ateebfoods_db');
		$sel = "SELECT * from `tbl_company`";
		$run=mysqli_query($conn,$sel);
		$result=mysqli_fetch_assoc($run);
		 ?>
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
                                            <input class="form-control" type="text" name="address2" id="address2" required="true">
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
                                            <input class="form-control" type="number" name="postal_code" id="postal_code" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Alternate Mobile No:</strong></label>
                                            <input class="form-control" type="number" name="other_mobile" id="other_mobile" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Alternate Email ID:</strong></label>
                                            <input class="form-control" type="email" name="other_email" id="other_email" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Driving License:</strong></label>
                                            <input class="form-control" type="text" name="driving_license" id="driving_license" required="true">
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
                                            <input class="form-control" name="hobbies" id="hobbies" type="text" value="" required="true">

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
                        <?php 
		$conn = mysqli_connect('localhost','root','','ateebfoods_db');
		$sel = "SELECT * from `tbl_company`";
		$run=mysqli_query($conn,$sel);
		$result=mysqli_fetch_assoc($run);
		 ?>

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
                                            <label for="hra"><strong>Mobile Allowance:</strong></label>
                                            <input class="form-control" name="hra" id="hra" onkeyup="cal();" type="number" required="true">
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
                                        <div id="response" class="form-group">
                                            <label for="empTotalSalary"><strong>Total Salary:</strong></label>
                                            <input class="form-control" name="total_salary" id="total_salary" onkeyup="cal();" type="text" readonly>
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
                        <?php 
		$conn = mysqli_connect('localhost','root','','ateebfoods_db');
		$sel = "SELECT * from `tbl_company`";
		$run=mysqli_query($conn,$sel);
		$result=mysqli_fetch_assoc($run);
		 ?>

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
                                            <label for=""><strong>Branch:</strong></label>
                                            <input class="form-control" name="branch" id="branch" type="text" required="true">
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
                        <?php 
		$conn = mysqli_connect('localhost','root','','ateebfoods_db');
		$sel = "SELECT * from `tbl_company`";
		$run=mysqli_query($conn,$sel);
		$result=mysqli_fetch_assoc($run);
		 ?>
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
