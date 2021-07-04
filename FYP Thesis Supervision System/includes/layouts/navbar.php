<?php 
    // if user has not logged in, show default nav bar
    if (!isset($_SESSION['username'])) { ?>
        <div class="header">
        	<div class="start_header_container">
        	    <a href="boardingPage.php">
        	        <img class="navlogo" alt="ThesisMS Logo" src="assets/img/thesisms_logo.png" />
        	        <p>ThesisSupervision</p>
                </a>
        	    <div class="start_btn_container">
        	    	<a href="login.php">Log In</a>	
        	    	<a href="register.php">Sign Up</a>
        		</div>
        	</div>
        </div>
    <?php  }
    
    // if user has logged in, show personalised nav bar
    if (isset($_SESSION['username'])) { ?>
	    <div class="header">
        	<div class="start_header_container">
        	    <a href="index.php">
        	        <img class="navlogo" alt="ThesisMS Logo" src="assets/img/thesisms_logo.png" />
        	        <p>ThesisSupervision</p>
                </a>
                <div class="start_btn_container" style="font-size:1vw; padding: 10px 50px 1vw 0px;">
                    <?php  if (($_SESSION['role']=="Student")) : ?>
                    <a href="materials.php" style="text-decoration: none;">
                        <p style="text-decoration: underline;">Materials</p>
                    </a>
                    <?php endif ?>
                    <?php  if (($_SESSION['role']!="Dean")) : ?>
                    <a href="profile.php" style="text-decoration: none;">
                        <p>Welcome <strong style="text-decoration: underline;"><?php echo $_SESSION['username'];?>,</strong></p>
                    </a>
                    <?php endif ?>
                    <?php  if (($_SESSION['role']=="Dean")) : ?>
                    <a style="text-decoration: none;">
                        <p>Welcome <strong><?php echo $_SESSION['username'];?>,</strong></p>
                    </a>
                    <?php endif ?>
    				<a href="index.php?logout='1'">
    				    <p style="text-decoration: underline;">Logout</p>
				    </a>
                </div>
            </div>
        </div>
<?php } ?>