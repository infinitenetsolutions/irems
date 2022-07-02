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
    if(isset($_POST["action"])):
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit(0);
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Add Data Section Start -----------
            // -----------------------------------------------
            case "addPO":
                if($authority == 1):
                    if(!empty($_POST["itemName"] && $_POST["itemCode"] && $_POST["itemCategory"] && $_POST["Uom"] && $_POST["Price"] && $_POST["Qty"] && $_POST["ReOrder"])):

                                                $itemName           =      htmlspecialchars($_POST["itemName"], ENT_QUOTES);
                                                $itemCode           =      htmlspecialchars($_POST["itemCode"], ENT_QUOTES);
                                                $itemCategory       =      htmlspecialchars($_POST["itemCategory"], ENT_QUOTES);
                                                $Uom                =      htmlspecialchars($_POST["Uom"], ENT_QUOTES);
                                                $Price              =      htmlspecialchars($_POST["Price"], ENT_QUOTES);
                                                $Qty                =      htmlspecialchars($_POST["Qty"], ENT_QUOTES);
                                                $ReOrder            =      htmlspecialchars($_POST["ReOrder"], ENT_QUOTES);
                        $item_log = array(
                                            array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            )
                                        );
                        $tableData["manage_po_date"] = $poDate;
                        $tableData["manage_po_order"] = $poItems;
                        $tableData["manage_item_log"] = json_encode($item_log);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_manage_item", $tableData);
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Data added successfully!!!";
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            if ($flag1>0) {
                              $data["responseMessage"] = "Item Code Already Exists!!!";
                            }
                            elseif ($flag2>0) {
                              $data["responseMessage"] = "Item Name Already Exists!!!";
                            }
                            else {
                              $data["responseMessage"] = "Something went wrong please try again!!!";
                            }
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Please fill out the required fields!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            // -----------------------------------------------
            // ------------ Add Data Section End -------------
            // -----------------------------------------------
            // -----------------------------------------------------------
            default:
                $data["response"] = "notFound";
                $data["responseType"] = "warning";
                $data["responseMessage"] = "Something went wrong please try again!!!";
                break;
        endswitch;
        // -----------------------------------
        // ------------ Switch End -----------
        // -----------------------------------
        echo json_encode($data);
    endif;
?>
