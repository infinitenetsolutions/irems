<?php
require_once ("../../classes-and-objects/config.php");
require_once ("../../classes-and-objects/veriables.php");
require_once ("../../classes-and-objects/authentication.php");
require_once ("../../classes-and-objects/PHPExcel/PHPExcel.php");
$auth = new AUTHENTICATION($databaseObj);
$objPHPExcel = new PHPExcel();
$defaultLogo = "assets/dp/default.png";
$randSix = $auth->randSix();
$authority = 1;
$manageItemStoreDir = "../../../assets/admin/manage-items/";
$manageItemDir = "assets/admin/manage-items/";

   

if (isset($_POST["action"]))
{
    
    if ($_POST["action"] == "Purchase Order")
    {

        $invstatus = $_POST["invstatus"];
        $date_from = strtotime($_POST["from"]);
        $date_to = strtotime($_POST["to"]);
                 
        //echo "$invstatus";
        if (!empty($date_from) && !empty($date_to))
        {

//            if (empty($invstatus))
//            {
                $databaseObj->select("tbl_manage_po");
                  if (empty($_POST["invstatus"])):
                      $databaseObj->where("`status` = '" . $auth->visible() . "'");
                  else:
                      $databaseObj->where("`status` = '" . $auth->visible() . "' && `order_status` = '" . $_POST["invstatus"] . "'");
                  endif;
                $databaseObj->order_by("`manage_po_id` DESC");
                $result = $databaseObj->get();
              

?>

<div id="printableArea">
    <h2>Purchase Order Details</h2><br>

    <table id="example1" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>S No</th>
                <th>Order No</th>
                <th>Order Date</th>
                <th>Supplier Name</th>
                <th>Company Name</th>
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Payment Status</th>

                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $cnt = 1;
                $no = 1;

                // $databaseObj->select("tbl_manage_po");
                // $databaseObj->where("`status` = '".$auth->visible()."' && `order_status` = '".$_POST["invstatus"]."'");
                // $databaseObj->order_by("`manage_po_id` DESC");
                // $result = $databaseObj->get();
                

                //    echo "<pre>";
                // print_r($result); exit;
                if ($result != 0):
                    foreach ($result as $rows):
                        $manage_po_info = json_decode($rows["manage_po_info"]);
                        //Search by Date Range
                        $odr_date=explode("/", $manage_po_info->poDate);
                        $orderDate=date("d-m-Y",strtotime($odr_date['0']."-".$odr_date['1']."-".$odr_date['2']));
                        $fromDate=date("d-m-Y",$date_from);
                        $toDate=date("d-m-Y",$date_to);
                        // exit();
                        if ($orderDate >= $fromDate && $orderDate <= $toDate):
                            //echo $manage_po_info->poDate."<br/>";
                            //DD-MM-YY FORMAT
                            $original_date = $manage_po_info->poDate;
                            // $timestamp = strtotime($original_date);
                            //  $new_date = date("d-m-Y", $timestamp);
                            
                             ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?=$manage_po_info->orderNo ?></td>
                                <td><?=$original_date ?> </td>
                                <?php

                            $databaseObj->select("tbl_manage_supplier");

                            $databaseObj->where("`status` = '" . $auth->visible() . "' && `manage_supplier_id` = '" . $manage_po_info->vendor_name . "'");

                            $databaseObj->order_by("`manage_supplier_id` DESC");

                            $getData = $databaseObj->get();

                            //Checking If Data Is Available
                            if ($getData != 0):

                                $sno = 1;

                                foreach ($getData as $rowsvendor):

                                    $manage_supplier_info = json_decode($rowsvendor["manage_supplier_info"]);
                                endforeach;
                            endif;

                              ?>
                             <td><?= $manage_supplier_info->supplierName ?></td><?php

                            $databaseObj->select("tbl_manage_company");

                            $databaseObj->where("`status` = '" . $auth->visible() . "' && `manage_company_id` = '" .$manage_po_info->company_name. "'");

                            $databaseObj->order_by("`manage_company_id` DESC");

                            $getData = $databaseObj->get();

                            //Checking If Data Is Available
                            if ($getData != 0):

                                $sno = 1;

                                foreach ($getData as $rowscompany):

                                    $manage_company_info = json_decode($rowscompany["manage_company_info"]);
                                endforeach;
                            endif;

                             ?>
                <td><?= $manage_company_info->companyName ?></td>
                <td><?php echo $rows["total_amount"]; ?></td>
                <td><?php echo $rows["order_status"]; ?></td>
                <td><?php echo $rows["payment_status"]; ?></td>

                <td><a href="print_view.php?action=pur_ord&id=<?php echo $rows["manage_po_id"]; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            </tr>

            <?php
                            $cnt++;
                        endif;
                    endforeach;
                endif;
?>
            <tr>
                <!-- <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th> -->


            </tr>
            </tfoot>

    </table>
</div>

<th><input type="button" style="margin-left:960px;" id="printbutton" name="" value="Print" onclick="printDiv('printableArea')" class="btn btn-success" /></th>


<script type="text/javaScript">

    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}   
     
     
  
     
  function printing(){
    document.getElementById("printbutton").style.display = "none";
    window.print();
    window.close();
   }

  </script>



<?php
//            }

        }
        else
        {
            $databaseObj->select("tbl_manage_po");

            if (empty($_POST["invstatus"])):
                $databaseObj->where("`status` = '" . $auth->visible() . "'");
            else:
                $databaseObj->where("`status` = '" . $auth->visible() . "' && `order_status` = '" . $_POST["invstatus"] . "'");
            endif;

            $databaseObj->order_by("`manage_po_id` DESC");
            $result1 = $databaseObj->get();

            // echo "<pre>";
            // print_r($result1); exit;
            
?>

<div id="printableArea">
    <h2>Purchase Order Details</h2><br>

    <table id="example1" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>S No</th>
                <th>Order No</th>
                <th>Order Date</th>
                <th>Supplier Name</th>
                <th>Company Name</th>
                <!--
                                        <th>Project Name</th>
                                        <th>Property Type</th>
                                        <th>Project Location</th>
-->
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Payment Status</th>

                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cnt = 1;
            $no = 1;

            if ($result1 != 0):
                foreach ($result1 as $rows1):
                    $manage_po_info = json_decode($rows1["manage_po_info"]);

                    //                                    echo "<pre>";
                    //                                   print_r($manage_po_info->propertyType);
                    

                    //Search by Date Range
                    $order_date = $manage_po_info->poDate;

                    //DD-MM-YY FORMAT
                    // $original_date = "$manage_po_info->poDate";
                    // $timestamp = strtotime($original_date);
                    $new_date = $manage_po_info->poDate;
?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?=$manage_po_info->orderNo ?></td>

                <td><?=$new_date ?> </td>
                <?php

                    $databaseObj->select("tbl_manage_supplier");

                    $databaseObj->where("`status` = '" . $auth->visible() . "' && `manage_supplier_id` = '" . $manage_po_info->vendor_name . "'");

                    $databaseObj->order_by("`manage_supplier_id` DESC");

                    $getData = $databaseObj->get();

                    //Checking If Data Is Available
                    if ($getData != 0):

                        $sno = 1;

                        foreach ($getData as $rows):

                            $manage_supplier_info = json_decode($rows["manage_supplier_info"]);
                        endforeach;
                    endif;

?>
                <td><?=$manage_supplier_info->supplierName
?></td>
                <?php

                    $databaseObj->select("tbl_manage_company");

                    $databaseObj->where("`status` = '" . $auth->visible() . "' && `manage_company_id` = '" . $manage_po_info->company_name . "'");

                    $databaseObj->order_by("`manage_company_id` DESC");

                    $getData = $databaseObj->get();

                    //Checking If Data Is Available
                    if ($getData != 0):

                        $sno = 1;

                        foreach ($getData as $rows):

                            $manage_company_info = json_decode($rows["manage_company_info"]);
                        endforeach;
                    endif;

?>


                <td><?=$manage_company_info->companyName
?></td>



                <td><?php echo $rows1["total_amount"]; ?></td>

                <td><?php echo $rows1["order_status"]; ?></td>
                <td><?php echo $rows1["payment_status"]; ?></td>

                <td><a href="print_view.php?action=pur_ord&id=<?php echo $rows1["manage_po_id"]; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            </tr>

            <?php
                    $cnt++;

                endforeach;
            endif;
?>
            <tr>
                <!--
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
-->
                <!--                                        <th><input type="button" style="" id="printbutton" name="" value="Print Purchase Orders List" onclick="printDiv('printableArea')"  class="btn btn-success"  /></th>-->



            </tr>
            </tfoot>

    </table>
</div>
<th><input type="button" style="margin-left:960px;" id="printbutton" name="" value="Print" onclick="printDiv('printableArea')" class="btn btn-success" /></th>


<script type="text/javaScript">

    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}   
     
     
  
     
  function printing(){
    document.getElementById("printbutton").style.display = "none";
    window.print();
    window.close();
   }

  </script>

<!--
        <style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>  
-->


<?php
            // echo "<pre>";
            // print_r($result1); exit;
            //$sql_order = "SELECT * FROM `in_orders` WHERE order_date BETWEEN '$date_from' AND '$date_to' ORDER BY in_ordersid DESC";
            
        }
    }
    else
    {
        if (!empty($status))
        {
            $sql_order = "SELECT * FROM `in_orders` WHERE in_ord_status = '$status' ORDER BY in_ordersid DESC";
        }
        else
        {
            $sql_order = "SELECT * FROM `in_orders` ORDER BY in_ordersid DESC";
        }

        // Goods Issue
        if ($_POST["action"] == "Goods Issue")
        {
          
            $invstatus = $_POST["invstatus"];
            $date_from = strtotime($_POST["from"]);
            $date_to = strtotime($_POST["to"]);
            $project = $_POST["project"];

            if (!empty($date_from) && !empty($date_to))
            {

                // if (empty($invstatus))
                // {

                    $databaseObj->select("tbl_goods_issue");
                     if (empty($_POST["invstatus"])):
                      $databaseObj->where("`status` = '" . $auth->visible() . "'");
                     else:
                    
                  
                    $databaseObj->where("`status` = '" . $auth->visible() . "' && `goods_issue_status` = '" .$_POST["invstatus"]. "'");
                     endif;
                     $databaseObj->order_by("`goods_issue_id` DESC");
                    $issue_result = $databaseObj->get();
                     $return_result = $databaseObj->get();
                   
                  
?>
<div id="printableArea">
    <h2>Goods Issue Details</h2><br>

    <table id="example1" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>S No</th>
                <th>Project</th>
                <th>Issued Date</th>
                <th>Issued Time</th>
                <th>Issued By</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Previous Stock</th>
                <th>Issued</th>
                <th>Stock After Issued</th>
                 <th>Issue Status</th>
                <th>Remarks</th>
               
                
               
               <!--  <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                    $cnt = 1;
                    $no = 1;
                    if ($issue_result != 0):
                        
                        foreach ($issue_result as $issue_rows):

                            $goods_issue_info = json_decode($issue_rows["goods_issue_info"]);
                            $goods_issue_log = json_decode($issue_rows["goods_issue_log"]);
                      
                        

            
                             $databaseObj->select("tbl_admin");
                             $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                             $databaseObj->order_by("`admin_id` DESC");
                             $getData = $databaseObj->get(); 
                             //Checking If Data Is Available
                            if($getData != 0):
                                foreach($getData as $rowsadmin):
                                    $admin_info = json_decode($rowsadmin["admin_info"]);
                                    $databaseObj->select("tbl_manage_employee");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rowsemployee):
                                            $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;  
                             if($goods_issue_info->project == $manage_employee_info->project):
                               
                            //Search by Date Range
                            $issue_date=explode("/", $goods_issue_info->ginDate);
                            $issue_date=date("d-m-Y",strtotime($issue_date['0']."-".$issue_date['1']."-".$issue_date['2']));
                         
                             $fromDate=date("d-m-Y",$date_from);
                             $toDate=date("d-m-Y",$date_to);

                            if ($issue_date >= $fromDate && $issue_date <= $toDate):
                                //echo $goods_issue_info->ginDate."<br/>";
                                //DD-MM-YY FORMAT
                                // $original_date = "$goods_issue_info->ginDate";
                                // $timestamp = strtotime($original_date);
                                $new_date = $goods_issue_info->ginDate;
?>

                
                <!-- <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?> </td> -->
                <?php    foreach ($goods_issue_info->items as $goods_issue_item_info):
                    ?>
                                                         <tr>
                                                              <td><?php echo  $cnt; ?></td>
                                                              <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info->project."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                                                               <td><?= $new_date ?></td>
                                                              <td><?= $goods_issue_log->at ?></td>

                                                             <td> <?= $goods_issue_info->issueBy ?></td>
                                                              <?php     $databaseObj->select("tbl_manage_item");

                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_issue_item_info->itemCode."'");
                                                                                                                       
                                                                $getDatas = $databaseObj->get();
                                                                
                                                                  foreach($getDatas as $rowsdata):
                                                                     $itemName = $rowsdata["itemName"];
                                                        
                                                                     $itemCode = $rowsdata["itemCode"];
                                                                     $uom = $rowsdata["Uom"];?>
                                                              <td><?= $itemCode ?></td>
                                                              <td><?= $itemName ?></td>  
                                                              <td><?= $uom ?></td>
                                                              <td><?= $goods_issue_item_info->existing_quantity ?></td> 
                                                              <td><?= $goods_issue_item_info->quantity ?></td> 
                                                              <td><?= $goods_issue_item_info->current_stock ?></td> 
                                                         
                                                               
                                                                 
                                                               
                                                              <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                                               if($goods_issue_status  == ''):
                                                                   echo "Issued";
                                                                   else:
                                                                   echo $goods_issue_status ;
                                                               endif;?></td>
                                                               
                                                              <td><?= $goods_issue_item_info->remarks ?></td> 
                                                      
                                                             

                                                               </tr>
                                                                <?php    

                                                                 
  
                                                          
                                                                 
                       endforeach;   $cnt++; 


endforeach;    
                           
              
                     endif;
                    
                     elseif($goods_issue_info->project == $_POST["project"]):
                            //Search by Date Range 
                     $issue_date=explode("/", $goods_issue_info->ginDate);
                            $issue_date=date("d-m-Y",strtotime($issue_date['0']."-".$issue_date['1']."-".$issue_date['2']));
                         
                             $fromDate=date("d-m-Y",$date_from);
                             $toDate=date("d-m-Y",$date_to);

                            if ($issue_date >= $fromDate && $issue_date <= $toDate):
                                //echo $goods_issue_info->ginDate."<br/>";
                                //DD-MM-YY FORMAT
                                // $original_date = "$goods_issue_info->ginDate";
                                // $timestamp = strtotime($original_date);
                                $new_date = $goods_issue_info->ginDate;
?>

                
                <!-- <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?> </td> -->
                <?php    foreach ($goods_issue_info->items as $goods_issue_item_info):
                    ?>
                                                         <tr>
                                                              <td><?php echo  $cnt; ?></td>
                                                              <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["project"]."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                                                               <td><?= $new_date ?></td>
                                                                <td><?= $goods_issue_log->at ?></td>
                                                             <td> <?= $goods_issue_info->issueBy ?></td>
                                                              <?php     $databaseObj->select("tbl_manage_item");

                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_issue_item_info->itemCode."'");
                                                                                                                       
                                                                $getDatas = $databaseObj->get();
                                                                
                                                                  foreach($getDatas as $rowsdata):
                                                                     $itemName = $rowsdata["itemName"];
                                                        
                                                                     $itemCode = $rowsdata["itemCode"];
                                                                     $uom = $rowsdata["Uom"];?>
                                                              <td><?= $itemCode ?></td>
                                                              <td><?= $itemName ?></td>  
                                                              <td><?= $uom ?></td>
                                                              <td><?= $goods_issue_item_info->existing_quantity ?></td> 
                                                              <td><?= $goods_issue_item_info->quantity ?></td> 
                                                              <td><?= $goods_issue_item_info->current_stock ?></td> 
                                                         
                                                               
                                                                 
                                                               
                                                              <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                                               if($goods_issue_status  == ''):
                                                                   echo "Issued";
                                                                   else:
                                                                   echo $goods_issue_status ;
                                                               endif;?></td>
                                                               
                                                              <td><?= $goods_issue_item_info->remarks ?></td> 
                                                      
                                                             

                                                               </tr>
                                                                <?php    

                                                                 
  
                                                          
                                                                 
                       endforeach;   $cnt++; 


