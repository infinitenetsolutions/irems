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
                       <center id="aside-loader" class="mt-3 mb-3"><img width="26px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>
                       <li class="nav-item has-treeview display-none data-page-class" data-page="page_no_0">
                            <a href="dashboard" class="nav-link <?php if($page_no == "0"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>  
                        </li>
                      	<li class="nav-item has-treeview" >
                            <a href="profile" class="nav-link ">
                              <i class="fa fa-user" aria-hidden="true"></i>
                                 <p>  Profile    </p>
                            </a>
                         </li>
                        
                        <li class="nav-item has-treeview display-none <?php if($page_no == "1"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_1">
                            <a href="#" class="nav-link <?php if($page_no == "1"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-poll-h"></i>
                                <p>
                                    Set Up
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_1_1">
                                <li class="nav-item">
                                    <a href="manage-role" class="nav-link <?php if($page_no_inside == "1_1"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Role Management</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_1_2">
                                <li class="nav-item">
                                    <a href="manage-company" class="nav-link <?php if($page_no_inside == "1_2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-city"></i>
                                        <p>Company Management</p>
                                    </a>
                                </li>
                            </ul>
                        </li>                              
                        <li class="nav-item has-treeview display-none <?php if($page_no == "2"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_2">
                            <a href="#" class="nav-link <?php if($page_no == "2"){ echo 'active'; } ?>">
                                <i class="nav-icon far fa-building"></i>
                                <p>
                                    Project Master
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_2_1">
                                <li class="nav-item">
                                    <a href="phase-master" class="nav-link <?php if($page_no_inside == "2_1"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-vihara"></i>
                                        <p>Phase</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_2_2">
                                <li class="nav-item">
                                    <a href="building" class="nav-link <?php if($page_no_inside == "2_2"){ echo 'active'; } ?>">
                                        <i class="nav-icon far fa-building"></i>
                                        <p>Block</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_2_3">
                                <li class="nav-item">
                                    <a href="property-type" class="nav-link <?php if($page_no_inside == "2_3"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-home"></i>
                                        <p>Property Type</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_2_4">
                                <li class="nav-item">
                                    <a href="accommodation-type" class="nav-link <?php if($page_no_inside == "2_4"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p>Accommodation Type</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_2_5">
                                <li class="nav-item">
                                    <a href="projects" class="nav-link <?php if($page_no_inside == "2_5"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-landmark"></i>
                                        <p>Project</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview display-none <?php if($page_no == "3"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_3">
                            <a href="#" class="nav-link <?php if($page_no == "3"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Employee Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_3_1">
                                <li class="nav-item">
                                    <a href="manage-department" class="nav-link <?php if($page_no_inside == "3_1"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-fax"></i>
                                        <p>Manage Department</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_3_2">
                                <li class="nav-item">
                                    <a href="manage-designation" class="nav-link <?php if($page_no_inside == "3_2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Manage Designation</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_3_3">
                                <li class="nav-item">
                                    <a href="manage-employees" class="nav-link <?php if($page_no_inside == "3_3"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-landmark"></i>
                                        <p>Manage Employees</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview display-none <?php if($page_no == "4"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_4">
                            <a href="#" class="nav-link <?php if($page_no == "4"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-poll-h"></i>
                                <p>
                                    Purchase Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_4_1">
                                <li class="nav-item">
                                    <a href="manage-supplier" class="nav-link <?php if($page_no_inside == "4_1"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Manage Supplier</p>
                                    </a>
                                </li>
                            </ul>
                             <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_4_5">
                                <li class="nav-item">
                                    <a href="new-supplier" class="nav-link <?php if($page_no_inside == "4_5"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>New Supplier</p>
                                    </a>
                                </li>
                            </ul>
                            <!--<ul class="nav-header">Purchase Order</ul>-->
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_4_2">
                                <li class="nav-item">
                                    <a href="purchase-order" class="nav-link <?php if($page_no_inside == "4_2"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Create PO</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_4_3">
                                <li class="nav-item">
                                    <a href="manage-po" class="nav-link <?php if($page_no_inside == "4_3"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Manage PO</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_4_4">
                                <li class="nav-item">
                                    <a href="receive-indent" class="nav-link <?php if($page_no_inside == "4_4"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Receive Indent</p>
                                    </a>
                                </li>
                            </ul>
                        </li>         
                        <li class="nav-item has-treeview display-none <?php if($page_no == "5"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_5">
                            <a href="inventory" class="nav-link <?php if($page_no == "5"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-toolbox"></i>
                                <p>
                                    Inventory
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_1">
                                <li class="nav-item">
                                    <a href="indent" class="nav-link <?php if($page_no_inside == "5_1"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Create Indent</p>
                                    </a>
                                </li>
                            </ul>                            
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_2">
                                <li class="nav-item">
                                    <a href="manage-category" class="nav-link <?php if($page_no_inside == "5_2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-toolbox"></i>
                                        <p>Item Category</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_3">
                                <li class="nav-item">
                                    <a href="manage-item" class="nav-link <?php if($page_no_inside == "5_3"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Manage Items</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_4">
                                <li class="nav-item">
                                    <a href="goods-receipt" class="nav-link <?php if($page_no_inside == "5_4"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Goods Receipt</p>
                                    </a>
                                </li>
                            </ul>
                             <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_5">
                                <li class="nav-item">
                                    <a href="goods-issue" class="nav-link <?php if($page_no_inside == "5_5"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                                        <p>Goods Issue & Return</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_6">
                                <li class="nav-item">
                                    <a href="manage-stock" class="nav-link <?php if($page_no_inside == "5_6"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-box-open"></i>
                                        <p>Item Details</p>
                                    </a>
                                </li>
                            </ul>
                             <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_7">
                                <li class="nav-item">
                                    <a href="inv-reports" class="nav-link <?php if($page_no_inside == "5_7"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-clipboard"></i>
                                        <p>Inventory Reports</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_8">
                                <li class="nav-item">
                                    <a href="mystock" class="nav-link <?php if($page_no_inside == "5_8"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-clipboard"></i>
                                        <p>My Store</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_9">
                                <li class="nav-item">
                                    <a href="stores" class="nav-link <?php if($page_no_inside == "5_9"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-store"></i>
                                        <p>Stores</p>
                                    </a>
                                </li>
                            </ul>
                            
                            
                            
                               <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_5_10">
                                <li class="nav-item">
                                    <a href="manage-indent" class="nav-link <?php if($page_no_inside == "5_10"){ echo 'active'; } ?>">
                                        <i class="fas fa-angle-double-right nav-icon"></i>
                                        <p>Manage Indent</p>
                                    </a>
                                </li>
                            </ul>
                          
                            
                            
                            
                        </li>
                        <li class="nav-item has-treeview display-none <?php if($page_no == "6"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_6">
                            <a href="#" class="nav-link <?php if($page_no == "6"){ echo 'active'; } ?>">
                                <i class="nav-icon fa fa-network-wired"></i>
                                <p>
                                    Work Flow Master
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_6_1">
                                <li class="nav-item">
                                    <a href="main-work-type" class="nav-link <?php if($page_no_inside == "6_1"){ echo 'active'; } ?>">
                                        <i class="nav-icon fa fa-toolbox"></i>
                                        <p>Main Work</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_6_2">
                                <li class="nav-item">
                                    <a href="work-type" class="nav-link <?php if($page_no_inside == "6_2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fa fa-clipboard"></i>
                                        <p>Work</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_6_3">
                                <li class="nav-item">
                                    <a href="item-type" class="nav-link <?php if($page_no_inside == "6_3"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-tasks"></i>
                                        <p>Items</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_6_4">
                                <li class="nav-item">
                                    <a href="unit-type" class="nav-link <?php if($page_no_inside == "6_4"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-balance-scale"></i>
                                        <p>Unit</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_6_5">
                                <li class="nav-item">
                                    <a href="work-flow" class="nav-link <?php if($page_no_inside == "6_5"){ echo 'active'; } ?>">
                                        <i class="nav-icon fa fa-cubes"></i>
                                        <p>Work Flow</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview display-none <?php if($page_no == "7"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_7">
                            <a href="#" class="nav-link <?php if($page_no == "7"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Customer Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                               
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_7_1">
                                <li class="nav-item">
                                    <a href="customers" class="nav-link <?php if($page_no_inside == "7_1"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p>Customers</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_7_2">
                                <li class="nav-item">
                                    <a href="complaints" class="nav-link <?php if($page_no_inside == "7_2"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-clipboard"></i>
                                        <p>Complaints</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_7_3">
                                <li class="nav-item">
                                    <a href="services" class="nav-link <?php if($page_no_inside == "7_3") echo "active"; ?>">
                                        <i class="nav-icon fas fa-tasks"></i>
                                        <p>Services</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview display-none <?php if($page_no == "8"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_8">
                            <a href="#" class="nav-link <?php if($page_no == "8"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-landmark"></i>
                                <p>
                                    Land Aquisition
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_8_1">
                                <li class="nav-item">
                                    <a href="land-acquisition-uom" class="nav-link <?php if($page_no_inside == "8_1"){ echo 'active'; } ?>">
                                        <i class="nav-icon fas fa-balance-scale"></i>
                                        <p>Land Aquisition UOM</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_8_2">
                                <li class="nav-item">
                                    <a href="land-acquisition-owners" class="nav-link <?php if($page_no_inside == "8_2") echo "active"; ?>">
                                        <i class="nav-icon far fa-user-circle"></i>
                                        <p>Land Aquisition Owners </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_8_3">
                                <li class="nav-item">
                                    <a href="land-acquisition-lands" class="nav-link <?php if($page_no_inside == "8_3"){ echo 'active'; } ?>">
                                        <i class="nav-icon  fas fa-map-marker"></i>
                                        <p>Lands</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview display-none <?php if($page_no == "9"){ echo 'menu-open'; } ?> data-page-class" data-page="page_no_9">
                            <a href="#" class="nav-link <?php if($page_no == "9"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-id-card-alt"></i>
                                <p>
                                    Admin Profile/Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_9_1">
                                <li class="nav-item">
                                    <a href="profile" class="nav-link <?php if($page_no_inside == "9_1") echo "active"; ?>">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>Profile</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview display-none data-page-class" data-page="page_no_inside_9_2">
                                <li class="nav-item">
                                    <a href="settings" class="nav-link <?php if($page_no_inside == "9_2") echo "active"; ?>">
                                        <i class="nav-icon fas fa-cog"></i>
                                        <p>Settings</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                      
                        <?php if($auth->admin_info->name == 'Admin') {
                             $admin_id =  $auth->employee_id; ?>
                        <li class="nav-item has-treeview display-none data-page-class" data-page="page_no_10">
                            <a href="https://srinathhomes.in/irems/crm/admin/leadmanage/manage_all_lead/<?=$admin_id ?>" class="nav-link <?php if($page_no == "10"){ echo 'active'; } ?>" target="_blank">
                                <i class="nav-icon fas fa-th"></i>
                                <p>CRM</p>
                            </a>  
                        </li>
                      <?php } else { 
                     // echo $auth->admin_info->name;
                      ?>

                       <li class="nav-item has-treeview display-none data-page-class" data-page="page_no_10">
                            <a href="https://srinathhomes.in/irems/crm/" class="nav-link <?php if($page_no == "10"){ echo 'active'; } ?>" target="_blank">
                                <i class="nav-icon fas fa-th"></i>
                                <p>CRM</p>
                            </a>  
                        </li>
                      <?php } ?>
                      
                       <li class="nav-item has-treeview display-none data-page-class" data-page="page_no_11">
                            <a href="https://srinathhomes.in/irems/payroll/admin/attendance/attendance_view" class="nav-link <?php if($page_no == "11"){ echo 'active'; } ?>" target="_blank">
                                <i class="nav-icon fas fa-id-card-alt"></i>
                                <p>
                                    Payroll
                                </p>
                           </a>
                        </li>


                        <!-- <li class="nav-item has-treeview display-none data-page-class" data-page="page_no_12">
                            <a href="maintainance" class="nav-link <?php if($page_no == "12"){ echo 'active'; } ?>" target="_blank">
                                <i class="nav-icon fa fa-cogs"></i>
                                <p>
                                    Maintenance
                                </p>
                           </a>
                        </li> -->


                        <li class="nav-item has-treeview display-none data-page-class" data-page="page_no_12">
                            <a href="manage-maintainance" class="nav-link <?php if($page_no == "12"){ echo 'active'; } ?>" target="_blank">
                                 <p>
                                    Manage Maintenance
                                </p>
                           </a>
                        </li>
                        
                        <?php if($auth->admin_info->name != 'Admin') {
                             $admin_id =  $auth->employee_id; ?>
                        <li class="nav-item has-treeview" data-page="page_no_13">
                            <a href="leave_application" class="nav-link <?php if($page_no == "13"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Leave Application</p>
                            </a>  
                        </li>
                      
                      <li class="nav-item has-treeview" data-page="page_no_14">
                            <a href="loan_application" class="nav-link <?php if($page_no == "14"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Loan Application</p>
                            </a>  
                        </li>
                      
                      
                      <?php } ?>
                      
                    
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Log
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="javascript:void(0)"  class="nav-link lock-application">
                                        <i class="nav-icon fas fa-lock"></i>
                                        <p>Lock</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link logOut-application">
                                        <i class="nav-icon fas fa-power-off"></i>
                                        <p>Log Out</p>
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