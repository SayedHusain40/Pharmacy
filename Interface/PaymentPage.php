<?php
/*
  include ""; 
*/

try {
  require("../Connection/init.php");

  //Assume 
  $userID = 3; //$_SESSION["user_id"]

  // This if statement for when user click on pay 
  if (isset($_POST["paymentOption"]) && $_POST["paymentOption"] == "Pay") {

    //get OrderID from (order data) that not pay
    $data = $db->prepare("SELECT OrderID, TotalPrice FROM `order data` WHERE UserID = ? AND PaymentID IS NULL");
    $data->execute([$userID]);
    $result = $data->fetch();
    $OrderID = $result["OrderID"];


    //Get items that user order from (view cart table)
    $ItemsOrdered = $db->prepare("SELECT * FROM `view cart` WHERE UserID = ?");
    $ItemsOrdered->execute([$userID]);

    //insert order Items in (ordered item table) and reduce Qty in (product data table)
    while ($row = $ItemsOrdered->fetch()) {
      $productQtyQuery = $db->prepare("SELECT Quantity FROM `product data` WHERE ProductID = ?");
      $productQtyQuery->execute([$row["ProductID"]]);

      $productQtyResult = $productQtyQuery->fetch();
      $productQty = $productQtyResult['Quantity'];

      $stmt = $db->prepare("INSERT INTO `ordered item` (OrderID, ProductID, Qty, Total) VALUES (?,?,?,?)");
      $stmt->execute([$OrderID, $row["ProductID"], $row["Qty"], $row["Total"]]);

      $newQty = $productQty - $row["Qty"];
      $updateQty = $db->prepare("UPDATE `product data` SET Quantity = ? WHERE ProductID = ?");
      $updateQty->execute([$newQty, $row["ProductID"]]);
    }

    // Insert Payment into the (payment database table)
    $stmtPayment = $db->prepare("INSERT INTO `payment database` (UserID) VALUES (?)");
    $stmtPayment->execute([$userID]);

    // Get the last inserted PaymentID
    $PaymentID = $db->lastInsertId();

    // Update PaymentID in (order data table)
    $updatePaymentID = $db->prepare("UPDATE `order data` SET PaymentID = ? WHERE OrderID = ?");
    $updatePaymentID->execute([$PaymentID, $OrderID]);

    echo "Thank You for Your Purchase";

    exit();
  } else {

    $totalPrice = $_REQUEST["TotalPrice"];
    $paymentMethod = $_REQUEST["paymentMethod"];
    date_default_timezone_set('Asia/Bahrain');
    $OrderDate = date('Y-m-d');

    // This if statement for when user click on checkout 
    if (isset($_POST["checkout-submit"]) && $_POST["checkout-submit"] == "Checkout") {

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

      // when user select delivery  will go to AddAddresses.php page
      if (isset($_POST["checkout-submit"]) && $_POST["order"] == "delivery") {

        header("location: ../ManageShopingCart/AddAddresses.php?TotalPrice=$totalPrice&paymentMethod=$paymentMethod");
        exit;
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
      <div class="payment MainHeader ">
        <h1>Complete Your Purchase</h1>
      </div>

      <div class="payment-content">
        <div class="payment MainContent">
          <h1>Payment</h1>
          <h3 class="Price">Total Price: <?php echo $totalPrice ?> BHD</h3>
          <div class="credit-card">
            <h3>
              <?php
              if ($paymentMethod == "Debit Card")
                echo "Debit Card";
              else
                echo "Credit Card";
              ?>
            </h3>
            <img src="../images/pay_by_cards.webp" alt="" />
          </div>

          <form class="paymentForm" method="post">
            <label>Cardholder Name (exactly as shown on card)</label>
            <input type="text" placeholder="Enter Your Full Name" id="cardholder-name" />
            <p class="name-error MainError"><i class="fa-solid fa-circle-exclamation"></i><span>Cardholder Name cannot be empty</span></p>

            <br /> <br>

            <label>Card number</label>
            <input type="text" placeholder="0000 0000 0000 0000" id="card-number" />
            <p class="card-error MainError"><i class="fa-solid fa-circle-exclamation"></i><span>Card number cannot be empty</span></p>

            <br /><br>

            <div class="parentDiv">
              <div>
                <label>Expiration date</label><br />
                <input type="text" placeholder="MM/YY" class="ExpDate" id="expiration-date" />
                <p class="expiration-error MainError">
                  <i class="fa-solid fa-circle-exclamation"></i><span>Expiration date cannot be empty</span>
                </p>
              </div>
              <div>
                <label>CVV</label><br />
                <input type="text" placeholder="CVV" id="cvv" />
                <p class="cvv-error MainError">
                  <i class="fa-solid fa-circle-exclamation"></i><span>CVV cannot be empty</span>
                </p>
              </div>
            </div>
            <div class="MainSubmit">
              <input type="hidden" name="paymentOption" value="Pay">
              <button onclick="goToPreviousPage()">Cancel</button>
              <input type="submit" name="paymentOption" value="Pay" id="inputPaymentOption" />
            </div>
          </form>
        </div>
      </div>

      <script src="../js/main.js"></script>
    </body>

    </html>

<?php
  }
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>