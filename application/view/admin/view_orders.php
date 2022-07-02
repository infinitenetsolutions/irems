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
        //$grn_no = $_POST["grn_no"];
        $databaseObj->select("tbl_manage_po");
        $databaseObj->where("`manage_po_id` = '$order_no'");
        $result = $databaseObj->get();
    
       
    
         $databaseObj->select("in_item_master");
         $databaseObj->where("`status` = 'active'");
         $item_result = $databaseObj->get();
         $grn_no = $_POST["receipt_no"];
    

//  $order_no = $_POST["order_no"];
//  $sql_order = "SELECT * FROM `in_orders` WHERE `in_ordersid`='$order_no'";
//  $result = $conn->query($sql_order);
//  $sql_item = "SELECT * FROM `in_item_master` WHERE `status`='active'";
//  $item_result = $conn->query($sql_item);
//  $grn_no = $_POST["receipt_no"];

  ?>
<div class="page-content">
    <!-- Panel -->
    <div class="panel">

    </div>
    <!-- End Panel -->
    <!-- Panel -->
    <br>
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-lg-12">
                    <!-- vendor Basic -->
                    <div class="vendor-wrap">
                        <h4 class="vendor-title">PURCHASE ORDER DETAILS</h4><hr>
                        <div class="vendor table-responsive">
                            <form id="receiptForm" class="" action="application/controller/admin/order_controller.php"  method="post" name="receiveItems">
                                <input type="hidden" id="secondaryLocation" name="checkLocation" />
                                <input type="hidden" id="secondaryIp" name="checkIp" />
                                <div class="panel-body container-fluid">
                                    <div class="row row-lg">
                                        <div class="col-lg-12">
                                            <!-- vendor Basic -->
                                            <?php
                                        if($result != 0):
                                        foreach($result as $row):
                                        $manage_po_info = json_decode($row["manage_po_info"]);
                                        ?>
    
                                            <div class="vendor-wrap">
                                                <div class="row">
                                                   <div class="col-sm-4">
                                                       
                                                        <div class="col-sm-12"><input type="hidden"  name="order_no" id="order_no" value="<?php echo $row["manage_po_id"] ?>">

                                                             <input type="hidden" name="grn_no" id="" value="<?php echo $grn_no ?>">

                                                         <div class="col-sm-12"> <label for="">Supplier: </label> 
                                                           <?php 
                                                          $databaseObj->select("tbl_manage_supplier");
                                                          $databaseObj->where("`status` = '".$auth->visible()."'&& `manage_supplier_id` = '".$manage_po_info->vendor_name."'");
                                                          $databaseObj->order_by("`manage_supplier_id` DESC");
                                                          $getData = $databaseObj->get();
                                                          //Checking If Data Is Available
                                                          
                                                                foreach($getData as $rows):
                                                                     $manage_supplier_info = json_decode($rows["manage_supplier_info"]);
                                                                 endforeach;?>
                                                                  <input type="text" class="form-control" value="<?php echo $manage_supplier_info->supplierName ?>" readonly> 
                                                                   <input type="hidden" class="form-control" id="supplier" name="supplier" value="<?php echo $rows['manage_supplier_id'] ?>" readonly> 
                                                                </div>
                                                        </div>
                               
<!--
                                                            <div class="col-sm-7">&nbsp;</div>


                                                            <div class="col-sm-2">&nbsp;</div>
                                                            <div class="col-sm-3">&nbsp;</div>
                                                            <div class="col-sm-7">&nbsp;</div>
-->
                                          
                                                    </div>
                                                    <div class="col-sm-4">
                                                
                                                            <div class="col-sm-12"><label for="">GRN Date :</label> </div>
                                                            <div class="col-sm-12"><input type="text" class="form-control" name="grn_date" value="<?php
                                                                    echo date('d/m/Y');?>" required></div>
<!--                                                            <div class="col-sm-12">&nbsp;</div>-->


<!--
                                                            <div class="col-sm-2">&nbsp;</div>
                                                            <div class="col-sm-3">&nbsp;</div>
                                                            <div class="col-sm-7">&nbsp;</div>
