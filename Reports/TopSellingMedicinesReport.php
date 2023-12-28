<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Top Selling Item Report</title>
    <link rel="stylesheet" href="../css/Report.css" />
</head>
<body>
    <main>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare( "SELECT
`ordered item`.ProductID,
`Product data`.Name,
`Product data`.Price,
SUM(`ordered item`.Qty) AS Total_Sold_Quantity
FROM
`ordered item`
JOIN
`Product data` ON `ordered item`.ProductID = `Product data`.ProductID
GROUP BY `ordered item`.ProductID, `Product data`.Name, `Product data`.Price
ORDER BY
Total_Sold_Quantity DESC");

$stmt->execute();
$top = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-x1-12">
            <h1 style="text-align: center">Top Selling Items Report</h1>
                <table>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Total Sold Quantity</th>
                            <th>Product Price</th>
                        </tr>


        <tbody>
<?php

foreach ($top as $top) {
    $ProductID = $top['ProductID'];
    $Name = $top['Name'];
    $TotalSoldQuantity = $top['Total_Sold_Quantity'];
    $Price = $top['Price'];

?>
        <tr>
            <td><?php echo $ProductID ?></td>
            <td><?php echo $Name ?></td>
            <td><?php echo $TotalSoldQuantity ?></td>
            <td><?php echo $Price ?></td>

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

