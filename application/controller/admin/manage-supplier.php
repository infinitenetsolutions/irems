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
    $manageSupplierDir = "../../../assets/admin/manage-items/";
//    ini_set('display_errors', 1);
//    ini_set('display_startup_errors', 1);
//    error_reporting(E_ALL);
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
                    if(!empty($_POST["supplierName"] && $_POST["supplierCity"] && $_POST["supplierState"] && $_POST["supplierCountry"] && $_POST["supplierAddress"] && $_POST["supplierPhone"] && $_POST["supplierEmail"] && $_POST["supplierGstin"])):
                        $supplier_info = array(
                                                "supplierName"              =>      htmlspecialchars($_POST["supplierName"], ENT_QUOTES),
                                                "supplierCity"              =>      htmlspecialchars($_POST["supplierCity"], ENT_QUOTES),
                                                "supplierState"             =>      htmlspecialchars($_POST["supplierState"], ENT_QUOTES),
                                                "supplierCountry"           =>      htmlspecialchars($_POST["supplierCountry"], ENT_QUOTES),
                                                "supplierAddress"           =>      htmlspecialchars($_POST["supplierAddress"], ENT_QUOTES),
                                                "supplierConcernPersonName" =>      htmlspecialchars($_POST["supplierConcernPersonName"], ENT_QUOTES),
                                                "supplierOfficePhone"       =>      htmlspecialchars($_POST["supplierOfficePhone"], ENT_QUOTES),
                                                "supplierPhone"             =>      htmlspecialchars($_POST["supplierPhone"], ENT_QUOTES),
                                                "supplierAlternatePhone"    =>      htmlspecialchars($_POST["supplierAlternatePhone"], ENT_QUOTES),
                                                "supplierEmail"             =>      htmlspecialchars($_POST["supplierEmail"], ENT_QUOTES),
                                                "supplierGstin"             =>      htmlspecialchars($_POST["supplierGstin"], ENT_QUOTES),
                                                "approval"             =>    "Approved"  
                                        );
                        $supplier_log = array(
                                            array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            )
                                        );
                        $tableData["manage_supplier_info"] = json_encode($supplier_info);
                        $tableData["manage_supplier_log"] = json_encode($supplier_log);
                        $tableData["status"] = $auth->visible();
                            $check = $databaseObj->insert("tbl_manage_supplier", $tableData);
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
                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $manageSupplierDir.$randSix."_".$_FILES["importedExcel"]["name"])):
                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];
                            $file_type	= PHPExcel_IOFactory::identify($manageSupplierDir.$fileName);
                            $objReader	= PHPExcel_IOFactory::createReader($file_type);
                            $objPHPExcel = $objReader->load($manageSupplierDir.$fileName);
                            $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            $sno = 0;
                            foreach ($sheet_data as $row):
                                if(!empty($row["A"])):
                                    $supplier_info = array(
                                                            "supplierName"              =>      htmlspecialchars($row["A"], ENT_QUOTES),
                                                            "supplierCity"              =>      htmlspecialchars($row["B"], ENT_QUOTES),
                                                            "supplierState"             =>      htmlspecialchars($row["C"], ENT_QUOTES),
                                                            "supplierCountry"           =>      htmlspecialchars($row["D"], ENT_QUOTES),
                                                            "supplierAddress"           =>      htmlspecialchars($row["E"], ENT_QUOTES),
                                                            "supplierConcernPersonName" =>      htmlspecialchars($row["F"], ENT_QUOTES),
                                                            "supplierOfficePhone"       =>      htmlspecialchars($row["G"], ENT_QUOTES),
                                                            "supplierPhone"             =>      htmlspecialchars($row["H"], ENT_QUOTES),
                                                            "supplierAlternatePhone"    =>      htmlspecialchars($row["I"], ENT_QUOTES),
                                                            "supplierEmail"             =>      htmlspecialchars($row["J"], ENT_QUOTES),
                                                            "supplierGstin"             =>      htmlspecialchars($row["K"], ENT_QUOTES)
                                                    );
                                    $supplier_log = array(
                                                        array(
                                                                "action"                =>      "imported",
                                                                "by"                    =>      $auth->admin_id,
                                                                "ip"                    =>      $_POST["checkIp"],
                                                                "location"              =>      $_POST["checkLocation"],
                                                                "at"                    =>      date("H:i:s A"),
                                                                "date"                  =>      date("d-m-Y")
                                                        )
                                                    );
                                    $tableData["manage_supplier_info"] = json_encode($supplier_info);
                                    $tableData["manage_supplier_log"] = json_encode($supplier_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->insert("tbl_manage_supplier", $tableData);
                                    if($check == 1):
                                        unset($tableData["manage_supplier_info"]);
                                        unset($tableData["manage_supplier_log"]);
                                        unset($tableData["status"]);
                                        $databaseObj->sql = "";
                                        $databaseObj->data = array();
                                        $databaseObj->dataVal = "";
                                        $sno++;
                                    endif;
                                endif;
                            endforeach;
                            if($sno > 0):
                                unlink($manageSupplierDir.$fileName);
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
                        $databaseObj->select("tbl_manage_supplier");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $supplier_info = json_decode($rows["manage_supplier_info"]);
                                $supplier_log = json_decode($rows["manage_supplier_log"]);
                            endforeach;
                            if(!empty($_POST["editSupplierName"] && $_POST["editSupplierCity"] && $_POST["editSupplierState"] && $_POST["editSupplierCountry"] && $_POST["editSupplierAddress"] && $_POST["editSupplierPhone"] && $_POST["editSupplierEmail"] && $_POST["editSupplierGstin"])):
                                $edit_info = array(
                                                        "supplierName"              =>      htmlspecialchars($_POST["editSupplierName"], ENT_QUOTES),
                                                        "supplierCity"              =>      htmlspecialchars($_POST["editSupplierCity"], ENT_QUOTES),
                                                        "supplierState"             =>      htmlspecialchars($_POST["editSupplierState"], ENT_QUOTES),
                                                        "supplierCountry"           =>      htmlspecialchars($_POST["editSupplierCountry"], ENT_QUOTES),
                                                        "supplierAddress"           =>      htmlspecialchars($_POST["editSupplierAddress"], ENT_QUOTES),
                                                        "supplierConcernPersonName" =>      htmlspecialchars($_POST["editSupplierConcernPersonName"], ENT_QUOTES),
                                                        "supplierOfficePhone"       =>      htmlspecialchars($_POST["editSupplierOfficePhone"], ENT_QUOTES),
                                                        "supplierPhone"             =>      htmlspecialchars($_POST["editSupplierPhone"], ENT_QUOTES),
                                                        "supplierAlternatePhone"    =>      htmlspecialchars($_POST["editSupplierAlternatePhone"], ENT_QUOTES),
                                                        "supplierEmail"             =>      htmlspecialchars($_POST["editSupplierEmail"], ENT_QUOTES),
                                                        "supplierGstin"             =>      htmlspecialchars($_POST["editSupplierGstin"], ENT_QUOTES)
                                                );

                                 $edit_log = array(
                                                        "action"                    =>      "edited",
                                                        "by"                        =>      $auth->admin_id,
                                                        "ip"                        =>      $_POST["checkIp"],
                                                        "location"                  =>      $_POST["checkLocation"],
                                                        "at"                        =>      date("H:i:s A"),
                                                        "date"                      =>      date("d-m-Y")
                                            );
                                array_push($supplier_log, $edit_log);
                                $tableData["manage_supplier_info"] = json_encode($edit_info);
                                $tableData["manage_supplier_log"] = json_encode($supplier_log);
                                $tableData["status"] = $auth->visible();
                                $check = $databaseObj->update("tbl_manage_supplier", $tableData, "`manage_supplier_id` = '".$_POST["editTableId"]."'");
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
                        $databaseObj->select("tbl_manage_supplier");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $supplier_log = json_decode($rows["manage_supplier_log"]);
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
                        array_push($supplier_log, $delete_log);
                        $tableData["manage_supplier_log"] = json_encode($supplier_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`manage_supplier_id` = '".$_POST["tableId"]."'");
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
                                $databaseObj->select("tbl_manage_supplier");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $supplier_log = json_decode($rows["manage_supplier_log"]);
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
                                array_push($supplier_log, $delete_log);
                                $tableData["manage_supplier_log"] = json_encode($supplier_log);
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`manage_supplier_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["manage_supplier_log"]);
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
                            $fileName = "Supplier-Management-".date("d-m-Y").".xlsx";
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
                                                         ->setTitle("Supplier Management")
                                                         ->setSubject("Supplier Management")
                                                         ->setDescription("Supplier Management $fileName.")
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
                            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:L2');
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Supplier Management");
                            cellColor('B2', '001F3F');
                            fontColor('B2', 'FFFFFF', '18', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:L2')->applyFromArray($thinBorder);

                            //Setting Header --------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Supplier Name");
                            fontColor('B4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "City");
                            fontColor('C4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "State");
                            fontColor('D4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Country");
                            fontColor('E4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Address");
                            fontColor('F4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Concern Person Name");
                            fontColor('G4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Supplier Office Number");
                            fontColor('H4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Supplier Phone Number");
                            fontColor('I4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Supplier Alternate Number");
                            fontColor('J4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Supplier Email");
                            fontColor('K4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Supplier Gstin");
                            fontColor('L4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $inc = 5;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_manage_supplier");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $supplier_info = json_decode($rows["manage_supplier_info"]);
                                        if(isset($supplier_info->supplierAlternatePhone))
                                            $supplierAlternatePhone = $supplier_info->supplierAlternatePhone;
                                        else
                                            $supplierAlternatePhone = "";
                                        if(isset($supplier_info->supplierConcernPersonName))
                                            $supplierConcernPersonName = $supplier_info->supplierConcernPersonName;
                                        else
                                            $supplierConcernPersonName = "";
                                        if(isset($supplier_info->supplierOfficePhone))
                                            $supplierOfficePhone = $supplier_info->supplierOfficePhone;
                                        else
                                            $supplierOfficePhone = "";
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section Start ----------------------
                                        //-----------------------------------------------------------------
                                        $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('B'.$inc, $supplier_info->supplierName)
                                            ->setCellValue('C'.$inc, $supplier_info->supplierCity)
                                            ->setCellValue('D'.$inc, $supplier_info->supplierState)
                                            ->setCellValue('E'.$inc, $supplier_info->supplierCountry)
                                            ->setCellValue('F'.$inc, $supplier_info->supplierAddress)
                                            ->setCellValue('G'.$inc, $supplierConcernPersonName)
                                            ->setCellValue('H'.$inc, $supplierOfficePhone)
                                            ->setCellValue('I'.$inc, $supplier_info->supplierPhone)
                                            ->setCellValue('J'.$inc, $supplierAlternatePhone)
                                            ->setCellValue('K'.$inc, $supplier_info->supplierEmail)
                                            ->setCellValue('L'.$inc, $supplier_info->supplierGstin);
                                        fontColor('B'.$inc, '000000', '12', '', true);
                                        $objPHPExcel->getActiveSheet()->getStyle('B'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        fontColor('L'.$inc, '000000', '12', '', true);
                                        $objPHPExcel->getActiveSheet()->getStyle('L'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $inc++;
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section End ------------------------
                                        //-----------------------------------------------------------------
                                    endforeach;
                                endif;
                            endforeach;
                            // ----------------------------------------------------------------
                            $objPHPExcel->getActiveSheet()->getStyle('B5:L'.--$inc)->applyFromArray($thinBorder);
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
                                $databaseObj->select("tbl_manage_supplier");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_supplier_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $supplier_log = json_decode($rows["manage_supplier_log"]);
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
                                array_push($supplier_log, $delete_log);
                                $tableData["manage_supplier_log"] = json_encode($supplier_log);
                                $tableData["status"] = $auth->trash();
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`manage_supplier_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["manage_supplier_log"]);
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