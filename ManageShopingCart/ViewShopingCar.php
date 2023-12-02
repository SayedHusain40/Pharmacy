<?php
try {
  require("../Connection/init.php");

  //Assume 
  $userID = 000000001; 

  //data for view orders
  $sql = "SELECT 
    `product data`.Photo,
    `product data`.Name,
    `product data`.Price,
    `view cart`.Qty,
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
  <link rel="stylesheet" href="/css/main.css" />
  <link rel="stylesheet" href="/css/all.min.css">
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
        <?php while ($row = $data->fetch(PDO::FETCH_ASSOC)) { ?>
          <tr>
            <td><img src="/images/<?php echo $row['Photo']; ?>" width="150px" /></td>
            <td><?php echo $row['Name']; ?></td>
            <td>$<?php echo $row['Price']; ?></td>
            <td><input type="number" name="quantity1" min="1" value="<?php echo $row['Qty']; ?>"></td>
            <td>$<?php echo $row["TotalPrice"]; ?></td>
            <td>
              <a href=""><i class="heart-icon fa-regular fa-heart"></i></a>
              <a href=""><i class="close-icon fa-regular fa-circle-xmark"></i></a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
</body>

</html>