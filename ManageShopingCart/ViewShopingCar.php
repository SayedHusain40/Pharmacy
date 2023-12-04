<?php
try {
  require("../Connection/init.php");

  //Assume 
  $userID = 000000004;

  //query for view orders
  $sql = "SELECT 
    `product data`.Photo,
    `product data`.Name,
    `product data`.Price,
    `view cart`.Qty,
    `view cart`.cartID,
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

  //delete 
  if (isset($_GET['cartID']) && $_GET['do'] == "delete") {

    $cartID = $_GET['cartID'];

    $deleteQuery = "DELETE FROM `view cart` WHERE CartID = ?";
    $stmt = $db->prepare($deleteQuery);
    $stmt->execute([$cartID]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }

  //Update Qty
  if (isset($_GET['update-qty']) && isset($_GET['newQTY']) && isset($_GET['cartID'])) {

    $UpdateQTY = "UPDATE `view cart` SET `Qty` = ? WHERE `CartID` = ?";
    $stmt = $db->prepare($UpdateQTY);
    $stmt->execute([$_GET['newQTY'], $_GET['cartID']]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }

  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
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
  if ($count > 0) {
  ?>
    <h1 class="titleSC">Your Shopping Cart</h1>
    <table class="table-cart">
      <thead>
        <tr>
          <th>Image</th>
          <th>Item Name</th>
          <th>Item Price</th>
          <th>Items Quantity</th>
          <th>Total Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $TotalPrice = 0;
        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
          $TotalPrice += $row["TotalPrice"];
        ?>
          <tr>
            <td><img src="../images/<?php echo $row['Photo']; ?>" width="100px" /></td>
            <td><?php echo $row['Name']; ?></td>
            <td>$<?php echo $row['Price']; ?></td>
            <td>
              <form action="">
                <input type="hidden" name="cartID" value="<?php echo $row["cartID"] ?>">
                <input type="number" name="newQTY" min="1" value="<?php echo $row['Qty']; ?>"><br> <br>
                <input type="submit" name="update-qty" value="Update" class="update-btn">
              </form>
            </td>
            <td>$<?php echo $row["TotalPrice"]; ?></td>
            <td>
              <a href=""><button class="favorite">favorite</button></a>
              <a href="?do=delete&cartID=<?php echo $row["cartID"]; ?>"><button class="delete">delete</button></a>
            </td>
          </tr>

        <?php } ?>
      </tbody>
    </table>

    <div class="checkout">
      <h1 class="summary">Summary</h1>
      <form action="../Interface/PaymentPage.php">
        <h2>Shipping Method</h2>
        <input type="radio" name="order" value="pick-up" checked> Pick Up
        <br><br>
        <input type="radio" name="order" value="delivery"> Delivery(+1.5 BD)
        <hr>
        <div>
          <h2>Sub total</h2>
          <h2><?php echo isset($TotalPrice) ? $TotalPrice : 0 ?> BHD</h2>
        </div>
        <div id="deliveryCost" style="display: none;">
          <h2>Delivery</h2>
          <h2>1.5 BHD</h2>
        </div>
        <hr>
        <div class="total">
          <h2>Total</h2>
          <h2 id="totalPrice">
            <?php
            if (isset($TotalPrice)) {
              echo $TotalPrice . " BHD";
            } else {
              echo "0 BHD";
            }
            ?>
          </h2>
        </div>

        <input type="hidden" id="hiddenTotalPrice" name="TotalPrice" value="<?php echo isset($TotalPrice) ? $TotalPrice : 0 ?>">
        <div class="submit-btn">
          <input type="submit" name="checkout-submit" value="Checkout">
        </div>
      </form>
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
  } 
  else { ?>
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