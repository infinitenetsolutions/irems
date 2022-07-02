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
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/receive-indent.php">
                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_indent">
                        <input type="hidden" id="action" name="action" value="exportSelectedData">
                        <input type="hidden" id="secondaryLocation" name="checkLocation" />
                        <input type="hidden" id="secondaryIp" name="checkIp" />
                        <table id="example1" class="table table-bordered table-striped">


                                <thead>
                                   <tr>
                                     <th>S.No.</th>
                                     <th>Indent No.</th>
                                     <th>Indent Date</th>
                                     <th>Site Received From</th>
                                     <th>Indent Prepared By</th>
                                     <th>Designation(Indent Prepared)</th>

                                     <th>Action</th>
                                   </tr>
                                </thead>
                                <tbody>
                                            <?php
                                                $databaseObj->select("tbl_manage_indent");
                                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                                $databaseObj->order_by("`manage_indent_id` DESC");
                                                $getData = $databaseObj->get();
                                                //Checking If Data Is Available
                                                if($getData != 0):
                                                    $sno = 1;
                                                    foreach($getData as $rows):
                                                        $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                                               
                                                        $manage_indent_log = json_decode($rows["manage_indent_log"]);
                                                        ?>
                                                        <tr>
                                                                                
                                                            <td><?= $sno ?>.</td>
                                                            <td><?= $manage_indent_info->employee_req ?></td>
                                                            <td><?= $manage_indent_info->indentDate ?></td>
                                                            <?php 
                               
                                                            $databaseObj->select("tbl_projects");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id`='".$manage_indent_info->employee_project."'");
                                                            $databaseObj->order_by("`projects_id` DESC");
                                                            $getData = $databaseObj->get(); 

                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                            
                                                              foreach($getData as $rowsproject):
                                                                $projects_info = json_decode($rowsproject["projects_info"]);
                                                                $projects_log = json_decode($rowsproject["projects_log"]);
                                                                 ?>
                                                            <td><?= $projects_info->projectName ?></td>
                                                            <?php 
                               
                                                            $databaseObj->select("tbl_manage_employee");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$manage_indent_info->indentCreated."'");
                                                            $databaseObj->order_by("`manage_employee_id` DESC");
                                                            $getData = $databaseObj->get(); 

                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                             
                                                              foreach($getData as $rowsemployee):
                                                                $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                                               
                                                                  ?>
                                                            <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?></td>
                                                            <?php 
                               
                                                            $databaseObj->select("tbl_manage_designation");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id`='".$manage_employee_info->designation."'");
                                                            $databaseObj->order_by("`manage_designation_id` DESC");
                                                            $getData = $databaseObj->get(); 

                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                             
                                                              foreach($getData as $rowsdesignation):
                                                                $manage_designation_info = json_decode($rowsdesignation["manage_designation_info"]);
                                                               
                                                                ?>
                                                                 <td><?= $manage_designation_info->designationName ?></td>
                                                                   
                                                                <td class="text-center">
                                                                                    
                                                                
                                                                                    
                                                                                    <button type="button" id="see-button-<?= $rows["manage_indent_id"] ?>" class="see-button btn btn-xs btn-danger mt-1 mb-1" title="View Indent">
                                                                                        <i class="fa fa-eye fa-sm"></i>
                                                                                    </button>
                                                                                    <button type="button" id="print-button-<?= $rows["manage_indent_id"] ?>" class="print-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                                        <i class="fa fa-print fa-sm"></i>
                                                                                    </button>
                                                                </td>
                                                        </tr>
                                                        <script>
                                                                       // See Section Start ---------------------------------------------------------------
                                                                        $("#see-button-<?= $rows["manage_indent_id"] ?>").click(function () {
                                                                            $("#see-modal").modal('show');
                                                                            $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                            var formData = {"action":"fetchSee","id":"<?= $rows["manage_indent_id"] ?>"};
                                                                            $.ajax({
                                                                                url: 'application/view/admin/receive-indent.php',
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
                                                                        $("#edit-button-<?= $rows["manage_indent_id"] ?>").click(function () {
                                                                            $("#edit-modal").modal('show');
                                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                            var formData = {"action":"fetchEdit","id":"<?= $rows["manage_indent_id"] ?>"};
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
                                                                        $("#pay-button-<?= $rows["manage_indent_id"] ?>").click(function () {
                                                                            $("#pay-modal").modal('show');
                                                                            $('#pay-section').html('<center id = "pay-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                            var formData = {"action":"fetchPay","id":"<?= $rows["manage_indent_id"] ?>"};
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
                                                                        $("#delete-button-<?= $rows["manage_indent_id"] ?>").click(function () {
                                                                            $("#delete-modal").modal('show');
                                                                            $('#deleteButton').prop('disabled', true);
                                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["manage_indent_id"] ?>"};
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
                                                                        $("#print-button-<?= $rows["manage_indent_id"] ?>").click(function () {

                                                                            $("#print-modal").modal('show');
                                                                            $('#printButton').prop('disabled', true);
                                                                            $('#print-section').html('<center id = "print-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                                            var formData = {"action":"fetchPrint","id":"<?= $rows["manage_indent_id"] ?>"};
                                                                            $.ajax({
                                                                                url: 'application/view/admin/receive-indent.php',
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
                                                endforeach;
                                                endif;
                                                 endforeach;
                                                endif;
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
                        $databaseObj->select("tbl_manage_indent");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`manage_indent_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_indent_log = json_decode($rows["manage_indent_log"]);
                                ?>
                                    <div class="row">
                                        <?php
                                            $sno = 1;
                                            foreach($manage_indent_log as $manage_indent_log_info):
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($manage_indent_log_info->action) ?> By</a></li>
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($manage_indent_log_info->action) ?> By -
                                                                    <?php
                                                                        if($manage_indent_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$manage_indent_log_info->by."'");
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
                                                                    <?= date("l, M d, Y", strtotime($manage_indent_log_info->date)) ?> At <?= $manage_indent_log_info->at ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                                    <?= $manage_indent_log_info->ip ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                                    <?php
                                                                        $latLangArray = explode(",", $manage_indent_log_info->location);
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
                        $databaseObj->select("tbl_manage_indent");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();

                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                
                              //  echo "<pre>";
                              //  print_r($manage_indent_info);
                              //  exit();

                                   ?>
                                <table id="example1" class="table table-bordered table-striped">

                                    <thead>
                                        <tr>
                                            
                                            <th>S.No.</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>UOM</th>
                                            <th>Qty</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                           
                                            

                                               $cnt = 1;
                                            
                                                foreach ($manage_indent_info->item_info as $item_info):            
                                               
                                                $databaseObj->select("tbl_manage_item");
                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$item_info->itemName."'");
                                                $getData = $databaseObj->get();
                                                if($getData != 0):
                                                    foreach($getData as $rows_deptt):
                                                        $itemName = $rows_deptt["itemName"];
                                                        $itemCode = $rows_deptt["itemCode"];
                                                        $Uom = $rows_deptt["Uom"];
                                                        $Qty = $rows_deptt["Qty"];
                                                    endforeach;
                                                endif;
                                                 ?>
            
       
                                                <tr>         
                                                        <td><?= $cnt ?>.</td>
                                                        <td><?= $itemCode ?></td>
                                                        <td><?= $itemName ?></td>
                                                        <td><?= $Uom ?></td>
                                                        <td><?= $item_info->quantity ?></td>
                                                        <td><?= $item_info->remark ?></td>
                                                                 
                                                                 
                                                </tr>
                                                    <?php
                                        
                      


                                                    $cnt++;
                                            endforeach;
                                            
                            
                                                                            ?>
                                                                                                            
                                                                                                            
                                                                   

                                    </tbody>
                                </table>
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
                        $databaseObj->select("tbl_manage_indent");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                ?>
                    <section class="content">
                     <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                     <input type="hidden" id="secondaryLocation" name="checkLocation" />
                      <input type="hidden" id="secondaryIp" name="checkIp" />
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>PO No</label>
                              <input class="form-control" name="orderNo" id="orderNo" type="text" value="<?php echo $manage_indent_info->orderNo; ?>" readonly>
                            </div>
                            <div class="form-group">
                              <label>State</label>
                              <select class="country form-control select2" name="state" id="state" style="width: 100%;" readonly>
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
                              <input class="form-control" name="editpoDate" id="editpoDate" value="<?php echo $manage_indent_info->poDate; ?>" type="date">
                            </div>
                            <div id="response" class="form-group">
                              <label> State Code</label>
                               <input class="form-control" name="editstateCode" id="editstateCode" type="text" value="20" readonly>
                            </div>
                          </div>
                        </div>
<!--                      </div>-->
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
                              
                                <select id="editvendor_name" name="editvendor_name" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                                <option disabled selected>Select</option>
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
                                                                                <option <?php if($manage_supplier_info->supplierName == $rows["manage_supplier_id"]) echo "selected" ?> value="<?= $rows["manage_supplier_id"] ?>"><?= $manage_supplier_info->supplierName ?></option>
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
                                <div class="form-group">
                                  <label>Address</label>
                                  <input class="form-control" name="editvendor_address" type="text" value="<?php echo $manage_indent_info->vendor_address; ?>" readonly>
                                </div>
                                <div id="response" class="form-group">
                                  <label>GSTIN</label>
                                   <input class="form-control" name="editvendor_gstin" value="<?php echo $manage_indent_info->vendor_gstin; ?>" type="text" readonly>
                                </div>
                                <div id="response" class="form-group">
                                  <label>Contact Person</label>
                                   <input class="form-control" name="editvendor_contact_person" value="<?=$manage_indent_info->vendor_contact_person; ?>" type="text" readonly>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                
                <section class="content">
                  <div class="container-fluid">
                    <div class="card card-default">
                      <div class="card-header">
                        <h3 class="card-title">Billing Address : </h3>

                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <div class="card-tools">

                                  <label>Company Name</label>
                                     <input list="company" class="form-control" name="editcompany_name" id='editcompany_name' style="width: 100%;" autocomplete="off" value="<?php echo $manage_indent_info->company_name; ?>" readonly>
                             
                                </div>
<!--
                            <div id="gstin">
                            <div id="viewgstin">
                            <div class="form-group">
                              <label>GSTIN</label>
                               <input class="form-control" name="company_gstin" type="text" value="<?php echo $manage_indent_info->company_gstin; ?>" readonly>
                            </div>
                            </div>
                            </div>
-->
                          </div>
                          <div class="col-md-6">
                          <div id="company">
                          <div id="viewcompany" >
                           
                            <div class="form-group">
                              <label>GSTIN</label>
                               <input class="form-control" name="editcompany_gstin" type="text" value="<?php echo $manage_indent_info->company_gstin; ?>" readonly>
                            </div>
                            
                            <div class="form-group">
                              <label>Address</label>
                              <input class="form-control" name="editcompany_address" value="<?php echo $manage_indent_info->company_address; ?>" id="company_address" type="text" readonly>
                            </div>
                          </div>
                        </div>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
                          <div class="col-md-6">
                            <div class="form-group">
                            <label for="project">Project Name</label>
                            
                                <select id="editproject" name="editproject" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" readonly>
                                    <?php 
                                        $databaseObj->select("tbl_projects");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rows):
                                        $project_info = json_decode($rows["projects_info"]);
                                        ?>

                                     <option value="<?= $rows["projects_id"] ?>" <?php if($project_info->projectName == $rows["projects_id"]) echo "selected" ?>><?= $project_info->projectName ?></option>
                                    <?php
                                    endforeach;
                                    endif;
                                    ?>
                                </select>

                            </div>

                          </div>
                          
                        <div class="col-md-6">
                            <div id="project12">
                              <div id="viewproject" >
                                      
                                         
                                        <!-- <div class="form-group">
                                            <label>Property</label>
                                             <input class="form-control" name="propertyType" type="text" value="<?php echo $manage_indent_info->propertyType->propertyType; ?>,<?php echo $manage_indent_info->propertyType->accommodationType; ?>,<?php echo $manage_indent_info->propertyType->squareFeet; ?>" readonly>                          
                                             </div> -->

                                        <!-- <div class="form-group">
                                            <label>Project Location</label>
                                            <input class="form-control" value="<?php echo $manage_indent_info->projectLocation; ?>" name="projectLocation" id="projectLocation" type="text" readonly>
                                        </div> -->
                              </div>
      
                            </div>
                        </div>
<!--
                          <div class="col-md-6">
                            <div class="form-group">
                            <label for="property">Property</label>
                            <select id="property" name="property" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">

                            </select>
                            </div>
                        </div>
-->
                        
<!--
                            <div class="col-md-6">
                            <div class="form-group">
                            <label for="projectLocation">Project Location</label>
                            <input type="text" id="projectLocation" name="projectLocation" class="form-control" readonly>
                            </div>
                            </div>
                            
-->
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
                        <th width="5%">Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th>
                      </tr>
                         
                             
                        <?php
                            $cnt = 1; 
                            foreach($manage_indent_info->item_info as $manage_indent_item_info):
                                
                                ?>
                              <tr id="row<?php echo $cnt; ?>">
                                 <td width="10%"><input type="text" id="slno<?php echo $cnt; ?>" value="<?php echo $cnt; ?>" readonly class="form-control"></td>
                                 

                                <td width="">
                                <select id="item_code[<?php echo $cnt; ?>]" name="item_code[]" class="form-control" readonly style="width:80px;">
                                <?php 

                                $databaseObj->select("tbl_manage_item");
                                $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$manage_indent_item_info->itemCode."'");
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
                                    $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$manage_indent_item_info->itemName."'");
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
                                    $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$manage_indent_item_info->uom."'");
                                    $item_det = $databaseObj->get(); 
                                    $item_deltails =  array();
                                    foreach($item_det as $item_det_all)
                                    $item_deltails = $item_det_all;
                                    ?>
                                       <option value="<?= $item_deltails["manage_item_id"] ?>"><?= $item_deltails["Uom"] ?>
                                      </select>
                                    </td>


                                <td><input type="text" name="quantity[]" placeholder="" id="tonne_id[<?php echo $cnt; ?>][tonne]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); getGst();" class="form-control" value="<?php echo $manage_indent_item_info->quantity; ?>" style=""></td>
                                
                                <td><input type="text" name="rate[]"  placeholder="" id="rate_id[<?php echo $cnt; ?>][rate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); getGst();" value="<?php echo $manage_indent_item_info->rate; ?>" class="form-control" style="width:80px;"></td>
                                
                                <td><input type="text" name="amount[]" placeholder="" id="amount_id[<?php echo $cnt; ?>][amount]" class="form-control" value="<?php echo $manage_indent_item_info->amount; ?>"  style="width:80px;" readonly /></td>
                                

                                <td><input type="text" name="cgstrate[]" value="9" placeholder="" id="cgst_id[<?php echo $cnt; ?>][cgstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control cGstValue" ></td>
                                
                                
                                
                                <input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id[<?php echo $cnt; ?>][cgstamt]" class="form-control"  hidden />

                                <td><input type="text" name="sgstrate[]" value="9" placeholder="" id="sgst_id[<?php echo $cnt; ?>][sgstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control sGstValue" ></td>
                                <input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id[<?php echo $cnt; ?>][sgstamt]" class="form-control"   hidden />

                                <td><input type="text" name="igstrate[]" value="0" placeholder="" id="igst_id[<?php echo $cnt; ?>][igstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control iGstValue" ></td>
                                <input type="text" name="igstamt[]" placeholder="" id="igstamt_id[<?php echo $cnt; ?>][igstamt]" class="form-control"  hidden />


                                <td><input type="text" name="total[]" value="<?php echo $manage_indent_item_info->total; ?>" placeholder="" id="total_id[<?php echo $cnt; ?>][total]" class="form-control"  style="width:80px;" readonly /></td>


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

                                
<!--                                <button type="button" name="remove" id="<?php echo $cnt; ?>" class="btn btn-danger btn_remove">X</button>-->
                                </td>

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
</section>
                  
                  <script>
                        function onSelection(id, val)
                        {
                            var code_id = "item_code[" +id+ "]";
                            var name_id = "item_name[" +id+ "]";
                            var uom_id =  "uom[" +id+ "]";

                            console.log(code_id+ " " +name_id+ " "+uom_id);
                            document.getElementById(code_id).value = val;
                            document.getElementById(name_id).value = val;
                            document.getElementById(uom_id).value =  val;
                        }
                    </script>
                   
                 <script>
                 function cal(si){
                   if(document.getElementById('tonne_id['+si+'][tonne]').value!="" && document.getElementById('rate_id['+si+'][rate]').value!=""){
                     document.getElementById('amount_id['+si+'][amount]').value = document.getElementById('tonne_id['+si+'][tonne]').value*document.getElementById('rate_id['+si+'][rate]').value;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('amount_id['+si+'][amount]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_cgst(si){
                   if(document.getElementById('cgst_id['+si+'][cgstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var cgstr = tamount*document.getElementById('cgst_id['+si+'][cgstrate]').value;
                     cgstr = cgstr.toFixed(2);
                     document.getElementById('cgstamt_id['+si+'][cgstamt]').value = cgstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('cgstamt_id['+si+'][cgstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_sgst(si){
                   if(document.getElementById('sgst_id['+si+'][sgstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var sgstr = tamount*document.getElementById('sgst_id['+si+'][sgstrate]').value;
                     sgstr = sgstr.toFixed(2);
                     document.getElementById('sgstamt_id['+si+'][sgstamt]').value = sgstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('sgstamt_id['+si+'][sgstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_igst(si){
                   if(document.getElementById('igst_id['+si+'][igstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var igstr = tamount*document.getElementById('igst_id['+si+'][igstrate]').value;
                     igstr = igstr.toFixed(2);
                     document.getElementById('igstamt_id['+si+'][igstamt]').value = igstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('igstamt_id['+si+'][igstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
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
                                   <textarea name="description" class="form-control"><?php echo $manage_indent_info->description; ?></textarea>
                                 </div>
                               </div>
                               <div class="col-md-6">
                                 <div class="form-group">
                                   <label>Payment Terms</label>
                                 <textarea width="600" name="payment_terms" id="payment_terms" class="form-control"> <?php echo $manage_indent_info->payment_terms; ?></textarea>
                                 <script>
                                    CKEDITOR.replace( 'payment_terms' );
                                 </script>
                                 </div>
                             </div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </section>
<!--
                         
                          <?php 
                          if($getData != 0): 
                        foreach($getData as $rows):
                                $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                ?>
                        
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Payment Mode</label>
                            <select class="form-control" name="payment_mode" id="payment_mode"  readonly>
                                 <option value="Cash" <?php if($manage_indent_info->payment_mode == "Cash") echo "selected" ?>>Cash</option>
                                 <option value="Cheque" <?php if($manage_indent_info->payment_mode == "Cheque") echo "selected" ?>>Cheque</option>
                                 <option value="DD" <?php if($manage_indent_info->payment_mode == "DD") echo "selected" ?>>DD</option>
                                 <option value="NEFT" <?php if($manage_indent_info->payment_mode == "NEFT") echo "selected" ?>>NEFT</option>
                              </select>
                            </div>
                            
                          </div>
                          
                          
                           <div class="col-md-6">
                            <div class="form-group">
                             <label>Account Number</label>
                            <input type="text" class="form-control" value="<?php echo $manage_indent_info->accountNo ?>" name="accountNo" id='accountNo' readonly>
                            </div>
                            
                          </div>
                          
                          <div class="col-md-6">
                            <div class="form-group">
                             <label>Check/DD/NEFT Number : </label>
                            <input type="text" class="form-control" value="<?php echo $manage_indent_info->checkNo ?>"  name="checkNo" id='checkNo' readonly>
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
                        $databaseObj->select("tbl_manage_indent");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                              //$payment_info = $rows["manage_indent_receipt"]
                                ?>
                                 

                                     <div class="row">
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Total Amount</h5>
                                                    <?= $rows["total_amount"] ?>
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
                        <input type="hidden" id="tableName" name="tableName" value="tbl_manage_indent" />
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
            // ------------ Fetch Information Section End -----------
            // ------------------------------------------------------
            // ------------ Fetch Print Section Start -----------
                case "fetchPrint":
                    if($authority == 1):
                        if(isset($_POST["id"]) && !empty($_POST["id"])):
                            $databaseObj->select("tbl_manage_indent");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$_POST["id"]."'");
                            $databaseObj->order_by("`manage_indent_id` DESC");
                            $getData = $databaseObj->get();
                            //Checking If Data Is Available
                            if($getData != 0):
                                foreach($getData as $rows):
                                    $manage_indent_log = json_decode($rows["manage_indent_log"]);
                                    $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                    ?>
                                <section class="content">
                                  <div class="container-fluid">
                                    <div class="row">
                                      <div class="col-12">
                                       
                                            
                                        <h4 class="text-center">Requisition Slip</h4>  

                                       </div>
                                        <div class="col-sm-3">
                                                        
                                            Req No: <?= $manage_indent_info->employee_req ?>
                                                            
                                        </div>                                   
                                        <div class="col-sm-3">    
                                        </div>
                                        <div class="col-sm-3">    
                                        </div>  
                                        <div class="col-sm-3">  
                                         <a style="float: right;">Date: <?= $manage_indent_info->indentDate ?></a>
                                        </div>
                                    </div>            
                                    


                                        <!-- Main content -->
                                        <!-- <div class="invoice p-3 mb-3" > -->
                                         <table  class="table table-bordered table-striped">

                                    <thead>
                                        <tr>
                                            
                                            <th>S.No.</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            
                                            <th>UOM</th>
                                            
                                            <th>Qty</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                           
                                            

                                               $cnt = 1;
                                            
                                                foreach ($manage_indent_info->item_info as $item_info):            
                                               
                                                $databaseObj->select("tbl_manage_item");
                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$item_info->itemName."'");
                                                $getData = $databaseObj->get();
                                                if($getData != 0):
                                                    foreach($getData as $rows_deptt):
                                                        $itemName = $rows_deptt["itemName"];
                                                        $itemCode = $rows_deptt["itemCode"];
                                                        $Uom = $rows_deptt["Uom"];
                                                        $Qty = $rows_deptt["Qty"];
                                                    endforeach;
                                                endif;
                                                 ?>
            
       
                                                <tr>         
                                                        <td><?= $cnt ?>.</td>
                                                        <td><?= $itemCode ?></td>
                                                        <td><?= $itemName ?></td>
                                                        <td><?= $Uom ?></td>
                                                        <td><?= $Qty ?></td>
                                                        <td><?= $item_info->remark ?></td>
                                                                 
                                                                 
                                                </tr>
                                                    <?php
                                        
                      


                                                    $cnt++;
                                            endforeach;
                                            
                            
                                                                            ?>
                                                                                                            
                                                                                                            
                                                                   

                                    </tbody>
                                </table> <!-- title row -->
                                 <div class="row">
                                      <div class="col-4">

                                       Prepared By</br>
                                       <?php 
                               
                                                            $databaseObj->select("tbl_manage_employee");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$manage_indent_info->indentCreated."'");
                                                            $databaseObj->order_by("`manage_employee_id` DESC");
                                                            $getData = $databaseObj->get(); 

                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                             
                                                              foreach($getData as $rowsemployee):
                                                                $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                                               endforeach;
                                                            endif;   
                                                                  ?>
                                       (<?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>)                 
                                                 
                                            
                                      </div> 
                                      <div class="col-4"> 
                                       <a class="text-center">Signature</a>

                                                       
                                                 
                                            
                                      </div>     
                                      
                                      <div class="col-4"> 
                                       <a style="float: right;">Approved By</br>
                                         <?php 
                               
                                                            $databaseObj->select("tbl_manage_employee");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$manage_indent_info->employee_approval."'");
                                                            $databaseObj->order_by("`manage_employee_id` DESC");
                                                            $getData = $databaseObj->get(); 

                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                             
                                                              foreach($getData as $rowsemployee):
                                                                $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                                               endforeach;
                                                            endif;   
                                                                  ?>
                                       (<?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>)  
                                       </a>              
                                                 
                                            
                                      </div>                 
                                                
                                        </div>         
                                         

                                            
                                        
                                        <div class="row no-print">
                                            <div class="col-12">

                                              <a href="application/view/admin/print_indent.php?id=<?= $rows["manage_indent_id"] ?>" id="print_indent-button-<?= $rows["manage_indent_id"] ?>" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                             
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
                
            default:
                ?>
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