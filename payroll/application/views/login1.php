<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Ateeb Foods Pvt Ltd | Login</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>/assets/img/logo/logo.png">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<link href="<?php echo base_url() ?>/assets/css/default/app.min.css" rel="stylesheet" />

</head>
<body class="pace-top">

<!-- <div id="page-loader" class="fade show">
<span class="spinner"></span>
</div> -->


<div id="page-container" class="fade">

<div class="login login-v1">

<div class="login-container">

<div class="login-header rounded mx-auto d-block" style="width:21%;">
	 <center><img src="<?php echo base_url() ?>assets/img/logo/logo.png" /></center>
</div>
<style type="text/css">

	.login-header{
		padding: 40px;
		border-radius: 0px;
		background:rgba(0, 0, 0, 0.2);
		-webkit-box-shadow: 2px 2px 5px -1px rgba(0,0,0,0.75);
		-moz-box-shadow: 2px 2px 5px -1px rgba(0,0,0,0.75);
		box-shadow: 2px 2px 5px -1px rgba(0,0,0,0.75);
	}
</style>

<?php echo $this->session->flashdata('msg'); ?>
<div class="login-body">

<div class="login-content">
<form method="post" autocomplete="off" action="<?= base_url() ?>admin/login/login_user">
<div class="form-group m-b-20">
<input type="text" name="username" class="form-control form-control-lg inverse-mode" placeholder="Username" required />
</div>
<div class="form-group m-b-20">
<input type="password" name="password" class="form-control form-control-lg inverse-mode" placeholder="Password" required />
</div>
<div class="checkbox checkbox-css m-b-20">
<input type="checkbox" id="remember_checkbox" />
<label for="remember_checkbox">
Remember Me
</label>
</div>
<div class="login-buttons">
	   <input type="submit" name="submit" value="Sign me in" id="" class="btn btn-success btn-block btn-lg" />

<!-- <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button> -->
</div>
</form>
</div>

</div>

</div>

</div>





<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

</div>


<script src="<?php echo base_url() ?>/assets/js/app.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>/assets/js/theme/default.min.js" type="text/javascript"></script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="|49" defer=""></script></body>

<!-- Mirrored from seantheme.com/color-admin/admin/html/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Aug 2020 08:22:10 GMT -->
</html>