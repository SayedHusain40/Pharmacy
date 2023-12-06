<?php
/*
  include ""; 
*/

try {
  require("../Connection/init.php");

  //assume
  $userID = 29; //$_SESSION["user_id"]
  $productID = 3; //GET by js
  $QTY = 1; //GET by js

  // Get product Price
  $stmt = $db->prepare("SELECT Price FROM `product data` WHERE ProductID = ?");
  $stmt->execute([$productID]);
  $ProductPrice = $stmt->fetch();

  $total = $QTY * $ProductPrice["Price"];
  date_default_timezone_set('Asia/Bahrain');
  $AddedDate = date('Y-m-d');

  // insert into view cart
  $stmt = $db->prepare("INSERT INTO `view cart` (UserID, ProductID, Qty, Total, AddedDate) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$userID, $productID, $QTY, $total, $AddedDate]);

  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
