<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<style>
  .mt-3, .my-3 {
    margin-top: 20px !important;
}
.font-bold{
  font-weight: bold;
}
.ml-2, .mx-2 {
    margin-left: 10px !important;
}
.mr-2, .mx-2 {
    margin-right: 10px !important;
}

body #gritter-notice-wrapper {
    width: 420px;
    z-index: 1099;
}
.placeholder {
    width: 94%;
    display: none;
    height: auto;
    position: absolute;
    border: 1px solid #ddd;
    background: #fff;
    z-index: 9;
    overflow: scroll;
    overflow-x: hidden;
    border-radius: 5px;
    margin-top: 5px;
    list-style: none;
    padding: 0;
    margin-bottom: 0;
    max-height: 200px;
}

.placeholder li:hover{
  background: #ddd;
  color: #333;
}
.placeholder li{
  padding:0.4375rem 0.75rem;
  border-bottom: 1px solid #ddd;
  cursor: pointer;
}
.placeholder li:last-child{
  border-bottom: 0;
}
.modal-loader{
    display: none;
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 99;
    background: #ffffffc4;
    border-radius: .5em;
}
</style>

<div id="content" class="content">

<ol class="breadcrumb float-xl-right">
<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
<li class="breadcrumb-item"><a href="javascript:;">Packaging Attribute</a></li>
</ol>


<h1 class="page-header">Packaging Attribute</h1>
<div class="row"> 
<div class="col-xl-12">
   <?php $i=1;  foreach($products as $value) {

        $p_id = $value['p_id'];
       $packetDetails = $this->pacm->getPacketbypidSortASC($p_id);
        // echo "<pre>";
        // print_r($packetDetails);
    ?>
<div id="accordion" class="accordion">
<div class="card bg-white text-black">
<div class="card-header bg-dark-darker pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapse<?=$i?>" style="color:white;">
<i class="fa fa-circle fa-fw text-white mr-2 f-s-8"></i> <?= $value['p_name']; ?>
</div>
<div id="collapse<?=$i?>" class="collapse" data-parent="#accordion">
<div class="card-body">
     <?php  foreach($packetDetails as $packets) {  ?>
        <div class="row" id="">
        <div class="col-4">
        <label>Packet Size</label>
        <input type="text" name="" value="<?= $packets['size']?>" autocomplete="" class="form-control" onkeyup="">
        <ul class="placeholder" id="placeholder"></ul>
        </div>
        <div class="col-3">
        <label>Packet Unit</label>
        <input type="text" name="" value="<?= $packets['unit']?>" class="form-control"></div>

        <div class="col-2">
        <button class="btn btn-sm btn-warning pull-right mt-3" type="button" onclick="getpackagingattr(<?=$packets['p_id']?>,<?=$packets['pac_id']?>)">Configure Attribute</button>

        </div>

        <div class="col-2">
        <button class="btn btn-sm btn-success pull-right mt-3" type="button" onclick="getnutritionalfact(<?=$packets['p_id']?>,<?=$packets['pac_id']?>)">Nutritional Facts</button>

        </div>
        </div>

      <?php } ?>

        </div>
        </div>
        </div>

</div>

<?php $i++;} ?>




    </div>

    </div>

    </div>




<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

</div>
 
<!-- Packaging Attribute MODAL -->
<div class="modal fade" id="viewpackagingattrmodal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">

</div>
</div>
</div>
<!--  Packaging Attribute MODAL -->



 <?php include($view_path.'admin/include/footer.php')  ?>

<script src="<?=base_url()?>assets/plugins/form-repeater/jquery.repeater.min.js"></script>
<script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>

<script>

