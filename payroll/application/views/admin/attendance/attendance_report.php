<?php
// require_once("classes-and-objects/authentication.php");
// $auth = new AUTHENTICATION($databaseObj);
?>
<link href="<?=base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet"/>
         <div id="content" class="content">
            <ol class="breadcrumb float-xl-right">
               <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
               <li class="breadcrumb-item"><a href="javascript:;">Attendance Report</a></li>
            </ol>
            <h1 class="page-header">Attendance Report</h1>

        <?php if($this->session->flashdata('msg')): ?>
          <?php echo $this->session->flashdata('msg'); ?>
            <?php endif; ?>
            <div class="row">
               <div class="col-xl-12">
                  <div class="panel panel-inverse">
                     <div class="panel-heading">
                        <h4 class="panel-title">&nbsp;&nbsp;&nbsp;</h4>
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
                        <div class="row">
                            
                          <div class="col-md-3">
                              <label class="control-label mr-2"><strong>Employee Name::</strong></label>
                            <div class="form-group">
                                <select class="default-select2 form-control" name="employee_id" id="employee_id">
                                    <option value="" selected> All </option>
                                     <?php
                                       // $databaseObj->select("tbl_manage_employee");
                                       // $databaseObj->where("`status` = '".$auth->visible()."'");
                                       // $databaseObj->order_by("`manage_employee_id` DESC");
                                       // $getData = $databaseObj->get();
                                        //Checking If Data Is Available
                                       // if($getData != 0):
                                            	  //foreach($getData as $rows):
                                                //$manage_item_info = json_decode($rows["manage_employee_info"]);
                                   ?>
                                   <!--<option><?//= $manage_item_info->empType ?></option>-->
                                   <?php
                                      
                                            //endforeach;
                                       // endif;
                                    ?>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-3">
                          <label class="control-label"><strong>Date:</strong></label>
                          <div class="form-group">
                            <div id="advance-daterange" class="btn btn-default btn-block text-left">
                            <i class="fa fa-caret-down pull-right m-t-2"></i>
                            <span id="dateRange">July 26, 2020 - August 24, 2020</span>
                            </div>
                          </div>
                          </div>
                            <div class="col-md-2">
                          <label class="control-label mr-2"><strong>Status:</strong></label>
                            <div class="form-group">
                              <select class="form-control" name="status" id="status">
                                <option value="" disabled selected> Select Status </option>
                                 <option value="Present">Present</option>
                                 <option value="Absent">Absent</option>
                                 <option value="On Leave">On Leave</option>
                                 <option value="Overtime">Overtime</option>
                            </select>
                            </div>
                          </div>
                
                <div class="col-md-3">
                  <label class="control-label mr-2"><strong></strong></label>
                  <button class="btn btn-success btn-sm" id="show_leave" style="margin-top:28px;">Show Attendance Report</button>
                </div>
              </div>

    <div class="panel-body" id="attandance_report_table">
    
    </div>
  
                     </div>
                  </div>
               </div>
            </div>
         </div>
 <?php include($view_path.'admin/include/footer.php') ?>   
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
      </script>
<script src="<?=base_url();?>assets/plugins/select2/dist/js/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/moment/min/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/demo/form-plugins.demo.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js" type="text/javascript"></script>
      <script src="<?php echo base_url() ?>assets/js/demo/table-manage-buttons.demo.js"></script>
 <script> 
  $(".default-select2").select2();
         $(document).ready(function(){                   
                $("#show_leave").click(function(){
                    var employee_id=$('#employee_id').val();
                    var status=$('#status').val();
                    var storeid=$('#emp_store_name').val();
                     var dateRange = $('#dateRange').html();
                    var startDate = getDateYMD(dateRange.split(' - ')[0]);  // return 2018-10-21
                    var endDate = getDateYMD(dateRange.split(' - ')[1]);
                    $.ajax({
                          url:"<?php echo base_url();?>admin/Attendance/show_attendance_report_view/",
                          method:"POST",
                          data:{"employee_id":employee_id,"start_date":startDate,"end_date":endDate,'status':status,'storeid':storeid},
                          success:function(data)
                          {
                              $("#attandance_report_table").html(data);
                              $('#data-table-buttons').DataTable({
                                  dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
                                  buttons: [{
                                      extend: 'copy',
                                      className: 'btn-sm'
                                  }, {
                                      extend: 'csv',
                                      className: 'btn-sm'
                                  }, {
                                      extend: 'excel',
                                      className: 'btn-sm'
                                  }, {
                                      extend: 'pdf',
                                      className: 'btn-sm'
                                  }, {
                                      extend: 'print',
                                      className: 'btn-sm'
                                  }],
                                  responsive: true
                              });
                          }
                   })
              });
                  // function for convert string to date formateS
                function getDateYMD(strDate) {
                   var date = new Date(strDate);
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    if (day < 10) {
                        day = "0" + day;
                    }
                    if (month < 10) {
                        month = "0" + month;
                    }
                    var date =  year + "-" + month + "-" +day; 
                     return date;
                }
            });

        </script> 

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