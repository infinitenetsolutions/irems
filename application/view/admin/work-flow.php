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
    $manageCompanyStoreDir = "../../../assets/admin/work-flow/";
    $manageCompanyDir = "assets/admin/work-flow/";
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
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/projects.php">
                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_projects">
                        <input type="hidden" id="action" name="action" value="exportSelectedData">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="icheck-navy d-inline">
                                            <input type="checkbox" id="check-all" name="check-all" title="Check All" value="all" disabled>
                                            <label for="check-all" title="Check All">
                                            </label>
                                        </div>
                                    </th>
                                    <th>S. No.</th>
                                    <th>Project Name</th>
                                    <th>Project Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $databaseObj->select("tbl_projects");
                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                    $databaseObj->order_by("`projects_id` DESC");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rows):
                                            $projects_info = json_decode($rows["projects_info"]);
                                            $projects_log = json_decode($rows["projects_log"]);
                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="icheck-navy d-inline">
                                                            <input type="checkbox" id="checkbox-<?= $rows["projects_id"] ?>" name="checkbox-select[]" value="<?= $rows["projects_id"] ?>" class="check-table" disabled>
                                                            <label for="checkbox-<?= $rows["projects_id"] ?>">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td><?= $sno ?>.</td>
                                                    <td><?= $projects_info->projectName ?></td>
                                                    <td><?= $projects_info->projectLocation ?></td>
                                                    <td>
                                                        <?php
                                                        if(empty($projects_info->projectEndingDate)):
                                                            $statusOrg = "active";
                                                        ?>
                                                        <input type="hidden" id="statusGo-<?= $rows["projects_id"] ?>" value="active">
                                                        <button type="button" class="btn btn-success btn-block btn-xs" id="statusButton-<?= $rows["projects_id"] ?>">Opened </button>
                                                        <?php
                                                            else:
                                                                $statusOrg = "inactive";
                                                        ?>
                                                        <input type="hidden" id="statusGo-<?= $rows["projects_id"] ?>" value="inactive">
                                                        <button type="button" class="btn btn-danger btn-block btn-xs" id="statusButton-<?= $rows["projects_id"] ?>">Closed </button>
                                                        <?php
                                                            endif;
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" id="work-flow-button-<?= $rows["projects_id"] ?>" class="work-flow-button btn btn-xs btn-warning mt-1 mb-1" title="Work Flow" style="width: 100px;">
                                                            <i class="fa fa-network-wired mr-1"></i> Work Flow
                                                        </button>
                                                    </td>
                                                </tr>
                                                <script>
                                                    //Activate Currect Option ----------------------------------------------------------
                                                    $("#statusButton-<?= $rows["projects_id"] ?>").click(function () {
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
                                                        });
                                                        function topEndNotification(theme, message){
                                                            Toast.fire({
                                                                icon: theme,
                                                                title: message
                                                            })
                                                        }
                                                        $("#statusButton-<?= $rows["projects_id"] ?>").prop('disabled', true);
                                                        $('#statusButton-<?= $rows["projects_id"] ?>').html('<center id = "information-loading"><img width="16px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
                                                        var statusGo = $("#statusGo-<?= $rows["projects_id"] ?>").val();
                                                        topEndNotification("info", "Please wait...");
                                                        var formData = new FormData();
                                                        formData.append("checkLocation", $("#checkLocation").val());
                                                        formData.append("checkIp", $("#checkIp").val());
                                                        formData.append("action", "changeProjectStatus");
                                                        formData.append("status", statusGo);
                                                        formData.append("projects_id", <?= $rows["projects_id"] ?>);
                                                        $.ajax({
                                                            url: 'application/controller/admin/work-flow.php',
                                                            type: 'POST',
                                                            data: formData,
                                                            dataType: "json",
                                                            success: function (data) {
                                                                if(data.response == "success"){
                                                                    setTimeout(function(){
                                                                        if(statusGo == "active"){
                                                                            topEndNotification("info", "Project Closed!!!");
                                                                            $("#statusButton-<?= $rows["projects_id"] ?>").prop('disabled', false);
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').html('Closed');
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').removeClass('btn-success');
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').addClass('btn-danger');
                                                                            $("#statusGo-<?= $rows["projects_id"] ?>").val("inactive");
                                                                        }
                                                                        else{
                                                                            topEndNotification("info", "Project Opened!!!");
                                                                            $("#statusButton-<?= $rows["projects_id"] ?>").prop('disabled', false);
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').html('Opened');
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').addClass('btn-success');
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').removeClass('btn-danger');
                                                                            $("#statusGo-<?= $rows["projects_id"] ?>").val("active");
                                                                        }
                                                                    }, 1000);
                                                                } else{
                                                                    setTimeout(function(){
                                                                        topEndNotification(data.responseType, data.responseMessage);
                                                                        if(statusGo == "active"){
                                                                            $("#statusButton-<?= $rows["projects_id"] ?>").prop('disabled', false);
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').html('Closed');
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').removeClass('btn-success');
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').addClass('btn-danger');
                                                                        }
                                                                        else{
                                                                            $("#statusButton-<?= $rows["projects_id"] ?>").prop('disabled', false);
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').html('Opened');
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').addClass('btn-success');
                                                                            $('#statusButton-<?= $rows["projects_id"] ?>').removeClass('btn-danger');
                                                                        }
                                                                    }, 1000);
                                                                }
                                                            },
                                                            cache: false,
                                                            contentType: false,
                                                            processData: false
                                                        });
                                                    });
                                                    // Work Flow Section Start ---------------------------------------------------------------
                                                    $("#work-flow-button-<?= $rows["projects_id"] ?>").click(function () {
                                                        $('#view-section').html('<center id = "work-flow-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                        $("#projects_id").val(<?= $rows["projects_id"] ?>);
                                                        var formData = {"action":"fetchWorkFlow","id":"<?= $rows["projects_id"] ?>"};
                                                        $.ajax({
                                                            url: 'application/view/admin/work-flow.php',
                                                            type: 'POST',
                                                            data: formData,
                                                            success: function (data) {
                                                                $('#work-flow-loading').fadeOut(500, function () {
                                                                    $(this).remove();
                                                                    $('#view-section').html(data);
                                                                    $('#add-button').prop('disabled', false);
                                                                    $('#import-button').prop('disabled', false);
                                                                    $('#back-button').prop('disabled', false);
                                                                    $('#back-button').removeClass('display-none');
                                                                    $("#show-who").html("<?= $projects_info->projectName ?>");
                                                                    $("#show-who").data("pre", "<?= $projects_info->projectName ?>");
                                                                });
                                                            }
                                                        });
                                                    });
                                                    // Work Flow Section End -----------------------------------------------------------------
                                                    
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
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                    <script src="dist/js/admin/for-all-tables.js"></script>
                <?php
                break;
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Work Flow Section Start ---------
            // ------------------------------------------------------
            case "fetchWorkFlow":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`work_flow_id` DESC");
                        $getData = $databaseObj->get();
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`projects_id` DESC");
                        $getDataProjects = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getDataProjects != 0):
                            foreach($getDataProjects as $rowsProjects):
                                $projects_info = json_decode($rowsProjects["projects_info"]);
                            endforeach;
                        endif;
                        //Checking If Data Is Available
                        if(!empty($projects_info->projectEndingDate)):
                        ?>
                            <div class="alert alert-danger alert-dismissible p-2 text-center">
                                <h5 class="mb-0">Note : This Project has been closed, and you are not able to add more works on it.</h5>
                            </div>
                        <?php
                        endif;
                        if(count($getData) != 0):
                            ?>
                            <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/projects.php">
                                <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_projects">
                                <input type="hidden" id="action" name="action" value="exportSelectedData">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <div class="icheck-navy d-inline">
                                                    <input type="checkbox" id="check-all" name="check-all" title="Check All" value="all" disabled>
                                                    <label for="check-all" title="Check All">
                                                    </label>
                                                </div>
                                            </th>
                                            <th>S. No.</th>
                                            <th>Main Work</th>
                                            <th>Starting Date/Time</th>
                                            <th>Expected Ending Date/Time</th>
                                            <th>Ending Date/Time</th>
                                            <th>Opened Works</th>
                                            <th>Closed Works</th>
                                            <th>Total Works</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sno = 1;
                                        $totalWork = 0;
                                        $complateOpened = 0;
                                        $complateClosed = 0;
                                        foreach($getData as $rows):
                                            $work_flow_info = json_decode($rows["work_flow_info"]);
                                            $work_flow_works = json_decode($rows["work_flow_works"]);
                                            $totalWork = $totalWork + intval(count($work_flow_works));
                                            $totalOpened = 0;
                                            $totalClosed = 0;
                                            foreach($work_flow_works as $work_flow_works_all):
                                                empty($work_flow_works_all->ending_date) ? $totalOpened++ : $totalClosed++;
                                            endforeach;
                                            $complateOpened = $complateOpened + $totalOpened;
                                            $complateClosed = $complateClosed + $totalClosed;
                                        ?>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="icheck-navy d-inline">
                                                        <input type="checkbox" id="checkbox-<?= $rows["work_flow_id"] ?>" name="checkbox-select[]" value="<?= $rows["work_flow_id"] ?>" class="check-table" disabled>
                                                        <label for="checkbox-<?= $rows["work_flow_id"] ?>">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><?= $sno ?>.</td>
                                                <?php 
                                                    $databaseObj->select("tbl_main_work_type");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `main_work_type_id` = '".$work_flow_info->main_work_type."'");
                                                    $databaseObj->order_by("`main_work_type_id` DESC");
                                                    $getDataMainWork = $databaseObj->get();
                                                    //Checking If Data Is Available
                                                    if(count($getDataMainWork) != 0):
                                                        foreach($getDataMainWork as $rowsMainWork):
                                                            $main_work_type_info = json_decode($rowsMainWork["main_work_type_info"]);
                                                        endforeach;
                                                    endif;
                                                ?>
                                                <td>
                                                    <div style="width: 200px;" class="text-bold">
                                                        <?= $main_work_type_info->main_work_type ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 200px;">
                                                        <?= "<kbd class='bg-info btn-block btn-sm text-center'>".date("d M, Y", strtotime($work_flow_info->starting_date))." / ".date("h:i A", strtotime($work_flow_info->starting_time))."</kbd>" ?></td>
                                                    </div>
                                                <td>
                                                    <div style="width: 200px;">
                                                        <?= "<kbd class='bg-warning btn-block btn-sm text-center'>".date("d M, Y", strtotime($work_flow_info->expected_ending_date))." / ".date("h:i A", strtotime($work_flow_info->expected_ending_time))."</kbd>" ?></td>
                                                    </div>
                                                <td>
                                                    <div style="width: 200px;">
                                                        <?php
                                                            if(empty($work_flow_info->ending_date)):
                                                        ?>
                                                        <kbd id='statusShow-<?= $rows["work_flow_id"] ?>' class='bg-success btn-block btn-sm text-center'>Not End</kbd>
                                                        <?php
                                                            else:
                                                        ?>
                                                        <?= "<kbd id='statusShow-".$rows["work_flow_id"]."' class='bg-danger btn-block btn-sm text-center'>".date("d M, Y", strtotime($work_flow_info->ending_date))." / ".date("h:i A", strtotime($work_flow_info->ending_time))."</kbd>" ?>
                                                        <?php
                                                            endif;
                                                        ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 100px;">
                                                        <kbd class='bg-warning btn-block btn-sm text-center'><?= $totalOpened ?></kbd>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 100px;">
                                                        <kbd class='bg-danger btn-block btn-sm text-center'><?= $totalClosed ?></kbd>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 100px;">
                                                        <kbd class='bg-warning btn-block btn-sm text-center'><?= count($work_flow_works) ?></kbd>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                        if(empty($work_flow_info->ending_date)):
                                                            $statusOrg = "active";
                                                    ?>
                                                    <input type="hidden" id="statusGo-<?= $rows["work_flow_id"] ?>" value="active">
                                                    <button type="button" class="btn btn-success btn-block btn-xs" id="statusButton-<?= $rows["work_flow_id"] ?>">Opened </button>
                                                    <?php
                                                        else:
                                                            $statusOrg = "inactive";
                                                    ?>
                                                    <input type="hidden" id="statusGo-<?= $rows["work_flow_id"] ?>" value="inactive">
                                                    <button type="button" class="btn btn-danger btn-block btn-xs" id="statusButton-<?= $rows["work_flow_id"] ?>">Closed </button>
                                                    <?php
                                                        endif;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <div style="width: 250px;">
                                                        <button type="button" id="work-flow-button-<?= $rows["work_flow_id"] ?>" class="work-flow-button btn btn-xs btn-warning" title="Work Flow" style="width: 100px;">
                                                            <i class="fa fa-network-wired mr-1"></i> Works
                                                        </button>
                                                        <button type="button" id="information-button-<?= $rows["work_flow_id"] ?>" class="information-button btn btn-xs btn-danger" title="Informations">
                                                            <i class="fa fa-scroll fa-sm"></i>
                                                        </button>
                                                        <button type="button" id="edit-button-<?= $rows["work_flow_id"] ?>" class="edit-button btn btn-xs btn-warning" title="Edit/Update">
                                                            <i class="fa fa-edit fa-sm"></i>
                                                        </button>
                                                        <button type="button" id="delete-button-<?= $rows["work_flow_id"] ?>" class="delete-button btn btn-xs btn-danger" title="Delete">
                                                            <i class="fa fa-trash fa-sm"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <script>
                                                // Work Flow Section Start ---------------------------------------------------------------
                                                $("#work-flow-button-<?= $rows["work_flow_id"] ?>").click(function () {
                                                    $('#add-button').prop('disabled', true);
                                                    $('#import-button').prop('disabled', true);
                                                    $('#back-button').prop('disabled', true);
                                                    $('#export-button').prop('disabled', true);
                                                    $('#delete-button').prop('disabled', true);
                                                    $('#view-section').html('<center id = "work-flow-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                    $("#work_main_work_type_id").val(<?= $rows["work_flow_id"] ?>);
                                                    var formData = {"action":"fetchWorkFlowFromMain","id":"<?= $rows["work_flow_id"] ?>"};
                                                    $.ajax({
                                                        url: 'application/view/admin/work-flow.php',
                                                        type: 'POST',
                                                        data: formData,
                                                        success: function (data) {
                                                            $('#work-flow-loading').fadeOut(500, function () {
                                                                $(this).remove();
                                                                $('#view-section').html(data);
                                                                $('#add-button').prop('disabled', false);
                                                                $('#import-button').prop('disabled', false);
                                                                $('#export-button').prop('disabled', false);
                                                                $('#delete-button').prop('disabled', false);
                                                                $('#add-button').attr('data-target', '#add-work-modal');
                                                                $('#import-button').attr('data-target', '#import-work-modal');
                                                                $('#export-button').attr('data-target', '#export-work-modal');
                                                                $('#delete-button').attr('data-target', '#delete-selected-work-modal');
                                                                $('#back-button').prop('disabled', false);
                                                                $('#back-button').removeClass('display-none');
                                                                $('#add-more-button').prop('disabled', false);
                                                                $('#add-more-button').removeClass('display-none');
                                                                $("#show-who").append(", <?= $main_work_type_info->main_work_type ?>");
                                                            });
                                                        }
                                                    });
                                                });
                                                // Work Flow Section End -----------------------------------------------------------------
                                                //Activate Currect Option ----------------------------------------------------------
                                                $("#statusButton-<?= $rows["work_flow_id"] ?>").click(function () {
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
                                                    });
                                                    function topEndNotification(theme, message){
                                                        Toast.fire({
                                                            icon: theme,
                                                            title: message
                                                        })
                                                    }
                                                    $("#statusButton-<?= $rows["work_flow_id"] ?>").prop('disabled', true);
                                                    $('#statusButton-<?= $rows["work_flow_id"] ?>').html('<center id = "information-loading"><img width="16px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
                                                    var statusGo = $("#statusGo-<?= $rows["work_flow_id"] ?>").val();
                                                    topEndNotification("info", "Please wait...");
                                                    var formData = new FormData();
                                                    formData.append("checkLocation", $("#checkLocation").val());
                                                    formData.append("checkIp", $("#checkIp").val());
                                                    formData.append("action", "changeOrgStatus");
                                                    formData.append("status", statusGo);
                                                    formData.append("work_flow_id", <?= $rows["work_flow_id"] ?>);
                                                    $.ajax({
                                                        url: 'application/controller/admin/work-flow.php',
                                                        type: 'POST',
                                                        data: formData,
                                                        dataType: "json",
                                                        success: function (data) {
                                                            if(data.response == "success"){
                                                                setTimeout(function(){
                                                                    if(statusGo == "active"){
                                                                        topEndNotification("info", "Main Work Closed!!!");
                                                                        $("#statusButton-<?= $rows["work_flow_id"] ?>").prop('disabled', false);
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').html('Closed');
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').removeClass('btn-success');
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').addClass('btn-danger');
                                                                        $('#statusShow-<?= $rows["work_flow_id"] ?>').html(data.returnStatus);
                                                                        $('#statusShow-<?= $rows["work_flow_id"] ?>').addClass('bg-danger');
                                                                        $('#statusShow-<?= $rows["work_flow_id"] ?>').removeClass('bg-success');
                                                                        $("#statusGo-<?= $rows["work_flow_id"] ?>").val("inactive");
                                                                    }
                                                                    else{
                                                                        topEndNotification("info", "Main Work Opened!!!");
                                                                        $("#statusButton-<?= $rows["work_flow_id"] ?>").prop('disabled', false);
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').html('Opened');
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').addClass('btn-success');
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').removeClass('btn-danger');
                                                                        $('#statusShow-<?= $rows["work_flow_id"] ?>').html(data.returnStatus);
                                                                        $('#statusShow-<?= $rows["work_flow_id"] ?>').addClass('bg-success');
                                                                        $('#statusShow-<?= $rows["work_flow_id"] ?>').removeClass('bg-danger');
                                                                        $("#statusGo-<?= $rows["work_flow_id"] ?>").val("active");
                                                                    }
                                                                }, 1000);
                                                            } else{
                                                                setTimeout(function(){
                                                                    topEndNotification(data.responseType, data.responseMessage);
                                                                    if(statusGo == "active"){
                                                                        $("#statusButton-<?= $rows["work_flow_id"] ?>").prop('disabled', false);
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').html('Closed');
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').removeClass('btn-success');
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').addClass('btn-danger');
                                                                    }
                                                                    else{
                                                                        $("#statusButton-<?= $rows["work_flow_id"] ?>").prop('disabled', false);
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').html('Opened');
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').addClass('btn-success');
                                                                        $('#statusButton-<?= $rows["work_flow_id"] ?>').removeClass('btn-danger');
                                                                    }
                                                                }, 1000);
                                                            }
                                                        },
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false
                                                    });
                                                });
                                                // Information Section Start ---------------------------------------------------------------
                                                $("#information-button-<?= $rows["work_flow_id"] ?>").click(function () {
                                                    $("#information-modal").modal('show');
                                                    $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                    var formData = {"action":"fetchInformation","id":"<?= $rows["work_flow_id"] ?>"};
                                                    $.ajax({
                                                        url: 'application/view/admin/work-flow.php',
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
                                                // Edit Section Start ---------------------------------------------------------------
                                                $("#edit-button-<?= $rows["work_flow_id"] ?>").click(function () {
                                                    $("#edit-modal").modal('show');
                                                    $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                    var formData = {"action":"fetchEdit","id":"<?= $rows["work_flow_id"] ?>"};
                                                    $.ajax({
                                                        url: 'application/view/admin/work-flow.php',
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
                                                $("#delete-button-<?= $rows["work_flow_id"] ?>").click(function () {
                                                    $("#delete-modal").modal('show');
                                                    $('#deleteButton').prop('disabled', true);
                                                    $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                    var formData = {"action":"fetchDelete","id":"<?= $rows["work_flow_id"] ?>"};
                                                    $.ajax({
                                                        url: 'application/view/admin/work-flow.php',
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
                                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>
                                                <div style="width: 100px;">
                                                    <kbd class='bg-warning btn-block btn-sm text-center'><?= $complateOpened ?></kbd>
                                                </div>
                                            </th>
                                            <th>
                                                <div style="width: 100px;">
                                                    <kbd class='bg-danger btn-block btn-sm text-center'><?= $complateClosed ?></kbd>
                                                </div>
                                            </th>
                                            <th>
                                                <div style="width: 100px;">
                                                    <kbd class='bg-warning btn-block btn-sm text-center'><?= $totalWork ?></kbd>
                                                </div>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                            <script src="dist/js/admin/for-all-tables.js"></script>
                            <?php
                        else:
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Empty!</h5>
                                No Main Works Added Now on this Project.
                            </div>
                            <?php
                        endif;
                        if(!empty($projects_info->projectEndingDate)):
                        ?>
                            <script>
                                setTimeout(function(){
                                    $(".add-button, .edit-button, .delete-button, .import-button").prop("disabled", true);
                                }, 500);
                            </script>
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
            case "fetchWorkFlowFromMain":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`work_flow_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if(count($getData) != 0):
                            foreach($getData as $rows):
                                $work_flow_info = json_decode($rows["work_flow_info"]);
                                $work_flow_works = json_decode($rows["work_flow_works"]);
                                $databaseObj->select("tbl_projects");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$rows["projects_id"]."'");
                                $databaseObj->order_by("`projects_id` DESC");
                                $getDataProjects = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getDataProjects != 0):
                                    foreach($getDataProjects as $rowsProjects):
                                        $projects_info = json_decode($rowsProjects["projects_info"]);
                                    endforeach;
                                endif;
                                //Checking If Data Is Available
                                if(!empty($projects_info->projectEndingDate)):
                                ?>
                                    <div class="alert alert-danger alert-dismissible p-2 text-center">
                                        <h5 class="mb-0">Note : This Project has been closed, and you are not able to add more works on it.</h5>
                                    </div>
                                <?php
                                endif;
                                if(!empty($work_flow_info->ending_date)):
                                ?>
                                    <div class="alert alert-danger alert-dismissible p-2 text-center">
                                        <h5 class="mb-0">Note : This Work has been closed, and you are not able to add more works on it.</h5>
                                    </div>
                                <?php
                                endif;
                                if(count($work_flow_works) > 0):
                                    ?>
                                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/projects.php">
                                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_projects">
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
                                                    <th>Work</th>
                                                    <th>Starting Date/Time</th>
                                                    <th>Expected Ending Date/Time</th>
                                                    <th>Ending Date/Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $sno = 1;
                                                foreach($work_flow_works as $work_flow_works_all):
                                                ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="icheck-navy d-inline">
                                                                <input type="checkbox" id="checkbox-<?= $work_flow_works_all->work_type_id ?>" name="checkbox-select[]" value="<?= $work_flow_works_all->work_type_id ?>" class="check-table">
                                                                <label for="checkbox-<?= $work_flow_works_all->work_type_id ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= $sno ?>.</td>
                                                        <?php 
                                                            $databaseObj->select("tbl_work_type");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `work_type_id` = '".$work_flow_works_all->work_type."'");
                                                            $databaseObj->order_by("`work_type_id` DESC");
                                                            $getDataWork = $databaseObj->get();
                                                            //Checking If Data Is Available
                                                            if(count($getDataWork) != 0):
                                                                foreach($getDataWork as $rowsWork):
                                                                    $work_type_info = json_decode($rowsWork["work_type_info"]);
                                                                endforeach;
                                                            endif;
                                                        ?>
                                                        <td>
                                                            <div style="width: 200px;" class="text-bold">
                                                                <?= $work_type_info->work_type ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="width: 200px;">
                                                                <?= "<kbd class='bg-info btn-block btn-sm text-center'>".date("d M, Y", strtotime($work_flow_works_all->starting_date))." / ".date("h:i A", strtotime($work_flow_works_all->starting_time))."</kbd>" ?></td>
                                                            </div>
                                                        <td>
                                                            <div style="width: 200px;">
                                                                <?= "<kbd class='bg-warning btn-block btn-sm text-center'>".date("d M, Y", strtotime($work_flow_works_all->expected_ending_date))." / ".date("h:i A", strtotime($work_flow_works_all->expected_ending_time))."</kbd>" ?></td>
                                                            </div>
                                                        <td>
                                                            <div style="width: 200px;">
                                                                <?php
                                                                    if(empty($work_flow_works_all->ending_date)):
                                                                ?>
                                                                <kbd id='statusShow-<?= $work_flow_works_all->work_type_id ?>' class='bg-success btn-block btn-sm text-center'>Not End</kbd>
                                                                <?php
                                                                    else:
                                                                ?>
                                                                <?= "<kbd id='statusShow-".$work_flow_works_all->work_type_id."' class='bg-danger btn-block btn-sm text-center'>".date("d M, Y", strtotime($work_flow_works_all->ending_date))." / ".date("h:i A", strtotime($work_flow_works_all->ending_time))."</kbd>" ?>
                                                                <?php
                                                                    endif;
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td><?php
                                                                if(empty($work_flow_works_all->ending_date)):
                                                                    $statusOrg = "active";
                                                            ?>
                                                            <input type="hidden" id="statusGo-<?= $work_flow_works_all->work_type_id ?>" value="active">
                                                            <button type="button" class="btn btn-success btn-block btn-xs" id="statusButton-<?= $work_flow_works_all->work_type_id ?>">Opened </button>
                                                            <?php
                                                                else:
                                                                    $statusOrg = "inactive";
                                                            ?>
                                                            <input type="hidden" id="statusGo-<?= $work_flow_works_all->work_type_id ?>" value="inactive">
                                                            <button type="button" class="btn btn-danger btn-block btn-xs" id="statusButton-<?= $work_flow_works_all->work_type_id ?>">Closed </button>
                                                            <?php
                                                                endif;
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div style="width: 100px;">
                                                                <button type="button" id="edit-button-<?= $work_flow_works_all->work_type_id ?>" class="edit-button btn btn-xs btn-warning" title="Edit/Update">
                                                                    <i class="fa fa-edit fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="delete-button-<?= $work_flow_works_all->work_type_id ?>" class="delete-button btn btn-xs btn-danger" title="Delete">
                                                                    <i class="fa fa-trash fa-sm"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        //Activate Currect Option Start ----------------------------------------------------------
                                                        $("#statusButton-<?= $work_flow_works_all->work_type_id ?>").click(function () {
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
                                                            });
                                                            function topEndNotification(theme, message){
                                                                Toast.fire({
                                                                    icon: theme,
                                                                    title: message
                                                                })
                                                            }
                                                            $("#statusButton-<?= $work_flow_works_all->work_type_id ?>").prop('disabled', true);
                                                            $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').html('<center id = "information-loading"><img width="16px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
                                                            var statusGo = $("#statusGo-<?= $work_flow_works_all->work_type_id ?>").val();
                                                            topEndNotification("info", "Please wait...");
                                                            var formData = new FormData();
                                                            formData.append("checkLocation", $("#checkLocation").val());
                                                            formData.append("checkIp", $("#checkIp").val());
                                                            formData.append("action", "changeOrgStatusWork");
                                                            formData.append("status", statusGo);
                                                            formData.append("work_type_id", <?= $work_flow_works_all->work_type_id ?>);
                                                            formData.append("work_flow_id", <?= $rows["work_flow_id"] ?>);
                                                            $.ajax({
                                                                url: 'application/controller/admin/work-flow.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                dataType: "json",
                                                                success: function (data) {
                                                                    if(data.response == "success"){
                                                                        setTimeout(function(){
                                                                            if(statusGo == "active"){
                                                                                topEndNotification("info", "Main Work Closed!!!");
                                                                                $("#statusButton-<?= $work_flow_works_all->work_type_id ?>").prop('disabled', false);
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').html('Closed');
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').removeClass('btn-success');
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').addClass('btn-danger');
                                                                                $('#statusShow-<?= $work_flow_works_all->work_type_id ?>').html(data.returnStatus);
                                                                                $('#statusShow-<?= $work_flow_works_all->work_type_id ?>').addClass('bg-danger');
                                                                                $('#statusShow-<?= $work_flow_works_all->work_type_id ?>').removeClass('bg-success');
                                                                                $("#statusGo-<?= $work_flow_works_all->work_type_id ?>").val("inactive");
                                                                            }
                                                                            else{
                                                                                topEndNotification("info", "Main Work Opened!!!");
                                                                                $("#statusButton-<?= $work_flow_works_all->work_type_id ?>").prop('disabled', false);
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').html('Opened');
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').addClass('btn-success');
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').removeClass('btn-danger');
                                                                                $('#statusShow-<?= $work_flow_works_all->work_type_id ?>').html(data.returnStatus);
                                                                                $('#statusShow-<?= $work_flow_works_all->work_type_id ?>').addClass('bg-success');
                                                                                $('#statusShow-<?= $work_flow_works_all->work_type_id ?>').removeClass('bg-danger');
                                                                                $("#statusGo-<?= $work_flow_works_all->work_type_id ?>").val("active");
                                                                            }
                                                                        }, 1000);
                                                                    } else{
                                                                        setTimeout(function(){
                                                                            topEndNotification(data.responseType, data.responseMessage);
                                                                            if(statusGo == "active"){
                                                                                $("#statusButton-<?= $work_flow_works_all->work_type_id ?>").prop('disabled', false);
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').html('Closed');
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').removeClass('btn-success');
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').addClass('btn-danger');
                                                                            }
                                                                            else{
                                                                                $("#statusButton-<?= $work_flow_works_all->work_type_id ?>").prop('disabled', false);
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').html('Opened');
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').addClass('btn-success');
                                                                                $('#statusButton-<?= $work_flow_works_all->work_type_id ?>').removeClass('btn-danger');
                                                                            }
                                                                        }, 1000);
                                                                    }
                                                                },
                                                                cache: false,
                                                                contentType: false,
                                                                processData: false
                                                            });
                                                        });
                                                        //Activate Currect Option End ----------------------------------------------------------
                                                        // Edit Section Start ---------------------------------------------------------------
                                                        $("#edit-button-<?= $work_flow_works_all->work_type_id ?>").click(function () {
                                                            $("#edit-work-modal").modal('show');
                                                            $('#edit-work-section').html('<center id = "edit-work-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchWorkEdit","work_flow_id":"<?= $rows["work_flow_id"] ?>","work_type_id":"<?= $work_flow_works_all->work_type_id ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/work-flow.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#edit-work-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#edit-work-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Edit Section End -----------------------------------------------------------------
                                                        // Delete Section Start ---------------------------------------------------------------
                                                        $("#delete-button-<?= $work_flow_works_all->work_type_id ?>").click(function () {
                                                            $("#delete-work-modal").modal('show');
                                                            $('#deleteButton').prop('disabled', true);
                                                            $('#delete-work-section').html('<center id = "delete-work-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchWorkDelete","work_flow_id":"<?= $rows["work_flow_id"] ?>","work_type_id":"<?= $work_flow_works_all->work_type_id ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/work-flow.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#delete-work-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#delete-work-section').html(data);
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
                                    <script src="dist/js/admin/for-all-tables.js"></script>
                                    <?php
                                else:
                                    ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-ban"></i> Empty!</h5>
                                        No Works Added Now on this Main Work.
                                    </div>
                                    <?php
                                endif;
                                if(!empty($projects_info->projectEndingDate)):
                                ?>
                                    <script>
                                        setTimeout(function(){
                                            $(".add-button, .edit-button, .delete-button, .import-button").prop("disabled", true);
                                        }, 500);
                                    </script>
                                <?php
                                endif;
                                if(!empty($work_flow_info->ending_date)):
                                ?>
                                    <script>
                                        setTimeout(function(){
                                            $(".add-button, .edit-button, .delete-button, .import-button").prop("disabled", true);
                                        }, 500);
                                    </script>
                                <?php
                                endif;
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
            case "fetchMainWorkType":
                $databaseObj->select("tbl_main_work_type");
                $databaseObj->where("`status` = '".$auth->visible()."'");
                $getData = $databaseObj->get();
                //Checking If Data Is Available
                if(count($getData) != 0):
                    $sno = 1;
                    foreach($getData as $rows):
                        $main_work_type_info = json_decode($rows["main_work_type_info"]);
                        ?>
                            <option value="<?= $rows["main_work_type_id"] ?>"><?= $main_work_type_info->main_work_type ?></option>
                        <?php
                    endforeach;
                endif;
                break;
            case "fetchWorkType":
                $databaseObj->select("tbl_work_type");
                $databaseObj->where("`status` = '".$auth->visible()."'");
                $getData = $databaseObj->get();
                //Checking If Data Is Available
                if(count($getData) != 0):
                    $sno = 1;
                    foreach($getData as $rows):
                        $work_type_info = json_decode($rows["work_type_info"]);
                        ?>
                            <option value="<?= $rows["work_type_id"] ?>"><?= $work_type_info->work_type ?></option>
                        <?php
                    endforeach;
                endif;
                break;
            // ------------------------------------------------------
            // ------------ Fetch Work Flow Section End -----------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchInformation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`work_flow_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $work_flow_log = json_decode($rows["work_flow_log"]);
                                ?>
                                    <div class="row">
                                        <?php
                                            $sno = 1;
                                            foreach($work_flow_log as $work_flow_log_info):
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($work_flow_log_info->action) ?> By</a></li>
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($work_flow_log_info->action) ?> By - 
                                                                    <?php
                                                                        if($work_flow_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$work_flow_log_info->by."'");
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
                                                                    <?= date("l, M d, Y", strtotime($work_flow_log_info->date)) ?> At <?= $work_flow_log_info->at ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                                    <?= $work_flow_log_info->ip ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                                    <?php
                                                                        $latLangArray = explode(",", $work_flow_log_info->location);
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
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $work_flow_info = json_decode($rows["work_flow_info"]);
                                ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Building</h5>
                                                    <?= $work_flow_info->work_flow ?>
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
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $work_flow_info = json_decode($rows["work_flow_info"]);
                                if(empty($work_flow_info->ending_date)):
                                ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="edit_main_work_type">Main Work Type</label>
                                                <select id="edit_main_work_type" name="edit_main_work_type" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                    <option disabled selected>Select</option>
                                                    <?php 
                                                        $databaseObj->select("tbl_main_work_type");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getDataMainWork = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if(count($getDataMainWork) != 0):
                                                            $sno = 1;
                                                            foreach($getDataMainWork as $rowsMainWork):
                                                                $main_work_type_info = json_decode($rowsMainWork["main_work_type_info"]);
                                                                ?>
                                                                    <option value="<?= $rowsMainWork["main_work_type_id"] ?>" <?php if($rowsMainWork["main_work_type_id"] == $work_flow_info->main_work_type) echo "selected" ?>><?= $main_work_type_info->main_work_type ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit_main_work_type_starting_date">Starting Date</label>
                                                <input type="date" class="form-control" id="edit_main_work_type_starting_date" name="edit_main_work_type_starting_date" value="<?= $work_flow_info->starting_date ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit_main_work_type_starting_time">Starting Time</label>
                                                <input type="time" class="form-control" id="edit_main_work_type_starting_time" name="edit_main_work_type_starting_time" value="<?= $work_flow_info->starting_time ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit_main_work_type_expected_ending_date">Expected Ending Date</label>
                                                <input type="date" class="form-control" id="edit_main_work_type_expected_ending_date" name="edit_main_work_type_expected_ending_date" value="<?= $work_flow_info->expected_ending_date ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit_main_work_type_expected_ending_time">Expected Ending Time</label>
                                                <input type="time" class="form-control" id="edit_main_work_type_expected_ending_time" name="edit_main_work_type_expected_ending_time" value="<?= $work_flow_info->expected_ending_time ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit_main_work_type_ending_date">Ending Date</label>
                                                <input type="date" class="form-control" id="edit_main_work_type_ending_date" name="edit_main_work_type_ending_date" value="<?= $work_flow_info->ending_date ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit_main_work_type_ending_time">Ending Time</label>
                                                <input type="time" class="form-control" id="edit_main_work_type_ending_time" name="edit_main_work_type_ending_time" value="<?= $work_flow_info->ending_time ?>" readonly />
                                            </div>
                                        </div>
                                        <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                    </div>
                                    <script>
                                        $("#editButton").show();
                                    </script>
                                <?php
                                else:
                                    ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5>Work Closed!</h5>
                                        Now you are not able to Edit this Work.
                                    </div>
                                    <script>
                                        $("#editButton").hide();
                                    </script>
                                    <?php
                                endif;
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
            case "fetchWorkEdit":
                if($authority == 1):
                    if(isset($_POST["work_flow_id"]) && !empty($_POST["work_flow_id"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["work_flow_id"]."'");
                        $getData = $databaseObj->get();
                        // Checking If Data Is Available
                        // work_flow_id
                        // work_type_id
                        if($getData != 0):
                            foreach($getData as $rows):
                                $work_flow_info = json_decode($rows["work_flow_info"]);
                                $work_flow_works = json_decode($rows["work_flow_works"]);
                                if(empty($work_flow_info->ending_date)):
                                    if(count($work_flow_works) > 0):
                                        $works_all = false;
                                        foreach($work_flow_works as $work_flow_works_all):
                                            if(intval($work_flow_works_all->work_type_id) == intval($_POST["work_type_id"])):
                                                $works_all = $work_flow_works_all;
                                                break;
                                            endif;
                                        endforeach;
                                        if($works_all != false):
                                        ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="edit_work_type">Work Type</label>
                                                        <select id="edit_work_type" name="edit_work_type" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option disabled selected>Select</option>
                                                            <?php 
                                                                $databaseObj->select("tbl_work_type");
                                                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                $getData = $databaseObj->get();
                                                                //Checking If Data Is Available
                                                                if(count($getData) != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rows):
                                                                        $work_type_info = json_decode($rows["work_type_info"]);
                                                                        ?>
                                                                            <option <?php if($works_all->work_type == $rows["work_type_id"]) echo "selected"; ?> value="<?= $rows["work_type_id"] ?>"><?= $work_type_info->work_type ?></option>
                                                                        <?php
                                                                    endforeach;
                                                                endif;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit_work_type_starting_date">Starting Date</label>
                                                        <input type="date" class="form-control" id="edit_work_type_starting_date" name="edit_work_type_starting_date" value="<?= $works_all->starting_date ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit_work_type_starting_time">Starting Time</label>
                                                        <input type="time" class="form-control" id="edit_work_type_starting_time" name="edit_work_type_starting_time" value="<?= $works_all->starting_time ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit_work_type_expected_ending_date">Expected Ending Date</label>
                                                        <input type="date" class="form-control" id="edit_work_type_expected_ending_date" name="edit_work_type_expected_ending_date" value="<?= $works_all->expected_ending_date ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit_work_type_expected_ending_time">Expected Ending Time</label>
                                                        <input type="time" class="form-control" id="edit_work_type_expected_ending_time" name="edit_work_type_expected_ending_time" value="<?= $works_all->expected_ending_time ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit_work_type_ending_date">Ending Date</label>
                                                        <input type="date" class="form-control" id="edit_work_type_ending_date" name="edit_work_type_ending_date" readonly value="<?= $works_all->ending_date ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit_work_type_ending_time">Ending Time</label>
                                                        <input type="time" class="form-control" id="edit_work_type_ending_time" name="edit_work_type_ending_time" readonly value="<?= $works_all->ending_time ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="card card-navy">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Item Information</h3>
                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <div class="row">
                                                                <div class="col-md-12 table-responsive">
                                                                    <input type="hidden" id="editTotalItemInfo" name="editTotalItemInfo" value="<?= count($works_all->items) ?>">
                                                                    <table class="table table-bordered" id="dynamic_field_edit">
                                                                        <thead>
                                                                            <tr>
                                                                                <th data-field="S. No." data-sortable="true">S.No.</th>
                                                                                <th data-field="Item Type" data-sortable="true">Item Type</th>
                                                                                <th data-field="Unit" data-sortable="true">Unit</th>
                                                                                <th data-field="Quantity" data-sortable="true">Quantity</th>
                                                                                <th data-field="Rate" data-sortable="true">Rate</th>
                                                                                <th data-field="Amount" data-sortable="true">Amount</th>
                                                                                <th data-field="A (Material)" data-sortable="true">A (Material)</th>
                                                                                <th data-field="B (Labour)" data-sortable="true">B (Labour)</th>
                                                                                <th data-field="Remarks" data-sortable="true">Remarks</th>
                                                                                <th>Actions</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                $snoTemp = 0;
                                                                                $totalA = 0;
                                                                                $totalB = 0;
                                                                                $totalAandB = 0;
                                                                                foreach($works_all->items as $itemsAll):
                                                                                    $snoTemp++;
                                                                                    $totalA = $totalA + intval($itemsAll->a);
                                                                                    $totalB = $totalB + intval($itemsAll->b);
                                                                                    $totalAandB = $totalAandB + intval($itemsAll->amount);
                                                                            ?>
                                                                            <tr id="row<?= $snoTemp ?>_edit">
                                                                                <td>
                                                                                    <span class="p-3 mt-2"><?= $snoTemp ?>.</span>
                                                                                </td>
                                                                                <td>
                                                                                    <select id="editItemInfoItemType<?= $snoTemp ?>" name="editItemInfoItemType[]" class="form-control select2 select2-navy item-type-all calculate-edited-amount" data-dropdown-css-class="select2-navy" style="width:200px;">
                                                                                        <option disabled selected>Select</option>
                                                                                        <?php 
                                                                                            $databaseObj->select("tbl_item_type");
                                                                                            $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                            $getData = $databaseObj->get();
                                                                                            //Checking If Data Is Available
                                                                                            if($getData != 0):
                                                                                                foreach($getData as $rows):
                                                                                                    $item_type_info = json_decode($rows["item_type_info"]);
                                                                                                    ?>
                                                                                                        <option <?php if($itemsAll->item_type == $rows["item_type_id"]) echo "selected"; ?> data-ab="<?= $item_type_info->item_type_ab ?>" value="<?= $rows["item_type_id"] ?>"><?= $item_type_info->item_type ?></option>
                                                                                                    <?php
                                                                                                endforeach;
                                                                                            endif;
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select id="editItemInfoUnitType<?= $snoTemp ?>" name="editItemInfoUnitType[]" class="form-control select2 select2-navy unit-type-all calculate-edited-amount" data-dropdown-css-class="select2-navy" style="width:150px;">
                                                                                        <option disabled selected>Select</option>
                                                                                        <?php 
                                                                                            $databaseObj->select("tbl_unit_type");
                                                                                            $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                            $getData = $databaseObj->get();
                                                                                            //Checking If Data Is Available
                                                                                            if($getData != 0):
                                                                                                foreach($getData as $rows):
                                                                                                    $unit_type_info = json_decode($rows["unit_type_info"]);
                                                                                                    ?>
                                                                                                        <option <?php if($itemsAll->unit_type == $rows["unit_type_id"]) echo "selected"; ?> value="<?= $rows["unit_type_id"] ?>"><?= $unit_type_info->unit_type ?></option>
                                                                                                    <?php
                                                                                                endforeach;
                                                                                            endif;
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input id="editItemInfoQuantity<?= $snoTemp ?>" name="editItemInfoQuantity[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount"  style="width:200px;" value="<?= floatval($itemsAll->quantity) ?>" />
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group mb-0">
                                                                                        <div class="input-group" style="width:200px;">
                                                                                            <div class="input-group-prepend">
                                                                                                <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                            </div>
                                                                                            <input id="editItemInfoRate<?= $snoTemp ?>" name="editItemInfoRate[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount" value="<?= floatval($itemsAll->rate) ?>" />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group mb-0">
                                                                                        <div class="input-group" style="width:200px;">
                                                                                            <div class="input-group-prepend">
                                                                                                <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                            </div>
                                                                                            <input id="editItemInfoAmount<?= $snoTemp ?>" name="editItemInfoAmount[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly value="<?= floatval($itemsAll->amount) ?>" />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group mb-0">
                                                                                        <div class="input-group" style="width:200px;">
                                                                                            <div class="input-group-prepend">
                                                                                                <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                            </div>
                                                                                            <input id="editItemInfoMaterial<?= $snoTemp ?>" name="editItemInfoMaterial[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly value="<?= floatval($itemsAll->a) ?>" />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group mb-0">
                                                                                        <div class="input-group" style="width:200px;">
                                                                                            <div class="input-group-prepend">
                                                                                                <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                            </div>
                                                                                            <input id="editItemInfoLabour<?= $snoTemp ?>" name="editItemInfoLabour[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly value="<?= floatval($itemsAll->b) ?>" />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <input id="editItemInfoRemarks<?= $snoTemp ?>" name="editItemInfoRemarks[]" type="text" class="form-control calculate-edited-amount" style="width:200px;" value="<?= $itemsAll->remarks ?>" />
                                                                                </td>
                                                                                <td>
                                                                                    <?php 
                                                                                        if($snoTemp == 1):
                                                                                    ?>
                                                                                            <button type="button" name="add_edit" id="add_edit" class="btn btn-warning calculate-edited-amount"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                                    <?php 
                                                                                        else:
                                                                                    ?>
                                                                                            <button type="button" name="remove" id="<?= $snoTemp ?>_edit" class="btn btn-danger  btn_remove_edit calculate-edited-amount">X</button>
                                                                                    <?php
                                                                                        endif;
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php 
                                                                                endforeach;
                                                                            ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th></th>
                                                                                <th></th>
                                                                                <th></th>
                                                                                <th></th>
                                                                                <th></th>
                                                                                <th>
                                                                                    <div class="form-group mb-0">
                                                                                        <div class="input-group" style="width:200px;">
                                                                                            <div class="input-group-prepend">
                                                                                                <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                            </div>
                                                                                            <input id="editItemInfoTotalAmount" name="editItemInfoTotalAmount" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly value="<?= $totalAandB ?>" />
                                                                                        </div>
                                                                                    </div>
                                                                                </th>
                                                                                <th>
                                                                                    <div class="form-group mb-0">
                                                                                        <div class="input-group" style="width:200px;">
                                                                                            <div class="input-group-prepend">
                                                                                                <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                            </div>
                                                                                            <input id="editItemInfoTotalA" name="editItemInfoTotalA" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly value="<?= $totalA ?>" />
                                                                                        </div>
                                                                                    </div>
                                                                                </th>
                                                                                <th>
                                                                                    <div class="form-group mb-0">
                                                                                        <div class="input-group" style="width:200px;">
                                                                                            <div class="input-group-prepend">
                                                                                                <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                            </div>
                                                                                            <input id="editItemInfoTotalB" name="editItemInfoTotalB" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly value="<?= $totalB ?>" />
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="editTableId" value="<?= $_POST["work_flow_id"] ?>" />
                                                <input type="hidden" name="work_type_id" value="<?= $_POST["work_type_id"] ?>" />
                                            </div>
                                            <script>
                                                $(function(){
                                                    //Multiple Rows Section Start ----------------------------------------------------------------------------------   
                                                    var theCount = Number($("#editTotalItemInfo").val());
                                                    
                                                    $('#add_edit').click(function(){
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
                                                        var temp_flag = 1;
                                                        var temp_error = 1;
                                                        for(j = 1; j <= Number($("#editTotalItemInfo").val()); j++){
                                                            if($("#editItemInfoItemType"+j).val() == null){
                                                                $("#editItemInfoItemType"+j).addClass("is-invalid");
                                                                temp_flag = 0;
                                                                temp_error = "Please complete required fields!!!";
                                                            }else
                                                                $("#editItemInfoItemType"+j).removeClass("is-invalid");
                                                            if($("#editItemInfoUnitType"+j).val() == null){
                                                                $("#editItemInfoUnitType"+j).addClass("is-invalid");
                                                                temp_flag = 0;
                                                                temp_error = "Please complete required fields!!!";
                                                            }else
                                                                $("#editItemInfoUnitType"+j).removeClass("is-invalid");
                                                            if($("#editItemInfoQuantity"+j).val() == ""){
                                                                $("#editItemInfoQuantity"+j).addClass("is-invalid");
                                                                temp_flag = 0;
                                                                temp_error = "Please complete required fields!!!";
                                                            }else
                                                                $("#editItemInfoQuantity"+j).removeClass("is-invalid");
                                                            if($("#editItemInfoRate"+j).val() == ""){
                                                                $("#editItemInfoRate"+j).addClass("is-invalid");
                                                                temp_flag = 0;
                                                                temp_error = "Please complete required fields!!!";
                                                            }else
                                                                $("#editItemInfoRate"+j).removeClass("is-invalid");
                                                            if($("#editItemInfoAmount"+j).val() == ""){
                                                                $("#editItemInfoAmount"+j).addClass("is-warning");
                                                                temp_flag = 0;
                                                                temp_error = "Please complete required fields!!!";
                                                            }else
                                                                $("#editItemInfoAmount"+j).removeClass("is-warning");
                                                            if($("#editItemInfoMaterial"+j).val() == "" && $("#editItemInfoLabour"+j).val() == ""){
                                                                $("#editItemInfoMaterial"+j).addClass("is-warning");
                                                                $("#editItemInfoLabour"+j).addClass("is-warning");
                                                                temp_flag = 0;
                                                                temp_error = "Please complete required fields!!!";
                                                            }else{
                                                                $("#editItemInfoMaterial"+j).removeClass("is-warning");
                                                                $("#editItemInfoLabour"+j).removeClass("is-warning");
                                                            } 
                                                        }
                                                        if(temp_flag == 1){
                                                            theCount++; 
                                                            $('#dynamic_field_edit').append('<tr id="row'+theCount+'_edit" class="dynamic-added" ><td><span class="p-3 mt-2">'+theCount+'.</span></td> <td> <select id="editItemInfoItemType'+theCount+'" name="editItemInfoItemType[]" class="form-control select2 select2-navy item-type-all calculate-edited-amount" data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select</option> <?php  $databaseObj->select("tbl_item_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $item_type_info = json_decode($rows["item_type_info"]); ?> <option data-ab="<?= $item_type_info->item_type_ab ?>" value="<?= $rows["item_type_id"] ?>"><?= $item_type_info->item_type ?></option> <?php endforeach; endif; ?> </select> </td> <td> <select id="editItemInfoUnitType'+theCount+'" name="editItemInfoUnitType[]" class="form-control select2 select2-navy unit-type-all calculate-edited-amount" data-dropdown-css-class="select2-navy" style="width:150px;"> <option disabled selected>Select</option> <?php  $databaseObj->select("tbl_unit_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $unit_type_info = json_decode($rows["unit_type_info"]); ?> <option value="<?= $rows["unit_type_id"] ?>"><?= $unit_type_info->unit_type ?></option> <?php endforeach; endif; ?> </select> </td> <td> <input id="editItemInfoQuantity'+theCount+'" name="editItemInfoQuantity[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount"  style="width:200px;" /> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="editItemInfoRate'+theCount+'" name="editItemInfoRate[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount" /> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="editItemInfoAmount'+theCount+'" name="editItemInfoAmount[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly /> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="editItemInfoMaterial'+theCount+'" name="editItemInfoMaterial[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly /> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="editItemInfoLabour'+theCount+'" name="editItemInfoLabour[]" type="number" min="0.00" step=any class="form-control calculate-edited-amount" readonly /> </div> </div> </td> <td> <input id="editItemInfoRemarks'+theCount+'" name="editItemInfoRemarks[]" type="text" class="form-control calculate-edited-amount" style="width:200px;" /> </td> <td><button type="button" name="remove" id="'+theCount+'_edit" class="btn btn-danger btn_remove_edit calculate-edited-amount">X</button></td></tr>');
                                                            $('.select2').select2();
                                                            $("#editTotalItemInfo").val(theCount);
                                                        } else{
                                                            topEndNotification("warning", temp_error);
                                                        }
                                                    });
                                                    $(document).on('click', '.btn_remove_edit', function(){  
                                                        // console.log($(this).attr("id"));
                                                        var button_id = $(this).attr("id");   
                                                        $('#row'+button_id+'').remove(); 
                                                        theCount--;
                                                        // console.log(theCount);
                                                        $("#editTotalItemInfo").val(theCount);
                                                    }); 
                                                    //Multiple Rows Section End ------------------------------------------------------------------------------------
                                                    // Calculate Percentage Section Start -------------------------------------------------------------------- 
                                                    $(document).on('click keyup change', '.calculate-edited-amount', function(){
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
                                                        var editItemInfoTotalAmount = 0.00;
                                                        var editItemInfoTotalA = 0.00;
                                                        var editItemInfoTotalB = 0.00;
                                                        var flag = 1;
                                                        var totalRows = $("#editTotalItemInfo").val();
                                                        for(i = 1; i <= totalRows; i++){
                                                            var item_type_ab = $("#editItemInfoItemType" + i).find(':selected').data('ab');
                                                            var amount = Number($("#editItemInfoQuantity" + i).val()) * Number($("#editItemInfoRate" + i).val());
                                                            $("#editItemInfoAmount" + i).val(amount);
                                                            editItemInfoTotalAmount = editItemInfoTotalAmount + amount;
                                                            if(item_type_ab == "a"){
                                                                $("#editItemInfoMaterial" + i).val(amount);
                                                                editItemInfoTotalA = editItemInfoTotalA + amount;
                                                                $("#editItemInfoLabour" + i).val("");
                                                            } else{
                                                                $("#editItemInfoLabour" + i).val(amount);
                                                                editItemInfoTotalB = editItemInfoTotalB + amount;
                                                                $("#editItemInfoMaterial" + i).val("");
                                                            }
                                                        }
                                                        $("#editItemInfoTotalAmount").val(parseFloat(editItemInfoTotalAmount));
                                                        $("#editItemInfoTotalA").val(parseFloat(editItemInfoTotalA));
                                                        $("#editItemInfoTotalB").val(parseFloat(editItemInfoTotalB));
                                                    });
                                                    // Calculate Percentage Section End ---------------------------------------------------------------------- 
                                                });
                                            </script>
                                            <script>
                                                $("#editButton").show();
                                                $(".select2").select2();
                                            </script>
                                        <?php
                                        else:
                                            ?>
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                                Something went wrong, Please try again later.
                                            </div>
                                            <?php
                                        endif;
                                    else:
                                    ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-ban"></i> Empty!</h5>
                                        No Works Added Now on this Main Work.
                                    </div>
                                    <?php
                                endif;
                                else:
                                    ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5>Work Closed!</h5>
                                        Now you are not able to Edit this Work.
                                    </div>
                                    <script>
                                        $("#editButton").hide();
                                    </script>
                                    <?php
                                endif;
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
            // ------------ Fetch Delete Section Start ---------
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
                        <input type="hidden" id="tableName" name="tableName" value="tbl_work_flow" />
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
            case "fetchWorkDelete":
                if($authority == 1):
                    if(isset($_POST["work_flow_id"]) && isset($_POST["work_type_id"]) && !empty($_POST["work_flow_id"] && $_POST["work_type_id"])):
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            Do you really wanna delete this data???
                        </div>
                        <input type="hidden" id="work_flow_id" name="work_flow_id" value="<?= $_POST["work_flow_id"] ?>" />
                        <input type="hidden" id="work_type_id" name="work_type_id" value="<?= $_POST["work_type_id"] ?>" />
                        <input type="hidden" id="tableName" name="tableName" value="tbl_work_flow" />
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
            // ------------ Fetch Delete Section End -----------
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