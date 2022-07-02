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
		                                <section class="content">
		                                  <div class="container-fluid">
		                                  	<div class="row">
		                                        <div class="col-12">
		                                       
		                                            
		                                        <h4 style="text-align: center;">Requisition Slip</h4>  

		                                        </div>
		                                    </div>    
		                                  	<table style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">
		                                      <tr>
                                               <td colspan="4">
		                                       Req No: <?= $manage_indent_info->employee_req ?> 
		                                       </td>                
		                                                
		                                            
		                                       <td colspan="4"></td>

		                                                       
		                                                 
		                                            
		                                           
		                                      
		                                      <td colspan="4" style="float: right;">
		                                        
		                                         Date: <?= $manage_indent_info->indentDate?>
		                                       
		                                       </td>                  
		                                                
		                                </table>      
		                                    <!-- <div class="row">
		                                        <div class="col-12">
		                                       
		                                            
		                                        <h4 style="text-align: center;">Requisition Slip</h4>  

		                                        </div>
		                                        <div class="col-sm-3">
		                                                        
		                                            Req No: <?= $manage_indent_info->employee_req ?>
		                                                            
		                                        </div>                                   
		                                        <div class="col-sm-3">    
		                                        </div>
		                                        <div class="col-sm-3">    
		                                        </div>  
		                                        <div class="col-sm-3" style="float: right;">  
		                                         Date: <?=date("d/m/Y", strtotime($manage_indent_info->indentDate))?>
		                                        </div>
		                                    </div>  -->           
		                                    


		                                        <!-- Main content -->
		                                        <!-- <div class="invoice p-3 mb-3" > -->
		                                    <table style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">

		                                        
		                                          <tr style="border: 1px solid #dddddd;">
		                                            
		                                            <th style="border: 1px solid #dddddd;">S.No.</th>
		                                            <th style="border: 1px solid #dddddd;">Item Code</th>
		                                            <th style="border: 1px solid #dddddd;">Item Name</th>
		                                            
		                                            <th style="border: 1px solid #dddddd;">UOM</th>
		                                            
		                                            <th style="border: 1px solid #dddddd;">Qty</th>
		                                            <th style="border: 1px solid #dddddd;">Remark</th>
		                                          </tr>
		                                        
		                                    
		                                        <?php
		                                           
		                                            

		                                               $cnt = 1;
		                                            
		                                                  foreach ($manage_indent_info->item_info as $item_info):            
		                                               
		                                                $databaseObj->select("tbl_manage_item");
		                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$item_info->itemName."'");
		                                                $getData = $databaseObj->get();
		                                                if($getData != 0):
		                                                    foreach($getData as $rows_deptt):
		                                                        $itemName = $rows_deptt["itemName"];
		                                                        $itemCode = $rows_deptt["itemCode"];
		                                                        $Uom = $rows_deptt["Uom"];
		                                                        $Qty = $rows_deptt["Qty"];
		                                                    endforeach;
		                                                endif;
		                                                 ?>
		            
		       
		                                                <tr style="border: 1px solid #dddddd;text-align: center;">         
		                                                        <td style="border: 1px solid #dddddd;"><?= $cnt ?>.</td>
		                                                        <td style="border: 1px solid #dddddd;"><?= $itemCode ?></td>
		                                                        <td style="border: 1px solid #dddddd;"><?= $itemName ?></td>
		                                                        <td style="border: 1px solid #dddddd;"><?= $Uom ?></td>
		                                                        <td style="border: 1px solid #dddddd;"><?= $Qty ?></td>
		                                                        <td style="border: 1px solid #dddddd;"><?= $item_info->remark ?></td>
		                                                                 
		                                                                 
		                                                </tr>
		                                                    <?php
		                                        
		                      


		                                                    $cnt++;
		                                            endforeach;
		                                            
		                            
		                                                                            ?>
		                                                                                                            
		                                                                                                            
		                                                                   

		                                    
		                                    </table>
		                                <table style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">
		                                      <tr>
                                               <td colspan="4">
		                                       Prepared By</br>
		                                       <?php 
                               
                                                            $databaseObj->select("tbl_manage_employee");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$manage_indent_info->indentCreated."'");
                                                            $databaseObj->order_by("`manage_employee_id` DESC");
                                                            $getData = $databaseObj->get(); 

                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                             
                                                              foreach($getData as $rowsemployee):
                                                                $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                                               endforeach;
                                                            endif;   
                                                                  ?>
                                       (<?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>)  
		                                       
		                                       </td>                
		                                                
		                                            
		                                       <td colspan="4">Signature</td>

		                                                       
		                                                 
		                                            
		                                           
		                                      
		                                      <td colspan="4" style="float: right;">Approved By</br>
		                                        
		                                         <?php 
                               
                                                            $databaseObj->select("tbl_manage_employee");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$manage_indent_info->employee_approval."'");
                                                            $databaseObj->order_by("`manage_employee_id` DESC");
                                                            $getData = $databaseObj->get(); 

                                                            //Checking If Data Is Available
                                                            if($getData != 0):
                                                             
                                                              foreach($getData as $rowsemployee):
                                                                $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                                               endforeach;
                                                            endif;   
                                                                  ?>
                                       (<?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?>)  
		                                       
		                                       </td>                  
		                                                
		                                </table>         
		                                         

		                                            
		                                        
		                                        
		                                             
		                                            </div>
		                                        </div>                                    </div>
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
                            
