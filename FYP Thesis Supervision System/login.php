<?php include('server.php') ?>
<!DOCTYPE html>
<html>
	<head>
		<title>ThesisSupervision : Log In</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style type="text/css">
		    #hints {
		        line-height: 1.8;
		    }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php') ?>
		<?php if (isset($_SESSION['success'])) : ?>
				<div class="error success" style="width:30%;">
					<h3>
						<?php 
							echo $_SESSION['success']; 
							unset($_SESSION['success']);
						?>
					</h3>
				</div>
		<?php endif ?>
		<div class="form-header">
			<h2>Log In</h2>
		</div>
		 
		<form method="post" action="login.php">
			<?php include('errors.php'); ?>
			<br>
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username"/>
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password"/>
			</div>
			<div class="input-group">
				<label for="role">I am a:</label>
				<select name="role" id="role" class="role-container">
					<option value="Student" class="role-option">Student</option>
					<option value="Lecturer" class="role-option">Lecturer</option>
					<option value="Coordinator" class="role-option">Coordinator</option>
					<option value="Dean" class="role-option">Dean</option>
				</select>
				<button type="submit" class="btn" name="login_user">Log In</button>
				<br>
			</div>
			<div id="hints">
    			<p>
    			    Forgot your password? <a href="passwordreset.php">Reset Password</a><br>
    				Not yet a member? <a href="register.php">Sign up</a>
    			</p>
    		</div>
		</form>
	</body>
</html>