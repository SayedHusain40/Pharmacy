<?php
session_start();

if (isset($_GET['OrderID'])) {
  $orderId = $_GET['OrderID'];
  $newTotalPrice = 123.45; // New TotalPrice value
  $newPaymentMethod = 'Credit Card'; // New PaymentMethod value
  $newStatus = 'Pending'; // New Status value

  try {
    include '../Connection/init.php';

    // Update fields in the `Order data` table
    $updateOrderDataSql = "UPDATE `order data`
                           SET TotalPrice = ?, PaymentMethod = ?, Status = ?, OrderDate = NOW(), CreditCardInfo = ?, OrderDetails = ?, MemberShipPoints = ?
                           WHERE OrderID = ?";
    $updateOrderDataStmt = $db->prepare($updateOrderDataSql);
    $updateOrderDataStmt->execute([$newTotalPrice, $newPaymentMethod, $newStatus, $newCreditCardInfo, $newOrderDetails, $newMemberShipPoints, $orderId]);

    // Update fields in the `Ordered item` table
    $updateOrderedItemSql = "UPDATE `ordered item`
                             SET TotalPrice = ?
                             WHERE OrderID = ?";
    $updateOrderedItemStmt = $db->prepare($updateOrderedItemSql);
    $updateOrderedItemStmt->execute([$newTotalPrice, $orderId]);

    // Update fields in the `Payment` table
    $updatePaymentSql = "UPDATE `payment database`
                         SET Total = ?, CreditCardInfo = ?, AccBalance = ?
                         WHERE PaymentID = ?";
    $updatePaymentStmt = $db->prepare($updatePaymentSql);
    $updatePaymentStmt->execute([$newTotalPrice, '123456789', 500, $orderId]);

    echo "Order updated successfully.";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // Close the database connection
  $db = null;
}



?>