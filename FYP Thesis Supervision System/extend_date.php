<?php include('server.php') ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Extend Due Date</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
        <div class="form-header" style="width:30%;">
			<h2 style="text-decoration: underline;">Request to Incomplete Status</h2>
		</div>
		<form method="post" action="extend_date.php" enctype="multipart/form-data">
		    <?php if (isset($_SESSION['success'])) : ?>
    			<div class="error success" style="margin: 0px 0px 20px 0px; width:93%;">
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
    		    <label>Submit Date:</label>
				<input type="date" id="extd_date" name="extd_date" required>
            </div>
    		<div class="input-group" style="width: 100%">
    			<label>Reason:</label>
                <textarea placeholder="Please be thoughtful when sending out requests." id="extd_reason" name="extd_reason" rows="6" style="padding: 10px; width: 93%;" required></textarea>
    		</div>
    		<div class="input-group" style="width: 100%; margin: 0 auto;">
    		    <button type="submit" class="btn" style="width: 97%; float:none;" name="send_extd">Send</button><br>
    		</div>
		</form>
	</body>
</html>