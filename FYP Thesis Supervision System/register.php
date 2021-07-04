<?php include('server.php') ?>
<!DOCTYPE html>
<html>
	<head>
		<title>ThesisSupervision : Register</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php') ?>
		<div class="form-header">
			<h2>Register</h2>
		</div>
		
		<form method="post" action="register.php">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username" value="<?php echo $username; ?>">
			</div>
			<div class="input-group">
				<label>Email</label>
				<input type="email" name="email" value="<?php echo $email; ?>">
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password_1">
			</div>
			<div class="input-group">
				<label>Confirm password</label>
				<input type="password" name="password_2">
			</div>
			<div class="input-group">
				<label for="role">I am a:</label>
				<select name="role" id="role" class="role-container">
					<option value="1" class="role-option">Student</option>
					<option value="2" class="role-option">Lecturer</option>
					<option value="3" class="role-option">Coordinator</option>
					<option value="4" class="role-option">Dean</option>
				</select>
			    <label id="spec_label" for="specialisation" style="display: none; margin-top: 20px;">Specialisation Field:</label>
			    <div id="1"></div>
			    <select class="role-container" name="specialisation" id="2" style="display: none" disabled>
                    <option value="Social Work" class="role-option">Social Work</option>
			        <option value="Counselling" class="role-option">Counselling</option>
                </select>
                <div id="3"></div>
                <div id="4"></div>
                <br>
                <button type="submit" class="btn" name="reg_user">Sign Up</button>
				<br>
			</div>
			<p>
				Already a member? <a href="login.php">Sign in</a>
			</p>
		</form>
	</body>
	<script>
	    document.getElementById('role').onchange = function() {
            var i = 1;
            var mySel = document.getElementById(i);
            while(mySel) {
                document.getElementById('spec_label').style.display = 'none';
                mySel.style.display = 'none';
                mySel.disabled = true;
                mySel.required = false;
                mySel = document.getElementById(++i);
            }
            if (document.getElementById('role').value == "2") {
                document.getElementById('spec_label').style.display = 'block';
            }
            document.getElementById(this.value).style.display = 'block';
            document.getElementById(this.value).disabled = false;
            document.getElementById(this.value).required = true;
        };
	</script>
</html>