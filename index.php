<?php 
  session_start();
  require("../includes/functions.php");
  require("./includes/functions.php");
  
  //login to the page
  if(isset($_POST["username"]) && $_POST["username"] != ''){
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    login($username, $password);
  }
  
?>
<!doctype html>
<html>
<head>
  <title>Upload</title>
</head>
<body>
  <?php if(isset($_SESSION["authorized"])): //check if user is logged in ?>
  <div class="pull-right add-margin-top">
    <a href="./logout.php" class="btn btn-info">Logout</a>
  </div>
  <?php endif; ?>
  <?php
    //file upload logic
    if(isset($_FILES["gtfsFile"]) && $_FILES["gtfsFile"] != ''){
      $path = $_SERVER['DOCUMENT_ROOT'] ."/gtfs-upload/files";
      if(upload_file($_FILES["gtfsFile"], $path)){
        echo "<div class=\"alert alert-success alert-dismissable\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
          <h4>Success!</h4> Your file has been uploaded.
        </div>";
      }
    }
  ?>
  <?php 
    if(isset($_SESSION["error"]) && $_SESSION["error"] != ''){
      echo "<div class=\"alert alert-danger alert-dismissable\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
          <h4>Error!</h4> $_SESSION[error].
        </div>";
    }
  ?>
  <?php if($_SESSION["authorized"] != 1): //check if user is logged in ?>
    <form role="form" method="POST" action="./">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
  <?php else: ?>
    <p>Use this form to upload a file</p>
    <form role="form" method="POST" action="./" enctype="multipart/form-data">
      <div class="form-group">
        <label for="gtfsFile">File</label>
        <input type="file" name="gtfsFile" id="gtfsFile">
        <p class="help-block">Please upload a .zip file only. All other files will result in an error.</p>
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
  <?php endif; ?>
</body>
</html>