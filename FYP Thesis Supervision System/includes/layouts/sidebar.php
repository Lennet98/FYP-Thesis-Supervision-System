<div class="sidenav">
    <h3 style="padding: 5px 0px 10px 16px; color: #FFFFFF; text-decoration: underline;">Navigation</h3>
    <!-- For students only -->
    <?php  if ($_SESSION['role']=="Student") : ?>
        <a href="register_thesis.php">
            <h4>Register Thesis Title & Supervisor</h4>
        </a>
        <hr/>
        <a href="progress_note.php">
            <h4>Record Progress Note</h4>
        </a>
        <hr/>
        <a href="appointment.php">
            <h4>Make Appointment</h4>
        </a>
        <hr/>
        <a href="extend_date.php">
            <h4>Make Request to Incomplete Status</h4>
        </a>
    <?php endif ?>
    
    <!-- For lecturers and deans only -->
    <?php  if (($_SESSION['role']=="Lecturer") || ($_SESSION['role']=="Dean")) : ?>
        <a href="student_info.php">
            <h4>Student's Info</h4>
        </a>
        <hr/>
        <?php  if ($_SESSION['role']=="Lecturer") : ?>
            <a href="mg_progress_note.php">
                <h4>Manage Progress Note</h4>
            </a>
            <hr/>
        <?php endif ?>
        <a href="manage_extend.php">
            <h4>Manage Incomplete Status Request</h4>
        </a>
    <?php endif ?>
    
    <!-- For coordinators only -->
    <?php  if ($_SESSION['role']=="Coordinator") : ?>
        <a href="manage_thesis.php">
            <h4>Thesis Title & Supervisor Request</h4>
        </a>
        <hr/>
        <a href="manage_extend.php">
            <h4>Incomplete Status Request</h4>
        </a>
        <hr/>
        <a href="mg_progress_note.php">
            <h4>Progress Note</h4>
        </a>
    <?php endif ?>
    
    <!-- For all roles except for Dean -->
    <?php  if (($_SESSION['role']!="Dean")) : ?>
        <hr/>
        <a href="profile.php">
            <h4>Profile</h4>
        </a>
    <?php endif ?>
    
    <!-- For students and lecturers only -->
    <?php  if (($_SESSION['role']=="Student") || ($_SESSION['role']=="Lecturer")) : ?>
        <hr/>
        <a href="forum.php">
            <h4>Forum</h4>
        </a>
    <?php endif ?>
</div>