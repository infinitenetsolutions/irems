<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>FAIZ FACILITIES MANAGEMENT SYSTEM | Employee</title>
	<link href="../../../login_css/images/logo.gif" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!-- Canonical SEO -->
    <link rel="canonical" href="" />
    <!--  Social tags      -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="">
    <meta itemprop="description" content="">
    <meta itemprop="image" content="">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:creator" content="">
    <meta name="twitter:image" content="">
    <meta name="twitter:data1" content="">
    <meta name="twitter:label1" content="Product Type">
    <meta name="twitter:data2" content="$39">
    <meta name="twitter:label2" content="Price">
    <!-- Open Graph data -->
    <meta property="og:title" content="">
    <meta property="og:type" content="article" />
    <meta property="og:url" content="dashboard.html" />
    <meta property="og:image" content="" >
    <meta property="og:description" content="" />
    <meta property="og:site_name" content="" />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../../assets/css/light-bootstrap-dashboard790f.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../../../assets/css/demo.css" rel="stylesheet" />
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NKDMSK6');</script>
    <!-- End Google Tag Manager -->

<!-- view password -->	
<script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

    </head>

    <body>
      <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrapper">  
     <!-- Sidebar -->
    <?php echo $sidebar1; ?>
	 <!-- End Sidebar -->	
        <div class="main-panel">
            <!-- Navbar -->
              <?php echo $navbar; ?>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="TypeValidation" class="form-horizontal" action="<?php echo base_url();?>admin/Employee/edit_employee_page/<?php echo $employee_item['id'] ?>" method="post" enctype="multipart/form-data">
                                    
									<div class="card holder">
                                        <div class="card-header ">
                                            <h4 class="card-title" style="margin-left:69px;">Employee Details</h4>
											<h3 style="text-align:right;margin-top: -24px;"><button type="button" class="btn btn-primary"><a href="<?php echo site_url(); ?>admin/Employee/employee_view" style="color:white;">Employee List</a></button></h3>
                                       
                                        </div>
                                             <div>&nbsp;</div>           
                                        
                                            <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">First Name</label>
                                                                <input class="form-control" type="text" name="first_name" value="<?php echo $employee_item['first_name'] ?>" readonly required="true" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Last Name</label>
                                                                <input class="form-control" type="text" name="last_name" value="<?php echo $employee_item['last_name'] ?>" readonly required="true"  />
                                                            </div>
                                                        </div>
                                                    </div>
                                            
											
                                           
                                         <div class="row justify-content-center">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Employee ID</label>
                                                                <input class="form-control" name="employee_id" type="text"  value="<?php echo $employee_item['employee_id'] ?>" readonly required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                            </div>
                                                        </div>
                                                    </div>
											
                                               <div class="card-header ">
                                            <h4 class="card-title" style="margin-left:69px;">Login Details</h4>
                                        </div>
											   <div>&nbsp;</div>           

										<div class="row justify-content-center">
                                                         <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Email</label>
                                                                <input class="form-control" name="email" type="email" value="<?php echo $employee_item['email'] ?>" readonly required="true">
                                                            </div>
                                                        </div>
                                                         <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Password</label>
                                                                <input id="myInput" class="form-control" name="password" type="password" value="<?php echo $employee_item['password'] ?>" readonly required="true">
                                                            <span  class="field-icon"><input type="checkbox" onclick="myFunction()">
															</span>
															</div>
                                                        </div>
                                                    </div>
													
                                        <div class="card-header ">
                                            <h4 class="card-title" style="margin-left:69px;">Work</h4>
                                        </div>
										     <div>&nbsp;</div>           

                                            <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Department</label>
                                                                <input class="form-control" name="department" value="<?php echo $employee_item['department'] ?>" type="text"  readonly required="true" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Title</label>
                                                                <input class="form-control" name="title" value="<?php echo $employee_item['title'] ?>" type="text" readonly required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                           
                                         <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Reporting To</label>
                                                                <input class="form-control" name="reporting_to" value="<?php echo $employee_item['reporting_to'] ?>" readonly type="text" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Date of Hire</label>
                                                                <input class="form-control" name="date_of_hire" value="<?php echo $employee_item['date_of_hire'] ?>" type="date" readonly required="true">
                                                            </div>
                                                        </div>
                                                    </div>
													
                                            <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Source of Hire</label>
                                                                <input class="form-control" name="source_of_hire" value="<?php echo $employee_item['source_of_hire'] ?>" type="text"  readonly required="true" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Employee Status</label>
                                                               <select name="emp_status" class="selectpicker"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                    <option value="<?php echo $employee_item['emp_status'] ?>"><?php echo $employee_item['emp_status'] ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                           
                                         <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Work phone</label>
                                                                <input class="form-control" name="work_phone_no" value="<?php echo $employee_item['work_phone_no'] ?>" type="text" readonly required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Employee Type</label>
                                                               <select name="emp_type" class="selectpicker"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                    <option value="<?php echo $employee_item['emp_type'] ?>"><?php echo $employee_item['emp_type'] ?></option>
																 </select>
                                                            </div>
                                                        </div>
                                                    </div>
											
                                        <div class="card-header ">
                                            <h4 class="card-title" style="margin-left:69px;">Personal Details</h4>
                                        </div>
										
										        <div>&nbsp;</div>           

										
                                            <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Address 1</label>
                                                                <input class="form-control" name="address1" value="<?php echo $employee_item['address1'] ?>" type="text" readonly required="true"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Address 2</label>
                                                                <input class="form-control" name="address2"  value="<?php echo $employee_item['address2'] ?>" type="text"  readonly required="true"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                           
                                         <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">State</label>
																<select name="state" class="selectpicker" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                    <option value="<?php echo $employee_item['state'] ?>"><?php echo $employee_item['state'] ?></option>
                                                                 </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Country</label>
                                                                <select name="country" class="selectpicker"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                  <option value="<?php echo $employee_item['country'] ?>"><?php echo $employee_item['country'] ?></option>
																  </select>
                                                            </div>
                                                        </div>
                                                    </div>
													
                                                            
													
                                            <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">City</label>
																<select name="city" class="selectpicker"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                   <option value="<?php echo $employee_item['city'] ?>"><?php echo $employee_item['city'] ?></option>
																   </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Postal code</label>
                                                                <input class="form-control" name="postal_code" value="<?php echo $employee_item['postal_code'] ?>" type="number"  readonly required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                           
                                         <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Mobile</label>
                                                                <input class="form-control" name="mobile" value="<?php echo $employee_item['mobile'] ?>" type="text" readonly required="true" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Other Email</label>
                                                                <input class="form-control" type="text" name="other_email" value="<?php echo $employee_item['other_email'] ?>" readonly required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
													<div class="row justify-content-center">
                                                        <div class="col-md-5 ">
													<div class="form-group">
                                                                <label class="control-label">Date of Birth</label>
                                                                <input class="form-control" name="date_of_birth" value="<?php echo $employee_item['date_of_birth'] ?>" type="date" readonly required="true" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Gender</label>
                                                              <select name="gender" class="selectpicker"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                  <option value="<?php echo $employee_item['gender'] ?>"><?php echo $employee_item['gender'] ?></option>																     
																   </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                           
                                         <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Nationality</label>
																<select name="nationality" class="selectpicker"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                  <option value="<?php echo $employee_item['nationality'] ?>"><?php echo $employee_item['nationality'] ?></option>																     
																  </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Marital Status</label>
																<select name="marital_status" class="selectpicker" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                    <option value="<?php echo $employee_item['marital_status'] ?>"><?php echo $employee_item['marital_status'] ?></option>																     
																   </select>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
													<div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Driving License</label>
                                                                <input class="form-control" name="driving_license" value="<?php echo $employee_item['driving_license'] ?>" type="text" readonly required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Hobbies</label>
                                                                <input class="form-control" name="hobbies" value="<?php echo $employee_item['hobbies'] ?>" type="text" readonly required="true">
                                                            </div>
                                                        </div>
                                                    </div>
													<div class="card-header ">
                                            <h4 class="card-title" style="margin-left:69px;">Work Experience</h4>
                                        </div>
								           <div>&nbsp;</div>           

										<div class="row justify-content-center">
                                                        <div class="col-md-5 ">
													<div class="form-group">
                                                                <label class="control-label">Previous Company</label>
                                                                <input class="form-control" type="text" name="previous_company"  value="<?php echo $employee_item['previous_company'] ?>" readonly required="true" />
                                                            </div>
                                                      </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Job Title</label>
                                                                <input class="form-control" type="text" name="job_title"  value="<?php echo $employee_item['job_title'] ?>" readonly required="true"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                           
                                         <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">From</label>
                                                                <input class="form-control" name="from" value="<?php echo $employee_item['from'] ?>" type="date" readonly required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">To</label>
                                                                <input class="form-control" name="to" value="<?php echo $employee_item['to'] ?>" type="date" readonly required="true">
                                                            </div>
                                                        </div>
                                                    </div>
													<div class="row justify-content-center">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Job Description</label>
                                                                <input class="form-control" name="job_description" value="<?php echo $employee_item['job_description'] ?>" type="text" readonly required="true"/>
                                                            </div>
															</div>
															
															<div class="col-md-5">
                                                            <div class="form-group">
                                                                
                                                            </div>
															</div>
                                                        </div>
														<div class="card-header ">
                                            <h4 class="card-title" style="margin-left:69px;">Education</h4>
                                        </div>
									          <div>&nbsp;</div>           

                                            <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">School Name</label>
                                                                <input class="form-control" name="school_name" value="<?php echo $employee_item['school_name'] ?>" type="text" readonly required="true"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Degree</label>
                                                                <input class="form-control" name="degree" value="<?php echo $employee_item['degree'] ?>" type="text"  readonly required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                           
                                         <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Field(s) of study</label>
                                                                <input class="form-control" name="field_of_study" value="<?php echo $employee_item['field_of_study'] ?>" type="text" readonly required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Year of Completion</label>
                                                                <select name="year_of_completion" class="selectpicker"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                    <option value="<?php echo $employee_item['year_of_completion'] ?>"><?php echo $employee_item['year_of_completion'] ?></option>
                                                                   </select>
                                                            </div>
                                                        </div>
                                                    </div>
													
                                            <div class="row justify-content-center">
                                                        <div class="col-md-5 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Additional Notes</label>
                                                                <input class="form-control" name="additional_notes" value="<?php echo $employee_item['additional_notes'] ?>" type="text" readonly required="true"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">interests</label>
                                                                <input class="form-control" name="interests" value="<?php echo $employee_item['interests'] ?>" type="text"  readonly required="true"/>
                                                            </div>
                                                        </div>
                                                    </div>
													<div class="card-header ">
                                            <h4 class="card-title" style="margin-left:69px;">Dependents</h4>
                                        </div>
											   <div>&nbsp;</div>           

										<div class="row justify-content-center">
                                                        <div class="col-md-5 ">
													<div class="form-group">
                                                                <label class="control-label">Name</label>
                                                                <input class="form-control" name="dependents_name" value="<?php echo $employee_item['dependents_name'] ?>" type="text" readonly required="true" />
                                                            </div>
                                                      </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Relationship</label>
                                                                <select name="dependents_relationship" class="selectpicker"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                                    <option value="<?php echo $employee_item['dependents_relationship'] ?>"><?php echo $employee_item['dependents_relationship'] ?></option>
																 </select>
                                                            </div>
                                                        </div>
                                                    </div>
													<div class="row justify-content-center">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Date of Birth</label>
                                                                <input class="form-control" name="dependents_date_of_birth" value="<?php echo $employee_item['dependents_date_of_birth'] ?>" type="date" readonly required="true"/>
                                                            </div>
															</div>
															
															<div class="col-md-5">
                                                            <div class="form-group">
                                                                
                                                            </div>
															</div>
                                                        </div>
														
															<div class="card-header ">
															<h4 class="card-title" style="margin-left:69px;">Image Upload</h4>
															</div>
															<div>&nbsp;</div>           

														
														
														<div class="row justify-content-center">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Profile Image</label>
																<img src="<?php echo base_url();?>upload/employee/<?php echo $employee_item['image']; ?>" height="70" width="100" />
                                                             </div>
															</div>
															
															<div class="col-md-5">
                                                            <div class="form-group">
                                                                
                                                            </div>
															</div>
                                                        </div>
												
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			<?php echo $footer; ?>
            
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="../../../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../../../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: https://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../../../assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>
<!--  Chartist Plugin  -->
<script src="../../../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../../../assets/js/plugins/bootstrap-notify.js"></script>
<!--  Share Plugin -->
<script src="../../../assets/js/plugins/jquery.sharrre.js"></script>
<!--  jVector Map  -->
<script src="../../../assets/js/plugins/jquery-jvectormap.js" type="text/javascript"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="../../../assets/js/plugins/moment.min.js"></script>
<!--  DatetimePicker   -->
<script src="../../../assets/js/plugins/bootstrap-datetimepicker.js"></script>
<!--  Sweet Alert  -->
<script src="../../../assets/js/plugins/sweetalert2.min.js" type="text/javascript"></script>
<!--  Tags Input  -->
<script src="../../../assets/js/plugins/bootstrap-tagsinput.js" type="text/javascript"></script>
<!--  Sliders  -->
<script src="../../../assets/js/plugins/nouislider.js" type="text/javascript"></script>
<!--  Bootstrap Select  -->
<script src="../../../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
<!--  jQueryValidate  -->
<script src="../../../assets/js/plugins/jquery.validate.min.js" type="text/javascript"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="../../../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--  Bootstrap Table Plugin -->
<script src="../../../assets/js/plugins/bootstrap-table.js"></script>
<!--  DataTable Plugin -->
<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<!--  Full Calendar   -->
<script src="../../../assets/js/plugins/fullcalendar.min.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../../../assets/js/light-bootstrap-dashboard790f.js?v=2.0.1" type="text/javascript"></script>
<!-- Light Dashboard DEMO methods, don't include it in your project! -->
<script src="../../../assets/js/demo.js"></script>
<script type="text/javascript">
    function setFormValidation(id) {
        $(id).validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                $(element).closest('.form-check').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                $(element).closest('.form-check').removeClass('has-error').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error).addClass('has-error');
            },
        });
    }

    $(document).ready(function() {
        setFormValidation('#RegisterValidation');
        setFormValidation('#TypeValidation');
        setFormValidation('#LoginValidation');
        setFormValidation('#RangeValidation');
    });
</script>
<!-- Facebook Pixel Code Don't Delete -->
<script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window,
        document, 'script', 'connect.facebook.net/en_US/fbevents.js');

    try {
        fbq('init', '111649226022273');
        fbq('track', "PageView");

    } catch (err) {
        console.log('Facebook Track Error:', err);
    }
</script>
<noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=111649226022273&amp;ev=PageView&amp;noscript=1" />
</noscript>
</html>