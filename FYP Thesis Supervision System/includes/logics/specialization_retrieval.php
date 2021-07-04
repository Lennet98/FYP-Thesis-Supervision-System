<?php 
	include('server.php');
	$query = "SELECT username FROM supervisors WHERE specialization='Social Work'";
	$result = mysqli_query($db, $query);
	$social_posts = array();
	while($social_result = mysqli_fetch_array($result)){
    	$social_posts[]=array("username"=>$social_result['username']);
    }
    
    $query = "SELECT username FROM supervisors WHERE specialization='Counselling'";
    $result = mysqli_query($db, $query);
	$counsel_posts = array();
	while($counsel_result = mysqli_fetch_array($result)){
    	$counsel_posts[]=array("username"=>$counsel_result['username']);
    }
?>