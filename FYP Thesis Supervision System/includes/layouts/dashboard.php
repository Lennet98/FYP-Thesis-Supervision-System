<div class="dashboard-header">
	<h2><?php echo $_SESSION['role']; ?> Dashboard</h2>
</div>
<div class="dashboard-content">
    <?php include('errors.php'); ?>
    <?php if (isset($_SESSION['success'])) : ?>
	    <div class="error success" style="margin: 0px; width: 95%; font-size: 1.2vw;">
            <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif ?>
	<!-- logged in user information -->
	<?php  if (isset($_SESSION['username'])) : ?>
	    <?php  if (($_SESSION['role']=="Student") || ($_SESSION['role']=="Lecturer")) : ?>
    		<div class=dashboard-layout>
    		    <div class="menu">
    		        <?php include ('includes/layouts/menu.php') ?>
		        </div>
                <div>
                    <div class="fc-content">
                        <?php include ('includes/layouts/announcements.php') ?>
                    </div>
                    <div class="fc-content">
                        <?php include ('includes/layouts/documents.php') ?>
                    </div>
                </div>
    	    </div>
	    <?php endif ?>
	    <?php  if ($_SESSION['role']=="Coordinator") : ?>
	        <div class=dashboard-layout>
	            <div class="menu">
    		        <?php include ('includes/layouts/menu.php') ?>
		        </div>
		        <div>
                    <div class="fc-content">
                        <?php include ('includes/layouts/announcements.php') ?>
                    </div>
                </div>
	        </div>
	    <?php endif ?>
	    <?php  if ($_SESSION['role']=="Dean") : ?>
	        <div class=dashboard-layout>
	            <div class="menu">
    		        <?php include ('includes/layouts/menu.php') ?>
		        </div>
	        </div>
	    <?php endif ?>
	<?php endif ?>
</div>