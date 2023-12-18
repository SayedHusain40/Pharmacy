<?php
try {
  require("../Connection/init.php");

  //delete odder from offers data when click on delete
  if (isset($_POST['OfferID'])) {

    $OfferID = $_POST['OfferID'];

    $stmt = $db->prepare("DELETE FROM `offers data` WHERE OfferID = ?");
    $stmt->execute([$OfferID]);

    // session_start();
    // $_SESSION['deleteProduct_success'] = "true";
    // header("Location: ViewShoppingCart.php");
    // exit();
  }

  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
