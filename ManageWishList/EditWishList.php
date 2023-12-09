<?php



try {
  require("../Connection/init.php");
  //assume
  $userID = 6; //$_SESSION["user_id"]


  $stmt = $db->prepare("SELECT * FROM `wish list data` WHERE UserID = ?");

  $stmt->execute([$userID]);


  while($row = $stmt->fetch()) {

  }

  $db = null;
} catch (PDOException $e) {

  echo "Error: " . $e->getMessage();
}
