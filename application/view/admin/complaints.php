<?php 
    require_once("../../classes-and-objects/config.php");
    require_once("../../classes-and-objects/veriables.php");
    require_once("../../classes-and-objects/authentication.php");
    require_once("../../classes-and-objects/PHPExcel/PHPExcel.php");
    $auth = new AUTHENTICATION($databaseObj);
    $objPHPExcel = new PHPExcel();
    $defaultLogo = "../assets/dp/default.png";
    $randSix = $auth->randSix();
    $authority = 1;
    $complainStoreDir = "../../../assets/customer/manage-tickets/";
    $complainDir = "../../../assets/customer/manage-tickets/";
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
                    <form id="selectForm" method="POST" enctype="multipart/form-data" action="application/controller/admin/complaints.php">
                        <input type="hidden" id="nameOfATable" name="nameOfATable" value="tbl_complaints">
                        <input type="hidden" id="action" name="action" value="exportSelectedData">
                        <table id="example1" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <div class="icheck-navy d-inline">
                                                <input type="checkbox" id="check-all" name="check-all" title="Check All" value="all">
                                                <label for="check-all" title="Check All">
                                                </label>
                                            </div>
                                        </th>
                                        <th>S. No.</th>
                                        <th>Ticket No.</th>
                                        <th>Client Name</th>
										<th>Email</th>
                                        <th>Priority</th>
                                        <th>Subject</th>
                                        <th>Content</th>
										<th>Scope</th>
										<th>Alloted To</th>
										<th>Attachment</th>
										<th>Ticket Status</th>
									   
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $databaseObj->select("tbl_complaints");
                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                        $databaseObj->order_by("`complain_id` DESC");
                                        $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                        if($getData != 0):
                                            $sno = 1;
                                            foreach($getData as $rows):
                                                $complain_info = json_decode($rows["complain_info"]);
                                                $complain_log = json_decode($rows["complain_log"]);
                                    ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="icheck-navy d-inline">
                                                                <input type="checkbox" id="checkbox-<?= $rows["complain_id"] ?>" name="checkbox-select[]" value="<?= $rows["complain_id"] ?>" class="check-table">
                                                                <label for="checkbox-<?= $rows["complain_id"] ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= $sno ?>.</td>
                                                        
                                                        <td><?= $complain_info->ticketNo ?></td>
                                                        <td><?= $complain_info->clientName ?></td>
														<td><?= $complain_info->email ?></td>
                                                        <td><?= $complain_info->priority ?></td>
                                                        <td><?= $complain_info->subject ?></td>
														 <td><?= $complain_info->content ?></td>
														 <td><?= $complain_info->scope ?></td>
														  <td><?= $complain_info->emp_name ?></td>
														  
														 <td>
														<?php
														if($complain_info->attachment == "default"):
														?>
														<a href="<?= $defaultLogo ?>" target="_blank"><img src="<?= $defaultLogo ?>" alt="" class="table-avatar"></a>
														<?php
														else:
														?>
														<a href="<?= $complainDir.$complain_info->attachment ?>" target="_blank"><img src="<?= $complainDir.$complain_info->attachment ?>" alt="" class="table-avatar"></a>
														<?php 
														endif;
														?>
															</td>
														 
														 <td>
														 
														  <?php 
														 if($complain_info->status == 'opened')
														 { ?>
														 <span class="badge badge-success"><?= $complain_info->status ?></span>
														 <?php } ?>
														 
														 <?php 
														 if($complain_info->status == 'On Hold')
														 { ?>
														 <span class="badge badge-warning"><?= $complain_info->status ?></span>
														 <?php } ?>
														 
														 <?php if($complain_info->status == 'Closed') { ?>
														 <span class="badge badge-danger"><?= $complain_info->status ?></span>
														 <?php } ?>
														 
														 
														 <?php if($complain_info->status == 'In Progress'){?>
														 <span class="badge badge-success"><?= $complain_info->status ?></span>
														 <?php } ?>
														 
														 <?php if($complain_info->status == 'Allot'){?>
														 <span class="badge badge-primary"><?= $complain_info->status ?></span>
														 <?php } ?>
														 </td>
														
														
														 
														 
                                                        <td class="text-center">
                                                            <button type="button" id="information-button-<?= $rows["complain_id"] ?>" class="information-button btn btn-xs btn-danger mt-1 mb-1" title="Informations">
                                                                <i class="fa fa-scroll fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="see-button-<?= $rows["complain_id"] ?>" class="see-button btn btn-xs btn-info mt-1 mb-1" title="See">
                                                                <i class="fa fa-eye fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="edit-button-<?= $rows["complain_id"] ?>" class="edit-button btn btn-xs btn-warning mt-1 mb-1" title="Edit/Update">
                                                                <i class="fa fa-edit fa-sm"></i>
                                                            </button>
                                                            <button type="button" id="delete-button-<?= $rows["complain_id"] ?>" class="delete-button btn btn-xs btn-danger mt-1 mb-1" title="Delete">
                                                                <i class="fa fa-trash fa-sm"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        // Information Section Start ---------------------------------------------------------------
                                                        $("#information-button-<?= $rows["complain_id"] ?>").click(function () {
                                                            $("#information-modal").modal('show');
                                                            $('#information-section').html('<center id = "information-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchInformation","id":"<?= $rows["complain_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/complaints.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#information-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#information-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Information Section End -----------------------------------------------------------------
                                                        // See Section Start ---------------------------------------------------------------
                                                        $("#see-button-<?= $rows["complain_id"] ?>").click(function () {
                                                            $("#see-modal").modal('show');
                                                            $('#see-section').html('<center id = "see-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchSee","id":"<?= $rows["complain_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/complaints.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#see-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#see-section').html(data);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // See Section End -----------------------------------------------------------------
                                                        // Edit Section Start ---------------------------------------------------------------
                                                        $("#edit-button-<?= $rows["complain_id"] ?>").click(function () {
                                                            $("#edit-modal").modal('show');
                                                            $('#edit-section').html('<center id = "edit-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchEdit","id":"<?= $rows["complain_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/complaints.php',
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
                                                        // Delete Section Start ---------------------------------------------------------------
                                                        $("#delete-button-<?= $rows["complain_id"] ?>").click(function () {
                                                            $("#delete-modal").modal('show');
                                                            $('#deleteButton').prop('disabled', true);
                                                            $('#delete-section').html('<center id = "delete-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
                                                            var formData = {"action":"fetchDelete","id":"<?= $rows["complain_id"] ?>"};
                                                            $.ajax({
                                                                url: 'application/view/admin/complaints.php',
                                                                type: 'POST',
                                                                data: formData,
                                                                success: function (data) {
                                                                    $('#delete-loading').fadeOut(500, function () {
                                                                        $(this).remove();
                                                                        $('#delete-section').html(data);
                                                                        $('#deleteButton').prop('disabled', false);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                        // Delete Section End -----------------------------------------------------------------
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
            // -----------------------------------------------
            // ------------ Fetch Data Section End -----------
            // -----------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchInformation":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_complaints");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `complain_id` = '".$_POST["id"]."'");
                        $databaseObj->order_by("`complain_id` DESC");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $complain_log = json_decode($rows["complain_log"]);
                                ?>
                                    <div class="row">
                                        <?php
                                            $sno = 1;
                                            foreach($complain_log as $complain_log_info):
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link" href="#tab_4_<?= $sno ?>" data-toggle="tab"><?= ucfirst($complain_log_info->action) ?> By</a></li>
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1_<?= $sno ?>" data-toggle="tab">Date/Time</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2_<?= $sno ?>" data-toggle="tab">IP</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3_<?= $sno ?>" data-toggle="tab">Location</a></li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane" id="tab_4_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-user-alt"></i> <?= ucfirst($complain_log_info->action) ?> By - 
                                                                    <?php
                                                                        if($complain_log_info->by == $auth->admin_id):
                                                                            echo "You";
                                                                        else:
                                                                            $databaseObj->select("tbl_admin");
                                                                            $databaseObj->where("`status` = '".$auth->visible()."' && `admin_id` = '".$complain_log_info->by."'");
                                                                            $getData = $databaseObj->get();
                                                                            //Checking If Data Is Available
                                                                            if($getData != 0):
                                                                                foreach($getData as $rows):
                                                                                    $admin_info = json_decode($rows["admin_info"]);
                                                                                    echo $admin_info->name;
                                                                                endforeach;
                                                                            else:
                                                                                echo "Anonymous";
                                                                            endif;
                                                                        endif;
                                                                    ?>
                                                                    </h5>
                                                                </div>
                                                                <div class="tab-pane active" id="tab_1_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-calendar"></i> Date/Time - </h5>
                                                                    <?= date("l, M d, Y", strtotime($complain_log_info->date)) ?> At <?= $complain_log_info->at ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_2_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-server"></i> IP - </h5>
                                                                    <?= $complain_log_info->ip ?>
                                                                </div>
                                                                <div class="tab-pane" id="tab_3_<?= $sno ?>">
                                                                    <h5><i class="icon fas fa-map-marker"></i> Location - </h5>
                                                                    <?php
                                                                        $latLangArray = explode(",", $complain_log_info->location);
                                                                        $lat = explode(":", $latLangArray[0]);
                                                                        $lang = explode(":", $latLangArray[1]);
                                                                    ?>
                                                                    <iframe width="100%" height="300" src="https://maps.google.com/maps?q=<?= $lat[1] ?>,<?= $lang[1] ?>&output=embed"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                $sno++;
                                            endforeach;
                                        ?>
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
            // ------------ Fetch Information Section End -----------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch See Section Start -----------------
            // ------------------------------------------------------
            case "fetchSee":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_complaints");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `complain_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $complain_log_info = json_decode($rows["complain_info"]);
                                ?>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Ticket No</h5>
                                                    <?= $complain_log_info->ticketNo ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Client Name</h5>
                                                    <?= $complain_log_info->clientName ?>
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Email</h5>
                                                    <?= $complain_log_info->email ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Priority</h5>
                                                    <?= $complain_log_info->priority ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Subject</h5>
                                                    <?= $complain_log_info->subject ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Content</h5>
                                                    <?= $complain_log_info->content ?>
                                                </div>
                                            </div>
											
											
											 <div class="col-md-4">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Attachment</h5>
                                                    <?= $complain_log_info->attachment ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="callout callout-danger">
                                                    <h5 class="text-bold">Status</h5>
                                                    <?= $complain_log_info->status ?>
                                                </div>
                                            </div>
                                            
                                            
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
            // ------------ Fetch See Section End -------------------
            // ------------------------------------------------------
            // ------------------------------------------------------
            // ------------ Fetch Edit Section Start ----------------
            // ------------------------------------------------------
            case "fetchEdit":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        $databaseObj->select("tbl_complaints");
                        $databaseObj->where("`status` = '".$auth->visible()."' && `complain_id` = '".$_POST["id"]."'");
                        $getData = $databaseObj->get();
                        //Checking If Data Is Available
                        if($getData != 0):
                            foreach($getData as $rows):
                                $complain_info = json_decode($rows["complain_info"]);
                                ?>
                                    <div class="row">
                                       
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editTicketNo">Ticket No</label>
                                                <input type="text" class="form-control" id="editTicketNo" name="editTicketNo" placeholder="Ticket No" value="<?= $complain_info->ticketNo ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editClientName">Client Name</label>
                                                <input type="text" class="form-control" id="editClientName" name="editClientName" placeholder="Client Name" value="<?= $complain_info->clientName ?>" readonly>
                                            </div>
                                        </div>
										
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editClientName">Email</label>
                                                <input type="text" class="form-control" id="editEmail" name="editEmail" placeholder="Email" value="<?= $complain_info->email ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editPriority">Priority</label>
                                                <input type="text" class="form-control" id="editPriority" name="editPriority" placeholder="Priority" value="<?= $complain_info->priority ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editCompanyGSTIN">Subject</label>
                                                <input type="text" class="form-control" id="editSubject" name="editSubject" placeholder="Subject" value="<?= $complain_info->subject ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editContent">Content</label>
                                                <input type="text" class="form-control" id="editContent" name="editContent" placeholder="Content" value="<?= $complain_info->content ?>" readonly>
                                            </div>
                                        </div>
										
										 <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editStatus">Scope</label>
												
											<select class="form-control" id="editScope" name="editScope">
											<option value="Not in Scope" <?php if(!empty($complain_info) && $complain_info->scope =='Not in Scope'){echo 'selected';} ?>>Not in Scope</option>
											<option value="Under AMC" <?php if(!empty($complain_info) && $complain_info->scope =='Under AMC'){echo 'selected';} ?>>Under AMC</option>
											
											</select>
                                            </div>
                                        </div>
										
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editContent">Attachment</label>
                                                <input type="text" class="form-control" id="editAttachment" name="editAttachment" placeholder="Attachment" value="<?= $complain_info->attachment ?>" readonly>
                                            </div>
                                        </div>
										
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editStatus">Status</label>
												
											<select class="form-control" id="change" name="editStatus">
											<option value="In Progress" <?php if(!empty($complain_info) && $complain_info->status =='In Progress'){echo 'selected';} ?>>In Progress</option>
											<option value="On Hold" <?php if(!empty($complain_info) && $complain_info->status =='On Hold'){echo 'selected';} ?>>On Hold</option>
											<option value="Closed" <?php if(!empty($complain_info) && $complain_info->status =='Closed'){echo 'selected';} ?>>Closed</option>
											<option value="Allot" <?php if(!empty($complain_info) && $complain_info->status =='Allot'){echo 'selected';} ?>>Allot</option>
											</select>
                                            </div>
                                        </div>
										
										 <div class="col-md-6">
                                            <div class="form-group">
											<label for="editEmpName"></label>
											<?php 
														 if($complain_info->status != '')
														 { ?>
                                                <input type="text" class="form-control" id="show_emp"  name="editEmpName" placeholder="Employee Name" value="<?= $complain_info->emp_name ?>" readonly>
														 <?php } ?>
											
                                                <input type="text" class="form-control" id="show_emp"  name="editEmpName" placeholder="Employee Name" value="" style="display:none;">
                                            </div>
                                        </div>
                                       
                                       
                                        <input type="hidden" name="editTableId" value="<?= $_POST["id"] ?>" />
                                    </div>
									

								<script>

								$(document).ready(function(){


								$('#change').on('change', function() {
								if ( this.value == 'Allot')
								//.....................^.......
								{
								$("#show_emp").show();

								}
								else
								{
								$("#show_emp").hide();    

								}
								});
								});

								</script>


									
									
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
            // ------------ Fetch Information Section Start ---------
            // ------------------------------------------------------
            case "fetchDelete":
                if($authority == 1):
                    if(isset($_POST["id"]) && !empty($_POST["id"])):
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            Do you really wanna delete this data???
                        </div>
                        <input type="hidden" id="tableId" name="tableId" value="<?= $_POST["id"] ?>" />
                        <input type="hidden" id="tableName" name="tableName" value="tbl_complaints" />
                        <?php
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