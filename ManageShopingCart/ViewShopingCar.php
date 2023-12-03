<?php
try {
  require("../Connection/init.php");

  //Assume 
  $userID = 000000003;
  



  //data for view orders
  $sql = "SELECT 
    `product data`.Photo,
    `product data`.Name,
    `product data`.Price,
    `view cart`.Qty,
    `view cart`.cartID,
    `view cart`.orderID,
    (`product data`.Price * `view cart`.Qty) AS TotalPrice
    FROM 
        `user data`
    JOIN 
        `order data` ON `user data`.UserID = `order data`.UserID
    JOIN 
        `view cart` ON `order data`.OrderID = `view cart`.OrderID
    JOIN 
        `product data` ON `view cart`.ProductID = `product data`.ProductID
    WHERE 
        `user data`.UserID = $userID";

  $data = $db->query($sql);


  //delete
  if (isset($_GET['cartID']) && isset($_GET['do']) && $_GET['do'] == "delete") {
    $cardIDToDelete = $_GET['cartID'];

    $deleteQuery = "DELETE FROM `view cart` WHERE cartID = $cardIDToDelete";
    $stmt = $db->prepare($deleteQuery);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }

  //Update
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
        // echo "<pre>";
        // echo print_r($row);
        // echo "</pre>";
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
            <a href="?do=delete$cartID=<?php echo $row["cartID"]; ?>"><button class="delete">delete</button></a>
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
        <input type="submit" value="Checkout">
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

</body>

</html>