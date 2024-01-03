<?php
session_start();
try {
    include '../Connection/init.php';

  

    // Check if OrderID is set in the session
    if (isset($_SESSION['orderId'])) {
        // Get the order ID from the session
        $orderId = $_POST['orderId'];

        // Get the order status
        $status = getOrderStatus($orderId);

        // Display the order status
        if ($status) {
            echo "Order ID: " . $orderId . "<br>";
            echo "Status: " . $status;
        } else {
            echo "Order not found.";
        }
    } else {
        echo "Please provide an order ID.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

  // Function to get order status based on order ID
  function getOrderStatus($orderId) {
    global $db;

    // Prepare the SQL statement
    $stmt = $db->prepare("SELECT Status FROM `order data` WHERE OrderID = :OrderID");

    // Bind the parameter
    $stmt->bindParam(':OrderID', $orderId);

    // Execute the query
    $stmt->execute();

    // Fetch the status
    $status = $stmt->fetchColumn();

    return $status;
}

// Close the database connection
$db = null;
?>