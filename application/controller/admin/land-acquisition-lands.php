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
    $landAcquisitionLandsDir = "../../../assets/admin/land-acquisition-lands/";
    $landAcquisitionLandsDirTemp = "../../../assets/admin/land-acquisition-lands/temp/";
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
                    if(!empty($_POST["landState"] && $_POST["landCity"] && $_POST["landUnit"] && $_POST["landSubUnit"] && $_POST["landStreetName"] && $_POST["landLandMark"] && $_POST["landLineNo"] && $_POST["landPincode"] && $_POST["landAddress"] && $_POST["totalLandInfo"] && $_POST["landInfoType"] && $_POST["landInfoArea"] && $_POST["landInfoUOM"] && $_POST["landInfoPricePerUOM"] && $_POST["landInfoTotalPrice"] && $_POST["landInfoRemarks"] && $_POST["landInfoRemarks"] && $_POST["totalNumberOfDivision"] && $_POST["landPurchasePaymentStuctureWhen"] && $_POST["landPurchasePaymentStuctureDate"] && $_POST["landPurchasePaymentStuctureCompletion"] && $_POST["landPurchasePaymentStuctureCompletion"] && $_POST["landPurchasePaymentStuctureAmount"] && $_POST["landPurchasePaymentStuctureRemark"]&& $_POST["ownerName"] && $_POST["landOwnerName"] && $_POST["landInfoTotalCompletePrice"] && $_POST["landPurchaseTotalPrice"] && $_POST["landPurchaseDealingPrice"] && $_POST["landPurchaseDealingPrice"] && $_POST["landPurchaseCondition"])):
          
               
              // Image upload file
                $landImgList=""; //image name collection variable
                $preImageFiles=$_POST['landPurchaseAttacmentsImagesAll'];//save pereload images into variable
                $preImageFiles_arr = explode(',', $preImageFiles); //string to array conversion
                // code for pre upload image upload to directory
                if(!empty($preImageFiles))
                {    
                    foreach($preImageFiles_arr as $key=>$val)
                    { 
                        if(rename($landAcquisitionLandsDirTemp.$preImageFiles_arr[$key], $landAcquisitionLandsDir.$preImageFiles_arr[$key])){
                                 $landImgList .= $preImageFiles_arr[$key].",";
                                 //unlink($landAcquisitionLandsDirTemp.$preImageFiles_arr[$key]);
                            }
                            // else{
                            //     $landImgList .="empty,";
                            // }
                    }#for end
                }#end if

                $imageFiles = $_FILES['landPurchaseAttacmentsImages']['name']; 
                if(!empty($imageFiles))
                {    
                   foreach($_FILES['landPurchaseAttacmentsImages']['name'] as $key=>$val)
                  { 
                    if(move_uploaded_file($_FILES["landPurchaseAttacmentsImages"]["tmp_name"][$key] , $landAcquisitionLandsDir.$randSix."_".$_FILES["landPurchaseAttacmentsImages"]["name"][$key]))
                        {
                            $landImgList .= $randSix."_".$_FILES["landPurchaseAttacmentsImages"]["name"][$key].",";

                        }
                    // else{
                    //         $landImgList .="empty,";
                    //     }
                 }#for end
              }#end if 

              // document upload file
              $landDocList=""; //document name collection variable
                $preDocFiles=$_POST['landPurchaseAttacmentsDocumentsAll'];//save pereload images into variable
                $preDocFiles_arr = explode(',', $preDocFiles); //string to array conversion
                // code for pre upload image upload to directory
                if(!empty($preDocFiles))
                {    
                    foreach($preDocFiles_arr as $key=>$val)
                    { 
                        if(rename($landAcquisitionLandsDirTemp.$preDocFiles_arr[$key], $landAcquisitionLandsDir.$preDocFiles_arr[$key])){
                                 $landDocList .= $preDocFiles_arr[$key].",";
                                 //unlink($landAcquisitionLandsDirTemp.$preImageFiles_arr[$key]);
                            }
                            else{
                                $landDocList .="empty,";
                            }
                    }#for end
                }#end if

                $docFiles = $_FILES['landPurchaseAttacmentsDocuments']['name']; 
                if(!empty($docFiles))
                {    
                   foreach($_FILES['landPurchaseAttacmentsDocuments']['name'] as $key=>$val)
                  { 
                   if(move_uploaded_file($_FILES["landPurchaseAttacmentsDocuments"]["tmp_name"][$key] , $landAcquisitionLandsDir.$randSix."_".$_FILES["landPurchaseAttacmentsDocuments"]["name"][$key]))
                        {
                            $landDocList .= $randSix."_".$_FILES["landPurchaseAttacmentsDocuments"]["name"][$key].",";
                        }
                    else{
                            $landDocList .="empty,";
                        }
                 }#for end
              }#end if 


                // pdf file uploading code
              $landPdfList=""; //document name collection variable
                $prePdfFiles=$_POST['landPurchaseAttacmentsPdfAll'];//save pereload images into variable
                $prePdfFiles_arr = explode(',', $prePdfFiles); //string to array conversion
                // code for pre upload image upload to directory
                if(!empty($prePdfFiles))
                {    
                    foreach($prePdfFiles_arr as $key=>$val)
                    { 
                        if(rename($landAcquisitionLandsDirTemp.$prePdfFiles_arr[$key], $landAcquisitionLandsDir.$prePdfFiles_arr[$key])){
                                 $landPdfList .= $prePdfFiles_arr[$key].",";
                                 //unlink($landAcquisitionLandsDirTemp.$preImageFiles_arr[$key]);
                            }
                            else{
                                $landPdfList .="empty,";
                            }
                    }#for end
                }#end if

                $pdfFiles = $_FILES['landPurchaseAttacmentsPdf']['name']; 
                if(!empty($pdfFiles))
                {    
                   foreach($_FILES['landPurchaseAttacmentsPdf']['name'] as $key=>$val)
                  { 
                   if(move_uploaded_file($_FILES["landPurchaseAttacmentsPdf"]["tmp_name"][$key] , $landAcquisitionLandsDir.$randSix."_".$_FILES["landPurchaseAttacmentsPdf"]["name"][$key]))
                        {
                            $landPdfList .= $randSix."_".$_FILES["landPurchaseAttacmentsPdf"]["name"][$key].",";
                        }
                    else{
                            $landPdfList .="empty,";
                        }
                 }#for end
              }#end if 



                // excel file uploading code
              $landExcelList=""; //document name collection variable
                $preExcelFiles=$_POST['landPurchaseAttacmentsExcelAll'];//save pereload images into variable
                $preExcelFiles_arr = explode(',', $preExcelFiles); //string to array conversion
                // code for pre upload image upload to directory
                if(!empty($preExcelFiles))
                {    
                    foreach($preExcelFiles_arr as $key=>$val)
                    { 
                        if(rename($landAcquisitionLandsDirTemp.$preExcelFiles_arr[$key], $landAcquisitionLandsDir.$preExcelFiles_arr[$key])){
                                 $landExcelList .= $preExcelFiles_arr[$key].",";
                                 //unlink($landAcquisitionLandsDirTemp.$preImageFiles_arr[$key]);
                            }
                            else{
                                $landExcelList .="empty,";
                            }
                    }#for end
                }#end if

                $docFiles = $_FILES['landPurchaseAttacmentsExcel']['name']; 
                if(!empty($docFiles))
                {    
                   foreach($_FILES['landPurchaseAttacmentsExcel']['name'] as $key=>$val)
                  { 
                   if(move_uploaded_file($_FILES["landPurchaseAttacmentsExcel"]["tmp_name"][$key] , $landAcquisitionLandsDir.$randSix."_".$_FILES["landPurchaseAttacmentsExcel"]["name"][$key]))
                        {
                            $landExcelList .= $randSix."_".$_FILES["landPurchaseAttacmentsExcel"]["name"][$key].",";
                        }
                    else{
                            $landExcelList .="empty,";
                        }
                 }#for end
              }#end if 


            
                    // echo var_dump($preImageFiles_arr);
                   // echo $landImgList;
                   // exit(0);
                        $flag = 1;
                        $landInfo = array();
                        for($i = 0; $i<$_POST["totalLandInfo"]; $i++):
                            $landInfoType=null;
                            $landInfoArea=null;
                            $landInfoUOM=null;
                            $landInfoPricePerUOM=null;
                            $landInfoTotalPrice=null;
                            $landInfoRemarks=null;
                            if(empty($_POST["landInfoType"][$i])):
                                $flag = 0;
                            else:
                                $landInfoType = $_POST["landInfoType"][$i];
                            endif;
                            if(empty($_POST["landInfoArea"][$i])):
                                $flag = 0;
                            else:
                                $landInfoArea = $_POST["landInfoArea"][$i];
                            endif;
                            if(empty($_POST["landInfoUOM"][$i])):
                                $flag = 0;
                            else:
                                $landInfoUOM = $_POST["landInfoUOM"][$i];
                            endif;
                            if(empty($_POST["landInfoPricePerUOM"][$i])):
                                $flag = 0;
                            else:
                                $landInfoPricePerUOM = $_POST["landInfoPricePerUOM"][$i];
                            endif;
                            if(empty($_POST["landInfoTotalPrice"][$i])):
                                $flag = 0;
                            else:
                                $landInfoTotalPrice = $_POST["landInfoTotalPrice"][$i];
                            endif;
                            if(empty($_POST["landInfoRemarks"][$i])):
                                $flag = 0;
                            else:
                                $landInfoRemarks = $_POST["landInfoRemarks"][$i];
                            endif;
                            $tempLandInfo = array(
                                                "landType"                                 =>      htmlspecialchars($landInfoType, ENT_QUOTES),
                                                "landArea"                                 =>      htmlspecialchars($landInfoArea, ENT_QUOTES),
                                                "UOM"                 =>      htmlspecialchars($landInfoUOM, ENT_QUOTES),
                                                "landPricePerUOM"                          =>      htmlspecialchars($landInfoPricePerUOM, ENT_QUOTES),
                                                "landTotalPrice"                     =>      htmlspecialchars($landInfoTotalPrice, ENT_QUOTES),
                                                "landRemarks"                            =>      htmlspecialchars($landInfoRemarks, ENT_QUOTES),
                                            );
                            array_push($landInfo, $tempLandInfo);
                            unset($tempLandInfo);
                        endfor;
                        // land payment information 
                          $landPurchase = array();
                         for($i = 0; $i<$_POST["totalNumberOfDivision"]; $i++):
                            $landPaymentStuctureWhen=null;
                            $landPaymentStuctureDate=null;
                            $landPaymentStuctureCompletion=null;
                            $landPaymentStuctureAmount=null;
                            $landPaymentStuctureRemark=null;
                            if(empty($_POST["landPurchasePaymentStuctureWhen"][$i])):
                                $flag = 0;
                            else:
                                $landPaymentStuctureWhen = $_POST["landPurchasePaymentStuctureWhen"][$i];
                            endif;
                            if(empty($_POST["landPurchasePaymentStuctureDate"][$i])):
                                $flag = 0;
                            else:
                                $landPaymentStuctureDate = $_POST["landPurchasePaymentStuctureDate"][$i];
                            endif;
                            if(empty($_POST["landPurchasePaymentStuctureCompletion"][$i])):
                                $flag = 0;
                            else:
                                $landPaymentStuctureCompletion = $_POST["landPurchasePaymentStuctureCompletion"][$i];
                            endif;
                            if(empty($_POST["landPurchasePaymentStuctureAmount"][$i])):
                                $flag = 0;
                            else:
                                $landPaymentStuctureAmount = $_POST["landPurchasePaymentStuctureAmount"][$i];
                            endif;
                            if(empty($_POST["landPurchasePaymentStuctureRemark"][$i])):
                                $flag = 0;
                            else:
                                $landPaymentStuctureRemark = $_POST["landPurchasePaymentStuctureRemark"][$i];
                            endif;
                            $tempPaymentInfo = array(
                                                "when"                                 =>      htmlspecialchars($landPaymentStuctureWhen, ENT_QUOTES),
                                                "date"                                 =>      htmlspecialchars($landPaymentStuctureDate, ENT_QUOTES),
                                                "completion"                 =>      htmlspecialchars($landPaymentStuctureCompletion, ENT_QUOTES),
                                                "amount"                          =>      htmlspecialchars($landPaymentStuctureAmount, ENT_QUOTES),
                                                "remark"                     =>      htmlspecialchars($landPaymentStuctureRemark, ENT_QUOTES)
                                            );
                            array_push($landPurchase, $tempPaymentInfo);
                            unset($tempPaymentInfo);
                        endfor;
            $land_location = array(
                    "ownerId"       =>      htmlspecialchars($_POST["ownerName"], ENT_QUOTES),
                    "ownerName"       =>      htmlspecialchars($_POST["landOwnerName"], ENT_QUOTES),
                    "landState"       =>      htmlspecialchars($_POST["landState"], ENT_QUOTES),
                    "landCity"        =>      htmlspecialchars($_POST["landCity"], ENT_QUOTES),
                    "landUnit"        =>      htmlspecialchars($_POST["landUnit"], ENT_QUOTES),
                    "landSubUnit"     =>      htmlspecialchars($_POST["landSubUnit"], ENT_QUOTES),
                    "landStreetName" =>      htmlspecialchars($_POST["landStreetName"], ENT_QUOTES),
                    "landLandMark"    =>      htmlspecialchars($_POST["landLandMark"], ENT_QUOTES),
                    "landLineNo"      =>      htmlspecialchars($_POST["landLineNo"], ENT_QUOTES),
                    "landPincode"     =>      htmlspecialchars($_POST["landPincode"], ENT_QUOTES),
                    "landAddress"     =>      htmlspecialchars($_POST["landAddress"], ENT_QUOTES)
                );
                $land_info = array(
                            "landInfo"          =>  $landInfo,
                            "TotalCompletePrice" =>   htmlspecialchars($_POST["landInfoTotalCompletePrice"], ENT_QUOTES) 
                            );
                $land_purchase = array(
                        "totalPrice"         =>  htmlspecialchars($_POST["landPurchaseTotalPrice"], ENT_QUOTES),
                        "dealingPrice"         =>  htmlspecialchars($_POST["landPurchaseDealingPrice"], ENT_QUOTES),
                        "dealingPriceInWords"     =>  htmlspecialchars($_POST["landPurchaseDealingPrice"], ENT_QUOTES),
                        "purchaseCondition"     =>  htmlspecialchars($_POST["landPurchaseCondition"], ENT_QUOTES) 
                            );
                 $land_payment = array(
                            "landPaymentInfo"          =>  $landPurchase    
                            );
                $land_docs = array(
                            "landImages"          =>  $landImgList,
                            "landDocs"     =>  $landDocList,
                            "landPdfs"  =>  $landPdfList,
                            "landExcel" => $landExcelList
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
                        $tableData["land_location"] = json_encode($land_location);
                        $tableData["land_info"] = json_encode($land_info);
                        $tableData["land_purchase"] = json_encode($land_purchase);
                        $tableData["land_payment"] = json_encode($land_payment);
                         $tableData["land_docs"] = json_encode($land_docs);
                        $tableData["land_log"] = json_encode($land_log);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_land", $tableData);
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
            case "addLandPurchaseCondition":
                if($authority == 1):
                    if(!empty($_POST["landPurchaseConditionAdd"])):
                        $land_info = array(
                                                "landPurchaseCondition"          =>      htmlspecialchars($_POST["landPurchaseConditionAdd"], ENT_QUOTES)
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
                        $tableData["land_purchase_condition_info"] = json_encode($land_info);
                        $tableData["land_purchase_condition_log"] = json_encode($land_log);
                        $tableData["status"] = $auth->visible();
                        $check = $databaseObj->insert("tbl_land_purchase_condition", $tableData);
                        if($check == 1):
                            $data["response"] = "success";
                            $data["responseType"] = "success";
                            $data["responseMessage"] = "Condition added successfully!!!";
                            $data["responseId"] = $databaseObj->last_inserted_id();
                        else:
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Something went wrong please try again!!!";
                        endif;
                    else:
                        $data["response"] = "empty";
                        $data["responseType"] = "warning";
                        $data["responseMessage"] = "Please give Condition!!!";
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
                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $landAcquisitionLandsDir.$randSix."_".$_FILES["importedExcel"]["name"])):
                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];
                            $file_type	= PHPExcel_IOFactory::identify($landAcquisitionLandsDir.$fileName);
                            $objReader	= PHPExcel_IOFactory::createReader($file_type);
                            $objPHPExcel = $objReader->load($landAcquisitionLandsDir.$fileName);
                            $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            $sno = 0;
                            foreach ($sheet_data as $row):   
                                if(!empty($row["A"])):
                                    $land_info = array(
                                                            "landLogo"             =>      "default",
                                                            "landName"             =>      htmlspecialchars($row["A"], ENT_QUOTES),
                                                            "landContactNumber"    =>      htmlspecialchars($row["B"], ENT_QUOTES),
                                                            "landOfficeNumber"     =>      htmlspecialchars($row["C"], ENT_QUOTES),
                                                            "landEmail"            =>      htmlspecialchars($row["D"], ENT_QUOTES),
                                                            "landWebsite"          =>      htmlspecialchars($row["E"], ENT_QUOTES),
                                                            "landPanNo"            =>      htmlspecialchars($row["F"], ENT_QUOTES),
                                                            "landAadharNo"         =>      htmlspecialchars($row["G"], ENT_QUOTES),
                                                            "landGSTIN"            =>      htmlspecialchars($row["H"], ENT_QUOTES),
                                                            "landState"            =>      htmlspecialchars($row["I"], ENT_QUOTES),
                                                            "landCity"             =>      htmlspecialchars($row["J"], ENT_QUOTES),
                                                            "landPincode"          =>      htmlspecialchars($row["K"], ENT_QUOTES),
                                                            "landAddress"          =>      htmlspecialchars($row["L"], ENT_QUOTES)
                                                    );
                                    $land_log = array(
                                                        array(
                                                                "action"                =>      "imported",
                                                                "by"                    =>      $auth->admin_id,
                                                                "ip"                    =>      $_POST["checkIp"],
                                                                "location"              =>      $_POST["checkLocation"],
                                                                "at"                    =>      date("H:i:s A"),
                                                                "date"                  =>      date("d-m-Y")
                                                        )
                                                    );
                                    $tableData["land_info"] = json_encode($land_info);
                                    $tableData["land_log"] = json_encode($land_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->insert("tbl_land", $tableData);
                                    if($check == 1):
                                        unset($tableData["land_info"]); 
                                        unset($tableData["land_log"]); 
                                        unset($tableData["status"]);
                                        $databaseObj->sql = "";
                                        $databaseObj->data = array();
                                        $databaseObj->dataVal = "";
                                        $sno++;
                                    endif;
                                endif;
                            endforeach;
                            if($sno > 0):
                                unlink($landAcquisitionLandsDir.$fileName);
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
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $land_info = json_decode($rows["land_info"]);
                                $land_log = json_decode($rows["land_log"]);
                            endforeach;
                            if(!empty($_POST["editLandName"] && $_POST["editLandCity"] && $_POST["editLandState"] && $_POST["editLandPincode"] && $_POST["editLandContactNumber"] && $_POST["editLandOfficeNumber"] && $_POST["editLandEmail"] && $_POST["editLandAddress"] && $_POST["editLandPanNo"] && $_POST["editLandAadharNo"])):
                                if(!empty($_FILES["editLandLogo"]["name"])):
                                    if(move_uploaded_file($_FILES["editLandLogo"]["tmp_name"] , $landAcquisitionLandsDir.$randSix."_".$_FILES["editLandLogo"]["name"])):
                                        $landLogo = $randSix."_".$_FILES["editLandLogo"]["name"];
                                        $landLogo = htmlspecialchars($landLogo, ENT_QUOTES);
                                        if($land_info->landLogo != "default"):
                                            if(file_exists($landAcquisitionLandsDir.str_replace("&#039;", "'", $land_info->landLogo))):
                                                unlink($landAcquisitionLandsDir.str_replace("&#039;", "'", $land_info->landLogo));
                                            endif;
                                        endif;
                                    else:
                                        $landLogo = $land_info->landLogo;
                                    endif;
                                else:
                                    $landLogo = $land_info->landLogo;
                                endif;
                                $edit_info = array(
                                                        "landLogo"             =>      $landLogo,
                                                        "landName"             =>      htmlspecialchars($_POST["editLandName"], ENT_QUOTES),
                                                        "landContactNumber"    =>      htmlspecialchars($_POST["editLandContactNumber"], ENT_QUOTES),
                                                        "landOfficeNumber"     =>      htmlspecialchars($_POST["editLandOfficeNumber"], ENT_QUOTES),
                                                        "landEmail"            =>      htmlspecialchars($_POST["editLandEmail"], ENT_QUOTES),
                                                        "landWebsite"          =>      htmlspecialchars($_POST["editLandWebsite"], ENT_QUOTES),
                                                        "landPanNo"            =>      htmlspecialchars($_POST["editLandPanNo"], ENT_QUOTES),
                                                        "landAadharNo"         =>      htmlspecialchars($_POST["editLandAadharNo"], ENT_QUOTES),
                                                        "landGSTIN"            =>      htmlspecialchars($_POST["editLandGSTIN"], ENT_QUOTES),
                                                        "landState"            =>      htmlspecialchars($_POST["editLandState"], ENT_QUOTES),
                                                        "landCity"             =>      htmlspecialchars($_POST["editLandCity"], ENT_QUOTES),
                                                        "landPincode"          =>      htmlspecialchars($_POST["editLandPincode"], ENT_QUOTES),
                                                        "landAddress"          =>      htmlspecialchars($_POST["editLandAddress"], ENT_QUOTES)
                                                );
                                 
                                 $edit_log = array(
                                                    "action"                =>      "edited",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                                array_push($land_log, $edit_log);
                                $tableData["land_info"] = json_encode($edit_info);
                                $tableData["land_log"] = json_encode($land_log);
                                $tableData["status"] = $auth->visible();
                                $check = $databaseObj->update("tbl_land", $tableData, "`land_id` = '".$_POST["editTableId"]."'");
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
                        $databaseObj->select("tbl_land");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $land_log = json_decode($rows["land_log"]);
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
                        array_push($land_log, $delete_log);
                        $tableData["land_log"] = json_encode($land_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`land_id` = '".$_POST["tableId"]."'");
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
                                $databaseObj->select("tbl_land");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $land_log = json_decode($rows["land_log"]);
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
                                array_push($land_log, $delete_log);
                                $tableData["land_log"] = json_encode($land_log);
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`land_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["land_log"]); 
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
                            $fileName = "Lands-".date("d-m-Y").".xlsx";
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
                                                         ->setTitle("Lands")
                                                         ->setSubject("Lands")
                                                         ->setDescription("Lands $fileName.")
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
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:M2');
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Lands");
                            cellColor('B2', '001F3F');
                            fontColor('B2', 'FFFFFF', '18', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B2:M2')->applyFromArray($thinBorder);

                            //Setting Header --------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Land Name");
                            fontColor('B4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Contact Number");
                            fontColor('C4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Office Number");
                            fontColor('D4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Email");
                            fontColor('E4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Website");
                            fontColor('F4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Pan No");
                            fontColor('G4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Aadhar No");
                            fontColor('H4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "GST IN");
                            fontColor('I4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "City");
                            fontColor('J4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "State");
                            fontColor('K4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Pincode");
                            fontColor('L4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($thinBorder);
                            // ----------------------------------------------------------------
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Address");
                            fontColor('M4', '001F3F', '10', 'serif', true);
                            $objPHPExcel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getStyle('M4')->applyFromArray($thinBorder);
                            $inc = 5;
                            foreach($_POST["checkbox-select"] as $selectedIds):
                                $databaseObj->select("tbl_land");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $land_info = json_decode($rows["land_info"]);
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section Start ----------------------
                                        //-----------------------------------------------------------------
                                        $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('B'.$inc, $land_info->landName)
                                            ->setCellValue('C'.$inc, $land_info->landContactNumber)
                                            ->setCellValue('D'.$inc, $land_info->landOfficeNumber)
                                            ->setCellValue('E'.$inc, $land_info->landEmail)
                                            ->setCellValue('F'.$inc, $land_info->landWebsite)
                                            ->setCellValue('G'.$inc, $land_info->landPanNo)
                                            ->setCellValue('H'.$inc, $land_info->landAadharNo)
                                            ->setCellValue('I'.$inc, $land_info->landGSTIN)
                                            ->setCellValue('J'.$inc, $land_info->landCity)
                                            ->setCellValue('K'.$inc, $land_info->landState)
                                            ->setCellValue('L'.$inc, $land_info->landPincode)
                                            ->setCellValue('M'.$inc, $land_info->landAddress);
                                        $objPHPExcel->getActiveSheet()->getStyle('B'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('C'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('D'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('E'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('F'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('G'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('H'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('I'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('J'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('K'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('L'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        $objPHPExcel->getActiveSheet()->getStyle('M'.$inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        fontColor('B'.$inc, '000000', '12', '', true);
                                        fontColor('I'.$inc, '000000', '12', '', true);
                                        $inc++;
                                        //-----------------------------------------------------------------
                                        //----------------------- Data Section End ------------------------
                                        //-----------------------------------------------------------------
                                    endforeach;
                                endif;
                            endforeach;
                            // ----------------------------------------------------------------
                            $objPHPExcel->getActiveSheet()->getStyle('B5:M'.--$inc)->applyFromArray($thinBorder);
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
                                $databaseObj->select("tbl_land");
                                $databaseObj->where("`status` = '".$auth->visible()."' && `land_id` = '".$selectedIds."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if($getData != 0):
                                    foreach($getData as $rows):
                                        $land_log = json_decode($rows["land_log"]);
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
                                array_push($land_log, $delete_log);
                                $tableData["land_log"] = json_encode($land_log);
                                $tableData["status"] = $auth->trash();
                                $check = $databaseObj->update($_POST["nameOfATable"], $tableData, "`land_id` = '".$selectedIds."'");
                                $databaseObj->error();
                                if($check == 1):
                                    unset($tableData["land_log"]); 
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
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //*************************************** File Upload Section Starts Here ***************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************

            // ----------------------------------------------------
            // ------------ Upload Images Section Start -----------
            // ----------------------------------------------------
            case "landPurchaseAttacmentsImagesUploadNow":
                if($authority == 1):
                    if(isset($_FILES["landPurchaseAttacmentsImages"]["name"])):
                        $allFileHere = array();
                        for($i = 0; $i < count($_FILES["landPurchaseAttacmentsImages"]["name"]); $i++):
                            if(!empty($_FILES["landPurchaseAttacmentsImages"]["name"][$i])):
                                if(move_uploaded_file($_FILES["landPurchaseAttacmentsImages"]["tmp_name"][$i] , $landAcquisitionLandsDirTemp.$randSix."_".$_FILES["landPurchaseAttacmentsImages"]["name"][$i])):
                                    array_push($allFileHere, $randSix."_".$_FILES["landPurchaseAttacmentsImages"]["name"][$i]);
                                else:
                                    // array_push($allFileHere, "default");
                                    continue;
                                endif;
                            endif;
                        endfor;
                        //Send Uploaded Message
                        if(count($allFileHere) > 0){
                            $data["response"] = "success";
                            $data["responseType"] = "info";
                            $data["responseMessage"] = "Images Uploaded!!!";
                            $data["responseAre"] = implode(",", $allFileHere);
                        } else{
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Error uploading your files, Please try again!!!";
                        }
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
            // ----------------------------------------------------
            // ------------ Upload Images Section End -------------
            // ----------------------------------------------------
            // ----------------------------------------------------
            // ------------ Upload Documents Section Start -----------
            // ----------------------------------------------------
            case "landPurchaseAttacmentsDocumentsUploadNow":
                if($authority == 1):
                    if(isset($_FILES["landPurchaseAttacmentsDocuments"]["name"])):
                        $allFileHere = array();
                        for($i = 0; $i < count($_FILES["landPurchaseAttacmentsDocuments"]["name"]); $i++):
                            if(!empty($_FILES["landPurchaseAttacmentsDocuments"]["name"][$i])):
                                if(move_uploaded_file($_FILES["landPurchaseAttacmentsDocuments"]["tmp_name"][$i] , $landAcquisitionLandsDirTemp.$randSix."_".$_FILES["landPurchaseAttacmentsDocuments"]["name"][$i])):
                                    array_push($allFileHere, $randSix."_".$_FILES["landPurchaseAttacmentsDocuments"]["name"][$i]);
                                else:
                                    // array_push($allFileHere, "default");
                                    continue;
                                endif;
                            endif;
                        endfor;
                        //Send Uploaded Message
                        if(count($allFileHere) > 0){
                            $data["response"] = "success";
                            $data["responseType"] = "info";
                            $data["responseMessage"] = "Documents Uploaded!!!";
                            $data["responseAre"] = implode(",", $allFileHere);
                        } else{
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Error uploading your files, Please try again!!!";
                        }
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
            // ----------------------------------------------------
            // ------------ Upload Documents Section End -------------
            // ----------------------------------------------------
            // ----------------------------------------------------
            // ------------ Upload Pdf Section Start -----------
            // ----------------------------------------------------
            case "landPurchaseAttacmentsPdfUploadNow":
                if($authority == 1):
                    if(isset($_FILES["landPurchaseAttacmentsPdf"]["name"])):
                        $allFileHere = array();
                        for($i = 0; $i < count($_FILES["landPurchaseAttacmentsPdf"]["name"]); $i++):
                            if(!empty($_FILES["landPurchaseAttacmentsPdf"]["name"][$i])):
                                if(move_uploaded_file($_FILES["landPurchaseAttacmentsPdf"]["tmp_name"][$i] , $landAcquisitionLandsDirTemp.$randSix."_".$_FILES["landPurchaseAttacmentsPdf"]["name"][$i])):
                                    array_push($allFileHere, $randSix."_".$_FILES["landPurchaseAttacmentsPdf"]["name"][$i]);
                                else:
                                    // array_push($allFileHere, "default");
                                    continue;
                                endif;
                            endif;
                        endfor;
                        //Send Uploaded Message
                        if(count($allFileHere) > 0){
                            $data["response"] = "success";
                            $data["responseType"] = "info";
                            $data["responseMessage"] = "Pdf Uploaded!!!";
                            $data["responseAre"] = implode(",", $allFileHere);
                        } else{
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Error uploading your files, Please try again!!!";
                        }
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
            // ----------------------------------------------------
            // ------------ Upload Pdf Section End -------------
            // ----------------------------------------------------
            // ----------------------------------------------------
            // ------------ Upload Excel Section Start -----------
            // ----------------------------------------------------
            case "landPurchaseAttacmentsExcelUploadNow":
                if($authority == 1):
                    if(isset($_FILES["landPurchaseAttacmentsExcel"]["name"])):
                        $allFileHere = array();
                        for($i = 0; $i < count($_FILES["landPurchaseAttacmentsExcel"]["name"]); $i++):
                            if(!empty($_FILES["landPurchaseAttacmentsExcel"]["name"][$i])):
                                if(move_uploaded_file($_FILES["landPurchaseAttacmentsExcel"]["tmp_name"][$i] , $landAcquisitionLandsDirTemp.$randSix."_".$_FILES["landPurchaseAttacmentsExcel"]["name"][$i])):
                                    array_push($allFileHere, $randSix."_".$_FILES["landPurchaseAttacmentsExcel"]["name"][$i]);
                                else:
                                    // array_push($allFileHere, "default");
                                    continue;
                                endif;
                            endif;
                        endfor;
                        //Send Uploaded Message
                        if(count($allFileHere) > 0){
                            $data["response"] = "success";
                            $data["responseType"] = "info";
                            $data["responseMessage"] = "Excel Uploaded!!!";
                            $data["responseAre"] = implode(",", $allFileHere);
                        } else{
                            $data["response"] = "error";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "Error uploading your files, Please try again!!!";
                        }
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
            // ----------------------------------------------------
            // ------------ Upload Excel Section End -------------
            // ----------------------------------------------------

            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //*************************************** File Upload Section Ends Here *****************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
            //***************************************************************************************************************************
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