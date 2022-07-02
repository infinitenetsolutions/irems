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
            $databaseObj->select("tbl_manage_po");
            $databaseObj->where("`status` = '".$auth->visible()."'");
            $getData = $databaseObj->get();
            $ordNo = 1;
            foreach ($getData as $rows) {
              $ordNo = $rows["manage_po_id"]+1;
            }
                ?>
                <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/purchase-order.php">
                <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_po">
                <input type="hidden" id="action" name="action" value="addPO">
                <section class="content">
                  <div class="container-fluid">
                    <div class="card card-default">
                      <div class="card-header">
                        <h3 class="card-title">PO Details</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>PO No</label>
                              <input class="form-control" name="orderNo" id="orderNo" type="text" value="<?php echo $ordNo; ?>" readonly>
                            </div>
                            <div class="form-group">
                              <label>State</label>
                              <select class="country form-control select2" name="state" id="state" style="width: 100%;">
                                <option value="Andhra Pradesh" >Andhra Pradesh</option>
                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                <option value="Assam">Assam</option>
                                <option value="Bihar">Bihar</option>
                                <option value="Chhattisgarh">Chhattisgarh</option>
                                <option value="Goa">Goa</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Haryana">Haryana</option>
                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                <option value="Jammu & Kashmir">Jammu & Kashmir</option>
                                <option selected="selected" value="Jharkhand">Jharkhand</option>
                                <option value="Karnataka">Karnataka</option>
                                <option value="Kerala">Kerala</option>
                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Manipur">Manipur</option>
                                <option value="Meghalaya">Meghalaya</option>
                                <option value="Mizoram">Mizoram</option>
                                <option value="Nagaland">Nagaland</option>
                                <option value="Odisha">Odisha</option>
                                <option value="Punjab">Punjab</option>
                                <option value="Rajasthan">Rajasthan</option>
                                <option value="Sikkim">Sikkim</option>
                                <option value="Tamil Nadu">Tamil Nadu</option>
                                <option value="Tripura">Tripura</option>
                                <option value="Uttarakhand">Uttarakhand</option>
                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                <option value="West Bengal">West Bengal</option>
                                <option value="Andaman & Nicobar">Andaman & Nicobar</option>
                                <option value="Chandigarh">Chandigarh</option>
                                <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                <option value="Daman & Diu">Daman & Diu</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Lakshadweep">Lakshadweep</option>
                                <option value="Puducherry">Puducherry</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>PO Date</label>
                              <input class="form-control" name="poData" id="poData" type="date">
                            </div>
                            <div id="response" class="form-group">
                              <label>Code</label>
                               <input class="form-control" name="stateCode" id="stateCode" type="text" value="20" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>


                <?php
                $databaseObj->select("tbl_manage_supplier");
                $databaseObj->where("`status` = '".$auth->visible()."'");
                $getData = $databaseObj->get();
                 ?>
                <section class="content">
                  <div class="container-fluid">
                    <div class="card card-default">
                      <div class="card-header">
                        <h3 class="card-title">To :</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Supplier/Vendor</label>
                              <input list="supplier" class="form-control" name="vendor_name" id='vendor_name' style="width: 100%;">
                              <datalist id="supplier">
                              <?php
                              foreach ($getData as $rows) {
                                $manage_po_info = json_decode($rows["manage_supplier_info"]);
                              ?>
                              <option value="<?= $manage_po_info->supplierName ?>"></option>
                              <?php
                              }
                               ?>
                              </datalist>
                            </div>
                          </div>
                          <div class="col-md-6">
                          <div id="branchName">
                          <div id="view" >
                            <div class="form-group">
                              <label>Address</label>
                              <input class="form-control" name="vendor_address" type="text">
                            </div>
                            <div id="response" class="form-group">
                              <label>GSTIN</label>
                               <input class="form-control" name="vendor_gstin" type="text">
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
                        <h3 class="card-title">Billing Address : </h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Company Name</label>
                              <input list="company" class="form-control select2" name="company_name" id='company_name' style="width: 100%;">
                              <datalist id="company">
                                <?php
                                $databaseObj->select("tbl_manage_company");
                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                $getCompanyData = $databaseObj->get();
                                foreach ($getCompanyData as $row) {
                                  $manage_company_info = json_decode($row["manage_company_info"]);
                                  ?>
                                  <option value="<?= $manage_company_info->companyName ?>"></option>
                                  <?php
                                }
                                 ?>
                              </datalist>
                            </div>
                            <div id="gstin">
                            <div id="viewgstin">
                            <div class="form-group">
                              <label>GSTIN</label>
                               <input class="form-control" name="company_gstin" type="text">
                            </div>
                            </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                          <div id="company">
                          <div id="viewcompany" >
                            <div class="form-group">
                              <label>Phone</label>
                               <input class="form-control" name="company_phone" id="company_phone" type="number">
                            </div>
                            <div class="form-group">
                              <label>Address</label>
                              <input class="form-control" name="company_address" id="company_address" type="text">
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
                        <h3 class="card-title">PO Items</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">

                      <tr>
                        <th width="5%">S.NO</th>
                        <th width="35%">Item Name</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">Unit Price</th>
                        <th width="10%">Amount</th>
                        <th width="5%">Cgst%</th>
                        <th width="5%">Sgst%</th>
                        <th width="5%">Igst%</th>
                        <th width="10%">Total Amount</th>
                        <th width="5%">Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th>
                      </tr>
                          <?php
                          if (isset($_POST["ckeckItem"])) {
                            foreach ($_POST["ckeckItem"] as $item) {
                              ?>
                              <tr id="row<?php echo $cnt; ?>">
                                 <td><input type="text" id="slno<?php echo $cnt; ?>" value="<?php echo $cnt; ?>" readonly class="form-control"></td>
                                <td>
                                  <?php
                                  $databaseObj->select("tbl_manage_item");
                                  $databaseObj->where("`status` = '".$auth->visible()."'");
                                  $getItemData = $databaseObj->get();
                                   ?>
                                   <input list="item" type="text" name="item_name[]" id="item_name[<?php echo $cnt; ?>]" value="<?php foreach ($getItemData as $row) { if ($row["manage_item_id"] == $_POST["ckeckItem"][$cnt-1]) { echo $row["itemName"]; } } ?>" class="form-control">
                                   <datalist id="item">
                                     <?php
                                     $databaseObj->select("tbl_manage_item");
                                     $databaseObj->where("`status` = '".$auth->visible()."'");
                                     $getItemData = $databaseObj->get();
                                     foreach ($getItemData as $row) {
                                       ?>
                                       <option value="<?= $row["itemName"] ?>"></option>
                                       <?php
                                     }
                                      ?>
                                    </datalist>

                                </td>


                                <td><input type="text" name="quantity[]" placeholder="" id="tonne_id[<?php echo $cnt; ?>][tonne]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); getGst();" class="form-control" style=""></td>
                                <td><input type="text" name="rate[]"  placeholder="" id="rate_id[<?php echo $cnt; ?>][rate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); getGst();" class="form-control" ></td>
                                <td><input type="text" name="amount[]" placeholder="" id="amount_id[<?php echo $cnt; ?>][amount]" class="form-control"  readonly /></td>

                                <td><input type="text" name="cgstrate[]" value="9" placeholder="" id="cgst_id[<?php echo $cnt; ?>][cgstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control cGstValue" ></td>
                                <input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id[<?php echo $cnt; ?>][cgstamt]" class="form-control"  hidden />

                                <td><input type="text" name="sgstrate[]" value="9" placeholder="" id="sgst_id[<?php echo $cnt; ?>][sgstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control sGstValue" ></td>
                                <input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id[<?php echo $cnt; ?>][sgstamt]" class="form-control"   hidden />

                                <td><input type="text" name="igstrate[]" value="0" placeholder="" id="igst_id[<?php echo $cnt; ?>][igstrate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>);" class="form-control iGstValue" ></td>
                                <input type="text" name="igstamt[]" placeholder="" id="igstamt_id[<?php echo $cnt; ?>][igstamt]" class="form-control"  hidden />


                                <td><input type="text" name="total[]" placeholder="" id="total_id[<?php echo $cnt; ?>][total]" class="form-control"  readonly /></td>


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
                                 <input list="item" type="text" name="item_name[]" id="item_name" class="form-control">
                                 <datalist id="item" class="">
                                   <?php
                                   $databaseObj->select("tbl_manage_item");
                                   $databaseObj->where("`status` = '".$auth->visible()."'");
                                   $getItemData = $databaseObj->get();
                                   foreach ($getItemData as $row) {
                                     ?>
                                     <option value="<?= $row["itemName"] ?>"></option>
                                     <?php
                                   }
                                    ?>
                                  </datalist>

                              </td>


                              <td><input type="text" name="quantity[]" placeholder="" id="tonne_id[1][tonne]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1); getGst();" class="form-control" style=""></td>
                              <td><input type="text" name="rate[]"  placeholder="" id="rate_id[1][rate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1); getGst();" class="form-control" ></td>
                              <td><input type="text" name="amount[]" placeholder="" id="amount_id[1][amount]" class="form-control"  readonly /></td>

                              <td><input type="text" name="cgstrate[]" value="9" placeholder="" id="cgst_id[1][cgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" class="form-control cGstValue" ></td>
                              <input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id[1][cgstamt]" class="form-control"  hidden />

                              <td><input type="text" name="sgstrate[]" value="9" placeholder="" id="sgst_id[1][sgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" class="form-control sGstValue" ></td>
                              <input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id[1][sgstamt]" class="form-control"   hidden />

                              <td><input type="text" name="igstrate[]" value="0" placeholder="" id="igst_id[1][igstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" class="form-control iGstValue" ></td>
                              <input type="text" name="igstamt[]" placeholder="" id="igstamt_id[1][igstamt]" class="form-control"  hidden />


                              <td><input type="text" name="total[]" placeholder="" id="total_id[1][total]" class="form-control"  readonly /></td>


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
                               <div class="col-md-6">
                                 <div class="form-group">
                                   <label>Payment Terms</label>
                                 <textarea width="600" name="payment_terms" id="payment_terms" class="form-control"></textarea>
                                 <script>
                                    CKEDITOR.replace( 'payment_terms' );
                                 </script>
                                 </div>
                             </div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </section>

                <section class="content">
                                 <h3 class="card-title float-right">
                                     <button id="addButton" type="submit" class="order-button btn btn-sm btn-success mt-1 mb-1" title="Create PO">
                                         <i class="fa fa-cart-plus fa-sm"></i> Order Now
                                     </button>
                                 </h3>
                     </section>
                </form>
                <script>
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
               $('#vendor_name').on('input', function( event ) {
                   $.ajax({
                       url: 'getInformationsvendor.php',
                       type: 'POST',
                       data: $('#selectForm').serializeArray(),
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
                     $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><input type="text" id="slno'+i+'" value="'+i+'" readonly class="form-control" style="border:none;" /></td><td>' +
           		   '<input list = "item" type="text" name="item_name[]" class="form-control" ></td><td><input type="text" name="quantity[]" placeholder="" id="tonne_id['+i+'][tonne]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control"></td><td><input type="text" name="rate[]"  placeholder="" id="rate_id['+i+'][rate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+'); getGst();" class="form-control"></td><td><input type="text" name="amount[]" placeholder="" id="amount_id['+i+'][amount]" class="form-control" readonly /></td><td><input type="text" name="cgstrate[]" value="9" placeholder="" id="cgst_id['+i+'][cgstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control cGstValue"/><input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id['+i+'][cgstamt]" class="form-control" hidden /></td><td><input type="text" name="sgstrate[]" value="9" placeholder="" id="sgst_id['+i+'][sgstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control sGstValue"/><input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id['+i+'][sgstamt]" class="form-control" hidden /></td><td><input type="text" name="igstrate[]" value="0" placeholder="" id="igst_id['+i+'][igstrate]" onkeyup="cal('+i+'); cal_cgst('+i+'); cal_sgst('+i+'); cal_igst('+i+');" class="form-control iGstValue"/><input type="text" name="igstamt[]" placeholder="" id="igstamt_id['+i+'][igstamt]" class="form-control" hidden /></td><td><input type="text" name="total[]" placeholder="" id="total_id['+i+'][total]" class="form-control" readonly /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                 });

                 $(document).on('click', '.btn_remove', function(){
                      var button_id = $(this).attr("id");
                      $('#row'+button_id+'').remove();
                 });
                   });
               </script>
               <script>
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
