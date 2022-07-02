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
//                    echo "<pre>";
//                    print_r($_POST);
//                    exit(0);
                    if(!empty($_POST["projectName"] && $_POST["properties"] && $_POST["propertyPrice"] && $_POST["propertyPriceDeal"] && $_POST["firstApplicantName"] && $_POST["firstApplicantParentOf"] && $_POST["firstApplicantPhoneNumber"] && $_POST["firstApplicantUsername"] && $_POST["logPass"] && $_POST["firstApplicantEmailId"] && $_POST["firstApplicantDateOfBirth"] && $_POST["firstApplicanPanNumber"] && $_POST["firstApplicanAadharNumber"] && $_POST["firstApplicanPermanentAddress"] && $_POST["firstApplicanCorrespondenceAddress"] && $_POST["secondApplicantName"] && $_POST["secondApplicantParentOf"] && $_POST["secondApplicantPhoneNumber"] && $_POST["secondApplicantEmailId"] && $_POST["secondApplicantDateOfBirth"] && $_POST["secondApplicanPanNumber"] && $_POST["secondApplicanAadharNumber"] && $_POST["secondApplicanPermanentAddress"] && $_POST["secondApplicanCorrespondenceAddress"])):
                        $flag = 1;
                        $downPayment = 0;
                        $customerStatus = "";
                        $errorMessage = "Please fill out the required fields!!!";
                        $paymentStucture = array();
                        $gender = "male";
                        $dp = "men-Icon.png";
                        
                        $data_property_info = array(
                                                    "projectId"                                 =>      htmlspecialchars($_POST["projectName"], ENT_QUOTES),
                                                    "propertyType"                              =>      json_decode($_POST["properties"], true),
                                                    "propertyPrice"                             =>      htmlspecialchars($_POST["propertyPrice"], ENT_QUOTES),
                                                    "propertyPriceDeal"                         =>      htmlspecialchars($_POST["propertyPriceDeal"], ENT_QUOTES),
                                                    "propertyNumber"                            =>      htmlspecialchars($_POST["propertyNumber"], ENT_QUOTES),
                                                    "propertyCarParkings"                       =>      htmlspecialchars($_POST["propertyCarParkings"], ENT_QUOTES),
                                                    "CarParkingAmount"                       =>      htmlspecialchars($_POST["CarParkingAmount"], ENT_QUOTES),
                                                    "propertyScooterParkings"                   =>      htmlspecialchars($_POST["propertyScooterParkings"], ENT_QUOTES),
                                                    "ScooterParkingAmount"                       =>      htmlspecialchars($_POST["ScooterParkingAmount"], ENT_QUOTES)
                                              );
                        if(!empty($_POST["paymentAmount"])):
                            $data_payment_info = array(
                                                    array(
                                                        "paymentType"                           =>      "downPayment",
                                                        "paymentRemark"                         =>      "Down Payment",
                                                        "paymentAmount"                         =>      htmlspecialchars($_POST["paymentAmount"], ENT_QUOTES),
                                                        "paymentInWords"                        =>      htmlspecialchars($_POST["paymentAmountInRupees"], ENT_QUOTES),
                                                        "paymentNumber"                         =>      htmlspecialchars($_POST["paymentAmountNumber"], ENT_QUOTES),
                                                        "paymentMode"                           =>      "",
                                                        "paymentModeFrom"                       =>      "",
                                                        "paymentTransactionNumber"              =>      htmlspecialchars($_POST["paymentAmountNumber"], ENT_QUOTES),
                                                        "paymentDate"                           =>      htmlspecialchars($_POST["paymentAmountDate"], ENT_QUOTES),
                                                        "paymentStoredDate"                     =>      date("d-m-Y"),
                                                        "paymentStoredTime"                     =>      date("H:i:s A"),
                                                        "paymentStatus"                         =>      "paid"
                                                    )
                                                );
                            $paymentStucturePercentageOfAmount = null;
                            $paymentStuctureAmount = null;
                            $paymentStuctureRemark = null;
                            if(empty($_POST["paymentStuctureCompletion"][$downPayment])):
                                $flag = 0;
                            else:
                                $paymentStucturePercentageOfAmount = $_POST["paymentStuctureCompletion"][$downPayment];
                            endif;
                            if(empty($_POST["paymentStuctureAmount"][$downPayment])):
                                $flag = 0;
                            else:
                                $paymentStuctureAmount = $_POST["paymentStuctureAmount"][$downPayment];
                            endif;
                            if(empty($_POST["paymentStuctureRemark"][$downPayment])):
                                $flag = 0;
                            else:
                                $paymentStuctureRemark = $_POST["paymentStuctureRemark"][$downPayment];
                            endif;
                            $tempPaymentStucture = array(
                                                    "paymentStuctureCompletion"                 =>      htmlspecialchars($paymentStucturePercentageOfAmount, ENT_QUOTES),
                                                    "paymentStuctureAmount"                     =>      htmlspecialchars($paymentStuctureAmount, ENT_QUOTES),
                                                    "paymentStuctureRemark"                     =>      htmlspecialchars($paymentStuctureRemark, ENT_QUOTES),
                                                    "paymentStucturePaid"                       =>      htmlspecialchars($_POST["paymentAmount"], ENT_QUOTES),
                                                    "paymentStucturePaidRemark"                 =>      "Down Payment",
                                                    "paymentStuctureStatus"                     =>      "paid"
                                                    );
                            array_push($paymentStucture, $tempPaymentStucture);
                            unset($tempPaymentStucture);
                            $downPayment = 1;
                            $data_payment_info = json_encode($data_payment_info);
                        else:
                            $data_payment_info = "[]";
                        endif;
                        for($i = $downPayment; $i<$_POST["totalNumberOfDivision"]; $i++):
                            $paymentStucturePercentageOfAmount = null;
                            $paymentStuctureAmount = null;
                            $paymentStuctureRemark = null;
                            if(empty($_POST["paymentStuctureCompletion"][$i])):
                                $flag = 0;
                            else:
                                $paymentStucturePercentageOfAmount = $_POST["paymentStuctureCompletion"][$i];
                            endif;
                            if(empty($_POST["paymentStuctureAmount"][$i])):
                                $flag = 0;
                            else:
                                $paymentStuctureAmount = $_POST["paymentStuctureAmount"][$i];
                            endif;
                            if(empty($_POST["paymentStuctureRemark"][$i])):
                                $flag = 0;
                            else:
                                $paymentStuctureRemark = $_POST["paymentStuctureRemark"][$i];
                            endif;
                            $tempPaymentStucture = array(
                                                    "paymentStuctureCompletion"                 =>      htmlspecialchars($paymentStucturePercentageOfAmount, ENT_QUOTES),
                                                    "paymentStuctureAmount"                     =>      htmlspecialchars($paymentStuctureAmount, ENT_QUOTES),
                                                    "paymentStuctureRemark"                     =>      htmlspecialchars($paymentStuctureRemark, ENT_QUOTES),
                                                    "paymentStucturePaid"                       =>      "",
                                                    "paymentStucturePaidRemark"                 =>      "",
                                                    "paymentStuctureStatus"                     =>      ""
                                                    );
                            array_push($paymentStucture, $tempPaymentStucture);
                            unset($tempPaymentStucture);
                        endfor;
                        $extra = array();
                        for($j = 0; $j<$_POST["totalextraamount"]; $j++):
                            $ExtraAmount = null;
                            $ExtraAmountRemarks = null;
                            if(empty($_POST["ExtraAmount"][$j])):
                                $ExtraAmount = "";
                            else:
                                $ExtraAmount = $_POST["ExtraAmount"][$j];
                            endif;
                            if(empty($_POST["ExtraAmountRemarks"][$j])):
                                $ExtraAmountRemarks = "";
                            else:
                                $ExtraAmountRemarks = $_POST["ExtraAmountRemarks"][$j];
                            endif;
                           
                            $extratempProperty = array(
                                                "ExtraAmount"                                 =>      htmlspecialchars($ExtraAmount, ENT_QUOTES),
                                                "ExtraAmountRemarks"                                 =>      htmlspecialchars($ExtraAmountRemarks, ENT_QUOTES)
                                            );
                            array_push($extra, $extratempProperty);
                            unset($extratempProperty);
                        endfor;

                        if($_POST["firstApplicantTitle"] != "Mr"):
                            $gender = "female";
                            $dp = "women-Icon.png";
                        endif;
                        $data_info = array(
                                            "title"                                 =>      htmlspecialchars($_POST["firstApplicantTitle"], ENT_QUOTES),
                                            "name"                                  =>      htmlspecialchars($_POST["firstApplicantName"], ENT_QUOTES),
                                            "parentName"                            =>      htmlspecialchars($_POST["firstApplicantParentOf"], ENT_QUOTES),
                                            "nickName"                              =>      "",
                                            "phoneNumber"                           =>      htmlspecialchars($_POST["firstApplicantPhoneNumber"], ENT_QUOTES),
                                            "firstApplicantUsername"                           =>      htmlspecialchars($_POST["firstApplicantUsername"], ENT_QUOTES),
                                            "password"                           =>      htmlspecialchars($_POST["logPass"], ENT_QUOTES),
                                            "phoneNumberAlternate"                  =>      htmlspecialchars($_POST["firstApplicantAlternatePhoneNumber"], ENT_QUOTES),
                                            "fax"                                   =>      htmlspecialchars($_POST["firstApplicantAlternateFax"], ENT_QUOTES),
                                            "emailId"                               =>      htmlspecialchars($_POST["firstApplicantEmailId"], ENT_QUOTES),
                                            "dob"                                   =>      htmlspecialchars($_POST["firstApplicantDateOfBirth"], ENT_QUOTES),
                                            "age"                                   =>      htmlspecialchars($_POST["firstApplicantAge"], ENT_QUOTES),
                                            "maritalStatus"                         =>      htmlspecialchars($_POST["firstApplicantMaritalStatus"], ENT_QUOTES),
                                            "dateOfAnniversary"                     =>      htmlspecialchars($_POST["firstApplicantDateOfAnniversary"], ENT_QUOTES),
                                            "noOfChild"                             =>      htmlspecialchars($_POST["firstApplicantNoOfChild"], ENT_QUOTES),
                                            "religion"                              =>      htmlspecialchars($_POST["firstApplicantReligion"], ENT_QUOTES),
                                            "caste"                                 =>      htmlspecialchars($_POST["firstApplicantCaste"], ENT_QUOTES),
                                            "residentialStatus"                     =>      htmlspecialchars($_POST["firstApplicantResidentialStatus"], ENT_QUOTES),
                                            "occupation"                            =>      htmlspecialchars($_POST["firstApplicanOccupation"], ENT_QUOTES),
                                            "panNumber"                             =>      htmlspecialchars($_POST["firstApplicanPanNumber"], ENT_QUOTES),
                                            "aadharNumber"                          =>      htmlspecialchars($_POST["firstApplicanAadharNumber"], ENT_QUOTES),
                                            "permanentAddress"                      =>      htmlspecialchars($_POST["firstApplicanPermanentAddress"], ENT_QUOTES),
                                            "correspondenceAddress"                 =>      htmlspecialchars($_POST["firstApplicanCorrespondenceAddress"], ENT_QUOTES),
                                            "dp"                                    =>      $dp,
                                            "gender"                                =>      $gender
                                      );
                        $gender = "male";
                        $dp = "men-Icon.png";
                        if($_POST["secondApplicantTitle"] != "Mr"):
                            $gender = "female";
                            $dp = "women-Icon.png";
                        endif;
                        $data_second_info = array(
                                            "title"                                 =>      htmlspecialchars($_POST["secondApplicantTitle"], ENT_QUOTES),
                                            "name"                                  =>      htmlspecialchars($_POST["secondApplicantName"], ENT_QUOTES),
                                            "parentName"                            =>      htmlspecialchars($_POST["secondApplicantParentOf"], ENT_QUOTES),
                                            "nickName"                              =>      "",
                                            "phoneNumber"                           =>      htmlspecialchars($_POST["secondApplicantPhoneNumber"], ENT_QUOTES),
                                            "phoneNumberAlternate"                  =>      htmlspecialchars($_POST["secondApplicantAlternatePhoneNumber"], ENT_QUOTES),
                                            "fax"                                   =>      htmlspecialchars($_POST["secondApplicantAlternateFax"], ENT_QUOTES),
                                            "emailId"                               =>      htmlspecialchars($_POST["secondApplicantEmailId"], ENT_QUOTES),
                                            "dob"                                   =>      htmlspecialchars($_POST["secondApplicantDateOfBirth"], ENT_QUOTES),
                                            "age"                                   =>      htmlspecialchars($_POST["secondApplicantAge"], ENT_QUOTES),
                                            "maritalStatus"                         =>      htmlspecialchars($_POST["secondApplicantMaritalStatus"], ENT_QUOTES),
                                            "dateOfAnniversary"                     =>      htmlspecialchars($_POST["secondApplicantDateOfAnniversary"], ENT_QUOTES),
                                            "noOfChild"                             =>      htmlspecialchars($_POST["secondApplicantNoOfChild"], ENT_QUOTES),
                                            "religion"                              =>      htmlspecialchars($_POST["secondApplicantReligion"], ENT_QUOTES),
                                            "caste"                                 =>      htmlspecialchars($_POST["secondApplicantCaste"], ENT_QUOTES),
                                            "residentialStatus"                     =>      htmlspecialchars($_POST["secondApplicantResidentialStatus"], ENT_QUOTES),
                                            "occupation"                            =>      htmlspecialchars($_POST["secondApplicanOccupation"], ENT_QUOTES),
                                            "panNumber"                             =>      htmlspecialchars($_POST["secondApplicanPanNumber"], ENT_QUOTES),
                                            "aadharNumber"                          =>      htmlspecialchars($_POST["secondApplicanAadharNumber"], ENT_QUOTES),
                                            "permanentAddress"                      =>      htmlspecialchars($_POST["secondApplicanPermanentAddress"], ENT_QUOTES),
                                            "correspondenceAddress"                 =>      htmlspecialchars($_POST["secondApplicanCorrespondenceAddress"], ENT_QUOTES),
                                            "dp"                                    =>      $dp,
                                            "gender"                                =>      $gender
                                      );
                            if(!empty($_POST["propertyNumber"])):
                                $customerStatus = "customer";
                            endif;
                        if($flag == 1):
                            $data_log = array(
                                                    "type"                          =>      "customer",
                                                    "user"                          =>           htmlspecialchars($_POST["firstApplicantUsername"], ENT_QUOTES),
                                                    "pass"                          =>      htmlspecialchars($_POST["logPass"], ENT_QUOTES),
                                                    "oldPass"                       =>      "",
                                                    "auth"                          =>      "",
                                                    "status"                        =>      $customerStatus
                                         );
                            $data_service = "[]";
                            $data_log_info = "[]";
                            $data_ajax = array(
                                                    "maxDate"                       =>      "",
                                                    "maxLog"                        =>      "",
                                                    "responce"                      =>      "",
                                                    "ip"                            =>      "",
                                                    "location"                      =>      "",
                                                    "otp"                           =>      ""
                                         );
                            $data_theme = array(
                                                    "header_color"                  =>      "",
                                                    "header_bg"                     =>      "",
                                                    "footer_color"                  =>      "",
                                                    "footer_bg"                     =>      "",
                                                    "sidebar_color"                 =>      "",
                                                    "sidebar_bg"                    =>      "",
                                                    "sidebar_active_color"          =>      "",
                                                    "sidebar_active_bg"             =>      "",
                                                    "index_bg"                      =>      "index-bg.png"
                                          );
                            $data_create = array(
                                            array(
                                                    "action"                        =>      "added",
                                                    "by"                            =>      $auth->admin_id,
                                                    "ip"                            =>      $_POST["checkIp"],
                                                    "location"                      =>      $_POST["checkLocation"],
                                                    "at"                            =>      date("H:i:s A"),
                                                    "date"                          =>      date("d-m-Y")
                                            )
                                          );
                            $tableData["customer_log"]                              =   json_encode($data_log);
                            $tableData["customer_info"]                             =   json_encode($data_info);
                            $tableData["customer_second_applicant"]                 =   json_encode($data_second_info);
                            $tableData["customer_property_info"]                    =   json_encode($data_property_info);
                            $tableData["customer_payment_structure"]                =   json_encode($paymentStucture);
                            $tableData["customer_extra_payment_structure"]         =   json_encode($extra);
                            $tableData["customer_payment_info"]                     =   $data_payment_info;
                            $tableData["customer_service"]                          =   $data_service;
                            $tableData["customer_log_info"]                         =   $data_log_info;
                            $tableData["customer_ajax"]                             =   json_encode($data_ajax);
                            $tableData["customer_theme"]                            =   json_encode($data_theme);
                            $tableData["customer_create"]                           =   json_encode($data_create);
                            $tableData["status"]                                    =   $auth->visible();
							
                          $databaseObj->select("tbl_customer");
                          $databaseObj->where("`status` = '".$auth->visible()."'");
                          $getCategoryData = $databaseObj->get();
                          echo $databaseObj->error();
                          $flag = 0;
							if($getCategoryData != 0):
                            foreach($getCategoryData as $categoryrows):
                                $customer_info = json_decode($categoryrows["customer_info"]);
							 if ($customer_info->firstApplicantUsername == $_POST["firstApplicantUsername"]) {
								 $flag++;
							 }
							   endforeach;
							 endif;
							 if ($flag==0) {
								$check = $databaseObj->insert("tbl_customer", $tableData);
							 }
							 else {
							   $check = 2;
							 }
							if($check == 1):
                                $message="Dear $customer_info->name, Your Form has been Successfully submitted. \nClick below link to Login.\nhttp://localhost/Real-Estate-Management-System/ \nUsername: $customer_info->firstApplicantUsername \nPassword: $customer_info->password \n\nRegards,\nIREMS";
                                $databaseObj->send_to_phone($customer_info->phoneNumber, $message);
                                //*********************************************************************************************************
                                //sEND mESSAGE tO tHE cUSTOMER aND aLSO tO tHE sECOND aPPLICANT aND aDMIN tOO *****************************
                                //*********************************************************************************************************
                                
                                //*********************************************************************************************************
                                //sEND mESSAGE tO tHE cUSTOMER aND aLSO tO tHE sECOND aPPLICANT aND aDMIN tOO *****************************
                                //*********************************************************************************************************
                             
								$data["response"] = "success";
								$data["responseType"] = "success";
								$data["responseMessage"] = "Data added successfully!!!";
							else:
								$data["response"] = "error";
								$data["responseType"] = "error";
								if ($check == 2) {
								$data["responseMessage"] = "Username Already Exists!!!";
								}
								else {
								$data["responseMessage"] = "Something went wrong please try again11!!!";
								}
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
            // ------------------------------------------------------------
            // ------------ Edit Payment Structure Section Start ----------
            // ------------------------------------------------------------
            case "editPaymentStructure":
                if($authority == 1):
                    if(!empty($_POST["editTableId"])):
                        $flag = 1;
                        $errorMessage = "";
                        $paymentStucture = array();
                        for($i = 0; $i<$_POST["editTotalNumberOfDivision"]; $i++):
                            $paymentStucturePercentageOfAmount = null;
                            $paymentStuctureAmount = null;
                            $paymentStuctureRemark = null;
                            $paymentStucturePaid = "";
                            $paymentStucturePaidRemark = "";
                            $paymentStuctureStatus = "";
                            if(isset($_POST["paymentStuctureStatus"][$i])):
                                $paymentStucturePaid = $_POST["paymentStucturePaid"][$i];
                                $paymentStucturePaidRemark = $_POST["paymentStucturePaidRemark"][$i];
                                $paymentStuctureStatus = $_POST["paymentStuctureStatus"][$i];
                            endif;
                            if(empty($_POST["paymentStuctureCompletion"][$i])):
                                $flag = 0;
                            else:
                                $paymentStucturePercentageOfAmount = $_POST["paymentStuctureCompletion"][$i];
                            endif;
                            if(empty($_POST["paymentStuctureAmount"][$i])):
                                $flag = 0;
                            else:
                                $paymentStuctureAmount = $_POST["paymentStuctureAmount"][$i];
                            endif;
                            if(empty($_POST["paymentStuctureRemark"][$i])):
                                $flag = 0;
                            else:
                                $paymentStuctureRemark = $_POST["paymentStuctureRemark"][$i];
                            endif;
                            $tempPaymentStucture = array(
                                                    "paymentStuctureCompletion"                 =>      htmlspecialchars($paymentStucturePercentageOfAmount, ENT_QUOTES),
                                                    "paymentStuctureAmount"                     =>      htmlspecialchars($paymentStuctureAmount, ENT_QUOTES),
                                                    "paymentStuctureRemark"                     =>      htmlspecialchars($paymentStuctureRemark, ENT_QUOTES),
                                                    "paymentStucturePaid"                       =>      $paymentStucturePaid,
                                                    "paymentStucturePaidRemark"                 =>      $paymentStucturePaidRemark,
                                                    "paymentStuctureStatus"                     =>      $paymentStuctureStatus
                                                    );
                            array_push($paymentStucture, $tempPaymentStucture);
                            unset($tempPaymentStucture);
                        endfor;
                        if($flag == 1):
                            $databaseObj->select("tbl_customer");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["editTableId"]."'");
                            $getData = $databaseObj->get();
                            //Checking If Data Is Available
                            if($getData != 0):
                                $sno = 1;
                                foreach($getData as $rows):
                                    $data_log = json_decode($rows["customer_create"]);
                                endforeach;
                                if(!empty($_POST["editTableId"])):
                                     $edit_log = array(
                                                        "action"                        =>      "Payment Structure Updated",
                                                        "by"                            =>      $auth->admin_id,
                                                        "ip"                            =>      $_POST["checkIp"],
                                                        "location"                      =>      $_POST["checkLocation"],
                                                        "at"                            =>      date("H:i:s A"),
                                                        "date"                          =>      date("d-m-Y")
                                                );
                                    array_push($data_log, $edit_log);
                                    $tableData["customer_payment_structure"] = json_encode($paymentStucture);
                                    $tableData["customer_create"] = json_encode($data_log);
                                    $tableData["status"] = $auth->visible();
                                    $check = $databaseObj->update("tbl_customer", $tableData, "`customer_id` = '".$_POST["editTableId"]."'");
                                    if($check == 1):
                                        $data["response"] = "success";
                                        $data["responseType"] = "success";
                                        $data["responseMessage"] = "Payment Structure Updated Successfully!!!";
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
            // ------------------------------------------------------------
            // ------------ Edit Payment Structure Section End ------------
            // ------------------------------------------------------------
            // ------------ Edit First Applicant Data Section Start ----------
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
                                $data_info = json_decode($rows["customer_info"]);
                                $data_log = json_decode($rows["customer_log_info"]);
                            endforeach;
                            $gender = "male";
                            $dp = "men-Icon.png";
                            if($_POST["editfirstApplicantTitle"] != "Mr"):
                            $gender = "female";
                            $dp = "women-Icon.png";
                            endif;
                            if(!empty($_POST["editfirstApplicantTitle"] && $_POST["editfirstApplicantName"] && $_POST["editfirstApplicantParentOf"] && $_POST["editfirstApplicantPhoneNumber"] && $_POST["editfirstApplicantEmailId"] && $_POST["editfirstApplicantDateOfBirth"] && $_POST["editfirstApplicantAge"] && $_POST["editfirstApplicantReligion"] && $_POST["editfirstApplicanPanNumber"] &&  $_POST["editfirstApplicanAadharNumber"] &&  $_POST["editfirstApplicanPermanentAddress"] &&  $_POST["editfirstApplicanCorrespondenceAddress"])):
                                $edit_info = array(
                                    "title"               =>      htmlspecialchars($_POST["editfirstApplicantTitle"], ENT_QUOTES),
                                    "name"                =>      htmlspecialchars($_POST["editfirstApplicantName"], ENT_QUOTES),
                                    "parentName"          =>      htmlspecialchars($_POST["editfirstApplicantParentOf"], ENT_QUOTES),
                                    "phoneNumber"         =>      htmlspecialchars($_POST["editfirstApplicantPhoneNumber"], ENT_QUOTES),
                                    "phoneNumberAlternate" =>     htmlspecialchars($_POST["editfirstApplicantAlternatePhoneNumber"], ENT_QUOTES),
                                    "fax"          =>      htmlspecialchars($_POST["editfirstApplicantAlternateFax"], ENT_QUOTES),
                                    "emailId"          =>      htmlspecialchars($_POST["editfirstApplicantEmailId"], ENT_QUOTES),
                                    "dob"          =>      htmlspecialchars($_POST["editfirstApplicantDateOfBirth"], ENT_QUOTES),
                                    "age"          =>      htmlspecialchars($_POST["editfirstApplicantAge"], ENT_QUOTES),
                                    "maritalStatus"          =>      htmlspecialchars($_POST["editfirstApplicantMaritalStatus"], ENT_QUOTES),
                                    "dateOfAnniversary"      =>      htmlspecialchars($_POST["editfirstApplicantDateOfAnniversary"], ENT_QUOTES),
                                    "noOfChild"                             =>      htmlspecialchars($_POST["editfirstApplicantNoOfChild"], ENT_QUOTES),
                                    "religion"          =>      htmlspecialchars($_POST["editfirstApplicantReligion"], ENT_QUOTES),
                                    "caste"          =>      htmlspecialchars($_POST["editfirstApplicantCaste"], ENT_QUOTES),

                                    "residentialStatus"          =>      htmlspecialchars($_POST["editfirstApplicantResidentialStatus"], ENT_QUOTES),
                                    "occupation"          =>      htmlspecialchars($_POST["editfirstApplicanOccupation"], ENT_QUOTES),
                                    "panNumber"          =>      htmlspecialchars($_POST["editfirstApplicanPanNumber"], ENT_QUOTES),
                                    "aadharNumber"          =>      htmlspecialchars($_POST["editfirstApplicanAadharNumber"], ENT_QUOTES),
                                    "permanentAddress"          =>      htmlspecialchars($_POST["editfirstApplicanPermanentAddress"], ENT_QUOTES),
                                    "correspondenceAddress"          =>      htmlspecialchars($_POST["editfirstApplicanCorrespondenceAddress"], ENT_QUOTES),
                                    "dp"                                    =>      $dp,
                                    "gender"                                =>      $gender

                                     );
                                 
                                 $edit_log = array(
                                                    "action"                =>      "edited",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                                array_push($data_log, $edit_log);
                                $tableData["customer_info"] = json_encode($edit_info);
                                $tableData["customer_log_info"] = json_encode($data_log);
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
            // ------------ Edit First Applicant Data Section End ------------
            // ------------ Edit Second Applicant Data Section Start ----------
            // -----------------------------------------------
            case "secondeditData":
                if($authority == 1):
                    if(!empty($_POST["editTableId"])):
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["editTableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_info = json_decode($rows["customer_second_applicant"]);
                                $data_log = json_decode($rows["customer_log_info"]);
                            endforeach;
                            $gender = "male";
                            $dp = "men-Icon.png";
                            if($_POST["editsecondApplicantTitle"] != "Mr"):
                            $gender = "female";
                            $dp = "women-Icon.png";
                            endif;
                            if(!empty($_POST["editsecondApplicantTitle"] && $_POST["editsecondApplicantName"] && $_POST["editsecondApplicantParentOf"] && $_POST["editsecondApplicantPhoneNumber"] && $_POST["editsecondApplicantEmailId"] && $_POST["editsecondApplicantDateOfBirth"] && $_POST["editsecondApplicantAge"] && $_POST["editsecondApplicantReligion"] && $_POST["editsecondApplicanPanNumber"] &&  $_POST["editsecondApplicanAadharNumber"] &&  $_POST["editsecondApplicanPermanentAddress"] &&  $_POST["editsecondApplicanCorrespondenceAddress"])):
                                $edit_info = array(
                                    "title"               =>      htmlspecialchars($_POST["editsecondApplicantTitle"], ENT_QUOTES),
                                    "name"                =>      htmlspecialchars($_POST["editsecondApplicantName"], ENT_QUOTES),
                                    "parentName"          =>      htmlspecialchars($_POST["editsecondApplicantParentOf"], ENT_QUOTES),
                                    "phoneNumber"         =>      htmlspecialchars($_POST["editsecondApplicantPhoneNumber"], ENT_QUOTES),
                                    "phoneNumberAlternate" =>     htmlspecialchars($_POST["editsecondApplicantAlternatePhoneNumber"], ENT_QUOTES),
                                    "fax"          =>      htmlspecialchars($_POST["editsecondApplicantAlternateFax"], ENT_QUOTES),
                                    "emailId"          =>      htmlspecialchars($_POST["editsecondApplicantEmailId"], ENT_QUOTES),
                                    "dob"          =>      htmlspecialchars($_POST["editsecondApplicantDateOfBirth"], ENT_QUOTES),
                                    "age"          =>      htmlspecialchars($_POST["editsecondApplicantAge"], ENT_QUOTES),
                                    "maritalStatus"          =>      htmlspecialchars($_POST["editsecondApplicantMaritalStatus"], ENT_QUOTES),
                                    "dateOfAnniversary"      =>      htmlspecialchars($_POST["editsecondApplicantDateOfAnniversary"], ENT_QUOTES),
                                    "noOfChild"                             =>      htmlspecialchars($_POST["editsecondApplicantNoOfChild"], ENT_QUOTES),
                                    "religion"          =>      htmlspecialchars($_POST["editsecondApplicantReligion"], ENT_QUOTES),
                                    "caste"          =>      htmlspecialchars($_POST["editsecondApplicantCaste"], ENT_QUOTES),

                                    "residentialStatus"          =>      htmlspecialchars($_POST["editsecondApplicantResidentialStatus"], ENT_QUOTES),
                                    "occupation"          =>      htmlspecialchars($_POST["editsecondApplicanOccupation"], ENT_QUOTES),
                                    "panNumber"          =>      htmlspecialchars($_POST["editsecondApplicanPanNumber"], ENT_QUOTES),
                                    "aadharNumber"          =>      htmlspecialchars($_POST["editsecondApplicanAadharNumber"], ENT_QUOTES),
                                    "permanentAddress"          =>      htmlspecialchars($_POST["editsecondApplicanPermanentAddress"], ENT_QUOTES),
                                    "correspondenceAddress"          =>      htmlspecialchars($_POST["editsecondApplicanCorrespondenceAddress"], ENT_QUOTES),
                                    "dp"                                    =>      $dp,
                                    "gender"                                =>      $gender

                                     );
                                 
                                 $edit_log = array(
                                                    "action"                =>      "edited",
                                                    "by"                    =>      $auth->admin_id,
                                                    "ip"                    =>      $_POST["checkIp"],
                                                    "location"              =>      $_POST["checkLocation"],
                                                    "at"                    =>      date("H:i:s A"),
                                                    "date"                  =>      date("d-m-Y")
                                            );
                                array_push($data_log, $edit_log);
                                $tableData["customer_second_applicant"] = json_encode($edit_info);
                                $tableData["customer_log_info"] = json_encode($data_log);
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
            // ------------ Edit second Applicant Data Section End ------------
            // --------------------------------------------------
            // ------------ Import Data Section Start -----------
            // --------------------------------------------------
            case "importData":
                if($authority == 1):
                    if(!empty($_FILES["importedExcel"]["name"])):
                        if(move_uploaded_file($_FILES["importedExcel"]["tmp_name"] , $projectsDir.$randSix."_".$_FILES["importedExcel"]["name"])):
                            $fileName = $randSix."_".$_FILES["importedExcel"]["name"];
                            $file_type	= PHPExcel_IOFactory::identify($projectsDir.$fileName);
                            $objReader	= PHPExcel_IOFactory::createReader($file_type);
                            $objPHPExcel = $objReader->load($projectsDir.$fileName);
                            $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
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
                    if(!empty($_POST["editTableId"])):
                        $flag = 1;
                        $errorMessage = "";
                        $properties = array();
                        for($i = 0; $i<$_POST["editTotalProperty"]; $i++):
                            $propertyType = null;
                            $accommodationType = null;
                            $squareFeet = null;
                            $price = null;
                            $availablility = null;
                            $StartingDate = null;
                            $ExpectedEndingDate = null;
                            $EndingDate = null;
                            if(empty($_POST["propertyType"][$i])):
                                $flag = 0;
                            else:
                                $propertyType = $_POST["propertyType"][$i];
                            endif;
                            if(empty($_POST["accommodationType"][$i])):
                                $flag = 0;
                            else:
                                $accommodationType = $_POST["accommodationType"][$i];
                            endif;
                            if(empty($_POST["squareFeet"][$i])):
                                $flag = 0;
                            else:
                                $squareFeet = $_POST["squareFeet"][$i];
                            endif;
                            if(empty($_POST["price"][$i])):
                                $flag = 0;
                            else:
                                $price = $_POST["price"][$i];
                            endif;
                            if(empty($_POST["availablility"][$i])):
                                $flag = 0;
                            else:
                                $availablility = $_POST["availablility"][$i];
                            endif;
                            if(empty($_POST["StartingDate"][$i])):
                                $flag = 0;
                            else:
                                $StartingDate = $_POST["StartingDate"][$i];
                            endif;
                            if(empty($_POST["ExpectedEndingDate"][$i])):
                                $flag = 0;
                            else:
                                $ExpectedEndingDate = $_POST["ExpectedEndingDate"][$i];
                            endif;
                            if(empty($_POST["EndingDate"][$i])):
                                $EndingDate = "";
                            else:
                                $EndingDate = $_POST["EndingDate"][$i];
                            endif;
                            $tempProperty = array(
                                                "propertyType"                          =>      htmlspecialchars($propertyType, ENT_QUOTES),
                                                "accommodationType"                     =>      htmlspecialchars($accommodationType, ENT_QUOTES),
                                                "squareFeet"                            =>      htmlspecialchars($squareFeet, ENT_QUOTES),
                                                "price"                                 =>      htmlspecialchars($price, ENT_QUOTES),
                                                "availablility"                         =>      htmlspecialchars($availablility, ENT_QUOTES),
                                                "StartingDate"                          =>      htmlspecialchars($StartingDate, ENT_QUOTES),
                                                "ExpectedEndingDate"                    =>      htmlspecialchars($ExpectedEndingDate, ENT_QUOTES),
                                                "EndingDate"                            =>      htmlspecialchars($EndingDate, ENT_QUOTES)
                                            );
                            array_push($properties, $tempProperty);
                            unset($tempProperty);
                        endfor;
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
                            if($getData != 0):
                                $sno = 1;
                                foreach($getData as $rows):
                                    $data_info = json_decode($rows["projects_info"]);
                                    $data_log = json_decode($rows["projects_log"]);
                                endforeach;
                                if(!empty($_POST["editProjectName"])):
                                     $edit_info = array(
                                                        "projectName"                   =>      htmlspecialchars($_POST["editProjectName"], ENT_QUOTES),
                                                        "projectLocation"               =>      htmlspecialchars($_POST["editProjectLocation"], ENT_QUOTES),
                                                        "projectLocationMapUrl"         =>      htmlspecialchars($_POST["editProjectLocationMapUrl"], ENT_QUOTES),
                                                        "projectStartingDate"           =>      htmlspecialchars($_POST["editProjectStartingDate"], ENT_QUOTES),
                                                        "projectExpectedEndingDate"     =>      htmlspecialchars($_POST["editProjectExpectedEndingDate"], ENT_QUOTES),
                                                        "projectEndingDate"             =>      htmlspecialchars($_POST["editProjectEndingDate"], ENT_QUOTES),
                                                        "properties"                    =>      $properties
                                                    );

                                     $edit_log = array(
                                                        "action"                        =>      "edited",
                                                        "by"                            =>      $auth->admin_id,
                                                        "ip"                            =>      $_POST["checkIp"],
                                                        "location"                      =>      $_POST["checkLocation"],
                                                        "at"                            =>      date("H:i:s A"),
                                                        "date"                          =>      date("d-m-Y")
                                                );
                                    array_push($data_log, $edit_log);
                                    $tableData["projects_info"] = json_encode($edit_info);
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
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["tableId"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $data_log = json_decode($rows["customer_create"]);
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
                        $tableData["customer_create"] = json_encode($data_log);
                        $tableData["status"] = $auth->trash();
                        $check = $databaseObj->update($_POST["tableName"], $tableData, "`customer_id` = '".$_POST["tableId"]."'");
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
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Property Type	");
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
                                                ->setCellValue('Q'.$noOfProperties, $EndingDate);
                                            fontColor('I'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('M'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('N'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('O'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('P'.$noOfProperties, '000000', '12', '', true);
                                            fontColor('Q'.$noOfProperties, '000000', '12', '', true);
                                            $objPHPExcel->getActiveSheet()->getStyle('I'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('M'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('N'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('O'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('P'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $objPHPExcel->getActiveSheet()->getStyle('Q'.$noOfProperties)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
                            $objPHPExcel->getActiveSheet()->getStyle('B5:Q'.--$inc)->applyFromArray($thinBorder);
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