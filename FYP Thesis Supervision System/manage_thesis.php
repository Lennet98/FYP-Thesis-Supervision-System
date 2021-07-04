<?php include('includes/logics/request_retrieval.php'); ?>
<?php include('includes/logics/specialization_retrieval.php'); ?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Manage Theses</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style>
		    .spc_thesis_content {
		        grid-template-columns: 15% 25% 15% 10% 15% 20%;
		    }
		    .thesis-option {
		        width: 90%;
		        padding: 5px;
		        border-radius: 5px;
		        font-size: 0.8vw;
		    }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
	    <div class="forum-header" style="width: 60%">
	        <h3>Manage Thesis Requests</h3>
        </div>
        <div class="forum-content" style="width: 60%">
            <div class="thesis-content" style="border: none; margin: 0 auto; width: 100%;">
                <h3>List of Requests: </h3>
                <?php include('errors.php'); ?>
                <?php if (isset($_SESSION['success'])) : ?>
    			    <div class="error success" style="font-weight: bold; margin: 10px 0px; width: 98%">
                        <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif ?>
                <div class="spc_thesis_content">
                    <div style="text-decoration: underline; font-weight: bold"><p>Student Name</p></div>
                    <div style="text-decoration: underline; font-weight: bold"><p>Thesis Title</p></div>
                    <div style="text-decoration: underline; font-weight: bold"><p>Supervisor Name</p></div>
                    <div style="text-align: center;"><p></p></div>
                    <div style="text-align: center;"><p></p></div>
                    <div style="text-align: center;"><p></p></div>
                </div>
                <?php 
                    if(sizeof($posts) == 0) { ?>
                        <div style="border: 1px solid; border-top: none; padding: 20px 35px;">   
                            <p>No available requests found.</p>
                        </div>
                <?php } else { ?>
                    <?php $count = 1 ?>
                    <?php foreach ($posts as $row) : ?>
                        <form method="post" action="manage_thesis.php" style="all:initial;">
                            <input id="student_name<?php echo $count; ?>" name="student_name<?php echo $count; ?>" value="<?php echo $row['student_name']; ?>" style="display:none;">
                            <input id="thesis_title<?php echo $count; ?>" name="thesis_title<?php echo $count; ?>" value="<?php echo $row['thesis_title']; ?>" style="display:none;">
                            <input id="lect_name<?php echo $count; ?>" name="lect_name<?php echo $count; ?>" value="<?php echo $row['lect_name']; ?>" style="display:none;">
                            <input id="count" name="count" value="<?php echo $count ?>" style="display:none;">
                            <div class="spc_thesis_content" style="border-top:none;">
                                <div style="padding-top: 10px;">
                                    <p><?php echo $row['student_name']; ?></p>
                                </div>
                                <div style="padding-top: 10px;">
                                    <p><?php echo $row['thesis_title']; ?></p>
                                </div>
                                <div style="padding-top: 10px;">
                                    <p><?php echo $row['lect_name']; ?></p>
                                </div>
                                <div class="mg-thesis-option">                            
                                    <button type="submit" class="btn" name="accept_rq" style="float:none;">Approve</button>
                                </div>
                                <div class="mg-thesis-option">                            
                                    <button type="submit" class="btn" name="reject_rq" style="font-size: 0.67vw; float:none; background: red;">Change Supervisor</button>
                                </div>
                                <div class="mg-thesis-option">
                                    <select class="thesis-option" name="supervisor<?php echo $count; ?>" id="supervisor<?php echo $count; ?>">
                                        <option disabled selected value> -- Select a supervisor -- </option>
                                        <?php if ($row['specialization']=='Social Work') : ?>
                                            <?php foreach ($social_posts as $row) : ?>
                                                <option><?php echo $row['username']; ?></option>
                                            <?php endforeach ?>
                                        <?php elseif ($row['specialization']=='Counselling') : ?>
                                            <?php foreach ($counsel_posts as $row) : ?>
                                                <option><?php echo $row['username']; ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
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