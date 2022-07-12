<?php


 $servicename = $_POST['servicename'];



$last_no = 1;
$con = mysqli_connect('localhost', 'root', '', 'srinathhomes_db_irmes');

$sql = "SELECT * FROM `tbl_maintenance` where `project_id` = '".$servicename."'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $last_invoice_no = $row["invoice_no"];

    // echo "<pre>";
    // print_r($last_invoice_no); exit;

    $last_no_check = $last_invoice_no[3];
    if ($last_no_check > $last_no) {
      $last_no = $last_no_check;
    }
  }
  $last_no++;
  $last_no_lng = strlen((string)$last_no);
  if ($last_no_lng == 1) {
    $last_no = "0" . $last_no;
  } else if ($last_no_lng == 2) {
    $last_no = "0" . $last_no;
  } else if ($last_no_lng == 3) {
    $last_no = "0" . $last_no;
  }
} else {
  $last_no = '01';
}


//if($servicename == 12){

//   $yearDate = date('Y')."-03-31"; 
//   $todayDate = date('Y-m-d');
//   if ($todayDate > $yearDate ) { 

//   echo "SS".'/'.$last_no.'/'.date("y"). "-" .date("y", strtotime("+1 year"))?>
 <?php  //} else { 
//     echo "SS".'/'.$last_no.'/'.date("y", strtotime("-1 year")). "-" .date("y") ?>
 <?php 
// } 

// } else{ 

 echo $last_no; ?>

<?php //} ?>

	 	
