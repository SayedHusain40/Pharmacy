<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <style>
        th {
  border-top: 2px solid black;
  border-bottom: 2px solid black;
        }
        table, th, tr, td {
            padding: 2px ;
        }
      </style>
</head>
<body>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `order data`");
$stmt->execute();
$order = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
    <div class="col-x1-12">
        <h1>+ Processing</h1>
                <table>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Details</th>
                            <th>Total Price</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th>Order Date</th>
                            <th>Details</th>
                            
                        </tr>

        <tbody>
<?php

foreach ($order as $order) {
    $OrderID = $order['OrderID'];
    $TotalPrice = $order['TotalPrice'];
    $paymentMethod = $order['PaymentMethod'];
    $Status = $order['Status'];
    $OrderDate = $order['OrderDate'];
    $OrderDetails = $order['OrderDetails'];
?>
        <tr>
            <td><?php echo $OrderID ?></td>
            <td><?php echo $OrderDetails ?></td>
            <td><?php echo $TotalPrice ?></td>
            <td><?php echo $paymentMethod ?></td>
            <td><?php echo $Status ?></td>
            <td><i class="fas fa-sync"></i></td>
            <td><?php echo $OrderDate ?></td>
            <td><i class="fas fa-info-circle"></i></td>
        <tr>
        <?php } ?>
        </tbody>
        </div>
    </div>
</div>
</table>
</div>
</html>

