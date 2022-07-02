  <!-- Purchase Order -->
  <?php
      $page_no = "4";
      $page_no_inside = "4_2";
  ?>
  <?php require_once("include/auth.php");
      require_once("application/classes-and-objects/config.php");
      require_once("application/classes-and-objects/veriables.php"); ?>
  <!DOCTYPE html>
  <html>

  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Create PO</title>
      <!-- Css Section Start -->
      <?php require_once("include/css.php"); ?>
      <!-- Css Section End -->
  </head>

  <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">
      <div id="wrapper" class="wrapper">
          <!-- Navbar Section Start -->
          <?php require_once("include/navbar.php"); ?>

          <!-- Navbar Section End -->
          <!-- Main Sidebar Section Start -->
          <?php require_once("include/aside.php"); ?>

          <!-- Main Sidebar Section End -->

          <!-- All Contains Section Start -->
          <div class="content-wrapper">
              <div class="content-header">
                  <div class="container-fluid">
                      <div class="row mb-2">
                          <div class="col-sm-6">
                              <h1 class="m-0 text-dark">Maintainance</h1>
                          </div><!-- /.col -->
                          <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                  <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                  <li class="breadcrumb-item active">Create Bill</li>
                              </ol>
                          </div>
                      </div><!-- /.row -->
                  </div><!-- /.container-fluid -->
              </div>
              <!-- Main content -->
             
              <section class="content">
                <div class="card card-navy card-outline">
                  <div class="card-body table-responsive">
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/purchase-order.php">
                      <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_po">
                      <input type="hidden" id="action" name="action" value="addPO">
                      <input type="hidden" id="secondaryLocation" name="checkLocation" />
                      <input type="hidden" id="secondaryIp" name="checkIp" />
                      <section class="content">
                        <div class="container-fluid">
                           <div class="card card-default">
                             <div class="card-header">
                               <h3 class="card-title">Maintainance Services</h3>
                                 <div class="card-tools">
                                   <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                 </div>
                             </div>
                             <div class="card-body">
                                <div class="row">



                                 <div class="col-md-6">
                                      <div class="form-group">
                                         <label>Invoice No</label>

                                         <?php
                                         $databaseObj->select("tbl_maintainance");
                                         $databaseObj->where("`status` = '".$auth->visible()."'");
                                         $getData = $databaseObj->get();
                                         $ordNo = 1;
                                         foreach ($getData as $rows):
                                         $ordNo =  $ordNo +1;
                                         endforeach;
                                        $invoice_no = str_pad($ordNo, 4, '0', STR_PAD_LEFT);
                                          ?>
                                  <input class="form-control" name="invoiceNo" id="invoiceNo" type="text" value="<?= $invoice_no ?>" readonly>
                                      </div>
                                    </div>


                                       <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Invoice Date</label> 
                                      <input class="form-control" name="invoiceDate" id="" type="date" value="">
 
                                      </div>
                                    </div>

                                      <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Delivery Note</label> 
                                      <input class="form-control" name="deliveryNote" id="" type="text" value="">
                                      </div>
                                    </div>


                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Mode/Terms of payment</label> 
                                      <input class="form-control" name="modeofpayment" id="" type="text" value="">
                                      </div>
                                    </div>


                                         
                                    <?php
                                    $databaseObj->select("tbl_projects");
                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                    $getData = $databaseObj->get();
                                    ?>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                         <label>Project Name</label>
                                      <select class="form-control select2" name="projects" id='project' style="width: 100%;">
                                        <option value="">Select Project Name</option>
                                        <?php
                                        foreach ($getData as $rows):
                                        $projects_info = json_decode($rows["projects_info"]);
                                        ?>

                                        <option value="<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                        </select> 
                                      
                                      </div>
                                    </div>  


                                     <div class="col-md-6">
                                      <div id="projects">
                                     <div id="view" >
                              
                                   </div>
                                </div>
                              </div>
                                  
                                   
                                  
                                    <div class="col-md-6">
                                      <div class="form-group">
                                         <label>Contact No.</label>
                                         <input class="form-control" name="contactNo" id="" type="text" value="">
                                         
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div id="response" class="form-group">
                                         <label>State Code</label>
                                         <input class="form-control" name="stateCode" id="stateCode" type="text" value="20" readonly>
                                      </div>
                                    </div>
                            
                                    <div class="col-md-6">
                                      <div id="requisitionDate">
                                        <div id="viewDate" >
                                  
                                        </div>
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
                                <select class="form-control select2" name="vendor_name" id='vendor_name' style="width: 100%;">
                                  <option value="">Select</option>
                                     <?php
                                       foreach ($getData as $rows):
                                         $manage_supplier_info = json_decode($rows["manage_supplier_info"]);
                                          ?>

                                          <option value="<?= $rows["manage_supplier_id"] ?>"><?= $manage_supplier_info->supplierName ?></option>
                                           <?php
                                        endforeach;
                                      ?>
                                </select> 
                                
                             
                              </div>
                            </div>
                            <div class="col-md-6">
                             <div id="branchName">
                              <div id="view" >
                              
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
                                  <select id="company_name" name="company_name" class="form-control">
                                  <option value="">Select Company</option>
                                <?php
                                  $databaseObj->select("tbl_manage_company");
                                  $databaseObj->where("`status` = '".$auth->visible()."'");
                                  $getCompanyData = $databaseObj->get();
                                  foreach ($getCompanyData as $row) {
                                    $manage_company_info = json_decode($row["manage_company_info"]);
                                    ?>
                                    <option value="<?= $row["manage_company_id"] ?>"><?= $manage_company_info->companyName ?></option>
                                    <?php
                                    // endforeach;
                                  }
                                   ?>
                                  </select>
                              </div>

                            </div>
                            <div class="col-md-6">
                            <div id="company">
                            <div id="viewcompany" >
                            </div>
                            </div>
                            </div>
                          </div>

                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label>Contact Person</label>

                                  <select id="billing_contact_person" name="billing_contact_person" class="form-control">
                                  <option value="">Select Employee</option>

                                <?php

                                  $databaseObj->select("tbl_manage_employee");

                           
                                         $databaseObj->where("`status` = '".$auth->visible()."'");

                                  $getCompanyData = $databaseObj->get();

                                  foreach ($getCompanyData as $row) {

                                    $manage_employee_info = json_decode($row["manage_employee_info"]);
                                    ?>

                                    <option value="<?= $row["manage_employee_id"] ?>"><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?></option>

                                    <?php
                                    // endforeach;

                                  }

                                   ?>

                                  </select>

                              </div>
                            
                            </div>

                            <div class="col-md-6">

                            <div id="contactPerson">

                            <div id="viewdesignation" >
                            
                               
                              
                              
                          
        
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

                          <h3 class="card-title">Delivering Address : </h3>
                       
                          <div class="card-tools">

                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

                          </div>

                        </div>

                        <div class="card-body">

                          <div class="row">

                           <!--  <div class="col-md-6"> -->

                              <!-- <div class="form-group">

                                <?php
                                  $databaseObj->select("tbl_projects");

                                  $databaseObj->where("`status` = '".$auth->visible()."'");

                                  $getData = $databaseObj->get();

                                   ?>
                              
                                    <label>Project Name</label>
                                    
                                    <select class="form-control select2" name="project" id='project' style="width: 100%;">
                                      <option value="">Select Project</option>

                                    <?php
                                    foreach ($getData as $rows) {
                                      $projects_info = json_decode($rows["projects_info"]);
                                    ?>

                                    <option value="<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?></option>
                                    <?php
                                    }

                                     ?>

                                    </select>
                                 
                                  </div> -->

                                     
                                          <?php
                                          $databaseObj->select("tbl_projects");
                                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_indent_info->employee_project."'");
                                                $getData = $databaseObj->get();
                                                
                                                
                                                if($getData != 0):
                                                  foreach($getData as $rows):
                                                     $projects_info = json_decode($rows["projects_info"]);
                                                     // $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                                  endforeach;
                                                endif; 
                                            ?>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Project</label>
                                            
                                              <input class="form-control"  type="text" value="<?= $projects_info->projectName ?>" readonly> 
                                               <input class="form-control" name="project" id="project" type="hidden" value="<?= $rows["projects_id"] ?>" readonly>     
                                    
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Project Location</label>
                                            
                                              <input class="form-control" name="projectLocation" id="projectLocation" type="text" value="<?= $projects_info->projectLocation ?>" readonly>     
                                    
                                            </div>
                                          </div>

                                    </div>
                                    </div>
                               
                            

                            
                            
                              <div class="col-md-6">

                                <div id="viewproject456">

                                  <div id="project_sec_div1" >
                            
                               
                                
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
                                    <th width="3%">S.NO</th>                                    
                                    <th width="10%">Item Code</th>
                                    <th width="44%">Item Name</th>
                                    <th width="10%">UOM</th>
                                    <th width="5%">Quantity</th>
                                    <th width="2%">Rate</th>
                                    <th width="10%">Amount</th>
                                    <th width="5%">Cgst%</th>
                                    <th width="5%">Sgst%</th>
                                    <th width="5%">Igst%</th>
                                     <th width="15%">Remark</th>
                                    <th width="10%">Total Amount</th>
                                    
                                   <!--  <th width="5%">Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th> -->
                                  </tr>
                                  <?php
                                    $cnt = 1;
                                             
                                      foreach ($manage_indent_info->item_info as $item_info):  
                                        // echo "<pre>";
                                        // print_r($item_info->itemCode);
                                        // echo "</pre>";
                                                       ?>
                                 <tr>
                                  <td width="5%"><?= $cnt ?>.</td>
                                
                                  
                                  <?php
                                   $databaseObj->select("tbl_manage_item");

                                                     $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$item_info->itemCode."'");
                                                     
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
                                                      // echo "<pre>";
                                                      // print_r($item_info->itemCode);
                                                      // echo "</pre>";
                                                      ?>
                                                      
                                 <td><input type="hidden" class="form-control" name="item_code_po[]" id="item_code_po[<?php echo $cnt; ?>]"  value="<?= $item_info->itemCode ?>" readonly> <input type="text" class="form-control"  value="<?= $itemCode ?>" readonly>  </td>
                                 
                                 <td><input type= "hidden"class="form-control" name="item_name_po[]" id="item_name_po[<?php echo $cnt; ?>]" type="text" value="<?= $item_info->itemName ?>" readonly>
                                  <input class="form-control"  type="text" value="<?= $itemName ?>" readonly></td>

                                 <td><input type= "hidden" class="form-control" name="uom_po[]" id="uom_po[<?php echo $cnt; ?>]" value="<?= $item_info->uom ?>" readonly
                                  ><input class="form-control"  type="text" value="<?= $uom ?>" readonly></td>
                                 <td><input class="form-control" name="quantity_po[]" id="tonne_id_po[<?php echo $cnt; ?>][tonne]" type="text" value="<?= $item_info->quantity ?>" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); cal_totalAll(<?php echo $cnt; ?>);" ></td>
                                  
                                    
                                    <td><input type="text" name="rate_po[]"  placeholder="" id="rate_id_po[<?php echo $cnt; ?>][rate]" onkeyup="cal(<?php echo $cnt; ?>); cal_cgst(<?php echo $cnt; ?>); cal_sgst(<?php echo $cnt; ?>); cal_igst(<?php echo $cnt; ?>); cal_totalAll(<?php echo $cnt; ?>);" class="form-control" style="width:80px;"></td>
                                     <td><input type="text" name="amount_po[]" placeholder="" id="amount_id_po[<?php echo $cnt; ?>][amount]" class="form-control" style="width:80px;"  readonly /></td>
                                      <td><input type="text" name="cgstrate_po[]" value="0" placeholder="" id="cgst_id_po[<?php echo $cnt; ?>][cgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" class="form-control cGstValue" readonly></td>
                                      <td><input type="text" name="sgstrate_po[]" value="0" placeholder="" id="sgst_id_po[<?php echo $cnt; ?>][sgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" class="form-control sGstValue" readonly ></td>
                                      <td><input type="text" name="igstrate_po[]" value="0" placeholder="" id="igst_id_po[<?php echo $cnt; ?>][igstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" onkeyup="cal_totalAll(<?php echo $cnt; ?>);" class="form-control iGstValue" readonly></td>
                                         <td><input class="form-control" name="remark_po[]" id="remark_id_po[<?php echo $cnt; ?>][remark]" type="text" value="<?= $item_info->remark ?>" ></td>
                                       <td><input type="text" name="total_po[]" placeholder="" id="total_id_po[<?php echo $cnt; ?>][total]" class="form-control" onkeyup="cal_totalAll(<?php echo $cnt; ?>);"   style="width:80px;"readonly /></td>
                                   </tr>
                              <?php
                                              
                            
                                                          $cnt++;
                                                  endforeach;

                                                  
                                  
                                                                                  ?>
                                                                                   <tfoot>
                                     <tr>
                                      <th colspan="10"></th>
                                     <th>Total : </th>
                                    <th>

                                     <input type="text" name="totalAll" id="totalAll" class="form-control"  readonly>
                                   </th>
                                                    

                                   <!--  <th></th> -->
                                     </tr>
                                 </tfoot>
                              </table>
                           <input type="hidden" class="form-control" value="<?php echo $cnt ?>" id="counter" name="counter" >
                            
                          </div>

                        </div>

                      </div>

                    </div>

                  </section>

                  
                     <!--  <script>
                          function onSelection(id, val)
                          {
                              var code_id = "item_code_po[" +id+ "]";
                              var name_id = "item_name_po[" +id+ "]";
                              var uom_id =  "uom_po[" +id+ "]";

                              console.log(code_id+ " " +name_id+ " "+uom_id);
                              document.getElementById(code_id).value = val;
                              document.getElementById(name_id).value = val;
                              document.getElementById(uom_id).value =  val;
                          }

                   function cal(si){
                    
                    
                     if(document.getElementById('tonne_id_po['+si+'][tonne]').value!="" && document.getElementById('rate_id_po['+si+'][rate]').value!=""){
                       document.getElementById('amount_id_po['+si+'][amount]').value = document.getElementById('tonne_id_po['+si+'][tonne]').value*document.getElementById('rate_id_po['+si+'][rate]').value;
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);                      
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value)
                       var total = amt+camt+samt+iamt;
                       // var t_camt= amt * (camt/100);
                       // var t_samt=  amt * (samt/100);
                       // var t_iamt=  amt * (iamt/100);
                       // var total = amt+t_camt+t_samt+t_iamt;
                       total = total.toFixed(2);
                       
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                       document.getElementById('amount_id_po['+si+'][amount]').value = "";
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                      
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_cgst(si){
                     if(document.getElementById('cgst_id_po['+si+'][cgstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var cgstr = tamount*document.getElementById('cgst_id_po['+si+'][cgstrate]').value;
                       cgstr = cgstr.toFixed(2);
                       document.getElementById('cgst_id_po['+si+'][cgstrate]').value = cgstr;
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                       document.getElementById('cgst_id_po['+si+'][cgstrate]').value = "";
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_sgst(si){
                     if(document.getElementById('sgst_id_po['+si+'][sgstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var sgstr = tamount*document.getElementById('sgst_id_po['+si+'][sgstrate]').value;
                       sgstr = sgstr.toFixed(2);
                       
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                      
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_igst(si){
                     if(document.getElementById('igst_id_po['+si+'][igstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var igstr = tamount*document.getElementById('igst_id_po['+si+'][igstrate]').value;
                       igstr = igstr.toFixed(2);
                      
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                     
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
               
                  
                     
   $('#vendor_name').on('change', function( event ) {
                         $.ajax({
                         url: 'getInformationsvendor.php',
                         type: 'POST',
                         data: {"vendor_name":$(this).val()},
                         success: function(result) {
                             $('#viewbranch').remove();
                             $('#branchName').append('<div id="view" >' + result + '</div>');
                         }
                     });
                     event.preventDefault();
                 });
                $('#company_name').on('change', function( event ) {
                     $.ajax({
                         url: 'getinformationscompany.php',
                         type: 'POST',
                         data: {"company_name":$(this).val()},
                         success: function(result) {
                             $('#viewcompany').remove();
                             $('#company').append('<div id="viewcompany" >' + result + '</div>');
                           
                         }
                     });
                     event.preventDefault();
                 });
                $('#billing_contact_person').on('change', function( event ) {
                           
                         $.ajax({

                             url: 'getInformationbillingcontactDesignation.php',
                             type: 'POST',

                             data: {"billing_contact_person": $(this).val()},
                             
                             success: function(result) {
                               

                                 // $('#viewdesignation').remove();
                                 $('#contactPerson').html('<div id="viewdesignation" >' + result + '</div>');
                             }
                         });
                         event.preventDefault();
                 });

                      </script>
   -->



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
                                     <textarea name="payment_description" id="payment_description" class="form-control" value="<?= $manage_indent_info->description_approval ?>" readonly><?= $manage_indent_info->description_approval ?></textarea>
                                   </div>
                                 </div>
                                 <div class="col-md-6">
                                   <div class="form-group">
                                     <label>Payment Terms</label>
                                   <textarea width="600" name="payment_terms" id="payment_terms" class="form-control" value="Terms & Conditions
                                    1.GST Extra as per Govt. Norms
                                    2.Freight Inclusive
                                    3.Delivery: Immediate after issuance of PO
                                    4.Bill Should be submitted along with the PO (Strictly)
                                    For,Srinath Homes India Pvt Ltd.
                                    ">Terms & Conditions
  1.GST Extra as per Govt. Norms
  2.Freight Inclusive
  3.Delivery: Immediate after issuance of PO
  4.Bill Should be submitted along with the PO (Strictly)
  For,Srinath Homes India Pvt Ltd.
  </textarea>
  <section class="content">
                                   <h3 class="card-title float-right">
                                       <button id="addButton" type="submit" class="order-button btn btn-sm btn-success mt-1 mb-1" title="Create PO">
                                           <i class="fa fa-cart-plus fa-sm"></i> Order Now
                                       </button>
                                   </h3>
                  </section>
                                   
                                   </div>
                               </div>
                               </div>
                             </div>
                           </div>
                         </div>

                  
                  </section>


  </form>
                            
                                
                      </div>
                  </section>
            
              <!-- /.content -->
          </div>
        </section>
       
          <!-- Footer Section Start -->
          <?php require_once("include/footer.php"); ?>
          <!-- Footer Section End -->
          <!-- Control Sidebar -->
          <aside class="control-sidebar control-sidebar-dark">
              <!-- Control sidebar content goes here -->
          </aside>
          <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->

      <!-- Js Section Start -->
      <?php require_once("include/js.php"); ?>
     
      
      <script src="dist/js/ajax.js"></script>
       <script src="dist/js/admin/purchase-order.js"></script>
        <script>
                           function onSelection(id, val)
                          {
                              var code_id = "item_code_po[" +id+ "]";
                              var name_id = "item_name_po[" +id+ "]";
                              var uom_id =  "uom_po[" +id+ "]";

                              console.log(code_id+ " " +name_id+ " "+uom_id);
                              document.getElementById(code_id).value = val;
                              document.getElementById(name_id).value = val;
                              document.getElementById(uom_id).value =  val;
                          }

                   function cal(si){
                    
                    
                     if(document.getElementById('tonne_id_po['+si+'][tonne]').value!="" && document.getElementById('rate_id_po['+si+'][rate]').value!=""){
                       document.getElementById('amount_id_po['+si+'][amount]').value = document.getElementById('tonne_id_po['+si+'][tonne]').value*document.getElementById('rate_id_po['+si+'][rate]').value;
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);                      
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value)
                       var total = amt+camt+samt+iamt;
                       // var t_camt= amt * (camt/100);
                       // var t_samt=  amt * (samt/100);
                       // var t_iamt=  amt * (iamt/100);
                       // var total = amt+t_camt+t_samt+t_iamt;
                       total = total.toFixed(2);
                       
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                       document.getElementById('amount_id_po['+si+'][amount]').value = "";
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                      
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_cgst(si){
                     if(document.getElementById('cgst_id_po['+si+'][cgstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var cgstr = tamount*document.getElementById('cgst_id_po['+si+'][cgstrate]').value;
                       cgstr = cgstr.toFixed(2);
                       document.getElementById('cgst_id_po['+si+'][cgstrate]').value = cgstr;
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                       document.getElementById('cgst_id_po['+si+'][cgstrate]').value = "";
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_sgst(si){
                     if(document.getElementById('sgst_id_po['+si+'][sgstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var sgstr = tamount*document.getElementById('sgst_id_po['+si+'][sgstrate]').value;
                       sgstr = sgstr.toFixed(2);
                       
                       
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;

                     } else{
                      
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
                   function cal_igst(si){
                     if(document.getElementById('igst_id_po['+si+'][igstrate]').value!=""){
                       var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                       var igstr = tamount*document.getElementById('igst_id_po['+si+'][igstrate]').value;
                       igstr = igstr.toFixed(2);
                      
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     } else{
                       
                       var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                       var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                       var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                       var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                       var total = amt+camt+samt+iamt;
                       total = total.toFixed(2);
                       document.getElementById('total_id_po['+si+'][total]').value = total;
                     }
                   }
               function cal_totalAll(si){
                     var count= Number(document.getElementById('counter').value);
                     // alert(total);
                     var totalAmt=0;
                      console.log(count-1);
                      for(i=1;i<=(count-1);i++){
                        console.log(Number(totalAmt));
                        totalAmt=Number(totalAmt)+Number(document.getElementById('total_id_po['+i+'][total]').value);
                        console.log(totalAmt);
                        document.getElementById('totalAll').value=totalAmt;
                        
                      }
                     //document.getElementById('totalAll').value = total;   
                   } 
                   
                  
  
                $('#project').on('change', function( event ) {
                     $.ajax({
                         url: 'getinformationsproject.php',
                         type: 'POST',
                         data: {"project":$(this).val()},
                         success: function(result) {
                             $('#viewprojects').remove();
                             $('#projects').html('<div id="viewprojects" >' + result + '</div>');
                           
                         }
                     });
                     event.preventDefault();
                 });







                $('#billing_contact_person').on('change', function( event ) {
                           
                         $.ajax({

                             url: 'getInformationbillingcontactDesignation.php',
                             type: 'POST',

                             data: {"billing_contact_person": $(this).val()},
                             
                             success: function(result) {
                               

                                 // $('#viewdesignation').remove();
                                 $('#contactPerson').html('<div id="viewdesignation" >' + result + '</div>');
                             }
                         });
                         event.preventDefault();
                 });
                      </script>

      <!-- Js Section End -->
  </body>

  </html>