<?php
session_start();
// Retrieve the order ID sent from the client-side
$orderID = $_POST['OrderID'];


try {

    include '../Connection/init.php';
    // Prepare and execute the SQL query to update the order
    $sql = "UPDATE `order data` SET status = 'completed' WHERE OrderID = :orderID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':orderID', $orderID);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        $response = array('success' => true, 'message' => 'Order updated successfully');
    } else {
        $response = array('success' => false, 'message' => 'Failed to update order');
    }
} catch (PDOException $e) {
    $response = array('success' => false, 'message' => 'Database error: ' . $e->getMessage());
}

// Close the database connection
$db = null;

// Return the JSON response to the client
echo json_encode($response);
?>