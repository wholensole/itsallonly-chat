<?php
	include ('functions.php');
	get_header();
	if (is_loggedin()) {
		redirect('/');
	}else{
		?>
		<div class="mid-box">
			<p><span id="login" class="login-text">Login</span> | <span id="register" class="login-text">Register</span></p>
			<form class="login-box" data-id="login" method="POST" action="action.php">
				<h1>Login to ChatApp</h1>
				<input type="text" name="email" placeholder="Email or Chat Handle" />
				<input type="password" name="password" placeholder="Password" />
				<input type="hidden" name="action" value="login">
				<button type="submit">Login</button>
			</form>
			<form class="login-box closed" data-id="register" method="POST" action="action.php">
				<h1>Register to ChatApp</h1>
				<input type="text" name="email" placeholder="Email" />
				<input type="text" name="username" placeholder="Chat Handle" />
				<input type="hidden" name="action" value="register">
				<button type="submit">Register</button>
			</form>
			<form class="login-box closed" data-id="forgot" method="POST" action="action.php">
				<h1>Forgot Password</h1>
				<input type="text" name="username" placeholder="Email or Chat Handle" />
				<input type="hidden" name="action" value="forgot-password">
				<button type="submit">Get Password</button>
			</form>
			<p><span id="forgot" class="login-text">Forgot Password</span></p>
		</div>
		<?php
	}
	get_footer();
?>