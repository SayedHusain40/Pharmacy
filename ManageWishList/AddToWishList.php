<?php
/*
  include ""; 
*/

try {
  require("../Connection/init.php");

  //assume
  $userID = 6; //$_SESSION["user_id"]
  $productID = 3; //GET by js

  // insert into wish list data table
  $stmt = $db->prepare("INSERT INTO `wish list data` (UserID, ProductID) VALUES (?, ?)");
  $stmt->execute([$userID, $productID]);

  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
