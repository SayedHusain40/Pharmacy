<?php
session_start();
try {
  require("../Connection/init.php");

  $query = "SELECT * FROM `product data`";

  $data = $db->prepare($query);
  $data->execute();
  $count = $data->rowCount();

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Offer</title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
      input[type='range']::-webkit-slider-runnable-track {
        background-color: #3498db;
        height: 9px;
      }

      input[type='range']::-moz-range-track {
        background-color: #3498db;
        height: 9px;
      }
    </style>
  </head>

  <body>
    <?php
    include "../header.php";


    ?>
    <div class="HeaderTitle">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../Interface/HomePageAdmin.php">Home Page</a></li>
          <li class="breadcrumb-item active" aria-current="page">Offers</li>
        </ol>
      </nav>
      <h3>Offers</h3>
    </div>
    <div class="containerProducts">

      <?php

      if ($count > 0) {
      ?>
        <div class="content">
          <div style="max-width: 300px;">
            <span>
              <span class="SearchSpan">
                <input type="search" id="searchInput" placeholder="Search for products by name">
                <i class="fa-solid fa-magnifying-glass"></i>
              </span>
            </span>
          </div>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            while ($row = $data->fetch()) {
              $productID = $row["ProductID"];
              $Quantity = $row["Quantity"];
              $Brand = $row["Brand"];
              $categoryName = $row["Type"];

              date_default_timezone_set('Asia/Bahrain');
              $currentDate = date("Y-m-d");

              $stmt = $db->prepare("SELECT DiscountedPrice FROM `offers data` WHERE ProductID = ? 
                      AND StartDate <= ? AND EndDate >= ?");
              $stmt->execute([$productID, $currentDate, $currentDate]);

              $result = $stmt->fetch();
              $countOffer = $stmt->rowCount();

              $name = $row["Name"];
              $price = $row["Price"];
              $Photo = $row["Photo"];
              $Availability = $row["Availability"];
              if ($countOffer > 0) {

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
                          <a href="#" class="wishlist-action" data-product-id="<?php echo $productID; ?>" data-wishlist-id="<?php echo isset($dataWishList["WID"]) ? $dataWishList["WID"] : ''; ?>">
                            <i id="HeartIcon" class="<?php echo isset($dataWishList["WID"]) ? 'fa-solid' : 'fa-regular'; ?> fa-heart"></i>
                          </a>
                        </div>
                      <?php
                      } else {
                      ?>
                        <div class="HeartDiv">
                          <a href="#" tabindex="0" data-bs-toggle="modal" data-bs-target="#alertModal_<?php echo $productID ?>">
                            <i class="fa-regular fa-heart" id="HeartIcon2"></i>
                          </a>
                        </div>

                        <!-- Modal -->
                        <div class="modal" id="alertModal_<?php echo $productID ?>" tabindex="-1">
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

                      <span><?php echo $categoryName . ", " . $Brand ?></span>
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
                        <button type="button" class="btn btn-outline-primary w-100 d-block mx-auto" data-bs-toggle="modal" data-bs-target="#cartModal_<?php echo $productID ?>">
                          Add to Cart
                        </button>

                        <!-- Modal -->
                        <div class="modal" id="cartModal_<?php echo $productID ?>" tabindex="-1">
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
            }
            ?>
          </div>
        </div>

      <?php
      } else {
      ?>
        <h3 style="width: 100%; margin: 10px">Not Found Products</h3>
      <?php
      }
      ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../js/editWishList.js"></script>

    <script>
      //for open filter div
      const filterDiv = document.getElementById('showFilterDiv');
      const filterIcon = document.getElementById('filterIcon');
      const closeFilter = document.querySelector('.filter .closeFilter');
      filterIcon.addEventListener('click', function() {
        filterDiv.classList.toggle('open');
      });
      closeFilter.addEventListener('click', function() {
        filterDiv.classList.toggle('open');
      });

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

        // Hide the success box after 3 seconds
        setTimeout(() => {
          successBox.style.display = 'none';
        }, 3000);
      }


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

      // Function to sort products based on user selection
      function sortProducts(select) {
        const selectedOption = select.value;

        window.location.href = `OfferPage.php?Category=<?php echo $categoryName ?>&sort=${selectedOption}`;
      }
    </script>
    <script>
      //for Search
      const searchInput = document.getElementById('searchInput');
      const cols = document.querySelectorAll('.col'); // Select elements with class name 'col'

      searchInput.addEventListener('input', function(event) {
        const searchQuery = event.target.value.trim().toLowerCase(); // Get the input value in lowercase

        cols.forEach(col => {
          const productName = col.querySelector('.card-title').textContent.toLowerCase();

          // Check if the product name includes the search query
          if (productName.includes(searchQuery)) {
            col.style.display = 'block';
          } else {
            col.style.display = 'none';
          }
        });
      });

      //validation range price
      function updateMaxPrice() {
        const minPriceInput = document.getElementById('minPrice');
        const maxPriceInput = document.getElementById('maxPrice');

        // Ensure the max price is not less than the min price
        if (parseInt(maxPriceInput.value) < parseInt(minPriceInput.value)) {
          maxPriceInput.value = minPriceInput.value;
        }
      }

      function validatePriceRange() {
        const minPriceInput = document.getElementById('minPrice');
        const maxPriceInput = document.getElementById('maxPrice');

        // Ensure the max price is not less than the min price
        if (parseInt(maxPriceInput.value) < parseInt(minPriceInput.value)) {
          alert("Maximum price cannot be less than minimum price!");
          return false; // Prevent form submission
        }
        return true; // Allow form submission
      }
    </script>
  </body>

  </html>
<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>