<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    $log_table = "tbl_customer";
    $log_type = "";
    $log_id =  "";
    $log_complete   =  "";
    $user_flag = 0;
    $pass_flag = 0;
    $auth_flag = 0;
    if(isset($_POST["action"])){
        // Customer Log In Request
        if($_POST["action"] == "logTry"){
            $logUser = $_POST["logUser"]; //Get Username From Log In Page
            $logPass = $_POST["logPass"]; //Get Password From Log In Page
            $logLocation = $_POST["logLocation"]; //Get Location (Latitude And Longitude) From Log In Page
            $logIp = $_POST["logIp"]; //Get Current IP From Log In Page
            $logDate = $_POST["logDate"]; //Get Today's Date In DD-MM-YYY Format From Log In Page
            $logTime = $_POST["logTime"]; //Get Current Time In HH-MM-SS From Log In Page
            if(!isset($doNotGiveAccess)){
                //If Username And Password Are Not Empty
                if(!empty($logUser && $logPass)){
                    //If Location (Latitude And Longitude) Is Not Empty
                    if(!empty($logLocation)){
                        //If Current IP, Today's Date And Current Time Is Not Empty
                        if(!empty($logIp && $logDate && $logTime)){
                            //Get Data From All Tables
                            if(!empty($log_table)){
                                $databaseObj->select($log_table);
                                $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if(count($getData) != 0){
                                    foreach($getData as $rows){
                                        //Get Admin Log In Information
                                        $customer_log = json_decode($rows["customer_log"]);
                                        $customer_info = json_decode($rows["customer_info"]);
                                        
                                        //Check Username
                                        if($customer_log->user == $logUser){
                                           
                                            $user_flag = 1;
                                            //Check Password
                                            $user_flag = 1;
                                            //Check Password
                                            if($customer_log->pass == md5($logPass)){
                                                $pass_flag = 1;
                                                //If Any SESSION Is Available Unset All
                                                if(isset($_SESSION["wrongPass"]))
                                                    unset($_SESSION["wrongPass"]);
                                                if(isset($_SESSION["wrongUser"]))
                                                    unset($_SESSION["wrongUser"]);
                                                if(isset($_SESSION["primaryLog"]))
                                                    unset($_SESSION["primaryLog"]);
                                                if(isset($_SESSION["primaryLogVal"]))
                                                    unset($_SESSION["primaryLogVal"]);
                                                if(isset($_SESSION["logInfoCustomer"]))
                                                    unset($_SESSION["logInfoCustomer"]);
                                                if(isset($_SESSION["acceptSecondaryLog"]))
                                                    unset($_SESSION["acceptSecondaryLog"]);
                                                if(isset($_COOKIE["logInfoCustomer"])){
                                                    setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                                                    unset($_COOKIE["logInfoCustomer"]);
                                                }
                                                if(isset($_SESSION["checkLoginOTP"]))
                                                    unset($_SESSION["checkLoginOTP"]);
                                                //Add New Log Information In Log In Information
                                                $customer_log_info_updated = array(
                                                                                    "logDate"       =>  $logDate,
                                                                                    "logTime"       =>  $logTime,
                                                                                    "logIp"         =>  $logIp,
                                                                                    "logLocation"   =>  $logLocation,
                                                                                    "logStatus"     =>  "primary"
                                                                            );
                                                $customer_log_info = json_decode($rows["customer_log_info"], true);
                                                array_push($customer_log_info, $customer_log_info_updated);
                                                $dataUpdate["customer_log_info"] = json_encode($customer_log_info);
                                                //Update The Records
                                                $check = $databaseObj->update("tbl_customer", $dataUpdate, "`customer_id` = '".$rows["customer_id"]."'");
                                                if($check == 1){
                                                    //Store All Sessions
                                                    $sessionLogInfo = array(
                                                                                    "logUser"       =>  $customer_log->user,  
                                                                                    "logTime"       =>  $logTime,  
                                                                                    "logIp"         =>  $logIp,  
                                                                                    "logLocation"   =>  $logLocation,  
                                                                                    "logStatus"     =>  "primary",  
                                                                                    "logType"       =>  $customer_log->type, 
                                                                                    "tblType"       =>  "tbl_customer" 
                                                                      );
                                                    $_SESSION["logInfoCustomer"] = json_encode($sessionLogInfo);
                                                    setcookie("logInfoCustomer", json_encode($sessionLogInfo), time() + (86400 * 365), "/");
                                                    $data["success"] = true;
                                                    $data["message"] = "You have successfully Logged In!!!";
                                                    if(isset($_COOKIE["lastInfoCustomer"]))
                                                        $data["redirect"] = $_COOKIE["lastInfoCustomer"];
                                                    else
                                                        $data["redirect"] = "dashboard";
                                                } else{
                                                    $data["error"] = "error";
                                                    $data["errorType"] = "error";
                                                    $data["message"] = "Something went wrong, Please try again later!!!";
                                                }
                                                break;
                                            } else{
                                                if(isset($_SESSION["wrongPass"])){
                                                    if($_SESSION["wrongPass"] < 4){
                                                        $_SESSION["wrongPass"] = $_SESSION["wrongPass"] + 1;
                                                        $data["wrongPass"] = true;
                                                        $data["errorType"] = "error";
                                                        $data["message"] = "Incorrect password, Please try again!!!";
                                                    } else{
                                                        unset($_SESSION["wrongPass"]);
                                                        $data["wrongPassReached"] = true;
                                                        $data["errorType"] = "info";
                                                        $data["message"] = "If you forgot your Password, You can change it now!!!";
                                                    }
                                                } else{
                                                    $_SESSION["wrongPass"] = 1;
                                                    $data["wrongPass"] = true;
                                                    $data["errorType"] = "error";
                                                    $data["message"] = "Incorrect password, Please try again!!!";
                                                }
                                                break;
                                            }
                                            break;
                                        }
                                    }
                                    if($user_flag != 1){
                                        if(isset($_SESSION["wrongUser"])){
                                            if($_SESSION["wrongUser"] < 4){
                                                $_SESSION["wrongUser"] = $_SESSION["wrongUser"] + 1;
                                                $data["wrongUser"] = true;
                                                $data["errorType"] = "error";
                                                $data["message"] = "Username not found, Please check and try again!!!";
                                            } else{
                                                unset($_SESSION["wrongUser"]);
                                                $data["wrongUserReached"] = true;
                                                $data["errorType"] = "info";
                                                $data["message"] = "If you forgot your Username, You can change it now or you can create a new account!!!";
                                            }
                                        } else{
                                            $_SESSION["wrongUser"] = 1;
                                            $data["wrongUser"] = true;
                                            $data["errorType"] = "error";
                                            $data["message"] = "Username not found, Please check and try again!!!";
                                        }
                                    }
                                } else{
                                    $data["error"] = "error";
                                    $data["errorType"] = "question";
                                    $data["message"] = "We are unable to Login this time, Please try again later!!!";
                                }
                            } else{
                                $data["error"] = "error";
                                $data["errorType"] = "warning";
                                $data["message"] = "We are unable to Login this time, Please try again later!!!";
                            }
                        } else{
                            $data["error"] = "error";
                            $data["errorType"] = "warning";
                            $data["message"] = "Please check your Internet Connection!!!";
                        }
                    } else{
                            $data["error"] = "error";
                            $data["errorType"] = "question";
                            $data["message"] = "We are unable to fetch your location, Please try again later!!!";
                    }
                } else{
                    $data["error"] = "empty";
                    $data["errorType"] = "warning";
                    $data["message"] = "Please fill out your Username and Password both!!!";
                }
            }
        }
        // Customer Send Log In Request
        elseif($_POST["action"] == "logSendOtpTry"){
            $logUser = $_POST["logUser"]; //Get Username From Log In Page
            $logPass = $_POST["logPass"]; //Get Password From Log In Page
            $logLocation = $_POST["logLocation"]; //Get Location (Latitude And Longitude) From Log In Page
            $logIp = $_POST["logIp"]; //Get Current IP From Log In Page
            $logDate = $_POST["logDate"]; //Get Today's Date In DD-MM-YYY Format From Log In Page
            $logTime = $_POST["logTime"]; //Get Current Time In HH-MM-SS From Log In Page
            if(!isset($doNotGiveAccess)){
                //If Username And Password Are Not Empty
                if(!empty($logUser && $logPass)){
                    //If Location (Latitude And Longitude) Is Not Empty
                    if(!empty($logLocation)){
                        //If Current IP, Today's Date And Current Time Is Not Empty
                        if(!empty($logIp && $logDate && $logTime)){
                            //Get Data From All Tables
                            if(!empty($log_table)){
                                $databaseObj->select($log_table);
                                $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if(count($getData) != 0){
                                    foreach($getData as $rows){
                                        //Get Admin Log In Information
                                        $customer_log = json_decode($rows["customer_log"]);
                                        $customer_info = json_decode($rows["customer_info"]);
                                        //Check Username
                                        if($customer_log->user == $logUser){
                                            $user_flag = 1;
                                            //Check Password
                                            if($customer_log->pass == md5($logPass)){
                                                $pass_flag = 1;
                                                //If Any SESSION Is Available Unset All
                                                if(isset($_SESSION["wrongPass"]))
                                                    unset($_SESSION["wrongPass"]);
                                                if(isset($_SESSION["wrongUser"]))
                                                    unset($_SESSION["wrongUser"]);
                                                if(isset($_SESSION["primaryLog"]))
                                                    unset($_SESSION["primaryLog"]);
                                                if(isset($_SESSION["primaryLogVal"]))
                                                    unset($_SESSION["primaryLogVal"]);
                                                if(isset($_SESSION["logInfoCustomer"]))
                                                    unset($_SESSION["logInfoCustomer"]);
                                                if(isset($_SESSION["acceptSecondaryLog"]))
                                                    unset($_SESSION["acceptSecondaryLog"]);
                                                if(isset($_COOKIE["logInfoCustomer"])){
                                                    setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                                                    unset($_COOKIE["logInfoCustomer"]);
                                                }
                                                if(isset($_SESSION["checkLoginOTP"]))
                                                    unset($_SESSION["checkLoginOTP"]);
                                                //Give Informations About User
                                                if(!empty($customer_info->phoneNumber)):
                                                    $_SESSION["checkLoginOTP"] = $randSix;
                                                    $messageForOTP = "Dear ".$customer_info->name.", $randSix is your OTP. Please verify to Login into your Dashboard. Do Not share this OTP to anyone. \n\nRegards,\nNetaji Subhas University.";
                                                    // $databaseObj->send_to_phone($customer_info->phoneNumber, $messageForOTP);
                                                    $data["success"] = true;
                                                    $data["phoneNumber"] = "+91 ".substr($customer_info->phoneNumber, 0, 2)."******".substr($customer_info->phoneNumber, 8);
                                                    $data["name"] = $customer_info->name;
                                                    $data["message"] = "We have Sent you an OTP to your Phone Number ( +91 ".substr($customer_info->phoneNumber, 0, 2)."******".substr($customer_info->phoneNumber, 8) ."), Please verify and Login to your Dashboard!!!";
                                                else:
                                                    $data["success"] = true;
                                                    $data["phoneNumber"] = "";
                                                    $data["name"] = $customer_info->phoneNumber;
                                                    $data["message"] = "Your phone number is not Registered, Please contact to Examination Department to Register your Number!!!";
                                                endif;
                                                break;
                                            } else{
                                                if(isset($_SESSION["wrongPass"])){
                                                    if($_SESSION["wrongPass"] < 4){
                                                        $_SESSION["wrongPass"] = $_SESSION["wrongPass"] + 1;
                                                        $data["wrongPass"] = true;
                                                        $data["errorType"] = "error";
                                                        $data["message"] = "Incorrect password, Please try again!!!";
                                                    } else{
                                                        unset($_SESSION["wrongPass"]);
                                                        $data["wrongPassReached"] = true;
                                                        $data["errorType"] = "info";
                                                        $data["message"] = "If you forgot your Password, You can change it now!!!";
                                                    }
                                                } else{
                                                    $_SESSION["wrongPass"] = 1;
                                                    $data["wrongPass"] = true;
                                                    $data["errorType"] = "error";
                                                    $data["message"] = "Incorrect password, Please try again!!!";
                                                }
                                                break;
                                            }
                                            break;
                                        }
                                    }
                                    if($user_flag != 1){
                                        if(isset($_SESSION["wrongUser"])){
                                            if($_SESSION["wrongUser"] < 4){
                                                $_SESSION["wrongUser"] = $_SESSION["wrongUser"] + 1;
                                                $data["wrongUser"] = true;
                                                $data["errorType"] = "error";
                                                $data["message"] = "Username not found, Please check and try again!!!";
                                            } else{
                                                unset($_SESSION["wrongUser"]);
                                                $data["wrongUserReached"] = true;
                                                $data["errorType"] = "info";
                                                $data["message"] = "If you forgot your Username, You can change it now or you can create a new account!!!";
                                            }
                                        } else{
                                            $_SESSION["wrongUser"] = 1;
                                            $data["wrongUser"] = true;
                                            $data["errorType"] = "error";
                                            $data["message"] = "Username not found, Please check and try again!!!";
                                        }
                                    }
                                } else{
                                    $data["error"] = "error";
                                    $data["errorType"] = "question";
                                    $data["message"] = "We are unable to Login this time, Please try again later!!!";
                                }
                            } else{
                                $data["error"] = "error";
                                $data["errorType"] = "warning";
                                $data["message"] = "We are unable to Login this time, Please try again later!!!";
                            }
                        } else{
                            $data["error"] = "error";
                            $data["errorType"] = "warning";
                            $data["message"] = "Please check your Internet Connection!!!";
                        }
                    } else{
                            $data["error"] = "error";
                            $data["errorType"] = "question";
                            $data["message"] = "We are unable to fetch your location, Please try again later!!!";
                    }
                } else{
                    $data["error"] = "empty";
                    $data["errorType"] = "warning";
                    $data["message"] = "Please fill out your Username and Password both!!!";
                }
            }
        }
        // Customer Check OTP Request
        elseif($_POST["action"] == "logCheckOtpTry"){
            $logUser = $_POST["logUser"]; //Get Username From Log In Page
            $logPass = $_POST["logPass"]; //Get Password From Log In Page
            $logLocation = $_POST["logLocation"]; //Get Location (Latitude And Longitude) From Log In Page
            $logIp = $_POST["logIp"]; //Get Current IP From Log In Page
            $logDate = $_POST["logDate"]; //Get Today's Date In DD-MM-YYY Format From Log In Page
            $logTime = $_POST["logTime"]; //Get Current Time In HH-MM-SS From Log In Page
            $logOtp = $_POST["logOtp"]; //Get Current Time In HH-MM-SS From Log In Page
            if(!isset($doNotGiveAccess)){
                //If Username And Password Are Not Empty
                if(!empty($logUser && $logPass)){
                    //If Location (Latitude And Longitude) Is Not Empty
                    if(!empty($logLocation)){
                        //If Current IP, Today's Date And Current Time Is Not Empty
                        if(!empty($logIp && $logDate && $logTime)){
                            if(!empty($logOtp) && strlen($logOtp) == 6){
                                // Check OTP
                                if(isset($_SESSION["checkLoginOTP"]) && $_SESSION["checkLoginOTP"] == $logOtp){
                                    //Get Data From All Tables
                                    if(!empty($log_table)){
                                        $databaseObj->select($log_table);
                                        $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if(count($getData) != 0){
                                            foreach($getData as $rows){
                                                //Get Admin Log In Information
                                                $customer_log = json_decode($rows["customer_log"]);
                                                //Check Username
                                                if($customer_log->user == $logUser){
                                                    $user_flag = 1;
                                                    //Check Password
                                                    if($customer_log->pass == md5($logPass)){
                                                        $pass_flag = 1;
                                                        //If Any SESSION Is Available Unset All
                                                        if(isset($_SESSION["wrongPass"]))
                                                            unset($_SESSION["wrongPass"]);
                                                        if(isset($_SESSION["wrongUser"]))
                                                            unset($_SESSION["wrongUser"]);
                                                        if(isset($_SESSION["primaryLog"]))
                                                            unset($_SESSION["primaryLog"]);
                                                        if(isset($_SESSION["primaryLogVal"]))
                                                            unset($_SESSION["primaryLogVal"]);
                                                        if(isset($_SESSION["logInfoCustomer"]))
                                                            unset($_SESSION["logInfoCustomer"]);
                                                        if(isset($_SESSION["acceptSecondaryLog"]))
                                                            unset($_SESSION["acceptSecondaryLog"]);
                                                        if(isset($_COOKIE["logInfoCustomer"])){
                                                            setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                                                            unset($_COOKIE["logInfoCustomer"]);
                                                        }
                                                        if(isset($_SESSION["checkLoginOTP"]))
                                                            unset($_SESSION["checkLoginOTP"]);
                                                        //Add New Log Information In Log In Information
                                                        $customer_log_info_updated = array(
                                                                                            "logDate"       =>  $logDate,
                                                                                            "logTime"       =>  $logTime,
                                                                                            "logIp"         =>  $logIp,
                                                                                            "logLocation"   =>  $logLocation,
                                                                                            "logStatus"     =>  "primary"
                                                                                    );
                                                        $customer_log_info = json_decode($rows["customer_log_info"], true);
                                                        array_push($customer_log_info, $customer_log_info_updated);
                                                        $dataUpdate["customer_log_info"] = json_encode($customer_log_info);
                                                        //Update The Records
                                                        $check = $databaseObj->update("tbl_customer", $dataUpdate, "`customer_id` = '".$rows["customer_id"]."'");
                                                        if($check == 1){
                                                            //Store All Sessions
                                                            $sessionLogInfo = array(
                                                                                            "logUser"       =>  $customer_log->user,  
                                                                                            "logTime"       =>  $logTime,  
                                                                                            "logIp"         =>  $logIp,  
                                                                                            "logLocation"   =>  $logLocation,  
                                                                                            "logStatus"     =>  "primary",  
                                                                                            "logType"       =>  $customer_log->type, 
                                                                                            "tblType"       =>  "tbl_customer" 
                                                                              );
                                                            $_SESSION["logInfoCustomer"] = json_encode($sessionLogInfo);
                                                            setcookie("logInfoCustomer", json_encode($sessionLogInfo), time() + (86400 * 365), "/");
                                                            $data["success"] = true;
                                                            $data["message"] = "You have successfully Logged In!!!";
                                                            if(isset($_COOKIE["lastInfoCustomer"]))
                                                                $data["redirect"] = $_COOKIE["lastInfoCustomer"];
                                                            else
                                                                $data["redirect"] = "dashboard";
                                                        } else{
                                                            $data["error"] = "error";
                                                            $data["errorType"] = "error";
                                                            $data["message"] = "Something went wrong, Please try again later!!!";
                                                        }
                                                        break;
                                                    } else{
                                                        if(isset($_SESSION["wrongPass"])){
                                                            if($_SESSION["wrongPass"] < 4){
                                                                $_SESSION["wrongPass"] = $_SESSION["wrongPass"] + 1;
                                                                $data["wrongPass"] = true;
                                                                $data["errorType"] = "error";
                                                                $data["message"] = "Incorrect password, Please try again!!!";
                                                            } else{
                                                                unset($_SESSION["wrongPass"]);
                                                                $data["wrongPassReached"] = true;
                                                                $data["errorType"] = "info";
                                                                $data["message"] = "If you forgot your Password, You can change it now!!!";
                                                            }
                                                        } else{
                                                            $_SESSION["wrongPass"] = 1;
                                                            $data["wrongPass"] = true;
                                                            $data["errorType"] = "error";
                                                            $data["message"] = "Incorrect password, Please try again!!!";
                                                        }
                                                        break;
                                                    }
                                                    break;
                                                }
                                            }
                                            if($user_flag != 1){
                                                if(isset($_SESSION["wrongUser"])){
                                                    if($_SESSION["wrongUser"] < 4){
                                                        $_SESSION["wrongUser"] = $_SESSION["wrongUser"] + 1;
                                                        $data["wrongUser"] = true;
                                                        $data["errorType"] = "error";
                                                        $data["message"] = "Username not found, Please check and try again!!!";
                                                    } else{
                                                        unset($_SESSION["wrongUser"]);
                                                        $data["wrongUserReached"] = true;
                                                        $data["errorType"] = "info";
                                                        $data["message"] = "If you forgot your Username, You can change it now or you can create a new account!!!";
                                                    }
                                                } else{
                                                    $_SESSION["wrongUser"] = 1;
                                                    $data["wrongUser"] = true;
                                                    $data["errorType"] = "error";
                                                    $data["message"] = "Username not found, Please check and try again!!!";
                                                }
                                            }
                                        } else{
                                            $data["error"] = "error";
                                            $data["errorType"] = "question";
                                            $data["message"] = "We are unable to Login this time, Please try again later!!!";
                                        }
                                    } else{
                                        $data["error"] = "error";
                                        $data["errorType"] = "warning";
                                        $data["message"] = "We are unable to Login this time, Please try again later!!!";
                                    }
                                } else{
                                    $data["incorrectOtp"] = true;
                                    $data["error"] = "error";
                                    $data["errorType"] = "error";
                                    $data["message"] = "Incorrect OTP!!!";
                                }
                            } else{
                                $data["error"] = "empty";
                                $data["errorType"] = "warning";
                                $data["message"] = "Please enter 6 Digit OTP!!!";
                            }
                        } else{
                            $data["error"] = "error";
                            $data["errorType"] = "warning";
                            $data["message"] = "Please check your Internet Connection!!!";
                        }
                    } else{
                            $data["error"] = "error";
                            $data["errorType"] = "question";
                            $data["message"] = "We are unable to fetch your location, Please try again later!!!";
                    }
                } else{
                    $data["error"] = "empty";
                    $data["errorType"] = "warning";
                    $data["message"] = "Please fill out your Username and Password both!!!";
                }
            }
        }
        // Customer Unlock Request
        elseif($_POST["action"] == "unlockTry"){
            if(isset($_COOKIE["logInfoCustomer"])){
                $logInfoCustomer = json_decode($_COOKIE["logInfoCustomer"]);
                if($logInfoCustomer->tblType == "tbl_customer"){
                    $logPass = $_POST["lockPass"]; //Get Password From Log In Page
                    $logLocation = $_POST["lockLocation"]; //Get Location (Latitude And Longitude) From Log In Page
                    $logIp = $_POST["lockIp"]; //Get Current IP From Log In Page
                    $logDate = $_POST["lockDate"]; //Get Today's Date In DD-MM-YYY Format From Log In Page
                    $logTime = $_POST["lockTime"]; //Get Current Time In HH-MM-SS From Log In Page
                    //If Password Are Not Empty
                    if(!empty($logPass)){
                        //If Location (Latitude And Longitude) Is Not Empty
                        if(!empty($logLocation)){
                            //If Current IP, Today's Date And Current Time Is Not Empty
                            if(!empty($logIp && $logDate && $logTime)){
                                //Get Data From Admin Table
                                $databaseObj->select("tbl_customer");
                                $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if(count($getData) != 0){
                                    foreach($getData as $rows){
                                        //Get Admin Log In Information
                                        $customer_log = json_decode($rows["customer_log"]);
                                        //Check Username
                                        if($customer_log->user == $logInfoCustomer->logUser){
                                            $user_flag = 1;
                                            //Check Password
                                            if($customer_log->pass == md5($logPass)){
                                                $pass_flag = 1;
                                                //Get All Log In Information
                                                $customer_log_info = json_decode($rows["customer_log_info"]);
                                                $customer_log_info_update = array();
                                                foreach($customer_log_info as $last_info){
                                                    if($logInfoCustomer->logStatus == $last_info->logStatus && $logInfoCustomer->logIp == $last_info->logIp){
                                                        $flag = 1;
                                                        continue;
                                                    }
                                                    array_push($customer_log_info_update, $last_info);
                                                }
                                                if(isset($flag)){
                                                    $logStatus = $logInfoCustomer->logStatus;
                                                    //If Any SESSION Is Available Unset All
                                                    if(isset($_SESSION["wrongPass"]))
                                                        unset($_SESSION["wrongPass"]);
                                                    if(isset($_SESSION["wrongUser"]))
                                                        unset($_SESSION["wrongUser"]);
                                                    if(isset($_SESSION["primaryLog"]))
                                                        unset($_SESSION["primaryLog"]);
                                                    if(isset($_SESSION["primaryLogVal"]))
                                                        unset($_SESSION["primaryLogVal"]);
                                                    if(isset($_SESSION["logInfoCustomer"]))
                                                        unset($_SESSION["logInfoCustomer"]);
                                                    if(isset($_COOKIE["logInfoCustomer"])){
                                                        setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                                                        unset($_COOKIE["logInfoCustomer"]);
                                                    }
                                                    //Add New Log Information In Log In Information
                                                    $customer_log_info_updated = array(
                                                                                    "logDate"       =>  $logDate,
                                                                                    "logTime"       =>  $logTime,
                                                                                    "logIp"         =>  $logIp,
                                                                                    "logLocation"   =>  $logLocation,
                                                                                    "logStatus"     =>  $logStatus
                                                                                );
                                                    array_push($customer_log_info_update, $customer_log_info_updated);
                                                    $dataUpdate["customer_log_info"] = json_encode($customer_log_info_update);
                                                    //Update The Records
                                                    $check = $databaseObj->update("tbl_customer", $dataUpdate, "`customer_id` = '".$rows["customer_id"]."'");
                                                    if($check == 1){
                                                        //Store All Sessions
                                                        $sessionLogInfo = array(
                                                                                    "logUser"       =>  $customer_log->user,  
                                                                                    "logTime"       =>  $logTime,  
                                                                                    "logIp"         =>  $logIp,  
                                                                                    "logLocation"   =>  $logLocation,  
                                                                                    "logStatus"     =>  $logStatus,  
                                                                                    "logType"       =>  $customer_log->type,
                                                                                    "tblType"       =>  "tbl_customer" 
                                                                            );
                                                        $_SESSION["logInfoCustomer"] = json_encode($sessionLogInfo);
                                                        setcookie("logInfoCustomer", json_encode($sessionLogInfo), time() + (86400 * 365), "/");
                                                        $data["success"] = true;
                                                        $data["message"] = "You have successfully Unlocked!!!";
                                                        if(isset($_COOKIE["lastInfoCustomer"]))
                                                            $data["redirect"] = $_COOKIE["lastInfoCustomer"];
                                                        else
                                                            $data["redirect"] = "dashboard";
                                                    } else{
                                                        $data["error"] = "error";
                                                        $data["errorType"] = "error";
                                                        $data["message"] = "Something went wrong, Please try again later!!!";
                                                    }
                                                } else{
                                                    if(isset($_SESSION["wrongPass"]))
                                                        unset($_SESSION["wrongPass"]);
                                                    if(isset($_SESSION["wrongUser"]))
                                                        unset($_SESSION["wrongUser"]);
                                                    if(isset($_SESSION["primaryLog"]))
                                                        unset($_SESSION["primaryLog"]);
                                                    if(isset($_SESSION["primaryLogVal"]))
                                                        unset($_SESSION["primaryLogVal"]);
                                                    if(isset($_SESSION["logInfoCustomer"]))
                                                        unset($_SESSION["logInfoCustomer"]);
                                                    if(isset($_COOKIE["logInfoCustomer"])){
                                                        setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                                                        unset($_COOKIE["logInfoCustomer"]);
                                                    }
                                                    setcookie("notNow", $logInfoCustomer->logUser, time() + (60 * 30), "/");
                                                    $data["error"] = "emptyCookie";
                                                    $data["errorType"] = "error";
                                                    $data["message"] = "We are unable to find your Information, Please kindly log in again!!!";
                                                }
                                                break;
                                            } else{
                                                if(isset($_SESSION["wrongPass"])){
                                                    if($_SESSION["wrongPass"] < 4){
                                                        $_SESSION["wrongPass"] = $_SESSION["wrongPass"] + 1;
                                                        $data["wrongPass"] = true;
                                                        $data["errorType"] = "error";
                                                        $data["message"] = "Incorrect password, Please try again!!!";
                                                    } else{
                                                        unset($_SESSION["wrongPass"]);
                                                        $data["wrongPassReached"] = true;
                                                        $data["errorType"] = "info";
                                                        $data["message"] = "If you forgot your Password, You can change it now!!!";
                                                    }
                                                } else{
                                                    $_SESSION["wrongPass"] = 1;
                                                    $data["wrongPass"] = true;
                                                    $data["errorType"] = "error";
                                                    $data["message"] = "Incorrect password, Please try again!!!";
                                                }
                                                break;
                                            }
                                            break;
                                        }
                                    }
                                    if($user_flag != 1){
                                        if(isset($_SESSION["wrongPass"]))
                                            unset($_SESSION["wrongPass"]);
                                        if(isset($_SESSION["wrongUser"]))
                                            unset($_SESSION["wrongUser"]);
                                        if(isset($_SESSION["primaryLog"]))
                                            unset($_SESSION["primaryLog"]);
                                        if(isset($_SESSION["primaryLogVal"]))
                                            unset($_SESSION["primaryLogVal"]);
                                        if(isset($_SESSION["logInfoCustomer"]))
                                            unset($_SESSION["logInfoCustomer"]);
                                        if(isset($_COOKIE["logInfoCustomer"])){
                                            setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                                            unset($_COOKIE["logInfoCustomer"]);
                                        }
                                        $data["error"] = "emptyCookie";
                                        $data["errorType"] = "error";
                                        $data["message"] = "We are unable to find your Informations, Please kindly log in again!!!";
                                    }
                                } else{
                                    $data["error"] = "error";
                                    $data["errorType"] = "error";
                                    $data["message"] = "Something went wrong, Please try again later!!!";
                                }
                            } else{
                                $data["error"] = "error";
                                $data["errorType"] = "warning";
                                $data["message"] = "Please check your Internet Connection!!!";
                            }
                        } else{
                                if(isset($_SESSION["wrongPass"]))
                                    unset($_SESSION["wrongPass"]);
                                if(isset($_SESSION["wrongUser"]))
                                    unset($_SESSION["wrongUser"]);
                                if(isset($_SESSION["primaryLog"]))
                                    unset($_SESSION["primaryLog"]);
                                if(isset($_SESSION["primaryLogVal"]))
                                    unset($_SESSION["primaryLogVal"]);
                                if(isset($_SESSION["logInfoCustomer"]))
                                    unset($_SESSION["logInfoCustomer"]);
                                if(isset($_COOKIE["logInfoCustomer"])){
                                    setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                                    unset($_COOKIE["logInfoCustomer"]);
                                }
                                $data["error"] = "error";
                                $data["errorType"] = "question";
                                $data["message"] = "We are unable to fetch your location, Please try again later!!!";
                        }
                    } else{
                        $data["error"] = "empty";
                        $data["errorType"] = "warning";
                        $data["message"] = "Please fill out your Password!!!";
                    }
                } else{
                    if(isset($_SESSION["wrongPass"]))
                        unset($_SESSION["wrongPass"]);
                    if(isset($_SESSION["wrongUser"]))
                        unset($_SESSION["wrongUser"]);
                    if(isset($_SESSION["primaryLog"]))
                        unset($_SESSION["primaryLog"]);
                    if(isset($_SESSION["primaryLogVal"]))
                        unset($_SESSION["primaryLogVal"]);
                    if(isset($_SESSION["logInfoCustomer"]))
                        unset($_SESSION["logInfoCustomer"]);
                    if(isset($_COOKIE["logInfoCustomer"])){
                        setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                        unset($_COOKIE["logInfoCustomer"]);
                    }
                    $data["error"] = "emptyCookie";
                    $data["errorType"] = "error";
                    $data["message"] = "We are unable to find your Information, Please kindly log in again!!!";
                }
            } else{
                if(isset($_SESSION["wrongPass"]))
                    unset($_SESSION["wrongPass"]);
                if(isset($_SESSION["wrongUser"]))
                    unset($_SESSION["wrongUser"]);
                if(isset($_SESSION["primaryLog"]))
                    unset($_SESSION["primaryLog"]);
                if(isset($_SESSION["primaryLogVal"]))
                    unset($_SESSION["primaryLogVal"]);
                if(isset($_SESSION["logInfoCustomer"]))
                    unset($_SESSION["logInfoCustomer"]);
                if(isset($_COOKIE["logInfoCustomer"])){
                    setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                    unset($_COOKIE["logInfoCustomer"]);
                }
                $data["error"] = "emptyCookie";
                $data["errorType"] = "error";
                $data["message"] = "We are unable to find your Informations, Please kindly log in again!!!";
            }
        }
        // Customer Lock Request
        elseif($_POST["action"] == "lockApp"){
            //Unset the logInfoCustomer SESSION
            if(isset($_SESSION["logInfoCustomer"])){
                unset($_SESSION["logInfoCustomer"]);
                if(!isset($_SESSION["logInfoCustomer"]))
                    $data["success"] = true;
                else{
                    $data["error"] = "error";
                    $data["errorType"] = "error";
                    $data["message"] = "Something went wrong, Please try again later!!!";
                }
            } else{
                $data["error"] = "error";
                $data["errorType"] = "error";
                $data["message"] = "Something went wrong, Please try again later!!!";
            }
        }
        // Customer Log Out Request
        elseif($_POST["action"] == "logOutApp"){
            $logInfoCustomer = json_decode($_COOKIE["logInfoCustomer"]);
            if($logInfoCustomer->tblType == "tbl_customer"){
                //Get Data From Admin Table
                $databaseObj->select("tbl_customer");
                $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                $getData = $databaseObj->get();
                //Checking If Data Is Available
                if(count($getData) != 0){
                    foreach($getData as $rows){
                        //Get Admin Log In Information
                        $customer_log = json_decode($rows["customer_log"]);
                        $customer_info = json_decode($rows["customer_info"]);
                        //Check Username
                        if($customer_log->user == $logInfoCustomer->logUser){
                            $user_flag = 1;
                            //Get All Log In Information
                            $customer_log_info = json_decode($rows["customer_log_info"]);
                            foreach($customer_log_info as $last_info){
                                if($last_info->logIp == $logInfoCustomer->logIp && $last_info->logStatus == $logInfoCustomer->logStatus)
                                    $last_info->logStatus = "out";
                            }
                            $dataUpdate["customer_log_info"] = json_encode($customer_log_info);
                            //Update The Records
                            $check = $databaseObj->update("tbl_customer", $dataUpdate, "`customer_id` = '".$rows["customer_id"]."'");
                            if($check == 1){
                                $flag = 1;
                                //If Any SESSION Is Available Unset All
                                if(isset($_SESSION["wrongPass"]))
                                    unset($_SESSION["wrongPass"]);
                                if(isset($_SESSION["wrongUser"]))
                                    unset($_SESSION["wrongUser"]);
                                if(isset($_SESSION["primaryLog"]))
                                    unset($_SESSION["primaryLog"]);
                                if(isset($_SESSION["primaryLogVal"]))
                                    unset($_SESSION["primaryLogVal"]);
                                if(isset($_SESSION["logInfoCustomer"]))
                                    unset($_SESSION["logInfoCustomer"]);
                                if(isset($_COOKIE["logInfoCustomer"])){
                                    setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                                    unset($_COOKIE["logInfoCustomer"]);
                                }
                                $data["success"] = true;
                            } else{
                                $data["error"] = "error";
                                $data["errorType"] = "error";
                                $data["message"] = "Something went wrong, Please try again later!!!";
                            }
                            break;
                        }
                    }
                    if($user_flag != 1){
                        if(isset($_SESSION["wrongPass"]))
                        unset($_SESSION["wrongPass"]);
                        if(isset($_SESSION["wrongUser"]))
                            unset($_SESSION["wrongUser"]);
                        if(isset($_SESSION["primaryLog"]))
                            unset($_SESSION["primaryLog"]);
                        if(isset($_SESSION["primaryLogVal"]))
                            unset($_SESSION["primaryLogVal"]);
                        if(isset($_SESSION["logInfoCustomer"]))
                            unset($_SESSION["logInfoCustomer"]);
                        if(isset($_COOKIE["logInfoCustomer"])){
                            setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                            unset($_COOKIE["logInfoCustomer"]);
                        }
                        $data["error"] = "emptyCookie";
                        $data["errorType"] = "error";
                        $data["message"] = "Something went wrong, Please try again later!!!";
                    }
                } else{
                    if(isset($_SESSION["wrongPass"]))
                        unset($_SESSION["wrongPass"]);
                    if(isset($_SESSION["wrongUser"]))
                        unset($_SESSION["wrongUser"]);
                    if(isset($_SESSION["primaryLog"]))
                        unset($_SESSION["primaryLog"]);
                    if(isset($_SESSION["primaryLogVal"]))
                        unset($_SESSION["primaryLogVal"]);
                    if(isset($_SESSION["logInfoCustomer"]))
                        unset($_SESSION["logInfoCustomer"]);
                    if(isset($_COOKIE["logInfoCustomer"])){
                        setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                        unset($_COOKIE["logInfoCustomer"]);
                    }
                    $data["error"] = "emptyCookie";
                    $data["errorType"] = "error";
                    $data["message"] = "Something went wrong, Please try again later!!!";
                }
            } else{
                $data["error"] = "error";
                $data["errorType"] = "error";
                $data["message"] = "Something went wrong, Please try again later!!!";
            }
        }
        
        else{
            $data["error"] = "error";
            $data["errorType"] = "error";
            $data["message"] = "Something went wrong, Please try again later!!!";
        }
        echo json_encode($data);
    }
?>