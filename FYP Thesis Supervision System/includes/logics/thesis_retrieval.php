<?php 
	include('server.php');
	$query = "SELECT * FROM thesis";
	$result = mysqli_query($db, $query);
	$thesis_posts = array();
	while($thesis_result = mysqli_fetch_array($result)){
    	$thesis_posts[]=array("thesis_id"=>$thesis_result['thesis_id'],"thesis_desc"=>$thesis_result['thesis_desc']);
    }
?>