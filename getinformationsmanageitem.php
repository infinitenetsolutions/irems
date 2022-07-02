<?php
  require_once("application/classes-and-objects/config.php");
  require_once("application/classes-and-objects/veriables.php");
  require_once("application/classes-and-objects/authentication.php");
  require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");
  

  $auth = new AUTHENTICATION($databaseObj);

  $q = $_POST['item_code'];
  $p = $_POST['project'];
 $databaseObj->select("tbl_manage_stock");
 $databaseObj->where("`status` = '".$auth->visible()."' && `project` = '".$p."'&& `itemCode` = '".$q."'");
 $getDatastock = $databaseObj->get();
foreach ($getDatastock as $rows):
  $Qty = $rows["Qty"];
 endforeach; 
 echo $Qty;
 
 
 
 
   

        
      
