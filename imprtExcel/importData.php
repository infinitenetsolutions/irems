<?php
$extention = '';
require("./connectio.in.php");
require_once("../application/classes-and-objects/config.php");
require_once("../application/classes-and-objects/veriables.php");
require_once("../application/classes-and-objects/authentication.php");
//require_once("../application/classes-and-objects/PHPExcel/PHPExcel.php");  


$auth = new AUTHENTICATION($databaseObj);

 
 
if (isset($_POST['submit'])) {

  $extention = $_FILES['doc']['name'];
  $extention = (pathinfo($extention))['extension'];

  if ($extention == 'xl' || $extention == "xls" || $extention == "xlsx" || $extention == "csv") {
    require('./PHPExcel/PHPExcel.php');
    require('./PHPExcel/PHPExcel/IOFactory.php');
    $doc_name = $_FILES['doc']['tmp_name'];
    $obj = PHPExcel_IOFactory::load($doc_name);
    foreach ($obj->getWorksheetIterator() as $all_data) {
      // all data is the associtive array in the all the data of the excel file
      $number_of_row = $all_data->getHighestRow();
      for ($i = 2; $i <= $number_of_row; $i++) {
        // here 0 and 1 is the number of index or colunmn in excel file 
        // $i is th number of data in rows 
        $sno = $all_data->getCellByColumnAndRow(0, $i)->getValue();
        $invoice_no = $all_data->getCellByColumnAndRow(1, $i)->getValue();
        $invoice_date = $all_data->getCellByColumnAndRow(2, $i)->getValue();
        $bill_due_date = $all_data->getCellByColumnAndRow(3, $i)->getValue();
        $payment_terms = $all_data->getCellByColumnAndRow(4, $i)->getValue();
        $other_ref = $all_data->getCellByColumnAndRow(5, $i)->getValue();
        $terms_of_delivery = $all_data->getCellByColumnAndRow(6, $i)->getValue();
        $project_id = get_projects_id($all_data->getCellByColumnAndRow(7, $i)->getValue());
        $customer_id = get_customer_id($all_data->getCellByColumnAndRow(8, $i)->getValue());

        $qty = $all_data->getCellByColumnAndRow(9, $i)->getValue();
        $fixed_maint = $all_data->getCellByColumnAndRow(10, $i)->getValue();
        $water_charges = $all_data->getCellByColumnAndRow(11, $i)->getValue();
        $diesel_expenses = $all_data->getCellByColumnAndRow(12, $i)->getValue();
        $meter_redg_curr = $all_data->getCellByColumnAndRow(13, $i)->getValue();
        $meter_redg_pre = $all_data->getCellByColumnAndRow(14, $i)->getValue();

        
        $meter_redg_amount = $all_data->getCellByColumnAndRow(16, $i)->getValue();
        $meter_fixed_amount = $all_data->getCellByColumnAndRow(17, $i)->getValue();
        $common_power = $all_data->getCellByColumnAndRow(18, $i)->getValue();
 
        $sgst_amount = $all_data->getCellByColumnAndRow(22, $i)->getValue();
        $cgst_amnt = $all_data->getCellByColumnAndRow(23, $i)->getValue();
        $total_amount = $all_data->getCellByColumnAndRow(26, $i)->getValue();
        $two_percent = $all_data->getCellByColumnAndRow(27, $i)->getValue();
        $after_due_date = $all_data->getCellByColumnAndRow(28, $i)->getValue();

        "<br>";




        // here can write the sql query for inserting the data in database
        $query = "INSERT INTO `tbl_maintenance`(`m_id`,`invoice_no`,`invoice_date`,`bill_due_date`,`payment_terms`,`other_ref`,`terms_of_delivery`,`project_id`, `customer_id`,`qty`,`fixed_maint`,`water_charges`,`meter_redg_amount`,`meter_fixed_amount`, `common_power`, `diesel_expenses`,`meter_redg_curr`,`meter_redg_pre`
               , `sgst_amount`,`cgst_amnt`,`two_percent`,`after_due_date`) 
                                              VALUES ('','$invoice_no','$invoice_date','$bill_due_date','$payment_terms','$other_ref','$terms_of_delivery','$project_id','$customer_id','$qty','$fixed_maint','$water_charges','$meter_redg_amount','$meter_fixed_amount','$common_power','$diesel_expenses','$meter_redg_curr','$meter_redg_pre','$sgst_amount','$cgst_amnt','$total_amount','$two_percent','$after_due_date'
                                             )";
        $result = mysqli_query($connection, $query);
      }
    }


    if ($result) {
      $_SESSION['massage'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Data Imported Successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
    
              <script>
              setTimeout(function() {  window.location.replace(window.location.href) },2000);
                </script>
              ';

      echo '  <script>
                window.location.replace("../manage-maintainance.php") ;
                </script>';
    } else {
      $_SESSION['massage'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Format not matched! </strong> ' . $connection->error . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
    }
  }
}




function get_projects_id($project_name)
{
  global $databaseObj;
  global $auth;
  $databaseObj->select("tbl_projects");
  $databaseObj->where("`status` = '".$auth->visible() ."' && `projects_info` LIKE '%".$project_name."%'");
  $getData = $databaseObj->get();
  foreach ($getData as $rows) {
      return $rows['projects_id'];    
  }
}



function get_customer_id($cus_name)
{
  global $databaseObj;
  global $auth;
  $databaseObj->select("tbl_customer");
  $databaseObj->where("`status` = '".$auth->visible() ."' && `customer_info` LIKE '%".$cus_name."%'");
  $getData = $databaseObj->get();
  foreach ($getData as $rows) {
      return $rows['customer_id'];    
  }
}
