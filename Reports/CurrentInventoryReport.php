<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Current Inventory Report</title>
    <link rel="stylesheet" href="../css/Report.css" />
</head>
<body>
    <main>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `product data`");
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-x1-12">
            <h1 style="text-align: center">Current Inventory Report</h1>
                <table>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Membership Points</th>
                            <th>Brand</th>
                        </tr>


        <tbody>
<?php

foreach ($product as $product) {
    $ProductID = $product['ProductID'];
    $Name = $product['Name'];
    $Type = $product['Type'];
    $Quantity = $product['Quantity'];
    $Price = $product['Price'];
    $Points = $product['Points'];
    $Brand = $product['Brand'];

?>
        <tr>
            <td><?php echo $ProductID ?></td>
            <td><?php echo $Name ?></td>
            <td><?php echo $Type ?></td>
            <td><?php echo $Quantity ?></td>
            <td><?php echo $Price ?></td>
            <td><?php echo $Points ?></td>
            <td><?php echo $Brand ?></td>

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

