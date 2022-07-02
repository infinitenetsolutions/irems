<style>
td{
font-size:10px!important;
padding: 5px 0px;
}
</style>
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
				    $manageItemStoreDir = "../../assets/admin/manage-items/";
				    $manageItemDir = "../assets/admin/manage-items/";
				    $manageCompanyStoreDir = "../../../assets/admin/manage-company/";

				    $manageCompanyDir = "../../../assets/admin/manage-company/";
                
                    if(isset($_GET["id"]) && !empty($_GET["id"])):
                        $databaseObj->select("tbl_manage_po");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '".$_GET["id"]."'");
                        $databaseObj->order_by("`manage_po_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $manage_po_log = json_decode($rows["manage_po_log"]);
                                $manage_po_info = json_decode($rows["manage_po_info"]);
                                ?>
                              <section class="content">
                                  <div class="container-fluid">
                                    <div class="row">
                                      <div class="col-12">
                                        <div class="callout callout-info">
                                            <table style="width:100%">
                                                <tr>
                                                    <!-- <td></td> -->
                                                    
                                                           
                                                            <?php
                                                            
                                                                $databaseObj->select("tbl_manage_company");
                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$manage_po_info->company_name."'");
                                                                $getCompanyData = $databaseObj->get();
                                                                foreach ($getCompanyData as $row):
                                                                  $manage_company_info = json_decode($row["manage_company_info"]);
                                                                  ?>
                                                                 <?php
                                                                    
                                                                  endforeach;
                                                                ?><td>
                                                        <h5 style="text-align: center; padding-left: 10%;padding-top: 5%;font-size:20px;"><?= $manage_company_info->companyName ?><br> 
                                                         <?= $manage_company_info->companyAddress ?></h5>
                                                                              
                                                    </td>    
                                                    
                                                    <td >
                                                        <?php
                                                                   
                                                                        if($manage_company_info->companyLogo == "default"):

                                                                    ?>

                                                                            <a style="text-align: right; padding-right: 0%; margin: 0%; border: 0%;" href="<?= $defaultLogo ?>" target="_blank"><img  src="<?= $defaultLogo ?>" alt="Company Logo" class="table-avatar" style="float:right;text-align: right; padding-right: 10%; margin: 0%; border: 0%;" width="100px" height="100px"></a>

                                                                    <?php

                                                                        else:

                                                                    ?>
                                                                            <a style="text-align: right; padding-right: 0%; margin: 0%; border: 0%;" href="<?= $manageCompanyDir.$manage_company_info->companyLogo ?>" target="_blank"><img  src="<?= $manageCompanyDir.$manage_company_info->companyLogo ?>" alt="Company Logo" class="table-avatar" style="float:right;text-align: right; padding-right: 10%; margin: 0%; border: 0%;" width="100px" height="100px"></a>

                                                                    <?php 

                                                                        endif;
                                                                    
                                                     
                                            
                                                                    ?>
                                                                </h4>
                                                    </td>
                                                </tr>
                                               <!--  <tr>
                                                    <td>
                                                        
                                                        <?= $manage_po_info->company_address ?>
                                                   
                                                    </td> 
                                                </tr> -->
                                                      <!-- <small class="float-right"> Date:<?= date("Y/m/d") ?></small>
                                                     </h4> -->
                                                <tr>
                                                     
                                                </tr> 
                                            </table>           
                                                
                                        </div>


                                        <!-- Main content -->
                                        <div class="invoice p-3 mb-3" >
                                          <!-- title row -->
                                          <table style="border-collapse: collapse;width:100%;">
                                             
                                            
                                                <tr style="border: 1px solid black;">
                                                    <td colspan="5"></td>
                                                    
                                                    <td colspan="2"  class="text-center" >PURCHASE ORDER</td>
                                                    <td colspan ="5" style="border-right: 1px solid black;"></td>
                                                   
                                                </tr> 
                                                    <tr style="border: 1px solid black;">
                                                         <?php
                                                          $databaseObj->select("tbl_projects");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_po_info->project."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                                $projects_info = json_decode($rows_deptt["projects_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="8" rowspan="2" style="border: 1px solid black;"  >Project/Site: <?= $projects_info->projectName ?>,<?= $projects_info->projectLocation ?>
                                                            
                                                        </td>
                                                         <td colspan="2"style="border: 1px solid black;" >PO No:</td>
                                                         
                                                         <td  colspan="2" style="border: 1px solid black;"><?= $manage_po_info->orderNo ?></td>
                                                        
                                                         
                                                        
                                                    </tr> 
                                                    <tr>
                                                        
                                                         <td colspan="2"  style="border: 1px solid black;">Date:</td>
                                                        <td colspan="2"  style="border: 1px solid black;"><?= $manage_po_info->poDate ?></td>
                                                    </tr>
                                                    <tr  style="border: 1px solid black;">
                                                        
                                                        <td colspan="4"  style="border: 1px solid black;">Vendor's Name & Address</td><br>
                                                        <td colspan="4"  style="border: 1px solid black;">Delivery Address</td>

                                                        <td colspan="2"   style="border: 1px solid black;">Req No</td>
                                                        <?php
                                                          $databaseObj->select("tbl_manage_indent");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$manage_po_info->requisition_no."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $manage_indent_info = json_decode($rows_deptt["manage_indent_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="2" style="border: 1px solid black;"><?= $manage_indent_info->employee_req ?></td>
                                                    </tr>    
                                                    <tr ><?php
                                                          $databaseObj->select("tbl_manage_supplier");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$manage_po_info->vendor_name."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $manage_supplier_info = json_decode($rows_deptt["manage_supplier_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="4"  rowspan="3" style="border: 1px solid black;" ><?= $manage_supplier_info->supplierName ?>
                                                        <br />
                                                        <?= $manage_po_info->vendor_address ?>
                                                                
                                                        </td>
                                                        <?php
                                                          $databaseObj->select("tbl_projects");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_po_info->project."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $projects_info = json_decode($rows_deptt["projects_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="4"   style="border: 1px solid black;">
                                                            <?= $projects_info->projectName ?>,<?= $projects_info->projectLocation?>
                                                                
                                                        </td>
                                                        <td colspan="2" style="border: 1px solid black;">Req Date</td>
                                                         <td colspan="2" style="border: 1px solid black;"><?= $manage_po_info->requisition_date ?></td>    
                                                    </tr>   
                                                    <tr>
                                                        <td colspan="4" style="border: 1px solid black;" >Billing Address
                                                                
                                                        </td>
                                                        <td colspan="4" style="border: 1px solid black;">Payment terms
                                                                
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                         <td colspan="4" style="border: 1px solid black;"><?= $manage_company_info->companyName ?><br><?= $manage_company_info->companyAddress ?>
                                                                
                                                        </td>
                                                        <td colspan="4" rowspan="8" style="border: 1px solid black;">Within 30 Days after Receiving of Bill
                                                                
                                                       
                                                                
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" style="border: 1px solid black;">Contact Person
                                                                
                                                        </td>
                                                        <td colspan="4"  style="border: 1px solid black;">Contact Person & Designation </td>
                                                       
                                                    </tr>
                                                    <tr >
                                                        <td colspan="4" rowspan="4" style="border: 1px solid black;"  ><?= $manage_po_info->vendor_contact_person ?>
                                                                

                                                        </td>
                                                        <?php
                                                          $databaseObj->select("tbl_manage_employee");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$manage_po_info->billing_contact_person."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $manage_employee_info = json_decode($rows_deptt["manage_employee_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>

                                                         <?php
                                                          $databaseObj->select("tbl_manage_designation");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$manage_po_info->billing_contact_designation."'");
                                                        $getData = $databaseObj->get();
                                                        if($getData != 0):
                                                            foreach($getData as $rows_deptt):
                                                               
                                                                  $manage_designation_info = json_decode($rows_deptt["manage_designation_info"]);
                                                            endforeach;
                                                        endif;
                                                         ?>
                                                        <td colspan="4"  style="border: 1px solid black;"><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>,<?= $manage_designation_info->designationName ?>
                                                       </td>
                                                    </tr>
                                                    <tr >
                                                       <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                    <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td colspan="4" ></td>
                                                        <!-- <td colspan="4"  style="border: 1px solid black;" >Contact Telephone Number</td> -->
                                                    </tr>
                                                    <tr >
                                                         <td colspan="4" style="border: 1px solid black;">Telephone Number</td>
                                                        <td colspan="4" style="border: 1px solid black;">Telephone Number</td>
                                                    </tr> 
                                                    <tr >
                                                         <td colspan="4" style="border: 1px solid black;"><?= $manage_po_info->vendor_contact_phone_no ?></td>
                                                        <td colspan="4" style="border: 1px solid black;"><?= $manage_po_info->billing_contact_number ?></td>
                                                    </tr>    
                                                   <tr style="border: 1px solid black;">
                                                        <td colspan="1" style="border: 1px solid black;">Sr No.</td>
                                                        <td colspan="1" style="border: 1px solid black;">Item Code.</td>
                                                        <td colspan="2" style="border: 1px solid black;">Item Name.</td>
                                                        
                                                        <td colspan="1" style="border: 1px solid black;">UNIT</td>
                                                        <td colspan="2" style="border: 1px solid black;">Remark</td>
                                                        <td colspan="2" style="border: 1px solid black;">Rate</td>
                                                        <td colspan="2" style="border: 1px solid black;">Quantity</td>
                                                        <td colspan="1" style="border: 1px solid black;">Amount(Rs)</td>
                                                        
                                                    </tr> 
                                                    <?php
                                                        $databaseObj->select("tbl_manage_po");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '".$_GET["id"]."'");
                                                            $getData = $databaseObj->get();
                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                                foreach($getData as $rows):
                                                                    ?>

                                                    
                                                            <?php
                                                $cnt = 1;
                                             
                                    
                               
                                                    
                                                                    foreach ($manage_po_info->item_info as $item_info) {
                                                            
                                                                  
                                                        
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
                                                              $itemCategory = $rows_deptt["itemCategory"];
                                                              $Uom = $rows_deptt["Uom"];
                                                              // $Qty = $rows_deptt["Qty"];
                                                              // print_r($rows_deptt);
                                                          endforeach;
                                                      endif;      
                                                         ?>         <tr>         
                                                                   <td colspan="1" style="border: 1px solid black;"><?= $cnt ?>.</td> 
                                                                    <td colspan="1" style="border: 1px solid black;"><?= $itemCode ?></td>
                                                                    <td colspan="2" style="border: 1px solid black;"><?= $itemName ?></td>
                                                                    <td colspan="1" style="border: 1px solid black;"><?= $Uom ?></td>
                                                                    <td colspan="2" style="border: 1px solid black;"><?= $item_info->remark ?></td>
                                                                    <td colspan="2" style="border: 1px solid black;"><?= $item_info->rate ?></td>
                                                                    
                                                                    <td  colspan="2" style="border: 1px solid black;"><?= $item_info->quantity ?></td>  
                                                                    <td colspan="2" style="border: 1px solid black;"><?= number_format((float)($item_info->amount), 2); ?></td>  
                                                                    
                                                    </tr>
                                                               <?php
                                                                
                                              


                                                                                   $cnt++;}
                                                                                endforeach;
                                                                            endif;
                                                                            ?>
                                                                            <th colspan="9" style="border: 1px solid black;"></th>
                                     <th style="border-bottom: 1px solid black;">Total : </th>
                                    <th>
                                      <td colspan="2" style="border: 1px solid black;"><?= number_format((float)($manage_po_info->totalAll), 2); ?></td>  
                                     
                                   </th>
                                          </table>
                                         

                                            
                                        </div> 
                                          <!-- info row -->
                                          
                                         <br>
                                         <br>
                                        <div class="invoice p-3 mb-3">
                                        <table style="width: 100%;border: 1px solid black;">
                                            
                                                <?php 
                                                $terms = explode('  ', $manage_po_info->payment_terms);
                        						foreach($terms as $data){
                                                ?>
                                                <tr><td> <?php echo $data?> </td></tr>
                                                <?php } ?>
                                                    
                                                                                                </tr> 
                                                </table>
                                          <!--  <div class="col-sm-4 invoice-col"> -->
                                                     
                                          
                                         
                                          <!--   </div> -->
                                            <!-- /.col -->
                                           </div> 

                                          <!-- this row will not appear when printing -->
                                       
                                    </div>
                                        <!-- /.invoice -->
                                      </div><!-- /.col -->
                                    </div><!-- /.row -->
                                  </div><!-- /.container-fluid -->
                                </section>
		                      <script type="text/javascript"> 
		                         window.addEventListener("load", window.print());
		                      </script>
                                <?php
                            endforeach;
                            else:
                        endif;
                    endif;  

?>
                            

