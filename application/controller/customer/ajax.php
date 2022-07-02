<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    if(isset($_POST["action"])){
        //Admin Cookies And Session Request From Index
        if($_POST["action"] == "checkCookiesAndSessions"){
            if(isset($_COOKIE["logInfoCustomer"])){
                if(isset($_SESSION["logInfoCustomer"])){
                    $data["success"] = true;
                } else{
                    $logInfoCustomer = json_decode($_COOKIE["logInfoCustomer"]);
                    //Get Data From Admin Table
                    $databaseObj->select("tbl_customer");
                    $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                    $getData = $databaseObj->get();
                    //Checking If Data Is Available
                    if($getData != 0){
                        foreach($getData as $rows){
                            //Get Admin Log In Information
                            $customer_log = json_decode($rows["customer_log"]);
                            $customer_info = json_decode($rows["customer_info"]);
                            //Check Username
                            if($customer_log->user == $logInfoCustomer->logUser){
                                $flag = 1;
                                $data["error"] = true;
                                $data["errorType"] = "emptySession";
                                if($customer_info->nickName != "")
                                    $data["logName"] = $customer_info->nickName;
                                else
                                    $data["logName"] = $customer_info->name;
                                if($customer_info->dp != "")
                                    $data["logDp"] = "../../assets/customer/profile/".$customer_info->dp;
                                else
                                    if($customer_info->gender == "male")
                                        $data["logDp"] = "../../assets/customer/profile/men-Icon.png";
                                    else
                                        $data["logDp"] = "../../assets/customer/profile/women-Icon.png";
                                break;
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
                        if(isset($_SESSION["logInfoCustomer"]))
                            unset($_SESSION["logInfoCustomer"]);
                        if(isset($_COOKIE["logInfoCustomer"])){
                            setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                            unset($_COOKIE["logInfoCustomer"]);
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
            if(isset($_COOKIE["logInfoCustomer"])){
                if(isset($_SESSION["logInfoCustomer"])){
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
                if(isset($_SESSION["logInfoCustomer"]))
                    unset($_SESSION["logInfoCustomer"]);
                if(isset($_COOKIE["logInfoCustomer"])){
                    setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                    unset($_COOKIE["logInfoCustomer"]);
                }
                $data["error"] = true;
                $data["errorType"] = "emptyCookies";
            }
        }
        //Admin Out From All Pages
        if($_POST["action"] == "checkOut"){
            if(!isset($_SESSION["checkAlready"])){
                if(isset($_COOKIE["logInfoCustomer"])){
                    if(isset($_SESSION["logInfoCustomer"])){
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
                        if(isset($_SESSION["logInfoCustomer"]))
                            unset($_SESSION["logInfoCustomer"]);
                        if(isset($_COOKIE["logInfoCustomer"])){
                            setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                            unset($_COOKIE["logInfoCustomer"]);
                        }
                        $data["error"] = true;
                        $data["errorType"] = "emptyCookies";
                    } else
                        $data["success"] = true;
                }
            } else
                $data["success"] = true;
        }
        //Check Another Request
        if($_POST["action"] == "checkAnotherRequest"){
            if(!isset($_SESSION["requestAlreadyChecked"])){
                $logInfoCustomer = json_decode($_COOKIE["logInfoCustomer"]);
                if($logInfoCustomer->logStatus == "primary"){
                    //Get Data From Admin Table
                    $databaseObj->select("tbl_customer");
                    $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                    $getData = $databaseObj->get();
                    //Checking If Data Is Available
                    if($getData != 0){
                        foreach($getData as $rows){
                            //Get Admin Log In Information
                            $customer_log = json_decode($rows["customer_log"]);
                            $customer_info = json_decode($rows["customer_info"]);
                            $customer_ajax = json_decode($rows["customer_ajax"]);
                            //Check Username
                            if($customer_log->user == $logInfoCustomer->logUser){
                                if($customer_ajax->responce == "request"){
                                    $loc = explode(",", $customer_ajax->location);
                                    $completeLat = explode(":", $loc[0]);
                                    $completeLong = explode(":", $loc[1]);
                                    $data["lat"] = $completeLat[1];
                                    $data["long"] = $completeLong[1];
                                    $data["success"] = true;
                                    $_SESSION["requestAlreadyChecked"] = true;
                                } else{
                                    $data["error"] = true;
                                    $data["errorType"] = "notYet";
                                }
                                break;
                            }
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
                        if(isset($_SESSION["logInfoCustomer"]))
                            unset($_SESSION["logInfoCustomer"]);
                        if(isset($_COOKIE["logInfoCustomer"])){
                            setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                            unset($_COOKIE["logInfoCustomer"]);
                        }
                        $data["error"] = true;
                        $data["errorType"] = "userNotFound";
                    }
                } else
                    $data["notAPrimaryUser"] = true;
            } else
                $data["requestAlreadyChecked"] = true;
        }
        //Check Log Out From Outside
        if($_POST["action"] == "checkLogOutFromOutsite"){
            //If user get logged Off
            if(isset($_COOKIE["notNow"]))
                $_SESSION["outAlreadyChecked"] = true;
            else
                if(isset($_SESSION["outAlreadyChecked"]))
                    unset($_SESSION["outAlreadyChecked"]);
            if(!isset($_SESSION["outAlreadyChecked"])){
                if(isset($_SESSION["logInfoCustomer"])){
                    $logInfoCustomer = json_decode($_COOKIE["logInfoCustomer"]);
                    //Get Data From Admin Table
                    $databaseObj->select("tbl_customer");
                    $databaseObj->where("`status` = '".md5($databaseObj->visible)."'");
                    $getData = $databaseObj->get();
                    //Checking If Data Is Available
                    if($getData != 0){
                        foreach($getData as $rows){
                            //Get Admin Log In Information
                            $customer_log = json_decode($rows["customer_log"]);
                            $customer_log_info = json_decode($rows["customer_log_info"]);
                            //Check Username
                            if($customer_log->user == $logInfoCustomer->logUser){
                                foreach($customer_log_info as $last_info){
                                    if($logInfoCustomer->logStatus == $last_info->logStatus && $logInfoCustomer->logIp == $last_info->logIp){
                                        $flag = 1;
                                        break;
                                    }
                                }
                            }
                        }
                        if(isset($flag)){
                            $data["error"] = true;
                            $data["errorType"] = "notNow";
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
                            $data["success"] = true;
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
                        if(isset($_SESSION["logInfoCustomer"]))
                            unset($_SESSION["logInfoCustomer"]);
                        if(isset($_COOKIE["logInfoCustomer"])){
                            setcookie("logInfoCustomer",  "",  time() - 3600, "/");
                            unset($_COOKIE["logInfoCustomer"]);
                        }
                        $data["error"] = true;
                        $data["errorType"] = "userNotFound";
                    }
                }
            } else
                $data["outAlreadyChecked"] = true;
        }
        echo json_encode($data);
    }
?>