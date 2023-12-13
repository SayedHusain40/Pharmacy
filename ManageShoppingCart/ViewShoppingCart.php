<?php
session_start();
/*
  include ""; 
*/

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
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
  </head>

  <body>
    <?php
    include "../header.php";
    if ($count > 0) {
    ?>
      <h1 class="title">Your Shopping Cart</h1>
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
                <div class="price">Price: <?php echo $row['Price']; ?> BHD</div>
                <div class="points"><?php echo $row['Qty'] . " x " . $row['Points'] . " = " . $row['Qty'] * $row['Points'] . " Points"; ?></div>
                <div class="totalPrice">Total Price: <?php echo $row["TotalPrice"]; ?> BHD</div>
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
                <i class="fa-regular fa-heart"></i>
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
              <p><?php echo isset($TotalPrice) ? $TotalPrice : 0 ?> BHD</p>
            </div>
            <div class="delivery" id="deliveryCost" style="display: none;">
              <p>Delivery</p>
              <p>1.5 BHD</p>
            </div>

            <div class="line"></div>

            <div class="total">
              <h4>Total</h4>
              <h4 id="totalPrice">
                <?php
                if (isset($TotalPrice)) {
                  echo $TotalPrice . " BHD";
                } else {
                  echo "0 BHD";
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