endforeach;    
                           
              
                     endif;                 
                              
                               elseif($_POST["project"] == "All"):
                            //Search by Date Range 
                     $issue_date=explode("/", $goods_issue_info->ginDate);
                            $issue_date=date("d-m-Y",strtotime($issue_date['0']."-".$issue_date['1']."-".$issue_date['2']));
                         
                             $fromDate=date("d-m-Y",$date_from);
                             $toDate=date("d-m-Y",$date_to);

                            if ($issue_date >= $fromDate && $issue_date <= $toDate):
                                //echo $goods_issue_info->ginDate."<br/>";
                                //DD-MM-YY FORMAT
                                // $original_date = "$goods_issue_info->ginDate";
                                // $timestamp = strtotime($original_date);
                                $new_date = $goods_issue_info->ginDate;
?>

                
                <!-- <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?> </td> -->
                <?php    foreach ($goods_issue_info->items as $goods_issue_item_info):
                    ?>
                                                         <tr>
                                                              <td><?php echo  $cnt; ?></td>
                                                              <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info->project."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                                                               <td><?=$new_date ?></td>
                                                              <td><?= $goods_issue_log->at ?></td>
                                                             <td> <?= $goods_issue_info->issueBy ?></td>
                                                              <?php     $databaseObj->select("tbl_manage_item");

                                                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_issue_item_info->itemCode."'");
                                                                                                                       
                                                                $getDatas = $databaseObj->get();
                                                                
                                                                  foreach($getDatas as $rowsdata):
                                                                     $itemName = $rowsdata["itemName"];
                                                        
                                                                     $itemCode = $rowsdata["itemCode"];
                                                                     $uom = $rowsdata["Uom"];?>
                                                              <td><?= $itemCode ?></td>
                                                              <td><?= $itemName ?></td>  
                                                              <td><?= $uom ?></td>
                                                              <td><?= $goods_issue_item_info->existing_quantity ?></td> 
                                                              <td><?= $goods_issue_item_info->quantity ?></td> 
                                                              <td><?= $goods_issue_item_info->current_stock ?></td> 
                                                         
                                                               
                                                                 
                                                               
                                                              <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                                               if($goods_issue_status  == ''):
                                                                   echo "Issued";
                                                                   else:
                                                                   echo $goods_issue_status ;
                                                               endif;?></td>
                                                               
                                                              <td><?= $goods_issue_item_info->remarks ?></td> 
                                                      
                                                             

                                                               </tr>
                                                                <?php    

                                                                 
  
                                                          
                                                                 
                       endforeach;   $cnt++; 


