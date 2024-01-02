<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["un"];

      include '../Connection/init.php';

    $stmt = $db->prepare("SELECT * FROM `user data` WHERE Username = :un");
    $stmt->bindParam(':un', $username);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        echo "Not unique";
    } else {
        echo "Unique";
    }
}
?>
