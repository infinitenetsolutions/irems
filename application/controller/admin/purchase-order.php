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
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Add Data Section Start -----------
            // -----------------------------------------------
            case "addPO":
                if($authority == 1):
                  
                   if (!empty($_POST["orderNo"] && $_POST["poDate"] && $_POST["vendor_name"] && $_POST["company_name"])):
                        $slashNandR =  array("\n", "\r");
                        if(!empty($_FILES["companyLogo"]["name"])):

                            if(move_uploaded_file($_FILES["companyLogo"]["tmp_name"] , $manageCompanyDir.$randSix."_".$_FILES["companyLogo"]["name"])):

                                $companyLogo = $randSix."_".$_FILES["companyLogo"]["name"];

                            else:

                                $companyLogo = "default";

                            endif;

                        else:

                            $companyLogo = "default";

                        endif;
                                  //echo count($_POST["check-all"]); exit;
                                         $item_info = array();
                                         //$checked = $request->has('delete') ? 1 : 0;
                                          for($i = 0; $i < count($_POST["item_name_po"]); $i++):
                                         	//if ($_POST["checkbox-select"][$i]=='checked'):
                                            $temp_item = array(
                                            					"itemSel" => htmlspecialchars(str_replace($slashNandR, "", $_POST["checkbox-select"][$i]), ENT_QUOTES),
                                                                "itemCode" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_code_po"][$i]), ENT_QUOTES),
                                                                "itemName" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_name_po"][$i]), ENT_QUOTES),
                                                                "uom" => htmlspecialchars(str_replace($slashNandR, "", $_POST["uom_po"][$i]), ENT_QUOTES),
                                                                "quantity" => htmlspecialchars(str_replace($slashNandR, "", $_POST["quantity_po"][$i]), ENT_QUOTES),
                                                                "rate" => htmlspecialchars(str_replace($slashNandR, "", $_POST["rate_po"][$i]), ENT_QUOTES),
                                                                "amount" => htmlspecialchars(str_replace($slashNandR, "", $_POST["amount_po"][$i]), ENT_QUOTES),
                                                                "cgstrate" => htmlspecialchars(str_replace($slashNandR, "", $_POST["cgstrate_po"][$i]), ENT_QUOTES),
                                                                "sgstrate" =>htmlspecialchars(str_replace($slashNandR, "", $_POST["sgstrate_po"][$i]), ENT_QUOTES),
                                                                "igstrate_po" => htmlspecialchars(str_replace($slashNandR, "", $_POST["igstrate"][$i]), ENT_QUOTES),
                                                                "remark" => htmlspecialchars(str_replace($slashNandR, "", $_POST["remark_po"][$i]), ENT_QUOTES),
                                                                "total" => htmlspecialchars(str_replace($slashNandR, "", $_POST["total_po"][$i]), ENT_QUOTES)
													
                                            	            );
                                          
                                            array_push($item_info, $temp_item);
                                            
                                           // endif;
                                         endfor;
                                         
                                         $po_info = array(
                                                      "companyLogo" => htmlspecialchars($companyLogo, ENT_QUOTES),
                                                        "orderNo" => htmlspecialchars(str_replace($slashNandR, "", $_POST["orderNo"]), ENT_QUOTES),
                                                        "state" => htmlspecialchars(str_replace($slashNandR, "", $_POST["state"]), ENT_QUOTES),
                                                        "poDate" => htmlspecialchars(str_replace($slashNandR, "", $_POST["poDate"]), ENT_QUOTES),
                                                        "stateCode" => htmlspecialchars(str_replace($slashNandR, "", $_POST["stateCode"]), ENT_QUOTES),
                                                        "vendor_name" => htmlspecialchars(str_replace($slashNandR, "", $_POST["vendor_name"]), ENT_QUOTES),
                                                        "vendor_address" => htmlspecialchars(str_replace($slashNandR, "", $_POST["vendor_address"]), ENT_QUOTES),
                                                        "vendor_gstin" => htmlspecialchars(str_replace($slashNandR, "", $_POST["vendor_gstin"]), ENT_QUOTES),
                                                        "vendor_contact_person" => htmlspecialchars(str_replace($slashNandR, "", $_POST["vendor_contact_person"]), ENT_QUOTES),
                                                        "vendor_contact_phone_no" => htmlspecialchars(str_replace($slashNandR, "", $_POST["vendor_contact_phone_no"]), ENT_QUOTES),
                                                        "companyLogo" => htmlspecialchars(str_replace($slashNandR, "", $_POST["companyLogo"]), ENT_QUOTES),
                                                        "company_name" => htmlspecialchars(str_replace($slashNandR, "", $_POST["company_name"]), ENT_QUOTES),
                                                        "company_gstin" => htmlspecialchars(str_replace($slashNandR, "", $_POST["company_gstin"]), ENT_QUOTES),
                                                        "company_address" => htmlspecialchars(str_replace($slashNandR, "", $_POST["company_address"]), ENT_QUOTES),
                                                        "employee_project" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_project"]), ENT_QUOTES),
                                                        "employee_designation" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_designation"]), ENT_QUOTES),

                                                         "employee" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee"]), ENT_QUOTES), 
                                                        "description" => htmlspecialchars(str_replace($slashNandR, "", $_POST["description"]), ENT_QUOTES),
                                                        "payment_terms" => htmlspecialchars(str_replace($slashNandR, "", $_POST["payment_terms"]), ENT_QUOTES),
                                                        "requisition_no" => htmlspecialchars(str_replace($slashNandR, "", $_POST["requisition_no"]), ENT_QUOTES),
                                                        "requisition_date" => htmlspecialchars(str_replace($slashNandR, "", $_POST["requisition_date"]), ENT_QUOTES),
                                                        "project" => htmlspecialchars(str_replace($slashNandR, "", $_POST["project"]), ENT_QUOTES),
                                                        "project_location" => htmlspecialchars(str_replace($slashNandR, "", $_POST["project_location"]), ENT_QUOTES),
                                                        "payment_terms" => htmlspecialchars(str_replace($slashNandR, "", $_POST["payment_terms"]), ENT_QUOTES),
                                                        "payment_description" => htmlspecialchars(str_replace($slashNandR, "", $_POST["payment_description"]), ENT_QUOTES),
                                                        "billing_contact_person" => htmlspecialchars(str_replace($slashNandR, "", $_POST["billing_contact_person"]), ENT_QUOTES),
                                                        "billing_contact_designation" => htmlspecialchars(str_replace($slashNandR, "", $_POST["billing_contact_designation"]), ENT_QUOTES),
                                                        "billing_contact_number" => htmlspecialchars(str_replace($slashNandR, "", $_POST["billing_contact_number"]), ENT_QUOTES),
                                                         "totalAll" => htmlspecialchars(str_replace($slashNandR, "", $_POST["totalAll"]), ENT_QUOTES),
                                                        "item_info" => $item_info
                                                    );


                       

                           

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
//                        $tableData["poDate"] = $poDate;
//                        $tableData["orderNo"] = $orderNo;
                        $tableData["manage_po_info"] = json_encode($item_info);
                        $tableData["manage_po_info"] = json_encode($po_info);
                        $tableData["order_status"] = "pending";
                        //$tableData["rec_note_no"] = 0;
                        $tableData["manage_po_log"] = json_encode($item_log);
                        $tableData["status"] = $auth->visible();

                        $check = $databaseObj->insert("tbl_manage_po", $tableData);
                         $databaseObj->error();
                        if($check == 1):

                        // echo '<script type="text/javascript">
                        // location.replace("../../../purchase-order.php?response=success");
                        // </script>';  
                        

                        //  echo '<script type="text/javascript">
                        //  location.replace("../../../manage-po.php?response=success");
                        // </script>
                            
//                     echo '<script>parent.window.location.reload(true);</script>';

                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Data added successfully!!!";

                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                           $data["responseMessage"] = "Something went wrong please try again!!!";
//                            if ($flag1>0) {
//                              $data["responseMessage"] = "Item Code Already Exists!!!";
//                            }
//                            elseif ($flag2>0) {
//                              $data["responseMessage"] = "Item Name Already Exists!!!";
//                            }
                           
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