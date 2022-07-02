<?php
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");
    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $defaultLogo = "assets/dp/default.png";
    $randSix = $auth->randSix();
    $authority = 1;
    $manageItemStoreDir = "../../../assets/admin/manage-items/";
    $manageItemDir = "assets/admin/manage-items/";
    if(isset($_POST["action"])):

        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Fetch Data Section Start ---------
            // -----------------------------------------------
            case "fetchData":
                $databaseObj->select("tbl_manage_po");
                $databaseObj->where("`order_status` = 'pending'");
                $receipt_result = $databaseObj->get();

               $databaseObj->select("tbl_manage_po");
                $order_result = $databaseObj->get();

            ?>
                
                
                

                
                    <div class="page-content">
                        <!-- Panel Mode Switch -->
                        <div class="panel">
                            <!--
                         <header class="panel-heading">
                           <h3 class="panel-title">GOODS RECEIPT NOTE (GRN)</h3>
                         </header>
                    -->
                            <div class="panel-body">
                                <form class="" enctype="multipart/form-data" action="" id="inv_orders" name="inv_orders" method="post">
                                                 

                                               <div class="row">
                                                 <div class="col-md-4">
                                                <div class="form-group">
                                                <label>From:</label>

                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                                </span>
                                                </div>
                                                <input type="date" name="from" class="form-control float-right" id="from">
                                                </div>
                                                <!-- /.input group -->
                                                </div>

                                            </div>


                                             <div class="col-md-4">
                                                <div class="form-group">
                                                <label>To:</label>

                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                                </span>
                                                </div>
                                                <input type="date" name="to" class="form-control float-right" id="to">
                                                </div>
                                                <!-- /.input group -->
                                                </div>
                                            </div>




                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>Report Type:</label>

                                                <div class="input-group">
                                                     <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                <i class="far fa-save"></i>
                                                </span>
                                                </div>
                                               <select name="report_type" id="report_type" class="form-control" onchange="myFunction(this.value)">
                                                <option value="">Select Report Type</option>
                                                 <option value="Purchase Order">Purchase Order</option>
                                                  <option value="Goods Issue">Goods Issue</option>
                                                  <!--  <option value="Goods Receipt">Goods Receipt</option> -->

                                               </select>
                                                
                                                </div>
                                                <!-- /.input group -->
                                                </div>
                                            </div>

                                              <div class="col-md-4">
                                                <div class="form-group">
                                               

                                                <div class="input-group">


                                                    <div id="purchase_order" style="display:none;">
                                                         <label>Order status</label>
                                                    <select class="form-control" name="order_status" id="order_status">
                                                    <option value="">All</option>
                                                    <option value="pending">pending</option>
                                                    <option value="complete">complete</option>
                                                    </select>
                                                    </div>
                                                </div>
                                               </div>
                                              </div>  
                                            <div class="col-md-4">
                                                <div class="form-group">
                                               

                                                <div class="input-group">
                                                    <div id="goods_issue" style="display:none;">
                                                    <label for="issue_status">Issue Status</label>
                                                    <select class="form-control" name="issue_status" style="" id="issue_status">
                                                    <option value="">all</option>
                                                    <option value="">Issued</option>
                                                    <!-- <option value="partial returned">partial returned</option> -->
                                                    <option value="returned">returned</option>
                                                    </select>
                                                    </div>
                                                </div>
                                               </div>
                                            </div>    
                                             <div class="col-md-4">
                                                <div class="form-group">    
                                                 <div id="project" style="display:none;">
                                           
                                                <label for="project_select">Project Name</label>
                                                <select id="project_select" name="project_select" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="display:none;">
                                                  <option value="All">All</option>
                                                <?php 
                                                    $databaseObj->select("tbl_projects");
                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                    $getData = $databaseObj->get();
                                                    //Checking If Data Is Available
                                                    if($getData != 0):
                                                    $sno = 1;
                                                    foreach($getData as $rows):
                                                    $projects_info = json_decode($rows["projects_info"]);
                                                    ?>
                                                  
                                                    <option value="<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?></option>
                                                    <?php
                                                    endforeach;
                                                    endif;
                                                ?>
                                                </select>
                                            
                                            </div>
                                        </div>
                                    </div>
                                            
                                          <div class="col-md-4">
                                                <div class="form-group">    

                                          <div id="goods_receipt" style="display:none;">
                                            <select class="form-control" name="receipt_status" style="" id="receipt_status">
                                            <option value="paid">Paid</option>
                                           <!--  <option value="partial returned">partial returned</option>
                                            <option value="returned">returned</option> -->
                                            </select>
                                            </div> 

                                        </div>
                                    </div>
                               



                                             <div class="col-md-4">
                                                <div class="form-group">
                                                <label></label>

                                                <div class="input-group">
                                               
                                                <input type="button" name="submit" id="search" value="Search" class="btn btn-lg btn-success" id="">
                                                </div>
                                                <!-- /.input group -->
                                                </div>
                                            </div>
                                            </div>
                                            </form>
                                          
                            </div>
                        </div>
                        <!-- End Panel Mode Switch -->
                        <div id="main-section"></div>
                        <div id="loader_section"></div>

                    </div>
               
                <script>
                    function myFunction(value) {
                      if (value == "Purchase Order") {
                        document.getElementById("goods_issue").style.display = "none";
                        document.getElementById("goods_receipt").style.display = "none";
                        document.getElementById("purchase_order").style.display = "block";
                         document.getElementById("project").style.display = "none";
                      }
                      else if (value == "Goods Issue") {
                        document.getElementById("purchase_order").style.display = "none";
                        document.getElementById("goods_receipt").style.display = "none";
                        document.getElementById("goods_issue").style.display = "block";
                        document.getElementById("project").style.display = "block";
                      }
                      // else if (value == "Goods Receipt") {
                      //   document.getElementById("purchase_order").style.display = "none";
                      //   document.getElementById("goods_issue").style.display = "none";
                      //   document.getElementById("goods_receipt").style.display = "block";
                      // }
                      else {
                        document.getElementById("purchase_order").style.display = "none";
                        document.getElementById("goods_issue").style.display = "none";
                        document.getElementById("goods_receipt").style.display = "block";
                      }
                    }
                   

                    //Date range picker
                    $('#fromTo').daterangepicker()
                    //Date range picker with time picker
                    $('#reservationtime').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    locale: {
                    format: 'DD/MM/YYYY hh:mm A'
                    }
                    })


                    $('#search').click(function() {
                        $('#loader_section').append('<center id = "loading"><br /><br /><img width="100px" src = "assets/loader/pre-loader.gif" alt="Loading..." /><p id="connectionError"></p><br/></center>');

                        var action = document.getElementById('report_type').value;
                        if (action == "Purchase Order") {
                        var invstatus = document.getElementById('order_status').value;
                        }
                        // else if(action == "Goods Receipt"){
                        // var invstatus = "complete";
                        // }
                        else if (action == "Goods Issue") {
                        var invstatus = document.getElementById('issue_status').value;
                        var project = document.getElementById('project_select').value;
                        }
                        //else if (action == "Repairable Items") {
                       // var status = document.getElementById('repair_status').value;
                       // }

                        else {
                        var invstatus = "";
                        }


                        //var action = "invOrders";
                        //var dataString = 'action=' + action;
                        var from = document.getElementById('from').value;
                        var to = document.getElementById('to').value;

                        $.ajax({
                            url: 'application/view/admin/view_inv_reports.php',
                            type: 'POST',
                            data: {
                                from: from,
                                to: to,
                                invstatus: invstatus,
                                action: action,
                                project: project,
                            },
                            success: function(result) {
                               
                              
                                $('#loading').fadeOut(500, function() {
                                    $(this).remove();
                                    $('#main-section').html('<div id = "response">' + result + '</div>');
                                });
                            }
                        });
                    });
                </script>
                <script src="dist/js/admin/for-all-tables.js"></script>
                <?php
                break;
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            default:
                ?>
                    <script>
                        const Toast = Swal.mixin({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 5000,
                          timerProgressBar: false,
                          onOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                          }
                        })
                        function topEndNotification(theme, message){
                            Toast.fire({
                              icon: theme,
                              title: message
                            })
                        }
                        topEndNotification("warning", "Something went wrong, please try again or refresh...");
                    </script>
                <?php
                break;
        endswitch;
    endif;
?>