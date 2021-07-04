<?php 
	include('server.php');
	$username = $_SESSION['username'];
	$query = "SELECT * FROM thesis_application";
	$result = mysqli_query($db, $query);
	$posts = array();
    while($app_result = mysqli_fetch_array($result)){
    	$posts[]=array("student_name"=>$app_result['student_name'],"lect_name"=>$app_result['lect_name'],"specialization"=>$app_result['specialization'],"thesis_title"=>$app_result['thesis_title']);
    }
?>