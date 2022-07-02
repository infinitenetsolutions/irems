<!-- Purchase Order -->
<?php
      $page_no = "4";
      $page_no_inside = "4_2";
  ?>
    <?php require_once("include/auth.php");
      require_once("application/classes-and-objects/config.php");
      require_once("application/classes-and-objects/veriables.php"); ?>

  <?php
    if($_POST['project_name']) {  
    // query to get all US records  
    $query = mysql_query("SELECT * FROM auip_wipo_sample WHERE app_country='US'");  
    }  
    elseif($_POST['country'] == 'AUD') {   
    }
?>
    <!DOCTYPE html>
    
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            <?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Create PO</title>
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
                                    <li class="breadcrumb-item active">Create Bill</li>
                                </ol>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- Main content -->

                <section class="content">
                    <div class="card card-navy card-outline">
                        <div class="card-body table-responsive">
                            <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/purchase-order.php">
                                <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_manage_po">
                                <input type="hidden" id="action" name="action" value="addPO">
                                <input type="hidden" id="secondaryLocation" name="checkLocation" />
                                <input type="hidden" id="secondaryIp" name="checkIp" />
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
                                                        <div class="">
                                                            <label>Invoice No</label>

                                                            <?php
                                         $databaseObj->select("tbl_maintainance");
                                          //$databaseObj->where("`status` = '".$auth->visible()."'");
                                         $getData = $databaseObj->get();
                                         $ordNo = 1;
                                         foreach ($getData as $rows):
                                         $ordNo =  $ordNo +1;
                                         endforeach;
                                        $invoice_no = str_pad($ordNo, 4, '0', STR_PAD_LEFT);
                                          ?>
                                                                <input class="form-control" name="invoiceNo" id="invoiceNo" type="text" value="<?= $invoice_no ?>" readonly>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Invoice Date</label>
                                                            <input class="form-control" name="invoiceDate" id="" type="date" value="">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Delivery Note</label>
                                                            <input class="form-control" name="deliveryNote" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mode/Terms of Payment</label>
                                                            <input class="form-control" name="paymentTerms" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Supplier's Ref.</label>
                                                            <input class="form-control" name="supplierRef" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Other Reference(s)</label>
                                                            <input class="form-control" name="supplierRef" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Buyer's Order No.</label>
                                                            <input class="form-control" name="buyerOrderNo" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Buyer's Order Date.</label>
                                                            <input class="form-control" name="buyerOrderNo" id="" type="date" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Despatch Document No.</label>
                                                            <input class="form-control" name="despatchNo" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Delivery Note Date</label>
                                                            <input class="form-control" name="deliveryNoteDate" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Despatched through</label>
                                                            <input class="form-control" name="despatchedThrough" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Destination</label>
                                                            <input class="form-control" name="destination" id="" type="text" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Terms of Delivery</label>
                                                            <textarea class="form-control" row="4" name="termofdelivery"></textarea>
                                                            <!--<input class="form-control" name="termofdelivery" id="" type="text" value="">-->
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </section>
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
                                            <label>Projects:</label>
                                            <select id="project_name" name="project_name" class="form-control">
                                  <option value="">Select Project</option>
                                <?php
                                  $databaseObj->select("tbl_projects");
                                  $databaseObj->where("`status` = '".$auth->visible()."'");
                                  $getCompanyData = $databaseObj->get();
                                  foreach ($getCompanyData as $row) {
                                    $manage_company_info = json_decode($row["projects_info"]);
                                    ?>
                                    <option value="<?= $row["firmName"] ?>"><?= $manage_company_info->projectName ?> Maint. Services</option>
                                    <?php
                                    // endforeach;
                                  }
                                   ?>
                                  </select>
                                        </div>

                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Address:</label>
                                            <?php
                                  $databaseObj->select("tbl_manage_company");
                                  $databaseObj->where("`status` = '".$auth->visible()."'");
                                  $getCompanyData = $databaseObj->get();
                                  foreach ($getCompanyData as $row) {
                                    $manage_company_info = json_decode($row["manage_company_info"]);
                                    if($manage_company_info->companyName == 'SRINATH HOMES INDIA PRIVATE LIMITED'){
                                    ?>
                                                <input class="form-control" name="contactNo" id="" type="text" value="<?= $manage_company_info->companyAddress ?>" readonly>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact No:</label>
                                            <input class="form-control" name="contactNo" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" value="<?= $manage_company_info->companyContactNumber ?>" readonly/>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email Address:</label>
                                            <input class="form-control" name="contactNo" id="" type="email" value="<?= $manage_company_info->companyEmail ?>" readonly>
                                        </div>
                                    </div>

                                     <div class="col-md-6" id="hidden_div">
                                        <div class="form-group">
                                            <label>Phase:</label>
                                            <select id="phase_name" name="phase_name" class="form-control" disabled>
                                  <option value="">Select Phase</option>
                                <?php
                                  $databaseObj->select("tbl_phase");
                                  $databaseObj->where("`status` = '".$auth->visible()."'");
                                  $getCompanyData = $databaseObj->get();
                                  foreach ($getCompanyData as $row) {
                                    $manage_company_info = json_decode($row["phase_info"]);
                                    ?>
                                    <option value="<?= $row["phase"] ?>"><?= $manage_company_info->phase ?> </option>
                                    <?php
                                    // endforeach;
                                  }
                                   ?>
                                  </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6" id="hidden_div">
                                        <div class="form-group">
                                            <label>Building:</label>
                                            <select id="building_name" name="building_name" class="form-control" disabled>
                                  <option value="">Select Building</option>
                                <?php
                                  $databaseObj->select("tbl_building");
                                  $databaseObj->where("`status` = '".$auth->visible()."'");
                                  $getCompanyData = $databaseObj->get();
                                  foreach ($getCompanyData as $row) {
                                    $manage_company_info = json_decode($row["building_info"]);
                                    ?>
                                    <option value="<?= $row["building"] ?>"><?= $manage_company_info->building ?> </option>
                                    <?php
                                    // endforeach;
                                  } 
                                   ?>
                                  </select>
                                        </div>

                                    </div>

                                     <div class="col-md-6" id="hidden_div">
                                        <div class="form-group">
                                            <label>Floor:</label>
                                            <select id="floor_name" name="floor_name" class="form-control" disabled> 
                                  <option value="">Select Floor</option>
                                  <option value="1">1 </option>
                                  <option value="2">2 </option>
                                  <option value="3">3 </option>
                                  <option value="4">4 </option>
                                  <option value="5">5 </option>
                                  <option value="6">6 </option>
                                  <option value="7">7 </option>
                                  <option value="8">8 </option>
                                  <option value="9">9 </option>
                                  <option value="10">10 </option>
                                  </select>
                                        </div>

                                    </div>
                               
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Flat No:</label>
                                            <input class="form-control" id="flatNo" name="flatNo" type="number"  disabled/>

                                        </div>
                                    </div>
                                  </div>
                                <?php
                                  }}
                                   ?>
                            </div>

                              

                        </div>

                    </div>

                </section>


                <?php
                                   /*        $databaseObj->select("tbl_manage_indent");
                                           $databaseObj->where("`status` = '".$auth->visible()."'");
                                           $databaseObj->order_by("`manage_indent_id` DESC");
                                           $getData = $databaseObj->get();
                                           //Checking If Data Is Available
                                                foreach($getData as $rows):
                                                   $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                                 endforeach;
                                          
                                          $databaseObj->select("tbl_projects");
                                          $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$manage_indent_info->employee_project."'");
                                          $getData = $databaseObj->get();
                                                
                                                
                                                if($getData != 0):
                                                  foreach($getData as $rows):
                                                     $projects_info = json_decode($rows["projects_info"]);
                                                     // $manage_indent_info = json_decode($rows["manage_indent_info"]);
                                                  endforeach;
                                                endif;  */
                                            ?>
          



        
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
                        <div class="float-right" id="importFrm" >
                          <form action="importData.php" method="post" enctype="multipart/form-data">
                              <input type="file" name="file" />
                              <button id="addButton" type="submit" class="order-button btn btn-sm btn-success mt-1 mb-1" title="Create PO">Import</button>
                              <!--<input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT"> -->
                          </form>
                        </div>
                        <div class="table-responsive" style="overflow-x:auto;">
                           <!-- <br><b>Warning</b>: Undefined variable $manage_indent_info in <b>D:\xamp_new\htdocs\irems\purchase-order.php</b> on line <b>508</b><br><br><b>Warning</b>: Attempt to read property "item_info" on null in <b>D:\xamp_new\htdocs\irems\purchase-order.php</b>                            on line <b>508</b><br><br><b>Warning</b>: foreach() argument must be of type array|object, null given in <b>D:\xamp_new\htdocs\irems\purchase-order.php</b> on line <b>508</b><br>-->
                           
                            <table class="table table-bordered" id="dynamic_field" style="overflow-y:auto;">

                                <tbody>
                                    <tr>
                                        <th width="3%">S.NO</th>
                                        <th width="7%">Flat No</th>
                                        <th width="7%">Building</th>
                                        <th width="10%">Client Name</th>
                                        <th width="7%">Fixed Maint.</th>
                                        <th width="8%">Dsl Exp.</th>
                                        <th width="8%">Comm. Pow</th>
                                        <th width="8%">Total</th>
                                        <th width="8%">Outstnd.</th>
                                        <th width="8%">Meter Rgd.</th>
                                        <th width="8%">Sgst%</th>
                                        <th width="8%">Cgst%</th>
                                        <th width="10%">GST Total</th>

                                        <!--  <th width="5%">Actions<button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></th> -->
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
                                    */?>
                                   <tr> </tr>





                                </tbody>
                            </table>

                        </div>

                    </div>

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
 // $('#phase_name').prop('disabled', true);
 
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
        <script src="dist/js/admin/purchase-order.js"></script>
        <script>
            function onSelection(id, val) {
                var code_id = "item_code_po[" + id + "]";
                var name_id = "item_name_po[" + id + "]";
                var uom_id = "uom_po[" + id + "]";

                console.log(code_id + " " + name_id + " " + uom_id);
                document.getElementById(code_id).value = val;
                document.getElementById(name_id).value = val;
                document.getElementById(uom_id).value = val;
            }

            function cal(si) {


                if (document.getElementById('tonne_id_po[' + si + '][tonne]').value != "" && document.getElementById('rate_id_po[' + si + '][rate]').value != "") {
                    document.getElementById('amount_id_po[' + si + '][amount]').value = document.getElementById('tonne_id_po[' + si + '][tonne]').value * document.getElementById('rate_id_po[' + si + '][rate]').value;
                    var amt = Number(document.getElementById('amount_id_po[' + si + '][amount]').value);
                    var camt = Number(document.getElementById('cgst_id_po[' + si + '][cgstrate]').value);
                    var samt = Number(document.getElementById('sgst_id_po[' + si + '][sgstrate]').value);
                    var iamt = Number(document.getElementById('igst_id_po[' + si + '][igstrate]').value)
                    var total = amt + camt + samt + iamt;
                    // var t_camt= amt * (camt/100);
                    // var t_samt=  amt * (samt/100);
                    // var t_iamt=  amt * (iamt/100);
                    // var total = amt+t_camt+t_samt+t_iamt;
                    total = total.toFixed(2);

                    document.getElementById('total_id_po[' + si + '][total]').value = total;
                } else {
                    document.getElementById('amount_id_po[' + si + '][amount]').value = "";
                    var amt = Number(document.getElementById('amount_id_po[' + si + '][amount]').value);
                    var camt = Number(document.getElementById('cgst_id_po[' + si + '][cgstrate]').value);
                    var samt = Number(document.getElementById('sgst_id_po[' + si + '][sgstrate]').value);
                    var iamt = Number(document.getElementById('igst_id_po[' + si + '][igstrate]').value);
                    var total = amt + camt + samt + iamt;
                    total = total.toFixed(2);

                    document.getElementById('total_id_po[' + si + '][total]').value = total;
                }
            }

            function cal_cgst(si) {
                if (document.getElementById('cgst_id_po[' + si + '][cgstrate]').value != "") {
                    var tamount = document.getElementById('amount_id_po[' + si + '][amount]').value / 100;
                    var cgstr = tamount * document.getElementById('cgst_id_po[' + si + '][cgstrate]').value;
                    cgstr = cgstr.toFixed(2);
                    document.getElementById('cgst_id_po[' + si + '][cgstrate]').value = cgstr;
                    var amt = Number(document.getElementById('amount_id_po[' + si + '][amount]').value);
                    var camt = Number(document.getElementById('cgst_id_po[' + si + '][cgstrate]').value);
                    var samt = Number(document.getElementById('sgst_id_po[' + si + '][sgstrate]').value);
                    var iamt = Number(document.getElementById('igst_id_po[' + si + '][igstrate]').value);
                    var total = amt + camt + samt + iamt;
                    total = total.toFixed(2);
                    document.getElementById('total_id_po[' + si + '][total]').value = total;
                } else {
                    document.getElementById('cgst_id_po[' + si + '][cgstrate]').value = "";
                    var amt = Number(document.getElementById('amount_id_po[' + si + '][amount]').value);
                    var camt = Number(document.getElementById('cgst_id_po[' + si + '][cgstrate]').value);
                    var samt = Number(document.getElementById('sgst_id_po[' + si + '][sgstrate]').value);
                    var iamt = Number(document.getElementById('igst_id_po[' + si + '][igstrate]').value);
                    var total = amt + camt + samt + iamt;
                    total = total.toFixed(2);
                    document.getElementById('total_id_po[' + si + '][total]').value = total;
                }
            }

            function cal_sgst(si) {
                if (document.getElementById('sgst_id_po[' + si + '][sgstrate]').value != "") {
                    var tamount = document.getElementById('amount_id_po[' + si + '][amount]').value / 100;
                    var sgstr = tamount * document.getElementById('sgst_id_po[' + si + '][sgstrate]').value;
                    sgstr = sgstr.toFixed(2);


                    var amt = Number(document.getElementById('amount_id_po[' + si + '][amount]').value);
                    var camt = Number(document.getElementById('cgst_id_po[' + si + '][cgstrate]').value);
                    var samt = Number(document.getElementById('sgst_id_po[' + si + '][sgstrate]').value);
                    var iamt = Number(document.getElementById('igst_id_po[' + si + '][igstrate]').value);
                    var total = amt + camt + samt + iamt;
                    total = total.toFixed(2);
                    document.getElementById('total_id_po[' + si + '][total]').value = total;

                } else {

                    var amt = Number(document.getElementById('amount_id_po[' + si + '][amount]').value);
                    var camt = Number(document.getElementById('cgst_id_po[' + si + '][cgstrate]').value);
                    var samt = Number(document.getElementById('sgst_id_po[' + si + '][sgstrate]').value);
                    var iamt = Number(document.getElementById('igst_id_po[' + si + '][igstrate]').value);
                    var total = amt + camt + samt + iamt;
                    total = total.toFixed(2);
                    document.getElementById('total_id_po[' + si + '][total]').value = total;
                }
            }

            function cal_igst(si) {
                if (document.getElementById('igst_id_po[' + si + '][igstrate]').value != "") {
                    var tamount = document.getElementById('amount_id_po[' + si + '][amount]').value / 100;
                    var igstr = tamount * document.getElementById('igst_id_po[' + si + '][igstrate]').value;
                    igstr = igstr.toFixed(2);

                    var amt = Number(document.getElementById('amount_id_po[' + si + '][amount]').value);
                    var camt = Number(document.getElementById('cgst_id_po[' + si + '][cgstrate]').value);
                    var samt = Number(document.getElementById('sgst_id_po[' + si + '][sgstrate]').value);
                    var iamt = Number(document.getElementById('igst_id_po[' + si + '][igstrate]').value);
                    var total = amt + camt + samt + iamt;
                    total = total.toFixed(2);
                    document.getElementById('total_id_po[' + si + '][total]').value = total;
                } else {

                    var amt = Number(document.getElementById('amount_id_po[' + si + '][amount]').value);
                    var camt = Number(document.getElementById('cgst_id_po[' + si + '][cgstrate]').value);
                    var samt = Number(document.getElementById('sgst_id_po[' + si + '][sgstrate]').value);
                    var iamt = Number(document.getElementById('igst_id_po[' + si + '][igstrate]').value);
                    var total = amt + camt + samt + iamt;
                    total = total.toFixed(2);
                    document.getElementById('total_id_po[' + si + '][total]').value = total;
                }
            }

            function cal_totalAll(si) {
                var count = Number(document.getElementById('counter').value);
                // alert(total);
                var totalAmt = 0;
                console.log(count - 1);
                for (i = 1; i <= (count - 1); i++) {
                    console.log(Number(totalAmt));
                    totalAmt = Number(totalAmt) + Number(document.getElementById('total_id_po[' + i + '][total]').value);
                    console.log(totalAmt);
                    document.getElementById('totalAll').value = totalAmt;

                }
                //document.getElementById('totalAll').value = total;   
            }



            $('#project').on('change', function(event) {
                $.ajax({
                    url: 'getinformationsproject.php',
                    type: 'POST',
                    data: {
                        "project": $(this).val()
                    },
                    success: function(result) {
                        $('#viewprojects').remove();
                        $('#projects').html('<div id="viewprojects" >' + result + '</div>');

                    }
                });
                event.preventDefault();
            });







            $('#billing_contact_person').on('change', function(event) {

                $.ajax({

                    url: 'getInformationbillingcontactDesignation.php',
                    type: 'POST',

                    data: {
                        "billing_contact_person": $(this).val()
                    },

                    success: function(result) {


                        // $('#viewdesignation').remove();
                        $('#contactPerson').html('<div id="viewdesignation" >' + result + '</div>');
                    }
                });
                event.preventDefault();
            });
        </script>

        <!-- Js Section End -->
    </body>

    </html>