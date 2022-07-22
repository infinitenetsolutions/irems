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
    $projectsDir = "../../../assets/admin/projects/";
  
    if(isset($_POST["action"])):
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Add Data Section Start -----------
            // -----------------------------------------------
            case "addData":
                if($authority == 1):
                    if(!empty($_POST["firmName"] && $_POST["projectName"] && $_POST["projectLocation"] && $_POST["projectStartingDate"] && $_POST["projectExpectedEndingDate"])):
                        $flag = 1;
                        $errorMessage = "Please fill out the required fields";
                        // $property_details = array();
                        // for($i = 1; $i <= count($_POST["floor"]); $i++):
                        //     $index = ($i - 1);
                        //     $floorArray = array();
                        //     for($x = 1; $x <= intval($_POST["floor"][$index]); $x++):
                        //         $index_floor = ($x - 1);
                        //         $flatArray = array();
                        //         for($y = 0; $y < count($_POST["flat_no_". $i ."_". $x]); $y++):
                        //             array_push($flatArray,   array(
                        //                                         "flat_no"                   =>      $_POST["flat_no_". $i ."_". $x][$y],
                        //                                         "property_type"             =>      $_POST["property_type_". $i ."_". $x][$y],
                        //                                         "accommodation_type"        =>      $_POST["accommodation_type_". $i ."_". $x][$y],
                        //                                         "square_feet"               =>      $_POST["square_feet_". $i ."_". $x][$y],
                        //                                         "price_per_square"          =>      $_POST["price_per_square_". $i ."_". $x][$y],
                        //                                         "price_total"               =>      $_POST["price_total_". $i ."_". $x][$y],
                        //                                         "carpet_area"               =>      $_POST["carpet_area_". $i ."_". $x][$y],
                        //                                         "starting_date"             =>      $_POST["starting_date_". $i ."_". $x][$y],
                        //                                         "expected_ending_date"      =>      $_POST["expected_ending_date_". $i ."_". $x][$y],
                        //                                         "ending_date"               =>      $_POST["ending_date_". $i ."_". $x][$y],
                        //                                         "percent_completed"         =>      $_POST["percent_completed_". $i ."_". $x][$y],
                        //                                         "customer_details"          =>      array(
                        //                                                                                 "customer_id"       =>      ""
                        //                                                                             ),
                        //                                         "status"                    =>      "" #reserved or blank
                        //                                     )
                        //             );
                        //         endfor;
                        //         array_push($floorArray, $flatArray);
                        //     endfor;
                        //     array_push($property_details,   array(
                        //                                         "phase"         =>      $_POST["phase"][$index],
                        //                                         "building"      =>      $_POST["building"][$index],
                        //                                         "total_floors"  =>      $_POST["floor"][$index],
                        //                                         "floors"        =>      $floorArray
                        //                                     )
                        //     );
                        // endfor;
                        if(!empty($_POST["projectLocationMapUrl"])):
                            if(!filter_var($_POST["projectLocationMapUrl"], FILTER_VALIDATE_URL)):
                                $flag = 0;
                                $errorMessage = "Please give currect URL for Map!!!";
                            else:
                                $projectLocationMapUrl = $_POST["projectLocationMapUrl"];
                            endif;
                        else:
                            $projectLocationMapUrl = "";
                        endif;
                        if($flag == 1):
                            $data_info = array(          
                                                        "firmName"                      =>      htmlspecialchars($_POST["firmName"], ENT_QUOTES),
                                                        "projectName"                   =>      htmlspecialchars($_POST["projectName"], ENT_QUOTES),
                                                        "projectLocation"               =>      htmlspecialchars($_POST["projectLocation"], ENT_QUOTES),
                                                        "projectLocationMapUrl"         =>      htmlspecialchars($_POST["projectLocationMapUrl"], ENT_QUOTES),
                                                        "projectStartingDate"           =>      htmlspecialchars($_POST["projectStartingDate"], ENT_QUOTES),
                                                        "projectExpectedEndingDate"     =>      htmlspecialchars($_POST["projectExpectedEndingDate"], ENT_QUOTES),
                                                        "projectEndingDate"             =>      htmlspecialchars($_POST["projectEndingDate"], ENT_QUOTES),
                                                        "projectstatus"                =>      htmlspecialchars($_POST["projectstatus"], ENT_QUOTES),
                                            );
                            $data_log = array(
                                                array(
                                                        "action"                        =>      "added",
                                                        "by"                            =>      $auth->admin_id,
                                                        "ip"                            =>      $_POST["checkIp"],
                                                        "location"                      =>      $_POST["checkLocation"],
                                                        "at"                            =>      date("H:i:s A"),
                                                        "date"                          =>      date("d-m-Y")
                                                )
                                            );
                            $tableData["projects_info"] = json_encode($data_info);
                            $tableData["projects_log"] = json_encode($data_log);
                            $tableData["status"] = $auth->visible();
                            $check = $databaseObj->insert("tbl_projects", $tableData);
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
                            $data["responseMessage"] = $errorMessage;
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
            case "addPropertiesData":
               
                if($authority == 1):
                    if(!empty($_POST["phase"] && $_POST["building"] && $_POST["floor"]) && isset($_POST["properties_project_id"])):
                        $flag = 1;
                        $errorMessage = "Please fill out the required fields";
                        $property_details = array();
                        $floorArray = array();
                        for($i = 1; $i <= intval($_POST["floor"]); $i++):
                            $index = ($i - 1);
                            $flatArray = array();
                            for($y = 0; $y < count($_POST["flat_no_". $i]); $y++):
                                array_push($flatArray,   array(
                                                            "flat_no"                   =>      $_POST["flat_no_". $i][$y],
                                                            "property_type"             =>      $_POST["property_type_". $i][$y],
                                                            "accommodation_type"        =>      $_POST["accommodation_type_". $i][$y],
                                                            "square_feet"               =>      $_POST["square_feet_". $i][$y],
                                                            "price_per_square"          =>      $_POST["price_per_square_". $i][$y],
                                                            "price_total"               =>      $_POST["price_total_". $i][$y],
                                                            "carpet_area"               =>      $_POST["carpet_area_". $i][$y],
                                                            "starting_date"             =>      $_POST["starting_date_". $i][$y],
                                                            "expected_ending_date"      =>      $_POST["expected_ending_date_". $i][$y],
                                                            "ending_date"               =>      $_POST["ending_date_". $i][$y],
                                                            "percent_completed"         =>      $_POST["percent_completed_". $i][$y],
                                                            "customer_details"          =>      array(
                                                                                                    "customer_id"       =>      ""
                                                                                                ),
                                                            "status"                    =>      "" #reserved or blank
                                                        )
                                );
                            endfor;
                            array_push($floorArray, $flatArray);
                        endfor;
                        $property_details   =   array(
                                                        "phase"         =>      $_POST["phase"],
                                                        "building"      =>      $_POST["building"],
                                                        "total_floors"  =>      $_POST["floor"],
                                                        "floors"        =>      $floorArray
                                                    );
                        if($flag == 1):
                            $data_info = $property_details;
                            $data_log = array(
                                                array(
                                                        "action"                        =>      "Property Added",
                                                        "by"                            =>      $auth->admin_id,
                                                        "ip"                            =>      $_POST["checkIp"],
                                                        "location"                      =>      $_POST["checkLocation"],
                                                        "at"                            =>      date("H:i:s A"),
                                                        "date"                          =>      date("d-m-Y")
                                                )
                                            );
                            $tableData["projects_id"] = $_POST["properties_project_id"];
                            $tableData["properties_info"] = json_encode($data_info);
                            $tableData["properties_log"] = json_encode($data_log);
                            $tableData["status"] = $auth->visible();
                            $check = $databaseObj->insert("tbl_properties", $tableData);
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
                            $data["responseMessage"] = $errorMessage;
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
            // -----------------------------------------------
            // ------------ Edit Data Section Start ----------
            // -----------------------------------------------
            case "editPropertiesData":
               
                if($authority == 1):
                    
                    if(!empty($_POST["edit_phase"] && $_POST["edit_building"] && $_POST["edit_floor"])):
                         
                        $flag = 1;
                        $errorMessage = "Please fill out the required fields";
                        $property_details = array();
                        $floorArray = array();
                        for($i = 1; $i <= intval($_POST["edit_floor"]); $i++):
                            $index = ($i - 1);
                            $flatArray = array();

                            for($y = 0; $y < count($_POST["edit_flat_no_".$i]); $y++):
                                array_push($flatArray,   array(
                                                            "flat_no"                   =>      $_POST["edit_flat_no_". $i][$y],
                                                            "property_type"             =>      $_POST["edit_property_type_". $i][$y],
                                                            "accommodation_type"        =>      $_POST["edit_accommodation_type_". $i][$y],
                                                            "square_feet"               =>      $_POST["edit_square_feet_". $i][$y],
                                                            "price_per_square"          =>      $_POST["edit_price_per_square_". $i][$y],
                                                            "price_total"               =>      $_POST["edit_price_total_". $i][$y],
                                                            "carpet_area"               =>      $_POST["edit_carpet_area_". $i][$y],
                                                            "starting_date"             =>      $_POST["edit_starting_date_". $i][$y],
                                                            "expected_ending_date"      =>      $_POST["edit_expected_ending_date_". $i][$y],
                                                            "ending_date"               =>      $_POST["edit_ending_date_". $i][$y],
                                                            "percent_completed"         =>      $_POST["edit_percent_completed_". $i][$y],
                                                            "customer_details"          =>      array(
                                                                                                    "customer_id"       =>      $_POST["edit_customer_id_". $i][$y]
                                                                                                ),
                                                            "status"                    =>      "" #reserved or blank
                                                        )
                                );
                            endfor;
                            array_push($floorArray, $flatArray);
                        endfor;
                        if($flag == 1):
                            $databaseObj->select("tbl_properties");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `properties_id` = '".$_POST["editTableId"]."'");
                            $getData = $databaseObj->get();
                            //Checking If Data Is Available
                            if(count($getData) != 0):
                                $sno = 1;
                                foreach($getData as $rows):
                                    $data_info = json_decode($rows["properties_info"]);
                                    $data_log = json_decode($rows["properties_log"]);
                                endforeach;
                                if(!empty($_POST["editTableId"])):
                                    $data_info->phase = htmlspecialchars($_POST["edit_phase"], ENT_QUOTES);
                                    $data_info->building = htmlspecialchars($_POST["edit_building"], ENT_QUOTES);
                                    $data_info->total_floors = htmlspecialchars($_POST["edit_floor"], ENT_QUOTES);
                                    $data_info->floors = $floorArray;
                                    $edit_log = array(
                                                        "action"                        =>      "Property Edited",
                                                        "by"                            =>      $auth->admin_id,
                                                        "ip"                            =>      $_POST["checkIp"],
                                                        "location"                      =>      $_POST["checkLocation"],
                                                        "at"                            =>      date("H:i:s A"),
                                                        "date"                          =>      date("d-m-Y")
                                                );
                                    array_push($data_log, $edit_log);
                                    $tableData["properties_info"] = json_encode($data_info);
                                    $tableData["properties_log"] = json_encode($data_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->update("tbl_properties", $tableData, "`properties_id` = '".$_POST["editTableId"]."'");
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
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = $errorMessage;
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
            // ------------ Import Data Section Start -----------
            // --------------------------------------------------
            case "importData":
                if($authority == 1):
                    if(!empty($_FILES["importedExcel"]["name"])):
                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $projectsDir.$randSix."_".$_FILES["importedExcel"]["name"])):
                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];
                            $file_type  = PHPExcel_IOFactory::identify($projectsDir.$fileName);
                            $objReader  = PHPExcel_IOFactory::createReader($file_type);
                            $objPHPExcel = $objReader->load($projectsDir.$fileName);
                            $sheet_data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            $sno = 0;
                            foreach ($sheet_data as $row):   
                                if(!empty($row["A"])):
                                    
                                    $data_info = array(
                                                            "projectName"               =>      htmlspecialchars($row["A"], ENT_QUOTES),
                                                            "projectLocation"           =>      htmlspecialchars($row["B"], ENT_QUOTES),
                                                            "properties"                =>      $properties
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
                                    $tableData["projects_info"] = json_encode($data_info);
                                    $tableData["projects_log"] = json_encode($data_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->insert("tbl_projects", $tableData);
                                    if($check == 1):
                                        unset($tableData["projects_info"]); 
                                        unset($tableData["projects_log"]); 
                                        unset($tableData["status"]);
                                        $databaseObj->sql = "";
                                        $databaseObj->data = array();
                                        $databaseObj->dataVal = "";
                                        $sno++;
                                    endif;
                                endif;
                            endforeach;
                            if($sno > 0):
                                unlink($projectsDir.$fileName);
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
                    if(!empty($_POST["editTableId"] && $_POST["editFirmName"] && $_POST["editProjectName"] && $_POST["editProjectLocation"] && $_POST["editProjectStartingDate"] && $_POST["editProjectExpectedEndingDate"] && $_POST["editProjectstatus"])):
                        $flag = 1;
                        $errorMessage = "Please fill out the required fields";
                        if(!empty($_POST["editProjectLocationMapUrl"])):
                            if(!filter_var($_POST["editProjectLocationMapUrl"], FILTER_VALIDATE_URL)):
                                $flag = 0;
                                $errorMessage = "Please give currect URL for Map!!!";
                            else:
                                $projectLocationMapUrl = $_POST["editProjectLocationMapUrl"];
                            endif;
                        else:
                            $projectLocationMapUrl = "";
                        endif;
                        if($flag == 1):
                            $databaseObj->select("tbl_projects");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["editTableId"]."'");
                            $getData = $databaseObj->get();
                            //Checking If Data Is Available
                            if(count($getData) != 0):
                                $sno = 1;
                                foreach($getData as $rows):
                                    $data_info = json_decode($rows["projects_info"]);
                                    $data_log = json_decode($rows["projects_log"]);
                                endforeach;
                                if(!empty($_POST["editProjectName"] )):
                                    $data_info->firmName = htmlspecialchars($_POST["editFirmName"], ENT_QUOTES);
                                    $data_info->projectName = htmlspecialchars($_POST["editProjectName"], ENT_QUOTES);
                                    $data_info->projectLocation = htmlspecialchars($_POST["editProjectLocation"], ENT_QUOTES);
                                    $data_info->projectLocationMapUrl = htmlspecialchars($_POST["editProjectLocationMapUrl"], ENT_QUOTES);
                                    $data_info->projectStartingDate = htmlspecialchars($_POST["editProjectStartingDate"], ENT_QUOTES);
                                    $data_info->projectExpectedEndingDate = htmlspecialchars($_POST["editProjectExpectedEndingDate"], ENT_QUOTES);
                                    $data_info->projectEndingDate = htmlspecialchars($_POST["editProjectEndingDate"], ENT_QUOTES);
                                    $data_info->projectstatus = htmlspecialchars($_POST["editProjectstatus"], ENT_QUOTES);
                                    $edit_log = array(
                                                        "action"                        =>      "edited",
                                                        "by"                            =>      $auth->admin_id,
                                                        "ip"                            =>      $_POST["checkIp"],
                                                        "location"                      =>      $_POST["checkLocation"],
                                                        "at"                            =>      date("H:i:s A"),
                                                        "date"                          =>      date("d-m-Y")
                                                );
                                    array_push($data_log, $edit_log);
                                    $tableData["projects_info"] = json_encode($data_info);
                                    $tableData["projects_log"] = json_encode($data_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->update("tbl_projects", $tableData, "`projects_id` = '".$_POST["editTableId"]."'");
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
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = $errorMessage;
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
                        $databaseObj->select("tbl_projects");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log = json_decode($rows["projects_log"]);
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
                        $tableData["projects_log"] = json_encode($data_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`projects_id` = '".$_POST["tableId"]."'");
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
            case "deletePropertiesData":
                if($authority == 1):
                    if(!empty($_POST["tableName"] && $_POST["tableId"])):
                        $databaseObj->select("tbl_properties");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `properties_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log = json_decode($rows["properties_log"]);
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
                        $tableData["properties_log"] = json_encode($data_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`properties_id` = '".$_POST["tableId"]."'");
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
                        if(isset($_POST["checkbox-select"]) && count($_POST["checkbox-select"]) > 0):
                            $sno = 0;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_projects");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $data_log = json_decode($rows["projects_log"]);
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
                                $tableData["projects_log"] = json_encode($data_log);
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`projects_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["projects_log"]); 
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
                        if(isset($_POST["checkbox-select"]) && count($_POST["checkbox-select"]) > 0):
                            //--------------------------------------------------------------------------------------------------
                            //------------------------------------- Excel Inner Section Start ----------------------------------
                            //--------------------------------------------------------------------------------------------------
                            //Set Filename
                            $fileName = "Projects-".date("d-m-Y").".xlsx";
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
                                                         ->setTitle("Projects")
                                                         ->setSubject("Projects")
                                                         ->setDescription("Projects $fileName.")
                                                         ->setKeywords("$fileName")
                                                         ->setCategory("$fileName");
                            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
                            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);     
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:Q2');
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Project Details");
                            cellColor('B2', '001F3F');
                            fontColor('B2', 'FFFFFF', '18', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:Q2')->applyFromArray($thinBorder);
                            //Setting Header --------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "S. No.");
                            fontColor('B4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Project Name");
                            fontColor('C4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Project Location");
                            fontColor('D4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Project Location Map URL");
                            fontColor('E4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Project Starting Date");
                            fontColor('F4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Project Expected Ending Date");
                            fontColor('G4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Project Ending Date");
                            fontColor('H4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "S. No");
                            fontColor('I4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Property Type ");
                            fontColor('J4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Accommodation Type");
                            fontColor('K4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Square Feet");
                            fontColor('L4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Price");
                            fontColor('M4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('M4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4', "Availability");
                            fontColor('N4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('N4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4', "Starting Date");
                            fontColor('O4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4', "Expected Ending Date");
                            fontColor('P4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('P4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4', "Ending Date");
                            fontColor('Q4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('Q4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4', "Project Percent completion");
                            fontColor('R4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('R4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('R4')->applyFromArray($thinBorder);

                            $inc = 5;
                            $sno = 1;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_projects");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $data_info = json_decode($rows["projects_info"]);
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section Start ----------------------
                                        //-----------------------------------------------------------------
                                        if(!empty($data_info->projectStartingDate)):
                                            $projectStartingDate = date("d-m-Y", strtotime($data_info->projectStartingDate));
                                        else:
                                            $projectStartingDate = "";
                                        endif;
                                        if(!empty($data_info->projectExpectedEndingDate)):
                                            $projectExpectedEndingDate = date("d-m-Y", strtotime($data_info->projectExpectedEndingDate));
                                        else:
                                            $projectExpectedEndingDate = "";
                                        endif;
                                        if(!empty($data_info->projectEndingDate)):
                                            $projectEndingDate = date("d-m-Y", strtotime($data_info->projectEndingDate));
                                        else:
                                            $projectEndingDate = "";
                                        endif;
                                       if(!empty($data_info->projectEndingDate)):
                                            $projectEndingDate = date("d-m-Y", strtotime($data_info->projectEndingDate));
                                        else:
                                            $projectEndingDate = "";
                                        endif;
                                        $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('B'.$inc, $sno)
                                            ->setCellValue('C'.$inc, $data_info->projectName)
                                            ->setCellValue('D'.$inc, $data_info->projectLocation)
                                            ->setCellValue('E'.$inc, $data_info->projectLocationMapUrl)
                                            ->setCellValue('F'.$inc, $projectStartingDate)
                                            ->setCellValue('G'.$inc, $projectExpectedEndingDate)
                                            ->setCellValue('H'.$inc, $projectEndingDate);
                                        $noOfProperties = $inc;
                                        $snoProp = 1;
                                        foreach($data_info->properties as $properties):
                                            $databaseObj->select("tbl_property_type");
                                            $databaseObj->where("`status` = '".$auth->visible()."' && `property_type_id` = '".$properties->propertyType."'");
                                            $getData = $databaseObj->get();
                                            if($getData != 0):
                                                foreach($getData as $rows_prop):
                                                    $property_type_info = json_decode($rows_prop["property_type_info"]);
                                                endforeach;
                                            endif;
                                            $databaseObj->select("tbl_accommodation_type");
                                            $databaseObj->where("`status` = '".$auth->visible()."' && `accommodation_type_id` = '".$properties->accommodationType."'");
                                            $getData = $databaseObj->get();
                                            if($getData != 0):
                                                foreach($getData as $rows_acco):
                                                    $accommodation_type_info = json_decode($rows_acco["accommodation_type_info"]);
                                                endforeach;
                                            endif;
                                            if(!empty($properties->StartingDate)):
                                                $StartingDate = date("d-m-Y", strtotime($properties->StartingDate));
                                            else:
                                                $StartingDate = "";
                                            endif;
                                            if(!empty($properties->ExpectedEndingDate)):
                                                $ExpectedEndingDate = date("d-m-Y", strtotime($properties->ExpectedEndingDate));
                                            else:
                                                $ExpectedEndingDate = "";
                                            endif;
                                            if(!empty($properties->EndingDate)):
                                                $EndingDate = date("d-m-Y", strtotime($properties->EndingDate));
                                            else:
                                                $EndingDate = "";
                                            endif;
                                            $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue('I'.$noOfProperties, $snoProp)
                                                ->setCellValue('J'.$noOfProperties, $property_type_info->propertyType)
                                                ->setCellValue('K'.$noOfProperties, $accommodation_type_info->accommodationType)
                                                ->setCellValue('L'.$noOfProperties, $properties->squareFeet)
                                                ->setCellValue('M'.$noOfProperties, $properties->price)
                                                ->setCellValue('N'.$noOfProperties, $properties->availablility)
                                                ->setCellValue('O'.$noOfProperties, $StartingDate)
                                                ->setCellValue('P'.$noOfProperties, $ExpectedEndingDate)
                                                ->setCellValue('Q'.$noOfProperties, $EndingDate)
                                                ->setCellValue('R'.$noOfProperties, $PercentCompleted);
                                            fontColor('I'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('M'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('N'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('O'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('P'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('Q'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('R'.$noOfProperties, '000000', '12', '', true);

                                            $objPHPExcel->getActiveSheet()->getStyle('I'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('M'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('N'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('O'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('P'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('Q'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('R'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $noOfProperties++;
                                            $snoProp++;
                                        endforeach;
                                        fontColor('C'.$inc, '000000', '12', '', true);
                                        fontColor('F'.$inc, '000000', '12', '', true);
                                        fontColor('G'.$inc, '000000', '12', '', true);
                                        fontColor('H'.$inc, '000000', '12', '', true);
                                        $objPHPExcel->getActiveSheet()->getStyle('B'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('C'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('F'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('G'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('H'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $inc = ++$noOfProperties;
                                        $sno++;
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section End ------------------------
                                        //-----------------------------------------------------------------
                                    endforeach;
                                endif;
                            endforeach;
                            // ----------------------------------------------------------------
                            $objPHPExcel->getActiveSheet()->getStyle('B5:R'.--$inc)->applyFromArray($thinBorder);
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
                        if(isset($_POST["checkbox-select"]) && count($_POST["checkbox-select"]) > 0):
                            $sno = 0;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_projects");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $data_log = json_decode($rows["projects_log"]);
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
                                $tableData["projects_log"] = json_encode($data_log);
                                $tableData["status"] = $auth->trash();
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`projects_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["projects_log"]); 
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