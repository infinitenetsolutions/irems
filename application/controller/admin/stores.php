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
    // echo"<pre>";
    // print_r($_POST);
    // echo "</pre>";

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
                    if(!empty($_POST["itemName"] && $_POST["itemCode"] && $_POST["itemCategory"] && $_POST["Uom"] && $_POST["Price"] && $_POST["Qty"] && $_POST["ReOrder"])):

                                                $itemName           =      htmlspecialchars($_POST["itemName"], ENT_QUOTES);
                                                $itemCode           =      htmlspecialchars($_POST["itemCode"], ENT_QUOTES);
                                                $itemCategory       =      htmlspecialchars($_POST["itemCategory"], ENT_QUOTES);
                                                $Uom                =      htmlspecialchars($_POST["Uom"], ENT_QUOTES);
                                                $Price              =      htmlspecialchars($_POST["Price"], ENT_QUOTES);
                                                $Qty                =      htmlspecialchars($_POST["Qty"], ENT_QUOTES);
                                                $ReOrder            =      htmlspecialchars($_POST["ReOrder"], ENT_QUOTES);
                                                 $itemCategory           =      htmlspecialchars($_POST["itemCategory"], ENT_QUOTES);
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
                        $tableData["itemName"] = $itemName;
                        $tableData["itemCode"] = $itemCode;
                        $tableData["itemCategory"] = $itemCategory;
                        $tableData["Uom"] = $Uom;
                        $tableData["Price"] = $Price;
                        $tableData["Qty"] = $Qty;
                        $tableData["ReOrder"] = $ReOrder;
                        $tableData["Ordered"] = "yes";
                        $tableData["manage_item_log"] = json_encode($item_log);
                        $tableData["status"] = $auth->visible();
                        // Check for duplicate data start
                        $databaseObj->select("tbl_manage_item");
                        $databaseObj->where("`status` = '".$auth->visible()."'");
                        $getItemData = $databaseObj->get();
                        $flag1 = 0;
                        $flag2 = 0;
                      if($getItemData != 0):
                          foreach($getItemData as $itemrows):
                       if ($itemrows["itemCode"] == $itemCode) {
                           $flag1++;
                       }
                       elseif ($itemrows["itemName"] == $itemName) {
                         $flag2++;
                       }
                         endforeach;
                       endif;
                       if ($flag1==0 && $flag2==0) {
                           $check = $databaseObj->insert("tbl_manage_item", $tableData);
                       }
                       else {
                         $check = 2;
                       }
                        // Check for duplicate data end
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
            // --------------------------------------------------
            // ------------ Import Data Section Start -----------
            // --------------------------------------------------
            case "importData":
                if($authority == 1):
                    if(!empty($_FILES["importedExcel"]["name"])):
                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $manageItemDir.$randSix."_".$_FILES["importedExcel"]["name"])):
                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];
                            $file_type  = PHPExcel_IOFactory::identify($manageItemDir.$fileName);
                            $objReader  = PHPExcel_IOFactory::createReader($file_type);
                            $objPHPExcel = $objReader->load($manageItemDir.$fileName);
                            $sheet_data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            $sno = 0;
                            foreach ($sheet_data as $row):
                                if(!empty($row["A"])):
                                                            $itemCode           =      htmlspecialchars($row["A"], ENT_QUOTES);
                                                            $itemName           =      htmlspecialchars($row["B"], ENT_QUOTES);
                                                            $itemCategory       =      htmlspecialchars($row["C"], ENT_QUOTES);
                                                            $Uom                =      htmlspecialchars($row["D"], ENT_QUOTES);
                                                            $Price              =      htmlspecialchars($row["E"], ENT_QUOTES);
                                                            $Qty                =      htmlspecialchars($row["F"], ENT_QUOTES);
                                                            $ReOrder            =      htmlspecialchars($row["G"], ENT_QUOTES);
                                    $item_log = array(
                                                        array(
                                                                "action"                =>      "imported",
                                                                "by"                    =>      $auth->admin_id,
                                                                "ip"                    =>      $_POST["checkIp"],
                                                                "location"              =>      $_POST["checkLocation"],
                                                                "at"                    =>      date("H:i:s A"),
                                                                "date"                  =>      date("d-m-Y")
                                                        )
                                                    );
                                    $tableData["manage_item_log"] = json_encode($item_log);
                                    $tableData["status"] = $auth->visible();
                                    // Check for duplicate data start
                                     $flag1 = 0;
                                     $flag2 = 0;
                                    $databaseObj->select("tbl_manage_item");
                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                    $getItemData = $databaseObj->get();
                                    $flag1 = 0;
                                    $flag2 = 0;
                                  if($getItemData != 0):
                                      foreach($getItemData as $itemrows):
                                   if ($itemrows["itemCode"] == $itemCode) {
                                       $flag1++;
                                   }
                                   elseif ($itemrows["itemName"] == $itemName) {
                                     $flag2++;
                                   }
                                     endforeach;
                                   endif;
                                   if ($flag1==0 && $flag2==0) {
                                     $check = $databaseObj->insert("tbl_manage_item", $tableData);
                                   }
                                   else {
                                     $check = 1;
                                   }
                                    // Check for duplicate data end
                                    if($check == 1):
                                        unset($tableData["manage_item_log"]);
                                        unset($tableData["status"]);
                                        $databaseObj->sql = "";
                                        $databaseObj->data = array();
                                        $databaseObj->dataVal = "";
                                        $sno++;
                                    endif;
                                endif;
                            endforeach;
                            if($sno > 0):
                                unlink($manageItemDir.$fileName);
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
              // echo "<pre>";
                                     // print_r($_POST);
                                   //    print_r($getData);
                                   // echo "</pre>"; 
                if($authority == 1):
                    if(!empty($_POST["editTableId"])):

                        $databaseObj->select("tbl_manage_stock");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_stock_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                                  
                                  
                        //Checking If Data Is Available
                        if($getData != 0):
                                         
                            if(!empty($_POST["editItemName"])):
                                            $project           =      htmlspecialchars($_POST["editproject"], ENT_QUOTES);
                                            $itemName           =      htmlspecialchars($_POST["editItemName"], ENT_QUOTES);
                                            $itemCode           =      htmlspecialchars($_POST["editItemCode"], ENT_QUOTES);
                                            $itemCategory       =      htmlspecialchars($_POST["editItemCategory"], ENT_QUOTES);
                                            $Uom                =      htmlspecialchars($_POST["editUom"], ENT_QUOTES);
                                            $Price              =      htmlspecialchars($_POST["editItemPrice"], ENT_QUOTES);
                                            $Qty1                =      htmlspecialchars($_POST["editQty"], ENT_QUOTES);
                                            $ReOrder            =      htmlspecialchars($_POST["editReOrder"], ENT_QUOTES);

                                             // $getItemData = $databaseObj->get();
                                            $edit_log = array(
                                                    "action"                =>      "added",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                                 );
                                                // array_push($item_log, $edit_log);
                                                $oldQty=(int)$Qty1 ;
                                                // echo  $oldQty;
                                                $tableData["project"] = $project;
                                                $tableData["itemCode"] = $itemCode;
                                                // $tableData["itemCode"] = $itemCode;
                                                $tableData["itemName"] = $itemName;
                                                $tableData["itemCategory"] = $itemCategory;
                                                $tableData["Uom"] = $Uom;
                                                $tableData["Price"] = $Price;
                                                $tableData["Qty"] = $Qty1 + $oldQty;
                                                $tableData["Uom"] = $Uom;
                                                $tableData["Reorder"] = $ReOrder;
                                                $tableData["manage_stock_log"] = json_encode($edit_log);
                                                $tableData["status"] = $auth->visible();
                                                echo "<pre>";
                                                print_r($tableData["project"]);
                                                echo "</pre>";
                                                 $check = $databaseObj->update("tbl_manage_stock", $tableData, "`manage_stock_id` = '".$_POST["editTableId"]."'");
                                                // $check = $databaseObj->update("tbl_manage_stock",$tableData);
                                   
                                                 // Check for duplicate data end
                                        if($check == 1):
                                            $data["response"] = "success";
                                            $data["responseType"] = "success";
                                            $data["responseMessage"] = "Data  edited successfully!!!";
                                        else:
                                            $data["response"] = "error";
                                            $data["responseType"] = "error";
                                           
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
                                   
                            // END getdata
                        
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
            // print_r($_POST);
                if($authority == 1):
                    if(!empty($_POST["tableName"] && $_POST["tableId"])):
                        $databaseObj->select("tbl_manage_stock");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_stock_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $manage_stock_log = json_decode($rows["manage_stock_log"]);
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
                        // array_push($manage_stock_log, $delete_log);
                        $tableData["manage_stock_log"] = json_encode($delete_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`manage_stock_id` = '".$_POST["tableId"]."'");
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
                                $databaseObj->select("tbl_manage_item");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $item_log = json_decode($rows["manage_item_log"]);
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
                                array_push($item_log, $delete_log);
                                $tableData["manage_item_log"] = json_encode($item_log);
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`manage_item_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["manage_item_log"]);
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
                            $fileName = "Stock-Details-".date("d-m-Y").".xlsx";
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
                                                         ->setTitle("Stock Deatils")
                                                         ->setSubject("Stock Deatils")
                                                         ->setDescription("Stock Deatils $fileName.")
                                                         ->setKeywords("$fileName")
                                                         ->setCategory("$fileName");
                            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:J2');
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Stock Details");
                            cellColor('B2', '001F3F');
                            fontColor('B2', 'FFFFFF', '18', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:J2')->applyFromArray($thinBorder);

                            //Setting Header --------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Item Code");
                            fontColor('B4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Item Name");
                            fontColor('C4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Item Category");
                            fontColor('D4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Uom");
                            fontColor('E4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Price");
                            fontColor('F4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Qty");
                            fontColor('G4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Re-Order Level");
                            fontColor('H4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Last Issued");
                            fontColor('I4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Last Received");
                            fontColor('J4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $inc = 5;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_manage_item");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $itemCode = $rows["itemCode"];
                                        $itemName = $rows["itemName"];
                                        $itemCategory = $rows["itemCategory"];
                                        $Uom = $rows["Uom"];
                                        $Price = $rows["Price"];
                                        $Qty = $rows["Qty"];
                                        $ReOrder = $rows["ReOrder"];
                                        $lastIssued = $rows["lastIssued"];
                                        $lastReceived = $rows["lastReceived"];
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section Start ----------------------
                                        //-----------------------------------------------------------------
                                        $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('B'.$inc, $itemCode)
                                            ->setCellValue('C'.$inc, $itemName)
                                            ->setCellValue('D'.$inc, $itemCategory)
                                            ->setCellValue('E'.$inc, $Uom)
                                            ->setCellValue('F'.$inc, $Price)
                                            ->setCellValue('G'.$inc, $Qty)
                                            ->setCellValue('H'.$inc, $ReOrder)
                                            ->setCellValue('I'.$inc, $lastIssued)
                                            ->setCellValue('J'.$inc, $lastReceived);
                                        $inc++;
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section End ------------------------
                                        //-----------------------------------------------------------------
                                    endforeach;
                                endif;
                            endforeach;
                            // ----------------------------------------------------------------
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
                                $databaseObj->select("tbl_manage_item");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $item_log = json_decode($rows["manage_item_log"]);
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
                                array_push($item_log, $delete_log);
                                $tableData["manage_item_log"] = json_encode($item_log);
                                $tableData["status"] = $auth->trash();
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`manage_item_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["manage_item_log"]);
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
