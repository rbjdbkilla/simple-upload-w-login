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
  //file upload logic
  if(isset($_FILES["gtfsFile"]) && $_FILES["gtfsFile"] != ''){
    $path = $_SERVER['DOCUMENT_ROOT'] ."/gtfs-upload/files";
    if(upload_file($_FILES["gtfsFile"], $path)){
      echo "yay";
    }
  }
?>
<!doctype html>
<html>
<head>
  <title>Upload</title>
</head>
<body>
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
  <p>Use this form to upload a .zip GTFS file</p>
  <form role="form" method="POST" action="./" enctype="multipart/form-data">
    <div class="form-group">
      <label for="gtfsFile">GTFS File</label>
      <input type="file" name="gtfsFile" id="gtfsFile">
      <p class="help-block">Please upload a GTFS .zip file only. All other files will result in an error.</p>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
<?php endif; ?>
</body>
</html>