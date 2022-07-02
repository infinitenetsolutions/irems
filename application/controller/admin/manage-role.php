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
    $adminDir = "../../../assets/admin/";
   
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
                    if(!empty($_POST["roleUsername"] && $_POST["rolePassword"] && $_POST["roleRePassword"] && $_POST["roleName"] && $_POST["roleContactNumber"] && $_POST["roleEmail"] && $_POST["roleGender"] && $_POST["roleEmpId"] )):
                        $auth_st = array();
                        // check_page_no_
                        // page_no_4_2_auth
                        // page_no_4_2_add
                        // page_no_4_2_see
                        // page_no_4_2_update
                        // page_no_4_2_delete
                        // page_no_4_2_import
                        // page_no_4_2_export
                        // page_no_4_2_information
                        for($i = 1; $i <= 10; $i++):
                            if(isset($_POST["page_no_". $i])):
                                $submenu = array();
                                for($j = 1; $j <= intval($_POST["check_page_no_". $i]); $j++):
                                    if(isset($_POST["page_no_". $i ."_". $j ."_auth"])):
                                        $auth_st_tmp =  array(
                                                        "add"           =>  "no",
                                                        "see"           =>  "no",
                                                        "update"        =>  "no",
                                                        "delete"        =>  "no",
                                                        "import"        =>  "no",
                                                        "export"        =>  "no",
                                                        "information"   =>  "no"
                                                    );
                                        if(isset($_POST["page_no_". $i ."_". $j ."_add"]))
                                            $auth_st_tmp["add"] = "yes";
                                        if(isset($_POST["page_no_". $i ."_". $j ."_see"]))
                                            $auth_st_tmp["see"] = "yes";
                                        if(isset($_POST["page_no_". $i ."_". $j ."_update"]))
                                            $auth_st_tmp["update"] = "yes";
                                        if(isset($_POST["page_no_". $i ."_". $j ."_delete"]))
                                            $auth_st_tmp["delete"] = "yes";
                                        if(isset($_POST["page_no_". $i ."_". $j ."_import"]))
                                            $auth_st_tmp["import"] = "yes";
                                        if(isset($_POST["page_no_". $i ."_". $j ."_export"]))
                                            $auth_st_tmp["export"] = "yes";
                                        if(isset($_POST["page_no_". $i ."_". $j ."_information"]))
                                            $auth_st_tmp["information"] = "yes";
                                        $submenu["page_no_inside_". $i ."_". $j]  =  $auth_st_tmp;
                                    else:
                                        continue;
                                    endif; 
                                endfor;
                                $auth_st["page_no_". $i]  =  $submenu;
                            else:
                                continue;
                            endif;
                        endfor;
                        // echo "<pre>";
                        // print_r($auth_st);
                        // exit(0);
                        $admin_log  =   array(
                                            "type"              =>      "subadmin",
                                            "user"              =>      $_POST["roleUsername"],
                                            "pass"              =>      md5($_POST["rolePassword"]),
                                            "oldPass"           =>      md5($_POST["rolePassword"]),
                                            "auth"              =>      $auth_st
                                        );
                        $admin_info =   array(
                                            "firmName"          =>      "Srinath Homes",
                                            "empId"             =>      htmlspecialchars($_POST["roleEmpId"], ENT_QUOTES),
                                            "name"              =>      htmlspecialchars($_POST["roleName"], ENT_QUOTES),
                                            "nickName"          =>      "",
                                            "phoneNumber"       =>      htmlspecialchars($_POST["roleContactNumber"], ENT_QUOTES),
                                            "emailId"           =>      htmlspecialchars($_POST["roleEmail"], ENT_QUOTES),
                                            "dp"                =>      "",
                                            "address"           =>      htmlspecialchars($_POST["roleAddress"], ENT_QUOTES),
                                            "gender"            =>      htmlspecialchars(strtolower($_POST["roleGender"]), ENT_QUOTES)
                                            // "project"            =>      htmlspecialchars($_POST["roleProject"], ENT_QUOTES)
                                        );

                        
                        $admin_ajax =   array(
                                            "maxDate"           =>      "",
                                            "maxLog"            =>      "",
                                            "responce"          =>      "",
                                            "ip"                =>      "",
                                            "location"          =>      "",
                                            "otp"               =>      ""
                                        );
                        $admin_create   =   array(
                                                array(
                                                    "action"    =>      "added",
                                                    "by"        =>      $auth->admin_id,
                                                    "ip"        =>      $_POST["checkIp"],
                                                    "location"  =>      $_POST["checkLocation"],
                                                    "at"        =>      date("H:i:s A"),
                                                    "date"      =>      date("d-m-Y")
                                                )
                                            );
                        $tableData["admin_log"] = json_encode($admin_log);
                        $tableData["admin_info"] = json_encode($admin_info);
                        // print_r($tableData["admin_info"]);
                        $tableData["admin_log_info"] = "[]";
                        $tableData["admin_ajax"] = json_encode($admin_ajax);
                        $tableData["admin_theme"] = "[]";
                        $tableData["admin_create"] = json_encode($admin_create);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_admin", $tableData);
                     
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
            // -----------------------------------------------
            // ------------ Add Data Section End -------------
            // -----------------------------------------------
            // --------------------------------------------------
            // ------------ Import Data Section Start -----------
            // --------------------------------------------------
            case "importData":
                if($authority == 1):
                    if(!empty($_FILES["importedExcel"]["name"])):
                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $adminDir.$randSix."_".$_FILES["importedExcel"]["name"])):
                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];
                            $file_type	= PHPExcel_IOFactory::identify($adminDir.$fileName);
                            $objReader	= PHPExcel_IOFactory::createReader($file_type);
                            $objPHPExcel = $objReader->load($adminDir.$fileName);
                            $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            $sno = 0;
                            foreach ($sheet_data as $row):   
                                if(!empty($row["A"])):
                                    $company_info = array(
                                                            "companyLogo"           =>      "default",
                                                            "companyName"           =>      htmlspecialchars($row["A"], ENT_QUOTES),
                                                            "companyContactNumber"  =>      htmlspecialchars($row["B"], ENT_QUOTES),
                                                            "companyEmail"          =>      htmlspecialchars($row["C"], ENT_QUOTES),
                                                            "companyGSTIN"          =>      htmlspecialchars($row["D"], ENT_QUOTES),
                                                            "companyCity"           =>      htmlspecialchars($row["E"], ENT_QUOTES),
                                                            "companyState"          =>      htmlspecialchars($row["F"], ENT_QUOTES),
                                                            "companyPincode"        =>      htmlspecialchars($row["G"], ENT_QUOTES),
                                                            "companyAddress"        =>      htmlspecialchars($row["H"], ENT_QUOTES)
                                                    );
                                    $company_log = array(
                                                        array(
                                                                "action"                =>      "imported",
                                                                "by"                    =>      $auth->admin_id,
                                                                "ip"                    =>      $_POST["checkIp"],
                                                                "location"              =>      $_POST["checkLocation"],
                                                                "at"                    =>      date("H:i:s A"),
                                                                "date"                  =>      date("d-m-Y")
                                                        )
                                                    );
                                    $tableData["admin_info"] = json_encode($company_info);
                                    $tableData["admin_log"] = json_encode($company_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->insert("tbl_admin", $tableData);
                                    if($check == 1):
                                        unset($tableData["admin_info"]); 
                                        unset($tableData["admin_log"]); 
                                        unset($tableData["status"]);
                                        $databaseObj->sql = "";
                                        $databaseObj->data = array();
                                        $databaseObj->dataVal = "";
                                        $sno++;
                                    endif;
                                endif;
                            endforeach;
                            if($sno > 0):
                                unlink($adminDir.$fileName);
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
                   echo "<pre>";
                   print_r($_POST);
                    if(!empty($_POST["editRoleUsername"] && $_POST["editRoleName"] && $_POST["editRoleContactNumber"] && $_POST["editRoleEmail"] && $_POST["editRoleGender"] && $_POST["editRoleAddress"] && $_POST["editRoleAddress"] )):
                        $databaseObj->select("tbl_admin");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_info = json_decode($rows["admin_info"]);
                                $data_log = json_decode($rows["admin_log"]);
                                $data_create = json_decode($rows["admin_create"]);
                            endforeach;
                            if(!empty($_POST["editRoleUsername"])):
                                $auth_st = array();
                                for($i = 1; $i <= 10; $i++):
                                    if(isset($_POST["edit_page_no_". $i])):
                                        $submenu = array();
                                        for($j = 1; $j <= intval($_POST["check_page_no_". $i]); $j++):
                                            if(isset($_POST["edit_page_no_". $i ."_". $j ."_auth"])):
                                                $auth_st_tmp =  array(
                                                                "add"           =>  "no",
                                                                "see"           =>  "no",
                                                                "update"        =>  "no",
                                                                "delete"        =>  "no",
                                                                "import"        =>  "no",
                                                                "export"        =>  "no",
                                                                "information"   =>  "no"
                                                            );
                                                if(isset($_POST["edit_page_no_". $i ."_". $j ."_add"]))
                                                    $auth_st_tmp["add"] = "yes";
                                                if(isset($_POST["edit_page_no_". $i ."_". $j ."_see"]))
                                                    $auth_st_tmp["see"] = "yes";
                                                if(isset($_POST["edit_page_no_". $i ."_". $j ."_update"]))
                                                    $auth_st_tmp["update"] = "yes";
                                                if(isset($_POST["edit_page_no_". $i ."_". $j ."_delete"]))
                                                    $auth_st_tmp["delete"] = "yes";
                                                if(isset($_POST["edit_page_no_". $i ."_". $j ."_import"]))
                                                    $auth_st_tmp["import"] = "yes";
                                                if(isset($_POST["edit_page_no_". $i ."_". $j ."_export"]))
                                                    $auth_st_tmp["export"] = "yes";
                                                if(isset($_POST["edit_page_no_". $i ."_". $j ."_information"]))
                                                    $auth_st_tmp["information"] = "yes";
                                                $submenu["page_no_inside_". $i ."_". $j]  =  $auth_st_tmp;
                                            else:
                                                continue;
                                            endif; 
                                        endfor;
                                        $auth_st["page_no_". $i]  =  $submenu;
                                    else:
                                        continue;
                                    endif;
                                endfor;
                                $data_log->user = $_POST["editRoleUsername"];
                                $data_log->pass  =  md5($_POST["editRolePassword"]);
                               // $data_log->oldPass = md5($_POST["rolePassword"]),
                                // if(!empty($_POST["editRolePassword"])):
                                //     $data_log->oldPass = $data_log->pass;
                                //     $data_log->pass = md5($_POST["editRolePassword"]);
                                // endif;            
                                $data_log->auth = $auth_st;
                                $data_info->name = htmlspecialchars($_POST["editRoleName"], ENT_QUOTES);
                                $data_info->phoneNumber = htmlspecialchars($_POST["editRoleContactNumber"], ENT_QUOTES);
                                $data_info->emailId = htmlspecialchars($_POST["editRoleEmail"], ENT_QUOTES);
                                $data_info->address = htmlspecialchars($_POST["editRoleAddress"], ENT_QUOTES);
                                $data_info->gender = htmlspecialchars($_POST["editRoleGender"], ENT_QUOTES);
                                // $data_info->project = htmlspecialchars($_POST["editRoleProject"], ENT_QUOTES);
                                $edit_log = array(
                                                "action"                =>      "edited",
                                                "by"                    =>      $auth->admin_id,
                                                "ip"                    =>      $_POST["checkIp"],
                                                "location"              =>      $_POST["checkLocation"],
                                                "at"                    =>      date("H:i:s A"),
                                                "date"                  =>      date("d-m-Y")
                                            );
                                array_push($data_create, $edit_log);
                                $tableData["admin_info"] = json_encode($data_info);
                                $tableData["admin_log"] = json_encode($data_log);
                                $tableData["admin_create"] = json_encode($data_create);
                                
                                $tableData["status"] = $auth->visible();
                                $check = $databaseObj->update("tbl_admin", $tableData, "`admin_id` = '".$_POST["editTableId"]."'");
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
                        $databaseObj->select("tbl_admin");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $company_log = json_decode($rows["admin_create"]);
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
                        array_push($company_log, $delete_log);
                        $tableData["admin_create"] = json_encode($company_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`admin_id` = '".$_POST["tableId"]."'");
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
                                $databaseObj->select("tbl_admin");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $company_log = json_decode($rows["admin_log"]);
                                    endforeach;
                                endif;
                                $delete_log = array(
                                                        "action"                =>      "exported",
                                                        "by"                    =>      $auth->admin_id,
                                                        "ip"                    =>      $_POST["checkIp"],
                                                        "location"              =>      $_POST["checkLocation"],
                                                        "at"                    =>      date("H:i:s A"),
                                                        "date"                  =>      date("d-m-Y")
                                                );
                                array_push($company_log, $delete_log);
                                $tableData["admin_log"] = json_encode($company_log);
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`admin_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["admin_log"]); 
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
                            $fileName = "Company-Management-".date("d-m-Y").".xlsx";
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
                                                         ->setTitle("Company Management")
                                                         ->setSubject("Company Management")
                                                         ->setDescription("Company Management $fileName.")
                                                         ->setKeywords("$fileName")
                                                         ->setCategory("$fileName");
                            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);	
                            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);	
                            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	
                            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	
                            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);	
                            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);	
                            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);	
                            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);		
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:I2');
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Company Management");
                            cellColor('B2', '001F3F');
                            fontColor('B2', 'FFFFFF', '18', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:I2')->applyFromArray($thinBorder);

                            //Setting Header --------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Company Name");
                            fontColor('B4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Contact Number");
                            fontColor('C4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Email");
                            fontColor('D4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "GST IN");
                            fontColor('E4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "City");
                            fontColor('F4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "State");
                            fontColor('G4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Pincode");
                            fontColor('H4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Address");
                            fontColor('I4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($thinBorder);
                            $inc = 5;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_admin");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $company_info = json_decode($rows["admin_info"]);
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section Start ----------------------
                                        //-----------------------------------------------------------------
                                        $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('B'.$inc, $company_info->companyName)
                                            ->setCellValue('C'.$inc, $company_info->companyContactNumber)
                                            ->setCellValue('D'.$inc, $company_info->companyEmail)
                                            ->setCellValue('E'.$inc, $company_info->companyGSTIN)
                                            ->setCellValue('F'.$inc, $company_info->companyCity)
                                            ->setCellValue('G'.$inc, $company_info->companyState)
                                            ->setCellValue('H'.$inc, $company_info->companyPincode)
                                            ->setCellValue('I'.$inc, $company_info->companyAddress);
                                        fontColor('B'.$inc, '000000', '12', '', true);
                                        fontColor('E'.$inc, '000000', '12', '', true);
                                        $inc++;
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section End ------------------------
                                        //-----------------------------------------------------------------
                                    endforeach;
                                endif;
                            endforeach;
                            // ----------------------------------------------------------------
                            $objPHPExcel->getActiveSheet()->getStyle('B5:I'.--$inc)->applyFromArray($thinBorder);
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
                                $databaseObj->select("tbl_admin");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $company_log = json_decode($rows["admin_create"]);
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
                                array_push($company_log, $delete_log);
                                $tableData["admin_create"] = json_encode($company_log);
                                $tableData["status"] = $auth->trash();
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`admin_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["admin_create"]); 
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
            // ----------------------------------------------------
            // ------------ Check Username Section Start ----------
            // ----------------------------------------------------
            case "checkUsername":
                if($authority == 1):
                    if(!empty($_POST["user"])):
                        $flag = 1;
                        $databaseObj->select("tbl_admin");
                        $databaseObj->where("`status` = '".$auth->visible()."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $admin_log = json_decode($rows["admin_log"]);
                                if($admin_log->user == $_POST["user"]):
                                    $data["response"] = "exists";
                                    $data["responseType"] = "error";
                                    $data["responseMessage"] = "Username already exists, Please change and try again!!!";
                                    $flag = 0;
                                    break;
                                endif;
                            endforeach;
                            if($flag == 1):
                                $data["response"] = "ok";
                                $data["responseType"] = "success";
                                $data["responseMessage"] = "Correct Username!!!";
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
            // ----------------------------------------------------
            // ------------ Check Username Section End ------------
            // ----------------------------------------------------
             case "addCommitEdit":
                // print_r($_POST);
               
                if(isset($_POST["edit_commit_edit"])){
                    $databaseObj->select("tbl_manage_employee");
                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$_POST["empid"]."'");
                    $getemployeeData = $databaseObj->get();
                    // echo "<pre>";
                    // print_r($getemployeeData);
                    // echo "</pre>";
                    if($getemployeeData != 0){
                        foreach($getemployeeData as $rowsemployee){
                             $manage_employee_info= json_decode($rowsemployee["manage_employee_info"]);
                            
                              // echo "<pre>";
                              // print_r($manage_employee_info);
                              // echo "</pre>";
                              $databaseObj->select("tbl_projects");
                              $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_employee_info->project."'");
                              $getprojectData = $databaseObj->get();
                              
                               if($getprojectData != 0){
                                 foreach($getprojectData as $rowsproject){
                                   $commit_edit= $rowsproject["commit_edit"];
                              // echo "<pre>";
                              // print_r($commit_edit);
                              // echo "</pre>";
                              // $commit_edit_log = array(
                              //                       "action"                =>      "committed edited",

                              //                       "by"                    =>      $auth->admin_id,

                              //                       "ip"                    =>      $_POST["checkIp"],

                              //                       "location"              =>      $_POST["checkLocation"],

                              //                       "at"                    =>      date("H:i:s A"),

                              //                       "date"                  =>      date("d-m-Y")
                              //                   );
                               
                              //   $tableData["projects_log"] = json_encode($commit_edit_log);
                                $tableData["commit_edit"] =  $_POST['edit_commit_edit'];
                                
                              // exit(0);
                                $check = $databaseObj->update("tbl_projects", $tableData, "`projects_id` = '".$manage_employee_info->project."'");
                              
                                // exit(0);
                             
                                if($check == 1):

                                    $data["response"] = "success";

                                    $data["responseType"] = "success";

                                    $data["responseMessage"] = "Data committed successfully!!!";

                                else:

                                    $data["response"] = "error";

                                    $data["responseType"] = "error";

                                    $data["responseMessage"] = "Data  not committed successfully!!!";

                                endif;

                             }
                }   else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                        }
                         }
                }   else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                        }
                        // }
                // }   else{
                //             $data["response"] = "empty";
                //             $data["responseType"] = "warning";
                //             $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                //         }
                    }
                    else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, commit edit not found!!!";
                        }     
                    
            break;   
             case "editCommitEdit":
                // print_r($_POST);
               
               
                if(isset($_POST["commit_edit"])){
                    $databaseObj->select("tbl_manage_employee");
                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$_POST["empid"]."'");
                    $getemployeeData = $databaseObj->get();
                    // echo "<pre>";
                    // print_r($getemployeeData);
                    // echo "</pre>";s
                    if($getemployeeData != 0){
                        foreach($getemployeeData as $rowsemployee){
                             $manage_employee_info= json_decode($rowsemployee["manage_employee_info"]);
                            
                              // echo "<pre>";
                              // print_r($manage_employee_info);
                              // echo "</pre>";
                              $databaseObj->select("tbl_projects");
                              $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_employee_info->project."'");
                              $getprojectData = $databaseObj->get();
                              
                               if($getprojectData != 0){
                                 foreach($getprojectData as $rowsproject){
                                   $commit_edit= $rowsproject["commit_edit"];
                              // echo "<pre>";
                              // print_r($commit_edit);
                              // echo "</pre>";
                              // $commit_edit_log = array(
                              //                       "action"                =>      "committed edited",

                              //                       "by"                    =>      $auth->admin_id,

                              //                       "ip"                    =>      $_POST["checkIp"],

                              //                       "location"              =>      $_POST["checkLocation"],

                              //                       "at"                    =>      date("H:i:s A"),

                              //                       "date"                  =>      date("d-m-Y")
                              //                   );
                               
                              //   $tableData["projects_log"] = json_encode($commit_edit_log);
                                $tableData["commit_edit"] =  $_POST['commit_edit'];

                                $check = $databaseObj->update("tbl_projects", $tableData, "`projects_id` = '".$manage_employee_info->project."'");
                              
                                // exit(0);
                             
                                if($check == 1):

                                    $data["response"] = "success";

                                    $data["responseType"] = "success";

                                    $data["responseMessage"] = "Data committed successfully!!!";

                                else:

                                    $data["response"] = "error";

                                    $data["responseType"] = "error";

                                    $data["responseMessage"] = "Data  not committed successfully!!!";

                                endif;

                             }
                }   else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                        }
                         }
                }   else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                        }
                        // }
                // }   else{
                //             $data["response"] = "empty";
                //             $data["responseType"] = "warning";
                //             $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                //         }
                    }
                    else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, commit edit not found!!!";
                        }     
                    
            break;                                                                         
            case "addCommitDelete":
                // print_r($_POST);
               
                if(isset($_POST["commit_delete"])){
                    $databaseObj->select("tbl_manage_employee");
                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$_POST["empid"]."'");
                    $getemployeeData = $databaseObj->get();
                    // echo "<pre>";
                    // print_r($getemployeeData);
                    // echo "</pre>";
                    if($getemployeeData != 0){
                        foreach($getemployeeData as $rowsemployee){
                             $manage_employee_info= json_decode($rowsemployee["manage_employee_info"]);
                            
                              // echo "<pre>";
                              // print_r($manage_employee_info);
                              // echo "</pre>";
                              $databaseObj->select("tbl_projects");
                              $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_employee_info->project."'");
                              $getprojectData = $databaseObj->get();
                              
                               if($getprojectData != 0){
                                 foreach($getprojectData as $rowsproject){
                                   $commit_delete= $rowsproject["commit_delete"];
                              // echo "<pre>";
                              // print_r($commit_edit);
                              // echo "</pre>";
                              // $commit_edit_log = array(
                              //                       "action"                =>      "committed edited",

                              //                       "by"                    =>      $auth->admin_id,

                              //                       "ip"                    =>      $_POST["checkIp"],

                              //                       "location"              =>      $_POST["checkLocation"],

                              //                       "at"                    =>      date("H:i:s A"),

                              //                       "date"                  =>      date("d-m-Y")
                              //                   );
                               
                              //   $tableData["projects_log"] = json_encode($commit_edit_log);
                                $tableData["commit_delete"] =  $_POST['commit_delete'];
                                
                              // exit(0);
                                $check = $databaseObj->update("tbl_projects", $tableData, "`projects_id` = '".$manage_employee_info->project."'");
                              
                                // exit(0);
                             
                                if($check == 1):

                                    $data["response"] = "success";

                                    $data["responseType"] = "success";

                                    $data["responseMessage"] = "Data committed successfully!!!";

                                else:

                                    $data["response"] = "error";

                                    $data["responseType"] = "error";

                                    $data["responseMessage"] = "Data  not committed successfully!!!";

                                endif;

                             }
                }   else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                        }
                         }
                }   else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                        }
                        // }
                // }   else{
                //             $data["response"] = "empty";
                //             $data["responseType"] = "warning";
                //             $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                //         }
                    }
                    else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, commit delete not found!!!";
                        }     
                    
            break;     
             case "editCommitDelete":
                
               
                if(isset($_POST["commit_delete"])){
                    $databaseObj->select("tbl_manage_employee");
                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$_POST["empid"]."'");
                    $getemployeeData = $databaseObj->get();
                    // echo "<pre>";
                    // print_r($getemployeeData);
                    // echo "</pre>";
                    if($getemployeeData != 0){
                        foreach($getemployeeData as $rowsemployee){
                             $manage_employee_info= json_decode($rowsemployee["manage_employee_info"]);
                            
                              // echo "<pre>";
                              // print_r($manage_employee_info);
                              // echo "</pre>";
                              $databaseObj->select("tbl_projects");
                              $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_employee_info->project."'");
                              $getprojectData = $databaseObj->get();
                              
                               if($getprojectData != 0){
                                 foreach($getprojectData as $rowsproject){
                                   $commit_delete= $rowsproject["commit_delete"];
                              // echo "<pre>";
                              // print_r($commit_edit);
                              // echo "</pre>";
                              // $commit_edit_log = array(
                              //                       "action"                =>      "committed edited",

                              //                       "by"                    =>      $auth->admin_id,

                              //                       "ip"                    =>      $_POST["checkIp"],

                              //                       "location"              =>      $_POST["checkLocation"],

                              //                       "at"                    =>      date("H:i:s A"),

                              //                       "date"                  =>      date("d-m-Y")
                              //                   );
                               
                              //   $tableData["projects_log"] = json_encode($commit_edit_log);
                                $tableData["commit_delete"] =  $_POST['commit_delete'];
                                
                              // exit(0);
                                $check = $databaseObj->update("tbl_projects", $tableData, "`projects_id` = '".$manage_employee_info->project."'");
                              
                                // exit(0);
                             
                                if($check == 1):

                                    $data["response"] = "success";

                                    $data["responseType"] = "success";

                                    $data["responseMessage"] = "Data committed successfully!!!";

                                else:

                                    $data["response"] = "error";

                                    $data["responseType"] = "error";

                                    $data["responseMessage"] = "Data  not committed successfully!!!";

                                endif;

                             }
                }   else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                        }
                         }
                }   else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                        }
                        // }
                // }   else{
                //             $data["response"] = "empty";
                //             $data["responseType"] = "warning";
                //             $data["responseMessage"] = "Something went wrong, Employee  not found!!!";
                //         }
                    }
                    else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, commit delete not found!!!";
                        }     
                    
            break;           
            case "fetchProject":
                // print_r($_POST);
                // exit();
                if(isset($_POST["roleProject"])){   
                    $databaseObj->select("tbl_projects");
                    $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$_POST["roleProject"]."'");
                    $getData = $databaseObj->get();
                    // print_r($getData);
                    //Checking If Data Is Available
                    if($getData != 0){
                        foreach($getData as $rows){
                             $projects_info= json_decode($rows["projects_info"]);
                             $data["projects_name"]=$projects_info->projectName;
                             $data["commit_edit"]=$rows["commit_edit"];
                             $data["commit_delete"]=$rows["commit_delete"];
                        }
                    }else{
                            $data["response"] = "empty";
                            $data["responseType"] = "warning";
                            $data["responseMessage"] = "Something went wrong, Project is not found!!!";
                        }

                }
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