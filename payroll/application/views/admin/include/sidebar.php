<?php
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
				<!-- Payroll link -->
				<li class="has-sub <?php echo ($page == 'payroll') ? 'active' : ''; ?>">
                  <a href="javascript:;">
						<b class="caret"></b>
						<i class="fa big-icon fa-file icon-wrap"></i>
						<span>Payroll</span>
					</a>
					
					<ul class="sub-menu">
                <li class="<?php echo (@$sub_page == 'attendance_view') ? 'active' : ''; ?>">
					<a href="
						<?php echo base_url(); ?>admin/attendance/attendance_view">Add Attendance
					</a>
				</li>
                
                <li class="<?php echo (@$sub_page == 'academic_calendar') ? 'active' : ''; ?>">
					<a href="
						<?php echo base_url(); ?>admin/attendance/academic_calendar">Financial Calendar
					</a>
				</li>
                <!--<li class="<?php //echo (@$sub_page == 'leave_type') ? 'active' : ''; ?>">
					<a href="
						<?php //echo base_url(); ?>admin/attendance/leave_type">Leave Type   
					</a>
				</li>-->
                      
				<li class="<?php echo (@$sub_page == 'attendance_report') ? 'active' : ''; ?>">
					<a href="
						<?php echo base_url(); ?>admin/attendance/attendance_report_view">Attendance Report
					</a>
				</li>
                      
                   <li class="<?php echo (@$sub_page == 'leave_management') ? 'active' : ''; ?>">
					<a href="
						<?php echo base_url(); ?>admin/attendance/leave_management">Leave Management 
					</a>
				</li>  
                      
                    <li class="<?php echo (@$sub_page == 'loan_approval') ? 'active' : ''; ?>">
					<a href="
						<?php echo base_url(); ?>admin/attendance/loan_approval">Loan Aprroval 
					</a>
				  </li>     
                      
                      
				<li class="<?php echo (@$sub_page == 'pay_slips') ? 'active' : ''; ?>">
					<a href="
						<?php echo base_url(); ?>admin/payroll/pay_slips">Pay slips
					</a>
				</li>
                      
                      
					</ul>
                    
                 
				</li>
				<!-- CRM links -->
			</ul>
            
            
            
            
            
            
		</div>
	</div>
	<div class="sidebar-bg"></div>
