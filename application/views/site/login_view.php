
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
