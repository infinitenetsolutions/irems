<?php
$page_no = "4";
$page_no_inside = "4_2";
?>


<?php
require_once("include/auth.php");
require_once("application/classes-and-objects/config.php");
require_once("application/classes-and-objects/veriables.php");
?>





<!DOCTYPE html>
<html>

<head>
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(1.8125rem + 2px);
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .w-200 {
            width: 150px !important;
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php if ($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name;
        else echo $setting->setting_firm_info->firm_name; ?> | Maintainance</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">
    <div id="wrapper" class="wrapper">
        <!-- Navbar Section Start -->
        <?php require_once("include/navbar.php"); ?>

        <!-- Navbar Section End -->
        <!-- Main Sidebar Section Start -->
        <?php require_once("include/aside.php"); ?>

        <!-- Main Sidebar Section End -->

        <!-- All Contains Section Start -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Maintainance</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Maintainance</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <?php
            if (isset($_SESSION['massage'])) {
                echo $_SESSION['massage'];
                unset($_SESSION['massage']);
            }

            ?>

            <section class="content">
                <div class="card card-navy card-outline">
                    <div class="card-body table-responsive">
                        <form action="./insertBill.php" class="form-horizontal" action="" method="post" enctype="multipart/form-data">


                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">Maintainance Services</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Projects</label>
                                                        <select id="service_name" name="service_name" class="form-control">
                                                            <option value="">Select Project</option>
                                                            <?php
                                                            $databaseObj->select("tbl_projects");
                                                            $databaseObj->where("`status` = '" . $auth->visible() . "'");
                                                            $getCompanyData = $databaseObj->get();
                                                            foreach ($getCompanyData as $row) {
                                                                $manage_company_info = json_decode($row["projects_info"]);
                                                            ?>
                                                                <option value="<?= $row["projects_id"] ?>"><?= $manage_company_info->projectName ?></option>
                                                            <?php
                                                                // endforeach;
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="">
                                                        <label>Invoice No</label>
                                                        <input required class="form-control" name="invoiceNo" id="showinvoiceNo" type="text" value="" readonly>

                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Invoice Date</label>
                                                        <input required class="form-control" name="invoiceDate" id="" type="date" value="">

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Bill Due Date</label>
                                                        <input required class="form-control" name="billDuedate" id="" type="date" value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Mode/Terms of Payment</label>
                                                        <input required class="form-control" name="paymentTerms" id="" type="text" value="">
                                                    </div>
                                                </div>



                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Other Reference(s)</label>
                                                        <input required class="form-control" name="otherRef" id="" type="text" value="">
                                                    </div>
                                                </div>



                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Terms of Delivery</label>
                                                        <textarea class="form-control" row="4" name="termofdelivery"></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </section>


                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">Projects: </h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Customers:</label>
                                                        <input required class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" list="demo" id="customer_name" name="customer_name" id="customer_name" onkeyup="search_customer(this.value)" onclick="search_customer(this.value)">
                                                        <datalist class="demo" id="demo">
                                                        </datalist>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Projects:</label>
                                                        <select id="project_name" name="project_name" class="form-control">
                                                            <option value="">Select Project</option>

                                                        </select>
                                                    </div>

                                                </div>




                                            </div>
                                            <div class="table-responsive" style="overflow-x:auto;">
                                                <table class="table table-bordered" style="overflow-y:auto;">

                                                    <tr>
                                                        <th data-field="S.NO" data-sortable="true" rowspan="2">S.NO</th>
                                                        <th data-field="Description" data-sortable="true" rowspan="2">Services</th>
                                                        <th data-field="Unit" data-sortable="true" rowspan="2">Unit</th>
                                                        <th data-field="Quantity" data-sortable="true" rowspan="2">Quantity</th>
                                                        <th data-field="Rate" data-sortable="true" rowspan="2">Rate</th>
                                                        <th data-field="Amount" data-sortable="true" rowspan="2">Amount</th>
                                                        <th data-field="CGST" data-sortable="true" colspan="2">Cgst</th>
                                                        <th data-field="SGST" data-sortable="true" colspan="2">Sgst</th>
                                                        <th data-field="IGST" data-sortable="true" colspan="2">Igst</th>
                                                        <th data-field="Total" data-sortable="true" rowspan="2">Total</th>
                                                        <th rowspan="2">Actions</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Rate</th>
                                                        <th>Amt</th>
                                                        <th>Rate</th>
                                                        <th>Amt</th>
                                                        <th>Rate</th>
                                                        <th>Amt</th>

                                                    </tr>
                                                    <?php
                                                    $cnt = 1;





                                                    ?>

                                                    <tbody id="dynamic_field">
                                                        <tr>
                                                            <?php
                                                            $databaseObj->select("tbl_services");
                                                            $databaseObj->where("`status` = '" . $auth->visible() . "'");
                                                            $getData = $databaseObj->get();


                                                            ?>
                                                            <td width="10%"><input type="text" id="slno1" value="1" readonly class="form-control" style="border:none;width:50px!important;" /></td>
                                                            <td width="80%">
                                                                <input class="form-control form-control-sm product w-200" list="demo" id="service" name="service[]" onclick="search(this.value)" onclick="calculate(0)" onmouseover="calculate(0)" onkeydown="calculate(0)" onkeyup="search(this.value)">
                                                                <datalist class="demo" id="demo">

                                                                </datalist>
                                                            </td>

                                                            <td width="70%">
                                                                <input type="text" name="unit[]" placeholder="" id="'unit'" class="form-control unit" style="width:80px!important;" />
                                                            </td>
                                                            <td><input type="text" name="quantity[]" placeholder="" id="tonne_id[1][tonne]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1); getGst();" class="form-control" style="width:50px!important;" /></td>
                                                            <td><input type="text" name="rate[]" placeholder="" id="rate_id[1][rate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1); getGst();" class="form-control" style="width:80px!important;" /></td>
                                                            <td><input type="text" name="amount[]" placeholder="" id="amount_id[1][amount]" class="form-control servicePrice" style="width:80px!important;" readonly /></td>

                                                            <td><input type="text" name="cgstrate[]" placeholder="" id="cgst_id[1][cgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" class="form-control cGstValue" style="width:50px!important;" /></td>
                                                            <td><input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id[1][cgstamt]" class="form-control" style="width:80px!important;" readonly /></td>


                                                            <td><input type="text" name="sgstrate[]" placeholder="" id="sgst_id[1][sgstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" class="form-control sGstValue" style="width:50px!important;" /></td>
                                                            <td><input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id[1][sgstamt]" class="form-control" style="width:80px!important;" style="width:110px;" readonly /></td>

                                                            <td><input type="text" name="igstrate[]" placeholder="" id="igst_id[1][igstrate]" onkeyup="cal(1); cal_cgst(1); cal_sgst(1); cal_igst(1);" class="form-control iGstValue" style="width:50px!important;" /></td>
                                                            <td><input type="text" name="igstamt[]" placeholder="" id="igstamt_id[1][igstamt]" class="form-control" style="width:80px;" readonly /></td>

                                                            <td><input type="text" name="total[]" placeholder="" id="total_id[1][total]" class="form-control" style="width:80px!important;" readonly /></td>
                                                            <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></td>

                                                        </tr>
                                                    </tbody>

                                                    <?php
                                                    $cnt++;

                                                    ?>

                                                    <tfoot>
                                                        <tr>
                                                            <th data-field="S.NO" data-sortable="true" rowspan="2"></th>
                                                            <th data-field="services" data-sortable="true" rowspan="2"></th>
                                                            <th data-field="Unit" data-sortable="true" rowspan="2"></th>
                                                            <th data-field="Quantity" data-sortable="true" rowspan="2"></th>
                                                            <th data-field="Rate" data-sortable="true" rowspan="2"></th>
                                                            <th data-field="Amount" data-sortable="true" rowspan="2">
                                                                <input type="text" name="amount_grand_total" placeholder="" id="amount_grand_total" class="form-control" style="width:80px!important;" readonly />
                                                            </th>
                                                            <th data-field="CGST" data-sortable="true" colspan="2"></th>
                                                            <th data-field="SGST" data-sortable="true" colspan="2"></th>
                                                            <th data-field="IGST" data-sortable="true" colspan="2"></th>
                                                            <th data-field="Total" data-sortable="true" rowspan="2">
                                                                <input type="text" name="all_grand_total" placeholder="" id="all_grand_total" class="form-control" style="width:80px!important;" readonly />
                                                            </th>

                                                            <th rowspan="2"></th>
                                                        </tr>
                                                        <tr>

                                                            <th>
                                                                <input type="text" name="cgstrate_grand_total" placeholder="" id="cgstrate_grand_total" class="form-control" style="width:80px!important;" readonly />
                                                            </th>
                                                            <th>
                                                                <input type="text" name="cgst_grand_total" placeholder="" id="cgst_grand_total" class="form-control" style="width:80px!important;" readonly />
                                                            </th>

                                                            <th>
                                                                <input type="text" name="sgstrate_grand_total" placeholder="" id="sgstrate_grand_total" class="form-control" style="width:80px!important;" readonly />
                                                            </th>
                                                            <th><input type="text" name="sgst_grand_total" placeholder="" id="sgst_grand_total" class="form-control" style="width:80px!important;" readonly /></th>

                                                            <th>
                                                                <input type="text" name="igstrate_grand_total" placeholder="" id="igstrate_grand_total" class="form-control" style="width:80px!important;" readonly />
                                                            </th>
                                                            <th><input type="text" name="igst_grand_total" placeholder="" id="igst_grand_total" class="form-control" style="width:80px!important;" readonly /></th>
                                                        </tr>
                                                    </tfoot>



                                                </table>

                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="text-center mg-b-pro-edt custom-pro-edt-ds">
                                                            <button type="su" id="billing_form_id" class="btn btn-info">Generate Bill</button>
                                                            <div id="billing_form_error_section"></div>
                                                        </div>
                                                    </div>
                                                </div>
                        </form>
                        <br>
                        <!--<input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" /> -->
                    </div>

                </div>
        </div>

    </div>
    </div>
    </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Description of Goods and Services</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="float-right" id="importFrm">
                        <form action="./imprtExcel/importData.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="doc" />
                            <button name="submit" id="addButton" type="submit" class="order-button btn btn-sm btn-success mt-1 mb-1" title="">Import</button>
                        </form>
                    </div>
                    <div class="table-responsive" style="overflow-x:auto;">

                        <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">

                            <tbody>
                                <tr>
                                    <th width="3%">Sl.No</th>
                                    <th width="3%">Project</th>
                                    <th width="3%">Invoice No</th>
                                    <th width="3%">Invoice Date</th>
                                    <th width="3%">Bill Due Date</th>
                                    <th width="3%">Mode Of Payment</th>
                                    <th width="3%">Other Reference</th>
                                    <th width="3%">Terms Of Delivery</th>
                                    <th width="3%">Customer Name</th>
                                    <th width="7%">Unit No</th>
                                    <th width="7%">Name</th>
                                    <th width="10%">Area Sq. Ft.</th>
                                    <th width="7%">Fixed Maint.</th>
                                    <th width="7%">Meter Rdg.</th>
                                    <th width="7%">Amt.</th>
                                    <th width="7%">Meter Fixed Charges</th>
                                    <th width="7%">Water</th>
                                    <th width="8%">Comm. Pow</th>
                                    <th width="8%">Unit Comm.</th>
                                    <th width="8%">Total</th>
                                    <th width="8%">Diesel</th>
                                    <th width="8%">GST Total</th>
                                    <th width="8%">SGST @ 9%</th>
                                    <th width="8%">CGST @ 9%</th>
                                    <th width="8%">Outstanding</th>
                                    <th width="8%">Total</th>
                                    <th width="8%">Due</th>
                                    <th width="8%">Total</th>
                                    <th width="8%">2%</th>
                                    <th width="8%">After Due Date</th>

                                </tr>

                                <?php
                                /*  $databaseObj->select("tbl_customer");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $databaseObj->order_by("`customer_id` DESC");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                                $customer_info = json_decode($rows["customer_info"]);
                                                $customer_log = json_decode($rows["customer_log"]);
                                                $customer_property_info = json_decode($rows["customer_property_info"]);
                                                $customer_second_applicant = json_decode($rows["customer_second_applicant"]);
                                    */ ?>
                                <tr> </tr>





                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

        </div>

    </section>



    <!-- </form> -->
    </div>
    </div>
    </section>




    <!-- Footer Section Start -->
    <?php require_once("include/footer.php"); ?>
    <!-- Footer Section End -->
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Js Section Start -->
    <?php require_once("include/js.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        //   INSERT BILL

        $(function() {


            $('#billing_form_id').click(function() {
                console.log($('#billing_form').serializeArray());
                // alert('hello');
                $.ajax({
                    url: 'insertBill.php',
                    type: 'POST',
                    data: $('#billing_form').serializeArray(),
                    success: function(result) {
                        $('#response_form').remove();
                        //  $('#billing_form')[0].reset();
                        $('#billing_form_error_section').append('<p id = "response_form">' + result + '</p>');
                    }

                });

            });

        });




        function search(data) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementsByClassName('demo')[0].innerHTML = this.responseText;
            }
            xhttp.open("GET", "selectSearch.php?q=" + data, true);
            xhttp.send();
        }
        // ADD row



        function search_customer(data) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementsByClassName('demo')[0].innerHTML = this.responseText;
                getCustomerInfo();
                //console.log(this.responseText);
            }
            xhttp.open("GET", "selectSearchcustomer.php?q=" + data, true);
            xhttp.send();
        }


        // calculation of the payment
        function calculate(id) {
            if (id > 0) {
                id = id - 1
            }

            // getting the value of the amount 
            var service_amount = document.getElementById('service').value;
            service_array = service_amount.split("|")
            service_amount = service_array[1];
            if (service_amount != null) {
                document.getElementsByClassName('servicePrice')[id].value = service_amount
                console.log(service_amount)
            } else {
                document.getElementsByClassName('servicePrice')[id].value = ''

            }

        }

        // GET GST
        function getGst() {
            var gstin_value = String(document.getElementById('get_gstin_value').value);
            //var gstin_value = "Hello";
            var state_code = gstin_value.charAt(0) + gstin_value.charAt(1);
            //alert(state_code);
            if (state_code == "20") {
                var tObj = document.getElementsByClassName('iGstValue');
                for (var i = 0; i < tObj.length; i++) {
                    tObj[i].value = '0';

                }
                var tObj = document.getElementsByClassName('cGstValue');
                for (var i = 0; i < tObj.length; i++) {
                    tObj[i].value = '9';

                }
                var tObj = document.getElementsByClassName('sGstValue');
                for (var i = 0; i < tObj.length; i++) {
                    tObj[i].value = '9';

                }
            } else {
                var tObj = document.getElementsByClassName('iGstValue');
                for (var i = 0; i < tObj.length; i++) {
                    tObj[i].value = '18';

                }
                var tObj = document.getElementsByClassName('cGstValue');
                for (var i = 0; i < tObj.length; i++) {
                    tObj[i].value = '0';

                }
                var tObj = document.getElementsByClassName('sGstValue');
                for (var i = 0; i < tObj.length; i++) {
                    tObj[i].value = '0';

                }
            }
        }




        // $('#phase_name').prop('disabled', true);

        $('#customer_name').change(function() {
            //   $('#project_name').prop('disabled', false);
            //   if ($(this).val() == '') {
            //     $('#phase_name').prop('disabled', true);
            //     $('#building_name').attr("disabled", true);
            //     $('#floor_name').attr("disabled", true);
            //     $('#flatNo').attr("disabled", true);
            //}
        });


        $('#project_name').change(function() {
            $('#phase_name').prop('disabled', false);
            if ($(this).val() == '') {
                $('#phase_name').prop('disabled', true);
                $('#building_name').attr("disabled", true);
                $('#floor_name').attr("disabled", true);
                $('#flatNo').attr("disabled", true);
            }
        });

        $('#phase_name').change(function() {
            $('#building_name').prop('disabled', false);
            if ($(this).val() == '') {
                $('#building_name').attr("disabled", true);
                $('#floor_name').attr("disabled", true);
                $('#flatNo').attr("disabled", true);
            }
            //if($('#phase_name').attr("disabled", true))
            //{$('#building_name').attr("disabled", true);  }
        });

        $('#building_name').change(function() {
            $('#floor_name').prop('disabled', false);
            if ($(this).val() == '') {
                $('#floor_name').attr("disabled", true);
                $('#flatNo').attr("disabled", true);
            }
        });

        $('#floor_name').change(function() {
            $('#flatNo').prop('disabled', false);
            if ($(this).val() == '') {
                $('#flatNo').attr("disabled", true);
            }
        });
    </script>


    <script src="dist/js/ajax.js"></script>
    <!-- <script src="dist/js/admin/purchase-order.js"></script> -->
    <script type="text/javascript">
        function cal(si) {


            if (document.getElementById('tonne_id[' + si + '][tonne]').value != "" && document.getElementById('rate_id[' + si + '][rate]').value != "") {
                document.getElementById('amount_id[' + si + '][amount]').value = document.getElementById('tonne_id[' + si + '][tonne]').value * document.getElementById('rate_id[' + si + '][rate]').value;
                var amt = Number(document.getElementById('amount_id[' + si + '][amount]').value);
                var camt = Number(document.getElementById('cgst_id[' + si + '][cgstrate]').value);
                var samt = Number(document.getElementById('sgst_id[' + si + '][sgstrate]').value);
                var iamt = Number(document.getElementById('igst_id[' + si + '][igstrate]').value)
                var total = amt + camt + samt + iamt;
                // var t_camt= amt * (camt/100);
                // var t_samt=  amt * (samt/100);
                // var t_iamt=  amt * (iamt/100);
                // var total = amt+t_camt+t_samt+t_iamt;
                total = total.toFixed(2);

                document.getElementById('total_id[' + si + '][total]').value = total;
            } else {
                document.getElementById('amount_id[' + si + '][amount]').value = "";
                var amt = Number(document.getElementById('amount_id[' + si + '][amount]').value);
                var camt = Number(document.getElementById('cgst_id[' + si + '][cgstrate]').value);
                var samt = Number(document.getElementById('sgst_id[' + si + '][sgstrate]').value);
                var iamt = Number(document.getElementById('igst_id[' + si + '][igstrate]').value);
                var total = amt + camt + samt + iamt;
                total = total.toFixed(2);

                document.getElementById('total_id[' + si + '][total]').value = total;
            }
        }

        function cal_cgst(si) {
            if (document.getElementById('cgst_id[' + si + '][cgstrate]').value != "") {
                var tamount = document.getElementById('amount_id[' + si + '][amount]').value / 100;
                document.getElementById('cgstamt_id[' + si + '][cgstamt]').value = tamount * document.getElementById('cgst_id[' + si + '][cgstrate]').value;
                var amt = Number(document.getElementById('amount_id[' + si + '][amount]').value);
                var camt = Number(document.getElementById('cgstamt_id[' + si + '][cgstamt]').value);
                var samt = Number(document.getElementById('sgstamt_id[' + si + '][sgstamt]').value);
                var iamt = Number(document.getElementById('igstamt_id[' + si + '][igstamt]').value);
                var total = amt + camt + samt + iamt;
                document.getElementById('total_id[' + si + '][total]').value = total;
            } else {
                document.getElementById('cgstamt_id[' + si + '][cgstamt]').value = "";
                var amt = Number(document.getElementById('amount_id[' + si + '][amount]').value);
                var camt = Number(document.getElementById('cgstamt_id[' + si + '][cgstamt]').value);
                var samt = Number(document.getElementById('sgstamt_id[' + si + '][sgstamt]').value);
                var iamt = Number(document.getElementById('igstamt_id[' + si + '][igstamt]').value);
                var total = amt + camt + samt + iamt;
                document.getElementById('total_id[' + si + '][total]').value = total;
            }
            calculate_cgst_total();
            calculate_cgstrate_total();
            calculate_sgst_total();
            calculate_sgstrate_total();
            calculate_igst_total();
            calculate_igstrate_total();
            calculate_all_total();
            calculate_amount_total();
        }

        function cal_sgst(si) {
            if (document.getElementById('sgst_id[' + si + '][sgstrate]').value != "") {
                var tamount = document.getElementById('amount_id[' + si + '][amount]').value / 100;
                document.getElementById('sgstamt_id[' + si + '][sgstamt]').value = tamount * document.getElementById('sgst_id[' + si + '][sgstrate]').value;
                var amt = Number(document.getElementById('amount_id[' + si + '][amount]').value);
                var camt = Number(document.getElementById('cgstamt_id[' + si + '][cgstamt]').value);
                var samt = Number(document.getElementById('sgstamt_id[' + si + '][sgstamt]').value);
                var iamt = Number(document.getElementById('igstamt_id[' + si + '][igstamt]').value);
                var total = amt + camt + samt + iamt;
                document.getElementById('total_id[' + si + '][total]').value = total;
            } else {
                document.getElementById('sgstamt_id[' + si + '][sgstamt]').value = "";
                var amt = Number(document.getElementById('amount_id[' + si + '][amount]').value);
                var camt = Number(document.getElementById('cgstamt_id[' + si + '][cgstamt]').value);
                var samt = Number(document.getElementById('sgstamt_id[' + si + '][sgstamt]').value);
                var iamt = Number(document.getElementById('igstamt_id[' + si + '][igstamt]').value);
                var total = amt + camt + samt + iamt;
                document.getElementById('total_id[' + si + '][total]').value = total;
            }
            calculate_cgst_total();
            calculate_cgstrate_total();
            calculate_sgst_total();
            calculate_sgstrate_total();
            calculate_igst_total();
            calculate_igstrate_total();
            calculate_all_total();
            calculate_amount_total();
        }

        function cal_igst(si) {
            if (document.getElementById('igst_id[' + si + '][igstrate]').value != "") {
                var tamount = document.getElementById('amount_id[' + si + '][amount]').value / 100;
                document.getElementById('igstamt_id[' + si + '][igstamt]').value = tamount * document.getElementById('igst_id[' + si + '][igstrate]').value;
                var amt = Number(document.getElementById('amount_id[' + si + '][amount]').value);
                var camt = Number(document.getElementById('cgstamt_id[' + si + '][cgstamt]').value);
                var samt = Number(document.getElementById('sgstamt_id[' + si + '][sgstamt]').value);
                var iamt = Number(document.getElementById('igstamt_id[' + si + '][igstamt]').value);
                var total = amt + camt + samt + iamt;
                document.getElementById('total_id[' + si + '][total]').value = total;
            } else {
                document.getElementById('igstamt_id[' + si + '][igstamt]').value = "";
                var amt = Number(document.getElementById('amount_id[' + si + '][amount]').value);
                var camt = Number(document.getElementById('cgstamt_id[' + si + '][cgstamt]').value);
                var samt = Number(document.getElementById('sgstamt_id[' + si + '][sgstamt]').value);
                var iamt = Number(document.getElementById('igstamt_id[' + si + '][igstamt]').value);
                var total = amt + camt + samt + iamt;
                document.getElementById('total_id[' + si + '][total]').value = total;
            }
            calculate_cgst_total();
            calculate_cgstrate_total();
            calculate_sgst_total();
            calculate_sgstrate_total();
            calculate_igst_total();
            calculate_igstrate_total();
            calculate_all_total();
            calculate_amount_total();
        }

        function cal_totalAll(si) {
            var count = Number(document.getElementById('counter').value);
            // alert(total);
            var totalAmt = 0;
            console.log(count - 1);
            for (i = 1; i <= (count - 1); i++) {
                console.log(Number(totalAmt));
                totalAmt = Number(totalAmt) + Number(document.getElementById('total_id[' + i + '][total]').value);
                console.log(totalAmt);
                document.getElementById('totalAll').value = roundToXDigits(totalAmt, 2);

            }
            //document.getElementById('totalAll').value = total;   
        }





        function getCustomerInfo() {
            // alert('test');
            var customer_data = document.getElementById('customer_name').value;
            var customer_id = customer_data.split("|")[4];


            $.ajax({
                url: 'getinformationscustomer.php',
                type: 'POST',
                data: {
                    "customer": customer_id
                },
                success: function(result, result1) {
                    console.log(result);
                    //console.log(result1);
                    $('#viewprojects').remove();

                    $('#project_name').html('<div id="viewprojects" >' + result + '</div>');


                }
            });
            event.preventDefault();
        }



        $('#service_name').on('change', function(event) {

            $.ajax({
                url: 'getinvoiceno.php',
                type: 'POST',
                data: {
                    "servicename": $(this).val()
                },
                success: function(result) {
                    document.getElementById('showinvoiceNo').value = result


                }

            });
            event.preventDefault();

        });


        $('#project_name').on('change', function(event) {
            // alert('test');
            $.ajax({
                url: 'getinformationsproject.php',
                type: 'POST',
                data: {
                    "project": $(this).val()
                },
                success: function(result) {
                    $('#viewprojects').remove();
                    $('#projectLocation').html('<div id="viewprojects" >' + result + '</div>');

                }
            });
            event.preventDefault();
        });
        $(document).ready(function() {
            var i = 1;

            $('#add').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added" ><td><input type="text" id="slno' + i + '" value="' + i + '" readonly class="form-control" style="border:none;" /></td><td>' +
                    '<input class="form-control form-control-sm product w-200" list="demo" id="service" name="service[]" onclick="search(this.value)"  onclick="calculate(' + i + ')" onmouseover="calculate(' + i + ')" onkeydown="calculate(' + i + ')" onkeyup="search(this.value)"><datalist class="demo" id="demo"></datalist><td>' +
                    '<input type="text" name="unit[]" placeholder="" class="form-control" /></td><td>' +
                    '<input type="text" name="quantity[]" placeholder="" id="tonne_id[' + i + '][tonne]" onkeyup="cal(' + i + '); cal_cgst(' + i + '); cal_sgst(' + i + '); cal_igst(' + i + '); getGst();" class="form-control"/></td><td><input type="text" name="rate[]"  placeholder="" id="rate_id[' + i + '][rate]" onkeyup="cal(' + i + '); cal_cgst(' + i + '); cal_sgst(' + i + '); cal_igst(' + i + '); getGst();" class="form-control"/></td><td><input type="text" name="amount[]" placeholder="" id="amount_id[' + i + '][amount]" class="form-control" readonly /></td><td><input type="text" name="cgstrate[]" placeholder="" id="cgst_id[' + i + '][cgstrate]" onkeyup="cal(' + i + '); cal_cgst(' + i + '); cal_sgst(' + i + '); cal_igst(' + i + ');" class="form-control cGstValue"/></td>	<td><input type="text" name="cgstamt[]" placeholder="" id="cgstamt_id[' + i + '][cgstamt]" class="form-control" readonly /></td><td><input type="text" name="sgstrate[]" placeholder="" id="sgst_id[' + i + '][sgstrate]" onkeyup="cal(' + i + '); cal_cgst(' + i + '); cal_sgst(' + i + '); cal_igst(' + i + ');" class="form-control sGstValue"/></td><td><input type="text" name="sgstamt[]" placeholder="" id="sgstamt_id[' + i + '][sgstamt]" class="form-control" readonly /></td><td><input type="text" name="igstrate[]" placeholder="" id="igst_id[' + i + '][igstrate]" onkeyup="cal(' + i + '); cal_cgst(' + i + '); cal_sgst(' + i + '); cal_igst(' + i + ');" class="form-control iGstValue"/></td><td><input type="text" name="igstamt[]" placeholder="" id="igstamt_id[' + i + '][igstamt]" class="form-control" readonly /></td><td><input type="text" name="total[]" placeholder="" id="total_id[' + i + '][total]" class="form-control" readonly /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');

                calculate_cgst_total();
                calculate_cgstrate_total();
                calculate_sgst_total();
                calculate_sgstrate_total();
                calculate_igst_total();
                calculate_igstrate_total();
                calculate_all_total();
                calculate_amount_total();

            });



            $(document).on('click', '.btn_remove', function() {
                i--
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                calculate_cgst_total();
                calculate_cgstrate_total();
                calculate_sgst_total();
                calculate_sgstrate_total();
                calculate_igstrate_total();
                calculate_igst_total();
                calculate_all_total();
                calculate_amount_total();

            });


            calculate_all_total = function() {
                var all_grand_total = 0;
                for (x = 1; x <= i; x++) {
                    all_grand_total = all_grand_total + Number(document.getElementById('total_id[' + x + '][total]').value);
                }
                document.getElementById('all_grand_total').value = all_grand_total;
            }


            calculate_amount_total = function() {
                var amount_grand_total = 0;
                for (x = 1; x <= i; x++) {
                    amount_grand_total = amount_grand_total + Number(document.getElementById('amount_id[' + x + '][amount]').value);
                }
                document.getElementById('amount_grand_total').value = amount_grand_total;
            }


            calculate_cgst_total = function() {
                var cgst_grand_total = 0;
                for (x = 1; x <= i; x++) {
                    cgst_grand_total = cgst_grand_total + Number(document.getElementById('cgstamt_id[' + x + '][cgstamt]').value);
                }
                document.getElementById('cgst_grand_total').value = cgst_grand_total;
            }


            calculate_cgstrate_total = function() {
                var cgstrate_grand_total = 0;
                for (x = 1; x <= i; x++) {
                    cgstrate_grand_total = cgstrate_grand_total + Number(document.getElementById('cgst_id[' + x + '][cgstrate]').value);
                }
                document.getElementById('cgstrate_grand_total').value = cgstrate_grand_total;
            }


            calculate_sgst_total = function() {
                var sgst_grand_total = 0;
                for (x = 1; x <= i; x++) {
                    sgst_grand_total = sgst_grand_total + Number(document.getElementById('sgstamt_id[' + x + '][sgstamt]').value);
                }
                document.getElementById('sgst_grand_total').value = sgst_grand_total;
            }


            calculate_sgstrate_total = function() {
                var sgstrate_grand_total = 0;
                for (x = 1; x <= i; x++) {
                    sgstrate_grand_total = sgstrate_grand_total + Number(document.getElementById('sgst_id[' + x + '][sgstrate]').value);
                }
                document.getElementById('sgstrate_grand_total').value = sgstrate_grand_total;
            }





            calculate_igstrate_total = function() {
                var igstrate_grand_total = 0;
                for (x = 1; x <= i; x++) {
                    igstrate_grand_total = igstrate_grand_total + Number(document.getElementById('igst_id[' + x + '][igstrate]').value);
                }
                document.getElementById('igstrate_grand_total').value = igstrate_grand_total;
            }


            calculate_igst_total = function() {
                var igst_grand_total = 0;
                for (x = 1; x <= i; x++) {
                    igst_grand_total = igst_grand_total + Number(document.getElementById('igstamt_id[' + x + '][igstamt]').value);
                }
                document.getElementById('igst_grand_total').value = igst_grand_total;
            }

        });
    </script>

    <!-- Js Section End -->
</body>

</html>