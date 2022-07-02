<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/customer-authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");
    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $defaultLogo = "assets/dp/default.png";
    $randSix = $auth->randSix();
    $authority = 1;
    $manageCompanyStoreDir = "../../../assets/admin/projects/";
    $manageCompanyDir = "assets/admin/projects/";
    if(isset($_POST["action"])):
       
        // -----------------------------------
        // ------------ Switch Start ---------
        // -----------------------------------
        switch($_POST["action"]):
            // -----------------------------------------------
            // ------------ Fetch Data Section Start ---------
            // -----------------------------------------------
            case "fetchData":
                ?>
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="../application/admin/customer/dashboard.php">
                        
                      
                                              
                                        <div class="card">
                                          
                                             <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_customer">
                                                <input type="hidden" id="action" name="action" value="exportSelectedData">
                                                <table id="example1" class="table table-bordered table-striped">

                                                  
                                                  <tr>
                                                     <th>S.No.</th>
                                                    <th>Percentage Of Amount(%)</th>
                                                    <th>Amount(in Rs)</th>
                                                    <th>Remark</th>
                                                    <th>Paid(in Rs)</th>
                                                    <th>Paid Remark</th>
                                                    <th>Status</th>
                                                 </tr>
                                                
                                         <?php 
                       
                                        $databaseObj->select("tbl_customer");
                                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id`='".$auth->customer_id."'");
                                        $databaseObj->order_by("`customer_id` DESC");
                                        $getData = $databaseObj->get();

                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                                $customer_info = json_decode($rows["customer_info"]);
                                                $customer_log = json_decode($rows["customer_log"]);
                                                $customer_payment_info = json_decode($rows["customer_payment_info"]);
                                                $customer_payment_structure = json_decode($rows["customer_payment_structure"]);
                       
                                                        $noOfRows = 1;
                                                        $totalPer = 0.00;
                                                        $totalAmount = 0.00;
                                                        $totalPaid = 0.00;
                                                        foreach($customer_payment_structure as $customer_payment_structure_all):
                                                            $totalPer = $totalPer + floatval($customer_payment_structure_all->paymentStuctureCompletion);
                                                            $totalAmount = $totalAmount + floatval($customer_payment_structure_all->paymentStuctureAmount);
                                                            $totalPaid = $totalPaid + floatval($customer_payment_structure_all->paymentStucturePaid);
                                                     
                                                        
                        ?>          
                                    
                                                    <tr>
                                                     
                                                        <td><?= $sno ?>.</td>
                                                        <td><?= $customer_payment_structure_all->paymentStuctureCompletion ?></td>
                                                        <td><?= $customer_payment_structure_all->paymentStuctureAmount ?></td>
                                                        <td><?= $customer_payment_structure_all->paymentStuctureRemark ?></td>
                                                        
                                                        <td><?= $customer_payment_structure_all->paymentStucturePaid ?></td>
                                                        <td><?= $customer_payment_structure_all->paymentStucturePaidRemark ?></td>
                                                        
                                                        <td> <?php 
                                                                if(empty($customer_payment_structure_all->paymentStuctureStatus)):
                                                                    echo "<span class='badge badge-danger '>Not Paid</span>";
                                                                else:
                                                                    if($customer_payment_structure_all->paymentStuctureStatus == "paid"):
                                                                        echo "<span class='badge badge-info '>".ucwords($customer_payment_structure_all->paymentStuctureStatus)."</span>";
                                                                    else:  
                                                                        echo "<span class='badge badge-warning '>".ucwords($customer_payment_structure_all->paymentStuctureStatus)."</span>";
                                                                    endif;
                                                                endif;
                                                            ?></td>
                                                            <?php 
                                                            $sno++;
                                                            $noOfRows++;
                                                        endforeach;
                                                    ?>
                                                         </tr>
                                                    
                                                    <tr>
                                                        <th>Total</th>
                                                        <th>
                                                            <?php printf("%.2f", $totalPer) ?>
                                                        </th>
                                                        <th><?php printf("%.2f", $totalAmount) ?>
                                                            
                                                        </th>
                                                        <th></th>
                                                        <th><?php printf("%.2f", $totalPaid) ?>
                                                            
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    
                                                   
                                                
                                                    
                                              </table>
                                        </div>
                                   
                                <?php
                            endforeach;
                                                                           
                        else:
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                                Something went wrong plase try again or refresh.
                            </div>
                            <?php
                        endif;
                   
                    
                break;
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            
                                       
                                            //Toast Setting Section Start ------------------------------------------------------------------------------------------------------------------
                                            
            default:
                ?>
                    <script>
                         $(function(){
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
                         });
                    </script>
                <?php 
                break;
        endswitch;
    endif;
?>