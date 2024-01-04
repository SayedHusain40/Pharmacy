<?php 
session_start();
try {
    include '../Connection/init.php';

    if (isset($_POST['orderId']) && isset($_POST['status'])) {
        $orderId = $_POST['orderId'];
        $status = $_POST['status'];

        // Check if the order exists in the `order data` table
        $checkStmt = $db->prepare("SELECT OrderID FROM `order data` WHERE OrderID = :orderId");
        $checkStmt->bindParam(':orderId', $orderId);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            if ($status === 'Completed') {
                // Check if the order exists in the `trackorder` table
                $trackOrderStmt = $db->prepare("SELECT OrderID FROM `trackorder` WHERE OrderID = :orderId");
                $trackOrderStmt->bindParam(':orderId', $orderId);
                $trackOrderStmt->execute();

                if ($trackOrderStmt->rowCount() > 0) {
                    // Update the existing row in the `trackorder` table
                    $stmt = $db->prepare("UPDATE `trackorder` SET CompleteOrderDate = NOW() WHERE OrderID = :orderId");
                    $stmt->bindParam(':orderId', $orderId);
                    $stmt->execute();
                } else {
                    // Insert a new row in the `trackorder` table
                    $stmt = $db->prepare("INSERT INTO `trackorder` (OrderID, CompleteOrderDate) VALUES (:orderId, NOW())");
                    $stmt->bindParam(':orderId', $orderId);
                    $stmt->execute();
                }

                // Update the `Status` column in the `order data` table
                $updateStatusStmt = $db->prepare("UPDATE `order data` SET Status = :status WHERE OrderID = :orderId");
                $updateStatusStmt->bindParam(':status', $status);
                $updateStatusStmt->bindParam(':orderId', $orderId);
                $updateStatusStmt->execute();

                header("Location: ../ManageOrders/OrderStatus.php");
                exit;
            } else if ($status === 'Out for Delivery') { 
                // Check if the order exists in the `trackorder` table
                $trackOrderStmt = $db->prepare("SELECT OrderID FROM `trackorder` WHERE OrderID = :orderId");
                $trackOrderStmt->bindParam(':orderId', $orderId);
                $trackOrderStmt->execute();

                if ($trackOrderStmt->rowCount() > 0) {
                    // Update the existing row in the `trackorder` table
                    $stmt = $db->prepare("UPDATE `trackorder` SET OutForDeliveryDate = NOW() WHERE OrderID = :orderId");
                    $stmt->bindParam(':orderId', $orderId);
                    $stmt->execute();
                } else {
                    // Insert a new row in the `trackorder` table
                    $stmt = $db->prepare("INSERT INTO `trackorder` (OrderID, OutForDeliveryDate) VALUES (:orderId, NOW())");
                    $stmt->bindParam(':orderId', $orderId);
                    $stmt->execute();
                }

                // Update the `Status` column in the `order data` table
                $updateStatusStmt = $db->prepare("UPDATE `order data` SET Status = :status WHERE OrderID = :orderId");
                $updateStatusStmt->bindParam(':status', $status);
                $updateStatusStmt->bindParam(':orderId', $orderId);
                $updateStatusStmt->execute();

                header("Location: ../ManageOrders/OrderStatus.php");
                exit;
            } else if ($status === 'Processing') { 
      // Check if the order exists in the `trackorder` table
      $trackOrderStmt = $db->prepare("SELECT OrderID FROM `trackorder` WHERE OrderID = :orderId");
      $trackOrderStmt->bindParam(':orderId', $orderId);
      $trackOrderStmt->execute();

      if ($trackOrderStmt->rowCount() > 0) {
          // Update the existing row in the `trackorder` table
          $stmt = $db->prepare("UPDATE `trackorder` SET ProcessingDate = NOW() WHERE OrderID = :orderId");
          $stmt->bindParam(':orderId', $orderId);
          $stmt->execute();
      } else {
          // Insert a new row in the `trackorder` table
          $stmt = $db->prepare("INSERT INTO `trackorder` (OrderID, ProcessingDate) VALUES (:orderId, NOW())");
          $stmt->bindParam(':orderId', $orderId);
          $stmt->execute();
      }

      // Update the `Status` column in the `order data` table
      $updateStatusStmt = $db->prepare("UPDATE `order data` SET Status = :status WHERE OrderID = :orderId");
      $updateStatusStmt->bindParam(':status', $status);
      $updateStatusStmt->bindParam(':orderId', $orderId);
      $updateStatusStmt->execute();

      header("Location: ../ManageOrders/OrderStatus.php");
      exit;
            } else if ($status === 'Confirmed') { 
                   // Check if the order exists in the `trackorder` table
      $trackOrderStmt = $db->prepare("SELECT OrderID FROM `trackorder` WHERE OrderID = :orderId");
      $trackOrderStmt->bindParam(':orderId', $orderId);
      $trackOrderStmt->execute();

      if ($trackOrderStmt->rowCount() > 0) {
          // Update the existing row in the `trackorder` table
          $stmt = $db->prepare("UPDATE `trackorder` SET ConfirmedDate = NOW() WHERE OrderID = :orderId");
          $stmt->bindParam(':orderId', $orderId);
          $stmt->execute();
      } else {
          // Insert a new row in the `trackorder` table
          $stmt = $db->prepare("INSERT INTO `trackorder` (OrderID, ConfirmedDate) VALUES (:orderId, NOW())");
          $stmt->bindParam(':orderId', $orderId);
          $stmt->execute();
      }

      // Update the `Status` column in the `order data` table
      $updateStatusStmt = $db->prepare("UPDATE `order data` SET Status = :status WHERE OrderID = :orderId");
      $updateStatusStmt->bindParam(':status', $status);
      $updateStatusStmt->bindParam(':orderId', $orderId);
      $updateStatusStmt->execute();

      header("Location: ../ManageOrders/OrderStatus.php");
      exit;
            } else if ($status === 'Ready to Pickup') { 
                                 // Check if the order exists in the `trackorder` table
      $trackOrderStmt = $db->prepare("SELECT OrderID FROM `trackorder` WHERE OrderID = :orderId");
      $trackOrderStmt->bindParam(':orderId', $orderId);
      $trackOrderStmt->execute();

      if ($trackOrderStmt->rowCount() > 0) {
          // Update the existing row in the `trackorder` table
          $stmt = $db->prepare("UPDATE `trackorder` SET ReadyToPickUpDate = NOW() WHERE OrderID = :orderId");
          $stmt->bindParam(':orderId', $orderId);
          $stmt->execute();
      } else {
          // Insert a new row in the `trackorder` table
          $stmt = $db->prepare("INSERT INTO `trackorder` (OrderID, ReadyToPickUpDate) VALUES (:orderId, NOW())");
          $stmt->bindParam(':orderId', $orderId);
          $stmt->execute();
      }

      // Update the `Status` column in the `order data` table
      $updateStatusStmt = $db->prepare("UPDATE `order data` SET Status = :status WHERE OrderID = :orderId");
      $updateStatusStmt->bindParam(':status', $status);
      $updateStatusStmt->bindParam(':orderId', $orderId);
      $updateStatusStmt->execute();

      header("Location: ../ManageOrders/OrderStatus.php");
      exit;
            }
        } else {
            echo "Order not found.";
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
} 
?>