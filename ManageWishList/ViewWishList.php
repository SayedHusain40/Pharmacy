<?php
session_start();
try {
  require("../Connection/init.php");
  include "../header.php";

  //query for view products
  $userID = $_SESSION["user_id"];

  $sql = "SELECT 
  `product data`.*,
  `wish list data`.WID
  FROM 
    `wish list data`
  JOIN 
    `product data` 
  ON 
    `wish list data`.ProductID = `product data`.ProductID
  WHERE 
    `wish list data`.UserID = ?";

  $data = $db->prepare($sql);
  $data->execute([$userID]);
  $count = $data->rowCount();
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wish List</title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    <?php
    //for display Successfully messages
    if (isset($_SESSION['payment_success'])) {
      echo '<div class="success-box" id="successBox">';
      echo '<div> <i class= "success-icon fa-solid fa-circle-check" id="iconX"></i>"Payment successful! 🎉 Thank you for your payment!</div>';
      echo '</div>';
      unset($_SESSION['payment_success']);
    }

    if ($count > 0) {
    ?>
      <div class="HeaderTitle">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../Interface/HomePageCustomer.php">Home Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
          </ol>
        </nav>
        <h3>Your Shopping Cart</h3>
      </div>
      <div class="containerProducts">

        <div class="content">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php
            while ($row = $data->fetch()) {
              $productID = $row["ProductID"];
              $Quantity = $row["Quantity"];
              $categoryName = $row["Type"];

              date_default_timezone_set('Asia/Bahrain');
              $currentDate = date("Y-m-d");

              $stmt = $db->prepare("SELECT DiscountedPrice FROM `offers data` WHERE ProductID = ? 
                      AND StartDate <= ? AND EndDate >= ?");
              $stmt->execute([$productID, $currentDate, $currentDate]);

              $result = $stmt->fetch();
              $countOffer = $stmt->rowCount();

              // echo  $countOffer;

              $name = $row["Name"];
              $price = $row["Price"];
              $Photo = $row["Photo"];
              $Availability = $row["Availability"];
            ?>
              <div class="col">
                <div class="card card-color:red">
                  <div class="cartImag">
                    <img src="../images/<?php echo $Photo ?>" class="card-img-top w-50 mx-auto d-block">
                  </div>
                  <div class="card-body">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                      $userID = $_SESSION['user_id'];
                    ?>
                      <div class="HeartDiv">
                        <?php
                        // check for if product already in wish list
                        $check = $db->prepare("SELECT * FROM `wish list data` WHERE ProductID = ? And UserID = ?");
                        $check->execute([$productID, $userID]);
                        $checkResult = $check->rowCount();
                        $dataWishList = $check->fetch();

                        // Insert and delete in wishlist
                        ?>
                        <a href="#" class="wishlist-action" data-wishlist-id="<?php echo $dataWishList["WID"] ?>">
                          <i id="HeartIcon" class="fa-solid fa-circle-xmark"></i>
                        </a>
                      </div>
                    <?php
                    } else {
                    ?>
                      <div class="HeartDiv">
                        <a href="#" tabindex="0" data-bs-toggle="modal" data-bs-target="#alertModal">
                          <i class="fa-regular fa-heart" id="HeartIcon2"></i>
                        </a>
                      </div>

                      <!-- Modal -->
                      <div class="modal" id="alertModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" style="color: #0288d1;">Important!</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="font-size: large;">
                              "Please Log In to add this product to your wishlist Cart."
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php
                    }

                    if ($countOffer > 0) {
                      $DiscountedPrice = $result["DiscountedPrice"];
                      $percentage = round((($price - $DiscountedPrice) / $price) * 100, 1);
                    ?>
                      <div class="offer"> <?php echo $percentage . "%" ?> </div>
                    <?php
                    }
                    ?>

                    <span><?php echo $categoryName ?></span>
                    <h5 class="card-title"><?php echo $name ?></h5>
                    <?php
                    if ($countOffer === 0) {
                    ?>
                      <p class="card-text nowPrice"><?php echo "BHD" . $price ?></p>
                    <?php
                    } else {
                      $DiscountedPrice = $result["DiscountedPrice"];
                    ?>
                      <p class="card-text discountPrice">
                        <span>
                          <span class="originalPrice"><?php echo "BHD" . $price ?></span>
                          <span class="line"></span>
                        </span>
                        <span class="nowPrice"><?php echo "BHD" . $DiscountedPrice ?></span>
                      </p>
                    <?php
                    }
                    $maxValue = min(24, $Quantity);
                    ?>
                    <div class="inputQtyContainer">
                      <button class="btnMins" id="decreaseQty"><i class="fas fa-minus"></i></button>
                      <input type="number" class="custom-number-input" id="quantity" value="1" min="1" max="<?php echo $maxValue ?>" productID=<?php echo $productID ?>>
                      <button class="btnPlus" id="increaseQty"><i class="fas fa-plus"></i></button>
                    </div>

                    <?php

                    if (isset($_SESSION['user_id'])) {
                      if ($Availability === 1) {
                    ?>
                        <button type="button" onclick="addToCart(<?php echo $productID ?>)" class="btn btn-outline-primary w-100 d-block mx-auto">Add to Cart</button>
                      <?php
                      } else {
                      ?>
                        <button id="outOfStock" type="button" class="btn btn-outline-primary w-100 d-block mx-auto" style="pointer-events: none; filter: none; background-color:#eee;
                      border-color:#ddd; color:#333;">
                          Out Of Stock
                        </button>
                      <?php
                      }
                    } else {
                      ?>
                      <button type="button" class="btn btn-outline-primary w-100 d-block mx-auto" data-bs-toggle="modal" data-bs-target="#cartModal">
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

                    ?>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    <?php
    } else {
    ?>
      <h1>Not Found Products</h1>
    <?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../js/editWishList.js"></script>
    <script>
      const quantityInputs = document.querySelectorAll('.custom-number-input');
      const increaseQtyBtns = document.querySelectorAll('.btnPlus');
      const decreaseQtyBtns = document.querySelectorAll('.btnMins');

      // Function to increase quantity when the plus button is clicked
      increaseQtyBtns.forEach((button, index) => {
        button.addEventListener('click', () => {
          const currentValue = parseInt(quantityInputs[index].value);
          const maxValue = parseInt(quantityInputs[index].getAttribute('max')); // Get the max value from the attribute

          if (currentValue < maxValue) {
            quantityInputs[index].value = currentValue + 1;
          }
        });
      });

      // Function to decrease quantity when the minus button is clicked
      decreaseQtyBtns.forEach((button, index) => {
        button.addEventListener('click', () => {
          const currentValue = parseInt(quantityInputs[index].value);

          if (currentValue > 1) {
            quantityInputs[index].value = currentValue - 1;
          }
        });
      });


      // Function to validate the quantity
      function isValidQuantity(quantity, maxValue) {
        return !isNaN(quantity) && parseInt(quantity) > 0 && parseInt(quantity) <= maxValue;
      }

      // add To Cart
      function addToCart(productID) {
        const quantityInput = document.querySelector(`input[productID='${productID}']`);
        const quantity = quantityInput.value;
        const maxValue = parseInt(quantityInput.getAttribute('max'));

        if (!isValidQuantity(quantity, maxValue)) {
          alert(`Please enter a valid quantity (From 1 up to ${maxValue})`);
          return;
        }

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

      document.getElementById("outOfStock").disabled = true;
    </script>
    <script>
      //remove Items
      function removeFromWishlist(clickedElement) {
        const productBox = clickedElement.closest('.col');
        const wishlistId = clickedElement.closest('.wishlist-action').dataset.wishlistId;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../ManageWishList/DeleteWishList.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        const wID = `WID=${wishlistId}`;

        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              console.log('Item removed from wishlist!');
              productBox.remove(); // Remove the entire product box container
            } else {
              console.error('Failed to remove item from wishlist');
            }
          }
        };

        xhr.send(wID);
      }
      // Get all the x icons
      const xIcons = document.querySelectorAll('.fa-circle-xmark');
      xIcons.forEach(icon => {
        icon.addEventListener('click', function(event) {
          event.preventDefault();
          removeFromWishlist(this);
        });
      });
    </script>
  </body>

  </html>
<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>