         <div id="content" class="content">
            <ol class="breadcrumb float-xl-right">
               <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
               <li class="breadcrumb-item"><a href="javascript:;">Add Attendance</a></li>
            </ol>
            <h1 class="page-header">Add Attendance</h1>

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
            <div class="col-md-4">
              <div class="form-group">
                <label for=""><strong>Select Store:</strong></label>
                <select class="form-control" name="emp_store_name" id="emp_store_name" style="" required="">
                  <option value="" selected="" disabled="">All</option>
                  <?php
                  foreach ($store as $sRow) {
                  echo "<option value=".$sRow['str_id'].">".$sRow['str_name']."</option>";
                  }  ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <button type="button" class="btn btn-warning mt-4" onclick="load_data_table()">Show Employees</button>
            </div>
            <div class="col-md-2">
              <div class="mt-4">
                <a href="<?php echo base_url(); ?>admin/Attendance/manage_attendance" class="btn btn-inverse">Manage Attendance</a>
              </div>
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
                        url:'<?php echo base_url();?>admin/attendance/fetchAllEmployeeData',
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
   
