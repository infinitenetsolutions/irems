<!-- User Profile -->
<?php 
    $page_no = "2";
    
   
?>
<?php require_once("../customer/include/auth.php"); ?>
<!DOCTYPE html>
<html>
    
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> Profile</title>
  
    <!-- Css Section Start -->
    <?php require_once("../customer/include/css.php"); ?>
    <!-- Css Section End -->

</head>
<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed text-sm accent-navy pace-red"  >
   <div class="wrapper" id="wrapper" >
     <!-- Navbar Section Start -->
        <?php require_once("../customer/include/navbar.php"); ?>
       <!-- Navbar Section End -->
       
       <!-- Main Sidebar Section Start -->
        <?php require_once("../customer/include/aside.php"); ?>

        <!-- Main Sidebar Section End -->
       <!-- Content Wrapper. Contains page content -->
                      <div class="content-wrapper"  >
                        <!-- Content Header (Page header) -->
                        <section class="content-header">
                          <div class="container-fluid">
                            <div class="row mb-2">
                              <div class="col-sm-6">
                                <h1>Profile</h1>
                              </div>
                              <div class="col-sm-6">
                                  <span class= "right">
                                <ol class="breadcrumb float-sm-right">
                                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                  <li class="breadcrumb-item active">Profile</li>
                                </ol>
                                  </span>
                              </div>
                            </div>
                              <div class= "card-body" id="view-section"></div>
                          </div><!-- /.container-fluid -->
                        </section>
                           </div> <!-- ./wrapper -->
                          <!-- Edit Section Start -->
                            <div class="modal fade" id="edit-modal">
                                <div class="modal-dialog modal-lg">
                                    <form id="editForm" method="POST" enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit This</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card card-navy card-outline">
                                                    <div class="card-body" id="edit-section"></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                                                <button type="submit" id="editButton" class="edit-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Edit Section End -->
                          
                                  <!-- Footer Section Start -->
                            <?php require_once("../customer/include/footer.php"); ?>
                            <!-- Footer Section End -->

                        </div>

                       

                        <!-- Js Section Start -->
                        <?php require_once("../customer/include/js.php"); ?>

                        <script src="../dist/js/customer-ajax.js"></script>
                        <script src="../dist/js/customer/profile.js"></script>
                        <!-- Js Section End -->
                    </body>

                    </html>

   
    
