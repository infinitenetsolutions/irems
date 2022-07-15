<?php


include './include/commonFuncs.php';
@require_once("include/auth.php");
require_once("application/classes-and-objects/config.php");
require_once("application/classes-and-objects/veriables.php");
include './framwork/main.php';


?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
  <style type="text/css">
    table {
      page-break-inside: auto
    }

    tr {
      page-break-inside: avoid;
      page-break-after: auto
    }

    thead {
      display: table-header-group
    }

    tfoot {
      display: table-footer-group
    }

    table thead tr td h5 {
      margin-bottom: -18px;
    }

    .global_vill h5 {
      margin-bottom: -25px;
    }
  </style>
  <meta charset="utf-8" />

  <title>IREMS | Print All Bill</title>

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/css/demo.css" rel="stylesheet" />
  <!-- Google Tag Manager -->


  <style>
    * {
      font-family: arial !important;
    }
  </style>


  <script>
    function myFunction() {
      document.getElementById('print').style.display = "none";
      window.print();
    }
  </script>


  <!-- End Google Tag Manager -->
</head>
<?php
$result1 = fetchResult('tbl_maintenance');
while ($result = mysqli_fetch_array($result1)) {

?>

  <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <div>
      <!-- End Google Tag Manager (noscript) -->
      <div class="wrapper">
        <!-- Sidebar -->
        <?php //echo $sidebar1; 
        ?>

        <!-- End Sidebar -->
        <div class="main-panel" style="width: calc(100% - 10px);">
          <!-- Navbar -->
          <?php //echo $navbar; 
          ?>
          <!-- End Navbar -->
          <!--<div class="container">-->
          <div class="card holder">

            <div id="page">
              <table border="1px solid black" class="table" style="width: 100%; margin-top:30px">
                <thead>
                  <?php
                  if ($result['project_id'] == '8') {  ?>

                    <td>
                      <img src="./assets/dp/logo.png" align="left" align="left" height="12%;" style="text-align: center; height: 140px;    width: 100px;">
                      <h5 style=" color:#6b0100;text-align: center;"><b style="font-size: 30px !important;">Rock Garden Maintenance Services</b></h5>
                      <h5 style="color:#6b0100;text-align: center;"><b style="font-size: 16px !important;">112,1st Floor,Ashiana Trade Center,Jamshedpur</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;"></b></h5>
                      <!-- <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;">GSTIN:<?php //echo $result['gstin']; 
                                                                                                                                      ?></b></h5>-->
                    </td>
                  <?php  } ?>

                  <?php if ($result['project_id'] == '10') {  ?>

                    <td class="global_vill">
                      <img src="./assets/dp/logo.png" align="left" align="left" height="12%;" style="text-align: center; height: 140px;    width: 100px;">
                      <h5 style=" color:#6b0100;text-align: center;"><b style="font-size: 30px !important;">Srinath Global Village Maintenance Services</b></h5>
                      <h5 style="color:#6b0100;text-align: center;"><b style="font-size: 16px !important;">112,First Floor,Ashiana Trade Center,Adityapur,Jamshedpur-831013</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;">Dist-Seraikella Kharsawan</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;">State Name - Jharkhand,Code:20</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;">E-Mail : srinathservices05@gmail.com</b></h5>
                    </td>
                  <?php  } ?>

                  <?php if ($result['project_id'] == '12') {  ?>

                    <td>
                      <img src="./assets/dp/logo.png" align="left" align="left" height="12%;" style="text-align: center; height: 140px;    width: 100px;">
                      <h5 style=" color:#6b0100;text-align: center;"><b style="font-size: 30px !important;">Srinath Services</b></h5>
                      <h5 style="color:#6b0100;text-align: center;"><b style="font-size: 16px !important;">112,First Floor,Ashiana Trade Center,Adityapur,Jamshedpur-831013</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;">Dist-Seraikella Kharsawan</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;">GSTIN/UIN: 20AHTPM2433R1ZW</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px; margin-bottom: 10px;"><b style="text-align: center;">State Name - Jharkhand,Code:20</b></h5>
                    </td>
                  <?php  } ?>


                  <?php if ($result['project_id'] == '13') {  ?>

                    <td>
                      <img src="./assets/dp/logo.png" align="left" align="left" height="12%;" style="text-align: center; height: 140px;    width: 100px;">
                      <h5 style=" color:#6b0100;text-align: center;"><b style="font-size: 30px !important;">Srinath Services</b></h5>
                      <h5 style="color:#6b0100;text-align: center;"><b style="font-size: 16px !important;">112,First Floor,Ashiana Trade Center,Adityapur,Jamshedpur-831013</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;">Dist-Seraikella Kharsawan</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px;"><b style="font-size: 16px !important;">GSTIN/UIN: 20AHTPM2433R1ZW</b></h5>
                      <h5 style="color:#6b0100;text-align: center;font-size:16px; margin-bottom: 10px;"><b style="text-align: center;">State Name - Jharkhand,Code:20</b></h5>
                    </td>
                  <?php  } ?>

              </table>





              <table border="1" style="width:100%; margin-top:-1px; border-top-color: white;">

                <tr>
                  <td style="color:#6b0100;"><b>Invoice No.:</b><b style="color:black;"> <?php echo $result['invoice_no']   ?></b></td>
                  <td style="color:#6b0100;"><b>Bill Due Date:</b><b style="color:black;"> <?php echo date("d-m-Y", strtotime($result['bill_due_date']))  ?></b></td>
                  <td style="color:#6b0100;"><b>Payment After Due Date:</b><b style="color:black;"> <?php echo $result['after_due_date']
                                                                                                    ?>.00</b></td>
                </tr>
                <tr>
                  <td style="color:#6b0100;"><b>Invoice Date:</b><b style="color:black;"> <?php echo date("d-m-Y", strtotime($result['invoice_date']))  ?></b></td>
                  <td style="color:#6b0100;"><b>Other References:</b><b style="color:black;"> <?php echo $result['other_ref']  ?></b></td>
                </tr>
                <tr>
                  <td style="width: 35%;color:#6b0100;"><b>Mode/Terms of Payment:</b><b style="color:black;"> <?php echo $result['payment_terms']  ?></b></td>
                  <td style="padding:10px; color:#6b0100;"><b>Terms Of Delivery:</b><b style="color:black;"> <?php echo $result['terms_of_delivery'] ?></b></td>
                </tr>
              </table>
              <div class="card holder" style="margin-top:-2px;">
                <table border="1" style="width:100%;margin-bottom:-1px;">
                  <tr style="color: #6b0100;background-color: white; ">
                    <th style="width: 25%;">
                      <center style="text-align:left">Buyer(Bill to)</center>
                    </th>
                    <th>
                      <!-- <center>Shipped to: -->
                    </th>
                  </tr>
                  <?php
                  $customerId = $result['customer_id'];
                  $databaseObj->select("tbl_customer");
                  $databaseObj->where("`status` = '" . $auth->visible() . "' && `customer_id` = '$customerId'");
                  $getCustomerData = $databaseObj->get();
                  foreach ($getCustomerData as $row) {
                    $manage_customer_info = json_decode($row["customer_info"]);
                    $manage_customerproperty_info = json_decode($row["customer_property_info"]);
                    $projectId = $manage_customerproperty_info->projectName;

                    $databaseObj->select("tbl_projects");
                    $databaseObj->where("`status` = '" . $auth->visible() . "' && `projects_id` = '$projectId'");
                    $getprojectData = $databaseObj->get();

                    foreach ($getprojectData as $row) {
                      $manage_project_info = json_decode($row["projects_info"]);
                  ?>
                      <tr>
                        <td colspan="2" style="width: 50%;"><b style="color:#6b0100;"> </b><b><?= $manage_customer_info->name ?></b><br>
                          <b style="color:#6b0100;"></b><?php echo $manage_project_info->projectName;
                                                        ?><br>
                          <b style="color:#6b0100;"> </b><?php echo $manage_project_info->projectLocation;
                                                          ?>
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </table>
                <div class="card holder" style="margin-top: 0px !important">
                  <table border="1" style="width:100%; font-size: 0.8em; page-break-inside:auto;">
                    <!--</thead>-->
                    <tr align="center" style="color:#6b0100;background-color:white; page-break-inside:avoid; page-break-after:auto;">
                      <th rowspan="2">
                        <center>S.No</center>
                      </th>
                      <th style="width: 20%;" rowspan="2" colspan="3">
                        <center>Description Of Services</center>
                      </th>

                      <th rowspan="2">
                        <center>Quantity</center>
                      </th>
                      <th rowspan="2">
                        <center>Rate</center>
                      </th>

                      <th rowspan="2">
                        <center>Per</center>
                      </th>
                      <th rowspan="2">
                        <center>Amount</center>
                      </th>
                      <th rowspan="2">
                        <center>Water Charges</center>
                      </th>

                      <th rowspan="2">
                        <center>Common Power</center>
                      </th>

                      <th rowspan="2">
                        <center>Diesel Expenses</center>
                      </th>

                      <th colspan="2">
                        <center>Meter Redg.</center>
                      </th>
                      <th colspan="2">
                        <center>CGST</center>
                      </th>
                      <th colspan="2">
                        <center>SGST<center>
                      </th>
                      <!-- <th colspan="2">
                                            <center>IGST</center>
                                        </th> -->
                      <th style="width: 13%;" rowspan="2">
                        <center>Total</center>
                      </th>
                    </tr>
                    <div id="watermark">
                      <img src="login_css/images/faiz_print_watermark.png" alt="">
                    </div>
                    <!--<div id="bottom-watermark">-->
                    <!--    <span>POWERED BY</span>-->
                    <!--  <img src="login_css/images/ins_logo.png" alt="">-->
                    <!--</div>-->

                    <tr style="color:#6b0100;background-color:white">
                      <th>
                        <center>Current</center>
                      </th>
                      <th>
                        <center>Previous</center>
                      </th>
                      <th>
                        <center>Rate</center>
                      </th>
                      <th>
                        <center>Amount</center>
                      </th>
                      <th>
                        <center>Rate</center>
                      </th>
                      <th>
                        <center>Amount</center>
                      </th>
                      <!-- <th>
                                            <center>Rate</center>
                                        </th>
                                        <th>
                                            <center>Amount</center>
                                        </th> -->
                    </tr>

                    <?php

                    $cnt = 1;
                    ?>
                    <tr align="center" style="border-bottom: white; page-break-inside:avoid; page-break-after:auto">
                      <td style="font-family:arial !important;"><?php echo $cnt++ ?></td>
                      <?php //if(!empty($result['desc_of_goods'])) 
                      ?>
                      <td align="left" colspan="3" style="font-family:arial !important;">Fixed Maintanance</td>
                      <td style="font-family:arial !important;"><?php echo $result['qty'] ?>.00 Sqft</td>
                      <td style="font-family:arial !important;">0.90</td>
                      <td style="font-family:arial !important;">Sqft</td>
                      <td style="font-family:arial !important;"><?php echo $result['fixed_maint']  ?>.00</td>
                      <td style="font-family:arial !important;"><?php echo $result['water_charges']  ?></td>
                      <td style="font-family:arial !important;"><?php echo $result['common_power']  ?></td>
                      <td style="font-family:arial !important;"><?php echo $result['diesel_expenses']  ?></td>
                      <td style="font-family:arial !important;"><?php echo $result['meter_redg_curr']  ?></td>
                      <td style="font-family:arial !important;"><?php echo $result['meter_redg_pre']  ?></td>


                      <td style="font-family:arial !important;">9%</td>
                      <td style="font-family:arial !important;"><?php echo $result['sgst_amount'] ?></td>
                      <td style="font-family:arial !important;">9%</td>
                      <td style="font-family:arial !important;"><?php echo $result['cgst_amnt'] ?></td>

                      <td style="font-family:arial !important;"><?php echo round($result['total_amount'], 2)  ?>.00</td>
                    </tr>




                    <tr align="center" style="border: solid thin; border-bottom-color: white;">
                      <td colspan="4" align="right"><b>Total</b></td>
                      <td align="right"><?php echo $result['qty'] ?>.00 Sqft</td>
                      <td align="right"></td>
                      <td align="right"></td>
                      <td align="right"></td>
                      <td align="right"></td>
                      <td align="right"></td>
                      <td><b></b></td>
                      <td colspan="1"><b></b></td>
                      <td colspan="1"><b></b></td>
                      <td colspan="1"><b></b></td>
                      <td colspan="1"><b></b></td>
                      <td colspan="1"><b></b></td>
                      <td colspan="1"><b></b></td>
                      <td colspan="1"><b><?php echo $result['total_amount'] ?></b>.00</b></td>
                    </tr>



                  </table>


                  <table border="1" style="width:100%;">
                    <tr style="border-top-color: white !important;">
                      <td rowspan="6" style="width:60%;"><b style="color:#6b0100;">Amount Chargeable (in words) :</b><br><br>
                        <b style="color:#6b0100;">Rupees:</b><b> <?php echo convert_number_to_words($result['total_amount']); ?> Only</b>
                      </td>
                    </tr>

                  </table>

                  <table border="1" style="width: 100%; margin-top:0px; border-top-color: white;">
                    <tr>


                      <?php if ($result['project_id'] == '8') {  ?>
                        <td style=" width:50%;">
                          Company's PAN : <b> CTLPM9753Q</b><br>
                          <p><u>Declaration</u></p>
                          MOBILE NO OF --SITE INCHARGE - 9204758462,LIFT<BR>
                          -HIGHTECH - 9006727193,ELECTRICIAN -9279511276
                        </td>

                      <?php
                      } ?>

                      <?php if ($result['project_id'] == '10') {  ?>
                        <td style=" width:50%;">
                          Company's PAN : <b> ACMFS6536M</b><br>
                          <p><u>Declaration</u></p>
                          Contact No:-Security Guard - 9262298520,Electrician <BR>
                          -9204398500,Gas Agency - 8676982794,Lift Hightech<br>
                          -9006727193,Lift Otis -9835120396
                        </td>

                      <?php
                      } ?>


                      <?php if ($result['project_id'] == '12') {  ?>
                        <td style=" width:50%;">
                          Company's PAN : <b> AHTPM2433R</b><br>
                          <p><u>Declaration</u></p>
                          MOBILE NO OF --- ELECTRICIAN - 9279511276,LIFT <BR>
                          OTIS -9835120396,LIFT HIGHTECH - 9006727193
                        </td>

                      <?php
                      } ?>

                      <?php if ($result['project_id'] == '13') {  ?>
                        <td style=" width:50%;">
                          Company's PAN : <b> AHTPM2433R</b><br>
                          <p><u>Declaration</u></p>
                          MOBILE NO OF --- ELECTRICIAN - 9279511276,LIFT <BR>
                          OTIS -9835120396,LIFT HIGHTECH - 9006727193
                        </td>

                      <?php
                      } ?>






                      <td>
                        <?php if ($result['project_id'] == '13') {  ?>

                          <center><b>Srinath Maintenance Services</b></center>
                        <?php } ?>

                        <?php if ($result['project_id'] == '12') {  ?>

                          <center><b>Srinath Maintenance Services</b></center>
                        <?php } ?>

                        <?php if ($result['project_id'] == '8') {  ?>

                          <center><b>Rock Garden Maintenance Services</b></center>
                        <?php } ?>

                        <?php if ($result['project_id'] == '10') {  ?>

                          <center><b>Srinath Global Maintenance Services</b></center>
                        <?php } ?>
                        <center><b></b></center> <br><br><br>
                        <center><b> Authorized Signatory </b></center>
                      </td>

                    </tr>

                  </table>


                </div><br>
              </div>



            </div>

          </div>
          <form class="form-inline">
            <button type="button" id="print" class="btn btn-success" onclick="myFunction()" style="margin-top: 33px; margin-left:1190px;">Print</button>


            </button>

          </form>
  </body>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
<?php  } ?>

<script>
  myFunction();
</script>

</html>