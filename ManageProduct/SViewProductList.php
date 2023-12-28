<?php
session_start();

include '../Connection/init.php';

// Check if the "Delete Product" button is clicked
if (isset($_POST['delaccbtn'])) {
    // Check if any products are selected for deletion
    if (isset($_POST['ProductID']) && is_array($_POST['ProductID'])) {
        $productIds = $_POST['ProductID'];

        // Prepare the placeholder string for the IN clause
        $placeholder = str_repeat('?,', count($productIds) - 1) . '?';

        // Delete the selected products from the database
        $deleteStmt = $db->prepare("DELETE FROM `sproduct data` WHERE ProductID IN ($placeholder)");
        $deleteStmt->execute($productIds);

        // Redirect to the same page to see the updated product list
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
if (isset($_POST['Vbtn'])) {
  // Check if any products are selected for viewing details
  if (isset($_POST['ProductID']) && is_array($_POST['ProductID'])) {
      $productIds = $_POST['ProductID'];
      $urlParams = implode(',', $productIds);
      header("Location: ../ManageProduct/SProductDetails.php?ProductID=" . $urlParams);
      exit();
  }
}
// Retrieve the products from the database
$stmt = $db->prepare("SELECT * FROM `sproduct data`");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if the selected product IDs array is set
$selectedProductIds = isset($_POST['ProductID']) ? $_POST['ProductID'] : [];
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
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
          <a href="../ManageProduct/SProductDetails.php?ProductID=' . $productId . '" name="ProductID[]">
           <div class="card h-100">
              <div class="product-card" data-product-id="1">
              <input type="checkbox" name="ProductID[]" value="'. $productId .'" />
                  <div class="card-image">
                      <img src="../Simages/' . $photo . '" alt="Product Image" class="product-image" id="product-image">
                  </div>
                  <div class="product-name">Product Name: ' . $productName . '</div>
                  <div class="product-price">Price: BHD ' . $price . '</div>
                  <div class="quantity">
                      <button class="quantity-button minus"><i class="fas fa-minus"></i></button>
                      <input type="number" class="quantity-input" value="1" min="1">
                      <button class="quantity-button plus"><i class="fas fa-plus"></i></button>
                  </div>
                  <button class="add-to-cart-button" data-product-id="' . $productId . '">Add to Cart</button>
              </div>
            </div>
          </a>
          ';
        }
        ?>
      </div>
      <br> <br>
      <button type="submit" name="Vbtn">View Details</button>
      <button type="submit" name="delaccbtn" class="btn">Delete Product</button>
      <a href="../ManageProduct/SAddProduct.php" ><button type="submit" name="addbtn" class="btn">Add Product</button> </a>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>