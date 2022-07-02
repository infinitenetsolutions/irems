<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");

    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $defaultLogo = "assets/dp/default.png";
    $default_bg_image = "assets/bg/index-bg.png";
    $randSix = $auth->randSix();
    $authority = 1;
    $settingbgimageStoreDir = "assets/bg/";
    $settingbgimageDir = "../../../assets/bg/";
    $settingStoreDir = "../../../assets/admin/setting/";
    $settingDir = "assets/admin/setting/";
    
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
                       
                           <section class="content">
                                <div class="container-fluid">
                                   <div class="row">
                                      <!-- left column -->
                                      <div class="col-md-6">
                                        <!-- general form elements -->
                                           <div class="card card-primary">
                                              <div class="card-header">
                                                 <h3 class="card-title"> About Software</h3>
                                               </div>
                                               <!-- /.card-header -->
                                                   <?php 
                                                        $databaseObj->select("tbl_setting");
                                                        $databaseObj->order_by("`setting_id` DESC");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                           $sno = 1;
                                                          foreach($getData as $rows):
                                                                $setting_soft_info = json_decode($rows["setting_soft_info"]);
                                                                $setting_firm_info = json_decode($rows["setting_firm_info"]);
                                                                $setting_theme_info = json_decode($rows["setting_theme_info"]);
                                                                $setting_payment_info = json_decode($rows["setting_payment_info"]);
                                                               
                                                    ?>
                                                    <!-- form start -->
                                                           <form role="form">
                                                             <div class="card-body">
                                                              <div class="form-group">
                                                                 <input type="hidden" class="form-control"  value="<?= $setting_soft_info->uniqe_id ?>" placeholder="Enter software id">
                                                              </div>

                                                                <ul class="list-group list-group-unbordered mb-3">
                                                                 <li class="list-group-item">
                                                                   <b>Purchaser</b> <a class="float-right"><?= $setting_soft_info->purchaser ?></a>
                                                                 </li>
                                                                 <li class="list-group-item">
                                                                    <b>Purchased Date </b> <a class="float-right"><?= $setting_soft_info->purchased_date ?></a>
                                                                 </li>
                                                                 <li class="list-group-item">
                                                                    <b>Purchased Price </b> <a class="float-right"><?= $setting_soft_info->purchased_price ?> INR</a>
                                                                 </li>
                                                                 <li class="list-group-item">
                                                                     <b>Domain </b> <a class="float-right"><?= $setting_soft_info->domain ?></a>
                                                                 </li> 
                                                                 <li class="list-group-item">
                                                                       
                                                                    <div class="table-responsive">
                                                                         <table id="example7" class="table ">
                                                                          <tr>  
                                                                             <th></th>
                                                                             <th></th>
                                                                             <th></th>
                                                                             <th></th>
                                                                             <th></th>
                                                                             <th></th>
                                                                             <th></th>
                                                                             <th>Mail/ Message Status</th>
                                                                             <th></th>
                                                                             <th>Purchased Status</th>
                                                                         </tr>
                                                                         <tr>
                                                                            <td><b>Mail Services</b></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td class="text-center">
                                                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                                      <input type="checkbox" class="custom-control-input" id="mailServiceStatus" name="mailServiceStatus" <?php if($setting_soft_info->mail_status == "on") echo "checked";  ?> <?php if($setting_soft_info->mail_service == "not purchased") echo "disabled";  ?>>
                                                                                      <label class="custom-control-label" for="mailServiceStatus" id="forMailServiceStatus"><?php if($setting_soft_info->mail_status == "on") echo "ON"; else echo "OFF";  ?></label>
                                                                                </div>
                                                                                
                                                                            </td>
                                                                            <td></td>
                                                                            <td><?php
                                                                                if($setting_soft_info->mail_status=="on"):
                                                                                $setting_soft_info->mail_service = "purchased";
                                                                            ?>
                                                                                <span  class="badge badge-success" id ="displaymailservices"> <?php  echo "Thanks for availing the mail services  ";  ?></span>
                                                               
                                                                            <?php
                                                                                else:
                                                                                $setting_soft_info->mail_service ==  "not purchased";
                                                                            ?>
                                                        
                                                                           <span  class="badge badge-danger"> <?php echo "Sorry , You have not availed the mail service";  ?></span>     
                                                                            <?php 
                                                                                endif;
                                                                            ?></td>
                                                                            
                                                                        </tr>
                                                                         <tr>
                                                                            <td><b>Message  Services</b></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td class="text-center">
                                                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                                      <input type="checkbox" class="custom-control-input" id="messageServiceStatus" name="messageServiceStatus" <?php if($setting_soft_info->message_status == "on") echo "checked";  ?> <?php if($setting_soft_info->message_service == "not purchased") echo "disabled";  ?>>
                                                                                      <label class="custom-control-label" for="messageServiceStatus" id="forMessageServiceStatus"><?php if($setting_soft_info->message_status == "on") echo "ON"; else echo "OFF";  ?></label>
                                                                                </div>
                                                                                 
                                                                            </td>
                                                                            <td></td>
                                                                            <td><?php
                                                                                if  
                                                                                ($setting_soft_info->message_status ==  "on"): 
                                                                                $setting_soft_info->message_service ==  "purchased";
                                                                                ?>
                                                                          
                                                                                <span  class="badge badge-success"> <?php  echo "Thanks for availing the message services  ";  ?></span>
                                                               
                                                                            <?php
                                                                                else:
                                                                                 $setting_soft_info->message_service ==  "not purchased";

                                                                            ?>
                                                        
                                                                           <span  class="badge badge-danger"> <?php echo "Sorry , You have not availed the message service";  ?></span>     
                                                                            <?php 
                                                                                endif;
                                                                            ?>
                                                                                </td>
                                                                            </tr>
                                                                                              </table>
                                                                     </div>
