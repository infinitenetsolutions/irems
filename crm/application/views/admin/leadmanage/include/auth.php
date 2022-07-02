<?php 

    require_once("./classes-and-objects/config.php");
    require_once("./classes-and-objects/veriables.php");
    require_once("./classes-and-objects/authentication.php");
    $auth = new AUTHENTICATION($databaseObj);
    //if($page_no != 0): //That Means Dashbord
    	//$auth->checkAuth($page_no, $page_no_inside);
   // endif;
?>