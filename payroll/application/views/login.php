<!DOCTYPE html>
<html>
<head>
	<title>ATEEB FOODS PVT LTD | Login </title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Raleway:400,700');
		 *, *:before, *:after {
	 box-sizing: border-box;
}
.displayNone{
	display: none;
}
.display{
	display: block;
}
 body {
	 min-height: 100vh;
	 font-family: 'Raleway', sans-serif;
}

 .container {
	 position: absolute;
	 width: 100%;
	 height: 100%;
	 overflow: hidden;
}
 .container:hover .top:before, .container:active .top:before, .container:hover .bottom:before, .container:active .bottom:before, .container:hover .top:after, .container:active .top:after, .container:hover .bottom:after, .container:active .bottom:after {
	 margin-left: 200px;
	 transform-origin: -200px 50%;
	 transition-delay: 0s;
}
 .container:hover .center, .container:active .center {
	 opacity: 1;
	 transition-delay: 0.2s;
}
 .top:before, .bottom:before, .top:after, .bottom:after {
	 content: '';
	 display: block;
	 position: absolute;
	 width: 200vmax;
	 height: 200vmax;
	 top: 50%;
	 left: 50%;
	 margin-top: -100vmax;
	 transform-origin: 0 50%;
	 transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
	 z-index: 10;
	 opacity: 0.65;
	 transition-delay: 0.2s;
}
 .top:before {
	 transform: rotate(45deg);
	 background: #e46569;
}
 .top:after {
	 transform: rotate(135deg);
	 background: #ecaf81;
}
 .bottom:before {
	 transform: rotate(-45deg);
	 background: #60b8d4;
}
 .bottom:after {
	 transform: rotate(-135deg);
	 background: #3745b5;
}
 .center {
	 position: absolute;
	 width: 400px;
	 height: 400px;
	 top: 50%;
	 left: 50%;
	 margin-left: -200px;
	 margin-top: -200px;
	 display: flex;
	 flex-direction: column;
	 justify-content: center;
	 align-items: center;
	 padding: 30px;
	 opacity: 0;
	 transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
	 transition-delay: 0s;
	 color: #333;
}
 .center input[type=text], .center input[type=password] , .center input[type=submit] {
	    width: 100%;
    padding: 10px 10px;
    margin: 5px 0px;
    border-radius: 1px;
	 border: 2px solid #ccc;
	 font-family: inherit;
	  transition: all 1s;
}
 /* width */
*::-webkit-scrollbar {
  width: 10px;
}

/* Track */
*::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
.text-center{
	text-align: center;
}

