<?php include('includes/logics/doc_retrieval.php'); ?>
<style>
    #turnitinValues {
        visibility: hidden;
    }
</style>
<div class="document-content">
    <h2>Documents</h2><hr><br>
    <button class="announcement-btn" onclick="openDocForm()">+ Upload Document</button>
    <a href="edit_document.php">
        <button class="announcement-btn">Edit Documents</button>
    </a>
    <?php  if ($_SESSION['role']=="Lecturer") : ?>
    <button class="announcement-btn" onclick="openClosePlag()">Show Plagiarism</button>
    <?php endif ?><br><br>
    <div class="form-popup" id="docForm">
        <form method="post" action="" class="form-container" enctype = "multipart/form-data">
            <div style="background: white; color: black; border-radius: 10px;">
                <h3>Upload Document</h3><br>
                <input type="file" name="docToUpload" id="docToUpload" class="docToUpload" style="text-align-last: center; margin: auto; margin-bottom: 30px;"/><br>
                <button type="submit" class="btn" name="upload_doc" style="float:none; margin-right: 0px;">Submit</button>
                <button type="button" class="btn" onclick="closeDocForm()" style="background: red; float:none; margin-right: 0px;">Cancel</button><br>
            </div>
        </form>
    </div>
    <h3 style="margin-top: 20px; text-align:left;">&emsp;List of Available Documents:</h3><hr>
    
    <div class="doc-content">
        <div class="doc-files">
            <div>
                <?php foreach ($posts as $row) : ?>
                <?php
                    $filename = pathinfo($row['doc_path']);
                    $filename = $filename['basename'];
                ?>
                <a href="<?php echo $row['doc_path'] ?>" download> [<?php echo $row['doc_id'] ?>] <?php echo $filename ?></a>
                <p>Uploaded by: <?php echo $row['username'] ?></p><br>
                <?php endforeach ?>
            </div>
            <div id="turnitinValues">
                <?php foreach ($posts as $row) : ?>
                <?php  if ($_SESSION['role']=="Lecturer") : ?>
                <p>Turnitin ID: <?php echo $row['turnitin_id'] ?></p>
                <p>Similarity: <?php echo $row['similarity'] ?> %</p><br>
                <?php  endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<script>
    function openClosePlag() {
        if(document.getElementById("turnitinValues").style.visibility == "visible"){
            document.getElementById("turnitinValues").style.visibility = "hidden";
        } else {
            document.getElementById("turnitinValues").style.visibility = "visible";
        }
    }
    
    function openDocForm() {
      document.getElementById("docForm").style.display = "block";
    }
    
    function closeDocForm() {
      document.getElementById("docForm").style.display = "none";
    }
</script>