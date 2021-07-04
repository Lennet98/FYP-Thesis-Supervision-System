<?php 
	include('server.php');
	$username = $_SESSION['username'];
	$query = "SELECT * FROM users WHERE username='$username'";
	$result = mysqli_query($db, $query);
	$profile_check = mysqli_fetch_array($result);
	$assoc_email = $profile_check['email'];
	$profile_query = "SELECT * FROM profile WHERE email='$assoc_email'";
	$profile_query_result = mysqli_query($db, $profile_query);
	$profile_result = mysqli_fetch_array($profile_query_result);
	if ($_SESSION['role']=="Lecturer") {
	    $query = "SELECT specialization FROM supervisors WHERE username='$username'";
	    $result = mysqli_query($db, $query);
	    $specialisation = mysqli_fetch_array($result);
	    $assoc_specialisation = $specialisation['specialization'];
	}
?>