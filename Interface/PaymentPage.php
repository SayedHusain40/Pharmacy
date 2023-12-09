<?php
session_start();
/*
  include ""; 
*/

try {
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
  <?php

  require("../Connection/init.php");

  if (isset($_REQUEST["TotalPrice"]) && isset($_REQUEST["paymentMethod"])) {
    $_SESSION['TotalPrice'] = $_REQUEST["TotalPrice"];
    $_SESSION['paymentMethod'] = $_REQUEST["paymentMethod"];
  }

  //Assume 
  $userID = 6; //$_SESSION["user_id"]

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
    $TotalMembershipPoints = 0;
    while ($row = $ItemsOrdered->fetch()) {
      $productQtyQuery = $db->prepare("SELECT Quantity, Points FROM `product data` WHERE ProductID = ?");
      $productQtyQuery->execute([$row["ProductID"]]);

      $productQtyResult = $productQtyQuery->fetch();
      $productQty = $productQtyResult['Quantity'];
      $productPoint = $productQtyResult['Points'];

      $MembershipPoints = $productPoint * $row["Qty"];
      $TotalMembershipPoints = $TotalMembershipPoints + $MembershipPoints;

      $stmt = $db->prepare("INSERT INTO `ordered item` (OrderID, ProductID, Qty, TotalPrice, TotalPoints) VALUES (?,?,?,?,?)");
      $stmt->execute([$OrderID, $row["ProductID"], $row["Qty"], $row["Total"], $MembershipPoints]);

      $newQty = $productQty - $row["Qty"];
      $updateQty = $db->prepare("UPDATE `product data` SET Quantity = ? WHERE ProductID = ?");
      $updateQty->execute([$newQty, $row["ProductID"]]);

      // Check if Quantity is 0 and update Availability in product data table
      if ($newQty <= 0) {
        $updateAvailability = $db->prepare("UPDATE `product data` SET Availability = 0 WHERE ProductID = ?");
        $updateAvailability->execute([$row["ProductID"]]);
      }
    }

    //Get CreditCardInfo to store them in database
    $cardholderName = $_POST['cardholder-name'];
    $cardNumber = $_POST['card-number'];
    $expirationDate = $_POST['expiration-date'];
    $cvv = $_POST['cvv'];

    // Encrypt sensitive data
    $key = 'secretKey';
    $iv = openssl_random_pseudo_bytes(16);
    $encryptedCardNumber = openssl_encrypt($cardNumber, 'AES-256-CBC', $key, 0, $iv);

    $CreditCardInfo = [
      'cardholderName' => $cardholderName,
      'encryptedCardNumber' => $encryptedCardNumber,
      'expirationDate' => $expirationDate,
      'cvv' => $cvv,
    ];

    $CardInfoArray = json_encode($CreditCardInfo);


    // Insert PaymentInfo into the (payment database table)
    date_default_timezone_set('Asia/Bahrain');
    $PayDate = date('Y-m-d');
    $totalPrice = $_SESSION['TotalPrice'];
    $PaymentStatus = "paid";


    // customer data for shippingInfo
    $stmt = $db->prepare("SELECT * FROM `customer data` WHERE UserID = ?");
    $stmt->execute([$userID]);
    $result = $stmt->fetch();
    $currentMembershipPoints = $result["MembershipPoints"];

    $shippingInfo = [
      'RecipientName' => $result['FirstName'] . ' ' . $result['LastName'],
      'Address' => [
        'Area' => $result['Area'],
        'House' => $result['House'],
        'Street' => $result['Street'],
        'Block' => $result['Block'],
      ],
      'Contact' => [
        'MobileNumber' => $result['MobileNumber'],
        'Email' => $result['Email'],
      ]
    ];

    $shippingInfoArray = json_encode($shippingInfo);


    $stmtPayment = $db->prepare("INSERT INTO `payment database` (PayDate, Total, ShippingInfo, MembershipPoints, CreditCardInfo, PaymentStatus, UserID) VALUES (?,?, ?, ?, ?, ?, ?)");
    $stmtPayment->execute([$PayDate, $totalPrice, $shippingInfoArray, $TotalMembershipPoints, $CardInfoArray, $PaymentStatus, $userID]);

    // Get the last inserted PaymentID
    $PaymentID = $db->lastInsertId();


    // Update (order data table)
    $Status = "Payment Confirmed";
    $update = $db->prepare("UPDATE `order data` SET PaymentID = ?, Status = ?, CreditCardInfo = ?, MembershipPoints = ? WHERE OrderID = ?");
    $update->execute([$PaymentID, $Status, $CardInfoArray, $TotalMembershipPoints, $OrderID]);


    // Update CreditCardInfo and ShippingInfo and MembershipPoints for customer in (customer data table)
    $newMembershipPoints = $currentMembershipPoints + $TotalMembershipPoints;
    $update = $db->prepare("UPDATE `customer data` SET CreditCardInfo = ?,ShippingInfo = ?, MembershipPoints = ? WHERE UserID = ?");
    $update->execute([$CardInfoArray, $shippingInfoArray, $newMembershipPoints, $userID]);
  ?>

    <div class="MessagePaid">
      <i class="fa-solid fa-circle-check"></i> Thank You for Your Purchase
    </div>

    <div class="MessagePaid-btn">
      <a href="../Interface/HomePageCustomer.php"><button>Return Home</button></a>
    </div>

  <?php
    exit();
  } else {


    $totalPrice = $_SESSION['TotalPrice'];
    $paymentMethod = $_SESSION['paymentMethod'];

    date_default_timezone_set('Asia/Bahrain');
    $OrderDate = date('Y-m-d');

    // This if statement for when user click on checkout 
    if (isset($_POST["checkout-submit"]) && $_POST["checkout-submit"] == "Checkout") {

      $stmt = $db->prepare("SELECT * FROM `order data` WHERE UserID = ? AND PaymentID IS NULL");
      $stmt->execute([$userID]);
      $count = $stmt->rowCount();
      $Status = "Payment Pending";

      //check if Order Exit Or no if not insert order else means there is order but not pay so will update it
      if ($count == 0) {
        $sql = "INSERT INTO `order data` (UserID, TotalPrice, PaymentMethod, Status,  OrderDate) VALUES (?, ?, ?, ?, ?)";
        $data = $db->prepare($sql);
        $data->execute([$userID, $totalPrice, $paymentMethod, $Status, $OrderDate]);
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
            <input type="text" placeholder="Enter Your Full Name" id="cardholder-name" name="cardholder-name" />
            <p class="name-error MainError"><i class="fa-solid fa-circle-exclamation"></i><span>Cardholder Name cannot be empty</span></p>

            <br /> <br>

            <label>Card number</label>
            <input type="text" placeholder="0000 0000 0000 0000" id="card-number" name="card-number" />
            <p class="card-error MainError"><i class="fa-solid fa-circle-exclamation"></i><span>Card number cannot be empty</span></p>

            <br /><br>

            <div class="parentDiv">
              <div>
                <label>Expiration date</label><br />
                <input type="text" placeholder="MM/YY" class="ExpDate" id="expiration-date" name="expiration-date" />
                <p class="expiration-error MainError">
                  <i class="fa-solid fa-circle-exclamation"></i><span>Expiration date cannot be empty</span>
                </p>
              </div>
              <div>
                <label>CVV</label><br />
                <input type="text" placeholder="CVV" id="cvv" name="cvv" />
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