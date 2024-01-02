<?php
include '../Connection/init.php'; // Replace with your own database configuration file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['name'];

    try {
        $stmt = $db->prepare("SELECT * FROM `product data` WHERE Name = :name");
        $stmt->bindParam(":name", $productName);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {
            echo "The product exists!";
        } else {
            echo "Valid";
        }
    } catch (PDOException $e) {
        echo 'Error retrieving data: ' . $e->getMessage();
    }
}
?>