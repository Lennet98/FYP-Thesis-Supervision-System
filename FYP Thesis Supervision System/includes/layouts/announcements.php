<?php include('includes/logics/annc_retrieval.php'); ?>
<div class="announcement-content">
    <div>
        <h2>Announcements</h2><hr>
        <?php  if ($_SESSION['role']=="Lecturer" || $_SESSION['role']=="Coordinator") : ?>
            <button class="announcement-btn" onclick="openForm()">+ Add Announcement</button>
            <a href="edit_announcement.php">
                <button class="announcement-btn">Edit Announcements</button>
            </a><br><br>
            <div class="form-popup" id="ancForm">
                <form method="post" action="index.php" class="form-container">
                    <h3>Add Announcement</h3><br><br>
                    <textarea id="announcement" name="announcement" placeholder="Enter Description" rows="6" cols="50" required></textarea>
                    <button type="button" class="btn" onclick="closeForm()" style="background: red;">Cancel</button>
                    <button type="submit" class="btn" name="add_anc">Submit</button>
                </form>
            </div>
        <?php endif ?>
        <?php foreach ($posts as $row) : ?>
            <div class="annc-header">
                <h4>&emsp;Posted by: <strong><?php echo $row['username'] ?></strong></h4>
                <hr>
            </div>
            <div class="annc-content">
                <p><?php echo $row['announcement'] ?></p>
            </div>
        <?php endforeach ?>
    </div>
</div>
<script>
    function openForm() {
      document.getElementById("ancForm").style.display = "block";
    }
    
    function closeForm() {
      document.getElementById("ancForm").style.display = "none";
    }
</script>