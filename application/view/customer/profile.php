<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/customer-authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");
    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $defaultLogo = "../assets/dp/men-Icon.png";
    $randSix = $auth->randSix();
    $authority = 1;
   
    $profileDir = "../assets/customer/profile/";
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
                                 <form id="selectForm" method="POST" enctype="multipart/form-data" action="../application/controller/customer/profile.php">
                                  
                                    <!-- Main content -->
                                  <section class="content">
                                      <div class="container-fluid">
                                        <div class="row"> 
                                            <?php
                                                $databaseObj->select("tbl_customer");
                                                $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id`='".$auth->customer_id."'");
                                                $databaseObj->order_by("`customer_id` DESC");
                                                $getData = $databaseObj->get();

                                                if($getData != 0):
                                                //Checking If Data Is Available
                                                $sno = 1;
                                                    foreach($getData as $rows):
                                                        $customer_log_info = array_reverse(json_decode($rows["customer_log_info"]));
                                                         $customer_info = json_decode($rows["customer_info"]);
                                                         $customer_second_applicant= json_decode($rows["customer_info"]);


                                                ?>
                                                    <div class="col-md-3">

                                        <!-- Profile Image -->
                                             <div class="card card-primary card-outline">  
                                                  <div class="card-body box-profile">
                                                        <div class="text-center" id="dp">
                                                          
                                                              <?php 
                                                                if(empty($customer_info->dp) || $customer_info->dp == "men-Icon.png" || $customer_info->dp == "women-Icon.png"):
                                                                    ?>
                                                                    <a href="../assets/dp/<?= $customer_info->dp ?>" target="_blank"><img src="../assets/dp/<?= $customer_info->dp ?>" width="35px;" /></a>
                                                                    <?php
                                                                else:
                                                                    ?>
                                                                    <a href="../assets/dp/<?= $customer_info->dp ?>" target="_blank"><img src="../assets/dp/<?= $customer_info->dp ?>" width="35px;" /></a>
                                                                    <?php
                                                                endif;
                                                            ?>
                                                        
                                                         </div>
                                                        <h3 class="profile-username text-center" id="name"><?= $customer_info->name ?></h3>
                                                        <!-- <p class="text-muted text-center" id="nickName"><?= $customer_info->nickName ?></p> -->
                                                        <ul class="list-group list-group-unbordered mb-3">
                                                          <li class="list-group-item">
                                                            <b>Contact</b> <a class="float-right" id="phoneNumber"><?= $customer_info->phoneNumber ?></a>

                                                          </li> 
                                                          <li class="list-group-item">
                                                            <b>Date Of Birth </b> <a class="float-right" id="phoneNumber"><?= $customer_info->dob ?></a>

                                                          </li> 
                                                          <li class="list-group-item">
                                                            <b>Marital Status </b> <a class="float-right" id="phoneNumber"><?= $customer_info->maritalStatus ?></a>

                                                          </li> 
                                                          <li class="list-group-item">
                                                            <b>Date Of Anniversary </b> <a class="float-right" id="phoneNumber"><?= $customer_info->dateOfAnniversary ?></a>

                                                          </li> 

                                                          <li class="list-group-item">
                                                            <b>Religion</b> <a class="float-right"id="emailId"><?= $customer_info->religion ?></a>
                                                          </li>
                                                          <li class="list-group-item">
                                                            <b>Caste</b> <a class="float-right"id="emailId"><?= $customer_info->caste ?></a>
                                                          </li>
                                                          <li class="list-group-item">
                                                            <b>Residential Status</b> <a class="float-right"id="emailId"><?= $customer_info->residentialStatus ?></a>
                                                          </li>
                                                          <li class="list-group-item">
                                                            <b>Occupation</b> <a class="float-right"id="emailId"><?= $customer_info->occupation ?></a>
                                                          </li>
                                                           <li class="list-group-item">
                                                            <b>PAN NUMBER</b> <a class="float-right"id="emailId"><?= $customer_info->panNumber ?></a>
                                                          </li>
                                                          <li class="list-group-item">
                                                            <b>AADHAR NUMBER</b> <a class="float-right"id="emailId"><?= $customer_info->aadharNumber ?></a>
                                                          </li>
                                                          <li class="list-group-item">
                                                            <b>Gender </b> <a class="float-right"id="emailId"><?= $customer_info->gender ?></a>
                                                          </li>
                                                             <li class="list-group-item">
                                                            <b>Permanent Address </b> <a class="float-right"id="emailId"><?= $customer_info->permanentAddress ?></a>
                                                          </li>
                                                          <li class="list-group-item">
                                                            <b>Correspondence Address </b> <a class="float-right"id="emailId"><?= $customer_info->correspondenceAddress ?></a>
                                                          </li>
                                                          <button type="button" id="edit-button-<?= $rows["customer_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                                              <i class="fa fa-edit fa-sm"></i>
                                                              </button>
                                                        </ul>

                                                   </div>
                                                  <!-- /.card-body -->
                                                </div>
                                                <!-- /.card -->

                                                <!-- About Me Box -->
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                       <h3 class="card-title">Current Logged Location </h3>
                                                    </div>
                                                        <?php
                                                       foreach($customer_log_info as $customer_log_info_data):

                                                            $latLangArray = explode(",", $customer_log_info_data->logLocation);
                                                            $lat = explode(":", $latLangArray[0]);
                                                            $lang = explode(":", $latLangArray[1]);
                                                                   endforeach;

                                                                             ?>
                                                                            <iframe width="100%" height="300" src="https://maps.google.com/maps?q=<?= $lat[1] ?>,<?= $lang[1] ?>&output=embed"></iframe>

                                                </div>
                                                        <!-- /.card -->
                                                 </div>
                                                   <div class="col-md-9">
                                                      <div class="card">
                                                        <div class="card-header p-2">
                                                           <ul class="nav nav-pills">
                                                             <li class="nav-item"><a class="nav-link active" href="#logdetails" data-toggle="tab">Log Details</a></li>
                                                           </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                         <div class="tab-content">
                                                        <div class="active tab-pane" id="logdetails">
                                                        <!-- Post -->
                                                         <div class="post">
                                                            <div class="table-responsive">
                                                                <table id="example1" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>

                                                                            <th>S. No.</th>
                                                                            <th>Log Date</th>
                                                                            <th>Log Time</th>
                                                                            <th>Log Ip</th>
                                                                            <th>Log Location</th>
                                                                            <th>LogStatus</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php 


                                                           foreach($customer_log_info as $customer_log_info_data):


                                                            ?>
                                                                        <tr>

                                                                            <td><?= $sno ?>.</td>

                                                                            <td><?= $customer_log_info_data->logDate ?></td>
                                                                            <td><?= $customer_log_info_data->logTime ?></td>
                                                                            <td><?= $customer_log_info_data->logIp ?></td>
                                                                            <td><?= $customer_log_info_data->logLocation ?></td>

                                                                            <td>
                                                                                 <?php
                                                                                    if($customer_log_info_data->logStatus == "primary"):
                                                                                ?>
                                                                                <span  class="badge badge-success"> <?php  echo "Logged In";  ?></span>

                                                                                <?php
                                                                                    else:

                                                                                ?>

                                                                               <span  class="badge badge-danger"> <?php echo "Logged Out";  ?></span></td>      
                                                                                <?php 
                                                                                    endif;
                                                                                ?>
                                                                                <?php 
                                                                                $sno++;
                                                                             endforeach; ?>
                                                                                </tr>

                                                    <script>

                                                    // Edit Section Start ---------------------------------------------------------------
                                                    $("#edit-button-<?= $rows["customer_id"] ?>").click(function () {
                                                        $("#edit-modal").modal('show');
                                                        $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "../assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                        var formData = {"action":"fetchEdit","id":"<?= $rows["customer_id"] ?>"};
                                                        $.ajax({
                                                            url: '../application/view/customer/profile.php',
                                                            type: 'POST',
                                                            data: formData,
                                                            success: function (data) {
                                                                $('#edit-loading').fadeOut(500, function () {
                                                                    $(this).remove();
                                                                    $('#edit-section').html(data);
                                                                });
                                                            }
                                                        });
                                                    });
                                                    // Edit Section End -----------------------------------------------------------------

                                                        </script>
                                                                        
                                                        </tbody>
                                                                    <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>

                                                            </tr>
                                                        </tfoot>

                                                    </table>
<!--                                                </div> -->
                                                     <!-- table responsive  -->
                                <!--                                                            </div> /.post     -->
                                            </div><!-- /.tab-pane -->
                                        </div> <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div> <!-- /.nav-tabs-custom -->
                                </div> <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                      </div><!-- /.container-fluid -->
                                               <?php 
                                                endforeach;
                                                   $sno++;
                                                    endif;
                                               ?>
                                        </div>
                                          
                                      </div>      
                                      
                                </section>
                               </form>
                       
                    <script>
                        $('#add-button').prop('disabled', false);
                        $('#import-button').prop('disabled', false);
                    </script>
                    <script src="../dist/js/customer/for-all-tables.js"></script>
                <?php
                break;
                                                       
                


            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            // ------------------------------------------------------
           // ------------------------------------------------------
            // ------------ Fetch Edit Section Start ----------------
            // ------------------------------------------------------
            case "fetchEdit":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_customer");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `customer_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $customer_info = json_decode($rows["customer_info"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editdp">New Profile Picture </label>
                                                <input type="file" class="form-control" id="editdp" name="editdp" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editName">Name</label>
                                                <input type="text" class="form-control" id="editName" name="editName" placeholder="Name" value="<?= $customer_info->name ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editparentname">Parents Name</label>
                                                <input type="text" class="form-control" id="editparentname" name="editparentname" placeholder="Parent Name " value="<?= $customer_info->parentName ?>">
                                            </div>
                                        </div>
                                        
                                       
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editphoneNumber">Phone number</label>
                                                <input type="number" class="form-control" id="editphoneNumber" name="editphoneNumber" placeholder="Phone Number" value="<?= $customer_info->phoneNumber ?>">
                                            </div> -->
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editemailId">Email ID</label>
                                                <input type="email" class="form-control" id="editemailId" name="editemailId" placeholder="Email Id" value="<?= $customer_info->emailId ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editgender">Gender</label>
                                                <input type="text" class="form-control" id="editgender" name="editgender" placeholder="Gender" value="<?= $customer_info->gender ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editpermanentaddress">Permanent Address</label>
                                                <input type="text" class="form-control" id="editpermanentaddress" name="editpermanentaddress" placeholder="Permanent  Address" value="<?= $customer_info->permanentAddress ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editcorrespondenceaddress">Correspondence Address</label>
                                                <input type="text" class="form-control" id="editcorrespondenceaddress" name="editcorrespondenceaddress" placeholder="Adress" value="<?= $customer_info->correspondenceAddress ?>">
                                            </div>
                                        </div>
                                        
                                        
                                        <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                    </div>
                                <?php
//                             $sno++;
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
                    else:
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error Occurred!</h5>
                            Something went wrong plase try again or refresh.
                        </div>
                        <?php
                    endif;
                else:
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
                        
                        
                        
                      
                  
                 
                 
                  
    

                  
                
             
            
         
       
     
    
                        
                        
                       