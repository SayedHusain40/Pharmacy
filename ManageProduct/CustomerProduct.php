<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="../css/Pdetails.css" />
  <link rel="stylesheet" href="../css/all.min.css" />

</head>

<body>



  <?php
  session_start();
  include '../Connection/init.php';

  //for display Successfully messages
  if (isset($_SESSION['payment_success'])) {
    echo '<div class="success-box" id="successBox">';
    echo '<div> <i class= "success-icon fa-solid fa-circle-check" id="iconX"></i>"Payment successful! 🎉 Thank you for your payment!</div>';
    echo '</div>';
    unset($_SESSION['payment_success']);
  }

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
			<h1>' . $productName . '</h1>
			<span>ID: ' . $productId . '</span>
		</div>
        <div class="price">
        BD <span>' . $price . '</span>
    </div>
        <div class="description">
			<h2>Details</h2>
			<ul>
				<li>Name: ' . $productName . '</li>
				<li>Type: ' . $productType . ' </li>
				<li>Expiration Date: ' . $expireDate .  '</li>
				<li>On Stock: ' . $quantity . '</li>    
                <li>Points: ' . $points . ' </li>
			</ul>
		</div>
        ';
  ?>



        <!-- <button class="buy--btn" onclick="addToCart('.$productId.')">ADD TO CART</button> -->
        <?php
        if ($availability === 1) {
          date_default_timezone_set('Asia/Bahrain');
          $currentDate = date("Y-m-d");
          if ($expireDate <= $currentDate) {
        ?>
            <button id="outOfStock" type="button" class="buy--btn">
              Out Of Stock
            </button>
            <?php
          } else {
            if (isset($_SESSION['user_id'])) {
            ?>
              <button type="button" onclick="addToCart(<?php echo $productId ?>)" qty=<?php echo $quantity / $quantity ?> class="buy--btn addToCart">Add to Cart</button>
            <?php
            } else {
            ?>
              <button type="button" class="buy--btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                Add to Cart
              </button>

              <!-- Modal -->
              <div class="modal" id="cartModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" style="color: #0288d1;">Important!</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-size: large;">
                      "Please Log In to add this product to your Shopping Cart."
                    </div>
                  </div>
                </div>
              </div>
          <?php
            }
          }
        } else {
          ?>
          <button id="outOfStock" class="buy--btn">
            Out Of Stock
          </button>
  <?php
        }



        echo '
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

  <script>
    //for hiding Successfully  message 
    let iconX = document.getElementById('iconX');
    let successBox = document.getElementById('successBox');

    // Hide the success box after 3 seconds
    setTimeout(hideSuccessBox, 3000);

    //display Success Message
    function displaySuccessMessage() {
      const successBox = document.createElement('div');
      successBox.className = 'success-box';
      successBox.id = 'successBox';

      const successMessage = document.createElement('div');
      successMessage.innerHTML = '<i class="success-icon fa-solid fa-check"></i> Successfully Added To Cart!';

      successBox.appendChild(successMessage);
      document.body.appendChild(successBox);

      // Hide the success box after 5 seconds
      setTimeout(() => {
        successBox.style.display = 'none';
      }, 5000);
    }

    // add To Cart
    function addToCart(productID) {
      console.log(productID);
      const button = document.querySelector(".addToCart");
      const quantity = button.getAttribute('qty');

      const xhr = new XMLHttpRequest();
      xhr.open("POST", "../ManageShoppingCart/AddToCart.php");
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      const data = `quantity=${quantity}&productID=${productID}`;
      xhr.send(data);

      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            displaySuccessMessage(); // Call the function to display the success message
          } else {
            console.error('Error adding to cart');
          }
        }
      };
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>