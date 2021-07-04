<?php 
	include('server.php');
	$student_name = $_SESSION['student'];
	$query = "SELECT * FROM users WHERE username='$student_name'";
	$result = mysqli_query($db, $query);
	$profile_check = mysqli_fetch_array($result);
	$assoc_email = $profile_check['email'];
	$profile_query = "SELECT * FROM profile WHERE email='$assoc_email'";
	$profile_query_result = mysqli_query($db, $profile_query);
	$profile_result = mysqli_fetch_array($profile_query_result);
?>