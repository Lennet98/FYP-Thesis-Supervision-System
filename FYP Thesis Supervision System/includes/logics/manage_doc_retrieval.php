<?php 
	$username = $_SESSION['username'];
	$query = "SELECT * FROM documents WHERE username='$username' ORDER BY doc_id ASC";
	$result = mysqli_query($db, $query);
	$posts = array();
    while($doc_result = mysqli_fetch_array($result)){
    	$posts[]=array("doc_id"=>$doc_result['doc_id'],"username"=>$doc_result['username'],"doc_path"=>$doc_result['doc_path'],"turnitin_id"=>$doc_result['turnitin_id'],"similarity"=>$doc_result['similarity']);
    }
?>