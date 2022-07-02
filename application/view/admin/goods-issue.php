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
                $databaseObj->select("tbl_goods_issue");

                // $databaseObj->where("`goods_issue_status` = ' '");
                 $databaseObj->order_by("`goods_issue_id` DESC");

                $receipt_result = $databaseObj->get();
                
                $databaseObj->select("goods_issue_id");

                $order_result = $databaseObj->get();                ?>



<div class="page">

    <?php

     if ($_GET) {

       if($_GET["receipt"] == "success"){

         ?>

    <div class="alert alert-success" id="fade" role="alert">

        <h4 class="alert-heading">ITEMS RECEIVED SUCCESSFULLY!!!</h4>

    </div>

    <?php

       }

       else if($_GET["receipt"] == "nodate"){

           ?>

    <div class="alert alert-danger" id="fade" role="alert">

        <h4 class="alert-heading">PLEASE ENTER DATE</h4>

    </div>

    <?php

       }

       else if($_GET["receipt"] == "nobill"){

           ?>

    <div class="alert alert-danger" id="fade" role="alert">

        <h4 class="alert-heading">PLEASE ENTER BILL NUMBER</h4>

    </div>

    <?php

       }

     }



      ?>



    <div class="page-content">

        <!-- Panel Mode Switch -->

        <div class="panel">

            <!--

                         <header class="panel-heading">

                           <h3 class="panel-title">GOODS RECEIPT NOTE (GRN)</h3>

                         </header>

                    -->

            <div class="panel-body">

                <form class="" enctype="multipart/form-data" action="application/controller/admin/goods-receipt.php" id="inv_orders" name="inv_orders" method="post">

                    <!--       <input type="hidden" id="action" name="action" value="addPO">-->



				

                    <table class="tablesaw table-striped" data-tablesaw-mode="swipe" data-tablesaw-mode-switch data-tablesaw-minimap>

                        <thead>

                            <tr>

                                <th>ISSUE RETUN NOTE (IRN)</th>

                                <th></th>

                                <th></th>

                            </tr>

                            <tr>

                                <th></th>

                                <th></th>

                                <th></th>

                            </tr>

                            <tr>

                                <th>Issue No.&nbsp;</th>

                                <th>&nbsp;:&nbsp;</th>

                                <th>

                                    <input type="hidden" id="grn_no" value="<?php echo $grn_no; ?>"><select class="form-control" name="in_rec_note_no" id="goods_receipt">

                                        <option value="">---Select---</option>

                                        <?php

                                                            foreach ($receipt_result as $grn) {
                                                                $goods_issue_info = json_decode($grn["goods_issue_info"]);
                                                                
                                                              $databaseObj->select("tbl_admin");
                                                              $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                                                             $databaseObj->order_by("`admin_id` DESC");
                                                             $getData = $databaseObj->get(); 

                                                             //Checking If Data Is Available
                                                             if($getData != 0):
                                                       
                                                                foreach($getData as $rowsadmin):
                                                                    $admin_info = json_decode($rowsadmin["admin_info"]);
                                                                    $databaseObj->select("tbl_manage_employee");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                        $sno = 1;
                                                                      foreach($getData as $rowsemployee):
                                                                        $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                                                      
                                                                      if($manage_employee_info->project == $goods_issue_info->project): 


                                                        ?>

                                        <option  value="<?=  $grn['goods_issue_id'] ?>"><?=  $grn['goods_issue_id'] ?> - <?=  $goods_issue_info->ginDate ?> </option>
                                        <?php
                                    endif;
                                       endforeach;
                                                                    endif;
                                                                endforeach;   
                                                             endif;     

                                       

                                                           }

                                                        ?>

                                    </select>

                                </th>

                            </tr>

                        </thead>

                    </table>

            </div>

        </div>

        <!-- End Panel Mode Switch -->

        <div id="main-section"></div>

        <div id="loader_section"></div>



    </div>

</div>

<script>

    $('#goods_receipt').change(function() {

        $('#loader_section').append('<center id = "loading"><br /><br /><img width="100px" src = "assets/loader/pre-loader.gif" alt="Loading..." /><p id="connectionError"></p><br/></center>');

        var action = "goodsReceipt";

        var dataString = 'action=' + action;

        var order_no = document.getElementById('goods_receipt').value;

        var receipt_no = document.getElementById('grn_no').value;

        $.ajax({

            url: 'application/view/admin/view-goods-issue.php',

            type: 'POST',

            data: {

                order_no: order_no,

                receipt_no: receipt_no,

                action: action

            },

            success: function(result) {

                $('#loading').fadeOut(500, function() {

                    $(this).remove();

                    $('#main-section').html('<div id = "response">' + result + '</div>');

                });

            }

        });

    });



</script>

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