endforeach;    
                           
              
                     endif;                 
                             endif; endforeach; 
                            endif;
                       
                      
?> </tfoot> 

    </table>
    
     <table id="example1" class="table table-bordered table-striped">
        <h2>Goods Return Details</h2><br>
        <thead>
            <tr>
                <th>S No</th>
                <th>Project</th>
                <th>Issued Date</th>
                <th>Issued Time</th>
                <th>Issued By</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Previous Stock</th>
                <th>Return</th>
                <th>Stock After Return</th>
                 <th>Issue Status</th>
                <th>Remarks</th>
               
                
               
               <!--  <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                    $cnt = 1;
                    $no = 1;
                   
                    if ($return_result != 0):
                        
                        foreach ($return_result as $issue_rows):

                           
                            $goods_issue_returned = json_decode($issue_rows["goods_issue_returned"]);
                      
                        

            
                             $databaseObj->select("tbl_admin");
                             $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                             $databaseObj->order_by("`admin_id` DESC");
                             $getData = $databaseObj->get(); 
                             //Checking If Data Is Available
                            if($getData != 0):
                                foreach($getData as $rowsadmin):
                                    $admin_info = json_decode($rowsadmin["admin_info"]);
                                    $databaseObj->select("tbl_manage_employee");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rowsemployee):
                                            $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;  
                             if($goods_issue_info->project == $manage_employee_info->project):
                               
                            //Search by Date Range
                            $issue_date=explode("/", $goods_issue_info->ginDate);
                            $issue_date=date("d-m-Y",strtotime($issue_date['0']."-".$issue_date['1']."-".$issue_date['2']));
                         
                             $fromDate=date("d-m-Y",$date_from);
                             $toDate=date("d-m-Y",$date_to);

                            if ($issue_date >= $fromDate && $issue_date <= $toDate):
                                //echo $goods_issue_info->ginDate."<br/>";
                                //DD-MM-YY FORMAT
                                // $original_date = "$goods_issue_info->ginDate";
                                // $timestamp = strtotime($original_date);
                                $new_date = $goods_issue_info->ginDate;?>

                                <?php if (isset($goods_issue_returned)) { ?>
                                <!-- <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?> </td> -->
                                 <?php    foreach ($goods_issue_returned->recv_item_info as $goods_return_item_info):
                                 ?>
                                                         <tr>
                                                              <td><?php echo  $cnt; ?></td>
                                                              <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info->project."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                                                               <td><?=$new_date ?></td>
                                                                <td><?= $goods_issue_log->at ?></td>
                                                               <td> <?= $goods_issue_info->issueBy ?></td>
                                                                    <?php     $databaseObj->select("tbl_manage_item");

                                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_return_item_info->itemCode."'");
                                                                                                                       
                                                                    $getDatas = $databaseObj->get();
                                                                
                                                                    foreach($getDatas as $rowsdata):
                                                                     $itemName = $rowsdata["itemName"];
                                                        
                                                                     $itemCode = $rowsdata["itemCode"];
                                                                     $uom = $rowsdata["Uom"];?>
                                                                     <td><?= $itemCode ?></td>
                                                                     <td><?= $itemName ?></td>  
                                                                     <td><?= $uom ?></td>
                                                                     <td><?= $goods_return_item_info->qty ?></td> 
                                                                     <td><?= $goods_return_item_info->quantity ?></td> 
                                                                     <td><?= $goods_return_item_info->current_stock ?></td> 
                                                                     <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                                               if($goods_issue_status  == ''):
                                                                   echo "Issued";
                                                                   else:
                                                                   echo $goods_issue_status ;
                                                               endif;?></td>
                                                               
                                                              <td><?= $goods_return_item_info->comments ?></td> 
                                                      
                                                             

                                                               </tr>

                                                                <?php    

                                                                 
  
                                                          
                                                                 
                       endforeach;   $cnt++; 


