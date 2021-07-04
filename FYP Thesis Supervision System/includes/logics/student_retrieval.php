<?php 
	include('server.php');
	$username = $_SESSION['username'];
	if ($_SESSION['role']=="Lecturer") {
	    $query = "SELECT * FROM thesis WHERE lect_name='$username'";
	} else if ($_SESSION['role']=="Dean") {
	    $query = "SELECT * FROM thesis";
	}
	$result = mysqli_query($db, $query);
	$student_posts = array();
	while($student_result = mysqli_fetch_array($result)){
    	$student_posts[]=array("thesis_id"=>$student_result['thesis_id'],"student_name"=>$student_result['student_name'],"lect_name"=>$student_result['lect_name'],"thesis_desc"=>$student_result['thesis_desc']);
    }
?>