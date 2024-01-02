<?php
session_start();
include '../header.php';
include '../Connection/init.php';

// Get today's date and time
$CurrentDate = date("Y-m-d");
$currentTime = date("h:i:s");

// Get customer details
$userID =  $_SESSION["user_id"];
$customerQuery = "SELECT CustomerID, UserID, FirstName, Email, MobileNumber, Area, House, Street, Block FROM `Customer data` WHERE UserID = ?";
$customerStatement = $db->prepare($customerQuery);
$customerStatement->execute([$userID]);
$customer = $customerStatement->fetch(PDO::FETCH_ASSOC);


$query = "SELECT od.OrderID, od.UserID, od.TotalPrice, od.PaymentMethod, od.Status, od.OrderDate, od.OrderDetails, oi.ProductID, oi.Qty, oi.TotalPrice AS ItemTotalPrice, oi.TotalPoints, pd.PaymentID, pd.PayDate, pd.Total, pd.ShippingInfo, pd.Details, pd.MembershipPoints, pd.CreditCardInfo, pd.AccBalance, pd.PaymentStatus
          FROM `Order data` AS od
          JOIN `Ordered Item` AS oi ON od.OrderID = oi.OrderID
          JOIN `Payment database` AS pd ON pd.PaymentID = od.PaymentID 
          WHERE od.UserID = ?";
$statement = $db->prepare($query);
$statement->execute([$userID]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

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
    <h3>Date: <?php echo $CurrentDate; ?></h3>
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
            <td><?php echo $customer['FirstName']; ?></td>
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
        <th>Product ID</th>
        <th>Quantity</th>
        <th>Item Total Price</th>
        <th>Total Points</th>
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
    <?php foreach ($result as $row) { ?>
        <tr>
            <td><?php echo $row['OrderID']; ?></td>
            <td><?php echo $row['UserID']; ?></td>
            <td><?php echo $row['TotalPrice']; ?></td>
            <td><?php echo $row['PaymentMethod']; ?></td>
            <td><?php echo $row['Status']; ?></td>
            <td><?php echo $row['OrderDate']; ?></td>
            <td><?php echo $row['OrderDetails']; ?></td>
            <td><?php echo $row['ProductID']; ?></td>
            <td><?php echo $row['Qty']; ?></td>
            <td><?php echo $row['ItemTotalPrice']; ?></td>
            <td><?php echo $row['TotalPoints']; ?></td>
            <td><?php echo $row['PaymentID']; ?></td>
            <td><?php echo $row['PayDate']; ?></td>
            <td><?php echo $row['Total']; ?></td>
            <td><?php echo $row['ShippingInfo']; ?></td>
            <td><?php echo $row['Details']; ?></td>
            <td><?php echo $row['MembershipPoints']; ?></td>
            <td><?php echo $row['CreditCardInfo']; ?></td>
            <td><?php echo $row['AccBalance']; ?></td>
            <td><?php echo $row['PaymentStatus']; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>