function getpackagingattr(p_id,pac_id) {
          
              $.ajax({
              type: "POST",
              url: "<?php echo site_url('admin/Inventory/fetch_packagingattr'); ?>",      
              data:{"p_id":p_id,"pac_id":pac_id},
              success: function(data){

              $('#viewpackagingattrmodal .modal-content').html(data);
              $('#viewpackagingattrmodal').modal('show');

              $(".file-repeater").repeater({
              show: function () {
              $(this).slideDown()
              },
              hide: function (e) {
              confirm("Are you sure you want to remove this item?") && $(this).slideUp(e)
              }
              })

              }

              });

            }



            function getnutritionalfact(p_id,pac_id) {
          
              $.ajax({
              type: "POST",
              url: "<?php echo site_url('admin/Inventory/fetch_nutrifact'); ?>",      
              data:{"p_id":p_id,"pac_id":pac_id},
              success: function(data){

              $('#viewpackagingattrmodal .modal-content').html(data);
              $('#viewpackagingattrmodal').modal('show');

              $(".file-repeater").repeater({
              show: function () {
              $(this).slideDown()
              },
              hide: function (e) {
              confirm("Are you sure you want to remove this item?") && $(this).slideUp(e)
              }
              })

              }

              });

            }

            



          function submitnutrifactform(form) {
          $('.modal-loader').show();
          var form_data = $(form).serialize();
          $.ajax({
          url:'<?=site_url('admin/Inventory/submitnutrifactform')?>',
          type:'POST',
          data:form_data,
          success:function(data) {
          $('.modal-loader').hide();
          var response = JSON.parse(data);
          if(response.status == true){
          $.gritter.add({
          title: 'Hurray!!',
          text: response.message,
          class_name: 'bg-success'
          });
          }else{
          $.gritter.add({
          title: 'Something went wrong',
          text: response.message,
          class_name: 'bg-red-darker'
          });
          }
          }
          });
          return false;
          }


           function submitpackagingattrform(form) {
          $('.modal-loader').show();
          var form_data = $(form).serialize();
          $.ajax({
          url:'<?=site_url('admin/Inventory/submitpackagingattrform')?>',
          type:'POST',
          data:form_data,
          success:function(data) {
          $('.modal-loader').hide();
          var response = JSON.parse(data);
          if(response.status == true){
          $.gritter.add({
          title: 'Hurray!!',
          text: response.message,
          class_name: 'bg-success'
          });
          }else{
          $.gritter.add({
          title: 'Something went wrong',
          text: response.message,
          class_name: 'bg-red-darker'
          });
          }
          }
          });
          return false;
          }



  var currentRequest = null; 
function getplaceholdervalues(input) {
  var form_data = {"key":$(input).val()};
  currentRequest =  $.ajax({
      url:'<?=site_url('admin/Inventory/getplaceholdervalues')?>',
      type:'POST',
      data:form_data,
            beforeSend : function()    {           
                if(currentRequest != null && currentRequest.readyState < 4) {
                    currentRequest.abort();
                }
            },
      success:function(data) {
        // console.log(data);
        $(input).siblings('.placeholder').show().html(data);
      }
    });
}


var currentRequest = null; 
function getplaceholdervalues1(input) {
  var form_data = {"key":$(input).val()};
  currentRequest =  $.ajax({
      url:'<?=site_url('admin/Inventory/getplaceholdervalues1')?>',
      type:'POST',
      data:form_data,
            beforeSend : function()    {           
                if(currentRequest != null && currentRequest.readyState < 4) {
                    currentRequest.abort();
                }
            },
      success:function(data) {
        // console.log(data);
        $(input).siblings('.placeholder').show().html(data);
      }
    });
}


  function delete_attr(attr_id) {
  $('.modal-loader').show();
  var form_data = {"attr_id":attr_id};
  $.ajax({
      url:'<?=site_url('admin/Inventory/delete_attr')?>',
      type:'POST',
      data:form_data,
      success:function(data) {
        $('.modal-loader').hide();
        var response = JSON.parse(data);
        if(response.status == true){
          $.gritter.add({
            title: 'Hurray!!',
            text: response.message,
            class_name: 'bg-success'
          });
          $('#wm_row_'+attr_id).detach();
        }else{
          $.gritter.add({
            title: 'Something went wrong',
            text: response.message,
            class_name: 'bg-red-darker'
          });
        }
      }
    }); 
}


function getthisvalue(li){
  var val = $(li).text();
  $(li).parent().siblings('input').val(val);
}


function getthisvalue1(li){
  var val = $(li).text();
  $(li).parent().siblings('input').val(val);
}


$(document).mouseup(function (e) { 
            if ($(e.target).closest(".placeholder").length 
                        === 0) { 
                $(".placeholder").hide(); 
            } 
        }); 



</script>




