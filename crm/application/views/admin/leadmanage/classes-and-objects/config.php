<?php 
   // session_start();
    date_default_timezone_set("Asia/Kolkata");
    require_once("database-class.php");
    require_once("setting.php");
    ini_set('max_execution_time', 0);
    $databaseObj = new DATABASE("localhost", "srinathhomes_db_irmes", "n7LVzdkd7", "srinathhomes_db_irmes");
    $databaseObj_sec = new DATABASE("localhost", "srinathhomes_db_irmes", "n7LVzdkd7", "srinathhomes_db_irmes");
    $setting = new SETTING($databaseObj);
    $databaseObj->error();
?>