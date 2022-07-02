<?php 
    setcookie("lastInfo", str_replace(".php", "", basename($_SERVER["PHP_SELF"])), time() + (86400 * 365), "/");
?>
<nav class="main-header navbar navbar-expand navbar-dark navbar-navy" id="navbar" style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?> ; background-color : <?php if($setting->setting_theme_info->header_bg != "") echo $setting->setting_theme_info->header_bg  ?>">
  
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="navpushmenu" style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block" title="Go to the Dashboard">
                    <a href="dashboard" id="navdashboard"  style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;" class="nav-link"><i class="fas fa-tachometer-alt mr-1"></i> Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block" title="Go to the Setting">
                    <a href="settings" class="nav-link" id="navsetting" style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;"><i class="fas fa-cog mr-1"></i> Settings</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block" title="Lock Application">
                    <a href="javascript:void(0)" class="nav-link lock-application" id="navlock" style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;"><i class="fas fa-lock mr-1"></i> Lock</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto" id="navbadges" style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;">
                <li class="nav-item dropdown" title="">
                    <a class="nav-link" href="#" id="navbadges"style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-primary navbar-badge">13</span>
                    </a>
                </li>
                <li class="nav-item dropdown" title="">
                    <a class="nav-link" href="#" id="navbadges"style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-success navbar-badge">8</span>
                    </a>
                </li>
                <li class="nav-item dropdown" title="">
                    <a class="nav-link" href="#" id="navbadges"style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                </li>
                <li class="nav-item dropdown" title="">
                    <a class="nav-link" href="#" id="navbadges"style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                </li>
                <li class="nav-item dropdown user-menu" title="Profile">
                    <a href="#" id="navbadges"style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="assets/dp/profile/<?= $auth->logDp ?>" class="img-size-50 user-image img-circle elevation-2" alt="Profile">
                        <span class="d-none d-md-inline text-bold"><?php if($auth->admin_info->nickName != "") echo $auth->admin_info->nickName; else echo $auth->admin_info->name; ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item" id="navbadges"style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="assets/dp/profile/<?= $auth->logDp ?>" alt="Profile" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title text-lg text-bold">
                                        <?php if($auth->admin_info->nickName != "") echo $auth->admin_info->nickName; else echo $auth->admin_info->name; ?>
                                    </h3>
                                    <p class="text-muted text-xs">(Logged In Since <b><i class="far fa-clock mr-1 ml-1"></i><?= date("h:i A", strtotime($auth->logTime)); ?>)</b></p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" class="dropdown-item dropdown-footer lock-application" id="navbadges"style=" color : <?php if($setting->setting_theme_info->header_color != "") echo $setting->setting_theme_info->header_color  ?>;"><i class="fas fa-lock"></i> Lock</a>
                    </div>
                </li>
            </ul>
        </nav>