<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ThesisSupervision</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<style type="text/css">
		#caption {
		    text-align: center;
		    font-size: 2vw;
		}
		#caption input {
			width: 10%;
			color: white;
			font-size: 1vw;
			display: block;
			margin-left: auto;
			margin-right: auto;
			margin-top: 20px;
			padding: 12px 28px;
			border: none;
			border-radius: 8px;
			background-color: #013163;
		}
	</style>
</head>
	<body>
	    <?php include ('includes/layouts/navbar.php') ?>
		<div class="logo-container">
			<img class="thesislogo" alt="ThesisMS Logo" src="assets/img/thesisms_logo.png" />
			<p>ThesisSupervision</p><br>
		</div>
		<div id="caption">
		    <p>The hub for all thesis purposes.</p>
		    <input onclick="document.location='register.php'" type="button" value="Get Started" />
		</div>
	</body>
</html>