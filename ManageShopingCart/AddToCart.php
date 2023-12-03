<?php
try {
  require("../Connection/init.php");

  $userID = 000000001; 
  $productID = 000000001; 
  $QTY = 3; 

  $result = $db->query("SELECT * FROM `product data` WHERE ProductID = $productID");
  $row = $result->fetch();

  if ($row) {
    $total = $QTY * $row["Price"];

    date_default_timezone_set('Asia/Bahrain');
    $AddedDate = date('Y-m-d');

    echo $total . "<br>";
    echo $AddedDate . "<br>";

    $insertInViewCart = "INSERT INTO `view cart` (ProductID, Qty, Total, AddedDate) 
                            VALUES ($productID, $QTY, $total, '$AddedDate')";
    $db->exec($$insertInViewCart);

    $db = null;
  } else {
    echo "Product not found";
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
