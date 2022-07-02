<?php 
    setcookie("lastInfoCustomer", str_replace(".php", "", basename($_SERVER["PHP_SELF"])), time() + (86400 * 365), "/");
?>
<nav class="main-header navbar navbar-expand navbar-dark navbar" id="main-header">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block" rel="tooltip" data-placement="bottom" title="Go to the Dashboard">
                    <a href="dashboard" class="nav-link"><i class="fas fa-tachometer-alt mr-1"></i> Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block" rel="tooltip" data-placement="bottom" title="Lock Application">
                    <a href="javascript:void(0)" class="nav-link lock-application"><i class="fas fa-lock mr-1"></i> Lock</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block display-none" rel="tooltip" data-placement="bottom" title="Next Exam In" id="hearder-next-exam-main">
                    <a class="nav-link" href="exam-portal">
                        <i class="fas fa-clock mr-1"></i> <span id="hearder-next-exam-timer"></span> (Next Exam)
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown display-none" rel="tooltip" data-placement="bottom" title="Time Left" id="hearder-start-exam-main">
                    <a class="nav-link" href="javascript:void(0)" id="hearder-start-exam-timer-i">
                        <i class="fas fa-clock fa-sm"></i> <span id="hearder-start-exam-timer"></span>
                    </a>
                </li>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="../<?= $auth->logDp ?>" class="img-size-50 user-image img-circle elevation-2" alt="<?= $auth->customer_info->name ?>">
                        <span class="d-none d-md-inline text-bold"><?php if($auth->customer_info->name != "") echo $auth->customer_info->name; else echo $auth->customer_info->name; ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="../../assets/customer/profile/<?= $auth->customer_info->dp ?>" alt="<?= $auth->customer_info->name ?>" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title text-lg text-bold">
                                        <?php if($auth->customer_info->name != "") echo $auth->customer_info->name; else echo $auth->customer_info->name; ?>
                                    </h3>
                                    <p class="text-muted text-xs">(Logged In Since <b><i class="far fa-clock mr-1 ml-1"></i><?= date("h:i A", strtotime($auth->logTime)); ?>)</b></p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" class="dropdown-item dropdown-footer lock-application"><i class="fas fa-lock"></i> Lock</a>
                    </div>
                </li>
            </ul>
        </nav>