<!--                                                                       </a>   -->
                                                                  </li>
                                                                 </ul>
                                                                </div>
                                                               <!-- /.card-body -->
                                                             </form>
                                               
                                                 </div>
                                             <div class="card card-success">
                                                      <div class="card-header">
                                                        <h3 class="card-title">Useful Links </h3>
                                                      </div>
                                                      <div class="card-body">
                                                            <ul class="links">
                                                                    <li>
                                                                        <a href="dashboard" class="nav-link"><i class="fa fa-angle-right"></i>Dashboard</a>
                                                                    </li>
                                                                    
                                                                    <li>
                                                                        <a href="manage-company" class="nav-link">
                                                                        <i class="fa fa-angle-right"></i>Company management</a>
                                                                    </li>
                                                                 <li>
                                                                        <a href="phase" class="nav-link"><i class="fa fa-angle-right"></i>Phase</a>
                                                                    </li>
                                                                 <li>
                                                                        <a href="block" class="nav-link"><i class="fa fa-angle-right"></i>Block</a>
                                                                    </li>
                                                                 <li>
                                                                        <a href="building" class="nav-link"><i class="fa fa-angle-right"></i>Building</a>
                                                                    </li>
                                                                <li>
                                                                        <a href="property-type" class="nav-link"><i class="fa fa-angle-right"></i>Property Type</a>
                                                                </li>
                                                                <li>
                                                                        <a href="property-type" class="nav-link"><i class="fa fa-angle-right"></i>Accomodation Type</a>
                                                                </li>
                                                                 <li>
                                                                        <a href="projects" class="nav-link"><i class="fa fa-angle-right"></i>AProject</a>
                                                                </li>
                                                                 <li>
                                                                        <a href="customer" class="nav-link"><i class="fa fa-angle-right"></i>Customer</a>
                                                                </li>
                                                                 <li>
                                                                        <a href="land-acquisition-owners" class="nav-link"><i class="fa fa-angle-right"></i>Land Acquisition</a>
                                                                </li>
                                                                 <li>
                                                                        <a href="land-acquisition-uom" class="nav-link"><i class="fa fa-angle-right"></i>UOM</a>
                                                                </li>
                                                                 <li>
                                                                        <a href="land-acquisition-lands" class="nav-link"><i class="fa fa-angle-right"></i>Lands</a>
                                                                </li>
                                                                <li>
                                                                        <a href="profile" class="nav-link"><i class="fa fa-angle-right"></i>User Profile</a>
                                                                </li>
                                                               
                                                            </ul>
                                                      </div>
                                                              <!-- /.card-body -->
                                             </div> <!-- /.card card-success-->

                                      
                  <!-------------------- form theme---------------------------------------------------------------------->
                                          
                                                      
                                    <form id="select_theme" method="POST" enctype="multipart/form-data">
                                                <div class="card card-info" id="default_theme">
                                                  <div class="card-header">
                                                    <h3 class="card-title">Theme</h3>
                                                  </div> <!-- /.card-header --> 
                                                  <div class="card-body">
                                                     <!-- Header Color Starts-->
                                                            <div class="form-group">
                                                              <label>Header Color</label>
                                                                    <div class="input-group my-colorpicker2">
                                                                        <input type="text" class="form-control" id="headerColor"  name="headerColor" value="<?= $setting_theme_info->header_color ?>" autocomplete="off">

                                                                        <div class="input-group-append">
                                                                          <span class="input-group-text"><i class="fas fa-square" ></i></span>
                                                                        </div>
                                                                    </div>
