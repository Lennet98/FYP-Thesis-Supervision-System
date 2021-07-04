<?php include('includes/logics/mg_note_retrieval.php'); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Manage Progress Notes</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style>
		    .confirm {
		        display: none;
		        position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 30%;
            }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
	    <div class="forum-header" style="width: 50%">
	        <h3>Manage Progress Notes</h3>
        </div>
        <div class="forum-content" style="width: 50%">
            <?php include('errors.php'); ?>
            <?php if (isset($_SESSION['success'])) : ?>
			    <div class="error success" style="margin: 0px auto; width: 90%">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif ?>
            <div class="thesis-content" style="border: none; margin: 0 auto; width: 100%;">
                <h3>List of Students:</h3>
                <div class="mg_notes_content">
                    <div style="padding-left: 20px; text-decoration: underline; font-weight: bold"><p>Student Name</p></div>
                    <div style="padding-left: 20px; text-decoration: underline; font-weight: bold"><p>Thesis Title</p></div>
                    <div style="padding-left: 20px; text-decoration: underline; font-weight: bold">
                        <p><?php  if ($_SESSION['role']=="Coordinator") : ?>Supervisor<?php endif?></p>
                    </div>
                    <div style="padding-left: 20px; text-decoration: underline; font-weight: bold"><p></p></div>
                </div>
                <?php 
                    if(sizeof($posts) == 0) { ?>
                        <div style="border: 1px solid; border-top: none; padding: 20px 35px;">   
                            <p>No progress notes found.</p>
                        </div>
                <?php } else { ?>
                    <?php $count = 1 ?>
                    <?php foreach ($posts as $row) : ?>
                        <form method="post" action="student_info.php" style="all:initial;">
                            <input id="student_name<?php echo $count; ?>" name="student_name<?php echo $count; ?>" value="<?php echo $row['student_name']; ?>" style="display:none;">
                            <input id="count" name="count" value="<?php echo $count ?>" style="display:none;">
                            <div class="mg_notes_content" style="border-top: none;">
                                <div style="padding: 10px 0px 0px 20px;">
                                    <p><?php echo $row['student_name']; ?></p>
                                </div>
                                <div style="padding: 10px 0px 0px 20px;">
                                    <p><?php echo $row['thesis_desc']; ?></p>
                                </div>
                                <div style="padding: 10px 0px 0px 20px;">
                                    <p><?php  if ($_SESSION['role']=="Coordinator") : ?><?php echo $row['lect_name']; ?><?php endif ?></p>
                                </div>
                                <div>
                                    <div class="mg-thesis-option">                            
                                        <button type="submit" class="btn" name="get_notes" style="float:none;">View</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endforeach ?>
                <?php } ?>
            </div>
        </div>
	</body>
</html>