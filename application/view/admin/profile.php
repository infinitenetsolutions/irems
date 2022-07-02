<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");
    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $defaultLogo = "assets/dp/men-Icon.png";
    $randSix = $auth->randSix();
    $authority = 1;
   
    $profileDir = "assets/dp/";
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
                                 <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/profile.php">
                                  
                                    <!-- Main content -->
                                  <section class="content">
                                      <div class="container-fluid">
                                        <div class="row"> 
                                            <?php
                                                $databaseObj->select("tbl_admin");
                                                $databaseObj->where("`status` = '".$auth->visible()."'");
                                                $databaseObj->order_by("`admin_id` DESC");
                                                $getData = $databaseObj->get();

                                                //Checking If Data Is Available
                                                if($getData != 0):
                                                $sno = 1;
                                                    foreach($getData as $rows):
                                                        $admin_log_info = array_reverse(json_decode($rows["admin_log_info"]));
                                                         $admin_info = json_decode($rows["admin_info"]);


                                                ?>
                                                    <div class="col-md-3">

                                        <!-- Profile Image -->
                                             <div class="card card-primary card-outline">  
                                                  <div class="card-body box-profile">
                                                        <div class="text-center" id="dp">
                                                          
                                                              <?php 
                                                                if(empty($admin_info->dp) || $admin_info->dp == "men-Icon.png" || $admin_info->dp == "women-Icon.png"):
                                                                    ?>
                                                                    <a href="assets/dp/profile/<?= $admin_info->dp ?>" target="_blank"><img src="assets/dp/profile/<?= $admin_info->dp ?>" width="35px;" /></a>
                                                                    <?php
                                                                else:
                                                                    ?>
                                                                    <a href="assets/dp/profile/<?= $admin_info->dp ?>" target="_blank"><img src="assets/dp/profile/<?= $admin_info->dp ?>" width="35px;" /></a>
                                                                    <?php
                                                                endif;
                                                            ?>
                                                        
                                                         </div>
                                                        <h3 class="profile-username text-center" id="name"><?= $admin_info->name ?></h3>
                                                        <p class="text-muted text-center" id="nickName"><?= $admin_info->nickName ?></p>
                                                        <ul class="list-group list-group-unbordered mb-3">
                                                          <li class="list-group-item">
                                                            <b>Contact</b> <a class="float-right" id="phoneNumber"><?= $admin_info->phoneNumber ?></a>

                                                          </li> 
                                                          <li class="list-group-item">
                                                            <b>Email Id </b> <a class="float-right"id="emailId"><?= $admin_info->emailId ?></a>
                                                          </li>
                                                          <li class="list-group-item">
                                                            <b>Gender </b> <a class="float-right"id="emailId"><?= $admin_info->gender ?></a>
                                                          </li>
                                                             <li class="list-group-item">
                                                            <b>Address </b> <a class="float-right"id="emailId"><?= $admin_info->address ?></a>
                                                          </li>
                                                          <button type="button" id="edit-button-<?= $rows["admin_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
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
                                                       foreach($admin_log_info as $admin_log_info_data):

                                                            $latLangArray = explode(",", $admin_log_info_data->logLocation);
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


                                                           foreach($admin_log_info as $admin_log_info_data):


                                                            ?>
                                                                        <tr>

                                                                            <td><?= $sno ?>.</td>

                                                                            <td><?= $admin_log_info_data->logDate ?></td>
                                                                            <td><?= $admin_log_info_data->logTime ?></td>
                                                                            <td><?= $admin_log_info_data->logIp ?></td>
                                                                            <td><?= $admin_log_info_data->logLocation ?></td>

                                                                            <td>
                                                                                 <?php
                                                                                    if($admin_log_info_data->logStatus == "primary"):
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
                                                    $("#edit-button-<?= $rows["admin_id"] ?>").click(function () {
                                                        $("#edit-modal").modal('show');
                                                        $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                        var formData = {"action":"fetchEdit","id":"<?= $rows["admin_id"] ?>"};
                                                        $.ajax({
                                                            url: 'application/view/admin/profile.php',
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
                    <script src="dist/js/admin/for-all-tables.js"></script>
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
                        $databaseObj->select("tbl_admin");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $admin_info = json_decode($rows["admin_info"]);
                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editdp">New Logo</label>
                                                <input type="file" class="form-control" id="editdp" name="editdp" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editfirmName">Firm Name</label>
                                                <input type="text" class="form-control" id="editfirmName" name="editfirmName" placeholder="Firm  Name" value="<?= $admin_info->firmName ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editname">Name</label>
                                                <input type="text" class="form-control" id="editname" name="editname" placeholder="Nmae" value="<?= $admin_info->name ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editnickName">Nick Name</label>
                                                <input type="text" class="form-control" id="editnickName" name="editnickName" placeholder="Email" value="<?= $admin_info->nickName ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editphoneNumber">Phone number</label>
                                                <input type="number" class="form-control" id="editphoneNumber" name="editphoneNumber" placeholder="Phone Number" value="<?= $admin_info->phoneNumber ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editemailId">Email ID</label>
                                                <input type="email" class="form-control" id="editemailId" name="editemailId" placeholder="Email Id" value="<?= $admin_info->emailId ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editemailId">Gender</label>
                                                <input type="text" class="form-control" id="editgender" name="editgender" placeholder="Gender" value="<?= $admin_info->gender ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editemailId">Address</label>
                                                <input type="text" class="form-control" id="editaddress" name="editaddress" placeholder="Adress" value="<?= $admin_info->address ?>">
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
                        
                        
                        
                      
                  
                 
                 
                  
    

                  
                
             
            
         
       
     
    
                        
                        
                       