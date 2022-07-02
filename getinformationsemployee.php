<?php
    require_once("application/classes-and-objects/config.php");
    require_once("application/classes-and-objects/veriables.php");
    require_once("application/classes-and-objects/authentication.php");
    require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");
//   ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

  $auth = new AUTHENTICATION($databaseObj);

  $q = $_POST['employee'];



    $databaseObj->select("tbl_manage_employee");
    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$q."'");
    $getData = $databaseObj->get();

 

    foreach ($getData as $rows):

        $manage_employee_info = json_decode($rows["manage_employee_info"]);

        

        ?>

        <div class="form-group">

            <label>Designation</label>

            <input class="form-control" name="employee_designation" id="employee_designation" type="text" value="<?= $manage_employee_info->designation ?>" readonly>

        </div>



        <div class="form-group">

            <label>Project</label>
             <?php
                                                              $databaseObj->select("tbl_projects");
                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_employee_info->project."'");
                                                            $getData = $databaseObj->get();
                                                            if($getData != 0):
                                                                foreach($getData as $rows_deptt):
                                                                    $projects_info = json_decode($rows_deptt["projects_info"]);
                                                                endforeach;
                                                            endif;
                                                             ?>
                                                            

            <input class="form-control" name="employee_project" id="employee_project" type="text" value="<?= $projects_info->projectName ?>" readonly>

        </div>
        <div class="form-group">

                    <label>Requistion No</label>
                        <?php
                            $databaseObj->select("tbl_manage_indent");
                            $databaseObj->where("`status` = '".$auth->visible()."'");
                            $getData = $databaseObj->get();
                            $indentNo = 1;
                            foreach ($getData as $rows):
                                $indentNo = $rows["manage_indent_id"]+1;
                            endforeach;
                        ?>
                        <?php
                            $databaseObj->select("tbl_projects");
                            $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_employee_info->project."'");
                            $getData = $databaseObj->get();
                            if($getData != 0):
                                            foreach($getData as $rows_deptt):
                                                $projects_info = json_decode($rows_deptt["projects_info"]);
                                            endforeach;
                            endif;
                                            
                            
                                                                        
                        ?>
                        <?php
                        
                           
                             if (ucwords(strtolower(trim($projects_info->projectName))) == "Srinath Global Village") {
                                
                                $employee_req= "SGV/$indentNo/20-21";
                            } else if (ucwords(strtolower(trim($projects_info->projectName))) == "Srinath Rock Garden") {
                                
                                $employee_req= "SRG/$indentNo/20-21";
                  
                            }  else if (ucwords(strtolower(trim($projects_info->projectName))) == "Srinath Shikhar") {
                                $employee_req= "SS/$indentNo/20-21"; 
                            }  else if (ucwords(strtolower(trim($projects_info->projectName))) == "Srinath&#039;s Residency") {
                                $employee_req= "SSR/$indentNo/20-21"; 
                           
                            }  else if (ucwords(strtolower(trim($projects_info->projectName))) == "Srinath's Shandhya Shambhu Apartment") {
                                
                                $employee_req= "SSAD/$indentNo/20-21";
                            }
                        
                        ?>
                        <input class="form-control" name="employee_req" id="employee_req" type="text" value="<?= $employee_req ?>" readonly>
                                                                                    

        </div>
       <?php
    endforeach;

?> 

