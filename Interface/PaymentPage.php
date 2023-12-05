<?php
try {
  require("../Connection/init.php");
  //Assume 
  $userID = 000000005;

  // when click on pay
  if (isset($_GET["paymentOption"]) && $_GET["paymentOption"] == "Pay") 
  {

    //get OrderID
    $data = $db->prepare("SELECT OrderID, TotalPrice FROM `order data` WHERE UserID = ? AND PaymentID IS NULL");
    $data->execute([$userID]);
    $result = $data->fetch();
    $OrderID = $result["OrderID"];


    //Get items that user ordered from (view cart table)
    $ItemsOrdered = $db->prepare("SELECT * FROM `view cart` WHERE UserID = ?");
    $ItemsOrdered->execute([$userID]);

    //insert ordered Items in (ordered item table)
    while ($row = $ItemsOrdered->fetch()) {
      $stmt = $db->prepare("INSERT INTO `ordered item` (OrderID, ProductID, Qty, Total) VALUES (?,?,?,?)");
      $stmt->execute([$OrderID, $row["ProductID"], $row["Qty"], $row["Total"],]);
    }

    // Insert Payment into the payment database table
    $stmtPayment = $db->prepare("INSERT INTO `payment database` (UserID) VALUES (?)");
    $stmtPayment->execute([$userID]);

    // Get the last inserted PaymentID
    $PaymentID = $db->lastInsertId();

    // Update the order data table with PaymentID where OrderID matches
    $updatePaymentID = $db->prepare("UPDATE `order data` SET PaymentID = ? WHERE OrderID = ?");
    $updatePaymentID->execute([$PaymentID, $OrderID]);

    echo "Thank You for Your Purchase";

    exit;
  } 
  else 
  {

    $totalPrice = $_GET["TotalPrice"];
    $paymentMethod = $_GET["paymentMethod"];
    date_default_timezone_set('Asia/Bahrain');
    $OrderDate = date('Y-m-d');

    // GO to AddAddresses.php when select delivery
    if (isset($_GET["checkout-submit"]) && $_GET["order"] == "delivery") {

      header("location: ../ManageShopingCart/AddAddresses.php?TotalPrice=$totalPrice");
      exit;
    }


    //when click on cancel return user to previous page
    if (isset($_GET["paymentOption"]) && $_GET["paymentOption"] == "Cancel") {

      header("location: ../ManageShopingCart/ViewShopingCar.php");
      exit;
    }


    //Insert order in to order data table
    if (isset($_GET["checkout-submit"]) && $_GET["checkout-submit"] == "Checkout") {

      $stmt = $db->prepare("SELECT * FROM `order data` WHERE UserID = ? AND PaymentID IS NULL");
      $stmt->execute([$userID]);

      $count = $stmt->rowCount();

      //check if Order Exit Or no if not insert order else means there is order but not pay so will update it
      if ($count == 0) {
        $sql = "INSERT INTO `order data` (UserID, TotalPrice, PaymentMethod, OrderDate) VALUES (?, ?, ?, ?)";
        $data = $db->prepare($sql);
        $data->execute([$userID, $totalPrice, $paymentMethod, $OrderDate]);
      } else {
        $sql = "UPDATE `order data` SET TotalPrice = ?, PaymentMethod = ?, OrderDate = ?";
        $data = $db->prepare($sql);
        $data->execute([$totalPrice, $paymentMethod, $OrderDate]);
      }
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
      <div class="payment-header">
        <h1>Complete Your Purchase</h1>
      </div>

      <div class="payment-content">
        <div class="payment">
          <h1>Payment</h1>
          <h3 class="Price">Total Price: <?php echo $totalPrice ?> BHD</h3>
          <div class="credit-card">
            <h3>
              <?php
              if ($_GET["paymentMethod"] == "Debit Card")
                echo "Debit Card";
              else
                echo "Credit Card";
              ?>
            </h3>
            <img src="../images/pay_by_cards.webp" alt="" />
          </div>

          <form action="">
            <label>Cardholder Name (exactly as shown on card)</label>
            <input type="text" placeholder="Enter Your Full Name" id="cardholder-name" />
            <p class="name-error payError"><i class="fa-solid fa-circle-exclamation"></i><span>Cardholder Name cannot be empty</span></p>

            <br /> <br>

            <label>Card number</label>
            <input type="text" placeholder="0000 0000 0000 0000" id="card-number" />
            <p class="card-error payError"><i class="fa-solid fa-circle-exclamation"></i><span>Card number cannot be empty</span></p>

            <br /><br>

            <div class="expCvv">
              <div>
                <label>Expiration date</label><br />
                <input type="text" placeholder="MM/YY" class="ExpDate" id="expiration-date" />
                <p class="expiration-error payError">
                  <i class="fa-solid fa-circle-exclamation"></i><span>Expiration date cannot be empty</span>
                </p>
              </div>
              <div>
                <label>CVV</label><br />
                <input type="text" placeholder="CVV" id="cvv" />
                <p class="cvv-error payError">
                  <i class="fa-solid fa-circle-exclamation"></i><span>CVV cannot be empty</span>
                </p>
              </div>
            </div>
            <div class="pay-cancel">
              <form action="" method="post">
                <input type="submit" name="paymentOption" value="Pay" />
                <input type="submit" name="paymentOption" value="Cancel" onclick="goToPreviousPage()" />
              </form>
            </div>
          </form>
        </div>
      </div>

      <script src="/js/main.js"></script>
    </body>

    </html>

    <?php
  }
  $db = null;
} 
catch (PDOException $e) 
{
  echo "Error: " . $e->getMessage();
}
?>