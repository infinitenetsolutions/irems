<aside class="main-sidebar sidebar-light-danger elevation-4" id="main-aside">
            <!-- Brand Logo -->
            <a href="dashboard" class="brand-link">
              <img src="../assets/dp/<?php if($setting->setting_firm_info->logo != "") echo $setting->setting_firm_info->logo; else echo "logo.png"; ?>" alt="Exam Portal" class="brand-image img-circle elevation-3" style="opacity: .8">
              <span class="brand-text font-weight-light"><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-1">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                       with font-awesome or any other icon font library -->
                        <li class="nav-header">Main</li>
                        <li class="nav-item">
                            <a href="dashboard" class="nav-link <?php if($page_no == 1) echo "active"; ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-header">Profile</li>
                        <li class="nav-item">
                            <a href="profile" class="nav-link <?php if($page_no == 2) echo "active"; ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        
                        <li class="nav-header">Bills</li>
                        <li class="nav-item">
                            <a href="bills" class="nav-link <?php if($page_no == 3) echo "active"; ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Bills</p>
                            </a>
                        </li>
                        
                        <li class="nav-header">Complain & Feedback </li>
                        <li class="nav-item">
                            <a href="complain&feedback" class="nav-link <?php if($page_no == 4) echo "active"; ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Complain & Feedback</p>
                            </a>
                        </li>
                        <li class="nav-header">Documents</li>
                        <li class="nav-item">
                            <a href="documentsuploading" class="nav-link <?php if($page_no == 5) echo "active"; ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Documents Uploading </p>
                            </a>
                        </li>
                         <li class="nav-item has-treeview <?php if($page_no == "6"){ echo 'menu-open'; } ?>" >
                            <a href="#" class="nav-link <?php if($page_no == "6"){ echo 'active'; } ?>">
                                <i class="nav-icon fas fa-power-off" ></i>
                                <p>Log
                                    <i class="fas fa-angle-left right" ></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="javascript:void(0)"  class="nav-link lock-application">
                                       <i class="nav-icon fas fa-lock"></i>
                                        <p >Lock</p>
                                    </a>
                                </li>
                            </ul>
                             <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link logOut-application">
                                        <i class="nav-icon fas fa-power-off" ></i>
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