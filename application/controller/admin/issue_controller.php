<?php
require_once ("../../classes-and-objects/config.php");
require_once ("../../classes-and-objects/veriables.php");
require_once ("../../classes-and-objects/authentication.php");
require_once ("../../classes-and-objects/PHPExcel/PHPExcel.php");
require_once ("../../classes-and-objects/PHPExcel/PHPExcel/IOFactory.php");
$auth = new AUTHENTICATION($databaseObj);
$objPHPExcel = new PHPExcel();
$randSix = $auth->randSix();
$authority = 1;
$manageItemDir = "../../../assets/admin/manage-items/";


// RETURN ITEM START------------------------------------------------------------
if($_POST["action"] == "return_goods"){

    $in_goods_issueid = $_POST["issue_no"];
    $issueTo = $_POST["issueTo"];
    $return_date = $_POST["gin_date"];

                       
                        //Checking If Data Is Available

                       

                           

                             
                            
    //$status = "returned";
   
    $item_info = array();
    $return_item_info = array();
    for ($i = 0;$i < count($_POST["itemName"]);$i++):
        $temp_item = array(
            "itemCode" => htmlspecialchars($_POST["itemCode"][$i], ENT_QUOTES) ,
            "itemName" => htmlspecialchars($_POST["itemName"][$i], ENT_QUOTES) ,
            "uom" => htmlspecialchars($_POST["Uom"][$i], ENT_QUOTES) ,
            "qty" => htmlspecialchars($_POST["Qty"][$i], ENT_QUOTES) ,
            "quantity" => htmlspecialchars($_POST["quantity1"][$i], ENT_QUOTES) ,
            "comments" => htmlspecialchars($_POST["remark"][$i], ENT_QUOTES) ,
            "current_stock" => htmlspecialchars(intval($_POST["Qty"][$i]) + intval($_POST["quantity1"][$i]) , ENT_QUOTES) ,
        );
       
        // exit(0);
        $item_log = array(
            
                "action" => "Returned",
                "by" => $auth->admin_id,
                "ip" => $_POST["checkIp"],
                "location" => $_POST["checkLocation"],
                "at" => date("H:i:s A") ,
                "date" => date("d-m-Y")
           
        );
        array_push($return_item_info, $temp_item);
       

        /*data store in GOODS iSSUE Table */
        $received_info = array(
            array(
                "issue_no" => $in_goods_issueid,
                "issueTo" => $issueTo,
                "return_date" => $return_date,
                "recv_item_info" => $return_item_info
            )
        );
        /*QTY updated in item Table */
        $qty = 0;
        $databaseObj->data = array();
        $databaseObj->dataVal = "";
        $databaseObj->select("tbl_manage_stock");
        $databaseObj->where("`status` = '" .$auth->visible(). "' && `project` = '" .$_POST["project"]. "'&& `itemCode` = '" .$_POST["itemCode"][$i]. "'");
        $getData = $databaseObj->get();
        //Checking If Data Is Available
        if ($getData != 0):
            $sno = 1;
            foreach ($getData as $rows):
                $qty = $rows["Qty"];
            endforeach;
        endif;
        $databaseObj->data = array();
        $databaseObj->dataVal = "";
        $tableData1["Qty"] = intval($qty) + intval($_POST["quantity"][$i]);
        $tableData1["lastReceived"] = $return_date;
        $tableData1["manage_stock_log"] = json_encode($item_log);
        $check = $databaseObj->update("tbl_manage_stock", $tableData1, "`project` = '" . $_POST["project"] . "' && `itemCode` = '" . $_POST["itemCode"][$i] . "'");
        $databaseObj->dataVal = "";
        $databaseObj->data = "";
        $databaseObj->sql = "";
    endfor;
    $databaseObj->select("tbl_goods_issue");
    $databaseObj->where("`status` = '" . $auth->visible() . "'&& `goods_issue_id` = '" . $_POST["order_no"] . "'");
    $getData = $databaseObj->get();
    //Checking If Data Is Available
    foreach ($getData as $rows):
        $goods_issue_returned = json_decode($rows["goods_issue_returned"]);
        $goods_issue_info = json_decode($rows["goods_issue_info"]);
    endforeach;
    for ($i = 0;$i < count($_POST["itemName"]);$i++):
        //     $temp_item = array(
        //     "itemCode" => htmlspecialchars(str_replace($slashNandR, "", $_POST["itemCode"][$i]), ENT_QUOTES),
        //     "itemName" => htmlspecialchars(str_replace($slashNandR, "", $_POST["itemName"][$i]), ENT_QUOTES),
        //     "uom" => htmlspecialchars(str_replace($slashNandR, "", $_POST["Uom"][$i]), ENT_QUOTES),
        //     "quantity" => htmlspecialchars(str_replace($slashNandR, "", $_POST["quantity"][$i]), ENT_QUOTES),
        //     "qty" => htmlspecialchars(str_replace($slashNandR, "", $qty), ENT_QUOTES),
        //     "comments" => htmlspecialchars(str_replace($slashNandR, "", $_POST["remark"][$i]), ENT_QUOTES)
        //     );
        //     $item_log = array(
        //         array(
        //     "action"                        =>      "Return Item Data Updated",
        //     "by"                            =>      $auth->admin_id,
        //     "ip"                            =>      $_POST["checkIp"],
        //     "location"                      =>      $_POST["checkLocation"],
        //     "at"                            =>      date("H:i:s A"),
        //     "date"                          =>      date("d-m-Y")
        //             )
        //     );
        // array_push($return_item_info, $temp_item);
        /*data store in GOODS iSSUE Table */
        $received_info = array(
            "issue_no" => $in_goods_issueid,
            "issueTo" => $issueTo,
            "return_date" => $return_date,
            "recv_item_info" => $return_item_info
        );
        // echo "<pre>";
        // print_r($received_info); exit;
        $tableData["goods_issue_returned"] = json_encode($received_info);
        $tableData["goods_issue_log"] = json_encode($item_log);
        $tableData["goods_issue_status"] = "returned";
        $tableData["status"] = $auth->visible();
    endfor;
   
    $check = $databaseObj->update("tbl_goods_issue", $tableData, "`goods_issue_id` = '" .$_POST["order_no"]. "'");
   
    $databaseObj->error();
    if ($check == 1):
        $data["id"] = $_POST["order_no"];
        $data["response"] = "success";
        $data["responseType"] = "success";
        $data["responseMessage"] = "Goods Returned Successfully .!!!!!!";
    else:
        $data["response"] = "error";
        $data["responseType"] = "error";
        $data["responseMessage"] = "Something went wrong please try again!!!";
    endif;

    echo json_encode($data);
}

?>