endforeach;    
                 }          
              
                     endif;
                     
                      elseif($goods_issue_info->project == $_POST["project"]):

                      $issue_date=explode("/", $goods_issue_info->ginDate);
                            $issue_date=date("d-m-Y",strtotime($issue_date['0']."-".$issue_date['1']."-".$issue_date['2']));
                         
                             $fromDate=date("d-m-Y",$date_from);
                             $toDate=date("d-m-Y",$date_to);

                            if ($issue_date >= $fromDate && $issue_date <= $toDate):
                                //echo $goods_issue_info->ginDate."<br/>";
                                //DD-MM-YY FORMAT
                                // $original_date = "$goods_issue_info->ginDate";
                                // $timestamp = strtotime($original_date);
                                $new_date = $goods_issue_info->ginDate;?>

                                <?php if (isset($goods_issue_returned)) { ?>
                                <!-- <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?> </td> -->
                                 <?php    foreach ($goods_issue_returned->recv_item_info as $goods_return_item_info):
                                 ?>
                                                         <tr>
                                                              <td><?php echo  $cnt; ?></td>
                                                              <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["project"]."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                                                               <td><?=$new_date ?></td>
                                                              <td><?= $goods_issue_log->at ?></td>
                                                               <td> <?= $goods_issue_info->issueBy ?></td>
                                                                    <?php     $databaseObj->select("tbl_manage_item");

                                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_return_item_info->itemCode."'");
                                                                                                                       
                                                                    $getDatas = $databaseObj->get();
                                                                
                                                                    foreach($getDatas as $rowsdata):
                                                                     $itemName = $rowsdata["itemName"];
                                                        
                                                                     $itemCode = $rowsdata["itemCode"];
                                                                     $uom = $rowsdata["Uom"];?>
                                                                     <td><?= $itemCode ?></td>
                                                                     <td><?= $itemName ?></td>  
                                                                     <td><?= $uom ?></td>
                                                                     <td><?= $goods_return_item_info->qty ?></td> 
                                                                     <td><?= $goods_return_item_info->quantity ?></td> 
                                                                     <td><?= $goods_return_item_info->current_stock ?></td> 
                                                                     <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                                               if($goods_issue_status  == ''):
                                                                   echo "Issued";
                                                                   else:
                                                                   echo $goods_issue_status ;
                                                               endif;?></td>
                                                               
                                                              <td><?= $goods_return_item_info->comments ?></td> 
                                                      
                                                             

                                                               </tr>

                                                                <?php    

                                                                 
  
                                                          
                                                                 
                       endforeach;   $cnt++; 


