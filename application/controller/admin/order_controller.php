<?php


    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel/IOFactory.php");
    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $randSix = $auth->randSix();
    $authority = 1;
    $manageItemDir = "../../../assets/admin/manage-items/";

//include '../include/commonfunctions.php';
// ADD ORDER START--------------------------------------------------------------
   
 
if (isset($_POST["inv_orders"])) {
// manageItemDir = "../../../assets/admin/manage-items/";
     

  $in_ordersid = $_POST["in_ordersid"];
  $order_date = $_POST["order_date"];
  $in_suplier_name = $_POST["in_suplier_name"];
  $ordered_iems = array();
  $sl = 1;
  $ip = $_SERVER['REMOTE_ADDR'];
  
  if(empty($_POST["order_date"])){
      ?>
<script type="text/javascript">
    location.replace('../purchase_order.php?order=nodate');

</script>
<?php
  }
  else if(empty($_POST["order_date"])){
      ?>
<script type="text/javascript">
    location.replace('../purchase_order.php?order=nosupplier');

</script>
<?php
  }




      for($n=1;$n<=count($_POST["item_code"]);$n++){
          if(!empty($_POST["item_code"][$n])){
             $ordered_iems[$sl]['slno'] = $sl;
             $ordered_iems[$sl]['item_code'] = $_POST["item_code"][$n];
             $in_item_masterid = $_POST["item_code"][$n];
             $ordered_iems[$sl]['item_code'] = $_POST["item_code"][$n];
             $ordered_iems[$sl]['qty'] = abs(intval($_POST["qty"][$n]));
             $ordered_iems[$sl]['comments'] = replace_apos($_POST["comments"][$n]);
             $sl++;
             $sql = "UPDATE `in_item_master` SET `ordered`='yes' WHERE `in_item_masterid`='$in_item_masterid'";
             $conn->query($sql);
          }
      }


            // Use json_encode() function
            $in_items_purchased = json_encode($ordered_iems);

      $sql = "INSERT INTO `in_orders`(`in_ordersid`, `in_suplier_name`, `in_items_purchased`, `order_date`, `in_rec_note_no`, `in_rec_date`, `in_rec_bill_no`, `in_items_recieved`, `in_tot_amnt`, `in_ord_status`, `status`) VALUES
              ('$in_ordersid','$in_suplier_name','$in_items_purchased','$order_date','','','','','','pending','active');";
      $sql .= "INSERT INTO `in_userlogs`(`id`, `user_id`, `table_name`, `module`, `submodule`, `record_id`, `action`, `ipaddress`) VALUES
              ('','','in_orders','inv_orders','ADD ORDER','$in_ordersid','add','$ip');";

      if ($conn->multi_query($sql)) {
        ?>
<script type="text/javascript">
    location.replace('../purchase_order.php?order=success');

</script>
<?php
      }
  }
