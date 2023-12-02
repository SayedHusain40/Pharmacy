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
  if (isset($_GET['cartID'])) {
    $cardIDToDelete = $_GET['cartID'];

    $deleteQuery = "DELETE FROM `view cart` WHERE cartID = $cardIDToDelete";
    $stmt = $db->prepare($deleteQuery);
    $stmt->execute();

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
        $ID = $row["cartID"];
      ?>
        <tr>
          <td><img src="../images/<?php echo $row['Photo']; ?>" width="100px" /></td>
          <td><?php echo $row['Name']; ?></td>
          <td>$<?php echo $row['Price']; ?></td>
          <td><input type="number" name="quantity1" min="1" value="<?php echo $row['Qty']; ?>"></td>
          <td>$<?php echo $row["TotalPrice"]; ?></td>
          <td>
            <a href=""><button class="favorite">favorite</button></a>
            <a href="?cartID=<?php echo $ID; ?>"><button class="delete">delete</button></a>
          </td>
        </tr>

      <?php } ?>
    </tbody>
  </table>

  <div class="checkout">
    <h1 class="summary">Summary</h1>
    <form action="../Interface/PaymentPage.php">
      <h2>Shipping Method</h2>
      <input type="radio" name="order" value="pick-up"> Pick Up
      <br><br>
      <input type="radio" name="order" value="delivery"> Delivery(+1.5 BD)
      <hr>
      <div>
        <h2>Sub total</h2>
        <h2><?php echo "$" . $TotalPrice ?></h2>
      </div>
      <hr>
      <div calss="total">
        <h2>Total</h2>
        <h2><?php echo "$" . $TotalPrice ?></h2>
      </div>

      <input type="hidden" name="price" value="8" <?php echo $TotalPrice ?>>
      <div class="submit-btn">
        <input type="submit" value="Checkout">
      </div>
    </form>
  </div>
</body>

</html>