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
    $uomStoreDir = "../../../assets/admin/land-acquisition-uom/";
    $uomDir = "assets/admin/land-acquisition-uom/";
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
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/land-acquisition-uom">
                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_uom">
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
                                        <th>Unit Of Measurement</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $databaseObj->select("tbl_uom");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $databaseObj->order_by("`uom_id` DESC");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                                $uom_info = json_decode($rows["uom_info"]);
                                                $uom_log = json_decode($rows["uom_log"]);
                                    ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="icheck-navy d-inline">
                                                                <input type="checkbox" id="checkbox-<?= $rows["uom_id"] ?>" name="checkbox-select[]" value="<?= $rows["uom_id"] ?>" class="check-table">
                                                                <label for="checkbox-<?= $rows["uom_id"] ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= $sno ?>.</td>
                                                        <td><?= $uom_info->uom ?></td>
                                                        <td class="text-center">
                                                            <button type="button" id="information-button-<?= $rows["uom_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">
                                                                <i class="fa fa-scroll fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="see-button-<?= $rows["uom_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See">
                                                                <i class="fa fa-eye fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="edit-button-<?= $rows["uom_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                                                <i class="fa fa-edit fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="delete-button-<?= $rows["uom_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                <i class="fa fa-trash fa-sm"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        // Information Section Start ---------------------------------------------------------------
                                                        $("#information-button-<?= $rows["uom_id"] ?>").click(function () {
                                                            $("#information-modal").modal('show');
                                                            $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchInformation","id":"<?= $rows["uom_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-uom',
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
                                                        $("#see-button-<?= $rows["uom_id"] ?>").click(function () {
                                                            $("#see-modal").modal('show');
                                                            $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSee","id":"<?= $rows["uom_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-uom',
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
                                                        $("#edit-button-<?= $rows["uom_id"] ?>").click(function () {
                                                            $("#edit-modal").modal('show');
                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchEdit","id":"<?= $rows["uom_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-uom',
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
                                                        $("#delete-button-<?= $rows["uom_id"] ?>").click(function () {
                                                            $("#delete-modal").modal('show');
                                                            $('#deleteButton').prop('disabled', true);
                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["uom_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/land-acquisition-uom',
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
                        $databaseObj->select("tbl_uom");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `uom_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`uom_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $uom_log = json_decode($rows["uom_log"]);
                                ?>
                                    <div class="row">
                                        <?php
                                            $sno = 1;
                                            foreach($uom_log as $uom_log_info):
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($uom_log_info->action) ?> By</a></li>
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($uom_log_info->action) ?> By - 
                                                                    <?php
                                                                        if($uom_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$uom_log_info->by."'");
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
                                                                    <?= date("l, M d, Y", strtotime($uom_log_info->date)) ?> At <?= $uom_log_info->at ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                                    <?= $uom_log_info->ip ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                                    <?php
                                                                        $latLangArray = explode(",", $uom_log_info->location);
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
                        $databaseObj->select("tbl_uom");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `uom_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $uom_info = json_decode($rows["uom_info"]);
                                ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Uom</h5>
                                                    <?= $uom_info->uom ?>
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
                        $databaseObj->select("tbl_uom");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `uom_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $uom_info = json_decode($rows["uom_info"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editUom">Uom</label>
                                                <input type="text" class="form-control" id="editUom" name="editUom" placeholder="Uom" value="<?= $uom_info->uom ?>">
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
                        <input type="hidden" id="tableName" name="tableName" value="tbl_uom" />
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