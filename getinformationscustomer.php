

<?php
  require_once("application/classes-and-objects/config.php");
  require_once("application/classes-and-objects/veriables.php");
  require_once("application/classes-and-objects/authentication.php");
  require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");  
  

  $auth = new AUTHENTICATION($databaseObj);

  $customerId = $_POST['customer'];


    $databaseObj->select("tbl_customer");
    $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$customerId."'");
    $getData = $databaseObj->get();

     foreach ($getData as $rows) {

    $customers_info = json_decode($rows["customer_property_info"]);
    // echo "<pre>";
    // print_r($customers_info);
    
      $projectId = $customers_info->projectName;

   
    $databaseObj->select("tbl_projects");
    $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$projectId."'");
    $getData = $databaseObj->get();

     foreach ($getData as $rows) {

    $projects_info = json_decode($rows["projects_info"]);
   
   ?>

    <option value="<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?> </option>

    <!-- <input class="form-control" id="" name="" type="text"  value="<?= $customers_info->phase ?>"/> -->

    <?php
     }
       
     } 

