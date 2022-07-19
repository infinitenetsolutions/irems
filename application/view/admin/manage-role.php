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
$manageRoleStoreDir = "../../../assets/admin/manage-role/";
$manageRoleDir = "assets/admin/manage-role/";
if (isset($_POST["action"])) :
    // -----------------------------------
    // ------------ Switch Start ---------
    // -----------------------------------
    switch ($_POST["action"]):
            // -----------------------------------------------
            // ------------ Fetch Data Section Start ---------
            // -----------------------------------------------
        case "fetchData":
?>
            <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/manage-role.php">
                <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_admin">
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
                            <th>Username</th>
                            <th>Employee Name</th>
                            <th>Gender</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $databaseObj->select("tbl_admin");
                        $databaseObj->where("`status` = '" . $auth->visible() . "' && `admin_id` NOT IN ('1', '" . $auth->admin_id . "')");
                        $databaseObj->order_by("`admin_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if ($getData != 0) :
                            $sno = 1;
                            foreach ($getData as $rows) :
                                $admin_info = json_decode($rows["admin_info"]);
                                $admin_log = json_decode($rows["admin_log"]);
                        ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="icheck-navy d-inline">
                                            <input type="checkbox" id="checkbox-<?= $rows["admin_id"] ?>" name="checkbox-select[]" value="<?= $rows["admin_id"] ?>" class="check-table">
                                            <label for="checkbox-<?= $rows["admin_id"] ?>">
                                            </label>
                                        </div>
                                    </td>
                                    <td><?= $sno ?>.</td>
                                    <td><?= $admin_log->user ?></td>
                                    <td><?= $admin_info->name ?></td>
                                    <td><?= ucwords($admin_info->gender) ?></td>
                                    <td><?= $admin_info->phoneNumber ?></td>
                                    <td><?= $admin_info->emailId ?></td>
                                    <td class="text-center">
                                        <button type="button" id="information-button-<?= $rows["admin_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">
                                            <i class="fa fa-scroll fa-sm"></i>
                                        </button>
                                        <!-- <button type="button" id="see-button-<?= $rows["admin_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See">
                                                                <i class="fa fa-eye fa-sm"></i>
                                                            </button> -->
                                        <button type="button" id="edit-button-<?= $rows["admin_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                            <i class="fa fa-edit fa-sm"></i>
                                        </button>
                                        <button type="button" id="delete-button-<?= $rows["admin_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                            <i class="fa fa-trash fa-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                                <script>
                                    // Information Section Start ---------------------------------------------------------------
                                    $("#information-button-<?= $rows["admin_id"] ?>").click(function() {
                                        $("#information-modal").modal('show');
                                        $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                        var formData = {
                                            "action": "fetchInformation",
                                            "id": "<?= $rows["admin_id"] ?>"
                                        };
                                        $.ajax({
                                            url: 'application/view/admin/manage-role.php',
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
                                    $("#see-button-<?= $rows["admin_id"] ?>").click(function() {
                                        $("#see-modal").modal('show');
                                        $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                        var formData = {
                                            "action": "fetchSee",
                                            "id": "<?= $rows["admin_id"] ?>"
                                        };
                                        $.ajax({
                                            url: 'application/view/admin/manage-role.php',
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
                                    $("#edit-button-<?= $rows["admin_id"] ?>").click(function() {
                                        $("#edit-modal").modal('show');
                                        $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                        var formData = {
                                            "action": "fetchEdit",
                                            "id": "<?= $rows["admin_id"] ?>"
                                        };
                                        $.ajax({
                                            url: 'application/view/admin/manage-role.php',
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
                                    $("#delete-button-<?= $rows["admin_id"] ?>").click(function() {
                                        $("#delete-modal").modal('show');
                                        $('#deleteButton').prop('disabled', true);
                                        $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                        var formData = {
                                            "action": "fetchDelete",
                                            "id": "<?= $rows["admin_id"] ?>"
                                        };
                                        $.ajax({
                                            url: 'application/view/admin/manage-role.php',
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
            if ($authority == 1) :
                if (isset($_POST["id"]) && !empty($_POST["id"])) :
                    $databaseObj->select("tbl_admin");
                    $databaseObj->where("`status` = '" . $auth->visible() . "' && `admin_id` = '" . $_POST["id"] . "'");
                    $databaseObj->order_by("`admin_id` DESC");
                    $getData = $databaseObj->get();
                    //Checking If Data Is Available
                    if ($getData != 0) :
                        foreach ($getData as $rows) :
                            $admin_create = json_decode($rows["admin_create"]);
            ?>
                            <div class="row">
                                <?php
                                $sno = 1;
                                foreach ($admin_create as $admin_create_info) :
                                ?>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header d-flex p-0">
                                                <ul class="nav nav-pills ml-auto p-2">
                                                    <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($admin_create_info->action) ?> By</a></li>
                                                    <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                </ul>
                                            </div><!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                        <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($admin_create_info->action) ?> By -
                                                            <?php
                                                            if ($admin_create_info->by == $auth->admin_id) :
                                                                echo "You";
                                                            else :
                                                                $databaseObj->select("tbl_admin");
                                                                $databaseObj->where("`status` = '" . $auth->visible() . "' && `admin_id` = '" . $admin_create_info->by . "'");
                                                                $getData = $databaseObj->get();
                                                                //Checking If Data Is Available
                                                                if ($getData != 0) :
                                                                    foreach ($getData as $rows) :
                                                                        $admin_info = json_decode($rows["admin_info"]);
                                                                        echo $admin_info->name;
                                                                    endforeach;
                                                                else :
                                                                    echo "Anonymous";
                                                                endif;
                                                            endif;
                                                            ?>
                                                        </h5>
                                                    </div>
                                                    <div class="tab-pane active" id="tab_1_<?= $sno ?>">
                                                        <h5><i class="icon fas fa-calendar"></i> Date/Time - </h5>
                                                        <?= date("l, M d, Y", strtotime($admin_create_info->date)) ?> At <?= $admin_create_info->at ?>
                                                    </div>
                                                    <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                        <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                        <?= $admin_create_info->ip ?>
                                                    </div>
                                                    <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                        <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                        <?php
                                                        $latLangArray = explode(",", $admin_create_info->location);
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
                    else :
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                    <?php
                    endif;
                else :
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                        Something went wrong plase try again or refresh.
                    </div>
                <?php
                endif;
            else :
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
            // ------------ Fetch Edit Section Start ----------------
            // ------------------------------------------------------
        case "fetchEdit":
            if ($authority == 1) :
                if (isset($_POST["id"]) && !empty($_POST["id"])) :
                    $databaseObj->select("tbl_admin");
                    $databaseObj->where("`status` = '" . $auth->visible() . "' && `admin_id` = '" . $_POST["id"] . "'");
                    $getData = $databaseObj->get();
                    //Checking If Data Is Available
                    if ($getData != 0) :
                        foreach ($getData as $rows) :
                            $admin_info = json_decode($rows["admin_info"]);
                            $admin_log = json_decode($rows["admin_log"]);
                            // print_r($admin_log);
                ?>
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="hidden" class="form-group" id="edit_id" value="<?= $admin_info->empId ?>">
                                            <div class="form-group">
                                                <label for="editRoleUsername">Username</label>
                                                <input type="text" class="form-control form-control-sm" id="editRoleUsername" name="editRoleUsername" data-already-user="<?= $admin_log->user ?>" placeholder="Username" value="<?= $admin_log->user ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="editRolePassword">Change Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control form-control-sm" id="editRolePassword" name="editRolePassword" placeholder="Change Password" autocomplete="off">
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
                                                <label for="editRoleRePassword">Re Enter Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control form-control-sm" id="editRoleRePassword" name="editRoleRePassword" placeholder="Re Enter Password" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <button type="button" class="open-close btn btn-sm btn-danger" data-open-close="close">
                                                            <i class="fa fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $databaseObj->select("tbl_manage_employee");
                                        $databaseObj->where("`status` = '" . $auth->visible() . "' && `manage_employee_id` = '" . $admin_info->empId . "'");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if ($getData != 0) :
                                            foreach ($getData as $rows) :
                                                $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                            endforeach;
                                        endif;
                                        // $admin_log = json_decode($rows["admin_log"]);
                                        // print_r($admin_info);


                                        ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="editRoleName">Employee</label>
                                                <input type="text" class="form-control form-control-sm" id="editRoleName" name="editRoleName" placeholder="Name" value="<?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="editRoleContactNumber">Contact Number</label>
                                                <input type="text" class="form-control form-control-sm" id="editRoleContactNumber" name="editRoleContactNumber" placeholder="Contact Number" value="<?= $manage_employee_info->mobile ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="editRoleEmail">Email</label>
                                                <input type="text" class="form-control form-control-sm" id="editRoleEmail" name="editRoleEmail" placeholder="Email" value="<?= $manage_employee_info->email ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="editRoleGender">Gender</label>
                                                <input type="text" class="form-control form-control-sm" id="editRoleGender" name="editRoleGender" placeholder="Name" value="<?= ucwords($manage_employee_info->gender) ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editRoleAddress">Address</label>
                                                <textarea class="form-control form-control-sm" id="editRoleAddress" name="editRoleAddress" placeholder="Address" readonly><?= $manage_employee_info->address1 ?></textarea>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="card card-navy">
                                <div class="card-header">
                                    <h3 class="card-title">Project</h3>
                                </div>
                                <!--  <div class="card-body">
                                       <div class="card"> -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editprojectName">Project</label>
                                                <input type="hidden" class="form-control form-control-sm" id="projectName" name="projectName" value="<?= $manage_employee_info->project ?>" readonly>
                                                <?php
                                                // echo $manage_employee_info->project;
                                                $databaseObj_sec->select("tbl_projects");
                                                $databaseObj_sec->where("`status` = '" . $auth->visible() . "' && `projects_id` = '" . $manage_employee_info->project . "'");
                                                $getData = $databaseObj_sec->get();

                                                //Checking If Data Is Available
                                                if ($getData != 0) :
                                                    foreach ($getData as $rows) :
                                                        $projects_info = json_decode($rows["projects_info"]);


                                                        $commit_edit = $rows["commit_edit"];
                                                        $commit_delete = $rows["commit_delete"];


                                                    endforeach;
                                                endif; ?>
                                                <input type="text" class="form-control form-control-sm" value="<?= $projects_info->projectName ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit_commit_edit">Edit</label>

                                                <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" id="edit_commit_edit" name="edit_commit_edit">

                                                    <option value="" disabled selected>Select Edit Status</option>
                                                    <option value="1" <?php if ($commit_edit == "1") echo "selected" ?>>DISABLE</option>
                                                    <option value="0" <?php if ($commit_edit == "0") echo "selected" ?>>ENABLE</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit_commit_delete">Delete</label>

                                                <!--                                                  <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" id="commit_delete" name="commit_delete">
                                                    <option selected="" disabled="">Select Delete Status</option>
                                                    <option value="0"> OFF </option> -->
                                                <!-- option value="1"> ON </option>

                                                 </select> -->
                                                <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" id="edit_commit_delete" name="edit_commit_delete">
                                                    <option disabled selected value="">Select Delete Status</option>
                                                    <option value="1" <?php if ($commit_delete == "1") echo "selected" ?>>DISABLE</option>
                                                    <option value="0" <?php if ($commit_delete == "0") echo "selected" ?>>ENABLE</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <script>
                                    $('#edit_commit_delete').on('change', function(event) {


                                        var formData = new FormData();

                                        formData.append("action", "editCommitDelete");
                                        formData.append("commit_delete", $("#edit_commit_delete").val());
                                        formData.append("empid", $("#edit_id").val());
                                        // formData.append("project", $("#roleProject").val($(this).find(":selected").data("project")));
                                        // $("#designation").prop("disabled", true);

                                        $.ajax({

                                            url: 'application/controller/admin/manage-role.php',

                                            type: 'POST',

                                            data: formData,

                                            success: function(result) {


                                                // if(data.response != "ok")
                                                //     topEndNotification(data.responseType, data.responseMessage);

                                            },

                                            cache: false,

                                            contentType: false,

                                            processData: false

                                        });

                                        event.preventDefault();

                                    });


                                    $('#edit_commit_edit').on('change', function(event) {


                                        var formData = new FormData();

                                        formData.append("action", "editCommitEdit");
                                        formData.append("commit_edit", $("#edit_commit_edit").val());
                                        formData.append("empid", $("#edit_id").val());
                                        // formData.append("project", $("#roleProject").val($(this).find(":selected").data("project")));
                                        // $("#designation").prop("disabled", true);

                                        $.ajax({

                                            url: 'application/controller/admin/manage-role.php',

                                            type: 'POST',

                                            data: formData,

                                            success: function(result) {




                                            },

                                            cache: false,

                                            contentType: false,

                                            processData: false

                                        });

                                        event.preventDefault();

                                    });
                                </script>

                            </div>
                            <div class="card card-navy">
                                <div class="card-header">
                                    <h3 class="card-title">Select Authentication</h3>
                                </div>
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-1" name="edit_page_no_1">
                                                <input type="hidden" name="check_page_no_1" value="2">
                                                <label for="edit-check-menu-1">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-1-1" name="edit_page_no_1_1_auth">
                                                                        <label for="edit-check-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-1-1" name="edit_page_no_1_1_add">
                                                                        <label for="edit-add-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-1-1" name="edit_page_no_1_1_see">
                                                                        <label for="edit-see-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-1-1" name="edit_page_no_1_1_update">
                                                                        <label for="edit-update-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-1-1" name="edit_page_no_1_1_delete">
                                                                        <label for="edit-delete-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-1-1" name="edit_page_no_1_1_import">
                                                                        <label for="edit-import-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-1-1" name="edit_page_no_1_1_export">
                                                                        <label for="edit-export-menu-1-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-1-1" name="edit_page_no_1_1_information">
                                                                        <label for="edit-information-menu-1-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-1-2" name="edit_page_no_1_2_auth">
                                                                        <label for="edit-check-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-1-2" name="edit_page_no_1_2_add">
                                                                        <label for="edit-add-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-1-2" name="edit_page_no_1_2_see">
                                                                        <label for="edit-see-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-1-2" name="edit_page_no_1_2_update">
                                                                        <label for="edit-update-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-1-2" name="edit_page_no_1_2_delete">
                                                                        <label for="edit-delete-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-1-2" name="edit_page_no_1_2_import">
                                                                        <label for="edit-import-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-1-2" name="edit_page_no_1_2_export">
                                                                        <label for="edit-export-menu-1-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-1-2" name="edit_page_no_1_2_information">
                                                                        <label for="edit-information-menu-1-2"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-2" name="edit_page_no_2">
                                                <input type="hidden" name="check_page_no_2" value="5">
                                                <label for="edit-check-menu-2">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-2-1" name="edit_page_no_2_1_auth">
                                                                        <label for="edit-check-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-2-1" name="edit_page_no_2_1_add">
                                                                        <label for="edit-add-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-2-1" name="edit_page_no_2_1_see">
                                                                        <label for="edit-see-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-2-1" name="edit_page_no_2_1_update">
                                                                        <label for="edit-update-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-2-1" name="edit_page_no_2_1_delete">
                                                                        <label for="edit-delete-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-2-1" name="edit_page_no_2_1_import">
                                                                        <label for="edit-import-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-2-1" name="edit_page_no_2_1_export">
                                                                        <label for="edit-export-menu-2-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-2-1" name="edit_page_no_2_1_information">
                                                                        <label for="edit-information-menu-2-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-2-2" name="edit_page_no_2_2_auth">
                                                                        <label for="edit-check-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-2-2" name="edit_page_no_2_2_add">
                                                                        <label for="edit-add-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-2-2" name="edit_page_no_2_2_see">
                                                                        <label for="edit-see-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-2-2" name="edit_page_no_2_2_update">
                                                                        <label for="edit-update-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-2-2" name="edit_page_no_2_2_delete">
                                                                        <label for="edit-delete-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-2-2" name="edit_page_no_2_2_import">
                                                                        <label for="edit-import-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-2-2" name="edit_page_no_2_2_export">
                                                                        <label for="edit-export-menu-2-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-2-2" name="edit_page_no_2_2_information">
                                                                        <label for="edit-information-menu-2-2"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-2-3" name="edit_page_no_2_3_auth">
                                                                        <label for="edit-check-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-2-3" name="edit_page_no_2_3_add">
                                                                        <label for="edit-add-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-2-3" name="edit_page_no_2_3_see">
                                                                        <label for="edit-see-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-2-3" name="edit_page_no_2_3_update">
                                                                        <label for="edit-update-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-2-3" name="edit_page_no_2_3_delete">
                                                                        <label for="edit-delete-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-2-3" name="edit_page_no_2_3_import">
                                                                        <label for="edit-import-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-2-3" name="edit_page_no_2_3_export">
                                                                        <label for="edit-export-menu-2-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-2-3" name="edit_page_no_2_3_information">
                                                                        <label for="edit-information-menu-2-3"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-2-4" name="edit_page_no_2_4_auth">
                                                                        <label for="edit-check-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-2-4" name="edit_page_no_2_4_add">
                                                                        <label for="edit-add-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-2-4" name="edit_page_no_2_4_see">
                                                                        <label for="edit-see-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-2-4" name="edit_page_no_2_4_update">
                                                                        <label for="edit-update-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-2-4" name="edit_page_no_2_4_delete">
                                                                        <label for="edit-delete-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-2-4" name="edit_page_no_2_4_import">
                                                                        <label for="edit-import-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-2-4" name="edit_page_no_2_4_export">
                                                                        <label for="edit-export-menu-2-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-2-4" name="edit_page_no_2_4_information">
                                                                        <label for="edit-information-menu-2-4"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-2-5" name="edit_page_no_2_5_auth">
                                                                        <label for="edit-check-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-2-5" name="edit_page_no_2_5_add">
                                                                        <label for="edit-add-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-2-5" name="edit_page_no_2_5_see">
                                                                        <label for="edit-see-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-2-5" name="edit_page_no_2_5_update">
                                                                        <label for="edit-update-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-2-5" name="edit_page_no_2_5_delete">
                                                                        <label for="edit-delete-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-2-5" name="edit_page_no_2_5_import">
                                                                        <label for="edit-import-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-2-5" name="edit_page_no_2_5_export">
                                                                        <label for="edit-export-menu-2-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-2-5" name="edit_page_no_2_5_information">
                                                                        <label for="edit-information-menu-2-5"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-3" name="edit_page_no_3">
                                                <input type="hidden" name="check_page_no_3" value="3">
                                                <label for="edit-check-menu-3">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-3-1" name="edit_page_no_3_1_auth">
                                                                        <label for="edit-check-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-3-1" name="edit_page_no_3_1_add">
                                                                        <label for="edit-add-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-3-1" name="edit_page_no_3_1_see">
                                                                        <label for="edit-see-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-3-1" name="edit_page_no_3_1_update">
                                                                        <label for="edit-update-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-3-1" name="edit_page_no_3_1_delete">
                                                                        <label for="edit-delete-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-3-1" name="edit_page_no_3_1_import">
                                                                        <label for="edit-import-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-3-1" name="edit_page_no_3_1_export">
                                                                        <label for="edit-export-menu-3-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-3-1" name="edit_page_no_3_1_information">
                                                                        <label for="edit-information-menu-3-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-3-2" name="edit_page_no_3_2_auth">
                                                                        <label for="edit-check-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-3-2" name="edit_page_no_3_2_add">
                                                                        <label for="edit-add-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-3-2" name="edit_page_no_3_2_see">
                                                                        <label for="edit-see-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-3-2" name="edit_page_no_3_2_update">
                                                                        <label for="edit-update-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-3-2" name="edit_page_no_3_2_delete">
                                                                        <label for="edit-delete-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-3-2" name="edit_page_no_3_2_import">
                                                                        <label for="edit-import-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-3-2" name="edit_page_no_3_2_export">
                                                                        <label for="edit-export-menu-3-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-3-2" name="edit_page_no_3_2_information">
                                                                        <label for="edit-information-menu-3-2"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-3-3" name="edit_page_no_3_3_auth">
                                                                        <label for="edit-check-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-3-3" name="edit_page_no_3_3_add">
                                                                        <label for="edit-add-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-3-3" name="edit_page_no_3_3_see">
                                                                        <label for="edit-see-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-3-3" name="edit_page_no_3_3_update">
                                                                        <label for="edit-update-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-3-3" name="edit_page_no_3_3_delete">
                                                                        <label for="edit-delete-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-3-3" name="edit_page_no_3_3_import">
                                                                        <label for="edit-import-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-3-3" name="edit_page_no_3_3_export">
                                                                        <label for="edit-export-menu-3-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-3-3" name="edit_page_no_3_3_information">
                                                                        <label for="edit-information-menu-3-3"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-4" name="edit_page_no_4">
                                                <input type="hidden" name="check_page_no_4" value="4">
                                                <label for="edit-check-menu-4">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-4-1" name="edit_page_no_4_1_auth">
                                                                        <label for="edit-check-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-4-1" name="edit_page_no_4_1_add">
                                                                        <label for="edit-add-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-4-1" name="edit_page_no_4_1_see">
                                                                        <label for="edit-see-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-4-1" name="edit_page_no_4_1_update">
                                                                        <label for="edit-update-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-4-1" name="edit_page_no_4_1_delete">
                                                                        <label for="edit-delete-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-4-1" name="edit_page_no_4_1_import">
                                                                        <label for="edit-import-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-4-1" name="edit_page_no_4_1_export">
                                                                        <label for="edit-export-menu-4-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-4-1" name="edit_page_no_4_1_information">
                                                                        <label for="edit-information-menu-4-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-4-2" name="edit_page_no_4_2_auth">
                                                                        <label for="edit-check-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-4-2" name="edit_page_no_4_2_add">
                                                                        <label for="edit-add-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-4-2" name="edit_page_no_4_2_see">
                                                                        <label for="edit-see-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-4-2" name="edit_page_no_4_2_update">
                                                                        <label for="edit-update-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-4-2" name="edit_page_no_4_2_delete">
                                                                        <label for="edit-delete-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-4-2" name="edit_page_no_4_2_import">
                                                                        <label for="edit-import-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-4-2" name="edit_page_no_4_2_export">
                                                                        <label for="edit-export-menu-4-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-4-2" name="edit_page_no_4_2_information">
                                                                        <label for="edit-information-menu-4-2"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-4-3" name="edit_page_no_4_3_auth">
                                                                        <label for="edit-check-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-4-3" name="edit_page_no_4_3_add">
                                                                        <label for="edit-add-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-4-3" name="edit_page_no_4_3_see">
                                                                        <label for="edit-see-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-4-3" name="edit_page_no_4_3_update">
                                                                        <label for="edit-update-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-4-3" name="edit_page_no_4_3_delete">
                                                                        <label for="edit-delete-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-4-3" name="edit_page_no_4_3_import">
                                                                        <label for="edit-import-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-4-3" name="edit_page_no_4_3_export">
                                                                        <label for="edit-export-menu-4-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-4-3" name="edit_page_no_4_3_information">
                                                                        <label for="edit-information-menu-4-3"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-4-4" name="edit_page_no_4_4_auth">
                                                                        <label for="edit-check-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-4-4" name="edit_page_no_4_4_add">
                                                                        <label for="edit-add-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-4-4" name="edit_page_no_4_4_see">
                                                                        <label for="edit-see-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-4-4" name="edit_page_no_4_4_update">
                                                                        <label for="edit-update-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-4-4" name="edit_page_no_4_4_delete">
                                                                        <label for="edit-delete-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-4-4" name="edit_page_no_4_4_import">
                                                                        <label for="edit-import-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-4-4" name="edit_page_no_4_4_export">
                                                                        <label for="edit-export-menu-4-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-4-4" name="edit_page_no_4_4_information">
                                                                        <label for="edit-information-menu-4-4"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-5" name="edit_page_no_5">
                                                <input type="hidden" name="check_page_no_5" value="9">
                                                <label for="edit-check-menu-5">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-1" name="edit_page_no_5_1_auth">
                                                                        <label for="edit-check-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-1" name="edit_page_no_5_1_add">
                                                                        <label for="edit-add-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-1" name="edit_page_no_5_1_see">
                                                                        <label for="edit-see-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-1" name="edit_page_no_5_1_update">
                                                                        <label for="edit-update-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-1" name="edit_page_no_5_1_delete">
                                                                        <label for="edit-delete-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-1" name="edit_page_no_5_1_import">
                                                                        <label for="edit-import-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-1" name="edit_page_no_5_1_export">
                                                                        <label for="edit-export-menu-5-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-1" name="edit_page_no_5_1_information">
                                                                        <label for="edit-information-menu-5-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-2" name="edit_page_no_5_2_auth">
                                                                        <label for="edit-check-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-2" name="edit_page_no_5_2_add">
                                                                        <label for="edit-add-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-2" name="edit_page_no_5_2_see">
                                                                        <label for="edit-see-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-2" name="edit_page_no_5_2_update">
                                                                        <label for="edit-update-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-2" name="edit_page_no_5_2_delete">
                                                                        <label for="edit-delete-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-2" name="edit_page_no_5_2_import">
                                                                        <label for="edit-import-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-2" name="edit_page_no_5_2_export">
                                                                        <label for="edit-export-menu-5-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-2" name="edit_page_no_5_2_information">
                                                                        <label for="edit-information-menu-5-2"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-3" name="edit_page_no_5_3_auth">
                                                                        <label for="edit-check-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-3" name="edit_page_no_5_3_add">
                                                                        <label for="edit-add-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-3" name="edit_page_no_5_3_see">
                                                                        <label for="edit-see-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-3" name="edit_page_no_5_3_update">
                                                                        <label for="edit-update-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-3" name="edit_page_no_5_3_delete">
                                                                        <label for="edit-delete-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-3" name="edit_page_no_5_3_import">
                                                                        <label for="edit-import-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-3" name="edit_page_no_5_3_export">
                                                                        <label for="edit-export-menu-5-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-3" name="edit_page_no_5_3_information">
                                                                        <label for="edit-information-menu-5-3"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-4" name="edit_page_no_5_4_auth">
                                                                        <label for="edit-check-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-4" name="edit_page_no_5_4_add">
                                                                        <label for="edit-add-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-4" name="edit_page_no_5_4_see">
                                                                        <label for="edit-see-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-4" name="edit_page_no_5_4_update">
                                                                        <label for="edit-update-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-4" name="edit_page_no_5_4_delete">
                                                                        <label for="edit-delete-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-4" name="edit_page_no_5_4_import">
                                                                        <label for="edit-import-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-4" name="edit_page_no_5_4_export">
                                                                        <label for="edit-export-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-4" name="edit_page_no_5_4_information">
                                                                        <label for="edit-information-menu-5-4"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>5. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Goods Issue Note
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-5" name="edit_page_no_5_5_auth">
                                                                        <label for="edit-check-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-5" name="edit_page_no_5_5_add">
                                                                        <label for="edit-add-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-5" name="edit_page_no_5_5_see">
                                                                        <label for="edit-see-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-5" name="edit_page_no_5_5_update">
                                                                        <label for="edit-update-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-5" name="edit_page_no_5_5_delete">
                                                                        <label for="edit-delete-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-5" name="edit_page_no_5_5_import">
                                                                        <label for="edit-import-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-5" name="edit_page_no_5_5_export">
                                                                        <label for="edit-export-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-5" name="edit_page_no_5_5_information">
                                                                        <label for="edit-information-menu-5-5"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>6. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Stock Details
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-6" name="edit_page_no_5_6_auth">
                                                                        <label for="edit-check-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-6" name="edit_page_no_5_6_add">
                                                                        <label for="edit-add-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-6" name="edit_page_no_5_6_see">
                                                                        <label for="edit-see-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-6" name="edit_page_no_5_6_update">
                                                                        <label for="edit-update-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-6" name="edit_page_no_5_6_delete">
                                                                        <label for="edit-delete-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-6" name="edit_page_no_5_6_import">
                                                                        <label for="edit-import-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-6" name="edit_page_no_5_6_export">
                                                                        <label for="edit-export-menu-5-6"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-6" name="edit_page_no_5_6_information">
                                                                        <label for="edit-information-menu-5-6"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-7" name="edit_page_no_5_7_auth">
                                                                        <label for="edit-check-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-7" name="edit_page_no_5_7_add">
                                                                        <label for="edit-add-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-7" name="edit_page_no_5_7_see">
                                                                        <label for="edit-see-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-7" name="edit_page_no_5_7_update">
                                                                        <label for="edit-update-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-7" name="edit_page_no_5_7_delete">
                                                                        <label for="edit-delete-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-7" name="edit_page_no_5_7_import">
                                                                        <label for="edit-import-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-7" name="edit_page_no_5_7_export">
                                                                        <label for="edit-export-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-7" name="edit_page_no_5_7_information">
                                                                        <label for="edit-information-menu-5-7"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>8. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        My Stock
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-8" name="edit_page_no_5_8_auth">
                                                                        <label for="edit-check-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-8" name="edit_page_no_5_8_add">
                                                                        <label for="edit-add-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-8" name="edit_page_no_5_8_see">
                                                                        <label for="edit-see-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-8" name="edit_page_no_5_8_update">
                                                                        <label for="edit-update-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-8" name="edit_page_no_5_8_delete">
                                                                        <label for="edit-delete-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-8" name="edit_page_no_5_8_import">
                                                                        <label for="edit-import-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-8" name="edit_page_no_5_8_export">
                                                                        <label for="edit-export-menu-5-8"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-8" name="edit_page_no_5_8_information">
                                                                        <label for="edit-information-menu-5-8"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-5-9" name="edit_page_no_5_9_auth">
                                                                        <label for="edit-check-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-5-9" name="edit_page_no_5_9_add">
                                                                        <label for="edit-add-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-5-9" name="edit_page_no_5_9_see">
                                                                        <label for="edit-see-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-5-9" name="edit_page_no_5_9_update">
                                                                        <label for="edit-update-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-5-9" name="edit_page_no_5_9_delete">
                                                                        <label for="edit-delete-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-5-9" name="edit_page_no_5_9_import">
                                                                        <label for="edit-import-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-5-9" name="edit_page_no_5_9_export">
                                                                        <label for="edit-export-menu-5-9"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-5-9" name="edit_page_no_5_9_information">
                                                                        <label for="edit-information-menu-5-9"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-6" name="edit_page_no_6">
                                                <input type="hidden" name="check_page_no_6" value="5">
                                                <label for="edit-check-menu-6">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-6-1" name="edit_page_no_6_1_auth">
                                                                        <label for="edit-check-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-6-1" name="edit_page_no_6_1_add">
                                                                        <label for="edit-add-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-6-1" name="edit_page_no_6_1_see">
                                                                        <label for="edit-see-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-6-1" name="edit_page_no_6_1_update">
                                                                        <label for="edit-update-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-6-1" name="edit_page_no_6_1_delete">
                                                                        <label for="edit-delete-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-6-1" name="edit_page_no_6_1_import">
                                                                        <label for="edit-import-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-6-1" name="edit_page_no_6_1_export">
                                                                        <label for="edit-export-menu-6-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-6-1" name="edit_page_no_6_1_information">
                                                                        <label for="edit-information-menu-6-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-6-2" name="edit_page_no_6_2_auth">
                                                                        <label for="edit-check-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-6-2" name="edit_page_no_6_2_add">
                                                                        <label for="edit-add-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-6-2" name="edit_page_no_6_2_see">
                                                                        <label for="edit-see-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-6-2" name="edit_page_no_6_2_update">
                                                                        <label for="edit-update-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-6-2" name="edit_page_no_6_2_delete">
                                                                        <label for="edit-delete-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-6-2" name="edit_page_no_6_2_import">
                                                                        <label for="edit-import-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-6-2" name="edit_page_no_6_2_export">
                                                                        <label for="edit-export-menu-6-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-6-2" name="edit_page_no_6_2_information">
                                                                        <label for="edit-information-menu-6-2"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-6-3" name="edit_page_no_6_3_auth">
                                                                        <label for="edit-check-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-6-3" name="edit_page_no_6_3_add">
                                                                        <label for="edit-add-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-6-3" name="edit_page_no_6_3_see">
                                                                        <label for="edit-see-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-6-3" name="edit_page_no_6_3_update">
                                                                        <label for="edit-update-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-6-3" name="edit_page_no_6_3_delete">
                                                                        <label for="edit-delete-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-6-3" name="edit_page_no_6_3_import">
                                                                        <label for="edit-import-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-6-3" name="edit_page_no_6_3_export">
                                                                        <label for="edit-export-menu-6-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-6-3" name="edit_page_no_6_3_information">
                                                                        <label for="edit-information-menu-6-3"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-6-4" name="edit_page_no_6_4_auth">
                                                                        <label for="edit-check-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-6-4" name="edit_page_no_6_4_add">
                                                                        <label for="edit-add-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-6-4" name="edit_page_no_6_4_see">
                                                                        <label for="edit-see-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-6-4" name="edit_page_no_6_4_update">
                                                                        <label for="edit-update-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-6-4" name="edit_page_no_6_4_delete">
                                                                        <label for="edit-delete-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-6-4" name="edit_page_no_6_4_import">
                                                                        <label for="edit-import-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-6-4" name="edit_page_no_6_4_export">
                                                                        <label for="edit-export-menu-6-4"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-6-4" name="edit_page_no_6_4_information">
                                                                        <label for="edit-information-menu-6-4"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-6-5" name="edit_page_no_6_5_auth">
                                                                        <label for="edit-check-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-6-5" name="edit_page_no_6_5_add">
                                                                        <label for="edit-add-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-6-5" name="edit_page_no_6_5_see">
                                                                        <label for="edit-see-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-6-5" name="edit_page_no_6_5_update">
                                                                        <label for="edit-update-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-6-5" name="edit_page_no_6_5_delete">
                                                                        <label for="edit-delete-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-6-5" name="edit_page_no_6_5_import">
                                                                        <label for="edit-import-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-6-5" name="edit_page_no_6_5_export">
                                                                        <label for="edit-export-menu-6-5"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-6-5" name="edit_page_no_6_5_information">
                                                                        <label for="edit-information-menu-6-5"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-7" name="edit_page_no_7">
                                                <input type="hidden" name="check_page_no_7" value="3">
                                                <label for="edit-check-menu-7">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-7-1" name="edit_page_no_7_1_auth">
                                                                        <label for="edit-check-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-7-1" name="edit_page_no_7_1_add">
                                                                        <label for="edit-add-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-7-1" name="edit_page_no_7_1_see">
                                                                        <label for="edit-see-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-7-1" name="edit_page_no_7_1_update">
                                                                        <label for="edit-update-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-7-1" name="edit_page_no_7_1_delete">
                                                                        <label for="edit-delete-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-7-1" name="edit_page_no_7_1_import">
                                                                        <label for="edit-import-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-7-1" name="edit_page_no_7_1_export">
                                                                        <label for="edit-export-menu-7-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-7-1" name="edit_page_no_7_1_information">
                                                                        <label for="edit-information-menu-7-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-7-2" name="edit_page_no_7_2_auth">
                                                                        <label for="edit-check-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-7-2" name="edit_page_no_7_2_add">
                                                                        <label for="edit-add-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-7-2" name="edit_page_no_7_2_see">
                                                                        <label for="edit-see-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-7-2" name="edit_page_no_7_2_update">
                                                                        <label for="edit-update-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-7-2" name="edit_page_no_7_2_delete">
                                                                        <label for="edit-delete-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-7-2" name="edit_page_no_7_2_import">
                                                                        <label for="edit-import-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-7-2" name="edit_page_no_7_2_export">
                                                                        <label for="edit-export-menu-7-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-7-2" name="edit_page_no_7_2_information">
                                                                        <label for="edit-information-menu-7-2"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-7-3" name="edit_page_no_7_3_auth">
                                                                        <label for="edit-check-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-7-3" name="edit_page_no_7_3_add">
                                                                        <label for="edit-add-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-7-3" name="edit_page_no_7_3_see">
                                                                        <label for="edit-see-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-7-3" name="edit_page_no_7_3_update">
                                                                        <label for="edit-update-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-7-3" name="edit_page_no_7_3_delete">
                                                                        <label for="edit-delete-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-7-3" name="edit_page_no_7_3_import">
                                                                        <label for="edit-import-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-7-3" name="edit_page_no_7_3_export">
                                                                        <label for="edit-export-menu-7-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-7-3" name="edit_page_no_7_3_information">
                                                                        <label for="edit-information-menu-7-3"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-8" name="edit_page_no_8">
                                                <input type="hidden" name="check_page_no_8" value="3">
                                                <label for="edit-check-menu-8">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-8-1" name="edit_page_no_8_1_auth">
                                                                        <label for="edit-check-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-8-1" name="edit_page_no_8_1_add">
                                                                        <label for="edit-add-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-8-1" name="edit_page_no_8_1_see">
                                                                        <label for="edit-see-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-8-1" name="edit_page_no_8_1_update">
                                                                        <label for="edit-update-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-8-1" name="edit_page_no_8_1_delete">
                                                                        <label for="edit-delete-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-8-1" name="edit_page_no_8_1_import">
                                                                        <label for="edit-import-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-8-1" name="edit_page_no_8_1_export">
                                                                        <label for="edit-export-menu-8-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-8-1" name="edit_page_no_8_1_information">
                                                                        <label for="edit-information-menu-8-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-8-2" name="edit_page_no_8_2_auth">
                                                                        <label for="edit-check-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-8-2" name="edit_page_no_8_2_add">
                                                                        <label for="edit-add-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-8-2" name="edit_page_no_8_2_see">
                                                                        <label for="edit-see-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-8-2" name="edit_page_no_8_2_update">
                                                                        <label for="edit-update-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-8-2" name="edit_page_no_8_2_delete">
                                                                        <label for="edit-delete-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-8-2" name="edit_page_no_8_2_import">
                                                                        <label for="edit-import-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-8-2" name="edit_page_no_8_2_export">
                                                                        <label for="edit-export-menu-8-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-8-2" name="edit_page_no_8_2_information">
                                                                        <label for="edit-information-menu-8-2"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-8-3" name="edit_page_no_8_3_auth">
                                                                        <label for="edit-check-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-8-3" name="edit_page_no_8_3_add">
                                                                        <label for="edit-add-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-8-3" name="edit_page_no_8_3_see">
                                                                        <label for="edit-see-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-8-3" name="edit_page_no_8_3_update">
                                                                        <label for="edit-update-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-8-3" name="edit_page_no_8_3_delete">
                                                                        <label for="edit-delete-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-8-3" name="edit_page_no_8_3_import">
                                                                        <label for="edit-import-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-8-3" name="edit_page_no_8_3_export">
                                                                        <label for="edit-export-menu-8-3"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-8-3" name="edit_page_no_8_3_information">
                                                                        <label for="edit-information-menu-8-3"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-9" name="edit_page_no_9">
                                                <input type="hidden" name="check_page_no_9" value="2">
                                                <label for="edit-check-menu-9">
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-9-1" name="edit_page_no_9_1_auth">
                                                                        <label for="edit-check-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-9-1" name="edit_page_no_9_1_add">
                                                                        <label for="edit-add-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-9-1" name="edit_page_no_9_1_see">
                                                                        <label for="edit-see-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-9-1" name="edit_page_no_9_1_update">
                                                                        <label for="edit-update-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-9-1" name="edit_page_no_9_1_delete">
                                                                        <label for="edit-delete-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-9-1" name="edit_page_no_9_1_import">
                                                                        <label for="edit-import-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-9-1" name="edit_page_no_9_1_export">
                                                                        <label for="edit-export-menu-9-1"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-9-1" name="edit_page_no_9_1_information">
                                                                        <label for="edit-information-menu-9-1"></label>
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
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-9-2" name="edit_page_no_9_2_auth">
                                                                        <label for="edit-check-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-9-2" name="edit_page_no_9_2_add">
                                                                        <label for="edit-add-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-see-menu-9-2" name="edit_page_no_9_2_see">
                                                                        <label for="edit-see-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-update-menu-9-2" name="edit_page_no_9_2_update">
                                                                        <label for="edit-update-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-delete-menu-9-2" name="edit_page_no_9_2_delete">
                                                                        <label for="edit-delete-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-import-menu-9-2" name="edit_page_no_9_2_import">
                                                                        <label for="edit-import-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-export-menu-9-2" name="edit_page_no_9_2_export">
                                                                        <label for="edit-export-menu-9-2"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="sub-menu-checkbox" id="edit-information-menu-9-2" name="edit_page_no_9_2_information">
                                                                        <label for="edit-information-menu-9-2"></label>
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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-10" name="edit_page_no_10">
                                                <input type="hidden" name="check_page_no_10" value="2">
                                                <label for="edit-check-menu-9">
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
                                                                <th>S. No</th>
                                                                <th>Sub Menu</th>
                                                                <th>Auth</th>
                                                                <!-- <th>Add</th>
                                                                   <th>View</th>
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
                                                                        CRM
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-10-1" name="edit_page_no_10_1_auth">
                                                                        <label for="edit-check-menu-10-1"></label>
                                                                    </div>
                                                                </td>
                                                                <!--<td>
                                                                        <div class="icheck-navy d-inline">
                                                                            <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-10-1" name="edit_page_no_10_1_add">
                                                                            <label for="edit-add-menu-10-1"></label>
                                                                        </div>
                                                                    </td>-->

                                                            </tr>
                                                            <tr>


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
                                                <input type="checkbox" class="menu-checkbox" id="edit-check-menu-12" name="edit_page_no_12">
                                                <input type="hidden" name="check_page_no_12" value="2">
                                                <label for="edit-check-menu-12">
                                                    Maintainance
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
                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1. </td>
                                                                <td>
                                                                    <div style="width: 200px">
                                                                        Manage Maintainance
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="icheck-navy d-inline">
                                                                        <input type="checkbox" class="auth-checkbox sub-menu-checkbox" id="edit-check-menu-12-1" name="edit_page_no_12_1_auth">
                                                                        <label for="edit-check-menu-12-1"></label>
                                                                    </div>
                                                                </td>
                                                                <!--<td>
                                                                        <div class="icheck-navy d-inline">
                                                                            <input type="checkbox" class="sub-menu-checkbox" id="edit-add-menu-10-1" name="edit_page_no_10_1_add">
                                                                            <label for="edit-add-menu-10-1"></label>
                                                                        </div>
                                                                    </td>-->

                                                            </tr>
                                                            <tr>


                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                            <script>
                                $(".select2").select2();
                                $(function() {
                                    <?php
                                    if ($admin_log->auth != "all") :
                                        foreach ($admin_log->auth as $menus_key => $menus_val) :
                                    ?>
                                            $("#edit-check-menu-<?= str_replace("page_no_", "", $menus_key) ?>").attr("checked", "checked");
                                            <?php
                                            foreach ($menus_val as $submenus_key => $submenus_val) :
                                            ?>
                                                $("#edit-check-menu-<?= str_replace("_", "-", str_replace("page_no_inside_", "", $submenus_key)) ?>").attr("checked", "checked");
                                                <?php
                                                if ($submenus_val->add == "yes") :
                                                ?>
                                                    $("#edit-add-menu-<?= str_replace("_", "-", str_replace("page_no_inside_", "", $submenus_key)) ?>").attr("checked", "checked");
                                                <?php
                                                endif;
                                                if ($submenus_val->see == "yes") :
                                                ?>
                                                    $("#edit-see-menu-<?= str_replace("_", "-", str_replace("page_no_inside_", "", $submenus_key)) ?>").attr("checked", "checked");
                                                <?php
                                                endif;
                                                if ($submenus_val->update == "yes") :
                                                ?>
                                                    $("#edit-update-menu-<?= str_replace("_", "-", str_replace("page_no_inside_", "", $submenus_key)) ?>").attr("checked", "checked");
                                                <?php
                                                endif;
                                                if ($submenus_val->delete == "yes") :
                                                ?>
                                                    $("#edit-delete-menu-<?= str_replace("_", "-", str_replace("page_no_inside_", "", $submenus_key)) ?>").attr("checked", "checked");
                                                <?php
                                                endif;
                                                if ($submenus_val->import == "yes") :
                                                ?>
                                                    $("#edit-import-menu-<?= str_replace("_", "-", str_replace("page_no_inside_", "", $submenus_key)) ?>").attr("checked", "checked");
                                                <?php
                                                endif;
                                                if ($submenus_val->export == "yes") :
                                                ?>
                                                    $("#edit-export-menu-<?= str_replace("_", "-", str_replace("page_no_inside_", "", $submenus_key)) ?>").attr("checked", "checked");
                                                <?php
                                                endif;
                                                if ($submenus_val->information == "yes") :
                                                ?>
                                                    $("#edit-information-menu-<?= str_replace("_", "-", str_replace("page_no_inside_", "", $submenus_key)) ?>").attr("checked", "checked");
                                    <?php
                                                endif;
                                            endforeach;
                                        endforeach;
                                    endif;
                                    ?>
                                });
                            </script>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                    <?php
                    endif;
                else :
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                        Something went wrong plase try again or refresh.
                    </div>
                <?php
                endif;
            else :
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
            if ($authority == 1) :
                if (isset($_POST["id"]) && !empty($_POST["id"])) :
                ?>
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        Do you really wanna delete this data???
                    </div>
                    <input type="hidden" id="tableId" name="tableId" value="<?= $_POST["id"] ?>" />
                    <input type="hidden" id="tableName" name="tableName" value="tbl_admin" />
                <?php
                else :
                ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                        Something went wrong plase try again or refresh.
                    </div>
                <?php
                endif;
            else :
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