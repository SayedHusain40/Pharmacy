<?php
try {
  session_start();

  require("../Connection/init.php");

  //assume
  $userID = $_SESSION["user_id"];
  $stmt = $db->prepare("SELECT * FROM `customer data` WHERE UserID = '$userID'");
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

//update form 
if (isset($_POST['Update'])){
    
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    //$MobileNumber = $_POST['MobileNumber'];
    $Email = $_POST['Email'];
    //$DOB = $_POST['DOB'];

    $up = $db->prepare("UPDATE `customer data`SET FirstName='$FirstName' , LastName='$LastName' , Email='$Email' WHERE UserID = '$userID'");
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
        <link rel="stylesheet" href="../css/Account.css" />
    <title>Document</title>
</head>
<body>
<?php 
  include '../header.php';
  ?>
<?php foreach ($user as $user) {
$FirstName = $user['FirstName'];
$LastName = $user['LastName'];
$MobileNumber = $user['MobileNumber'];
$Email = $user['Email'];
$DOB = $user['DOB'];
?>
  <header>
    <div class="container">
  <div class="row">
    <div class="col-lg-6 col-md-8 col-sm-10 col-12">
      <h1>Sign up</h1>
    <form action="#" method="POST">
<div class="form-group">
            <label for="fname">First Name:</label> <br>
            <input type="text" class="form-control" id="fname" name="FirstName" placeholder="Enter your first name" title="Enter your first name!" value="<?php echo $FirstName; ?>">
          </div>
          <div class="form-group">
            <label for="lname">Last Name:</label> <br>
            <input type="text" class="form-control" id="lname" name="LastName" placeholder="Enter your last name" title="Enter your last name!" value="<?php echo $LastName; ?>">
          </div>
          <div class="form-group">
            <label for="email">Email:</label> <br>
            <input type="text" class="form-control" id="Email" name="Email" placeholder="Enter an email" title="Enter an email!" value="<?php echo $Email; ?>">
          </div>
          <div class="form-group">
            <label for="username">Username:</label> <br>
            <input type="text" class="form-control" id="username" name="un" placeholder="Enter an username" title="Enter an username!" value="<?php echo $user; ?>">
          </div>
          <div class="form-group">
          <label for="phone_number">Phone Number:</label> <br>
          <input type="text" class="form-control" id="phone_number" name="phn" placeholder="Enter phone number" title="Enter phone number" value="<?php echo $MobileNumber; ?>">
          </div>
          <div class="G form-group">
          <label for="gender">Gender:</label> <br>
          <input type="radio" id="male" name="gender" value="male">
          <label id="male" for="male">Male</label>
          <input type="radio" id="female" name="gender" value="female">
          <label id="female" for="female">Female</label> 
          </div>
          <div class="form-group">
          <label for="dob">Date of Birth:</label> <br>
          <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter your date of birth" title="Enter your date of birth" value="<?php echo $DOB; ?>">
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