<?php
  require_once("application/classes-and-objects/config.php");
  require_once("application/classes-and-objects/veriables.php");
  require_once("application/classes-and-objects/authentication.php");
  require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");
  

  $auth = new AUTHENTICATION($databaseObj);

  $q = $_POST['employee_approval'];



    $databaseObj->select("tbl_manage_employee");
    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$q."'");
    $getData = $databaseObj->get();

 

    foreach ($getData as $rows):

        $manage_employee_info = json_decode($rows["manage_employee_info"]);

        

        ?>
       
          <div class="form-group form-group-smform-group-sm">

            <label>Designation</label>
             <?php

                                                      $databaseObj->select("tbl_manage_designation");
                                                    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$manage_employee_info->designation."'");
                                                    $getData = $databaseObj->get();
                                                    if($getData != 0):
                                                        foreach($getData as $rows_deptt):
                                                            $manage_designation_info = json_decode($rows_deptt["manage_designation_info"]);
                                                        endforeach;
                                                    endif;
                                                     ?>

            <input class="form-control form-control-sm"  type="text" value="<?= $manage_designation_info->designationName ?>" readonly>
            <input class="form-control form-control-sm" name="employee_designation_approval" id="employee_designation_approval" type="hidden" value="<?= $manage_employee_info->designation ?>" readonly>
         
       
        
         

            <label>Email</label>

            <input class="form-control form-control-sm" name="employee_email_approval" id="employee_email_approval" type="text" value="<?= $manage_employee_info->email ?>" readonly>

        </div>
     


        
       <?php
    endforeach;
?> 

