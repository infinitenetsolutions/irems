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
    $manageCategoryDir = "../../../assets/admin/manage-items/";
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
                    if(!empty($_POST["categoryName"] && $_POST["categoryDescription"])):
                        $category_info = array(
                                                "categoryName"           =>      htmlspecialchars($_POST["categoryName"], ENT_QUOTES),
                                                "categoryDescription"    =>      htmlspecialchars($_POST["categoryDescription"], ENT_QUOTES)
                                        );
                        $category_log = array(
                                            array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            )
                                        );
                        $tableData["manage_category_info"] = json_encode($category_info);
                        $tableData["manage_category_log"] = json_encode($category_log);
                        $tableData["status"] = $auth->visible();
                          $databaseObj->select("tbl_manage_category");
                          $databaseObj->where("`status` = '".$auth->visible()."'");
                          $getCategoryData = $databaseObj->get();
                          $flag = 0;
                        if($getCategoryData != 0):
                            foreach($getCategoryData as $categoryrows):
                                $manage_category_info = json_decode($categoryrows["manage_category_info"]);
                         if ($manage_category_info->categoryName == $_POST["categoryName"]) {
                             $flag++;
                         }
                           endforeach;
                         endif;
                         if ($flag==0) {
                            $check = $databaseObj->insert("tbl_manage_category", $tableData);
                         }
                         else {
                           $check = 2;
                         }
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Data added successfully!!!";
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            if ($check == 2) {
                            $data["responseMessage"] = "Item Category Already Exists!!!";
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
            // --------------------------------------------------
            // ------------ Import Data Section Start -----------
            // --------------------------------------------------
            case "importData":
                if($authority == 1):
                    if(!empty($_FILES["importedExcel"]["name"])):
                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $manageCategoryDir.$randSix."_".$_FILES["importedExcel"]["name"])):
                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];
                            $file_type	= PHPExcel_IOFactory::identify($manageCategoryDir.$fileName);
                            $objReader	= PHPExcel_IOFactory::createReader($file_type);
                            $objPHPExcel = $objReader->load($manageCategoryDir.$fileName);
                            $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            $sno = 0;
                            foreach ($sheet_data as $row):
                                if(!empty($row["A"])):
                                    $category_info = array(
                                                            "categoryName"           =>      htmlspecialchars($row["A"], ENT_QUOTES),
                                                            "categoryDescription"    =>      htmlspecialchars($row["B"], ENT_QUOTES)
                                                    );
                                    $category_log = array(
                                                        array(
                                                                "action"                =>      "imported",
                                                                "by"                    =>      $auth->admin_id,
                                                                "ip"                    =>      $_POST["checkIp"],
                                                                "location"              =>      $_POST["checkLocation"],
                                                                "at"                    =>      date("H:i:s A"),
                                                                "date"                  =>      date("d-m-Y")
                                                        )
                                                    );
                                    $tableData["manage_category_info"] = json_encode($category_info);
                                    $tableData["manage_category_log"] = json_encode($category_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->insert("tbl_manage_category", $tableData);
                                    if($check == 1):
                                        unset($tableData["manage_category_info"]);
                                        unset($tableData["manage_category_log"]);
                                        unset($tableData["status"]);
                                        $databaseObj->sql = "";
                                        $databaseObj->data = array();
                                        $databaseObj->dataVal = "";
                                        $sno++;
                                    endif;
                                endif;
                            endforeach;
                            if($sno > 0):
                                unlink($manageCategoryDir.$fileName);
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
                        $databaseObj->select("tbl_manage_category");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $category_info = json_decode($rows["manage_category_info"]);
                                $category_log = json_decode($rows["manage_category_log"]);
                            endforeach;
                            if(!empty($_POST["editCategoryName"] && $_POST["editCategoryDesctiption"])):
                                $edit_info = array(
                                                        "categoryName"           =>      htmlspecialchars($_POST["editCategoryName"], ENT_QUOTES),
                                                        "categoryDescription"    =>      htmlspecialchars($_POST["editCategoryDesctiption"], ENT_QUOTES)
                                                );

                                 $edit_log = array(
                                                    "action"                =>      "edited",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                                array_push($category_log, $edit_log);
                                $tableData["manage_category_info"] = json_encode($edit_info);
                                $tableData["manage_category_log"] = json_encode($category_log);
                                $tableData["status"] = $auth->visible();
                                // Check for duplicate data start
                                $databaseObj->select("tbl_manage_category");
                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                $getCategoryData = $databaseObj->get();
                                $flag = 0;
                              if($getCategoryData != 0):
                                  foreach($getCategoryData as $categoryrows):
                                      $manage_category_info = json_decode($categoryrows["manage_category_info"]);
                               if ($manage_category_info->categoryName == $_POST["editCategoryName"] && $categoryrows["manage_category_id"] != $_POST["editTableId"]) {
                                   $flag++;
                               }
                                 endforeach;
                               endif;
                               if ($flag==0) {
                                 $check = $databaseObj->update("tbl_manage_category", $tableData, "`manage_category_id` = '".$_POST["editTableId"]."'");
                               }
                               else {
                                 $check = 2;
                               }
                                // Check for duplicate data end
                                if($check == 1):
                                    $data["response"] = "success";
                                    $data["responseType"] = "success";
                                    $data["responseMessage"] = "Data edited successfully!!!";
                                else:
                                    $data["response"] = "error";
                                    $data["responseType"] = "error";
                                    if ($check == 2) {
                                      $data["responseMessage"] = "Category Name Already Exists!!!";
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
                        $databaseObj->select("tbl_manage_category");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $category_log = json_decode($rows["manage_category_log"]);
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
                        array_push($category_log, $delete_log);
                        $tableData["manage_category_log"] = json_encode($category_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`manage_category_id` = '".$_POST["tableId"]."'");
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
                                $databaseObj->select("tbl_manage_category");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $category_log = json_decode($rows["manage_category_log"]);
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
                                array_push($category_log, $delete_log);
                                $tableData["manage_category_log"] = json_encode($category_log);
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`manage_category_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["manage_category_log"]);
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
                            $fileName = "Category-Management-".date("d-m-Y").".xlsx";
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
                                                         ->setTitle("Category Management")
                                                         ->setSubject("Category Management")
                                                         ->setDescription("Category Management $fileName.")
                                                         ->setKeywords("$fileName")
                                                         ->setCategory("$fileName");
                            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Category Management");
                            cellColor('B2', '001F3F');
                            fontColor('B2', 'FFFFFF', '18', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($thinBorder);

                            //Setting Header --------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Category Name");
                            fontColor('B4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Category Description");
                            fontColor('C4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $inc = 5;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_manage_category");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $category_info = json_decode($rows["manage_category_info"]);
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section Start ----------------------
                                        //-----------------------------------------------------------------
                                        $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('B'.$inc, $category_info->categoryName)
                                            ->setCellValue('C'.$inc, $category_info->categoryDescription);
                                        fontColor('B'.$inc, '000000', '12', '', true);
                                        $inc++;
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
                                $databaseObj->select("tbl_manage_category");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $category_log = json_decode($rows["manage_category_log"]);
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
                                array_push($category_log, $delete_log);
                                $tableData["manage_category_log"] = json_encode($category_log);
                                $tableData["status"] = $auth->trash();
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`manage_category_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["manage_category_log"]);
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