<!-- Item Management -->
<?php
    $page_no = "4";
    $page_no_inside = "4_4";
?>
<?php require_once("include/auth.php");
    require_once("application/classes-and-objects/config.php");
    require_once("application/classes-and-objects/veriables.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Manage Indent</title>
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
                            <h1 class="m-0 text-dark">Manage Indent</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Indent List</li>
                            </ol>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="card card-navy card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-right">
                            <button id="refresh-button" type="button" class="refresh-button btn btn-sm btn-danger mt-1 mb-1" title="Refresh" disabled>
                                <i class="fas fa-sync-alt fa-sm"></i>
                            </button>
                            <button id="export-button" type="button" class="export-button btn btn-sm btn-warning display-none mt-1 mb-1" data-toggle="modal" data-target="#export-modal" title="Export" disabled>
                                <i class="fa fa-download fa-sm"></i> Export
                            </button>
                        </h3>
                    </div>
                    <div class="card-body table-responsive" id="view-section"></div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- Information Section Start -->
        <div class="modal fade" id="information-modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Information</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body" id="information-section"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Information Section End -->
        
        <!-- Edit Section Start -->
        <div class="modal fade" id="edit-modal">
            <div class="modal-dialog modal-xl">
                <form id="editForm" method="POST" enctype="multipart/form-data" style="width:1020px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit This</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body" id="edit-section"></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="editButton" class="edit-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
                
                <script>
                 function cal(si){
                   if(document.getElementById('tonne_id['+si+'][tonne]').value!="" && document.getElementById('rate_id['+si+'][rate]').value!=""){
                     document.getElementById('amount_id['+si+'][amount]').value = document.getElementById('tonne_id['+si+'][tonne]').value*document.getElementById('rate_id['+si+'][rate]').value;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('amount_id['+si+'][amount]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_cgst(si){
                   if(document.getElementById('cgst_id['+si+'][cgstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var cgstr = tamount*document.getElementById('cgst_id['+si+'][cgstrate]').value;
                     cgstr = cgstr.toFixed(2);
                     document.getElementById('cgstamt_id['+si+'][cgstamt]').value = cgstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('cgstamt_id['+si+'][cgstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_sgst(si){
                   if(document.getElementById('sgst_id['+si+'][sgstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var sgstr = tamount*document.getElementById('sgst_id['+si+'][sgstrate]').value;
                     sgstr = sgstr.toFixed(2);
                     document.getElementById('sgstamt_id['+si+'][sgstamt]').value = sgstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('sgstamt_id['+si+'][sgstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                 function cal_igst(si){
                   if(document.getElementById('igst_id['+si+'][igstrate]').value!=""){
                     var tamount = document.getElementById('amount_id['+si+'][amount]').value/100;
                     var igstr = tamount*document.getElementById('igst_id['+si+'][igstrate]').value;
                     igstr = igstr.toFixed(2);
                     document.getElementById('igstamt_id['+si+'][igstamt]').value = igstr;
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   } else{
                     document.getElementById('igstamt_id['+si+'][igstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgstamt_id['+si+'][cgstamt]').value);
                     var samt = Number(document.getElementById('sgstamt_id['+si+'][sgstamt]').value);
                     var iamt = Number(document.getElementById('igstamt_id['+si+'][igstamt]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id['+si+'][total]').value = total;
                   }
                 }
                    
                    
            
               </script>
               
    <script type="text/javascript">
    function mode(value){
      if(value == "Cash"){
        document.getElementById("mode").style.display = "none";
      }
      else{
        document.getElementById("mode").style.display = "block";
      }
    }
   </script>
                <script>
                   function getGst(){
                       var gstin_value = String(document.getElementById('stateCode').value);
                       //var gstin_value = "Hello";
                       var state_code = gstin_value.charAt(0)+gstin_value.charAt(1);
                       //alert(state_code);
                       if(state_code == "20"){
                           var tObj = document.getElementsByClassName('iGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='0';

                           }
                           var tObj = document.getElementsByClassName('cGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='9';

                           }
                           var tObj = document.getElementsByClassName('sGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='9';

                           }
                       } else{
                           var tObj = document.getElementsByClassName('iGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='18';

                           }
                           var tObj = document.getElementsByClassName('cGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='0';

                           }
                           var tObj = document.getElementsByClassName('sGstValue');
                           for(var i = 0; i < tObj.length; i++){
                               tObj[i].value='0';

                           }
                       }
                   }
               </script>
            </div>
        </div>
        <!-- Edit Section End -->
        
        
         <!-- Delete Section Start -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-sm">
                <form id="deleteForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="delete-section"></div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="deleteButton" class="delete-button btn btn-warning btn-sm"><i class="fas fa-trash fa-sm"></i> Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Delete Section End -->
        <!-- Add Payment Section Start -->
<!--
        <div class="modal fade" id="payment-modal">
            <div class="modal-dialog modal-lg">
                <form id="paymentForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Payment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body" id="payment-section"></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="payButton" class="pay-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i>Add Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
-->
        <!-- Add Payment Section End -->
        <!-- Export Selected Section Start -->
        <div class="modal fade" id="export-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Are you sure?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning alert-dismissible">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Confirm!</h5>
                            Do you really wanna Export selected data in excel???
                        </div>
                        <div id="export-section"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                        <button type="submit" id="exportSelectedButton" class="export-button btn btn-info btn-sm"><i class="fas fa-download fa-sm"></i> Export Selected</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Export Selected Section End -->


 <!-- view Payment Status Section Start -->
        <div class="modal fade" id="see-modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Indent</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body" id="see-section"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- view Payment Status Section END -->
        <!-- view Payment Status Section Start -->
        <div class="modal fade" id="print-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Indent</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body" id="print-section"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- view Payment Status Section END -->





        
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

    <script src="dist/js/ajax.js"></script>
    <script src="dist/js/admin/receive-indent.js"></script>
    
    
    <?php
        if(isset($_GET["response"])):
            if($_GET["response"] == "success"):
                echo "<script>
                        setTimeout(function(){
                            topEndNotification('success', 'Item Ordered successfully!!!');
                        }, 3000);
                      </script>";
            endif;
        endif;
    ?>
    <!-- Js Section End -->
</body>

</html>