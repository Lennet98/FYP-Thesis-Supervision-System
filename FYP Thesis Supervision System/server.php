<?php
	session_start();
	// initializing variables
	$username = "";
	$email    = "";
	$errors = array(); 

	// connect to the database
	$db = mysqli_connect('localhost', 'programm_thesisms_user', 'thesisms_user', 'programm_thesisms');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$role = mysqli_real_escape_string($db, $_POST['role']);
		if ($role == 1){
            $role = 'Student';
        } else if ($role == 2){
            $role = 'Lecturer';
        } else if ($role == 3){
            $role = 'Coordinator';
        } else if ($role == 4){
            $role = 'Dean';
        }
		$specialisation = mysqli_real_escape_string($db, $_POST['specialisation']);

		// form validation: ensure that the form is correctly filled ...
		// by adding (array_push()) corresponding error unto $errors array
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required");
		}
		if ($password_1 != $password_2) {
			array_push($errors, "Passwords do not match");
		}
		if (empty($role)) {
			array_push($errors, "Role is required");
		}

		// first check the database to make sure 
		// a user does not already exist with the same username and/or email
		$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
		$result = mysqli_query($db, $user_check_query);
		$user = mysqli_fetch_assoc($result);
	  
		if ($user) { // if user exists
			if ($user['username'] === $username) {
			  array_push($errors, "Username already exists");
			}

			if ($user['email'] === $email) {
				array_push($errors, "Email already exists");
			}
		}

	  // Finally, register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database

			$query = "INSERT INTO users (username, email, password, role)
					VALUES('$username', '$email', '$password', '$role')";
			mysqli_query($db, $query);
			$profile_query = "INSERT INTO profile (email, name, phone, address, profile_picture)
					VALUES('$email', '', '', '', '')";
			mysqli_query($db, $profile_query);
			if ($role=='Lecturer') {
			    $lecturer_query = "INSERT INTO supervisors VALUES('$username','$specialisation')";
			    mysqli_query($db, $lecturer_query);
			}
			$_SESSION['success'] = "Account succesfully registered!";
			header('location: login.php');
		}
	}

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
		$role = mysqli_real_escape_string($db, $_POST['role']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}
		if (empty($role)) {
			array_push($errors, "Role is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
			$results = mysqli_query($db, $query);
			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['role'] = $role;
				header('location: index.php');
			}else {
				array_push($errors, "Invalid username/password/role combination");
			}
		}
	}
	
	// PASSWORD RESET
	if (isset($_POST['pw_reset'])) {
		// retrieve email address
		$email = mysqli_real_escape_string($db, $_POST['email']);
		
		// validate if email field is filled
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		
		// check if account registered with provided email exists
		$user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result = mysqli_query($db, $user_check_query);
		$user = mysqli_fetch_assoc($result);
		
		if ($user) { // if user exists
			if (count($errors) == 0) {
				$passkey = md5(2418*2+$email);
                $addKey = substr(md5(uniqid(rand(),1)),3,10);
                $passkey = $passkey . $addKey;
				$insert_temp_pw = "INSERT INTO password_reset (email, passkey) VALUES ('$email','$passkey')";
				mysqli_query($db, $insert_temp_pw);

				// email content
				$output='<p>Dear user,</p>';
				$output.='<p>Please click on the following link to reset your password.</p>';
				$output.='<p>-------------------------------------------------------------</p>';
				$output.='<p><a href="https://programmingprojecthj.com/thesisms/reset-password.php?passkey='.$passkey.'&email='.$email.'&action=reset" target="_blank">
				https://programmingprojecthj.com/thesisms/reset-password.php?passkey='.$passkey.'&email='.$email.'&action=reset</a></p>'; 
				$output.='<p>-------------------------------------------------------------</p>';
				$output.='<p>Please be sure to copy the entire link into your browser.</p>';
				$output.='<p>If you did not request this forgotten password email, no action 
				is needed, your password will not be reset. However, you may want to log into 
				your account and change your security password as someone may have guessed it.</p>';   
				$output.='<p>Thanks,</p>';
				$output.='<p>ThesisSupervision</p>';
				$body = $output; 
				$subject = "Password Recovery - ThesisSupervision";
				
				// send email using PHPMailer
				$email_to = $email;
				$fromserver = "noreply@programmingprojecthj.com"; 
				require("PHPMailer/PHPMailerAutoload.php");
				$mail = new PHPMailer();
				$mail->Host = "foxtrot.jom.hosting"; // Enter your host here
				$mail->SMTPAuth = true;
				$mail->Username = "noreply@programmingprojecthj.com"; // Enter your email here
				$mail->Password = "thesisms_email"; //Enter your password here
				$mail->Port = 465;
				$mail->IsHTML(true);
				$mail->From = $fromserver;
				$mail->FromName = "ThesisSupervision";
				$mail->Sender = $fromserver; // indicates ReturnPath header
				$mail->Subject = $subject;
				$mail->Body = $body;
				$mail->AddAddress($email_to);
				if(!$mail->Send()){
					echo "Mailer Error: " . $mail->ErrorInfo;
				}else{
					$_SESSION['success'] = "An email has been sent to your registered email address with
					instructions on how to reset your password.";
					header('location: login.php');
				}
			}
		} else {
			array_push($errors, "Email address not registered.");
		}
	}
	
	// update password
	if (isset($_POST['update_password'])) {
		// receive email address and password
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		
		if (empty($email)) {
		    array_push($errors, "Email is required");
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required");
		}
		if (empty($password_2)) {
			array_push($errors, "Confirm Password is required");
		}
		if ($password_1 != $password_2) {
			array_push($errors, "Passwords do not match");
		}
		
		$email_check_query = "SELECT * FROM password_reset WHERE email='$email'";
		$result = mysqli_query($db, $email_check_query);
		$email_check = mysqli_fetch_assoc($result);
        
        if(!$email_check) {
            array_push($errors, "The link is invalid. You have already used the key in which case it is 
				deactivated.");
        }
        
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "UPDATE users SET password='$password' WHERE email='$email'";
			mysqli_query($db, $query);
			$del_query = "DELETE FROM password_reset WHERE email='$email'";
			mysqli_query($db, $del_query);
			$_SESSION['success'] = "Password succesfully updated.";
			header('location: login.php');
		}
	}
	
	// Update Profile
    if (isset($_POST['update_profile'])) {
        $username = $_SESSION['username'];
        $email = mysqli_real_escape_string($db, $_POST['email']);
		$profile_name = mysqli_real_escape_string($db, $_POST['profile_name']);
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		$address = mysqli_real_escape_string($db, $_POST['address']);
		
		$specialisation = mysqli_real_escape_string($db, $_POST['specialisation']);
		
		$inasis = mysqli_real_escape_string($db, $_POST['inasis']);
		$semester = mysqli_real_escape_string($db, $_POST['semester']);
		$college = mysqli_real_escape_string($db, $_POST['college']);
		$school = mysqli_real_escape_string($db, $_POST['school']);
        $guardian_no = mysqli_real_escape_string($db, $_POST['guardian_no']);
        $progress = mysqli_real_escape_string($db, $_POST['progress']);
        $progress2 = mysqli_real_escape_string($db, $_POST['progress2']);
        $progress3 = mysqli_real_escape_string($db, $_POST['progress3']);
        $progress4 = mysqli_real_escape_string($db, $_POST['progress4']);
        $progress5 = mysqli_real_escape_string($db, $_POST['progress5']);
        $progress6 = mysqli_real_escape_string($db, $_POST['progress6']);
        
		$target_dir = "admin/users/users_img/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		if (strlen($phone) > 0){
    		if (!is_numeric($phone)) {
    		    array_push($errors, "Phone number should only contain digits.");
    		}
		}
		
		if (strlen($semester) > 0){
    		if (!is_numeric($semester)) {
    		    array_push($errors, "Semester should only contain digits.");
    		}
		}
		
        if($target_file != $target_dir){
            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                array_push($errors, "File is not an image.");
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                array_push($errors, "Sorry, your file is too large.");
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                array_push($errors, "Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $query = "UPDATE profile SET profile_picture='$target_file' WHERE email='$email'";
    		        mysqli_query($db, $query);
                } else {
                    array_push($errors, "Sorry, there was an error uploading your file.");
                }
    
    		}
        }
            
        if (count($errors) == 0) {
			$query = "UPDATE profile SET name='$profile_name' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET phone='$phone' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET address='$address' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET inasis='$inasis' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET semester='$semester' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET college='$college' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET school='$school' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET guardian_no='$guardian_no' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET progress='$progress' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET progress2='$progress2' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET progress3='$progress3' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET progress4='$progress4' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET progress5='$progress5' WHERE email='$email'";
			mysqli_query($db, $query);
			$query = "UPDATE profile SET progress6='$progress6' WHERE email='$email'";
			mysqli_query($db, $query);
			if ($specialisation != ""){
    			$query = "UPDATE supervisors SET specialization='$specialisation' WHERE username='$username'";
    			mysqli_query($db, $query);
			}
			$_SESSION['success'] = "Profile succesfully updated.";
			header('location: profile.php');
		}
    }
    
    // Add Announcement
    if (isset($_POST['add_anc'])) {
        $announcement = mysqli_real_escape_string($db, $_POST['announcement']);
        $username = $_SESSION['username'];
        if (empty($announcement)) {
		    array_push($errors, "Description is required");
		}
		
		if (count($errors) == 0) {
		    if (isset($_SESSION['username'])){
    		    $query = "INSERT INTO announcements VALUES('','$username', '$announcement')";
    		    mysqli_query($db, $query);
    		    $_SESSION['success'] = "Announcement succesfully added.";
		    }
		}
		header('location: index.php');
        exit();
    }
    
    // Edit Announcement
    if (isset($_POST['edit_anc'])) {
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $annc_id = mysqli_real_escape_string($db, $_POST['annc_id'.$count]);
        $announcement = mysqli_real_escape_string($db, $_POST['announcement'.$count]);
        
        if (empty($announcement)) {
		    array_push($errors, "Description is required");
		}
		
		if (count($errors) == 0) {
		    $query = "UPDATE announcements SET announcement='$announcement' WHERE annc_id='$annc_id'";
            mysqli_query($db, $query);
			$_SESSION['success'] = "Announcement succesfully edited!";
			header('location: edit_announcement.php');
			exit();
		}
    }
    
    // Delete Announcement
    if (isset($_POST['del_anc'])) {
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $annc_id = mysqli_real_escape_string($db, $_POST['annc_id'.$count]);
        
        $query = "DELETE FROM announcements WHERE annc_id='$annc_id'";
        mysqli_query($db, $query);
		$_SESSION['success'] = "Announcement succesfully deleted!";
		header('location: edit_announcement.php');
		exit();
    }
    
    // Send Message
    if (isset($_POST['send_msg'])) {
        $username = $_SESSION['username'];
        $message = mysqli_real_escape_string($db, $_POST['message']);
        
        if (empty($message)) {
		    array_push($errors, "Message is required");
		}
		
		if (count($errors) == 0) {
		    if (isset($_SESSION['username'])){
    		    $query = "INSERT INTO forum (timestamp, username, message) VALUES(NOW(), '$username', '$message')";
    		    mysqli_query($db, $query);
    			$_SESSION['success'] = "Message succesfully sent!";
    			header('location: forum.php');
    			exit();
		    }
		}
    }
    
    // Submit Thesis Request
    if (isset($_POST['submit_rq'])) {
        $specialization = mysqli_real_escape_string($db, $_POST['options']);
        if ($specialization == 1){
            $specialization = 'Social Work';
        } else if ($specialization == 2){
            $specialization = 'Counselling';
        }
		$thesis_desc = mysqli_real_escape_string($db, $_POST['thesis']);
		$lect_name = mysqli_real_escape_string($db, $_POST['lect_options']);
        $username = $_SESSION['username'];
        
        if (empty($thesis_desc)) {
		    array_push($errors, "Please select a thesis title!");
		}
        if (empty($lect_name)) {
		    array_push($errors, "Please select a supervisor!");
		}
			
		if (count($errors) == 0) {
		    $user_check_query = "SELECT * FROM thesis_application WHERE student_name='$username'";
    		$result = mysqli_query($db, $user_check_query);
    		$user = mysqli_fetch_assoc($result);
    		$existing_user_query = "SELECT * FROM thesis WHERE student_name='$username'";
    		$result = mysqli_query($db, $existing_user_query);
    		$exist_user = mysqli_fetch_assoc($result);
    		if ($user) { // if user exists
	            array_push($errors, "You have already submitted a request. Please wait for approval or rejection.");
    		} else {
    		    if ($exist_user) { 
    		        array_push($errors, "You are already involved in a project. Please consult your supervisor directly for any issues.");
        		} else {
        		    $query = "INSERT INTO thesis_application (student_name, lect_name, specialization, thesis_title) VALUES('$username', '$lect_name', '$specialization', '$thesis_desc')";
        		    mysqli_query($db, $query);
        			$_SESSION['success'] = "Request sent succesfully! Please wait for the announcement.";
        			header('location: register_thesis.php');
        			exit();
        		}
    		}
		}
    }
    
    // Accept Thesis Request
    if (isset($_POST['accept_rq'])) {
        $username = $_SESSION['username'];
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $student_name = mysqli_real_escape_string($db, $_POST['student_name'.$count]);
        $thesis_title = mysqli_real_escape_string($db, $_POST['thesis_title'.$count]);
        $lect_name = mysqli_real_escape_string($db, $_POST['lect_name'.$count]);

        // Retrieve user email
        $student_query = "SELECT email FROM users WHERE username='$student_name'";
        $student_result = mysqli_query($db, $student_query);
        $student_email = mysqli_fetch_assoc($student_result);
        
        // Retrieve supervisor email
        $supervisor_query = "SELECT email FROM users WHERE username='$lect_name'";
        $supervisor_result = mysqli_query($db, $supervisor_query);
        $supervisor_email = mysqli_fetch_assoc($supervisor_result);
        
        // Email body (Student)
        $output='<p>Dear '.$student_name.',</p>';
		$output.='<br>';
		$output.='<p>Your thesis application has been approved.</p>';
		$output.='<p>Application details are shown below.</p>';
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<p><strong>Student Name: </strong>'.$student_name.'</p>';
		$output.='<p><strong>Thesis Title: </strong>'.$thesis_title.'</p>';
		$output.='<p><strong>Supervisor Name: </strong>'.$lect_name.'</p>';  
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<br>';
		$output.='<p>Thanks,</p>';
		$output.='<p>ThesisSupervision</p>';
		$student_body = $output;
		
		// Email body (Supervisor)
		$output='<p>Dear '.$lect_name.',</p>';
		$output.='<br>';
		$output.='<p>You have been assigned a supervisee under your guidance.</p>';
		$output.='<p>Application details are shown below.</p>';
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<p><strong>Student Name: </strong>'.$student_name.'</p>';
		$output.='<p><strong>Thesis Title: </strong>'.$thesis_title.'</p>';
		$output.='<p><strong>Supervisor Name: </strong>'.$lect_name.'</p>';  
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<br>';
		$output.='<p>Thanks,</p>';
		$output.='<p>ThesisSupervision</p>';
		$lect_body = $output; 
		
		$subject = "Thesis Application - ThesisSupervision";
		
		// Send email using PHPMailer (Student)
		$email_to = $student_email['email'];
		$fromserver = "noreply@programmingprojecthj.com"; 
		require("PHPMailer/PHPMailerAutoload.php");
		$mail = new PHPMailer();
		$mail->Host = "foxtrot.jom.hosting"; // Enter your host here
		$mail->SMTPAuth = true;
		$mail->Username = "noreply@programmingprojecthj.com"; // Enter your email here
		$mail->Password = "thesisms_email"; //Enter your password here
		$mail->Port = 465;
		$mail->IsHTML(true);
		$mail->From = $fromserver;
		$mail->FromName = "ThesisSupervision";
		$mail->Sender = $fromserver; // indicates ReturnPath header
		$mail->Subject = $subject;
		$mail->Body = $student_body;
		$mail->AddAddress($email_to);
		
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		
		// Send email using PHPMailer (Supervisor)
		$email_to = $supervisor_email['email'];
		$lect_mail = new PHPMailer();
		$lect_mail->Host = "foxtrot.jom.hosting"; // Enter your host here
		$lect_mail->SMTPAuth = true;
		$lect_mail->Username = "noreply@programmingprojecthj.com"; // Enter your email here
		$lect_mail->Password = "thesisms_email"; //Enter your password here
		$lect_mail->Port = 465;
		$lect_mail->IsHTML(true);
		$lect_mail->From = $fromserver;
		$lect_mail->FromName = "ThesisSupervision";
		$lect_mail->Sender = $fromserver; // indicates ReturnPath header
		$lect_mail->Subject = $subject;
		$lect_mail->Body = $lect_body;
		$lect_mail->AddAddress($email_to);
		
		if(!$lect_mail->Send()){
		    echo "Mailer Error: " . $lect_mail->ErrorInfo;
		}
				
        $query = "INSERT INTO thesis VALUES('','$student_name','$lect_name','$thesis_title')";
        mysqli_query($db, $query);
        $del_query = "DELETE FROM thesis_application WHERE student_name='$student_name'";
        mysqli_query($db, $del_query);
        $target_email = $student_email['email'];
        $update_query = "UPDATE profile set thesis_title='$thesis_title' WHERE email='$target_email'";
        mysqli_query($db, $update_query);
        $update_query = "UPDATE profile set supervisor='$lect_name' WHERE email='$target_email'";
        mysqli_query($db, $update_query);

        $_SESSION['success'] = "An offer letter has been sent to the student and supervisor!";
        header('location: manage_thesis.php');
        exit();
    }
    
    // Reject Thesis Request
    if (isset($_POST['reject_rq'])) {
        $username = $_SESSION['username'];
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $student_name = mysqli_real_escape_string($db, $_POST['student_name'.$count]);
        $thesis_title = mysqli_real_escape_string($db, $_POST['thesis_title'.$count]);
        $supervisor = mysqli_real_escape_string($db, $_POST['supervisor'.$count]);
        
        if (empty($supervisor)) {
            array_push($errors, "Please select a supervisor for reassignment.");
        }
        
        if (count($errors) == 0) {
            // Retrieve user email
            $student_query = "SELECT email FROM users WHERE username='$student_name'";
            $student_result = mysqli_query($db, $student_query);
            $student_email = mysqli_fetch_assoc($student_result);
            
            // Retrieve supervisor email
            $supervisor_query = "SELECT email FROM users WHERE username='$supervisor'";
            $supervisor_result = mysqli_query($db, $supervisor_query);
            $supervisor_email = mysqli_fetch_assoc($supervisor_result);
            
            // Email body (Student)
            $output='<p>Dear '.$student_name.',</p>';
    		$output.='<br>';
    		$output.='<p>Your thesis application has been approved, but you are assigned to a different supervisor.</p>';
    		$output.='<p>Application details are shown below.</p>';
    		$output.='<p>-------------------------------------------------------------</p>';
    		$output.='<p><strong>Student Name: </strong>'.$student_name.'</p>';
    		$output.='<p><strong>Thesis Title: </strong>'.$thesis_title.'</p>';
    		$output.='<p><strong>Supervisor Name: </strong>'.$supervisor.'</p>';  
    		$output.='<p>-------------------------------------------------------------</p>';
    		$output.='<br>';
    		$output.='<p>Thanks,</p>';
    		$output.='<p>ThesisSupervision</p>';
    		$student_body = $output;
    		
    		// Email body (Supervisor)
    		$output='<p>Dear '.$supervisor.',</p>';
    		$output.='<br>';
    		$output.='<p>You have been assigned a supervisee under your guidance.</p>';
    		$output.='<p>Application details are shown below.</p>';
    		$output.='<p>-------------------------------------------------------------</p>';
    		$output.='<p><strong>Student Name: </strong>'.$student_name.'</p>';
    		$output.='<p><strong>Thesis Title: </strong>'.$thesis_title.'</p>';
    		$output.='<p><strong>Supervisor Name: </strong>'.$supervisor.'</p>';  
    		$output.='<p>-------------------------------------------------------------</p>';
    		$output.='<br>';
    		$output.='<p>Thanks,</p>';
    		$output.='<p>ThesisSupervision</p>';
    		$lect_body = $output; 
    		
    		$subject = "Thesis Application - ThesisSupervision";
    		
    		// Send email using PHPMailer (Student)
    		$email_to = $student_email['email'];
    		$fromserver = "noreply@programmingprojecthj.com"; 
    		require("PHPMailer/PHPMailerAutoload.php");
    		$mail = new PHPMailer();
    		$mail->Host = "foxtrot.jom.hosting"; // Enter your host here
    		$mail->SMTPAuth = true;
    		$mail->Username = "noreply@programmingprojecthj.com"; // Enter your email here
    		$mail->Password = "thesisms_email"; //Enter your password here
    		$mail->Port = 465;
    		$mail->IsHTML(true);
    		$mail->From = $fromserver;
    		$mail->FromName = "ThesisSupervision";
    		$mail->Sender = $fromserver; // indicates ReturnPath header
    		$mail->Subject = $subject;
    		$mail->Body = $student_body;
    		$mail->AddAddress($email_to);
    		
    		if(!$mail->Send()){
    			echo "Mailer Error: " . $mail->ErrorInfo;
    		}
    		
    		// Send email using PHPMailer (Supervisor)
    		$email_to = $supervisor_email['email'];
    		$lect_mail = new PHPMailer();
    		$lect_mail->Host = "foxtrot.jom.hosting"; // Enter your host here
    		$lect_mail->SMTPAuth = true;
    		$lect_mail->Username = "noreply@programmingprojecthj.com"; // Enter your email here
    		$lect_mail->Password = "thesisms_email"; //Enter your password here
    		$lect_mail->Port = 465;
    		$lect_mail->IsHTML(true);
    		$lect_mail->From = $fromserver;
    		$lect_mail->FromName = "ThesisSupervision";
    		$lect_mail->Sender = $fromserver; // indicates ReturnPath header
    		$lect_mail->Subject = $subject;
    		$lect_mail->Body = $lect_body;
    		$lect_mail->AddAddress($email_to);
    		
    		if(!$lect_mail->Send()){
    		    echo "Mailer Error: " . $lect_mail->ErrorInfo;
    		}
    		
            $query = "INSERT INTO thesis VALUES('','$student_name','$supervisor','$thesis_title')";
            mysqli_query($db, $query);
            $del_query = "DELETE FROM thesis_application WHERE student_name='$student_name'";
            mysqli_query($db, $del_query);
            $target_email = $student_email['email'];
            $update_query = "UPDATE profile set thesis_title='$thesis_title' WHERE email='$target_email'";
            mysqli_query($db, $update_query);
            $update_query = "UPDATE profile set supervisor='$supervisor' WHERE email='$target_email'";
            mysqli_query($db, $update_query);
            $_SESSION['success'] = "An offer letter has been sent to the student and your assigned supervisor!";
            header('location: manage_thesis.php');
            exit();
        }
    }
    
    // Send Appointment
    if (isset($_POST['send_apt'])) {
        $apt_date = mysqli_real_escape_string($db, $_POST['apt_date']);
		$apt_time = mysqli_real_escape_string($db, $_POST['apt_time']);
		$reason = mysqli_real_escape_string($db, $_POST['reason']);
		date_default_timezone_set("Asia/Singapore");
		$calc_time = substr($apt_time, 0,2) . substr($apt_time, 3);
		$curr_time = date('Hi', time());
		$dis_time = date('h:i a', time());
        $username = $_SESSION['username'];
        
        if ($apt_date == date("Y-m-d")){
            if($calc_time <= $curr_time){
                array_push($errors, "Time must be later than current time for appointments dated today.<br>Current time is " . $dis_time);
            }
        }
        
        if (count($errors) == 0) {
            //Retrieve user email
		    $email_query = "SELECT email FROM users WHERE username='$username' LIMIT 1";
		    $result = mysqli_query($db, $email_query);
		    $user_profile = mysqli_fetch_assoc($result);
		    $user_email = $user_profile['email'];
		    
		    //Retrieve assigned supervisor username
		    $supervisor_query = "SELECT supervisor FROM profile WHERE email='$user_email' LIMIT 1";
		    $result = mysqli_query($db, $supervisor_query);
		    $supervisor_username = mysqli_fetch_assoc($result);
            $supervisor_username = $supervisor_username['supervisor'];
            
            //Retrieve supervisor username and email
            $supervisor_profile_query = "SELECT * FROM users WHERE username='$supervisor_username'";
		    $result = mysqli_query($db, $supervisor_profile_query);
		    $supervisor_profile = mysqli_fetch_assoc($result);
		    
		    //Check if supervisor exists
		    if($supervisor_profile){
		        // email content
				$output='<p>Dear '.$supervisor_username.',</p>';
				$output.='<br>';
				$output.='<p>A student under your supervision has requested for an appointment.</p>';
				$output.='<p>Appointment details are shown below.</p>';
				$output.='<p>-------------------------------------------------------------</p>';
				$output.='<p><strong>Student Name: </strong>'.$username.'</p>';
				$output.='<p><strong>Appointment Date: </strong>'.$apt_date.'</p>';
				$output.='<p><strong>Appointment Time: </strong>'.$dis_time.'</p>';  
				$output.='<p><strong>Reason: </strong>'.$reason.'</p>';   
				$output.='<p>-------------------------------------------------------------</p>';
				$output.='<br>';
				$output.='<p>Thanks,</p>';
				$output.='<p>ThesisSupervision</p>';
				$body = $output; 
				$subject = "Appointment Request - ThesisSupervision";
				
				// send email using PHPMailer
				$email_to = $supervisor_profile['email'];
				$fromserver = "noreply@programmingprojecthj.com"; 
				require("PHPMailer/PHPMailerAutoload.php");
				$mail = new PHPMailer();
				$mail->Host = "foxtrot.jom.hosting"; // Enter your host here
				$mail->SMTPAuth = true;
				$mail->Username = "noreply@programmingprojecthj.com"; // Enter your email here
				$mail->Password = "thesisms_email"; //Enter your password here
				$mail->Port = 465;
				$mail->IsHTML(true);
				$mail->From = $fromserver;
				$mail->FromName = "ThesisSupervision";
				$mail->Sender = $fromserver; // indicates ReturnPath header
				$mail->Subject = $subject;
				$mail->Body = $body;
				$mail->AddAddress($email_to);
				
				if(!$mail->Send()){
					echo "Mailer Error: " . $mail->ErrorInfo;
				}else{
					$_SESSION['success'] = "Appointment sent succesfully!";
        		    header('location: appointment.php');
                    exit();
				}
		    } else {
                array_push($errors, "You have not been assigned a supervisor or registered for a thesis project yet.");		    
		    }
        }
    }
    
    // Send Extension Request
    if (isset($_POST['send_extd'])) {
        $username = $_SESSION['username'];
        $extd_date = mysqli_real_escape_string($db, $_POST['extd_date']);
        $extd_reason = mysqli_real_escape_string($db, $_POST['extd_reason']);
        
        $check_query = "SELECT * FROM thesis WHERE student_name = '$username'";
        $result = mysqli_query($db, $check_query);
        $thesis = mysqli_fetch_assoc($result);
        
        if ($thesis) {
            $ext_query = "INSERT INTO incomplete_request (student, request_date, reason) VALUES('$username', '$extd_date', '$extd_reason')";
            mysqli_query($db, $ext_query);
    
            $_SESSION['success'] = "Request sent succesfully!";
            header('location: extend_date.php');
            exit();
        } else {
            array_push($errors, "You have not been assigned a supervisor or registered for a thesis project yet.");
        }
    }
    
    // Accept Extension Request
    if (isset($_POST['accept_extd'])) {
        //Retrieve request details
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $request_id = mysqli_real_escape_string($db, $_POST['request_id'.$count]);
        $username = $_SESSION['username'];
        $request_query = "SELECT * FROM incomplete_request WHERE request_id='$request_id'";
        $result = mysqli_query($db, $request_query);
        $request_details = mysqli_fetch_assoc($result);
        $student = $request_details['student'];
        $request_date = $request_details['request_date'];
        $reason = $request_details['reason'];
        
        //Retrieve student's email address
        $email_query = "SELECT username, email FROM users WHERE username='$student' LIMIT 1";
	    $result = mysqli_query($db, $email_query);
	    $user_profile = mysqli_fetch_assoc($result);
	    $user_name = $user_profile['username'];
	    $user_email = $user_profile['email'];
        
        //Email content
        $output='<p>Dear '.$user_name.',</p>';
		$output.='<br>';
		$output.='<p>Your "Incomplete Status" request has been approved.</p>';
		$output.='<p>Request details are shown below.</p>';
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<p><strong>Student Name: </strong>'.$user_name.'</p>';
		$output.='<p><strong>Request Date: </strong>'.$request_date.'</p>';
		$output.='<p><strong>Reason: </strong>'.$reason.'</p>';
		$output.='<p><strong>Approved by: </strong>'.$username.'</p>';   
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<br>';
		$output.='<p>Thanks,</p>';
		$output.='<p>ThesisSupervision</p>';
		$body = $output; 
		$subject = "Incomplete Status Request - ThesisSupervision";
		
		// send email using PHPMailer
		$email_to = $user_email;
		$fromserver = "noreply@programmingprojecthj.com"; 
		require("PHPMailer/PHPMailerAutoload.php");
		$mail = new PHPMailer();
		$mail->Host = "foxtrot.jom.hosting"; // Enter your host here
		$mail->SMTPAuth = true;
		$mail->Username = "noreply@programmingprojecthj.com"; // Enter your email here
		$mail->Password = "thesisms_email"; //Enter your password here
		$mail->Port = 465;
		$mail->IsHTML(true);
		$mail->From = $fromserver;
		$mail->FromName = "ThesisSupervision";
		$mail->Sender = $fromserver; // indicates ReturnPath header
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($email_to);
		
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
			$del_query = "DELETE FROM incomplete_request WHERE request_id='$request_id'";
	        mysqli_query($db, $del_query);
			$_SESSION['success'] = "Request succesfully approved!";
            header('location: manage_extend.php');
            exit();
		}
    }
    
    // Reject Extension Request
    if (isset($_POST['reject_extd'])) {
        //Retrieve request details
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $request_id = mysqli_real_escape_string($db, $_POST['request_id'.$count]);
        $username = $_SESSION['username'];
        $request_query = "SELECT * FROM incomplete_request WHERE request_id='$request_id'";
        $result = mysqli_query($db, $request_query);
        $request_details = mysqli_fetch_assoc($result);
        $student = $request_details['student'];
        $request_date = $request_details['request_date'];
        $reason = $request_details['reason'];
        
        //Retrieve student's email address
        $email_query = "SELECT username, email FROM users WHERE username='$student' LIMIT 1";
	    $result = mysqli_query($db, $email_query);
	    $user_profile = mysqli_fetch_assoc($result);
	    $user_name = $user_profile['username'];
	    $user_email = $user_profile['email'];
        
        //Email content
        $output='<p>Dear '.$user_name.',</p>';
		$output.='<br>';
		$output.='<p>Your "Incomplete Status" request has been rejected.</p>';
		$output.='<p>Request details are shown below.</p>';
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<p><strong>Student Name: </strong>'.$user_name.'</p>';
		$output.='<p><strong>Request Date: </strong>'.$request_date.'</p>';
		$output.='<p><strong>Reason: </strong>'.$reason.'</p>';
		$output.='<p><strong>Rejected by: </strong>'.$username.'</p>';   
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<br>';
		$output.='<p>Thanks,</p>';
		$output.='<p>ThesisSupervision</p>';
		$body = $output; 
		$subject = "Incomplete Status Request - ThesisSupervision";
		
		// send email using PHPMailer
		$email_to = $user_email;
		$fromserver = "noreply@programmingprojecthj.com"; 
		require("PHPMailer/PHPMailerAutoload.php");
		$mail = new PHPMailer();
		$mail->Host = "foxtrot.jom.hosting"; // Enter your host here
		$mail->SMTPAuth = true;
		$mail->Username = "noreply@programmingprojecthj.com"; // Enter your email here
		$mail->Password = "thesisms_email"; //Enter your password here
		$mail->Port = 465;
		$mail->IsHTML(true);
		$mail->From = $fromserver;
		$mail->FromName = "ThesisSupervision";
		$mail->Sender = $fromserver; // indicates ReturnPath header
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($email_to);
		
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
			$del_query = "DELETE FROM incomplete_request WHERE request_id='$request_id'";
	        mysqli_query($db, $del_query);
			$_SESSION['success'] = "Request succesfully rejected!";
            header('location: manage_extend.php');
            exit();
		}
    }
    
    // Upload Document
    if (isset($_POST['upload_doc'])) {
        $username = $_SESSION['username'];
        $target_dir = "admin/users/users_docs/";
        $target_file = $target_dir . basename($_FILES["docToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $turnitin_query = "SELECT FLOOR(RAND()*(999999-100000+1)+100000)";
        $results = mysqli_query($db, $turnitin_query);
        $turnitin_id = mysqli_fetch_array($results);
        $turnitin_id = $turnitin_id[0];
        $similarity_query = "SELECT FLOOR(RAND()*(50-0+1)+0)";
        $results = mysqli_query($db, $similarity_query);
        $similarity = mysqli_fetch_array($results);
        $similarity = $similarity[0];
        
        if($target_file != $target_dir){
            // Check file size
            if ($_FILES["docToUpload"]["size"] > 500000) {
                array_push($errors, "Sorry, your file is too large.");
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                array_push($errors, "Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
            } else {
                if (isset($_SESSION['username'])){
                    if (move_uploaded_file($_FILES["docToUpload"]["tmp_name"], $target_file)) {
                        $query = "INSERT INTO documents VALUES('', '$username', '$target_file', '$turnitin_id', '$similarity')";
        		        mysqli_query($db, $query);
        		        $_SESSION['success'] = "Document succesfully uploaded.";
                    } else {
                        array_push($errors, "Sorry, there was an error uploading your file.");
                    }
                }
    		}
        }
        header('location: index.php');
        exit();
    }
    
    // Edit Document
    if (isset($_POST['edit_doc'])) {
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $doc_id = mysqli_real_escape_string($db, $_POST['doc_id'.$count]);
        $target_dir = "admin/users/users_docs/";
        $target_file = $target_dir . basename($_FILES["docToUpload".$count]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		if($target_file != $target_dir){
            // Check file size
            if ($_FILES["docToUpload"]["size"] > 500000) {
                array_push($errors, "Sorry, your file is too large.");
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                array_push($errors, "Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["docToUpload".$count]["tmp_name"], $target_file)) {
                    $query = "UPDATE documents set doc_path='$target_file' WHERE doc_id='$doc_id'";
    		        mysqli_query($db, $query);
    		        $_SESSION['success'] = "Document succesfully edited!";
                } else {
                    array_push($errors, "Sorry, there was an error uploading your file.");
                }
    		}
        }
        header('location: edit_document.php');
        exit();
    }
    
    // Delete Document
    if (isset($_POST['del_doc'])) {
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $doc_id = mysqli_real_escape_string($db, $_POST['doc_id'.$count]);
        
        $query = "DELETE FROM documents WHERE doc_id='$doc_id'";
        mysqli_query($db, $query);
		$_SESSION['success'] = "Document succesfully deleted!";
		header('location: edit_document.php');
		exit();
    }
    
    // Retrieve Student Information
    if (isset($_POST['get_info'])) {
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $student_name = mysqli_real_escape_string($db, $_POST['student_name'.$count]);
        
        $_SESSION['student'] = $student_name;
        header('location: manage_student_info.php');
        exit();
    }
    
    // Retrieve Student Progress Notes
    if (isset($_POST['get_notes'])) {
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $student_name = mysqli_real_escape_string($db, $_POST['student_name'.$count]);
        
        $_SESSION['student'] = $student_name;
        header('location: progress_note.php');
        exit();
    }
    
    // Edit Thesis Title
    if (isset($_POST['edit_thesis_title'])) {
        $thesis_title = mysqli_real_escape_string($db, $_POST['thesis_title']);
        $student_name = $_SESSION['student'];
        
        // Retrieve student email
        $student_query = "SELECT email FROM users WHERE username='$student_name'";
        $student_result = mysqli_query($db, $student_query);
        $student_email = mysqli_fetch_assoc($student_result);
        $email = $student_email['email'];
        $update_query = "UPDATE thesis SET thesis_desc='$thesis_title' WHERE student_name='$student_name'";
        mysqli_query($db, $update_query);
        $update_query = "UPDATE profile SET thesis_title='$thesis_title' WHERE email='$email'";
        mysqli_query($db, $update_query);
        
        $_SESSION['success'] = "Thesis title succesfully edited!";
        header('location: manage_student_info.php');
        exit();
    }
    
    // Add Progress Note
    if (isset($_POST['add_note'])) {
        $username = $_SESSION['username'];
        $date = mysqli_real_escape_string($db, $_POST['date']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        
        $check_query = "SELECT * FROM thesis WHERE student_name = '$username'";
        $result = mysqli_query($db, $check_query);
        $thesis = mysqli_fetch_assoc($result);
        
        if($thesis){
            $add_query = "INSERT INTO progress_notes VALUES('','$username','$date','$description')";
            $_SESSION['success'] = "Progress note succesfully added!";
            mysqli_query($db, $add_query);
            header('location: progress_note.php');
            exit();
        } else {
            array_push($errors, "You are not involved in a thesis project yet.");
            array_push($errors, "Please register for a project under the 'Register Thesis Title & Supervisor' section.");
        }
    }
    
    // Edit Progress Note
    if (isset($_POST['edit_note'])) {
        $count = mysqli_real_escape_string($db, $_POST['count']);
        $note_id = mysqli_real_escape_string($db, $_POST['note_id'.$count]);
        $description = mysqli_real_escape_string($db, $_POST['description'.$count]);
        echo $count;
        echo $note_id;
        echo $description;
        
        $_SESSION['success'] = "Progress note succesfully edited!";
        $update_query = "UPDATE progress_notes SET description='$description' WHERE note_id='$note_id'";
        mysqli_query($db, $update_query);
        header('location: edit_progress_note.php');
        exit();
    }
?>