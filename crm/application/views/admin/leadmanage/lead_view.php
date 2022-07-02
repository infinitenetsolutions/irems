<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
      <li class="breadcrumb-item"><a href="javascript:;">View Advertisement</a></li>
   </ol>
   <h1 class="page-header">View Advertisement</h1>
   <?php if($this->session->flashdata('success')): ?>
   <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
   <?php endif; ?>
   <?php if($this->session->flashdata('danger')): ?>
   <p class="alert alert-danger"><?php echo $this->session->flashdata('danger'); ?></p>
   <?php endif; ?>
   <!-- online Advertisement form start  -->
   <div class="panel panel-inverse mt-3 hidden form_panel" id="adv_form" data-sortable-id="form-plugins-4">
       <?php
       $ad_type=$_GET['t'];
       $adv_id=$_GET['i'];
        if ($ad_type == 'ONLINE')
        {   ?>
      <div class="panel-heading">
         <h4 class="panel-title">Online Advertisement</h4>
         <a href="<?=base_url();?>admin/advertisement/manage_advertisement" class="btn btn-sm btn-default float-right mr-3"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back</a>
         <button type="button" class="btn btn-sm btn-warning float-right edit_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button> 
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="online_ad_form" class="form-horizontal" onsubmit="return edit_advertisement(this)" method="POST" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Title : </strong></label>
                     <input class="form-control" type="hidden" name="adv_id" id="adv_id" value="<?=$adv_id?>">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true" value="<?= $advertisement['adv_name'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Online Advertisement Type : </strong></label>
                     <input class="form-control" type="text" name="adv_type" id="adv_type" required="true" placeholder="E.g Image, Vidoe, Audio" value="<?= $advertisement['adv_type'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Platform :<span id="empid_msg"></span></strong></label>
                     <input class="form-control" type="text" name="adv_platform" id="adv_platform" required="true" placeholder="E.g Facebook, Instagram, Youtube etc" value="<?= $advertisement['adv_platform'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Manage By (Department): </strong></label>
                     <select class="form-control" name="manage_depart" id="manage_depart" disabled="">
                        <option value="" selected="" disabled="">Select Department Name</option>
                  <?php foreach ($department as $dpartrow)
                  { ?>
                    <option value="<?php echo $dpartrow['id']; ?>" <?php if($dpartrow['id'] == $advertisement['manage_depart']){ echo 'selected';} ?>><?php echo $dpartrow['department_name']; ?></option>
                 <?php }?></select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group" id="emp_name">
                           <span id="emp_input" class="dipaly-show">
                           <label class="control-label"><strong>Manage By (Employee): </strong></label>
                           <select class="form-control" name="adv_empid" id="adv_empid" disabled="">
                        <?php foreach ($employee as $emprow)
                           { ?>
                             <option value="<?php echo $emprow['id']; ?>" <?php if($emprow['id'] == $advertisement['adv_empid']){ echo 'selected';} ?>><?php echo $emprow['first_name'].' '.$emprow['last_name']; ?></option>
                          <?php }?>

                           </select>

                           </span>
                        <span id="third_party" class="dispaly-none">
                        <label class="control-label"><strong>Company/Vendor Name:</strong></label><input type="text" class="form-control" id="adv_vendor" name="adv_vendor" value="<?= $advertisement['adv_vendor'];?>" readonly>
                        </span>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Start Date:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true" value="<?= $advertisement['adv_startdate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement End Date:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" value="<?= $advertisement['adv_enddate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Pay Type :</strong></label>
                     <input type="text" class="form-control" id="ad_chargetype" name="ad_chargetype"  required="true" placeholder="E.g Pay-per-click etc" value="<?= $advertisement['ad_chargetype'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true" value="<?= $advertisement['adv_budget'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true" value="<?= $advertisement['adv_amt'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file" readonly>
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Existing Image:</strong></label>
                     <?php if(!empty($advertisement['adv_img'])){?>
                     <img  class="form-control img-fluid" src="../../upload/advertisement/<?=$advertisement['adv_img'];?>" alt="" style="width:100px;height: auto;">
                      <?php }else{
                        echo "No Image Preset";
                      }?>
                  </div>
               </div>
         
               <div class="col-md-12">
                  <div id="response" class="form-group">
                     <?php $adv_link=json_decode($advertisement['adv_link']);?>
                     <label for=""><strong>Advertisement Links:</strong></label>
                     <input type="text" id="adv_link" name="adv_link" data-role="tagsinput" value="<?=(!is_array($adv_link)?$advertisement['adv_link']:implode(',', $adv_link));?>" readonly />
                  </div>
               </div>
               <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for=""><strong>Advertisement Description:</strong></label>
                     <textarea class="form-control m-b-2"  rows="3" id="adv_desc" name="adv_desc" readonly><?= $advertisement['adv_desc'];?></textarea>
                  </div>
               </div>
               <div class="savebtn_div">
                  <button type='submit' class='btn btn-warning ml-3 save_btn'>Save</button>
               </div>
            </div>
            </form></div></div>
        <?php }
        if ($ad_type == 'OFFLINE')
        {   ?>
        <div class="panel-heading">
         <h4 class="panel-title">Offline Advertisement</h4>
         <button type="button" class="btn btn-sm btn-warning float-right edit_btn" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="offline_ad_form" class="form-horizontal" onsubmit="return edit_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Title : </strong></label>
                     <input class="form-control" type="hidden" name="adv_id" id="adv_id" value="<?=$adv_id?>">
                     <input class="form-control" type="text"  name="adv_name" id="adv_name" required="true" value="<?= $advertisement['adv_name'];?>" readonly>

                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Offline Advertisement Type : </strong></label>
                     <input class="form-control" type="text" name="adv_type" id="adv_type" required="true" placeholder="E.g Posters, Hoardings, Ad Vehicles"  value="<?= $advertisement['adv_type'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Name :</strong></label>
                     <input class="form-control" type="text" name="adv_area" id="adv_area" required="true"  value="<?= $advertisement['adv_area'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Pincode :</strong></label>
                     <input class="form-control" type="number" name="adv_areapin" id="adv_areapin" required="true"  value="<?= $advertisement['adv_areapin'];?>" readonly>
                  </div>
               </div>
                 <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>No. Of Posters/Hoadings/Leaflet :</strong></label>
                     <input class="form-control" type="number" name="poster_no" id="poster_no" required="true" value="<?= $advertisement['poster_no'];?>" readonly>
                  </div>
               </div>
            
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Manage By (Department):</strong></label>
                     <select class="form-control" name="manage_depart" id="manage_depart" disabled="">
                        <option value="" selected="" disabled="">Select Department Name</option>
                  <?php foreach ($department as $dpartrow)
                  { ?>
                    <option value="<?php echo $dpartrow['id']; ?>" <?php if($dpartrow['id'] == $advertisement['manage_depart']){ echo 'selected';} ?>><?php echo $dpartrow['department_name']; ?></option>
                 <?php }?></select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group" id="emp_name">
                   <span id="emp_input" class="dipaly-show">
                     <label class="control-label"><strong>Manage By (Employee): </strong></label>
                     <select class="form-control" name="adv_empid" id="adv_empid" disabled="">
                        <?php foreach ($employee as $emprow)
                           { ?>
                             <option value="<?php echo $emprow['id']; ?>" <?php if($emprow['id'] == $advertisement['adv_empid']){ echo 'selected';} ?>><?php echo $emprow['first_name'].' '.$emprow['last_name']; ?></option>
                          <?php }?>

                           </select>

                        </span>
                        <span id="third_party" class="dispaly-none">
                        <label class="control-label"><strong>Company/Vendor Name:</strong></label><input type="text" class="form-control" id="adv_vendor1" name="adv_vendor" value="<?= $advertisement['adv_vendor'];?>" readonly>
                        </span>
                  </div>
               </div>
              <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Start Date:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true" value="<?= $advertisement['adv_startdate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement End Date:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" value="<?= $advertisement['adv_enddate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true" value="<?= $advertisement['adv_budget'];?>" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true" value="<?= $advertisement['adv_amt'];?>" readonly> 
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file" readonly>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Existing Image:</strong></label>
                     <?php if(!empty($advertisement['adv_img'])){?>
                     <img  class="form-control img-fluid" src="../../upload/advertisement/<?=$advertisement['adv_img'];?>" alt="" style="width:100px;height: auto;">
                      <?php }else{
                        echo "No Image Preset";
                      }?>
                  </div>
               </div>
                <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for=""><strong>Advertisement Description:</strong></label>
                     <textarea class="form-control m-b-2"  rows="3" id="adv_desc" name="adv_desc" readonly><?= $advertisement['adv_desc']?></textarea>
                  </div>
               </div>
               <div class="savebtn_div">
                  <button type='submit' class='btn btn-warning ml-3 save_btn'>Save</button>
               </div>
            </div>
            </form></div></div>
       <?php  }
        if ($ad_type == 'SEMINARS')
        {   ?>
         <div class="panel-heading">
         <h4 class="panel-title">Seminars</h4>
         <button type="button" class="btn btn-sm btn-warning float-right edit_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="seminar_ad_form" class="form-horizontal" onsubmit="return edit_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar Title : </strong></label>
                      <input class="form-control" type="hidden" name="adv_id" id="adv_id" value="<?=$adv_id?>">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true" readonly value="<?= $advertisement['adv_name'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Name :</strong></label>
                     <input class="form-control" type="text" name="adv_area" id="adv_area" required="true" readonly value="<?= $advertisement['adv_area'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Pincode :</strong></label>
                     <input class="form-control" type="number" name="adv_areapin" id="adv_areapin" required="true" readonly value="<?= $advertisement['adv_areapin'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Manage By (Department) : </strong></label>
                    <select class="form-control" name="manage_depart" id="manage_depart" disabled="">
                        <option value="" selected="" disabled="">Select Department Name</option>
                  <?php foreach ($department as $dpartrow)
                  { ?>
                    <option value="<?php echo $dpartrow['id']; ?>" <?php if($dpartrow['id'] == $advertisement['manage_depart']){ echo 'selected';} ?>><?php echo $dpartrow['department_name']; ?></option>
                 <?php }?></select>
                  </div>
               </div>
                   <div class="col-md-4 dispaly-none" id="third_party">
                  <div id="response" class="form-group">
                    <label class="control-label"><strong>Company/Vendor Name:</strong></label>
                    <input type="text" class="form-control" id="adv_vendor" name="adv_vendor" readonly value="<?= $advertisement['adv_vendor'];?>">
                  </div>
               </div>

               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar Guest Names :</strong></label>
                     <input type="text" class="form-control" id="guest_name" name="guest_name" required="true" readonly value="<?= $advertisement['guest_name'];?>">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar Topics :</strong></label>
                     <input type="text" class="form-control" id="seminar_topic" name="seminar_topic" required="true" readonly value="<?= $advertisement['seminar_topic'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar Start Date & Time:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true" value="<?= $advertisement['adv_startdate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar End Date & Time:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" value="<?= $advertisement['adv_enddate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true" readonly value="<?= $advertisement['adv_budget'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true" readonly value="<?= $advertisement['adv_amt'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file" readonly>                    
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Existing Image:</strong></label>
                     <?php if(!empty($advertisement['adv_img'])){?>
                     <img  class="form-control img-fluid" src="../../upload/advertisement/<?=$advertisement['adv_img'];?>" alt="" style="width:100px;height: auto;">
                      <?php }else{
                        echo "No Image Preset";
                      }?>
                  </div>
               </div>
                 <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for=""><strong>Seminar Description:</strong></label>
                     <textarea class="form-control m-b-2"  rows="3" id="adv_desc" name="adv_desc" readonly><?=$advertisement['adv_desc'];?></textarea>
                  </div>
               </div>
               <div class="savebtn_div">
                  <button type='submit' class='btn btn-warning ml-3 save_btn'>Save</button>
               </div>
            </div>
        </form></div></div>
        <?php }
        if ($ad_type == 'EXHIBITION')
        { ?>
            <div class="panel-heading">
         <h4 class="panel-title">Exhibition</h4>
         <button type="button" class="btn btn-sm btn-warning float-right edit_btn" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body"><form id="exhibition_ad_form" class="form-horizontal" onsubmit="return edit_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition Title : </strong></label>
                       <input class="form-control" type="hidden" name="adv_id" id="adv_id" value="<?=$adv_id?>">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true" readonly value="<?=$advertisement['adv_name'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Name :</strong></label>
                     <input class="form-control" type="text" name="adv_area" id="adv_area" required="true" readonly value="<?=$advertisement['adv_area'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Pincode :</strong></label>
                     <input class="form-control" type="number" name="adv_areapin" id="adv_areapin" required="true" readonly value="<?=$advertisement['adv_areapin'];?>">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Manage By (Department) : </strong></label>
                    <select class="form-control" name="manage_depart" id="manage_depart" disabled="">
                        <option value="" selected="" disabled="">Select Department Name</option>
                  <?php foreach ($department as $dpartrow)
                  { ?>
                    <option value="<?php echo $dpartrow['id']; ?>" <?php if($dpartrow['id'] == $advertisement['manage_depart']){ echo 'selected';} ?>><?php echo $dpartrow['department_name']; ?></option>
                 <?php }?></select>
                  </div>
               </div>
                   <div class="col-md-4 dispaly-none" id="third_party">
                  <div id="response" class="form-group">
                    <label class="control-label"><strong>Company/Vendor Name:</strong></label>
                    <input type="text" class="form-control" id="adv_vendor" name="adv_vendor" readonly value="<?=$advertisement['adv_vendor'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition Start Date & Time:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true" value="<?= $advertisement['adv_startdate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition End Date & Time:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" value="<?= $advertisement['adv_enddate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true" readonly value="<?=$advertisement['adv_budget'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true" readonly value="<?=$advertisement['adv_amt'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file" readonly value="<?=$advertisement['adv_img'];?>">
                    
                  </div>
               </div>
                 <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Existing Image:</strong></label>
                     <?php if(!empty($advertisement['adv_img'])){?>
                     <img  class="form-control img-fluid" src="../../upload/advertisement/<?=$advertisement['adv_img'];?>" alt="" style="width:100px;height: auto;">
                      <?php }else{
                        echo "No Image Preset";
                      }?>
                  </div>
               </div>
               <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for=""><strong>Exhibition Description:</strong></label>
                     <textarea class="form-control m-b-2"  rows="3" id="exhibition_ad_desc" name="exhibition_ad_desc" readonly><?=$advertisement['exhibition_ad_desc'];?></textarea>
                  </div>
               </div>
               <div class="savebtn_div">
                  <button type='submit' class='btn btn-warning ml-3 save_btn'>Save</button>
               </div>
            </div>
            </form></div></div>
        <?php }
        if ($ad_type == 'ELECTRONIC')
        {?>
         <div class="panel-heading">
         <h4 class="panel-title">Commercial Advertisement</h4>
         <button type="button" class="btn btn-sm btn-warning float-right edit_btn" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="commercial_ad_form" class="form-horizontal" onsubmit="return edit_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Title : </strong></label>  
                       <input class="form-control" type="hidden" name="adv_id" id="adv_id" value="<?=$adv_id?>">
                     <input class="form-control" type="text" name="adv_type" id="adv_type" required="true" readonly value="<?=$advertisement['adv_type'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Vendor/Company Name : </strong></label>
                     <input class="form-control" type="text" name="adv_vendor" id="adv_vendor" required="true" readonly value="<?=$advertisement['adv_vendor'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Manage By (Department) : </strong></label>
                     <select class="form-control" name="manage_depart" id="manage_depart" disabled="">
                        <option value="" selected="" disabled="">Select Department Name</option>
                  <?php foreach ($department as $dpartrow)
                  { ?>
                    <option value="<?php echo $dpartrow['id']; ?>" <?php if($dpartrow['id'] == $advertisement['manage_depart']){ echo 'selected';} ?>><?php echo $dpartrow['department_name'];?></option>
                 <?php }?></select>
                  </div>
               </div>
               <div class="col-md-4 dispaly-none" id="third_party">
                  <div id="response" class="form-group">
                    <label class="control-label"><strong>Company/Vendor Name:</strong></label>
                    <input type="text" class="form-control" id="adv_vendor" name="adv_vendor" readonly value="<?=$advertisement['adv_vendor'];?>">
                  </div>
               </div>
                    <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition Start Date & Time:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true" value="<?= $advertisement['adv_startdate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition End Date & Time:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" value="<?= $advertisement['adv_enddate'];?>" readonly>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true" readonly value="<?=$advertisement['adv_budget'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true" readonly value="<?=$advertisement['adv_amt'];?>">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file" readonly value="<?=$advertisement['adv_img'];?>">
                  </div>
               </div>
                 <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for=""><strong>Existing Image:</strong></label>
                     <?php if(!empty($advertisement['adv_img'])){?>
                     <img  class="form-control img-fluid" src="../../upload/advertisement/<?=$advertisement['adv_img'];?>" alt="" style="width:100px;height: auto;">
                      <?php }else{
                        echo "No Image Preset";
                      }?>
                  </div>
               </div>
                <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for=""><strong>Advertisement Description:</strong></label>
                     <textarea class="form-control m-b-2" rows="3" id="adv_desc" name="adv_desc" readonly><?=$advertisement['adv_desc'];?></textarea>
                  </div>
               </div>
               <div class="savebtn_div">
                    <button type='submit' class='btn btn-warning ml-3 save_btn'>Save</button> 
               </div>
            </div>
        </form></div></div>
        <?php }?>
 
</div>
<?php include($view_path.'admin/include/footer.php');?>
<script src="<?=base_url()?>assets/plugins/tag-it/js/tag-it.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="<?=base_url()?>assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js" type="text/javascript">
</script>
<script type="text/javascript">
      $('#adv_link').tagit();
       var depart_name = $("#manage_depart option:selected").text();
       var depart_id = $("#manage_depart").val();
           if (depart_name == "Other (Third Parties)") {
               $("#third_party").show();
               $("#emp_input").hide();
         }
         if (depart_name != "Other (Third Parties)"){
              $("#emp_input").show();
               $("#third_party").hide();
        } 
         // show department list and show hide vendor and employee list input fields
   $("#manage_depart").change(function () {
           var depart_name = $("#manage_depart option:selected").text();
           var depart_id = $("#manage_depart").val();
           if (depart_name == "Other (Third Parties)") {
               $("#third_party").show();
               $("#emp_input").hide();
         }
         if (depart_name != "Other (Third Parties)"){
          $.ajax({
            url: "<?php echo base_url(); ?>admin/Advertisement/fetch_employee_name",
            method: "POST",
            data: {
              "depart_id": depart_id
            },
            success: function (data) {
               $("#adv_empid").html(data);
               $("#emp_input").show();
               $("#third_party").hide();
            }
          });
        } 
   });
   // code or enable and disable edit and save button 
   $('.savebtn_div').hide();
   $(".edit_btn").click(function () {
         $('input').removeAttr('readonly');
         $('textarea').removeAttr('readonly');
         $('select').removeAttr('disabled');
            $('.savebtn_div').show();
         });

function edit_advertisement(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: "<?php echo base_url('admin/Advertisement/update_advertisement'); ?>",
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
                              location.href='<?=base_url()?>admin/advertisement/manage_advertisement';
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
