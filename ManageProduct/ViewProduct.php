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
        $deleteStmt = $db->prepare("DELETE FROM `product data` WHERE ProductID IN ($placeholder)");
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
      header("Location: ../ManageProduct/ProductDetails.php?ProductID=<?php echo $productID; ?>");
      exit();
  }
}
// Retrieve the products from the database
$stmt = $db->prepare("SELECT * FROM `product data`");
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
          
          if (isset($_SESSION['un'])) {
              if ($_SESSION['user_role'] == 'Customer') {
                  echo '<a href="../ManageProduct/CProductDetails.php?ProductID=' . $productId . '" name="ProductID[]">';
              } else if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Staff') {
                  echo '<a href="../ManageProduct/CustomerProduct.php?ProductID=<?php echo $productID; ?>" name="ProductID[]">';
              }
          }
          
          echo '<div class="card h-100">
          <div class="product-card" data-product-id="1" onclick="selectProduct(event)">
          <input type="checkbox" name="ProductID[]" value="<?php echo $productId; ?>" />
                  <div class="card-image">
                      <img src="../images/<?php echo $photo; ?>" alt="Product Image" class="product-image" id="product-image">
                  </div>
                  <div class="product-name">Product Name: <?php echo $productName; ?></div>
                  <div class="product-price">Price: BHD <?php echo $price; ?></div>
                  <div class="quantity">
                      <button class="quantity-button minus"><i class="fas fa-minus"></i></button>
                      <input type="number" class="quantity-input" value="1" min="1">
                      <button class="quantity-button plus"><i class="fas fa-plus"></i></button>
                  </div>
                  <button class="add-to-cart-button" data-product-id="<?php echo $productId; ?>">Add to Cart</button>
              </div>
          </div>';
          if (isset($_SESSION['un'])) {
              echo '</a>';
          }
        }
        ?>
      </div>
      <br> <br>
      <button type="submit" name="Vbtn" class="btn">View Details</button>
<button type="submit" name="delaccbtn" class="btn">Delete Product</button>
      <a href="../ManageProduct/AddProduct.php" ><button type="submit" name="addbtn" class="btn">Add Product</button> </a> <br>
     
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function selectProduct(event) {
    if (!event.target.classList.contains('add-to-cart-button')) {
        const checkbox = event.currentTarget.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
    }
}
  </script>
</body>
</html>