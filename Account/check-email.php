<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    include '../Connection/init.php';

    $stmt = $db->prepare("SELECT * FROM `user data` WHERE Email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Not unique";
    } else {
        echo "Unique";
    }
}
?>