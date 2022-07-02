<aside class="main-sidebar sidebar-light-navy elevation-4" id ="asidebar" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ; background-color : <?php if($setting->setting_theme_info->sidebar_bg != "") echo $setting->setting_theme_info->sidebar_bg  ?>;" >
            <!-- Brand Logo -->
            <a href="dashboard" class="brand-link">
              <img src="assets/dp/<?php if($setting->setting_firm_info->logo != "") echo $setting->setting_firm_info->logo; else echo "logo.png"; ?>" alt="IREMS" class="brand-image img-square elevation-3" style="opacity: .8">
              <span class="brand-text font-weight-light" id="theme_change" style="color:  <?php if($setting->setting_theme_info->ThemeChange != "") echo $setting->setting_theme_info->ThemeChange  ?> !important;"><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?></span>
            </a>
    <style>
        .sidebar-dark-navy .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-navy .nav-sidebar>.nav-item>.nav-link.active, .nav-treeview>.nav-item>.nav-link.active:hover {    
            background-color: <?php if($setting->setting_theme_info->sidebar_active_bg != "") echo $setting->setting_theme_info->sidebar_active_bg  ?>;
            color: <?php if($setting->setting_theme_info->sidebar_active_color != "") echo $setting->setting_theme_info->sidebar_active_color  ?>;
}
    </style>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-1">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                       with font-awesome or any other icon font library -->
					   <li class="nav-item has-treeview <?php if($page_no == "1"){ echo 'menu-open'; } ?>">
                            <a href="dashboard" class="nav-link <?php if($page_no == "1"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-tachometer-alt" id="sidedashboard" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?>;"></i>
                                <p id="sidedashboard" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?>;">
                                    Dashboard                               
                                </p>
                            </a>  
                        </li>
