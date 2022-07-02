<!--setting-->
<?php 
    $page_no = "9";
    $page_no_inside = "9_2";
   
?>
<?php require_once("include/auth.php"); ?>
 
<!DOCTYPE html>
<html>
    
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name;
      else echo $setting->setting_firm_info->firm_name; ?> Setting</title>
  
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->

</head>
<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed text-sm accent-navy pace-red"  >
   <div class="wrapper" id="wrapper" >
     <!-- Navbar Section Start -->
        <?php require_once("include/navbar.php"); ?>
       <!-- Navbar Section End -->
       
       <!-- Main Sidebar Section Start -->
        <?php require_once("include/aside.php"); ?>

        <!-- Main Sidebar Section End -->
       <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"  >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <span class= "right" >
            <ol class="breadcrumb float-sm-right"  >
              <li class="breadcrumb-item" ><a href="#"  >Dashboard</a></li>
              <li class="breadcrumb-item active" >Settings</li>
            </ol>
            </span>
          </div>
        </div>
            <!-- See Section Start -->
        <div class="modal fade" id="see-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Complete Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body" id="see-section"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
         
          <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
        <!-- Edit Section End -->
          <div class="card-body" id="view-section"></div>
      </div><!-- /.container-fluid -->
    </section>
       </div>
              <!-- Footer Section Start -->
        <?php require_once("include/footer.php"); ?>
        <!-- Footer Section End -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
    
    <!-- ./wrapper -->
    
    <!-- Js Section Start -->
    <?php require_once("include/js.php"); ?>
     
    <script src="dist/js/ajax.js"></script>
    <script src="dist/js/admin/settings.js"></script>
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
 
    <!-- Js Section End -->
</body>

</html>
      
   