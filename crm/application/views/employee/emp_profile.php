<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>FAIZ FACILITIES MANAGEMENT SYSTEM | Edit Employee</title>
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
    <meta itemprop="image" content="s3.amazonaws.com/creativetim_bucket/products/34/original/opt_lbd_pro_thumbnail.jpg">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:creator" content="">
    <meta name="twitter:image" content="s3.amazonaws.com/creativetim_bucket/products/34/original/opt_lbd_pro_thumbnail.jpg">
    <meta name="twitter:data1" content="">
    <meta name="twitter:label1" content="Product Type">
    <meta name="twitter:data2" content="$39">
    <meta name="twitter:label2" content="Price">
    <!-- Open Graph data -->
    <meta property="og:title" content="">
    <meta property="og:type" content="article" />
    <meta property="og:url" content="dashboard.html" />
    <meta property="og:image" content="s3.amazonaws.com/creativetim_bucket/products/34/original/opt_lbd_pro_thumbnail.jpg" />
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
							        <div class="card">
									<div class="card-header">
									<div class="card-body">
							         	<div class="row">
								            <div class="col-sm-2"><img src="<?php echo base_url();?>upload/employee/<?php echo $employee_item['image']; ?>" style="height:124px;" />  </div>
								                <div class="col-sm-5" style="margin-top:30px;">
									            <h5 style="font-size:12px; margin-bottom: 7px; "><i class='fa fa-user'></i>UserName  : <?php echo ucfirst($employee_item['first_name']) ?></h5>
									             <p style="font-size:12px; margin-bottom: 5px;"><i class='fa fa-chevron-right'></i>Department  : <?php echo $employee_item['department'] ?></p>
                                                 <p style="font-size:12px; margin-bottom: 5px;"><i class='fa fa-envelope'></i>Email id    : <?php echo $employee_item['email'] ?></p>
									             <p style="font-size:12px; margin-bottom: 5px;"><i class='fa fa-mobile' style="font-size:18px;"></i>Mobile No   : <?php echo $employee_item['mobile'] ?></p></div>
									
										    <div class="col-sm-2">
												<button type="button" class="btn btn-success btn-wd btn-edit pull-right" style="min-width:60px; margin-top: 30px;">Edit</button></div>
													<div class="col-sm-1">
													<button type="button" class="btn btn-warning btn-wd btn-terminate pull-right" style="min-width:60px; padding-right:2px; padding-left:8px; margin-top: 30px;">Terminate</button></div>
													<div class="col-sm-1">
													<button type="button" class="btn btn-success" onclick="myFunction()" style="margin-top: 30px; padding-left: 19px;">Print</button></div>
													<script>
													function myFunction() {
													  window.print();
													}
													</script>
                                            <div class="col-sm-1"></div>
                                        </div></br></br>
										<div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"></h4>
                                        <p class="card-category"></p>
                                    </div>
                                    <div class="card-body">
                                        <ul role="tablist" class="nav nav-tabs">
                                            <li role="presentation" class="nav-item show active">
                                                <a class="nav-link" id="generalinfo-tab" href="#generalinfo" data-toggle="tab">General Info</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="job-tab" href="#job" data-toggle="tab">Job</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="leave-tab" href="#leave" data-toggle="tab">Leave</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="notes-tab" href="#notes" data-toggle="tab">Notes</a>
                                            </li>
											<li class="nav-item">
                                                <a class="nav-link" id="performance-tab" href="#performance" data-toggle="tab">Performance</a>
                                            </li>
											<li class="nav-item">
                                                <a class="nav-link" id="permission-tab" href="#permission" data-toggle="tab">Permission</a>
                                            </li>
											<li class="nav-item">
                                                <a class="nav-link" id="documents-tab" href="#documents" data-toggle="tab">Documents</a>
                                            </li>
											<li class="nav-item">
                                                <a class="nav-link" id="payroll-tab" href="#payroll" data-toggle="tab">Payroll</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="generalinfo" class="tab-pane fade show active" role="tabpanel" aria-labelledby="generalinfo-tab">
                                            <div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">First Name : <?php echo $employee_item['first_name'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Last Name : <?php echo $employee_item['last_name'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
											<div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Employee ID : <?php echo $employee_item['employee_id'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Mobile No : <?php echo $employee_item['mobile'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
											<div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Date Of Birth : <?php echo $employee_item['date_of_birth'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Gender : <?php echo $employee_item['gender'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
											</div>
											 <div id="job" class="tab-pane fade" role="tabpanel" aria-labelledby="job-tab">
                                            <div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Department : <?php echo $employee_item['department'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Title : <?php echo $employee_item['title'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
											
											<div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Reporting To : <?php echo $employee_item['reporting_to'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Date Of Joining : <?php echo $employee_item['date_of_hire'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
											<div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Source Of Hire : <?php echo $employee_item['source_of_hire'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Employee Status : <?php echo $employee_item['emp_status'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
											<div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Work Phone : <?php echo $employee_item['work_phone_no'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Employee Type : <?php echo $employee_item['emp_type'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
                                            </div>
											 <div id="leave" class="tab-pane fade" role="tabpanel" aria-labelledby="leave-tab">
                                           
										     </div>
											 <div id="notes" class="tab-pane fade" role="tabpanel" aria-labelledby="notes-tab">
                                           
										   </div>
											 <div id="performance" class="tab-pane fade" role="tabpanel" aria-labelledby="performance-tab">
                                            
											</div>
                                            <div id="permission" class="tab-pane fade" role="tabpanel" aria-labelledby="permission-tab">
                                           
										   </div>
                                            <div id="documents" class="tab-pane fade" role="tabpanel" aria-labelledby="documents-tab">
                                          
										  </div>
                                            <div id="payroll" class="tab-pane fade" role="tabpanel" aria-labelledby="payroll-tab">
                                           <div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Basic Salary : <?php echo $employee_item['basic_salary'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">HRA : <?php echo $employee_item['hra'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
											<div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Medical Allowance : <?php echo $employee_item['medical_allownce'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="control-label">Monthly Tax Deduction : <?php echo $employee_item['monthly_tax_deduc'] ?></label>
                                                        </div>
                                                    </div>
                                            </div>
											<div class="row justify-content-center">
                                                    <div class="col-md-5 ">
                                                        <div class="form-group">
                                                            <label class="control-label">Total Salary : <?php echo $employee_item['total_salary'] ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                            </div>
										   </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
										<!--<div class="container">
										<h2></h2>
                                        <p></p>
 <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#general">General Info</a></li>
    <li><a data-toggle="tab" href="#job">Job</a></li> 
    <li><a data-toggle="tab" href="#leave">Leave</a></li>
    <li><a data-toggle="tab" href="#notes">Notes</a></li>
	<li><a data-toggle="tab" href="#performance">Performance</a></li>
    <li><a data-toggle="tab" href="#permission">Permission</a></li>
    <li><a data-toggle="tab" href="#documents">Documents</a></li>
	<li><a data-toggle="tab" href="#payroll">Payroll</a></li>
  </ul>

  <div class="tab-content">
    <div id="general" class="tab-pane fade in active">
      <h3>Personal Details</h3>
      <div class="row ">
                                                        
                                                            <div class="form-group">
                                                                <label class="control-label">First Name: Sweta</label>
                                                           </div>
                                                       
                                                         <div class="form-group">
                                                                <label class="control-label">Last Name: Sharma</label>
                                                            </div>
                                                        
                                            </div>
	</div>
    <div id="job" class="tab-pane fade">
      <h3>Job</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="leave" class="tab-pane fade">
      <h3>Leave</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="notes" class="tab-pane fade">
      <h3>Notes</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
	<div id="performance" class="tab-pane fade">
      <h3>Performance</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
	<div id="permission" class="tab-pane fade">
      <h3>Permission</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
	<div id="documents" class="tab-pane fade">
      <h3>Documents</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
	<div id="payroll" class="tab-pane fade">
      <h3>Payroll</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>-->
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
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Style</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Background Image</p>
                        <label class="switch-image">
                            <input type="checkbox" data-toggle="switch" checked="" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Sidebar Mini</p>
                        <label class="switch-mini">
                            <input type="checkbox" data-toggle="switch" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Fixed Navbar</p>
                        <label class="switch-nav">
                            <input type="checkbox" data-toggle="switch" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <p>Filters</p>
                        <div class="pull-right">
                            <span class="badge filter badge-black" data-color="black"></span>
                            <span class="badge filter badge-azure" data-color="azure"></span>
                            <span class="badge filter badge-green" data-color="green"></span>
                            <span class="badge filter badge-orange active" data-color="orange"></span>
                            <span class="badge filter badge-red" data-color="red"></span>
                            <span class="badge filter badge-purple" data-color="purple"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">Sidebar Images</li>
                <li class="active">
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="../../assets/img/sidebar-1.jpg" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="../../assets/img/sidebar-3.jpg" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="assets/img/sidebar-4.jpg" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="assets/img/sidebar-5.jpg" alt="" />
                    </a>
                </li>
                <li class="button-container">
                    <div>
                        <a href="https://www.creative-tim.com/product/light-bootstrap-dashboard" target="_blank" class="btn btn-info btn-block">Get free demo!</a>
                    </div>
                </li>
                <li class="button-container">
                    <div>
                        <a href="https://www.creative-tim.com/product/light-bootstrap-dashboard-pro" target="_blank" class="btn btn-warning btn-block">Buy now!</a>
                    </div>
                </li>
                <li class="button-container">
                    <div>
                        <a href="https://demos.creative-tim.com/light-bootstrap-dashboard-pro/documentation/tutorial-components.html" target="_blank" class="btn btn-danger btn-block">Documention</a>
                    </div>
                </li>
                <li class="header-title" id="sharrreTitle">Thank you for sharing!</li>
                <li class="button-container">
                    <button id="twitter" class="btn btn-social btn-twitter btn-round twitter-sharrre"><i class="fa fa-twitter"></i> · 256</button>
                    <button id="facebook" class="btn btn-social btn-facebook btn-round facebook-sharrre"><i class="fa fa-facebook-square"></i> · 426</button>
                </li>
            </ul>
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
