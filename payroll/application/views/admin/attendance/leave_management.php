<div id="content" class="content">
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Leave Management</a></li>
  </ol>
  <h1 class="page-header">Leave Management</h1>
  <div class="row">
    <div class="col-xl-12">
      
      <div class="panel panel-inverse">
        <div class="panel-heading">
          <h4 class="panel-title">&nbsp;&nbsp;&nbsp;</h4>
          <!-- <a href="#modal-dialog" class="btn btn-success btn-sm" data-toggle="modal">Demo</a>
          --><div class="panel-heading-btn">
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
<script type="text/javascript">
function load_data_table(){

$('.spinner_load').show();
  $.ajax({
    url:'<?php echo base_url();?>admin/attendance/fetchAllEmployeeLeaveData',
    method: 'POST',
    data: {},
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