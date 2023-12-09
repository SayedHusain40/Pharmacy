<?php
session_start();

include '../Connection/init.php';

$userId = $_SESSION['user_id'];
$productId = isset($_POST['productId']) ? $_POST['productId'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

if ($productId) {
    try {
        // Retrieve the product price from the database
        $stmt = $db->prepare("SELECT Price FROM `product data` WHERE ProductID = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        $product = $stmt->fetch();

        if ($product) {
            $totalPrice = $product['Price'] * $quantity;

            // Check if the user already has an active cart
            $stmt = $db->prepare("SELECT CartID FROM `view cart` WHERE UserID = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $cartId = $stmt->fetchColumn();

            if (!$cartId) {
                // User doesn't have an active cart, create a new one
                $stmt = $db->prepare("INSERT INTO `view cart` (UserID, ProductID, Qty, Total, AddedDate)
                VALUES (:userId, :productId, :quantity, :totalPrice, CURDATE())");
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':productId', $productId);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':totalPrice', $totalPrice);
                $stmt->execute();

                // Get the newly created cart ID
                $cartId = $db->lastInsertId();
            } else {
                // Check if the product already exists in the cart
                $stmt = $db->prepare("SELECT * FROM `view cart` WHERE CartID = :cartId AND ProductID = :productId");
                $stmt->bindParam(':cartId', $cartId);
                $stmt->bindParam(':productId', $productId);
                $stmt->execute();
                $existingProduct = $stmt->fetch();

                if ($existingProduct) {
                    // Product already exists in the cart, update the quantity and total price
                    $stmt = $db->prepare("UPDATE `view cart` SET Qty = Qty + :quantity, Total = Total + :totalPrice WHERE CartID = :cartId AND ProductID = :productId");
                    $stmt->bindParam(':cartId', $cartId);
                    $stmt->bindParam(':productId', $productId);
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':totalPrice', $totalPrice);
                    $stmt->execute();
                } else {
                    // Product doesn't exist in the cart, insert a new row
                    $stmt = $db->prepare("INSERT INTO `view cart` (CartID, UserID, ProductID, Qty, Total, AddedDate)
                    VALUES (:cartId, :userId, :productId, :quantity, :totalPrice, CURDATE())");
                    $stmt->bindParam(':cartId', $cartId);
                    $stmt->bindParam(':userId', $userId);
                    $stmt->bindParam(':productId', $productId);
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':totalPrice', $totalPrice);
                    $stmt->execute();
                }
            }

            echo 'Product added to cart successfully';
        } else {
            echo 'Product not found';
        }
    } catch (Exception $e) {
        echo 'Error adding product to cart: ' . $e->getMessage();
    }
}
?>