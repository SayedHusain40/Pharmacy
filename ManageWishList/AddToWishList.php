<?php

try {
  session_start();
  require("../Connection/init.php");

  $userID = $_SESSION["user_id"];
  $productID = $_REQUEST["productID"]; 

  // check for if product already in wish list
  $check = $db->prepare("SELECT * FROM `wish list data` WHERE ProductID = ? And UserID = ?");
  $check->execute([$productID, $userID]);
  $checkResult = $check->rowCount();

  //insert if not in wish list
  if ($checkResult === 0) {
    // insert into wish list data table
    $stmt = $db->prepare("INSERT INTO `wish list data` (UserID, ProductID) VALUES (?, ?)");
    $stmt->execute([$userID, $productID]);
  }

  
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