-->
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="col-sm-12"><label for="">Bill No. :</label> </div>
                                                        <div class="col-sm-12"><input type="text" class="form-control" name="bill_no" required></div>
<!--                                                        <div class="col-sm-7">&nbsp;</div>-->
                                                    </div>
                                   <input type="hidden" name="project" id="project" value="<?php echo $manage_po_info->project ?>" class="form-control" readonly>

                                              </div>
                                            </div>
                                            <?php endforeach; ?>
                                             <?php endif; ?>



                                            <!-- End vendor Basic -->
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <br>
                                <section class="content">
                  <div class="container-fluid">
                    <div class="card card-default">
                      <div class="card-header">
<!--                        <h3 class="card-title">PO Items</h3>-->

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                          <div class="col-md-12 table-responsive" style="overflow-x:auto;">
<!--                        <div class="table-responsive" style="overflow-x:auto;">-->
                            <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">

                      <tr>
                        <th>S.NO</th>
                        <th >Item Code</th>
                        <th >Item Name</th>
                        <th>UOM</th>
                        <th >Quantity</th>
                        <th>Rate</th>
                        <th >Amount</th>
                        <th >Cgst%</th>
                        <th>Sgst%</th>
                        <th >Igst%</th>
                        <th >Total Amount</th>
                       <!--  <th>Actions</th> -->
                       
                      </tr>
                        
                         
                             
                        <?php
                            $cnt = 1; 
                            $totalAll = 0;
                            foreach($manage_po_info->item_info as $item_info_item):  

                                        
                                  $databaseObj->select("tbl_manage_item");

                                  $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$item_info_item->itemCode."'");
                                  $getDatas = $databaseObj->get();
                                  if($getDatas != 0):
                                    foreach($getDatas as $rows_deptt):
                                      $itemName = $rows_deptt["itemName"];
                                      $itemCode = $rows_deptt["itemCode"];
                                      $itemCategory = $rows_deptt["itemCategory"];
                                      $Uom = $rows_deptt["Uom"];
                                                            // $Qty = $rows_deptt["Qty"];
                                    endforeach;
                                  endif;?>
                                
                                
                              <tr id="row<?php echo $cnt; ?>">

                                 <td ><input type="text" id="slno<?php echo $cnt; ?>" value="<?php echo $cnt; ?>" readonly class="form-control" style="width: 40px;"></td>
                                 <td >


                                     <select id="item_code[<?php echo $cnt; ?>]" name="item_code[]" class="form-control" readonly style="width: 80px;" >
                                         <?php 

                                $databaseObj->select("tbl_manage_item");
                                $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$item_info_item->itemCode."'");
                                $item_det = $databaseObj->get(); 
                                $item_deltails =  array();
                                foreach($item_det as $item_det_all)
                                $item_deltails = $item_det_all;

                                ?>


                                         <option value="<?= $item_deltails["manage_item_id"] ?>"><?= $item_deltails["itemCode"] ?></option>
                                     </select>

                                 </td>
                                 
                                <td width="">
                                 <select id="item_name[<?php echo $cnt; ?>]" name="item_name[]" class="form-control" style="width: 195px;" readonly>
                                 <?php 
                                     
                                    $databaseObj->select("tbl_manage_item");
                                    $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$item_info_item->itemName."'");
                                    $item_det = $databaseObj->get(); 
                                    $item_deltails =  array();
                                    foreach($item_det as $item_det_all)
                                    $item_deltails = $item_det_all;
                                     ?>                           
                                    <option value="<?= $item_deltails["manage_item_id"] ?>"><?= $item_deltails["itemName"] ?></option>
                                    </select>
                                </td>
                                
                                
                                 <td>
                                    <select id="item_name[<?php echo $cnt; ?>]" name="uom[]" class="form-control" readonly style="width: 79px;">

                                    <?php 
                                    $databaseObj->select("tbl_manage_item");
                                    $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$item_info_item->uom."'");
                                    $item_det = $databaseObj->get(); 
                                    $item_deltails =  array();
                                    
                                    foreach($item_det as $item_det_all)
                                    $item_deltails = $item_det_all;
                                    ?>
                                       <option value="<?= $item_deltails["manage_item_id"] ?>"><?= $item_deltails["Uom"] ?>
                                      </select>
                                    </td>


                                <td><input type="text" name="quantity[]" placeholder="" id="tonne_id[<?php echo $cnt; ?>][tonne]" style="width: 50px;" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); cal_totalAll(<?php echo $cnt; ?>);" class="form-control" value="<?php echo $item_info_item->quantity; ?>"></td>
                                
                                <td><input type="text" name="rate[]"  placeholder="" id="rate_id[<?php echo $cnt; ?>][rate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); cal_totalAll(<?php echo $cnt; ?>);" value="<?php echo $item_info_item->rate; ?>" class="form-control" style="width: 50px;"></td>
                                
                                <td><input type="text" name="amount[]" placeholder="" id="amount_id[<?php echo $cnt; ?>][amount]" class="form-control" value="<?php echo $item_info_item->amount; ?>" style="width: 50px;"readonly /></td>
                                

                                <td><input type="text" name="cgstrate_po[]" value="0" placeholder="" id="cgst_id[<?php echo $cnt; ?>][cgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" style="width: 50px;" class="form-control" readonly></td>
                                    <td><input type="text" name="sgstrate_po[]" value="0" placeholder="" id="sgst_id[<?php echo $cnt; ?>][sgstrate]"  style="width: 50px;" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" class="form-control" readonly></td>
                                    <td><input type="text" name="igstrate_po[]" value="0" style="width: 50px;" placeholder="" id="igst_id[<?php echo $cnt; ?>][igstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" class="form-control" readonly></td>


                                <td><input type="text" name="total[]" value="<?php echo $item_info_item->total; ?>" placeholder="" id="total_id[<?php echo $cnt; ?>][total]" class="form-control"  onkeyup="cal_totalAll(<?php echo $cnt; ?>);" readonly style="width: 100px;" /></td>
                               

                               <!--  <td> -->
                           
                           <!--  <button type="button" name="remove" id="<?php echo $cnt; ?>" class="btn btn-danger btn_remove">X</button>
                            -->
                          

                                
