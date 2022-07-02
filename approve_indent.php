<?php
   require_once("application/classes-and-objects/config.php");
  require_once("application/classes-and-objects/veriables.php");
  require_once("application/classes-and-objects/authentication.php");
  require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");
?>  
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
</head>
<?php
  $auth = new AUTHENTICATION($databaseObj);
    
    if(isset($_GET["id"]) && !empty($_GET["id"])):
       
                           $databaseObj->select("tbl_manage_indent");
                           $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$_GET["id"]."'");
                           $databaseObj->order_by("`manage_indent_id` DESC");
                            $getData = $databaseObj->get();
                            //Checking If Data Is Available
                            if($getData != 0):
                                foreach($getData as $rows):
                                    $manage_indent_log = json_decode($rows["manage_indent_log"]);
                                    $manage_indent_info = json_decode($rows["manage_indent_info"]);

                                    ?>

               

                <form id="editForm" method="POST" enctype="multipart/form-data" >
                 <input type="hidden" name="approveTableId" id="approveTableId" value="<?= $_GET["id"] ?>" />
                <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_indent">
                <input type="hidden" id="action" name="action" value="approveIndent">
                <input type="hidden" id="secondaryLocation" name="checkLocation" />
                 <input type="hidden" id="secondaryIp" name="checkIp" />
                    <section class="content">
                      <div class="container-fluid">
                        <div class="card card-default">
                          <div class="card-header">
                            <h3 class="card-title">Indent Details</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                                <div class="col-md-1">
                                  <div class="form-group">
                                    <label>Indent No</label>
                                    <input class="form-control form-control-sm" name="indentNo" id="indentNo" type="text" value="<?= $manage_indent_info->indentNo ?>" readonly>
                                  </div>
                                </div>

                                <div class="col-md-1">
                                  <div class="form-group">
                                    <label>Indent Date</label>
                                    <input class="form-control form-control-sm" name="indentDate" id="indentDate" type="text" value="<?= $manage_indent_info->indentDate ?>"readonly>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Indent Created By</label>
                                    <?php
                                                            foreach($manage_indent_log as $manage_indent_log_info):
                                                              // echo $manage_indent_log_info->by;
                                                                $databaseObj->select("tbl_admin");
                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$manage_indent_log_info->by."'");
                                                                $getData = $databaseObj->get();

                                                                //Checking If Data Is Available

                                                                if($getData != 0):

                                                                 foreach($getData as $rows):

                                                                  $admin_info = json_decode($rows["admin_info"]);
                          
                                                                
                                                           
                                                                // echo $manage_indent_log_info->by;
                                                                $databaseObj->select("tbl_manage_employee");

                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$admin_info->empId."'");

                                                                $getData = $databaseObj->get();

                                                                //Checking If Data Is Available

                                                                if($getData != 0):

                                                                 foreach($getData as $rows):

                                                                  $manage_employee_info = json_decode($rows["manage_employee_info"]);
                          
                                                                 endforeach;

                                                                endif;
                                                                
                                                            endforeach;
                                                             endif;
                                                              endforeach;
                                                                 
                                                                

                                                                        ?>
                                    <input class="form-control form-control-sm" type="text" value="<?= $manage_employee_info->firstName; ?><?= $manage_employee_info->lastName; ?>"readonly>
                                     <input class="form-control form-control-sm" name="indentCreated" id="indentCreated" type="hidden" value="<?= $rows["manage_employee_id"]; ?>"readonly>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Designation(Indent Created)</label>
                                    <?php
                                    $databaseObj->select("tbl_manage_designation");

                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$manage_employee_info->designation."'");

                                                                $getData = $databaseObj->get();

                                                                //Checking If Data Is Available

                                                                if($getData != 0):

                                                                 foreach($getData as $rows):

                                                                  $manage_designation_info = json_decode($rows["manage_designation_info"]);
                          
                                                                 endforeach;

                                                                endif;?>
                                    
                                     <input class="form-control form-control-sm"  type="text" value="<?= $manage_designation_info->designationName; ?>"readonly>
                                     <input class="form-control form-control-sm" name="indentCreatedDesignation" id="indentCreatedDesignation" type="hidden" value="<?= $rows["manage_designation_id"]; ?>"readonly>
                                  </div>
                                </div>
                                <?php
                                foreach($getData as $rows):
                                            $databaseObj->select("tbl_projects");
                                            $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_indent_info->employee_project."'");
                                            $getDataPro = $databaseObj->get();
                                            //Checking If Data Is Available
                                            if($getDataPro != 0):
                                              foreach($getDataPro as $rowsPro):
                                                $projects_info = json_decode($rowsPro["projects_info"]);
                                               endforeach;
                                            endif;
                                endforeach;
                                ?>                
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Project</label>
                                    <input class="form-control form-control-sm" name="employee_project" id="employee_project" type="hidden" value="<?= $manage_indent_info->employee_project ?>"readonly>
                                     <input class="form-control form-control-sm" type="text" value="<?= $projects_info->projectName ?>"readonly>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Requistion No</label>
                                               <input class="form-control form-control-sm" name="employee_req" id="employee_req" type="text" value="<?= $manage_indent_info->employee_req ?>" readonly>   
                                        </div>
                                </div>                
                            </div>
                          </div>
                        </div>
                      </div>  
                    </section>
                    
                                
                            
                          
                             
                               
                           <!--  </div>
                          </div>
                        </div>
                        </div> -->
                    <section class="content">
                      <div class="container-fluid">
                        <div class="card card-default">
                          <div class="card card-default">
                              <div class="card-header">
                               <h3 class="card-title">Indent Approved By: </h3>

                                <div class="card-tools">
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                </div>
                              </div>
                                    <?php
                                      $databaseObj->select("tbl_manage_employee");
                                      $databaseObj->where("`status` = '".$auth->visible()."'");
                                      $getData = $databaseObj->get();
                                    ?>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Employee </label>
                                      <?php
                                      $databaseObj->select("tbl_manage_employee");
                                      $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$manage_indent_info->employee_approval."'");
                                      $getData = $databaseObj->get();
                                      if($getData != 0):
                                        foreach($getData as $rows_deptt):
                                          $manage_employee_info = json_decode($rows_deptt["manage_employee_info"]);
                                        endforeach;
                                      endif;
                                      ?>
                                      <input class="form-control form-control-sm"  type="text" value="<?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>" readonly>
                                      <input class="form-control form-control-sm" name="employee_approval" id="employee_approval" type="hidden" value="<?= $manage_indent_info->employee_approval ?>" readonly> 
                                   </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Designation</label>
                                      <?php
                                      $databaseObj->select("tbl_manage_designation");
                                      $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$manage_indent_info->employee_designation_approval."'");
                                      $getData = $databaseObj->get();
                                      if($getData != 0):
                                        foreach($getData as $rows_deptt):
                                          $manage_designation_info = json_decode($rows_deptt["manage_designation_info"]);
                                        endforeach;
                                      endif;
                                      ?>
                                      <input class="form-control form-control-sm"  type="text" value="<?= $manage_designation_info->designationName ?>" readonly>
                                      <input class="form-control form-control-sm" name="employee_designation_approval" id="employee_designation_approval" type="hidden" value="<?= $manage_indent_info->employee_designation_approval ?>" readonly>
                                    </div>   
                                  </div> 
                                  <div class="col-md-4">           
                                    <div class="form-group">
                                      <label>Email</label>
                                      <input class="form-control form-control-sm" name="employee_email_approval"   type="text" value="<?= $manage_indent_info->employee_email_approval ?>" readonly>
                                      <input class="form-control form-control-sm" name="employee_email_approval" id="employee_email_approval" type="hidden" value="<?= $manage_indent_info->employee_email_approval ?>" readonly>
                                    </div>
                                  </div>  
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section class="content">
                      <div class="container-fluid">
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title">For 2nd level Approval: </h3>

                                <div class="card-tools">
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                </div>
                              </div>
                                    <?php
                                      $databaseObj->select("tbl_manage_employee");
                                      $databaseObj->where("`status` = '".$auth->visible()."'");
                                      $getData = $databaseObj->get();
                                    ?>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Select Employee for Next Level Approval </label>
                                        <select class="form-control form-control-sm select2" name="employee_approval_po" id='employee_approval_po' style="width: 100%;">
                                          <option value="">Select</option>
                                            <?php
                                              foreach ($getData as $rows):
                                                $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                                ?>

                                                <option value="<?= $rows["manage_employee_id"] ?>"><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?></option>
                                                <?php
                                              endforeach;
                                                ?>
                                        </select> 

                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div id="employee_sec">
                                      <div id="viewdetails">
                            
                               
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input class="form-control form-control-sm" name="employee_designation_approval_po"  id="employee_designation_approval_po" type="text" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control form-control-sm" name="employee_email_approval_po"  id="employee_email_approval_po" type="text" readonly>
                                        </div>
                                      </div>
                                    </div>   
                                  </div>  
                                </div>              
                              </div>          
                          </div> 
                      </div>       
                    </section>               
                    
                    <section class="content">
                      <div class="container-fluid">
                       <div class="card card-default">
                         <div class="card-header">
                        <h3 class="card-title">Indent Items</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                       </div>
                         <div class="card-body">
                          <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">

                              <tr>
                                <th width="5%">S.NO</th>
                                <th width="7%">Item Code</th>
                                <th>Item Name</th>
                                <th>Item Category</th>
                                <th>UOM</th>
                                <th width="5%">Quantity</th>
                               <!-- <th width="5%">Requistion Quantity</th>-->
                                <th>Remark</th>
                                <!-- <th width="8%">Rate</th>
                                <th width="10%">Amount</th>
                                <th width="5%">Cgst%</th>
                                <th width="5%">Sgst%</th>
                                <th width="5%">Igst%</th>
                                <th width="10%">Total Amount</th> -->
                                <!-- <th width="5%">Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th> -->
                              </tr>
                            <?php
                            $cnt = 1;
                            foreach ($manage_indent_info->item_info as $item_info):  ?>
                                <td width="5%"><?= $cnt ?>.</td>

                                                   
                                   <?php                 $databaseObj->select("tbl_manage_item");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$item_info->itemName."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        foreach($getData as $rows_deptt):
                                                            $itemName = $rows_deptt["itemName"];
                                                            $itemCode = $rows_deptt["itemCode"];
                                                            $itemCategory = $rows_deptt["itemCategory"];
                                                            $Uom = $rows_deptt["Uom"];
                                                            $Qty = $rows_deptt["Qty"];
                                  
                                  
                                       //$databaseObj->select("tbl_manage_stock");
                                       //$databaseObj->where("`status` = '".$auth->visible()."'&& `manage_stock_id` = '".$item."'");
                                      // $getStockData = $databaseObj->get();
                                      // $databaseObj->select("tbl_manage_item");
                                       //$databaseObj->where("`status` = '".$auth->visible()."'&& `manage_item_id`='". $getStockData[0]["itemCode"]."'");
                                      // $getData = $databaseObj->get(); 
                                      // foreach($getData as $rows):
                                      // endforeach;
                                                       
                                          ?>
                
                              
                                <td><input class="form-control form-control-sm"  type="text" value="<?= $itemCode ?>" readonly>
                                <input class="form-control form-control-sm" name="item_code_approve[]" id="item_code_approve[<?php echo $cnt; ?>]" type="hidden" value="<?= $rows_deptt["manage_item_id"] ?>" readonly></td>
                                <td><input class="form-control form-control-sm" type="text" value="<?= $itemName ?>" readonly>
                                 <input class="form-control form-control-sm" name="item_name_approve[]" id="item_name_approve[<?php echo $cnt; ?>]" type="hidden" value="<?= $rows_deptt["manage_item_id"] ?>" readonly></td>
                                 <?php
                                $databaseObj->select("tbl_manage_category");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$itemCategory."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        foreach($getData as $rows_category):
                                                            $manage_category_info = json_decode($rows_category["manage_category_info"]);
                                                        endforeach;
                                                    endif;
                                        ?>
                                                    
                                                       
                               <td><input class="form-control form-control-sm"  type="text" value="<?= $manage_category_info->categoryName ?>" readonly>
                               <input class="form-control"  type="hidden"  name="item_category_approve[]" id="item_category[<?php echo $cnt; ?>]" value="<?= $rows_category["manage_category_id"] ?>" readonly></td>
                                  <td><input class="form-control form-control-sm"  type="text" value="<?= $Uom ?>" readonly>
                                  <input class="form-control form-control-sm" name="uom_approve[]" id="uom_approve[<?php echo $cnt; ?>]" type="hidden" value="<?= $rows_deptt["manage_item_id"] ?>"  readonly></td>
                                   <td><input class="form-control form-control-sm" name="quantity_approve[]" id="tonne_id_approve[<?php echo $cnt; ?>][tonne]" type="text" value="<?= $item_info->quantity ?>"readonly></td>
                                  <!--<td><input class="form-control form-control-sm" name="quantity_approve[]" id="tonne_id_approve[<?php echo $cnt; ?>][tonne]" type="text" value="<?//= $item_info->quantity ?>"readonly></td>-->
                                <td><input class="form-control form-control-sm" name="remark_approve[]" id="remark_id_approve[<?php echo $cnt; ?>][remark]" type="text" value="<?= $item_info->remark ?>" readonly></td>
                                
                                
                                
                               
                               
                                
                            </tr>
                            <?php
                                            
                          

                                                  endforeach;
                                                    endif;
                                                        $cnt++;
                                                endforeach;
                                                
                                ?>
                            </table>
                       </div>
                      </div>
                    </div>
                  
                </section>
                  




                <section class="content">
                       <div class="container-fluid">
                         <div class="card card-default">
                           <div class="card-header">
                             <h3 class="card-title">Terms and Conditions : </h3>

                             <div class="card-tools">
                               <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                             </div>
                           </div>
                           <div class="card-body">
                             <div class="row">
                               <div class="col-md-6">
                                 <div class="form-group">
                                   <label>Description</label>

                                   <textarea class="form-control form-control-sm" id="description_approval" name="description_approval" value="<?= $manage_indent_info->description ?>" ><?= $manage_indent_info->description ?> </textarea>
                                 </div>
                               </div>
                                   <h3 class="card-title float-right">
                                    <button id="editButton" type="submit" class="order-button btn btn-sm btn-success mt-5 mb-5" title="Approve Indent">
                                          Approve Now
                                     </button>
                                    
                                    <h3>
                                      <h3>
                                      <h3 class="card-title float-right">
                                 
                               </div>
                              
                               
                         </div>
                       </div>
                       
                </section>
                 <?php
                // break;
        endforeach;
    endif;
  endif;
?>

                
</form>
<?php require_once("include/footer.php"); ?>
                
                  
                  
               
 
               
 <!-- <?php  ?> -->
       <?php require_once("include/js.php"); ?>

    <!-- <script src="dist/js/ajax.js"></script> -->


 
 


    
    <script src="dist/js/admin/approve_indent.js"></script>
    
    <!-- Js Section End -->

  

  
</body>


</html>
