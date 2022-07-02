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

    $manageCategoryStoreDir = "../../../assets/admin/manage-items/";

    $manageCategoryDir = "assets/admin/manage-items/";

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

                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/manage-department.php">

                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_designation">

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

                                        <th>Department</th>

                                        <th>Designation</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                        $databaseObj->select("tbl_manage_designation");

                                        $databaseObj->where("`status` = '".$auth->visible()."'");

                                        $databaseObj->order_by("`manage_designation_id` DESC");

                                        $getData = $databaseObj->get();

                                        //Checking If Data Is Available

                                        if($getData != 0):

                                            $sno = 1;

                                            foreach($getData as $rows):

                                                $manage_designation_info = json_decode($rows["manage_designation_info"]);

                                                $manage_designation_log = json_decode($rows["manage_designation_log"]);

                                    ?>

                                                    <tr>

                                                        <td class="text-center">

                                                            <div class="icheck-navy d-inline">

                                                                <input type="checkbox" id="checkbox-<?= $rows["manage_designation_id"] ?>" name="checkbox-select[]" value="<?= $rows["manage_designation_id"] ?>" class="check-table">

                                                                <label for="checkbox-<?= $rows["manage_designation_id"] ?>">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td><?= $sno ?>.</td>
                                                        <?php
                                                      $databaseObj->select("tbl_manage_department");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_department_id` = '".$manage_designation_info->departmentName."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        foreach($getData as $rows_deptt):
                                                            $manage_department_info = json_decode($rows_deptt["manage_department_info"]);
                                                        endforeach;
                                                    endif;
                                                     ?>

                                                        <td><?= $manage_department_info->departmentName ?></td>

                                                        <td><?= $manage_designation_info->designationName ?></td>

                                                        <td class="text-center">

                                                            <button type="button" id="information-button-<?= $rows["manage_designation_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">

                                                                <i class="fa fa-scroll fa-sm"></i>

                                                            </button>

                                                            <button type="button" id="see-button-<?= $rows["manage_designation_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See">

                                                                <i class="fa fa-eye fa-sm"></i>

                                                            </button>

                                                            <button type="button" id="edit-button-<?= $rows["manage_designation_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">

                                                                <i class="fa fa-edit fa-sm"></i>

                                                            </button>

                                                            <button type="button" id="delete-button-<?= $rows["manage_designation_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">

                                                                <i class="fa fa-trash fa-sm"></i>

                                                            </button>

                                                        </td>

                                                    </tr>

                                                    <script>

                                                        // Information Section Start ---------------------------------------------------------------

                                                        $("#information-button-<?= $rows["manage_designation_id"] ?>").click(function () {

                                                            $("#information-modal").modal('show');

                                                            $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

                                                            var formData = {"action":"fetchInformation","id":"<?= $rows["manage_designation_id"] ?>"};

                                                            $.ajax({

                                                                url: 'application/view/admin/manage-designation.php',

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

                                                        $("#see-button-<?= $rows["manage_designation_id"] ?>").click(function () {

                                                            $("#see-modal").modal('show');

                                                            $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

                                                            var formData = {"action":"fetchSee","id":"<?= $rows["manage_designation_id"] ?>"};

                                                            $.ajax({

                                                                url: 'application/view/admin/manage-designation.php',

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

                                                        $("#edit-button-<?= $rows["manage_designation_id"] ?>").click(function () {

                                                            $("#edit-modal").modal('show');

                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

                                                            var formData = {"action":"fetchEdit","id":"<?= $rows["manage_designation_id"] ?>"};

                                                            $.ajax({

                                                                url: 'application/view/admin/manage-designation.php',

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

                                                        $("#delete-button-<?= $rows["manage_designation_id"] ?>").click(function () {

                                                            $("#delete-modal").modal('show');

                                                            $('#deleteButton').prop('disabled', true);

                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["manage_designation_id"] ?>"};

                                                            $.ajax({

                                                                url: 'application/view/admin/manage-designation.php',

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

                        $databaseObj->select("tbl_manage_designation");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$_POST["id"]."'");

                        $databaseObj->order_by("`manage_designation_id` DESC");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            foreach($getData as $rows):

                                $manage_designation_log = json_decode($rows["manage_designation_log"]);

                                ?>

                                    <div class="row">

                                        <?php

                                            $sno = 1;

                                            foreach($manage_designation_log as $manage_designation_log_info):

                                            ?>

                                                <div class="col-md-12">

                                                    <div class="card">

                                                        <div class="card-header d-flex p-0">

                                                            <ul class="nav nav-pills ml-auto p-2">

                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($manage_designation_log_info->action) ?> By</a></li>

                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>

                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>

                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>

                                                            </ul>

                                                        </div><!-- /.card-header -->

                                                        <div class="card-body">

                                                            <div class="tab-content">

                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($manage_designation_log_info->action) ?> By -

                                                                    <?php

                                                                        if($manage_designation_log_info->by == $auth->admin_id):

                                                                            echo "You";

                                                                        else:

                                                                            $databaseObj->select("tbl_admin");

                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$manage_designation_log_info->by."'");

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

                                                                    <?= date("l, M d, Y", strtotime($manage_designation_log_info->date)) ?> At <?= $manage_designation_log_info->at ?>

                                                                </div>

                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>

                                                                    <?= $manage_designation_log_info->ip ?>

                                                                </div>

                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>

                                                                    <?php

                                                                        $latLangArray = explode(",", $manage_designation_log_info->location);

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

                        $databaseObj->select("tbl_manage_designation");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$_POST["id"]."'");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            foreach($getData as $rows):

                                $manage_designation_info = json_decode($rows["manage_designation_info"]);

                                ?>

                                        <div class="row">
                                             <?php
                                                      $databaseObj->select("tbl_manage_department");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_department_id` = '".$manage_designation_info->departmentName."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        foreach($getData as $rows_deptt):
                                                            $manage_department_info = json_decode($rows_deptt["manage_department_info"]);
                                                        endforeach;
                                                    endif;
                                                     ?>


                                            <div class="col-md-12">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Department</h5>

                                                    <?= $manage_department_info->departmentName ?>

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Designation</h5>

                                                    <?= $manage_designation_info->designationName ?>

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

                        $databaseObj->select("tbl_manage_designation");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$_POST["id"]."'");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            foreach($getData as $rows):

                                $manage_designation_info = json_decode($rows["manage_designation_info"]);

                                ?>

                                    <div class="row">

                                        <div class="col-md-12">

                                           <div class="form-group">
                                                <label for="editdepartmentName">Department Name</label>
                                                  <select id="editdepartmentName" name="editdepartmentName" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
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
                                                                                <option <?php if($manage_designation_info->departmentName == $rows["manage_department_id"]) echo "selected" ?> value="<?= $rows["manage_department_id"] ?>"><?= $manage_department_info->departmentName ?></option>
                                                                            <?php
                                                                        endforeach;
                                                                    endif;
                                                                ?>
                                                              </select>   
                                                                
                                            </div>

                                        </div>

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label for="editdesignationName">Designation</label>

                                                <input type="text" class="form-control form-control-sm" id="editdesignationName" name="editdesignationName" placeholder="Designation" value="<?= $manage_designation_info->designationName ?>">

                                            </div>

                                        </div>

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

                        <input type="hidden" id="tableName" name="tableName" value="tbl_manage_designation" />

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

