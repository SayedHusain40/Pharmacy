<?php
session_start();
try {
  require("../Connection/init.php");

  // Check if the Reset All button was clicked and unset session 
  if (isset($_GET['ResetAll'])) {
    unset($_SESSION['sortingOrder']);
    header('Location: ProductByBrand.php');
    exit;
  }

  // Check and store selected filters in session 
  if (isset($_GET["Brand"])) {
    $_SESSION['brandName'] = $_GET["Brand"];
  }

  if (isset($_GET['sort'])) {
    if ($_GET['sort'] === "Default") {
      unset($_SESSION['sortingOrder']); // Remove the sorting order session variable for "Default"
    } else {
      $_SESSION['sortingOrder'] = "Price " . $_GET['sort']; // Set the sorting order session variable for other options
    }
  }


  // Initialize the base query
  $query = "SELECT * FROM `product data` WHERE Brand = ?";

  // Use session variables if they exist
  $brandName = isset($_SESSION['brandName']) ? $_SESSION['brandName'] : null;
  $sortingOrder = isset($_SESSION['sortingOrder']) ? $_SESSION['sortingOrder'] : "ProductID";

  // Initialize the parameters array
  $exc = [$brandName];

  // Add conditions based on the filters
  if (isset($_GET['Category'])) {
    $selectedCategory = $_GET['Category'];
    $query .= " AND Type = ?";
    $exc[] = $selectedCategory;
  }

  if (isset($_GET['minPrice']) && isset($_GET['maxPrice'])) {
    // Retrieve the min and max prices from the submitted form
    $minPriceFilter = $_GET['minPrice'];
    $maxPriceFilter = $_GET['maxPrice'];
    $query .= " AND Price BETWEEN ? AND ?";
    $exc[] = $minPriceFilter;
    $exc[] = $maxPriceFilter;
  }

  $query .= " ORDER BY $sortingOrder";

  // Prepare and execute the query
  $data = $db->prepare($query);
  $data->execute($exc);
  $count = $data->rowCount();
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shopping By Brands</title>
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
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="navContainerProducts">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="HomePageCustomer.php">Home Page</a></li>
        <li class="breadcrumb-item"><a href="ShopByCategories.php">Shopping By Brand</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $brandName ?></li>
      </ol>
    </nav>
    <div class="containerProducts">
      <div class="filter" id="showFilterDiv">
        <i class="closeFilter fa-solid fa-circle-xmark"></i>
        <h2 style="margin-bottom: 30px;">Filter</h2>
        <div class="sort-options">
          <label for="sort">
            <h5>Sort by:</h5>
          </label>
          <select id="sort" name="sort" onchange="sortProducts(this)">
            <option value="Default" <?php if (!isset($_GET["sort"]) || $_GET["sort"] === "") echo "selected" ?>>
              Default sorting
            </option>
            <option value="asc" <?php if (isset($_SESSION['sortingOrder']) && $_SESSION['sortingOrder'] === 'Price asc') echo "selected" ?>>
              Lowest Price
            </option>
            <option value="desc" <?php if (isset($_SESSION['sortingOrder']) && $_SESSION['sortingOrder'] === 'Price desc') echo "selected" ?>>
              Highest Price
            </option>
          </select>
        </div>

        <h5>Shopping By Brands</h5>
        <div class=" dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            echo $brandName;
            ?>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php
            $brandData = $db->prepare("SELECT DISTINCT Brand FROM `product data`");
            $brandData->execute();
            while ($brands = $brandData->fetch()) {
            ?>
              <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brands["Brand"]; ?>"><?php echo $brands["Brand"]; ?></a>
            <?php
            }
            ?>
          </ul>
        </div>

        <h5>Categories</h5>
        <div class=" dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            if (isset($_GET['Category'])) {
              $selectedCategory = $_GET['Category'];
              echo $selectedCategory;
            } else {
              echo 'All Categories';
            }
            ?>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>">All Categories</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Medicine">Medicine</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Minerals">Minerals</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Vitamins">Vitamins</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Supplements">Supplements</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Common Conditions">Common Conditions</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Skin Care">Skin Care</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Oral Care">Oral Care</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Bath & Shower">Bath & Shower</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Hair Wash & Care">Hair Wash & Care</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Body Supports">Body Supports</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Feminine Hygiene">Feminine Hygiene</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Mens Grooming">Mens Grooming</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Deodorants">Deodorants</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Health Accessories">Health Accessories</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=First Aid">First Aid</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Diagnostics & Monitoring">Diagnostics & Monitoring</a>
            <a class="dropdown-item" href="ProductByBrand.php?Brand=<?php echo $brandName ?>&Category=Baby Skin Care & Accessories">Baby Skin Care & Accessories</a>

          </ul>
        </div>
        <?Php
        //  retrieve minimum and maximum prices for current Brand
        if (isset($_GET['Category'])) {
          // If a brand is selected, fetch min and max prices for that brand within the category
          $selectedCategory = $_GET['Category'];
          $minMaxQuery = "SELECT MIN(Price) AS MinPrice, MAX(Price) AS MaxPrice FROM `product data` WHERE Brand = ? AND Type = ?";
          $minMaxData = $db->prepare($minMaxQuery);
          $minMaxData->execute([$brandName, $selectedCategory]);
        } else {
          $minMaxQuery = "SELECT MIN(Price) AS MinPrice, MAX(Price) AS MaxPrice FROM `product data` WHERE Brand = ?";
          $minMaxData = $db->prepare($minMaxQuery);
          $minMaxData->execute([$brandName]);
        }
        $minMaxResult = $minMaxData->fetch(PDO::FETCH_ASSOC);
        $minPrice = $minMaxResult['MinPrice'];
        $maxPrice = $minMaxResult['MaxPrice'];
        ?>
        <div>
          <form action="ProductByBrand.php" method="GET">
            <h5>Price Range</h5>
            <div>
              <div>
                Min: <input type="number" name="minPrice" id="minPrice" style="width: 70px;" min="<?php echo $minPrice ?>" max="<?php echo $maxPrice ?>" value="<?php echo isset($_GET['minPrice']) ? $_GET['minPrice'] : $minPrice ?>">
                -
                Max: <input type="number" name="maxPrice" id="maxPrice" style="width: 70px;" min="<?php echo isset($_GET['minPrice']) ? $_GET['minPrice'] : $minPrice ?>" max="<?php echo $maxPrice ?>" value="<?php echo isset($_GET['maxPrice']) ? $_GET['maxPrice'] : $maxPrice ?>">
              </div>
              <div style="margin-top: 5px;">
                <input type="hidden" name="Brand" value="<?php echo $brandName; ?>">
                <input type="submit" class="btn btn-primary" value="Apply">
              </div>
            </div>
          </form>
        </div>

        <div style="margin: 20px 0;">
          <form action="ProductByBrand.php" method="GET">
            <input type="hidden" name="ResetAll" value="true">
            <input type="hidden" name="Category" value="<?php echo $categoryName; ?>">
            <?php
            if (isset($_GET['Brand'])) {
              echo '<input type="hidden" name="Brand" value="' . $_GET['Brand'] . '">';
            }
            ?>
            <button type="submit" class="btn btn-outline-primary mx-auto d-block" style="width: 50%;">Reset All</button>
          </form>
        </div>
      </div>

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
          <div class="headerContainer">
            <h2 class="title" style="width: fit-content;"> <?php echo $brandName ?></h2>
            <i class="fa-solid fa-sliders" id="filterIcon"></i>
          </div>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            while ($row = $data->fetch()) {
              $productID = $row["ProductID"];
              $Quantity = $row["Quantity"];
              $Type = $row["Type"];

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

                    <span><?php echo $brandName . ", " . $Type ?></span>
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

        window.location.href = `ProductByBrand.php?Brand=<?php echo $brandName ?>&sort=${selectedOption}`;
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