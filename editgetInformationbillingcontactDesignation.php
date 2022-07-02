
<?php

  require_once("application/classes-and-objects/config.php");

  require_once("application/classes-and-objects/veriables.php");

  require_once("application/classes-and-objects/authentication.php");

  require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");

  $auth = new AUTHENTICATION($databaseObj);
 
  

  $q = $_POST['editbilling_contact_person'];



  $databaseObj->select("tbl_manage_employee");

  $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id` = '".$q."'");

  $getData = $databaseObj->get();
  
  foreach ($getData as $rows):

    $manage_employee_info = json_decode($rows["manage_employee_info"]);

 

   

      ?>

      <div class="row">
        <div class="col-md-6">
          <label>Designation</label>
          <div class="form-group">
            <?php
            $databaseObj->select("tbl_manage_designation");

            $databaseObj->where("`status` = '".$auth->visible()."' && `manage_designation_id` = '".$manage_employee_info->designation."'");

            $getData = $databaseObj->get();
  
            foreach ($getData as $rows):

                $manage_designation_info = json_decode($rows["manage_designation_info"]);
            endforeach;?>
            <input class="form-control" type="text" value="<?= $manage_designation_info->designationName ?>" readonly>
            <input class="form-control" name="editbilling_contact_designation" id="editbilling_contact_designation" type="hidden" value="<?= $rows["manage_designation_id"] ?>" readonly>

          </div>
        </div>

     
      <div class="col-md-6">
       <label>Contact Number</label>
       <div class="form-group">

        <input class="form-control" name="editbilling_contact_number" id="editbilling_contact_number" type="text" value="<?= $manage_employee_info->mobile ?>" readonly>

       </div>
      </div>    
      </div> 
      <?php

 
        endforeach;

  ?>

