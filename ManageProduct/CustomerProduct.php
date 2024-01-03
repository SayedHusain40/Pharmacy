<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/Pdetails.css" />
</head>
<body>
    


<?php
session_start();

include '../Connection/init.php';

// Check if the productid parameter exists in the URL
if (isset($_GET['ProductID'])) {
    $productIds = $_GET['ProductID'];

    // Convert the product IDs into an array
    $productIds = explode(',', $productIds);

    // Iterate over the product IDs
    foreach ($productIds as $productId) {
        // Retrieve the product details based on the productid
        $stmt = $db->prepare("SELECT * FROM `product data` WHERE ProductID = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the product exists
        if ($product) {
            // Display the product details or perform any other desired actions
            $productName = $product['Name'];
            $productType = $product['Type'];
            $requiresPrescription = $product['RequiresPrescription'];
            $description = $product['Description'];
            $expireDate = $product['ExpireDate'];
            $quantity = $product['Quantity'];
            $availability = $product['Availability'];
            $price = $product['Price'];
            $points = $product['Points'];
            $brand = $product['Brand'];
            $photo = $product['Photo'];
            $alternate = $product['Alternate'];

            // Display the product details on the page or perform any other desired actions
            echo '
            <section class="product">
            <div class="product__photo">
            <div class="photo-container">
                <div class="photo-main">
                    <img src="../images/' . $photo . '">
                </div>
            </div>
        </div>
        <div class="product__info">
		<div class="title">
			<h1>'. $productName .'</h1>
			<span>ID: '.$productId.'</span>
		</div>
        <div class="price">
        BD <span>' . $price . '</span>
    </div>
        <div class="description">
			<h3>Detals</h3>
			<ul>
				<li>Name: ' .$productName. '</li>
				<li>Type: ' .$productType. ' </li>
				<li>Expiration Date: '. $expireDate .  '</li>
				<li>Quantity: ' . $quantity . '</li>    
                <li>Points: ' . $points . ' </li>
			</ul>
		</div>
		<button class="buy--btn">ADD TO CART</button>
	</div>
    </section>
        
        '; // Add a horizontal line between each product
        } else {
            // Product not found
            echo 'Product with ID ' . $productId . ' not found.<br>';
        }
    }
} else {
    // productid parameter is missing
    echo 'Invalid request.';
}
?>

</body>
</html>
