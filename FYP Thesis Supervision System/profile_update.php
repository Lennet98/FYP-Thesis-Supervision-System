<?php include('includes/logics/profile_retrieval.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Update Profile</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style type="text/css">
		    .input-group label {
		        font-weight: bold;
		    }
		    .input-group p {
		        margin: 3px;
		    }
		    .input-group img {
		        border: 1px #013163;
		    }
		    .btn {
		        float: none;
		        display: block;
		        margin-left: auto;
                margin-right: auto;
		    }
		    .imgUpload {
		        display: block;
		        margin-left: auto;
                margin-right: auto;
                font-size: 1vw;
                font-family: times;
		    }
		    .profile-progress {
		        display: grid;
                grid-template-columns: 20% 80%;
		    }
		    .profile-checkbox {
		        width: 50%;
		        margin: auto;
		    }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
		<div class="form-header" style="width:40%;">
			<h2 style="text-decoration: underline;">Profile</h2>
			<p><?php echo $username?></p>
		</div>
		<form method="post" action="profile_update.php" enctype="multipart/form-data" style="width: 40%;">
			<?php include('errors.php'); ?>
			<div class="input-group" style="text-align:center;">
				<p>Fields marked with ( * ) are unable to be updated.</p><br>
			    <?php if (($profile_result['profile_picture'] == '')||(!file_exists($profile_result['profile_picture']))){
			        $temp_image = 'assets/img/default_profile.png';
			    ?>
			        <img src="<?php echo $temp_image; ?>" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
			    <?php } else { ?>
			        <img src="<?php echo $profile_result['profile_picture']; ?>" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
			    <?php } ?>
            </div>
            <input type="file" name="fileToUpload" id="fileToUpload" class="imgUpload" accept="image/*"><br/>
			<div class="input-group">
				<label>Name:</label>
				<input type="text" name="profile_name" value="<?php echo $profile_result['name']; ?>">
			</div>
			<div class="input-group">
				<label>*Email:</label>
				<input type="email" name="email" value="<?php echo $profile_result['email']; ?>" readonly>
			</div>
			<div class="input-group">
				<label>Phone:</label>
				<input type="text" name="phone" value="<?php echo $profile_result['phone']; ?>">
			</div>
			<div class="input-group">
				<label>Address:</label>
				<input type="text" name="address" value="<?php echo $profile_result['address']; ?>">
			</div>
			<?php  if ($_SESSION['role']=="Lecturer") : ?>
			<div class="input-group">
			    <label>Specialisation Field:</label>
				<select name="specialisation" id="specialisation" class="role-container" style="padding: 16px 10px;">
				    <option disabled selected class="role-option"> -- Select a field -- </option>
					<option value="Social Work" class="role-option">Social Work</option>
					<option value="Counselling" class="role-option">Counselling</option>
				</select>
		    </div>
			<?php endif ?>
            <?php  if ($_SESSION['role']=="Student") : ?>
			<div class="input-group">
				<label>Inasis:</label>
				<input type="text" name="inasis" value="<?php echo $profile_result['inasis']; ?>">
			</div>
			<div class="input-group">
				<label>Semester:</label>
				<input type="text" name="semester" value="<?php echo $profile_result['semester']; ?>">
			</div>
			<div class="input-group">
				<label>College:</label>
				<input type="text" name="college" value="<?php echo $profile_result['college']; ?>">
			</div>
			<div class="input-group">
				<label>School:</label>
				<input type="text" name="school" value="<?php echo $profile_result['school']; ?>">
			</div>
			<div class="input-group">
				<label>Guardian Number:</label>
				<input type="text" name="guardian_no" value="<?php echo $profile_result['guardian_no']; ?>">
			</div>
			<div class="input-group">
				<label>*Thesis Title:</label>
				<input type="text" name="thesis_title" value="<?php echo $profile_result['thesis_title']; ?>" readonly>
			</div>
			<div class="input-group">
				<label>*Supervisor:</label>
				<input type="text" name="supervisor" value="<?php echo $profile_result['supervisor']; ?>" readonly>
			</div>
			<br>
			<div class="input-group">
			    <div class="profile-progress">
			        <div>
				        <label>Progress:</label>
			        </div>
			        <div>
			            <div class="profile-progress">
			                <div>
                				<p>Proposal</p>
			                </div>
			                <div class="profile-checkbox">
			                    <input type="checkbox" name="progress" value=1
			                        <?php if ($profile_result['progress'] != 0){ ?>
			                            checked
			                        <?php } ?>
		                        >
			                </div>
		                </div>
		                <div class="profile-progress">
			                <div>
                				<p>Introduction</p>
			                </div>
			                <div class="profile-checkbox">
			                    <input type="checkbox" name="progress2" value=1
			                        <?php if ($profile_result['progress2'] != 0){ ?>
			                            checked
			                        <?php } ?>
		                        >
			                </div>
		                </div>
		                <div class="profile-progress">
			                <div>
                				<p>Methodology</p>
			                </div>
			                <div class="profile-checkbox">
			                    <input type="checkbox" name="progress3" value=1
			                        <?php if ($profile_result['progress3'] != 0){ ?>
			                            checked
			                        <?php } ?>
		                        >
			                </div>
		                </div>
		                <div class="profile-progress">
			                <div>
                				<p>Finding</p>
			                </div>
			                <div class="profile-checkbox">
			                    <input type="checkbox" name="progress4" value=1
			                        <?php if ($profile_result['progress4'] != 0){ ?>
			                            checked
			                        <?php } ?>
		                        >
			                </div>
		                </div>
		                <div class="profile-progress">
			                <div>
                				<p>Reference</p>
			                </div>
			                <div class="profile-checkbox">
			                    <input type="checkbox" name="progress5" value=1
			                        <?php if ($profile_result['progress5'] != 0){ ?>
			                            checked
			                        <?php } ?>
		                        >
			                </div>
		                </div>
		                <div class="profile-progress">
			                <div>
                				<p>Appendix</p>
			                </div>
			                <div class="profile-checkbox">
			                    <input type="checkbox" name="progress6" value=1
			                        <?php if ($profile_result['progress6'] != 0){ ?>
			                            checked
			                        <?php } ?>
		                        >
			                </div>
		                </div>
			        </div>
			</div>
			<br>
			<?php endif ?>
			<div class="input-group">
			    <button type="submit" class="btn" name="update_profile">Update Profile</button>
			</div>
		</form>
	</body>
</html>