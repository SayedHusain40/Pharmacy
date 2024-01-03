<?php
session_start();
include '../header.php';
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `product data`");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$lowestQuantity = 20; // Initialize the lowest quantity with a high value

// Find the lowest quantity among the products
foreach ($products as $product) {
    if ($product['Quantity'] < $lowestQuantity) {
        $lowestQuantity = $product['Quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/Admin.css">
    <style>
        body {
            background-image: url("../images/b1.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    <title> Home Page Admin </title>
</head>
<body>
    <h1>Welcome <?php echo $_SESSION['un']; ?></h1>
    <h1>Low Stock Items</h1>
    <?php if (!empty($products)) { ?>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <?php if ($product['Quantity'] == $lowestQuantity) { ?>
                        <tr>
                            <td><?php echo $product['Name']; ?></td>
                            <td><?php echo $product['Quantity']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No products found.</p>
    <?php } ?>

    <h1>Items Sold Today</h1>
    <p>Integer number</p>
    <h1>Month Best Seller</h1>
    <p>x(25)</p>

   
</body>
</html>