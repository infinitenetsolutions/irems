<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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
    
    if(isset($_POST["action"])):
        // -----------------------------------
        // ------------ Switch Start --------- 
        // -----------------------------------
        // print_r($_POST);
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Add Data Section Start -----------
            // -----------------------------------------------
            case "addIndent":

                
                                    if (!empty($_POST["indentNo"] && $_POST["indentDate"])):
                                        $slashNandR =  array("\n", "\r");
                                         $item_info = array();
                                         for($i = 0; $i < count($_POST["item_name"]); $i++):
                                            $temp_item = array(
                                                                "itemCode" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_code"][$i]), ENT_QUOTES),
                                                                "itemName" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_name"][$i]), ENT_QUOTES),
                                                                "itemCategory" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_category"][$i]), ENT_QUOTES),
                                                                "uom" => htmlspecialchars(str_replace($slashNandR, "", $_POST["uom"][$i]), ENT_QUOTES),
                                                                "quantity" => htmlspecialchars(str_replace($slashNandR, "", $_POST["quantity"][$i]), ENT_QUOTES),
                                                                "remark" => htmlspecialchars(str_replace($slashNandR, "", $_POST["remark"][$i]), ENT_QUOTES),
                                                                

                                                        );
                                            array_push($item_info, $temp_item);
                                         endfor;
                                         $indent_info = array(
                                                        "indentNo" => htmlspecialchars(str_replace($slashNandR, "", $_POST["indentNo"]), ENT_QUOTES),
                                                        "indentDate" => htmlspecialchars(str_replace($slashNandR, "", $_POST["indentDate"]), ENT_QUOTES),
                                                         "indentCreated" => htmlspecialchars(str_replace($slashNandR, "", $_POST["indentCreated"]), ENT_QUOTES),
                                                          "indentCreatedDesignation" => htmlspecialchars(str_replace($slashNandR, "", $_POST["indentCreatedDesignation"]), ENT_QUOTES),
                                                        
                                                        "description" => htmlspecialchars(str_replace($slashNandR, "", $_POST["description"]), ENT_QUOTES),
                                                        // "payment_terms" => htmlspecialchars(str_replace($slashNandR, "", $_POST["payment_terms"]), ENT_QUOTES),
                                                        "employee_project" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_project"]), ENT_QUOTES),
                                                        // "employee_designation" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_designation"]), ENT_QUOTES),
                                                        "employee_req" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_req"]), ENT_QUOTES),
                                                        // "employee_req" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_req"]), ENT_QUOTES),
                                                        // "employee" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee"]), ENT_QUOTES),
                                                        "employee_approval" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_approval"]), ENT_QUOTES),
                                                        "employee_designation_approval" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_designation_approval"]), ENT_QUOTES),
                                                        "employee_email_approval" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_email_approval"]), ENT_QUOTES),

                                                        "item_info" => $item_info
                                                    );


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
                        //                        $tableData["indentDate"] = $indentDate;
                        //                        $tableData["orderNo"] = $orderNo;
                                                $tableData["manage_indent_info"] = json_encode($item_info);
                                                $tableData["manage_indent_info"] = json_encode($indent_info);
                                                $tableData["order_status"] = "pending";
                                                //$tableData["rec_note_no"] = 0;
                                                $tableData["manage_indent_log"] = json_encode($item_log);
                                                $tableData["status"] = $auth->visible();
                                                // $databaseObj->select("tbl_manage_employee");
                                                // $databaseObj->where("`status` = '".$auth->visible()."' && `mange_employee_id` = '".$manage_indent_id."'");
                                                // $getData = $databaseObj->get();
                                                // //Checking If Data Is Available
                                                // if($getData != 0):
                                                //     $sno = 1;
                                                //     foreach($getData as $rows):
                                                //         $data_info = json_decode($rows["manage_employee_info"]);
                                                //         // $data_log = json_decode($rows["student_create"]);
                                                //     endforeach;
                                                $check = $databaseObj->insert("tbl_manage_indent", $tableData);                                                 
                                                 $databaseObj->error();
                                                  $last_inserted_id= $databaseObj->last_inserted_id();
                                                  // print_r($last_inserted_id);
                                                  //exit();
                                                if($check == 1):
                                                     
                                                    $to =  $_POST["employee_email_approval"];
                                                    $subject = "Approve Indent";
                                                   
                                                    $mail_content = "
                                                    
                                                    <html>
                                                    <body>

                                                    <div>
                                                    <table style='border:1px solid black;'>
                                                        <tr style='border:1px solid black;'>
                                                        <th style='border:1px solid black;'>Indent No</th>
                                                        <th style='border:1px solid black;'>Indent Requistion</th>
                                                        <th style='border:1px solid black;'>Indent Date</th>
                                                        <th style='border:1px solid black;'>Created By</th>
                                                        </tr>
                                                        <tr style='border:1px solid black;'>
                                                        <td style='border:1px solid black;'>".$_POST["indentNo"]."</td>
                                                        <td style='border:1px solid black;'>".$_POST["employee_req"]."</td>
                                                        <td style='border:1px solid black;'>".$_POST["indentDate"]."</td>
                                                        
                                                           
                                                       
                                                        <td style='border:1px solid black;'>".$auth->admin_info->name."</td>
                                                       
                                                        
                                                        </tr>
                                                           
                                                    </table>
                                                    <table style='border:1px solid black;'>
                                                        <tr style='border:1px solid black;'>
                                                        <th style='border:1px solid black;'>Item Code</th>
                                                        <th style='border:1px solid black;'>Item Name</th>
                                                        <th style='border:1px solid black;'>UOM</th>
                                                        <th style='border:1px solid black;'>Quantity</th>
                                                         <th style='border:1px solid black;'>Requisition Quantity</th>
                                                        <th style='border:1px solid black;'>Remark</th>
                                                        </tr>";
                                                        for($i = 0; $i < count($_POST["item_name"]); $i++):
                                                                  $databaseObj->select("tbl_manage_item");
                                                                  $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$_POST["item_code"][$i]."'");
                                                                  $getData = $databaseObj->get();
                                                                  if($getData != 0):
                                                                    foreach ($getData as $rows):
                                                                            $itemcode=$rows["itemCode"];
                                                                            $itemname=$rows["itemName"];
                                                                            $uom=$rows["Uom"];
                                                                    endforeach;
                                                                  endif;    
                                                                   $databaseObj->select("tbl_manage_category");
                                                                  $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$_POST["item_category"][$i]."'");
                                                                  $getData = $databaseObj->get();
                                                                  if($getData != 0):
                                                                    foreach ($getData as $rowscategory):
                                                                            $manage_category_info = $rowscategory["manage_category_info"];
                                                                            // $itemname=$rows["itemName"];
                                                                    endforeach;
                                                                  endif;                                                          
                                                                    $mail_content .= "<tr style='border:1px solid black;'>
                                                                        <td style='border:1px solid black;'>".$itemcode."</td>
                                                                        <td style='border:1px solid black;'>".$itemname."</td>
                                                                       
                                                                        <td style='border:1px solid black;'>".$uom."</td>
                                                                         <td style='border:1px solid black;'>".$_POST["quantity1"][$i]."</td>
                                                                        <td style='border:1px solid black;'>".$_POST["quantity"][$i]."</td>
                                                                        <td style='border:1px solid black;'>".$_POST["remark"][$i]."</td>
                                                                       
                                                                        
                                                                        </tr>";
                                                        endfor;
                                                        $mail_content .= "</table>
                                                           <h5>An indent has been created.</h5>
                                                            <p>Please <a href='https://srinathhomes.in/irems/approve_indent.php?id=".$last_inserted_id."'>Approve Now</a></p>

                                                             

                                                    </div>
                                                    </body>
                                                    </html>";

                                                    // echo $mail_content;
                                                    // $txt = "   \n\n.";
                                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                                                    $headers .= "From: ". $auth->admin_info->emailId ."\r\n";
                                                    if(mail($to,$subject,$mail_content,$headers)){
                                                        
                                                     }
                                                    else{
                                                      
                                                    }

                                                                   
                                                     
                                                   //  $subject = "Approve Indent";
                                                   //   $txt = "An indent has been created.";c
                                                   // $headers = "From: srinathhomes.in" . "\r\n" .
                                                    
                                                   //  mail($to,$subject,$txt,$headers);
                                                     echo '<script type="text/javascript">
                                                            location.replace("../../../dashboard.php");
                                                        </script>'; 
                                                
                                                    $data["response"] = "success";
                                                    $data["responseType"] = "success";
                                                    $data["responseMessage"] = "Indent created successfully !!!";

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

                // else:
                //     $data["response"] = "noAuthority";
                //     $data["responseType"] = "error";
                //     $data["responseMessage"] = "You are not authorized to add!!!";
                // endif;
                break;
                // ET["approveTableId");
            
            case "approveIndent":
             
               
                        if(!empty($_POST["approveTableId"])):
                        $databaseObj->select("tbl_manage_indent");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_indent_id` = '".$_POST["approveTableId"]."'");
                        $getData = $databaseObj->get();
                        
                        //Checking If Data Is Available
                        if($getData != 0):
                            $sno = 1;
                            foreach($getData as $rows):
                                $manage_indent_info = json_decode($rows["manage_indent_info"]);
                            endforeach;
                
                                   if(!empty($_POST["indentNo"] && $_POST["indentDate"])):
                                              $slashNandR =  array("\n", "\r");
                                               $item_info = array();
                                               // echo count($_POST["item_name_approve"]);
                                               // exit(0);
                                               for($i = 0; $i < count($_POST["item_name_approve"]); $i++):
                                                  $temp_item = array(
                                                                      "itemCode" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_code_approve"][$i]), ENT_QUOTES),
                                                                      "itemName" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_name_approve"][$i]), ENT_QUOTES),
                                                                      "itemCategory" => htmlspecialchars(str_replace($slashNandR, "", $_POST["item_category_approve"][$i]), ENT_QUOTES),
                                                                      "uom" => htmlspecialchars(str_replace($slashNandR, "", $_POST["uom_approve"][$i]), ENT_QUOTES),
                                                                      "quantity" => htmlspecialchars(str_replace($slashNandR, "", $_POST["quantity_approve"][$i]), ENT_QUOTES),
                                                                      "remark" => htmlspecialchars(str_replace($slashNandR, "", $_POST["remark_approve"][$i]), ENT_QUOTES),
                                                                      

                                                              );

                                                  array_push($item_info, $temp_item);
                                               endfor;
                                           
                                               $indent_info = array(
                                                              "indentNo" => htmlspecialchars(str_replace($slashNandR, "", $_POST["indentNo"]), ENT_QUOTES),
                                                              "indentDate" => htmlspecialchars(str_replace($slashNandR, "", $_POST["indentDate"]), ENT_QUOTES),
                                                              
                                                             
                                                              // "payment_terms" => htmlspecialchars(str_replace($slashNandR, "", $_POST["payment_terms"]), ENT_QUOTES),
                                                              "employee_project" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_project"]), ENT_QUOTES),
                                                              // "employee_designation" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_designation"]), ENT_QUOTES),
                                                              "employee_req" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_req"]), ENT_QUOTES),
                                                              // "employee_req" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_req"]), ENT_QUOTES),
                                                              // "employee" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee"]), ENT_QUOTES),
                                                              "employee_approval" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_approval"]), ENT_QUOTES),
                                                              "employee_approval_po" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_approval_po"]), ENT_QUOTES),
                                                              "employee_designation_approval" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_designation_approval"]), ENT_QUOTES),
                                                               "employee_designation_approval_po" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_designation_approval_po"]), ENT_QUOTES),
                                                              "employee_email_approval" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_email_approval"]), ENT_QUOTES),
                                                              "employee_email_approval_po" => htmlspecialchars(str_replace($slashNandR, "", $_POST["employee_email_approval_po"]), ENT_QUOTES),
                                                              "indentCreated" => htmlspecialchars(str_replace($slashNandR, "", $_POST["indentCreated"]), ENT_QUOTES),
                                                               "indentCreatedDesignation" => htmlspecialchars(str_replace($slashNandR, "", $_POST["indentCreatedDesignation"]), ENT_QUOTES),
                                                                "description_approval" => htmlspecialchars(str_replace($slashNandR, "", $_POST["description_approval"]), ENT_QUOTES),
                                                            
                                                              
                                                              "item_info" => $item_info
                                                          );
                                            

                                                       
                                                      $item_log = array(
                                                                          array(
                                                                                  "action"                =>      "approved",
                                                                                  "by"                    =>      $auth->admin_id,
                                                                                  "ip"                    =>      $_POST["checkIp"],
                                                                                  "location"              =>      $_POST["checkLocation"],
                                                                                  "at"                    =>      date("H:i:s A"),
                                                                                  "date"                  =>      date("d-m-Y")
                                                                          )
                                                                      );
                                                      
                             
                                                      $tableData["manage_indent_info"] = json_encode($item_info);
                                                      $tableData["manage_indent_info"] = json_encode($indent_info);
                                                      
                                                      $tableData["order_status"] = "approved";
                                                      //$tableData["rec_note_no"] = 0;
                                                      $tableData["manage_indent_log"] = json_encode($item_log);
                                                      $tableData["status"] = $auth->visible();

                                                      // $databaseObj->select("tbl_manage_employee");
                                                      // $databaseObj->where("`status` = '".$auth->visible()."' && `mange_employee_id` = '".$manage_indent_id."'");
                                                      // $getData = $databaseObj->get();
                                                      // //Checking If Data Is Available
                                                      // if($getData != 0):
                                                      //     $sno = 1;
                                                      //     foreach($getData as $rows):
                                                      //         $data_info = json_decode($rows["manage_employee_info"]);
                                                      //         // $data_log = json_decode($rows["student_create"]);
                                                      //     endforeach;
                                                      // update($tblName, $data, $passedCondition)
                                                  // echo $_GET["approveTableId"];
                                                      $check = $databaseObj-> update("tbl_manage_indent", $tableData, "`manage_indent_id` = '".$_POST["approveTableId"]."'");
                                                      // $check = $databaseObj->update("tbl_manage_indent", $tableData, "`manage_indent_id` = '".$_POST["approveTableId"]."'");
                                                      // $check = $databaseObj->insert("tbl_manage_indent", $tableData);
                                                     
                                                        // print_r($check);
                                                        // exit(0);                                                  
                                                       // $databaseObj->error();

                                             
                                                      if($check == 1):
                                                          // $q =  $_POST["manage_indent_id"];
                                                          $to = $_POST["employee_email_approval_po"];
                                                          $subject = "Next level Approval";                                                         
                                                          $mail_content = "
                                                          <html>
                                                          <body>

                                                          <div>
                                                          <table style='border:1px solid black;'>
                                                              <tr style='border:1px solid black;'>
                                                              <th style='border:1px solid black;'>Indent No</th>
                                                              <th style='border:1px solid black;'>Indent Requistion</th>
                                                              <th style='border:1px solid black;'>Indent Date</th>
                                                              
                                                             
                                                              <th style='border:1px solid black;'>Approved By</th>
                                                              </tr>
                                                              <tr style='border:1px solid black;'>
                                                              <td style='border:1px solid black;'>".$_POST["indentNo"]."</td>
                                                              <td style='border:1px solid black;'>".$_POST["employee_req"]."</td>
                                                              <td style='border:1px solid black;'>".$_POST["indentDate"]."</td>
                                                              
                                                              
                                                              <td style='border:1px solid black;'>".$auth->admin_info->name."</td>
                                                             
                                                              
                                                              </tr>
                                                                 
                                                          </table>
                                                          <table style='border:1px solid black;'>
                                                              <tr style='border:1px solid black;'>
                                                              <th style='border:1px solid black;'>Item Code</th>
                                                              <th style='border:1px solid black;'>Item Name</th>
                                                             
                                                              <th style='border:1px solid black;'>UOM</th>
                                                              <th style='border:1px solid black;'>Quantity</th>
                                                              <th style='border:1px solid black;'>Requisition Quantity</th>

                                                              <th style='border:1px solid black;'>Remark</th>
                                                              </tr>";
                                                              // echo count($_POST["item_name_approve"]);
                                                              // exit(0);
                                                              for($i = 0; $i < count($_POST["item_name_approve"]); $i++):
                                                                $databaseObj->select("tbl_manage_item");
                                                                  $databaseObj->where("`status` = '".$auth->visible()."' && `manage_item_id` = '".$_POST["item_code_approve"][$i]."'");
                                                                  $getData = $databaseObj->get();
                                                                  if($getData != 0):
                                                                    foreach ($getData as $rows):
                                                                            $itemcode=$rows["itemCode"];
                                                                            $itemname=$rows["itemName"];
                                                                            $uom=$rows["Uom"];
                                                                    endforeach;
                                                                  endif;    
                                                                   $databaseObj->select("tbl_manage_category");
                                                                  $databaseObj->where("`status` = '".$auth->visible()."' && `manage_category_id` = '".$_POST["item_category"][$i]."'");
                                                                  $getData = $databaseObj->get();
                                                                  if($getData != 0):
                                                                    foreach ($getData as $rowscategory):
                                                                            $manage_category_info = $rowscategory["manage_category_info"];
                                                                            // $itemname=$rows["itemName"];
                                                                    endforeach;
                                                                  endif;         
                                                                          $mail_content .= "<tr style='border:1px solid black;'>
                                                                              <td style='border:1px solid black;'>".$itemcode."</td>
                                                                              <td style='border:1px solid black;'>". $itemname."</td>

                                                                              
                                                                              <td style='border:1px solid black;'>".$uom."</td>
                                                                              <td style='border:1px solid black;'>".$_POST["quantity_approve"][$i]."</td>
                                                                               <td style='border:1px solid black;'>".$_POST["quantity_approve"][$i]."</td>
                                                                              <td style='border:1px solid black;'>".$_POST["remark_approve"][$i]."</td>
                                                                             
                                                                              
                                                                              </tr>";
                                                              endfor;
                                                              $mail_content .= "</table>
                                                                 <h5>An indent has been created.</h5>
                                                                  <p>Click For <a href='https://srinathhomes.in/irems/purchase-order.php?id=".$_POST["approveTableId"]."'>Next Level Approval</a></p>
                                                                  


                                                                 
                                                                   

                                                          </div>
                                                          </body>
                                                          </html>";

                                                          // echo $mail_content;
                                                          // $txt = "   \n\n.";
                                                          $headers = "MIME-Version: 1.0" . "\r\n";
                                                          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                                                          $headers .= "From: ". $auth->admin_info->emailId ."\r\n";
                                                          if(mail($to,$subject,$mail_content,$headers)){
                                                               
                                                           }
                                                          else{
                                                            
                                                          }
 
                                                                         
                                                           
                                                         //  $subject = "Approve Indent";
                                                         //   $txt = "An indent has been created.";
                                                         // $headers = "From: srinathhomes.in" . "\r\n" .
                                                          
                                                         // //  mail($to,$subject,$txt,$headers);
                                                        //   echo '<script type="text/javascript">
                                                        //     location.replace("../../../receive-indent.php");
                                                        // </script>'; 
                                                          $data["response"] = "success";
                                                          $data["responseType"] = "success";
                                                          $data["responseMessage"] = " Mail Sent successfully & Indent Approved !!!";
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
                  else:
                  $data["response"] = "error";
                  $data["responseType"] = "error";
                  $data["responseMessage"] = "Please Check your connection!!!";                        
                                         
            endif;
        break;

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