<!--                                                                    /.input group -->
                                                            </div>
                                                        <!-- /.Header Color ends  -->
                                                        <!-- /.Header Background Starts  -->
                                                        <div class="form-group">
                                                                  <label>Header Background</label>
                                                                <div class="input-group my-colorpicker3">
                                                                    <input type="text" class="form-control" id="headerBackground" name="headerBackground" value="<?= $setting_theme_info->header_bg ?>" autocomplete="off">
                                                                    <div class="input-group-append">
                                                                      <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                    </div>
                                                                </div>
<!--                                                            /.input group -->
                                                       </div>
                                                        <!-- /.Header Background Ends  -->


                                                               <!-- /.Footer Color Starts -->
                                                               <div class="form-group">
                                                                  <label>Footer Color</label>
                                                                    <div class="input-group my-colorpicker4">
                                                                        <input type="text" class="form-control" id="FooterColor" name="FooterColor" value="<?= $setting_theme_info->footer_color ?>" autocomplete="off">

                                                                        <div class="input-group-append">
                                                                          <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
<!--                                                                        /.Footer Color  Ends  -->
                                                                </div>

                                                               <!-- /.Footer Background  Starts  -->

                                                               <div class="form-group">
                                                                  <label>Footer Background</label>
                                                                    <div class="input-group my-colorpicker5">
                                                                        <input type="text" class="form-control" id="FooterBackground" name="FooterBackground"  value="<?= $setting_theme_info->footer_bg ?>" autocomplete="off">

                                                                        <div class="input-group-append">
                                                                          <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
<!--                                                                        /.Footer Background Ends  -->
                                                                </div>


                                                               <div class="form-group">
                                                                  <label>Sidebar Color </label>
                                                                    <div class="input-group my-colorpicker6">
                                                                        <input type="text" class="form-control" id="SidebarColor" name="SidebarColor" value="<?= $setting_theme_info->sidebar_color ?>" autocomplete="off">

                                                                        <div class="input-group-append">
                                                                          <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
<!--                                                                        /.Footer Background Ends  -->
                                                                </div>
                                                                         <!-- /.Sidebar Background Starts  -->

                                                               <div class="form-group">
                                                                  <label>Sidebar Background </label>
                                                                    <div class="input-group my-colorpicker7">
                                                                        <input type="text" class="form-control" id="SidebarBackground" name="SidebarColor" value="<?= $setting_theme_info->sidebar_bg ?>" autocomplete="off">

                                                                        <div class="input-group-append">
                                                                          <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
<!--                                                                        /.Sidebar Background End  -->
                                                                </div>

                                                                           <!-- /.Sidebar Active Color Starts  -->

                                                               <div class="form-group">
                                                                  <label>Sidebar Active Color  </label>
                                                                    <div class="input-group my-colorpicker8">
                                                                        <input type="text" class="form-control"  id="SidebarActiveColor" name="SidebarActiveColor" value="<?= $setting_theme_info->sidebar_active_color ?>" autocomplete="off" >

                                                                        <div class="input-group-append">
                                                                          <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
<!--                                                                       /.Sidebar Active Color End  -->
                                                                </div>

                                                                <!-- /.Sidebar Active Background  Starts  -->

                                                               <div class="form-group">
                                                                  <label>Sidebar Active Background  </label>
                                                                    <div class="input-group my-colorpicker9">
                                                                        <input type="text" class="form-control" id="SidebarActiveBackground" name="SidebarActiveBackground" value="<?= $setting_theme_info->sidebar_active_bg ?>" autocomplete="off">

                                                                        <div class="input-group-append">
                                                                          <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                   
