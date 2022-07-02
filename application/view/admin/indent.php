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
   
    if(isset($_POST["action"])):
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Fetch Data Section Start ---------
            // -----------------------------------------------
            
                    
            case "fetchData":
            $databaseObj->select("tbl_manage_stock");
            $databaseObj->where("`status` = '".$auth->visible()."'");
            $getData = $databaseObj->get();
            $indentNo = 1;
            foreach ($getData as $rows) {
              $indentNo = $rows["manage_stock_id"]+1;
            } ?>
            
             
              <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/indent.php">
                <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_stock">
                <input type="hidden" id="action" name="action" value="addIndent">
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
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Indent No</label>
                                  <input class="form-control" name="indentNo" id="indentNo" type="text" value="<?php echo $indentNo; ?>" readonly>
                              </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Indent Date</label>
                                  <input class="form-control" name="indentDate" id="indentDate" type="text" value=" <?php
                                  echo date('d/m/Y');?>" readonly>
                                </div>
                              </div>
                              <?php
                              if (isset($_POST["ckeckItem"])):
                                $databaseObj->select("tbl_manage_stock");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_stock_id` = '".$_POST["ckeckItem"][0]."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                // $databaseObj->error();
                                if($getData != 0):
                                 $sno = 1;
                                 $employee_req = "";
                                 foreach($getData as $rowsstock):
                                  $databaseObj->select("tbl_projects");
                                  $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$rowsstock['project']."'");
                                  $getDataPro = $databaseObj->get();
                                  //Checking If Data Is Available
                                  if($getDataPro != 0):
                                    foreach($getDataPro as $rowsPro):
                                      $projects_info = json_decode($rowsPro["projects_info"]);
                                      $req = explode(" ",$projects_info->projectName);
                                      $reqName = "";
                                      foreach($req as $reqAll)
                                        if(isset($reqAll[0]))
                                          // $reqName .= $reqAll[0];
                                          // $employee_req= $reqName."/".$indentNo."/20-21";
                                      
                                           $reqName .= $reqAll[0];
                                           $year =  date("y");
                                           // $yearnow= date("Y");
                                           $yearnext=$year+1;
                                           $yearcurrent = date("y")."-".$yearnext;
                                              // echo "<pre>";
                                              //   print_r($year);
                                              //   echo "</pre>";
                                           $employee_req= $reqName."/".$indentNo."/".$yearcurrent;
                                      endforeach;
                                  endif;
                                            
                                 endforeach;   
                                endif ;
                              endif; ?>  
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Project</label>                   
                                  <input class="form-control form-control-sm" type="text" value="<?= $projects_info->projectName ?>" readonly>
                                  <input  name="employee_project" id="project" type="hidden" value="<?= $rowsPro["projects_id"] ?>" readonly>
                                </div>
                               
                              </div>
                              <div class="col-md-6">
                                <!-- <div id="projectrequisition">
                                  <div id="viewprojectrequisition"> -->
                                    <!--  <div class="col-md-6"> -->
                                <div class="form-group">
                                  <label>Requistion No</label>                   
                                  <input class="form-control form-control-sm" name="employee_req" id="employee_req" type="text" value="<?= $employee_req ?>" readonly>
                                </div>
                              </div>
                                
                              <?php   
                              $databaseObj->select("tbl_admin");
                              $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                              $databaseObj->order_by("`admin_id` DESC");
                              $getData = $databaseObj->get(); 
                              //Checking If Data Is Available
                              if($getData != 0):
                                $sno = 1;
                                foreach($getData as $rows):
                                  $admin_info = json_decode($rows["admin_info"]);
                                  $admin_log = json_decode($rows["admin_log"]);
                                  $databaseObj->select("tbl_manage_employee");
                                  $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                  $getData = $databaseObj->get();
                                  //Checking If Data Is Available
                                  if($getData != 0):
                                    $sno = 1;
                                    foreach($getData as $rows):
                                      $manage_employee_info = json_decode($rows["manage_employee_info"]);?>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Indent Created </label>
                                          <input class="form-control"  type="text" value="<?= $manage_employee_info->firstName; ?><?= $manage_employee_info->lastName; ?>"readonly>
                                          <input class="form-control" name="indentCreated" id="indentCreated" type="hidden" value="<?= $rows["manage_employee_id"]; ?>"readonly>
                                        </div>
                                      </div>  
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Designation </label>
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
                                          <input class="form-control"  type="text" value="<?= $manage_designation_info->designationName; ?>"readonly>
                                          <input class="form-control" name="indentCreatedDesignation" id="indentCreatedDesignation" type="hidden" value="<?= $rows["manage_designation_id"]; ?>"readonly>
                                        </div>
                                      </div> 
                                      <?php
                                    endforeach;
                                  endif;
                                endforeach;
                              endif;?> 
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
                            <h3 class="card-title">For next level Approval : </h3>

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
                                  <label> Select Employee for approval </label>
                              
                                  <select class="form-control select2" name="employee_approval" id='employee_approval' style="width: 100%;" required>
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
                                <div id="project_sec_div5">
                                  <div id="viewproject56">
                                    <div class="form-group">
                                       <label>Designation</label>
                                       <input class="form-control" name="employee_designation_approval" type="text" readonly>
                                    </div>
                                    <div class="form-group">
                                      <label>Email</label>
                                      <input class="form-control" name="employee_email_approval" type="text" readonly>
                                    </div>
                                  </div>
                                </div>  
                              </div>
                            </div>
                          </div>
                        </div>  
                      </div>
                    </section>   
                    <?php
                    $cnt = 1;
                    ?>
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
                          
                          <div class="table-responsive" >
                            <table class="table table-bordered" id="dynamic_field" >

                              <tr>
                                  <th width="7%">S.NO</th>
                                  <th width="15%">Item Code</th>
                                  <th width="34%">Item Name</th>
                                  <th width="34%" >Item Category</th>
                                  <th width="13%" >UOM</th>
                                  <th width="10%">Existing Quantity</th>
                                  <th width="10%">Requisition Quantity</th>
                                  <th width="10%" >Remark</th>
                                  <!-- <th width="8%">Rate</th>
                                  <th width="10%">Amount</th>
                                  <th width="5%">Cgst%</th>
                                  <th width="5%">Sgst%</th>
                                  <th width="5%">Igst%</th>
                                  <th width="10%">Total Amount</th> -->
                                  <th>Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th>
                             </tr>
                             <?php
                        // echo "<pre>";
                        // print_r($_POST);
                        // echo "</pre>";

 
                          if (isset($_POST["ckeckItem"])) {
                            $check_one = true;
                            foreach ($_POST["ckeckItem"] as $item) {
                              

                                   


                                    
                                 
                              
                                    // echo "<pre>";
                                    // print_r($getDataPro);
                                    // echo "</pre>";
                                    

                                    //      echo "<pre>";
                                    // print_r($rowsPro);

                                 // $databaseObj_sec->select_inner_join("tbl_manage_stock","tbl_manage_item","tbl_manage_stock.itemCode = tbl_manage_item.manage_item_id");
                                 //  $databaseObj_sec->where("`status` = '".$auth->visible()."' && `manage_stock_id` = '".$item."'");
                                 //  $getStockData = $databaseObj_sec->get();
                                  // echo"<pre>";
                                  // print_r($getStockData);
                                  // echo"</pre>";
                                  // exit();
                              ?>
                              <tr id="row<?php echo $cnt; ?>">
                                 <td><input type="text" id="slno<?php echo $cnt; ?>" value="<?php echo $cnt; ?>" readonly class="form-control"></td>
                                <?php  $databaseObj->select("tbl_manage_stock");
                                  $databaseObj->where("`status` = '".$auth->visible()."'&& `manage_stock_id` = '".$item."'");
                                  $getStockData = $databaseObj->get();
                                  $databaseObj->select("tbl_manage_item");
                                  $databaseObj->where("`status` = '".$auth->visible()."'&& `manage_item_id`='". $getStockData[0]["itemCode"]."'");
                                  $getData = $databaseObj->get(); 
                                  foreach($getData as $rows):
                                  endforeach;

                                  ?>
                                  <td><input type="hidden"  name="item_code[]"   id="item_code[<?php echo $cnt; ?>]"  class="form-control"  value="<?= $getStockData[0]["itemCode"] ?>" readonly><input type="text" class="form-control" value="<?= $rows["itemCode"] ?>" readonly> </td>
                                   

                               

                               

                                  <?php  $databaseObj->select("tbl_manage_stock");
                                  $databaseObj->where("`status` = '".$auth->visible()."'&& `manage_stock_id` = '".$item."'");
                                  $getStockData = $databaseObj->get();
                                  $databaseObj->select("tbl_manage_item");
                                  $databaseObj->where("`status` = '".$auth->visible()."'&& `manage_item_id`='".$getStockData[0]["itemName"]."'");
                                  $getData = $databaseObj->get(); 
                                  foreach($getData as $rows):
                                    
                                  endforeach;

                                  
                                 

                                  ?>
                                  <td><input type="hidden"  name="item_name[]"   id="item_name[<?php echo $cnt; ?>]"  class="form-control"  value="<?= $getStockData[0]["itemName"] ?>" readonly><input type="text" class="form-control" value="<?= $rows["itemName"] ?>" readonly> </td>

                                
                             

                                
                                   <?php
                                    $databaseObj->select("tbl_manage_stock");
                                  $databaseObj->where("`status` = '".$auth->visible()."'&& `manage_stock_id` = '".$item."'");
                                  $getStockData = $databaseObj->get();
                                    $getDatacategory = $databaseObj_sec->sqlCmdRun("SELECT * FROM tbl_manage_item INNER JOIN tbl_manage_category ON tbl_manage_item.itemCategory = tbl_manage_category.manage_category_id 
                                    where tbl_manage_item.status = '".$auth->visible()."'");
                                   
                                    
                                    //Checking If Data Is Available
                                   
                                    foreach($getDatacategory as $rowcategory):
                                      $manage_category_info = json_decode($rowcategory["manage_category_info"]);
                                        endforeach;
                                        
                                     
                                    ?>
                                    <td><input type="hidden"  name="item_category[]"   id="item_category[<?php echo $cnt; ?>]"  class="form-control"  value="<?= $getStockData[0]["itemCategory"] ?>" readonly><input type="text"  class="form-control"  value="<?= $manage_category_info->categoryName ?>" readonly></td>

                                    
                                   <?php  $databaseObj->select("tbl_manage_stock");
                                  $databaseObj->where("`status` = '".$auth->visible()."'&& `manage_stock_id` = '".$item."'");
                                  $getStockData = $databaseObj->get();
                                  $databaseObj->select("tbl_manage_item");
                                  $databaseObj->where("`status` = '".$auth->visible()."'&& `manage_item_id`='".$getStockData[0]["Uom"]."'");
                                  $getData = $databaseObj->get(); 
                                  foreach($getData as $rows):
                                    
                                  endforeach; ?>
                                    <td><input type="hidden"  name="uom[]"   id="uom[<?php echo $cnt; ?>]"  class="form-control"  value="<?= $getStockData[0]["Uom"] ?>" readonly><input type="text"  class="form-control"  value="<?= $rows["Uom"] ?>" readonly></td>  

                              
                                
                            
                                 
                                 
                                  
                                
                                <td><input type="text"  name="quantity1[]"   id="tonne_id1[<?php echo $cnt; ?>][tonne]"  class="form-control"  value="<?= $getStockData[0]["Qty"] ?>" readonly></td>
                                <td><input type="text"  name="quantity[]"   id="tonne_id[<?php echo $cnt; ?>][tonne]"  class="form-control" value="<?= $getStockData[0]["Qty"] ?>"></td>
                               
                                
                                <td><input type="text" name="remark[]"  placeholder="" id="remark_id[<?php echo $cnt; ?>][remark]"  class="form-control" style="" required></td>


                                <td><button type="button" name="remove" id="<?php echo $cnt; ?>" class="btn btn-danger btn_remove">X</button></td>

                              </tr>
                              <?php
                              $cnt++;
                               
                            }
                          }
                          else {
                            ?>
                            <tr id="row1">
                               <td><input type="text" id="slno1" value="1" readonly class="form-control"></td>
                               
                               
                                <td>
                                     <select id="item_code[<?php echo $cnt; ?>]" name="item_code[]" class="form-control" onchange="onSelection('<?php echo $cnt; ?>',this.value);" onblur="onSelection('<?php echo $cnt; ?>',this.value);">
                                <?php

                                    $databaseObj->select("tbl_manage_item");
                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                    $getDataPro = $databaseObj->get();
                                    // echo "<pre>";
                                    // print_r($getDataPro);
                                    // echo "</pre>";
                                      foreach($getDataPro as $rowsPro):
                                    //      echo "<pre>";
                                    // print_r($rowsPro);
                                    // echo "</pre>";

                                   ?>
                                <option value="<?= $rowsPro["manage_item_id"] ?>" <?php if($getStockData[0]["itemCode"] == $rowsPro["manage_item_id"]) echo "selected" ?>><?= $rowsPro["itemCode"] ?></option>
                                <?php
                                endforeach;
                                // endif;
                                ?>
                                </select>
                                </td>
                                
                                
                              <td>
                                  <select id="item_name[<?php echo $cnt; ?>]" name="item_name[]" class="form-control" onchange="onSelection('<?php echo $cnt; ?>',this.value);" onblur="onSelection('<?php echo $cnt; ?>',this.value);">
                                    <?php 
                                   $databaseObj->select("tbl_manage_item");
                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                   
                                    foreach($getData as $rows):
                                    ?>
                                   <option value="<?=  $rows["manage_item_id"] ?>" <?php if($getStockData[0]["itemName"] == $rows["manage_item_id"]) echo "selected" ?>><?= $rows["itemName"] ?></option>                                        <?php
                                    endforeach;
                                   
                                    ?>
                                    </select>

                              </td>
                              <td>
                                 <select id="item_category[<?php echo $cnt; ?>]" name="item_category[]" class="form-control" onchange="onSelection('<?php echo $cnt; ?>',this.value);" >
                                   <?php
                                    $databaseObj->select("tbl_manage_category");
                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                    $getDatacategory = $databaseObj->get();
                                    // echo "<pre>";
                                    // print_r($getDatacategory);
                                    //Checking If Data Is Available
                                    if($getDatacategory != 0):
                                   
                                    foreach($getDatacategory as $rowcategory):
                                      $manage_category_info = json_decode($rowcategory["manage_category_info"]);
                                   
                                    ?>
                                    <option value="<?= $rowcategory["manage_category_id"] ?>"<?php if($rows["manage_item_id"] == $rowcategory["manage_category_id"]) echo "selected" ?>><?= $manage_category_info->categoryName ?></option>        <?php
                                     endforeach;
                                    endif;  
                                    ?>
                                    </select>

                                 <!-- <select id="item_category[<?php echo $cnt; ?>]" name="item_category[]" class="form-control" onchange="onSelection('<?php echo $cnt; ?>',this.value);" onblur="onSelection('<?php echo $cnt; ?>',this.value);">
                                    <?php 
                                    $databaseObj->select("tbl_manage_item");
                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                    $sno = 1;
                                    foreach($getData as $rows):
                                    ?>
                                   <option value="<?=  $rows["manage_item_id"] ?>" <?php if($_POST["ckeckItem"][$cnt-1] == $rows["manage_item_id"]) echo "selected" ?>><?= $rows["itemCategory"] ?></option>                  <?php
                                    endforeach;
                                    endif;
                                    ?>
                                    </select> -->

                                </td>
                              
                                    <td>
                               <select id="uom[<?php echo $cnt; ?>]"  name="uom[]" class="form-control" onchange="onSelection('<?php echo $cnt; ?>',this.value);" onblur="onSelection('<?php echo $cnt; ?>',this.value);">
                                    <?php 
                                    $databaseObj->select("tbl_manage_item");
                                   $databaseObj->where("`status` = '".$auth->visible()."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                    $sno = 1;
                                    foreach($getData as $rows):
                                    ?>
                                    <option value="<?=  $rows["manage_item_id"] ?>" <?php if($getStockData[0]["itemCode"] == $rows["manage_item_id"]) echo "selected" ?>><?= $rows["Uom"] ?></option>                                        

                                        <?php
                                    endforeach;
                                    endif;
                                    ?>
                                </select>
                              </td>


                             <input type="text"  name="quantity[]"   id="tonne_id[<?php echo $cnt; ?>][tonne]"  class="form-control"   value="<?= $getStockData[0]["Qty"] ?>">
                              <td><input type="text" name="remark[]"  placeholder="" id="remark_id[1][remark]"  class="form-control" style=""></td>
                              


                              <td><button type="button" name="remove" id="<?php echo $cnt; ?>" class="btn btn-danger btn_remove">X</button></td>

                            </tr>
                            <?php
                          }
                           ?>
                            </table>
                           
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                    <script>
                        function onSelection(id, val)
                        {  
                            var code_id = "item_code[" +id+ "]";
                            var name_id = "item_name[" +id+ "]";
                            var uom_id =  "uom[" +id+ "]";
                            var category_id =  "item_category[" +id+ "]";
                           
                            $.ajax({
                                   url: 'getinformationsmanageitemnew.php',
                                   type: 'POST',
                                  data: {"item_code": val,"project": $("#project").val()},
                                   success: function(result) {
                                    console.log(result);
                                    
                                       document.getElementById("tonne_id1[" +id+ "][tonne]").value = result;
                                   }
                               });
                            // console.log(val);
                            // console.log(code_id+ " " +name_id+ " "+uom_id+ " " +category_id+ " "+qty_id);



                            document.getElementById(code_id).value = val;
                            document.getElementById(name_id).value = val;
                            document.getElementById(uom_id).value =  val;
                            document.getElementById(category_id).value =  val;
                           
                        }
                    </script>


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
                                   <textarea name="description" class="form-control"></textarea>
                                 </div>
                               </div>
                               <!-- <div class="col-md-6">
                                 <div class="form-group">
                                   <label>Payment Terms</label>
                                 <textarea width="600" name="payment_terms" id="payment_terms" class="form-control"></textarea>
                                  <script>
                                    CKEDITOR.replace( 'payment_terms' );
                                 </script> -->
                                 <!-- </div>
                             </div>
                             </div> --> 
                           </div>
                         </div>
                       </div>
                </section>


                <section class="content">
                                 <h3 class="card-title float-right">
                                     <button id="addButton" type="submit" class="order-button btn btn-sm btn-success mt-1 mb-1" title="Create Indent">
                                         <i class="fa fa-cart-plus fa-sm"></i> Send for Approval
                                     </button>
                                 </h3>
                </section>
</form>
                <script>
                   $('#employee_project').on('change', function( event ) {

                                                   $.ajax({
                                                       url: 'getinformationrequisitionnumber.php',
                                                       type: 'POST',
                                                       data: {"employee_project":$(this).val(),
                                                               "indentNo":$(indentNo).val()},
                                                       success: function(result) {

                                                           $('#employee_req').remove();
                                                           $('#projectrequisition').html('<div id="viewprojectrequisition" >' + result + '</div>');
                                                         
                                                       }
                                                   });
                                                   event.preventDefault();
                                               }); 
                 function cal(si){
                   if(document.getElementById('tonne_id['+si+'][tonne]').value!="" && document.getElementById('rate_id['+si+'][rate]').value!=""){
                     document.getElementById('amount_id['+si+'][amount]').value = document.getElementById('tonne_id['+si+'][tonne]').value*document.getElementById('rate_id['+si+'][rate]').value;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('amount_id['+si+'][amount]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_cgst(si){
                   if(document.getElementById('cgst_id['+si+'][cgstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var cgstr = tamount*document.getElementById('cgst_id['+si+'][cgstrate]').value;
                     cgstr = cgstr.toFixed(2);
                     document.getElementById('cgstamt_id['+si+'][cgstamt]').value = cgstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('cgstamt_id['+si+'][cgstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_sgst(si){
                   if(document.getElementById('sgst_id['+si+'][sgstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var sgstr = tamount*document.getElementById('sgst_id['+si+'][sgstrate]').value;
                     sgstr = sgstr.toFixed(2);
                     document.getElementById('sgstamt_id['+si+'][sgstamt]').value = sgstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('sgstamt_id['+si+'][sgstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_igst(si){
                   if(document.getElementById('igst_id['+si+'][igstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var igstr = tamount*document.getElementById('igst_id['+si+'][igstrate]').value;
                     igstr = igstr.toFixed(2);
                     document.getElementById('igstamt_id['+si+'][igstamt]').value = igstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('igstamt_id['+si+'][igstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
               </script>
               <script>
               $(document).ready(function() {
               $('#vendor_name').on('change', function( event ) {
                   $.ajax({
                       url: 'getInformationsvendor.php',
                       type: 'POST',
                       data: {"vendor_name":$(this).val()},
                       success: function(result) {
                           $('#view').remove();
                           $('#branchName').append('<div id="view" >' + result + '</div>');
                       }
                   });
                   event.preventDefault();
               });
               $('#company_name').on('input', function( event ) {
                   $.ajax({
                       url: 'getinformationscompany.php',
                       type: 'POST',
                       data: $('#selectForm').serializeArray(),
                       success: function(result) {
                           $('#viewcompany').remove();
                           $('#company').append('<div id="viewcompany" >' + result + '</div>');
                          $.ajax({
                             url: 'getinformationsgstin.php',
                             type: 'POST',
                             data: $('#selectForm').serializeArray(),
                             success: function(result) {
                                 $('#viewgstin').remove();
                                 $('#gstin').append('<div id="viewgstin" >' + result + '</div>');
                             }
                           });
                       }
                   });
                   event.preventDefault();
               });
                   
                   
                  $('#employee').on('change', function( event ) {
                   $.ajax({
                       url: 'getinformationsemployee.php',
                       type: 'POST',
                       data: {"employee":$(this).val()},
                       success: function(result) {
                           $('#viewproject12').remove();
                           $('#project_sec').html('<div id="viewproject" >' + result + '</div>');
                    
                       }
                   });
                   event.preventDefault();
               }); 
                  
                $('#project').on('change', function( event ) {
                   $.ajax({
                       url: 'getinformationsproject.php',
                       type: 'POST',
                       data: {"project":$(this).val()},
                       success: function(result) {
                        // alert(result);
                           //$('#viewproject456').remove();
                           $('#project_sec_div1').append('<div id="viewproject456" >' + result + '</div>');
//                         
                       }
                   });
                   event.preventDefault();
               });    
                  
               $("select.country").change(function(){
                   var selectedCountry = $(".country option:selected").val();
                   $.ajax({
                       type: "POST",
                       url: "process-request.php",             
                       data: { country : selectedCountry } 
                   }).done(function(data){
                       $("#response").html(data);
                   });
               });
                  var i=<?php echo $cnt; ?>;

                 $('#add').click(function(){
                        i++;
                     $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><input type="text" id="slno'+i+'" value="'+i+'" readonly class="form-control" style="border:none;" /></td><td>' +'<select id="item_code[' + i + ']" name="item_code[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_stock"); $databaseObj->where("`status` = '".$auth->visible()."'&& `project`='".$rowsstock['project']."'"); $getData = $databaseObj->get();foreach($getData as $rowstocks): $item_Code = $rowstocks["itemCode"];$item_Name = $rowstocks["itemName"]; $Uom = $rowstocks["Uom"];$Qty = $rowstocks["Qty"];$databaseObj->select("tbl_manage_item");$databaseObj->where("`status` = '".$auth->visible()."'&& `manage_item_id`='". $item_Code."'");$getDataitem = $databaseObj->get(); foreach($getDataitem as $rowsitem):?><option value="<?= $rowsitem["manage_item_id"] ?>" <?php if($item_Code == $rowsitem["manage_item_id"]) echo "selected" ?>><?= $rowsitem["itemCode"] ?></option><?php endforeach; endforeach;?></select></td><td>' +'<select id="item_name[' + i + ']" name="item_name[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_stock"); $databaseObj->where("`status` = '".$auth->visible()."'&& `project`='".$rowsstock['project']."'"); $getData = $databaseObj->get();foreach($getData as $rowstocks): $item_Name = $rowstocks["itemName"];  $databaseObj->select("tbl_manage_item");$databaseObj->where("`status` = '".$auth->visible()."'&& `manage_item_id`='". $item_Name."'");$getDataitem = $databaseObj->get(); foreach($getDataitem as $rowsitem): ?><option value="<?= $rowsitem["manage_item_id"] ?>" <?php if($item_Name == $rowsitem["manage_item_id"]) echo "selected" ?>><?= $rowsitem["itemName"] ?></option><?php endforeach;endforeach;?></select></td><td>' + '<select id="item_category[' + i + ']" name="item_category[]" class="form-control" onchange="onSelection(' +i+',this.value);" onblur="onSelection('+i+',this.value);" ><?php $getDatacategory = $databaseObj_sec->sqlCmdRun("SELECT * FROM tbl_manage_item INNER JOIN tbl_manage_category ON tbl_manage_item.itemCategory = tbl_manage_category.manage_category_id where tbl_manage_item.status = '".$auth->visible()."'");if($getDatacategory != 0):foreach($getDatacategory as $rowcategory): $manage_category_info = json_decode($rowcategory["manage_category_info"]); ?><option value="<?= $rowcategory["manage_item_id"] ?>" <?php if($getStockData[0]["itemCategory"] == $rowcategory["manage_category_id"]) echo "selected" ?>><?= $manage_category_info->categoryName ?></option><?php endforeach; endif; ?></select></td><td>' +'<select id="uom[' + i + ']" name="uom[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); foreach($getData as $rows):?><option value="<?= $rows["manage_item_id"] ?>"<?php if($getStockData[0]["Uom"] == $rows["manage_item_id"])echo "selected" ?>><?= $rows["Uom"] ?></option>  <?php endforeach;?> </select></td><td><input type="text" name="quantity1[]" placeholder="" id="tonne_id1['+i+'][tonne]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control" readonly/></td><td><input type="text" name="quantity[]" placeholder="" id="tonne_id['+i+'][tonne]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control"/></td><td><input type="text" name="remark[]"  placeholder="" id="remark_id['+i+'][remark]"  class="form-control"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                   
                 });

                 $(document).on('click', '.btn_remove', function(){
                      var button_id = $(this).attr("id");
                      $('#row'+button_id+'').remove(); 
                    
                 });
                  i--;
                   });
               </script>
               <script>
                
                $('#employee_approval').on('change', function( event ) {
                    // alert($(this).val());
                   $.ajax({
                       url: 'getinformationsemployeeapproval.php',
                       type: 'POST',
                       data: {"employee_approval":$(this).val()},
                       success: function(result) {
                           $('#viewproject56').remove();
                           $('#project_sec_div5').html('<div id="viewproject56" >' + result + '</div>');
                    
                       }
                   });
                   event.preventDefault();
               });  
                                               
                   function getGst(){
                       var gstin_value = String(document.getElementById('stateCode').value);
                       //var gstin_value = "Hello";
                       var state_code = gstin_value.charAt(0)+gstin_value.charAt(1);
                       //alert(state_code);
                       if(state_code == "20"){
                           var tObj = document.getElementsByClassName('iGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='0';

                           }
                           var tObj = document.getElementsByClassName('cGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='9';

                           }
                           var tObj = document.getElementsByClassName('sGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='9';

                           }
                       } else{
                           var tObj = document.getElementsByClassName('iGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='18';

                           }
                           var tObj = document.getElementsByClassName('cGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='0';

                           }
                           var tObj = document.getElementsByClassName('sGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='0';

                           }
                       }
                   }
               </script>
               <script src="dist/js/admin/for-all-tables.js"></script>
               <script src="dist/js/main.js"></script>
                <?php
                break;
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
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