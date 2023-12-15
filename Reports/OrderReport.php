<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Orders Report</title>
    <link rel="stylesheet" href="../css/Report.css" />
</head>
<body>
    <main>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `order data`");
$stmt->execute();
$order = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-x1-12">
            <h1 style="text-align: center">Orders Report</h1>
                <table>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Payment ID</th>
                            <th>Total Price</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Account Balance</th>
                            <th>Membership Points</th>
                        </tr>


        <tbody>
<?php

foreach ($order as $order) {
    $OrderID = $order['OrderID'];
    $UserID = $order['UserID'];
    $PaymentID = $order['PaymentID'];
    $TotalPrice = $order['TotalPrice'];
    $paymentMethod = $order['PaymentMethod'];
    $Status = $order['Status'];
    $OrderDate = $order['OrderDate'];
    $AccBalance = $order['AccBalance'];
    $MembershipPoints = $order['MembershipPoints'];

?>
        <tr>
            <td><?php echo $OrderID ?></td>
            <td><?php echo $UserID ?></td>
            <td><?php echo $PaymentID ?></td>
            <td><?php echo $TotalPrice ?></td>
            <td><?php echo $paymentMethod ?></td>
            <td><?php echo $Status ?></td>
            <td><?php echo $OrderDate ?></td>
            <td><?php echo $AccBalance ?></td>
            <td><?php echo $MembershipPoints ?></td>

        <tr>
        <?php } ?>
        </tbody>
        </div>
    </div>
</div>
</table>
<button onclick="window.print()" class="Print">Print</button>
</div>

</main>
</html>