<!--                                                                 /.Sidebar Active Background  End  -->
                                                               <!-- /.Theme Color Change   Starts  -->

                                                               <div class="form-group">
                                                                  <label>Theme color change   </label>
                                                                    <div class="input-group my-colorpicker10">
                                                                        <input type="text" class="form-control" id="ThemeColorChange" name="ThemeColorChange" value="<?= $setting_theme_info->ThemeChange ?>" autocomplete="off">

                                                                        <div class="input-group-append">
                                                                          <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                   
<!--                                                                 /.Theme Color Change   End  -->

                                                                      <!-- /.Index Background Starts   -->
                                                                      <div class="form-group">
                                                                        <label for="IndexBackground">Index Background</label>
                                                                        <input type="file" class="form-control" id="IndexBackground" name="IndexBackground" accept="image/*" value="<?= $setting_theme_info->IndexBackground ?>" >
                                                                      </div>
                                                                    <div class="form-group" id="preview-index-back"></div>
                                                      
                                                                <div class="form-group">
                                                                   <div class="card-footer">
                                                                     <button type="submit" class="btn btn-primary float-right" id="SaveChanges" name="SaveChanges">Save Changes</button>
                                                                   </div>
                                                                </div><!-- /.submit --> 

                                                                </div><!-- /.card-body -->           
                                                          </div>  <!-- /.card card-info --> 
                                            </form>     
<!--                                                           // settings theme form ends   ---------------------------------------------->
                                          <script>
                                              
                                              
                                              
                                              
                                                 
                                           
                                        $('#add-button').prop('disabled', false);
                                        $('#import-button').prop('disabled', false);
                                        $("input[data-bootstrap-switch]").each(function(){
                                          $(this).bootstrapSwitch('state', $(this).prop('checked'));
                                        });
////
//                                        //color picker with addon
                                        $('.my-colorpicker2').colorpicker();

                                        $('.my-colorpicker2').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
                                        });
////
////                                        //color picker with addon
                                        $('.my-colorpicker3').colorpicker();

                                        $('.my-colorpicker3').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker3 .fa-square').css('color', event.color.toString());
                                        });
////
////                                        //color picker with addon
                                        $('.my-colorpicker4').colorpicker();
                                        $('.my-colorpicker4').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker4 .fa-square').css('color', event.color.toString());
                                        });

////                                         //color picker with addon
                                        $('.my-colorpicker5').colorpicker();
                                        $('.my-colorpicker5').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker5 .fa-square').css('color', event.color.toString());
                                        });
////                                        //color picker with addon
                                        $('.my-colorpicker6').colorpicker();
                                        $('.my-colorpicker6').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker6 .fa-square').css('color', event.color.toString());
                                        });
                                         //color picker with addon
                                        $('.my-colorpicker7').colorpicker();
                                        $('.my-colorpicker7').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker7 .fa-square').css('color', event.color.toString());
                                        });
////                                          //color picker with addon
                                        $('.my-colorpicker8').colorpicker();
                                        $('.my-colorpicker8').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker8 .fa-square').css('color', event.color.toString());
                                        });
////                                          //color picker with addon
                                        $('.my-colorpicker9').colorpicker();
                                        $('.my-colorpicker9').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker9 .fa-square').css('color', event.color.toString());
                                        });
