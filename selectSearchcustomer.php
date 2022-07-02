<?php
include('./framwork/main.php');
$result = fetchResult('tbl_customer', " status='46cf0e59759c9b7f1112ca4b174343ef'");

while ($row = mysqli_fetch_array($result)) {
   
     $building_id =  json_decode($row['customer_property_info'])->building;
     $floor_id =  json_decode($row['customer_property_info'])->floors;
     $flat_no =  json_decode($row['customer_property_info'])->flat_no;
     $projectId =  $row['customer_id'];

    $row1 = fetchRow('tbl_building', " building_id = " . $building_id . "");

    echo "<option value = '"  .   json_decode($row['customer_info'])->name . " | "  . json_decode( $row1['building_info'])->building . " | "  .  $floor_id.  " | "  .  $flat_no . " | "  .  $projectId . "'></option>";
}
