<?php 
   $page_no = 10;
    //$page_no_inside = "10_1";

?>

<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<style>
  .spinner_load {

position: absolute; display: none; width: 100%;min-height: 150px;height: 100%;background: #ffffff99;top: 0;left: 0;text-align: center;padding-top: 5%;
}
</style>


<div id="content" class="content">

<ol class="breadcrumb float-xl-right">
<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
<li class="breadcrumb-item"><a href="javascript:;">Managed Advertisements</a></li>
</ol>
<h1 class="page-header">Manage Advertisements </h1>
  <?php
   // $admin_id =  $this->uri->segment(4);
    //echo $admin_id; 
    //$userId = $this->session->userdata('username');
     // echo $userId; ?>
  
 <div class="card card-navy card-outline">
      <div class="card-body">
         <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                  <label for="employeeCategory"><strong>Advertisement Category:</strong></label>
                  <select class="form-control" name="ad_type" id="ad_type">
                     <option value="" selected="" disabled="">Select Advertisement Type</option>
                     <option value="ONLINE" title="Email Ads, Social Media Ads, Mobile Ads, Website Ads" selected="">Online Advertisement</option>
                     <option value="OFFLINE" title="Hoarding,Posters,Ad Vehicle,Leaflet Ads" >Offline Advertisement</option>
                     <option value="ELECTRONIC" title="Tv,Magazine,Radio Ads" >Commercial Advertisement</option>
                     <option value="SEMINARS" title="Product Promotion Seminar" >Seminars</option>
                     <option value="EXHIBITION" title="Product Exhibition" >Exhibition</option>
                      <option value="AGENTBROKER" title="Agent And Broker">Agent And Broker</option>
                     <option value="SALESMARKETING" title="Sales And Marketing Companies">Sales And Marketing Companies</option>
                  </select>
               </div>
            </div>
            <div class="col-md-4"></div>
             <div class="col-md-2">
              <div class="mt-4">
              <a href='<?=base_url()?>admin/advertisement/create_advertisement' type="button" class="btn btn-inverse btn-sm">Add Advertisements</a>
              </div>
            </div>
           
           <?php if($this->session->userdata('user_id') != '1' && $this->session->userdata('user_id') != '') {?>
            <div class="col-md-2">
              <div class="mt-4">
              <a href='<?=base_url()?>admin/leadmanage/manage_lead' type="button" class="btn btn-inverse btn-sm">Manage All Leads</a>
              </div>
            </div>
             <?php } ?>
           
            <?php  if($this->session->userdata('user_id') == '') {?>
            <div class="col-md-2">
              <div class="mt-4">
              <a href='<?=base_url()?>admin/leadmanage/manage_all_lead/1' type="button" class="btn btn-inverse btn-sm">Manage All Leads</a>
              </div>
            </div>
             <?php } ?>
           
         </div>
      </div>
   </div>
<style type="text/css">
  .label {
    /*top:00px;
    position: absolute;
    display: block;
    background: #00acac;
    line-height: 12px;
    font-weight: 600;
    color: #fff;
    padding: 3px 6px;
    -webkit-border-radius: 30px;
    border-radius: 30px;*/
}
</style>
<div class="row">
   <div class="col-xl-12 mt-3">
      <ul class="nav nav-tabs">
       
         <li class="nav-item">
            <a href="#dataresultId"  data-status = "RUNNING" data-toggle="tab" class="nav-link adv_sts_btn active">
            <span class="d-sm-none">Running Advertisement</span>
            <span class="d-sm-block d-none">Running Advertisement</span>
            </a>
         </li>
          <li class="nav-item">
            <a id="default_click" href="#dataresultId" data-status = "PENDING"  data-toggle="tab" class="nav-link adv_sts_btn">
            <span class="d-sm-none">Pending Advertisement</span>
            <span class="d-sm-block d-none">Pending Advertisement</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="#dataresultId"  data-status = "COMPLETED" data-toggle="tab" class="nav-link adv_sts_btn">
            <span class="d-sm-none">Completed Advertisement</span>
            <span class="d-sm-block d-none">Completed Advertisement</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="#dataresultId"  data-status = "PAUSE" data-toggle="tab" class="nav-link adv_sts_btn">
            <span class="d-sm-none">Pause Advertisement</span>
            <span class="d-sm-block d-none">Pause Advertisement</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="#dataresultId"  data-status = "CANCELED" data-toggle="tab" class="nav-link adv_sts_btn">
            <span class="d-sm-none">Canceled Orders</span>
            <span class="d-sm-block d-none">Canceled Orders</span>
            </a>
         </li>
      </ul>
      <div class="tab-content">
            <div class="spinner_load panel-loader"><span class="spinner-small"></span></div>
         <!-- <div class="spinner_load"><img src="<?= base_url()?>assets\img\loader.gif"></div> -->
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
<script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
<script>

  function load_adv_table(){
    var elmId = $('#ad_type').val();
    var tab_btn = $('.adv_sts_btn.active').data('status');
    $('.spinner_load').show();
      $.ajax({
        url:'<?php echo base_url();?>admin/Advertisement/fetch_all_OrdersByOrderStatus',
        method: 'POST',
        data: {"adv_status": tab_btn, "adv_category": elmId},
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
  load_adv_table();

  $('#ad_type').change(function(){
    var elmId = $(this).val();
    var tab_btn = $('.adv_sts_btn').data('status');
    $('.spinner_load').show();
      $.ajax({
        url:'<?php echo base_url();?>admin/Advertisement/fetch_all_OrdersByOrderStatus',
        method: 'POST',
        data: {"adv_status":tab_btn,"adv_category": elmId},
        success: function(response){
        $('.spinner_load').hide();
        $('#dataresultId').html(response); 
         $('#dataresultId table').DataTable({
                                  dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
                                  buttons: [{ extend: 'excel',
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

  $('.adv_sts_btn').click(function(){
    var elmId = $('#ad_type').val();
    var tab_btn = $(this).data('status');
    $('.spinner_load').show();
      $.ajax({
        url:'<?php echo base_url();?>admin/Advertisement/fetch_all_OrdersByOrderStatus',
        method: 'POST',
        data: {"adv_status":tab_btn,"adv_category": elmId},
        success: function(response){
        $('.spinner_load').hide();
        $('#dataresultId').html(response); 
         $('#dataresultId table').DataTable({
                                  dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
                                  buttons: [{ extend: 'excel',
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

    if(confirm('Do you really want to delete this advertisment?')){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/Advertisement/delete_advertisment",      
      data:{"adv_id":adv_id},
      success: function(data){
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
  }


function update_adv_sts(input){
      var adv_status = $(input).val();
      var adv_id = $(input).data('adv_id');
      console.log(adv_status);
      console.log(adv_id);
      if(adv_status!=null){
            $('.spinner_load').show();
      $.ajax({
        url:'<?php echo base_url();?>admin/Advertisement/update_adv_status',
        method: 'POST',
        data: {"adv_status":adv_status,"adv_id":adv_id},
        success: function(response){
          var response = JSON.parse(response);
          if(response.status == true){
             load_adv_table();
          }else{
            $.gritter.add({
              title: 'Something went wrong',
              text: response.msg,
              class_name: 'bg-red-darker'
            });
         }
        }
     });
      }else{
          $.gritter.add({
              title: 'Something went wrong',
              text: 'Unable to update try again!',
              class_name: 'bg-red-darker'
            });
      }
      }

</script>


