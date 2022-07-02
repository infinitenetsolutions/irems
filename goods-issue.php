<!--Goods Issue -->
<?php  $page_no = "5"; $page_no_inside = "5_5";
?>
<?php require_once("include/auth.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Goods Issue Note(GIN)</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">
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
                            <h1 class="m-0 text-dark"></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Goods Issue Note(GIN)</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Main content -->
            <section class="content">
                <div class="card card-navy card-outline">
                    <div class="card-header">
                        <h3>Goods Issue Note(GIN)</h3>
                        <h3 class="card-title float-right">
                            <button id="refresh-button" type="button" class="refresh-button btn btn-sm btn-danger mt-1 mb-1" title="Refresh" disabled>
                                <i class="fas fa-sync-alt fa-sm"></i>
                            </button>
                            <button id="add-button" type="button" class="add-button btn btn-sm btn-success mt-1 mb-1" data-toggle="modal" data-target="#add-modal" title="Add New" disabled>
                                <i class="fa fa-plus fa-sm"></i> Add New
                            </button>
                            <!--
                            <button id="import-button" type="button" class="import-button btn btn-sm btn-info mt-1 mb-1" data-toggle="modal" data-target="#import-modal" title="Import" disabled>
                                <i class="fa fa-upload fa-sm"></i> Import
                            </button>
                            <button id="export-button" type="button" class="export-button btn btn-sm btn-warning display-none mt-1 mb-1" data-toggle="modal" data-target="#export-modal" title="Export" disabled>
                                <i class="fa fa-download fa-sm"></i> Export
                            </button>
-->
                            <button id="delete-button" type="button" class="delete-button btn btn-sm btn-danger display-none mt-1 mb-1" data-toggle="modal" data-target="#delete-selected-modal" title="Delete" disabled>
                                <i class="fa fa-trash fa-sm"></i> Delete
                            </button>
                        </h3>
                    </div>
                    <div class="card-body table-responsive" id="view-section"></div>
                </div>
            </section>
            <!-- /.content -->
            <!-- Main content -->
            <section class="content">
                <div class="card card-navy card-outline">
                    <div class="card-body table-responsive" id="view-sectionn"></div>
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
                            <h6 class="modal-title">Goods Issue Note(GIN)-</h6>
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
                                                <label for="ginNo">GIN No</label>
                                                <?php
                                                    $databaseObj->select("tbl_goods_issue");
                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                    $getData = $databaseObj->get();
                                                    $issueNo = 1;
                                                    foreach ($getData as $rows) {
                                                      $issueNo = $rows["goods_issue_id"]+1;
                                                    }
                                                ?>
                                                <input class="form-control" name="ginNo" id="ginNo" type="text" value="<?php echo $issueNo; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ginDate">GIN Date</label>
                                                <input type="text" class="form-control" id="ginDate" name="ginDate" placeholder="GIN Date" value="<?php
                                                echo date('d/m/Y');?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-navy">
                                <div class="card-body">
                                    <h6><b><u>Issue To:</u></b></h6>
                                    <div class="row">
                                       
                                               
                                                <?php 
                       
                                                    $databaseObj->select("tbl_admin");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                                                    $databaseObj->order_by("`admin_id` DESC");
                                                    $getData = $databaseObj->get(); 

                                                    //Checking If Data Is Available
                                                    if($getData != 0):
                                                        $sno = 1;
                                                            foreach($getData as $rows):
                                                                $admin_info = json_decode($rows["admin_info"]);

                                                                $admin_log = json_decode($rows["admin_log"]);
                                                               
                                                                $databaseObj->select("tbl_manage_employee");
                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                                                $getData = $databaseObj->get();
                                                                //Checking If Data Is Available
                                                                if($getData != 0):
                                                                    $sno = 1;
                                                                  foreach($getData as $rows):
                                                                    $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                                                    ?>
                                                                     <div class="col-md-6">
                                                                       <div class="form-group form-group-smform-group-sm">
                                                                        <?php
                                                                  

                                                                      if ($manage_employee_info->project == "")
                                                                       {
                                                                      
                                                                        // echo("1");
                                                                          ?>


                                                                           <label for="project">Project Name</label>
                                                                           <select id="project" name="project" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" required>
                                                                            <!-- <option value="">Select Project</option> -->
                                                                            <?php 
                                                                            $databaseObj->select("tbl_projects");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                             $getData = $databaseObj->get();
                                                                            //Checking If Data Is Available
                                                                            if($getData != 0):
                                                                               $sno = 1;
                                                                                foreach($getData as $rows):
                                                                                   $projects_info = json_decode($rows["projects_info"]);
                                                                                         ?>

                                                                                    <option value="<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?></option>
                                                                                    <?php
                                                                               endforeach;
                                                                             endif;
                                                                            ?>
                                                                            </select>
                                                                            <?php
                                                                        }
                                                                       
                                                                       else
                                                                       {
                                                                        


                                                                               // echo "aaaaa";
                                                                           
                                                                       
                                                                              $databaseObj->select("tbl_projects");
                                                                              $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id`='".$manage_employee_info->project."'");
                                                                              $getData = $databaseObj->get();
                                                                              //Checking If Data Is Available
                                                                               if($getData != 0):
                                                                                 $sno = 1;
                                                                                 foreach($getData as $rows):
                                                                                  $projects_info = json_decode($rows["projects_info"]);    
                                                                                      
                                                                                   ?>   
                                                                                   <label for="project">Project Name</label>
                                                                                    <input class="form-control form-control-sm"  type="text" value="<?= $projects_info->projectName ?>" readonly >
                                                                                    <input class="form-control form-control-sm" name="project" id="project" type="hidden" value="<?= $rows["projects_id"] ?>" readonly>
                                                                                     <?php
                                                                                 endforeach;
                                                                               endif;
                                                                        }
                                                                     
                                                                    endforeach;
                                                                endif;
                                                            endforeach;
                                                    endif;
                                                ?>
                                            </div>
                                        </div>

                                       <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectLocation">Project Location</label>
                                                <input type="text" id="projectLocation" name="projectLocation" class="form-control form-control-sm"   value="<?= $projects_info->projectLocation ?>"readonly>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="property">Property</label>
                                                <select id="property" name="property" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">

                                                </select>
                                            </div>
                                        </div> -->
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="issueTo">Issue To</label>
                                                <select id="issueTo" name="issueTo" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" required>
                                                <!-- <option value="">Select Project</option> -->
                                                <?php 
                                                    $databaseObj->select("tbl_manage_employee");
                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                    $getData = $databaseObj->get();
                                                    //Checking If Data Is Available
                                                    if($getData != 0):
                                                        $sno = 1;
                                                        foreach($getData as $rows):
                                                            $manage_employee_info = json_decode($rows["manage_employee_info"]);?>

                                                            <option value="<?= $rows["manage_employee_id"] ?>"><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?></option><?php
                                                                endforeach;
                                                                endif;?>
                                                </select>
                                                <!-- <input type="text" class="form-control form-control-sm"  id="issueTo" name="issueTo" placeholder="Issue To"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="issueBy">Issue By</label>
                                                <input type="text" class="form-control form-control-sm"  id="issueBy" name="issueBy" placeholder="Issue By" value="<?= $auth->admin_info->name?> " readonly required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inventoryType">Inventory Type</label>
                                                <select class="form-control" name="inventoryType" id="inventoryType" placeholder="Inventory Type" required>
                                                    <option>Select</option>
                                                    <option>Returnable Good</option>
                                                    <option>Non-Returnable Good</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-navy">
                                <div class="card-body">
                                      <?php
                                       $cnt = 1;
                                         ?>
                                    <h6><b><u>Issue Items:</u></b></h6>
                                   <!--  <h6><b><u> (NOTE: The Items which are not required to be issued please mention "0" in their respective Quantity field)</u></b></h6> -->
                                        <div class="col-md-12">
                                           <div id="manage_items">
                                              <div id="manage_items1">       
                                              </div>
                                            </div>
                                        </div> 
                                        <?php
                                         $databaseObj->select("tbl_admin");
                                         $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                                         $databaseObj->order_by("`admin_id` DESC");
                                         $getData = $databaseObj->get(); 
                                         
                                            //Checking If Data Is Available
                                            if($getData != 0):
                                                $sno = 1;
                                                foreach($getData as $rows):
                                                  $admin_info = json_decode($rows["admin_info"]);
                                                  $admin_log = json_decode($rows["admin_log"]);
                                                                   
                                                  $databaseObj->select("tbl_manage_employee");
                                                  $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                                  $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                        $sno = 1;
                                                                      foreach($getData as $rows):
                                                                        $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                                                       endforeach;
                                                                    endif;
                                                 endforeach;
                                            endif;

                                                                    
                                                                    $databaseObj->select("tbl_manage_stock");

                                                                     $databaseObj->where("`status` = '".$auth->visible()."'");

                                                                     $databaseObj->order_by("`manage_stock_id` DESC");

                                                                     $getData = $databaseObj->get();
                                                                    
                                                                    
                                                                       ?>
                                                                     <div id="divitemDetails" class="col-md-12">
                                                                    <div class="row">
                                                                      <div class="table-responsive">
                                                                          <table class="table table-bordered" id="dynamic_field">
                                                                              <thead>
                                                                                  <tr>
                                                                                      <th width="7%">S.No.</th>
                                                                                      <th width="11%">Item Code </th>
                                                                                      <th width="34%">Item Name</th>
                                                                                      <th width="11%">UOM</th>
                                                                                      <th>Existing Quantity</th>
                                                                                      <th>Quantity to be Issued</th>
                                                                                      <th>Remarks</th>
                                                                                       <th>Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th>
                                                                                      <!-- <th data-field="Remarks" data-sortable="true">Remarks</th> -->
                                                                                   
                                                                                  </tr>
                                                                              </thead>
                                                                              <tbody>
                                                                                <?php
                                                                                 $databaseObj->select("tbl_manage_stock");

                                                                                 $databaseObj->where("`status` = '".$auth->visible()."'");

                                                                                  $databaseObj->order_by("`manage_stock_id` DESC");

                                                                                 $getData = $databaseObj->get();
                                                                    
                                                                               
                                                                                 foreach($getData as $rowstock):
                                                                                 endforeach;
                                                                                   

                                                                                  
                                                                                    if(isset($rowstock["project"]))
                                                                                  
                                                                                   
                                                                                   
                                                                                    if($rowstock["project"] == $manage_employee_info->project)
                                                                                {

                                                                                   
                                                                                       // $manage_po_item_info = json_decode($rowpo["manage_po_item_info"]);
                                                                                      
                                                                               ?>
                                                                                  
                                                                                          <?php
                                                                                            // $cnt++; 
                                                                                            
                                                                            }
                                                                            else {}
                                                                                            // endforeach;
                                                                                           // endforeach;
                                                                                           // endif
                                                                                           ?>

                                                                                
                                                                              </tbody>
                                                                          </table>
                                                                         
                                                                      </div>
                                                                    </div> 
                                                            </div>        
                                        
                                   

                                       <!--  </div>
                                    </div>---->
                                    
                                </div> 
                            </div>
                            <div class="card card-navy">
                                <div class="card-body">
                                    <h6><b><u>Description:</u></b></h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea width="600" name="description" id="description" class="form-control"  required></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="$cnt" id="totalItem" name="totalItem" />
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                             <a href="#" id="printBtnLink" target="_blank"><button type="button" id="printButton" class="print-button btn btn-warning btn-sm" disabled>Print Goods Issued</button> </a>
                            <button type="submit" id="addButton"  class="add-button btn btn-success btn-sm"><i class="fa fa-plus fa-sm"></i> Add this</button>
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
                                            <a href="assets/admin/projects/default.xlsx" target="_blank" class="btn btn-warning btn-md btn-block"><i class="fa fa-eye fa-sm"></i> Format</a>
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
    <script src="dist/js/admin/goods-issue.js"></script>
    <script>
                                                  
                    function onSelection(id, val)
                        {
                            var code_id = "item_code[" +id+ "]";
                            var name_id = "item_name[" +id+ "]";
                            var uom_id =  "uom[" +id+ "]";
                            $.ajax({
                                   url: 'getinformationsmanageitem.php',
                                   type: 'POST',
                                   data: {"item_code": val,"project": $("#project").val()},
                                   success: function(result) {
                                    
                                       document.getElementById("tonne_id1[" +id+ "][tonne]").value = result;
                                   }
                               });
                               event.preventDefault();
                            document.getElementById(code_id).value = val;
                            document.getElementById(name_id).value = val;
                            document.getElementById(uom_id).value =  val;
                            
                           
                        }
                    


                                                 $(document).ready(function() {
                                                 
                                             var i=<?php echo $cnt; ?>;

                                            $('#add').click(function(){ <?php require_once("include/js.php"); ?>

   


                     $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><input type="text" id="slno'+i+'" value="'+i+'" readonly class="form-control" style="border:none;" /></td><td>' +'<select id="item_code[' + i + ']" name="item_code[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy"onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"> <?php $databaseObj->select("tbl_manage_stock"); $databaseObj->where("`status` = '".$auth->visible()."'&& `project`='".$manage_employee_info->project."'"); $getData = $databaseObj->get();foreach($getData as $rowstocks): $item_Code = $rowstocks["itemCode"];$item_Name = $rowstocks["itemName"]; $Uom = $rowstocks["Uom"];$Qty = $rowstocks["Qty"];$databaseObj->select("tbl_manage_item");$databaseObj->where("`status` = '".$auth->visible()."'&& `manage_item_id`='". $item_Code."'");$getDataitem = $databaseObj->get(); foreach($getDataitem as $rowsitem):?><option value="<?= $rowsitem["manage_item_id"] ?>" <?php if($item_Code == $rowsitem["manage_item_id"]) echo "selected" ?>><?= $rowsitem["itemCode"] ?></option><?php endforeach; endforeach;?></select></td><td>' +'<select id="item_name[' + i + ']" name="item_name[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_stock"); $databaseObj->where("`status` = '".$auth->visible()."'&& `project`='".$manage_employee_info->project."'"); $getData = $databaseObj->get();foreach($getData as $rowstocks): $item_Name = $rowstocks["itemName"];  $databaseObj->select("tbl_manage_item");$databaseObj->where("`status` = '".$auth->visible()."'&& `manage_item_id`='". $item_Name."'");$getDataitem = $databaseObj->get(); foreach($getDataitem as $rowsitem): ?><option value="<?= $rowsitem["manage_item_id"] ?>" <?php if($item_Name == $rowsitem["manage_item_id"]) echo "selected" ?>><?= $rowsitem["itemName"] ?></option><?php endforeach;endforeach;?></select></td><td>' +'<select id="uom[' + i + ']" name="uom[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);" readonly<?php $databaseObj->select("tbl_manage_item"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getDataPro = $databaseObj->get(); foreach($getDataPro as $rowsPro):?><option value="<?= $rowsPro["manage_item_id"] ?>"<?php if($Uom == $rowsPro["manage_item_id"])echo "selected" ?>><?= $rowsPro["Uom"] ?> </option>  <?php endforeach;?></select></td><?php $databaseObj->select("tbl_manage_stock"); $databaseObj->where("`status` = '".$auth->visible()."'&& `project`='".$manage_employee_info->project."'"); $getData = $databaseObj->get();foreach($getData as $rowstocks): $Qty = $rowstocks["Qty"]; endforeach?><td><input type="text" name="quantity1[]" placeholder="" id="tonne_id1['+i+'][tonne]" class="form-control" value="<?= $Qty ?>"readonly/></td><td><input type="number" name="tonne_id[]" placeholder="" id="tonne_id['+i+'][tonne]" class="form-control" /></td><td><input type="text" name="remark[]"  placeholder="" id="remark_id['+i+'][remark]"  class="form-control" required/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                     i++;
                 });

                 $(document).on('click', '.btn_remove', function(){
                      var button_id = $(this).attr("id");
                      $('#row'+button_id+'').remove(); 
                      i--;
                 });
                
                   });
                    
                
   <?php require_once("include/js.php"); ?>
                
                
                   </script>  
                                         
    <?php
        if(isset($_GET["response"])):
            if($_GET["response"] == "success"):
               
                echo "<script>
                        setTimeout(function(){
                            topEndNotification('success', 'Good return successfully!!!');
                        }, 3000);
                      </script>";
            endif;
        endif;
    ?>
    

    <script src="dist/js/ajax.js"></script>
</body>

</html>