endforeach;    
                 }          
              
                     endif;         
                            
                         elseif($_POST["project"] == "All"):

                      $issue_date=explode("/", $goods_issue_info->ginDate);
                            $issue_date=date("d-m-Y",strtotime($issue_date['0']."-".$issue_date['1']."-".$issue_date['2']));
                         
                             $fromDate=date("d-m-Y",$date_from);
                             $toDate=date("d-m-Y",$date_to);

                            if ($issue_date >= $fromDate && $issue_date <= $toDate):
                                //echo $goods_issue_info->ginDate."<br/>";
                                //DD-MM-YY FORMAT
                                // $original_date = "$goods_issue_info->ginDate";
                                // $timestamp = strtotime($original_date);
                                $new_date = $goods_issue_info->ginDate;?>

                                <?php if (isset($goods_issue_returned)) { ?>
                                <!-- <td><?= $manage_employee_info->firstName ?><?= $manage_employee_info->lastName ?> </td> -->
                                 <?php    foreach ($goods_issue_returned->recv_item_info as $goods_return_item_info):
                                 ?>
                                                         <tr>
                                                              <td><?php echo  $cnt; ?></td>
                                                              <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["project"]."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                                                               <td><?=$new_date ?></td>
                                                                <td><?= $goods_issue_log->at ?></td>
                                                               <td> <?= $goods_issue_info->issueBy ?></td>
                                                                    <?php     $databaseObj->select("tbl_manage_item");

                                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_return_item_info->itemCode."'");
                                                                                                                       
                                                                    $getDatas = $databaseObj->get();
                                                                
                                                                    foreach($getDatas as $rowsdata):
                                                                     $itemName = $rowsdata["itemName"];
                                                        
                                                                     $itemCode = $rowsdata["itemCode"];
                                                                     $uom = $rowsdata["Uom"];?>
                                                                     <td><?= $itemCode ?></td>
                                                                     <td><?= $itemName ?></td>  
                                                                     <td><?= $uom ?></td>
                                                                     <td><?= $goods_return_item_info->qty ?></td> 
                                                                     <td><?= $goods_return_item_info->quantity ?></td> 
                                                                     <td><?= $goods_return_item_info->current_stock ?></td> 
                                                                     <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                                               if($goods_issue_status  == ''):
                                                                   echo "Issued";
                                                                   else:
                                                                   echo $goods_issue_status ;
                                                               endif;?></td>
                                                               
                                                              <td><?= $goods_return_item_info->comments ?></td> 
                                                      
                                                             

                                                               </tr>

                                                                <?php    

                                                                 
  
                                                          
                                                                 
                       endforeach;   $cnt++; 


endforeach;    
                 }          
              
                     endif;         
                             endif;
                         
                              endforeach; 
                            endif;
                       
                      
?> </tfoot> 

    </table> 
</div>
<th><input type="button" style="margin-left:960px;" id="printbutton" name="" value="Print" onclick="printDiv('printableArea')" class="btn btn-success" /></th>

<script type="text/javaScript">

    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}   
     
     
  
     
  function printing(){
    document.getElementById("printbutton").style.display = "none";
    window.print();
    window.close();
   }

  </script>


