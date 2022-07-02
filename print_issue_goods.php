<?php
          
  
   require_once("include/auth.php");
    require_once("application/classes-and-objects/config.php");
    require_once("application/classes-and-objects/veriables.php"); 
     require_once("include/auth.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Inventory Reports</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">
   <section class="content">
      <div class="container-fluid">
         <div class="row">
                                      <div class="col-12">
                                        <!-- <div class="callout callout-info">  -->                 
                                          <?php   
                                          if(isset($_GET["id"]) && !empty($_GET["id"])):
                                           $databaseObj->select("tbl_goods_issue");
                                           $databaseObj->where("`status` = '".$auth->visible()."' && `goods_issue_id` = '".$_GET["id"]."'");
                                           $databaseObj->order_by("`goods_issue_id` DESC");
                                           $result = $databaseObj->get();
                             

                                               //Checking If Data Is Available
                                            //   echo"<pre>";
                                            // print_r($result);
                                              foreach ($result as $rows):
                                                  $goods_issue_info =json_decode($rows["goods_issue_info"]);
                                                  $goods_issue_returned =json_decode($rows["goods_issue_returned"]);
                                                 
                                                  ?>
                                                  <section class="content">
                                                    <div class="container-fluid">
                                                      <div class="row">
                                                          <div class="col-12" >
                                                         
                                                              
                                                             <h4 style="text-align: center;">Goods Issued</h4>  

                                                          </div>
                                                      </div>    
                                                      
                                                      <table style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">
                                                        <tr style="border: 1px solid #dddddd;">
                                                             <td colspan="3">
                                                         Issued to : <?php
                                                                       $databaseObj->select("tbl_manage_employee");
                                                                       $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$goods_issue_info->issueTo."'");
                                                                       $getData = $databaseObj->get();
                                                                       foreach($getData as $rowsupplier):
                                                                          $manage_employee_info = json_decode($rowsupplier["manage_employee_info"]);
                                                                       endforeach;?>
                                                                       <?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?> 
                                                         </td>                
                                                                  
                                                              
                                                         <td colspan="3">
                                                          Issued by : 
                                                                       <?= $goods_issue_info->issueBy ?></td>

                                                          <td colspan="3">
                                                         Project : <?php
                                                                       $databaseObj->select("tbl_projects");
                                                                       $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info->project."'");
                                                                       $getData = $databaseObj->get();
                                                                       foreach($getData as $rowprojects):
                                                                          $projects_info = json_decode($rowprojects["projects_info"]);
                                                                       endforeach;?>
                                                                       <?= $projects_info->projectName ?>
                                                         </td>                
                                                                                 
                                                                   
                                                              
                                                             
                                                        
                                                        <td colspan="3" style="float: right;">
                                                          
                                                           IRN Date : <?=  date('d/m/Y') ?>
                                                         
                                                         </td>                  
                                                                  
                                                      </table>      
                                                     

                                                    

                                                      <table style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">

                                                          
                                                          <tr style="border: 1px solid #dddddd;">
                                                              
                                                              <th style="border: 1px solid #dddddd;text-align: center">S.No.</th>
                                                              <th style="border: 1px solid #dddddd;text-align: center">ITEM CODE</th>
                                                              <th style="border: 1px solid #dddddd;text-align: center">ITEM NAME</th>
                                                              
                                                              <th style="border: 1px solid #dddddd;text-align: center">UNIT</th>
                                                              <th style="border: 1px solid #dddddd;text-align: center">PREVIOUS STOCK</th>
                                                              <th style="border: 1px solid #dddddd;text-align: center">QUANTITY ISSUED</th>
                                                              <th style="border: 1px solid #dddddd;text-align: center">CURRENT STOCK</th>
                                                              <th style="border: 1px solid #dddddd;text-align: center">Remarks</th>
                                                          </tr>
                                                          
                                                      
                                                              <?php
                                                             
                                                              

                                                                 $cnt = 1;
                                                              
                                                                   foreach($goods_issue_info->items as $items):       
                                                                 
                                                                  
                                                                      ?>
                              
                         
                                                                      <tr style="border: 1px solid #dddddd;text-align: center;">         
                                                                              <td style="border: 1px solid #dddddd;"><?= $cnt ?>.</td>
                                                                               <?php $databaseObj->select("tbl_manage_item");

                                                                              $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$items->itemCode."'");
                                                                                                                                     
                                                                              $getDatas = $databaseObj->get();
                                                                              if($getDatas != 0):
                                                                                foreach($getDatas as $rows_deptt):
                                                                                   $itemName = $rows_deptt["itemName"];
                                                                      
                                                                                   $itemCode = $rows_deptt["itemCode"];
                                                                                   $uom = $rows_deptt["Uom"];
                                                                     
                                                                                endforeach;
                                                                              endif;?>
                                                                              <td style="border: 1px solid #dddddd;"><?= $itemCode ?></td>
                                                                              <td style="border: 1px solid #dddddd;"><?= $itemName ?></td>
                                                                              <td style="border: 1px solid #dddddd;"><?= $uom ?></td>
                                                                              <td style="border: 1px solid #dddddd;"><?= $items->existing_quantity ?></td>
                                                                              <td style="border: 1px solid #dddddd;"><?= $items->quantity;  ?></td>
                                                                               <?php $databaseObj->select("tbl_manage_stock");
                                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `project` = '".$goods_issue_info->project."' && `itemCode` = '".$items->itemCode."'");
                                                                               $getstock = $databaseObj->get();


                                                                               if($getstock != 0):
                                                                                 foreach($getstock as $rows_stock):
                                                                                  $Qty = $rows_stock["Qty"];
                                                                                 endforeach;
                                                                               endif;?>
                                                                               <td style="border: 1px solid #dddddd;"><?=  $items->current_stock ?></td>
                                                                              <!-- <td style="border: 1px solid #dddddd;"><?= $items->quantity;  ?></td> -->
                                                                              <td style="border: 1px solid #dddddd;"><?= $items->remarks; ?></td>
                                                                                       
                                                                                       
                                                                      </tr>
                                                                      <?php
                                                          
                                        


                                                                      $cnt++;
                                                                    endforeach;
                                                              
                                              
                                                                     ?>
                                                                                                                              
                                                                                                                              
                                                                                     

                                                      
                                                      </table>
                                                      
                                                         

                                                              
                                                          
                                                          
                                                  
                                                  </div>       
                                                  </section>
                                                  <script type="text/javascript"> 
                                                    window.addEventListener("load", window.print());
                                                  </script>
                                                  <?php
                                              endforeach;
                           
                                          endif;
                                      
                    

                                                 ?>
                                      </div>
         </div>  

      </div>
    </section>

 </body>



</html>                           
