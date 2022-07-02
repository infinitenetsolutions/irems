<?php

$con = mysqli_connect('localhost','root','','ateebfoods_db');
  if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
  }
 $sql = "SELECT * FROM tbl_hsncodes";
 $query = mysqli_query($con,$sql);
 $sql_uom = "SELECT * FROM tbl_uom";
 $query_uom = mysqli_query($con,$sql_uom);
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ATEEB FOODS PVT LTD | Edit Employee</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>img/logo/logo.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/css/default/app.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="<?php echo base_url() ?>/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />

    <script src="<?php echo base_url() ?>/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url()."assets1/";  ?>ckeditor/ckeditor.js"></script>
    <script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>

</head>

<body>

    <!-- <div id="page-loader" class="fade show">
<span class="spinner"></span>
</div> -->


    <div id="page-container" class="fade in page-sidebar-fixed page-header-fixed">

        <?php echo $header; ?>

        <?php echo $sidebar; ?>


        <div id="content" class="content">

            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:;">Edit Employee</a></li>
            </ol>


            <h1 class="page-header">Edit Employee</h1>

            <form id="TypeValidation" class="form-horizontal" action="<?php echo base_url();?>admin/Employee/edit_employee_page/<?php echo $employee_item['id'] ?>" method="post" enctype="multipart/form-data">
                <div class="card card-navy card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employeeCategory"><strong>Employee Type:</strong></label>
                                    <select name="employee_type" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
