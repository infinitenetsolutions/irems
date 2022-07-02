<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<style>
  .spinner_load {
position: absolute; display: none; width: 100%;min-height: 150px;height: 100%;background: #ffffff99;top: 0;left: 0;text-align: center;padding-top: 5%;
}
body #gritter-notice-wrapper {
    width: 420px;
    z-index: 1099;
}
</style>



<div id="content" class="content">
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Loan Approval</a></li>
  </ol>
  <h1 class="page-header">Loan Approval</h1>
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


<!-- Edit Data modal end -->
<div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Pay EMI</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal lead_insert_form" onsubmit="return update_data(this)" method="post" enctype="multipart/form-data" >
          <div class="row">
            <div class="col-xl-12" id="form-data">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit data Model end-->






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
<script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>

<!-- datatable links end -->
<script type="text/javascript">
function load_data_table(){

$('.spinner_load').show();
  $.ajax({
    url:'<?php echo base_url();?>admin/attendance/fetchAllLoanApprovalData',
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
  
  //  edit popoup  function
  function editData(input) {
    id=$(input).data('id');
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/attendance/editData",      
      data:{"edit_id":id},
      success: function(data){
        $('#form-data').html(data);
        }
    });
  }
  
  
   function getAmount() {
    var loanEmi = $('#loan_emi').val();
      $("#remaining_amount").val(Number($('#last_payment_amount').val() - loanEmi));

  
      }
  
  
  function update_data(form) {
 var formData = new FormData(form);
  $.ajax({
    url: "<?php echo base_url('admin/attendance/update_data'); ?>",
    type: "POST",  
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
     // $('#save_leads').prop( "disabled", false );
      var response = JSON.parse(data);
      if (response.status == true) {
         $("#editData").modal('hide');
         $.gritter.add({
                    title: 'Hurray!!',
                    text: response.msg,
                    class_name: 'bg-success'
                });
      } else {
        $.gritter.add({
          title: 'Something went wrong',
          text: response.msg,
          class_name: 'bg-red-darker'
        });
      }
    }
  });
  return false;
}
  
  
</script>