<?php
try {
  session_start();

  require("../Connection/init.php");

  //assume
  $userID = $_SESSION["user_id"];
  $productID = $_POST["productID"];
  $QTY = $_POST["quantity"];

  // Get product Price
  //check first if this product have a offer
  date_default_timezone_set('Asia/Bahrain');
  $currentDate = date("Y-m-d");
  $discount = $db->prepare("SELECT DiscountedPrice FROM `offers data` WHERE ProductID = ? AND StartDate <= ? AND EndDate >= ?");
  $discount->execute([$productID, $currentDate, $currentDate]);
  $DiscountedPrice = $discount->fetch();
  $countOffer = $discount->rowCount();

  $stmt = $db->prepare("SELECT Price FROM `product data` WHERE ProductID = ?");
  $stmt->execute([$productID]);
  $ProductPrice = $stmt->fetch();

  $currentPrice = $ProductPrice["Price"];
  if ($countOffer > 0) {
    $currentPrice = $DiscountedPrice["DiscountedPrice"];
  }
  $total = $QTY *  $currentPrice;
  date_default_timezone_set('Asia/Bahrain');
  $AddedDate = date('Y-m-d');


  // check for if product already in cart
  $check = $db->prepare("SELECT * FROM `view cart` WHERE ProductID = ? And UserID = ?");
  $check->execute([$productID, $userID]);
  $checkResult = $check->rowCount();

  //means already added to cart now updated
  if ($checkResult === 1) {
    $row = $check->fetch();
    $currentQTY = $row["Qty"];
    $currentTotal = $row["Total"];

    $newQTY = $currentQTY + $QTY;
    $newTotal = $currentTotal + $total;

    // Update view cart
    $update = $db->prepare("UPDATE `view cart` SET Qty = ?, Total = ?, AddedDate = ? WHERE ProductID = ? AND UserID = ?");
    $update->execute([$newQTY, $newTotal, $AddedDate, $productID, $userID]);
  } else {
    // insert into view cart
    $stmt = $db->prepare("INSERT INTO `view cart` (UserID, ProductID, Qty, Total, AddedDate) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userID, $productID, $QTY, $total, $AddedDate]);
  }


  //for message added to cart successfully
  $_SESSION['addToCart_success'] = "true";

  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