<option value="Vendor Employee" <?php if(!empty($employee_item) && $employee_item['employee_type']=='Vendor Employee'){echo 'selected';} ?>>Vendor Employee </option>
<option value="On Payroll" <?php if(!empty($employee_item) && $employee_item['employee_type']=='On Payroll'){echo 'selected';} ?>>On Payroll  </option>					
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
                                        <input class="form-control" type="text" value="<?php echo $employee_item['first_name'] ?>" name="first_name" id="first_name" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Last Name:</strong></label>
                                        <input class="form-control" type="text" value="<?php echo $employee_item['last_name'] ?>" name="last_name" id="last_name" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Employee ID:</strong></label>
                                        <input class="form-control" type="text" value="<?php echo $employee_item['employee_id'] ?>" name="employee_id" id="employee_id" required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Mobile:</strong></label>
                                        <input class="form-control" type="number" value="<?php echo $employee_item['mobile'] ?>" name="mobile" id="mobile" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Date of Birth:</strong></label>
                                        <input type="date" class="form-control" id="date_of_birth" value="<?php echo $employee_item['date_of_birth'] ?>" name="date_of_birth" placeholder="Select Date" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="empGender"><strong>Gender:</strong></label>
                                       <select name="gender" class="form-control" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
										<option value="Male" <?php if(!empty($employee_item) && $employee_item['gender']=='Male'){echo 'selected';} ?>>Male</option>
										<option value ="Female" <?php if(!empty($employee_item) && $employee_item['gender']=='Female'){echo 'selected';} ?>>Female</option>
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
                                          <select name="department"  id='department' class="form-control" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue" >
												<?php
												foreach($department as $value)
												{
												?>
												<option value="<?php echo $value['department_name']; ?>" <?php if($value['department_name'] == $employee_item['department']){ echo 'selected';} ?>><?php echo $value['department_name']; ?></option>


												<?php
												}
												?>
												</select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Date of Joining:</strong></label>
                                            <input type="date" class="form-control" id="date_of_hire" name="date_of_hire" value="<?php echo $employee_item['date_of_hire'] ?>" placeholder="Select Date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="empTitle" class="form-group">
                                            <label class="control-label"><strong>Title:</strong></label>
                                            <input class="form-control" type="text" value="<?php echo $employee_item['title'] ?>" name="title" id="title" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Source of Hire:</strong></label>
                                            <input class="form-control" name="source_of_hire" id="source_of_hire" type="text"value="<?php echo $employee_item['source_of_hire'] ?>"  required="true">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="empReportTo" class="form-group">
                                            <label for=""><strong>Reporting To:</strong></label>
                                            <input class="form-control" name="reporting_to" id="reporting_to" type="text"value="<?php echo $employee_item['reporting_to'] ?>" required="true">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="empStatus"><strong>Employee Status:</strong></label>
                                            <select name="emp_status" class="form-control"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
											<option value="Active" <?php if(!empty($employee_item) && $employee_item['emp_status']=='Active'){echo 'selected';} ?> >Active</option>
											<option value ="Inactive" <?php if(!empty($employee_item) && $employee_item['emp_status']=='Inactive'){echo 'selected';} ?> >Inactive</option>									   
											</select>
										</div>
                                    </div>

                                    <div class="col-md-4">
                                        <div id="empWorkPhone" class="form-group">
                                            <label for=""><strong>Work Phone:</strong></label>
                                            <input class="form-control" name="work_phone_no" id="work_phone_no" type="text" value="<?php echo $employee_item['work_phone_no'] ?>" required="true">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="empType"><strong>Employee Type:</strong></label>
                                            <select name="emp_type" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Full Time" <?php if(!empty($employee_item) && $employee_item['emp_type']=='Full Time'){echo 'selected';} ?> >Full Time</option>
                                                <option value="Part Time" <?php if(!empty($employee_item) && $employee_item['emp_type']=='Part Time'){echo 'selected';} ?> >Part Time</option>
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
                                            <input class="form-control" type="text" name="address1"  value="<?php echo $employee_item['address1'] ?>" id="address1" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label class="control-label"><strong>Address 2:</strong></label>
                                            <input class="form-control" type="text" name="address2"  value="<?php echo $employee_item['address2'] ?>" id="address2" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country"><strong>Country:</strong></label>
                                            <select name="country" class="form-control" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
												<option value="India" <?php if(!empty($employee_item) && $employee_item['emp_status']=='India'){echo 'selected';} ?> >India</option>
												<option value ="Others" <?php if(!empty($employee_item) && $employee_item['emp_status']=='Others'){echo 'selected';} ?> >Others</option>																 
												</select> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state"><strong>State:</strong></label>
                                            <select name="state" class="form-control" data-title="Select"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Jharkhand" <?php if(!empty($employee_item) && $employee_item['state']=='Jharkhand'){echo 'selected';} ?>>Jharkhand</option>
                                                <option value="Others" <?php if(!empty($employee_item) && $employee_item['state']=='Others'){echo 'selected';} ?>>Others</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city"><strong>City:</strong></label>
                                            <select name="city" class="form-control" data-title="Select"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Jamshedpur" <?php if(!empty($employee_item) && $employee_item['city']=='Jamshedpur'){echo 'selected';} ?>>Jamshedpur</option>
                                                <option value="Others" <?php if(!empty($employee_item) && $employee_item['city']=='Others'){echo 'selected';} ?>>Others</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Postal Code:</strong></label>
                                            <input class="form-control" type="number" name="postal_code" value="<?php echo $employee_item['postal_code'] ?>" id="postal_code" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Alternate Mobile No:</strong></label>
                                            <input class="form-control" type="number" name="other_mobile" value="<?php echo $employee_item['other_mobile'] ?>" id="other_mobile" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Alternate Email ID:</strong></label>
                                            <input class="form-control" type="email" name="other_email" value="<?php echo $employee_item['other_email'] ?>" id="other_email" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Driving License:</strong></label>
                                            <input class="form-control" type="text" name="driving_license" value="<?php echo $employee_item['driving_license'] ?>" id="driving_license" required="true">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nationality"><strong>Nationality:</strong></label>
                                            <select name="nationality" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Indian" <?php if(!empty($employee_item) && $employee_item['nationality']=='Indian'){echo 'selected';} ?>>Indian</option>
                                                <option value="Others" <?php if(!empty($employee_item) && $employee_item['nationality']=='Others'){echo 'selected';} ?>>Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="marital_status"><strong>Marital Status:</strong></label>
                                            <select name="marital_status" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Married" <?php if(!empty($employee_item) && $employee_item['marital_status']=='Married'){echo 'selected';} ?>>Married</option>
                                                <option value="Single" <?php if(!empty($employee_item) && $employee_item['marital_status']=='Single'){echo 'selected';} ?>>Single</option>
                                                <option value="Others" <?php if(!empty($employee_item) && $employee_item['marital_status']=='Others'){echo 'selected';} ?>>Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Hobbies:</strong></label>
                                            <input class="form-control" name="hobbies" id="hobbies" value="<?php echo $employee_item['hobbies'] ?>" type="text" value="" required="true">

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
                                            <label for="basic_salary"><strong>Basic Salary: <?php echo $employee_item['basic_salary'] ?></strong></label>
                                            <input class="form-control" name="basic_salary" id="basic_salary" type="number" value="<?php echo $employee_item['basic_salary'] ?>"  onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fooding_allowance"><strong>Fooding Allowance:</strong></label>
                                            <input class="form-control" name="fooding_allowance" id="fooding_allowance" type="number" value="<?php echo $employee_item['fooding_allowance'] ?>" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="hra"><strong>Mobile Allowance:</strong></label>
                                            <input class="form-control" name="hra" id="hra" onkeyup="cal();" type="number" value="<?php echo $employee_item['hra'] ?>" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="transbortation_allowance"><strong>Transpotation Allowance:</strong></label>
                                            <input class="form-control" name="transbortation_allowance" id="transbortation_allowance" type="number" value="<?php echo $employee_item['transbortation_allowance'] ?>" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="medical_allownce"><strong>Medical Allowance:</strong></label>
                                            <input class="form-control" name="medical_allownce" id="medical_allownce" type="number" value="<?php echo $employee_item['medical_allownce'] ?>" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="accomodation"><strong>Accomodation:</strong></label>
                                            <input class="form-control" name="accomodation" id="accomodation" type="number" value="<?php echo $employee_item['accomodation'] ?>" onkeyup="cal();" required="true">
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
                                            <input class="form-control" name="account_holder_name" id="account_holder_name" type="text" value="<?php echo $employee_item['account_holder_name'] ?>" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="bank_name"><strong>Bank Name:</strong></label>
                                            <input class="form-control" name="bank_name" id="bank_name" type="text" value="<?php echo $employee_item['bank_name'] ?>" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="account_no"><strong>Account No:</strong></label>
                                            <input class="form-control" name="account_no" id="account_no" type="text" value="<?php echo $employee_item['account_no'] ?>" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="branch" class="form-group">
                                            <label for=""><strong>Branch:</strong></label>
                                            <input class="form-control" name="branch" id="branch" type="text" value="<?php echo $employee_item['branch'] ?>" required="true">
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
                                            <!--<span class="input-group-addon"><i class="fa fa-edit" aria-hidden="true"></i></span>-->
											<img src="<?php echo base_url();?>upload/employee/<?php echo $employee_item['image']; ?>"  style="width:80px;height:80px;" />
                                             <input class="form-control" name="image" value="<?php echo $employee_item['image'] ?>" id="image" type="file" selected>
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





    <?php echo $theme; ?>


    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

    </div>

    <?php echo $footer; ?>



    <script src="<?php echo base_url() ?>/assets/js/app.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/js/theme/default.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js" type="cf10a3b069cca062641b4e6b-text/javascript"></script>
    <link href="<?php echo base_url() ?>/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" />
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net/js/jquery.dataTables.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.print.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/build/pdfmake.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/build/vfs_fonts.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/jszip/dist/jszip.min.js" type="a068436a98d0724ad287ec23-text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/js/demo/table-manage-buttons.demo.js" type="a068436a98d0724ad287ec23-text/javascript"></script>


    	<!-- calculate fields -->
<script language=Javascript>
function cal() {
      var txtFirstNumberValue = document.getElementById('basic_salary').value;
      var txtSecondNumberValue = document.getElementById('hra').value;
	  var txtThirdNumberValue = document.getElementById('medical_allownce').value;
// 	  var txtFourthNumberValue = document.getElementById('monthly_tax_deduc').value
      var txtFourthNumberValue = document.getElementById('fooding_allowance').value;
      var txtFifthNumberValue = document.getElementById('transbortation_allowance').value;
      var txtSixthNumberValue = document.getElementById('accomodation').value;
    //   var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue) -  parseInt(txtFourthNumberValue);
    var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue) +  parseInt(txtFourthNumberValue) +  parseInt(txtFifthNumberValue) +  parseInt(txtSixthNumberValue);
      if (!isNaN(result)) {
         document.getElementById('total_salary').value = result;
      }
}
</script>

    <script src="<?php echo base_url() ?>/ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="a068436a98d0724ad287ec23-|49" defer=""></script>
    <script src="<?php echo base_url() ?>/assets/plugins/ckeditor/ckeditor.js" type="e3e3459d0ff0d99dcb6d5a6f-text/javascript"></script>


</body>


</html>