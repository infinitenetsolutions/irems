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
                                <form class="" enctype="multipart/form-data" action="application/controller/admin/goods-receipt.php" id="inv_orders" name="inv_orders" method="post">
                                    <!--       <input type="hidden" id="action" name="action" value="addPO">-->


                                    <table class="tablesaw table-striped" data-tablesaw-mode="swipe" data-tablesaw-mode-switch data-tablesaw-minimap>
                                        <thead>
                                            <tr>
                                                <th>GRN Number&nbsp;</th>
                                                <th>&nbsp;:&nbsp;</th>
                                                <?php
                                                     $grn_no = 0;
                                                     foreach ($order_result as $row) {
                                                       if($row['rec_note_no'] > $grn_no){
                                                       $grn_no = $row['rec_note_no'];
                                                       }
                                                     }  
                                                  ?>
                                                <th>&nbsp;<?php $grn_no++; echo $grn_no; ?></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th>Order No.&nbsp;</th>
                                                <th>&nbsp;:&nbsp;</th>
                                                <th>
                                                <?php
                                                $databaseObj->select("tbl_admin");
                                                $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id`='".$auth->admin_id."'");
                                                $databaseObj->order_by("`admin_id` DESC");
                                                $getData = $databaseObj->get(); 
                                                //Checking If Data Is Available
                                                if($getData != 0):
                                                    foreach($getData as $rowsadmin):
                                                        $admin_info = json_decode($rowsadmin["admin_info"]);
                                                        $databaseObj->select("tbl_manage_employee");
                                                        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_employee_id`='".$admin_info->empId."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $rowsemployee):
                                                                $manage_employee_info = json_decode($rowsemployee["manage_employee_info"]);
                                                            endforeach;
                                                        endif;
                                                    endforeach;
                                                endif;  ?>
                                                    <input type="hidden" id="grn_no" name="grn_no" value="<?php echo $grn_no; ?>">
                                                    <select class="form-control" name="rec_note_no" id="goods_receipt">
                                                     <option value="">Select Order No</option> 
                                               <?php 
                                                 $databaseObj->select("tbl_manage_po");
                                                 $databaseObj->where("`status` = '".$auth->visible()."' && `order_status` = 'pending'");
                                                 $getData = $databaseObj->get();
                                                 //Checking If Data Is Available
                                                 if($getData != 0):
                                                 $sno = 1;
                                                 foreach($getData as $rows):
                                                 $manage_po_info = json_decode($rows["manage_po_info"]);
                                                 if($manage_po_info->project == $manage_employee_info->project){
                                                 ?>
                                                 <option value="<?= $rows["manage_po_id"] ?>"><?= $rows["manage_po_id"] ?></option>
                                                  <?php 
                                                 	}else
                                                  {if($rowsemployee["manage_employee_id"] =="112" ){
                                                 ?>
                                                 <option value="<?= $rows["manage_po_id"] ?>"><?= $rows["manage_po_id"] ?></option>
                                                 <?php }
                                                 } 
                                                 endforeach;
                                                 endif;
												?>     
                                                       
                                                    </select>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <!-- End Panel Mode Switch -->
                        <div id="main-section"></div>
                        <div id="loader_section"></div>

                    </div>
               
                <script>
                    $('#goods_receipt').change(function() {
                        $('#loader_section').append('<center id = "loading"><br /><br /><img width="100px" src = "assets/loader/pre-loader.gif" alt="Loading..." /><p id="connectionError"></p><br/></center>');
                        var action = "goodsReceipt";
                        var dataString = 'action=' + action;
                        var order_no = document.getElementById('goods_receipt').value;
                        var receipt_no = document.getElementById('grn_no').value;
                        $.ajax({
                            url: 'application/view/admin/view_orders.php',
                            type: 'POST',
                            data: {
                                order_no: order_no,
                                receipt_no: receipt_no,
                                action: action
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