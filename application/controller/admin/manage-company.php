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

    $manageCompanyDir = "../../../assets/admin/manage-company/";

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

                    if(!empty($_POST["companyName"] && $_POST["companyCity"] && $_POST["companyState"] && $_POST["companyPincode"])):

                        if(!empty($_FILES["companyLogo"]["name"])):

                            if(move_uploaded_file($_FILES["companyLogo"]["tmp_name"] , $manageCompanyDir.$randSix."_".$_FILES["companyLogo"]["name"])):

                                $companyLogo = $randSix."_".$_FILES["companyLogo"]["name"];

                            else:

                                $companyLogo = "default";

                            endif;

                        else:

                            $companyLogo = "default";

                        endif;

                        $company_info = array(

                                                "companyLogo"           =>      htmlspecialchars($companyLogo, ENT_QUOTES),

                                                "companyName"           =>      htmlspecialchars($_POST["companyName"], ENT_QUOTES),

                                                "companyContactNumber"  =>      htmlspecialchars($_POST["companyContactNumber"], ENT_QUOTES),

                                                "companyEmail"          =>      htmlspecialchars($_POST["companyEmail"], ENT_QUOTES),

                                                "companyGSTIN"          =>      htmlspecialchars($_POST["companyGSTIN"], ENT_QUOTES),

                                                "companyCity"           =>      htmlspecialchars($_POST["companyCity"], ENT_QUOTES),

                                                "companyState"          =>      htmlspecialchars($_POST["companyState"], ENT_QUOTES),

                                                "companyPincode"        =>      htmlspecialchars($_POST["companyPincode"], ENT_QUOTES),

                                                "companyAddress"        =>      htmlspecialchars($_POST["companyAddress"], ENT_QUOTES)

                                        );

                        $company_log = array(

                                            array(

                                                    "action"                =>      "added",

                                                    "by"                    =>      $auth->admin_id,

                                                    "ip"                    =>      $_POST["checkIp"],

                                                    "location"              =>      $_POST["checkLocation"],

                                                    "at"                    =>      date("H:i:s A"),

                                                    "date"                  =>      date("d-m-Y")

                                            )

                                        );

                        $tableData["manage_company_info"] = json_encode($company_info);

                        $tableData["manage_company_log"] = json_encode($company_log);

                        $tableData["status"] = $auth->visible();

                        $check = $databaseObj->insert("tbl_manage_company", $tableData);

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

                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $manageCompanyDir.$randSix."_".$_FILES["importedExcel"]["name"])):

                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];

                            $file_type	= PHPExcel_IOFactory::identify($manageCompanyDir.$fileName);

                            $objReader	= PHPExcel_IOFactory::createReader($file_type);

                            $objPHPExcel = $objReader->load($manageCompanyDir.$fileName);

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

                                    $tableData["manage_company_info"] = json_encode($company_info);

                                    $tableData["manage_company_log"] = json_encode($company_log);

                                    $tableData["status"] = $auth->visible();

                                    $check = $databaseObj->insert("tbl_manage_company", $tableData);

                                    if($check == 1):

                                        unset($tableData["manage_company_info"]); 

                                        unset($tableData["manage_company_log"]); 

                                        unset($tableData["status"]);

                                        $databaseObj->sql = "";

                                        $databaseObj->data = array();

                                        $databaseObj->dataVal = "";

                                        $sno++;

                                    endif;

                                endif;

                            endforeach;

                            if($sno > 0):

                                unlink($manageCompanyDir.$fileName);

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

                        $databaseObj->select("tbl_manage_company");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$_POST["editTableId"]."'");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            $sno = 1;

                            foreach($getData as $rows):

                                $company_info = json_decode($rows["manage_company_info"]);

                                $company_log = json_decode($rows["manage_company_log"]);

                            endforeach;

                            if(!empty($_POST["editCompanyName"] && $_POST["editCompanyCity"] && $_POST["editCompanyState"] && $_POST["editCompanyPincode"])):

                                if(!empty($_FILES["editCompanyLogo"]["name"])):

                                    if(move_uploaded_file($_FILES["editCompanyLogo"]["tmp_name"] , $manageCompanyDir.$randSix."_".$_FILES["editCompanyLogo"]["name"])):

                                        $companyLogo = $randSix."_".$_FILES["editCompanyLogo"]["name"];

                                        $companyLogo = htmlspecialchars($companyLogo, ENT_QUOTES);

                                        if($company_info->companyLogo != "default"):

                                            if(file_exists($manageCompanyDir.str_replace("&#039;", "'", $company_info->companyLogo))):

                                                unlink($manageCompanyDir.str_replace("&#039;", "'", $company_info->companyLogo));

                                            endif;

                                        endif;

                                    else:

                                        $companyLogo = $company_info->companyLogo;

                                    endif;

                                else:

                                    $companyLogo = $company_info->companyLogo;

                                endif;

                                $edit_info = array(

                                                        "companyLogo"           =>      $companyLogo,

                                                        "companyName"           =>      htmlspecialchars($_POST["editCompanyName"], ENT_QUOTES),

                                                        "companyContactNumber"  =>      htmlspecialchars($_POST["editCompanyContactNumber"], ENT_QUOTES),

                                                        "companyEmail"          =>      htmlspecialchars($_POST["editCompanyEmail"], ENT_QUOTES),

                                                        "companyGSTIN"          =>      htmlspecialchars($_POST["editCompanyGSTIN"], ENT_QUOTES),

                                                        "companyCity"           =>      htmlspecialchars($_POST["editCompanyCity"], ENT_QUOTES),

                                                        "companyState"          =>      htmlspecialchars($_POST["editCompanyState"], ENT_QUOTES),

                                                        "companyPincode"        =>      htmlspecialchars($_POST["editCompanyPincode"], ENT_QUOTES),

                                                        "companyAddress"        =>      htmlspecialchars($_POST["editCompanyAddress"], ENT_QUOTES),

                                                );

                                 

                                 $edit_log = array(

                                                    "action"                =>      "edited",

                                                    "by"                    =>      $auth->admin_id,

                                                    "ip"                    =>      $_POST["checkIp"],

                                                    "location"              =>      $_POST["checkLocation"],

                                                    "at"                    =>      date("H:i:s A"),

                                                    "date"                  =>      date("d-m-Y")

                                            );

                                array_push($company_log, $edit_log);

                                $tableData["manage_company_info"] = json_encode($edit_info);

                                $tableData["manage_company_log"] = json_encode($company_log);

                                $tableData["status"] = $auth->visible();

                                $check = $databaseObj->update("tbl_manage_company", $tableData, "`manage_company_id` = '".$_POST["editTableId"]."'");

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

                        $databaseObj->select("tbl_manage_company");

                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$_POST["tableId"]."'");

                        $getData = $databaseObj->get();

                        //Checking If Data Is Available

                        if($getData != 0):

                            $sno = 1;

                            foreach($getData as $rows):

                                $company_log = json_decode($rows["manage_company_log"]);

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

                        $tableData["manage_company_log"] = json_encode($company_log);

                        $tableData["status"] = $auth->trash();

                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`manage_company_id` = '".$_POST["tableId"]."'");

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

                                $databaseObj->select("tbl_manage_company");

                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$selectedIds."'");

                                $getData = $databaseObj->get();

                                //Checking If Data Is Available

                                if($getData != 0):

                                    foreach($getData as $rows):

                                        $company_log = json_decode($rows["manage_company_log"]);

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

                                $tableData["manage_company_log"] = json_encode($company_log);

                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`manage_company_id` = '".$selectedIds."'");

                                $databaseObj->error();

                                if($check == 1):

                                    unset($tableData["manage_company_log"]); 

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

                                $databaseObj->select("tbl_manage_company");

                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$selectedIds."'");

                                $getData = $databaseObj->get();

                                //Checking If Data Is Available

                                if($getData != 0):

                                    foreach($getData as $rows):

                                        $company_info = json_decode($rows["manage_company_info"]);

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

                                $databaseObj->select("tbl_manage_company");

                                $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$selectedIds."'");

                                $getData = $databaseObj->get();

                                //Checking If Data Is Available

                                if($getData != 0):

                                    foreach($getData as $rows):

                                        $company_log = json_decode($rows["manage_company_log"]);

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

                                $tableData["manage_company_log"] = json_encode($company_log);

                                $tableData["status"] = $auth->trash();

                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`manage_company_id` = '".$selectedIds."'");

                                $databaseObj->error();

                                if($check == 1):

                                    unset($tableData["manage_company_log"]); 

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