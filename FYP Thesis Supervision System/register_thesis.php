<?php include('includes/logics/specialization_retrieval.php'); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Register Thesis & Supervisor</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style>
		    .thesis-option {
		        width: 100%;
		        padding: 10px;
		        border-radius: 5px;
		        font-size: 1vw;
		    }
		    .thesis-option option {
		        font-size: 1vw;
		    }
		    .thesis-input {
		        padding: 10px 10px;
		        width: 98%;
		        text-align: left;
		        border-radius: 5px;
		        border: solid 1px;
		        font-size: 1vw;
		    }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
	    <div class="forum-header">
	        <h3>Register Thesis Title & Supervisor</h3>
        </div>
        <div class="forum-content">
            <?php include('errors.php'); ?>
            <?php if (isset($_SESSION['success'])) : ?>
			    <div class="error success" style="margin: 0px auto; width: 90%">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif ?>
            <form method="post" action="register_thesis.php" style="all:initial;">
                <div class="thesis-content">
                    <h4>Your field: </h4><hr>
                    <fieldset id="thesis_title" class="thesis_style">
                        <select class="thesis-option" name="options" id="options" required>
                            <option disabled selected value> -- Select a field -- </option>
                            <option value="1">Social Work</option>
                            <option value="2">Counselling</option>
                        </select>
                    </fieldset>
                </div>
                <div class="thesis-content">
                    <h4>Your proposed thesis title: </h4><hr>
                    <fieldset id="thesis_title" class="thesis_style">
                        <input type="text" class="thesis-input" id="thesis" name="thesis" placeholder="Enter a suitable title" required>
                    </fieldset>
                </div>
                <div class="thesis-content">
                    <h4>Your proposed supervisor:</h4><hr>
                    <fieldset id="thesis_supervisor" class="thesis_style">
                        <select class="thesis-option" name="lect_options" id="1" style="display: none" disabled>
                            <option disabled selected value> -- Select a supervisor -- </option>
                            <?php foreach ($social_posts as $row) : ?>
                                <option><?php echo $row['username']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <select class="thesis-option" name="lect_options" id="2" style="display: none" disabled>
                            <option disabled selected value> -- Select a supervisor -- </option>
                            <?php foreach ($counsel_posts as $row) : ?>
                                <option><?php echo $row['username']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </fieldset>
                </div>
                <div style="padding-top: 10px; margin: 10px auto; width: 90%; text-align:center;">
                    <button type="submit" class="btn" name="submit_rq" style="float:none;">Submit Request</button>
                </div>
            </form>
        </div>
	</body>
	<script>
	    document.getElementById('options').onchange = function() {
            var i = 1;
            var mySel = document.getElementById(i);
            while(mySel) {
                mySel.style.display = 'none';
                mySel.disabled = true;
                mySel.required = false;
                mySel = document.getElementById(++i);
            }
            document.getElementById(this.value).style.display = 'block';
            document.getElementById(this.value).disabled = false;
            document.getElementById(this.value).required = true;
        };
	</script>
</html>