// ADD ORDER START--------------------------------------------------------------
// REVEIVE GOODS START----------------------------------------------------------
if (isset($_POST["receive_goods"])) {

//   echo "<pre>";
//   print_r($_POST);  exit();
    
//    $itemId = $_POST["item_id"];

    
    $in_rec_date = $_POST["grn_date"];
    $in_rec_bill_no = $_POST["bill_no"];
    $in_ordersid = $_POST["order_no"];
    $in_rec_note_no = $_POST["grn_no"];
    $in_tot_amnt = $_POST["total"];
    $payment_mode = $_POST["payment_mode"];
    $account_no = $_POST["acc_no"];
    $bank_name= $_POST["bank_name"];
    $ifsc_code= $_POST["ifsc_code"];
    $cheque_no= $_POST["cheque_no"];
    $total_amount = $_POST["totalAll"];
    $narration = $_POST["narration"];
    $project = $_POST["project"];

   
                    $slashNandR =  array("\n", "\r");
                    $item_info = array();
                    $recv_item_info = array();
                    for($i = 0; $i < count($_POST["item_name"]); $i++):
    
                    $temp_item = array(
                        
                    "itemCode" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_code"][$i]), ENT_QUOTES),
                    "itemName" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_name"][$i]), ENT_QUOTES),
                    "quantity" => htmlspecialchars(str_replace($slashNandR, "", $_POST["quantity"][$i]), ENT_QUOTES),
                    "rate" => htmlspecialchars(str_replace($slashNandR, "", $_POST["rate"][$i]), ENT_QUOTES),
                    "amount" => htmlspecialchars(str_replace($slashNandR, "", $_POST["amount"][$i]), ENT_QUOTES),
                    "cgstrate" => htmlspecialchars(str_replace($slashNandR, "", $_POST["cgstrate_po"][$i]), ENT_QUOTES),
                    "sgstrate" =>htmlspecialchars(str_replace($slashNandR, "", $_POST["sgstrate_po"][$i]), ENT_QUOTES),
                    "igstrate" => htmlspecialchars(str_replace($slashNandR, "", $_POST["igstrate_po"][$i]), ENT_QUOTES),
                    // "igstamt" => htmlspecialchars(str_replace($slashNandR, "", $_POST["igstamt"][$i]), ENT_QUOTES),
                    "total" => htmlspecialchars(str_replace($slashNandR, "", $_POST["total"][$i]), ENT_QUOTES)

                    );


    
    
                        $item_log = array(
                            
                        "action"                        =>      "Receipt Data Updated",
                        "by"                            =>      $auth->admin_id,
                        "ip"                            =>      $_POST["checkIp"],
                        "location"                      =>      $_POST["checkLocation"],
                        "at"                            =>      date("H:i:s A"),
                        "date"                          =>      date("d-m-Y")
                        );

    
                    array_push($recv_item_info, $temp_item);
   
    
    /*data store in manage_po Table */
    
                $received_info = array(
                        "in_rec_bill_no" => $in_rec_bill_no,    
                        "in_rec_date" => $in_rec_date,
                        "payment_mode" => $payment_mode,
                        "acc_no" => $account_no,
                        "bank_name" => $bank_name,
                        "ifsc_code" => $ifsc_code,
                        "cheque" => $cheque_no,
                        "project" => $project,

                        "narration" => str_replace("'","",$narration),  
                        "recv_item_info" => $recv_item_info
                            
                        );
    
    
     
                        $tableData["in_items_received"] = json_encode($received_info);
                         
    
                        $tableData["manage_po_log"] = json_encode($item_log);
                        $tableData["order_status"] = "complete"; 
                        $tableData["payment_status"] = "paid";           

                         $tableData["total_amount"] = $total_amount;  
          
                         $tableData["rec_note_no"] = $in_rec_note_no;
                       
                        $tableData["status"] = $auth->visible();
                        
                     $check = $databaseObj->update("tbl_manage_po", $tableData, "`manage_po_id` = '$in_ordersid'");

               /*data store end  in manage_po Table */

     
    
    
    
        /*QTY updated in item Table */
    
    
                    $qty = 0;
                     $databaseObj->data = array();
                     $databaseObj->dataVal = "";
                      
                        $databaseObj->select("tbl_manage_stock");
                       $databaseObj->where("`status` = '".$auth->visible()."' && `project` = '".$_POST["project"]."'&& `itemCode` = '".$_POST["item_code"][$i]."'");
                        $getData = $databaseObj->get();

                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $qty = $rows["Qty"];
                            endforeach;
                        endif;
    
    
    
    
    
    
                        $databaseObj->data = array();
                       $databaseObj->dataVal = "";
                        $tableData1["Qty"] = intval($qty) + intval($_POST["quantity"][$i]);
                        $tableData1["lastReceived"] = $in_rec_date;
                        $tableData1["manage_stock_log"] = json_encode($item_log);

                         $check1 = $databaseObj->update("tbl_manage_stock", $tableData1, "`project` = '".$_POST["project"]."' && `itemCode` = '".$_POST["item_code"][$i]."'");
                        
                        echo "<pre>";
                           echo $check1;
                        $databaseObj->data = array();
                        $databaseObj->dataVal = ""; 

                    endfor;
    
                  /*QTY  End updated in item Table */
              

                  
                       if($check1 == 1):   ?>
                    <script type="text/javascript">
                    location.replace('../../../goods-receipt.php?response=success');

                    </script>
                    <?php
                    else:
                    $data["response"] = "error";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "Something went wrong please try again!!!";
                    endif;
                   

             }
    


  ?>