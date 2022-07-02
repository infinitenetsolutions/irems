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
    $employeeStoreDir = "../../irems/assets/admin/employee/";

    $manageCompanyDir = "assets/admin/manage-company/";
    $employeeDir = "../../irems/assets/admin/employee/";
    
    if(isset($_POST["action"])):
        // ----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Fetch Data Section Start ---------
            // -----------------------------------------------
        case "fetchData":
                        ?>
        <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/manage-employees.php">
            <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_employee">
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
                <th>Full Name</th>
                <th>Employee ID</th>
                <th>Email</th>
                <th>Department</th>
                <th>Date Of Hire</th>
                <th>Status</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                                        $databaseObj->select("tbl_manage_employee");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $databaseObj->order_by("`manage_employee_id` DESC");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                                $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                                $manage_employee_log = json_decode($rows["manage_employee_log"]);
                                    ?>
            <tr>
                <td class="text-center">
                    <div class="icheck-navy d-inline">
                        <input type="checkbox" id="checkbox-<?= $rows["manage_employee_id"] ?>" name="checkbox-select[]" value="<?= $rows["manage_employee_id"] ?>" class="check-table">
                        <label for="checkbox-<?= $rows["manage_employee_id"] ?>">
                        </label>
                    </div>
                </td>
                <td><?= $sno ?>.</td>
                <td><?= $manage_employee_info->firstName ?> <?= $manage_employee_info->lastName ?></td>
                <td><?= $manage_employee_info->employeeId ?></td>
                <td><?= $manage_employee_info->email ?></td>
                <?php
                                                      $databaseObj->select("tbl_manage_department");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_department_id` = '".$manage_employee_info->department."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        foreach($getData as $rows_deptt):
                                                            $manage_department_info = json_decode($rows_deptt["manage_department_info"]);
                                                        endforeach;
                                                    endif;
                                                     ?>

                <td><?= $manage_department_info->departmentName?></td>
                <td><?= $manage_employee_info->date_of_joining ?></td>
                <td><?= $manage_employee_info->type ?></td>
                <td>
                    <?php
        if($manage_employee_info->img == "default"):
        ?>
                    <a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="" class="table-avatar"></a>
                    <?php
        else:
        ?>
                    <a href="<?= $employeeDir.$manage_employee_info->img ?>" target="_blank"><img src="<?= $employeeDir.$manage_employee_info->img ?>" alt="" class="table-avatar"></a>
                    <?php 
        endif;
        ?>
                </td>
                <td class="text-center">
                    <button type="button" id="information-button-<?= $rows["manage_employee_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">
                        <i class="fa fa-scroll fa-sm"></i>
                    </button>
                    <button type="button" id="see-button-<?= $rows["manage_employee_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See">
                        <i class="fa fa-eye fa-sm"></i>
                    </button>
                    <button type="button" id="edit-button-<?= $rows["manage_employee_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                        <i class="fa fa-edit fa-sm"></i>
                    </button>
                    <button type="button" id="delete-button-<?= $rows["manage_employee_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                        <i class="fa fa-trash fa-sm"></i>
                    </button>
                </td>
            </tr>
            <script>
                // Information Section Start ---------------------------------------------------------------
                $("#information-button-<?= $rows["manage_employee_id"] ?>").click(function() {
                    $("#information-modal").modal('show');
                    $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                    var formData = {
                        "action": "fetchInformation",
                        "id": "<?= $rows["manage_employee_id"] ?>"
                    };
                    $.ajax({
                        url: 'application/view/admin/manage-employees.php',
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            $('#information-loading').fadeOut(500, function() {
                                $(this).remove();
                                $('#information-section').html(data);
                            });
                        }
                    });
                });
                // Information Section End -----------------------------------------------------------------
                // See Section Start ---------------------------------------------------------------
                $("#see-button-<?= $rows["manage_employee_id"] ?>").click(function() {
                    $("#see-modal").modal('show');
                    $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                    var formData = {
                        "action": "fetchSee",
                        "id": "<?= $rows["manage_employee_id"] ?>"
                    };
                    $.ajax({
                        url: 'application/view/admin/manage-employees.php',
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            $('#see-loading').fadeOut(500, function() {
                                $(this).remove();
                                $('#see-section').html(data);
                            });
                        }
                    });
                });
                // See Section End -----------------------------------------------------------------
                // Edit Section Start ---------------------------------------------------------------
                $("#edit-button-<?= $rows["manage_employee_id"] ?>").click(function() {
                    $("#edit-modal").modal('show');
                    $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                    var formData = {
                        "action": "fetchEdit",
                        "id": "<?= $rows["manage_employee_id"] ?>"
                    };
                    $.ajax({
                        url: 'application/view/admin/manage-employees.php',
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            $('#edit-loading').fadeOut(500, function() {
                                $(this).remove();
                                $('#edit-section').html(data);
                            });
                        }
                    });
                });
                // Edit Section End -----------------------------------------------------------------
                // Delete Section Start ---------------------------------------------------------------
                $("#delete-button-<?= $rows["manage_employee_id"] ?>").click(function() {
                    $("#delete-modal").modal('show');
                    $('#deleteButton').prop('disabled', true);
                    $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                    var formData = {
                        "action": "fetchDelete",
                        "id": "<?= $rows["manage_employee_id"] ?>"
                    };
                    $.ajax({
                        url: 'application/view/admin/manage-employees.php',
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            $('#delete-loading').fadeOut(500, function() {
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
                        $databaseObj->select("tbl_manage_employee");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`manage_employee_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_employee_log = json_decode($rows["manage_employee_log"]);
                                ?>
