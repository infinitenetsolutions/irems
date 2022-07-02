<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    $log_table = "tbl_admin";
    $log_type = "";
    $log_id =  "";
    $log_complete   =  "";
    $user_flag = 0;
    $pass_flag = 0;
    $auth_flag = 0;
    if(isset($_POST["action"])){
        // Admin Log In Requestll
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
                               // $databaseObj->where("`status` = '"$databaseObj->visible"'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if(count($getData) != 0){
                                    foreach($getData as $rows){
                                        //Get Admin Log In Information
                                        $admin_log = json_decode($rows["admin_log"]);
                                        //Check Username
                                        if($admin_log->user == $logUser){
                                            $user_flag = 1;
                                            //Check Password
                                            if($admin_log->pass == md5($logPass)){
                                          //if($admin_log->pass == $logPass){
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
                                                if(isset($_SESSION["logInfo"]))
                                                    unset($_SESSION["logInfo"]);
                                                if(isset($_SESSION["acceptSecondaryLog"]))
                                                    unset($_SESSION["acceptSecondaryLog"]);
                                                if(isset($_COOKIE["logInfo"])){
                                                    setcookie("logInfo",  "",  time() - 3600, "/");
                                                    unset($_COOKIE["logInfo"]);
                                                }
                                                //Add New Log Information In Log In Information
                                                $admin_log_info_updated = array(
                                                                                    "logDate"       =>  $logDate,
                                                                                    "logTime"       =>  $logTime,
                                                                                    "logIp"         =>  $logIp,
                                                                                    "logLocation"   =>  $logLocation,
                                                                                    "logStatus"     =>  "primary"
                                                                            );
                                                $admin_log_info = json_decode($rows["admin_log_info"], true);
                                                array_push($admin_log_info, $admin_log_info_updated);
                                                $dataUpdate["admin_log_info"] = json_encode($admin_log_info);
                                                //Update The Records
                                                $check = $databaseObj->update("tbl_admin", $dataUpdate, "`admin_id` = '".$rows["admin_id"]."'");
                                                if($check == 1){
                                                    //Store All Sessions
                                                    $sessionLogInfo = array(
                                                                                    "logUser"       =>  $admin_log->user,  
                                                                                    "logTime"       =>  $logTime,  
                                                                                    "logIp"         =>  $logIp,  
                                                                                    "logLocation"   =>  $logLocation,  
                                                                                    "logStatus"     =>  "primary",  
                                                                                    "logType"       =>  $admin_log->type, 
                                                                                    "tblType"       =>  "tbl_admin" 
                                                                      );
                                                    $_SESSION["logInfo"] = json_encode($sessionLogInfo);
                                                    setcookie("logInfo", json_encode($sessionLogInfo), time() + (86400 * 365), "/");
                                                    $data["success"] = true;
                                                    $data["message"] = "You have successfully Logged In!!!";
                                                    if(isset($_COOKIE["lastInfo"]))
                                                        $data["redirect"] = $_COOKIE["lastInfo"];
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
        // Admin Unlock Request
        elseif($_POST["action"] == "unlockTry"){
            if(isset($_COOKIE["logInfo"])){
                $logInfo = json_decode($_COOKIE["logInfo"]);
                if($logInfo->tblType == "tbl_admin"){
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
                                $databaseObj->select("tbl_admin");
                                $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                if(count($getData) != 0){
                                    foreach($getData as $rows){
                                        //Get Admin Log In Information
                                        $admin_log = json_decode($rows["admin_log"]);
                                        //Check Username
                                        if($admin_log->user == $logInfo->logUser){
                                            $user_flag = 1;
                                            //Check Password
                                            if($admin_log->pass == md5($logPass)){
                                              //if($admin_log->pass == $logPass){
                                                $pass_flag = 1;
                                                //Get All Log In Information
                                                $admin_log_info = json_decode($rows["admin_log_info"]);
                                                $admin_log_info_update = array();
                                                foreach($admin_log_info as $last_info){
                                                    if($logInfo->logStatus == $last_info->logStatus && $logInfo->logIp == $last_info->logIp){
                                                        $flag = 1;
                                                        continue;
                                                    }
                                                    array_push($admin_log_info_update, $last_info);
                                                }
                                                if(isset($flag)){
                                                    $logStatus = $logInfo->logStatus;
                                                    //If Any SESSION Is Available Unset All
                                                    if(isset($_SESSION["wrongPass"]))
                                                        unset($_SESSION["wrongPass"]);
                                                    if(isset($_SESSION["wrongUser"]))
                                                        unset($_SESSION["wrongUser"]);
                                                    if(isset($_SESSION["primaryLog"]))
                                                        unset($_SESSION["primaryLog"]);
                                                    if(isset($_SESSION["primaryLogVal"]))
                                                        unset($_SESSION["primaryLogVal"]);
                                                    if(isset($_SESSION["logInfo"]))
                                                        unset($_SESSION["logInfo"]);
                                                    if(isset($_COOKIE["logInfo"])){
                                                        setcookie("logInfo",  "",  time() - 3600, "/");
                                                        unset($_COOKIE["logInfo"]);
                                                    }
                                                    //Add New Log Information In Log In Information
                                                    $admin_log_info_updated = array(
                                                                                    "logDate"       =>  $logDate,
                                                                                    "logTime"       =>  $logTime,
                                                                                    "logIp"         =>  $logIp,
                                                                                    "logLocation"   =>  $logLocation,
                                                                                    "logStatus"     =>  $logStatus
                                                                                );
                                                    array_push($admin_log_info_update, $admin_log_info_updated);
                                                    $dataUpdate["admin_log_info"] = json_encode($admin_log_info_update);
                                                    //Update The Records
                                                    $check = $databaseObj->update("tbl_admin", $dataUpdate, "`admin_id` = '".$rows["admin_id"]."'");
                                                    if($check == 1){
                                                        //Store All Sessions
                                                        $sessionLogInfo = array(
                                                                                    "logUser"       =>  $admin_log->user,  
                                                                                    "logTime"       =>  $logTime,  
                                                                                    "logIp"         =>  $logIp,  
                                                                                    "logLocation"   =>  $logLocation,  
                                                                                    "logStatus"     =>  $logStatus,  
                                                                                    "logType"       =>  $admin_log->type,
                                                                                    "tblType"       =>  "tbl_admin" 
                                                                            );
                                                        $_SESSION["logInfo"] = json_encode($sessionLogInfo);
                                                        setcookie("logInfo", json_encode($sessionLogInfo), time() + (86400 * 365), "/");
                                                        $data["success"] = true;
                                                        $data["message"] = "You have successfully Unlocked!!!";
                                                        if(isset($_COOKIE["lastInfo"]))
                                                            $data["redirect"] = $_COOKIE["lastInfo"];
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
                                                    if(isset($_SESSION["logInfo"]))
                                                        unset($_SESSION["logInfo"]);
                                                    if(isset($_COOKIE["logInfo"])){
                                                        setcookie("logInfo",  "",  time() - 3600, "/");
                                                        unset($_COOKIE["logInfo"]);
                                                    }
                                                    setcookie("notNow", $logInfo->logUser, time() + (60 * 30), "/");
                                                    $data["error"] = "emptyCookie";
                                                    $data["errorType"] = "error";
                                                    $data["message"] = "We are unable to find your Informations, Please kindly log in again!!!";
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
                                        if(isset($_SESSION["logInfo"]))
                                            unset($_SESSION["logInfo"]);
                                        if(isset($_COOKIE["logInfo"])){
                                            setcookie("logInfo",  "",  time() - 3600, "/");
                                            unset($_COOKIE["logInfo"]);
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
                                if(isset($_SESSION["logInfo"]))
                                    unset($_SESSION["logInfo"]);
                                if(isset($_COOKIE["logInfo"])){
                                    setcookie("logInfo",  "",  time() - 3600, "/");
                                    unset($_COOKIE["logInfo"]);
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
                    if(isset($_SESSION["logInfo"]))
                        unset($_SESSION["logInfo"]);
                    if(isset($_COOKIE["logInfo"])){
                        setcookie("logInfo",  "",  time() - 3600, "/");
                        unset($_COOKIE["logInfo"]);
                    }
                    $data["error"] = "emptyCookie";
                    $data["errorType"] = "error";
                    $data["message"] = "We are unable to find your Informations, Please kindly log in again!!!";
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
                if(isset($_SESSION["logInfo"]))
                    unset($_SESSION["logInfo"]);
                if(isset($_COOKIE["logInfo"])){
                    setcookie("logInfo",  "",  time() - 3600, "/");
                    unset($_COOKIE["logInfo"]);
                }
                $data["error"] = "emptyCookie";
                $data["errorType"] = "error";
                $data["message"] = "We are unable to find your Informations, Please kindly log in again!!!";
            }
        }
        // Admin Lock Request
        elseif($_POST["action"] == "lockApp"){
            //Unset the logInfo SESSION
            if(isset($_SESSION["logInfo"])){
                unset($_SESSION["logInfo"]);
                if(!isset($_SESSION["logInfo"]))
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
        // Admin Log Out Request
        elseif($_POST["action"] == "logOutApp"){
            $logInfo = json_decode($_COOKIE["logInfo"]);
            if($logInfo->tblType == "tbl_admin"){
                //Get Data From Admin Table
                $databaseObj->select("tbl_admin");
                $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                $getData = $databaseObj->get();
                //Checking If Data Is Available
                if(count($getData) != 0){
                    foreach($getData as $rows){
                        //Get Admin Log In Information
                        $admin_log = json_decode($rows["admin_log"]);
                        $admin_info = json_decode($rows["admin_info"]);
                        //Check Username
                        if($admin_log->user == $logInfo->logUser){
                            $user_flag = 1;
                            //Get All Log In Information
                            $admin_log_info = json_decode($rows["admin_log_info"]);
                            foreach($admin_log_info as $last_info){
                                if($last_info->logIp == $logInfo->logIp && $last_info->logStatus == $logInfo->logStatus)
                                    $last_info->logStatus = "out";
                            }
                            $dataUpdate["admin_log_info"] = json_encode($admin_log_info);
                            //Update The Records
                            $check = $databaseObj->update("tbl_admin", $dataUpdate, "`admin_id` = '".$rows["admin_id"]."'");
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
                                if(isset($_SESSION["logInfo"]))
                                    unset($_SESSION["logInfo"]);
                                if(isset($_COOKIE["logInfo"])){
                                    setcookie("logInfo",  "",  time() - 3600, "/");
                                    unset($_COOKIE["logInfo"]);
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
                        if(isset($_SESSION["logInfo"]))
                            unset($_SESSION["logInfo"]);
                        if(isset($_COOKIE["logInfo"])){
                            setcookie("logInfo",  "",  time() - 3600, "/");
                            unset($_COOKIE["logInfo"]);
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
                    if(isset($_SESSION["logInfo"]))
                        unset($_SESSION["logInfo"]);
                    if(isset($_COOKIE["logInfo"])){
                        setcookie("logInfo",  "",  time() - 3600, "/");
                        unset($_COOKIE["logInfo"]);
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