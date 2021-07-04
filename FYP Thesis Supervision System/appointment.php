<?php include('server.php') ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Make Appointment</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style>
		    .error-popup {
		        background: white;
		    }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
        <div class="form-header" style="width:30%;">
			<h2 style="text-decoration: underline;">Make an Appointment</h2>
		</div>
		<form method="post" action="appointment.php" enctype="multipart/form-data">
		    <?php if (isset($_SESSION['success'])) : ?>
    			<div class="error success" style="width:95%; margin-top: 10px;">
    				<h3>
    					<?php 
    						echo $_SESSION['success']; 
    						unset($_SESSION['success']);
    					?>
    				</h3>
    			</div>
    		<?php endif ?>
    		<?php include('errors.php'); ?>
    		<div class="input-group">
    		    <label>Date:</label>
				<input type="date" id="apt_date" name="apt_date" min="<?php echo date("Y-m-d") ?>" required>
            </div>
    		<div class="input-group">
    			<label>Time:</label>
				<input type="time" id="apt_time" name="apt_time" required>
    		</div>
    		<div class="input-group" style="width: 100%">
    			<label>Reason:</label>
                <textarea placeholder="Please be thoughtful when sending out appointment requests." id="reason" name="reason" rows="6" style="padding: 10px; width: 93%;" required></textarea>
    		</div>
    		<div class="input-group" style="width: 100%; margin: 0 auto;">
    		    <button type="submit" class="btn" style="width: 97%; float:none;" name="send_apt">Send</button><br>
    		</div>
		</form>
	</body>
</html>