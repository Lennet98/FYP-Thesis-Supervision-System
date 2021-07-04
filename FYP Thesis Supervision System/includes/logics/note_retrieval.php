<?php include('server.php'); ?>
<?php  if ($_SESSION['role']=="Student") : ?>
    <?php
        $username = $_SESSION['username'];
        $query = "SELECT * FROM progress_notes WHERE student_name='$username' ORDER BY date";
        $result = mysqli_query($db, $query);
        $posts = array();
        while($note_result = mysqli_fetch_array($result)){
        	$posts[]=array("note_id"=>$note_result['note_id'], "student_name"=>$note_result['student_name'],"date"=>$note_result['date'], "description"=>$note_result['description']);
        }
    ?>
<?php endif ?>

<?php  if ($_SESSION['role']=="Lecturer" || $_SESSION['role']=="Coordinator") : ?>
    <?php 
    	$student_name = $_SESSION['student'];
    	$query = "SELECT * FROM progress_notes WHERE student_name='$student_name' ORDER BY date";
    	$result = mysqli_query($db, $query);
    	$posts = array();
        while($note_result = mysqli_fetch_array($result)){
        	$posts[]=array("note_id"=>$note_result['note_id'], "student_name"=>$note_result['student_name'],"date"=>$note_result['date'], "description"=>$note_result['description']);
        }
    ?>
<?php endif ?>