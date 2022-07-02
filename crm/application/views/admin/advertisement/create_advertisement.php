<link href="<?=base_url()?>assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/plugins/moment/min/moment.min.js" type="text/javascript"></script>
<link href="<?=base_url()?>assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<style type="text/css">
   .dispaly-none{
      display: none;
   }
   .dipaly-show{
      display: block;
   }
</style>
<div id="content" class="content">
   <ol class="breadcrumb float-xl-right">
      <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript:;">Advertisement</a></li>
   </ol>
   <h1 class="page-header">Add Advertisement </h1>
   <?php if($this->session->flashdata('success')): ?>
   <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
   <?php endif; ?>
   <?php if($this->session->flashdata('danger')): ?>
   <p class="alert alert-danger"><?php echo $this->session->flashdata('danger'); ?></p>
   <?php endif; ?>
   <div class="card card-navy card-outline">
      <div class="card-body">
         <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                  <label for="employeeCategory"><strong>Advertisement Type:</strong></label>
                  <select class="form-control" name="ad_type" id="ad_type">
                     <option value="" selected="" disabled="">Select Advertisement Type</option>
                     <option value="online" title="Email Ads, Social Media Ads, Mobile Ads, Website Ads">Online Advertisement</option>
                     <option value="offline" title="Hoarding,Posters,Ad Vehicle,Leaflet Ads">Offline Advertisement</option>
                     <option value="commercial" title="Tv,Magazine,Radio Ads">Commercial Advertisement</option>
                     <option value="seminars" title="Product Promotion Seminar">Seminars</option>
                     <option value="exhibition" title="Product Exhibition">Exhibition</option>
                     <option value="agentBroker" title="Agent And Broker">Agent And Broker</option>
                     <option value="salesMarketing" title="Sales And Marketing Companies">Sales And Marketing Companies</option>
                  </select>
               </div>
            </div>
            <div class="col-md-4">
              </div>
              <div class="col-md-4 mt-4">
                <a href='<?=base_url()?>admin/advertisement/manage_advertisement' type="button" class="btn btn-inverse btn-sm mr-5">Manage Advertisement</a>
              </div>
         </div>
      </div>
   </div>
   <!-- online Advertisement form start  -->
   <div class="panel panel-inverse mt-3 hidden form_panel" id="adv_form" data-sortable-id="form-plugins-4">
</div>
<?php include($view_path.'admin/include/footer.php');?>
<script src="<?=base_url()?>assets/plugins/tag-it/js/tag-it.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 --><script type="text/javascript">
   $( "#ad_type" ).change(function() {
       var ad_type=$(this).val();
           $.ajax({
               url: "<?php echo base_url('admin/Advertisement/input_form_creator'); ?>",
               type: "POST",
               data: {"ad_type": ad_type},
               success: function (data) {
                 $('#adv_form').html(data);
                 $('#adv_link').tagit();
               }
             });
      }); 

   
function insert_advertisement(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: "<?php echo base_url('admin/Advertisement/insert_advertisement'); ?>",
                        type: "POST",
                        data: formData,
                        // cache: false,
                        contentType: false,
                        // contentType: 'multipart/form-data', 
                        processData: false,
                        success: function (data) {
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
                        }
                      });
                    return false;
}
                  
</script>