<div class="row">
    <?php
                                            $sno = 1;
                                            foreach($manage_employee_log as $manage_employee_log_info):
                                            ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex p-0">
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($manage_employee_log_info->action) ?> By</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane" id="tab_4_<?= $sno ?>">
                        <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($manage_employee_log_info->action) ?> By -
                            <?php
                                                                        if($manage_employee_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$manage_employee_log_info->by."'");
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
                        <?= date("l, M d, Y", strtotime($manage_employee_log_info->date)) ?> At <?= $manage_employee_log_info->at ?>
                    </div>
                    <div class="tab-pane" id="tab_2_<?= $sno ?>">
                        <h5><i class="icon fas fa-server"></i> IP - </h5>
                        <?= $manage_employee_log_info->ip ?>
                    </div>
                    <div class="tab-pane" id="tab_3_<?= $sno ?>">
                        <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                        <?php
                        $latLangArray = explode(",", $manage_employee_log_info->location);
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
                        $databaseObj->select("tbl_manage_employee");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                ?>
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Image</h5>


                                                        <?php
                                                            if($manage_employee_info->img == "default"): ?>
                                                                                                    
                                                        <a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="" class="table-see"></a>
                                                        <?php
                                                            else:
                                                                ?>
                                                        <a href="<?= $manageEmployeeDir.$manage_employee_info->img ?>" target="_blank"><img src="<?= $manageEmployeeDir.$manage_employee_info->img ?>" alt="" class="table-see"></a>
                                                        <?php 
                                                                                                    endif;
                                                                                                ?>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Employee Type</h5>
                                                        <?= $manage_employee_info->empType ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Project Name</h5>
                                                        <?= $manage_employee_info->project ?>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Property</h5>
                                                        <?= $manage_employee_info->property ?>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">First Name</h5>
                                                        <?= $manage_employee_info->firstName ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Last Name</h5>
                                                        <?= $manage_employee_info->lastName ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Employee ID</h5>
                                                        <?= $manage_employee_info->employeeId ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Mobile</h5>
                                                        <?= $manage_employee_info->mobile ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Date Of Birth</h5>
                                                        <?= $manage_employee_info->dob ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Email</h5>
                                                        <?= $manage_employee_info->email ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Gender</h5>
                                                        <?= $manage_employee_info->gender ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Department</h5>
                                                        <?= $manage_employee_info->department ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Date of Joining</h5>
                                                            <?= $manage_employee_info->date_of_joining ?>
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Source of Hire</h5>
                                                            <?= $manage_employee_info->source_of_hire ?>
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Reporting To</h5>
                                                            <?= $manage_employee_info->reporting_to ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Employee Status</h5>
                                                            <?= $manage_employee_info->empStatus ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Work Phone</h5>
                                                            <?= $manage_employee_info->workPhone ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Employee Type</h5>
                                                            <?= $manage_employee_info->type ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Address 1</h5>
                                                            <?= $manage_employee_info->address1 ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Address 2</h5>
                                                            <?= $manage_employee_info->address2 ?>
                                                    </div>
                                                </div>



                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">City</h5>
                                                            <?= $manage_employee_info->city ?>
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Country</h5>
                                                            <?= $manage_employee_info->country ?>
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">State</h5>
                                                            <?= $manage_employee_info->state ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Country</h5>
                                                            <?= $manage_employee_info->country ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">State</h5>
                                                            <?= $manage_employee_info->state ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Nationality</h5>
                                                            <?= $manage_employee_info->nationality ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Postal Code</h5>
                                                            <?= $manage_employee_info->postalCode ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Marital Status</h5>
                                                            <?= $manage_employee_info->MaritalStatus ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Basic Salary</h5>
                                                            <?= $manage_employee_info->basicSalary ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Basic Salary</h5>
                                                            <?= $manage_employee_info->basicSalary ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">HRA</h5>
                                                            <?= $manage_employee_info->hra ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Provident Fund</h5>
                                                            <?= $manage_employee_info->pf ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Total Salary</h5>
                                                            <?= $manage_employee_info->totalSalary ?>
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Account Holder Name</h5>
                                                            <?= $manage_employee_info->account_holder_name ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Bank Name</h5>
                                                            <?= $manage_employee_info->bankName ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Account No</h5>
                                                            <?= $manage_employee_info->acc_no ?>
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="callout callout-danger">
                                                        <h5 class="text-bold">Branch</h5>
                                                            <?= $manage_employee_info->branch ?>
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
                        $databaseObj->select("tbl_manage_employee");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                ?>
                            <div class="row">
                                <div class="col-md-3">
                                            <div class="form-group form-group-sm">
                                                <label for="editDepartment">Department</label>
                                                <select class="form-control form-control-sm " data-dropdown-css-class="select2-navy" id="editDepartment" name="editDepartment">
                                                   
                                                            <option disabled selected>Select</option>
                                                                <?php 
                                                                    $databaseObj->select("tbl_manage_department");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                        $sno = 1;
                                                                        foreach($getData as $rows):
                                                                            $manage_department_info = json_decode($rows["manage_department_info"]);
                                                                            ?>
                                                                                <option <?php if($manage_employee_info->department == $rows["manage_department_id"]) echo "selected" ?> value="<?= $rows["manage_department_id"] ?>"><?= $manage_department_info->departmentName ?></option>
                                                                            <?php
                                                                        endforeach;
                                                                    endif;
                                                                ?>
                                                        </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-sm">
                                                <label for="editDesignation">Designation</label>
                                                <select id="editDesignation" name="editDesignation" class="form-control form-control-sm " data-dropdown-css-class="select2-navy" readonly>
                                                    <option disabled selected>Select</option>
                                                    <?php 
                                                                    $databaseObj->select("tbl_manage_designation");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                        $sno = 1;
                                                                        foreach($getData as $rows):
                                                                            $manage_designation_info = json_decode($rows["manage_designation_info"]);
                                                                            ?>
                                                  <option <?php if($manage_employee_info->designation == $rows["manage_designation_id"]) echo "selected" ?> value="<?= $rows["manage_designation_id"] ?>"><?= $manage_designation_info->designationName ?></option>
                                                  <?php
                                                                        endforeach;
                                                                    endif;
                                                                ?>

                                                
                                                </select>       
                                            </div>
                                        </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editEmpType">Employee Type</label>
                                        <select class="form-control form-control-sm " data-dropdown-css-class="select2-navy" name="editEmpType" id="editEmpType">
                                            <option value="">Select Employee Type</option>
                                            <option value="Vendor Employee" <?php if($manage_employee_info->empType == "Vendor Employee") echo "selected" ?>>Vendor Employee</option>
                                            <option value="On Payroll" <?php if($manage_employee_info->empType == "On Payroll") echo "selected" ?>>On Payroll</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                            
                                            <div class="form-group form-group-sm">
                                                <label for="editProject">Project Name</label>
                                                <select id="editProject" name="editProject" class="form-control form-control-sm " data-dropdown-css-class="select2-navy">
                                                 <option disabled selected>Select</option>
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
                                                  
                                                    <!-- <option value="<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?></option> -->
                                                    <option <?php if($manage_employee_info->project == $rows["projects_id"]) echo "selected" ?> value="<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?></option>
                                                    <?php
                                                    endforeach;
                                                    endif;
                                                ?>
                                                </select>
                                            </div>
                                        </div>



                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="empType">Property</label>
                                                             <select id="property" name="property" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                        <input type="text" class="form-control" id="property" name="property" value="<?= $manage_employee_info->property ?>" autocomplete="off">


                                                           </select>-->
                                   <!--  </div>
                                </div> -->
 
                                <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Personal Details</h3>
                                    </div>

                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editFirstName">First Name</label>
                                        <input type="text" class="form-control form-control-sm " id="editFirstName" name="editFirstName" value="<?= $manage_employee_info->firstName ?>" autocomplete="off">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editLastName">Last Name</label>
                                        <input type="text" class="form-control form-control-sm " id="editLastName" name="editLastName" value="<?= $manage_employee_info->lastName ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editEmployeeId">Employee ID</label>
                                        <input type="text" class="form-control form-control-sm " id="editEmployeeId" name="editEmployeeId" value="<?= $manage_employee_info->employeeId ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editMobile">Mobile</label>
                                        <input type="text" class="form-control form-control-sm " id="editMobile" name="editMobile" value="<?= $manage_employee_info->mobile ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editDob">Date Of Birth</label>
                                        <input type="date" class="form-control form-control-sm " id="editDob" name="editDob" value="<?= $manage_employee_info->dob ?>">
                                        <!--                                                <small class="text-red">Define this date after the completion of project</small>-->
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editEmail">Email</label>
                                        <input type="text" class="form-control form-control-sm " id="editEmail" name="editEmail" value="<?= $manage_employee_info->email ?>">
                                        <!--                                                <small class="text-red">Define this date after the completion of project</small>-->
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editGender">Gender</label>
                                        <select class="form-control form-control-sm " data-dropdown-css-class="select2-navy" id="editGender" name="editGender">
                                            <option value="">Select Gender</option>
                                            <option value="Male" <?php if($manage_employee_info->gender == "Male") echo "selected" ?>>Male</option>
                                            <option value="Female" <?php if($manage_employee_info->gender == "Female") echo "selected" ?>>Female</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editMaritalStatus">Marital Status</label>
                                        <select class="form-control form-control-sm " data-dropdown-css-class="select2-navy" id="editMaritalStatus" name="editMaritalStatus">
                                            <option value="">Select Status</option>
                                            <option value="Single" <?php if($manage_employee_info->maritalStatus == "Single") echo "selected" ?>>Single</option>
                                            <option value="Married" <?php if($manage_employee_info->maritalStatus == "Married") echo "selected" ?>>Married</option>

                                        </select>
                                    </div>
                                </div>
                                <div id="editAnniversaryDiv" class="col-md-4 display-none">
                                                    <div class="form-group form-group-sm">
                                                        <label for="editAnniversary">Date Of Anniversary</label>
                                                        <input id="editAnniversary" name="editAnniversary" type="date" class="form-control form-control-sm" value="<?= $manage_employee_info->Anniversary ?>"/>
                                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Work Details</h3>
                                    </div>
                                </div>



                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <input type="text" class="form-control" id="department" name="department" value="<?= $manage_employee_info->department ?>">
                                    </div>
                                </div> -->


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editDate_of_joining">Date of Joining</label>
                                        <input type="date" class="form-control form-control-sm "  id="editDate_of_joining" name="editDate_of_joining" value="<?= $manage_employee_info->date_of_joining ?>">
                                        <!--                                                <small class="text-red">Define this date after the completion of project</small>-->
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editSource_of_hire">Source of Hire</label>
                                        <input type="text" class="form-control form-control-sm "  id="editSource_of_hire" name="editSource_of_hire" value="<?= $manage_employee_info->source_of_hire ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editReporting_to">Reporting To</label>
                                        <input type="text" class="form-control form-control-sm "  id="editReporting_to" name="editReporting_to" value="<?= $manage_employee_info->reporting_to ?>">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editEmpStatus">Employee Status</label>
                                        <select class="form-control form-control-sm " data-dropdown-css-class="select2-navy" name="editEmpStatus" id="editEmpStatus">
                                            <option value="">Select Status</option>
                                            <option value="Active" <?php if($manage_employee_info->empStatus == "Active") echo "selected" ?>>Active</option>
                                            <option value="Inactive" <?php if($manage_employee_info->empStatus == "Inactive") echo "selected" ?>>Inactive</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editWorkPhone">Work Phone</label>
                                        <input type="text" class="form-control form-control-sm "  id="editWorkPhone" name="editWorkPhone" value="<?= $manage_employee_info->workPhone ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editType">Employee Type</label>
                                        <select class="form-control form-control-sm " data-dropdown-css-class="select2-navy" name="editType">
                                            <option value="">Select Employee Type</option>
                                            <option value="Full Time" <?php if($manage_employee_info->type == "Full Time") echo "selected" ?>>Full Time</option>
                                            <option value="Part Time" <?php if($manage_employee_info->type == "Part Time") echo "selected" ?>>Part Time</option>

                                        </select>
                                    </div>
                                </div>




                                <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Contact Details</h3>
                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editAddress1">Address 1</label>
                                        <input type="text" class="form-control form-control-sm " id="editAddress1" name="editAddress1" value="<?= $manage_employee_info->address1 ?>">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editAddress2">Address 2</label>
                                        <input type="text" class="form-control form-control-sm " id="editAddress2" name="editAddress2" value="<?= $manage_employee_info->address2 ?>">
                                        <!--                                                <small class="text-red">Define this date after the completion of project</small>-->
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editCity">City</label>
                                        <input type="text" class="form-control form-control-sm " id="editCity" name="editCity" value="<?= $manage_employee_info->city ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editCountry">Country</label>
                                        <input type="text" class="form-control form-control-sm " id="editCountry" name="editCountry" value="<?= $manage_employee_info->country ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editState">State</label>
                                        <input type="text" class="form-control form-control-sm " id="editState" name="editState" value="<?= $manage_employee_info->state ?>">
                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editNationality">Nationality</label>
                                        <input type="text" class="form-control form-control-sm " id="editNationality" name="editNationality" value="<?= $manage_employee_info->nationality ?>">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editPostalCode">Postal Code</label>
                                        <input type="text" class="form-control form-control-sm " id="editPostalCode" name="editPostalCode" value="<?= $manage_employee_info->postalCode ?>">
                                    </div>
                                </div>



                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="maritalStatus">Marital Status</label>
                                        <select class="form-control" name="maritalStatus">
                                            <option value="">Select Status</option>
                                            <option value="Single" <?php if($manage_employee_info->maritalStatus == "Single") echo "selected" ?>>Single</option>
                                            <option value="Married" <?php if($manage_employee_info->maritalStatus == "Married") echo "selected" ?>>Married</option>

                                        </select>
                                    </div>
                                </div> -->


                                <!-- <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Financial Details</h3>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editBasicSalary">Basic Salary</label>
                                        <input type="text" class="form-control form-control-sm " id="editBasicSalary" name="editBasicSalary" onkeyup="cal1()" value="<?= $manage_employee_info->basicSalary ?>">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editHRA">HRA</label>
                                        <input type="text" class="form-control form-control-sm " id="editHRA" name="editHRA" onkeyup="cal1()" value="<?= $manage_employee_info->hra ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editPf">Provident Fund</label>
                                        <input type="text" class="form-control form-control-sm " id="editPf" name="editPf" onkeyup="cal1()" value="<?= $manage_employee_info->pf ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editTotalSalary">Total Salary</label>
                                        <input type="text" class="form-control form-control-sm " id="editTotalSalary" name="editTotalSalary" value="<?= $manage_employee_info->totalSalary ?>" onkeyup="cal1()" readonly/>
                                    </div>
                                </div> -->

                                <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Salaries</h3>
                                    </div> 
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>Basic Salary</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="basicSalary" value="<?= intval($manage_employee_info->basicSalary) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>HRA</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="hra" value="<?= intval($manage_employee_info->hra) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>DA</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="da" value="<?= intval($manage_employee_info->da) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>CA</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="ca" value="<?= intval($manage_employee_info->ca) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>LTA</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="lta" value="<?= intval($manage_employee_info->lta) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>SA</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="sa" value="<?= intval($manage_employee_info->sa) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>MA</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="ma" value="<?= intval($manage_employee_info->ma) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>OT</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="ot" value="<?= intval($manage_employee_info->ot) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>PB</label>
                                        <input type="number" class="form-control form-control-sm editSalary" name="pb" value="<?= intval($manage_employee_info->pb) ?>" />
                                    </div>
                                </div>




                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>Total Salary</label>
                                        <input type="number" class="form-control form-control-sm" name="totalSalary" id="editTotalSalary" value="<?= intval($manage_employee_info->totalSalary) ?>" readonly />
                                    </div>
                                </div>





                                <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Deductions</h3>
                                    </div> 
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>EPF (Provident Fund)</label>
                                        <input type="number" class="form-control form-control-sm editDeduction" name="epf" value="<?= intval($manage_employee_info->epf) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>ESI</label>
                                        <input type="number" class="form-control form-control-sm editDeduction" name="esi" value="<?= intval($manage_employee_info->esi) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>Loan</label>
                                        <input type="number" class="form-control form-control-sm editDeduction" name="loan" value="<?= intval($manage_employee_info->loan) ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">     
                                    <div class="form-group">
                                        <label>Total Deduction</label>
                                        <input type="number" class="form-control form-control-sm" name="totalDeduction" id="editTotalDeduction" value="<?= intval($manage_employee_info->totalDeduction) ?>" readonly />
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Totals</h3>
                                    </div> 
                                </div>
                                <div class="col-md-6">     
                                    <div class="form-group">
                                        <label>Gross Salary</label>
                                        <input type="number" class="form-control form-control-sm" name="grossSalary" id="editGrossSalary" value="<?= intval($manage_employee_info->grossSalary) ?>" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">     
                                    <div class="form-group">
                                        <label>Net Salary</label>
                                        <input type="number" class="form-control form-control-sm" name="netSalary" id="editNetSalary" value="<?= intval($manage_employee_info->netSalary) ?>" readonly />
                                    </div>
                                </div>

                                <script>
                                    $(document).on("click change keyup blur", ".editSalary", function(){
                                        editSalary();
                                        editTotals($(this).attr("id"));
                                    });
                                    $(document).on("click change keyup blur", ".editDeduction", function(){
                                        editDeduction();
                                        editTotals($(this).attr("id"));
                                    });
                                    editSalary = function(){
                                        var sumSal = 0.00;
                                        $(".editSalary").each(function(){
                                            sumSal += Number($(this).val());
                                        });
                                        $("#editTotalSalary").val(sumSal);
                                    }
                                    editDeduction = function(){
                                        var sumDed = 0.00;
                                        $(".editDeduction").each(function(){
                                            sumDed += Number($(this).val());
                                        });
                                        $("#editTotalDeduction").val(sumDed);
                                    }
                                    editTotals = function(currentId){
                                        if((Number($("#editTotalSalary").val()) - Number($("#editTotalDeduction").val())) < 0 || Number($("#editTotalSalary").val()) < 0 || Number($("#editTotalDeduction").val()) < 0){
                                            $("#"+ currentId).val(0);
                                            editSalary();
                                            editDeduction();
                                        }
                                        $("#editGrossSalary").val(Number($("#editTotalSalary").val()));
                                        $("#editNetSalary").val(Number($("#editTotalSalary").val()) - Number($("#editTotalDeduction").val()));
                                        if(Number($("#editNetSalary").val()) < 0){
                                            $(".editDeduction").each(function(){
                                                $(this).val(0);
                                            });
                                            editSalary();
                                            editDeduction();
                                            $("#editNetSalary").val(Number($("#editTotalSalary").val()) - Number($("#editTotalDeduction").val()));
                                        }
                                    }
                                </script>



                                <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Bank Account Details</h3>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editAccount_holder_name">Account Holder Name</label>
                                        <input type="text" class="form-control form-control-sm " id="editAccount_holder_name" name="editAccount_holder_name" value="<?= $manage_employee_info->account_holder_name ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editBankName">Bank Name</label>
                                        <input type="text" class="form-control form-control-sm " id="editBankName" name="editBankName" value="<?= $manage_employee_info->bankName ?>">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editAcc_no">Account No</label>
                                        <input type="text" class="form-control form-control-sm " id="editAcc_no" name="editAcc_no" value="<?= $manage_employee_info->acc_no ?>">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editBranch">Branch</label>
                                        <input type="text" class="form-control form-control-sm" id="editBranch" name="editBranch" value="<?= $manage_employee_info->branch ?>">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Image</h3>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                            <label for="editImg">Image Upload</label>


                                            <?php
                                            if($manage_employee_info->img == "default"):
                                                                                            ?>
                                            <a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="" class="table-avatar"></a>
                                            <?php
                                                                                                else:
                                                                                            ?>
                                            <a href="<?= $employeeDir.$manage_employee_info->img ?>" target="_blank"><img src="<?= $employeeDir.$manage_employee_info->img ?>" alt="" class="table-avatar"></a>
                                            <?php 
                                                                                                endif;
                                                                                            ?>
                                            <input type="file" class="form-control form-control-sm" id="editImg" name="editImg" accept="image/*">
                                    </div>
                                </div>
                               <!--  <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editAadharimage">AAdhar Card Image  Upload</label>


                                        <?php
                                        if($manage_employee_info->aadharimage == "default"):
                                                                                        ?>
                                        <a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="" class="table-avatar"></a>
                                        <?php
                                                                                            else:
                                                                                        ?>
                                        <a href="<?= $employeeDir.$manage_employee_info->aadharimage ?>" target="_blank"><img src="<?= $employeeDir.$manage_employee_info->aadharimage ?>" alt="" class="table-avatar"></a>
                                        <?php 
                                                                                            endif;
                                                                                        ?>
                                        <input type="file" class="form-control" id="editAadharimage" name="editAadharimage" accept="image/*">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                        <label for="editPanimage">Pan Card  Upload</label>


                                        <?php
                                        if($manage_employee_info->panimage == "default"):
                                                                                        ?>
                                        <a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="" class="table-avatar"></a>
                                        <?php
                                                                                            else:
                                                                                        ?>
                                        <a href="<?= $employeeDir.$manage_employee_info->panimage ?>" target="_blank"><img src="<?= $employeeDir.$manage_employee_info->panimage ?>" alt="" class="table-avatar"></a>
                                        <?php 
                                                                                            endif;
                                                                                        ?>
                                        <input type="file" class="form-control" id="editPanimage" name="editPanimage" accept="image/*">
                                    </div>
                               
                                    <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                </div>
                                <div class="col-md-3">
                                        <div class="form-group form-group-sm">
                                            <label for="editAddressProofimage">Address Proof Upload</label>


                                            <?php
                                            if($manage_employee_info->addressProofimage == "default"):
                                                                                            ?>
                                            <a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="" class="table-avatar"></a>
                                            <?php
                                                                                                else:
                                                                                            ?>
                                            <a href="<?= $employeeDir.$manage_employee_info->addressProofimage ?>" target="_blank"><img src="<?= $employeeDir.$manage_employee_info->addressProofimage ?>" alt="" class="table-avatar"></a>
                                            <?php 
                                                                                                endif;
                                                                                            ?>
                                            <input type="file" class="form-control" id="editAddressProofimage" name="editAddressProofimage" accept="image/*">
                                        </div>
                                     -->
                                        <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
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
                                            <input type="hidden" id="tableName" name="tableName" value="tbl_manage_employee" />
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
                                case "fetchProjectDetails": 
                                    if($authority == 1):
                                        if(isset($_POST["project"]) && !empty($_POST["project"])):
                                            $databaseObj->select("tbl_projects");
                                            $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["project"]."'");
                                            $getData = $databaseObj->get();
                                            //Checking If Data Is Available
                                            if($getData != 0):
                                                foreach($getData as $rows):
                                                    $project_info = json_decode($rows["projects_info"]);
                                                    foreach($project_info->properties as $properties):
                                                        $databaseObj->select("tbl_property_type");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `property_type_id` = '".$properties->propertyType."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            foreach($getData as $rows):
                                                                $property_type_info = json_decode($rows["property_type_info"]);
                                                            endforeach;
                                                        endif;
                                                        $databaseObj->select("tbl_accommodation_type");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `accommodation_type_id` = '".$properties->accommodationType."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            foreach($getData as $rows):
                                                                $accommodation_type_info = json_decode($rows["accommodation_type_info"]);
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                        <option value="<?=  $property_type_info->propertyType ?>,<?=  $accommodation_type_info->accommodationType ?>,<?= $properties->squareFeet  ?>"><?=  $property_type_info->propertyType ?>, <?= $accommodation_type_info->accommodationType  ?>, Sq. Feet - <?= $properties->squareFeet  ?></option>
                                                        <?php
                                                    endforeach;
                                                endforeach;
                                            endif;
                                            exit;

                                        endif;
                                    endif;    
                                     break;
                 // ------------------------------------------------------
            // ------------ Fetch Information Section End -----------
            // ------------------------------------------------------

                            case "fetchDesignationDetails": 
                                if($authority == 1):
                                    if(isset($_POST["department"]) && !empty($_POST["department"])):
                                        $databaseObj->select("tbl_manage_designation");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if(count($getData) != 0):
                                            foreach($getData as $rows):
                                                $manage_designation_info = json_decode($rows["manage_designation_info"]);
                                                if($manage_designation_info->departmentName == $_POST["department"]):
                                                    echo "yes";
                                                    $databaseObj->select("tbl_manage_department");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_department_id` = '".$manage_designation_info->departmentName."'");
                                                    $getDataDesignation = $databaseObj->get();
                                                    //Checking If Data Is Available
                                                    if(count($getDataDesignation) != 0):
                                                        foreach($getDataDesignation as $rowsDesignation):
                                                            $manage_department_info = json_decode($rowsDesignation["manage_department_info"]);
                                                        endforeach;
                                                    endif;
                                                    
                                                    ?>
                                                    <option value="<?= $rows["manage_designation_id"] ?>"><?=   $manage_designation_info->designationName  ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                            endif;
                                            exit;
                                        endif;
                                    endif;
                                    break;
                                
                            break;    
                            case "editfetchDesignationDetails": 
                                if($authority == 1):
                                    if(isset($_POST["editDepartment"]) && !empty($_POST["editDepartment"])):
                                        $databaseObj->select("tbl_manage_designation");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if(count($getData) != 0):
                                            foreach($getData as $rows):
                                                $manage_designation_info = json_decode($rows["manage_designation_info"]);
                                                if($manage_designation_info->departmentName == $_POST["editDepartment"]):
                                                    // echo "yes";
                                                    $databaseObj->select("tbl_manage_department");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_department_id` = '".$manage_designation_info->departmentName."'");
                                                    $getDataDesignation = $databaseObj->get();
                                                    //Checking If Data Is Available
                                                    if(count($getDataDesignation) != 0):
                                                        foreach($getDataDesignation as $rowsDesignation):
                                                            $manage_department_info = json_decode($rowsDesignation["manage_department_info"]);
                                                        endforeach;
                                                    endif;
                                                    
                                                    ?>
                                                    <option value="<?= $rows["manage_designation_id"] ?>"><?= $manage_designation_info->designationName ?></option>
                                                   
                                                    <?php
                                                    endif;
                                                endforeach;
                                            endif;
                                            exit;
                                        endif;
                                    endif;    
                                
                            break;
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

                                        function topEndNotification(theme, message) {
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