         <div id="content" class="content">
            <ol class="breadcrumb float-xl-right">
               <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
               <li class="breadcrumb-item"><a href="javascript:;">Leave Types</a></li>
            </ol>
            <h1 class="page-header">Leave Types</h1>

<?php if($this->session->flashdata('success')): ?>
   <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p> 
<?php endif; ?>
<?php if($this->session->flashdata('danger')): ?>
   <p class="alert alert-danger"><?php echo $this->session->flashdata('danger'); ?></p> 
<?php endif; ?>
            <div class="row">
               <div class="col-xl-12">
           <div class="card card-navy card-outline mb-3">
        <div class="card-body">
          <div class="row">
           
            <div class="col-md-12">
              <!--<div class="mt-4">-->
                <!--<a href="<?php echo base_url(); ?>admin/Attendance/manage_attendance" class="btn btn-inverse">Manage Attendance</a> -->
                <button id="add-button" type="button" class="add-button btn btn-sm btn-success mt-1 mb-1" data-toggle="modal" data-target="#add-modal" title="Add New" style="float:right;">
                <i class="fa fa-plus fa-sm"></i> Add New Leave
                </button>
              
            </div>
          </div>
        </div>
      </div>
                    <div class="panel panel-inverse">
                     <div class="panel-heading">
                        <h4 class="panel-title"></h4>
                        <!-- <a href="#modal-dialog" class="btn btn-success btn-sm" data-toggle="modal">Demo</a>
                           -->
                        <div class="panel-heading-btn">
                           <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                           <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                           <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                           <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                     </div>
                     <div class="panel-body">
                    <div class="tab-pane fade active show table-responsive" id="dataresultId">

                  </div>                   
               </div>
            </div>
         </div>
      </div>
    </div>


<!-- Add New Section Start -->
        <div class="modal fade" id="add-modal">
            <div class="modal-dialog modal-md">
                <form id="addForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New Leave</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="leave-type">Leave Name</label>
                                                <input type="text" class="form-control" id="leave-type" name="leave-type" placeholder="Name of Leave">
                                            </div>
                                        </div>
                                      <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="unit-type">No. of Days</label>
                                                <input type="text" class="form-control" id="leave_days" name="leave_days" placeholder="No. of Days">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="addButton" class="add-button btn btn-success btn-sm"><i class="fa fa-plus fa-sm"></i> Add this</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add New Section End -->

    <?php include($view_path.'admin/include/footer.php'); ?>
    <!-- datatable links  start-->
        <script src="<?php echo base_url() ?>/assets/plugins/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/build/pdfmake.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/jszip/dist/jszip.min.js" type="text/javascript"></script> 
    <!-- datatable links end -->

      <!-- all checkbox select one click script  -->
      <script type="text/javascript">
			function checkAll(ele) {
			     var checkboxes = document.getElementsByTagName('input');
			     if (ele.checked) {
			         for (var i = 0; i < checkboxes.length; i++) {
			             if (checkboxes[i].type == 'checkbox') {
			                 checkboxes[i].checked = true;
			             }
			         }
			     } else {
			         for (var i = 0; i < checkboxes.length; i++) {
			             console.log(i)
			             if (checkboxes[i].type == 'checkbox') {
			                 checkboxes[i].checked = false;
			             }
			         }
			     }
			 }
          function dateVerification() {
                var pickDate = $('.datepicker').val();
              var todayDate = $.datepicker.formatDate('yy-mm-dd', new Date());
                 if(pickDate>todayDate)
                 {
                  alert('Please Enter Todays Date');
                  return false;
                 }else{
                  return true;
                 }
             }

             function load_data_table(){
                    var dataid = $('#emp_store_name').val();
                    $('.spinner_load').show();
                      $.ajax({
                        url:'<?php echo base_url();?>admin/attendance/fetchAllLeaveData',
                        method: 'POST',
                        data: {"store_id": dataid},
                        success: function(response){
                        $('.spinner_load').hide();
                        $('#dataresultId').html(response);
                        $('#dataresultId table').DataTable({
                                                  dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
                                                  buttons: [
                                                  { extend: 'excel',
                                                      className: 'btn-sm'
                                                  }, {
                                                      extend: 'pdf',
                                                      className: 'btn-sm'
                                                  }, {
                                                      extend: 'print',
                                                      exportOptions: {
                                                       columns: ':visible'
                                                        },
                                                      className: 'btn-sm'
                                                  }],
                                                  responsive: false
                                              });
                          }
                       });  
                    }
        // call function onload
        load_data_table();
   		</script>
   
