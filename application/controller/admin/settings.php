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
    $settingbgimageDir = "../../../assets/bg/";
    $settingDir = "../../../assets/admin/setting/";
    
    if(isset($_POST["action"])):
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Change Mail Status Section Start -----------
            // -----------------------------------------------
            case "changeMailStatus":
                if($authority == 1):
                    if(isset($_POST["val"])):
                        $databaseObj->select("tbl_setting");
                        $databaseObj->where(" `setting_id` = '1'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $setting_soft_info = json_decode($rows["setting_soft_info"]);
                            endforeach;
                            $setting_soft_info->mail_status = $_POST["val"];
                            $dataUpdate["setting_soft_info"] = json_encode($setting_soft_info);

                            $check = $databaseObj->update("tbl_setting", $dataUpdate, "`setting_id` = '".$rows["setting_id"]."'");

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
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            // -----------------------------------------------
            // ------------ Change Mail Status Section End -------------
            // -----------------------------------------------
            




             // -----------------------------------------------
            // ------------ Change Message Service Status Start -----------
            // -----------------------------------------------
            case "changeMessageStatus":
                if($authority == 1):
                    if(isset($_POST["val"])):
                        $databaseObj->select("tbl_setting");
                        $databaseObj->where(" `setting_id` = '1'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $setting_soft_info = json_decode($rows["setting_soft_info"]);
                            endforeach;
                            $setting_soft_info->message_status = $_POST["val"];
                            $dataUpdate["setting_soft_info"] = json_encode($setting_soft_info);
                            $check = $databaseObj->update("tbl_setting", $dataUpdate, "`setting_id` = '".$rows["setting_id"]."'");

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
                    $data["response"] = "noAuthority";
                    $data["responseType"] = "error";
                    $data["responseMessage"] = "You are not authorized to add!!!";
                endif;
                break;
            // -----------------------------------------------
            // ------------ Change Mail Status Section End -------------
            // -----------------------------------------------

            // -----------------------------------------------
            // ------------ Changetheme setting -----------
            // -----------------------------------------------
            case "changethemesetting":
                
                            if($authority == 1):
                               
                                    
                                              if(!empty($_POST["headerColor"] && $_POST["headerBackground"] && $_POST["FooterColor"]  && $_POST["FooterBackground"] && $_POST["SidebarColor"] && $_POST["SidebarBackground"] && $_POST["SidebarActiveColor"]  && $_POST["SidebarActiveBackground"] && $_POST["ThemeColorChange"] )):

                                              $databaseObj->select("tbl_setting");
                                                $databaseObj->where(" `setting_id` = '1'");
                                                $getData = $databaseObj->get();
//echo "<pre>";
//   print_r($getData);
//echo "</pre>";
// exit(0);                                          //Checking If Data Is Available
                                                                if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rows):
                                                                        $setting_theme_info = json_decode($rows["setting_theme_info"]);
                                                                    endforeach;
//echo "<pre>";
//   print_r($getData);
//echo "</pre>";

                                                                    $setting_theme_info->header_color = $_POST["headerColor"];
                                                                    $setting_theme_info->header_bg = $_POST["headerBackground"];
                                                                    $setting_theme_info->footer_color = $_POST["FooterColor"];
                                                                    $setting_theme_info->footer_bg = $_POST["FooterBackground"];
                                                                    $setting_theme_info->sidebar_color = $_POST["SidebarColor"];
                                                                    $setting_theme_info->sidebar_bg = $_POST["SidebarBackground"];
                                                                    $setting_theme_info->sidebar_active_color = $_POST["SidebarActiveColor"];
                                                                    $setting_theme_info->sidebar_active_bg = $_POST["SidebarActiveBackground"];
                                                                     $setting_theme_info->ThemeChange = $_POST["ThemeColorChange"];

                                                                    $dataUpdate["setting_theme_info"] = json_encode($setting_theme_info);
                                                                    $check = $databaseObj->update("tbl_setting", $dataUpdate, "`setting_id` = '".$rows["setting_id"]."'");


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
                                                    $data["response"] = "Not Found";
                                                    $data["responseType"] = "error";
                                                    $data["responseMessage"] = "Something went wrong, please try again or refresh!!!";
                                                endif;
                           
                        else:
                            $data["response"] = "noAuthority";
                            $data["responseType"] = "error";
                            $data["responseMessage"] = "You are not authorized to add!!!";
                        endif;
                            break;
            // -----------------------------------------------
            // ------------ Change Theme Settings End -------------
            // -----------------------------------------------
           // -----------------------------------------------
            // ------------ Upload Background Image  -----------
            // -----------------------------------------------
            case "uploadIndexBack":
                
                            if($authority == 1):
                               
                                    
                                              if(!empty($_FILES["IndexBackground"]["name"])):
                                                 if(!empty($_FILES["IndexBackground"]["name"])):
                                                    
                                                    
                                                    if(move_uploaded_file($_FILES["IndexBackground"]["tmp_name"] ,          $settingbgimageDir.$randSix."_".$_FILES["IndexBackground"]["name"])):
                                                        $IndexBackground = $randSix."_".$_FILES["IndexBackground"]["name"];
                                                         
                                                    else:
                                                        $IndexBackground = "index-bg.png";
//                                                     else if (($_FILES["IndexBackground"]["size"] > 2000000)) {
//                                                        $response = array(
//                                                            "type" => "error",
//                                                            "message" => "Image size exceeds 2MB"
//                                                        );
//                                                    }   
                                                    endif;
                                                else:
                                                    $IndexBackground = "index-bg.png";
                                                endif;

                                                $databaseObj->select("tbl_setting");
                                                $databaseObj->where(" `setting_id` = '1'");
                                                $getData = $databaseObj->get();
                                                //Checking If Data Is Available
                                                                if($getData != 0):
                                                                    $sno = 1;
                                                                    foreach($getData as $rows):
                                                                        $setting_theme_info = json_decode($rows["setting_theme_info"]);
                                                                    endforeach;
                                                                   
                                                                    $setting_theme_info->IndexBackground = $IndexBackground;
                                                                    $dataUpdate["setting_theme_info"] = json_encode($setting_theme_info);
                                                                    $check = $databaseObj->update("tbl_setting", $dataUpdate, "`setting_id` = '".$rows["setting_id"]."'");
                                                                                if($check == 1):
                                                                                    echo $IndexBackground;
                                                                                else:
                                                                                    echo "error";
                                                                                endif;
                                                                else:
                                                                     echo "error";
                                                                endif;
                                                    
                                                else:
                                                     echo "error";
                                                endif;
                           
                        else:
                             echo "error";
                        endif;
                        exit(0);
                            break;
            // -----------------------------------------------
            // ------------ Upload Background Image -------------
            // -----------------------------------------------
        

             // -----------------------------------------------
             // ------------ Upload QR code -----------
             // -----------------------------------------------
            case "uploadQrCode":
                
                            if($authority == 1):
                               if(!empty($_FILES["QrCode"]["name"])):
                                 if(!empty($_FILES["QrCode"]["name"])):
                                    if(move_uploaded_file($_FILES["QrCode"]["tmp_name"] ,          
                                        $settingDir.$randSix."_".$_FILES["QrCode"]["name"])):
                                        $QrCode = $randSix."_".$_FILES["QrCode"]["name"];
                                    else:
                                        $QrCode = "qrcode2.png";
                                    endif;
                                else:
                                    $QrCode = "qrcode2.png";
                                    $QrCode = "qrcode2.png";
                                endif;

                                $databaseObj->select("tbl_setting");
                                $databaseObj->where(" `setting_id` = '1'");
                                $getData = $databaseObj->get();
                                //Checking If Data Is Available
                                                if($getData != 0):
                                                    $sno = 1;
                                                    foreach($getData as $rows):
                                                        $setting_theme_info = json_decode($rows["setting_theme_info"]);
                                                    endforeach;
//                                                                    
                                                    $setting_theme_info->QrCode= $QrCode;
                                                    $dataUpdate["setting_theme_info"] = json_encode($setting_theme_info);
                                                    $check = $databaseObj->update("tbl_setting", $dataUpdate, "`setting_id` = '".$rows["setting_id"]."'");
                                                                if($check == 1):
                                                                    echo $QrCode;
                                                                                else:
                                                                                    echo "error";
                                                                                endif;
                                                                else:
                                                                     echo "error";
                                                                endif;
                                                    
                                                else:
                                                     echo "error";
                                                endif;
                           
                        else:
                             echo "error";
                        endif;
                        exit(0);
                            break;
            // -----------------------------------------------
            // ------------ Upload Qrcode ends -------------
            // -----------------------------------------------
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