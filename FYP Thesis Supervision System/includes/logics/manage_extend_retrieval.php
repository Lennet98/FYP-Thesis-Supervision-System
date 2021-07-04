<?php include('server.php'); ?>
<?php
	$query = "SELECT * FROM incomplete_request";
	$result = mysqli_query($db, $query);
	$posts = array();
    while($extend_result = mysqli_fetch_array($result)){
    	$posts[]=array("request_id"=>$extend_result['request_id'], "student"=>$extend_result['student'], "request_date"=>$extend_result['request_date'], "reason"=>$extend_result['reason']);
    }
?>