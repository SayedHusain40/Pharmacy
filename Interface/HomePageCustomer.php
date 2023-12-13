<?php
session_start();
include '../header.php';
?>
<?php
include '../Connection/init.php';

$sql = "SELECT * FROM `product data`";
$all_product = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);  // Fetch all rows as an associative array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylecus.css">
    <title>Document</title>
    <style>
        body {
            background-image: url("../images/b1.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <main>
        <?php
        foreach ($all_product as $row) {  // Iterate over each row of the result set
        ?>
            <div class="card">
                <div class="image">
                    <img src="<?php echo $row["Photo"]; ?>" alt="">
                </div>
                <div class="caption">
                    <p class="product_name"><?php echo $row["Name"]; ?></p>
                    <p class="price"><b>$<?php echo $row["Price"]; ?></b></p>
                </div>
                <button class="add" data-id="<?php echo $row["ProductID"]; ?>">Add to cart</button>
            </div>
        <?php
        }
        ?>
    </main>
</body>
</html>