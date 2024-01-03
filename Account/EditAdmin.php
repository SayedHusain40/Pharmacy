<?php
try {
  session_start();

  require("../Connection/init.php");

  //assume
  $userID = $_SESSION["user_id"];
  $stmt = $db->prepare("SELECT * FROM `user data`  WHERE UserID = '$userID'");
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);


//update form 
if (isset($_POST['Update'])){
    
    $Email = $_POST['Email'];
    $Username = $_POST['Username'];

    $up = $db->prepare("UPDATE `user data`SET Email='$Email' , Username='$Username'   WHERE UserID = '$userID'");
    $up->execute();
    $update = $up->fetchAll(PDO::FETCH_ASSOC);

    if ($update){
        echo "Updated Succefully";
    }
}

} //end 
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" 
        crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/76f78292cc.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/EditProfile.css" />
    <title>Update Profile</title>
</head>
<body>
<?php 
  include '../header.php';
  ?>
<?php foreach ($user as $user) {
$Username = $user['Username'];
$Email = $user['Email'];
?>
  <header>
    <div class="container">
  <div class="row">
    <div class="col-lg-6 col-md-8 col-sm-10 col-12">
    <h1>Update Profile</h1>
    <form action="#" method="POST">
<div class="form-group">
            <label for="Username">Username:</label> <br>
            <input type="text" class="form-control" id="Email" name="Username" placeholder="Enter a username" title="Enter a username!" value="<?php echo $Username; ?>">
          <div class="edit">
          <div class="form-group">
            <label for="email">Email:</label> <br>
            <input type="text" class="form-control" id="Email" name="Email" placeholder="Enter an email" title="Enter an email!" value="<?php echo $Email; ?>">
        </div>
        <div class="form-button-wrapper1">
          <input type="submit" name="Update" value="Update"/>
        </div><?php } ?>
        </fieldset>
      </form>
      </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>