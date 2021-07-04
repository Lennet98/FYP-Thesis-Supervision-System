<?php include('server.php'); ?>
<?php include('includes/logics/manage_annc_retrieval.php'); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Edit Announcement</title>
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
            .announcement_content {
                display: grid;
                grid-template-columns: 20% auto 10% 10%;
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
            textarea {
                width: 90%;
                height: auto;
                box-sizing: border-box;
                padding: 10px;
            }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
	    <div class="forum-header" style="width: 60%">
	        <h3>Edit Announcements</h3>
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
                <div class="announcement_content">
                    <div style="padding-left: 20px; padding-bottom: 10px; text-decoration: underline; font-weight: bold"><p>Posted by</p></div>
                    <div style="padding-left: 20px; padding-bottom: 10px; text-decoration: underline; font-weight: bold"><p>Description</p></div>
                    <div style="padding-bottom: 10px; text-decoration: underline; font-weight: bold; text-align: center;"><p></p></div>
                    <div style="padding-bottom: 10px; text-decoration: underline; font-weight: bold; text-align: center;"><p></p></div>
                </div>
                <?php 
                    if(sizeof($posts) == 0) { ?>
                        <div style="border: 1px solid; border-top: none; padding: 20px 35px;">   
                            <p>No editable announcements.</p>
                        </div>
                <?php } else { ?>
                    <?php $count = 1 ?>
                    <?php foreach ($posts as $row) : ?>
                        <form method="post" action="index.php" class="form-extension">
                            <input id="annc_id<?php echo $count; ?>" name="annc_id<?php echo $count; ?>" value="<?php echo $row['annc_id']; ?>" style="display:none;">
                            <input id="count" name="count" value="<?php echo $count ?>" style="display:none;">
                            <div class="announcement_content" style="border-top:none;">
                                <div style="padding-left: 20px;">
                                    <p><?php echo $row['username']; ?></p>
                                </div>
                                <div style="padding-left: 20px; word-wrap: break-word;">
                                    <textarea id="announcement<?php echo $count; ?>" name="announcement<?php echo $count; ?>" placeholder="Enter Description" rows="6"><?php echo $row['announcement']; ?></textarea>
                                </div>
                                <div class="mg-thesis-option">  
                                    <button type="submit" class="btn" name="edit_anc" style="width: 80%; float:none;">Edit</button>
                                </div>
                                <div class="mg-thesis-option">      
                                    <button type="submit" class="btn" name="del_anc" style="width: 80%; float:none; background:red;">Delete</button>
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