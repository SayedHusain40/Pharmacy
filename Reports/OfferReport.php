<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Offers Report</title>
    <link rel="stylesheet" href="../css/Report.css" />
</head>
<body>
    <main>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `offers data`");
$stmt->execute();
$offer = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-x1-12">
            <h1 style="text-align: center">Offers Report</h1>
                <table>
                        <tr>
                            <th>Offer ID</th>
                            <th>Product ID</th>
                            <th>Offer Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Discounted Price</th>
                            <th>Original Price</th>
                        </tr>


        <tbody>
<?php

foreach ($offer as $offer) {
    $OfferID = $offer['OfferID'];
    $ProductID = $offer['ProductID'];
    $OfferCode = $offer['OfferCode'];
    $StartDate = $offer['StartDate'];
    $EndDate = $offer['EndDate'];
    $DiscountedPrice = $offer['DiscountedPrice'];
    $OriginalPrice = $offer['OriginalPrice'];

?>
        <tr>
            <td><?php echo $OfferID ?></td>
            <td><?php echo $ProductID ?></td>
            <td><?php echo $OfferCode ?></td>
            <td><?php echo $StartDate ?></td>
            <td><?php echo $EndDate ?></td>
            <td><?php echo $DiscountedPrice ?></td>
            <td><?php echo $OriginalPrice ?></td>

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

