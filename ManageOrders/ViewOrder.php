<?php
session_start();
include '../header.php';
include '../Connection/init.php';

$stmt = $db->prepare("
    SELECT od.*, oi.ProductID, oi.Qty, oi.TotalPrice
    FROM `order data` od
    LEFT JOIN `ordered item` oi ON od.OrderID = oi.OrderID
");
$stmt->execute();
$orderData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Display all order data and associated products -->
<?php if (!empty($orderData)): ?>
  <h1>All Orders</h1>
  <?php foreach ($orderData as $order): ?>
    <h2>Order ID: <?php echo $order['OrderID']; ?></h2>
    <table>
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Quantity</th>
          <th>Total Price</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orderData as $item): ?>
          <?php if ($item['OrderID'] == $order['OrderID']): ?>
            <tr>
              <td><?php echo $item['ProductID']; ?></td>
              <td><?php echo $item['Qty']; ?></td>
              <td><?php echo $item['TotalPrice']; ?></td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endforeach; ?>
<?php else: ?>
  <p>No order data found.</p>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    html{
    height: 100%;
  }
  body{
    font-family: arial;
    background-image: url('../images/order.gif');
    background-repeat: no-repeat;
    background-size: cover;
    margin: 0 auto;
  }

</style>
</head>
<body>


 
</body>
</html>
