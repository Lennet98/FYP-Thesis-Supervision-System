<?php include('server.php') ?>
<!DOCTYPE html>
<html>
	<head>
		<title>ThesisSupervision : Reset Password</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php') ?>
		<div class="form-header">
			<h2>Reset Password</h2>
		</div>
		 
		<form method="post" action="reset-password.php">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label>Email:</label>
				<input type="email" name="email" value="<?php echo $email; ?>">
			</div>
			<div class="input-group">
				<label>Enter New Password:</label>
				<input type="password" name="password_1"/>
			</div>
			<div class="input-group">
				<label>Re-Enter New Password:</label>
				<input type="password" name="password_2"/>
			</div>
			<div class="input-group">
				<button type="submit" class="btn" name="update_password"/>Confirm</button><br>
			</div>
		</form>
	</body>
</html>