<!--
                        <li class="nav-item has-treeview <?php if($page_no == "8"){ echo 'menu-open'; } ?>">
                            <a href="#" class="nav-link <?php if($page_no == "8"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-poll-h"></i>
                                <p>
                                    Admin Setting
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="profile" class="nav-link <?php if($page_no == "8_1"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>Profile</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="setting" class="nav-link <?php if($page_no == "8_2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-cog"></i>
                                        <p>Setting</p>
                                    </a>
                                </li>
                            </ul>
                            
                        </li>
-->
                        <li class="nav-item has-treeview <?php if($page_no == "2"){ echo 'menu-open'; } ?>">
                            <a href="#" class="nav-link <?php if($page_no == "2"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-poll-h" id="sidesetup" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sidesetup" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">
                                    Set Up
                                    <i class="fas fa-angle-left right" id="sidesetup" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="manage-company" class="nav-link <?php if($page_no == "2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-city"  id="sidesetup" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidesetup" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Company Management</p>
                                    </a>
                                </li>
                            </ul>
                        </li>								
                         <li class="nav-item has-treeview <?php if($page_no == "3"){ echo 'menu-open'; } ?>">
                            <a href="#" class="nav-link <?php if($page_no == "3"){ echo 'active'; } ?>">
                                 <i class="nav-icon far fa-building" id="sidephasemaster" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sidephasemaster" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">
                                    Project Master
                                    <i class="fas fa-angle-left right" id="sidephasemaster" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="phase-master" class="nav-link <?php if($page_no_inside == "3_1"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-vihara" id="sidephasemaster" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidephasemaster" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Phase</p>
                                    </a>
                                </li>
                            </ul>
							<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="blocks" class="nav-link <?php if($page_no_inside == "3_2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-building" id="sideblock" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sideblock" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Block</p>
                                    </a>
                                </li>
                            </ul>
							<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="building" class="nav-link <?php if($page_no_inside == "3_3"){ echo 'active'; } ?>">
                                        <i class="nav-icon far fa-building" id="sidebuilding" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidebuilding" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Building</p>
                                    </a>
                                </li>
                            </ul>
							<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="property-type" class="nav-link <?php if($page_no_inside == "3_4"){ echo 'active'; } ?>">
                                         <i class="nav-icon fas fa-home" id="sidepropertytype" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidepropertytype" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Property Type</p>
                                    </a>
                                </li>
                            </ul>
							<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="accommodation-type" class="nav-link <?php if($page_no_inside == "3_5"){ echo 'active'; } ?>">
                                       <i class="nav-icon fas fa-file-alt" id="sideaccomodationtype" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sideaccomodationtype" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Accommodation Type</p>
                                    </a>
                                </li>
                            </ul>
							<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="projects" class="nav-link <?php if($page_no_inside == "3_6"){ echo 'active'; } ?>">
                                         <i class="nav-icon fas fa-landmark"  id="sideproject" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sideproject" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Project</p>
                                    </a>
                                </li>
                            </ul>
                        </li>	
						
						 <li class="nav-item has-treeview <?php if($page_no == "4"){ echo 'menu-open'; } ?>">
                            <a href="#" class="nav-link <?php if($page_no == "4"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-users" id="sideemployeemanagement" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sideemployeemanagement" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">
                                    Employee Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="manage-department" class="nav-link <?php if($page_no_inside == "4_1"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-fax" id="sidemanagedepartment" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;" ></i>
                                        <p id="sidemanagedepartment" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Manage Department</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="manage-designation" class="nav-link <?php if($page_no_inside == "4_2"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-user-circle" id="sidemanagedesignation" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;" ></i>
                                        <p id="sidemanagedesignation" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Manage Designation</p>
                                    </a>
                                </li>
                            </ul>
							<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="manage-employees" class="nav-link <?php if($page_no_inside == "4_3"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-landmark" id="sidemanageemployees" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidemanageemployees" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Manage Employees</p>
                                    </a>
                                </li>
                            </ul>
							<!--<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link <?php if($page_no == "2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-city"></i>
                                        <p>Daily Attendance</p>
                                    </a>
                                </li>
                            </ul>
							<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link <?php if($page_no == "2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-city"></i>
                                        <p>Attendance Report</p>
                                    </a>
                                </li>
                            </ul>-->
                        </li>							

                        <li class="nav-item has-treeview <?php if($page_no == "5"){ echo 'menu-open'; } ?>">
                            <a href="#" class="nav-link <?php if($page_no == "5"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-poll-h" id="sidepurchasemanagement" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sidepurchasemanagement" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">
                                    Purchase Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            
                                <li class="nav-item">
                                    <a href="manage-supplier" class="nav-link <?php if($page_no_inside == "5_1"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon" id="sidemanagesupplier" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidemanagesupplier" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Suppliers/Vendors</p>
                                    </a>
                                </li>
                                
                                
                            </ul>
                            <!--<ul class="nav-header">Purchase Order</ul>-->
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="purchase-order" class="nav-link <?php if($page_no_inside == "5_2"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon" id="sidepurchase_order" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidepurchase_order" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Create PO</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="manage-po" class="nav-link <?php if($page_no_inside == "5_3"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Manage PO</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="new-supplier" class="nav-link <?php if($page_no_inside == "5_4"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>New Supplier</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        						
						<li class="nav-item has-treeview <?php if($page_no == "6"){ echo 'menu-open'; } ?>">
                            <a href="inventory" class="nav-link <?php if($page_no == "6"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-toolbox" id="sidemanagecategory" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sidemanagecategory" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Inventory</p>
                                    
                                    <i class="fas fa-angle-left right" id="sidemanagecategory" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;" ></i>
                                
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="manage-category" class="nav-link <?php if($page_no_inside == "6_1"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-toolbox" id="sidemanagecategory" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidemanagecategory" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Item Category</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="manage-item" class="nav-link <?php if($page_no_inside == "6_2"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon" id="sidemanageitem" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidemanageitem" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;" >Manage Items</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="goods-receipt" class="nav-link <?php if($page_no_inside == "6_3"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon" id="sidegoodsreceipt" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidegoodsreceipt" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Goods Receipt</p>
                                    </a>
                                </li>
                            </ul>
							 <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="goods-issue" class="nav-link <?php if($page_no_inside == "6_4"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-cart-arrow-down" id="sidegoodsissue" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidegoodsissue" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Goods Issue & Goods Return</p>
                                    </a>
                                </li>
                            </ul>
							<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="manage-stock" class="nav-link <?php if($page_no_inside == "6_5"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-box-open" id="sidemanagestock" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidegoodsissue" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Stock Details</p>
                                    </a>
                                </li>
                            </ul>
							 <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="inv-reports" class="nav-link <?php if($page_no_inside == "6_6"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-clipboard" id="sideinvreports" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sideinvreports" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Inventory Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                         <li class="nav-item has-treeview <?php if($page_no == "7"){ echo 'menu-open'; } ?>">
                            <a href="Customer Management" class="nav-link <?php if($page_no == "7"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-users" id="sidecustomers" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;" ></i>
                                <p id="sidecustomers" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">
                                   Customer Management </p>
                                    <i class="fas fa-angle-left right" id="sidecustomers" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                               
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="customers" class="nav-link <?php if($page_no_inside == "7_2"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-file-alt" id="sidecustomers" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidecustomers" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Customers</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="complaints" class="nav-link <?php if($page_no_inside == "7_1"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-clipboard" id="sidecomplaints" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidecomplaints" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Complaints</p>
                                    </a>
                                </li>
                            </ul>
                             <ul class="nav nav-treeview">
                                <li class="nav-item">
                            <a href="services" class="nav-link <?php if($page_no_inside == "7_3") echo "active"; ?>">
                                <i class="nav-icon fas fa-tasks" id="sideservices" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sideservices" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color?>;">Services</p>
                            </a>
                        </li>
                            </ul>
                         </li>
<!--                            <li class="nav-header">Services</li>-->
                        <li class="nav-item has-treeview <?php if($page_no == "8"){ echo 'menu-open'; } ?>">
                            <a href="land-acquisition" class="nav-link <?php if($page_no == "8"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-landmark" id="sidelandaquisition" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;" ></i>
                                <p id="sidelandaquisition" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">
                                   Land Aquisition </p>
                                    <i class="fas fa-angle-left right" id="sidelandaquisition" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                               
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="land-acquisition-uom" class="nav-link <?php if($page_no_inside == "8_1"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-balance-scale" id="sideuom" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sideuom" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Land Aquisition UOM</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                            <a href="land-acquisition-owners" class="nav-link <?php if($page_no_inside == "8_2") echo "active"; ?>">
                                <i class="nav-icon far fa-user-circle" id="sideowners" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sideowners" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color?>;">Land Aquisition Owners </p>
                            </a>
                        </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="land-acquisition-lands" class="nav-link <?php if($page_no_inside == "8_3"){ echo 'active'; } ?>">
                                <i class="nav-icon 	fas fa-map-marker" id="sidelands" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidelands" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Lands</p>
                                    </a>
                                </li>
                            </ul>
                            
                             
                         </li>
                        
                        <li class="nav-item has-treeview <?php if($page_no == "9"){ echo 'menu-open'; } ?>">
                            <a href="#" class="nav-link <?php if($page_no == "9"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-id-card-alt" id="sideprofile" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sideprofile" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color ?> ;">Admin Profile/Settings   </p>
                                    
                                    <i class="fas fa-angle-left right"  id="sideprofile" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                              
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="profile" class="nav-link <?php if($page_no_inside == "9_1") echo "active"; ?>">
                                        <i class="nav-icon fas fa-user" id="sideprofile" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sideprofile" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Profile</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="settings" class="nav-link <?php if($page_no_inside == "9_2") echo "active"; ?>">
                                        <i class="nav-icon fas fa-cog" id="sidesettings" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidesettings" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Settings</p>
                                    </a>
                                </li>
                            </ul>
                        </li>	

                        
                        <li class="nav-item has-treeview display-none data-page-class" data-page="page_no_10">
                            <a href="maintainance" class="nav-link <?php if($page_no == "10"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-wrench"></i>
                                <p>Maintainance</p>
                            </a>  
                        </li>
                       
                        
                        
						
						 <li class="nav-item has-treeview <?php if($page_no == "11"){ echo 'menu-open'; } ?>" >
                            <a href="#" class="nav-link <?php if($page_no == "11"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-power-off" id="sidelock" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                <p id="sidelock" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">
                                   Log
                                    <i class="fas fa-angle-left right" id="sidelock" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="javascript:void(0)"  class="nav-link lock-application">
                                       <i class="nav-icon fas fa-lock"id="sidelock" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;"></i>
                                        <p id="sidelock" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Lock</p>
                                    </a>
                                </li>
                            </ul>
							 <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link logOut-application">
                                        <i class="nav-icon fas fa-power-off" id="sidelog" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;" ></i>
                                        <p id="sidelog" style=" color : <?php if($setting->setting_theme_info->sidebar_color != "") echo $setting->setting_theme_info->sidebar_color  ?> ;">Log Out</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>