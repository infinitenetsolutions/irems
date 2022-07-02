<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    if(isset($_POST["action"])){
        //Admin Cookies And Session Request From Index
        if($_POST["action"] == "checkCookiesAndSessions"){
            if(isset($_COOKIE["logInfo"])){
                if(isset($_SESSION["logInfo"])){
                    $data["success"] = true;
                } else{
                    $logInfo = json_decode($_COOKIE["logInfo"]);
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
                                $flag = 1;
                                $data["error"] = true;
                                $data["errorType"] = "emptySession";
                                if($admin_info->nickName != "")
                                    $data["logName"] = $admin_info->nickName;
                                else
                                    $data["logName"] = $admin_info->name;
                                if($admin_info->dp != "")
                                    $data["logDp"] = $admin_info->dp;
                                else
                                    if($admin_info->gender == "male")
                                        $data["logDp"] = "men-Icon.png";
                                    else
                                        $data["logDp"] = "women-Icon.png";
                                break;
                            }
                        }
                    } 
                    if(!isset($flag)){
                        
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
                                if($customer_log->user == $logInfo->logUser){
                                    $flag = 1;
                                    $data["error"] = true;
                                    $data["errorType"] = "emptySession";
                                    if($customer_info->nickName != "")
                                        $data["logName"] = $customer_info->nickName;
                                    else
                                        $data["logName"] = $customer_info->name;
                                    if($customer_info->dp != "")
                                        $data["logDp"] = $customer_info->dp;
                                    else
                                        if($customer_info->gender == "male")
                                            $data["logDp"] = "men-Icon.png";
                                        else
                                            $data["logDp"] = "women-Icon.png";
                                    break;
                                }
                            }
                        }
                    }
                    if(!isset($flag)){
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
                        $data["error"] = true;
                        $data["errorType"] = "userNotFound";
                    }
                }
            } else{
                $data["error"] = true;
                $data["errorType"] = "emptyCookies";
            }
        }
        //Admin Cookies And Session Request From Inner
        if($_POST["action"] == "checkCookiesAndSessionsInner"){
            if(isset($_COOKIE["logInfo"])){
                if(isset($_SESSION["logInfo"])){
                    $data["success"] = true;
                } else{
                        $data["error"] = true;
                        $data["errorType"] = "emptySession";
                }
            } else{
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
                $data["error"] = true;
                $data["errorType"] = "emptyCookies";
            }
        }
        //Admin Out From All Pages
        if($_POST["action"] == "checkOut"){
            if(!isset($_SESSION["checkAlready"])){
                if(isset($_COOKIE["logInfo"])){
                    if(isset($_SESSION["logInfo"])){
                        $data["success"] = true;
                    } else{
                        if(!isset($_SESSION["checkAlready"])){
                            $_SESSION["checkAlready"] = true;
                            $data["error"] = true;
                            $data["errorType"] = "emptySession";
                        } else
                            $data["success"] = true;
                    }
                } else{
                    if(!isset($_SESSION["checkAlready"])){
                        //Store a Check Already SESSION
                        $_SESSION["checkAlready"] = true;
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
                        $data["error"] = true;
                        $data["errorType"] = "emptyCookies";
                    } else
                        $data["success"] = true;
                }
            } else
                $data["success"] = true;
        }
        echo json_encode($data);
    }
?>