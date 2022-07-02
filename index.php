<!-- Login Page -->
<?php require_once("include/index-auth.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Login</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    
    <!-- Css Section End -->
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm accent-navy pace-red login-page" style="background: url('assets/bg/<?php if($setting->setting_theme_info->IndexBackground != '') echo $setting->setting_theme_info->IndexBackground ; else echo "index-bg.png" ?>');background-size: cover;">
    <!-- Login Section Start -->
    <div class="login-box display-none" id="logDiv">
        <div class="login-logo">
            <div class="image">
              <img src="assets/dp/<?php if($setting->setting_firm_info->logo != "") echo $setting->setting_firm_info->logo; else echo "logo.png"; ?>" class="img-square" width="40%" alt="Firm Logo">
            </div>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="logForm" method="post">
                    <div class="input-group mb-3">
                        <input id="logUser" name="logUser" type="text" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-alt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="logPass" name="logPass" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span id="passShow" class="display-none fas fa-eye"></span>
                                <span id="passHide" class="fas fa-eye-slash"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-navy">
                                <input type="checkbox" id="remember" checked>
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <input type="hidden" name="action" value="logTry" />
                            <input type="hidden" id="logIp" name="logIp" value="" />
                            <input type="hidden" id="logLocation" name="logLocation" value="" />
                            <button id="logButton" type="submit" class="btn btn-info btn-block"><span id="primaryLoader"></span><span id="primaryText">Sign In</span></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="social-auth-links text-center mt-2">
                    <b>- OR -</b>
                    <a href="#" class="btn btn-block btn-warning mt-1">
                        <i class="nav-icon fas fa-edit mr-1"></i> Register
                    </a>
                    <a href="#" class="mt-3 mb-0 float-right">
                        Forgot Password
                    </a>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- Login Section End-->
    <!-- Lock Section Start -->
    <div class="lockscreen-wrapper display-none mt-0" id="lockDiv">
        <div class="login-logo">
            <div class="image">
              <img src="assets/dp/<?php if($setting->setting_firm_info->logo != "") echo $setting->setting_firm_info->logo; else echo "logo.png"; ?>" class="img-square" width="40%" alt="Firm Logo">
            </div>
        </div>
        <!-- User name -->
        <div id="lockName" class="lockscreen-name text-lg" align="center"></div>
        <div class="lockscreen-item">
            <!-- lockscreen image -->
            <div class="lockscreen-image">
                <img class="img-size-50 user-image img-circle elevation-2" id="lockDp" alt="Logger Image">
            </div>
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->
            <form class="lockscreen-credentials" id="lockForm" method="post">
                <div class="input-group">
                    <input type="password" id="lockPass" name="lockPass" class="form-control" placeholder="Enter Password">
                    <div class="input-group-append">
                        <input type="hidden" name="action" value="unlockTry" />
                        <input type="hidden" id="lockIp" name="lockIp" value="" />
                        <input type="hidden" id="lockLocation" name="lockLocation" value="" />
                        <button type="submit" id="lockButton" class="btn"><span id="lockLoader"></span><span id="lockText"><i class="fas fa-paper-plane text-muted"></i></span></button>
                    </div>
                </div>
            </form>
            <!-- /.lockscreen credentials -->

        </div>
        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
            Enter your password to retrieve your session
        </div>
        <div class="text-center">
            <a href="javascript:void(0);" id="logNew">Or sign in as a different user</a>
        </div>
        <div class="lockscreen-footer text-center">
            <strong>&copy; <?php if(date("Y") == "2020") echo "2020"; else echo "2020-".date("Y"); ?> <a href="#"><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?></a></strong>
        </div>
    </div>
    <!-- Lock Section End -->
    <!-- Js Section Start -->
    <?php require_once("include/js.php"); ?>
    
    <script src="dist/js/index-ajax.js"></script>
    <!-- Js Section End -->
</body>

</html>