<?php include('includes/logics/manage_extend_retrieval.php'); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Manage Incomplete Status Request</title>
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
            .mg_extend_content {
                display: grid;
                grid-template-columns: auto auto 40% 10% 10%;
                padding: 15px 15px 10px 15px;
                margin-bottom: 0px;
                border: 1px solid black;
            }
            .form-extension {
                width:100%;
                padding:0px;
                border: none;
                margin-bottom: 0px;
            }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
	    <div class="forum-header" style="width: 60%">
	        <h3>Manage Incomplete Status Request</h3>
        </div>
        <div class="forum-content" style="width: 60%">
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
                <h3>Student's Request to Incomplete Status:</h3>
                <div class="mg_extend_content">
                    <div style="padding-left: 20px; padding-bottom: 10px; text-decoration: underline; font-weight: bold"><p>Name</p></div>
                    <div style="padding-left: 20px; padding-bottom: 10px; text-decoration: underline; font-weight: bold"><p>Date</p></div>
                    <div style="padding-left: 20px; padding-bottom: 10px; text-decoration: underline; font-weight: bold"><p>Reason</p></div>
                    <div style="padding-bottom: 10px; text-decoration: underline; font-weight: bold; text-align: center;"><p></p></div>
                    <div style="padding-bottom: 10px; text-decoration: underline; font-weight: bold; text-align: center;"><p></p></div>
                </div>
                <?php 
                    if(sizeof($posts) == 0) { ?>
                        <div style="border: 1px solid; border-top: none; padding: 20px 35px;">   
                            <p>No availabe requests found.</p>
                        </div>
                <?php } else { ?>
                    <?php $count = 1 ?>
                    <?php foreach ($posts as $row) : ?>
                        <form method="post" action="index.php" class="form-extension">
                            <input id="request_id<?php echo $count; ?>" name="request_id<?php echo $count; ?>" value="<?php echo $row['request_id']; ?>" style="display:none;">
                            <input id="count" name="count" value="<?php echo $count ?>" style="display:none;">
                            <div class="mg_extend_content" style="border-top:none;">
                                <div style="padding-left: 20px;">
                                    <p><?php echo $row['student']; ?></p>
                                </div>
                                <div style="padding-left: 20px;">
                                    <p><?php echo $row['request_date']; ?></p>
                                </div>
                                <div style="padding-left: 20px; word-wrap: break-word;">
                                    <p><?php echo $row['reason']; ?></p>
                                </div>
                                <div class="mg-thesis-option">  
                                    <?php  if ($_SESSION['role']=="Lecturer" || $_SESSION['role']=="Dean") : ?>
                                    <button type="submit" class="btn" name="accept_extd" style="width: 80%; float:none;">Approve</button>
                                    <?php endif ?>
                                </div>
                                <div class="mg-thesis-option">      
                                    <?php  if ($_SESSION['role']=="Lecturer" || $_SESSION['role']=="Dean") : ?>
                                    <button type="submit" class="btn" name="reject_extd" style="width: 80%; float:none; background:red;">Reject</button>
                                    <?php endif ?>
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