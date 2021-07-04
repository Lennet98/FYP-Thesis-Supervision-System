<?php include('includes/logics/profile_retrieval.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ThesisSupervision : Profile</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style type="text/css">
		    .input-group label {
		        font-weight: bold;
		    }
		    .input-group p {
		        margin: 3px;
		    }
		    .input-group img {
		        border: 1px solid gray;
		    }
		    .btn {
		        float: none;
		        display: block;
		        margin-left: auto;
                margin-right: auto;
		    }
		    .profile-progress {
		        display: grid;
                grid-template-columns: 20% 80%;
		    }
		    .profile-checkbox {
		        width: 50%;
		        margin: auto;
		    }
		    .profile-checkbox img {
		        max-width: 15%;
		    }
		    .progress-container {
		        width: 98%;
		        background: #e3e3e3;
		        border-radius: 15px;
		    }
		    .progress-bar {
		        background: #77d48f;
		        color: white;
		        padding: 1%; 
                text-align: right; 
                font-size: 20px; 
                border-radius: 15px;
		    }
		</style>
	</head>
	<body>
	    <?php include ('includes/layouts/navbar.php'); ?>
	    <?php include ('includes/layouts/sidebar.php'); ?>
		<div class="form-header" style="width: 40%;">
			<h2 style="text-decoration: underline;">Profile</h2>
			<p><?php echo $username?></p>
		</div>
		<div class="profile-content" style="margin-bottom: 30px;">
		    <?php if (isset($_SESSION['success'])) : ?>
				<div class="error success" style="margin-top: 0px; width: 90%;">
					<h3>
						<?php 
							echo $_SESSION['success']; 
							unset($_SESSION['success']);
						?>
					</h3>
				</div>
		    <?php endif ?>
    		<div class="input-group" style="text-align:center;">
			    <?php if (($profile_result['profile_picture'] == '')||(!file_exists($profile_result['profile_picture']))){
    		        $temp_image = 'assets/img/default_profile.png';
    		    ?>
    		        <img src="<?php echo $temp_image; ?>" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
    		    <?php } else { ?>
    		        <img src="<?php echo $profile_result['profile_picture']; ?>" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
    		    <?php } ?>
            </div>
    		<div class="input-group">
    			<?php
    			    if (strlen($profile_result['name']) > 0) {
    			        $dis_name = $profile_result['name'];
    			    } else {
    			        $dis_name = "-";
    			    }
			    ?>
    			<p><strong>Name:</strong> <?php echo $dis_name; ?></p>
    		</div>
    		<div class="input-group">
    			<p><strong>Email:</strong> <?php echo $profile_result['email']; ?></p>
    		</div>
    		<div class="input-group">
    			<?php
    			    if (strlen($profile_result['phone']) > 0) {
    			        if (strlen($profile_result['phone']) < 4) {
    			            $phone_number = substr($profile_result['phone'], 0);
        			    } else {
            			    $ini_phone = substr($profile_result['phone'], 0, 3);
                            $last_phone = substr($profile_result['phone'], 3);
                            $phone_number = $ini_phone . "-" . $last_phone;
        			    }
    			    } else {
    			        $phone_number = "-";
    			    }
			    ?>
    			<p><strong>Phone:</strong> <?php echo $phone_number; ?></p>
    		</div>
    		<div class="input-group">
                <?php
    			    if (strlen($profile_result['address']) > 0) {
    			        $dis_add = $profile_result['address'];
    			    } else {
    			        $dis_add = "-";
    			    }
			    ?>
    			<p><strong>Address:</strong> <?php echo $dis_add; ?></p>
    		</div>
    		<?php  if ($_SESSION['role']=="Lecturer") : ?>
    		<div class="input-group">
    		    <p><strong>Specialisation:</strong> <?php echo $assoc_specialisation; ?></p>
		    </div>
    		<?php endif ?>
    		<?php  if ($_SESSION['role']=="Student") : ?>
    		<div class="input-group">
                <?php
    			    if (strlen($profile_result['inasis']) > 0) {
    			        $dis_inasis = $profile_result['inasis'];
    			    } else {
    			        $dis_inasis = "-";
    			    }
			    ?>
    			<p><strong>Inasis:</strong> <?php echo $dis_inasis; ?></p>
    		</div>
    		<div class="input-group">
    		    <?php
    			    if (strlen($profile_result['semester']) > 0) {
    			        $dis_sem = $profile_result['semester'];
    			    } else {
    			        $dis_sem = "-";
    			    }
			    ?>
    			<p><strong>Semester:</strong> <?php echo $dis_sem; ?></p>
    		</div>
    		<div class="input-group">
                <?php
    			    if (strlen($profile_result['college']) > 0) {
    			        $dis_college = $profile_result['college'];
    			    } else {
    			        $dis_college = "-";
    			    }
			    ?>
    			<p><strong>College:</strong> <?php echo $dis_college; ?></p>
    		</div>
    		<div class="input-group">
    		    <?php
    			    if (strlen($profile_result['school']) > 0) {
    			        $dis_sch = $profile_result['school'];
    			    } else {
    			        $dis_sch = "-";
    			    }
			    ?>
    			<p><strong>School:</strong> <?php echo $dis_sch; ?></p>
    		</div>
    		<div class="input-group">
    		    <?php
    		        if (strlen($profile_result['guardian_no']) > 0) {
    			        if (strlen($profile_result['guardian_no']) < 4) {
    			            $dis_guardian = substr($profile_result['guardian_no'], 0);
        			    } else {
            			    $ini_guard_phone = substr($profile_result['guardian_no'], 0, 3);
                            $last_guard_phone = substr($profile_result['guardian_no'], 3);
                            $dis_guardian = $ini_guard_phone . "-" . $last_guard_phone;
        			    }
    			    } else {
    			        $dis_guardian = "-";
    			    }
			    ?>
    			<p><strong>Guardian Number:</strong> <?php echo $dis_guardian; ?></p>
    		</div>
    		<div class="input-group">
    		    <?php
    			    if (strlen($profile_result['thesis_title']) > 0) {
    			        $dis_thesis = $profile_result['thesis_title'];
    			    } else {
    			        $dis_thesis = "-";
    			    }
			    ?>
    			<p><strong>Thesis Title:</strong> <?php echo $dis_thesis; ?></p>
    		</div>
    		<div class="input-group">
    		    <?php
    			    if (strlen($profile_result['supervisor']) > 0) {
    			        $dis_supervisor = $profile_result['supervisor'];
    			    } else {
    			        $dis_supervisor = "-";
    			    }
			    ?>
    			<p><strong>Supervisor:</strong> <?php echo $dis_supervisor; ?></p>
    		</div>
    		<br>
    		<div class="input-group">
			    <div class="profile-progress">
			        <div>
			            <p><strong>Progress:</strong></p>
			        </div>
			        <div>
    			        <div class="profile-progress">
    			            <div>
            		            <?php 
            		                $dis_progress1 = $profile_result['progress'];
            		                if ($dis_progress1 == 0) {
            		                    $dis_progress1 = "False";
            		                } else {
            		                    $dis_progress1 = "True";
            		                }
            	                ?>
            	                <p>Proposal</p>
        	                </div>
        	                <div class="profile-checkbox">
    			                <?php if($dis_progress1 == "True"){ ?>
    			                    <img src="assets/img/checkbox.png">
    		                    <?php } else { ?>
    			                    <img src="assets/img/unchecked_checkbox.png">
    		                    <?php } ?>
        			        </div>
    			        </div>
    			        <div class="profile-progress">
    			            <div>
            		            <?php 
            		                $dis_progress2 = $profile_result['progress2'];
            		                if ($dis_progress2 == 0) {
            		                    $dis_progress2 = "False";
            		                } else {
            		                    $dis_progress2 = "True";
            		                }
            	                ?>
            	                <p>Introduction</p>
        	                </div>
        	                <div class="profile-checkbox">
    			                <?php if($dis_progress2 == "True"){ ?>
    			                    <img src="assets/img/checkbox.png">
    		                    <?php } else { ?>
    			                    <img src="assets/img/unchecked_checkbox.png">
    		                    <?php } ?>
        			        </div>
    			        </div>
    			        <div class="profile-progress">
    			            <div>
            		            <?php 
            		                $dis_progress3 = $profile_result['progress3'];
            		                if ($dis_progress3 == 0) {
            		                    $dis_progress3 = "False";
            		                } else {
            		                    $dis_progress3 = "True";
            		                }
            	                ?>
            	                <p>Methodology</p>
        	                </div>
        	                <div class="profile-checkbox">
    			                <?php if($dis_progress3 == "True"){ ?>
    			                    <img src="assets/img/checkbox.png">
    		                    <?php } else { ?>
    			                    <img src="assets/img/unchecked_checkbox.png">
    		                    <?php } ?>
        			        </div>
    			        </div>
    			        <div class="profile-progress">
    			            <div>
            		            <?php 
            		                $dis_progress4 = $profile_result['progress4'];
            		                if ($dis_progress4 == 0) {
            		                    $dis_progress4 = "False";
            		                } else {
            		                    $dis_progress4 = "True";
            		                }
            	                ?>
            	                <p>Finding</p>
        	                </div>
        	                <div class="profile-checkbox">
    			                <?php if($dis_progress4 == "True"){ ?>
    			                    <img src="assets/img/checkbox.png">
    		                    <?php } else { ?>
    			                    <img src="assets/img/unchecked_checkbox.png">
    		                    <?php } ?>
        			        </div>
    			        </div>
    			        <div class="profile-progress">
    			            <div>
            		            <?php 
            		                $dis_progress5 = $profile_result['progress5'];
            		                if ($dis_progress5 == 0) {
            		                    $dis_progress5 = "False";
            		                } else {
            		                    $dis_progress5 = "True";
            		                }
            	                ?>
            	                <p>Reference</p>
        	                </div>
        	                <div class="profile-checkbox">
    			                <?php if($dis_progress5 == "True"){ ?>
    			                    <img src="assets/img/checkbox.png">
    		                    <?php } else { ?>
    			                    <img src="assets/img/unchecked_checkbox.png">
    		                    <?php } ?>
        			        </div>
    			        </div>
    			        <div class="profile-progress">
    			            <div>
            		            <?php 
            		                $dis_progress6 = $profile_result['progress6'];
            		                if ($dis_progress6 == 0) {
            		                    $dis_progress6 = "False";
            		                } else {
            		                    $dis_progress6 = "True";
            		                }
            	                ?>
            	                <p>Appendix</p>
        	                </div>
        	                <div class="profile-checkbox">
    			                <?php if($dis_progress6 == "True"){ ?>
    			                    <img src="assets/img/checkbox.png">
    		                    <?php } else { ?>
    			                    <img src="assets/img/unchecked_checkbox.png">
    		                    <?php } ?>
        			        </div>
    			        </div>
			        </div>
			    </div>
    		</div>
    		<div class="input-group">
    		    <?php
    		        $progress_bar = 0;
    		        $progress_pct = [$dis_progress1, $dis_progress2, $dis_progress3, $dis_progress4, $dis_progress5, $dis_progress6];
    		        $progress_len = count($progress_pct);
    			    foreach ($progress_pct as $progress_ele) : {
    			        if ($progress_ele == "True"){
    			            $progress_bar += 1;
    			        }
    			    }
    			    $progress_results = round(($progress_bar/$progress_len)*100);
			    ?>
			    <style type="text/css">
                    .progress-bar {
                        width: <?php echo $progress_results?>%;
                    }
                </style>
    			<?php endforeach ?>
    			<p><strong>Progress Percentage:</strong></p>
    			<div class="progress-container">
    			    <div class="progress-bar">
    			        <p style="font-size: 20px;"><?php echo $progress_results; ?>%</p>
			        </div>
			    </div>
    		</div>
    		<br>
    		<?php endif ?>
    		<div class="input-group">
    		    <button onclick="document.location='profile_update.php'" class="btn">Update Profile</button>
    		</div>
		</div>
	</body>
</html>