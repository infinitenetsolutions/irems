

<?php
  require_once("application/classes-and-objects/config.php");
  require_once("application/classes-and-objects/veriables.php");
  require_once("application/classes-and-objects/authentication.php");
  require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");
  

  $auth = new AUTHENTICATION($databaseObj);

  $q = $_POST['project'];

   echo $q;

    $databaseObj->select("tbl_projects");
    $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$q."'");
    $getData = $databaseObj->get();

     foreach ($getData as $rows) {

    $projects_info = json_decode($rows["projects_info"]);

    
      ?>

     <div class="form-group">

        <label>Project Location</label>

        <input class="form-control" name="employee_designation" id="employee_designation" type="text" value="<?= $projects_info->projectLocation ?>" readonly>

     </div>
<?php

  }


  ?>

