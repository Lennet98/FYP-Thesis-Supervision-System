<?php include('includes/logics/student_retrieval.php') ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Student's Info</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style>
		    .student_info_content {
                display: grid;
                grid-template-columns: 50% 50%;
                padding: 15px;
                padding-bottom: 15px;
                border: none;
                font-size: 1vw;
            }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
	    <div class="forum-header" style="width: 30%">
	        <h3>Student's Info</h3>
        </div>
        <div class="forum-content" style="width: 30%">
            <div class="thesis-content" style="border: none; margin: 0 auto; width: 100%;">
                <?php include('errors.php'); ?>
                <?php if (isset($_SESSION['success'])) : ?>
    			    <div class="error success" style="font-weight: bold; margin: 0px auto; width: 98%">
                        <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif ?>
                <?php 
                    if(sizeof($student_posts) == 0) { ?>
                        <div style="padding-left: 20px;">   
                            <p>No assigned students found.</p>
                        </div>
                <?php } else { ?>
                    <?php $count = 1 ?>
                    <?php foreach ($student_posts as $row) : ?>
                        <form method="post" action="student_info.php" style="all:initial;">
                            <input id="student_name<?php echo $count; ?>" name="student_name<?php echo $count; ?>" value="<?php echo $row['student_name']; ?>" style="display:none;">
                            <input id="count" name="count" value="<?php echo $count ?>" style="display:none;">
                            <div class="student_info_content" style="border-top:none;">
                                <div style="padding-top: 10px;">
                                    <p><strong><?php echo $row['student_name']; ?></strong></p>
                                </div>
                                <div class="mg-thesis-option">                            
                                    <button type="submit" class="btn" name="get_info" style="float:none;">View</button>
                                </div>
                                <?php $count += 1 ?>
                            </div>
                        </form>
                    <?php endforeach ?>
                <?php } ?>
            </div>
        </div>
	</body>
</html>