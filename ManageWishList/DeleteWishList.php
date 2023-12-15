<?php

try {
  require("../Connection/init.php");

  //delete Items from cart when click on delete
  if (isset($_REQUEST['WID'])) {

    $WID = $_REQUEST['WID'];

    $deleteQuery = "DELETE FROM `wish list data` WHERE WID = ?";
    $stmt = $db->prepare($deleteQuery);
    $stmt->execute([$WID]);

    header("Location: ViewWishList.php");
    exit();
  }

  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
