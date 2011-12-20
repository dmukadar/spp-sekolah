<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Adminique - admin template</title>
<meta charset="utf-8">
<base href="<?php echo base_url(); ?>"></base>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/skins/orange.css">
<!--[if lte IE 8]>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/Delicious_500.font.js"></script>
<script type="text/javascript">
$(function() {
	Cufon.replace('#site-title');
	$('.msg').click(function() {
		$(this).fadeTo('slow', 0);
		$(this).slideUp(341);
	});
});
</script>

</head>
<body>

<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_12">
			<!-- replace with your website title or logo -->
			<a id="site-title" href="dashboard.html"><span>Admin</span>ique</a>
			<a id="view-site" href="#">View Site</a>
		</div>
	</div>
</header>

<div id="login" class="box">
	<h2>Login</h2>
	<section>
		<div class="error msg">Message if login failed</div>
		<form action="<?php echo site_url('site/login'); ?>">
			<dl>
				<dt><label for="username">Username</label></dt>
				<dd><input id="username" type="text" /></dd>
			
				<dt><label for="adminpassword">Password</label></dt>
				<dd><input id="adminpassword" type="password" /></dd>
			</dl>
			<label><input type="checkbox" />Remember Me</label>
			<p>
				<button type="submit" class="button gray" id="loginbtn">LOGIN</button>
				<a id="forgot" href="#">Forgot Password?</a>
			</p>
		</form>
	</section>
</div>

</body>
</html>
