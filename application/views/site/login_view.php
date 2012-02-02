
<div id="login" class="box">
	<h2>Login</h2>
	<section>
		<!-- <div class="error msg">Message if login failed</div> -->
		<?php ME()->print_flash_message(); ?>
		<form action="<?php echo site_url('site/login'); ?>" method="post">
			<dl>
				<dt><label for="username">Username</label></dt>
				<dd><input id="username" type="text" name="username" value="<?php echo (@$sess->username);?>" /></dd>
			
				<dt><label for="adminpassword">Password</label></dt>
				<dd><input id="adminpassword" type="password" name="adminpassword" /></dd>
			</dl>
			<p>
				<button type="submit" class="button gray" name="loginbtn" id="loginbtn">LOGIN</button>
			</p>
		</form>
	</section>
</div>

<script>
	$('#username').focus();
</script>
