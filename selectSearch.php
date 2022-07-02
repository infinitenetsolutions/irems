<?php
include('./framwork/main.php');
$result=fetchResult('tbl_services'," status='46cf0e59759c9b7f1112ca4b174343ef'");
while($row=mysqli_fetch_array($result)){
    echo "<option value = '"  . json_decode($row[1])->servicesName . " | "  . json_decode($row[1])->pricesofService . "'></option>";
}
