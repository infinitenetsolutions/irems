<?php
echo $this->session->userdata('user_id');
//$baseLink= base_url()."admin/Service/";
?>
<div id="sidebar" class="sidebar">
	<div data-scrollbar="true" data-height="100%">
		<ul class="nav">
			<li class="nav-profile">
				<a href="javascript:;" data-toggle="nav-profile">
					<div class="cover" style="background:#fff;">
					    <center><img src="<?php echo base_url() ?>/assets/img/logo/logo.png" style="width:auto" alt="" /></center>
					</div>
					<div class="image">
						
						</div>
					</a>
				</li>
			</ul>
			<ul class="nav">
				<li class="nav-header">Navigation</li>
				<!-- CRM link -->
				<li class="has-sub <?php echo ($page == 'advertisement') ? 'active' : ''; ?>"  >
					<a href="javascript:;">
						<b class="caret"></b>
						<i class="fa big-icon fa-file icon-wrap"></i>
						<span>CRM </span>
                      <?php  //echo $this->session->userdata('user_id'); ?>
			
 		              </a>
					<ul class="sub-menu">
						<li class="<?php echo (@$sub_page == 'manage_advrtisment') ? 'active' : ''; ?>">
							<a href="
								<?php echo base_url(); ?>admin/advertisement/manage_advertisement">Advertisement
							</a>
						</li>
					</ul>
                  
                  <?php if($this->session->userdata('user_id') != '1' && $this->session->userdata('user_id') != '') {?>
                  <ul class="sub-menu">
						<li class="<?php echo (@$sub_page == 'manage_lead') ? 'active' : ''; ?>">
							<a href="
								<?php echo base_url(); ?>admin/leadmanage/manage_lead">Manage Leads 
							</a>
						</li>
					</ul>
                  <?php } ?>
                  
                     
                  <?php //if($this->session->userdata('user_id') == '') {?>
                 <!-- <ul class="sub-menu">
						<li class="<?php //echo (@$sub_page == 'manage_lead') ? 'active' : ''; ?>">
							<a href="
								<?php //echo base_url(); ?>admin/leadmanage/manage_all_lead">Manage Leads 
							</a>
						</li>
					</ul>-->
                  <?php //} ?>
                  
				<!-- CRM links -->
			</ul>
                
                  
				</li>
              
                
                  
            
            
            	
            
            
            
            
            
		</div>
	</div>
	<div class="sidebar-bg"></div>
