<?php
session_start();
include '../Connection/db.php';
// Retrieve the user ID from the query parameter
$userID = $_GET['userID'];

// Retrieve the user details from the database based on the user ID
$stmt = $db->prepare("SELECT * FROM `user data` WHERE `UserID` = :userid");
$stmt->bindParam(':userid', $userID);
$stmt->execute();

// Check if a user with the given ID exists
if ($row = $stmt->fetch()) {
    echo "<h1>User Details</h1>";
    echo "<p><strong>User ID:</strong> " . $row['UserID'] . "</p>";
    echo "<p><strong>Username:</strong> " . $row['Username'] . "</p>";
    echo "<p><strong>Type:</strong> " . $row['Type'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['Email'] . "</p>";
} else {
    echo "<p>User not found.</p>";
}
?>
<style>
      html{
    height: 100%;
    background-image: url('../images/Admin2.png');
    background-repeat: no-repeat;
    background-size: cover;
  }
  body{
    font-family: arial;
    background-image: url('../images/Admin2.png');
    background-repeat: no-repeat;
    background-size: cover;
    margin: 0 auto;
  }
</style>