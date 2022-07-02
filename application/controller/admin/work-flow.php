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
    $work_flowDir = "../../../assets/admin/work-flow/";
    if(isset($_POST["action"])):
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Add Data Section Start -----------
            // -----------------------------------------------
            case "addMainWorkForm":
                if($authority == 1):
                    if(!empty($_POST["projects_id"] && $_POST["main_work_type"] && $_POST["main_work_type_starting_date"] && $_POST["main_work_type_starting_time"] && $_POST["main_work_type_expected_ending_date"] && $_POST["main_work_type_expected_ending_time"])):
                        $data_info = array(
                                                    "main_work_type"                        =>      htmlspecialchars($_POST["main_work_type"], ENT_QUOTES),
                                                    "starting_date"          =>      htmlspecialchars($_POST["main_work_type_starting_date"], ENT_QUOTES),
                                                    "starting_time"          =>      htmlspecialchars($_POST["main_work_type_starting_time"], ENT_QUOTES),
                                                    "expected_ending_date"   =>      htmlspecialchars($_POST["main_work_type_expected_ending_date"], ENT_QUOTES),
                                                    "expected_ending_time"   =>      htmlspecialchars($_POST["main_work_type_expected_ending_time"], ENT_QUOTES),
                                                    "ending_date"            =>      htmlspecialchars($_POST["main_work_type_ending_date"], ENT_QUOTES),
                                                    "ending_time"            =>      htmlspecialchars($_POST["main_work_type_ending_time"], ENT_QUOTES)
                                        );
                        $data_log = array(
                                            array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            )
                                        );
                        $tableData["projects_id"] = $_POST["projects_id"];
                        $tableData["work_flow_info"] = json_encode($data_info);
                        $tableData["work_flow_works"] = "[]";
                        $tableData["work_flow_log"] = json_encode($data_log);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_work_flow", $tableData);
                        echo $databaseObj->error();
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Data added successfully!!!";
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
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            case "addWorkForm":
                if($authority == 1):
                    if(!empty($_POST["work_main_work_type_id"] && $_POST["work_type"] && $_POST["work_type_starting_date"] && $_POST["work_type_starting_time"] && $_POST["work_type_expected_ending_date"] && $_POST["work_type_expected_ending_time"] && $_POST["totalItemInfo"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["work_main_work_type_id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log_pre = json_decode($rows["work_flow_log"]);
                                $work_flow_works = json_decode($rows["work_flow_works"]);
                            endforeach;
                            $itemArray = array();
                            $work_type_id = 0;
                            if(count($work_flow_works) > 0):
                                foreach ($work_flow_works as $work_flow_works_all):
                                    if($work_type_id < $work_flow_works_all->work_type_id):
                                        $work_type_id = $work_flow_works_all->work_type_id;
                                    endif;
                                endforeach;
                            else:
                                $work_type_id = 0;
                            endif;
                            for($i = 0; $i < count($_POST["itemInfoItemType"]); $i++):
                                $tempItemArray = "";
                                $tempItemArray = array(
                                                    "item_type"         =>      htmlspecialchars($_POST["itemInfoItemType"][$i], ENT_QUOTES),
                                                    "unit_type"         =>      htmlspecialchars($_POST["itemInfoUnitType"][$i], ENT_QUOTES),
                                                    "quantity"          =>      htmlspecialchars($_POST["itemInfoQuantity"][$i], ENT_QUOTES),
                                                    "rate"              =>      htmlspecialchars($_POST["itemInfoRate"][$i], ENT_QUOTES),
                                                    "amount"            =>      htmlspecialchars($_POST["itemInfoAmount"][$i], ENT_QUOTES),
                                                    "a"                 =>      htmlspecialchars($_POST["itemInfoMaterial"][$i], ENT_QUOTES),
                                                    "b"                 =>      htmlspecialchars($_POST["itemInfoLabour"][$i], ENT_QUOTES),
                                                    "remarks"           =>      htmlspecialchars($_POST["itemInfoRemarks"][$i], ENT_QUOTES)
                                                );
                                array_push($itemArray, $tempItemArray);
                            endfor;
                            $data_works =   array(
                                                "work_type_id"              =>      ++$work_type_id,
                                                "work_type"                 =>      htmlspecialchars($_POST["work_type"], ENT_QUOTES),
                                                "starting_date"             =>      htmlspecialchars($_POST["work_type_starting_date"], ENT_QUOTES),
                                                "starting_time"             =>      htmlspecialchars($_POST["work_type_starting_time"], ENT_QUOTES),
                                                "expected_ending_date"      =>      htmlspecialchars($_POST["work_type_expected_ending_date"], ENT_QUOTES),
                                                "expected_ending_time"      =>      htmlspecialchars($_POST["work_type_expected_ending_time"], ENT_QUOTES),
                                                "ending_date"               =>      htmlspecialchars($_POST["work_type_ending_date"], ENT_QUOTES),
                                                "ending_time"               =>      htmlspecialchars($_POST["work_type_ending_time"], ENT_QUOTES),
                                                "items"                     =>      $itemArray
                                            );
                            $data_log = array(
                                            "action"                =>      "work Added",
                                            "by"                    =>      $auth->admin_id,
                                            "ip"                    =>      $_POST["checkIp"],
                                            "location"              =>      $_POST["checkLocation"],
                                            "at"                    =>      date("H:i:s A"),
                                            "date"                  =>      date("d-m-Y")
                                        );
                            array_push($data_log_pre, $data_log);
                            array_push($work_flow_works, $data_works);
                            $tableData["work_flow_log"] = json_encode($data_log_pre);
                            $tableData["work_flow_works"] = json_encode($work_flow_works);
                            $check = $databaseObj->update("tbl_work_flow", $tableData, "`work_flow_id` = '".$_POST["work_main_work_type_id"]."'");
                            if($check == 1):
                                $data["response"] = "success";
                                $data["responseType"] = "success";
                                $data["responseMessage"] = "Item added successfully!!!";
                            else:
                                $data["response"] = "error";
                                $data["responseType"] = "error";
                                $data["responseMessage"] = "Something went wrong please try again!!!";
                            endif;
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please refresh your page and try again!!!";
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
            case "addMainWorkType":
                if($authority == 1):
                    if(!empty($_POST["main_work_type_add"])):
                        $land_info = array(
                                                "main_work_type"          =>      htmlspecialchars($_POST["main_work_type_add"], ENT_QUOTES)
                                        );
                        $land_log = array(
                                            array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            )
                                        );
                        $tableData["main_work_type_info"] = json_encode($land_info);
                        $tableData["main_work_type_log"] = json_encode($land_log);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_main_work_type", $tableData);
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Main Work Added successfully!!!";
                            $data["responseId"] = $databaseObj->last_inserted_id();
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Please give Main Work Type!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            case "addWorkType":
                if($authority == 1):
                    if(!empty($_POST["work_type_add"])):
                        $land_info = array(
                                                "work_type"          =>      htmlspecialchars($_POST["work_type_add"], ENT_QUOTES)
                                        );
                        $land_log = array(
                                            array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            )
                                        );
                        $tableData["work_type_info"] = json_encode($land_info);
                        $tableData["work_type_log"] = json_encode($land_log);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_work_type", $tableData);
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Work Added successfully!!!";
                            $data["responseId"] = $databaseObj->last_inserted_id();
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Please give Main Work Type!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            case "addItemType":
                if($authority == 1):
                    if(!empty($_POST["item_type_add"] && $_POST["item_type_ab_add"])):
                        $land_info = array(
                                                "item_type"          =>      htmlspecialchars($_POST["item_type_add"], ENT_QUOTES),
                                                "item_type_ab"       =>      htmlspecialchars($_POST["item_type_ab_add"], ENT_QUOTES)
                                        );
                        $land_log = array(
                                            array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            )
                                        );
                        $tableData["item_type_info"] = json_encode($land_info);
                        $tableData["item_type_log"] = json_encode($land_log);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_item_type", $tableData);
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Item Added successfully!!!";
                            $data["responseId"] = $databaseObj->last_inserted_id();
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Please give Item Type!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            case "addUnitType":
                if($authority == 1):
                    if(!empty($_POST["unit_type_add"])):
                        $land_info = array(
                                                "unit_type"          =>      htmlspecialchars($_POST["unit_type_add"], ENT_QUOTES)
                                        );
                        $land_log = array(
                                            array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            )
                                        );
                        $tableData["unit_type_info"] = json_encode($land_info);
                        $tableData["unit_type_log"] = json_encode($land_log);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_unit_type", $tableData);
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Unit Added successfully!!!";
                            $data["responseId"] = $databaseObj->last_inserted_id();
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Please give Main Work Type!!!";
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
            // ------------ Opened/Closed Status Section Start -----------
            // -----------------------------------------------------------
            case "changeProjectStatus":
                if($authority == 1):
                    if(isset($_POST["projects_id"]) && !empty($_POST["projects_id"])):
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["projects_id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log = json_decode($rows["projects_log"]);
                                $projects_info = json_decode($rows["projects_info"]);
                            endforeach;
                        endif;
                        if($_POST["status"] == "active"):
                            $delete_log = array(
                                                    "action"                =>      "Project Closed",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                            array_push($data_log, $delete_log);
                            $projects_info->projectEndingDate = date("Y-m-d");
                            $returnStatus = date("d M, Y")." / ".date("h:i A");
                        else:
                            $delete_log = array(
                                                    "action"                =>      "Project Opened",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                            array_push($data_log, $delete_log);
                            $projects_info->projectEndingDate = "";
                            $returnStatus = "Not End";
                        endif;
                        $tableData["projects_log"] = json_encode($data_log);
                        $tableData["projects_info"] = json_encode($projects_info);
                        $check = $databaseObj->update("tbl_projects", $tableData, "`projects_id` = '".$_POST["projects_id"]."'");
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["returnStatus"] = $returnStatus;
                            $data["responseMessage"] = "Status Changed successfully!!!";
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            case "changeOrgStatus":
                if($authority == 1):
                    if(isset($_POST["work_flow_id"]) && !empty($_POST["work_flow_id"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["work_flow_id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log = json_decode($rows["work_flow_log"]);
                                $work_flow_info = json_decode($rows["work_flow_info"]);
                            endforeach;
                        endif;
                        if($_POST["status"] == "active"):
                            $delete_log = array(
                                                    "action"                =>      "Status Closed",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                            array_push($data_log, $delete_log);
                            $work_flow_info->ending_date = date("Y-m-d");
                            $work_flow_info->ending_time = date("H:i");
                            $returnStatus = date("d M, Y")." / ".date("h:i A");
                        else:
                            $delete_log = array(
                                                    "action"                =>      "Status Opened",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                            array_push($data_log, $delete_log);
                            $work_flow_info->ending_date = "";
                            $work_flow_info->ending_time = "";
                            $returnStatus = "Not End";
                        endif;
                        $tableData["work_flow_log"] = json_encode($data_log);
                        $tableData["work_flow_info"] = json_encode($work_flow_info);
                        $check = $databaseObj->update("tbl_work_flow", $tableData, "`work_flow_id` = '".$_POST["work_flow_id"]."'");
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["returnStatus"] = $returnStatus;
                            $data["responseMessage"] = "Status Changed successfully!!!";
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            case "changeOrgStatusWork":
                if($authority == 1):
                    if(isset($_POST["work_flow_id"]) && !empty($_POST["work_flow_id"] && $_POST["work_type_id"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["work_flow_id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log = json_decode($rows["work_flow_log"]);
                                $work_flow_works = json_decode($rows["work_flow_works"]);
                                $work_flow_info = json_decode($rows["work_flow_info"]);
                            endforeach;
                        endif;

                        foreach($work_flow_works as $work_flow_works_all):
                            if(intval($work_flow_works_all->work_type_id) == intval($_POST["work_type_id"])):
                                if($_POST["status"] == "active"):
                                    $delete_log = array(
                                                            "action"                =>      "Work Status Closed",
                                                            "by"                    =>      $auth->admin_id,
                                                            "ip"                    =>      $_POST["checkIp"],
                                                            "location"              =>      $_POST["checkLocation"],
                                                            "at"                    =>      date("H:i:s A"),
                                                            "date"                  =>      date("d-m-Y")
                                                    );
                                    array_push($data_log, $delete_log);
                                    $work_flow_works_all->ending_date = date("Y-m-d");
                                    $work_flow_works_all->ending_time = date("H:i");
                                    $returnStatus = date("d M, Y")." / ".date("h:i A");
                                else:
                                    $delete_log = array(
                                                            "action"                =>      "Work Status Opened",
                                                            "by"                    =>      $auth->admin_id,
                                                            "ip"                    =>      $_POST["checkIp"],
                                                            "location"              =>      $_POST["checkLocation"],
                                                            "at"                    =>      date("H:i:s A"),
                                                            "date"                  =>      date("d-m-Y")
                                                    );
                                    array_push($data_log, $delete_log);
                                    $work_flow_works_all->ending_date = "";
                                    $work_flow_works_all->ending_time = "";
                                    $returnStatus = "Not End";
                                endif;
                                break;
                            endif;
                        endforeach;
                        $tableData["work_flow_log"] = json_encode($data_log);
                        $tableData["work_flow_info"] = json_encode($work_flow_info);
                        $tableData["work_flow_works"] = json_encode($work_flow_works);
                        $check = $databaseObj->update("tbl_work_flow", $tableData, "`work_flow_id` = '".$_POST["work_flow_id"]."'");
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["returnStatus"] = $returnStatus;
                            $data["responseMessage"] = "Status Changed successfully!!!";
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            // -----------------------------------------------------------
            // ------------ Opened/Closed Status Section End -------------
            // -----------------------------------------------------------
            // --------------------------------------------------
            // ------------ Import Data Section Start -----------
            // --------------------------------------------------
            case "importData":
                if($authority == 1):
                    if(!empty($_FILES["importedExcel"]["name"])):
                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $work_flowDir.$randSix."_".$_FILES["importedExcel"]["name"])):
                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];
                            $file_type	= PHPExcel_IOFactory::identify($work_flowDir.$fileName);
                            $objReader	= PHPExcel_IOFactory::createReader($file_type);
                            $objPHPExcel = $objReader->load($work_flowDir.$fileName);
                            $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            $sno = 0;
                            foreach ($sheet_data as $row):   
                                if(!empty($row["A"])):
                                    $data_info = array(
                                                            "work_flow"          =>      htmlspecialchars($row["A"], ENT_QUOTES)
                                                    );
                                    $data_log = array(
                                                        array(
                                                                "action"                =>      "imported",
                                                                "by"                    =>      $auth->admin_id,
                                                                "ip"                    =>      $_POST["checkIp"],
                                                                "location"              =>      $_POST["checkLocation"],
                                                                "at"                    =>      date("H:i:s A"),
                                                                "date"                  =>      date("d-m-Y")
                                                        )
                                                    );
                                    $tableData["work_flow_info"] = json_encode($data_info);
                                    $tableData["work_flow_log"] = json_encode($data_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->insert("tbl_work_flow", $tableData);
                                    if($check == 1):
                                        unset($tableData["work_flow_info"]); 
                                        unset($tableData["work_flow_log"]); 
                                        unset($tableData["status"]);
                                        $databaseObj->sql = "";
                                        $databaseObj->data = array();
                                        $databaseObj->dataVal = "";
                                        $sno++;
                                    endif;
                                endif;
                            endforeach;
                            if($sno > 0):
                                unlink($work_flowDir.$fileName);
                                $data["response"] = "success";
                                $data["responseType"] = "success";
                                $data["responseMessage"] = "$sno data Imported successfully!!!";
                            else:
                                $data["response"] = "error";
                                $data["responseType"] = "error";
                                $data["responseMessage"] = "Something went wrong please try again!!!";
                            endif;
                        else:
                            $data["response"] = "excelNotStored";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Please select an Excel File!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            // --------------------------------------------------
            // ------------ Import Data Section End -------------
            // --------------------------------------------------
            // -----------------------------------------------
            // ------------ Edit Data Section Start ----------
            // -----------------------------------------------
            case "editData":
                if($authority == 1):
                    if(!empty($_POST["editTableId"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_info = json_decode($rows["work_flow_info"]);
                                $data_log = json_decode($rows["work_flow_log"]);
                            endforeach;
                            if(!empty($_POST["edit_main_work_type_starting_date"] && $_POST["edit_main_work_type_starting_time"] && $_POST["edit_main_work_type_expected_ending_date"] && $_POST["edit_main_work_type_expected_ending_time"])):
                                $data_info->main_work_type = $_POST["edit_main_work_type"];
                                $data_info->starting_date = $_POST["edit_main_work_type_starting_date"];
                                $data_info->starting_time = $_POST["edit_main_work_type_starting_time"];
                                $data_info->expected_ending_date = $_POST["edit_main_work_type_expected_ending_date"];
                                $data_info->expected_ending_time = $_POST["edit_main_work_type_expected_ending_time"];
                                 
                                 $edit_log = array(
                                                    "action"                =>      "edited",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                                array_push($data_log, $edit_log);
                                $tableData["work_flow_info"] = json_encode($data_info);
                                $tableData["work_flow_log"] = json_encode($data_log);
                                $tableData["status"] = $auth->visible();
                                $check = $databaseObj->update("tbl_work_flow", $tableData, "`work_flow_id` = '".$_POST["editTableId"]."'");
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
            case "editWorkData":
                if($authority == 1):
                    if(!empty($_POST["editTableId"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_info = json_decode($rows["work_flow_info"]);
                                $work_flow_works = json_decode($rows["work_flow_works"]);
                                $data_log = json_decode($rows["work_flow_log"]);
                            endforeach;
                            if(!empty($_POST["edit_work_type_starting_date"] && $_POST["edit_work_type_starting_time"] && $_POST["edit_work_type_expected_ending_date"] && $_POST["edit_work_type_expected_ending_time"])):
                                foreach($work_flow_works as $work_flow_works_all):
                                    if(intval($work_flow_works_all->work_type_id) == intval($_POST["work_type_id"])):
                                        $itemArray = array();
                                        for($i = 0; $i < count($_POST["editItemInfoItemType"]); $i++):
                                            $tempItemArray = "";
                                            $tempItemArray = array(
                                                                "item_type"         =>      htmlspecialchars($_POST["editItemInfoItemType"][$i], ENT_QUOTES),
                                                                "unit_type"         =>      htmlspecialchars($_POST["editItemInfoUnitType"][$i], ENT_QUOTES),
                                                                "quantity"          =>      htmlspecialchars($_POST["editItemInfoQuantity"][$i], ENT_QUOTES),
                                                                "rate"              =>      htmlspecialchars($_POST["editItemInfoRate"][$i], ENT_QUOTES),
                                                                "amount"            =>      htmlspecialchars($_POST["editItemInfoAmount"][$i], ENT_QUOTES),
                                                                "a"                 =>      htmlspecialchars($_POST["editItemInfoMaterial"][$i], ENT_QUOTES),
                                                                "b"                 =>      htmlspecialchars($_POST["editItemInfoLabour"][$i], ENT_QUOTES),
                                                                "remarks"           =>      htmlspecialchars($_POST["editItemInfoRemarks"][$i], ENT_QUOTES)
                                                            );
                                            array_push($itemArray, $tempItemArray);
                                        endfor;
                                        $work_flow_works_all->work_type = $_POST["edit_work_type"];
                                        $work_flow_works_all->starting_date = $_POST["edit_work_type_starting_date"];
                                        $work_flow_works_all->starting_time = $_POST["edit_work_type_starting_time"];
                                        $work_flow_works_all->expected_ending_date = $_POST["edit_work_type_expected_ending_date"];
                                        $work_flow_works_all->expected_ending_time = $_POST["edit_work_type_expected_ending_time"];
                                        $work_flow_works_all->items = $itemArray;
                                        break;
                                    endif;
                                endforeach;
                                $edit_log = array(
                                                    "action"                =>      "edited",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                                array_push($data_log, $edit_log);
                                $tableData["work_flow_info"] = json_encode($data_info);
                                $tableData["work_flow_log"] = json_encode($data_log);
                                $tableData["work_flow_works"] = json_encode($work_flow_works);
                                $tableData["status"] = $auth->visible();
                                $check = $databaseObj->update("tbl_work_flow", $tableData, "`work_flow_id` = '".$_POST["editTableId"]."'");
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
            // ------------ Delete Data Section Start -----------
            // --------------------------------------------------
            case "deleteData":
                if($authority == 1):
                    if(!empty($_POST["tableName"] && $_POST["tableId"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log = json_decode($rows["work_flow_log"]);
                            endforeach;
                        endif;
                        $delete_log = array(
                                                "action"                =>      "deleted",
                                                "by"                    =>      $auth->admin_id,
                                                "ip"                    =>      $_POST["checkIp"],
                                                "location"              =>      $_POST["checkLocation"],
                                                "at"                    =>      date("H:i:s A"),
                                                "date"                  =>      date("d-m-Y")
                                        );
                        array_push($data_log, $delete_log);
                        $tableData["work_flow_log"] = json_encode($data_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`work_flow_id` = '".$_POST["tableId"]."'");
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Data deleted successfully!!!";
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            case "deleteWorkData":
                if($authority == 1):
                    if(!empty($_POST["tableName"] && $_POST["work_flow_id"] && $_POST["work_type_id"])):
                        $databaseObj->select("tbl_work_flow");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$_POST["work_flow_id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log = json_decode($rows["work_flow_log"]);
                                $work_flow_works = json_decode($rows["work_flow_works"]);
                            endforeach;
                        endif;
                        $work_flow_works_updated = array();
                        foreach($work_flow_works as $work_flow_works_all):
                            if(intval($work_flow_works_all->work_type_id) == intval($_POST["work_type_id"])):
                                continue;
                            endif;
                            array_push($work_flow_works_updated, $work_flow_works_all);
                        endforeach;
                        $delete_log = array(
                                                "action"                =>      "item Deleted",
                                                "by"                    =>      $auth->admin_id,
                                                "ip"                    =>      $_POST["checkIp"],
                                                "location"              =>      $_POST["checkLocation"],
                                                "at"                    =>      date("H:i:s A"),
                                                "date"                  =>      date("d-m-Y")
                                        );
                        array_push($data_log, $delete_log);
                        if(count($work_flow_works_updated) < 1):
                            $tableData["work_flow_works"] = "[]";
                        else:
                            $tableData["work_flow_works"] = json_encode($work_flow_works_updated);
                        endif;
                        $tableData["work_flow_log"] = json_encode($data_log);
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`work_flow_id` = '".$_POST["work_flow_id"]."'");
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Data deleted successfully!!!";
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            // --------------------------------------------------
            // ------------ Delete Data Section End -------------
            // --------------------------------------------------
            // -----------------------------------------------------------
            // ------------ Export Selected Data Section Start -----------
            // -----------------------------------------------------------
            case "exportData":
                if($authority == 1):
                    if(!empty($_POST["nameOfATable"])):
                        if(count($_POST["checkbox-select"]) > 0):
                            $sno = 0;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_work_flow");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $data_log = json_decode($rows["work_flow_log"]);
                                    endforeach;
                                endif;
                                $export_log = array(
                                                        "action"                =>      "exported",
                                                        "by"                    =>      $auth->admin_id,
                                                        "ip"                    =>      $_POST["checkIp"],
                                                        "location"              =>      $_POST["checkLocation"],
                                                        "at"                    =>      date("H:i:s A"),
                                                        "date"                  =>      date("d-m-Y")
                                                );
                                array_push($data_log, $export_log);
                                $tableData["work_flow_log"] = json_encode($data_log);
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`work_flow_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["work_flow_log"]); 
                                    unset($tableData["status"]);
                                    $databaseObj->sql = "";
                                    $databaseObj->data = array();
                                    $databaseObj->dataVal = "";
                                    $sno++;
                                endif;
                            endforeach;
                            if($sno > 0):
                                $data["response"] = "success";
                                $data["responseType"] = "success";
                                $data["responseMessage"] = "$sno data Exported successfully!!!";
                            else:
                                $data["response"] = "error";
                                $data["responseType"] = "error";
                                $data["responseMessage"] = "Something went wrong please try again!!!";
                            endif;
                        else:
                            $data["response"] = "noSelection";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Please select atleast one data!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            case "exportSelectedData":
                if($authority == 1):
                    if(!empty($_POST["nameOfATable"])):
                        if(count($_POST["checkbox-select"]) > 0):
                            //--------------------------------------------------------------------------------------------------
                            //------------------------------------- Excel Inner Section Start ----------------------------------
                            //--------------------------------------------------------------------------------------------------
                            //Set Filename
                            $fileName = "Building-".date("d-m-Y").".xlsx";
                            //Set BackGround
                            function cellColor($cells, $color){
                                global $objPHPExcel;
                                $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'startcolor' => array(
                                         'rgb' => $color
                                    )
                                ));
                            }
                            //Set Color
                            function fontColor($cells, $color, $size, $style, $bold){
                                global $objPHPExcel;
                                $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
                                    'font'  => array(
                                        'bold'  => $bold,
                                        'color' => array('rgb' => $color),
                                        'size'  => $size,
                                        'name'  => $style
                                    )
                                ));
                            }
                            //Thin Border
                            $thinBorder = array(
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                        'color' => array('rgb' => '001F3F')
                                    )
                                )
                            );
                            //Thick Border
                            $thickBorder = array(
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THICK,
                                        'color' => array('rgb' => '001F3F')
                                    )
                                )
                            );
                            // Set document properties
                            $objPHPExcel->getProperties()->setCreator("IREMS")
                                                         ->setLastModifiedBy("IREMS")
                                                         ->setTitle("")
                                                         ->setSubject("Building")
                                                         ->setDescription("Building $fileName.")
                                                         ->setKeywords("$fileName")
                                                         ->setCategory("$fileName");
                            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);	
                            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);		
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Building");
                            cellColor('B2', '001F3F');
                            fontColor('B2', 'FFFFFF', '18', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($thinBorder);

                            //Setting Header --------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "S. No.");
                            fontColor('B4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Building");
                            fontColor('C4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
                            $inc = 5;
                            $sno = 1;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_work_flow");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $data_info = json_decode($rows["work_flow_info"]);
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section Start ----------------------
                                        //-----------------------------------------------------------------
                                        $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('B'.$inc, $sno)
                                            ->setCellValue('C'.$inc, $data_info->work_flow);
                                        fontColor('C'.$inc, '000000', '12', '', true);
                                        $objPHPExcel->getActiveSheet()->getStyle('B'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('C'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $inc++;
                                        $sno++;
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section End ------------------------
                                        //-----------------------------------------------------------------
                                    endforeach;
                                endif;
                            endforeach;
                            // ----------------------------------------------------------------
                            $objPHPExcel->getActiveSheet()->getStyle('B5:C'.--$inc)->applyFromArray($thinBorder);
                            $objPHPExcel->setActiveSheetIndex(0);
                            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                            $objPHPExcel->setActiveSheetIndex(0);
                            // Redirect output to a client’s web browser (Excel2007)
                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment;filename="'.$fileName.'"');
                            header('Cache-Control: max-age=0');
                            // If you're serving to IE 9, then the following may be needed
                            header('Cache-Control: max-age=1');
                            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                            $objWriter->save('php://output');
                            exit;
                            //--------------------------------------------------------------------------------------------------
                            //------------------------------------- Excel Inner Section End ------------------------------------
                            //--------------------------------------------------------------------------------------------------
                        else:
                            $data["response"] = "noSelection";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Please select atleast one data!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            // -----------------------------------------------------------
            // ------------ Export Selected Data Section End -------------
            // -----------------------------------------------------------
            // -----------------------------------------------------------
            // ------------ Delete Selected Data Section Start -----------
            // -----------------------------------------------------------
            case "deleteSelectedData":
                if($authority == 1):
                    if(!empty($_POST["nameOfATable"])):
                        if(count($_POST["checkbox-select"]) > 0):
                            $sno = 0;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_work_flow");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `work_flow_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $data_log = json_decode($rows["work_flow_log"]);
                                    endforeach;
                                endif;
                                $delete_log = array(
                                                        "action"                =>      "deleted",
                                                        "by"                    =>      $auth->admin_id,
                                                        "ip"                    =>      $_POST["checkIp"],
                                                        "location"              =>      $_POST["checkLocation"],
                                                        "at"                    =>      date("H:i:s A"),
                                                        "date"                  =>      date("d-m-Y")
                                                );
                                array_push($data_log, $delete_log);
                                $tableData["work_flow_log"] = json_encode($data_log);
                                $tableData["status"] = $auth->trash();
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`work_flow_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["work_flow_log"]); 
                                    unset($tableData["status"]);
                                    $databaseObj->sql = "";
                                    $databaseObj->data = array();
                                    $databaseObj->dataVal = "";
                                    $sno++;
                                endif;
                            endforeach;
                            if($sno != 0):
                                $data["response"] = "success";
                                $data["responseType"] = "success";
                                $data["responseMessage"] = "$sno data deleted successfully!!!";
                            else:
                                $data["response"] = "error";
                                $data["responseType"] = "error";
                                $data["responseMessage"] = "Something went wrong please try again!!!";
                            endif;
                        else:
                            $data["response"] = "noSelection";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Please select atleast one data!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                    endif;
                else:
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            // -----------------------------------------------------------
            // ------------ Delete Selected Data Section End -------------
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