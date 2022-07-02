<?php
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");
    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $defaultLogo = "assets/dp/default.png";
    $randSix = $auth->randSix();
    $authority = 1;
    $manageItemStoreDir = "../../../assets/admin/manage-items/";
    $manageItemDir = "assets/admin/manage-items/";
    $manageCompanyStoreDir = "assets/admin/manage-company/";

    $manageCompanyDir = "assets/admin/manage-company/";

    if(isset($_POST["action"])):
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Fetch Data Section Start ---------
            // -----------------------------------------------
            case "fetchData":
                ?>
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/manage-po.php">
                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_po">
                          <input type="hidden" id="action" name="action" value="exportSelectedData">
                            <input type="hidden" id="secondaryLocation" name="checkLocation" />
                              <input type="hidden" id="secondaryIp" name="checkIp" />
                            <table id="example1" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" id="check-all" name="check-all" title="Check All" value="all">
                                                <label for="check-all" title="Check All">
                                                </label>
                                            </div>
                                        </th>

                                        <th>S. No.</th>
                                        <th>PO No.</th>
                                        <th>Project</th>
                                        <th>PO Date</th>
                                        <th>Supplier Name</th>
                                        <!-- <th>Indent Created</th>
                                        <th>Indent Approved</th> -->



                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $databaseObj->select("tbl_manage_po");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $databaseObj->order_by("`manage_po_id` DESC");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                                $manage_po_info = json_decode($rows["manage_po_info"]);
        //                                                echo json_last_error_msg();
        //                                                print_r($manage_po_info);
        //                                                exit;
                                                        $manage_po_log = json_decode($rows["manage_po_log"]);
                                                        ?>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <div class="icheck-navy d-inline">

                                                                                <input type="checkbox" id="checkbox-<?= $rows["manage_po_id"] ?>" name="checkbox-select[]" value="<?= $rows["manage_po_id"] ?>" class="check-table">
                                                                                <label for="checkbox-<?= $rows["manage_po_id"] ?>">
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td><?= $sno ?>.</td>
                                                                         
                                                                        <td><?= $manage_po_info->orderNo ?></td>
                                                                       
                                                                         <?php
                                                                         $databaseObj->select("tbl_projects");
                                                                         $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_po_info->project."'");
                                                                         $databaseObj->order_by("`projects_id` DESC");
                                                                         $getData = $databaseObj->get();
                                                                          //Checking If Data Is Available
                                                                         if($getData != 0):
                                                                         
                                                                          foreach($getData as $rowproject):
                                                                            $projects_info = json_decode($rowproject["projects_info"]);
                                                                          endforeach;
                                                                         endif;
                                                                       ?>
                                                                         <td><?= $projects_info->projectName ?></td>
                                                                        <td><?= $manage_po_info->poDate ?></td>
                                                                        <?php
                                                                        $databaseObj->select("tbl_manage_supplier");
                                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$manage_po_info->vendor_name."'");
                                                                        $getData = $databaseObj->get();
                                                                        if($getData != 0):
                                                                         foreach($getData as $rows_supplier):
                                                                           $manage_supplier_info = json_decode($rows_supplier["manage_supplier_info"]);
                                                                         endforeach;
                                                                        endif;
                                                                        ?>

                                                                       <td><?= $manage_supplier_info->supplierName ?></td>
                                                                      <!--  <?php
                                                                        $databaseObj->select("tbl_manage_indent");
                                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$manage_po_info->requisition_no."'");
                                                                        $getData = $databaseObj->get();
                                                                        if($getData != 0):
                                                                         foreach($getData as $rows_ind):
                                                                           $manage_indent_info = json_decode($rows_ind["manage_indent_info"]);

                                                                           $databaseObj->select("tbl_manage_employee");
                                                                           $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$manage_indent_info->indentCreated."'");
                                                                           $getData = $databaseObj->get();
                                                                           if($getData != 0):
                                                                            foreach($getData as $rows_empl):
                                                                               $manage_employee_info = json_decode($rows_empl["manage_employee_info"]);
                                                                            endforeach;
                                                                           endif;?>
                                                                       
                                                                        

                                                                            <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?></td>
                                                                           <?php
                                                                           $databaseObj->select("tbl_manage_employee");
                                                                           $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$manage_indent_info->employee_approval."'");
                                                                           $getData = $databaseObj->get();
                                                                            if($getData != 0):
                                                                              foreach($getData as $rows_emplo):
                                                                                $manage_employee_info = json_decode($rows_emplo["manage_employee_info"]);
                                                                              endforeach;
                                                                            endif; 
                                                                          endforeach;
                                                                        endif;?>
                                                                        
                                                                       <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?></td> -->
                                                                       
                                                                  

                                                                     
                                                                        <td class="text-center">
                                                                            <button type="button" id="information-button-<?= $rows["manage_po_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Information">
                                                                                <i class="fa fa-scroll fa-sm"></i>
                                                                            </button>
                                                                            <?php //if (empty($rows["manage_po_receipt"])): ?>
                <!--                                                              <a href="#">-->
                                                                              <button type="button" id="edit-button-<?= $rows["manage_po_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                                                                  <i class="fa fa-edit fa-sm"></i>
                                                                              </button>
                <!--                                                              </a>-->
                                                                            <?php //endif; ?>
                                                                            

                                                                           <button type="button" id="pay-button-<?= $rows["manage_po_id"] ?>" class="pay-button btn btn-xs btn-info mt-1 mb-1" title="Paid Status">
                                                                               <i class="fas fa-money-check-alt fa-sm"></i>
                                                                            </button>
                                                                            
                                                                            
                                                                            <button type="button" id="delete-button-<?= $rows["manage_po_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                                <i class="fa fa-trash fa-sm"></i>
                                                                            </button>
                                                                            <button type="button" id="print-button-<?= $rows["manage_po_id"] ?>" class="print-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                                <i class="fa fa-print fa-sm"></i>
                                                                            </button>
                                                                </td>
                                                            </tr>
                                                            <script>
                                                                // Information Section Start ---------------------------------------------------------------
                                                                $("#information-button-<?= $rows["manage_po_id"] ?>").click(function () {

                                                                    $("#information-modal").modal('show');
                                                                    $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                    var formData = {"action":"fetchInformation","id":"<?= $rows["manage_po_id"] ?>"};
                                                                    $.ajax({
                                                                        url: 'application/view/admin/manage-po.php',
                                                                        type: 'POST',
                                                                        data: formData,
                                                                        success: function (data) {
                                                                            $('#information-loading').fadeOut(500, function () {
                                                                                $(this).remove();
                                                                                $('#information-section').html(data);
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                                // Information Section End -----------------------------------------------------------------
                                                                // See Section Start ---------------------------------------------------------------
                                                                $("#see-button-<?= $rows["manage_po_id"] ?>").click(function () {
                                                                    $("#see-modal").modal('show');
                                                                    $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                    var formData = {"action":"fetchSee","id":"<?= $rows["manage_po_id"] ?>"};
                                                                    $.ajax({
                                                                        url: 'application/view/admin/manage-po.php',
                                                                        type: 'POST',
                                                                        data: formData,
                                                                        success: function (data) {
                                                                            $('#see-loading').fadeOut(500, function () {
                                                                                $(this).remove();
                                                                                $('#see-section').html(data);
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                                // See Section End -----------------------------------------------------------------
                                                                
                                                                
                                                                
                                                                
                                                                // Edit Section Start ---------------------------------------------------------------
                                                                $("#edit-button-<?= $rows["manage_po_id"] ?>").click(function () {
                                                                    $("#edit-modal").modal('show');
                                                                    $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                    var formData = {"action":"fetchEdit","id":"<?= $rows["manage_po_id"] ?>"};
                                                                    $.ajax({
                                                                        url: 'application/view/admin/manage-po.php',
                                                                        type: 'POST',
                                                                        data: formData,
                                                                        success: function (data) {
                                                                            $('#edit-loading').fadeOut(500, function () {
                                                                                $(this).remove();
                                                                                $('#edit-section').html(data);
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                                // Edit Section End -----------------------------------------------------------------

                                                                
                                                                
                                                                
                                                                
                                                                
                                                                
                                                                
                                                                // Pay Section Start ---------------------------------------------------------------
                                                                $("#pay-button-<?= $rows["manage_po_id"] ?>").click(function () {
                                                                    $("#pay-modal").modal('show');
                                                                    $('#pay-section').html('<center id = "pay-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                    var formData = {"action":"fetchPay","id":"<?= $rows["manage_po_id"] ?>"};
                                                                    $.ajax({
                                                                        url: 'application/view/admin/manage-po.php',
                                                                        type: 'POST',
                                                                        data: formData,
                                                                        success: function (data) {
                                                                            $('#pay-loading').fadeOut(500, function () {
                                                                                $(this).remove();
                                                                                $('#pay-section').html(data);
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                                // Pay Section End -----------------------------------------------------------------
                                                                // Delete Section Start ---------------------------------------------------------------
                                                                $("#delete-button-<?= $rows["manage_po_id"] ?>").click(function () {
                                                                    $("#delete-modal").modal('show');
                                                                    $('#deleteButton').prop('disabled', true);
                                                                    $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                    var formData = {"action":"fetchDelete","id":"<?= $rows["manage_po_id"] ?>"};
                                                                    $.ajax({
                                                                        url: 'application/view/admin/manage-po.php',
                                                                        type: 'POST',
                                                                        data: formData,
                                                                        success: function (data) {
                                                                            $('#delete-loading').fadeOut(500, function () {
                                                                                $(this).remove();
                                                                                $('#delete-section').html(data);
                                                                                $('#deleteButton').prop('disabled', false);
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                                // Delete Section End -----------------------------------------------------------------
                                                                  // Print Section End -----------------------------------------------------------------
                                                                $("#print-button-<?= $rows["manage_po_id"] ?>").click(function () {
                                                                    $("#print-modal").modal('show');
                                                                    $('#printButton').prop('disabled', true);
                                                                    $('#print-section').html('<center id = "print-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                    var formData = {"action":"fetchPrint","id":"<?= $rows["manage_po_id"] ?>"};
                                                                    $.ajax({
                                                                        url: 'application/view/admin/manage-po.php',
                                                                        type: 'POST',
                                                                        data: formData,
                                                                        success: function (data) {
                                                                            $('#print-loading').fadeOut(500, function () {
                                                                                $(this).remove();
                                                                                $('#print-section').html(data);
                                                                                $('#printButton').prop('disabled', false);
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                                <?php
                                                                        $sno++;
                                                                    endforeach;
                                                                endif;
                                                                ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                        </table>
                    </form>
                    <script src="dist/js/admin/for-all-tables.js"></script>
                    <script src="dist/js/main.js"></script>

                <?php
                break;
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchInformation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_manage_po");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`manage_po_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_po_log = json_decode($rows["manage_po_log"]);
                                ?>
                                    <div class="row">
                                        <?php
                                            $sno = 1;
                                            foreach($manage_po_log as $manage_po_log_info):
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($manage_po_log_info->action) ?> By</a></li>
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($manage_po_log_info->action) ?> By -
                                                                    <?php
                                                                        if($manage_po_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$manage_po_log_info->by."'");
                                                                            $getData = $databaseObj->get();
                                                                            //Checking If Data Is Available
                                                                            if($getData != 0):
                                                                                foreach($getData as $rows):
                                                                                    $admin_info = json_decode($rows["admin_info"]);
                                                                                    echo $admin_info->name;
                                                                                endforeach;
                                                                            else:
                                                                                echo "Anonymous";
                                                                            endif;
                                                                        endif;
                                                                    ?>
                                                                    </h5>
                                                                </div>
                                                                <div class="tab-pane active" id="tab_1_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-calendar"></i> Date/Time - </h5>
                                                                    <?= date("l, M d, Y", strtotime($manage_po_log_info->date)) ?> At <?= $manage_po_log_info->at ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                                    <?= $manage_po_log_info->ip ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                                    <?php
                                                                        $latLangArray = explode(",", $manage_po_log_info->location);
                                                                        $lat = explode(":", $latLangArray[0]);
                                                                        $lang = explode(":", $latLangArray[1]);
                                                                    ?>
                                                                    <iframe width="100%" height="300" src="https://maps.google.com/maps?q=<?= $lat[1] ?>,<?= $lang[1] ?>&output=embed"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                $sno++;
                                            endforeach;
                                        ?>
                                    </div>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                                Something went wrong plase try again or refresh.
                            </div>
                            <?php
                        endif;
                    else:
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                        <?php
                    endif;
                else:
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                        You have no permission to see the information of this Data.
                    </div>
                    <?php
                endif;
                break;
            // ------------------------------------------------------
            // ------------ Fetch Information Section End -----------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch See Section Start -----------------
            // ------------------------------------------------------
            case "fetchSee":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_manage_po");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Item Code</h5>
                                                    <?= $rows["itemCode"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Item Name</h5>
                                                    <?= $rows["itemName"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Item Category</h5>
                                                    <?= $rows["itemCategory"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">UOM</h5>
                                                    <?= $rows["Uom"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Price</h5>
                                                    <?= $rows["Price"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">QTY</h5>
                                                    <?= $rows["Qty"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Re-order Level</h5>
                                                    <?= $rows["ReOrder"] ?>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                                Something went wrong plase try again or refresh.
                            </div>
                            <?php
                        endif;
                    else:
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                        <?php
                    endif;
                else:
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                        You have no permission to see the information of this Data.
                    </div>
                    <?php
                endif;
                break;
            // ------------------------------------------------------
            // ------------ Fetch See Section End -------------------
            // ------------------------------------------------------
            // ------------------------------------------------------


             // ------------------------------------------------------
            // ------------ Fetch Edit Section Start -------------------
            // ------------------------------------------------------
            // ------------------------------------------------------



             case "fetchEdit":
             
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_manage_po");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_po_info = json_decode($rows["manage_po_info"]);

                                ?>
                             
                              <section class="content">
                                <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                <input type="hidden" id="secondaryLocation" name="checkLocation" />
                                <input type="hidden" id="secondaryIp" name="checkIp" />
                            <div class="container-fluid">
                              <div class="card card-default">
                                <div class="card-header">
                                  <h3 class="card-title">PO Details</h3>
          

                                     <div class="card-tools">
                                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
          
                                </div>
                                    <div class="card-body">
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>PO No</label>
                                              <input class="form-control" name="editorderNo" id="editorderNo" type="text" value="<?php echo $manage_po_info->orderNo; ?>" readonly>
                                            </div>

                                            <div class="form-group">
                                              <label>State</label>
                                              <select class="country form-control select2" name="editstate" id="editstate" style="width: 100%;" >
                                                <option value="Andhra Pradesh" >Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                <option value="Assam">Assam</option>
                                                <option value="Bihar">Bihar</option>
                                                <option value="Chhattisgarh">Chhattisgarh</option>
                                                <option value="Goa">Goa</option>
                                                <option value="Gujarat">Gujarat</option>
                                                <option value="Haryana">Haryana</option>
                                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                <option value="Jammu & Kashmir">Jammu & Kashmir</option>
                                                <option selected="selected" value="Jharkhand">Jharkhand</option>
                                                <option value="Karnataka">Karnataka</option>
                                                <option value="Kerala">Kerala</option>
                                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Manipur">Manipur</option>
                                                <option value="Meghalaya">Meghalaya</option>
                                                <option value="Mizoram">Mizoram</option>
                                                <option value="Nagaland">Nagaland</option>
                                                <option value="Odisha">Odisha</option>
                                                <option value="Punjab">Punjab</option>
                                                <option value="Rajasthan">Rajasthan</option>
                                                <option value="Sikkim">Sikkim</option>
                                                <option value="Tamil Nadu">Tamil Nadu</option>
                                                <option value="Tripura">Tripura</option>
                                                <option value="Uttarakhand">Uttarakhand</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                <option value="West Bengal">West Bengal</option>
                                                <option value="Andaman & Nicobar">Andaman & Nicobar</option>
                                                <option value="Chandigarh">Chandigarh</option>
                                                <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                                <option value="Daman & Diu">Daman & Diu</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Lakshadweep">Lakshadweep</option>
                                                <option value="Puducherry">Puducherry</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>PO Date</label>
                                              <input class="form-control" name="editpoDate" id="editpoDate" value="<?php echo $manage_po_info->poDate; ?>" type="text" readonly>
                                            </div>
                                            <div id="response" class="form-group">
                                              <label> State Code</label>
                                               <input class="form-control" name="editstateCode" id="editstateCode" type="text" value="20" readonly>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
          <!--                    </div>-->
          <!--                  </div>-->
                              </section>
                                   
                                   
                                <section class="content">
                                  <div class="container-fluid">
                                    <div class="card card-default">
                                      <div class="card-header">
                                        <h3 class="card-title">To :</h3>

                                        <div class="card-tools">
                                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Supplier/Vendor</label>
                                            
                                          
                                                <select id="editvendor_name" name="editvendor_name" class="form-control form-control-sm " data-dropdown-css-class="select2-navy">
                                                               <!--   <option disabled selected>Select</option> -->
                                                                <?php 
                                                                    $databaseObj->select("tbl_manage_supplier");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rows):
                                                                    $manage_supplier_info = json_decode($rows["manage_supplier_info"]);
                                                                    ?>
                                                                  
                                                                   
                                                                    <option <?php if($manage_po_info->vendor_name == $rows["manage_supplier_id"]) echo "selected" ?> value="<?= $rows["manage_supplier_id"] ?>"><?= $manage_supplier_info->supplierName ?></option>
                                                                    <?php
                                                                    endforeach;
                                                                    endif;
                                                                ?>
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                           <div id="branchName">
                                            <div id="view" >
                                            
                                            </div>
                                           </div>
                                          </div>
                                          <script>
                                             $('#editvendor_name').on('change', function( event ) {
                                             $.ajax({
                                             url: 'editgetinformationsvendor.php',
                                             type: 'POST',
                                             data: {"editvendor_name":$(this).val()},
                                             success: function(result) {
                                                 $('#viewbranch').remove();
                                                 $('#branchName').html('<div id="view" >' + result + '</div>');
                                             }
                                            });
                                            event.preventDefault();
                                            });</script>
                                        
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                   <!--  </div>
                                  </div> -->
                                </section>
                
                                <section class="content">
                                  <div class="container-fluid">
                                    <div class="card card-default">
                                      <div class="card-header">
                                        <h3 class="card-title">Billing Address : </h3>

                                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                      </div>
                                   

                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-tools">

                                                  <label>Company Name</label>
                                                   <select id="editcompany_name" name="editcompany_name" class="form-control form-control-sm " data-dropdown-css-class="select2-navy">
                                                               <!--   <option disabled selected>Select</option> -->
                                                                <?php 
                                                                    $databaseObj->select("tbl_manage_company");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rows):
                                                                    $manage_company_info = json_decode($rows["manage_company_info"]);
                                                                    ?>
                                                                  
                                                                    
                                                                    <option <?php if($manage_po_info->company_name == $rows["manage_company_id"]) echo "selected" ?> value="<?= $rows["manage_company_id"] ?>"><?= $manage_company_info->companyName ?></option>
                                                                    <?php
                                                                    endforeach;
                                                                    endif;
                                                                ?>
                                                </select>
                                                
                                                  
                                                </div>

                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div id="company">
                                             <div id="viewcompany" >
                                             </div>
                                          </div>
                                        </div>
                                      </div>
                                       <script>
                                            $('#editcompany_name').on('change', function( event ) {
                                               $.ajax({
                                                   url: 'editgetinformationscompany.php',
                                                   type: 'POST',
                                                   data: {"editcompany_name":$(this).val()},
                                                   success: function(result) {
                                                       $('#viewcompany').remove();
                                                       $('#company').html('<div id="viewcompany" >' + result + '</div>');
                                                     
                                                   }
                                               });
                                               event.preventDefault();
                                           });
                                       </script> 
                                           <!-- <div class="col-md-6">
                                          <div class="form-group">
                                            <label>GSTIN</label>
                                              
                                                     
                                              <input class="form-control" name="editcompany_gstin" id="editcompany_gstin" type="text" value="<?php echo $manage_company_info->companyGSTIN; ?>" readonly>
                                          </div>
                                             </div> -->
                                            <!-- <div class="col-md-12">
                                          <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" name="editcompany_address" value="<?= $manage_company_info->companyAddress; ?>" id="editcompany_address" type="text" readonly>
                                          </div>
                                           </div> -->
                                    </div>
                                  </div>
                                  </div>
                                      <!-- </div>
                                    </div>
                                  </div> -->
                                </section>
                
                
                                <section class="content">
                                  <div class="container-fluid">
                                    <div class="card card-default">
                                      <div class="card-header">
                                        <h3 class="card-title">Delivering Address : </h3>

                                        <div class="card-tools">
                                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          
                                            <?php
                                            $databaseObj->select("tbl_projects");
                                                              $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_po_info->project."'");
                                                              $getData = $databaseObj->get();
                                                              
                                                              
                                                              if($getData != 0):
                                                                foreach($getData as $rows):
                                                                   $projects_info = json_decode($rows["projects_info"]);
                                                                   // $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                                                endforeach;
                                                              endif; 
                                                          ?>
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                            <label>Project</label>
                                                          
                                                            <input class="form-control"  type="text" value="<?= $projects_info->projectName ?>" readonly>     
                                                             <input class="form-control" name="editproject" id="editproject" type="hidden" value="<?= $rows["projects_id"] ?>" readonly>     
                                                  
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                            <label>Project Location</label>
                                                          
                                                            <input class="form-control" name="editprojectLocation" id="editprojecLocationt" type="text" value="<?= $projects_info->projectLocation ?>" readonly>     
                                                  
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">

                                                         <div class="form-group">

                                                           <label>Contact Person</label>

                                                           <select id="editbilling_contact_person" name="editbilling_contact_person" class="form-control">
                                                            <!--  <option disabled selected>Select</option> -->

                                                                  <?php

                                                                    $databaseObj->select("tbl_manage_employee");

                                                             
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");

                                                                    $getCompanyData = $databaseObj->get();

                                                                    foreach ($getCompanyData as $row):

                                                                      $manage_employee_info = json_decode($row["manage_employee_info"]);
                                                                      ?>
                                                                      <option <?php if($manage_po_info->billing_contact_person == $row["manage_employee_id"]) echo "selected" ?> value="<?= $row["manage_employee_id"] ?>"><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?></option>
                                                                    

                                                                      <?php
                                                                      endforeach;

                                                                             
                                                                     ?>

                                                           </select>

                                                         </div>
                                                        </div>
                                                     

                                                        <div class="col-md-6">

                                                          <div id="contactPerson">

                                                              <div id="viewdesignation">
                                                      
                                                              </div>

                                                          </div>
                                                        </div>
                                      
                                        </div>

                                      </div>
                                        <script>

                                           $('#editbilling_contact_person').on('change', function( event ) {
                                           
                                              
                                           $.ajax({

                                               url: 'editgetInformationbillingcontactDesignation.php',

                                               type: 'POST',


                                               data: {"editbilling_contact_person":$(this).val()},
                                               
                                               success: function(result) {

                                                  // alert(data);

                                                   $('#viewdesignation').remove();
                                                   $('#contactPerson').append('<div id="viewdesignation" >' + result + '</div>');
                                               }

                                           });
                                            // console.log(data);
                                           event.preventDefault();
                                   });</script>
                                       
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </section>
                                <section class="content">
                  <div class="container-fluid">
                    <div class="card card-default">
                      <div class="card-header">
                        <h3 class="card-title">PO Items</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">

                                <tr>
                                  <th> <input type="checkbox" id="check-all" name="check-all" title="Check All" onclick="SelectChkbox();"> </th>
                                  <th width="2%">S.NO</th>
                                  <th width="12%">Item Code</th>
                                  <th width="46%">Item Name</th>
                                  <th width="11%">UOM</th>
                                  <th width="5%">Quantity</th>
                                  <th width="2%">Rate</th>
                                  <th width="10%">Amount</th>
                                  <th width="5%">Cgst%</th>
                                  <th width="5%">Sgst%</th>
                                  <th width="5%">Igst%</th>
                                    <th width="10%">Remark</th>
                                  <th width="10%">Total Amount</th>
                                
                                 <!--  <th width="5%">Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th> -->
                                </tr>
                                <?php
                                  $cnt = 1;

                                            
                                                          
                                           
                                    foreach ($manage_po_info->item_info as $item_info_item):  

                                
                                     

                                    //   echo"<pre>";
                                    // print_r($item_info_item);
                                    // echo $item_info_item->remark;
                                    // echo
                                    
 
                                                    
                                                     ?>
                               <tr>
                               
                               <td><input type="checkbox" id="check-all" name="check-all" title="Check All"  <?php echo !empty($item_info_item->quantity) ? 'checked' : '' ?>></td>
                                <td width="5%"><?= $cnt ?>.</td>
                                <?php 
                                        
                                  $databaseObj->select("tbl_manage_item");

                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$item_info_item->itemCode."'");
                                                   

                                                    $getDatas = $databaseObj->get();

                                                        
                                                    if($getDatas != 0):
                                                        foreach($getDatas as $rows_deptt):
                                                        
                                                            $itemName = $rows_deptt["itemName"];
                                                           
                                                            $itemCode = $rows_deptt["itemCode"];
                                                            $itemCategory = $rows_deptt["itemCategory"];
                                                            $Uom = $rows_deptt["Uom"];
                                                            // $Qty = $rows_deptt["Qty"];
                                                            

                                                        endforeach;
                                                    endif;?>
                                 
                              
                                                   
                                 <td><input class="form-control" name="edititem_code_po[]" id="edititem_code_po[<?php echo $cnt; ?>]" type="hidden" value="<?= $item_info_item->itemCode ?>" readonly><input class="form-control"  type="text" value="<?= $itemCode ?>" readonly> </td>
                                 <td><input class="form-control" name="edititem_name_po[]" id="edititem_name_po[<?php echo $cnt; ?>]" type="hidden" value="<?= $item_info_item->itemName ?>" readonly><input class="form-control"  type="text" value="<?= $itemName ?>" readonly></td>
                                
                                 <td><input class="form-control" name="edituom_po[]" id="edituom_po[<?php echo $cnt; ?>]" type="hidden" value="<?= $item_info_item->uom ?>" readonly><input class="form-control"  type="text" value="<?= $Uom ?>" readonly></td>
                                
                                  <td><input class="form-control" name="tonne_id_po[]" id="tonne_id_po[<?php echo $cnt; ?>][tonne]" type="text" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); cal_totalAll(<?php echo $cnt; ?>);" value="<?= $item_info_item->quantity ?>" <?php echo empty($item_info_item->quantity) ? '' : 'readonly' ?>></td>
                                   <td><input type="text" name="rate_po[]"  placeholder="" id="rate_id_po[<?php echo $cnt; ?>][rate]"  value="<?= $item_info_item->rate ?>" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); cal_totalAll(<?php echo $cnt; ?>);" class="form-control" style="width:80px;" <?php echo empty($item_info_item->rate) ? '' : 'readonly' ?>></td>
                                     <td><input type="text" name="amount_po[]" placeholder="" id="amount_id_po[<?php echo $cnt; ?>][amount]" class="form-control"  value="<?= $item_info_item->amount ?>"style="width:80px;"  readonly /></td>
                                      <td><input type="text" name="cgstrate_po[]" value="0" placeholder="" id="cgst_id_po[<?php echo $cnt; ?>][cgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" class="form-control cGstValue" readonly></td>
                                      <td><input type="text" name="sgstrate_po[]" value="0" placeholder="" id="sgst_id_po[<?php echo $cnt; ?>][sgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" class="form-control sGstValue" readonly ></td>
                                      <td><input type="text" name="igstrate_po[]" value="0" placeholder="" id="igst_id_po[<?php echo $cnt; ?>][igstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" class="form-control iGstValue" readonly></td>
                                         <td><input class="form-control" name="remark_po[]" id="remark_id_po[<?php echo $cnt; ?>][remark]" type="text" value="<?= $item_info_item->remark ?>"></td>
                                       <td><input type="text" name="total_po[]" placeholder="" id="total_id_po[<?php echo $cnt; ?>][total]" class="form-control" onkeyup="cal_totalAll(<?php echo $cnt; ?>);"  value="<?= $item_info_item->total ?>"  style="width:80px;"readonly /></td>
                                      

                                 </tr>
                            <?php
                                            
                          


                                                        $cnt++;
                                                endforeach;

                                                
                                
                                                                                ?>
                                                                                 <tr>
                                     <tr>
                                      <th colspan="10"></th>
                                     <th>Total : </th>
                                    <th>

                                     <input type="text" name="totalAll" id="totalAll" class="form-control" value="<?= $manage_po_info->totalAll ?>"  readonly>
                                   </th>
                                                    

                                   <!--  <th></th> -->
                                     </tr>
                            </table>
                              <input type="hidden" class="form-control" value="<?php echo $cnt ?>" id="counter" name="counter" >
                        </div>

                      </div>

                    </div>

                  </div>

                </section>
                               
                 
                               <!--  <section class="content">
                                  <div class="container-fluid">
                                    <div class="card card-default">
                                      <div class="card-header">
                                        <h3 class="card-title">PO Items</h3>

                                        <div class="card-tools">
                                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                      </div>
                                      <div class="card-body">
                                        <div class="table-responsive" style="overflow-x:auto;">
                                            <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">

                                      <tr>
                                         <th width="5%">S.NO</th>
                                        <th width="35%">Item Code</th>
                                        <th width="35%">Item Name</th>
                                        <th width="15%">UOM</th>
                                        <th width="5%">Quantity</th>
                                        <th width="8%">Rate</th>
                                        <th width="10%">Amount</th>
                                        <th width="5%">Cgst%</th>
                                        <th width="5%">Sgst%</th>
                                        <th width="5%">Igst%</th>
                                        <th width="10%">Total Amount</th>
                                       <!-  <th width="5%">Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th> -->
                                     <!--  </tr>
                                         
                                             
                                        <?php
                                            $cnt = 1; 
                                            foreach($manage_po_info->item_info as $manage_po_item_info):
                                                
                                                ?>
                                              <tr id="row<?php echo $cnt; ?>">
                                                 <td width="10%"><input type="text" id="slno<?php echo $cnt; ?>" value="<?php echo $cnt; ?>" readonly class="form-control"></td>
                                                 

                                                <td width="">
                                                <select id="item_code[<?php echo $cnt; ?>]" name="item_code[]" class="form-control" readonly style="width:80px;">
                                                <?php 

                                                $databaseObj->select("tbl_manage_item");
                                                $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$manage_po_item_info->itemCode."'");
                                                $item_det = $databaseObj->get(); 
                                                $item_deltails =  array();
                                                foreach($item_det as $item_det_all)
                                                $item_deltails = $item_det_all;
                                                ?>
                                                <option value="<?= $item_deltails["manage_item_id"] ?>"><?= $item_deltails["itemCode"] ?></option>
                                                </select>
                                                </td>
                                                
                                                <td width="">
                                                 <select id="item_name[<?php echo $cnt; ?>]" name="item_name[]" class="form-control" style="width:80px;">
                                                 <?php 
                                                     
                                                    $databaseObj->select("tbl_manage_item");
                                                    $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$manage_po_item_info->itemName."'");
                                                    $item_det = $databaseObj->get(); 
                                                    $item_deltails =  array();
                                                    foreach($item_det as $item_det_all)
                                                    $item_deltails = $item_det_all;
                                                     ?>                           
                                                    <option value="<?= $item_deltails["manage_item_id"] ?>"><?= $item_deltails["itemName"] ?></option>
                                                    </select>

                                                </td>
                                                
                                                
                                                  <td>
                                                    <select id="item_name[<?php echo $cnt; ?>]" name="uom[]" class="form-control" style="width:80px;">

                                                    <?php 
                                                    $databaseObj->select("tbl_manage_item");
                                                    $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$manage_po_item_info->uom."'");
                                                    $item_det = $databaseObj->get(); 
                                                    $item_deltails =  array();
                                                    foreach($item_det as $item_det_all)
                                                    $item_deltails = $item_det_all;
                                                    ?>
                                                       <option value="<?= $item_deltails["manage_item_id"] ?>"><?= $item_deltails["Uom"] ?>
                                                      </select>
                                                    </td>


                                                <td><input type="text" name="quantity[]" placeholder="" id="tonne_id[<?php echo $cnt; ?>][tonne]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); getGst();" class="form-control" value="<?php echo $manage_po_item_info->quantity; ?>" style=""></td>
                                                
                                                <td><input type="text" name="rate[]"  placeholder="" id="rate_id[<?php echo $cnt; ?>][rate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); getGst();" value="<?php echo $manage_po_item_info->rate; ?>" class="form-control" style="width:80px;"></td>
                                                
                                                <td><input type="text" name="amount[]" placeholder="" id="amount_id[<?php echo $cnt; ?>][amount]" class="form-control" value="<?php echo $manage_po_item_info->amount; ?>"  style="width:80px;" readonly /></td>
                                                

                                                <td><input type="text" name="cgstrate[]" value="9" placeholder="" id="cgst_id[<?php echo $cnt; ?>][cgstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control cGstValue" ></td>
                                                
                                                
                                                
                                                <input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id[<?php echo $cnt; ?>][cgstamt]" class="form-control"  hidden />

                                                <td><input type="text" name="sgstrate[]" value="9" placeholder="" id="sgst_id[<?php echo $cnt; ?>][sgstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control sGstValue" ></td>
                                                <input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id[<?php echo $cnt; ?>][sgstamt]" class="form-control"   hidden />

                                                <td><input type="text" name="igstrate[]" value="0" placeholder="" id="igst_id[<?php echo $cnt; ?>][igstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control iGstValue" ></td>
                                                <input type="text" name="igstamt[]" placeholder="" id="igstamt_id[<?php echo $cnt; ?>][igstamt]" class="form-control"  hidden />


                                                <td><input type="text" name="total[]" value="<?php echo $manage_po_item_info->total; ?>" placeholder="" id="total_id[<?php echo $cnt; ?>][total]" class="form-control"  style="width:80px;" readonly /></td>


                                                <td>
                                            <?php
                                            if ($cnt > 0 ) {
                                            ?>
                                            <button type="button" name="remove" id="<?php echo $cnt+1; ?>" class="btn btn-danger btn_remove">X</button>
                                            <?php
                                            }
                                            else {
                                            ?>
                                            <button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            <?php
                                            }
                                                 ?>

                                                
                <                              <button type="button" name="remove" id="<?php echo $cnt; ?>" class="btn btn-danger btn_remove">X</button>-->
                                                <!-- </td>

                                              </tr>
                                              <?php
                                                $cnt++; 
                                                 endforeach;
                                               ?>
                                          
                                            </table>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </section> -->
                  
                              <script>
                                      function onSelection(id, val)
                          {
                              var code_id = "item_code_po[" +id+ "]";
                              var name_id = "item_name_po[" +id+ "]";
                              var uom_id =  "uom_po[" +id+ "]";

                              console.log(code_id+ " " +name_id+ " "+uom_id);
                              document.getElementById(code_id).value = val;
                              document.getElementById(name_id).value = val;
                              document.getElementById(uom_id).value =  val;
                          }

                   function cal(si){
                    
                    
                     if(document.getElementById('tonne_id_po['+si+'][tonne]').value!="" && document.getElementById('rate_id_po['+si+'][rate]').value!=""){
                       document.getElementById('amount_id_po['+si+'][amount]').value = document.getElementById('tonne_id_po['+si+'][tonne]').value*document.getElementById('rate_id_po['+si+'][rate]').value;
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);                      
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value)
                       var total = amt+camt+samt+iamt;
                       // var t_camt= amt * (camt/100);
                       // var t_samt=  amt * (samt/100);
                       // var t_iamt=  amt * (iamt/100);
                       // var total = amt+t_camt+t_samt+t_iamt;
                       total = total.toFixed(2);
                       
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                       document.getElementById('amount_id_po['+si+'][amount]').value = "";
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                      
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_cgst(si){
                     if(document.getElementById('cgst_id_po['+si+'][cgstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var cgstr = tamount*document.getElementById('cgst_id_po['+si+'][cgstrate]').value;
                       cgstr = cgstr.toFixed(2);
                       document.getElementById('cgst_id_po['+si+'][cgstrate]').value = cgstr;
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                       document.getElementById('cgst_id_po['+si+'][cgstrate]').value = "";
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_sgst(si){
                     if(document.getElementById('sgst_id_po['+si+'][sgstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var sgstr = tamount*document.getElementById('sgst_id_po['+si+'][sgstrate]').value;
                       sgstr = sgstr.toFixed(2);
                       
                       
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;

                     } else{
                      
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_igst(si){
                     if(document.getElementById('igst_id_po['+si+'][igstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var igstr = tamount*document.getElementById('igst_id_po['+si+'][igstrate]').value;
                       igstr = igstr.toFixed(2);
                      
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                       
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
               function cal_totalAll(si){
                     var count= Number(document.getElementById('counter').value);
                     // alert(total);
                     var totalAmt=0;
                      console.log(count-1);
                      for(i=1;i<=(count-1);i++){
                        console.log(Number(totalAmt));
                        totalAmt=Number(totalAmt)+Number(document.getElementById('total_id_po['+i+'][total]').value);
                        console.log(totalAmt);
                        document.getElementById('totalAll').value=totalAmt;
                        
                      }
                     //document.getElementById('totalAll').value = total;   
                   } 
                                     
                                     
                                     
                                     
                                     
                                      var i = <?php echo $cnt; ?>
                                    
                                 $('#add').click(function(){
                                      i++;
                                 $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><input type="text" id="slno'+i+'" value="'+i+'" readonly class="form-control" style="border:none;" /></td><td>' +
                           		   '<select id="item_code[' + i + ']" name="item_code[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item");  $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0):$sno = 1;  foreach($getData as $rows):?><option value="<?= $rows["manage_item_id"] ?>"><?= $rows["itemCode"] ?></option>  <?php endforeach; endif; ?> </select></td><td>' +
                           		   '<select id="item_name[' + i + ']" name="item_name[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item");  $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0):$sno = 1;  foreach($getData as $rows):?><option value="<?= $rows["manage_item_id"] ?>"><?= $rows["itemName"] ?></option>  <?php endforeach; endif; ?> </select></td><td>' +
                           		   '<select id="uom[' + i + ']" name="uom[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item");  $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0):$sno = 1;  foreach($getData as $rows):?><option value="<?= $rows["manage_item_id"] ?>"><?= $rows["Uom"] ?></option>  <?php endforeach; endif; ?> </select></td><td><input type="text" name="quantity[]" placeholder="" id="tonne_id['+i+'][tonne]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control"/></td><td><input type="text" name="rate[]" placeholder="" id="rate_id['+i+'][rate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control"/></td><td><input type="text" name="amount[]" placeholder="" id="amount_id['+i+'][amount]" class="form-control" readonly /></td><td><input type="text" name="cgstrate[]" value="9" placeholder="" id="cgst_id['+i+'][cgstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control cGstValue"/><input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id['+i+'][cgstamt]" class="form-control" hidden /></td><td><input type="text" name="sgstrate[]" value="9" placeholder="" id="sgst_id['+i+'][sgstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control sGstValue"/><input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id['+i+'][sgstamt]" class="form-control" hidden /></td><td><input type="text" name="igstrate[]" value="0" placeholder="" id="igst_id['+i+'][igstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control iGstValue"/><input type="text" name="igstamt[]" placeholder="" id="igstamt_id['+i+'][igstamt]" class="form-control" hidden /></td><td><input type="text" name="total[]" placeholder="" id="total_id['+i+'][total]" class="form-control" readonly /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                                 }); 
                                     
                                     
                                     
                                        $(document).on('click', '.btn_remove', function(){
                                        var button_id = $(this).attr("id");
                                        $('#row'+button_id+'').remove();
                                        });
                                </script>    
                   
                   
                    
                    
                     
               
      
                                   
               
                                   
                                <section class="content">
                                   <div class="container-fluid">
                                     <div class="card card-default">
                                       <div class="card-header">
                                         <h3 class="card-title">Terms and Conditions : </h3>

                                         <div class="card-tools">
                                           <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                         </div>
                                       </div>
                                       <div class="card-body">
                                         <div class="row">
                                           <div class="col-md-6">
                                             <div class="form-group">
                                               <label>Description</label>
                                               <textarea name="editdescription" id="editdescription"class="form-control" value="<?= $manage_po_info->payment_description ?>"><?php echo $manage_po_info->payment_description; ?></textarea>
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                             <div class="form-group">
                                               <label>Payment Terms</label>
                                             <textarea width="600" name="editpayment_terms" id="editpayment_terms" class="form-control" value="<?= $manage_po_info->payment_terms ?>"> <?php echo $manage_po_info->payment_terms; ?></textarea>
                                            <!--  <script>
                                                CKEDITOR.replace( 'payment_terms' );
                                             </script> -->
                                             </div>
                                         </div>
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                                </section>
                            
<!--<
                         
                          <?php 
                          if($getData != 0): 
                        foreach($getData as $rows):
                                $manage_po_info = json_decode($rows["manage_po_info"]);
                                ?>
                        
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Payment Mode</label>
                            <select class="form-control" name="payment_mode" id="payment_mode"  readonly>
                                 <option value="Cash" <?php if($manage_po_info->payment_mode == "Cash") echo "selected" ?>>Cash</option>
                                 <option value="Cheque" <?php if($manage_po_info->payment_mode == "Cheque") echo "selected" ?>>Cheque</option>
                                 <option value="DD" <?php if($manage_po_info->payment_mode == "DD") echo "selected" ?>>DD</option>
                                 <option value="NEFT" <?php if($manage_po_info->payment_mode == "NEFT") echo "selected" ?>>NEFT</option>
                              </select>
                            </div>
                            
                          </div>
                          
                          
                           <div class="col-md-6">
                            <div class="form-group">
                             <label>Account Number</label>
                            <input type="text" class="form-control" value="<?php echo $manage_po_info->accountNo ?>" name="accountNo" id='accountNo' readonly>
                            </div>
                            
                          </div>
                          
                          <div class="col-md-6">
                            <div class="form-group">
                             <label>Check/DD/NEFT Number : </label>
                            <input type="text" class="form-control" value="<?php echo $manage_po_info->checkNo ?>"  name="checkNo" id='checkNo' readonly>
                            </div>
                            
                          </div>
                          
                          
                          
                        </div>  
                        <?php
                           endforeach;
                        
                        
                         else:  
                        ?>
                                                     
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Payment Mode</label>
                            <select class="form-control" name="payment_mode" id="payment_mode" onchange="mode(this.value)">
                                 <option value="Cash">Cash</option>
                                 <option value="Cheque">Cheque</option>
                                 <option value="DD">DD</option>
                                 <option value="NEFT">NEFT</option>
                              </select>
                            </div>
                            
                          </div>
                          
                          
                          
                          
                          
                        </div> 
                        <?php 
                             endif; 
                            ?>                         
                            <div id="mode" style="display:none;">
                       <div class="col-md-6">
                            <div class="form-group">
                             <label>Account Number</label>
                            <input type="text" class="form-control" name="accountNo" id='accountNo'>
                            </div>
                            
                          </div>
                          
                          <div class="col-md-6">
                            <div class="form-group">
                             <label>Check/DD/NEFT Number : </label>
                            <input type="text" class="form-control" name="checkNo" id='checkNo'>
                            </div>
                            
                          </div>
                        
                        </div>                                                     
                                                                                                                                         
                                                   
                                                                   
                                    
                                <?php
                        
                            endforeach;
                        else:
                            ?>
                            
                            
-->
                            
                            
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                                Something went wrong plase try again or refresh.
                            </div>
                            <?php
                        endif;
                    else:
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                        <?php
                    endif;
                else:
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                        You have no permission to see the information of this Data.
                    </div>
                    <?php
                endif;
                break;
            // ------------------------------------------------------
            // ------------ Fetch Edit Section End ------------------








             // ------------ Fetch Pay Section Start ----------------
            // ------------------------------------------------------
            case "fetchPay":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):

                       // print_r($_POST["id"]); exit;
                        $databaseObj->select("tbl_manage_po");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                              $manage_po_info = json_decode($rows["manage_po_info"]);
                              
                                ?>
                                 

                                     <div class="row">
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Total Amount</h5>
                                                    Rs&nbsp<?= $manage_po_info->totalAll ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Payment Status</h5>
                                                    <?= $rows["payment_status"] ?>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    
                                <?php
                            endforeach;
                        else:
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                                Something went wrong plase try again or refresh.
                            </div>
                            <?php
                        endif;
                    else:
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                        <?php
                    endif;
                else:
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                        You have no permission to see the information of this Data.
                    </div>
                    <?php
                endif;
                break;
            // ------------------------------------------------------
            // ------------ Fetch Pay Section End ------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchDelete":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            Do you really wanna delete this data???
                        </div>
                        <input type="hidden" id="tableId" name="tableId" value="<?= $_POST["id"] ?>" />
                        <input type="hidden" id="tableName" name="tableName" value="tbl_manage_po" />
                        <?php
                    else:
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                        <?php
                    endif;
                else:
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                        You have no permission to see the information of this Data.
                    </div>
                    <?php
                endif;
                break;
            // ------------------------------------------------------
            // ------------ Fetch Information Section End -----------$manage_supplier_info
            // ------------------------------------------------------
            // ------------ Fetch Print Section Start -----------
                case "fetchPrint":
                    if($authority == 1):
                        if(isset($_POST["id"]) && !empty($_POST["id"])):
                            $databaseObj->select("tbl_manage_po");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '".$_POST["id"]."'");
                            $databaseObj->order_by("`manage_po_id` DESC");
                            $getData = $databaseObj->get();
                            //Checking If Data Is Available
                            if($getData != 0):
                                foreach($getData as $rows):
                                    $manage_po_log = json_decode($rows["manage_po_log"]);
                                    $manage_po_info = json_decode($rows["manage_po_info"]);
                                    ?>
                                <section class="content">
                                  <div class="container-fluid">
                                    <div class="row">
                                      <div class="col-12">
                                        <div class="callout callout-info">
                                            <table>
                                                <tr>
                                                    <!-- <td></td> -->
                                                    <td>
                                                        <h4>
                                                           
                                                            <?php
                                                            
                                                                $databaseObj->select("tbl_manage_company");
                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$manage_po_info->company_name."'");
                                                                $getCompanyData = $databaseObj->get();
                                                                foreach ($getCompanyData as $row):
                                                                  $manage_company_info = json_decode($row["manage_company_info"]);
                                                                 
                                                                 
                                                                    
                                                                  endforeach;
                                                                ?><?= $manage_company_info->companyName ?>
                                                        </h4>                        
                                                    </td> 
                                                    
                                                    <td>
                                                        <?php
                                                                   
                                                                        if($manage_company_info->companyLogo == "default"):

                                                                    ?>

                                                                            <a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="Company Logo" class="table-avatar"></a>

                                                                    <?php

                                                                        else:

                                                                    ?>
                                                                            <a href="<?= $manageCompanyDir.$manage_company_info->companyLogo ?>" target="_blank"><img src="<?= $manageCompanyDir.$manage_company_info->companyLogo ?>" alt="Company Logo" class="table-avatar"></a>

                                                                    <?php 

                                                                        endif;
                                                                    
                                                     
                                            
                                                                    ?>
                                                                </h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        
                                                        <?= $manage_po_info->company_address ?>
                                                   
                                                    </td> 
                                                </tr>
                                                      <!-- <small class="float-right"> Date:<?= date("Y/m/d") ?></small>
                                                     </h4> -->
                                                <tr>
                                                     
                                                </tr> 
                                            </table>           
                                                
                                        </div>


                                        <!-- Main content -->
                                        <div class="invoice p-3 mb-3" >
                                          <!-- title row -->
                                          <table style="border: 1px solid black;">
                                             
                                            
                                                <tr style="border: 1px solid black;">
                                                    <td colspan="5"></td>
                                                    
                                                    <td colspan="2">PURCHASE ORDER</td>
                                                    <td colspan ="5"></td>
                                                   
                                                </tr> 
                                                    <tr style="border: 1px solid black;">
                                                         <?php
                                                          $databaseObj->select("tbl_projects");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_po_info->project."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                                $projects_info = json_decode($rows_deptt["projects_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="8" rowspan="2"  ><h6>Project/Site: <?= $projects_info->projectName ?>,<?= $projects_info->projectLocation ?></h6>
                                                            
                                                        </td>
                                                         <td colspan="2"style="border: 1px solid black;" >PO No:</td>
                                                         <?php
                                                         $year =  date("y");
                                           // $yearnow= date("Y");
                                           $yearnext=$year+1;
                                           $yearcurrent = date("y")."-".$yearnext; ?>
                                                         <td  colspan="2" style="border: 1px solid black;"><?= $manage_po_info->orderNo ?></td>
                                                        
                                                         
                                                        
                                                    </tr> 
                                                    <tr>
                                                        
                                                         <td colspan="2"  style="border: 1px solid black;">Date:</td>
                                                        <td colspan="2"  style="border: 1px solid black;"><?= $manage_po_info->poDate ?></td>
                                                    </tr>
                                                    <tr  style="border: 1px solid black;">
                                                        
                                                        <td colspan="4"  style="border: 1px solid black;">Vendor's Name & Address</td><br>
                                                        <td colspan="4"  style="border: 1px solid black;">Delivery Address</td>

                                                        <td colspan="2"   style="border: 1px solid black;">Req No</td>
                                                        
                                                        <td colspan="2" style="border: 1px solid black;"><?= $manage_po_info->requisition_no ?></td>
                                                    </tr>    
                                                    <tr ><?php
                                                          $databaseObj->select("tbl_manage_supplier");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$manage_po_info->vendor_name."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $manage_supplier_info = json_decode($rows_deptt["manage_supplier_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="4"  rowspan="3" style="border: 1px solid black;" ><?= $manage_supplier_info->supplierName ?>
                                                        <br />
                                                        <?= $manage_po_info->vendor_address ?>
                                                         </td>
                                                         
                                                       
                                                        
                                                        <?php
                                                          $databaseObj->select("tbl_projects");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_po_info->project."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $projects_info = json_decode($rows_deptt["projects_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="4"   style="border: 1px solid black;">
                                                            <?= $projects_info->projectName ?>,<?= $projects_info->projectLocation?>
                                                                
                                                        </td>
                                                        <td colspan="2" style="border: 1px solid black;">Req Date</td>
                                                         <td colspan="2" style="border: 1px solid black;"><?= $manage_po_info->requisition_date ?></td>    
                                                    </tr>   
                                                    <tr>
                                                        <td colspan="4" style="border: 1px solid black;" >Billing Address
                                                                
                                                        </td>
                                                        <td colspan="4" style="border: 1px solid black;">Payment terms
                                                                
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                         <td colspan="4" style="border: 1px solid black;"><?= $manage_company_info->companyName ?>,<?= $manage_po_info->company_address ?>
                                                                
                                                        </td>
                                                        <td colspan="4" rowspan="8" style="border: 1px solid black;">Within 30 Days after Receiving of Bill
                                                                
                                                       
                                                                
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" style="border: 1px solid black;">Contact Person
                                                                
                                                        </td>
                                                        <td colspan="4"  style="border: 1px solid black;">Contact Person & Designation
                                                       
                                                    </tr>
                                                    <tr >
                                                        <td colspan="4" rowspan="4" ><?= $manage_po_info->vendor_contact_person ?>
                                                                
                                                        </td>
                                                        <?php
                                                          $databaseObj->select("tbl_manage_employee");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$manage_po_info->billing_contact_person."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $manage_employee_info = json_decode($rows_deptt["manage_employee_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                         <?php
                                                          $databaseObj->select("tbl_manage_designation");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$manage_po_info->billing_contact_designation."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $manage_designation_info = json_decode($rows_deptt["manage_designation_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="4"  style="border: 1px solid black;"><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>,<?= $manage_designation_info->designationName ?>
                                                       </td>
                                                    </tr>
                                                    <tr >
                                                       <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                    <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td colspan="4" ></td>
                                                        <!-- <td colspan="4"  style="border: 1px solid black;" >Contact Telephone Number</td> -->
                                                    </tr>
                                                    <tr >
                                                         <td colspan="4" style="border: 1px solid black;">Telephone Number</td>
                                                        <td colspan="4" style="border: 1px solid black;">Telephone Number</td>
                                                    </tr> 
                                                    <tr >
                                                         <td colspan="4" style="border: 1px solid black;"><?= $manage_po_info->vendor_contact_phone_no ?></td>
                                                        <td colspan="4" style="border: 1px solid black;"><?= $manage_po_info->billing_contact_number ?></td>
                                                    </tr>    
                                                    <tr style="border: 1px solid black;">
                                                        <td colspan="1" style="border: 1px solid black;">Sr No.</td>
                                                        <td colspan="1" style="border: 1px solid black;">Item Code.</td>
                                                        <td colspan="2" style="border: 1px solid black;">Item Name.</td>
                                                        
                                                        <td colspan="1" style="border: 1px solid black;">UNIT</td>
                                                        <td colspan="1" style="border: 1px solid black;">Quantity</td>
                                                        <td colspan="1" style="border: 1px solid black;">Rate</td>
                                                        <td colspan="4" style="border: 1px solid black;">Remark</td>
                                                        <td colspan="1" style="border: 1px solid black;">Amount(Rs)</td>
                                                        
                                                    </tr> 
                                                    <?php
                                                        $databaseObj->select("tbl_manage_po");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '".$_POST["id"]."'");
                                                            $getData = $databaseObj->get();
                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                                foreach($getData as $rows):
                                                                    ?>

                                                    
                                                            <?php
                                                 $cnt = 1;
                                                foreach ($manage_po_info->item_info as $item_info) {
                                                               if(!empty($item_info->quantity)):
                                                              
                                                              ?>
                                                           
                                    
                               
                                                    <tr>         
                                                                    <td colspan="1" style="border: 1px solid black;"><?= $cnt ?>.</td>
                                                                    <?php
                                   $databaseObj->select("tbl_manage_item");

                                                     $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$item_info->itemCode."'");
                                                     
                                                      $getDatas = $databaseObj->get();
                                                          
                                                      if($getDatas != 0):
                                                          foreach($getDatas as $rows_deptt):
                                                          
                                                              $itemName = $rows_deptt["itemName"];
                                                              // echo "<pre>";
                                                              // print_r($rows_deptt["itemName"]);
                                                              // echo"</pre>";
                                                              $itemCode = $rows_deptt["itemCode"];
                                                              $itemCategory = $rows_deptt["itemCategory"];
                                                              $Uom = $rows_deptt["Uom"];
                                                              // $Qty = $rows_deptt["Qty"];
                                                              // print_r($rows_deptt);
                                                          endforeach;
                                                      endif;    
                                                      
                                                        ?>
                                                                    <td colspan="1" style="border: 1px solid black;"><?= $itemCode ?></td>
                                                                    <td colspan="2" style="border: 1px solid black;"><?= $itemName ?></td>
                                                                    <td colspan="1" style="border: 1px solid black;"><?= $Uom ?></td>
                                                                    <td colspan="1" style="border: 1px solid black;"><?= $item_info->quantity ?></td>
                                                                    <td colspan="1" style="border: 1px solid black;"><?= $item_info->rate ?></td>
                                                                    
                                                                    <td  colspan="4" style="border: 1px solid black;"><?= $item_info->remark ?></td>  
                                                                    <td colspan="2" style="border: 1px solid black;"><?= $item_info->amount ?></td>  

                                                    </tr>
                                                                <?php
                                                                
                                              $cnt++;
																				endif;

                                                                                   }
                                                                                endforeach;
                                                                            endif;
                                                                            ?>
                                                                           
                                      <th colspan="9"></th>
                                     <th>Total : </th>
                                    <th>
                                      <td colspan="2" style="border: 1px solid black;"><?=$manage_po_info->totalAll ?></td>  
                                     
                                   </th>
                                          </table>
                                         

                                            
                                        </div> 
                                          <!-- info row -->

                                        <div class="invoice p-3 mb-3">
                                           <!--  <div class="col-sm-4 invoice-col"> -->
                                                     
                                           <br>Terms & Conditions
                                           <br>1.GST Extra as per Govt. Norms
                                           <br>2.Freight Inclusive
                                           <br>3.Delivery: Immediate after issuance of PO
                                           <br>4.Bill Should be submitted along with the PO (Strictly)


                                           <br>For,Srinath Homes India Pvt Ltd.
                                           <br>
                                           <br>Authorised Signature 

                                          <!--   </div> -->
                                            <!-- /.col -->
                                           </div> 

                                          <!-- this row will not appear when printing -->
                                        <div class="row no-print">
                                            <div class="col-12">
                                              <a href="application/view/admin/print_po.php?id=<?= $rows["manage_po_id"] ?>" id="print_po-button-<?= $rows["manage_po_id"] ?>" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                             
                                              <!-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                                <i class="fas fa-download"></i> Generate PDF
                                              </button> -->
                                             
                                            </div>
                                        </div>
                                    </div>
                                        <!-- /.invoice -->
                                      </div><!-- /.col -->
                                    </div><!-- /.row -->
                                  </div><!-- /.container-fluid -->
                                </section>
                                    <?php
                                endforeach;
                            else:
                                ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                                    Something went wrong plase try again or refresh.
                                </div>
                                <?php
                            endif;
                        else:
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                                Something went wrong plase try again or refresh.
                            </div>
                            <?php
                        endif;
                         else:
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                            You have no permission to see the information of this Data.
                        </div>
                        <?php
                    endif;
                break;
            // ------------------------------------------------------
            // ------------ Fetch Information Section End -----------
            // ------------------------------------------------------
            // ------------------------------------------------------
                //  case "editfetchDetails":
                //     if($authority == 1):
                //         if(isset($_POST["id"]) && !empty($_POST["id"])):
                //             $databaseObj->select("tbl_manage_supplier");
                //             $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$_POST["id"]."'");
                //             $databaseObj->order_by("`manage_supplier_id` DESC");
                //             $getData = $databaseObj->get();
                //             //Checking If Data Is Available
                //             if($getData != 0):
                //                 foreach($getData as $rows):
                //                     $manage_supplier_info = json_decode($rows["manage_supplier_info"]);
                //                     // $manage_po_info = json_decode($rows["manage_po_info"]);
                //                     ?>
                //               <div class="row"> 
                //                  <div class="col-sm-12">
                //               <label>Address</label>
                            
                //                <div class="form-group">

                //               <input class="form-control" name="editvendor_address" id="editvendor_address" type="text" value="<?= $manage_supplier_info->supplierAddress ?>" readonly>

                //                </div>
                //              </div>
                //              <div class="col-sm-6">
                //                  <label>GSTIN</label>

                //                <div class="form-group">

                //                 <input class="form-control" name="editvendor_gstin" id="editvendor_gstin" type="text" value="<?= $manage_supplier_info->supplierGstin ?>"readonly>

                //                </div>
                //                </div> 
                //                 <div class="col-sm-6">   
                //                    <label>Contact Person</label>

                //              <div class="form-group">

                //               <input class="form-control" name="editvendor_contact_person" id="editvendor_contact_person" type="text" value="<?= $manage_supplier_info->supplierConcernPersonName ?>" readonly>

                //              </div>
                //              </div>
                //               <div class="col-sm-6">
                //              <label>Contact  Phone Number</label>

                //              <div class="form-group">

                //               <input class="form-control" name="editvendor_contact_phone_no" id="editvendor_contact_phone_no" type="text" value="<?= $manage_supplier_info->supplierPhone ?>" readonly>

                //              </div>
                //               </div>
                //             </div>
                //                     <?php
                //                 endforeach;
                //               // endif;
                //             else:
                //                 ?>
                //                 <div class="alert alert-danger alert-dismissible">
                //                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                //                     <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                //                     Something went wrong plase try again or refresh.
                //                 </div>
                //                 <?php
                //             endif;
                //         else:
                //             ?>
                //             <div class="alert alert-danger alert-dismissible">
                //                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                //                 <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                //                 Something went wrong plase try again or refresh.
                //             </div>
                //             <?php
                //         endif;
                //          else:
                //         ?>
                //         <div class="alert alert-danger alert-dismissible">
                //             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                //             <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                //             You have no permission to see the information of this Data.
                //         </div>
                //         <?php
                //     endif;
                // break;
                
            default:
                ?>
                <!-- <script>
                  //  $('editvendor_name').change(function(){
                  //   alert("The text has been changed.");
                  // });

                function showAlert(){
                  alert("The text has been changed.");
                }
</script> -->
                    <script>
                        const Toast = Swal.mixin({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 5000,
                          timerProgressBar: false,
                          onOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                          }
                        })
                        function topEndNotification(theme, message){
                            Toast.fire({
                              icon: theme,
                              title: message
                            })
                        }
                        topEndNotification("warning", "Something went wrong, please try again or refresh...");
                    </script>
                <?php
                break;
        endswitch;
    endif;
?>
