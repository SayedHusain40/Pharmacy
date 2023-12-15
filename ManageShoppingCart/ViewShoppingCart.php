<?php
session_start();
try {
  require("../Connection/init.php");

  //Assume 
  $userID = 6; // $userID = $_SESSION["user_id"];

  //query for view orders
  $sql = "SELECT 
    `product data`.Photo,
    `product data`.Name,
    `product data`.Price,
    `product data`.Quantity,
    `product data`.Points,
    `view cart`.Qty,
    `view cart`.cartID,
    `view cart`.ProductID,
    (`product data`.Price * `view cart`.Qty) AS TotalPrice
    FROM 
        `view cart`
    JOIN 
        `product data` 
        ON `view cart`.ProductID = `product data`.ProductID
    WHERE 
        `view cart`.UserID = ?";

  $data = $db->prepare($sql);
  $data->execute([$userID]);
  $count = $data->rowCount();

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
  </head>

  <body>
    <?php
    include "../header.php";

    if ($count > 0) {
      //for display updated Qty success
      if (isset($_SESSION['updateQty_success'])) {
        echo '<div class="success-box" id="successBox">';
        echo '<div><i class="success-icon fa-solid fa-xmark" id="iconX"></i>Successfully Updated Qty!</div>';
        echo '</div>';
        unset($_SESSION['updateQty_success']);
      }
      if (isset($_SESSION['deleteProduct_success'])) {
        echo '<div class="success-box" id="successBox">';
        echo '<div><i class="success-icon fa-solid fa-xmark" id="iconX"></i>Successfully Delete Product!</div>';
        echo '</div>';
        unset($_SESSION['deleteProduct_success']);
      }
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
      <div class="cartContainer">
        <div>
          <?php
          $TotalPrice = 0;
          while ($row = $data->fetch()) {
            $TotalPrice = $TotalPrice + $row["TotalPrice"];
          ?>
            <div class="itemsBox">
              <div> <img src="../images/<?php echo $row['Photo']; ?>" width="100px" /></div>
              <div class="itemsBoxContent">
                <div>
                  <h3><?php echo $row['Name']; ?></h3>
                </div>
                <div class="quantity">Quantity: <?php echo $row['Qty']; ?></div>
                <div class="price">Price: BHD <?php echo $row['Price']; ?></div>
                <div class="points"><?php echo $row['Qty'] . " x " . $row['Points'] . " = " . $row['Qty'] * $row['Points'] . " Points"; ?></div>
                <div class="totalPrice">Total Price: BHD <?php echo $row["TotalPrice"]; ?></div>
                <div>
                  <form action="./EditCart.php" method="post">
                    <input type="hidden" name="cartID" value="<?php echo $row["cartID"] ?>">
                    Update Quantity: <input type="number" name="newQTY" min="1" value="<?php echo $row['Qty']; ?>" max="<?php echo $row["Quantity"] ?>">
                    <input type="hidden" name="productID" value="<?php echo $row["ProductID"] ?>">
                    <input class="update" type="submit" name="update-qty" value="Update" class="update-btn">
                  </form>
                </div>
              </div>
              <span class="deleteItemsCart">
                <a href="./EditCart.php?delete&cartID=<?php echo $row["cartID"]; ?>"> <i class="fa-solid fa-circle-xmark"></i> </a>
              </span>
              <span class="favorite">
                <?php
                // check for if product already in wish list
                $check = $db->prepare("SELECT * FROM `wish list data` WHERE ProductID = ? And UserID = ?");
                $check->execute([$row["ProductID"], $userID]);
                $checkResult = $check->rowCount();
                $dataWishList = $check->fetch();

                // Insert and delete in wishlist
                ?>
                <a href="#" class="wishlist-action" data-product-id="<?php echo $row["ProductID"]; ?>" data-wishlist-id="<?php echo isset($dataWishList["WID"]) ? $dataWishList["WID"] : ''; ?>">
                  <i class="<?php echo isset($dataWishList["WID"]) ? 'fa-solid' : 'fa-regular'; ?> fa-heart"></i>
                </a>

              </span>
            </div>
          <?php } ?>
        </div>

        <div class="checkout">
          <h2 class="summary">Summary</h2>
          <form action="../Interface/PaymentPage.php" method="post">
            <h5>Select a payment Method</h5>
            <input type="radio" name="paymentMethod" value="Credit Card" checked> <label> Credit Card </label>
            <input type="radio" name="paymentMethod" value="Debit Card"> <label> Debit Card </label>

            <br>

            <h5>Shipping Method</h5>
            <input type="radio" name="order" value="pick-up" checked> <label>Pick Up</label>

            <input type="radio" name="order" value="delivery"> <label>Delivery (+1.5 BD)</label>

            <div class="line"></div>

            <div class="subTotal">
              <p>Sub total</p>
              <p>BHD <?php echo isset($TotalPrice) ? $TotalPrice : 0 ?></p>
            </div>
            <div class="delivery" id="deliveryCost" style="display: none;">
              <p>Delivery</p>
              <p>BHD 1.5</p>
            </div>

            <div class="line"></div>

            <div class="total">
              <h4>Total</h4>
              <h4 id="totalPrice">
                <?php
                if (isset($TotalPrice)) {
                  echo "BHD " . $TotalPrice;
                } else {
                  echo "BHD 0";
                }
                ?>
              </h4>
            </div>

            <div class="line"></div>

            <input type="hidden" id="hiddenTotalPrice" name="TotalPrice" value="<?php echo isset($TotalPrice) ? $TotalPrice : 0 ?>">
            <div class="submit-btn">
              <input type="submit" name="checkout-submit" value="Checkout">
            </div>
          </form>
        </div>
      </div>

      <script>
        let iconX = document.getElementById('iconX');
        let successBox = document.getElementById('successBox');

        iconX.addEventListener('click', function() {
          hideSuccessBox();
        });

        // Function to hide the success box
        function hideSuccessBox() {
          successBox.style.display = 'none';
        }

        // Hide the success box after 3 seconds
        setTimeout(hideSuccessBox, 3000); 



        const deliveryRadio = document.querySelector('input[type=radio][value=delivery]');
        const pickUpRadio = document.querySelector('input[type=radio][value=pick-up]');
        const DivDeliveryCost = document.getElementById('deliveryCost');
        const hiddenPrice = document.getElementById('hiddenTotalPrice');
        const totalPriceElement = document.getElementById('totalPrice');
        const deliveryCost = 1.5;

        deliveryRadio.addEventListener('change', function() {
          if (this.checked) {
            hiddenPrice.value = parseFloat(hiddenPrice.value) + deliveryCost;
            totalPriceElement.textContent = hiddenPrice.value + " BHD";
            DivDeliveryCost.style.display = 'flex';
          }
        });

        pickUpRadio.addEventListener('change', function() {
          if (this.checked) {
            hiddenPrice.value = parseFloat(hiddenPrice.value) - deliveryCost;
            totalPriceElement.textContent = hiddenPrice.value + " BHD";
            DivDeliveryCost.style.display = 'none';
          }
        });


        // for update Quantity
        function updateQuantity() {
          var form = document.getElementById('updateForm');
          var formData = new FormData(form);

          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {}
            };

            xhr.open('POST', form.action, true);
            xhr.send(formData);
          }
        }


        // for delete and add to wish list 
        document.querySelectorAll('.wishlist-action').forEach(item => {
          item.addEventListener('click', function(event) {
            event.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const wishlistId = this.getAttribute('data-wishlist-id');

            const heartIcon = this.querySelector('i');
            if (heartIcon.classList.contains('fa-regular')) {
              heartIcon.classList.remove('fa-regular');
              heartIcon.classList.add('fa-solid');
              addToWishlist(productId);
            } else {
              heartIcon.classList.remove('fa-solid');
              heartIcon.classList.add('fa-regular');
              removeFromWishlist(wishlistId);
            }
          });
        });

        // Add function
        function addToWishlist(productID) {
          const xhr = new XMLHttpRequest();
          xhr.open('POST', '../ManageWishList/AddToWishList.php', true);
          xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

          const pID = `productID=${productID}`;

          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                console.log('Item added to wishlist!');
              } else {
                console.error('Failed to add item to wishlist');
              }
            }
          };

          xhr.send(pID);
        }


        // Remove function 
        function removeFromWishlist(wishlistId) {
          const xhr = new XMLHttpRequest();
          xhr.open('POST', '../ManageWishList/DeleteWishList.php', true);
          xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

          const wID = `WID=${wishlistId}`;

          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                console.log('Item removed from wishlist!');
              } else {
                console.error('Failed to remove item from wishlist');
              }
            }
          };

          xhr.send(wID);
        }
        // for delete and add to wish list
      </script>

    <?php
    } else {
    ?>
      <h1 class='cartEmpty'>Your Shopping Cart is Empty</h1>
      <div class="cart-image">
        <img src="../images/cart.jpeg" alt="">
      </div>

      <div class="start-shopping">
        <a href="../Interface/HomePage.php"><button>Start Shopping</button></a>
      </div>
    <?php
    }
    ?>
  </body>

  </html>
<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>