<?php include('includes/logics/note_retrieval.php'); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Progress Note</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
	    <div class="forum-header" style="width: 40%">
	        <?php  if ($_SESSION['role']=="Student") : ?>
	            <h3><?php echo $username ?>'s Progress Notes</h3>
	        <?php elseif ($_SESSION['role']=="Lecturer" || $_SESSION['role']=="Coordinator") : ?>
	            <h3><?php echo $student_name?>'s Progress Notes</h3>
	        <?php endif ?>
        </div>
        <div class="forum-content" style="width: 40%">
            <?php include('errors.php'); ?>
            <?php if (isset($_SESSION['success'])) : ?>
			    <div class="error success" style="margin: 0px auto; width: 90%">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif ?>
            <div style="all:initial;">
                <div class="thesis-content" style="border: none; margin: 0 auto; padding-bottom: 0px; width: 100%;">
                    <div class="form-popup" id="pgForm">
                        <form method="post" action="progress_note.php" class="form-container">
                            <h3 style="text-decoration: underline">Add Progress Note</h3>
                            <div class="input-group">
                    		    <label>Submit Date:</label>
                				<input type="date" name="date" max="<?php echo date("Y-m-d") ?>" style="width: 95%;">
                            </div>
                            <label>Progress:</label>
                            <textarea id="description" name="description" placeholder="Enter Description" rows="6" cols="50" required style="width: 95%;"></textarea>
                            <button type="button" class="btn" onclick="closeForm()" style="background: red; margin-right: 0px;">Cancel</button>
                            <button type="submit" class="btn" name="add_note">Confirm</button>
                        </form>
                    </div>
                    <h3>List of Progress Notes: </h3>
                    <div class="spc_notes_content">
                        <?php  if ($_SESSION['role']=="Student") : ?>
                            <div style="padding-left: 20px; padding-bottom: 10px; text-decoration: underline; font-weight: bold;"><p>Date</p></div>
                            <div style="padding-left: 20px; padding-bottom: 10px; text-decoration: underline; font-weight: bold;"><p>Progress</p></div>
                        <?php endif ?>
                        <?php 
                            if(sizeof($posts) == 0) { ?>
                                <div style="padding-left: 20px;">   
                                    <p>No progress notes found.</p>
                                </div>
                        <?php } else { ?>
                            <?php foreach ($posts as $row) : ?>
                                <div style="padding-left: 20px;">
                                    <p><?php echo $row['date']; ?></p>
                                </div>
                                <div style="padding-left: 20px;">
                                    <p><?php echo $row['description']; ?></p>
                                </div>
                            <?php endforeach ?>
                        <?php } ?>
                    </div>
                    <?php  if ($_SESSION['role']=="Student") : ?>
                        <button class="btn" style="width: 20%; margin: 10px 0px 0px 0px;" onclick="openForm()">Add</button><br><br>
                    <?php elseif ($_SESSION['role']=="Lecturer") : ?>
                        <a href="edit_progress_note.php">
                            <button class="btn" style="width: 20%; margin: 10px 0px 0px 0px;">Edit</button><br><br>
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
	</body>
	<script>
        function openForm() {
          document.getElementById("pgForm").style.display = "block";
        }
        
        function closeForm() {
          document.getElementById("pgForm").style.display = "none";
        }
	</script>
</html>