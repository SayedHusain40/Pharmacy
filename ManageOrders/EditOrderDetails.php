<?php
session_start();
include '../header.php';
include '../Connection/init.php';

// Get today's date and time
$todayDate = date("Y-m-d");
$currentTime = date("H:i:s");

// Get customer details
$userID =  $_SESSION["user_id"];
$customerQuery = "SELECT CustomerID, UserID, FirstName, LastName, Email, MobileNumber, Area, House, Street, Block FROM `Customer data` WHERE UserID = ?";
$customerStatement = $db->prepare($customerQuery);
$customerStatement->execute([$userID]);
$customer = $customerStatement->fetch(PDO::FETCH_ASSOC);

// Get order details
$orderUserID = $customer['UserID']; // Assuming you want to retrieve orders for the same customer
$orderDetailsQuery = "SELECT OrderID, UserID, TotalPrice, PaymentMethod, Status, OrderDate, OrderDetails FROM `Order data` WHERE UserID = ?";
$orderDetailsStatement = $db->prepare($orderDetailsQuery);
$orderDetailsStatement->execute([$orderUserID]);
$orderDetails = $orderDetailsStatement->fetchAll(PDO::FETCH_ASSOC);

// Get ordered item details
$orderedItemQuery = "SELECT ProductID, Qty, TotalPrice, TotalPoints FROM `Ordered item` WHERE OrderID = ?";
$orderedItemStatement = $db->prepare($orderedItemQuery);

// Get payment details
$paymentQuery = "SELECT PaymentID, PayDate, Total, ShippingInfo, Details, MembershipPoints, CreditCardInfo, AccBalance, PaymentStatus FROM `Payment database` WHERE PaymentID = ?";
$paymentStatement = $db->prepare($paymentQuery);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy - Order Details Report</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Pharmacy - Order Details Report</h1>
    <h3>Date: <?php echo $todayDate; ?></h3>
    <h3>Time: <?php echo $currentTime; ?></h3>

    <h2>Customer Details</h2>
    <table>
        <tr>
            <th>Customer Name</th>
            <th>Customer ID</th>
            <th>User ID</th>
            <th>E-mail</th>
            <th>Mobile Number</th>
            <th>Address</th>
        </tr>
        <tr>
            <td><?php echo $customer['FirstName'] . ' ' . $customer['LastName']; ?></td>
            <td><?php echo $customer['CustomerID']; ?></td>
            <td><?php echo $customer['UserID']; ?></td>
            <td><?php echo $customer['Email']; ?></td>
            <td><?php echo $customer['MobileNumber']; ?></td>
            <td><?php echo $customer['Area'] . ', ' . $customer['House'] . ', ' . $customer['Street'] . ', ' . $customer['Block']; ?></td>
        </tr>
    </table>

    <h2>Order Details Report</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Order Details</th>
        </tr>
        <?php foreach ($orderDetails as $order) { ?>
            <tr>
                <td><?php echo $order['OrderID']; ?></td>
                <td><?php echo $order['UserID']; ?></td>
                <td><?php echo $order['TotalPrice']; ?></td>
                <td><?php echo $order['PaymentMethod']; ?></td>
                <td><?php echo $order['Status']; ?></td>
                <td><?php echo $order['OrderDate']; ?></td>
                <td><?php echo $order['OrderDetails']; ?></td>
            </tr>

            <tr>
                <td colspan="7">
                    <h3>Ordered Item Details</h3>
                    <table>
                        <tr>
                            <th>Product ID</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Total Points</th>
                        </tr>
                        <?php
                        $orderID = $order['OrderID'];
                        $orderedItemStatement->execute([$orderID]);
                        $orderedItems = $orderedItemStatement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($orderedItems as $item) {
                            ?>
                            <tr>
                                <td><?php echo $item['ProductID']; ?></td>
                                <td><?php echo $item['Qty']; ?></td>
                                <td><?php echo $item['TotalPrice']; ?></td>
                                <td><?php echo $item['TotalPoints'];
                                ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
    
                <tr>
                    <td colspan="7">
                        <h3>Payment Details</h3>
                        <table>
                            <tr>
                                <th>Payment ID</th>
                                <th>Payment Date</th>
                                <th>Total Amount</th>
                                <th>Shipping Information</th>
                                <th>Details</th>
                                <th>Membership Points</th>
                                <th>Credit Card Information</th>
                                <th>Account Balance</th>
                                <th>Payment Status</th>
                            </tr>
                            <?php
                            $paymentStatement->execute([$orderID]);
                            $payments = $paymentStatement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($payments as $payment) {
                                ?>
                                <tr>
                                    <td><?php echo $payment['PaymentID']; ?></td>
                                    <td><?php echo $payment['PayDate']; ?></td>
                                    <td><?php echo $payment['Total']; ?></td>
                                    <td><?php echo $payment['ShippingInfo']; ?></td>
                                    <td><?php echo $payment['Details']; ?></td>
                                    <td><?php echo $payment['MembershipPoints']; ?></td>
                                    <td><?php echo $payment['CreditCardInfo']; ?></td>
                                    <td><?php echo $payment['AccBalance']; ?></td>
                                    <td><?php echo $payment['PaymentStatus']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </body>
    </html> 