.logo-image{	
	margin-top:-40%;margin-left: 0%;
}
.login-title{font-family: 'Audiowide';font-size: 22px;letter-spacing: 2px;color: #c90808;}
/*button code start */
.button {
  border-radius: 2px;
  background-color: #c90808;
  border: none;
  color: #fff;
  text-align: center;
  font-size: 16px;
  padding: 10px 0px;
  width:100%;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px 0px;
  font-weight: 600;
  letter-spacing: 1px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
	font-size: 26px;
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: -8px;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}

.footer-link{
	cursor: pointer;
	transition: all .5s;
	font-size: 14px;	
}
.footer-link:hover{
	color: red;
}

@media only screen and (min-device-width: 200px) and (max-device-width: 800px) {
	.container:hover .top:before, .container:active .top:before, .container:hover .bottom:before, .container:active .bottom:before, .container:hover .top:after, .container:active .top:after, .container:hover .bottom:after, .container:active .bottom:after {
		 margin-left: 200px;
		 transform-origin: -200px 50%;
		 transition-delay: 0s;
	}
	 .container:hover .center, .container:active .center {
		 opacity: 1;
		 transition-delay: 0.2s;
	}
	.center {
		width: 250px;
		height: 50%;
		top: 50%;
	left: 57%;
	 margin-left: -200px;
	 margin-top: -200px;
	 display: block;
	 flex-direction: column;
	 justify-content: center;
	 align-items: center;
	 padding: 50px;
	 opacity: 0;
	 transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
	 transition-delay: 0s;
	 color: #333;
}
.center input[type=text], .center input[type=password] {
    width: 90%;
    padding: 10px 10px;
    margin: 9px 0px;
    border-radius: 1px;
    border: 2px solid #ccc;
    font-family: inherit;
    transition: all 1s;
}

	*, *:before, *:after {
	 box-sizing: content-box;
	}
}

</style>
</head>
<body style="margin:0;padding: 0;">
<div class="container" onclick="onclick">
    <div class="top"></div>
    <div class="bottom"></div>
    <div class="center" id="login_form">
    	<center>
    		<img src="<?php echo base_url() ?>/assets/img/logo/logo.png" class="logo-image" alt="logo" /></center>
    		<?php echo $this->session->flashdata('msg'); ?>
    	<form  method="POST" autocomplete="off" action="<?=base_url()?>admin/login/login_user">
        <center><h2 class="text-center login-title">Log in</h2>
        <input type="text" class="form-input" name="username" placeholder="Enter Email ID"  value="<?php if(isset($_COOKIE["admin_username"])) { echo $_COOKIE["admin_username"]; } ?>" required/>
        <input type="password" class="form-input" name="password" placeholder="Enter Password" value="<?php if(isset($_COOKIE["admin_password"])) { echo $_COOKIE["admin_password"]; } ?>" required/> </center>
       <input type="checkbox" value="rememberMe" name="rememberMe" id="rememberMe">
        <label for="rememberMe"><small><b>Remember Me</b></small></label>
		<center><button class="button" type="submit" name="submit" id='login_btn'><span>Login </span></button>
		<p><small><b><span id='forgot_password' class="footer-link">Forgot Password ?</span></b></small></p>
        </center>
		</form>
    </div>
    <div class="center" id="forgot_password_form">
    	<center>
    	<img src="<?php echo base_url() ?>/assets/img/logo/logo.png" class="logo-image" alt="logo" />
    	<?php echo $this->session->flashdata('msg'); ?>
    	<form  method="POST" autocomplete="off" action="<?= base_url() ?>admin/login/reset_password">
        <h2 class="text-center login-title">Forgot Password</h2>
        <input type="text" class="form-input" name="username" placeholder="Enter Email ID" />
		<button class="button" type="submit" id='reset_pass'><span>Reset Password </span></button>
		<p><small><b><span id='gotoLogin' class="footer-link">Go to Login ?</span></b></small></p>
		</form>
        </center>
    </div>

</div>
<script type="text/javascript">

	$('#forgot_password_form').hide();
		var rotation = 0;
		jQuery.fn.rotate = function(degrees) {
		    $(this).css({'-webkit-transform' : 'rotate('+ degrees +'deg)',
		                 '-moz-transform' : 'rotate('+ degrees +'deg)',
		                 '-ms-transform' : 'rotate('+ degrees +'deg)',
		                 'transform' : 'rotate('+ degrees +'deg)'});
		};

		$('#forgot_password').click(function() {
		    rotation += 360;
		     $('#login_form').fadeOut(1);
			$('#login_form').delay(1500).rotate(rotation);
			$("#forgot_password_form").fadeIn(1);
			$('#forgot_password_form').delay(1500).rotate(rotation);
		});


		$('#gotoLogin').click(function() {
		    rotation += -360;
		     $('#forgot_password_form').fadeOut(1);
			 $('#forgot_password_form').delay(1500).rotate(rotation);
			 $("#login_form").fadeIn(1);
			 $('#login_form').delay(1500).rotate(rotation);
		});


		// 	$('#forgot_password').click(function() {
		//      $('#login_form').fadeOut(10);
		// 	$("#forgot_password_form").fadeIn(20);
		// });


		// $('#gotoLogin').click(function() {
		//      $('#forgot_password_form').fadeOut(10);
		// 	 $("#login_form").fadeIn(20);
		// });

		

</script>
</body>
</html>




}