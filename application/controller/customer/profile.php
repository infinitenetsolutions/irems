<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/customer-authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel/IOFactory.php");
    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $randSix = $auth->randSix();
    $authority = 1;
    $profileDir = "../../../assets/customer/profile/";
    if(isset($_POST["action"])):
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Add Data Section Start -----------
            // -----------------------------------------------
            
            // -----------------------------------------------
            // ------------ Edit Data Section Start ----------
            // -----------------------------------------------
            case "editData":
                if($authority == 1):
                    if(!empty($_POST["editTableId"])):
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $customer_info = json_decode($rows["customer_info"]);
                                $customer_log = json_decode($rows["customer_log"]);
                                $customer_second_applicant = json_decode($rows["customer_second_applicant"]);
                            endforeach;
                            if(!empty($_POST["editName"] && $_POST["editparentname"] && $_POST["editemailId"] && $_POST["editgender"] && $_POST["editpermanentaddress"] && $_POST["editcorrespondenceaddress"] )):
                                if(!empty($_FILES["editdp"]["name"])):
                                    if(move_uploaded_file($_FILES["editdp"]["tmp_name"] , $profileDir.$randSix."_".$_FILES["editdp"]["name"])):
                                        $dp= $randSix."_".$_FILES["editdp"]["name"];

                                        $dp = htmlspecialchars( $dp, ENT_QUOTES);
                                        if($customer_info->dp != "default"):
                                            if(file_exists($profileDir.str_replace("&#039;", "'", $customer_info->dp))):
                                                unlink($profileDir.str_replace("&#039;", "'", $customer_info->dp));
                                            endif;
                                        endif;
                                    else:
                                       $customer_info = $customer_info->dp;
                                    endif;
                                else:
                                    $customer_info = $customer_info->dp;
                                endif;
                                $edit_info = array(
                                                        "dp"           =>      $dp,
                                                        "name"     =>      htmlspecialchars($_POST["editName"], ENT_QUOTES),
                                                        "parentName"         =>      htmlspecialchars($_POST["editparentname"], ENT_QUOTES),
                                                        "emailId"     =>      htmlspecialchars($_POST["editemailId"], ENT_QUOTES),
                                                        "gender"  =>      htmlspecialchars($_POST["editgender"], ENT_QUOTES),
                                                        "permanentAddress"      =>      htmlspecialchars($_POST["editpermanentaddress"], ENT_QUOTES),
                                                        "correspondenceAddress"       =>      htmlspecialchars($_POST["editcorrespondenceaddress"], ENT_QUOTES),
                                                        
                                                );

                                 
                                 $edit_log = array(
                                                    "action"                =>      "edited",
                                                    "by"                    =>      $auth->customer_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                            
                                $tableData["customer_info"] = json_encode($edit_info);
                                $tableData["customer_second_applicant"] = json_encode($edit_info);
                                $tableData["customer_log"] = json_encode($customer_log);
                                $tableData["status"] = $auth->visible();
                                $check = $databaseObj->update("tbl_customer", $tableData, "`customer_id` = '".$_POST["editTableId"]."'");
                                if($check == 1):
                                    $data["response"] = "success";
                                    $data["responseType"] = "success";
                                    $data["responseMessage"] = "Data edited successfully!!!";
                                else:
                                    $data["response"] = "error";
                                    $data["responseType"] = "error";
                                    $data["responseMessage"] = "Something went wrong please try again!!!";
                                endif;
                            else:
                                $data["response"] = "empty";
                                $data["responseType"] = "warning";
                                $data["responseMessage"] = "Please fill out the required fields!!!";
                            endif;
                        else:
                            $data["response"] = "idNotFoundInTable";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                        endif;
                    else:
                        $data["response"] = "idNotFound";
                        $data["responseType"] = "error";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to edit!!!";
                endif;
                break;
            // -----------------------------------------------
            // ------------ Edit Data Section End ------------
            // -----------------------------------------------
            // --------------------------------------------------
            
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