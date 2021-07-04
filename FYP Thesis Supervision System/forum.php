<?php include('includes/logics/msg_retrieval.php'); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Forum</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
	    <div class="forum-header">
	        <h3>Welcome to the forum, <?php echo $_SESSION['username']; ?></h3>
        </div>
        <div class="forum-content">
            <?php include('errors.php'); ?>
            <?php if (isset($_SESSION['success'])) : ?>
				<div class="error success" style="width: 95%; margin: 0px 0px 20px 0px;" >
					<h3>
						<?php 
							echo $_SESSION['success']; 
							unset($_SESSION['success']);
						?>
					</h3>
				</div>
	    	<?php endif ?>
	    	<?php 
                if(sizeof($posts) == 0) { ?>
                    <div class="msg-content" style="padding-bottom: 20px;">   
                        <p>No previous messages found.</p>
                    </div>
            <?php } else { ?>
                <?php foreach ($posts as $row) : ?>
                    <div class="msg-content">
                        <?php 
                            $msg_date = date("j F Y", strtotime($row['timestamp']));
                            $msg_time = date("h:i A", strtotime($row['timestamp']));
                        ?>
                        <h4><strong><?php echo $msg_date ?></strong></h4>
                        <p>[<?php echo $msg_time ?>] <?php echo $row['username'] ?> : <?php echo $row['message'] ?></p><br>
                    </div>
                <?php endforeach ?>
            <?php } ?>
            <form method="post" action="forum.php" style="all:initial;">
                <div class="send-msg">
                    <input type="text" id="message" name="message" class="send-msg-container" placeholder="Enter message here..."/>
                    <button type="submit" class="btn" name="send_msg">Send</button>
                </div>
            </form>
        </div>
	</body>
</html>