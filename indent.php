<!-- Item Management -->

<?php
    $page_no = "5";
    $page_no_inside = "5_1";
?>

<?php require_once("include/auth.php");

    require_once("application/classes-and-objects/config.php");

    require_once("application/classes-and-objects/veriables.php"); ?>

<!DOCTYPE html>

<html>



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Create Indent</title>

    <!-- Css Section Start -->

    <?php require_once("include/css.php"); ?>

    <!-- Css Section End -->

</head>



<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">

    <div id="wrapper" class="wrapper">

        <!-- Navbar Section Start -->

        <?php require_once("include/navbar.php"); ?>



        <!-- Navbar Section End -->

        <!-- Main Sidebar Section Start -->

        <?php require_once("include/aside.php"); ?>



        <!-- Main Sidebar Section End -->



        <!-- All Contains Section Start -->

        <div class="content-wrapper">

            <div class="content-header">

                <div class="container-fluid">

                    <div class="row mb-2">

                        <div class="col-sm-6">

                            <h1 class="m-0 text-dark">Indent</h1>

                        </div><!-- /.col -->

                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">

                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>

                                <li class="breadcrumb-item active">Create Indent</li>

                            </ol>

                        </div>

                    </div><!-- /.row -->

                </div><!-- /.container-fluid -->

            </div>

            <!-- Main content -->

            <section class="content">

                <div class="card card-navy card-outline">

                    <div class="card-body table-responsive" id="view-section"></div>

                </div>

            </section>

            <!-- /.content -->

        </div>

        <!-- Footer Section Start -->

        <?php require_once("include/footer.php"); ?>

        <!-- Footer Section End -->

        <!-- Control Sidebar -->

        <aside class="control-sidebar control-sidebar-dark">

            <!-- Control sidebar content goes here -->

        </aside>

        <!-- /.control-sidebar -->

    </div>

    <!-- ./wrapper -->

    <!-- Js Section Start -->

    <?php require_once("include/js.php"); ?>
   <!--  <script src="dist/js/admin/indent.js"></script>
     -->

    <?php if (isset($_POST["action"])){

      ?> 

      <script src="dist/js/admin/create-indent.js"></script>

      <script>

      // Fetch Data Section Start --------------------------------------------------------------------------------------------------------------------

      function fetchFn() {

          $('#view-section').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

          var formData = {"action":"<?php echo $_POST["action"]; ?>","ckeckItem":<?php echo json_encode($_POST["checkbox-select"]); ?>};

          $.ajax({

              url: 'application/view/admin/indent.php',

              type: 'POST',

              data: formData,

              success: function (data) {

                  $('#loading').fadeOut(500, function () {

                      $(this).remove();

                      $('#view-section').html(data);

                      $('#refresh-button').html('<i class="fas fa-sync-alt fa-sm"></i>');

                      $('#refresh-button').prop('disabled', false);

                  });

              }

          });

      }

      // Fetch Data Section End ----------------------------------------------------------------------------------------------------------------------

      </script><?php

    }

      else {

        ?><script src="dist/js/admin/indent.js"></script><?php

      } ?>

   



    <!-- Js Section End -->

</body>



</html>

