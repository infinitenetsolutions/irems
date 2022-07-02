<!-- Services -->
<?php
include './imprtExcel/connectio.in.php';
//$page_no = "7";
//$page_no_inside = "7_3";
$leave_type_query = "SELECT * FROM `tbl_leave` WHERE 1";
// getting the leave type
$leave_type_result = mysqli_query($connection, $leave_type_query);

?>
<?php require_once("include/auth.php"); ?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php  if ($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name;
             else echo $setting->setting_firm_info->firm_name; 
            ?> | Loan Application</title>
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
                            <h1 class="m-0 text-dark">Loan Application</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Loan Application</li>
                            </ol>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="card card-navy card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-right">
                            <button id="refresh-button" type="button" class="refresh-button btn btn-sm btn-danger mt-1 mb-1" title="Refresh" disabled>
                                <i class="fas fa-sync-alt fa-sm"></i>
                            </button>
                            <button id="add-button" type="button" class="add-button btn btn-sm btn-success mt-1 mb-1" data-toggle="modal" data-target="#add-modal" title="Add New" disabled>
                                <i class="fa fa-plus fa-sm"></i> Add New
                            </button>


                            <button id="delete-button" type="button" class="delete-button btn btn-sm btn-danger display-none mt-1 mb-1" data-toggle="modal" data-target="#delete-selected-modal" title="Delete" disabled>
                                <i class="fa fa-trash fa-sm"></i> Delete
                            </button>
                        </h3>
                    </div>
                    <div class="card-body table-responsive" id="view-section"></div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- Add New Section Start -->
        <div class="modal fade" id="add-modal">
            <div class="modal-dialog modal-lg">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New
</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="servicesName">Name</label>
                                              
                                                    <input type="hidden" class="form-control" id="empid" name="emp_id" placeholder="" value="<?php echo $auth->admin_info->empId ?>" readonly>
                                                <input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="" value="<?php echo $auth->admin_info->name ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="renewalservicesType">Loan Type </label>
                                            <input type="text" class="form-control" id="loanType" name="loanType" placeholder="">

                                            </div>
                                        </div>
                                      
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="daterenewalServices">Loan Amount</label>
                                                <input type="text" class="form-control" id="loanAmount" name="loanAmount">
                                            </div>
                                        </div>
                                      
                                      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="daterenewalServices">Loan Date</label>
                                                <input type="date" class="form-control" id="loanDate" name="loanDate">
                                            </div>
                                        </div>
                                     

                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" name="add" class="add-button btn btn-success btn-sm"><i class="fa fa-plus fa-sm"></i> Add this</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add New Section End -->
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
        <!-- See Section End -->
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

    <script src="dist/js/ajax.js"></script>
    <script src="dist/js/admin/loan_application.js"></script>
    <!-- Js Section End -->
</body>

</html>
<?php
if (isset($_POST['add'])) {
    // echo "<pre>";
    // print_r($_POST);
    $user = $auth->admin_info->name;
    $emp_id = $_POST['emp_id'];
    $emp_name = $_POST['emp_name'];
    $loan_type = $_POST['loanType'];
    $loan_amount = $_POST['loanAmount'];
    $loan_date = $_POST['loanDate'];
   
    $loan_insert_query = "INSERT INTO `tbl_loan_application`(`emp_id`,`emp_name`, `loan_type`, `loan_amount`, `loan_date`,`loan_status`) VALUES ('$emp_id','$emp_name','$loan_type','$loan_amount','$loan_date','')";
    $success_query = mysqli_query($connection, $loan_insert_query);
    if ($success_query) {
        echo "data inserted successfully";
    }
}
?>