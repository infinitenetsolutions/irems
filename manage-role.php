<!-- Role Management -->
<?php 
    $page_no = 1;
    $page_no_inside = "1_1";
?>
<?php require_once("include/auth.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Role Management</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
    <style>
        .select2-container--default .select2-selection--single{
            height: calc(1.8125rem + 2px);
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini sidebar layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">
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
                            <h1 class="m-0 text-dark">Role Management</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Role Management</li>
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
                            <button id="import-button" type="button" class="import-button btn btn-sm btn-info mt-1 mb-1" data-toggle="modal" data-target="#import-modal" title="Import" disabled>
                                <i class="fa fa-upload fa-sm"></i> Import
                            </button>
                            <button id="export-button" type="button" class="export-button btn btn-sm btn-warning display-none mt-1 mb-1" data-toggle="modal" data-target="#export-modal" title="Export" disabled>
                                <i class="fa fa-download fa-sm"></i> Export
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
            <div class="modal-dialog modal-xl">
                <form id="addForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="roleUsername">Username</label>
                                                <input type="text" class="form-control form-control-sm" id="roleUsername" name="roleUsername" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="rolePassword">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control form-control-sm" id="rolePassword" name="rolePassword" placeholder="Password" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <button type="button" class="open-close btn btn-sm btn-danger" data-open-close="close">
                                                            <i class="fa fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="roleRePassword">Re Enter Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control form-control-sm" id="roleRePassword" name="roleRePassword" placeholder="Re Enter Password" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <button type="button" class="open-close btn btn-sm btn-danger" data-open-close="close">
                                                            <i class="fa fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="roleName">Name</label>
                                                <input type="text" class="form-control form-control-sm" id="roleName" name="roleName" placeholder="Name">
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="roleName">Select Employee</label>
                                                <select id="roleName" name="roleName" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="run(this);">
                                                    <option disabled selected>Select</option>
                                                    <?php 
                                                        $databaseObj->select("tbl_manage_employee");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            foreach($getData as $rows):
                                                                $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                                                ?>
                                                                <option value="<?= ucwords(strtolower($manage_employee_info->firstName." ".$manage_employee_info->lastName)) ?>" data-row-id="<?= $rows["manage_employee_id"] ?>" data-contact-number="<?= $manage_employee_info->mobile ?>" data-email="<?= $manage_employee_info->email ?>" data-gender="<?= $manage_employee_info->gender ?>" data-address="<?= $manage_employee_info->address1 ?>" data-project="<?= $manage_employee_info->project ?>"><?= ucwords(strtolower($manage_employee_info->firstName." ".$manage_employee_info->lastName)) ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="roleContactNumber">Contact Number</label>
                                                <input type="text" class="form-control form-control-sm" id="roleContactNumber" name="roleContactNumber" placeholder="Contact Number" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="roleEmail">Email</label>
                                                <input type="text" class="form-control form-control-sm" id="roleEmail" name="roleEmail" placeholder="Email" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="roleGender">Gender</label>
                                                <input type="hidden" class="form-control form-control-sm" id="roleGender" name="roleGender" placeholder="Gender" readonly>
                                                <input type="hidden" class="form-control form-control-sm" id="roleEmpId" name="roleEmpId" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="roleAddress">Address</label>
                                                <textarea class="form-control form-control-sm" id="roleAddress" name="roleAddress" placeholder="Address" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <!--  <div class="card card-navy">
                                <div class="card-header">
                                    <h3 class="card-title">Project</h3>
                                </div> -->
                                <!-- <div class="card-body"> 
                                   <div class="card"> -->
                                        
                                        <!-- <div class="card-body"> -->
<!--                                             <div class="row"> -->
<!--                                                <div class="col-md-6">
                                                  <div class="form-group">
                                                     <label for="projectName">Project</label>
                                                     <input type="text" class="form-control form-control-sm" id="projectName" name="projectName"  value="none" readonly>

                                                  </div>
                                               </div> -->
                                               <!-- <div class="col-md-3">
                                                  <div class="form-group">
                                                     <label for="commit_edit">Edit</label>
                                                     <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" id="commit_edit" name="commit_edit">
                                                        <option selected="" disabled="">Select Edit Status</option>
                                                        <option value="0">OFF </option>
                                                        <option value="1">ON </option>
                                                     </select>
                                                  </div>
                                               </div> -->

                                              <!--  <div class="col-md-3">
                                                  <div class="form-group">
                                                     <label for="commit_delete">Delete</label>
                                                     
                                                     <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" id="commit_delete" name="commit_delete">
                                                        <option selected="" disabled="">Select Delete Status</option>
                                                        <option value="0"> OFF </option>
                                                        <option value="1"> ON </option>

                                                     </select>
                                                  </div>
                                               </div> -->
                                              
                                           <!--  </div> -->
                                       <!--  </div> -->

                                    <!-- </div> -->
                            <div class="card card-navy">
                                <div class="card-header">
                                    <h3 class="card-title">Select Authentication</h3>
                                </div>
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-1" name="page_no_1">
                                                <input type="hidden" name="check_page_no_1" value="2">
                                                <label for="check-menu-1">
                                                    Set Up
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Role Management
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-1-1" name="page_no_1_1_auth">
                                                                        <label for="check-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-1-1" name="page_no_1_1_add">
                                                                        <label for="add-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-1-1" name="page_no_1_1_see">
                                                                        <label for="see-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-1-1" name="page_no_1_1_update">
                                                                        <label for="update-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-1-1" name="page_no_1_1_delete">
                                                                        <label for="delete-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-1-1" name="page_no_1_1_import">
                                                                        <label for="import-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-1-1" name="page_no_1_1_export">
                                                                        <label for="export-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-1-1" name="page_no_1_1_information">
                                                                        <label for="information-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Company Management
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-1-2" name="page_no_1_2_auth">
                                                                        <label for="check-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-1-2" name="page_no_1_2_add">
                                                                        <label for="add-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-1-2" name="page_no_1_2_see">
                                                                        <label for="see-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-1-2" name="page_no_1_2_update">
                                                                        <label for="update-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-1-2" name="page_no_1_2_delete">
                                                                        <label for="delete-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-1-2" name="page_no_1_2_import">
                                                                        <label for="import-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-1-2" name="page_no_1_2_export">
                                                                        <label for="export-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-1-2" name="page_no_1_2_information">
                                                                        <label for="information-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-2" name="page_no_2">
                                                <input type="hidden" name="check_page_no_2" value="5">
                                                <label for="check-menu-2">
                                                    Project Master
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Phase
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-2-1" name="page_no_2_1_auth">
                                                                        <label for="check-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-2-1" name="page_no_2_1_add">
                                                                        <label for="add-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-2-1" name="page_no_2_1_see">
                                                                        <label for="see-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-2-1" name="page_no_2_1_update">
                                                                        <label for="update-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-2-1" name="page_no_2_1_delete">
                                                                        <label for="delete-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-2-1" name="page_no_2_1_import">
                                                                        <label for="import-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-2-1" name="page_no_2_1_export">
                                                                        <label for="export-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-2-1" name="page_no_2_1_information">
                                                                        <label for="information-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Block
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-2-2" name="page_no_2_2_auth">
                                                                        <label for="check-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-2-2" name="page_no_2_2_add">
                                                                        <label for="add-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-2-2" name="page_no_2_2_see">
                                                                        <label for="see-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-2-2" name="page_no_2_2_update">
                                                                        <label for="update-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-2-2" name="page_no_2_2_delete">
                                                                        <label for="delete-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-2-2" name="page_no_2_2_import">
                                                                        <label for="import-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-2-2" name="page_no_2_2_export">
                                                                        <label for="export-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-2-2" name="page_no_2_2_information">
                                                                        <label for="information-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Property Type
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-2-3" name="page_no_2_3_auth">
                                                                        <label for="check-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-2-3" name="page_no_2_3_add">
                                                                        <label for="add-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-2-3" name="page_no_2_3_see">
                                                                        <label for="see-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-2-3" name="page_no_2_3_update">
                                                                        <label for="update-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-2-3" name="page_no_2_3_delete">
                                                                        <label for="delete-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-2-3" name="page_no_2_3_import">
                                                                        <label for="import-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-2-3" name="page_no_2_3_export">
                                                                        <label for="export-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-2-3" name="page_no_2_3_information">
                                                                        <label for="information-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>4. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Accommodation Type
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-2-4" name="page_no_2_4_auth">
                                                                        <label for="check-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-2-4" name="page_no_2_4_add">
                                                                        <label for="add-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-2-4" name="page_no_2_4_see">
                                                                        <label for="see-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-2-4" name="page_no_2_4_update">
                                                                        <label for="update-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-2-4" name="page_no_2_4_delete">
                                                                        <label for="delete-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-2-4" name="page_no_2_4_import">
                                                                        <label for="import-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-2-4" name="page_no_2_4_export">
                                                                        <label for="export-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-2-4" name="page_no_2_4_information">
                                                                        <label for="information-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>5. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Project
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-2-5" name="page_no_2_5_auth">
                                                                        <label for="check-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-2-5" name="page_no_2_5_add">
                                                                        <label for="add-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-2-5" name="page_no_2_5_see">
                                                                        <label for="see-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-2-5" name="page_no_2_5_update">
                                                                        <label for="update-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-2-5" name="page_no_2_5_delete">
                                                                        <label for="delete-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-2-5" name="page_no_2_5_import">
                                                                        <label for="import-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-2-5" name="page_no_2_5_export">
                                                                        <label for="export-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-2-5" name="page_no_2_5_information">
                                                                        <label for="information-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-3" name="page_no_3">
                                                <input type="hidden" name="check_page_no_3" value="3">
                                                <label for="check-menu-3">
                                                    Employee Management
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Manage Department
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-3-1" name="page_no_3_1_auth">
                                                                        <label for="check-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-3-1" name="page_no_3_1_add">
                                                                        <label for="add-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-3-1" name="page_no_3_1_see">
                                                                        <label for="see-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-3-1" name="page_no_3_1_update">
                                                                        <label for="update-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-3-1" name="page_no_3_1_delete">
                                                                        <label for="delete-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-3-1" name="page_no_3_1_import">
                                                                        <label for="import-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-3-1" name="page_no_3_1_export">
                                                                        <label for="export-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-3-1" name="page_no_3_1_information">
                                                                        <label for="information-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Manage Designation
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-3-2" name="page_no_3_2_auth">
                                                                        <label for="check-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-3-2" name="page_no_3_2_add">
                                                                        <label for="add-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-3-2" name="page_no_3_2_see">
                                                                        <label for="see-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-3-2" name="page_no_3_2_update">
                                                                        <label for="update-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-3-2" name="page_no_3_2_delete">
                                                                        <label for="delete-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-3-2" name="page_no_3_2_import">
                                                                        <label for="import-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-3-2" name="page_no_3_2_export">
                                                                        <label for="export-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-3-2" name="page_no_3_2_information">
                                                                        <label for="information-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Employee Management
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-3-3" name="page_no_3_3_auth">
                                                                        <label for="check-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-3-3" name="page_no_3_3_add">
                                                                        <label for="add-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-3-3" name="page_no_3_3_see">
                                                                        <label for="see-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-3-3" name="page_no_3_3_update">
                                                                        <label for="update-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-3-3" name="page_no_3_3_delete">
                                                                        <label for="delete-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-3-3" name="page_no_3_3_import">
                                                                        <label for="import-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-3-3" name="page_no_3_3_export">
                                                                        <label for="export-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-3-3" name="page_no_3_3_information">
                                                                        <label for="information-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-4" name="page_no_4">
                                                <input type="hidden" name="check_page_no_4" value="4">
                                                <label for="check-menu-4">
                                                    Purchase Management
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Suppliers/Vendors
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-4-1" name="page_no_4_1_auth">
                                                                        <label for="check-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-4-1" name="page_no_4_1_add">
                                                                        <label for="add-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-4-1" name="page_no_4_1_see">
                                                                        <label for="see-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-4-1" name="page_no_4_1_update">
                                                                        <label for="update-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-4-1" name="page_no_4_1_delete">
                                                                        <label for="delete-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-4-1" name="page_no_4_1_import">
                                                                        <label for="import-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-4-1" name="page_no_4_1_export">
                                                                        <label for="export-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-4-1" name="page_no_4_1_information">
                                                                        <label for="information-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Create PO
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-4-2" name="page_no_4_2_auth">
                                                                        <label for="check-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-4-2" name="page_no_4_2_add">
                                                                        <label for="add-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-4-2" name="page_no_4_2_see">
                                                                        <label for="see-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-4-2" name="page_no_4_2_update">
                                                                        <label for="update-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-4-2" name="page_no_4_2_delete">
                                                                        <label for="delete-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-4-2" name="page_no_4_2_import">
                                                                        <label for="import-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-4-2" name="page_no_4_2_export">
                                                                        <label for="export-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-4-2" name="page_no_4_2_information">
                                                                        <label for="information-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Manage PO
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-4-3" name="page_no_4_3_auth">
                                                                        <label for="check-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-4-3" name="page_no_4_3_add">
                                                                        <label for="add-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-4-3" name="page_no_4_3_see">
                                                                        <label for="see-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-4-3" name="page_no_4_3_update">
                                                                        <label for="update-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-4-3" name="page_no_4_3_delete">
                                                                        <label for="delete-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-4-3" name="page_no_4_3_import">
                                                                        <label for="import-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-4-3" name="page_no_4_3_export">
                                                                        <label for="export-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-4-3" name="page_no_4_3_information">
                                                                        <label for="information-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>4. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Receive Indent
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-4-4" name="page_no_4_4_auth">
                                                                        <label for="check-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-4-4" name="page_no_4_4_add">
                                                                        <label for="add-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-4-4" name="page_no_4_4_see">
                                                                        <label for="see-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-4-4" name="page_no_4_4_update">
                                                                        <label for="update-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-4-4" name="page_no_4_4_delete">
                                                                        <label for="delete-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-4-4" name="page_no_4_4_import">
                                                                        <label for="import-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-4-4" name="page_no_4_4_export">
                                                                        <label for="export-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-4-4" name="page_no_4_4_information">
                                                                        <label for="information-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-5" name="page_no_5">
                                                <input type="hidden" name="check_page_no_5" value="9">
                                                <label for="check-menu-5">
                                                    Inventory
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Create Indent
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-1" name="page_no_5_1_auth">
                                                                        <label for="check-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-1" name="page_no_5_1_add">
                                                                        <label for="add-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-1" name="page_no_5_1_see">
                                                                        <label for="see-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-1" name="page_no_5_1_update">
                                                                        <label for="update-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-1" name="page_no_5_1_delete">
                                                                        <label for="delete-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-1" name="page_no_5_1_import">
                                                                        <label for="import-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-1" name="page_no_5_1_export">
                                                                        <label for="export-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-1" name="page_no_5_1_information">
                                                                        <label for="information-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Item Category
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-2" name="page_no_5_2_auth">
                                                                        <label for="check-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-2" name="page_no_5_2_add">
                                                                        <label for="add-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-2" name="page_no_5_2_see">
                                                                        <label for="see-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-2" name="page_no_5_2_update">
                                                                        <label for="update-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-2" name="page_no_5_2_delete">
                                                                        <label for="delete-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-2" name="page_no_5_2_import">
                                                                        <label for="import-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-2" name="page_no_5_2_export">
                                                                        <label for="export-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-2" name="page_no_5_2_information">
                                                                        <label for="information-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Manage Items
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-3" name="page_no_5_3_auth">
                                                                        <label for="check-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-3" name="page_no_5_3_add">
                                                                        <label for="add-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-3" name="page_no_5_3_see">
                                                                        <label for="see-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-3" name="page_no_5_3_update">
                                                                        <label for="update-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-3" name="page_no_5_3_delete">
                                                                        <label for="delete-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-3" name="page_no_5_3_import">
                                                                        <label for="import-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-3" name="page_no_5_3_export">
                                                                        <label for="export-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-3" name="page_no_5_3_information">
                                                                        <label for="information-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>4. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Goods Receipt
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-4" name="page_no_5_4_auth">
                                                                        <label for="check-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-4" name="page_no_5_4_add">
                                                                        <label for="add-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-4" name="page_no_5_4_see">
                                                                        <label for="see-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-4" name="page_no_5_4_update">
                                                                        <label for="update-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-4" name="page_no_5_4_delete">
                                                                        <label for="delete-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-4" name="page_no_5_4_import">
                                                                        <label for="import-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-4" name="page_no_5_4_export">
                                                                        <label for="export-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-4" name="page_no_5_4_information">
                                                                        <label for="information-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>5. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Goods Issue & Return
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-5" name="page_no_5_5_auth">
                                                                        <label for="check-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-5" name="page_no_5_5_add">
                                                                        <label for="add-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-5" name="page_no_5_5_see">
                                                                        <label for="see-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-5" name="page_no_5_5_update">
                                                                        <label for="update-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-5" name="page_no_5_5_delete">
                                                                        <label for="delete-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-5" name="page_no_5_5_import">
                                                                        <label for="import-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-5" name="page_no_5_5_export">
                                                                        <label for="export-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-5" name="page_no_5_5_information">
                                                                        <label for="information-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>6. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Items Details
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-6" name="page_no_5_6_auth">
                                                                        <label for="check-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-6" name="page_no_5_6_add">
                                                                        <label for="add-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-6" name="page_no_5_6_see">
                                                                        <label for="see-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-6" name="page_no_5_6_update">
                                                                        <label for="update-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-6" name="page_no_5_6_delete">
                                                                        <label for="delete-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-6" name="page_no_5_6_import">
                                                                        <label for="import-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-6" name="page_no_5_6_export">
                                                                        <label for="export-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-6" name="page_no_5_6_information">
                                                                        <label for="information-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>7. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Inventory Reports
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-7" name="page_no_5_7_auth">
                                                                        <label for="check-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-7" name="page_no_5_7_add">
                                                                        <label for="add-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-7" name="page_no_5_7_see">
                                                                        <label for="see-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-7" name="page_no_5_7_update">
                                                                        <label for="update-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-7" name="page_no_5_7_delete">
                                                                        <label for="delete-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-7" name="page_no_5_7_import">
                                                                        <label for="import-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-7" name="page_no_5_7_export">
                                                                        <label for="export-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-7" name="page_no_5_7_information">
                                                                        <label for="information-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>8. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        My Store
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-8" name="page_no_5_8_auth">
                                                                        <label for="check-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-8" name="page_no_5_8_add">
                                                                        <label for="add-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-8" name="page_no_5_8_see">
                                                                        <label for="see-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-8" name="page_no_5_8_update">
                                                                        <label for="update-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-8" name="page_no_5_8_delete">
                                                                        <label for="delete-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-8" name="page_no_5_8_import">
                                                                        <label for="import-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-8" name="page_no_5_8_export">
                                                                        <label for="export-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-8" name="page_no_5_8_information">
                                                                        <label for="information-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td>9. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Stores
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-5-9" name="page_no_5_9_auth">
                                                                        <label for="check-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-5-9" name="page_no_5_9_add">
                                                                        <label for="add-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-5-9" name="page_no_5_9_see">
                                                                        <label for="see-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-5-9" name="page_no_5_9_update">
                                                                        <label for="update-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-5-9" name="page_no_5_9_delete">
                                                                        <label for="delete-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-5-9" name="page_no_5_9_import">
                                                                        <label for="import-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-5-9" name="page_no_5_9_export">
                                                                        <label for="export-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-5-9" name="page_no_5_9_information">
                                                                        <label for="information-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-6" name="page_no_6">
                                                <input type="hidden" name="check_page_no_6" value="5">
                                                <label for="check-menu-6">
                                                    Work Flow Master
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Main Work
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-6-1" name="page_no_6_1_auth">
                                                                        <label for="check-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-6-1" name="page_no_6_1_add">
                                                                        <label for="add-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-6-1" name="page_no_6_1_see">
                                                                        <label for="see-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-6-1" name="page_no_6_1_update">
                                                                        <label for="update-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-6-1" name="page_no_6_1_delete">
                                                                        <label for="delete-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-6-1" name="page_no_6_1_import">
                                                                        <label for="import-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-6-1" name="page_no_6_1_export">
                                                                        <label for="export-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-6-1" name="page_no_6_1_information">
                                                                        <label for="information-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Work
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-6-2" name="page_no_6_2_auth">
                                                                        <label for="check-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-6-2" name="page_no_6_2_add">
                                                                        <label for="add-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-6-2" name="page_no_6_2_see">
                                                                        <label for="see-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-6-2" name="page_no_6_2_update">
                                                                        <label for="update-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-6-2" name="page_no_6_2_delete">
                                                                        <label for="delete-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-6-2" name="page_no_6_2_import">
                                                                        <label for="import-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-6-2" name="page_no_6_2_export">
                                                                        <label for="export-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-6-2" name="page_no_6_2_information">
                                                                        <label for="information-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Items
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-6-3" name="page_no_6_3_auth">
                                                                        <label for="check-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-6-3" name="page_no_6_3_add">
                                                                        <label for="add-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-6-3" name="page_no_6_3_see">
                                                                        <label for="see-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-6-3" name="page_no_6_3_update">
                                                                        <label for="update-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-6-3" name="page_no_6_3_delete">
                                                                        <label for="delete-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-6-3" name="page_no_6_3_import">
                                                                        <label for="import-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-6-3" name="page_no_6_3_export">
                                                                        <label for="export-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-6-3" name="page_no_6_3_information">
                                                                        <label for="information-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>4. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Unit
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-6-4" name="page_no_6_4_auth">
                                                                        <label for="check-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-6-4" name="page_no_6_4_add">
                                                                        <label for="add-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-6-4" name="page_no_6_4_see">
                                                                        <label for="see-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-6-4" name="page_no_6_4_update">
                                                                        <label for="update-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-6-4" name="page_no_6_4_delete">
                                                                        <label for="delete-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-6-4" name="page_no_6_4_import">
                                                                        <label for="import-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-6-4" name="page_no_6_4_export">
                                                                        <label for="export-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-6-4" name="page_no_6_4_information">
                                                                        <label for="information-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>5. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Work Flow
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-6-5" name="page_no_6_5_auth">
                                                                        <label for="check-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-6-5" name="page_no_6_5_add">
                                                                        <label for="add-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-6-5" name="page_no_6_5_see">
                                                                        <label for="see-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-6-5" name="page_no_6_5_update">
                                                                        <label for="update-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-6-5" name="page_no_6_5_delete">
                                                                        <label for="delete-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-6-5" name="page_no_6_5_import">
                                                                        <label for="import-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-6-5" name="page_no_6_5_export">
                                                                        <label for="export-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-6-5" name="page_no_6_5_information">
                                                                        <label for="information-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-7" name="page_no_7">
                                                <input type="hidden" name="check_page_no_7" value="3">
                                                <label for="check-menu-7">
                                                    Customer Management
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Customers
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-7-1" name="page_no_7_1_auth">
                                                                        <label for="check-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-7-1" name="page_no_7_1_add">
                                                                        <label for="add-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-7-1" name="page_no_7_1_see">
                                                                        <label for="see-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-7-1" name="page_no_7_1_update">
                                                                        <label for="update-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-7-1" name="page_no_7_1_delete">
                                                                        <label for="delete-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-7-1" name="page_no_7_1_import">
                                                                        <label for="import-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-7-1" name="page_no_7_1_export">
                                                                        <label for="export-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-7-1" name="page_no_7_1_information">
                                                                        <label for="information-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Complaints
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-7-2" name="page_no_7_2_auth">
                                                                        <label for="check-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-7-2" name="page_no_7_2_add">
                                                                        <label for="add-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-7-2" name="page_no_7_2_see">
                                                                        <label for="see-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-7-2" name="page_no_7_2_update">
                                                                        <label for="update-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-7-2" name="page_no_7_2_delete">
                                                                        <label for="delete-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-7-2" name="page_no_7_2_import">
                                                                        <label for="import-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-7-2" name="page_no_7_2_export">
                                                                        <label for="export-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-7-2" name="page_no_7_2_information">
                                                                        <label for="information-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Services
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-7-3" name="page_no_7_3_auth">
                                                                        <label for="check-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-7-3" name="page_no_7_3_add">
                                                                        <label for="add-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-7-3" name="page_no_7_3_see">
                                                                        <label for="see-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-7-3" name="page_no_7_3_update">
                                                                        <label for="update-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-7-3" name="page_no_7_3_delete">
                                                                        <label for="delete-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-7-3" name="page_no_7_3_import">
                                                                        <label for="import-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-7-3" name="page_no_7_3_export">
                                                                        <label for="export-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-7-3" name="page_no_7_3_information">
                                                                        <label for="information-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-8" name="page_no_8">
                                                <input type="hidden" name="check_page_no_8" value="3">
                                                <label for="check-menu-8">
                                                    Land Aquisition
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Land Aquisition UOM
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-8-1" name="page_no_8_1_auth">
                                                                        <label for="check-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-8-1" name="page_no_8_1_add">
                                                                        <label for="add-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-8-1" name="page_no_8_1_see">
                                                                        <label for="see-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-8-1" name="page_no_8_1_update">
                                                                        <label for="update-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-8-1" name="page_no_8_1_delete">
                                                                        <label for="delete-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-8-1" name="page_no_8_1_import">
                                                                        <label for="import-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-8-1" name="page_no_8_1_export">
                                                                        <label for="export-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-8-1" name="page_no_8_1_information">
                                                                        <label for="information-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Land Aquisition Owners
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-8-2" name="page_no_8_2_auth">
                                                                        <label for="check-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-8-2" name="page_no_8_2_add">
                                                                        <label for="add-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-8-2" name="page_no_8_2_see">
                                                                        <label for="see-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-8-2" name="page_no_8_2_update">
                                                                        <label for="update-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-8-2" name="page_no_8_2_delete">
                                                                        <label for="delete-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-8-2" name="page_no_8_2_import">
                                                                        <label for="import-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-8-2" name="page_no_8_2_export">
                                                                        <label for="export-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-8-2" name="page_no_8_2_information">
                                                                        <label for="information-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Lands
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-8-3" name="page_no_8_3_auth">
                                                                        <label for="check-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-8-3" name="page_no_8_3_add">
                                                                        <label for="add-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-8-3" name="page_no_8_3_see">
                                                                        <label for="see-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-8-3" name="page_no_8_3_update">
                                                                        <label for="update-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-8-3" name="page_no_8_3_delete">
                                                                        <label for="delete-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-8-3" name="page_no_8_3_import">
                                                                        <label for="import-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-8-3" name="page_no_8_3_export">
                                                                        <label for="export-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-8-3" name="page_no_8_3_information">
                                                                        <label for="information-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-9" name="page_no_9">
                                                <input type="hidden" name="check_page_no_9" value="2">
                                                <label for="check-menu-9">
                                                    Admin Profile/Settings
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <th>Add</th>
                                                                <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Profile
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-9-1" name="page_no_9_1_auth">
                                                                        <label for="check-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-9-1" name="page_no_9_1_add">
                                                                        <label for="add-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-9-1" name="page_no_9_1_see">
                                                                        <label for="see-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-9-1" name="page_no_9_1_update">
                                                                        <label for="update-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-9-1" name="page_no_9_1_delete">
                                                                        <label for="delete-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-9-1" name="page_no_9_1_import">
                                                                        <label for="import-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-9-1" name="page_no_9_1_export">
                                                                        <label for="export-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-9-1" name="page_no_9_1_information">
                                                                        <label for="information-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Settings
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-9-2" name="page_no_9_2_auth">
                                                                        <label for="check-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-9-2" name="page_no_9_2_add">
                                                                        <label for="add-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="see-menu-9-2" name="page_no_9_2_see">
                                                                        <label for="see-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="update-menu-9-2" name="page_no_9_2_update">
                                                                        <label for="update-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="delete-menu-9-2" name="page_no_9_2_delete">
                                                                        <label for="delete-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="import-menu-9-2" name="page_no_9_2_import">
                                                                        <label for="import-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="export-menu-9-2" name="page_no_9_2_export">
                                                                        <label for="export-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="information-menu-9-2" name="page_no_9_2_information">
                                                                        <label for="information-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                              
                                                              
                                                              
                                                              
                                                            </tr>
                                                          
                                                          
                                                          
                                                          
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                 <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="check-menu-10" name="page_no_10">
                                                <input type="hidden" name="check_page_no_10" value="2">
                                                <label for="check-menu-10">
                                                   CRM
                                                </label>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand text-navy"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus text-navy"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <!--<th>Add</th>-->
                                                               <!--  <th>View</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                                <th>Import</th>
                                                                <th>Export</th>
                                                                <th>Information</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Advertisement
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="check-menu-10-1" name="page_no_10_1_auth">
                                                                        <label for="check-menu-10-1"></label>
                                                                    </div>
                                                                </td>
                                                               <!-- <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="add-menu-10-1" name="page_no_10_1_add">
                                                                        <label for="add-menu-10-1"></label>
                                                                    </div>
                                                                </td>-->
                                                              
                                                            </tr>
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                  
                                  
                                  
                                  
                                  
                                  
                                  
                                  
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="addButton" class="add-button btn btn-success btn-sm"><i class="fa fa-plus fa-sm"></i> Add this</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add New Section End -->
        <!-- Add New Section Start -->
        <div class="modal fade" id="import-modal">
            <div class="modal-dialog modal-md">
                <form id="importForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Import Excel</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="importedExcel">Choose An Excel</label>
                                                <input type="file" class="form-control" id="importedExcel" name="importedExcel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                <small class="text-red text-sm">Before importing please check the excel format</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="importedExcel">See Format</label>
                                            <a href="assets/admin/manage-role/default.xlsx" target="_blank" class="btn btn-warning btn-md btn-block"><i class="fa fa-eye fa-sm"></i> Format</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="importButton" class="import-button btn btn-info btn-sm"><i class="fa fa-upload fa-sm"></i> Import this</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add New Section End -->
        <!-- Information Section Start -->
        <div class="modal fade" id="information-modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Information</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body" id="information-section"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Information Section End -->
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
            <div class="modal-dialog modal-xl">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit This</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-section"></div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="editButton" class="edit-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Section End -->
        <!-- Export Selected Section Start -->
        <div class="modal fade" id="export-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Are you sure?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning alert-dismissible">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Confirm!</h5>
                            Do you really wanna Export selected data in excel???
                        </div>
                        <div id="export-section"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                        <button type="submit" id="exportSelectedButton" class="export-button btn btn-info btn-sm"><i class="fas fa-download fa-sm"></i> Export Selected</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Export Selected Section End -->
        <!-- Delete Section Start -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-sm">
                <form id="deleteForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="delete-section"></div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="deleteButton" class="delete-button btn btn-warning btn-sm"><i class="fas fa-trash fa-sm"></i> Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Delete Section End -->
        <!-- Delete Selected Section Start -->
        <div class="modal fade" id="delete-selected-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Are you sure?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            Do you really wanna delete selected data???
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                        <button type="submit" id="deleteSelectedButton" class="delete-button btn btn-warning btn-sm"><i class="fas fa-trash fa-sm"></i> Delete Selected</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Selected Section End -->
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
    <script src="dist/js/admin/manage-role.js"></script>
    <!-- Js Section End -->
</body>

</html>