////                                         //color picker with addon
                                        $('.my-colorpicker10').colorpicker();
                                        $('.my-colorpicker10').on('colorpickerChange', function(event) {
                                          $('.my-colorpicker10 .fa-square').css('color', event.color.toString());
                                        });
                                              

                                        
                                    </script>
                                       
                                       
                                         
                                          <script >

                                
                                //Header Background Change -----------------------------------------------------
                                 $(document).ready(function(){
                                    $("#headerBackground").change(function(){
                                        $("#navbar").css("background-color", $("#headerBackground").val());
                                    })
                                });
                               //----------------------------------------------------------------------------
                                 //Header Color Change 
                               
                                    $("#headerColor").change(function(){
                                        $("#navbar, #navpushmenu, #navdashboard, #navsetting, #navlock, #navbadges").css("color", $("#headerColor").val());
                                    })
                            
                                //----------------------------------------------------------------------------
                                 //Footer Color Change 
                                
                                    $("#FooterColor").change(function(){
                                        $("#main_footer").css("color", $("#FooterColor").val());
                                    })
                            
                                //----------------------------------------------------------------------------
                                //Footer Background Change 
                              
                                    $("#FooterBackground").change(function(){
                                        $("#main_footer").css("background-color", $("#FooterBackground").val());
                                    })
                              
                                //----------------------------------------------------------------------------
                                
                                 //Footer Background Change 
                              
                                    $("#SidebarBackground").change(function(){
                                        $("#asidebar").css("background-color", $("#SidebarBackground").val());
                                    })
                                
                                //----------------------------------------------------------------------------
                                //Footer Background Change 
                               
                                    $("#SidebarColor").change(function(){
                                        $("#nickname,#sidedashboard,#sidesetup,#sidephasemaster,#sideblock,#sidebuilding,#sidepropertytype,#sideaccomodationtype,#sideproject,#sidecustomers,#sideexamportal,#sidelandaquisition,#sideuom,#sidelands,#sideprofile,#sidesettings,#sidelock,#sideemployeemanagement,#sidemanagedepartment,#sidemanageemployees,#sidelogout,#sidepurchasemanagement,#sidelog,#sidelock,#sidesettings,#sideprofile,#sideservices,#sidecustomers,#sidecomplaints,#sidecustomers,#sideinvreports,#sidegoodsissue,#sidegoodsissue,#sidesettings,#sideprofile").css("color", $("#SidebarColor").val());
                                    })
                               
                                //----------------------------------------------------------------------------
                                //----------------------------------------------------------------------------
                                //Side Activebar Color Change 
                               
                                 
                                      $("#SidebarActiveColor").change(function(){
                                           
                                         $(".sidebar-dark-navy .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-navy .nav-sidebar>.nav-item>.nav-link.active").css("color", $("#SidebarActiveColor").val());
                                            
                                    })
                                
                                  //----------------------------------------------------------------------------
                                //----------------------------------------------------------------------------
                                //Side Activebar Background  Change 
                               
                                
                                      $("#SidebarActiveBackground").change(function(){
                                        $(".sidebar-dark-navy .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-navy .nav-sidebar>.nav-item>.nav-link.active ").css("background-color", $("#SidebarActiveBackground").val());
                                    })
                                
                                //----------------------------------------------------------------------------
                                //----------------------------------------------------------------------------
                                //Theme Color Change 
                               
                                      $("#ThemeColorChange").change(function(){
                                        $(" .theme_change ").css("color", $("#ThemeColorChange").val());
                                    })
                                
                                //----------------------------------------------------------------------------
                                //----------------------------------------------------------------------------
                                //Index Background Image Change 
                               

                                    $("#IndexBackground").change(function(){
                                        if($("#IndexBackground").val() != ""){
                                           
                                            $('#preview-index-back').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                            $('#IndexBackground').attr("readonly", "readonly");
                                            var formData = new FormData();
                                            var files = $('#IndexBackground')[0].files[0];
                                            
                                                    formData.append('IndexBackground', files);
                                                    formData.append('action', "uploadIndexBack");
                                                    $.ajax({
                                                        url: 'application/controller/admin/settings.php',
                                                        type: 'POST',
                                                        data: formData,
                                                        contentType: false,
                                                        cache: false,
                                                        processData: false,
                                                        success: function (data) 
                                               {     
                                                   
                                                   topEndNotification("info", "Data loaded Successfully...");
                                                    $('#loading').fadeOut(500, function () {
                                                        $(this).remove();
                                                        console.log(data);
                                                        if(data != "error")
                                                            $('#preview-index-back').html('<img src="assets/bg/'+data+'" width="100px" />');
                                                        else
                                                            $('#preview-index-back').html("Unable to upload your image, Please try again!!!");
                                                        $('#IndexBackground').removeAttr("readonly");
//                                                        $("#IndexBackground").val("");
                                                    });
                                                }
                                            });
                                        }

                                   
                                  });                                               

                                      
