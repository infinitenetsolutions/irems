<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SRINATH HOMES PVT LTD | <?php echo ucfirst($page);?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>assets/img/logo/logo.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/css/default/app.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="<?php echo base_url() ?>/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />

<link href="<?php echo base_url() ?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
</head>
<body>
<div id="page-container" class="fade in page-sidebar-fixed page-header-fixed">
<div id="header" class="header navbar-default">
	<div class="navbar-header">
		<a href="<?php echo base_url(); ?>admin" class="navbar-brand">
			<b>SRINATH HOMES PVT LTD</b>
		</a>
		<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<ul class="navbar-nav navbar-right">
		<li class="navbar-form">
			<form action="#" method="POST" name="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Enter keyword" />
					<button type="submit" class="btn btn-search">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</form>
		</li>
		<li class="dropdown">
			<a href="#" data-toggle="dropdown" class="dropdown-toggle f-s-14">
				<i class="fa fa-bell"></i>
				<span class="label">5</span>
			</a>
			<div class="dropdown-menu media-list dropdown-menu-right">
				<div class="dropdown-header">NOTIFICATIONS (5)</div>
			</div>
		</li>
		<li class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<img src="
					<?php echo base_url() ?>/assets/img/user/user-13.jpg" alt="" />
					<span class="d-none d-md-inline"><?php echo $this->session->userdata('email'); ?></span>
					<b class="caret"></b>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="javascript:;" class="dropdown-item">Change Password</a>
					<div class="dropdown-divider"></div>
					<a href="
						<?php echo base_url() ?>admin/login/logout" class="dropdown-item">Log Out
					</a>
				</div>
			</li>
		</ul>
	</div>



