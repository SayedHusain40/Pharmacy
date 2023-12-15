<?php
session_start();
include '../header.php';
if (isset($_POST['delaccbtn'])) {
  if (empty($_POST['id'])) {
    echo "<script>alert('Choose an account');</script>";
  } else {
    try {
        include '../Connection/db.php';
   $id = $_POST['id'];

foreach ($id as $i) {
  $userType = ''; // Variable to store the user type

  // Retrieve the user type for the given user ID
  $stmtType = $db->prepare("SELECT `Type` FROM `user data` WHERE `UserID` = :userid");
  $stmtType->bindParam(':userid', $i);
  $stmtType->execute();

  if ($row = $stmtType->fetch()) {
    $userType = $row['Type'];
  }

  // Delete the user account based on the user type
  if (!empty($userType)) {
    $db->exec("DELETE FROM `" . $userType . " data` WHERE `UserID` = '$i'");
  }

  $db->exec("DELETE FROM `user data` WHERE `UserID`='$i'");
}

echo "<script>alert('Account(s) successfully deleted')</script>";
      } catch (PDOException $ex) {
      echo "Error occured!";
      die(($ex->getMessage()));
    }
  } 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="Si", initial-scale="1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" 
        crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/76f78292cc.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/A.css">
    <title>Display All Accounts</title>
    <style>
  html{
    height: 100%;
  }
  body{
    font-family: arial;
    background-image: url('../images/bg2.jpeg');
    background-repeat: no-repeat;
    background-size: cover;
    margin: 0 auto;
  }
    </style>
</head>
<body>
 <form id="user_type" name="user_type" method="post">
  <fieldset>
    <select name="user_type" onchange="document.getElementById('user_type').submit();">
      <option value="">Select user type</option>
      <option value="Staff">Staff</option>
      <option value="Customer">Customer</option>
      <option value="Supplier">Supplier</option>
      <option value="Staff & Customer">Staff &amp; Customer</option>
      <option value="Staff & Supplier">Staff &amp; Supplier</option>
      <option value="Customer & Supplier">Customer &amp; Supplier</option>
      <option value="All">All users</option>
    </select>
  </fieldset>
</form>

<?php
try {
  require('../Connection/db.php');
  if(isset($_POST['user_type'])){
    $user_type = $_POST['user_type'];

    if($user_type === 'Staff' || $user_type === 'Customer' || $user_type === 'Supplier') {
      $stmt = $db->query("SELECT `UserID`, `Username`, `Type`, `Email` FROM `user data` WHERE `Type`='$user_type' ");
    } else if ($user_type === 'Staff & Customer') {
      $stmt = $db->query("SELECT `UserID`, `Username`, `Type`, `Email` FROM `user data` WHERE `Type` IN ('Staff', 'Customer') ");
    } else if ($user_type === 'Staff & Supplier') {
      $stmt = $db->query("SELECT `UserID`, `Username`, `Type`, `Email` FROM `user data` WHERE `Type` IN ('Staff', 'Supplier') ");
    } else if ($user_type === 'Customer & Supplier') {
      $stmt = $db->query("SELECT `UserID`, `Username`, `Type`, `Email` FROM `user data` WHERE `Type` IN ('Customer', 'Supplier') ");
    } else {
      $stmt = $db->query("SELECT `UserID`, `Username`, `Type`, `Email` FROM `user data` WHERE `Type` IN ('Staff','Customer', 'Supplier') ");
    }

    echo "<div id='acctable' class='table-responsive'>";
    echo "<form method='post' id='form'>";
    echo "<table class='table'>";
    echo "<tr>";
    echo "<th></th>";
    echo "<th>User ID</th>";
    echo "<th>User Name</th>";
    echo "<th>User Type</th>";
    echo "<th>Email</th>";
    echo "</tr>";
    $noAccs = 0;
    foreach ($stmt as $f) {
      echo "<tr onclick=\"window.location='../ManageUsers/ViewUser.php?userID=".$f['UserID']."'\">";
      echo "<td><input type='checkbox' name='id[]' value='".$f['UserID']."' /></td>";
      echo "<td>".$f['UserID']."</td>";
      echo "<td>".$f['Username']."</td>";
      echo "<td>".$f['Type']."</td>";
      echo "<td>".$f['Email']."</td>";
      echo "</tr>";
    }
    echo "</table>";
    echo "<a href='../ManageUsers/AddUsers.php' class='btn'>Add Admin Account</a>";
    echo "<button type='submit' name='delaccbtn' class='btn'>Remove Admin Account</button>";
    echo "</form>";
    echo "</div>";
  }
} catch (PDOException $ex) {
  echo "Error occurred!";
  die ($ex->getMessage());
}
?>


      <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

      <!-- Option 2: Separate Popper and Bootstrap JS -->
      <!--
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
      -->
     
  </body>
</html>
