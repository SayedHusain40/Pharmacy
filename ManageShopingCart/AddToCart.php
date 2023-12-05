<?php
try {
  require("../Connection/init.php");

  //assume
  $userID = 000000004;
  $productID = 000000001;
  $QTY = 1;

  $sql = $db->prepare("SELECT Price FROM `product data` WHERE ProductID = ?");
  $sql->execute([$productID]);

  $ProductPrice = $sql->fetch();

  $total = $QTY * $ProductPrice["Price"];

  date_default_timezone_set('Asia/Bahrain');
  $AddedDate = date('Y-m-d');

  // insert into view cart
  $sql = $db->prepare("INSERT INTO `view cart` (UserID, ProductID, Qty, Total, AddedDate) VALUES (?, ?, ?, ?, ?)");
  $sql->execute([$userID, $productID, $QTY, $total, $AddedDate]);


  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
