<?php
session_start();
try {
  require("../Connection/init.php");
  include "../header.php";
  $stmt = $db->prepare("
  SELECT DISTINCT ud.UserID, ud.Username, cd.FirstName, cd.LastName
  FROM `user data` ud
  LEFT JOIN `Customer data` cd ON ud.UserID = cd.UserID
  UNION
  SELECT DISTINCT ud.UserID, ud.Username, sd.FirstName, sd.LastName
  FROM `user data` ud
  LEFT JOIN `Staff data` sd ON ud.UserID = sd.UserID
  UNION
  SELECT DISTINCT ud.UserID, ud.Username, sd.FirstName, sd.LastName
  FROM `user data` ud
  LEFT JOIN `Supplier data` sd ON ud.UserID = sd.UserID
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
      header("Location: ../ManageProduct/ProductDetails.php?ProductID=" . $urlParams);
      exit();
  }
}
// Retrieve the products from the database
$data = $db->prepare("SELECT * FROM `product data`");
$data->execute();
$count = $data->rowCount();

// Check if the selected product IDs array is set
$selectedProductIds = isset($_POST['ProductID']) ? $_POST['ProductID'] : [];
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    
    <?php
    if (isset($_SESSION['AddProduct'])) {
    echo '<div class="success-box" id="successBox">';
    echo '<div> <i class= "success-icon fa-solid fa-circle-check" id="iconX"></i>"Product Added successfully! 🎉!</div>';
    echo '</div>';
    unset($_SESSION['AddProduct']);
    } //for display Successfully messages

    if ($count > 0) {
    
        echo '<select name="users">';
    foreach ($users as $user) {
      echo '<option value="' . $user['UserID'] . '">';
      echo $user['UserID'] . ' - ' . $user['Username'] . ' - ' . $user['FirstName'] . ' ' . $user['LastName'];
      echo '</option>';
    }
    echo '</select> <br> <br>';
    ?>
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
              $ExpireDate = $row["ExpireDate"];
            ?>

              <div class="col">
                <?php
                if (isset($_SESSION['un'])) {
                  if ($_SESSION['user_role'] == 'Customer') {
                    echo '<a href="../ManageProduct/CustomerProduct.php?ProductID=' . $productID . '" name="ProductID[]">';
                  } else if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Staff') {
                    echo '<a href="../ManageProduct/ProductDetails.php?ProductID=' . $productID . '" name="ProductID[]">';
                  }
                } ?>
                <div class="card card-color:red">
                <?php if (isset($_SESSION['un'])) {
                      if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Staff') {
                        echo '<input type="checkbox" name="ProductID[]" value="<?php echo $productId; ?>" />';
                      } }
                    ?>
                  <div class="cartImag">
                    <a href="../ManageProduct/CustomerProduct.php?ProductID=<?php echo $productID; ?>" name="ProductID[]"> <img src="../images/<?php echo $Photo ?>" class="card-img-top w-50 mx-auto d-block"></a>
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
                        <a href="#" tabindex="0" data-bs-toggle="modal" data-bs-target="#alertModal">
                          <i class="fa-regular fa-heart" id="HeartIcon2"></i>
                        </a>
                      </div>
                      <?php
                      if (isset($_SESSION['un'])) {
                        echo '</a>';
                      } ?>
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

                    if ($Availability === 1) {
                      if ($ExpireDate <= $currentDate) {
                    ?>
                        <button id="outOfStock" type="button" class="btn btn-outline-primary w-100 d-block mx-auto" style="pointer-events: none; filter: none; background-color:#eee;
                        border-color:#ddd; color:#333;">
                          Out Of Stock
                        </button>
                        <?php
                      } else {
                        if (isset($_SESSION['user_id'])) {
                        ?>
                          <button type="button" onclick="addToCart(<?php echo $productID ?>)" class="btn btn-outline-primary w-100 d-block mx-auto">Add to Cart</button>
                        <?php
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
                      }
                    } else {
                      ?>
                      <button id="outOfStock" type="button" class="btn btn-outline-primary w-100 d-block mx-auto" style="pointer-events: none; filter: none; background-color:#eee;
                      border-color:#ddd; color:#333;">
                        Out Of Stock
                      </button>
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
 
 <?php if (isset($_SESSION['un'])) {
                      if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Staff') {
                        echo '<button type="submit" name="Vbtn" class="btn">View Details</button>
                        <button type="submit" name="delaccbtn" class="btn">Delete Product</button>
                        <a href="../ManageProduct/AddProduct.php" ><button type="submit" name="addbtn" class="btn">Add Product</button> </a>
                        <br>';
                      } }
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

      //Function to hide the success box
      function hideSuccessBox() {
        successBox.style.display = 'none';
      }

      // Hide the success box after 5 seconds
      setTimeout(hideSuccessBox, 5000);
    </script>
  </body>

  </html>
<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