//                                        function ValidateSize(file) {
//                                            var FileSize = file.files[0].size / 1024 / 1024; // in MB
//                                            if (FileSize > 2) {
//                                                alert('File size exceeds 2 MB');
//                                               // $(file).val(''); //for clearing with Jquery
//                                            } else {
//
//                                            }
//                                        }   
                                              
                                          </script>
 
                                              
                           
                                
                                      
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
                                         
                                              $('#SaveChanges').on('click', function() {
                                          
                                                var headerColor = $('#headerColor').val();
                                                var headerBackground = $('#headerBackground').val();
                                                    
                                                var FooterColor = $('#FooterColor').val();
                                                var FooterBackground = $('#FooterBackground').val();
                                                var SidebarColor = $('#SidebarColor').val();
                                                  
                                                var SidebarBackground = $('#SidebarBackground').val();
                                                var SidebarActiveColor = $('#SidebarActiveColor').val();
                                                var SidebarActiveBackground = $('#SidebarActiveBackground').val();
                                                var SidebarActiveBackground = $('#SidebarActiveBackground').val();
                                                var ThemeColorChange= $('#ThemeColorChange').val();
                                                 
                                                if( headerBackground!="" ){
                                                    
                                                    $.ajax({
                                                        url: "application/controller/admin/settings.php",
                                                        type: "POST",
                                                        data: {
                                                             action: "changethemesetting", 
                                                                headerColor : headerColor,
                                                                headerBackground : headerBackground,
                                                                FooterColor : FooterColor,
                                                                FooterBackground : FooterBackground,
                                                                SidebarColor : SidebarColor, 		
                                                                SidebarBackground : SidebarBackground,
                                                                SidebarActiveColor : SidebarActiveColor,
                                                                SidebarActiveBackground : SidebarActiveBackground,
                                                                ThemeColorChange: ThemeColorChange,
                                                         
                                                        
                                                        },
                                                        
                                                        cache: false,
                                                        success: function(data){
                                                            console.log(data);
                                                          
                                                            topEndNotification("success", "Data uploaded successfully...");
                                                            
                                                              $('#theme-loading').fadeOut(1000, function () {             
                                                              $("#select_theme").html(data);
                                                             
                                                              $("#success").show();
                                                                  
                                                              $('#success').html('Data added successfully !'); 
                                                                 
                                                        });
                                                        }
                                                    });
                                                }
                                                else{
                                                    alert('Please fill all the field !');
                                                }
                                            });
                                      
                                          </script>
                                          
                                          </div>       <!-- left  column  ends 
                                             <!-- payment details section started -->
                                                <div class="col-md-6">
                                                <!-- general form elements disabled -->
                                                    <div class="card card-warning">
                                                      <div class="card-header">
                                                        <h3 class="card-title">About Firm</h3>
                                                      </div>
                                                      <!-- /.card-header -->
                                                      <div class="card-body">
                                                        <form role="form">
                                                          <div class="row">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control"  value="<?= $setting_soft_info->uniqe_id ?>" placeholder="Enter software id">
                                                              </div>
                                                            </div>
                                                             <ul class="list-group list-group-unbordered mb-3">
                                                                 <li class="list-group-item">
                                                                   <a href="<?= $settingDir.$setting_firm_info->logo ?>" target="_blank"><img src="<?= $settingDir.$setting_firm_info->logo  ?>" alt="Firm  Logo" class="table-avatar"></a>
                                                                 </li>
                                                                <li class="list-group-item">
                                                                  <b>Firm Name</b> <a class="float-right"><?= $setting_firm_info->firm_name ?></a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                  <b> </b> <a class="float-right"><?= $setting_firm_info->firm_nick_name ?></a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                  <b>Email </b> <a class="float-right"><?= $setting_firm_info->email ?></a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>Alternate Email </b> <a class="float-right"><?= $setting_firm_info->alternate_emails ?></a>
                                                                        </li> 
                                                                 <li class="list-group-item">
                                                                    <b> Contact Number </b> <a class="float-right"><?= $setting_firm_info->number ?></a>
                                                                </li> 
                                                                 <li class="list-group-item">
                                                                    <b> Alternate Contact Number </b> <a class="float-right"><?= $setting_firm_info->alternate_numbers ?></a>
                                                                </li> 
                                                                 <li class="list-group-item">
                                                                    <b> Landline Number </b> <a class="float-right"><?= $setting_firm_info->pnt ?></a>
                                                                 </li> 

                                                                  <li class="list-group-item">
                                                                    <b> Other Landline Numbers </b> <a class="float-right"><?= $setting_firm_info->alternate_pnts ?></a>
                                                                </li> 
                                                                 <li class="list-group-item">
                                                                    <b> Country </b> <a class="float-right"><?= $setting_firm_info->country ?></a>
                                                                </li> 
                                                                 <li class="list-group-item">
                                                                    <b> Country Code  </b> <a class="float-right"><?= $setting_firm_info->country_code ?></a>
                                                                </li> 
                                                                 <li class="list-group-item">
                                                                    <b> State</b> <a class="float-right"><?= $setting_firm_info->state ?></a>
                                                                </li> 
                                                                  <li class="list-group-item">
                                                                    <b> City</b> <a class="float-right"><?= $setting_firm_info->city ?></a>
                                                                </li> 
                                                          <li class="list-group-item">
                                                            <b> Pincode</b> <a class="float-right"><?= $setting_firm_info->pincode ?></a>
                                                        </li>
                                                         <li class="list-group-item">
                                                            <b> Address</b> <a class="float-right"><?= $setting_firm_info->address ?></a>
                                                        </li>
                                                          <li class="list-group-item">
                                                            <b>Map</b> <a class="float-right"><?= $setting_firm_info->map ?></a>
                                                        </li>
                                                         <li class="list-group-item">
                                                            <b>GSTIN</b> <a class="float-right"><?= $setting_firm_info->gstin ?></a>
                                                        </li>
                                                           <li class="list-group-item">
                                                            <b>Registration Certificate</b> <a class="float-right"><?= $setting_firm_info->gstin ?></a>
                                                        </li>
                                                         <li class="list-group-item">
                                                            <b>Established</b> <a class="float-right"><?= $setting_firm_info->stablised ?></a>
                                                        </li>
                                                          <li class="list-group-item">
                                                            <b>Owner Name</b> <a class="float-right"><?= $setting_firm_info->owner_name?></a>
                                                        </li>
                                                         <li class="list-group-item">
                                                            <b>Owner Email </b> <a class="float-right"><?= $setting_firm_info->owner_email?></a>
                                                        </li>

                                                          <li class="list-group-item">
                                                            <b>Owner Number </b> <a class="float-right"><?= $setting_firm_info->owner_number?></a>
                                                        </li>
                                                         <li class="list-group-item">
                                                            <b>Owner AAdhar </b> <a class="float-right"><?= $setting_firm_info->owner_aadhar?></a>
                                                        </li>
                                                         <li class="list-group-item">
                                                            <b>Owner PAN </b> <a class="float-right"><?= $setting_firm_info->owner_pan?></a>
                                                        </li>
                                                        </ul>
                                                    </form>
                                                   </div>
                                                      <!-- /.card-body -->
                                                </div>
                                                            <!-- /.card -->
                                                            <!-- general form elements disabled -->
