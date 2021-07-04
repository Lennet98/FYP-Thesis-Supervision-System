<!-- For students only -->
<?php  if ($_SESSION['role']=="Student") : ?>
    <div class="menu-content">
        <a href="register_thesis.php">
            <img class="navlogo" alt="Thesis Icon" src="assets/img/thesis-logo.png" />
            <h3>Register Thesis Title & Supervisor</h3>
        </a>
    </div>
    <div class="menu-content">
        <a href="progress_note.php">
            <img class="navlogo" alt="Progress Note Icon" src="assets/img/progress-note.png" />
            <h3>Record Progress Note</h3>
        </a>
    </div>
    <div class="menu-content">
        <a href="appointment.php">
            <img class="navlogo" alt="Appointment Icon" src="assets/img/appointment-icon.png" />
            <h3>Make Appointment</h3>
        </a>
    </div>    
    <div class="menu-content">
        <a href="extend_date.php">
            <img class="navlogo" alt="Extend Date Icon" src="assets/img/extension-icon.png" />
            <h3>Make Request to Incomplete Status</h3>
        </a>
    </div>
<?php endif ?>

<!-- For lecturers and deans only -->
<?php  if (($_SESSION['role']=="Lecturer") || ($_SESSION['role']=="Dean")) : ?>
    <div class="menu-content">
        <a href="student_info.php">
            <img class="navlogo" alt="Student Info Icon" src="assets/img/student_info.png" />
            <h3>Student's Info</h3>
        </a>
    </div>
    <?php  if ($_SESSION['role']=="Lecturer") : ?>
    <div class="menu-content">
        <a href="mg_progress_note.php">
            <img class="navlogo" alt="Progress Note Icon" src="assets/img/progress-note.png" />
            <h3>Manage Progress Note</h3>
        </a>
    </div>
    <?php endif ?>
    <div class="menu-content">
        <a href="manage_extend.php">
            <img class="navlogo" alt="Status Request Icon" src="assets/img/manage_extension.png" />
            <h3>Manage Incomplete Status Request</h3>
        </a>
    </div>
<?php endif ?>

<!-- For coordinators only -->
<?php  if ($_SESSION['role']=="Coordinator") : ?>
    <div class="menu-content">
        <a href="manage_thesis.php">
            <img class="navlogo" alt="Thesis Icon" src="assets/img/thesis-logo.png" />
            <h3>Thesis Title & Supervisor Request</h3>
        </a>
    </div>
    <div class="menu-content">
        <a href="manage_extend.php">
            <img class="navlogo" alt="Status Request Icon" src="assets/img/manage_extension.png" />
            <h3>Incomplete Status Request</h3>
        </a>
    </div>
    <div class="menu-content">
        <a href="mg_progress_note.php">
            <img class="navlogo" alt="Progress Note Icon" src="assets/img/progress-note.png" />
            <h3>Progress Note</h3>
        </a>
    </div>
<?php endif ?>

<!-- For all roles except for Dean -->
<?php  if (($_SESSION['role']!="Dean")) : ?>
<div class="menu-content">
    <a href="profile.php">
        <img class="navlogo" alt="Profile Icon" src="assets/img/profile_icon.png" />
        <h3>Profile</h3>
    </a>
</div>
<?php endif ?>

<!-- For students and lecturers only -->
<?php  if (($_SESSION['role']=="Student") || ($_SESSION['role']=="Lecturer")) : ?>
    <div class="menu-content">
        <a href="forum.php">
            <img class="navlogo" alt="Forum Icon" src="assets/img/forum_icon.png" />
            <h3>Forum</h3>
        </a>
    </div>
<?php endif ?>