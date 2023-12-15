<?php
try {
  require("../Connection/init.php");

  //assume
  $userID = 6; //$_SESSION["user_id"]
  $productID = 2; // $_POST[]  by js better
  $QTY = 1; //$_POST[]  by js better

  // Get product Price
  $stmt = $db->prepare("SELECT Price FROM `product data` WHERE ProductID = ?");
  $stmt->execute([$productID]);
  $ProductPrice = $stmt->fetch();

  $total = $QTY * $ProductPrice["Price"];
  date_default_timezone_set('Asia/Bahrain');
  $AddedDate = date('Y-m-d');


  // check for if product already in cart
  $check = $db->prepare("SELECT * FROM `view cart` WHERE ProductID = ? And UserID = ?");
  $check->execute([$productID, $userID]);
  $checkResult = $check->rowCount();

  //means already added to cart now updated
  if($checkResult === 1) {
    $row = $check->fetch();
    $currentQTY = $row["Qty"];
    $currentTotal = $row["Total"];

    $newQTY = $currentQTY + $QTY;
    $newTotal = $currentTotal + $total;

    // Update view cart
    $update = $db->prepare("UPDATE `view cart` SET Qty = ?, Total = ?, AddedDate = ? WHERE ProductID = ? AND UserID = ?");
    $update->execute([$newQTY, $newTotal, $AddedDate, $productID, $userID]);
  }
  else {
    // insert into view cart
    $stmt = $db->prepare("INSERT INTO `view cart` (UserID, ProductID, Qty, Total, AddedDate) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userID, $productID, $QTY, $total, $AddedDate]);
  }


  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
