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
$servicesStoreDir = "../../../assets/admin/services/";
$servicesDir = "assets/admin/services/";
if (isset($_POST["action"])) :
    // -----------------------------------
    // ------------ Switch Start ---------
    // -----------------------------------
    switch ($_POST["action"]):
            // -----------------------------------------------
            // ------------ Fetch Data Section Start ---------
            // -----------------------------------------------
        case "fetchData":
?>
            <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/loan_application.php">
                <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_loan_application">
                <input type="hidden" id="action" name="action" value="exportSelectedData">
                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Loan Type</th>
                             <th>Loan Amount</th>
                            <th>Loan Date</th>
                            <th>Status</th>
                            <th>Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_id = $auth->employee_id;
                        //echo $user_id;
                        //$getData = '';
                            $databaseObj->select("tbl_loan_application");
                            $databaseObj->where("`emp_id` = '$user_id'");
                            $databaseObj->order_by("`loan_id` DESC");
                            $getData = $databaseObj->get();
                       
                        //Checking If Data Is Available
                        if ($getData != 0) :
                            $sno = 1;
                            foreach ($getData as $rows) :
                              
                        ?>
                                <tr>
                                   
                                    <td><?= $sno ?>.</td>
                                    <td><?= $rows["emp_name"] ?></td>
                                    <td><?= $rows["loan_type"] ?></td>
                                    <td><?= $rows["loan_amount"] ?></td>
                                    <td><?= $rows["loan_date"] ?></td>
                                    <td><?= $rows["loan_status"] ?></td>
                                 
                                    <td class="text-center">
                                       
                                       
                                        <button type="button" id="edit-button-<?= $rows["loan_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                            <i class="fa fa-edit fa-sm"></i>
                                        </button>
                                       
                                    </td>
                                </tr>
                                <script>
                                
                                
                                    // Edit Section Start ---------------------------------------------------------------
                                    $("#edit-button-<?= $rows["loan_id"] ?>").click(function() {
                                        $("#edit-modal").modal('show');
                                        $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                        var formData = {
                                            "action": "fetchEdit",
                                            "id": "<?= $rows["loan_id"] ?>"
                                        };
                                        $.ajax({
                                            url: 'application/view/admin/loan_application.php',
                                            type: 'POST',
                                            data: formData,
                                            success: function(data) {
                                                $('#edit-loading').fadeOut(500, function() {
                                                    $(this).remove();
                                                    $('#edit-section').html(data);
                                                });
                                            }
                                        });
                                    });
                                    // Edit Section End -----------------------------------------------------------------
                                  
                                </script>
                        <?php
                                $sno++;
                            endforeach;
                        endif;
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>

                </table>
            </form>
            <script>
                $('#add-button').prop('disabled', false);
                $('#import-button').prop('disabled', false);
            </script>
            <script src="dist/js/admin/for-all-tables.js"></script>
            <?php
            break;
            // ------------ Fetch Data Section End -----------
          
       
            // ------------ Fetch See Section Start -----------------
        case "fetchSee":
            if ($authority == 1) :
                if (isset($_POST["id"]) && !empty($_POST["id"])) :
                    $databaseObj->select("tbl_leave_application");
                    $databaseObj->where("`emp_id` = '" . $_POST["id"] . "'");
                    $getData = $databaseObj->get();
                    //Checking If Data Is Available
                    if ($getData != 0) :
                        foreach ($getData as $rows) :
                           // $services_info = json_decode($rows["services_info"]);
                ?>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="callout callout-danger">
                                        <h5 class="text-bold">Leave Type</h5>
                                        <?//= $services_info->servicesName ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="callout callout-danger">
                                        <h5 class="text-bold">Leave Date</h5>
                                        <?//= $services_info->renewalservicesType ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="callout callout-danger">
                                        <h5 class="text-bold">No Of Days </h5>
                                        <?//= $services_info->daterenewalServices ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="callout callout-danger">
                                        <h5 class="text-bold">Reason</h5>
                                        <?//= $services_info->pricesofService ?>
                                    </div>
                                </div>




                            </div>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                    <?php
                    endif;
                else :
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                        Something went wrong plase try again or refresh.
                    </div>
                <?php
                endif;
            else :
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                    You have no permission to see the information of this Data.
                </div>
                <?php
            endif;
            break;
            // ------------------------------------------------------
            // ------------ Fetch See Section End -------------------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Edit Section Start ----------------
            // ------------------------------------------------------
        case "fetchEdit":
            if ($authority == 1) :
                if (isset($_POST["id"]) && !empty($_POST["id"])) :
                    $databaseObj->select("tbl_loan_application");
                    $databaseObj->where("`loan_id` = '".$_POST["id"]."'");
                    $getData = $databaseObj->get();

                 //Checking If Data Is Available
                    if ($getData != 0) :
                        foreach ($getData as $rows) :
                ?>
                            <div class="row">

                                 <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="renewalservicesType">Loan Type </label>
                                         <input type="text" class="form-control" id="loanType" name="loanType" placeholder="" value="<?= $rows['loan_type'] ?>">

                                                 
                                            </div>
                                        </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="editdaterenewalServices">Loan Date</label>
                                         <input type="date" class="form-control" id="daterenewalServices" name="loanDate" placeholder="" value="<?= $rows['loan_date'] ?>">
                                        
                                    </div>
                                </div>
                              
                              
                                   <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="editdaterenewalServices">Loan Amount</label>
                                         <input type="text" class="form-control" id="daterenewalServices" name="loanAmount" placeholder="" value="<?= $rows['loan_amount'] ?>">
                                        
                                    </div>
                                </div>


                                <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                            </div>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                    <?php
                    endif;
                else :
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                        Something went wrong plase try again or refresh.
                    </div>
                <?php
                endif;
            else :
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Restriction!</h5>
                    You have no permission to see the information of this Data.
                </div>
                <?php
            endif;
            break;
            // ------------------------------------------------------
            // ------------ Fetch Edit Section End ------------------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
      
            // ------------------------------------------------------
            // ------------ Fetch Information Section End -----------
            // ------------------------------------------------------
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

                function topEndNotification(theme, message) {
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