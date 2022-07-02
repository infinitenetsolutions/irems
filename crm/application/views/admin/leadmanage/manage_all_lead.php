<?php
      require_once("classes-and-objects/config.php");
     require_once("classes-and-objects/veriables.php"); 
    require_once("classes-and-objects/authentication.php");
    require_once("classes-and-objects/PHPExcel/PHPExcel.php");

?>

<script src="<?=base_url()?>assets/plugins/moment/min/moment.min.js" type="text/javascript"></script>
<link href="<?=base_url()?>assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<style>
  .spinner_load {

position: absolute; display: none; width: 100%;min-height: 150px;height: 100%;background: #ffffff99;top: 0;left: 0;text-align: center;padding-top: 5%;
}
</style>


<div id="content" class="content">

<ol class="breadcrumb float-xl-right">
<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
<li class="breadcrumb-item"><a href="javascript:;">Manage Advertisements Leads</a></li>
</ol>

<h1 class="page-header">Manage Advertisements Leads</h1>

<?php
    $admin_id =  $this->uri->segment(4);
    //echo $admin_id; 
//$userId = $this->session->userdata('username');
//echo $userId; ?>

<div class="row">
   <div class="col-xl-12 mt-3">
      <ul class="nav nav-tabs">
        <li class="nav-item">
            <a id="default_click" href="#dataresultId" data-status = "TODAY"  data-toggle="tab" class="nav-link l_sts_btn active">
            <span class="d-sm-none">Todays Leads</span>
            <span class="d-sm-block d-none">Todays Leads</span>
            </a>
         </li>
         <li class="nav-item">
            <a  href="#dataresultId" data-status = "FUTURE"  data-toggle="tab" class="nav-link l_sts_btn">
            <span class="d-sm-none">Future Leads</span>
            <span class="d-sm-block d-none">Future Leads</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="#dataresultId" data-status = "SUCCESS" data-toggle="tab" class="nav-link l_sts_btn">
            <span class="d-sm-none">Success Leads</span>
            <span class="d-sm-block d-none">Success Leads</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="#dataresultId" data-status = "FAILED" data-toggle="tab" class="nav-link l_sts_btn">
            <span class="d-sm-none">Failed Leads</span>
            <span class="d-sm-block d-none">Failed Leads</span>
            </a>
         </li>
      </ul>
      <div class="tab-content">
        <div class="spinner_load panel-loader"><span class="spinner-small"></span></div>
        <!--  <div class="spinner_load"><img src="<?= base_url()?>assets\img\logo\loader.gif"></div> -->
         <div class="tab-pane fade active show table-responsive" id="dataresultId">
         </div>
      </div>
   </div>
</div>
    </div>

<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

</div>
 
<div class="modal fade" id="viewpaymentdetailmodal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">

</div>
</div>
</div>
 <?php include($view_path.'admin/include/footer.php')  ?>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-fixedheader/js/dataTables.fixedheader.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-fixedheader-bs4/js/fixedheader.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/pdfmake/build/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/jszip/dist/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-fixedcolumns/js/dataTables.fixedcolumns.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-fixedcolumns-bs4/js/fixedcolumns.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
<script>
$(document).ready(function () {
  var tab_btn = $('#default_click').data('status');
  var adv_id = <?php echo (!empty($_GET['i'])?$_GET['i']:'0');?>;
  //var user_id = <?=$this->session->userdata('user_id'); ?>;
   var admin_id = <?=$this->uri->segment(4); ?>
  // alert(tab_btn); alert(adv_id); alert(user_id);  
  

    $('.spinner_load').show();
      $.ajax({
        url:'<?php echo base_url();?>admin/leadmanage/fetch_all_lead_by_status/',
        method: 'POST',
        data: {"l_status": tab_btn,"adv_id": adv_id,"employee_id":admin_id},
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
});

  $('.l_sts_btn').click(function(){
    var tab_btn = $(this).data('status');
     var adv_id = <?php echo (!empty($_GET['i'])?$_GET['i']:'0');?>;
     var admin_id = <?=$this->uri->segment(4); ?>

    $('.spinner_load').show();
      $.ajax({
        url:'<?php echo base_url();?>admin/leadmanage/fetch_all_lead_by_status',
        method: 'POST',
        data: {"l_status": tab_btn,"adv_id": adv_id,"employee_id":admin_id},
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
  });

  function deleteAdv(adv_id) {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/Advertisement/delete_advertisment",      
      data:{"adv_id":adv_id},
      success: function(data){
        alert(data);
       var response = JSON.parse(data);
          if(response.status == true){
              $.gritter.add({
              title: 'Hurray!!',
              text: response.msg,
              class_name: 'bg-success'
              });
              location.href='<?=base_url()?>admin/advertisement/advertisment_view?t='+response.adv_type+'&i='+response.adv_id;
          }else{
            $.gritter.add({
              title: 'Something went wrong',
              text: response.msg,
              class_name: 'bg-red-darker'
            });
         }
      location.reload();
        setTimeout(function(){
        window.location.reload();
      }, 1000); 
    }
      });
  }




  function editLeadData(lead_id) {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/leadmanage/editLeadData",      
      data:{"lead_id":lead_id},
      success: function(data){
        $('#form-data').html(data);
            $(".startDateTime").datetimepicker({
               format: "YYYY-MM-DD HH:mm:ss"                                
              });
            }
    });
  }
  
  
  function editLeadTransfer(lead_id) {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/leadmanage/editLeadTransfer",      
      data:{"lead_id":lead_id},
      success: function(data){
        $('#form-data').html(data);
            //$(".startDateTime").datetimepicker({
              // format: "YYYY-MM-DD HH:mm:ss"                                
            //  });
            }
    });
  }


</script>

<!-- Modal -->
<div class="modal fade" id="editLeadData" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal lead_insert_form" onsubmit="return update_lead_data(this)" method="post" enctype="multipart/form-data" >
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


<!-- Modal -->
<div class="modal fade" id="editLeadTransfer" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal lead_insert_form" onsubmit="return update_lead_data(this)" method="post" enctype="multipart/form-data" >
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




<script type="text/javascript">
  $(".startDateTime").click(function(){
  $(this).datetimepicker({
     format: "YYYY-MM-DD HH:mm:ss"                                
  });
});

function showDateinput(select){
 if(select=="PENDING")
  {
    $('#date_followup').show();
    }
  else{
    $('#date_followup').hide();
  }
}



function update_lead_data(form) {
  var formData = $(form).serialize();
  $.ajax({
    url: "<?php echo base_url('admin/Leadmanage/update_lead'); ?>",
    type: "POST",
    data: formData,
    success: function (data) {
      $('#save_leads').prop( "disabled", false );
      var response = JSON.parse(data);
      if (response.status == true) {
        location.reload();
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