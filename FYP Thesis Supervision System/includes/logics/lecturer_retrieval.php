<?php 
	include('server.php');
	$query = "SELECT * FROM users WHERE role='Lecturer'";
	$result = mysqli_query($db, $query);
	$lect_posts = array();
	while($lect_result = mysqli_fetch_array($result)){
    	$lect_posts[]=array("id"=>$lect_result['id'],"username"=>$lect_result['username'],"email"=>$lect_result['email']);
    }
?>