<div class="row">

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

                        <h5 class="text-bold">Square Feet</h5>

                        <?= $properties->squareFeet ?>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="callout callout-info">

                        <h5 class="text-bold">Price</h5>

                        <?= $properties->price ?>

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

<div class="row">

    <div class="col-md-6">

        <div class="form-group">

            <label for="editProjectName">Project Name</label>

            <input type="text" class="form-control" id="editProjectName" name="editProjectName" placeholder="Projects" value="<?= $projects_info->projectName ?>">

        </div>

    </div>

    <div class="col-md-6">

        <div class="form-group">

            <label for="editProjectLocation">Project Location</label>

            <input type="text" class="form-control" id="editProjectLocation" name="editProjectLocation" placeholder="Project Location" value="<?= $projects_info->projectLocation ?>">

        </div>

    </div>

    <div class="col-md-12">

        <div class="form-group">

            <label for="editProjectLocationMapUrl">Project Location Map URL</label>

            <input type="text" class="form-control" id="editProjectLocationMapUrl" name="editProjectLocationMapUrl" placeholder="Project Location Map URL" value="<?= $projects_info->projectLocationMapUrl ?>">

        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group">

            <label for="editProjectStartingDate">Project Starting Date</label>

            <input type="date" class="form-control" id="editProjectStartingDate" name="editProjectStartingDate" placeholder="Project Starting Date" value="<?= $projects_info->projectStartingDate ?>">

        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group">

            <label for="editProjectExpectedEndingDate">Project Expected Ending Date</label>

            <input type="date" class="form-control" id="editProjectExpectedEndingDate" name="editProjectExpectedEndingDate" placeholder="Project Expected Ending Date" value="<?= $projects_info->projectExpectedEndingDate ?>">

        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group">

            <label for="editProjectEndingDate">Project Ending Date</label>

            <input type="date" class="form-control" id="editProjectEndingDate" name="editProjectEndingDate" placeholder="Project Ending Date" value="<?= $projects_info->projectEndingDate ?>">

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

                                                        foreach($projects_info->properties as $properties):

                                                    ?>

                <?php 

                                                        if($noOfProperties == 1):

                                                    ?>

                <tr>

                    <?php 

                                                        else:

                                                    ?>

                <tr id="row<?= $noOfProperties."_".$rows["projects_id"] ?>" class="dynamic-added">

                    <?php 

                                                        endif;

                                                    ?>

                    <td>

                        <span class="p-3 mt-2"><?= $noOfProperties ?>.</span>

                    </td>

                    <td>

                        <select id="propertyType<?= $noOfProperties."_".$rows["projects_id"] ?>" name="propertyType[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;">

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

                        <select id="accommodationType<?= $noOfProperties."_".$rows["projects_id"] ?>" name="accommodationType[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;">

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

                            <option value="<?= $rows_acco["accommodation_type_id"] ?>" <?php if($properties->availablility == $rows_acco["accommodation_type_id"]) echo "selected" ?>><?= $accommodation_type_info->accommodationType ?></option>

                            <?php

                                                                        endforeach;

                                                                    endif;

                                                                ?>

                        </select>

                    </td>

                    <td>

                        <input id="squareFeet<?= $noOfProperties."_".$rows["projects_id"] ?>" name="squareFeet[]" type="number" min="0" class="form-control" style="width:150px;" value="<?= $properties->squareFeet ?>" />

                    </td>

                    <td>

                        <input id="price<?= $noOfProperties."_".$rows["projects_id"] ?>" name="price[]" type="number" min="0" class="form-control" style="width:150px;" value="<?= $properties->price ?>" />

                    </td>

                    <td>

                        <input id="availablility<?= $noOfProperties."_".$rows["projects_id"] ?>" name="availablility[]" type="number" min="0" class="form-control" style="width:100px;" value="<?= $properties->availablility ?>" />

                    </td>

                    <td>

                        <input id="StartingDate<?= $noOfProperties."_".$rows["projects_id"] ?>" name="StartingDate[]" type="date" class="form-control" style="width:180px;" value="<?= $properties->StartingDate ?>" />

                    </td>

                    <td>

                        <input id="ExpectedEndingDate<?= $noOfProperties."_".$rows["projects_id"] ?>" name="ExpectedEndingDate[]" type="date" class="form-control" style="width:180px;" value="<?= $properties->ExpectedEndingDate ?>" />

                    </td>

                    <td>

                        <input id="EndingDate<?= $noOfProperties."_".$rows["projects_id"] ?>" name="EndingDate[]" type="date" class="form-control" style="width:180px;" value="<?= $properties->EndingDate ?>" />

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

                        <button type="button" name="remove" id="<?= $noOfProperties."_".$rows["projects_id"] ?>" class="btn btn-danger btn_remove">X</button>

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

    $(function() {

        //Multiple Rows Section Start ------------------------------------------------------------------------------------------------------------------   

        var i = <?= $noOfProperties ?>;



        $('#editAdd').click(function() {

            i++;

            $('#edit_dynamic_field').append('<tr id="row' + i + '<?= "_".$rows["projects_id"] ?>" class="dynamic-added" ><td><span class="p-3 mt-2">' + i + '.</span></td><td> <select id="propertyType' + i + '<?= "_".$rows["projects_id"] ?>" name="propertyType[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;"><?php $databaseObj->select("tbl_property_type");  $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1;  foreach($getData as $rows_prop): $property_type_info = json_decode($rows_prop["property_type_info"]); ?><option value="<?= $rows_prop["property_type_id"] ?>"><?= $property_type_info->propertyType ?></option>  <?php endforeach; endif; ?> </select></td><td><select id="accommodationType' + i + '<?= "_".$rows["projects_id"] ?>" name="accommodationType[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width:150px;"> <?php  $databaseObj->select("tbl_accommodation_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows_acco): $accommodation_type_info = json_decode($rows_acco["accommodation_type_info"]); ?> <option value="<?= $rows_acco["accommodation_type_id"] ?>"><?= $accommodation_type_info->accommodationType ?></option> <?php endforeach; endif; ?> </select> </td> <td>' +'<input id="squareFeet' + i + '<?= "_".$rows["projects_id"] ?>" name="squareFeet[]" type="number" min="0" class="form-control" style="width:150px;" /> </td> <td> <input id="price' + i + '<?= "_".$rows["projects_id"] ?>" name="price[]" type="number" min="0" class="form-control" style="width:150px;" /> </td> <td> <input id="availablility' + i + '<?= "_".$rows["projects_id"] ?>" name="availablility[]" type="number" min="0" class="form-control" style="width:100px;" /> </td><td><input id="StartingDate' + i + '<?= "_".$rows["projects_id"] ?>" name="StartingDate[]" type="date" class="form-control" style="width:180px;" /></td><td><input id="ExpectedEndingDate' + i + '<?= "_".$rows["projects_id"] ?>" name="ExpectedEndingDate[]" type="date" class="form-control" style="width:180px;" /></td><td><input id="EndingDate' + i + '<?= "_".$rows["projects_id"] ?>" name="EndingDate[]" type="date" class="form-control" style="width:180px;" /><small class="text-red">When this property will completed</small></td> <td><button type="button" name="remove" id="' + i + '<?= "_".$rows["projects_id"] ?>" class="btn btn-danger btn_remove">X</button></td></tr>');

            $("#editTotalProperty").val(i);

        });

        $(document).on('click', '.btn_remove', function() {

            var button_id = $(this).attr("id");

            $('#row' + button_id + '').remove();

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







<option value='{"propertyType":"<?=  $property_type_info->propertyType ?>","accommodationType":"<?=  $accommodation_type_info->accommodationType ?>","squareFeet":"<?= $properties->squareFeet  ?>"}'><?=  $property_type_info->propertyType ?>, <?= $accommodation_type_info->accommodationType  ?>, Sq. Feet - <?= $properties->squareFeet  ?></option>

<?php

                                endforeach;

                            endforeach;

                        endif;

                    

                    endif;

                endif;

                break;

                

            // ------------ Fetch Information Section End -----------

            // ------------------------------------------------------

        

                ?>

<?php

                   // ------------ Fetch Information Section End -----------

                    // ------------------------------------------------------

                    case "fetchProjectlocationDetails": 

                        if($authority == 1):

                            if(isset($_POST["project"]) && !empty($_POST["project"])):

                                $databaseObj->select("tbl_projects");

                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["project"]."'");

                                $getDataa = $databaseObj->get();

                                //Checking If Data Is Available

                                if($getDataa != 0):

                                    foreach($getDataa as $rowss):

                                        $projects_info = json_decode($rowss["projects_info"]);

                                        echo $projects_info->projectLocation;

                                    endforeach;

                                endif;

                            

                            endif;

                        endif;

                        break;

                

            // ------------ Fetch Information Section End -----------

           // ------------------------------------------------------

                    case "fetchItemNameDetails": 

                        if($authority == 1):

                            if(isset($_POST["itemCode"]) && !empty($_POST["itemCode"])):

                                $databaseObj->select("tbl_manage_item");

                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$_POST["itemCode"]."'");

                                //echo $databaseObj->error();exit();

                              

                                $getData = $databaseObj->get();

                                //Checking If Data Is Available

                                if($getData != 0):

                                    foreach($getData as $rows):?>

<option value="<?= $rows["itemName"] ?>"><?= $rows["itemName"] ?></option>

<?php endforeach;

                                endif;

                               

                            endif;

                        endif;

                        break;

                

            // ------------ Fetch Information Section End -----------

          // ------------ Fetch Information Section End -----------

                    

// ------------------------------------------------------

default:

?>

<script>

    $('#add-button').prop('disabled', false);

    $('#import-button').prop('disabled', false);



</script>

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

