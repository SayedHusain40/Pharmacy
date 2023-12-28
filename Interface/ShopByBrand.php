<?php
session_start();
include '../header.php';

try {
  require("../Connection/init.php");

  $data = $db->prepare("SELECT DISTINCT Brand FROM `product data`");
  $data->execute();

  while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
?>
    <p><?php echo $row["Brand"]; ?></p>
<?php
  }

  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
