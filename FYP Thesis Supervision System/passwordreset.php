<?php include('server.php') ?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>ThesisSupervision : Forgot Password</title>
    	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
	<body>
	    <?php include ('includes/layouts/navbar.php') ?>
		<div class="form-header">
			<h2>Forgot Password</h2>
		</div>
		<form method="post" action="passwordreset.php">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label>Enter your email address:</label>
				<input type="email" name="email" value="<?php echo $email; ?>">
			</div>
			<div class="input-group">
    			<label>Click on the button below to reset your password.</label><br>
			    <button type="submit" class="btn" name="pw_reset">Reset Password</button><br>
			</div>
		</form>
	</body>
</html>