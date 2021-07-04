<?php 
	include('server.php');
	$username = $_SESSION['username'];
	$query = "SELECT * FROM forum ORDER BY timestamp ASC";
	$result = mysqli_query($db, $query);
	$posts = array();
    while($msg_result = mysqli_fetch_array($result)){
    	$posts[]=array("timestamp"=>$msg_result['timestamp'],"username"=>$msg_result['username'],"message"=>$msg_result['message']);
    }
?>