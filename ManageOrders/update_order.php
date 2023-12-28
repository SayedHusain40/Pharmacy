<?php
session_start();
try {

    include '../Connection/init.php';

if (isset($_POST['orderId']) && isset($_POST['status'])) {
  $orderId = $_POST['orderId'];
  $status = $_POST['status'];

  // Update the status in the database
  $stmt = $db->prepare("UPDATE `order data` SET Status = :status WHERE OrderID = :orderId");
  $stmt->bindParam(':status', $status);
  $stmt->bindParam(':orderId', $orderId);
  $stmt->execute();

  // Return a response if needed
  echo "Status updated successfully!";
  exit(); // Exit the script after updating the status
} 
} catch (PDOException $e) { 
    die("Error: " . $e->getMessage());
}
?>