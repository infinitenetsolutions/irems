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


                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/manage-stock.php">

                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_item">

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
                                       <!--  <th>Project</th> -->
                                        <th>Item Codes</th>

                                        <th>Item Name</th>

                                        <th>Item Category</th>

                                        <th>UOM</th>

                                        <th>Price</th>

                                        <th>QTY</th>

                                        <th>Re-order Level</th>

                                        <th>Last Issued</th>

                                        <th>Last Received</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>
                                   
<!--                                                        <?php
                                                       $databaseObj->select("tbl_manage_item");
                                                       if(empty($manage_employee_info->projectName))
                                                       {
                                                           $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        }else
                                                        {                                            
                                                          $databaseObj->where("`projectName`='".$manage_employee_info->projectName."' && `status` = '".$auth->visible()."'");
                                                       }?> -->
                                                     
                                                <?php  
                                           // endforeach;

                             
                                                 
                                                        $databaseObj->select("tbl_manage_item");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $databaseObj->order_by("`manage_item_id` DESC");
                                                        $getData = $databaseObj->get();
                                                       
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $rows):
                                                                $manage_item_log = json_decode($rows["manage_item_log"]);

                                                
                                
                                                       ?>

                                   
                                    

                                        
                                                    <tr>

                                                        <td class="text-center">

                                                            <div class="icheck-navy d-inline">
                                                               
                                                                <input type="checkbox" id="checkbox-<?= $rows["manage_item_id"] ?>" name="checkbox-select[]" value="<?= $rows["manage_item_id"] ?>" class="check-project-id check-table" data-project-id="<?= $rows["projectName"] ?>">

                                                                <label for="checkbox-<?= $rows["manage_item_id"] ?>">

                                                                </label>

                                                            </div>

                                                        </td>
                                                      
                                                        
                                                        <td><?= $sno ?>.</td>



                                                        <td><?= $rows["itemCode"] ?></td>

                                                        <td><?= $rows["itemName"] ?></td>
                                                         <?php
                                                          $databaseObj->select("tbl_manage_category");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$rows["itemCategory"]."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                                $manage_category_info = json_decode($rows_deptt["manage_category_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td><?= $manage_category_info->categoryName ?> </td>
                                                        <!-- <td><?= $rows["itemCategory"] ?></td> -->

                                                        <td><?= $rows["Uom"] ?></td>

                                                        <td><?= $rows["Price"] ?></td>

                                                       

                                                        <?php if ($rows["ReOrder"] > $rows["Qty"]) {

                                                        $class = "red";

                                                        } else {

                                                        $class = "";

                                                        }?><td style=" color: <?php echo $class; ?>"><?php echo $rows["Qty"]; ?>





                                                            </td>

                                                        <td><?= $rows["ReOrder"] ?></td>

                                                        <td><?= $rows["lastIssued"] ?></td>

                                                        <td><?= $rows["lastReceived"] ?></td>

                                                        <td class="text-center">

                                                           <!--  <button type="button" id="information-button-<?= $rows["manage_item_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">

                                                                <i class="fa fa-scroll fa-sm"></i>

                                                            </button> -->

                                                            <!-- <button type="button" id="see-button-<?= $rows["manage_item_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See">

                                                                <i class="fa fa-eye fa-sm"></i>

                                                            </button> -->

                                                             <button type="button" id="edit-button-<?= $rows["manage_item_id"] ?>" class="edit-button btn btn-xxl btn-warning mt-1 mb-1" title="Click here to add Items in your Stock">

                                                                <i class="fa fa-edit fa-sm"></i>

                                                            </button>

                                                        </td>

                                                    </tr>

                                                    <script>

                                                       

                                                        // Edit Section Start ---------------------------------------------------------------

                                                        $("#edit-button-<?= $rows["manage_item_id"] ?>").click(function () {

                                                            $("#edit-modal").modal('show');

                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

                                                            var formData = {"action":"fetchEdit","id":"<?= $rows["manage_item_id"] ?>"};

                                                            $.ajax({

                                                                url: 'application/view/admin/manage-stock.php',

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

                                                        $("#delete-button-<?= $rows["manage_item_id"] ?>").click(function () {

                                                            $("#delete-modal").modal('show');

                                                            $('#deleteButton').prop('disabled', true);

                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');

                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["manage_item_id"] ?>"};

                                                            $.ajax({

                                                                url: 'application/view/admin/manage-stock.php',

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
                                        // endforeach;

                                        // endif;
                                        //  endforeach;

                                        // endif;
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

                        $databaseObj->select("tbl_manage_item");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$_POST["id"]."'");

                        $databaseObj->order_by("`manage_item_id` DESC");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            foreach($getData as $rows):

                                $manage_item_log = json_decode($rows["manage_item_log"]);

                                ?>

                                    <div class="row">

                                        <?php

                                            $sno = 1;

                                            foreach($manage_item_log as $manage_item_log_info):

                                            ?>

                                                <div class="col-md-12">

                                                    <div class="card">

                                                        <div class="card-header d-flex p-0">

                                                            <ul class="nav nav-pills ml-auto p-2">

                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($manage_item_log_info->action) ?> By</a></li>

                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>

                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>

                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>

                                                            </ul>

                                                        </div><!-- /.card-header -->

                                                        <div class="card-body">

                                                            <div class="tab-content">

                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($manage_item_log_info->action) ?> By -

                                                                    <?php

                                                                        if($manage_item_log_info->by == $auth->admin_id):

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

                                                                    <?= date("l, M d, Y", strtotime($manage_item_log_info->date)) ?> At <?= $manage_item_log_info->at ?>

                                                                </div>

                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>

                                                                    <?= $manage_item_log_info->ip ?>

                                                                </div>

                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">

                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>

                                                                    <?php

                                                                        $latLangArray = explode(",", $manage_item_log_info->location);

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

                        $databaseObj->select("tbl_manage_item");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$_POST["id"]."'");

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

                if($authority == 1):

                    if(isset($_POST["id"]) && !empty($_POST["id"])):

                        $databaseObj->select("tbl_manage_item");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$_POST["id"]."'");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            foreach($getData as $rows):

                                ?>


<!--                                                 <label for="project">Item Code</label> -->
                                                 <?php 
                       
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
                                                      if($getData != 0):
                                                    
                                                        foreach($getData as $rowemployee):
                                                           $manage_employee_info = json_decode($rowemployee["manage_employee_info"]);
                                                                // print_r($manage_employee_info);
                                                          $databaseObj->select("tbl_projects");
                                                          $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id`='".$manage_employee_info->project."'");
                                                          $databaseObj->order_by("`projects_id` DESC");
                                                          $getData = $databaseObj->get();
                                                           //Checking If Data Is Available
                                                          if($getData != 0):
                                                               
                                                             foreach($getData as $rowproject):
                                                               $projects_info = json_decode($rowproject["projects_info"]);
                                                             ?>
                                                                 <input type="hidden"  class="form-control" id="project" name="project" value="<?=$rowproject["projects_id"]?>">
                                                                 <?php
                                                             endforeach;
                                                           endif;
                                                        endforeach;    
                                                    endif;
                                                endforeach;
                                              endif;  

?>

                                                

                                            


                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="ItemCode">Item Code</label>


                                                <input type="hidden" class="form-control" id="ItemCode" name="ItemCode"  value="<?= $rows["manage_item_id"] ?>" readonly>
                                                <input type="text" class="form-control" placeholder="Item Code" value="<?= $rows["itemCode"] ?>" readonly>


                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editItemName">Item Name</label>

                                                <input type="hidden" class="form-control" id="ItemName" name="ItemName"  value="<?= $rows["manage_item_id"] ?>" readonly>
                                                <input type="text" class="form-control" placeholder="Item Name" value="<?= $rows["itemName"] ?>" readonly>


                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="ItemCategory">Item Category</label>
                                                 <input type="hidden" id="ItemCategory" name="ItemCategory" class="form-control" value="<?= $rows['itemCategory'] ?>">

                                                <select class="form-control"  placeholder="Item Category" readonly >
                
                                                  <?php

                                                  $databaseObj->select("tbl_manage_category");

                                                  $databaseObj->where("`status` = '".$auth->visible()."'");

                                                  $getCategoryData = $databaseObj->get();

                                                if($getCategoryData != 0):

                                                    foreach($getCategoryData as $categoryrows):

                                                        $manage_category_info = json_decode($categoryrows["manage_category_info"]);

                                                 ?>
                                                    
                                                 <option value="<?= $categoryrows["manage_category_id"] ?>" <?php if ($rows["itemCategory"] == $categoryrows["manage_category_id"]) { echo "selected"; } ?> disabled><?= $manage_category_info->categoryName ?>
                                                    
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

                                                <label for="Uom">UOM</label>
                                                 <input type="hidden" class="form-control" id="Uom" name="Uom"  value="<?= $rows["manage_item_id"] ?>" readonly>
                                                

                                                <input type="text" class="form-control" placeholder="Item UOM" value="<?= $rows["Uom"] ?>" readonly>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="editItemPrice">Price</label>

                                                <input type="number" class="form-control" id="Price" name="Price" value="<?= $rows["Price"] ?>" readonly>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="Qty">Qty</label>

                                                <input type="number" class="form-control" id="Qty" name="Qty" value="<?= $rows["Qty"] ?>">

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="ReOrder">Re-Order Level</label>

                                                <input type="number" class="form-control" id="ReOrder" name="ReOrder" value="<?= $rows["ReOrder"] ?>" readonly>

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

                        <input type="hidden" id="tableName" name="tableName" value="tbl_manage_item" />

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

