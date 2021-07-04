<?php 
	$username = $_SESSION['username'];
	$query = "SELECT * FROM announcements WHERE username='$username' ORDER BY annc_id DESC";
	$result = mysqli_query($db, $query);
	$posts = array();
    while($annc_result = mysqli_fetch_array($result)){
    	$posts[]=array("annc_id"=>$annc_result['annc_id'],"username"=>$annc_result['username'],"announcement"=>$annc_result['announcement']);
    }
?>