<?php
                // }

            }

            else
            {
                $databaseObj->select("tbl_goods_issue");
                // $databaseObj->where("`goods_issue_status` = '".$_POST["invstatus"]."'");
                

                if (empty($_POST["invstatus"])):
                    $databaseObj->where("`status` = '" . $auth->visible() . "'");
                else:
                    $databaseObj->where("`status` = '" . $auth->visible() . "' && `goods_issue_status` = '" . $_POST["invstatus"] . "'");
                endif;

                $databaseObj->order_by("`goods_issue_id` DESC");
                $issue_result1 = $databaseObj->get();
                $return_result1 = $databaseObj->get();


                

              
                
?>
<div id="printableArea">
    <h2>Goods Issue Details</h2><br>

    <table id="example1" class="table table-bordered table-striped">

        <thead>
             <tr>
               <th>S No</th>
                <th>Project</th>
                <th>Issued Date</th>
                <th>Issued Time</th>
                <th>Issued By</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Previous Stock</th>
                <th>Issued</th>
                <th>Stock After Issued</th>
                 <th>Issue Status</th>
                <th>Remarks</th>
               
               <!--  <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                $cnt = 1;
                $no = 1;
                if ($issue_result1 != 0):
                    foreach ($issue_result1 as $issue_rows):
                        $goods_issue_info1 = json_decode($issue_rows["goods_issue_info"]);
                         $goods_issue_returned = json_decode($issue_rows["goods_issue_returned"]);
                         $goods_issue_log = json_decode($issue_rows["goods_issue_log"]);
                         $databaseObj->select("tbl_admin");
                             $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                             $databaseObj->order_by("`admin_id` DESC");
                             $getData = $databaseObj->get(); 
                             //Checking If Data Is Available
                            if($getData != 0):
                                foreach($getData as $rowsadmin):
                                    $admin_info = json_decode($rowsadmin["admin_info"]);
                                    $databaseObj->select("tbl_manage_employee");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rowsemployee):
                                            $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;  
                       if($goods_issue_info1->project == $manage_employee_info->project):
                      
                        //Search by Date Range
                        $issue_date1 = strtotime($goods_issue_info1->ginDate);

                        //DD-MM-YY FORMAT
                        // $original_date = "$goods_issue_info1->ginDate";
                        // $timestamp = strtotime($original_date);
                        $new_date = $goods_issue_info1->ginDate;
                        foreach ($goods_issue_info1->items as $goods_issue_item_info):
                             ?>
                         <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info1->project."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                            <td><?=$new_date ?></td>
                            
                            <td><?= $goods_issue_log->at ?></td>
                             <td><?= $goods_issue_info1->issueBy ?></td>
                            <?php    
                            $databaseObj->select("tbl_manage_item");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_issue_item_info->itemCode."'");
                            $getDatas = $databaseObj->get();
                            foreach($getDatas as $rows_deptt):
                             $itemName = $rows_deptt["itemName"];
                             $itemCode = $rows_deptt["itemCode"];
                             $uom = $rows_deptt["Uom"];
                             ?>
                            <td><?= $itemCode ?></td>
                            <td><?= $itemName ?></td>  
                            <td><?= $uom ?></td>
                            <td><?= $goods_issue_item_info->existing_quantity ?></td>                                    
                            <td><?= $goods_issue_item_info->quantity ?></td> 
                            <td><?= $goods_issue_item_info->current_stock ?></td>
                            <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                                               if($goods_issue_status  == ''):
                                                                   echo "Issued";
                                                                   else:
                                                                   echo $goods_issue_status ;
                                                               endif;?></td>
                                                                                      
                             <td><?= $goods_issue_item_info->remarks ?></td> 
                              </tr><?php
                            endforeach;
                              $cnt++;
                             endforeach;
                           elseif($goods_issue_info1->project == $_POST["project"]):
                               
                        //Search by Date Range
                        $issue_date1 = strtotime($goods_issue_info1->ginDate);

                        //DD-MM-YY FORMAT
                        // $original_date = "$goods_issue_info1->ginDate";
                        // $timestamp = strtotime($original_date);
                        $new_date = $goods_issue_info1->ginDate;
                        foreach ($goods_issue_info1->items as $goods_issue_item_info):
                             ?>
                         <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info1->project."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                            <td><?=$new_date ?></td>
                             <td><?= $goods_issue_log->at ?></td>
                            <td><?= $goods_issue_info1->issueBy ?></td>
                            <?php    
                            $databaseObj->select("tbl_manage_item");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_issue_item_info->itemCode."'");
                            $getDatas = $databaseObj->get();
                            foreach($getDatas as $rows_deptt):
                             $itemName = $rows_deptt["itemName"];
                             $itemCode = $rows_deptt["itemCode"];
                             $uom = $rows_deptt["Uom"];
                             ?>
                            <td><?= $itemCode ?></td>
                            <td><?= $itemName ?></td>  
                            <td><?= $uom ?></td>
                            <td><?= $goods_issue_item_info->existing_quantity ?></td>                                    
                            <td><?= $goods_issue_item_info->quantity ?></td> 
                            <td><?= $goods_issue_item_info->current_stock ?></td>
                            <td><?=  $issue_rows['goods_issue_status'] ?></td>
                                                                                      
                             <td><?= $goods_issue_item_info->remarks ?></td> 
                              </tr><?php
                            endforeach;
                              $cnt++;
                             endforeach;
                        
                          elseif($_POST["project"] == "All"):
                               
                        //Search by Date Range
                        $issue_date1 = strtotime($goods_issue_info1->ginDate);

                        //DD-MM-YY FORMAT
                        // $original_date = "$goods_issue_info1->ginDate";
                        // $timestamp = strtotime($original_date);
                        $new_date = $goods_issue_info1->ginDate;
                        foreach ($goods_issue_info1->items as $goods_issue_item_info):
                             ?>
                         <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php $databaseObj->select("tbl_projects");
                                                               $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info1->project."'");
                                                               $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                            <td><?= $new_date ?></td>
                             <td><?= $goods_issue_log->at ?></td>
                            <td><?= $goods_issue_info1->issueBy ?></td>
                            <?php    
                            $databaseObj->select("tbl_manage_item");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_issue_item_info->itemCode."'");
                            $getDatas = $databaseObj->get();
                            foreach($getDatas as $rows_deptt):
                             $itemName = $rows_deptt["itemName"];
                             $itemCode = $rows_deptt["itemCode"];
                             $uom = $rows_deptt["Uom"];
                             ?>
                            <td><?= $itemCode ?></td>
                            <td><?= $itemName ?></td>  
                            <td><?= $uom ?></td>
                            <td><?= $goods_issue_item_info->existing_quantity ?></td>                                    
                            <td><?= $goods_issue_item_info->quantity ?></td> 
                            <td><?= $goods_issue_item_info->current_stock ?></td>
                            <td><?=  $issue_rows['goods_issue_status'] ?></td>
                                                                                      
                             <td><?= $goods_issue_item_info->remarks ?></td> 
                              </tr><?php
                            endforeach;
                              $cnt++;
                             endforeach;
                         endif;
                         
                    endforeach;
                endif;
