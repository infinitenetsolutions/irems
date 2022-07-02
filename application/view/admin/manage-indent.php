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
    $manageItemStoreDir = "../../../assets/admin/manage-indent/";
    $manageItemDir = "assets/admin/manage-indent/";
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
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/manage-item.php">
                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_item">
                        <input type="hidden" id="action" name="action" value="exportSelectedData">
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
                                        <th>Indent No</th>
                                        <th>Indent Date</th>
                                        <th>Description</th>
                                        <th>Emp Requisition No</th>
                                        <th>Emp Email Approval</th>
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
                                                $manage_item_info = json_decode($rows["manage_indent_info"]);
                                   ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="icheck-navy d-inline">
                                                                <input type="checkbox" id="checkbox-<?= $rows["manage_indent_id"] ?>" name="checkbox-select[]" value="<?= $rows["manage_item_id"] ?>" class="check-table">
                                                                <label for="checkbox-<?= $rows["manage_indent_id"] ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= $sno ?>.</td>
                                                        <?php
                                                        //   $databaseObj->select("tbl_projects");
                                                        // $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$rows["projectName"]."'");
                                                        // $getData = $databaseObj->get();
                                                        // if($getData != 0):
                                                        //     foreach($getData as $rows_deptt):
                                                        //         $projects_info = json_decode($rows_deptt["projects_info"]);
                                                        //     endforeach;
                                                        // endif;
                                                         ?>
                                                        <!-- <td> //$projects_info->projectName </td> -->
                                                        <td><?= $manage_item_info->indentNo ?></td>
                                                        <td><?= $manage_item_info->indentDate ?></td>
                                                        <td><?= $manage_item_info->description ?></td>
                                                        <td><?= $manage_item_info->employee_req ?></td>
                                                        <td><?= $manage_item_info->employee_email_approval ?></td>
                                                        
                                                        
                                                        <td class="text-center">
                                                            <button type="button" id="information-button-<?= $rows["manage_indent_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">
                                                                <i class="fa fa-scroll fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="see-button-<?= $rows["manage_indent_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See">
                                                                <i class="fa fa-eye fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="edit-button-<?= $rows["manage_indent_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                                                <i class="fa fa-edit fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="delete-button-<?= $rows["manage_indent_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                <i class="fa fa-trash fa-sm"></i>
                                                            </button>
                                                           <!--  <button type="button" id="switch-button-<?= $rows["rec_note_no"] ?>" class="switch-button btn btn-xs btn-danger mt-1 mb-1" title="Switch">
                                                                <i class="fa fa-toggle-on fa-sm"></i>
                                                            </button> -->

                                                        </td>
                                                    </tr>
                                                    <script>
                                                        // Information Section Start ---------------------------------------------------------------
                                                        $("#information-button-<?= $rows["manage_indent_id"] ?>").click(function () {
                                                            $("#information-modal").modal('show');
                                                            $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchInformation","id":"<?= $rows["manage_indent_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/manage-indent.php',
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
                                                        $("#see-button-<?= $rows["manage_indent_id"] ?>").click(function () {
                                                            $("#see-modal").modal('show');
                                                            $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSee","id":"<?= $rows["manage_indent_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/manage-indent.php',
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
                                                                url: 'application/view/admin/manage-indent.php',
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
                                                        
                                                        // Switch Section Start ---------------------------------------------------------------
                                                        $("#switch-button-<?= $rows["manage_indent_id"] ?>").click(function () {
                                                            $("#switch-modal").modal('show');
                                                            $('#switchButton').prop('disabled', true);
                                                            $('#switch-section').html('<center id = "switch-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSwitch","id":"<?= $rows["manage_indent_id"] ?>"};
                                                            $.ajax({

                                                                url: 'application/view/admin/manage-indent.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#switch-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#switch-section').html(data);
                                                                        
                                                                        $('#switchButton').prop('disabled', false);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Switch Section End -----------------------------------------------------------------
                                                        // Switch Section Start ---------------------------------------------------------------
                                                        $("#delete-button-<?= $rows["manage_indent_id"] ?>").click(function () {
                                                            $("#delete-modal").modal('show');
                                                            $('#deleteButton').prop('disabled', true);
                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["manage_indent_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/manage-indent.php',
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
                                                        // Switch Section End -----------------------------------------------------------------
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
                                        <th></th>
                                        <th></th>
                                       <!--  <th></th> -->
                                    </tr>
                                </tfoot>

                        </table>
                    </form>
                    <script>
                        $('#add-button').prop('disabled', false);
                        $('#import-button').prop('disabled', false);
                    </script>
                    <script src="dist/js/admin/for-all-tables.js"></script>
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
                        $databaseObj->select("tbl_manage_item");
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
                        <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($manage_item_log_info->action) ?> By -
                            <?php
                                                                        if($manage_item_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$manage_item_log_info->by."'");
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
                        <?= date("l, M d, Y", strtotime($manage_item_log_info->date)) ?> At <?= $manage_item_log_info->at ?>
                    </div>
                    <div class="tab-pane" id="tab_2_<?= $sno ?>">
                        <h5><i class="icon fas fa-server"></i> IP - </h5>
                        <?= $manage_item_log_info->ip ?>

                    </div>
                    <div class="tab-pane" id="tab_3_<?= $sno ?>">
                        <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                        <?php
                        $latLangArray = explode(",", $manage_item_log_info->location);
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
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $databaseObj->order_by("`manage_indent_id` DESC");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                              
                                ?>
                                        <div class="row">
                                           <!-- <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Project Name</h5>
                                                    <?= $rows["in_items_received"] ?>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Item Code</h5>
                                                    <?= $rows["indentNo"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Item Name</h5>
                                                    <?= $rows["indentNo"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Item Category</h5>

                                                        <?php
                                                          $databaseObj->select("tbl_manage_category");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$rows["itemCategory"]."'");
                                                        $getData = $databaseObj->get();
                                                       
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                                $manage_category_info = json_decode($rows_deptt["manage_category_info"]);
                                                            endforeach;
                                                        endif;?>
                                                    <?= $manage_category_info->categoryName ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">UOM</h5>
                                                    <?= $rows["Uom"] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
            // ------------ Fetch Edit Section Start ----------------
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
                                
                                ?>
                                    
                            <div class="modal-body">
                                <!-- <div class="card card-navy card-outline"> -->
                                    <div class="card-body">
                                        <div class="row">
                                               
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editItemCode">Item Code</label>
                                                        <input type="text" class="form-control form-control-sm" id="editItemCode" name="editItemCode" placeholder="Item Code" value="<?= $rows["itemCode"] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editItemName">Item Name</label>
                                                        <input type="text" class="form-control form-control-sm" id="editItemName" name="editItemName" placeholder="Item Name" value="<?= $rows["itemName"] ?>">
                                                    </div>
                                                </div>
                                               
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editItemCategory">Item Category</label>
                                                       
                                                        <select class="form-control form-control-sm" id="editItemCategory" name="editItemCategory" placeholder="Item Category">
                                                          <?php
                                                          $databaseObj->select("tbl_manage_category");
                                                          $databaseObj->where("`status` = '".$auth->visible()."'");
                                                          $getCategoryData = $databaseObj->get();
                                                        if($getCategoryData != 0):
                                                            foreach($getCategoryData as $categoryrows):
                                                                $manage_category_info = json_decode($categoryrows["manage_category_info"]);
                                                         ?>
                                                        
                                                         <option <?php if($rows["itemCategory"] == $categoryrows["manage_category_id"]) echo "selected" ?> value="<?=$categoryrows["manage_category_id"] ?>"><?= $manage_category_info->categoryName  ?></option>
                                                         <?php
                                                           endforeach;
                                                         endif;
                                                         ?>
                                                        </select>
                                                    </div>
                                                </div>
                                       

                                      
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editItemUom">UOM</label>
                                                        <input type="text" class="form-control form-control-sm" id="editItemUom" name="editItemUom" placeholder="Item UOM" value="<?= $rows["Uom"] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editItemPrice">Price</label>
                                                        <input type="number" class="form-control form-control-sm" id="editItemPrice" name="editItemPrice" value="<?= $rows["Price"] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editItemQty">Qty</label>
                                                        <input type="number" class="form-control form-control-sm" id="editItemQty" name="editItemQty" value="<?= $rows["Qty"] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editItemReOrder">Re-Order Level</label>
                                                        <input type="number" class="form-control form-control-sm" id="editItemReOrder" name="editItemReOrder" value="<?= $rows["ReOrder"] ?>">
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                               <!--  </div>   -->
                                    <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                <?php
                            endforeach;?>
                            </div> 
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
            // ------------------------------------------------------
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
                        <input type="hidden" id="tableName" name="tableName" value="tbl_manage_item" />
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



            // ------------------------------------------------------
            // ------------ Fetch Switch Section Start -----------
            // ------------------------------------------------------
            case "fetchSwitch":

                       
                        
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_manage_item");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                ?>
                                    <div class="row">
                                        

                                           <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="showProjectName">Project Name</label>
                                                <input type="text" class="form-control form-control-sm" id="showProjectName" name="showProjectName" placeholder="Project Name" value="<?= $rows["projectName"] ?>" readonly/>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="showItemCode">Item Code</label>
                                                <input type="text" class="form-control form-control-sm" id="showItemCode" name="showItemCode" placeholder="Item Code" value="<?= $rows["itemCode"] ?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="showItemName">Item Name</label>
                                                <input type="text" class="form-control form-control-sm" id="showItemName" name="showItemName" placeholder="Item Name" value="<?= $rows["itemName"] ?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="showItemCategory">Item Category</label>
                                                <input type="text" class="form-control form-control-sm" id="showItemCategory" name="showItemCategory" placeholder="Item Castegory" value="<?= $rows["itemCategory"] ?>" readonly/>
                                                
                                            </div>
                                        </div>
                                       

                                          
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="showItemUom">UOM</label>
                                                <input type="text" class="form-control form-control-sm" id="editItemUom" name="showItemUom" placeholder="Item UOM" value="<?= $rows["Uom"] ?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="showItemPrice">Price</label>
                                                <input type="number" class="form-control form-control-sm" id="showItemPrice" name="showItemPrice" value="<?= $rows["Price"] ?>"  readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="showItemQty">Qty</label>
                                                <input type="number" class="form-control form-control-sm" id="showItemQty" name="showItemQty" value="<?= $rows["Qty"] ?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="showItemReOrder">Re-Order Level</label>
                                                <input type="number" class="form-control form-control-sm" id="showItemReOrder" name="showItemReOrder" value="<?= $rows["ReOrder"] ?>" readonly/>
                                            </div>
                                        </div>
                                        
                                            
                                        <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                    </div>

                                        <div class="card card-navy" id="switchStockDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">Switch Stock To:</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">

                                            <div class="form-group form-group-sm">
                                                <label for="toSwitchStock">Project Name</label>
                                                  <select id="toSwitchStock" name="toSwitchStock" class="form-control form-control-sm" data-dropdown-css-class="select2-navy">
                                                                
                                                                <?php 
                                                                    $databaseObj->select("tbl_manage_item");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                        $sno = 1;
                                                                        foreach($getData as $rows_manitem):
                                                                            $projectName = json_decode($rows_manitem["projectName"]);
                                                                            if($rows["projectName"]!=$rows_manitem["projectName"]){
                                                                            ?>                                     
                                                                        <option value="<?= $rows_manitem["projectName"] ?>"><?= $rows_manitem["projectName"]?></option>
                                                                            <?php
                                                                        }
                                                                        endforeach;
                                                                    endif;
                                                                ?>
                                                  </select>
                                            </div>
                                        </div>      
                                           <div class="col-md-3">
                                                        <div class="form-group form-group-sm">
                                                            <label for="Qtytogive">Quantity to give </label>
                                                            <input type="number" class="form-control form-control-sm" id="Qtytogive" name="Qtytogive">
                                                        </div>
                                            </div>
                                            
                                        <div class="col-md-3">
                                            <div class="form-group form-group-sm">
                                                <label for="switchStockDeptt">Department</label>
                                                <select id="switchStockDeptt" name="switchStockDeptt" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                 <!--  <option value="">Select Employees</option> -->
                                                <?php 
                                                    $databaseObj->select("tbl_manage_employee");
                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                    $getData = $databaseObj->get();
                                                    //Checking If Data Is Available
                                                    if($getData != 0):
                                                    $sno = 1;
                                                    foreach($getData as $rows):
                                                    $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                                    ?>
                                                  
                                                    <option value="<?= $rows["manage_employee_id"] ?>"><?= $manage_employee_info->department?></option>
                                                    <?php
                                                    endforeach;
                                                    endif;
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-sm">
                                                <label for="switchStockEmployee">Employee</label>
                                                <select id="switchStockEmployee" name="switchStockEmployee" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                 <!--  <option value="">Select Employees</option> -->
                                                <?php 
                                                    $databaseObj->select("tbl_manage_employee");
                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                    $getData = $databaseObj->get();
                                                    //Checking If Data Is Available
                                                    if($getData != 0):
                                                    $sno = 1;
                                                    foreach($getData as $rows):
                                                    $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                                    ?>
                                                  
                                                    <option value="<?= $rows["manage_employee_id"] ?>"><?= $manage_employee_info->firstName?><?= $manage_employee_info->lastName?></option>
                                                    <?php
                                                    endforeach;
                                                    endif;
                                                ?>
                                                </select>
                                            </div>
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
            // ------------ Fetch Switch Section End -----------
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