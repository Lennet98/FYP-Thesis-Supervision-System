<?php include('server.php'); ?>
<?php  if ($_SESSION['role']=="Lecturer") : ?>
    <?php
    	$username = $_SESSION['username'];
    	$query = "SELECT * FROM thesis WHERE lect_name='$username'";
    	$result = mysqli_query($db, $query);
    	$posts = array();
        while($note_result = mysqli_fetch_array($result)){
        	$posts[]=array("thesis_id"=>$note_result['thesis_id'],"student_name"=>$note_result['student_name'],"lect_name"=>$note_result['lect_name'],"thesis_desc"=>$note_result['thesis_desc']);
        }
    ?>
<?php endif ?>
<?php  if ($_SESSION['role']=="Coordinator") : ?>
    <?php
    	$query = "SELECT * FROM thesis";
    	$result = mysqli_query($db, $query);
    	$posts = array();
        while($note_result = mysqli_fetch_array($result)){
        	$posts[]=array("thesis_id"=>$note_result['thesis_id'],"student_name"=>$note_result['student_name'],"lect_name"=>$note_result['lect_name'],"thesis_desc"=>$note_result['thesis_desc']);
        }
    ?>
<?php endif ?>