?>
           
            </tfoot>

    </table>
    <h2>Goods Return Details</h2><br>
     <table id="example1" class="table table-bordered table-striped">

        <thead>
             <tr>
                <th>S No</th>
                <th>Project</th>
                <th>Issued Date</th>
                <th>Issued Time</th>
                <th>Issued To</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Previous Stock</th>
                <th>Returned</th>
                <!-- <th>Stock after Issued Goods</th> -->
                <th>Stock After Returned</th>
               
                 <th>Issue Status</th>
                <th>Remarks</th>
               
               <!--  <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                $cnt = 1;
                $no = 1;
                if ($return_result1 != 0):
                    foreach ($return_result1 as $return_rows):
                       
                        $goods_issue_info1 = json_decode($return_rows["goods_issue_info"]);
                         $goods_issue_returned1 = json_decode($return_rows["goods_issue_returned"]);
                         $databaseObj->select("tbl_admin");
                             $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                             $databaseObj->order_by("`admin_id` DESC");
                             $getData = $databaseObj->get(); 
                             //Checking If Data Is Available
                            if($getData != 0):
                                foreach($getData as $rowsadmin):
                                    $admin_info = json_decode($rowsadmin["admin_info"]);
                                    $databaseObj->select("tbl_manage_employee");
                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                    $getData = $databaseObj->get();
                                    //Checking If Data Is Available
                                    if($getData != 0):
                                        $sno = 1;
                                        foreach($getData as $rowsemployee):
                                            $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;
                            // for store keeper
                             if($goods_issue_info1->project == $manage_employee_info->project){
                                if (isset($goods_issue_returned1)):

                                    //Search by Date Range
                                    $return_date = strtotime($goods_issue_returned1->return_date);

                                    //DD-MM-YY FORMAT
                                    // $original_date = "$goods_issue_info1->ginDate";
                                    // $timestamp = strtotime($original_date);
                                    $new_date = $goods_issue_info1->ginDate;
                                    
                                    foreach ($goods_issue_returned1->recv_item_info as $goods_return_item_info):?>
                                         <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php $databaseObj->select("tbl_projects");
                                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info1->project."'");
                                                 $getproject = $databaseObj->get();
                                                                               if($getproject != 0):
                                                                                  foreach($getproject as $rows_project):
                                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                                        
                                                                                     
                                                                       
                                                                                  endforeach;
                                                                               endif;?><?= $projects_info->projectName ?></td>
                                            <td><?=$new_date ?></td>
                                              <td><?= $goods_issue_log->at ?></td>
                                             <td><?= $goods_issue_info1->issueBy ?></td>
                                          
                                            <?php    
                                            $databaseObj->select("tbl_manage_item");
                                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_return_item_info->itemCode."'");
                                            $getDatas = $databaseObj->get();
                                            foreach($getDatas as $rows_deptt):
                                                 $itemName = $rows_deptt["itemName"];
                                                 $itemCode = $rows_deptt["itemCode"];
                                                 $uom = $rows_deptt["Uom"];
                                                 ?>
                                                    <td><?= $itemCode ?></td>
                                                    <td><?= $itemName ?></td>  
                                                    <td><?= $uom ?></td>
                                                    <td><?= $goods_return_item_info->qty ?></td>                                    
                                                    <td><?= $goods_return_item_info->quantity ?></td> 
                                                    <td><?= $goods_return_item_info->current_stock ?></td>
                                                   <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                                                                       if($goods_issue_status  == ''):
                                                                                           echo "Issued";
                                                                                           else:
                                                                                           echo $goods_issue_status ;
                                                                                       endif;?></td>
                                                                                       
                                                                                                              
                                                     <td><?= $goods_return_item_info->comments ?></td> 
                                                      </tr><?php
                                            endforeach;
                                          $cnt++;
                                    endforeach;
                                endif;}
                                // for selected project from drop down
                       elseif($goods_issue_info1->project == $_POST["project"]){
                     
                        if (isset($goods_issue_returned1)) {

                        //Search by Date Range
                        $return_date = strtotime($goods_issue_returned1->return_date);

                        //DD-MM-YY FORMAT
                        // $original_date = "$goods_issue_info1->ginDate";
                        // $timestamp = strtotime($original_date);
                        $new_date = $goods_issue_info1->ginDate;
                        
                        foreach ($goods_issue_returned1->recv_item_info as $goods_return_item_info):?>
                         <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php $databaseObj->select("tbl_projects");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["project"]."'");
                                 $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                            <td><?= $new_date ?></td>
                            <td><?= $goods_issue_log->at?></td>
                            <td><?= $goods_issue_info1->issueBy ?></td>
                            <?php    
                            $databaseObj->select("tbl_manage_item");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_return_item_info->itemCode."'");
                            $getDatas = $databaseObj->get();
                            foreach($getDatas as $rows_deptt):
                                     $itemName = $rows_deptt["itemName"];
                                     $itemCode = $rows_deptt["itemCode"];
                                     $uom = $rows_deptt["Uom"];
                                     ?>
                                    <td><?= $itemCode ?></td>
                                    <td><?= $itemName ?></td>  
                                    <td><?= $uom ?></td>
                                    <td><?= $goods_return_item_info->qty ?></td>                                    
                                    <td><?= $goods_return_item_info->quantity ?></td> 
                                    <td><?= $goods_return_item_info->current_stock ?></td>
                                    <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                               if($goods_issue_status  == ''):
                                                   echo "Issued";
                                                   else:
                                                   echo $goods_issue_status ;
                                               endif;?>
                                                   
                                    </td>
                                                                       
                                                                                              
                                    <td><?= $goods_return_item_info->comments ?></td> 
                                      </tr><?php
                            endforeach;
                              $cnt++;
                        endforeach;
                           }
                      }
                       // for dropdown selected All
                        elseif($_POST["project"] == "All"){
                     
                        if (isset($goods_issue_returned1)) {

                        //Search by Date Range
                        $return_date = strtotime($goods_issue_returned1->return_date);

                        //DD-MM-YY FORMAT
                        // $original_date = "$goods_issue_info1->ginDate";
                        // $timestamp = strtotime($original_date);
                        $new_date = $goods_issue_info1->ginDate;
                        
                        foreach ($goods_issue_returned1->recv_item_info as $goods_return_item_info):?>
                         <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php $databaseObj->select("tbl_projects");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$goods_issue_info1->project."'");
                                 $getproject = $databaseObj->get();
                                                               if($getproject != 0):
                                                                  foreach($getproject as $rows_project):
                                                                     $projects_info = json_decode($rows_project["projects_info"]);
                                                                        
                                                                     
                                                       
                                                                  endforeach;
                                                               endif;?><?= $projects_info->projectName ?></td>
                            <td><?=$new_date ?></td>
                            <td><?= $goods_issue_log->at?></td>
                            <td><?= $goods_issue_info1->issueBy ?></td>
                            <?php    
                            $databaseObj->select("tbl_manage_item");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$goods_return_item_info->itemCode."'");
                            $getDatas = $databaseObj->get();
                            foreach($getDatas as $rows_deptt):
                                     $itemName = $rows_deptt["itemName"];
                                     $itemCode = $rows_deptt["itemCode"];
                                     $uom = $rows_deptt["Uom"];
                                     ?>
                                    <td><?= $itemCode ?></td>
                                    <td><?= $itemName ?></td>  
                                    <td><?= $uom ?></td>
                                    <td><?= $goods_return_item_info->qty ?></td>                                    
                                    <td><?= $goods_return_item_info->quantity ?></td> 
                                    <td><?= $goods_return_item_info->current_stock ?></td>
                                    <td><?php  $goods_issue_status= $issue_rows['goods_issue_status'];
                                               if($goods_issue_status  == ''):
                                                   echo "Issued";
                                                   else:
                                                   echo $goods_issue_status ;
                                               endif;?>
                                                   
                                    </td>
                                                                       
                                                                                              
                                    <td><?= $goods_return_item_info->comments ?></td> 
                                      </tr><?php
                            endforeach;
                              $cnt++;
                        endforeach;
                           }
                       }
                    endforeach;
                endif;