<!--                                <button type="button" name="remove" id="<?php echo $cnt; ?>" class="btn btn-danger btn_remove">X</button>-->
                               <!--  </td> -->

                              </tr>
                              <?php
                                $cnt++; 
                                 endforeach;
                               ?>

                               <tfoot>
                                   <tr>
                                    <th colspan="9"></th>
                                   <th>Total : </th>
                                  <th>

                                     <input type="text" name="totalAll" id="totalAll" class="form-control" value="<?= $manage_po_info->totalAll ?>"  readonly>
                                 </th>
                                                  

                                 
                                   </tr>
                               </tfoot>
                          
                            </table>
                             <input type="hidden" class="form-control" value="<?php echo $cnt ?>" id="counter" name="counter">
                        </div>
                      </div>
                    </div>
                  </div>
</section>
                               <script>
                                function cal(si){
                    
                    
                     if(document.getElementById('tonne_id['+si+'][tonne]').value!="" && document.getElementById('rate_id['+si+'][rate]').value!=""){
                       document.getElementById('amount_id['+si+'][amount]').value = document.getElementById('tonne_id['+si+'][tonne]').value*document.getElementById('rate_id['+si+'][rate]').value;
                       var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id['+si+'][sgstrate]').value);                      
                       var iamt = Number(document.getElementById('igst_id['+si+'][igstrate]').value)
                       var total = amt+camt+samt+iamt;
                       // var t_camt= amt * (camt/100);
                       // var t_samt=  amt * (samt/100);
                       // var t_iamt=  amt * (iamt/100);
                       // var total = amt+t_camt+t_samt+t_iamt;
                       total = total.toFixed(2);
                       
                       document.getElementById('total_id['+si+'][total]').value = total;
                     } else{
                       document.getElementById('amount_id['+si+'][amount]').value = "";
                       var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id['+si+'][igstrate]').value);
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
                       document.getElementById('cgst_id['+si+'][cgstrate]').value = cgstr;
                       var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id['+si+'][total]').value = total;
                     } else{
                       document.getElementById('cgst_id['+si+'][cgstrate]').value = "";
                       var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id['+si+'][igstrate]').value);
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
                       
                       
                       var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id['+si+'][total]').value = total;

                     } else{
                      
                       var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id['+si+'][igstrate]').value);
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
                      
                       var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id['+si+'][total]').value = total;
                     } else{
                       
                       var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id['+si+'][total]').value = total;
                     }
                   }
                               
                
                     
                     
                     
                     
                     
                      var i = <?php echo $cnt; ?>
                    
                 $('#add').click(function(){
                     
                     $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><input type="text" id="slno'+i+'" value="'+i+'" readonly class="form-control" style="border:none;" /></td><td>' +'<select id="item_code[' + i + ']" name="item_code[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item");$databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$item_info_item->itemCode."'");$item_det = $databaseObj->get(); $item_deltails =  array();foreach($item_det as $item_det_all):$item_deltails = $item_det_all;?><option value="<?= $item_deltails["manage_item_id"] ?>"><?= $item_deltails["itemCode"] ?></option>  <?php endforeach; ?> </select></td><td>' +'<select id="item_name[' + i + ']" name="item_name[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item");  $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0):$sno = 1;  foreach($getData as $rows):?><option value="<?= $rows["manage_item_id"] ?>"><?= $rows["itemName"] ?></option>  <?php endforeach; endif; ?> </select></td><td>' +'<select id="uom[' + i + ']" name="uom[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onchange="onSelection('+i+',this.value);" onblur="onSelection('+i+',this.value);"><?php $databaseObj->select("tbl_manage_item");  $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0):$sno = 1;  foreach($getData as $rows):?><option value="<?= $rows["manage_item_id"] ?>"><?= $rows["Uom"] ?></option>  <?php endforeach; endif; ?> </select></td><td><input type="text" name="quantity[]" placeholder="" id="tonne_id['+i+'][tonne]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control"></td><td><input type="text" name="rate[]"  placeholder="" id="rate_id['+i+'][rate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control"></td><td><input type="text" name="amount[]" placeholder="" id="amount_id['+i+'][amount]" class="form-control" readonly /></td><td><input type="text" name="cgstrate[]" value="9" placeholder="" id="cgst_id['+i+'][cgstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control cGstValue"/><input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id['+i+'][cgstamt]" class="form-control" hidden /></td><td><input type="text" name="sgstrate[]" value="9" placeholder="" id="sgst_id['+i+'][sgstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control sGstValue"/><input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id['+i+'][sgstamt]" class="form-control" hidden /></td<td><input type="text" name="igstrate[]" value="0" placeholder="" id="igst_id['+i+'][igstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control iGstValue"/><input type="text" name="igstamt[]" placeholder="" id="igstamt_id['+i+'][igstamt]" class="form-control" hidden /></td><td><input type="text" name="total[]" placeholder="" id="total_id['+i+'][total]" class="form-control" readonly /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"  onkeyup="cal_totalAll('+i+');">X</button></td></tr>');
                   
                 }); 
                     
                     
                     
                $(document).on('click', '.btn_remove', function(){
                      var button_id = $(this).attr("id");
                      $('#row'+button_id+'').remove(); 
                   i--;
                 });
                   
               </script>  
                               
                               <script>
                        function onSelection(id, val)
                        {
                            var code_id = "item_code[" +id+ "]";
                            var name_id = "item_name[" +id+ "]";
                            var uom_id =  "uom[" +id+ "]";

                            console.log(code_id+ " " +name_id+ " "+uom_id);
                            document.getElementById(code_id).value = val;
                            document.getElementById(name_id).value = val;
                            document.getElementById(uom_id).value =  val;
                        }
                         function cal_totalAll(si){
                     var count= Number(document.getElementById('counter').value);
                     // alert(total);
                     var totalAmt=0;
                      console.log(count-1);
                      for(i=1;i<=(count-1);i++){
                        console.log(Number(totalAmt));
                        totalAmt=Number(totalAmt)+Number(document.getElementById('total_id['+i+'][total]').value);
                        console.log(totalAmt);
                        document.getElementById('totalAll').value=totalAmt;
                        
                      }
                     //document.getElementById('totalAll').value = total;   
                   } 
                    </script>
                               
                               
                               <br>
                                
                                <div class="panel-body container-fluid">
                                    <div class="row row-lg">
                                        <div class="col-lg-12">
                                            <!-- vendor Basic -->
                                            <div class="vendor-wrap">
                                                <div class="row">
                                                    <div class="col-sm-2"> <label for="">Payment Mode : </label> </div>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" name="payment_mode" id="payment_mode" onchange="mode(this.value)">
                                                            <option value="Cash">Cash</option>
                                                            <option value="Cheque">Cheque</option>
                                                            <option value="DD">DD</option>
                                                            <option value="NEFT">NEFT</option>
                                                            <option value="NEFT">SEND TO FINANCE</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-7">&nbsp;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">&nbsp;</div>
                                                    <div class="col-sm-3">&nbsp;</div>
                                                    <div class="col-sm-7">&nbsp;</div>
                                                </div>
                                                <div id="mode" style="display:none;">

                                                   <div class="row">
                                                        <div class="col-sm-2"> <label for="">Bank Name : </label> </div>
                                                        <div class="col-sm-3"> <input type="text" name="bank_name" value="" class="form-control"> </div>
                                                        <div class="col-sm-7">&nbsp;</div>
                                                    </div>

                                                        <div class="row">
                                                        <div class="col-sm-2">&nbsp;</div>
                                                        <div class="col-sm-3">&nbsp;</div>
                                                        <div class="col-sm-7">&nbsp;</div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-sm-2"> <label for="">Account Number : </label> </div>
                                                        <div class="col-sm-3"> <input type="text" name="acc_no" value="" class="form-control"> </div>
                                                        <div class="col-sm-7">&nbsp;</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2">&nbsp;</div>
                                                        <div class="col-sm-3">&nbsp;</div>
                                                        <div class="col-sm-7">&nbsp;</div>
                                                    </div>


                                                    <div class="row">
                                                    <div class="col-sm-2"> <label for="">IFSC Code : </label> </div>
                                                    <div class="col-sm-3"> <input type="text" name="ifsc_code" value="" class="form-control"> </div>
                                                    <div class="col-sm-7">&nbsp;</div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-sm-2">&nbsp;</div>
                                                    <div class="col-sm-3">&nbsp;</div>
                                                    <div class="col-sm-7">&nbsp;</div>
                                                    </div>




                                                    <div class="row">
                                                        <div class="col-sm-2"> <label for="">Cheque/DD/NEFT Number : </label> </div>
                                                        <div class="col-sm-3"> <input type="text" name="cheque_no" value="" class="form-control"> </div>
                                                        <div class="col-sm-7">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">&nbsp;</div>
                                                    <div class="col-sm-3">&nbsp;</div>
                                                    <div class="col-sm-7">&nbsp;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">Narration : </div>
                                                    <div class="col-sm-7"> <textarea name="narration" class="form-control" rows="8" cols="80"></textarea> </div>
                                                    <div class="col-sm-3">&nbsp;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">&nbsp;</div>
                                                    <div class="col-sm-3">&nbsp;</div>
                                                    <div class="col-sm-7">&nbsp;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">&nbsp;</div>
                                                    <div class="col-sm-4"><button type="" name="receive_goods" id="receive_goods" class="btn btn-success">RECEIVE GOODS</button></div>
                                                    <div class="col-sm-4">&nbsp;</div>
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
 <script src="dist/js/main.js"></script>

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
