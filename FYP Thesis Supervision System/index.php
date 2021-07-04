<?php 
	include('server.php'); 

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: boardingPage.php');
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		unset($_SESSION['email']);
		header("location: login.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ThesisSupervision : Home</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php') ?>
        <?php include ('includes/layouts/dashboard.php') ?>
	</body>
</html>