?>
           
            </tfoot>

    </table>
</div>
<th><input type="button" style="margin-left:960px;" id="printbutton" name="" value="Print" onclick="printDiv('printableArea')" class="btn btn-success" /></th>

<script type="text/javaScript">

    function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;

          document.body.innerHTML = printContents;

          window.print();

          document.body.innerHTML = originalContents;
          }   




          function printing(){
          document.getElementById("printbutton").style.display = "none";
          window.print();
          window.close();
          }

          </script>



<?php
            }
        }

        //}
        
?>


<!---GOODS RECEIPT ----->

<?php
        if ($_POST["action"] == "Goods Receipt")
        {

            $invstatus = $_POST["invstatus"];
            $date_from = strtotime($_POST["from"]);
            $date_to = strtotime($_POST["to"]);

            if (!empty($date_from) && !empty($date_to))
            {

                //if (!empty($invstatus)) {
                $databaseObj->select("tbl_manage_po");
                $databaseObj->where("`status` = '" . $auth->visible() . "'");
                $databaseObj->order_by("`manage_po_id` DESC");
                $receipt_result = $databaseObj->get();

?>
<div id="printableArea">
    <h2>Goods Receipt Details</h2><br>
    <table id="example1" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>S No</th>
                <th>Order No</th>
                <th>Received Date</th>
                <th>Supplier Name</th>
                <th>Bill No.</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $cnt = 1;
                $no = 1;
                if ($receipt_result != 0):
                    foreach ($receipt_result as $receipt_rows):
                        $manage_po_info = json_decode($receipt_rows["manage_po_info"]);
                        $goods_receipt_info = json_decode($receipt_rows["in_items_received"]);

                        //Search by Date Range
                        $receipt_date = strtotime($goods_receipt_info->in_rec_date);
                        if ($receipt_date >= $date_from && $receipt_date <= $date_to):
                            //echo $goods_issue_info->ginDate."<br/>";
                            //DD-MM-YY FORMAT
                            $original_date = "$goods_receipt_info->receipt_date";
                            $timestamp = strtotime($original_date);
                            $new_date = date("d/m/Y", $timestamp);
?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?=$manage_po_info->orderNo ?></td>
                <td><?=$new_date ?> </td>
                <td><?=$goods_receipt_info->vendor_name ?></td>
                <td><?=$goods_receipt_info->bill_no ?></td>
                <td><?=$receipt_rows["total_amount"] ?></td>

                <td><a href="print_view.php?action=view_receipt&id=<?php echo $receipt_rows["manage_po_id"]; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            </tr>

            <?php
                            $cnt++;
                        endif;
                    endforeach;
                endif;
?>
            <tr>
                <!-- <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th> -->

            </tr>
            </tfoot>

    </table>
</div>
<th><input type="button" style="margin-left:960px;" id="printbutton" name="" value="Print" onclick="printDiv('printableArea')" class="btn btn-success" /></th>


<script type="text/javaScript">

    function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;

          document.body.innerHTML = printContents;

          window.print();

          document.body.innerHTML = originalContents;
          }   




          function printing(){
          document.getElementById("printbutton").style.display = "none";
          window.print();
          window.close();
          }

          </script>



<?php
            }

            // }
            else
            {
                $databaseObj->select("tbl_manage_po");
                $databaseObj->where("`status` = '" . $auth->visible() . "'");
                $databaseObj->order_by("`manage_po_id` DESC");
                $receipt_result1 = $databaseObj->get();

?>
<div id="printableArea">
    <h2>Goods Receipt Details</h2><br>
    <table id="example1" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>S No</th>
                <th>Order No</th>
                <th>Received Date</th>
                <th>Supplier Name</th>
                <th>Bill No.</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $cnt = 1;
                $no = 1;
                if ($receipt_result1 != 0):
                    foreach ($receipt_result1 as $receipt_rows1):
                        $manage_po_info = json_decode($receipt_rows1["manage_po_info"]);
                        $goods_receipt_info1 = json_decode($receipt_rows1["in_items_received"]);

                        //Search by Date Range
                        $issue_date1 = strtotime($goods_receipt_info1->in_rec_date);

                        // echo $issue_date1;
                        //DD-MM-YY FORMAT
                        $original_date = $goods_receipt_info1->in_rec_date;
                        // echo $original_date;
                        $timestamp = strtotime($original_date);
                        $new_date = date("d-m-Y", $timestamp);

?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?=$manage_po_info->orderNo ?></td>
                <td><?=$new_date ?> </td>
                <td><?=$manage_po_info->vendor_name ?></td>
                <td><?=$goods_receipt_info1->in_rec_date ?></td>
                <td><?=$receipt_rows1["total_amount"] ?></td>

                <td><a href="print_view.php?action=view_receipt&id=<?php echo $receipt_rows1["manage_po_id"]; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            </tr>

            <?php
                        $cnt++;

                    endforeach;
                endif;
?>
            <tr>
                <!--  <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th> -->

            </tr>
            </tfoot>

    </table>
</div>
<th><input type="button" style="margin-left:960px;" id="printbutton" name="" value="Print" onclick="printDiv('printableArea')" class="btn btn-success" /></th>


<script type="text/javaScript">

    function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;

          document.body.innerHTML = printContents;

          window.print();

          document.body.innerHTML = originalContents;
          }   

          function printing(){
          document.getElementById("printbutton").style.display = "none";
          window.print();
          window.close();
          }

          </script>

<?php
            }
        }

        //}
        
?>

<script src="dist/js/main.js"></script>


<?php
        //}
        // View STOCK END---------------------------------------------------------------
        
    }

}

?>