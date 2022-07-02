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
    $landAcquisitionLandsStoreDir = "../../../assets/admin/land-acquisition-lands/";
    $landAcquisitionLandsDir = "assets/admin/land-acquisition-lands/";
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
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/land-acquisition-lands.php">
                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_land">
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
                                        <th>Owner</th>
                                        <th>Location</th>
                                        <th>Land Information</th>
                                        <th>Purchase Information</th>
                                        <th>Payment Structure</th>
                                        <th>Attacments</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $databaseObj->select("tbl_land");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $databaseObj->order_by("`land_id` DESC");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                            $land_location = json_decode($rows["land_location"]);
                                                $land_info = json_decode($rows["land_info"]);
                                                $land_log = json_decode($rows["land_log"]);
                                    ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="icheck-navy d-inline">
                                                                <input type="checkbox" id="checkbox-<?= $rows["land_id"] ?>" name="checkbox-select[]" value="<?= $rows["land_id"] ?>" class="check-table">
                                                                <label for="checkbox-<?= $rows["land_id"] ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= $sno ?>.</td>
                                                        <td><?= $land_location->ownerName ?></td>
                                                        <td><button type="button" id="seeLandLocation-button-<?= $rows["land_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See"> <i class="fa fa-eye fa-sm"></i>
                                                                </button> </td>
                                                        <td><button type="button" id="seeLandType-button-<?= $rows["land_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See"><i class="fa fa-eye fa-sm"></i>
                                                                </button></td>
                                                        <td><button type="button" id="payment-structure-button-<?= $rows["land_id"] ?>" class="payment-structure-button btn btn-xs btn-danger mt-1 mb-1" title="Payment Structure Payments"><i class="fas fa-money-bill-wave fa-sm"></i>
                                                                </button>
                                                        </td>
                                                        <td><button type="button" id="payment-structure-chanage-button-<?= $rows["land_id"] ?>" class="payment-structure-chanage-button btn btn-xs btn-info mt-1 mb-1" title="Payment Structure"><i class="fa fa-money-check-alt fa-sm"></i></button>
                                                            <!-- <button type="button" id="payment-structure-edit-button-<?= $rows["land_id"] ?>" class="payment-structure-chanage-button btn btn-xs btn-info mt-1 mb-1" title="Payment Structure"><i class="fa fa-money-check-alt fa-sm"></i></button> --></td>
                                                        <td><button type="button" id="seeLandDocs-button-<?= $rows["land_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See"><i class="fa fa-eye fa-sm"></i>
                                                                </button></td>
                                                        <td class="text-center">
                                                            <div style="width:150px;">
                                                                <button type="button" id="information-button-<?= $rows["land_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">
                                                                    <i class="fa fa-scroll fa-sm"></i>
                                                                </button>
                                                              <!--   <button type="button" id="see-button-<?= $rows["land_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See">
                                                                    <i class="fa fa-eye fa-sm"></i>
                                                                </button> -->
                                                        <!--         <button type="button" id="edit-button-<?= $rows["land_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                                                    <i class="fa fa-edit fa-sm"></i>
                                                                </button> -->
                                                                <button type="button" id="delete-button-<?= $rows["land_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                    <i class="fa fa-trash fa-sm"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        // Information Section Start ---------------------------------------------------------------
                                                        $("#information-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#information-modal").modal('show');
                                                            $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchInformation","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
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
                                                        $("#see-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#see-modal").modal('show');
                                                            $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSee","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
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
                                                        $("#edit-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#edit-modal").modal('show');
                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchEdit","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
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
                                                        // Delete Section Start ---------------------------------------------------------------
                                                        $("#delete-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#delete-modal").modal('show');
                                                            $('#deleteButton').prop('disabled', true);
                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
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
                                                         // Land Location view Section Start ---------------------------------------------------------------
                                                        $("#seeLandLocation-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#seeLandLocation-modal").modal('show');
                                                            $('#seeLandLocation-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSeeLocation","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#see-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#seeLandLocation-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Land Location view End -----------------------------------------------------------------
                                                         // Land type Details view Section Start ---------------------------------------------------------------
                                                        $("#seeLandType-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#seeLandType-modal").modal('show');
                                                            $('#seeLandType-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSeeLandInformation","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#see-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#seeLandType-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Land Location view End -----------------------------------------------------------------
                                                        // Land Purchase Information view Section Start ---------------------------------------------------------------
                                                        $("#seeLandPurchase-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#seeLandPurchase-modal").modal('show');
                                                            $('#seeLandPurchase-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSeeLandPayment","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#see-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#seeLandPurchase-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Land Location view End -----------------------------------------------------------------
                                                         // Payment Structure Payment Section Start ---------------------------------------------------------------
                                                        $("#payment-structure-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#payment-structure-modal").modal('show');
                                                            $('#payment-structure-section').html('<center id = "payment-structure-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchPaymentStructure","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#payment-structure-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#payment-structure-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Payment Structure Pyament Section End -----------------------------------------------------------------
                                                         // Payment Structure change Section Start ---------------------------------------------------------------
                                                       $("#payment-structure-chanage-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#payment-structure-change-modal").modal('show');
                                                            $('#payment-structure-change-section').html('<center id = "payment-structure-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchPaymentStructureChange","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#payment-structure-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#payment-structure-change-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Payment Structure Section End -----------------------------------------------------------------
                                                        // Payment Structure Edit Section Start ---------------------------------------------------------------
                                                       $("#payment-structure-edit-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#payment-structure-change-modal").modal('show');
                                                            $('#payment-structure-change-section').html('<center id = "payment-structure-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchPaymentStructureEdit","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#payment-structure-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#payment-structure-change-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Payment Structure Section End -----------------------------------------------------------------



                                                        // Land Documents Details view Section Start ---------------------------------------------------------------
                                                        $("#seeLandDocs-button-<?= $rows["land_id"] ?>").click(function () {
                                                            $("#seeLandDocs-modal").modal('show');
                                                            $('#seeLandDocs-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSeeLandDocs","id":"<?= $rows["land_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-lands.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#see-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#seeLandDocs-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Land Location view End -----------------------------------------------------------------
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
            case "fetchLandPurchaseCondition":
                $databaseObj->select("tbl_land_purchase_condition");
                $databaseObj->where("`status` = '".$auth->visible()."'");
                $getData = $databaseObj->get();
                //Checking If Data Is Available
                if(count($getData) != 0):
                    $sno = 1;
                    foreach($getData as $rows):
                        $land_purchase_condition_info = json_decode($rows["land_purchase_condition_info"]);
                        ?>
                            <option value="<?= $rows["land_purchase_condition_id"] ?>"><?= $land_purchase_condition_info->landPurchaseCondition ?></option>
                        <?php
                    endforeach;
                endif;
                break;
            // ------------------------------------------------------
            // ------------ Fetch Owner Info Section Start ----------------
            // ------------------------------------------------------
            case "fetchOwnerInformations":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_owner");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `owner_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $owner_info = json_decode($rows["owner_info"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="number" class="form-control" value="<?= $owner_info->ownerContactNumber; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Office Number</label>
                                                <input type="number" class="form-control" value="<?= $owner_info->ownerOfficeNumber; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" value="<?= $owner_info->ownerEmail; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Website</label>
                                                <input type="url" class="form-control" value="<?= $owner_info->ownerWebsite; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pan No</label>
                                                <input type="number" class="form-control" value="<?= $owner_info->ownerPanNo; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Aadhar No</label>
                                                <input type="number" class="form-control" value="<?= $owner_info->ownerAadharNo; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>GST IN</label>
                                                <input type="text" class="form-control" value="<?= $owner_info->ownerGSTIN; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input type="text" class="form-control" value="<?= $owner_info->ownerState; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" value="<?= $owner_info->ownerCity; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pincode</label>
                                                <input type="text" class="form-control" value="<?= $owner_info->ownerPincode; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" readonly><?= $owner_info->ownerAddress; ?></textarea>
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
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchInformation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`land_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $land_log = json_decode($rows["land_log"]);
                                ?>
                                    <div class="row">
                                        <?php
                                            $sno = 1;
                                            foreach($land_log as $land_log_info):
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($land_log_info->action) ?> By</a></li>
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($land_log_info->action) ?> By - 
                                                                    <?php
                                                                        if($land_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$land_log_info->by."'");
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
                                                                    <?= date("l, M d, Y", strtotime($land_log_info->date)) ?> At <?= $land_log_info->at ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                                    <?= $land_log_info->ip ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                                    <?php
                                                                        $latLangArray = explode(",", $land_log_info->location);
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
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $land_location = json_decode($rows["land_location"]);
                                 $land_info = json_decode($rows["land_info"]);
                                ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Logo</h5>
                                                    <?php
                                                        if($land_info->landLogo == "default"):
                                                    ?>
                                                            <a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="Land Logo" class="table-see"></a>
                                                    <?php
                                                        else:
                                                    ?>
                                                            <a href="<?= $landAcquisitionLandsDir.$land_info->Logo ?>" target="_blank"><img src="<?= $landAcquisitionLandsDir.$land_info->landLogo ?>" alt="Land Logo" class="table-see"></a>
                                                    <?php 
                                                        endif;
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Land Type</h5>
                                                    <?= $land_info->landName ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Contact Number</h5>
                                                    <?= $land_info->landContactNumber ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Office Number</h5>
                                                    <?= $land_info->landOfficeNumber ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Email</h5>
                                                    <?= $land_info->landEmail ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Website</h5>
                                                    <?= $land_info->landWebsite ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">PanNo</h5>
                                                    <?= $land_info->landPanNo ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">AadharNo</h5>
                                                    <?= $land_info->landAadharNo ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">GST IN</h5>
                                                    <?= $land_info->landGSTIN ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">City</h5>
                                                    <?= $land_location->landCity ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">State</h5>
                                                    <?= $land_location->landState ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Pincode</h5>
                                                    <?= $land_location->landPincode ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Address</h5>
                                                    <?= $land_location->landAddress ?>
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
            // -------- Fetch See Location Section Start ------------
            // ------------------------------------------------------
            case "fetchSeeLocation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $land_location = json_decode($rows["land_location"]);
                                 $land_info = json_decode($rows["land_info"]);
                                ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">State</h5>
                                                    <?= $land_location->landState ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Unit</h5>
                                                    <?= $land_location->landUnit ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Sub Unit</h5>
                                                    <?= $land_location->landSubUnit ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Street Name</h5>
                                                    <?= $land_location->landStreetName ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Land Mark</h5>
                                                    <?= $land_location->landLandMark ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Line No</h5>
                                                    <?= $land_location->landLineNo ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Pincode</h5>
                                                    <?= $land_location->landPincode ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Address</h5>
                                                    <?= $land_location->landAddress ?>
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
            // ------------ Fetch See Location Section End -------------------
            // ------------------------------------------------------
           
            // ------------------------------------------------------
            // ------------ Fetch Edit Section Start ----------------
            // ------------------------------------------------------
            case "fetchEdit":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $land_info = json_decode($rows["land_info"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandLogo">Land Logo</label>
                                                <input type="file" class="form-control" id="editLandLogo" name="editLandLogo" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandName">Land Name</label>
                                                <input type="text" class="form-control" id="editLandName" name="editLandName" placeholder="Land Name" value="<?= $land_info->landName; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandContactNumber">Contact Number</label>
                                                <input type="number" class="form-control" id="editLandContactNumber" name="editLandContactNumber" placeholder="Contact Number" value="<?= $land_info->landContactNumber; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandOfficeNumber">Office Number</label>
                                                <input type="number" class="form-control" id="editLandOfficeNumber" name="editLandOfficeNumber" placeholder="Office Number" value="<?= $land_info->landOfficeNumber; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandEmail">Email</label>
                                                <input type="text" class="form-control" id="editLandEmail" name="editLandEmail" placeholder="Email" value="<?= $land_info->landEmail; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandWebsite">Website</label>
                                                <input type="url" class="form-control" id="editLandWebsite" name="editLandWebsite" placeholder="Website" value="<?= $land_info->landWebsite; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandPanNo">Pan No</label>
                                                <input type="number" class="form-control" id="editLandPanNo" name="editLandPanNo" placeholder="Pan No" value="<?= $land_info->landPanNo; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandAadharNo">Aadhar No</label>
                                                <input type="number" class="form-control" id="editLandAadharNo" name="editLandAadharNo" placeholder="Aadhar No" value="<?= $land_info->landAadharNo; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandGSTIN">GST IN</label>
                                                <input type="text" class="form-control" id="editLandGSTIN" name="editLandGSTIN" placeholder="GST IN" value="<?= $land_info->landGSTIN; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandState">State</label>
                                                <select class="form-control select2" id="editLandState" name="editLandState">
                                                    <option value="">Select State</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandCity">City</label>
                                                <select class="form-control select2" id="editLandCity" name="editLandCity">
                                                    <option value="">Select State First</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editLandPincode">Pincode</label>
                                                <input type="text" class="form-control" id="editLandPincode" name="editLandPincode" placeholder="Pincode" value="<?= $land_info->landPincode; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editLandAddress">Address</label>
                                                <textarea class="form-control" id="editLandAddress" name="editLandAddress" placeholder="Address"><?= $land_info->landAddress; ?></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                    </div>
                                    <script>
                                        $(function(){
                                            $('.select2').select2();
                                            // City And State Section Start -----------------------------------------------------------------------------------------------------
                                            $("#editLandState").html("<option>Please Wait...</option>");
                                            $("#editLandState").prop("disabled", true);
                                            $("#editLandCity").prop("disabled", true);
                                            var formData = '{"request": "fetch","request_for": "states","country_name": "india"}';
                                            $.ajax({
                                                url: 'https://et-azad.com/api/country-api/states.php',
                                                type: 'POST',
                                                data: formData,
                                                dataType: "json",
                                                success: function (data) {
                                                    $("#editLandState").html("<option>Select And Update</option>");
                                                    //Store All Start
                                                    data.response_data.forEach(appendAll);
                                                    function appendAll(name, val) {
                                                      $("#editLandState").append('<option value="'+ name +'" >'+ name +'</option>');
                                                    }
                                                    //Store All End
                                                    setTimeout(function(){
                                                        $("#editLandState").prop("disabled", false);
                                                        $("#editLandCity").prop("disabled", false);
                                                        $("#editLandState").val("<?= $land_info->landState; ?>");
                                                        if($("#editLandState").val() != ""){
                                                            $("#editLandCity").html("<option>Please Wait...</option>");
                                                            $("#editLandState").prop("disabled", true);
                                                            $("#editLandCity").prop("disabled", true);
                                                            var formData = '{"request": "fetch","request_for": "cities","country_name": "india","state_name": "'+ $("#editLandState").val() +'"}';
                                                            $.ajax({
                                                                url: 'https://et-azad.com/api/country-api/cities.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                dataType: "json",
                                                                success: function (data) {
                                                                    $("#editLandCity").html("<option>Select And Update</option>");
                                                                    //Store All Start
                                                                    data.response_data.forEach(appendAll);
                                                                    function appendAll(name, val) {
                                                                      $("#editLandCity").append('<option value="'+ name +'">'+ name +'</option>');
                                                                    }
                                                                    //Store All End
                                                                    setTimeout(function(){
                                                                        $("#editLandState").prop("disabled", false);
                                                                        $("#editLandCity").prop("disabled", false);
                                                                        $("#editLandCity").val("<?= $land_info->landCity; ?>");
                                                                    }, 1000);
                                                                },
                                                                error: function (data) {
                                                                    $("#editLandCity").html("<option>Unable to find Cities...</option>");
                                                                },
                                                                cache: false,
                                                                contentType: false,
                                                                processData: false
                                                            });
                                                        }
                                                    }, 1000);
                                                },
                                                error: function (data) {
                                                    $("#editLandState").html("<option>Unable to find States...</option>");
                                                },
                                                cache: false,
                                                contentType: false,
                                                processData: false
                                            });
                                            $("#editLandState").change(function(){
                                                $("#editLandCity").html("<option>Please Wait...</option>");
                                                $("#editLandState").prop("disabled", true);
                                                $("#editLandCity").prop("disabled", true);
                                                var formData = '{"request": "fetch","request_for": "cities","country_name": "india","state_name": "'+ $("#editLandState").val() +'"}';
                                                $.ajax({
                                                    url: 'https://et-azad.com/api/country-api/cities.php',
                                                    type: 'POST',
                                                    data: formData,
                                                    dataType: "json",
                                                    success: function (data) {
                                                        $("#editLandCity").html("<option>Select</option>");
                                                        //Store All Start
                                                        data.response_data.forEach(appendAll);
                                                        function appendAll(name, val) {
                                                          $("#editLandCity").append('<option value="'+ name +'">'+ name +'</option>');
                                                        }
                                                        //Store All End
                                                        setTimeout(function(){
                                                            $("#editLandState").prop("disabled", false);
                                                            $("#editLandCity").prop("disabled", false);
                                                        }, 1000);
                                                    },
                                                    error: function (data) {
                                                        $("#editLandCity").html("<option>Unable to find Cities...</option>");
                                                    },
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false
                                                });
                                            });
                                        });
                                    </script>
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
                        <input type="hidden" id="tableName" name="tableName" value="tbl_land" />
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
            // -------- Fetch See Land Information Section Start ------------
            // ------------------------------------------------------
            case "fetchSeeLandInformation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):                  
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $land_location = json_decode($rows["land_location"]);
                                 $land_info = json_decode($rows["land_info"]);
                                  foreach($land_info->landInfo as $land_info_arr):
                                    // code for fetch uom data from tbl_uom
                                ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Land Type</h5>
                                                    <?= $land_info_arr->landType ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Area</h5>
                                                      <?= $land_info_arr->landArea ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Unit of Measurement</h5>
                                                    <?php
                                                        $databaseObj->select("tbl_uom");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `uom_id` = '".$land_info_arr->UOM."'");
                                                            $getData = $databaseObj->get();
                                                            if($getData != 0):
                                                             $sno = 1;
                                                             foreach($getData as $rows_uom):
                                                               $uom_info = json_decode($rows_uom["uom_info"]);
                                                               echo $uom_info->uom;
                                                             endforeach;
                                                            endif;
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Price Per <?php echo $uom_info->uom;?></h5>
                                                    <?= $land_info_arr->landPricePerUOM ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Total Price</h5>
                                                    <?= $land_info_arr->landTotalPrice ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Remarks</h5>
                                                    <?php if($land_info_arr->landRemarks=='')
                                                    { echo "No Remarks";} 
                                                    else{
                                                        echo $land_info_arr->landRemarks;
                                                    }?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Total Complete Price</h5>
                                                    <?= $land_info->TotalCompletePrice ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Address</h5>
                                                    <?= $land_location->landAddress ?>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                endforeach;
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
            // ------------ Fetch See Location Section End -------------------
            // ------------------------------------------------------

             // -----------------------------------------------------------------------------
            // ------------ Fetch Payment Structure Payments Section Start -----------------
            // -----------------------------------------------------------------------------
            case "fetchPaymentStructure":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $land_payment = json_decode($rows["land_payment"]);
                                 $land_purchase = json_decode($rows["land_purchase"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-bordered table-striped dataTable" id="edit_dynamic_field">
                                                <thead>
                                                    <th>S. No.</th>  
                                                    <th>When</th>
                                                    <th>Date</th>
                                                    <th>Percentage Of Amount</th>
                                                    <th>Amount</th>
                                                    <th>Remark</th>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $noOfRows = 1;
                                                        $totalPer = 0.00;
                                                        $totalAmount = 0.00;
                                                        $totalPaid = 0.00;
                                                        foreach($land_payment->landPaymentInfo as $land_payment_all):
                                                            $totalPer = $totalPer + floatval($land_payment_all->completion);
                                                            $totalAmount = $totalAmount + floatval($land_payment_all->amount);
                                                    ?>
                                                    <tr>
                                                        <td><span class="p-3 mt-2"><?= $noOfRows ?>.</span></td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:150px;">
                                                                    <?= $land_payment_all->when ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                          <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:150px;">
                                                                    <?= $land_payment_all->date ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:150px;">
                                                                    <input type="number" class="form-control " value="<?= $land_payment_all->completion ?>" readonly/>
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger">%</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:200px;">
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                    </div>
                                                                    <input type="number" class="form-control"  value="<?= $land_payment_all->amount ?>" readonly/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <input type="text" class="form-control" value="<?= $land_payment_all->remark ?>" readonly style="width:200px;"/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                            $noOfRows++;
                                                        endforeach;
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:150px;">
                                                                     <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                    </div>
                                                                    <input type="number" class="form-control " value="<?= $land_purchase->dealingPrice; ?>" readonly/>
                                                                   
                                                                </div>
                                                            </div>
                                                        </th>
                                                         <th></th>
                                                        <th>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:150px;">
                                                                    <input type="number" class="form-control " value="<?php printf("%.2f", $totalPer) ?>" readonly/>
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger">%</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:200px;">
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                    </div>
                                                                    <input type="number" class="form-control"  value="<?php printf("%.2f", $totalAmount) ?>" readonly/>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
            // -----------------------------------------------------------------------------
            // ------------ Fetch Payment Structure Payments Section End -------------------
            // -----------------------------------------------------------------------------
           // --------------------------------------------------------------------
            // ------------ Fetch Payment Structure Section Start -----------------
            // --------------------------------------------------------------------
            case "fetchPaymentStructureChange":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                             foreach($getData as $rows):
                                 $land_purchase = json_decode($rows["land_purchase"]);
                                 $land_payment = json_decode($rows["land_payment"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-bordered table-striped dataTable" id="edit_dynamic_field">
                                             <thead>
                                                    <th>S. No.</th>  
                                                    <th>When</th>
                                                    <th>Date</th>
                                                    <th>Percentage Of Amount</th>
                                                    <th>Amount</th>
                                                    <th>Remark</th>
                                                    <th>Add</th>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $noOfRows = 1;
                                                        $totalPer = 0.00;
                                                        $totalAmount = 0.00;
                                                        //$totalPaid = 0.00;
                                                        foreach($land_payment->landPaymentInfo as $land_payment_all):
                                                            $totalPer = $totalPer + floatval($land_payment_all->completion);
                                                            $totalAmount = $totalAmount + floatval($land_payment_all->amount);
                                                            // $totalPaid = $totalPaid + floatval($land_payment_all->paymentStucturePaid);
                                                    ?>
                                                    <tr>
                                                        <td><span class="p-3 mt-2"><?= $noOfRows ?>.</span></td>
                                                        <td>
                                                           <div class="form-group mb-0">
                                                                                <input id="landPurchasePaymentStuctureWhen1" name="landPurchasePaymentStuctureWhen[]" type="text" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" value="<?=$land_payment_all->when ?>" readonly/>
                                                                            </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                                <input id="landPurchasePaymentStuctureDate1" name="landPurchasePaymentStuctureDate[]" type="date" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" value="<?=$land_payment_all->date ?>" readonly />
                                                                            </div>
                                                        </td>
                                                        <td>
                                                             <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:150px;">
                                                                                    <input id="landPurchasePaymentStuctureCompletion1" name="landPurchasePaymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" value="<?=$land_payment_all->completion ?>" readonly />
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger">%</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                        </td>
                                                        <td>
                                                                         <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:300px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                                    </div>
                                                                                    <input id="landPurchasePaymentStuctureAmount1" name="landPurchasePaymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();"  value="<?=$land_payment_all->amount ?>" readonly/>
                                                                                </div>
                                                                            </div>
                                                        </td>
                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <input id="landPurchasePaymentStuctureRemark1" name="landPurchasePaymentStuctureRemark[]" type="text" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" value="<?=$land_payment_all->remark ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                        <td>
                                                                            <button type="button" name="add" id="add_2" class="btn btn-warning " onclick="calculateAmount();" onkeyup="calculateAmount();"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                        </td>
                                                    </tr>
                                                    <?php 
                                                            $noOfRows++;
                                                        endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
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
            // -----------------------------------------------------------------------------
            // ------------ Fetch Payment Structure Payments Section End -------------------
            // -----------------------------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Edit Section Start ----------------
            // ------------------------------------------------------
            case "fetchEdit":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_info = json_decode($rows["projects_info"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editProjectName">Project Name</label>
                                                <input type="text" class="form-control" id="editProjectName" name="editProjectName" placeholder="Projects" value="<?= $customer_info->projectName ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editProjectLocation">Project Location</label>
                                                <input type="text" class="form-control" id="editProjectLocation" name="editProjectLocation" placeholder="Project Location" value="<?= $customer_info->projectLocation ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editProjectLocationMapUrl">Project Location Map URL</label>
                                                <input type="text" class="form-control" id="editProjectLocationMapUrl" name="editProjectLocationMapUrl" placeholder="Project Location Map URL" value="<?= $customer_info->projectLocationMapUrl ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="editProjectStartingDate">Project Starting Date</label>
                                                <input type="date" class="form-control" id="editProjectStartingDate" name="editProjectStartingDate" placeholder="Project Starting Date" value="<?= $customer_info->projectStartingDate ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="editProjectExpectedEndingDate">Project Expected Ending Date</label>
                                                <input type="date" class="form-control" id="editProjectExpectedEndingDate" name="editProjectExpectedEndingDate" placeholder="Project Expected Ending Date" value="<?= $customer_info->projectExpectedEndingDate ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="editProjectEndingDate">Project Ending Date</label>
                                                <input type="date" class="form-control" id="editProjectEndingDate" name="editProjectEndingDate" placeholder="Project Ending Date" value="<?= $customer_info->projectEndingDate ?>">
                                                <small class="text-red">Define this date after the completion of project</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-bordered" id="edit_dynamic_field">
                                                <thead>
                                                    <tr>
                                                        <th data-field="S. No." data-sortable="true">S.No.</th>
                                                        <th data-field="Property Type" data-sortable="true">Property Type</th>
                                                        <th data-field="Accommodation Type" data-sortable="true">Accommodation Type</th>
                                                        <th data-field="Square Feet" data-sortable="true">Square Feet</th>
                                                        <th data-field="Price" data-sortable="true">Price</th>
                                                        <th data-field="Availability" data-sortable="true">Availability</th>
                                                        <th data-field="Starting Date" data-sortable="true">Starting Date</th>
                                                        <th data-field="Expected Ending Date" data-sortable="true">Expected Ending Date</th>
                                                        <th data-field="Ending Date" data-sortable="true">Ending Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $noOfProperties = 1;
                                                        foreach($customer_info->properties as $properties):
                                                    ?>
                                                    <?php 
                                                        if($noOfProperties == 1):
                                                    ?>
                                                        <tr>
                                                    <?php 
                                                        else:
                                                    ?>
                                                            <tr id="row<?= $noOfProperties."_".$rows["customer_id"] ?>" class="dynamic-added" >
                                                    <?php 
                                                        endif;
                                                    ?>
                                                        <td>
                                                            <span class="p-3 mt-2"><?= $noOfProperties ?>.</span>
                                                        </td>
                                                        <td>
                                                            <select id="propertyType<?= $noOfProperties."_".$rows["customer_id"] ?>" name="propertyType[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;">
                                                                <?php 
                                                                    $databaseObj->select("tbl_property_type");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                        $sno = 1;
                                                                        foreach($getData as $rows_prop):
                                                                            $property_type_info = json_decode($rows_prop["property_type_info"]);
                                                                            ?>
                                                                                <option value="<?= $rows_prop["property_type_id"] ?>" <?php if($properties->propertyType == $rows_prop["property_type_id"]) echo "selected" ?>><?= $property_type_info->propertyType ?></option>
                                                                            <?php
                                                                        endforeach;
                                                                    endif;
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select id="accommodationType<?= $noOfProperties."_".$rows["customer_id"] ?>" name="accommodationType[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;">
                                                                <?php 
                                                                    $databaseObj->select("tbl_accommodation_type");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                        $sno = 1;
                                                                        foreach($getData as $rows_acco):
                                                                            $accommodation_type_info = json_decode($rows_acco["accommodation_type_info"]);
                                                                            ?>
                                                                                <option value="<?= $rows_acco["accommodation_type_id"] ?>" <?php if($properties->availablility == $rows_acco["accommodation_type_id"]) echo "selected" ?> ><?= $accommodation_type_info->accommodationType ?></option>
                                                                            <?php
                                                                        endforeach;
                                                                    endif;
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="squareFeet<?= $noOfProperties."_".$rows["customer_id"] ?>" name="squareFeet[]" type="number" min="0" class="form-control" style="width:150px;" value="<?= $properties->squareFeet ?>" />
                                                        </td>
                                                        <td>
                                                            <input id="price<?= $noOfProperties."_".$rows["customer_id"] ?>" name="price[]" type="number" min="0" class="form-control" style="width:150px;" value="<?= $properties->price ?>" />
                                                        </td>
                                                        <td>
                                                            <input id="availablility<?= $noOfProperties."_".$rows["customer_id"] ?>" name="availablility[]" type="number" min="0" class="form-control" style="width:100px;" value="<?= $properties->availablility ?>" />
                                                        </td>
                                                        <td>
                                                            <input id="StartingDate<?= $noOfProperties."_".$rows["customer_id"] ?>" name="StartingDate[]" type="date" class="form-control" style="width:180px;" value="<?= $properties->StartingDate ?>" />
                                                        </td>
                                                        <td>
                                                            <input id="ExpectedEndingDate<?= $noOfProperties."_".$rows["customer_id"] ?>" name="ExpectedEndingDate[]" type="date" class="form-control" style="width:180px;" value="<?= $properties->ExpectedEndingDate ?>" />
                                                        </td>
                                                        <td>
                                                            <input id="EndingDate<?= $noOfProperties."_".$rows["customer_id"] ?>" name="EndingDate[]" type="date" class="form-control" style="width:180px;" value="<?= $properties->EndingDate ?>" />
                                                            <small class="text-red">When this property will completed</small>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($noOfProperties == 1):
                                                            ?>
                                                                    <button type="button" name="editAdd" id="editAdd" class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                            <?php 
                                                                else:
                                                            ?>
                                                                    <button type="button" name="remove" id="<?= $noOfProperties."_".$rows["customer_id"] ?>" class="btn btn-danger btn_remove">X</button>
                                                            <?php 
                                                                endif;
                                                            ?>
                                                        </td>

                                                    </tr>
                                                    <?php 
                                                            $noOfProperties++;
                                                        endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>  
                                        <input type="hidden" value="<?= --$noOfProperties ?>" id="editTotalProperty" name="editTotalProperty" />
                                        <input type="hidden" id="editTableId" name="editTableId" value="<?= $_POST["id"] ?>" />
                                    </div>
                                    <script>
                                        $(function(){
                                            //Multiple Rows Section Start ------------------------------------------------------------------------------------------------------------------   
                                            var i=<?= $noOfProperties ?>;

                                            $('#editAdd').click(function(){
                                                i++; 
                                                $('#edit_dynamic_field').append('<tr id="row'+i+'<?= "_".$rows["customer_id"] ?>" class="dynamic-added" ><td><span class="p-3 mt-2">'+i+'.</span></td><td> <select id="propertyType'+i+'<?= "_".$rows["customer_id"] ?>" name="propertyType[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;"><?php $databaseObj->select("tbl_property_type");  $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1;  foreach($getData as $rows_prop): $property_type_info = json_decode($rows_prop["property_type_info"]); ?><option value="<?= $rows_prop["property_type_id"] ?>"><?= $property_type_info->propertyType ?></option>  <?php endforeach; endif; ?> </select></td><td><select id="accommodationType'+i+'<?= "_".$rows["customer_id"] ?>" name="accommodationType[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;"> <?php  $databaseObj->select("tbl_accommodation_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows_acco): $accommodation_type_info = json_decode($rows_acco["accommodation_type_info"]); ?> <option value="<?= $rows_acco["accommodation_type_id"] ?>"><?= $accommodation_type_info->accommodationType ?></option> <?php endforeach; endif; ?> </select> </td> <td>' +
                                                '<input id="squareFeet'+i+'<?= "_".$rows["customer_id"] ?>" name="squareFeet[]" type="number" min="0" class="form-control" style="width:150px;" /> </td> <td> <input id="price'+i+'<?= "_".$rows["customer_id"] ?>" name="price[]" type="number" min="0" class="form-control" style="width:150px;" /> </td> <td> <input id="availablility'+i+'<?= "_".$rows["customer_id"] ?>" name="availablility[]" type="number" min="0" class="form-control" style="width:100px;" /> </td><td><input id="StartingDate'+i+'<?= "_".$rows["customer_id"] ?>" name="StartingDate[]" type="date" class="form-control" style="width:180px;" /></td><td><input id="ExpectedEndingDate'+i+'<?= "_".$rows["customer_id"] ?>" name="ExpectedEndingDate[]" type="date" class="form-control" style="width:180px;" /></td><td><input id="EndingDate'+i+'<?= "_".$rows["customer_id"] ?>" name="EndingDate[]" type="date" class="form-control" style="width:180px;" /><small class="text-red">When this property will completed</small></td> <td><button type="button" name="remove" id="'+i+'<?= "_".$rows["customer_id"] ?>" class="btn btn-danger btn_remove">X</button></td></tr>');
                                                $("#editTotalProperty").val(i);
                                            });
                                            $(document).on('click', '.btn_remove', function(){  
                                               var button_id = $(this).attr("id");   
                                               $('#row'+button_id+'').remove(); 
                                               i--;
                                               $("#editTotalProperty").val(i);
                                            }); 
                                            //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
                                        });
                                    </script>
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
            // --------------------------------------------------------------------
            // ------------ Fetch Payment Structure Section End -------------------
            // --------------------------------------------------------------------
           // --------------------------------------------------------------------
            // ------------ Fetch Payment Structure Section Start -----------------
            // --------------------------------------------------------------------
            case "fetchPaymentStructureEdit":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $land_purchase = json_decode($rows["land_purchase"]);
                                $land_payment = json_decode($rows["land_payment"]);
                                
                                ?>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            
                                                <table class="table table-bordered table-striped dataTable" id="dynamic_field_2">
                                                                <thead>
                                                                    <th>S. No.</th>
                                                                    <th>When</th>
                                                                    <th>Date</th>
                                                                    <th>Percentage Of Amount</th>
                                                                    <th>Amount</th>
                                                                    <th>Remark</th>
                                                                    <th>Action</th>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                     $noOfRows = 1;
                                                                        foreach($land_payment->landPaymentInfo as $landPaymentInfo_all):
                                                                    ?>
                                                                    <tr>
                                                                        <td><span class="p-3 mt-2"><?php echo $noOfRows;?></span></td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <input type="hidden" value="<?php echo $noOfRows; ?>" id="totalNumberOfDivision" name="totalNumberOfDivision"/>
                                                                                <input id="landPurchaseDealingPriceEdit" name="landPurchaseDealingPriceEdit" type="text" class="form-control" value="<?= $land_purchase->dealingPrice ?>"/>

                                                                                <input id="landPurchasePaymentStuctureWhen1" name="landPurchasePaymentStuctureWhen[]" type="text" class="form-control " onclick="calculateAmountEdit();" onkeyup="calculateAmountEditEdit();" style="width:200px;" value="<?= $landPaymentInfo_all->when ?>" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <input id="landPurchasePaymentStuctureDate1" name="landPurchasePaymentStuctureDate[]" type="date" class="form-control " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" style="width:200px;" value="<?= $landPaymentInfo_all->date ?>" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:150px;">
                                                                                    <input id="landPurchasePaymentStuctureCompletion1" name="landPurchasePaymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" value="<?= $landPaymentInfo_all->completion ?>" />
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger">%</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:300px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                                    </div>
                                                                                    <input id="landPurchasePaymentStuctureAmount1" name="landPurchasePaymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" value="<?= $landPaymentInfo_all->amount ?>" readonly/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <input id="landPurchasePaymentStuctureRemark1" name="landPurchasePaymentStuctureRemark[]" type="text" class="form-control " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" style="width:200px;"  value="<?= $landPaymentInfo_all->remark ?>" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" name="add" id="add_2" class="btn btn-warning " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                        </td>
                                                                    </tr>

                                                                    <?php
                                                                    $noOfRows++;
                                                                     endforeach;
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                    <script>
                                       // Calculate Percentage Section Start ---------------------------------------------------------------------------------------------------------- 
function calculateAmountEdit() {
    //Toast Setting Section Start ------------------------------------------------------------------------------------------------------------------
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
    
    fullPercentage = (100).toFixed(2);
    if($('#landPurchaseDealingPriceEdit').val() == ""){
        topEndNotification("warning", "Please mention Dealing price first!!!");
    } else{
        var addedPercentage = (0).toFixed(2);
        var addedPercentageOld = (0).toFixed(2);
        var check = "";
        var flag = 1;
        var totalRows = $("#totalNumberOfDivision").val();
        for(i = 1; i <= totalRows; i++){
            //Checking empty and filled up rows Section Start
            if($("#landPurchasePaymentStuctureWhen"+i).val() == ""){
                $("#landPurchasePaymentStuctureWhen"+i).addClass("is-invalid");
                flag = 0;
            }else
                $("#landPurchasePaymentStuctureWhen"+i).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureDate"+i).val() == ""){
                $("#landPurchasePaymentStuctureDate"+i).addClass("is-invalid");
                flag = 0;
            }else
                $("#landPurchasePaymentStuctureDate"+i).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureCompletion"+i).val() == ""){
                $("#landPurchasePaymentStuctureCompletion"+i).addClass("is-invalid");
                $("#landPurchasePaymentStuctureAmount"+i).addClass("is-invalid");
                $("#landPurchasePaymentStuctureAmount"+i).val("");
            }else{
                if(flag == 1){
                    $("#landPurchasePaymentStuctureCompletion"+i).removeClass("is-invalid");
                    $("#landPurchasePaymentStuctureAmount"+i).removeClass("is-invalid");
                    var priceOfProperty = $("#landPurchaseDealingPrice").val();
                    var percentageOfOne = priceOfProperty/100;
                    addedPercentage = Number(addedPercentage) + Number($("#landPurchasePaymentStuctureCompletion"+i).val());
                    if(Number(addedPercentage) > Number(100)){
                        $("#landPurchasePaymentStuctureCompletion"+i).addClass("is-invalid");
                        $("#landPurchasePaymentStuctureAmount"+i).addClass("is-invalid");
                        $("#landPurchasePaymentStuctureCompletion"+i).val("");
                        $("#landPurchasePaymentStuctureCompletion"+i).prop("placeholder", (100.00 - addedPercentageOld).toFixed(2));
                        $("#landPurchasePaymentStuctureAmount"+i).val("");
                        check = "exceedPercentage";
                    } else{
                        var thisAmount = Number(percentageOfOne) * Number($("#landPurchasePaymentStuctureCompletion"+i).val());
                        $("#landPurchasePaymentStuctureAmount"+i).val((thisAmount).toFixed(2));
                    }
                } else{
                    check = "emptyData";
                }
            }
            addedPercentageOld = addedPercentage;
            //Checking empty and filled up rows Section End
        }
        switch(check){
            case "exceedPercentage":
                topEndNotification("warning", "The addition of Completeion % should be equal to 100%!!!");
                break;
            case "emptyData":
                topEndNotification("warning", "Please fill out required fields!!!");
                break;
        }
    }
}
// Calculate Percentage Section End ------------------------------------------------------------------------------------------------------------
    //Add Dynamic Payment Structure Section Start ------------------------------------------------------------------------------------------------------
$(function(){
    //Toast Setting Section Start ------------------------------------------------------------------------------------------------------------------
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
    //Multiple Rows Section Start ------------------------------------------------------------------------------------------------------------------   
    var i=1;  
    $('#add_2').click(function(){
        var addedPercentage = (0).toFixed(2);
        var check = "";
        var checkExceed = "";  
        var totalRows = $("#totalNumberOfDivision").val();
        for(j = 1; j <= totalRows; j++){
            if($("#landPurchasePaymentStuctureWhen"+j).val() == ""){
                $("#landPurchasePaymentStuctureWhen"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#landPurchasePaymentStuctureWhen"+j).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureDate"+j).val() == ""){
                $("#landPurchasePaymentStuctureDate"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#landPurchasePaymentStuctureDate"+j).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureCompletion"+j).val() == ""){
                $("#landPurchasePaymentStuctureCompletion"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#landPurchasePaymentStuctureCompletion"+j).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureAmount"+j).val() == ""){
                $("#landPurchasePaymentStuctureAmount"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#landPurchasePaymentStuctureAmount"+j).removeClass("is-invalid");
            addedPercentage = Number(addedPercentage) + Number($("#landPurchasePaymentStuctureCompletion"+j).val());
//            console.log(addedPercentage);
            if(Number(addedPercentage) >= Number(100))
                checkExceed = "exceedPercentage";
        }
        if(check != "emptyRows" && checkExceed != "exceedPercentage"){
            i++; 
            $('#dynamic_field_2').append('<tr id="row_2_'+i+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+i+'.</span></td> <td>  <div class="form-group mb-0"> <input id="landPurchasePaymentStuctureWhen'+i+'" name="landPurchasePaymentStuctureWhen[]" type="text" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" />  </div> </td> <td> <div class="form-group mb-0"> <input id="landPurchasePaymentStuctureDate'+i+'" name="landPurchasePaymentStuctureDate[]" type="date" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" /> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:150px;"> <input id="landPurchasePaymentStuctureCompletion'+i+'" name="landPurchasePaymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();"/> <div class="input-group-prepend"> <button type="button" class="btn btn-danger">%</button> </div> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:300px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger">&#8377;</button> </div> <input id="landPurchasePaymentStuctureAmount'+i+'" name="landPurchasePaymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" readonly/> </div> </div> </td> <td> <div class="form-group mb-0"> <input id="landPurchasePaymentStuctureRemark'+i+'" name="landPurchasePaymentStuctureRemark[]" type="text" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" /> </div> </td> <td><button type="button" name="remove" id="_2_'+i+'" class="btn btn-danger btn_remove_2 " onclick="calculateAmount();" onkeyup="calculateAmount();">X</button></td></tr>');
            $("#totalNumberOfDivision").val(i);
        } else if(checkExceed == "exceedPercentage")
            topEndNotification("warning", "100% completed! You are not able to add more rows!!!");
        else
            topEndNotification("warning", "Please first complete existing rows");
    });
    $(document).on('click', '.btn_remove_2', function(){  
       var button_id = $(this).attr("id");   
       $('#row'+button_id+'').remove(); 
       i--;
       $("#totalNumberOfDivision").val(i);
    }); 
    //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
});
//Add Dynamic Payment Structure Section End --------------------------------------------------------------------------------------------------------
                                
        </script>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                                Something went wrong plase try again or refresh.1
                            </div>
                            <?php
                        endif;
                    else:
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.2
                        </div>
                        <?php
                    endif;
                else:
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                        You have no permission to see the information of this Data.3
                    </div>
                    <?php
                endif;
                break;
            // --------------------------------------------------------------------
            // ------------ Fetch Payment Structure Section End -------------------
            // --------------------------------------------------------------------



              // -----------------------------------------------------------------------------
            // ------------ Fetch Docs Section Start -----------------
            // -----------------------------------------------------------------------------
            case "fetchSeeLandDocs":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        $num_doc=1;$num_pdf=1;$num_xl=1;
                        if($getData != 0):
                            foreach($getData as $rows):
                                $land_docs = json_decode($rows["land_docs"]);
                                ?>
                                    <div class="row">
                                            <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Images</h5>
                                                    <?php
                                                        $land_image_arr=explode(",", $land_docs->landImages);
                                                          $last_key = array_key_last($land_image_arr);
                                                        foreach ($land_image_arr as  $key => $landImage){
                                                            if($landImage=='empty'){
                                                                echo "No Image";  
                                                            }else{
                                                                if ($key != $last_key) {
                                                                             echo "<img src='{$landAcquisitionLandsDir}{$landImage}' alt='' class='img-thumbnail' style='width:150px;'/>";
                                                                    }                                                           
                                                            }  
                                                        }
                                                    ?>
                                                    <?php //if($land_docs->landImages=="empty,")
                                                    //     {echo "No Image";}
                                                    //     else{ echo "<img src='{$landAcquisitionLandsDir}{$land_docs->landImages}' style='width:100px;'>"; }  ?>
                                                </div>
                                            </div>
                                             <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Docs</h5>
                                                    <?php
                                                        $land_docs_arr=explode(",", $land_docs->landDocs);
                                                        $last_key = array_key_last($land_docs_arr);
                                                        foreach ($land_docs_arr as $key => $landDocs){
                                                            if($landDocs=='empty'){
                                                                 echo "No Documents";  
                                                            }else{
                                                                if ($key != $last_key) {
                                                                    $num=$key;
                                                                    $num++;
                                                                    echo "<a href='{$landAcquisitionLandsDir}{$landDocs}' download='{$landDocs}'><button type='button' class='btn btn-primary mr-2'>Doc {$num_doc}</button></a>";
                                                                    }                                                           
                                                            }$num_doc++;
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Pdf</h5>
                                                    <?php
                                                        $land_pdfs_arr=explode(",", $land_docs->landPdfs);
                                                        $last_key = array_key_last($land_pdfs_arr);
                                                        foreach ($land_pdfs_arr as $key => $landPdfs){
                                                               if($landPdfs =='empty'){
                                                                 echo "No PDFs";  
                                                                }else{
                                                                if ($key != $last_key) {
                                                                    echo "<a href='{$landAcquisitionLandsDir}{$landPdfs}' download='{$landPdfs}'><button type='button' class='btn btn-primary mr-2'>Pdf {$num_pdf}</button></a>";
                                                                    }                                                               
                                                                }    
                                                             $num_pdf++; 
                                                        }

                                                    ?>
                                                </div>
                                            </div>
                                           
                                             <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Excel</h5>    
                                                    <?php
                                                        $land_excel_arr=explode(",", $land_docs->landExcel);
                                                        $last_key = array_key_last($land_excel_arr);
                                                        foreach ($land_excel_arr as $key => $landExcel){
                                                               if($landExcel =='empty'){
                                                                    echo "No Excel Documents";  
                                                                }else{
                                                                if ($key != $last_key) {
                                                                    echo "<a href='{$landAcquisitionLandsDir}{$landExcel}' download='{$landExcel}'><button type='button' class='btn btn-primary mr-2'>Excel {$num_xl}</button></a>";
                                                                    }                                                               
                                                                }    
                                                             $num_xl++; 
                                                        }

                                                    ?>
                                                   <!--   <?= $land_docs->landExcel ?> -->
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
            // -----------------------------------------------------------------------------
            // ------------ Fetch Payment Structure Payments Section End -------------------
            // -----------------------------------------------------------------------------
           
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