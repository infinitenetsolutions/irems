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
    $manageCompanyDir = "../assets/admin/projects/";
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
                                                                <button type="button" id="edit-second-button-<?= $rows["customer_id"] ?>" class="edit-second-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update Second Appilcant Info">
                                                                    <i class="fa fa-users fa-sm"></i> <i class="fa fa-edit fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="service-button-<?= $rows["customer_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Services">
                                                                    <i class="fa fa-coffee fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="payment-structure-button-<?= $rows["customer_id"] ?>" class="payment-structure-button btn btn-xs btn-info mt-1 mb-1" title="Payment Structure">
                                                                    <i class="fa fa-money-check-alt fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="payment-structure-payment-button-<?= $rows["customer_id"] ?>" class="payment-structure-payment-button btn btn-xs btn-danger mt-1 mb-1" title="Payment Structure Payments">
                                                                    <i class="fas fa-money-bill-wave fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="payment-button-<?= $rows["customer_id"] ?>" class="payment-button btn btn-xs btn-warning mt-1 mb-1" title="Payments">
                                                                    <i class="fas fa-money-bill-wave fa-sm"></i> <i class="fas fa-rupee-sign fa-sm"></i>
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
                                                                $checkPaid = "readonly";
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
                                                                    <input id="paymentStuctureAmount<?= $noOfRows."_".$rows["customer_id"] ?>" name="paymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" value="<?= $customer_payment_structure_all->paymentStuctureAmount ?>" <?= $checkPaid ?> title="<?= ucwords($customer_payment_structure_all->paymentStuctureStatus) ?>"/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <input id="paymentStuctureRemark<?= $noOfRows."_".$rows["customer_id"] ?>" name="paymentStuctureRemark[]" type="text" class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" style="width:200px;" value="<?= $customer_payment_structure_all->paymentStuctureRemark ?>" <?= $checkPaid ?> title="<?= ucwords($customer_payment_structure_all->paymentStuctureStatus) ?>"/>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($noOfRows == 1):
                                                            ?>
                                                                    <button type="button" name="editAdd" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" id="editAdd" class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                            <?php 
                                                                else:
                                                            ?>
                                                                    <button type="button" name="remove" onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" id="<?= $noOfRows."_".$rows["customer_id"] ?>" class="btn btn-danger btn_remove">X</button>
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
                                                var addedPercentageOld = (0).toFixed(2);
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
                                                        var priceOfProperty = $("#propertyPriceDealForStructure").val();
                                                        var percentageOfOne = priceOfProperty/100;
                                                        addedPercentage = Number(addedPercentage) + Number($("#paymentStuctureCompletion"+i+"<?= "_".$rows["customer_id"] ?>").val());
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
                                                    $('#edit_dynamic_field').append('<tr id="row'+i+'<?= "_".$rows["customer_id"] ?>" class="dynamic-added" ><td><span class="p-3 mt-2">'+i+'.</span></td><td><div class="form-group mb-0"><div class="input-group" style="width:150px;"><input id="paymentStuctureCompletion'+i+'<?= "_".$rows["customer_id"] ?>" name="paymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();"/><div class="input-group-prepend"><button type="button" class="btn btn-danger">%</button></div></div></div></td><td><div class="form-group mb-0"><div class="input-group" style="width:200px;"><div class="input-group-prepend"><button type="button" class="btn btn-danger">&#8377;</button></div><input id="paymentStuctureAmount'+i+'<?= "_".$rows["customer_id"] ?>" name="paymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" readonly/></div></div></td><td><div class="form-group mb-0"><input id="paymentStuctureRemark'+i+'<?= "_".$rows["customer_id"] ?>" name="paymentStuctureRemark[]" type="text" class="form-control form-control-sm " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();" style="width:200px;"/></div></td><td><button type="button" name="remove" id="'+i+'<?= "_".$rows["customer_id"] ?>" class="btn btn-danger btn_remove " onclick="calculateAmountEdit();" onkeyup="calculateAmountEdit();">X</button></td></tr>');
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
                                                                    <input type="number" class="form-control form-control-sm " value="<?= $customer_payment_structure_all->paymentStuctureCompletion ?>" />
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
                                                                    <input type="number" class="form-control form-control-sm"  value="<?= $customer_payment_structure_all->paymentStuctureAmount ?>" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <input type="text" class="form-control form-control-sm" value="<?= $customer_payment_structure_all->paymentStuctureRemark ?>"  style="width:200px;"/>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="input-group" style="width:200px;">
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                    </div>
                                                                    <input type="number" class="form-control form-control-sm"  value="<?php printf("%.2f", $customer_payment_structure_all->paymentStucturePaid) ?>" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <input type="text" class="form-control form-control-sm" value="<?= $customer_payment_structure_all->paymentStucturePaidRemark ?>" style="width:200px;"/>
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
                                                                    <input type="number" class="form-control form-control-sm " value="<?php printf("%.2f", $totalPer) ?>" />
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
                                                                    <input type="number" class="form-control form-control-sm"  value="<?php printf("%.2f", $totalAmount) ?>" />
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
                                                                    <input type="number" class="form-control form-control-sm"  value="<?php printf("%.2f", $totalPaid) ?>" Percentage Of Amount/>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th></th>
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
                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantName">Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <select id="editfirstApplicantTitle" name="editfirstApplicantTitle" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option <?php if($customer_info->title == "Mr") echo "selected"; ?> value="Mr">Mr.</option> 
                                                            <option <?php if($customer_info->title == "Mrs") echo "selected"; ?> value="Mrs">Mrs.</option>  <option <?php if($customer_info->title == "Ms") echo "selected"; ?> value="Ms">Ms.</option>
                                                        </select>
                                                    </div>
                                                    <input id="editfirstApplicantName" name="editfirstApplicantName" type="text" class="form-control form-control-sm" value="<?= $customer_info->name ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantParentOf">S/D/W of</label>
                                                <input type="text" class="form-control form-control-sm" id="editfirstApplicantParentOf" name="editfirstApplicantParentOf" placeholder="S/D/W of" value="<?= $customer_info->parentName ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantPhoneNumber">Phone Number</label>
                                                <input type="number" class="form-control form-control-sm" id="editfirstApplicantPhoneNumber" name="editfirstApplicantPhoneNumber" placeholder="Phone Number" value="<?= $customer_info->phoneNumber ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantAlternatePhoneNumber">Alternate Phone Number</label>
                                                <input type="number" class="form-control form-control-sm" id="editfirstApplicantAlternatePhoneNumber" name="editfirstApplicantAlternatePhoneNumber" placeholder="Alternate Phone Number" value="<?= $customer_info->phoneNumberAlternate ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantAlternateFax">Fax</label>
                                                <input type="number" class="form-control form-control-sm" id="editfirstApplicantAlternateFax" name="editfirstApplicantAlternateFax" placeholder="Fax" value="<?= $customer_info->fax ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantEmailId">Email Id</label>
                                                <input type="email" class="form-control form-control-sm" id="editfirstApplicantEmailId" name="editfirstApplicantEmailId" placeholder="Email Id" value="<?= $customer_info->emailId ?>">
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantDateOfBirth">Date Of Birth</label>
                                                <input type="date" class="form-control form-control-sm" id="editfirstApplicantDateOfBirth" name="editfirstApplicantDateOfBirth" placeholder="Date Of Birth" value="<?= $customer_info->dob ?>">
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantAge">Age</label>
                                                <div class="input-group">
                                                    <input id="editfirstApplicantAge" name="editfirstApplicantAge" type="number" class="form-control form-control-sm" value="<?= $customer_info->age ?>" />
                                                    <div class="input-group-prepend">
                                                        <button type="button" id="editfirstApplicantCalculateAge" class="btn btn-danger">Calculate</button>
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
                                        // Edit First Applicant Find Age Section Start ------------------------------------------------------------------------------------------------------
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
                                        });
                                        // Edit First Applicant Find Age Section End --------------------------------------------------------------------------------------------------------
                                        </script>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantMaritalStatus">Marital Status</label>
                                                <select id="editfirstApplicantMaritalStatus" name="editfirstApplicantMaritalStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                <option <?php if($customer_info->maritalStatus == "Single") echo "selected"; ?> value="Single">Single</option> 
                                                <option <?php if($customer_info->maritalStatus == "Married") echo "selected"; ?> value="Married">Married</option> 
                                                </select>
                                            </div>
                                        </div> 
                                        <div id="editdivFirstApplicantDateOfAnniversary" class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="editfirstApplicantDateOfAnniversary">Date Of Anniversary</label>
                                                <input id="editfirstApplicantDateOfAnniversary" name="editfirstApplicantDateOfAnniversary" type="date" value="<?= $customer_info->dateOfAnniversary ?>" class="form-control form-control-sm"/>
                                            </div>
                                        </div>
                                        <div id="editdivFirstApplicantNoOfChild" class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="editfirstApplicantNoOfChild">Number Of Children</label>
                                                <input id="editfirstApplicantNoOfChild" name="editfirstApplicantNoOfChild" type="number" min="0" value="<?= $customer_info->noOfChild ?>" class="form-control form-control-sm"/>
                                            </div>
                                        </div>
                                        <script>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantReligion">Religion</label>
                                                <input type="text" class="form-control form-control-sm" id="editfirstApplicantReligion" name="editfirstApplicantReligion" placeholder="Religion" value="<?= $customer_info->religion ?>">
                                            </div>
                                        </div> 
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantCaste">Caste</label>
                                                <input type="text" class="form-control form-control-sm" id="editfirstApplicantCaste" name="editfirstApplicantCaste" placeholder="Caste" value="<?= $customer_info->caste ?>">
                                            </div>
                                        </div> 
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicantResidentialStatus">Residential Status</label>
                                                <select id="editfirstApplicantResidentialStatus" name="editfirstApplicantResidentialStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                <option <?php if($customer_info->residentialStatus == "Resident") echo "selected"; ?> value="Resident">Resident</option> 
                                                <option <?php if($customer_info->residentialStatus == "Non-Resident") echo "selected"; ?> value="Non-Resident">Non-Resident</option> 
                                                <option <?php if($customer_info->residentialStatus == "Foreign National of Indian Origin") echo "selected"; ?> value="Foreign National of Indian Origin">Foreign National of Indian Origin</option> 
                                                </select>
                                            </div>
                                        </div> 
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicanOccupation">Occupation</label>
                                                <input type="text" class="form-control form-control-sm" id="editfirstApplicanOccupation" name="editfirstApplicanOccupation" placeholder="Occupation" value="<?= $customer_info->occupation ?>">
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicanPanNumber">PAN Number</label>
                                                <input type="text" class="form-control form-control-sm" id="editfirstApplicanPanNumber" name="editfirstApplicanPanNumber" placeholder="PAN Number" value="<?= $customer_info->panNumber ?>">
                                            </div>
                                        </div> 
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirstApplicanAadharNumber">Aadhar Number</label>
                                                <input type="text" class="form-control form-control-sm" id="editfirstApplicanAadharNumber" name="editfirstApplicanAadharNumber" placeholder="Aadhar Number" value="<?= $customer_info->aadharNumber ?>">
                                            </div>
                                        </div> 
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editfirstApplicanPermanentAddress">Permanent Address</label>
                                                <textarea id="editfirstApplicanPermanentAddress" name="editfirstApplicanPermanentAddress" class="form-control form-control-sm"><?= $customer_info->permanentAddress ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editfirstApplicanCorrespondenceAddress">Correspondence Address</label>
                                                <textarea id="editfirstApplicanCorrespondenceAddress" name="editfirstApplicanCorrespondenceAddress" class="form-control form-control-sm"><?= $customer_info->correspondenceAddress ?></textarea>
                                            </div>
                                        </div>
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
            case "secondfetchEdit":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_second_applicant = json_decode($rows["customer_second_applicant"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantName">Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <select id="editsecondApplicantTitle" name="editsecondApplicantTitle" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option <?php if($customer_second_applicant->title == "Mr") echo "selected"; ?> value="Mr">Mr.</option> 
                                                            <option <?php if($customer_second_applicant->title == "Mrs") echo "selected"; ?> value="Mrs">Mrs.</option>  <option <?php if($customer_second_applicant->title == "Ms") echo "selected"; ?> value="Ms">Ms.</option>
                                                        </select>
                                                    </div>
                                                    <input id="editsecondApplicantName" name="editsecondApplicantName" type="text" class="form-control form-control-sm" value="<?= $customer_second_applicant->name ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantParentOf">S/D/W of</label>
                                                <input type="text" class="form-control form-control-sm" id="editsecondApplicantParentOf" name="editsecondApplicantParentOf" placeholder="S/D/W of" value="<?= $customer_second_applicant->parentName ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantPhoneNumber">Phone Number</label>
                                                <input type="number" class="form-control form-control-sm" id="editsecondApplicantPhoneNumber" name="editsecondApplicantPhoneNumber" placeholder="Phone Number" value="<?= $customer_second_applicant->phoneNumber ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantAlternatePhoneNumber">Alternate Phone Number</label>
                                                <input type="number" class="form-control form-control-sm" id="editsecondApplicantAlternatePhoneNumber" name="editsecondApplicantAlternatePhoneNumber" placeholder="Alternate Phone Number" value="<?= $customer_second_applicant->phoneNumberAlternate ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantAlternateFax">Fax</label>
                                                <input type="number" class="form-control form-control-sm" id="editsecondApplicantAlternateFax" name="editsecondApplicantAlternateFax" placeholder="Fax" value="<?= $customer_second_applicant->fax ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantEmailId">Email Id</label>
                                                <input type="email" class="form-control form-control-sm" id="editsecondApplicantEmailId" name="editsecondApplicantEmailId" placeholder="Email Id" value="<?= $customer_second_applicant->emailId ?>">
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantDateOfBirth">Date Of Birth</label>
                                                <input type="date" class="form-control form-control-sm" id="editsecondApplicantDateOfBirth" name="editsecondApplicantDateOfBirth" placeholder="Date Of Birth" value="<?= $customer_second_applicant->dob ?>">
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantAge">Age</label>
                                                <div class="input-group">
                                                    <input id="editsecondApplicantAge" name="editsecondApplicantAge" type="number" class="form-control form-control-sm" value="<?= $customer_second_applicant->age ?>" />
                                                    <div class="input-group-prepend">
                                                        <button type="button" id="editsecondApplicantCalculateAge" class="btn btn-danger">Calculate</button>
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
                                            var formData = {"action":"editfetchsecondApplicantCalculatedAge","dateOfBirth":$("#editsecondApplicantDateOfBirth").val()};
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantMaritalStatus">Marital Status</label>
                                                <select id="editsecondApplicantMaritalStatus" name="editsecondApplicantMaritalStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                <option <?php if($customer_second_applicant->maritalStatus == "Single") echo "selected"; ?> value="Single">Single</option> 
                                                <option <?php if($customer_second_applicant->maritalStatus == "Married") echo "selected"; ?> value="Married">Married</option> 
                                                </select>
                                            </div>
                                        </div> 
                                        <div id="editdivsecondApplicantDateOfAnniversary" class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="editsecondApplicantDateOfAnniversary">Date Of Anniversary</label>
                                                <input id="editsecondApplicantDateOfAnniversary" name="editsecondApplicantDateOfAnniversary" type="date" value="<?= $customer_second_applicant->dateOfAnniversary ?>" class="form-control form-control-sm"/>
                                            </div>
                                        </div>
                                        <div id="editdivsecondApplicantNoOfChild" class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="editsecondApplicantNoOfChild">Number Of Children</label>
                                                <input id="editsecondApplicantNoOfChild" name="editsecondApplicantNoOfChild" type="number" min="0" value="<?= $customer_second_applicant->noOfChild ?>" class="form-control form-control-sm"/>
                                            </div>
                                        </div>
                                        <script>
                                        $("#editsecondApplicantMaritalStatus").change(function () {
                                            if($("#editsecondApplicantMaritalStatus").val() == "Single"){
                                                $("#editdivsecondApplicantDateOfAnniversary").addClass("display-none");
                                                $("#editdivsecondApplicantNoOfChild").addClass("display-none");
                                            } else{
                                                $("#editdivsecondApplicantDateOfAnniversary").removeClass("display-none");
                                                $("#editdivsecondApplicantNoOfChild").removeClass("display-none");
                                            }
                                        });
                                       </script>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantReligion">Religion</label>
                                                <input type="text" class="form-control form-control-sm" id="editsecondApplicantReligion" name="editsecondApplicantReligion" placeholder="Religion" value="<?= $customer_second_applicant->religion ?>">
                                            </div>
                                        </div> 
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantCaste">Caste</label>
                                                <input type="text" class="form-control form-control-sm" id="editsecondApplicantCaste" name="editsecondApplicantCaste" placeholder="Caste" value="<?= $customer_second_applicant->caste ?>">
                                            </div>
                                        </div> 
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicantResidentialStatus">Residential Status</label>
                                                <select id="editsecondApplicantResidentialStatus" name="editsecondApplicantResidentialStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                <option <?php if($customer_second_applicant->residentialStatus == "Resident") echo "selected"; ?> value="Resident">Resident</option> 
                                                <option <?php if($customer_second_applicant->residentialStatus == "Non-Resident") echo "selected"; ?> value="Non-Resident">Non-Resident</option> 
                                                <option <?php if($customer_second_applicant->residentialStatus == "Foreign National of Indian Origin") echo "selected"; ?> value="Foreign National of Indian Origin">Foreign National of Indian Origin</option> 
                                                </select>
                                            </div>
                                        </div> 
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicanOccupation">Occupation</label>
                                                <input type="text" class="form-control form-control-sm" id="editsecondApplicanOccupation" name="editsecondApplicanOccupation" placeholder="Occupation" value="<?= $customer_second_applicant->occupation ?>">
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicanPanNumber">PAN Number</label>
                                                <input type="number" class="form-control form-control-sm" id="editsecondApplicanPanNumber" name="editsecondApplicanPanNumber" placeholder="PAN Number" value="<?= $customer_second_applicant->panNumber ?>">
                                            </div>
                                        </div> 
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editsecondApplicanAadharNumber">Aadhar Number</label>
                                                <input type="number" class="form-control form-control-sm" id="editsecondApplicanAadharNumber" name="editsecondApplicanAadharNumber" placeholder="Aadhar Number" value="<?= $customer_second_applicant->aadharNumber ?>">
                                            </div>
                                        </div> 
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editsecondApplicanPermanentAddress">Permanent Address</label>
                                                <textarea id="editsecondApplicanPermanentAddress" name="editsecondApplicanPermanentAddress" class="form-control form-control-sm"><?= $customer_second_applicant->permanentAddress ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editsecondApplicanCorrespondenceAddress">Correspondence Address</label>
                                                <textarea id="editsecondApplicanCorrespondenceAddress" name="editsecondApplicanCorrespondenceAddress" class="form-control form-control-sm"><?= $customer_second_applicant->correspondenceAddress ?></textarea>
                                            </div>
                                        </div>
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
            // ------------ Fetch Second Applicant Edit Section End ------------------
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
                        <input type="hidden" id="tableName" name="tableName" value="tbl_customer" />
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
            case "fetchInnerPropertyWithProjectId":
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
                                ?>
                                <table class="table table-bordered table-striped dataTable" id="edit_dynamic_field">
                                    <thead>
                                        <tr>
                                            <th data-field="S. No." data-sortable="true">S.No.</th>
                                            <th data-field="Phase" data-sortable="true">Phase</th>
                                            <th data-field="Block" data-sortable="true">Block</th>
                                            <th data-field="Building" data-sortable="true">Building</th>
                                            <th data-field="Property Type" data-sortable="true">Property Type</th>
                                            <th data-field="Accommodation Type" data-sortable="true">Accommodation Type</th>
                                            <th data-field="Total Sq. Feet" data-sortable="true">Total Area Sq.ft<br/>(S.B. Area)</th>
                                            <th data-field="Price / Sq. Feet" data-sortable="true">Price / Sq.ft</th>
                                            <th data-field="Total Price" data-sortable="true">Total Price</th>
                                            <th data-field="Set Price" data-sortable="true">Carpet Area Sq.ft</th>
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
                                            foreach($project_info->properties as $properties):
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="p-3 mt-2"><?= $noOfProperties ?>.</span>
                                            </td>
                                            <td>
                                                <select id="phase<?= $noOfProperties ?>" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:100px;" disabled>
                                                    <?php 
                                                        $databaseObj->select("tbl_phase");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $phase_in):
                                                                $phase_info = json_decode($phase_in["phase_info"]);
                                                                ?>
                                                                    <option value="<?= $phase_in["phase_id"] ?>" <?php if($properties->phase == $phase_in["phase_id"]) echo "selected" ?>><?= $phase_info->phase ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="block<?= $noOfProperties ?>" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:100px;" disabled>
                                                    <?php 
                                                        $databaseObj->select("tbl_block");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $block_in):
                                                                $block_info = json_decode($block_in["block_info"]);
                                                                ?>
                                                                    <option value="<?= $block_in["block_id"] ?>" <?php if($properties->block == $block_in["block_id"]) echo "selected" ?>><?= $block_info->block ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="building<?= $noOfProperties ?>" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:100px;" disabled>
                                                    <?php 
                                                        $databaseObj->select("tbl_building");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $building_in):
                                                                $building_info = json_decode($building_in["building_info"]);
                                                                ?>
                                                                    <option value="<?= $building_in["building_id"] ?>" <?php if($properties->building == $building_in["building_id"]) echo "selected" ?>><?= $building_info->building ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="propertyType<?= $noOfProperties ?>" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;" disabled>
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
                                                <select id="accommodationType<?= $noOfProperties ?>" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;" disabled>
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
                                                <input id="squareFeet<?= $noOfProperties ?>" type="number" min="0" class="form-control form-control-sm" style="width:150px;" value="<?= $properties->squareFeet ?>" disabled/>
                                            </td>

                                            <td>
                                                <input id="pricePerSquare<?= $noOfProperties ?>" type="number" min="0.00" step=any class="form-control form-control-sm"  style="width:150px;" value="<?= $properties->pricePerSquare ?>" disabled/>
                                            </td>
                                            <td>
                                                <input id="priceTotal<?= $noOfProperties ?>" type="number" min="0.00" step=any class="form-control form-control-sm" style="width:150px;" value="<?= $properties->priceTotal ?>" disabled />
                                            </td>
                                            <td>
                                                <input id="carpetArea<?= $noOfProperties ?>" type="number" min="0" class="form-control form-control-sm" style="width:150px;" value="<?= $properties->carpetArea ?>" disabled />
                                            </td>

                                            <td>
                                                <input id="availablility<?= $noOfProperties ?>" type="number" min="0" class="form-control form-control-sm" style="width:100px;" value="<?= $properties->availablility ?>" disabled />
                                            </td>
                                            <td>
                                                <input id="StartingDate<?= $noOfProperties ?>" type="date" class="form-control form-control-sm" style="width:180px;" value="<?= $properties->StartingDate ?>" disabled />
                                            </td>
                                            <td>
                                                <input id="ExpectedEndingDate<?= $noOfProperties ?>" type="date" class="form-control form-control-sm" style="width:180px;" value="<?= $properties->ExpectedEndingDate ?>" disabled />
                                            </td>
                                            <td>
                                                <input id="EndingDate<?= $noOfProperties ?>" type="date" class="form-control form-control-sm" style="width:180px;" value="<?= $properties->EndingDate ?>" disabled />
                                                <input id="propertiesAll<?= $noOfProperties ?>" type="hidden" class="form-control form-control-sm" style="width:180px;" value='{"phase":"<?= $properties->phase ?>","block":"<?= $properties->block ?>","building":"<?= $properties->building ?>","propertyType":"<?= $properties->propertyType ?>","accommodationType":"<?= $properties->accommodationType ?>","squareFeet":"<?= $properties->squareFeet ?>","pricePerSquare":"<?= $properties->pricePerSquare ?>","priceTotal":"<?= $properties->priceTotal ?>","carpetArea":"<?= $properties->carpetArea ?>","availablility":"<?= $properties->availablility ?>","StartingDate":"<?= $properties->StartingDate ?>","ExpectedEndingDate":"<?= $properties->ExpectedEndingDate ?>","EndingDate":"<?= $properties->EndingDate ?>"}' disabled />
                                            </td>
                                            <td>
                                                <button type="button" id="select<?= $noOfProperties ?>" class="btn btn-info" onclick="showAllPropertyDetails('<?= $noOfProperties ?>')">Select</button>
                                            </td>

                                        </tr>
                                        <?php 
                                                $noOfProperties++;
                                            endforeach;
                                        ?>
                                    </tbody>
                                </table>
                                <script>
                                    // Show All Property Details Section Start -----------------------------------------------------------------------
                                    function showAllPropertyDetails(idOfProject){
                                        $("#phase").val($("#phase"+idOfProject).find(":selected").text());
                                        $("#block").val($("#block"+idOfProject).find(":selected").text());
                                        $("#building").val($("#building"+idOfProject).find(":selected").text());
                                        $("#propertyType").val($("#propertyType"+idOfProject).find(":selected").text());
                                        $("#accommodationType").val($("#accommodationType"+idOfProject).find(":selected").text());
                                        $("#squareFeet").val($("#squareFeet"+idOfProject).val());
                                        $("#pricePerSquare").val($("#pricePerSquare"+idOfProject).val());
                                        $("#propertyPrice").val($("#priceTotal"+idOfProject).val());
                                        $("#properties").val($("#propertiesAll"+idOfProject).val());
                                    }
                                    // Show All Property Details Section End -------------------------------------------------------------------------
                                </script>
                                <?php
                            endforeach;
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
            // ------------------------------------------------------------------------
            // ------------ Fetch First Applicant Calculated Age Section End ----------
            // ------------ Edit Fetch First Applicant Calculated Age Section Start --------
            // ------------------------------------------------------------------------
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