<!--
                                                            <div class="card card-secondary">
                                                              <div class="card-header">
                                                                <h3 class="card-title">Payment Details </h3>
                                                              </div>
                                                              <div class="card-body">
                                                                <form role="form">

                                                                     <ul class="list-group list-group-unbordered mb-3">

                                                                        <li class="list-group-item">
                                                                         <b>Payment Gateway</b> <a class="float-right">
                                                                            <?= $setting_payment_info->payment_gateway ?>
                                                                            </a>
                                                                        </li>

                                                                 <li class="list-group-item">
                                                                  <b>Merchant ID</b> <a class="float-right"><?php echo str_repeat('*', strlen($setting_payment_info->merchant_id) - 3) . substr($setting_payment_info->merchant_id, -3);?></a>
                                                                </li>
                                                                 
                                                                 <li class="list-group-item">
                                                                  <b>Security Key</b> <a class="float-right"><?php echo str_repeat('*', strlen($setting_payment_info->security_key) - 3) . substr($setting_payment_info->security_key, -3);?></a>
                                                                </li>
                                                                 <li class="list-group-item">
                                                                          <b>Bank Information </b> <a class="float-right"><?= $setting_payment_info->bank_info ?></a>
                                                                 </li>
                                                                 <li class="list-group-item">
                                                                              <b>Account Number  </b> <a class="float-right"><?php echo str_repeat('*', strlen($setting_payment_info->accnt_info ) - 4) . substr($setting_payment_info->accnt_info , -4);?></a>
                                                                </li>
                                                                 <li class="list-group-item">
                                                                              <b>IFSC CODE </b> <a class="float-right"><?= $setting_payment_info->payment_gateway ?></a>
                                                                </li>
                                                                
                                                </ul>
                                                            
                                            </form>
                                           </div>
                                                    </div>
-->

<!--
                                                          <div class="card card-info">
                                                              <div class="card-header">
                                                                <h3 class="card-title"></h3>
                                                              </div>
