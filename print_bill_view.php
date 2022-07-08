<?php


include './include/commonFuncs.php';
@require_once("include/auth.php");
require_once("application/classes-and-objects/config.php");
require_once("application/classes-and-objects/veriables.php");



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
    </style>
    <meta charset="utf-8" />

    <title>IREMS | Print Bill</title>

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
                                $conn = mysqli_connect('localhost', 'root', '', 'srinathhomes_db_irmes');

                                $sel = "SELECT * from `tbl_maintenance` where invoice_no=" . $_GET['invoice_no'] . " GROUP BY invoice_no";
                                $run = mysqli_query($conn, $sel);
                                while ($result = mysqli_fetch_assoc($run)) {


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

                                        <td>
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





                                <?php }
                                ?>
                        </table>
                        <?php
                        //
                        // 			$sel = "SELECT * from tbl_company";
                        // 			$run=mysqli_query($conn,$sel);
                        // 			while($result=mysqli_fetch_assoc($run)){
                        ?>
                        <!--<div class="card-header ">-->
                        <!--    <center><h4 class="card-title" style="margin-top: -13px;background-color: #6b0100;color:white;"><b>GSTIN: <?php //echo $result['gstin'];
                                                                                                                                            ?></b></h4></center>-->
                        <!--</div>-->

                        <?php // }  
                        ?>
                        <!-- <div class="card holder" style="border:1px solid black !important;">
                            <div class="card-header">
                                <center>
                                    <h2 class="card-title" style=" background-color: white;color:#6b0100;"><b style="font-size:16px !important;">TAX INVOICE</b></h2>
                                </center>
                            </div>
                        </div> -->

                        <?php

                        $sel = "SELECT * from `tbl_maintenance` where invoice_no=" . $_GET['invoice_no'] . " GROUP BY invoice_no";
                        //echo $sel;
                        $run = mysqli_query($conn, $sel);
                        while ($result = mysqli_fetch_assoc($run)) {
                            // echo "<pre>";
                            // print_r($result);
                        ?>


                            <table border="1" style="width:100%; margin-top:-1px; border-top-color: white;">

                                <tr>
                                    <td style="color:#6b0100;"><b>Invoice No.:</b><b style="color:black;"> <?php echo $result['invoice_no']   ?></b></td>
                                    <td style="color:#6b0100;"><b>Bill Due Date:</b><b style="color:black;"> <?php echo date("d-m-Y", strtotime($result['bill_due_date']))  ?></b></td>
                                    <?php

                                    $resultt = mysqli_query($conn, "SELECT SUM(amount) AS totalsum FROM tbl_maintenance where invoice_no=" . $_GET['invoice_no'] . "");
                                    $row = mysqli_fetch_assoc($resultt);
                                    $sum3 = round($row['totalsum'], 2);
                                    $pay = round($sum3 * 0.02) + $sum3;  //calculate 2%  of total
                                    ?>
                                    <td style="color:#6b0100;"><b>Payment After Due Date:</b><b style="color:black;"> <?php echo $pay
                                                                                                                        ?></b></td>

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
                        <?php }   ?>






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

                                $sel = "SELECT * from `tbl_maintenance` where invoice_no=" . $_GET['invoice_no'] . " GROUP BY invoice_no";
                                $run = mysqli_query($conn, $sel);
                                while ($result = mysqli_fetch_assoc($run)) {

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
                                }
                                ?>

                            </table>


                            <div class="card holder" style="margin-top: 0px !important">



                                <table border="1" style="width:100%; font-size: 0.8em; page-break-inside:auto;">

                                    <?php

                                    $sel = "SELECT * from `tbl_maintenance` where invoice_no=" . $_GET['invoice_no'] . "";
                                    $run = mysqli_query($conn, $sel);
                                    while ($result = mysqli_fetch_assoc($run)) {
                                    }
                                    // $code_exp = explode("|",$code);
                                    // $des_exp = explode("|",$des);
                                    $i = 0;
                                    // echo count($code_exp);
                                    //while($i<count($code_exp)-1){
                                    ?>



                                    <?php
                                    $i++;
                                    //} 
                                    ?>
                                    <!--</thead>-->
                                    <tr align="center" style="color:#6b0100;background-color:white; page-break-inside:avoid; page-break-after:auto;">
                                        <th rowspan="2">
                                            <center>S.No</center>
                                        </th>
                                        <th style="width: 25%;" rowspan="2" colspan="3">
                                            <center>Description Of Goods & Services</center>
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
                                            <center>Taxable Value</center>
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
                                            <center>Total Tax Amount</center>
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

                                    $sel = "SELECT * from `tbl_maintenance` where invoice_no=" . $_GET['invoice_no'] . "";
                                    $cnt = 1;
                                    $run = mysqli_query($conn, $sel);
                                    while ($result = mysqli_fetch_assoc($run)) {
                                        $i++;
                                        // count($result['id']);
                                    ?>
                                        <tr align="center" style="border-bottom: white; page-break-inside:avoid; page-break-after:auto">
                                            <td style="font-family:arial !important;"><?php echo $cnt++ ?></td>
                                            <td align="left" colspan="3" style="font-family:arial !important;"><?php echo $result['desc_of_goods'] ?></td>
                                            <td style="font-family:arial !important;"><?php echo $result['qty'] ?></td>
                                            <td style="font-family:arial !important;"><?php echo $result['rate'] ?></td>
                                            <td style="font-family:arial !important;"><?php echo $result['per'] ?></td>
                                            <td style="font-family:arial !important;"><?php echo $result['amount']  ?></td>
                                            <td style="font-family:arial !important;"><?php echo $result['taxable_value']  ?></td>
                                            <td style="font-family:arial !important;"><?php echo $result['cgst_rate'] ?>%</td>
                                            <td style="font-family:arial !important;"><?php echo $result['cgst_amnt'] ?></td>
                                            <td style="font-family:arial !important;"><?php echo $result['sgst_rate'] ?>%</td>
                                            <td style="font-family:arial !important;"><?php echo $result['sgst_amount'] ?></td>

                                            <td style="font-family:arial !important;"><?php echo round($result['total_tax_amount'], 2)  ?></td>
                                        </tr>


                                    <?php
                                    }

                                    ?>


                                    <tr align="center" style="border: solid thin; border-bottom-color: white;">
                                        <td colspan="7" align="right"><b>Total</b></td>


                                        <?php

                                        $result = mysqli_query($conn, "SELECT SUM(amount) AS totalsum FROM tbl_maintenance where invoice_no=" . $_GET['invoice_no'] . "");
                                        $row = mysqli_fetch_assoc($result);
                                        $sum =  round($row['totalsum'], 2);

                                        ?>
                                        <td><b><?php echo $sum ?></b></td>
                                        <?php

                                        $result = mysqli_query($conn, "SELECT SUM(taxable_value) AS totalsum FROM tbl_maintenance where invoice_no=" . $_GET['invoice_no'] . "");
                                        $row = mysqli_fetch_assoc($result);
                                        $sum =  round($row['totalsum'], 2);

                                        ?>

                                        <td colspan="1"><b><?php echo $sum ?></b></td>
                                        <td colspan="1"><b></b></td>

                                        <?php

                                        $result = mysqli_query($conn, "SELECT SUM(cgst_amnt) AS totalsum FROM tbl_maintenance where invoice_no=" . $_GET['invoice_no'] . "");
                                        $row = mysqli_fetch_assoc($result);
                                        $sum_cgstamt = round($row['totalsum'], 2);
                                        ?>

                                        <td colspan="1"><b><?php echo $sum_cgstamt ?></b></td>
                                        <td colspan="1"><b></b></td>

                                        <?php

                                        // $result = mysqli_query($conn, "SELECT SUM(igstamt) AS totalsum FROM tbl_maintenance where invoice_no=" . $_GET['invoice_no'] . "");
                                        // $row = mysqli_fetch_assoc($result);
                                        // $sum1 = round($row['totalsum'], 2);
                                        ?>

                                        <?php

                                        $result = mysqli_query($conn, "SELECT SUM(sgst_amount) AS totalsum FROM tbl_maintenance where invoice_no=" . $_GET['invoice_no'] . "");
                                        $row = mysqli_fetch_assoc($result);
                                        $sum_sgstamt = round($row['totalsum'], 2);
                                        ?>
                                        <td colspan="1"><b><?php echo $sum_sgstamt ?></b></td>
                                        <?php

                                        $result = mysqli_query($conn, "SELECT SUM(total_tax_amount) AS totalsum FROM tbl_maintenance where invoice_no=" . $_GET['invoice_no'] . "");
                                        $row = mysqli_fetch_assoc($result);
                                        $sum3 = round($row['totalsum'], 2);
                                        ?>
                                        <td colspan="1"><b><?php echo $sum3 ?></b></td>




                                        <td></td>
                                    </tr>

                                </table>


                                <table border="1" style="width:100%;">
                                    <tr style="border-top-color: white !important;">
                                        <td rowspan="6" style="width:60%;"><b style="color:#6b0100;">Amount Chargeable (in words) :</b><br><br>
                                            <b style="color:#6b0100;">Rupees:</b><b> <?php echo convert_number_to_words($sum3); ?> Only</b>
                                        </td>
                                    </tr>

                                </table>

                                <table border="1" style="width: 100%; margin-top:0px; border-top-color: white;">
                                    <tr>

                                        <?php

                                        $sel = "SELECT * from `tbl_maintenance` where invoice_no=" . $_GET['invoice_no'] . " GROUP BY invoice_no";
                                        $run = mysqli_query($conn, $sel);
                                        while ($res = mysqli_fetch_assoc($run)) {

                                        ?>
                                            <?php if ($res['project_id'] == '8') {  ?>
                                                <td style=" width:50%;">
                                                    Company's PAN : <b> CTLPM9753Q</b><br>
                                                    <p><u>Declaration</u></p>
                                                    MOBILE NO OF --SITE INCHARGE - 9204758462,LIFT<BR>
                                                    -HIGHTECH - 9006727193,ELECTRICIAN -9279511276
                                                </td>

                                            <?php
                                            } ?>

                                            <?php if ($res['project_id'] == '10') {  ?>
                                                <td style=" width:50%;">
                                                    Company's PAN : <b> ACMFS6536M</b><br>
                                                    <p><u>Declaration</u></p>
                                                    Contact No:-Security Guard - 9262298520,Electrician <BR>
                                                    -9204398500,Gas Agency - 8676982794,Lift Hightech<br>
                                                    -9006727193,Lift Otis -9835120396
                                                </td>

                                            <?php
                                            } ?>


                                            <?php if ($res['project_id'] == '12') {  ?>
                                                <td style=" width:50%;">
                                                    Company's PAN : <b> AHTPM2433R</b><br>
                                                    <p><u>Declaration</u></p>
                                                    MOBILE NO OF --- ELECTRICIAN - 9279511276,LIFT <BR>
                                                    OTIS -9835120396,LIFT HIGHTECH - 9006727193
                                                </td>

                                            <?php
                                            } ?>

                                            <?php if ($res['project_id'] == '13') {  ?>
                                                <td style=" width:50%;">
                                                    Company's PAN : <b> AHTPM2433R</b><br>
                                                    <p><u>Declaration</u></p>
                                                    MOBILE NO OF --- ELECTRICIAN - 9279511276,LIFT <BR>
                                                    OTIS -9835120396,LIFT HIGHTECH - 9006727193
                                                </td>

                                            <?php
                                            } ?>





                                        <?php  } ?>
                                        <!-- <td style="padding-top: 160px; width:31%;">
                                            <center><b>(Common Seal)</center></b>
                                        </td> -->
                                        <?php

                                        $sel = "SELECT * from `tbl_maintenance` where invoice_no=" . $_GET['invoice_no'] . " GROUP BY invoice_no";
                                        $run = mysqli_query($conn, $sel);
                                        while ($res = mysqli_fetch_assoc($run)) {

                                        ?>
                                            <td>
                                                <?php if ($res['project_id'] == '13') {  ?>

                                                    <center><b>for Srinath Services</b></center>
                                                <?php } ?>

                                                <?php if ($res['project_id'] == '12') {  ?>

                                                    <center><b>for Srinath Services</b></center>
                                                <?php } ?>

                                                <?php if ($res['project_id'] == '8') {  ?>

                                                    <center><b>for Srinath Rock Garden</b></center>
                                                <?php } ?>

                                                <?php if ($res['project_id'] == '10') {  ?>

                                                    <center><b>for Srinath Global</b></center>
                                                <?php } ?>
                                                <center><b></b></center> <br><br><br>
                                                <center><b> Authorized Signatory </b></center>
                                                <!-- <center><b>Srinath Homes pvt ltd</b></center> -->
                                            </td>
                                        <?php } ?>
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



</html>