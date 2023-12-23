<?php

try {
  require("../Connection/init.php");

  //delete Items from cart when click on delete
  if (isset($_REQUEST['WID'])) {

    $WID = $_REQUEST['WID'];

    $stmt = $db->prepare("DELETE FROM `wish list data` WHERE WID = ?");
    $stmt->execute([$WID]);

    header("Location: ViewWishList.php");
    exit();
  }

  $db = null;   
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