-->
                                                              <!-- /.card-header -->
                                                              <!-- form start -->
<!--
                                                              <form class="form-horizontal">
                                                                <div class="card-body">
                                                                  <div class="form-group">
                                                                        <label for="QrCode">QR CODE</label>
                                                                        <input type="file" class="form-control" id="QrCode" name="QrCode" accept="image/*"   value="<?= $setting_theme_info->QrCode ?>" >
                                                                  </div>
                                                                     
                                                                  <div class="form-group" id="preview-qr-code"></div>
                                                                    
                                                                </div>
                                                              </form>
                                                                </div>
-->
                                                                <!-- /.card -->

                                            <?php 
                                            $sno++;
                                            endforeach;
                                            endif;
                                             ?>
                                                    
                                             <script>
                                              //----------------------------------------------------------------------------
                                              //----------------------------------------------------------------------------
                                              //QR Code  Image Upload Starts
                                              $(document).ready(function(){
                                              $("#QrCode").change(function(){
                                                if($("#QrCode").val() != ""){
                                                $('#preview-qr-code').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                $('#QrCode').attr("readonly", "readonly");
                                                var formData = new FormData();
                                                var files = $('#QrCode')[0].files[0]
                                                    
                                                    
                                                        formData.append('QrCode', files);
                                                        formData.append('action', "uploadQrCode");
                                                        $.ajax({
                                                            url: 'application/controller/admin/settings.php',
                                                            type: 'POST',
                                                            data: formData,
                                                            contentType: false,
                                                            cache: false,
                                                            processData: false,
                                                            success: function (data) {
                                                                 
                                                                $('#loading').fadeOut(500, function () {
                                                                    $(this).remove();
                                                                    console.log(data);
                                                                    if(data != "error")

                                                                        $('#preview-qr-code').html('<img src="assets/admin/setting/'+data+'" width="100px" />');
                                                                    else
                                                                        $('#preview-qr-code').html("Unable to upload your image, Please try again!!!");
                                                                    $('#QrCode').removeAttr("readonly");
                                                                    $("#QrCode").val("");
                                                        });
                                                    }
                                                });
                                           
                                            }

                                        });
                                                  
                               });
                                </script>

                                                    
                                                    
                                  
                    
                    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
                    
                    
                                                    
                    <script>
                        $(function(){
                            // Mail Service Status Section Start ---------------------------------------------------------------
                            $("#mailServiceStatus").change(function () {
                                var val = "";
                                $('#forMailServiceStatus').html('<center id = "status-loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
                                if($(this).is(":checked"))
                                    val = "on";
                               
                                else
                                    val = "off";
                                $("#mailServiceStatus").prop('disabled', true);
                                var formData = {"action":"changeMailStatus","val":val};
                                $.ajax({
                                    url: 'application/controller/admin/settings.php',
                                    type: 'POST',
                                    data: formData,
                                    success: function (data) {
                                        $('#status-loading').fadeOut(1000, function () {
                                            $("#forMailServiceStatus").html(val.toUpperCase());
                                             $('#displaymailservices').trigger('click');
                                            $("#mailServiceStatus").prop('disabled', false);
                                        });
                                    }
                                });
                            });
                            // Mail Service Status Section End ----------------------------------------------------------------- 
                            // Message Service Status Section Start ---------------------------------------------------------------
                            $("#messageServiceStatus").change(function () {
                                var val = "";
                                $('#forMessageServiceStatus').html('<center id = "status-loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
                                if($(this).is(":checked"))
                                    val = "on";
                                else
                                    val = "off";
                                $("#messageServiceStatus").prop('disabled', true);
                                var formData = {"action":"changeMessageStatus","val":val};
                                $.ajax({
                                    url: 'application/controller/admin/settings.php',
                                    type: 'POST',
                                    data: formData,
                                    success: function (data) {
                                        $('#status-loading').fadeOut(1000, function () {
                                            $("#forMessageServiceStatus").html(val.toUpperCase());
                                            $("#displaymessageservices").show();
                                                          
                                            $("#messageServiceStatus").prop('disabled', false);
                                        });
                                    }
                                });
                            });
                            // Message Service Status Section End ----------------------------------------------------------------- 
                         });
                         
                                        
                            </script>
                            <script src="dist/js/admin/for-all-tables.js"></script>
                            <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
                <?php
                break;
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start --------
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
                                                    