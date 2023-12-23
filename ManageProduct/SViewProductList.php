<?php
session_start();

include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `product data`");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/add.css" />
  <style>
    body {
      background-image: url("../images/m.jpg");
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>
<body>
  <div class="Container">
    <div class="col mb-4">
      <?php
      foreach ($products as $product) {
        $productId = $product['ProductID'];
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
        echo '
        <div class="card h-100">
          <div class="product-card" data-product-id="1">
            <div class="card-image">
              <img src="../images/'. $photo .'" alt="Product Image" class="product-image" id="product-image">
            </div>
            <div class="product-name">Product Name: '. $productName .'</div>
            <div class="product-price">Price: BHD '. $price.'</div>
            <div class="quantity">
              <button class="quantity-button minus"><i class="fas fa-minus"></i></button>
              <input type="number" class="quantity-input" value="1" min="1">
              <button class="quantity-button plus"><i class="fas fa-plus"></i></button>
            </div>
            <button class="view-details-btn" data-product-id="' . $productId . '">View Details</button>
            <button class="add-to-cart-button" data-product-id="' . $productId . '">Add to Cart</button>
          </div>
        </div>
        ';
      }
      ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.view-details-btn').click(function() {
        var productId = $(this).closest('.product-card').data('product-id');
        retrieveProductDetails(productId);
      });
    });

    function retrieveProductDetails(productId) {
      $.ajax({
        url: '../ManageProduct/SEditProduct.php',
        method: 'POST',
        data: { productId: productId },
        success: function(response) {
          // Handle the response from the server
          var product = JSON.parse(response);
          // Do something with the product data
          console.log(product);
        },
        error: function() {
          console.log('Error occurred while retrieving product details.');
        }
      });
    }
  </script>
</body>
</html>