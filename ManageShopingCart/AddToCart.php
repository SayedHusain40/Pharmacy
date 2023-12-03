<?php
try {
  require("../Connection/init.php");

  //assume
  $userID = 000000004;
  $productID = 000000002;
  $QTY = 5;

  $sql = $db->prepare("SELECT Price FROM `product data` WHERE ProductID = ?");
  $sql->execute([$productID]);

  $ProductPrice = $sql->fetch();

  $total = $QTY * $ProductPrice["Price"];

  date_default_timezone_set('Asia/Bahrain');
  $AddedDate = date('Y-m-d');

  $sql = $db->prepare("INSERT INTO `view cart` (ProductID, Qty, Total, AddedDate) VALUES (?, ?, ?, ?)");
  $sql->execute([$productID, $QTY, $total, $AddedDate]);

  
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
