<?php
try {
  require("../Connection/init.php");

  //delete Items from cart when click on delete
  if (isset($_REQUEST['cartID']) && isset($_REQUEST['delete'])) {

    $cartID = $_REQUEST['cartID'];

    $deleteQuery = "DELETE FROM `view cart` WHERE CartID = ?";
    $stmt = $db->prepare($deleteQuery);
    $stmt->execute([$cartID]);

    header("Location: ViewShoppingCart.php");
    exit();
  }


  //Update Qty and Price When click on update QTY
  if (isset($_POST['update-qty']) && isset($_POST['newQTY']) && isset($_POST['cartID'])) {

    $productID = $_POST["productID"];
    $sql = $db->prepare("SELECT Price FROM `product data` WHERE ProductID = ?");
    $sql->execute([$productID]);

    $ProductPrice = $sql->fetch();
    $total = $_POST['newQTY'] * $ProductPrice["Price"];

    $UpdateQTY = "UPDATE `view cart` SET Qty = ?, Total = ? WHERE `CartID` = ?";
    $stmt = $db->prepare($UpdateQTY);
    $stmt->execute([$_POST['newQTY'], $total, $_POST['cartID']]);

    header("Location:  ViewShoppingCart.php");
    exit();
  }

  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
