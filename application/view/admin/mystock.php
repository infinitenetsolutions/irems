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

    $manageItemStoreDir = "../../../assets/admin/manage-items/";

    $manageItemDir = "assets/admin/manage-items/";
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

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


                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/mystock.php">

                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_stock">

                        <input type="hidden" id="action" name="action" value="fetchData">

                        <table id="example1" class="table table-bordered table-striped">



                                <thead>

                                    <tr>

                                        <th class="text-center">

                                            <div class="icheck-navy d-inline">

                                                <input type="checkbox" id="check-all" name="check-all" title="Check All" value="all" onclick="SelectChkbox();">

                                                <label for="check-all" title="Check All">

                                                </label>

                                            </div>

                                        </th>

                                        <th>S. No.</th>
                                        <th>Project</th>
                                        <th>Item Code</th>

                                        <th>Item Name</th>

                                        <th>Item Category</th>

                                        <th>UOM</th>

                                        <th>Price</th>

                                        <th>QTY</th>

                                        <th>Re-order Level</th>

                                        <th>Last Issued</th>

                                        <th>Last Received</th>

                                        <th id="action" class="action_col">Action</th>

                                    </tr>

                                </thead>

                                <tbody>
                                   
                                     <?php
                                            $databaseObj->select("tbl_manage_stock");
                                            $databaseObj->where("`status` = '".$auth->visible()."'");
                                            $databaseObj->order_by("`manage_stock_id` DESC");
                                            $getData = $databaseObj->get();
                                           
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $rowsmanage):
                                                                $manage_stock_log = json_decode($rowsmanage["manage_stock_log"]);
                                                          
                       
                                                               $databaseObj->select("tbl_admin");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                                                               $databaseObj->order_by("`admin_id` DESC");
                                                               $getData = $databaseObj->get();
                                                               //Checking If Data Is Available
                                                               if($getData != 0):
                                                    
                                                                 foreach($getData as $rowadmin):
                                                                   $admin_info = json_decode($rowadmin["admin_info"]);
                                                                   $admin_log_info = json_decode($rowadmin["admin_log_info"]);

                                                                   $databaseObj->select("tbl_manage_employee");
                                                                   $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                                                   $databaseObj->order_by("`manage_employee_id` DESC");
                                                                   $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                  if($getData !=0):
                                                                    foreach($getData as $rowemployee):
                                                                         $manage_employee_info = json_decode($rowemployee["manage_employee_info"]);
                                                                            if($manage_employee_info->project == $rowsmanage['project']):
                                                            ?>

                                                    <tr>

                                                        <td class="text-center">

                                                            <div class="icheck-navy d-inline">

                                                                <input type="checkbox" id="checkbox-<?= $rowsmanage["manage_stock_id"] ?>" name="checkbox-select[]" value="<?= $rowsmanage["manage_stock_id"] ?>" class="check-project-id check-table" data-project-id="<?= $rowsmanage["project"] ?>">

                                                                <label for="checkbox-<?= $rowsmanage["manage_stock_id"] ?>">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td><?= $sno ?>.</td>
                                                        <?php 
                       
                                                         $databaseObj->select("tbl_projects");
                                                         $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id`='".$manage_employee_info->project."'");
                                                         $databaseObj->order_by("`projects_id` DESC");
                                                         $getData = $databaseObj->get();
                                                          if($getData !=0):
                                                                    foreach($getData as $rowsproject):
                                                                         $projects_info = json_decode($rowsproject["projects_info"]);
                                                                    endforeach;
                                                          endif;               ?>
          

                                                         <td><?= $projects_info->projectName ?></td>
                                                         <?php 
                       
                                                         $databaseObj->select("tbl_manage_item");
                                                         $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id`='".$rowsmanage['itemCode']."'");
                                                         $databaseObj->order_by("`manage_item_id` DESC");
                                                         $getData = $databaseObj->get();
                                                         // echo "<pre>";
                                                         // print_r($getData);
                                                         // echo "</pre>";
                                                         //Checking If Data Is Available
                                                         if($getData != 0):
                                                            
                                                            foreach($getData as $rowstock):
                                                             endforeach;  
                                                         endif;  
                                                               ?>
                                                         <td><?= $rowstock["itemCode"] ?></td>

                                                        

                                                        <td><?= $rowstock["itemName"] ?></td>
                                                         <?php
                                                          $databaseObj->select("tbl_manage_item");
                                                         $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id`='".$rowsmanage['itemCategory']."'");
                                                         $databaseObj->order_by("`manage_item_id` DESC");
                                                         $getData = $databaseObj->get();
                                                         // echo "<pre>";
                                                         // print_r($getData);
                                                         // echo "</pre>";
                                                         //Checking If Data Is Available
                                                         if($getData != 0):
                                                            
                                                            foreach($getData as $rowstock):
                                                             endforeach;  
                                                         endif;  
                                                          $databaseObj->select("tbl_manage_category");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$rowstock["itemCategory"]."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                                $manage_category_info = json_decode($rows_deptt["manage_category_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td><?= $manage_category_info->categoryName ?></td>
                                                        

                                                        <td><?= $rowstock["Uom"] ?></td>

                                                        <td><?= $rowsmanage["Price"] ?></td>

                                                       

                                                        <?php if ($rowsmanage["ReOrder"] > $rowsmanage["Qty"]) {

                                                        $class = "red";

                                                        } else {

                                                        $class = "";

                                                        }?><td style=" color: <?php echo $class; ?>"><?php echo $rowsmanage["Qty"]; ?>

                                                            </td>

                                                        <td><?= $rowsmanage["ReOrder"] ?></td>

                                                        <td><?= $rowsmanage["lastIssued"] ?> </td>

                                                        <td><?= $rowsmanage["lastReceived"] ?> </td>

                                                        <td class="text-center">
                                                            <?php

                       
                                                         // $databaseObj->select("tbl_projects");
                                                         // $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id`='".$manage_employee_info->project."'");
                                                         // $databaseObj->order_by("`projects_id` DESC");
                                                         // $getData = $databaseObj->get();
                                                         // // echo "<pre>";
                                                         // //  print_r($getData);
                                                         // //  echo "</pre>";
                                                         //  if($getData !=0):
                                                                    // foreach($getData as $rowssproject):
                                                                         $commit_edit = $rowsproject["commit_edit"];
                                                                         $commit_delete = $rowsproject["commit_delete"];
                                                                         // print_r($commit_edit);
                                                          //           endforeach;
                                                          // endif;  
                                                                if($commit_edit=='1'){
                                                            ?>
                                                            <script>
                                                             $('#edit-button-<?= $rowsmanage["manage_stock_id"] ?>').css("display", "none");
                                                              $('#commit-button').css("display", "none");
                                                             // $('#action').css("display", "none");
                                                            </script>
                                                            <?php } ?>
                                                             <?php
                                                                if($commit_delete =='1'){

                                                            ?>
                                                            <script>
                                                             $('#delete-button-<?= $rowsmanage["manage_stock_id"] ?>').css("display", "None");
                                                              $('#commit-button').css("display", "none");
                                                             // $('#action').css("display", "None");
                                                            </script>
                                                            <?php } ?>
                                                    
                                                             <button type="button" id="edit-button-<?= $rowsmanage["manage_stock_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update"><i class="fa fa-edit fa-sm"></i></button>
                                                            
                                                             <button type="button" id="delete-button-<?= $rowsmanage["manage_stock_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">

                                                                <i class="fa fa-trash fa-sm"></i>

                                                            </button>

                                                        </td>

                                                    </tr>
                                                   

                                                    <script>

                                                       

                                                        // Edit Section Start ---------------------------------------------------------------
                                                        
                                                        $("#edit-button-<?= $rowsmanage["manage_stock_id"] ?>").click(function () {


                                                            $("#edit-modal").modal('show');

                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

                                                            var formData = {"action":"fetchEdit","id":"<?= $rowsmanage["manage_stock_id"] ?>"};

                                                            $.ajax({

                                                                url: 'application/view/admin/mystock.php',

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

                                                        $("#delete-button-<?= $rowsmanage["manage_stock_id"] ?>").click(function () {
                                                            $("#delete-modal").modal('show');
                                                            $('#deleteButton').prop('disabled', true);

                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

                                                            var formData = {"action":"fetchDelete","id":"<?= $rowsmanage["manage_stock_id"] ?>"};

                                                            $.ajax({

                                                                url: 'application/view/admin/mystock.php',

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

                                                   endif;
                                                    endforeach;
                                                 endif;  
                                        endforeach;

                                        endif;
                                         endforeach;

                                        endif;
                                        //  endforeach;

                                        // endif;

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
                                        <th class="action_col"></th>

                                    </tr>

                                </tfoot>



                        </table>

                    </form>

                    <script>

                        $('#add-button').prop('disabled', false);

                        $('#import-button').prop('disabled', false);

                    </script>

                    <script src="dist/js/admin/for-all-tables.js"></script>



                    <script>

                        function SelectChkbox()

                        {

                                var oInputs = document.getElementsByTagName('input');

                                if(document.getElementById("checkall").checked == true) {

                                var ischked = true;

                        }
                        else
                        {

                        var ischked = false;

                        }

                        for ( i = 0; i < oInputs.length; i++ )

                        {

                        // loop through and find <input type="checkbox"/>

                        if (oInputs[i].type == 'checkbox')

                        {

                        var chk_box = oInputs[i].id;

                        document.getElementById(chk_box).checked = ischked;

                        }

                        }

                        activateCreateIndent();

                        }





                        </script>                                    



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

                        $databaseObj->select("tbl_manage_stock");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_stock_id` = '".$_POST["id"]."'");

                        $databaseObj->order_by("`manage_stock_id` DESC");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            foreach($getData as $rows):

                                $manage_stock_log = json_decode($rowsmanage["manage_stock_log"]);

                                ?>

                                    <div class="row">

                                        <?php

                                            $sno = 1;

                                            foreach($manage_stock_log as $manage_stock_log_info):

                                            ?>

                                                <div class="col-md-12">

                                                    <div class="card">

                                                        <div class="card-header d-flex p-0">

                                                            <ul class="nav nav-pills ml-auto p-2">

                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($manage_stock_log_info->action) ?> By</a></li>

                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>

                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>

                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>

                                                            </ul>

                                                        </div><!-- /.card-header -->

                                                        <div class="card-body">

                                                            <div class="tab-content">

                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($manage_stock_log_info->action) ?> By -

                                                                    <?php

                                                                        if($manage_stock_log_info->by == $auth->admin_id):

                                                                            echo "You";

                                                                        else:

                                                                            $databaseObj->select("tbl_admin");

                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$manage_item_log_info->by."'");

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

                                                                    <?= date("l, M d, Y", strtotime($manage_stock_log_info->date)) ?> At <?= $manage_stock_log_info->at ?>

                                                                </div>

                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>

                                                                    <?= $manage_stock_log_info->ip ?>

                                                                </div>

                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>

                                                                    <?php

                                                                        $latLangArray = explode(",", $manage_stock_log_info->location);

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

                        $databaseObj->select("tbl_manage_stock");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_stock_id` = '".$_POST["id"]."'");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            foreach($getData as $rows):

                                ?>

                                        <div class="row">

                                            <div class="col-md-6">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Item Code</h5>

                                                    <?= $rows["itemCode"] ?>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Item Name</h5>

                                                    <?= $rows["itemName"] ?>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Item Category</h5>

                                                    <?= $rows["itemCategory"] ?>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">UOM</h5>

                                                    <?= $rows["Uom"] ?>

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Price</h5>

                                                    <?= $rows["Price"] ?>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">QTY</h5>

                                                    <?= $rows["Qty"] ?>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Re-order Level</h5>

                                                    <?= $rows["ReOrder"] ?>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Last Issued</h5>

                                                    <?= $rows["lastIssued"] ?>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="callout callout-danger">

                                                    <h5 class="text-bold">Last Received</h5>

                                                    <?= $rows["lastReceived"] ?>

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
             // echo "<pre>";
             //            print_r($_POST["id"]);
             //            echo "</pre>";

                if($authority == 1):

                    if(isset($_POST["id"]) && !empty($_POST["id"])):

                        $databaseObj->select("tbl_manage_stock");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_stock_id` = '".$_POST["id"]."'");

                        $getData = $databaseObj->get();
                        // echo "<pre>";
                        // print_r($getData);
                        // echo "</pre>";

                        //Checking If Data Is Available

                        if($getData != 0):

                            foreach($getData as $rowsmanage):

                                ?>
                                <div class="row">
                                     <input type="hidden" class="form-control" id="editproject" name="editproject"  value="<?= $rowsmanage["project"] ?>" readonly>
                                                <!-- <input type="text" class="form-control" placeholder="Item Code" value="<?= $rowstock["itemCode"] ?>" readonly> -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editItemCode">Item Code</label>
                                                  <?php 
                       
                                                         $databaseObj->select("tbl_manage_item");
                                                         $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id`='".$rowsmanage['itemCode']."'");
                                                         $databaseObj->order_by("`manage_item_id` DESC");
                                                         $getData = $databaseObj->get();
                                                         // echo "<pre>";
                                                         // print_r($getData);
                                                         // echo "</pre>";
                                                         //Checking If Data Is Available
                                                         if($getData != 0):
                                                            
                                                            foreach($getData as $rowstock):
                                                             endforeach;  
                                                         endif;  ?>

                                                <input type="hidden" class="form-control" id="editItemCode" name="editItemCode"  value="<?= $rowstock["manage_item_id"] ?>" readonly>
                                                <input type="text" class="form-control" placeholder="Item Code" value="<?= $rowstock["itemCode"] ?>" readonly>


                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editItemName">Item Name</label>

                                                <input type="hidden" class="form-control" id="editItemName" name="editItemName"  value="<?= $rowstock["manage_item_id"] ?>" readonly>
                                                <input type="text" class="form-control" placeholder="Item Name" value="<?= $rowstock["itemName"] ?>" readonly>


                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editItemCategory">Item Category</label>
                                                 <input type="hidden" id="editItemCategory" name="editItemCategory" class="form-control" value="<?= $rowstock['itemCategory'] ?>">

                                                <select class="form-control"  placeholder="Item Category" readonly >
                
                                                  <?php

                                                  $databaseObj->select("tbl_manage_category");

                                                  $databaseObj->where("`status` = '".$auth->visible()."'");

                                                  $getCategoryData = $databaseObj->get();

                                                if($getCategoryData != 0):

                                                    foreach($getCategoryData as $categoryrows):

                                                        $manage_category_info = json_decode($categoryrows["manage_category_info"]);

                                                 ?>
                                                    
                                                 <option value="<?= $categoryrows["manage_category_id"] ?>" <?php if ($rowstock["itemCategory"] == $categoryrows["manage_category_id"]) { echo "selected"; } ?> disabled><?= $manage_category_info->categoryName ?>
                                                    
                                                 </option>

                                                 <?php

                                                   endforeach;

                                                 endif;

                                                 ?>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editUom">UOM</label>

                                                 <input type="hidden" class="form-control" id="editUom" name="editUom"  value="<?= $rowstock["manage_item_id"] ?>" readonly>
                                                

                                                <input type="text" class="form-control" placeholder="Item UOM" value="<?= $rowstock["Uom"] ?>" readonly>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editItemPrice">Price</label>

                                                <input type="number" class="form-control" id="editItemPrice" name="editItemPrice" value="<?= $rowsmanage["Price"] ?>" readonly>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editQty">Qty</label>

                                                <input type="number" class="form-control" id="editQty" name="editQty" value="<?= $rowsmanage["Qty"] ?>">

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editReOrder">Re-Order Level</label>

                                                <input type="number" class="form-control" id="editReOrder" name="editReOrder" value="<?= $rowsmanage["ReOrder"] ?>" readonly>

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
            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";

                if($authority == 1):

                    if(isset($_POST["id"]) && !empty($_POST["id"])):

                        ?>

                        <div class="alert alert-danger alert-dismissible">

                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>

                            Do you really wanna delete this data???

                        </div>

                        <input type="hidden" id="tableId" name="tableId" value="<?= $_POST["id"] ?>" />

                        <input type="hidden" id="tableName" name="tableName" value="tbl_manage_stock" />

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

