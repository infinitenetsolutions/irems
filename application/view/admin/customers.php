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
    $manageCompanyStoreDir = "../../../assets/admin/projects/";
    $manageCompanyDir = "assets/admin/projects/";
    if(isset($_POST["action"])):
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Fetch Data Section Start ----------
            // -----------------------------------------------
            case "fetchData":
                ?>
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/customers.php">
                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_customer">
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
                                        <th>Profile</th>
                                        <th>Project</th>
                                        <th>Phase </th>
                                        <th>Building </th>
                                        <th>Floor </th>
                                        <th>Flat No</th>
                                        <th>Customer Name</th>
                                        <th>Phone No.</th>
                                        <th>Email Id</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $databaseObj->select("tbl_customer");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $databaseObj->order_by("`customer_id` DESC");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                                $customer_info = json_decode($rows["customer_info"]);
                                                $customer_log = json_decode($rows["customer_log"]);
                                                $customer_property_info = json_decode($rows["customer_property_info"]);
                                                $customer_second_applicant = json_decode($rows["customer_second_applicant"]);
                                    ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="icheck-navy d-inline">
                                                                <input type="checkbox" id="checkbox-<?= $rows["customer_id"] ?>" name="checkbox-select[]" value="<?= $rows["customer_id"] ?>" class="check-table">
                                                                <label for="checkbox-<?= $rows["customer_id"] ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= $sno ?>.</td>
                                                        <td><?php 
                                                                if(empty($customer_info->dp) || $customer_info->dp == "men-Icon.png" || $customer_info->dp == "women-Icon.png"):
                                                                    ?>
                                                                    <a href="assets/dp/<?= $customer_info->dp ?>" target="_blank"><img src="assets/dp/<?= $customer_info->dp ?>" width="35px;" /></a>
                                                                    <?php
                                                                else:
                                                                    ?>
                                                                    <a href="assets/dp/customer/<?= $customer_info->dp ?>" target="_blank"><img src="assets/dp/customer/<?= $customer_info->dp ?>" width="35px;" /></a>
                                                                    <?php
                                                                endif;
                                                            ?>
                                                        </td>
                                                        <?php 
                                                            $databaseObj->select("tbl_projects");
                                                            $databaseObj->where("`status` = '".$auth->visible()."'&& `projects_id` = '".$customer_property_info->projectName."'");
                                                            $databaseObj->order_by("`projects_id` DESC");
                                                            $getData = $databaseObj->get();
                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                              
                                                                foreach($getData as $rowsproject):
                                                                    $projects_info = json_decode($rowsproject["projects_info"]);
                                                                endforeach;
                                                            endif;       
                                                        ?><td><?= $projects_info->projectName ?></td>
                                                       <?php 
                                                            $databaseObj->select("tbl_phase");
                                                            $databaseObj->where("`status` = '".$auth->visible()."'&& `phase_id` = '".$customer_property_info->phase."'");
                                                            $databaseObj->order_by("`phase_id` DESC");
                                                            $getData = $databaseObj->get();

                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                              
                                                                foreach($getData as $rowsphase):
                                                                   
                                                                    $phase_info = json_decode($rowsphase["phase_info"]);
                                                                endforeach;
                                                            endif; ?> <td><?= $phase_info->phase ?></td>
                                                        <?php 
                                                            $databaseObj->select("tbl_building");
                                                            $databaseObj->where("`status` = '".$auth->visible()."'&& `building_id` = '".$customer_property_info->building."'");
                                                            $databaseObj->order_by("`building_id` DESC");
                                                            $getData = $databaseObj->get();
                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                             
                                                                foreach($getData as $rowsbuilding):
                                                                
                                                                    $building_info = json_decode($rowsbuilding["building_info"]);
                                                                endforeach;
                                                            endif; ?>
                                                            <td><?= $building_info->building ?></td>
                                                        <td><?= $customer_property_info->floors ?></td>
                                                        <td><?= $customer_property_info->flat_no ?></td>
                                                        <td><?= $customer_info->name ?></td>
                                                        <td><?= $customer_info->phoneNumber ?></td>
                                                        <td><?= $customer_info->emailId ?></td>
                                                        <td><?= $customer_log->status ?></td>
                                                        <td class="text-center">
                                                            <div style="width:300px;">
                                                                <button type="button" id="information-button-<?= $rows["customer_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">
                                                                    <i class="fa fa-scroll fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="edit-button-<?= $rows["customer_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update First Appilcant Info">
                                                                    <i class="fa fa-user fa-sm"></i> <i class="fa fa-edit fa-sm"></i>
                                                                </button>
                                                                <!-- <button type="button" id="edit-second-button-<?= $rows["customer_id"] ?>" class="edit-second-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update Second Appilcant Info">
                                                                    <i class="fa fa-users fa-sm"></i> <i class="fa fa-edit fa-sm"></i>
                                                                </button> -->
                                                           <!--      <button type="button" id="service-button-<?= $rows["customer_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Services"><i class="fa fa-coffee fa-sm"></i>
                                                                </button> -->
                                                                <button type="button" id="payment-structure-button-<?= $rows["customer_id"] ?>" class="payment-structure-button btn btn-xs btn-info mt-1 mb-1" title="Payment Structure">
                                                                    <i class="fa fa-money-check-alt fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="payment-structure-payment-button-<?= $rows["customer_id"] ?>" class="payment-structure-payment-button btn btn-xs btn-danger mt-1 mb-1" title="Payment Structure Paid/Unpaid">
                                                                    <i class="fas fa-money-bill-wave fa-sm"></i>
                                                                </button>
                                                              
                                                                <button type="button" id="delete-button-<?= $rows["customer_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                    <i class="fa fa-trash fa-sm"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        // Information Section Start ---------------------------------------------------------------
                                                        $("#information-button-<?= $rows["customer_id"] ?>").click(function () {
                                                            $("#information-modal").modal('show');
                                                            $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchInformation","id":"<?= $rows["customer_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/customers.php',
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
                                                        // Payment Structure Section Start ---------------------------------------------------------------
                                                        $("#payment-structure-button-<?= $rows["customer_id"] ?>").click(function () {
                                                            $("#payment-structure-modal").modal('show');
                                                            $('#payment-structure-section').html('<center id = "payment-structure-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchPaymentStructure","id":"<?= $rows["customer_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/customers.php',
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
                                                        // Payment Structure Section End -----------------------------------------------------------------
                                                        // Payment Structure Pyament Section Start ---------------------------------------------------------------
                                                        $("#payment-structure-payment-button-<?= $rows["customer_id"] ?>").click(function () {
                                                            $("#payment-structure-payment-modal").modal('show');
                                                            $('#payment-structure-payment-section').html('<center id = "payment-structure-payment-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchPaymentStructurePayments","id":"<?= $rows["customer_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/customers.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#payment-structure-payment-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#payment-structure-payment-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Payment Structure Pyament Section End -----------------------------------------------------------------
                                                        // Edit first applicant Section Start ---------------------------------------------------------------
                                                        $("#edit-button-<?= $rows["customer_id"] ?>").click(function () {
                                                            $("#edit-modal").modal('show');
                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchEdit","id":"<?= $rows["customer_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/customers.php',
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
                                                        // Edit first applicant Section End -----------------------------------------------------------------
                                                        // Edit Second Applicant Section Start ---------------------------------------------------------------
                                                        $("#edit-second-button-<?= $rows["customer_id"] ?>").click(function () {
                                                            $("#edit-second-modal").modal('show');
                                                            $('#edit-second-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"secondfetchEdit","id":"<?= $rows["customer_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/customers.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#edit-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#edit-second-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Edit Second Applicant Section End -----------------------------------------------------------------
                                                        // Delete Section Start ---------------------------------------------------------------
                                                        $("#delete-button-<?= $rows["customer_id"] ?>").click(function () {
                                                            $("#delete-modal").modal('show');
                                                            $('#deleteButton').prop('disabled', true);
                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["customer_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/customers.php',
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
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchInformation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`customer_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_create = json_decode($rows["customer_create"]);
                                ?>
                                    <div class="row">
                                        <?php
                                            $sno = 1;
                                            foreach($customer_create as $customer_create_info):
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($customer_create_info->action) ?> By</a></li>
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($customer_create_info->action) ?> By - 
                                                                    <?php
                                                                        if($customer_create_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$customer_create_info->by."'");
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
                                                                    <?= date("l, M d, Y", strtotime($customer_create_info->date)) ?> At <?= $customer_create_info->at ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                                    <?= $customer_create_info->ip ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                                    <?php
                                                                        $latLangArray = explode(",", $customer_create_info->location);
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
            // --------------------------------------------------------------------
            // ------------ Fetch Payment Structure Section Start -----------------
            // --------------------------------------------------------------------
            case "fetchPaymentStructure":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_payment_structure = json_decode($rows["customer_payment_structure"]);
                                $customer_extra_payment_structure = json_decode($rows["customer_extra_payment_structure"]);
                                $customer_property_info = json_decode($rows["customer_property_info"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <input type="hidden" id="propertyPriceDealForStructure" name="propertyPriceDealForStructure" value="<?= $customer_property_info->propertyPriceDeal ?>" />
                                            <table class="table table-bordered table-striped dataTable" id="edit_dynamic_field">
                                                <thead>
                                                    <th>S. No.</th>
                                                    <th>Percentage Of Amount</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Remark</th>
                                                    <th>Action</th>

                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $noOfRows = 1;
                                                        $checkPaid = "";
                                                        foreach($customer_payment_structure as $customer_payment_structure_all):
                                                            $checkPaid = "";
                                                            if($customer_payment_structure_all->paymentStuctureStatus == "paid"):
                                                                $checkPaid = "disabled";
                                                                $checkPaidCount = $noOfRows;
                                                                $checkPaidCount--;
                                                                ?>
                                                                    <input name="paymentStucturePaid[<?= $checkPaidCount ?>]" type="hidden" value="<?= $customer_payment_structure_all->paymentStucturePaid ?>" />
                                                                    <input name="paymentStucturePaidRemark[<?= $checkPaidCount ?>]" type="hidden" value="<?= $customer_payment_structure_all->paymentStucturePaidRemark ?>" />
                                                                    <input name="paymentStuctureStatus[<?= $checkPaidCount ?>]" type="hidden" value="<?= $customer_payment_structure_all->paymentStuctureStatus ?>" />
                                                                <?php
                                                            endif;
                                                    ?>
                                                    <?php 
                                                        if($noOfRows == 1):
                                                    ?>
                                                        <tr>
                                                    <?php 
                                                        else:
                                                    ?>
                                                        <tr id="row<?= $noOfRows."_".$rows["customer_id"] ?>" class="dynamic-added" >
                                                    <?php 
                                                        endif;
                                                    ?>
                                                        <td><span class="p-3 mt-2"><?= $noOfRows ?>.</span></td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:150px;">
                                                                    <input id="paymentStuctureCompletion<?= $noOfRows."_".$rows["customer_id"] ?>" name="paymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" value="<?= $customer_payment_structure_all->paymentStuctureCompletion ?>" <?= $checkPaid ?> title="<?= ucwords($customer_payment_structure_all->paymentStuctureStatus) ?>"/>
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
                                                                    <input id="paymentStuctureAmount<?= $noOfRows."_".$rows["customer_id"] ?>" name="paymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();"  value="<?= $customer_payment_structure_all->paymentStuctureAmount ?>" <?= $checkPaid ?> title="<?= ucwords($customer_payment_structure_all->paymentStuctureStatus) ?>"/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                         <td>
                                                            <div class="form-group mb-0">
                                                                  <select class="form-control form-control-sm"  name="paymentStuctureStatus[]" id="paymentStuctureStatus<?= $noOfRows."_".$rows["customer_id"] ?>" style="width:130px;" <?= ($customer_payment_structure_all->paymentStuctureStatus=='paid'?'disabled':'');?> >
                                                                    <option value="" <?= ($customer_payment_structure_all->paymentStuctureStatus==''?'selected':'');?> >Select Status</option>
                                                                    <option value="paid" <?= ($customer_payment_structure_all->paymentStuctureStatus=='paid'?'selected':'');?> >Paid</option>
                                                                  </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <input id="paymentStuctureRemark<?= $noOfRows."_".$rows["customer_id"] ?>" name="paymentStuctureRemark[]" type="text" class="form-control form-control-sm " onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" style="width:200px;" value="<?= $customer_payment_structure_all->paymentStuctureRemark ?>" <?= $checkPaid ?> title="<?= ucwords($customer_payment_structure_all->paymentStuctureStatus) ?>"/>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($noOfRows == 1):
                                                            ?>
                                                                    <button type="button" name="editAdd" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();"id="editAdd" class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                            <?php 
                                                                else:
                                                            ?>
                                                                    <button type="button" name="remove" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();" id="<?= $noOfRows."_".$rows["customer_id"] ?>" class="btn btn-danger btn_remove">X</button>
                                                            <?php 
                                                                endif;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                            $noOfRows++;
                                                        endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                             <h5> Deal Amount : <?= (!empty($customer_property_info->propertyPriceDeal)?$customer_property_info->propertyPriceDeal.' &#8377;':'No Amount')?> </h5>
                                        </div>
                                        <input type="hidden" value="<?= --$noOfRows ?>" id="editTotalNumberOfDivision" name="editTotalNumberOfDivision" />
                                        <input type="hidden" id="editTableId" name="editTableId" value="<?= $_POST["id"] ?>" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <input type="hidden" id="propertyPriceDealForStructure" name="propertyPriceDealForStructure" value="<?= $customer_property_info->propertyPriceDeal ?>" />
                                            <table class="table table-bordered table-striped dataTable" id="edit_dynamic_field">
                                                <thead>
                                                    <th>S. No.</th>
                                                    <th>Percentage Of Amount</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Remark</th>
                                                    <th>Action</th>

                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $noOfRows = 1;
                                                        $checkPaid = "";
                                                        foreach($customer_payment_structure as $customer_payment_structure_all):
                                                            $checkPaid = "";
                                                            if($customer_payment_structure_all->paymentStuctureStatus == "paid"):
                                                                $checkPaid = "disabled";
                                                                $checkPaidCount = $noOfRows;
                                                                $checkPaidCount--;
                                                                ?>
                                                                    <input name="paymentStucturePaid[<?= $checkPaidCount ?>]" type="hidden" value="<?= $customer_payment_structure_all->paymentStucturePaid ?>" />
                                                                    <input name="paymentStucturePaidRemark[<?= $checkPaidCount ?>]" type="hidden" value="<?= $customer_payment_structure_all->paymentStucturePaidRemark ?>" />
                                                                    <input name="paymentStuctureStatus[<?= $checkPaidCount ?>]" type="hidden" value="<?= $customer_payment_structure_all->paymentStuctureStatus ?>" />
                                                                <?php
                                                            endif;
                                                    ?>
                                                    <?php 
                                                        if($noOfRows == 1):
                                                    ?>
                                                        <tr>
                                                    <?php 
                                                        else:
                                                    ?>
                                                        <tr id="row<?= $noOfRows."_".$rows["customer_id"] ?>" class="dynamic-added" >
                                                    <?php 
                                                        endif;
                                                    ?>
                                                        <td><span class="p-3 mt-2"><?= $noOfRows ?>.</span></td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:150px;">
                                                                    <input id="paymentStuctureCompletion<?= $noOfRows."_".$rows["customer_id"] ?>" name="paymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" value="<?= $customer_payment_structure_all->paymentStuctureCompletion ?>" <?= $checkPaid ?> title="<?= ucwords($customer_payment_structure_all->paymentStuctureStatus) ?>"/>
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
                                                                    <input id="paymentStuctureAmount<?= $noOfRows."_".$rows["customer_id"] ?>" name="paymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();"  value="<?= $customer_payment_structure_all->paymentStuctureAmount ?>" <?= $checkPaid ?> title="<?= ucwords($customer_payment_structure_all->paymentStuctureStatus) ?>"/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                         <td>
                                                            <div class="form-group mb-0">
                                                                  <select class="form-control form-control-sm"  name="paymentStuctureStatus[]" id="paymentStuctureStatus<?= $noOfRows."_".$rows["customer_id"] ?>" style="width:130px;" <?= ($customer_payment_structure_all->paymentStuctureStatus=='paid'?'disabled':'');?> >
                                                                    <option value="" <?= ($customer_payment_structure_all->paymentStuctureStatus==''?'selected':'');?> >Select Status</option>
                                                                    <option value="paid" <?= ($customer_payment_structure_all->paymentStuctureStatus=='paid'?'selected':'');?> >Paid</option>
                                                                  </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <input id="paymentStuctureRemark<?= $noOfRows."_".$rows["customer_id"] ?>" name="paymentStuctureRemark[]" type="text" class="form-control form-control-sm " onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" style="width:200px;" value="<?= $customer_payment_structure_all->paymentStuctureRemark ?>" <?= $checkPaid ?> title="<?= ucwords($customer_payment_structure_all->paymentStuctureStatus) ?>"/>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($noOfRows == 1):
                                                            ?>
                                                                    <button type="button" name="editAdd" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();"id="editAdd" class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                            <?php 
                                                                else:
                                                            ?>
                                                                    <button type="button" name="remove" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();" id="<?= $noOfRows."_".$rows["customer_id"] ?>" class="btn btn-danger btn_remove">X</button>
                                                            <?php 
                                                                endif;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                            $noOfRows++;
                                                        endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                             <h5> Deal Amount : <?= (!empty($customer_property_info->propertyPriceDeal)?$customer_property_info->propertyPriceDeal.' &#8377;':'No Amount')?> </h5>
                                        </div>
                                        <input type="hidden" value="<?= --$noOfRows ?>" id="editTotalNumberOfDivision" name="editTotalNumberOfDivision" />
                                        <input type="hidden" id="editTableId" name="editTableId" value="<?= $_POST["id"] ?>" />
                                    </div>

                                    <script>
                                        // Calculate Percentage Section Start ---------------------------------------------------------------------------------------------------
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

                                            if($('#propertyPriceDealForStructure').val() == ""){
                                                topEndNotification("warning", "Please mention Dealing price first!!!");
                                            } else{
                                                var addedPercentage = (0).toFixed(2);
                                               
                                                var addedPercentageOld =(0).toFixed(2);
                                                
                                                var check = "";
                                                var totalRows = $("#editTotalNumberOfDivision").val();

                                                for(i = 1; i <= totalRows; i++){
                                                    //Checking empty and filled up rows Section Start
                                                    if($("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val() == ""){
                                                        $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                        $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                        $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                    }else{
                                                        $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").removeClass("is-invalid");
                                                        $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").removeClass("is-invalid");

                                                        var priceOfProperty = $("#editpropertyPriceDeal").val();
                                                         
                                                        var percentageOfOne = priceOfProperty/100;
                                                         
                                                        addedPercentage = Number(addedPercentage) + Number($("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val());
                                                        alert
                                                        if(Number(addedPercentage) > Number(100)){
                                                            $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                            $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                            $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                            $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").prop("placeholder", (100.00 - addedPercentageOld).toFixed(2));
                                                            $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                            check = "exceedPercentage";
                                                        } else{
                                                            var thisAmount = Number(percentageOfOne) * Number($("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val());
                                                            $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val((thisAmount).toFixed(2));
                                                        }
                                                    }
                                                    addedPercentageOld = addedPercentage;
                                                    //Checking empty and filled up rows Section End
                                                }
                                                switch(check){
                                                    case "exceedPercentage":
                                                        topEndNotification("warning", "The addition of Completeion % should be equal to 100%!!!");
                                                        break;
                                                }
                                            }
                                        }
                                        // Calculate Percentage Section End -----------------------------------------------------------------------------------------------------

                                         // Calculate Percentage Section Start ---------------------------------------------------------------------------------------------------
                                        function calculatePercentageEdit() {
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
                                            if($('#propertyPriceDealForStructure').val() == ""){
                                                topEndNotification("warning", "Please mention Dealing price first!!!");
                                            } else{
                                                var addedAmount = Number(0);
                                                var addedPercentageOld = (0).toFixed(2);
                                                var check = "";
                                                var totalRows = $("#editTotalNumberOfDivision").val();
                                                for(i = 1; i <= totalRows; i++){
                                                    //Checking empty and filled up rows Section Start
                                                    if($("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val() == ""){
                                                        $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                        $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                        $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                    }else{
                                                        $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").removeClass("is-invalid");
                                                        $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").removeClass("is-invalid");
                                                        
                                                        var priceOfProperty = $("#propertyPriceDealForStructure").val();
                                                        var percentageOfOne = priceOfProperty/100;
                                                        addedAmount = Number(addedAmount) + Number($("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val());
                                                        if(Number(addedAmount) > Number(priceOfProperty)){
                                                            $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                            $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                            $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                            $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").prop("placeholder", (100.00 - addedAmountOld).toFixed(2));
                                                            $("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                            check = "exceedAmount";
                                                        } else{
                                                            var thisPercentage = Number($("#paymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val()) / Number(percentageOfOne) ;

                                                            $("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val((thisPercentage).toFixed(2));
                                                        }
                                                    }
                                                    addedAmountOld = addedAmount;
                                                    //Checking empty and filled up rows Section End
                                                }
                                                switch(check){
                                                    case "exceedPercentage":
                                                        topEndNotification("warning", "The addition of Completeion % should be equal to 100%!!!");
                                                        break;
                                                      case "exceedAmount":
                                                        topEndNotification("warning", "The addition of total Amount should be equal to Deal Price!!!");
                                                        break;
                                                }
                                            }
                                        }
                                        // Calculate Percentage Section End -----------------------------------------------------------------------------------------------------

                                        //Add Dynamic Payment Structure Section Start -------------------------------------------------------------------------------------------
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
                                            var i=<?= $noOfRows ?>;  
                                            $('#editAdd').click(function(){
                                                var addedPercentage = (0).toFixed(2);
                                                var check = "";
                                                var checkExceed = "";  
                                                var totalRows = $("#editTotalNumberOfDivision").val();
                                                for(j = 1; j <= totalRows; j++){
                                                    if($("#paymentStuctureCompletion"+j+"<?= "_".$rows["customer_id"] ?>").val() == ""){
                                                        $("#paymentStuctureCompletion"+j+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                        check = "emptyRows";
                                                    }else
                                                        $("#paymentStuctureCompletion"+j+"<?= "_".$rows["customer_id"] ?>").removeClass("is-invalid");
                                                    if($("#paymentStuctureAmount"+j+"<?= "_".$rows["customer_id"] ?>").val() == ""){
                                                        $("#paymentStuctureAmount"+j+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                        check = "emptyRows";
                                                    }else
                                                        $("#paymentStuctureAmount"+j+"<?= "_".$rows["customer_id"] ?>").removeClass("is-invalid");
                                                    addedPercentage = Number(addedPercentage) + Number($("#paymentStuctureCompletion"+j+"<?= "_".$rows["customer_id"] ?>").val());
                                        //            console.log(addedPercentage);
                                                    if(Number(addedPercentage) >= Number(100))
                                                        checkExceed = "exceedPercentage";
                                                }
                                                if(check != "emptyRows" && checkExceed != "exceedPercentage"){
                                                    i++; 
                                                    $('#edit_dynamic_field').append('<tr id="row'+i+'<?= "_".$rows["customer_id"] ?>" class="dynamic-added" ><td><span class="p-3 mt-2">'+i+'.</span></td><td><div class="form-group mb-0"><div class="input-group" style="width:150px;"><input id="paymentStuctureCompletion'+i+'<?= "_".$rows["customer_id"] ?>" name="paymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();"/><div class="input-group-prepend"><button type="button" class="btn btn-danger">%</button></div></div></div></td><td><div class="form-group mb-0"><div class="input-group" style="width:200px;"><div class="input-group-prepend"><button type="button" class="btn btn-danger">&#8377;</button></div><input id="paymentStuctureAmount'+i+'<?= "_".$rows["customer_id"] ?>" name="paymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculatePercentageEdit();" onkeyup="calculatePercentageEdit();" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" /></div></div></td><td><div class="form-group mb-0"><select class="form-control form-control-sm"  name="paymentStuctureStatus[]" id="paymentStuctureStatus<?= $noOfRows."_".$rows["customer_id"] ?>" style="width:130px;" <?= ($customer_payment_structure_all->paymentStuctureStatus=='paid'?'enabled':'');?> ><option value="" <?= ($customer_payment_structure_all->paymentStuctureStatus==''?'selected':'');?> >Select Status</option><option value="paid" <?= ($customer_payment_structure_all->paymentStuctureStatus=='paid'?'selected':'');?> >Paid</option></select></div></td><td><div class="form-group mb-0"><input id="paymentStuctureRemark'+i+'<?= "_".$rows["customer_id"] ?>" name="paymentStuctureRemark[]" type="text" class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" style="width:200px;"/></div></td><td><button type="button" name="remove" id="'+i+'<?= "_".$rows["customer_id"] ?>" class="btn btn-danger btn_remove " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();">X</button></td></tr>');
                                                    $("#editTotalNumberOfDivision").val(i);
                                                } else if(checkExceed == "exceedPercentage")
                                                    topEndNotification("warning", "100% completed! You are not able to add more rows!!!");
                                                else
                                                    topEndNotification("warning", "Please first complete existing rows");
                                            });
                                            $(document).on('click', '.btn_remove', function(){  
                                               var button_id = $(this).attr("id");   
                                               $('#row'+button_id+'').remove(); 
                                               i--;
                                               $("#editTotalNumberOfDivision").val(i);
                                            }); 
                                            //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
                                        });
                                        //Add Dynamic Payment Structure Section End ---------------------------------------------------------------------------------------------
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
            // -----------------------------------------------------------------------------
            // ------------ Fetch Payment Structure Payments Section Start -----------------
            // -----------------------------------------------------------------------------
            case "fetchPaymentStructurePayments":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_payment_structure = json_decode($rows["customer_payment_structure"]);
                                $customer_property_info = json_decode($rows["customer_property_info"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-bordered table-striped dataTable" id="edit_dynamic_field">
                                                <thead>
                                                    <th>S. No.</th>
                                                    <th>Percentage Of Amount</th>
                                                    <th>Amount</th>
                                                    <th>Remark</th>
                                                    <th>Paid</th>
                                                    <th>Paid Remark</th>
                                                    <th>Status</th>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $noOfRows = 1;
                                                        $totalPer = 0.00;
                                                        $totalAmount = 0.00;
                                                        $totalPaid = 0.00;
                                                        foreach($customer_payment_structure as $customer_payment_structure_all):
                                                            $totalPer = $totalPer + floatval($customer_payment_structure_all->paymentStuctureCompletion);
                                                            $totalAmount = $totalAmount + floatval($customer_payment_structure_all->paymentStuctureAmount);
                                                            $totalPaid = $totalPaid + floatval($customer_payment_structure_all->paymentStucturePaid);
                                                    ?>
                                                    <tr>
                                                        <td><span class="p-3 mt-2"><?= $noOfRows ?>.</span></td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:150px;">
                                                                    <input type="number" class="form-control form-control-sm " value="<?= $customer_payment_structure_all->paymentStuctureCompletion ?>" readonly/>
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
                                                                    <input type="number" class="form-control form-control-sm"  value="<?= $customer_payment_structure_all->paymentStuctureAmount ?>" readonly/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <input type="text" class="form-control form-control-sm" value="<?= $customer_payment_structure_all->paymentStuctureRemark ?>" readonly style="width:200px;"/>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:200px;">
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                    </div>
                                                                    <input type="number" class="form-control form-control-sm"  value="<?php printf("%.2f", $customer_payment_structure_all->paymentStucturePaid) ?>" readonly/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <input type="text" class="form-control form-control-sm" value="<?= $customer_payment_structure_all->paymentStucturePaidRemark ?>" readonly style="width:200px;"/>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if(empty($customer_payment_structure_all->paymentStuctureStatus)):
                                                                    echo "<span class='badge badge-danger text-md mt-2'>Not Paid</span>";
                                                                else:
                                                                    if($customer_payment_structure_all->paymentStuctureStatus == "paid"):
                                                                        echo "<span class='badge badge-info text-md mt-2'>".ucwords($customer_payment_structure_all->paymentStuctureStatus)."</span>";
                                                                    else:  
                                                                        echo "<span class='badge badge-warning text-md mt-2'>".ucwords($customer_payment_structure_all->paymentStuctureStatus)."</span>";
                                                                    endif;
                                                                endif;
                                                            ?>
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
                                                                    <input type="number" class="form-control form-control-sm " value="<?php printf("%.2f", $totalPer) ?>" readonly/>
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
                                                                    <input type="number" class="form-control form-control-sm"  value="<?php printf("%.2f", $totalAmount) ?>" readonly/>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th></th>
                                                        <th>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:200px;">
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                    </div>
                                                                    <input type="number" class="form-control form-control-sm"  value="<?php printf("%.2f", $totalPaid) ?>" readonly/>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <h5> Deal Amount : <?= (!empty($customer_property_info->propertyPriceDeal)?$customer_property_info->propertyPriceDeal.' &#8377;':'No Amount')?> </h5>
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
            // ------------ Fetch First Applicant Edit Section Start ----------------
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
                                $customer_info = json_decode($rows["customer_info"]);
                                 $customer_second_applicant = json_decode($rows["customer_second_applicant"]);
                                  $customer_property_info = json_decode($rows["customer_property_info"]);
                                  $customer_extra_payment_structure  = json_decode($rows["customer_extra_payment_structure"]);
                                  $customer_payment_structure  = json_decode($rows["customer_payment_structure"]);
                                  $customer_payment_info  = json_decode($rows["customer_payment_info"]);
                                

                                 
                                ?>
                              <!-- PropertY Edit Section Starts -->

                                 <input type="hidden" id="propertyPriceDealForStructurePayment" name="propertyPriceDealForStructurePayment" value="<?= $customer_property_info->propertyPriceDeal ?>" />
                                <div class="card-body">
                                    <div class="card card-navy" id="propertyInformationDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">Property Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editprojectName">Project</label>
                                                        <select id="editprojectName" name="editprojectName" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option value="" >Select Project</option>
                                                            
                                                            <?php 
                                                                $databaseObj->select("tbl_projects");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                $getData = $databaseObj->get();
                                                                //Checking If Data Is Available
                                                                if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rowsproject):
                                                                        $projects_info = json_decode($rowsproject["projects_info"]);
                                                                        ?>
                                                                            <option <?php if($customer_property_info->projectName == $rowsproject["projects_id"]) echo "selected" ?> value="<?= $rowsproject["projects_id"] ?>"><?= $projects_info->projectName ?></option>
                                                                        <?php
                                                                    endforeach;
                                                                endif;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editphase">Phase </label>
                                                        <select id="editphase" name="editphase" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <?php 
                                                                $databaseObj->select("tbl_phase");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                $getData = $databaseObj->get();
                                                                //Checking If Data Is Available
                                                                if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rowsphase):
                                                                        $phase_info = json_decode($rowsphase["phase_info"]);
                                                                        ?>
                                                                       <option <?php if($customer_property_info->phase == $rowsphase["phase_id"]) echo "selected" ?> value="<?= $rowsphase["phase_id"] ?>"><?= $phase_info->phase ?></option>
                                                                         <?php 

                                                                           endforeach;
                                                                           endif;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editbuilding">Block</label>
                                                        <select id="editbuilding" name="editbuilding" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <?php 
                                                                $databaseObj->select("tbl_building");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                $getData = $databaseObj->get();
                                                                //Checking If Data Is Available
                                                                if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rowsblock):
                                                                        $building_info = json_decode($rowsblock["building_info"]);
                                                                        ?>
                                                                       <option <?php if($customer_property_info->building == $rowsblock["building_id"]) echo "selected" ?> value="<?= $rowsblock["building_id"] ?>"><?= $building_info->building ?></option>
                                                                         <?php 

                                                                           endforeach;
                                                                           endif;
                                                            ?>
                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfloors">Floor Number</label>
                                                        <select id="editfloors" name="editfloors" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <?php 

                                                                $databaseObj->select("tbl_properties");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                $getData = $databaseObj->get();
                                                                //Checking If Data Is Available
                                                                if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rowsfloor):
                                                                        $properties_info = json_decode($rowsfloor["properties_info"]);
                                                                          ?>

                                                                        
                                                                       <option <?php if($customer_property_info->floors == $properties_info->total_floors) echo "selected" ?> value="<?= $properties_info->total_floors ?>">Floor|<?= $properties_info->total_floors ?></option>
                                                                         <?php 

                                                                           endforeach;
                                                                           endif;
                                                            ?>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editflat_no">Flat Number</label>
                                                        <select id="editflat_no" name="editflat_no" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <?php 
                                                                $databaseObj->select("tbl_properties");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                $getData = $databaseObj->get();
                                                                //Checking If Data Is Available
                                                                if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rowsflat):
                                                                        $properties_info = json_decode($rowsflat["properties_info"]);
                                                                         foreach($properties_info->floors as $rowsfloors):
                                                                             foreach($rowsfloors as $rowsfloorsnew):
                                                                              if(($customer_property_info->floors == $properties_info->total_floors)&&($customer_property_info->building == $properties_info->building)):
                                                                              endif; ?>
                                                                            
 

                                                                          

                                                                        
                                                                       <option <?php if($customer_property_info->flat_no == $rowsfloorsnew->flat_no)echo "selected" ?> value="<?= $rowsfloorsnew->flat_no ?>"><?= $rowsfloorsnew->flat_no ?></option>
                                                                         <?php 

                                                                             endforeach;
                                                                           endforeach;
                                                                           endforeach;
                                                                           endif;
                                                            ?>
                                                            
                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsquareFeet">Total Area Sq.ft</label>
                                                        <?php 
                                                   
                                                     
                                                                
                                                                $databaseObj->select("tbl_properties");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'&& `projects_id` = '".$customer_property_info->projectName."'");

                                                                $getDataproperty = $databaseObj->get();


                                                                foreach($getDataproperty as $rowsproperty):
                                                                   $properties_info = json_decode($rowsproperty["properties_info"]);
                                                               




                                
                                                               
                                                                  if(($customer_property_info->phase == $properties_info->phase) && ($customer_property_info->building == $properties_info->building))
                                                                     {
                                                                        
                                                              
                                                                          foreach($properties_info->floors as $rowsfloors):


                                                                            

                                                                          
                                                                             foreach($rowsfloors as $rowsfloorsnew):

                                                                                 
                                                                            foreach($rowsfloorsnew->customer_details as $rowsfloorscustomer):
                                                                                 if($customer_property_info->flat_no == $rowsfloorsnew->flat_no): ?>
                                                                               
                                                                              <input id="editsquareFeet" name="editsquareFeet" type="text" class="form-control form-control-sm" readonly value="<?= $rowsfloorsnew->square_feet ?>"/>
                                                                          <?php endif;
                                                                               
                                                                          

                                                                                endforeach;

                                                                                 endforeach; 

                                                                                 endforeach; }    
                                                                                  endforeach; 
                                                                   
                                                                                 ?>
                                                                                    
                                                                    
                                                                              

                                                                    
 
                                                                        
                                                                       
                                                                    
                                                                          
                                                                            
                                                            
                                                       
                                         
                                                                      

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editpricePerSquare">Price / Sq.ft</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                            </div>
                                                             <?php 
                                                                $databaseObj->select("tbl_properties");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'&& `projects_id` = '".$customer_property_info->projectName."'");
                                                                $getDataproperty = $databaseObj->get();
                                                                foreach($getDataproperty as $rowsproperty):
                                                                   $properties_info = json_decode($rowsproperty["properties_info"]);
                                                                    if(($customer_property_info->phase == $properties_info->phase) && ($customer_property_info->building == $properties_info->building))
                                                                     {
                                                                        foreach($properties_info->floors as $rowsfloors):
                                                                            foreach($rowsfloors as $rowsfloorsnew):
                                                                                foreach($rowsfloorsnew->customer_details as $rowsfloorscustomer):
                                                                                   if($customer_property_info->flat_no == $rowsfloorsnew->flat_no): ?>
                                                                               
                                                                                     <input id="editpricePerSquare" name="editpricePerSquare" type="number" min="0" class="form-control form-control-sm" value="<?= $rowsfloorsnew->price_per_square ?>" readonly />
                                                                                    <?php 
                                                                                   endif;
                                                                                endforeach;

                                                                            endforeach; 

                                                                        endforeach; 
                                                                      }     
                                                                endforeach; 
                                                                   
                                                             ?>
                                                           
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">/ Sq.ft</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editpropertyPrice">Property Price</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                            </div>
                                                            <?php 
                                                                $databaseObj->select("tbl_properties");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'&& `projects_id` = '".$customer_property_info->projectName."'");
                                                                $getDataproperty = $databaseObj->get();
                                                                foreach($getDataproperty as $rowsproperty):
                                                                 $properties_info = json_decode($rowsproperty["properties_info"]);
                                                                 if(($customer_property_info->phase == $properties_info->phase) && ($customer_property_info->building == $properties_info->building))
                                                                     {
                                                                        foreach($properties_info->floors as $rowsfloors):
                                                                            foreach($rowsfloors as $rowsfloorsnew):
                                                                                foreach($rowsfloorsnew->customer_details as $rowsfloorscustomer):
                                                                                  if($customer_property_info->flat_no == $rowsfloorsnew->flat_no): ?>
                                                                                    <input id="editpropertyPrice" name="editpropertyPrice" type="number" min="0" class="form-control form-control-sm" value="<?= $rowsfloorsnew->price_total ?>" readonly />
                                                                                    <?php 
                                                                                  endif;
                                                                                endforeach;

                                                                            endforeach;
                                                                        endforeach; 
                                                                     }     
                                                                endforeach; 
                                                                   
                                                            ?>
                                                           
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editpropertyPriceDeal">Dealing Price *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                            </div>
                                                            <input id="editpropertyPriceDeal" name="editpropertyPriceDeal" type="number" min="0.00" step=any class="form-control form-control-sm" value="<?= $customer_property_info->propertyPriceDeal ?>" reaonly />
                                                        </div>
                                                        <small class="text-red">Customer's dealing price. *</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editpropertyCarParking">Car Parking</label>
                                                        <select id="editpropertyCarParkings" name="editpropertyCarParkings" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option <?php if($customer_property_info->propertyCarParkings == "Yes") echo "selected" ?> value="<?= $customer_property_info->propertyCarParkings ?>">Yes</option>
                                                            <option  <?php if($customer_property_info->propertyCarParkings == "No") echo "selected" ?> value="<?= $customer_property_info->propertyCarParkings ?>">No</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="editdivCarParkingAmount">
                                                    <div class="form-group">
                                                        <label for="editCarParkingAmount">Car Parking Price</label>
                                                        <input id="editCarParkingAmount" name="editCarParkingAmount" type="number" class="form-control form-control-sm" value="<?= $customer_property_info->CarParkingAmount ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editpropertyScooterParkings">Scooter Parking</label>
                                                        <select id="editpropertyScooterParkings" name="editpropertyScooterParkings" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option <?php if($customer_property_info->propertyScooterParkings == "Yes") echo "selected" ?> value="<?= $customer_property_info->propertyCarParkings ?>">Yes</option>
                                                            <option  <?php if($customer_property_info->propertyScooterParkings == "No") echo "selected" ?> value="<?= $customer_property_info->propertyCarParkings ?>">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="editdivScooterParkingAmount">
                                                    <div class="form-group">
                                                        <label for="editScooterParkingAmount">Scooter Parking Price</label>
                                                        <input id="editScooterParkingAmount" name="editScooterParkingAmount" type="number" class="form-control form-control-sm" value="<?= $customer_property_info->ScooterParkingAmount ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                         $(function(){
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
                                         $("#editpropertyCarParkings").change(function () {
                                         if($("#editpropertyCarParkings").val() == "No"){
                                         $("#editdivCarParkingAmount").addClass("display-none");
                                         } else{
                                         $("#editdivCarParkingAmount").removeClass("display-none");
                                         }
                                         });
                                         $("#editpropertyScooterParkings").change(function () {
                                         if($("#editpropertyScooterParkings").val() == "No"){
                                         $("#editdivScooterParkingAmount").addClass("display-none");
                                         } else{
                                        $("#editdivScooterParkingAmount").removeClass("display-none");
                                          }
                                          });
                                        $("#editprojectName").change(function () {
                                       
                                        topEndNotification("info", "Please Wait...");
                                        $('#editprojectName').prop("disabled", true);     
                                        $('#editphase').prop("disabled", true);
                                        $('#editbuilding').prop("disabled", true);
                                        $('#editfloors').prop("disabled", true);
                                        $('#editflat_no').prop("disabled", true);
                                        $("#divScooterParkingAmount").removeClass("display-none");
    

                                        $('#editphase').val("");
                                        $('#editbuilding').val("");
                                        $('#editfloors').val("");
                                        $('#editflat_no').val("");
                                        $('#editflat_no').val("");
                                        disableTruePrices();
                                       var formData = {"action":"fetchPhaseFromeditProjectId","id":$("#editprojectName").val()};
                                        $.ajax({
                                            url: 'application/view/admin/customers',
                                            type: 'POST',
                                            data: formData,
                                            success: function (data) {
                                               
                                                setTimeout( function() {
                                                    topEndNotification("info", "Please Select Phase!!!");
                                                    $('#editphase').html("");
                                                    $('#editphase').html(data);
                                                    $('#editbuilding').html("");
                                                    $('#editbuilding').html('<option value="" selected>Select Block</option>');
                                                    $('#editfloors').html("");
                                                    $('#editfloors').html('<option value="" selected>Select Floor Number</option>');
                                                    $('#editflat_no').html("");
                                                    $('#editflat_no').html('<option value="" selected>Select Flat Number</option>');
                                                    $('#editprojectName').prop("disabled", false);
                                                    $('#editphase').prop("disabled", false);
                                                    disableFalsePrices();
                                                }, 500);
                                            }
                                        });
                                       });
                                        $("#editphase").change(function () {
                                        topEndNotification("info", "Please Wait...");
                                        $('#editprojectName').prop("disabled", true);
                                        $('#editphase').prop("disabled", true);
                                        $('#editbuilding').prop("disabled", true);
                                        $('#editfloors').prop("disabled", true);
                                        $('#editflat_no').prop("disabled", true);
                                        $('#editbuilding').val("");
                                        $('#editfloors').val("");
                                        $('#editflat_no').val("");
                                        disableTruePrices();
                                        var formData = {"action":"fetchBlockFromeditProjectId","id":$("#editprojectName").val(),"phase_id":$("#editphase").val()};
                                        $.ajax({
                                        url: 'application/view/admin/customers',
                                        type: 'POST',
                                        data: formData,
                                        success: function (data) {
                                            setTimeout( function() {
                                                topEndNotification("info", "Please Select Block!!!");
                                                $('#editbuilding').html("");
                                                $('#editbuilding').html(data);
                                                $('#editfloors').html("");
                                                $('#editfloors').html('<option value="" selected>Select Floor Number</option>');
                                                $('#editflat_no').html("");
                                                $('#editflat_no').html('<option value="" selected>Select Flat Number</option>');
                                                $('#editprojectName').prop("disabled", false);
                                                $('#editphase').prop("disabled", false);
                                                $('#editbuilding').prop("disabled", false);
                                                disableFalsePrices();
                                            }, 500);
                                        }
                                       });
                                       });
                                        $("#editbuilding").change(function () { 
                                        topEndNotification("info", "Please Wait...");
                                        $('#editprojectName').prop("disabled", true);
                                        $('#editphase').prop("disabled", true);
                                        $('#editbuilding').prop("disabled", true);
                                        $('#editfloors').prop("disabled", true);
                                        $('#editflat_no').prop("disabled", true);
                                        $('#editfloors').val("");
                                        $('#editflat_no').val("");
                                        disableTruePrices();
                                        var formData = {"action":"fetchFloorFromeditProjectId","id":$("#editprojectName").val(),"phase_id":$("#editphase").val(),"building_id":$("#editbuilding").val()};
                                        $.ajax({
                                            url: 'application/view/admin/customers',
                                            type: 'POST',
                                            data: formData,
                                            success: function (data) {
                                                setTimeout( function() {
                                                    topEndNotification("info", "Please Select Block!!!");
                                                    $('#editfloors').html("");
                                                    $('#editfloors').html(data);
                                                    $('#editflat_no').html("");
                                                    $('#editflat_no').html('<option value="" selected>Select Flat Number</option>');
                                                    $('#editprojectName').prop("disabled", false);
                                                    $('#editphase').prop("disabled", false);
                                                    $('#editbuilding').prop("disabled", false);
                                                    $('#editfloors').prop("disabled", false);
                                                    disableFalsePrices();
                                                }, 500);
                                            }
                                        });
                                    });
                                    $('#editfirstApplicantCalculateAge').click( function () {
                                    topEndNotification("info", "Calculating Age...");
                                    $('#editfirstApplicantAge').attr("readonly", "readonly");
                                    var formData = {"action":"editfetchFirstApplicantCalculatedAge","dateOfBirth":$("#editfirstApplicantDateOfBirth").val()};
                                    $.ajax({
                                        url: 'application/view/admin/customers.php',
                                        type: 'POST',
                                        data: formData,
                                        success: function (data) {
                                          
                                            setTimeout( function() {
                                                topEndNotification("info", data);
                                                $('#editfirstApplicantAge').val(data);
                                            }, 500);
                                        }
                                    });
                                });
                                $("#editfloors").change(function () { 
                                topEndNotification("info", "Please Wait...");
                                $('#editprojectName').prop("disabled", true);
                                $('#editphase').prop("disabled", true);
                                $('#editbuilding').prop("disabled", true);
                                $('#editfloors').prop("disabled", true);
                                $('#editflat_no').prop("disabled", true);
                                $('#editflat_no').val("");
                                disableTruePrices();
                                var formData = {"action":"fetchFlatFromeditProjectId","id":$("#editprojectName").val(),"phase_id":$("#editphase").val(),"building_id":$("#editbuilding").val(),"floors":$("#editfloors").val()};
                                $.ajax({
                                    url: 'application/view/admin/customers',
                                    type: 'POST',
                                    data: formData,
                                    success: function (data) {
                                        setTimeout( function() {
                                            topEndNotification("info", "Please Select Block!!!");
                                            $('#editflat_no').html("");
                                            $('#editflat_no').html(data);
                                            $('#editprojectName').prop("disabled", false);
                                            $('#editphase').prop("disabled", false);
                                            $('#editbuilding').prop("disabled", false);
                                            $('#editfloors').prop("disabled", false);
                                            $('#editflat_no').prop("disabled", false);
                                            disableFalsePrices();
                                        }, 500);
                                    }
                                });
                            });
        
        
                         $("#editflat_no").change(function () {
                        

                        $('#editsquareFeet').val($(this).find(":selected").data("square-feet"));
                        $('#editpricePerSquare').val($(this).find(":selected").data("price-per-square"));
                        $('#editpropertyPrice').val($(this).find(":selected").data("price-total"));
                    });
                    disableTruePrices = function(){
                        $('#editsquareFeet').val("");
                        $('#editpricePerSquare').val("");
                        $('#editpropertyPrice').val("");
                        $('#editsquareFeet').prop("disabled", true);
                        $('#editpricePerSquare').prop("disabled", true);
                        $('#editpropertyPrice').prop("disabled", true);
                        $('#editpropertyPriceDeal').prop("disabled", true);
                    }
                    disableFalsePrices = function(){
                        $('#editpropertyPriceDeal').prop("disabled", false);
                    }
                  });
                    $("#editpropertyPriceDeal").on("click keyup change", function () {
                            if($('#editpropertyPrice').val() == ""){
                                $("#editpropertyPriceDeal").val("");
                                topEndNotification("warning", "Please select Property first!!!");
                            } else{
                                $("#editpaymentAmount").val("");
                                $("#editpaymentStuctureRemark1").val("");
                                
                                $("#editpaymentStuctureCompletion1").val("");
                                $("#editpaymentStuctureAmount1").val("");
                                $("#editpaymentStuctureDate1").removeAttr("readonly");
                                $("#peditaymentStuctureRemark1").removeAttr("readonly");
                                $("#editpaymentStuctureCompletion1").removeAttr("readonly");
                                $("#editpaymentStuctureAmount1").removeAttr("readonly");
                                
                                calculateAmountEditPayment();
                            }
                        });
                    calculateAmountEditPayment = function() {
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
    console.log($('#editpropertyPriceDeal').val());
    if($('#editpropertyPriceDeal').val() == ""){
        topEndNotification("warning", "Please mention Dealing price first!!!");
        $("#editpaymentAmount").val(0);
    } else{
        var addedPercentage = (0).toFixed(2);
        var addedPercentageOld = (0).toFixed(2);
        var addedAmount = (0).toFixed(2);
        var addedAmountOld = (0).toFixed(2);
        var check = "";
        var totalRows = $("#editPaymentTotalNumberOfDivision").val();
        for(i = 1; i <= totalRows; i++){
            //Checking empty and filled up rows Section Start
            if($("#editpaymentStuctureCompletion"+i).val() == "" && $("#editpaymentStuctureCompletion"+i).val() == ""){
                $("#editpaymentStuctureCompletion"+i).addClass("is-invalid");
                $("#editpaymentStuctureAmount"+i).addClass("is-invalid");
                $("#editpaymentStuctureAmount"+i).val("");
                $("#editpaymentStuctureCompletion"+i).val("");
            }else{
                $("#editpaymentStuctureCompletion"+i).removeClass("is-invalid");
                $("#editpaymentStuctureAmount"+i).removeClass("is-invalid");
                var propertyPrice=$("#editpropertyPriceDeal").val();
                var carParkingPrice=$("#editCarParkingAmount").val();
                var scooterParkingPrice=$("#editScooterParkingAmount").val();
                var priceOfProperty=Number(propertyPrice)+Number(carParkingPrice)+Number(scooterParkingPrice);
                fullAmount = priceOfProperty.toFixed(2);
                //console.log(priceOfProperty);
                //var priceOfProperty = $("#propertyPriceDeal").val();
                var percentageOfOne = priceOfProperty/100;
                addedPercentage = Number(addedPercentage) + Number($("#editpaymentStuctureCompletion"+i).val());
                if(Number(addedPercentage) > Number(100)){
                    $("#editpaymentStuctureCompletion"+i).addClass("is-invalid");
                    $("#editpaymentStuctureAmount"+i).addClass("is-invalid");
                    $("#editpaymentStuctureCompletion"+i).val("");
                    $("#editpaymentStuctureCompletion"+i).prop("placeholder", (100.00 - addedPercentageOld).toFixed(2));
                    $("#editpaymentStuctureAmount"+i).val("");
                    check = "exceedPercentage";
                } else{
                    var thisAmount = Number(percentageOfOne) * Number($("#editpaymentStuctureCompletion"+i).val());
                    $("#editpaymentStuctureAmount"+i).val((thisAmount).toFixed(2));
                    // $("#paymentStuctureRemark"+i).val((Number($("#paymentStuctureAmount"+i).val()) / Number(priceOfProperty)) * 100);
                }
            }
            addedPercentageOld = addedPercentage;
            //Checking empty and filled up rows Section End
        }
        // switch(check){
        //     case "exceedPercentage":
        //         topEndNotification("warning", "The addition of Completeion % should be equal to 100%!!!");
        //         break;
        // }
    }
}
 function calculatePercentageEditPayment() {
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
                                            if($('#editpropertyPriceDealForStructure').val() == ""){
                                                topEndNotification("warning", "Please mention Dealing price first!!!");
                                            } else{
                                                var addedAmount = Number(0);
                                                var addedPercentageOld = (0).toFixed(2);
                                                var check = "";
                                                var totalRows = $("#editPaymentTotalNumberOfDivision").val();
                                                for(i = 1; i <= totalRows; i++){
                                                    //Checking empty and filled up rows Section Start
                                                    if($("#editpaymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val() == ""){
                                                        $("#editpaymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                        $("#editpaymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                        $("#editpaymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                    }else{
                                                        $("#editpaymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").removeClass("is-invalid");
                                                        $("#editpaymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").removeClass("is-invalid");
                                                        
                                                        var priceOfProperty = $("#editpropertyPriceDealForStructure").val();
                                                        var percentageOfOne = priceOfProperty/100;
                                                        addedAmount = Number(addedAmount) + Number($("#editpaymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val());
                                                        if(Number(addedAmount) > Number(priceOfProperty)){
                                                            $("#editpaymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                            $("#editpaymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").addClass("is-invalid");
                                                            $("#editpaymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                            $("#editpaymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").prop("placeholder", (100.00 - addedAmountOld).toFixed(2));
                                                            $("#editpaymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val("");
                                                            check = "exceedAmount";
                                                        } else{
                                                            var thisPercentage = Number($("#editpaymentStuctureAmount"+i+"<?= "_".$rows["customer_id"] ?>").val()) / Number(percentageOfOne) ;

                                                            $("#editpaymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val((thisPercentage).toFixed(2));
                                                        }
                                                    }
                                                    addedAmountOld = addedAmount;
                                                    //Checking empty and filled up rows Section End
                                                }
                                                switch(check){
                                                    case "exceedPercentage":
                                                        topEndNotification("warning", "The addition of Completeion % should be equal to 100%!!!");
                                                        break;
                                                      case "exceedAmount":
                                                        topEndNotification("warning", "The addition of total Amount should be equal to Deal Price!!!");
                                                        break;
                                                }
                                            }
                                        }

                    </script>
                    <!-- //Booking Info Starts  -->
                                     <!-- <div class="card card-navy" id="paymentInformationDiv"  class="col-md-12 display-none">
                                        <div class="card-header">
                                            <h3 class="card-title">Booking Information</h3>
                                        </div> -->
                                        <?php 
                                       
                                        // foreach($customer_payment_info as $customer_payment_info_all):
                                                           
                                                             
                                                                ?>
                                        <!-- <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editpaymentAmountDate">Payment Date</label>
                                                        <input id="editpaymentAmountDate" name="editpaymentAmountDate" type="date" class="form-control form-control-sm" value="<?= $customer_payment_info_all->paymentDate ?>"/>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editpaymentAmount">Booking Amount</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                            </div>
                                                            <input id="editpaymentAmount" name="editpaymentAmount" type="number" min="0" class="form-control form-control-sm" value="<?= $customer_payment_info_all->paymentAmount ?>"/>
                                                        </div>
                                                        <small class="text-red">Submitted Amount</small>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editpaymentAmountInRupees">In Words</label>
                                                        <div class="input-group">
                                                            <input id="editpaymentAmountInRupees" name="editpaymentAmountInRupees" type="text" class="form-control form-control-sm" value="<?= $customer_payment_info_all->paymentInWords ?>" readonly/>
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">Only</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paymentAmountNumber">Payment Number</label>
                                                        <input id="paymentAmountNumber" name="paymentAmountNumber" type="text" class="form-control form-control-sm"/>
                                                        <small class="text-red">Like Cheque No, Online Transaction No etc.</small>
                                                    </div>
                                                </div> -->
                                               <!--  <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editpaymentAmountMode">Payment Mode</label>
                                                        <select id="editpaymentAmountMode" name="editpaymentAmountMode" class="form-control select2">
                                                            <option value="Cash" selected>Cash</option>
                                                            <option value="Cheque">Cheque</option>
                                                            <option value="DD">DD</option>
                                                            <option value="Online">Online</option>
                                                            <option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                               <!--  <div class="col-md-6 other-mode display-none">
                                                    <div class="form-group">
                                                        <label for="editpaymentAmountBankName">Bank Name</label>
                                                        <input id="editpaymentAmountBankName" name="editpaymentAmountBankName" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-md-6 other-mode display-none">
                                                    <div class="form-group">
                                                        <label for="editpaymentAmountNumber">Cheque/DD/NEFT No</label>
                                                        <input id="editpaymentAmountNumber" name="editpaymentAmountNumber" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div> -->
                                                
                                            <!-- </div>
                                        </div>
                                    </div> -->
                                <?php  
                            // endforeach; 
                                // Payment Structure of Edit Section Starts here
                                 $cntr = 1;
                                  ?> 

                                    <div class="card card-navy" id="editpaymentStructureDiv"  class="col-md-12 display-none">
                                        <div class="card-header">
                                            
                                            <h3 class="card-title">Payment Structure </h3>
                                        </div>
                                       
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    
                                                    <table class="table table-bordered table-striped dataTable" id="EDITdynamic_field">
                                                        <thead>
                                                            <th>S.No.</th>
                                                            <th>Payment Date</th>
                                                            <th>Payment Description</th>
                                                            <th>Percentage Of Amount</th>
                                                            <th>Amount</th>
                                                            <th>Action
                                                           
                                                                    <button type="button" name="editpaymentstructureadd" id="editpaymentstructureadd" class="btn btn-warning btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                   
                                                                </th>
                                                        </thead>
                                                        <tbody>
                                                             <?php 
                                                        $noOfRows = 1;
                                                        $checkPaid = "";
                                                        foreach($customer_payment_structure as $customer_payment_structure_all):
                                                            ?>
                                                            <tr id="rowpayment<?php echo $cntr; ?>" >

                                                                <td><span class="p-3 mt-2"><?php echo $cntr; ?></span></td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <input id="editpaymentStuctureDate<?php echo $cntr; ?>" name="editpaymentStuctureDate<?php echo $cntr; ?>" type="date" class="form-control form-control-sm" onclick="calculateAmountEditPayment();" onkeyup="calculateAmountEditPayment();"  value="<?= $customer_payment_structure_all->paymentStuctureDate ?>" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <input id="editpaymentStuctureRemark<?php echo $cntr; ?>" name="editpaymentStuctureRemark<?php echo $cntr; ?>" type="text" class="form-control form-control-sm" style="width:200px;" onclick="calculateAmountEditPayment();" onkeyup="calculateAmountEditPayment();" value="<?= $customer_payment_structure_all->paymentStuctureRemark ?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <div class="input-group" style="width:150px;">
                                                                            <input id="editpaymentStuctureCompletion<?php echo $cntr; ?>" name="editpaymentStuctureCompletion<?php echo $cntr; ?>" type="number" min="0.00" step=any class="form-control form-control-sm" onclick="calculateAmountEditPayment();" onkeyup="calculateAmountEditPayment();" value="<?= $customer_payment_structure_all->paymentStuctureCompletion ?>" />
                                                                            <div class="input-group-prepend">
                                                                                <button type="button" class="btn btn-danger btn-sm">%</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <div class="input-group" style="width:200px;">
                                                                            <div class="input-group-prepend">
                                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                                            </div>
                                                                            <input id="editpaymentStuctureAmount<?php echo $cntr; ?>" name="editpaymentStuctureAmount<?php echo $cntr; ?>" type="number" min="0.00" value="<?= $customer_payment_structure_all->paymentStuctureAmount ?>"  step=any class="form-control form-control-sm" onclick="calculateAmountEditPayment();" onkeyup="calculateAmountEditPayment();" />
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><button type="button" name="remove" id="<?php echo $cntr; ?>" class="btn btn-danger btn-sm btn_removePayment ">X</button>
                                                               </td>

                                                                 
                                                            </tr>
                                                              <?php
                                                             $cntr++;
                                                                
                                                           
                                                             endforeach; 
 ?>
                                                              <input type="hidden" value="<?= --$cntr ?>" id="editPaymentTotalNumberOfDivision" name="editPaymentTotalNumberOfDivision" />

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
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
                                        var m = <?= $cntr ?>;  
                                        console.log(m);
                                    $('#editpaymentstructureadd').click(function(){
                                        var addedPercentage = (0).toFixed(2);
                                        console.log(addedPercentage);
                                        var check = "";
                                        console.log(check);
                                        var checkExceed = "";  
                                         console.log(checkExceed);
                                        var edittotalRows = $("#editPaymentTotalNumberOfDivision").val();
                                         console.log($("#editPaymentTotalNumberOfDivision").val());
                                        console.log(edittotalRows);
                                        for(j = 1; j <= edittotalRows; j++){
                                            console.log($("#editpaymentStuctureAmount"+j).val());
                                            if($("#editpaymentStuctureAmount"+j).val() == ""){
                                                $("#editpaymentStuctureAmount"+j).addClass("is-invalid");
                                                check = "emptyRows";
                                            }else
                                                $("#editpaymentStuctureAmount"+j).removeClass("is-invalid");
                                            if($("#editpaymentStuctureRemark"+j).val() == ""){
                                                $("#editpaymentStuctureRemark"+j).addClass("is-invalid");
                                                check = "emptyRows";
                                            }else
                                                $("#editpaymentStuctureRemark"+j).removeClass("is-invalid");
                                            if($("#editpaymentStuctureDate"+j).val() == ""){
                                                $("#editpaymentStuctureDate"+j).addClass("is-invalid");
                                                check = "emptyRows";
                                            }else
                                                $("#editpaymentStuctureDate"+j).removeClass("is-invalid");
                                                console.log(addedPercentage);
                                            addedPercentage = Number(addedPercentage) + Number($("#editpaymentStuctureCompletion"+j).val());
                                           console.log(addedPercentage);
                                            if(Number(addedPercentage) >= Number(100.00))
                                                checkExceed = "exceedPercentage";
                                        }
                                        if(check != "emptyRows" && checkExceed != "exceedPercentage"){
                                           m++;
                                           
                                            $('#EDITdynamic_field').append('<tr id="rowpayment'+m+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+m+'.</span></td> <td> <div class="form-group mb-0">  <input id="editpaymentStuctureDate'+m+'" name="editpaymentStuctureDate'+m+'" type="date" class="form-control form-control-sm" onclick="calculateAmountEditPayment();" onkeyup="calculateAmountEditPayment();" data-row-id='+m+' /> </div> </td> <td><div class="form-group mb-0"><input id="editpaymentStuctureRemark'+m+'" name="editpaymentStuctureRemark'+m+'" type="text" class="form-control form-control-sm"  onclick="calculateAmountEditPayment();" onkeyup="calculateAmountEditPayment();"data-row-id='+m+' style="width:200px;"/></div></td><td><div class="form-group mb-0"><div class="input-group" style="width:150px;"><input id="editpaymentStuctureCompletion'+m+'" name="editpaymentStuctureCompletion'+m+'" type="number" min="0.00" step=any class="form-control form-control-sm"onclick="calculateAmountEditPayment();" onkeyup="calculateAmountEditPayment();" data-row-id='+m+' /><div class="input-group-prepend"><button type="button" class="btn btn-danger btn-sm">%</button></div></div></div></td><td><div class="form-group mb-0"><div class="input-group" style="width:200px;"><div class="input-group-prepend"><button type="button" class="btn btn-danger btn-sm">&#8377;</button></div><input id="editpaymentStuctureAmount'+m+'" name="editpaymentStuctureAmount'+m+'" type="number" min="0.00" step=any class="form-control form-control-sm"onclick="calculateAmountEditPayment();" onkeyup="calculateAmountEditPayment();" data-row-id='+m+'  /></div></div></td><td><button type="button" name="remove" id="'+m+'" class="btn btn-danger btn-sm btn_removePayment ">X</button></td></tr>');
                                            $("#editPaymentTotalNumberOfDivision").val(m);
                                        } else if(checkExceed == "exceedPercentage")
                                            topEndNotification("warning", "100% completed! You are not able to add more rows!!!");
                                        else
                                            topEndNotification("warning", "Please first complete existing rows");
                                    });
                                    $(document).on('click', '.btn_removePayment', function(){  
                                        
                                       var button_id = $(this).attr("id");  
                                       console.log(button_id);

                                       $('#rowpayment'+button_id+'').remove(); 
                                       m--;
                                       $("#editPaymentTotalNumberOfDivision").val(m);
                                    }); 
                                    //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
                                });</script>
                              <!--  Payment Structure  of Edit Structure Ends here   -->    
                              <!--  Extra Payment Structure  of Edit Structure Starts  here   -->    
                                       <?php
                                 
                                  
                                        $cnt = 1;
                                     ?>
                                    <div class="card card-navy" id="">
                                        <div class="card-header">
                                            <h3 class="card-title">Extra Amount</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-striped dataTable" id="editdynamic_field1">
                                                        <thead>
                                                            <th>S. No.</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                            <th>Action
                                                             <button type="button" name="editextraamountadd" id="editextraamountadd" class="btn btn-warning btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button></th>
                                                        </thead>
                                                        <tbody>
                                                           <?php  foreach($customer_extra_payment_structure  as $extra): 
                                                           ?>

                                                           <tr id="row<?php echo $cnt; ?>" >
                                                              <td><span class="p-3 mt-2"><?php echo $cnt; ?></span></td>
                                                             
                                                                <td>

                                                                    <div class="form-group mb-0">
                                                                        <input id="editExtraAmountRemarks1" name="editExtraAmountRemarks[<?php echo $cnt; ?>]" type="text" class="form-control form-control-sm" value="<?= $extra->ExtraAmountRemarks?>"/>
                                                                    </div>
                                                                </td>
                                                              
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <div class="input-group">
                                                                            <input id="editExtraAmount1" name="editExtraAmount[<?php echo $cnt; ?>]" type="number" min="0.00" step=any class="form-control form-control-sm" value="<?= $extra->ExtraAmount?>"/>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                              <td><button type="button" name="remove" id="<?php echo $cnt; ?>" class="btn btn-danger btn_remove">X</button></td>
                                                            </tr>
                                                              <?php
                                                             $cnt++;
                                                           
                                                           endforeach;

                                                          ?>
                                                            
                                                         <input type="hidden" value="<?= $cnt ?>" id="edittotalextraamount" name="edittotalextraamount" />  
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                     var k = <?php echo $cnt; ?>;
                                        
                                    $('#editextraamountadd').click(function(){
                                    var addedExtraAmount = (0).toFixed(2);
                                    var checkAmt = "";
                                    var totalRow = $("#edittotalextraamount").val();
                                     for(l = 1; l <= totalRow; l++){
                                    if($("#editExtraAmount"+l).val() == ""){
                                        $("#editExtraAmount"+l).addClass("is-invalid");
                                        checkAmt = "emptyRows";
                                    }else
                                        $("#editExtraAmount"+l).removeClass("is-invalid");
                                    if($("#editExtraAmountRemarks"+l).val() == ""){
                                        $("#editExtraAmountRemarks"+l).addClass("is-invalid");
                                        checkAmt = "emptyRows";
                                    }else
                                        $("#editExtraAmountRemarks"+l).removeClass("is-invalid");           
                                }
                                    if(checkAmt != "emptyRows"){
                                   
                                    //console.log("K="+k);
                                    $('#editdynamic_field1').append('<tr id="extraAmtRow'+k+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+k+'.</span></td><td><input id="editExtraAmountRemarks'+k+'" name="editExtraAmountRemarks[]" type="text" class="form-control form-control-sm" /></td><td><input id="editExtraAmount'+k+'" name="editExtraAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm" /></td><td><button type="button" name="remove'+k+'" id="'+k+'" class="btn btn-danger btn-sm btn_removeExt">X</button></td></tr>');
                                    $("#edittotalextraamount").val(k);
                                     k++; 
                                } else {
                                    topEndNotification("warning", "Please first complete existing rows");
                                }
                                     
                                });
                                $("#editExtraAmount"+k).addClass("calculate-amount");
                                $("#editExtraAmountRemarks"+k).addClass("calculate-amount");      
                                
                                $(document).on('click', '.btn_removeExt', function(){  
                                   var button_id1 = $(this).attr("id");   
                                   $('#extraAmtRow'+button_id1+'').remove(); 
                                   k--;
                                  //  console.log("K="+k);
                                   $("#edittotalextraamount").val(k);
                                }); 
                                 $("#editfirstApplicantMaritalStatus").change(function () {
                                    if($("#editfirstApplicantMaritalStatus").val() == "Single"){
                                        $("#editdivFirstApplicantDateOfAnniversary").addClass("display-none");
                                        $("#editdivFirstApplicantNoOfChild").addClass("display-none");
                                    } else{
                                        $("#editdivFirstApplicantDateOfAnniversary").removeClass("display-none");
                                        $("#editdivFirstApplicantNoOfChild").removeClass("display-none");
                                    }
                                });
                             </script>
                              <!--  Extra Amount of Edit Section Ends here   -->    
                              <!--  First Applicant of Edit Section Starts here   -->    

                                   
                                    <div class="card card-navy" id="editfirstApplicantDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">First Applicant</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantName">Name</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <select id="editfirstApplicantTitle" name="editfirstApplicantTitle" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                                    <option selected value="<?= $customer_info->title ?>"><?= $customer_info->title ?>.</option>
                                                                     <option <?php if($customer_info->title == "Mr") echo "selected" ?> value="<?= $customer_info->title ?>">Mr.</option>
                                                                    <option <?php if($customer_info->title == "Mrs") echo "selected" ?> value="<?= $customer_info->title ?>">Mrs.</option>
                                                                    <option <?php if($customer_info->title == "Ms") echo "selected" ?> value="<?= $customer_info->title ?>">Ms.</option>
                                                                </select>
                                                            </div>
                                                            <input id="editfirstApplicantName" name="editfirstApplicantName" type="text" class="form-control form-control-sm" value="<?= $customer_info->name ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantParentOf">S/D/W of</label>
                                                        <input id="editfirstApplicantParentOf" name="editfirstApplicantParentOf" type="text" class="form-control form-control-sm" value="<?= $customer_info->parentName ?>"/>
                                                    </div>
                                                </div>
                                                
                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantPhoneNumber">Phone Number</label>
                                                        <input id="editfirstApplicantPhoneNumber" name="editfirstApplicantPhoneNumber" type="number" min="0" class="form-control form-control-sm" value="<?= $customer_info->phoneNumber ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantAlternatePhoneNumber">Alternate Phone Number</label>
                                                        <input id="editfirstApplicantAlternatePhoneNumber" name="editfirstApplicantAlternatePhoneNumber" type="number" min="0" class="form-control form-control-sm" value="<?= $customer_info->phoneNumberAlternate ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantAlternateFax">Fax</label>
                                                        <input id="editfirstApplicantAlternateFax" name="editfirstApplicantAlternateFax" type="number" min="0" class="form-control form-control-sm"  value="<?= $customer_info->fax ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantEmailId">Email Id</label>
                                                        <input id="editfirstApplicantEmailId" name="editfirstApplicantEmailId" type="email" class="form-control form-control-sm" value="<?= $customer_info->emailId ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantDateOfBirth">Date Of Birth</label>
                                                        <input id="editfirstApplicantDateOfBirth" name="editfirstApplicantDateOfBirth" type="date" class="form-control form-control-sm" value="<?= $customer_info->dob ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantAge">Age</label>
                                                        <div class="input-group">
                                                            <input id="editfirstApplicantAge" name="editfirstApplicantAge" type="text" class="form-control form-control-sm"  value="<?= $customer_info->age ?>"readonly/>
                                                            <div class="input-group-prepend">
                                                                <button type="button" id="editfirstApplicantCalculateAge" class="btn btn-danger btn-sm">Calculate</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantMaritalStatus">Marital Status</label>
                                                        <select id="editfirstApplicantMaritalStatus" name="editfirstApplicantMaritalStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy"> 
                                                            <option  <?php if($customer_info->maritalStatus == "Single") echo "selected" ?> value="<?= $customer_info->maritalStatus ?>">Single</option>
                                                            <option <?php if($customer_info->maritalStatus == "Married") echo "selected" ?> value="<?= $customer_info->maritalStatus ?>">Married</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="editdivFirstApplicantDateOfAnniversary">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantDateOfAnniversary">Date Of Anniversary</label>
                                                        <input id="editfirstApplicantDateOfAnniversary" name="editfirstApplicantDateOfAnniversary" type="date" class="form-control form-control-sm" value="<?= $customer_info->dateOfAnniversary ?>"/>
                                                    </div>
                                                </div>
                                                <div id="editdivFirstApplicantNoOfChild">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantNoOfChild">Number Of Children</label>
                                                        <input id="editfirstApplicantNoOfChild" name="editfirstApplicantNoOfChild" type="number" min="0" class="form-control form-control-sm" value="<?= $customer_info->noOfChild ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantReligion">Religion</label>
                                                        <input id="editfirstApplicantReligion" name="editfirstApplicantReligion" type="text" class="form-control form-control-sm" value="<?= $customer_info->religion ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantCaste">Caste</label>
                                                        <input id="editfirstApplicantCaste" name="editfirstApplicantCaste" type="text" class="form-control form-control-sm" value="<?= $customer_info->caste ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicantResidentialStatus">Residential Status</label>
                                                        <select id="editfirstApplicantResidentialStatus" name="editfirstApplicantResidentialStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option <?php if($customer_info->residentialStatus == "Resident") echo "selected" ?> value="<?= $customer_info->residentialStatus ?>">Resident</option>
                                                            <option <?php if($customer_info->residentialStatus == "Non-Resident") echo "selected" ?> value="<?= $customer_info->residentialStatus ?>">Non-Resident</option>
                                                            <option <?php if($customer_info->residentialStatus == "Foreign National of Indian Origin") echo "selected" ?> value="<?= $customer_info->residentialStatus ?>">Foreign National of Indian Origin</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicanOccupation">Occupation</label>
                                                        <input id="editfirstApplicanOccupation" name="editfirstApplicanOccupation" type="text" class="form-control form-control-sm" value="<?= $customer_info->occupation ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicanPanNumber">PAN Number</label>
                                                        <input id="editfirstApplicanPanNumber" name="editfirstApplicanPanNumber"  class="form-control form-control-sm" value="<?= $customer_info->panNumber ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicanAadharNumber">Aadhar Number</label>
                                                        <input id="editfirstApplicanAadharNumber" name="editfirstApplicanAadharNumber"  class="form-control form-control-sm" value="<?= $customer_info->aadharNumber ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicanPermanentAddress">Permanent Address</label>
                                                        <textarea id="editfirstApplicanPermanentAddress" name="editfirstApplicanPermanentAddress" class="form-control form-control-sm"  value="<?= $customer_info->permanentAddress ?>" ><?= $customer_info->permanentAddress ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="editfirstApplicanCorrespondenceAddress">Correspondence Address</label>
                                                        <textarea id="editfirstApplicanCorrespondenceAddress" name="editfirstApplicanCorrespondenceAddress" class="form-control form-control-sm" value="<?= $customer_info->correspondenceAddress ?>"><?= $customer_info->correspondenceAddress ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              <!--  First Applicant of Edit Section Ends here   -->   
                             <!--  Second Applicant of Edit Section Starts here   -->    

                                    <div class="card card-navy" id="editsecondApplicantDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">Second Applicant</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantName">Name</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <select id="editsecondApplicantTitle" name="editsecondApplicantTitle" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                                    <option <?php if($customer_second_applicant->title == "Mr") echo "selected" ?> value="<?= $customer_second_applicant->title ?>">Mr.</option>
                                                                    <option <?php if($customer_second_applicant->title == "Mrs") echo "selected" ?> value="<?= $customer_second_applicant->title ?>">Mrs.</option>
                                                                    <option <?php if($customer_second_applicant->title == "Ms") echo "selected" ?> value="<?= $customer_second_applicant->title ?>">Ms.</option>
                                                                </select>
                                                            </div>
                                                            <input id="editsecondApplicantName" name="editsecondApplicantName" type="text" class="form-control form-control-sm" value="<?= $customer_second_applicant->name ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantParentOf">S/D/W of</label>
                                                        <input id="editsecondApplicantParentOf" name="editsecondApplicantParentOf" type="text" class="form-control form-control-sm" value="<?= $customer_second_applicant->parentName ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantPhoneNumber">Phone Number</label>
                                                        <input id="editsecondApplicantPhoneNumber" name="editsecondApplicantPhoneNumber" type="number" min="0" class="form-control form-control-sm" value="<?= $customer_second_applicant->phoneNumber ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantAlternatePhoneNumber">Alternate Phone Number</label>
                                                        <input id="editsecondApplicantAlternatePhoneNumber" name="editsecondApplicantAlternatePhoneNumber" type="number" min="0" class="form-control form-control-sm" value="<?= $customer_second_applicant->phoneNumberAlternate ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantAlternateFax">Fax</label>
                                                        <input id="editsecondApplicantAlternateFax" name="editsecondApplicantAlternateFax" type="number" min="0" class="form-control form-control-sm" value="<?= $customer_second_applicant->fax ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantEmailId">Email Id</label>
                                                        <input id="editsecondApplicantEmailId" name="editsecondApplicantEmailId" type="email" class="form-control form-control-sm" value="<?= $customer_second_applicant->emailId ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantDateOfBirth">Date Of Birth</label>
                                                        <input id="editsecondApplicantDateOfBirth" name="editsecondApplicantDateOfBirth" type="date" class="form-control form-control-sm" value="<?= $customer_second_applicant->dob ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantAge">Age</label>
                                                        <div class="input-group">
                                                            <input id="editsecondApplicantAge" name="editsecondApplicantAge" type="text" class="form-control form-control-sm" value="<?= $customer_second_applicant->age ?>" readonly/>
                                                            <div class="input-group-prepend">
                                                                <button type="button" id="editsecondApplicantCalculateAge" class="btn btn-danger btn-sm ">Calculate</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <script>
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
                                        // Edit second Applicant Find Age Section Start ------------------------------------------------------------------------------------------------------
                                        $('#editsecondApplicantCalculateAge').click( function () {

                                            topEndNotification("info", "Calculating Age...");
                                            $('#editsecondApplicantAge').attr("readonly", "readonly");
                                            var formData = {"action":"editfetchsecondApplicantCalculatedAge","dateOfBirth": $("#editsecondApplicantDateOfBirth").val()};
                                            $.ajax({
                                                url: 'application/view/admin/customers.php',
                                                type: 'POST',
                                                data: formData,
                                                success: function (data) {
                                                    setTimeout( function() {
                                                        topEndNotification("info", data);
                                                        $('#editsecondApplicantAge').val(data);
                                                    }, 500);
                                                }
                                            });
                                        });
                                        });
                                        // Edit second Applicant Find Age Section End --------------------------------------------------------------------------------------------------------
                                        </script>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantMaritalStatus">Marital Status</label>
                                                        <select id="editsecondApplicantMaritalStatus" name="editsecondApplicantMaritalStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option  <?php if($customer_second_applicant->maritalStatus == "Single") echo "selected" ?> value="<?= $customer_second_applicant->maritalStatus ?>">Single</option>
                                                            <option <?php if($customer_second_applicant->maritalStatus == "Married") echo "selected" ?> value="<?= $customer_second_applicant->maritalStatus ?>">Married</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="editdivSecondApplicantDateOfAnniversary">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantDateOfAnniversary">Date Of Anniversary</label>
                                                        <input id="editsecondApplicantDateOfAnniversary" name="editsecondApplicantDateOfAnniversary" type="date" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div id="editdivSecondApplicantNoOfChild">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantNoOfChild">Number Of Children</label>
                                                        <input id="editsecondApplicantNoOfChild" name="editsecondApplicantNoOfChild" type="number" min="0" class="form-control form-control-sm" value="<?= $customer_second_applicant->noOfChild ?>"/>
                                                    </div>
                                                </div>
                                                 <script>
                                                //         $("#editfirstApplicantMaritalStatus").change(function () {
                                                //         if($("#editfirstApplicantMaritalStatus").val() == "Single"){
                                                           

                                                //           $("#editdivFirstApplicantDateOfAnniversary").addClass("display-none");
                                                //           $("#editdivFirstApplicantNoOfChild").addClass("display-none");
                                                //           } else{
                                                            

                                                //           $("#editdivFirstApplicantDateOfAnniversary").removeClass("display-none");
                                                //           $("#editdivFirstApplicantNoOfChild").removeClass("display-none");
                                                //           }
                                                //         });
                                                // $("#editsecondApplicantMaritalStatus").change(function () {

                                                // if($("#editsecondApplicantMaritalStatus").val() == "Single"){
                                                    
                                                // $("#editdivSecondApplicantDateOfAnniversary").addClass("display-none");
                                                // $("#editdivSecondApplicantNoOfChild").addClass("display-none");
                                                // } else{
                                                  
                                                // $("#editdivSecondApplicantDateOfAnniversary").removeClass("display-none");
                                                // $("#editdivSecondApplicantNoOfChild").removeClass("display-none");
                                                // }
                                                //  });
                                             </script>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantReligion">Religion</label>
                                                        <input id="editsecondApplicantReligion" name="editsecondApplicantReligion" type="text" class="form-control form-control-sm" value="<?= $customer_second_applicant->religion ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantCaste">Caste</label>
                                                        <input id="editsecondApplicantCaste" name="editsecondApplicantCaste" type="text" class="form-control form-control-sm" value="<?= $customer_second_applicant->caste ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicantResidentialStatus">Residential Status</label>
                                                        <select id="editsecondApplicantResidentialStatus" name="editsecondApplicantResidentialStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option selected value="Resident">Resident</option>
                                                            <option value="Non-Resident">Non-Resident</option>
                                                            <option value="Foreign National of Indian Origin">Foreign National of Indian Origin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicanOccupation">Occupation</label>
                                                        <input id="editsecondApplicanOccupation" name="editsecondApplicanOccupation" type="text" class="form-control form-control-sm" value="<?= $customer_second_applicant->occupation ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicanPanNumber">PAN Number</label>
                                                        <input id="editsecondApplicanPanNumber" name="editsecondApplicanPanNumber" type="text" class="form-control form-control-sm" value="<?= $customer_second_applicant->panNumber ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicanAadharNumber">Aadhar Number</label>
                                                        <input id="editsecondApplicanAadharNumber" name="editsecondApplicanAadharNumber" type="text"  class="form-control form-control-sm" value="<?= $customer_second_applicant->aadharNumber ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicanPermanentAddress">Permanent Address</label>
                                                        <textarea id="editsecondApplicanPermanentAddress" name="editsecondApplicanPermanentAddress" class="form-control form-control-sm" value="<?= $customer_second_applicant->permanentAddress ?>"><?= $customer_second_applicant->permanentAddress ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="editsecondApplicanCorrespondenceAddress">Correspondence Address</label>
                                                        <textarea id="editsecondApplicanCorrespondenceAddress" name="editsecondApplicanCorrespondenceAddress" class="form-control form-control-sm" value="<?= $customer_second_applicant->correspondenceAddress ?>"><?= $customer_second_applicant->correspondenceAddress ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                               
                                   
                                       <!--  </div> -->
                                        <input type="hidden" id="editTableId" name="editTableId" value="<?= $_POST["id"] ?>" />
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
            // ------------ Fetch first Applicant Edit Section End ------------------
            // ------------ Fetch Second Applicant Edit Section Start ----------------
            // ------------------------------------------------------
          
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchDelete":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])): $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_property_info = json_decode($rows["customer_property_info"]); ?>
                              
                      <?php      endforeach;
                        endif; 
                       ?>
                       

                      
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            Do you really wanna delete this data???
                        </div>
                        <input type="hidden" id="tableId" name="tableId" value="<?= $_POST["id"] ?>" />
                        <input type="hidden" id="tableName" name="tableName" value="tbl_customer" />

                        <input type="hidden" value="<?= $customer_property_info->projectName ?>"  id="projectName" name="projectName"/>
                         <input type="hidden" value="<?= $customer_property_info->phase ?>"  id="phase" name="phase"/>
                          <input type="hidden" value="<?= $customer_property_info->building ?>"  id="building" name="building"/>
                            <input type="hidden" value="<?= $customer_property_info->floors  ?>"  id="floors" name="floors"/>
                             <input type="hidden" value="<?= $customer_property_info->flat_no  ?>"  id="flat_no" name="flat_no"/>
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
            // ------------------------------------------------------------------------
            // ------------ Fetch Inner Property Using Project Id Section Start -----------
            // ------------------------------------------------------------------------
            case "fetchPhaseFromProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $phase = array();
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                array_push($phase, $properties_info->phase);
                            endforeach;
                            if(!empty($phase)):
                                ?>
                                <option value="" selected disabled>Select Phase</option>
                                <?php
                                foreach(array_unique($phase) as $allPhase):
                                    $databaseObj->select("tbl_phase");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `phase_id` = '".$allPhase."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rows):
                                            $phase_info = json_decode($rows["phase_info"]);
                                            ?>
                                                <option value="<?= $rows["phase_id"] ?>"><?= $phase_info->phase ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                endforeach;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
                case "fetchPhaseFromeditProjectId":

                  if($authority == 1):
                    
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                       
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $phase = array();
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                array_push($phase, $properties_info->phase);
                            endforeach;
                            if(!empty($phase)):
                                ?>
                                <option value="" selected disabled>Select Phase</option>
                                <?php
                                foreach(array_unique($phase) as $allPhase):
                                    $databaseObj->select("tbl_phase");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `phase_id` = '".$allPhase."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rows):
                                            $phase_info = json_decode($rows["phase_info"]);
                                            ?>
                                                <option value="<?= $rows["phase_id"] ?>"><?= $phase_info->phase ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                endforeach;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
            case "fetchBlockFromProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $block = array();
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                if($_POST["phase_id"] == $properties_info->phase):
                                    array_push($block, $properties_info->building);
                                endif;
                            endforeach;
                            if(!empty($block)):
                                ?>
                                <option value="" selected disabled>Select Block</option>
                                <?php
                                foreach(array_unique($block) as $allBlock):
                                    $databaseObj->select("tbl_building");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `building_id` = '".$allBlock."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rows):
                                            $building_info = json_decode($rows["building_info"]);
                                            ?>
                                                <option value="<?= $rows["building_id"] ?>"><?= $building_info->building ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                endforeach;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
                case "fetchBlockFromeditProjectId":
                  if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $block = array();
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                if($_POST["phase_id"] == $properties_info->phase):
                                    array_push($block, $properties_info->building);
                                endif;
                            endforeach;
                            if(!empty($block)):
                                ?>
                                <option value="" selected disabled>Select Block</option>
                                <?php
                                foreach(array_unique($block) as $allBlock):
                                    $databaseObj->select("tbl_building");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `building_id` = '".$allBlock."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rows):
                                            $building_info = json_decode($rows["building_info"]);
                                            ?>
                                                <option value="<?= $rows["building_id"] ?>"><?= $building_info->building ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                endforeach;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
            case "fetchFloorFromProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $floors = "";
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                if($_POST["phase_id"] == $properties_info->phase && $_POST["building_id"] == $properties_info->building):
                                    $floors = $properties_info->total_floors;
                                    break;
                                endif;
                            endforeach;
                            if(!empty($floors)):
                                ?>
                                <option value="" selected disabled>Select Floor Number</option>
                                <?php
                                for($i = 1; $i<=$floors; $i++):
                                    ?>
                                    <option value="<?= $i ?>">Floor | <?= $i ?></option>
                                    <?php
                                endfor;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
                case "fetchFloorFromeditProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $floors = "";
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                if($_POST["phase_id"] == $properties_info->phase && $_POST["building_id"] == $properties_info->building):
                                    $floors = $properties_info->total_floors;
                                    break;
                                endif;
                            endforeach;
                            if(!empty($floors)):
                                ?>
                                <option value="" selected disabled>Select Floor Number</option>
                                <?php
                                for($i = 1; $i<=$floors; $i++):
                                    ?>
                                    <option value="<?= $i ?>">Floor | <?= $i ?></option>
                                    <?php
                                endfor;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
                 case "fetchFloorFromProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $floors = "";
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                if($_POST["phase_id"] == $properties_info->phase && $_POST["building_id"] == $properties_info->building):
                                    $floors = $properties_info->total_floors;
                                    break;
                                endif;
                            endforeach;
                            if(!empty($floors)):
                                ?>
                                <option value="" selected disabled>Select Floor Number</option>
                                <?php
                                for($i = 1; $i<=$floors; $i++):
                                    ?>
                                    <option value="<?= $i ?>">Floor | <?= $i ?></option>
                                    <?php
                                endfor;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
            case "fetchFlatFromProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $floors = "";
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                if($_POST["phase_id"] == $properties_info->phase && $_POST["building_id"] == $properties_info->building):
                                    $floors = $properties_info->floors;
                                    break;
                                endif;
                            endforeach;
                            if(!empty($floors)):
                                $flats = "";
                                $i = 0;
                                foreach($floors as $allFloors):
                                    if($_POST["floors"] == ++$i):
                                        $flats = $allFloors;
                                        break;
                                    endif;
                                endforeach;
                                if(!empty($flats)):
                                    ?>
                                    <option value="" selected disabled>Select Flat Number</option>
                                    <?php
                                    foreach($flats as $allFlats):

                                        if(empty($allFlats->customer_details->customer_id)):
                                            ?>
                                            <option value='<?= $allFlats->flat_no ?>' data-property-type="<?= $allFlats->property_type ?>" data-accommodation-type="<?= $allFlats->accommodation_type ?>" data-square-feet="<?= $allFlats->square_feet ?>" data-price-per-square="<?= $allFlats->price_per_square ?>" data-price-total="<?= $allFlats->price_total ?>" data-percent-completed="<?= $allFlats->percent_completed ?>" ><?= $allFlats->flat_no ?></option>
                                            <?php
                                        endif;
                                    endforeach;
                                else:
                                    ?>
                                    <option selected disabled>No properties added on this Project.</option>
                                    <?php
                                endif;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
                 case "fetchFlatFromeditProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`properties_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $floors = "";
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                if($_POST["phase_id"] == $properties_info->phase && $_POST["building_id"] == $properties_info->building):
                                    $floors = $properties_info->floors;
                                    break;
                                endif;
                            endforeach;
                            if(!empty($floors)):
                                $flats = "";
                                $i = 0;
                                foreach($floors as $allFloors):
                                    if($_POST["floors"] == ++$i):
                                        $flats = $allFloors;
                                        break;
                                    endif;
                                endforeach;
                                if(!empty($flats)):
                                    ?>
                                    <option value="" selected disabled>Select Flat Number</option>
                                    <?php
                                    foreach($flats as $allFlats):
                                        if(empty($allFlats->customer_details->customer_id)):
                                            ?>
                                            <option value='<?= $allFlats->flat_no ?>' data-property-type="<?= $allFlats->property_type ?>" data-accommodation-type="<?= $allFlats->accommodation_type ?>" data-square-feet="<?= $allFlats->square_feet ?>" data-price-per-square="<?= $allFlats->price_per_square ?>" data-price-total="<?= $allFlats->price_total ?>" data-percent-completed="<?= $allFlats->percent_completed ?>" ><?= $allFlats->flat_no ?></option>
                                            <?php
                                        endif;
                                    endforeach;
                                else:
                                    ?>
                                    <option selected disabled>No properties added on this Project.</option>
                                    <?php
                                endif;
                            else:
                                ?>
                                <option selected disabled>No properties added on this Project.</option>
                                <?php
                            endif;
                        else:
                            ?>
                            <option selected disabled>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option selected disabled>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option selected disabled>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
            // ------------------------------------------------------------------------
            // ------------ Fetch Using Project Id Section Start -----------
            // ------------------------------------------------------------------------
            case "fetchPhaseWithProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`projects_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $project_info = json_decode($rows["projects_info"]);
                                $count_i = 0;
                                foreach($project_info->properties as $property):
                                    $databaseObj->select("tbl_phase");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `phase_id` = '".$property->phase."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        foreach($getData as $rows):
                                            $phase_info = json_decode($rows["phase_info"]);
                                            $phase = $phase_info->phase;
                                            $phase_id = $rows["phase_id"];
                                            $data_array_temp = array();
                                            $data_array_temp = array(
                                                                "id"    =>  $phase_id,
                                                                "val"   =>  $phase
                                                            );
                                            if(count($data_array) > 0):
                                                for($i = $count_i; $i < count($data_array); $i++):
                                                    echo $data_array[$i]["id"]."<br/>";
                                                    if($data_array[$i]["id"] == $phase_id):
                                                        $flagg = 1;
                                                        break;
                                                    endif;
                                                endfor;
                                                if(!isset($flagg)):
                                                    array_push($data_array, $data_array_temp);
                                                endif;
                                            else:
                                                array_push($data_array, $data_array_temp);
                                            endif;
                                        endforeach;
                                        $count_i++;
                                    endif;
                                endforeach;
                            endforeach;
                            if(count($data_array) > 0):
                                ?>
                                <option value="" selected disabled>Select Phase</option>
                                <?php
                                foreach ($data_array as $data_array_all):
                                    ?>
                                    <option value='<?= $data_array_all["id"] ?>'><?= $data_array_all["val"] ?></option>
                                    <?php
                                endforeach;
                            else:
                                echo "no";
                            endif;
                        else:
                            ?>
                            <option>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
            case "fetchBlockWithProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`projects_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $project_info = json_decode($rows["projects_info"]);
                                foreach($project_info->properties as $property):
                                    $databaseObj->select("tbl_block");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `block_id` = '".$property->block."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        foreach($getData as $rows):
                                            $block_info = json_decode($rows["block_info"]);
                                            $block = $block_info->block;
                                            $block_id = $rows["block_id"];
                                            $data_array_temp = array();
                                            $data_array_temp = array(
                                                                "id"    =>  $block_id,
                                                                "val"   =>  $block
                                                            );
                                            array_push($data_array, $data_array_temp);
                                        endforeach;
                                    endif;
                                endforeach;
                            endforeach;
                            if(count($data_array) > 0):
                                ?>
                                <option value="" selected disabled>Select Block</option>
                                <?php
                                foreach ($data_array as $data_array_all):
                                    ?>
                                    <option value='<?= $data_array_all["id"] ?>'><?= $data_array_all["val"] ?></option>
                                    <?php
                                endforeach;
                            else:
                                echo "no";
                            endif;
                        else:
                            ?>
                            <option>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
            case "fetchBuildingWithProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`projects_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $project_info = json_decode($rows["projects_info"]);
                                foreach($project_info->properties as $property):
                                    $databaseObj->select("tbl_building");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `building_id` = '".$property->building."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        foreach($getData as $rows):
                                            $building_info = json_decode($rows["building_info"]);
                                            $building = $building_info->building;
                                            $building_id = $rows["building_id"];
                                            $data_array_temp = array();
                                            $data_array_temp = array(
                                                                "id"    =>  $building_id,
                                                                "val"   =>  $building
                                                            );
                                            array_push($data_array, $data_array_temp);
                                        endforeach;
                                    endif;
                                endforeach;
                            endforeach;
                            if(count($data_array) > 0):
                                ?>
                                <option value="" selected disabled>Select Phase</option>
                                <?php
                                foreach ($data_array as $data_array_all):
                                    ?>
                                    <option value='<?= $data_array_all["id"] ?>'><?= $data_array_all["val"] ?></option>
                                    <?php
                                endforeach;
                            else:
                                echo "no";
                            endif;
                        else:
                            ?>
                            <option>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
            case "fetchPropertyTypeWithProjectId":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`projects_id` DESC");
                        $getData = $databaseObj->get();
                        $data_array = array();
                        $data_array_temp = array();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $project_info = json_decode($rows["projects_info"]);
                                foreach($project_info->properties as $property):
                                    $databaseObj->select("tbl_property_type");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `property_type_id` = '".$property->propertyType."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        foreach($getData as $rows):
                                            $property_type_info = json_decode($rows["property_type_info"]);
                                            $property_type = $property_type_info->propertyType;
                                            $property_type_id = $rows["property_type_id"];
                                            $data_array_temp = array();
                                            $data_array_temp = array(
                                                                "id"    =>  $property_type_id,
                                                                "val"   =>  $property_type
                                                            );
                                            array_push($data_array, $data_array_temp);
                                        endforeach;
                                    endif;
                                endforeach;
                            endforeach;
                            if(count($data_array) > 0):
                                ?>
                                <option value="" selected disabled>Select Property Type</option>
                                <?php
                                foreach ($data_array as $data_array_all):
                                    ?>
                                    <option value='<?= $data_array_all["id"] ?>'><?= $data_array_all["val"] ?></option>
                                    <?php
                                endforeach;
                            else:
                                echo "no";
                            endif;
                        else:
                            ?>
                            <option>Something went wrong plase try again or refresh.</option>
                            <?php
                        endif;
                    else:
                        ?>
                        <option>Something went wrong plase try again or refresh.</option>
                        <?php
                    endif;
                else:
                    ?>
                    <option>You have no permission to see the information of this Data.</option>
                    <?php
                endif;
                break;
            // ------------------------------------------------------------------------
            // ------------ Fetch Using Project Id Section End -------------
            // ------------------------------------------------------------------------
            // ------------------------------------------------------------------------
            // ------------ Fetch Properties Using Property Section Start -------------
            // ------------------------------------------------------------------------
            case "fetchPriceAndLocation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`projects_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_info = json_decode($rows["projects_info"]);
                                $projects_fetch_info = json_decode($_POST["val"]);
                                foreach($customer_info->properties as $property):
                                    if($property->propertyType == $projects_fetch_info->propertyType && $property->accommodationType == $projects_fetch_info->accommodationType && $property->squareFeet == $projects_fetch_info->squareFeet):
                                        echo "success|||-|||".$customer_info->projectLocation."|||-|||".$property->price;
                                    endif;
                                endforeach;
                            endforeach;
                        else:
                            echo "Something went wrong plase try again or refresh.";
                        endif;
                    else:
                        echo "Something went wrong plase try again or refresh.";
                    endif;
                else:
                    echo "You have no permission to see the information of this Data.";
                endif;
                break;
                 case "
                 fetcheditPriceAndLocation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`projects_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_info = json_decode($rows["projects_info"]);
                                $projects_fetch_info = json_decode($_POST["val"]);
                                foreach($customer_info->properties as $property):
                                    if($property->propertyType == $projects_fetch_info->propertyType && $property->accommodationType == $projects_fetch_info->accommodationType && $property->squareFeet == $projects_fetch_info->squareFeet):
                                        echo "success|||-|||".$customer_info->projectLocation."|||-|||".$property->price;
                                    endif;
                                endforeach;
                            endforeach;
                        else:
                            echo "Something went wrong plase try again or refresh.";
                        endif;
                    else:
                        echo "Something went wrong plase try again or refresh.";
                    endif;
                else:
                    echo "You have no permission to see the information of this Data.";
                endif;
                break;
            // ------------------------------------------------------------------------
            // ------------ Fetch Properties Using Property Section End ---------------
            // ------------------------------------------------------------------------
            // ------------------------------------------------------------------------
            // ------------ Fetch First Applicant Calculated Age Section Start --------
            // ------------------------------------------------------------------------
            case "fetchFirstApplicantCalculatedAge":
                if($authority == 1):
                    if(isset($_POST["dateOfBirth"]) && !empty($_POST["dateOfBirth"])):
                        $dob = new DateTime($_POST["dateOfBirth"]);
                        $today = new Datetime(date('Y-m-d'));
                        if(strtotime($_POST["dateOfBirth"]) < strtotime(date("Y-m-d"))):
                            $age = $today->diff($dob);
                            echo $age->y;
                        else:
                            echo "Please Select Correct Date.";
                        endif;
                    else:
                        echo "First Select Your Date Of Birth.";
                    endif;
                else:
                    echo "You have no permission to Calculate Your Age.";
                endif;
                break;
                case "editfetchFirstApplicantCalculatedAge":
                if($authority == 1):
                    if(isset($_POST["dateOfBirth"]) && !empty($_POST["dateOfBirth"])):
                        $dob = new DateTime($_POST["dateOfBirth"]);
                        $today = new Datetime(date('Y-m-d'));
                        if(strtotime($_POST["dateOfBirth"]) < strtotime(date("Y-m-d"))):
                            $age = $today->diff($dob);
                            echo $age->y;
                        else:
                            echo "Please Select Correct Date.";
                        endif;
                    else:
                        echo "First Select Your Date Of Birth.";
                    endif;
                else:
                    echo "You have no permission to Calculate Your Age.";
                endif;
                break;
            // ------------------------------------------------------------------------
            // ------------ Fetch First Applicant Calculated Age Section End ----------
            // ------------ Edit Fetch First Applicant Calculated Age Section Start --------
            // ------------------------------------------------------------------------
           
            // ------------------------------------------------------------------------
            // ------------ Edit Fetch First Applicant Calculated Age Section End ----------
            // ------------ Edit Fetch Second Applicant Calculated Age Section Start --------
            // ------------------------------------------------------------------------
            case "editfetchsecondApplicantCalculatedAge":
                if($authority == 1):
                    if(isset($_POST["dateOfBirth"]) && !empty($_POST["dateOfBirth"])):
                        $dob = new DateTime($_POST["dateOfBirth"]);
                        $today = new Datetime(date('Y-m-d'));
                        if(strtotime($_POST["dateOfBirth"]) < strtotime(date("Y-m-d"))):
                            $age = $today->diff($dob);
                            echo $age->y;
                        else:
                            echo "Please Select Correct Date.";
                        endif;
                    else:
                        echo "First Select Your Date Of Birth.";
                    endif;
                else:
                    echo "You have no permission to Calculate Your Age.";
                endif;
                break;
            // ------------------------------------------------------------------------
            // ------------ Edit Fetch First Applicant Calculated Age Section End ----------
            // ------------------------------------------------------------------------
            // ------------------------------------------------------------------------
            // ------------ Fetch Second Applicant Calculated Age Section Start -------
            // ------------------------------------------------------------------------
            case "fetchSecondApplicantCalculatedAge":
                if($authority == 1):
                    if(isset($_POST["dateOfBirth"]) && !empty($_POST["dateOfBirth"])):
                        $dob = new DateTime($_POST["dateOfBirth"]);
                        $today = new Datetime(date('Y-m-d'));
                        if(strtotime($_POST["dateOfBirth"]) < strtotime(date("Y-m-d"))):
                            $age = $today->diff($dob);
                            echo $age->y;
                        else:
                            echo "Please Select Correct Date.";
                        endif;
                    else:
                        echo "First Select Your Date Of Birth.";
                    endif;
                else:
                    echo "You have no permission to Calculate Your Age.";
                endif;
                break;
            // ------------------------------------------------------------------------
            // ------------ Fetch Second Applicant Calculated Age Section End ---------
            // ------------------------------------------------------------------------
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