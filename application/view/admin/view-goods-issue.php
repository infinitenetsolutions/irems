<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 <script>
// $(document).ready(function(){
//   $("#myInput").on("keyup", function() {
//     var value = $(this).val().toLowerCase();
//     $("#myTable").filter(function() {
//       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//     });
//   });
// });

var $rows = $('#table tr');

$('#search').keyup(function() {
  var searchText = $(this).val().toLowerCase();
  $rows
    .show()
    .filter(function() {
      var $inputs = $(this).find("input:text");
      var found = searchText.length == 0; // for empty search, show all rows
      for (var i=0; i < $inputs.length && !found; i++) {
        var text = $inputs.eq(i).val().replace(/\s+/g, ' ').toLowerCase();;
        found = text.length > 0 && text.indexOf(searchText) >= 0;
      }
      return !found;
   })
   .hide();
});
</script>

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
   
        
if(isset($_POST["action"])){

// VIew STOCK START-------------------------------------------------------------
    if($_POST["action"] == "goodsReceipt"){

    $order_no = $_POST["order_no"];
    $databaseObj->select("tbl_goods_issue");
    $databaseObj->where("`goods_issue_id` = '".$order_no."'");
    
    $result = $databaseObj->get();



    $databaseObj->select("in_item_master");
    $databaseObj->where("`status` = 'active'");
    $item_result = $databaseObj->get();
    // $grn_no = $_POST["receipt_no"];
    // echo "<pre>";
    //   print_r($grn_no) ;
    //   echo "</pre>"; 
  ?>
<div class="page-content">
    <!-- Panel -->
    <div class="panel">

    </div>
    <!-- End Panel -->
    <input type="text" id="search" placeholder="Type to search" class="form-control mt-2">
    <!-- Panel -->
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-lg-12">
                    <!-- vendor Basic -->
                    <div class="vendor-wrap"><br>
                        <h6 class="vendor-title"><b><u>ISSUED ITEM DETAILS</u></b></h6>
                        <div class="vendor table-responsive">
                            <form id="receiptForm" class="" onsubmit="return return_goods_ajax(this)" method="post" name="returnItems">
                               <input type="hidden" id="secondaryLocation" name="checkLocation" />
                                <input type="hidden" id="secondaryIp" name="checkIp" />
                                <div class="panel-body container-fluid">
                                    <div class="row row-lg">
                                        <div class="col-lg-12">
                                            <!-- vendor Basic -->
                                            <?php
                                          foreach ($result as $rows) {
                                                 $goods_issue_info =json_decode($rows["goods_issue_info"]);
                                                 $goods_issue_returned =json_decode($rows["goods_issue_returned"]);
                                                 $goods_issue_log =json_decode($rows["goods_issue_log"]);
                                               
                                                  // echo json_last_error_msg();                                            
                                                 ?>
                                            <div class="vendor-wrap">
                                                <div class="row">
                                                   <div class="col-sm-4">
                                                    <?php
                                                         $databaseObj->select("tbl_manage_employee");
                                                         $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$goods_issue_info->issueTo."'");
                                                          $getData = $databaseObj->get();
                                                          foreach($getData as $rowsupplier):
                                                            $manage_employee_info =json_decode($rowsupplier["manage_employee_info"]);
                                                                 endforeach;?>
                                                        <label for="">Issued To : </label>
                                                       
                                                        <input type="hidden" class="form-control" name="issue_no" value="<?= $goods_issue_info->ginNo ?>">
                                                        
                                                        <input type="text" class="form-control" name="issueTo" value="<?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>" readonly> 
                                                        <div class="col-sm-7">&nbsp;</div>
                                                  </div>
<!--
                                                <div class="row">
                                                    <div class="col-sm-2">&nbsp;</div>
                                                    <div class="col-sm-3">&nbsp;</div>
                                                    <div class="col-sm-7">&nbsp;</div>
                                                </div>
-->                                                <div class="col-sm-4">
<!--                                                <div class="row">-->
                                                      <label for="">IRN Date :  </label>
 
                                                        <input type="text" class="form-control" name="gin_date"  value="<?php echo date('d/m/Y');?>"required>
                                                        <!-- <input type="hidden" class="form-control" > -->
                                                        <div class="col-sm-7">&nbsp;</div>
<!--                                                </div>-->
                                                  </div>
                                                  <div class="col-sm-4">
<!--                                                <div class="row">-->
                                                   <?php
                                                         $databaseObj->select("tbl_projects");
                                                         $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info->project."'");
                                                          $getData = $databaseObj->get();
                                                          foreach($getData as $rowsproject):
                                                            $projects_info =json_decode($rowsproject["projects_info"]);
                                                                 endforeach;?>
                                                      <label for="">PROJECT :  </label>
 
                                                        <input type="hidden" class="form-control" name="project"  value="<?php echo $goods_issue_info->project;?>"readonly>
                                                        <input type="text" class="form-control" name="project"  value="<?php echo $projects_info->projectName;?>"readonly>
                                                        <!-- <input type="hidden" class="form-control" > -->
                                                        <div class="col-sm-7">&nbsp;</div>
<!--                                                </div>-->
                                                  </div>
                                            <?php } ?>
                                            <!-- End vendor Basic -->
                                        </div>
                                    </div>
                                </div><br>
                                <table class="table table-bordered" id="order_items">
                                    <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                   <!--  <input type="hidden" name="grn_no" value="<?php echo $grn_no; ?>"> -->
                                    <thead>
                                        <tr>
                                            <th data-field="S. No." data-sortable="true" style="width:10%;">S.No.</th>
                                            <th data-field="Item Code" data-sortable="true" style="width:20%;">Item Code </th>
                                            <th data-field="Item Name" data-sortable="true" style="width:20%;">Item Name</th>
                                            <th data-field="UOM" data-sortable="true" style="width:10%;">UOM</th>
                                             
                                            <th data-field="Quantty left  to be returned " data-sortable="true" style="width:10%;">Quantity left from issued</th>
                                            <th data-field="Quantity" data-sortable="true">Quantity to be returned </th>
                                            <th data-field="Remarks" data-sortable="true">Remarks</th>
                                            
                                    </thead>
                                    
                                    <tbody id="table"> 
                                        <?php
                      $cnt = 1;
                        foreach($goods_issue_info->items as $goods_issue_item_info):
                          
                            
                          ?>
                                       
                                            
                                           
                                <tr id="row<?php echo $cnt; ?>">

                                 <td><input type="text" id="slno<?php echo $cnt; ?>" value="<?php echo $cnt; ?>" readonly class="form-control"></td>
                                 
                                         <?php $databaseObj->select("tbl_manage_item");

                                         $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_issue_item_info->itemCode."'");
                                                                                                             
                                         $getDatas = $databaseObj->get();
                                                                                                                  
                                        if($getDatas != 0):
                                            foreach($getDatas as $rows_deptt):
                                                              
                                                 $itemName = $rows_deptt["itemName"];
                                                                  // echo "<pre>";
                                                                  // print_r($rows_deptt["itemName"]);
                                                                  // echo"</pre>";
                                                  $itemCode = $rows_deptt["itemCode"];
                                                                  
                                                   $uom = $rows_deptt["Uom"];
                                                                  // $Qty = $rows_deptt["Qty"];
                                                                 
                                            endforeach;
                                        endif;
                                    ?>                                                                        
                             
                                 <td><input  id="itemCode[<?php echo $cnt; ?>]" name="itemCode[]" class="form-control" value="<?= $goods_issue_item_info->itemCode ?>" type="hidden" readonly><input   value="<?= $itemCode?> " type="text" class="form-control" readonly></td>

                                 <td><input  id="itemName[<?php echo $cnt; ?>]" name="itemName[]" class="form-control" value="<?= $goods_issue_item_info->itemName ?>" type="hidden" readonly><input   value="<?= $itemName ?>" type="text" class="form-control" readonly></td>

                                  <td><input  id="Uom[<?php echo $cnt; ?>]" name="Uom[]" class="form-control" value="<?= $goods_issue_item_info->uom ?>" type="hidden" readonly><input   value="<?= $uom?>" type="text" class="form-control" readonly></td>    
                               
                             
                                 
                                

                                  
                                     <td><input type="text" name="quantity[]" placeholder="" id="tonne_id1[<?php echo $cnt; ?>][tonne]"  class="form-control" value="<?php echo $goods_issue_item_info->quantity; ?> " readonly></td>
                                
                                  

                                   

                          
                               
  


                               <td><input type="text" name="quantity1[]" placeholder="" id="tonne_id[<?php echo $cnt; ?>][tonne]"  class="form-control" value=" "></td>
                                
                                <td><input type="text" name="remark[]" placeholder="" id="remark[<?php echo $cnt; ?>][remark]"  class="form-control" value="<?php echo $goods_issue_item_info->remarks; ?>"></td>
                                
                                
                               
                                 <input type="hidden" name="Qty[]" placeholder="" id="Qty[<?php echo $cnt; ?>][Qty]"  class="form-control" value="<?php echo $goods_issue_item_info->current_stock; ?>" >
                                
                              </tr>
                              <?php
                              $cnt++;
                            
                            endforeach;
                          
                            
                           ?>
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
                                                                    $manage_employee_info = json_decode($rows["manage_employee_info"]);
                                                                    ?>
                                                                     <div class="col-md-6">
                                                                       <div class="form-group form-group-smform-group-sm">
                                                                        <?php
                                                                   // echo "<pre>";
                                                                   // print_r($manage_employee_info);
                                                                   // echo "</pre>";

                                                                     
                                                                        


                                                                               // echo "aaaaa";
                                                                           
                                                                       
                                                                              $databaseObj->select("tbl_projects");
                                                                              $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id`='".$manage_employee_info->project."'");
                                                                              $getData = $databaseObj->get();
                                                                              //Checking If Data Is Available
                                                                               if($getData != 0):
                                                                                 $sno = 1;
                                                                                 foreach($getData as $rows):
                                                                                  $projects_info = json_decode($rows["projects_info"]);    
                                                                                      // echo "<pre>";
                                                                                      //   print_r($projects_info);
                                                                                      //   echo "</pre>";
                                                                                   ?>   

                                                                                    
                                                                                    <input class="form-control form-control-sm" name="project" id="project" type="hidden" value="<?= $rows["projects_id"] ?>" readonly>
                                                                                     <?php
                                                                                 endforeach;
                                                                               endif;
                                                                        
                                                                     
                                                                    endforeach;
                                                                endif;
                                                            endforeach;
                                                    endif;
                                                ?>
                                            
                                        </tr>
                                      

                                    </tbody>
                                </table>
                                                                        <input type="hidden" id="sno" value="<?php echo $cnt; ?>">
                                
                            <script>
                            function onSelection(id, val) {
                            var code_id = "itemCode[" + id + "]";
                            var name_id = "itemName[" + id + "]";
                            var uom_id = "Uom[" + id + "]";
                            console.log(code_id + " " + name_id + " " + uom_id);
                            document.getElementById(code_id).value = val;
                            document.getElementById(name_id).value = val;
                            document.getElementById(uom_id).value = val;

                            }

                            </script>
                            <?php

                              
                                ?>
                                
                                <div class="panel-body container-fluid">
                                    <div class="row row-lg">
                                        <div class="col-lg-12">
                                            <!-- vendor Basic -->
                                            <div class="vendor-wrap">
                                                <div class="row">
                                                    <div class="col-sm-3">&nbsp;</div>
                                                       
                                                    

                                                    

                                                      
                                                    <div class="col-sm-3"><?php if($goods_issue_log->action == "Returned"):?><button type="" name="return_goods" id="return_goods" class="btn btn-success" disabled>RETURN GOODS</button><?php else: ?><button type="" name="return_goods" id="return_goods" class="btn btn-success">RETURN GOODS</button><?php endif;?>  </div>
                                                    <div class="col-sm-3"><a href="print_issue_goods.php?id=<?php echo $_POST["order_no"]; ?>" id="printIssueLink" target="_blank"><button type="button" id="printIssuedButton" class="print-button btn btn-warning btn-sm">Print Goods Issued</button> </a></div>
                                                    <div class="col-sm-3"><a href="print_return_goods.php?id=<?php echo $_POST["order_no"]; ?>" id="printReturnLink" target="_blank"><?php if($goods_issue_log->action == "Returned"):?><button type="button" id="printReturnButton" class="print-button btn btn-warning btn-sm" enabled>Print Goods Return</button><?php else: ?><button type="button" id="printReturnButton" class="print-button btn btn-warning btn-sm" disabled>Print Goods Return</button><?php endif;?></a></div>
                                                   
                                                </div>

                                            </div>
                                            <!-- End vendor Basic -->
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End vendor Basic -->
                </div>

            </div>
        </div>
    </div>
    <!-- End Panel -->




</div>
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

                       
                        var i=<?php echo $cnt; ?>;

                 $('#add').click(function(){
                      
                     $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><input type="text" id="slno'+i+'" value="'+i+'" readonly class="form-control" style="border:none;" /></td><td>' +'<select id="itemCode[' + i + ']" name="itemCode[]" class="form-control" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item"); $databaseObj->where("`status` = '".$auth->visible()."'");$getDatas = $databaseObj->get();foreach($getDatas as $rows_deptt):?><option value="<?= $rows_deptt["manage_item_id"] ?>" <?php if($goods_issue_item_info->itemCode == $rows_deptt["manage_item_id"]) echo "selected" ?>><?= $rows_deptt["itemCode"] ?></option><?php endforeach;?></select></td><td>' +'<select id="itemName[' + i + ']" name="itemName[]" class="form-control" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item"); $databaseObj->where("`status` = '".$auth->visible()."'");$getDatas = $databaseObj->get();foreach($getDatas as $rows_deptt):?><option value="<?= $rows_deptt["manage_item_id"] ?>" <?php if($goods_issue_item_info->itemCode == $rows_deptt["manage_item_id"]) echo "selected" ?>><?= $rows_deptt["itemCode"] ?></option><?php endforeach;?></select></td><td>' + '<select id="Uom[' + i + ']" name="Uom[]" class="form-control" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item");$databaseObj->where("`status` = '".$auth->visible()."'");$getDatas = $databaseObj->get();foreach($getDatas as $rows_deptt):?><option value="<?= $rows_deptt["manage_item_id"] ?>" <?php if($goods_issue_item_info->uom == $rows_deptt["manage_item_id"]) echo "selected" ?>><?= $rows_deptt["Uom"] ?></option><?php endforeach; ?></select></td><td><input type="text" name="quantity[]" placeholder="" id="tonne_id['+i+'][tonne]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control"/></td><td><input type="text" name="remark[]"  placeholder="" id="remark_id['+i+'][remark]"  class="form-control"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                     i++;
                    });

                 $(document).on('click', '.btn_remove', function(){
                      var button_id = $(this).attr("id");
                      $('#row'+button_id+'').remove(); 
                     i--;
                 });
                
               </script>
                    

<script>
    $(function() {

        $("#receive_goods").click(function() {
            var data = $("#receiptForm").serializeArray();
        });
    });

</script>

<script type="text/javascript">
    function mode(value) {
        if (value == "Cash") {
            document.getElementById("mode").style.display = "none";
        } else {
            document.getElementById("mode").style.display = "block";
        }
    }

function minmax(value, min, max) 
{
    if(parseInt(value) < min || isNaN(parseInt(value))) 
        return min; 
    else if(parseInt(value) > max) 
        return max; 
    else return value;
}

function return_goods_ajax(form) {
  var formData = new FormData(form);
  formData.append("action", "return_goods");
      $.ajax({
        type: "POST",
        url: "application/controller/admin/issue_controller.php",
        data: formData,
         
        contentType: false,
        processData: false,
        success: function (data) {
          // console.log(data);
          var responseData =JSON.parse(data)
          
                    console.log(responseData);
                    if(responseData.response == "success") {
                      
                       topEndNotification(responseData.responseType, responseData.responseMessage);
                       $('#printReturnButton').prop('disabled', false);
                        $("a#printReturnLink").attr("href", "print_return_goods.php?id="+responseData.id);
                       
                        
                        $('#printIssuedButton').prop('disabled', false);
                         $('#return_goods').prop('disabled', true);
                         // $('#addForm')[0].reset();
                       
                  
                     
                       
                    }else {
            topEndNotification("warning", "Please select the required Fields!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#addButton').html('<i class="fa fa-upload fa-sm"></i> Import this');
                $('#printButton').prop('disabled', false);
            });
        }
                
        },

            error: function (request, status, error) {
            console.log(request.responseText);
        }


      });
  return false;
}


</script>



<!--
<script src="global/js/Plugin/datatables.minfd53.js?v4.0.1"></script>
<script src="global/js/config/colors.minfd53.js?v4.0.1"></script>
<script src="assets/js/config/tour.minfd53.js?v4.0.1"></script>
-->
<!--
<script>
    Config.set('assets', 'assets');

</script>
<script src="assets/examples/js/tables/datatable.minfd53.js?v4.0.1"></script>
<script src="assets/examples/js/uikit/icon.minfd53.js?v4.0.1"></script>
-->
<?php
}
// View STOCK END---------------------------------------------------------------

}     
               
           
 else {
  echo "ACCESS DENIED";
}