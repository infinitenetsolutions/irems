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
                                                <input type="checkbox" id="check-all" name="check-all" title="Check All" value="all">
                                                <label for="check-all" title="Check All">
                                                </label>
                                            </div>
                                        </th>
                                        <th>S. No.</th>
                                        <th>Company Name</th>
                                        <th>Project Name</th>
                                        <th>Project Location</th>
                                        <th>Properties</th>
                                        <th>Project Status</th>
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
                                                                <input type="checkbox" id="checkbox-<?= $rows["projects_id"] ?>" name="checkbox-select[]" value="<?= $rows["projects_id"] ?>" class="check-table">
                                                                <label for="checkbox-<?= $rows["projects_id"] ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= $sno ?>.</td>
                                                        <?php
                                                        $databaseObj->select("tbl_manage_company");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$projects_info->firmName."'");
                                                        $getData = $databaseObj->get();
                                                        if(count($getData) != 0):
                                                            foreach($getData as $rows_firm):
                                                                $manage_company_info = json_decode($rows_firm["manage_company_info"]);
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                        <td><?= $manage_company_info->companyName ?></td>
                                                        <td id="projects-name-<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?></td>
                                                        <td>
                                                            <div style="width: 200px;">
                                                                <?= $projects_info->projectLocation ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="width: 200px;">
                                                            <?php 
                                                                $databaseObj->select("tbl_properties");
                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$rows["projects_id"]."'");
                                                                $getData = $databaseObj->get();
                                                                 if($getData != 0):
                            
                               
                                                                    $sno_in = 1;
                                                                    foreach($getData as $rows_prop): 
                                                                         $properties_info = json_decode($rows_prop["properties_info"]);
                                                                        
                                                                    
                                                                         $databaseObj->select("tbl_building");
                                                                         $databaseObj->where("`status` = '".$auth->visible()."' && `building_id` = '".$properties_info->building."'");
                                                                         $getData = $databaseObj->get();
                                                                          if($getData != 0):
                                                                          $sno_in = 1;
                                                                           foreach($getData as $rows_building): 
                                                                             $building_info = json_decode($rows_building["building_info"]);

                                                                              endforeach;
                                                                endif; 
                                                                            
                                                                    ?>
                                                                    <button type="button" data-projects-id="<?= $rows["projects_id"] ?>" data-properties-id="<?= $rows_prop["properties_id"] ?>" class="properties-button btn btn-xs btn-info mt-1 mb-1" title="Property <?= $sno_in ?>.">
                                                                       <?= $building_info->building ?>
                                                                    </button>
                                                               <?php

                                                                    endforeach;
                                                                endif;
                                                            ?>
                                                            </div>
                                                        </td>
                                                           <td id="projects-name-<?= $rows["projects_id"] ?>"><?= $projects_info->projectstatus ?></td>

                                                        <td class="text-center">
                                                            <div style="width: 150px;">
                                                                <button type="button" id="information-button-<?= $rows["projects_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">
                                                                    <i class="fa fa-scroll fa-sm"></i>
                                                                </button>
                                                                <button type="button" data-projects-id="<?= $rows["projects_id"] ?>" class="add-properties-button btn btn-xs btn-info" title="Add Property">
                                                                    <i class="fa fa-home fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="edit-button-<?= $rows["projects_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                                                    <i class="fa fa-edit fa-sm"></i>
                                                                </button>
                                                                <button type="button" id="delete-button-<?= $rows["projects_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                    <i class="fa fa-trash fa-sm"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        // Information Section Start ---------------------------------------------------------------
                                                        $("#information-button-<?= $rows["projects_id"] ?>").click(function () {
                                                            $("#information-modal").modal('show');
                                                            $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchInformation","id":"<?= $rows["projects_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/projects.php',
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
                                                        $("#edit-button-<?= $rows["projects_id"] ?>").click(function () {
                                                            $("#edit-modal").modal('show');
                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchEdit","id":"<?= $rows["projects_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/projects.php',
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
                                                        $("#delete-button-<?= $rows["projects_id"] ?>").click(function () {
                                                            $("#delete-modal").modal('show');
                                                            $('#deleteButton').prop('disabled', true);
                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["projects_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/projects.php',
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
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`projects_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $projects_log = json_decode($rows["projects_log"]);
                                ?>
                                    <div class="row">
                                        <?php
                                            $sno = 1;
                                            foreach($projects_log as $projects_log_info):
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($projects_log_info->action) ?> By</a></li>
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($projects_log_info->action) ?> By - 
                                                                    <?php
                                                                        if($projects_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$projects_log_info->by."'");
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
                                                                    <?= date("l, M d, Y", strtotime($projects_log_info->date)) ?> At <?= $projects_log_info->at ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                                    <?= $projects_log_info->ip ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                                    <?php
                                                                        $latLangArray = explode(",", $projects_log_info->location);
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
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $projects_info = json_decode($rows["projects_info"]);
                                ?>
                                 <?php
                                                    $databaseObj->select("tbl_manage_company");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$projects_info->firmName."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        foreach($getData as $rows_firm):
                                                            $manage_company_info = json_decode($rows_firm["manage_company_info"]);
                                                        endforeach;
                                                    endif;
                                                   
                                ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">CompanyName</h5>
                                                    <?= $manage_company_info->companyName ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Project Name</h5>
                                                    <?= $projects_info->projectName ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Project Location</h5>
                                                    <?= $projects_info->projectLocation ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Project Location Map Url</h5>
                                                    <?= $projects_info->projectLocationMapUrl ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Project Starting Date</h5>
                                                    <?= $projects_info->projectStartingDate ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Project Expected Ending Date</h5>
                                                    <?= $projects_info->projectExpectedEndingDate ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Project Ending Date</h5>
                                                    <?= $projects_info->projectEndingDate ?>
                                                </div>
                                            </div>
                                            
                                            <?php 
                                                foreach($projects_info->properties as $properties):
                                                    $databaseObj->select("tbl_phase");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `phase_id` = '".$properties->phase."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        $sno = 1;
                                                        foreach($getData as $rows_prop):
                                                            $phase_info = json_decode($rows_prop["phase_info"]);
                                                        endforeach;
                                                    endif;
                                                    $databaseObj->select("tbl_block");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `block_id` = '".$properties->block."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        $sno = 1;
                                                        foreach($getData as $rows_prop):
                                                            $block_info = json_decode($rows_prop["block_info"]);
                                                        endforeach;
                                                    endif;
                                                    $databaseObj->select("tbl_building");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `building_id` = '".$properties->building."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        $sno = 1;
                                                        foreach($getData as $rows_prop):
                                                            $building_info = json_decode($rows_prop["building_info"]);
                                                        endforeach;
                                                    endif;
                                                   
                                                    $databaseObj->select("tbl_property_type");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `property_type_id` = '".$properties->propertyType."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        $sno = 1;
                                                        foreach($getData as $rows_prop):
                                                            $property_type_info = json_decode($rows_prop["property_type_info"]);
                                                        endforeach;
                                                    endif;
                                                    $databaseObj->select("tbl_accommodation_type");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `accommodation_type_id` = '".$properties->accommodationType."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        foreach($getData as $rows_acco):
                                                            $accommodation_type_info = json_decode($rows_acco["accommodation_type_info"]);
                                                        endforeach;
                                                    endif;
                                            ?>
                                                    <div class="col-md-12">
                                                        <div class="callout callout-danger">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Phase</h5>
                                                                        <?= $phase_info->phase ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Block</h5>
                                                                        <?= $block_info->block ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Building</h5>
                                                                        <?= $building_info->building ?>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Property Type</h5>
                                                                        <?= $property_type_info->propertyType ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Accommodation Type</h5>
                                                                        <?= $accommodation_type_info->accommodationType ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Total Area Sq.ft (S.B. Area)</h5>
                                                                        <?= $properties->squareFeet ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Price / Sq.ft</h5>
                                                                        &#8377; <?= number_format($properties->pricePerSquare) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Total Price</h5>
                                                                        &#8377; <?= number_format($properties->priceTotal) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Carpet Area Sq.ft</h5>
                                                                        <?= $properties->carpetArea ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Availablility</h5>
                                                                        <?= $properties->availablility ?>
                                                                    </div>
                                                                </div>  
                                                                
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Starting Date</h5>
                                                                        <?= $properties->StartingDate ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Expected Ending Date</h5>
                                                                        <?= $properties->ExpectedEndingDate ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Ending Date</h5>
                                                                        <?= $properties->EndingDate ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="callout callout-info">
                                                                        <h5 class="text-bold">Project Percentage Complete</h5>
                                                                        <?= $properties->PercentCompleted ?>
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                            </div>  
                                                        </div>
                                                    </div>
                                            <?php 
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
            // ------------ Fetch See Section End -------------------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Edit Section Start ----------------
            // ------------------------------------------------------
            case "fetchEdit":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $projects_info = json_decode($rows["projects_info"]);
                                ?>
                                <div class="card card-navy card-outline">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="editFirmName">Firm Name</label>
                                                <select id="editFirmName" name="editFirmName" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                    <option disabled selected>Select</option>
                                                    <?php 
                                                        $databaseObj->select("tbl_manage_company");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $rows):
                                                                $manage_company_info = json_decode($rows["manage_company_info"]);
                                                                ?>
                                                                    <option <?php if($projects_info->firmName == $rows["manage_company_id"]) echo "selected" ?> value="<?= $rows["manage_company_id"] ?>"><?= $manage_company_info->companyName ?></option>
                                                                    
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                  </select>
                                            </div>
                                        </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="editProjectName">Project Name</label>
                                                    <input type="text" class="form-control form-control-sm" id="editProjectName" name="editProjectName" placeholder="Project Name" value="<?= $projects_info->projectName ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="editProjectLocation">Project Location</label>
                                                    <input type="text" class="form-control form-control-sm" id="editProjectLocation" name="editProjectLocation" placeholder="Project Location" value="<?= $projects_info->projectLocation ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="editProjectLocationMapUrl">Project Location Map URL</label>
                                                    <input type="text" class="form-control form-control-sm" id="editProjectLocationMapUrl" name="editProjectLocationMapUrl" placeholder="Project Location Map URL" value="<?= $projects_info->projectLocationMapUrl ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="editProjectStartingDate">Project Starting Date</label>
                                                    <input type="date" class="form-control form-control-sm" id="editProjectStartingDate" name="editProjectStartingDate" placeholder="Project Starting Date" value="<?= $projects_info->projectStartingDate ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="editProjectExpectedEndingDate">Project Expected Ending Date</label>
                                                    <input type="date" class="form-control form-control-sm" id="editProjectExpectedEndingDate" name="editProjectExpectedEndingDate" placeholder="Project Expected Ending Date" value="<?= $projects_info->projectExpectedEndingDate ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="editProjectEndingDate">Project Ending Date</label>
                                                    <input type="date" class="form-control form-control-sm" id="editProjectEndingDate" name="editProjectEndingDate" placeholder="Project Ending Date" value="<?= $projects_info->projectEndingDate ?>">
                                                    <small class="text-red">Define this date after the completion of project</small>
                                                </div>
                                            </div>
                                          <!-- testing -->
                                                           <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="editProjectstatus">Project Status</label>
                                                 
                                                 
                                         <select class="form-control form-control-sm " data-dropdown-css-class="select2-navy" name="editEmpStatus" id="editEmpStatus">
                                            <option value="">Select Status</option>
                                            <option value="Completed" <?php if($projects_info->projectstatus == "Completed") echo "selected" ?>>Completed</option>
                                            <option value="On Going" <?php if($projects_info->projectstatus == "On Going") echo "selected" ?>>On Going</option>

                                        </select>
                                        
                                        
                                                </div>
                                            </div>
                                          <!-- testing ended -->
                                        </div>
                                    </div>
                                </div> 
                                <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                <script>
                                    $(".select2").select2();
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
            // ------------ Fetch Add Property Section Start --------
            // ------------------------------------------------------
            case "fetchAddProperty":
              
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $projects_info = json_decode($rows["projects_info"]);
                                ?>
                                <div class="card card-navy"  id="main_row" data-total-sub-row="0">
                                    <div class="card-header">
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body" id="main_row_body">
                                        <div class="row" id="main_row_sub">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Select Phase</label>
                                                    <select id="phase" name="phase" class="form-control form-control-sm select2 select2-navy main-rows" data-dropdown-css-class="select2-navy" data-main-row-id="1">
                                                        <option disabled selected>Select Phase</option>
                                                        <?php 
                                                            $databaseObj->select("tbl_phase");
                                                            $databaseObj->where("`status` = '".$auth->visible()."'");
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
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Select Block</label>
                                                    <select id="building" name="building" class="form-control form-control-sm select2 select2-navy main-rows" data-dropdown-css-class="select2-navy" data-main-row-id="1">
                                                        <option disabled selected>Select Block</option>
                                                        <?php 

                                                            $databaseObj->select("tbl_building");
                                                            $databaseObj->where("`status` = '".$auth->visible()."'");
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

                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>No of Floors</label>
                                                    <input id="floor" name="floor" type="number" min="1" step=any class="form-control form-control-sm main-rows dynamic-floor" placeholder="No of Floors" />
                                                </div>
                                            </div>

                                            <!-- Testing Purpose Only -->
                                            <!-- <div class="col-md-12" id="floor_row_1" data-main-row-id="1"  data-floor-row-id="1">
                                                <div class="card card-navy">
                                                    <div class="card-header">
                                                        <h3 class="card-title" id="floor_row_sno_1">Floor | 1 </h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-main-row-id="1" data-floor-row-id="1"><i class="fas fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body" id="floor_row_body_1">
                                                        <div class="row">
                                                            <div class="table-responsive" id="floor_row_table_1">
                                                                <table class="table table-bordered table-striped border-radius">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>S.No.</th>
                                                                            <th>Flat Number</th>
                                                                            <th>Property Type</th>
                                                                            <th>Accommodation Type</th>
                                                                            <th>Total Area Sq.ft<br/>(S.B. Area)</th>
                                                                            <th>Price / Sq.ft</th>
                                                                            <th>Total Price</th>
                                                                            <th>Carpet Area Sq.ft</th>
                                                                            <th>Starting Date</th>
                                                                            <th>Expected Ending Date</th>
                                                                            <th>Ending Date</th>
                                                                            <th>% Of Completion</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="flat_row_1" data-main-row-id="1" data-floor-row-id="1" data-total-flat-row="1">
                                                                        <tr id="row_id_1_1">
                                                                            <td class="text-bold" id="flat_sno_1_1">
                                                                                1.
                                                                            </td>
                                                                            <td>
                                                                                <input  id="flat_no_1_1" name="flat_no_1[]" type="text"  class="form-control form-control-sm main-rows flat-nos" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:100px;" />
                                                                            </td>
                                                                            <td>
                                                                                <select id="property_type_1_1" name="property_type_1[]" class="form-control form-control-sm main-rows select2 select2-navy" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" data-dropdown-css-class="select2-navy" style="width:200px;">
                                                                                    <option disabled selected>Select Property</option>
                                                                                    <?php 
                                                                                        $databaseObj->select("tbl_property_type");
                                                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                        $getData = $databaseObj->get();
                                                                                        //Checking If Data Is Available
                                                                                        if($getData != 0):
                                                                                            $sno = 1;
                                                                                            foreach($getData as $rows):
                                                                                                $property_type_info = json_decode($rows["property_type_info"]);
                                                                                                ?>
                                                                                                    <option value="<?= $rows["property_type_id"] ?>"><?= $property_type_info->propertyType ?></option>
                                                                                                <?php
                                                                                            endforeach;
                                                                                        endif;
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select id="accommodation_type_1_1" name="accommodation_type_1[]" class="form-control form-control-sm main-rows select2 select2-navy" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1"  data-dropdown-css-class="select2-navy" style="width:200px;">
                                                                                    <option disabled selected>Select Accommodation</option>
                                                                                    <?php 
                                                                                        $databaseObj->select("tbl_accommodation_type");
                                                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                        $getData = $databaseObj->get();
                                                                                        //Checking If Data Is Available
                                                                                        if($getData != 0):
                                                                                            $sno = 1;
                                                                                            foreach($getData as $rows):
                                                                                                $accommodation_type_info = json_decode($rows["accommodation_type_info"]);
                                                                                                ?>
                                                                                                    <option value="<?= $rows["accommodation_type_id"] ?>"><?= $accommodation_type_info->accommodationType ?></option>
                                                                                                <?php
                                                                                            endforeach;
                                                                                        endif;
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <input id="square_feet_1_1" name="square_feet_1[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:150px;" />
                                                                            </td>
                                                                            <td>
                                                                                <input id="price_per_square_1_1" name="price_per_square_1[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:150px;" />
                                                                            </td>
                                                                            <td>
                                                                                <input id="price_total_1_1" name="price_total_1[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:150px;" readonly />
                                                                            </td>
                                                                            <td>
                                                                                <input id="carpet_area_1_1" name="carpet_area_1[]" type="number" min="0" class="form-control form-control-sm" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:150px;" />
                                                                            </td>
                                                                            <td>
                                                                                <input id="starting_date_1_1" name="starting_date_1[]" type="date" class="form-control form-control-sm main-rows" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:180px;" />
                                                                            </td>
                                                                            <td>
                                                                                <input id="expected_ending_date_1_1" name="expected_ending_date_1[]" type="date" class="form-control form-control-sm main-rows" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:180px;" />
                                                                                <small class="text-red">Tentative date to complete </small>
                                                                            </td>
                                                                            <td>
                                                                                <input id="ending_date_1_1" name="ending_date_1[]" type="date" class="form-control form-control-sm" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:180px;"  />
                                                                                <small class="text-red">When this property will completed</small>
                                                                            </td>
                                                                            <td>
                                                                                <input id="percent_completed_1_1" name="percent_completed_1[]" type="number" min="0.00" max="100.00" step=any class="form-control form-control-sm main-rows input-percentage" data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" style="width:150px;"  />
                                                                                <small class="text-red">Percantage of completion
                                                                                </small>
                                                                            </td>
                                                                            <td>
                                                                                <button data-main-row-id="1" data-floor-row-id="1" data-flat-row-id="1" type="button" class="btn btn-sm btn-warning add-edit-flat-row">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- Testing Purpose Only -->

                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(".select2").select2();
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
            // ------------ Fetch Add Property Section End ----------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Add Property Section Start --------
            // ------------------------------------------------------
            case "fetchEditProperty":
         
                if($authority == 1):

   

                    if(isset($_POST["id"]) && !empty($_POST["id"])):

                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `properties_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $properties_info = json_decode($rows["properties_info"]);
                                ?>
                                <div class="card card-navy" id="edit_main_row" data-total-sub-row="<?= count($properties_info->floors) ?>">
                                    <div class="card-header">
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body" id="edit_main_row_body">
                                        <div class="row" id="edit_main_row_sub">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Select Phase</label>
                                                    <select id="edit_phase" name="edit_phase" class="form-control form-control-sm select2 select2-navy edit-main-rows" data-dropdown-css-class="select2-navy">
                                                        <option disabled selected>Select Phase</option>
                                                        <?php 
                                                            $databaseObj->select("tbl_phase");
                                                            $databaseObj->where("`status` = '".$auth->visible()."'");
                                                            $getData = $databaseObj->get();
                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                                foreach($getData as $rows):
                                                                    $phase_info = json_decode($rows["phase_info"]);
                                                                    ?>
                                                                        <option <?php if($properties_info->phase == $rows["phase_id"]) echo "selected"; ?> value="<?= $rows["phase_id"] ?>"><?= $phase_info->phase ?></option>
                                                                    <?php
                                                                endforeach;
                                                            endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Select Block</label>
                                                    <select id="edit_building" name="edit_building" class="form-control form-control-sm select2 select2-navy edit-main-rows" data-dropdown-css-class="select2-navy">
                                                        <option disabled selected>Select Block</option>
                                                        <?php 
                                                            $databaseObj->select("tbl_building");
                                                            $databaseObj->where("`status` = '".$auth->visible()."'");
                                                            $getData = $databaseObj->get();
                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                                foreach($getData as $rows):
                                                                    $building_info = json_decode($rows["building_info"]);
                                                                    ?>
                                                                        <option <?php if($properties_info->building == $rows["building_id"]) echo "selected"; ?> value="<?= $rows["building_id"] ?>"><?= $building_info->building ?></option>
                                                                    <?php
                                                                endforeach;
                                                            endif;
                                                           
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>No of Floors</label>
                                                    <input id="edit_floor" name="edit_floor" type="number" min="1" step=any class="form-control form-control-sm edit-main-rows edit-dynamic-floor" placeholder="No of Floors" value="<?= $properties_info->total_floors ?>" />
                                                </div>
                                            </div>
                                            <?php
                                                $floors_count = 0;
                                                foreach($properties_info->floors as $floors):
                                            ?>
                                            <div class="col-md-12" id="edit_floor_row_<?= ++$floors_count ?>"  data-floor-row-id="<?= $floors_count ?>">
                                                <div class="card card-navy">
                                                    <div class="card-header">
                                                        <h3 class="card-title" id="edit_floor_row_sno_<?= $floors_count ?>">Floor | <?= $floors_count ?> </h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-floor-row-id="<?= $floors_count ?>"><i class="fas fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body" id="edit_floor_row_body_<?= $floors_count ?>">
                                                        <div class="row">
                                                            <div class="table-responsive" id="edit_floor_row_table_<?= $floors_count ?>">
                                                                <table class="table table-bordered table-striped border-radius">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>S.No.</th>
                                                                            <th>Status</th>
                                                                            <th>Customer Name</th>
                                                                            <th>Flat Number</th>
                                                                            <th>Property Type</th>
                                                                            <th>Accommodation Type</th>
                                                                            <th>Total Area Sq.ft<br/>(S.B. Area)</th>
                                                                            <th>Price / Sq.ft</th>
                                                                            <th>Total Price</th>
                                                                            <th>Carpet Area Sq.ft</th>
                                                                            <th>Starting Date</th>
                                                                            <th>Expected Ending Date</th>
                                                                            <th>Ending Date</th>
                                                                            <th>% Of Completion</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="edit_flat_row_<?= $floors_count ?>" data-floor-row-id="<?= $floors_count ?>" data-total-flat-row="<?= count($floors) ?>">
                                                                        <?php 
                                                                            $flats_count = 0;
                                                                            foreach($floors as $flats):
                                                                                ++$flats_count;
                                                                        ?>
                                                                        <tr id="edit_row_id_<?= $floors_count ?>_<?= $flats_count ?>">
                                                                            <td class="text-bold" id="edit_flat_sno_<?= $floors_count ?>_<?= $flats_count ?>">
                                                                                <?= $flats_count ?>.
                                                                            </td>
                                                                           
                                                                            <td class="text-center">
                                                                                <?php 
                                                                                    if(empty($flats->customer_details->customer_id)):
                                                                                ?>
                                                                                <div style="width: 120px">
                                                                                    <kbd class="btn btn-sm bg-danger">
                                                                                        Not Reserved
                                                                                    </kbd>
                                                                                </div>
                                                                                <?php 
                                                                                    else:
                                                                                ?> 
                                                                                <div style="width: 100px">
                                                                                    <kbd class="btn btn-sm bg-success">
                                                                                        Reserved
                                                                                    </kbd>
                                                                                </div>    
                                                                                <?php
                                                                                    endif;
                                                                                ?>
                                                                                <input type="hidden" id="edit_customer_id_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_customer_id_<?= $floors_count ?>[]" value="<?= $flats->customer_details->customer_id ?>" >
                                                                            </td>
                                                                             <td class="text-center">
                                                                                <?php 
                                                                                    if(empty($flats->customer_details->customer_id)):
                                                                                ?>
                                                                                <div style="width: 120px">
                                                                                    <kbd class="btn btn-sm bg-warning">
                                                                                        Not Allotted
                                                                                    </kbd>
                                                                                </div>
                                                                                <?php 
                                                                                    else:
                                                                                ?> 
                                                                                <div style="width: 100px">
                                                                                    <kbd class="btn btn-sm bg-primary">
                                                                                        <?php
                                                                                        $databaseObj->select("tbl_customer");
                                                                                        $databaseObj->where("`customer_id` = '".$flats->customer_details->customer_id."'");
                                                                                        $getData = $databaseObj->get();
                                                                                        
                                                                                            foreach($getData as $rows_cust):
                                                                                                $customer_info = json_decode($rows_cust["customer_info"]);
                                                                                            endforeach; ?>
                                                                                       

                                                                                        <?php echo $customer_info->name; ?>
                                                                                    </kbd>
                                                                                </div>    
                                                                                <?php
                                                                                    endif;
                                                                                ?>
                                                                               
                                                                            </td>

                                                                            <td>
                                                                                <input  id="edit_flat_no_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_flat_no_<?= $floors_count ?>[]" type="text"  class="form-control form-control-sm edit-main-rows edit-flat-nos" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" style="width:100px;" value="<?= $flats->flat_no ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <select id="edit_property_type_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_property_type_<?= $floors_count ?>[]" class="form-control form-control-sm edit-main-rows select2 select2-navy" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" data-dropdown-css-class="select2-navy" style="width:200px;">
                                                                                    <option disabled selected>Select Property</option>
                                                                                    <?php 
                                                                                        $databaseObj->select("tbl_property_type");
                                                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                        $getData = $databaseObj->get();
                                                                                        //Checking If Data Is Available
                                                                                        if($getData != 0):
                                                                                            $sno = 1;
                                                                                            foreach($getData as $rows):
                                                                                                $property_type_info = json_decode($rows["property_type_info"]);
                                                                                                ?>
                                                                                                    <option <?php if($rows["property_type_id"] == $flats->property_type) echo "selected" ?> value="<?= $rows["property_type_id"] ?>"><?= $property_type_info->propertyType ?></option>
                                                                                                <?php
                                                                                            endforeach;
                                                                                        endif;
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select id="edit_accommodation_type_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_accommodation_type_<?= $floors_count ?>[]" class="form-control form-control-sm edit-main-rows select2 select2-navy" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>"  data-dropdown-css-class="select2-navy" style="width:200px;">
                                                                                    <option disabled selected>Select Accommodation</option>
                                                                                    <?php 
                                                                                        $databaseObj->select("tbl_accommodation_type");
                                                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                        $getData = $databaseObj->get();
                                                                                        //Checking If Data Is Available
                                                                                        if($getData != 0):
                                                                                            $sno = 1;
                                                                                            foreach($getData as $rows):
                                                                                                $accommodation_type_info = json_decode($rows["accommodation_type_info"]);
                                                                                                ?>
                                                                                                    <option <?php if($rows["accommodation_type_id"] == $flats->accommodation_type) echo "selected" ?> value="<?= $rows["accommodation_type_id"] ?>"><?= $accommodation_type_info->accommodationType ?></option>
                                                                                                <?php
                                                                                            endforeach;
                                                                                        endif;
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <input id="edit_square_feet_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_square_feet_<?= $floors_count ?>[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" style="width:150px;" value="<?= $flats->square_feet ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <input id="edit_price_per_square_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_price_per_square_<?= $floors_count ?>[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" style="width:150px;" value="<?= $flats->price_per_square ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <input id="edit_price_total_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_price_total_<?= $floors_count ?>[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" style="width:150px;" value="<?= $flats->price_total ?>" readonly />
                                                                            </td>
                                                                            <td>
                                                                                <input id="edit_carpet_area_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_carpet_area_<?= $floors_count ?>[]" type="number" min="0" class="form-control form-control-sm" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" value="<?= $flats->carpet_area ?>" style="width:150px;" />
                                                                            </td>
                                                                            <td>
                                                                                <input id="edit_starting_date_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_starting_date_<?= $floors_count ?>[]" type="date" class="form-control form-control-sm edit-main-rows" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" style="width:180px;" value="<?= $flats->starting_date ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <input id="edit_expected_ending_date_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_expected_ending_date_<?= $floors_count ?>[]" type="date" class="form-control form-control-sm edit-main-rows" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" style="width:180px;" value="<?= $flats->expected_ending_date ?>" />
                                                                                <small class="text-red">Tentative date to complete </small>
                                                                            </td>
                                                                            <td>
                                                                                <input id="edit_ending_date_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_ending_date_<?= $floors_count ?>[]" type="date" class="form-control form-control-sm" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" style="width:180px;" value="<?= $flats->ending_date ?>"  />
                                                                                <small class="text-red">When this property will completed</small>
                                                                            </td>
                                                                            <td>
                                                                                <input id="edit_percent_completed_<?= $floors_count ?>_<?= $flats_count ?>" name="edit_percent_completed_<?= $floors_count ?>[]" type="number" min="0.00" max="100.00" step=any class="form-control form-control-sm edit-main-rows input-percentage" data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" style="width:150px;" value="<?= $flats->percent_completed ?>"  />
                                                                                <small class="text-red">Percantage of completion
                                                                                </small>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                                                    if($flats_count == 1):
                                                                                ?>
                                                                                <button data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" type="button" class="btn btn-sm btn-warning add-edit-flat-row">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </button>
                                                                                <?php 
                                                                                    else:
                                                                                ?> 
                                                                                <button data-floor-row-id="<?= $floors_count ?>" data-flat-row-id="<?= $flats_count ?>" type="button" class="btn btn-sm btn-danger remove-edit-flat-row"> 
                                                                                    <i class="fa fa-times"></i> 
                                                                                </button>
                                                                                <?php
                                                                                    endif;
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php 
                                                                            endforeach;
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                                endforeach;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                <script>
                                    $(".select2").select2();
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
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //

                                        // Auto Add Floors Section Start -----------------------------------------------------------------------------------------------------------------
                                        $(document).on("click change blur", ".edit-dynamic-floor", function(){
                                            var total_floor = $("#edit_main_row").attr("data-total-sub-row");
                                            if(Number($("#edit_floor").val()) == 0)
                                               $("#edit_floor").val(" ");
                                            if($("#edit_phase").val() != null && $("#edit_building").val() != null){
                                                if(Number($(this).val()) != Number(total_floor)) {
                                                    if(Number($(this).val()) > Number(total_floor))
                                                        for (var x = (Number(total_floor) + 1); x <= Number($(this).val()); x++){
                                                            $("#edit_main_row_body").append('<div class="col-md-12" id="edit_floor_row_'+ x +'"  data-floor-row-id="'+ x +'"> <div class="card card-navy"> <div class="card-header"> <h3 class="card-title" id="edit_floor_row_sno_'+ x +'">Floor | '+ x +'  </h3> <div class="card-tools"> <button type="button" class="btn btn-tool" data-card-widget="collapse"  data-floor-row-id="'+ x +'"><i class="fas fa-minus"></i></button> </div> </div> <div class="card-body" id="edit_floor_row_body_'+ x +'"> <div class="row"> <div class="table-responsive" id="edit_floor_row_table_'+ x +'"> <table class="table table-bordered table-striped border-radius"> <thead> <tr> <th>S.No.</th> <th>Status</th> <th>Flat Number</th> <th>Property Type</th> <th>Accommodation Type</th> <th>Total Area Sq.ft<br/>(S.B. Area)</th> <th>Price / Sq.ft</th> <th>Total Price</th> <th>Carpet Area Sq.ft</th> <th>Starting Date</th> <th>Expected Ending Date</th> <th>Ending Date</th> <th>% Of Completion</th> <th>Action</th> </tr>  </thead> <tbody id="edit_flat_row_'+ x +'"  data-floor-row-id="'+ x +'" data-total-flat-row="1"> <tr id="edit_row_id_'+ x +'_1"> <td class="text-bold" id="edit_flat_sno_'+ x +'_1"> 1. </td>  <td class="text-center"> <div style="width: 120px"> <kbd class="btn btn-sm bg-danger"> Not Reserved </kbd> </div> <input type="hidden" id="edit_customer_id_'+ x +'_1" name="edit_customer_id_'+ x +'[]" value="" > </td>  <td> <input  id="edit_flat_no_'+ x +'_1" name="edit_flat_no_'+ x +'[]" type="text"  class="form-control form-control-sm edit-main-rows flat-nos"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:100px;" /> </td> <td> <select id="edit_property_type_'+ x +'_1" name="edit_property_type_'+ x +'[]" class="form-control form-control-sm edit-main-rows select2 select2-navy"  data-floor-row-id="'+ x +'" data-flat-row-id="1" data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select Property</option> <?php  $databaseObj->select("tbl_property_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $property_type_info = json_decode($rows["property_type_info"]); ?> <option value="<?= $rows["property_type_id"] ?>"><?= $property_type_info->propertyType ?></option> <?php endforeach; endif; ?> </select> </td> <td> <select id="edit_accommodation_type_'+ x +'_1" name="edit_accommodation_type_'+ x +'[]" class="form-control form-control-sm edit-main-rows select2 select2-navy"  data-floor-row-id="'+ x +'" data-flat-row-id="1"  data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select Accommodation</option> <?php  $databaseObj->select("tbl_accommodation_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $accommodation_type_info = json_decode($rows["accommodation_type_info"]); ?> <option value="<?= $rows["accommodation_type_id"] ?>"><?= $accommodation_type_info->accommodationType ?></option> <?php endforeach; endif; ?> </select> </td> <td> <input id="edit_square_feet_'+ x +'_1" name="edit_square_feet_'+ x +'[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;" /> </td> <td> <input id="edit_price_per_square_'+ x +'_1" name="edit_price_per_square_'+ x +'[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;" /> </td> <td> <input id="edit_price_total_'+ x +'_1" name="edit_price_total_'+ x +'[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;" readonly /> </td> <td> <input id="edit_carpet_area_'+ x +'_1" name="edit_carpet_area_'+ x +'[]" type="number" min="0" class="form-control form-control-sm"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;" /> </td> <td> <input id="edit_starting_date_'+ x +'_1" name="edit_starting_date_'+ x +'[]" type="date" class="form-control form-control-sm edit-main-rows"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:180px;" /> </td> <td> <input id="edit_expected_ending_date_'+ x +'_1" name="edit_expected_ending_date_'+ x +'[]" type="date" class="form-control form-control-sm edit-main-rows"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:180px;" /> <small class="text-red">Tentative date to complete </small> </td> <td> <input id="edit_ending_date_'+ x +'_1" name="edit_ending_date_'+ x +'[]" type="date" class="form-control form-control-sm"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:180px;"  /> <small class="text-red">When this property will completed</small> </td> <td> <input id="edit_percent_completed_'+ x +'_1" name="edit_percent_completed_'+ x +'[]" type="number" min="0.00" max="100.00" step=any class="form-control form-control-sm edit-main-rows input-percentage"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;"  /> <small class="text-red">Percantage of completion </small> </td> <td> <button  data-floor-row-id="'+ x +'" data-flat-row-id="1" type="button" class="btn btn-sm btn-warning add-edit-flat-row"> <i class="fa fa-plus"></i> </button> </td> </tr> </tbody> </table> </div> </div> </div> </div> </div>');
                                                            $(".select2").select2();
                                                        }
                                                    else
                                                        for (var x = (Number($(this).val()) + 1); x <= Number(total_floor); x++)
                                                            $("#edit_floor_row_"+ x).remove();
                                                        // edit_floor_row_1_1
                                                    $("#edit_main_row").attr("data-total-sub-row", Number($(this).val()));
                                                }
                                            } else{
                                                $(this).val("");
                                                topEndNotification("warning", "Please complete the rest fields...");
                                            }
                                        });
                                        // Auto Add Floors Section End -----------------------------------------------------------------------------------------------------------------

                                        // Add More Flat Section Start -----------------------------------------------------------------------------------------------------------------
                                        // var i = 1;
                                        $(document).on("click", ".add-edit-flat-row", function(){
                                            var flag = 1;
                                            var edit_floor_row_id = $(this).attr("data-floor-row-id");
                                            var total_flat = $("#edit_flat_row_"+ edit_floor_row_id).attr("data-total-flat-row");
                                            $(".edit-main-rows").each(function(){
                                                if($(this).val() == "" || $(this).val() == null){
                                                    flag = 0;
                                                    $(this).addClass("is-invalid");
                                                } else
                                                    $(this).removeClass("is-invalid");
                                            });
                                            if(flag == 1){
                                                total_flat++;
                                                $("#edit_flat_row_"+ edit_floor_row_id).append('<tr id="edit_row_id_'+ edit_floor_row_id +'_'+ total_flat +'"> <td class="text-bold" id="edit_flat_sno_'+ edit_floor_row_id +'_'+ total_flat +'"> '+ total_flat +'. </td>  <td class="text-center"> <div style="width: 120px"> <kbd class="btn btn-sm bg-danger"> Not Reserved </kbd> </div> <input type="hidden" id="edit_customer_id_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_customer_id_'+ edit_floor_row_id +'[]" value="" > </td>  <td> <input  id="edit_flat_no_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_flat_no_'+ edit_floor_row_id +'[]" type="text"  class="form-control form-control-sm edit-main-rows flat-nos" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:100px;" /> </td> <td> <select id="edit_property_type_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_property_type_'+ edit_floor_row_id +'[]" class="form-control form-control-sm edit-main-rows select2 select2-navy" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select Property</option> <?php  $databaseObj->select("tbl_property_type"); $databaseObj->where("`status` = '".$auth->visible()."'");  $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $property_type_info = json_decode($rows["property_type_info"]); ?> <option value="<?= $rows["property_type_id"] ?>"><?= $property_type_info->propertyType ?></option> <?php endforeach;  endif; ?> </select> </td> <td> <select id="edit_accommodation_type_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_accommodation_type_'+ edit_floor_row_id +'[]" class="form-control form-control-sm edit-main-rows select2 select2-navy" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'"  data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select Accommodation</option> <?php  $databaseObj->select("tbl_accommodation_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $accommodation_type_info = json_decode($rows["accommodation_type_info"]); ?> <option value="<?= $rows["accommodation_type_id"] ?>"><?= $accommodation_type_info->accommodationType ?></option> <?php endforeach; endif; ?> </select> </td> <td> <input id="edit_square_feet_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_square_feet_'+ edit_floor_row_id +'[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;" /> </td> <td> <input id="edit_price_per_square_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_price_per_square_'+ edit_floor_row_id +'[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;" /> </td> <td> <input id="edit_price_total_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_price_total_'+ edit_floor_row_id +'[]" type="number" min="0.00" step=any class="form-control form-control-sm edit-main-rows edit-calculate-amount-now" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;" readonly /> </td> <td> <input id="edit_carpet_area_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_carpet_area_'+ edit_floor_row_id +'[]" type="number" min="0" class="form-control form-control-sm" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;" /> </td> <td> <input id="edit_starting_date_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_starting_date_'+ edit_floor_row_id +'[]" type="date" class="form-control form-control-sm edit-main-rows" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:180px;" /> </td> <td>  <input id="edit_expected_ending_date_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_expected_ending_date_'+ edit_floor_row_id +'[]" type="date" class="form-control form-control-sm edit-main-rows" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:180px;" /> <small class="text-red">Tentative date to complete </small>  </td> <td> <input id="edit_ending_date_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_ending_date_'+ edit_floor_row_id +'[]" type="date" class="form-control form-control-sm" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:180px;"  /> <small class="text-red">When this property will completed</small> </td> <td> <input id="edit_percent_completed_'+ edit_floor_row_id +'_'+ total_flat +'" name="edit_percent_completed_'+ edit_floor_row_id +'[]" type="number" min="0.00" max="100.00" step=any class="form-control form-control-sm edit-main-rows input-percentage" data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;"  /> <small class="text-red">Percantage of completion </small> </td> <td> <button data-floor-row-id="'+ edit_floor_row_id +'" data-flat-row-id="'+ total_flat +'" type="button" class="btn btn-sm btn-danger remove-edit-flat-row"> <i class="fa fa-times"></i> </button> </td> </tr>');
                                                $(".select2").select2();
                                                $("#edit_flat_row_"+ edit_floor_row_id).attr("data-total-flat-row", total_flat);
                                            } else
                                                topEndNotification("warning", "Please complete the rest fields...");
                                        }); 
                                        $(document).on("click", ".remove-edit-flat-row", function(){
                                            var row_id = $(this).attr("data-flat-row-id");
                                            var main_row_id = $(this).attr("data-main-row-id");
                                            var edit_floor_row_id = $(this).attr("data-floor-row-id");
                                            var total_flat = $("#edit_flat_row_"+ edit_floor_row_id).attr("data-total-flat-row");
                                            $("#edit_row_id_"+ edit_floor_row_id +"_"+ row_id).remove();
                                            if(Number(row_id) == Number(total_flat)){
                                                total_flat--;
                                                $("#edit_flat_row_"+ edit_floor_row_id).attr("data-total-flat-row", total_flat);
                                            }
                                            else{
                                                for (var j = Number(row_id); j <= Number(total_flat); j++){
                                                    $("#edit_flat_sno_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_flat_sno_"+ edit_floor_row_id +"_"+ j)
                                                        .html(j + ". ");
                                                    $("#edit_row_id_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_row_id_"+ edit_floor_row_id +"_"+ j)
                                                        .find("*")
                                                        .attr("data-flat-row-id", j);
                                                    $("#edit_flat_sno_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_flat_sno_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_flat_no_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_flat_no_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_property_type_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_property_type_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_accommodation_type_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_accommodation_type_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_square_feet_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_square_feet_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_price_per_square_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_price_per_square_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_price_total_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_price_total_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_carpet_area_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_carpet_area_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_starting_date_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_starting_date_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_expected_ending_date_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_expected_ending_date_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_ending_date_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_ending_date_"+ edit_floor_row_id +"_"+ j);
                                                    $("#edit_percent_completed_"+ edit_floor_row_id +"_"+ (j + 1)).attr("id", "edit_percent_completed_"+ edit_floor_row_id +"_"+ j);
                                                }
                                                total_flat--;
                                                $("#edit_flat_row_"+ edit_floor_row_id).attr("data-total-flat-row", total_flat);
                                            }
                                        });
                                        // Add More Flat Section End -----------------------------------------------------------------------------------------------------------------


                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
                                        // *********************************************************************************************************** //
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
            // ------------ Fetch Add Property Section End ----------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchDeleteProperty":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            Do you really wanna delete this data???
                        </div>
                        <input type="hidden" id="tableId" name="tableId" value="<?= $_POST["id"] ?>" />
                        <input type="hidden" id="tableName" name="tableName" value="tbl_properties" />
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
            case "fetchDelete":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            Do you really wanna delete this data???
                        </div>
                        <input type="hidden" id="tableId" name="tableId" value="<?= $_POST["id"] ?>" />
                        <input type="hidden" id="tableName" name="tableName" value="tbl_projects" />
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