<?php

session_start();
if (isset($_SESSION["user_id"])) {

  try {
    include "../header.php";
    require("../Connection/init.php");

    if (isset($_SESSION["user_id"]) && isset($_SESSION['PaymentID'])) {
      $userID = $_SESSION["user_id"];
      $PaymentID = $_SESSION['PaymentID'];

      $totalPrice = $_SESSION['TotalPrice'];
      $paymentMethod = $_SESSION['paymentMethod'];

      $sql = "SELECT 
                    `ordered item`.ProductID,
                    `product data`.Name,
                    `product data`.Price,
                    `ordered item`.Qty,
                    `order data`.OrderID,
                    `order data`.Status,
                    `order data`.OrderDate,
                    `order data`.PaymentMethod,
                    (`product data`.Price * `ordered item`.Qty) AS Subtotal
                FROM 
                    `ordered item`
                JOIN 
                    `product data` ON `ordered item`.ProductID = `product data`.ProductID
                JOIN 
                    `order data` ON `ordered item`.OrderID = `order data`.OrderID
                WHERE 
                    `order data`.PaymentID = ?";

      $data = $db->prepare($sql);
      $data->execute([$PaymentID]);
      $count = $data->rowCount();

      $customer = "SELECT * FROM `customer data` WHERE UserID = ?";
      $customerData = $db->prepare($customer);
      $customerData->execute([$userID]);
      $customer = $customerData->fetch(PDO::FETCH_ASSOC);

      $customerName = $customer['FirstName'] . ' ' . $customer['LastName'];
      $customerEmail = $customer['Email'];
      $customerMobile = $customer['MobileNumber'];
      $customerHouse = $customer['House'];
      $customerStreet = $customer['Street'];
      $customerArea = $customer['Area'];

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

        <div class="orderedContainer" style="padding: 0 10px;">
          <h2 style="text-align: center; color: #4CAF50">Thank you. Your order has been received.</h2>

          <p>Date: <?php echo date("Y-m-d"); ?></p>
          <p>Time: <?php echo date("H:i:s"); ?></p>

          <div class="container mt-4" style="margin-top: 5px;">
            <div class="row">
              <div class="col-lg-6 mb-4">
                <div class="card">
                  <div class="card-header">
                    <h3>Customer Details</h3>
                  </div>
                  <div class="card-body">
                    <p>Customer ID: <?php echo $userID; ?></p>
                    <p>Customer Name: <?php echo $customerName; ?></p>
                    <p>Email: <?php echo $customerEmail; ?></p>
                    <p>Mobile Number: <?php echo $customerMobile; ?></p>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h3>Address</h3>
                  </div>
                  <div class="card-body">
                    <p>House: <?php echo $customerHouse; ?></p>
                    <p>Street: <?php echo $customerStreet; ?></p>
                    <p>Area: <?php echo $customerArea; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table caption-top">
              <thead>
                <tr>
                  <th>ProductID</th>
                  <th>Name</th>
                  <th>Unit Price</th>
                  <th>Qty Ordered</th>
                  <th>Order Number</th>
                  <th>Status</th>
                  <th>Order Date</th>
                  <th>offer</th>
                  <th>Payment Method</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                  $offerData = $db->prepare("SELECT DiscountedPrice FROM `offers data` WHERE ProductID = ?");
                  $offerData->execute([$row['ProductID']]);
                  $offerPrice = $offerData->fetch();
                  $offerCount = $offerData->rowCount();

                  $percentage = "-";
                  $currentPice = $row['Price'];

                  if ($offerCount > 0) {
                    $percentage = round((($row['Price'] - $offerPrice["DiscountedPrice"]) / $row['Price']) * 100, 1) . "%";
                    $currentPice = $offerPrice["DiscountedPrice"];
                  }
                ?>
                  <tr>
                    <td><?php echo $row['ProductID']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo "BHD " . $row['Price']; ?></td>
                    <td><?php echo $row['Qty']; ?></td>
                    <td><?php echo $row['OrderID']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td><?php echo $row['OrderDate']; ?></td>
                    <td><?php echo $percentage ?></td>
                    <td><?php echo $row['PaymentMethod']; ?></td>
                    <td><?php echo "BHD " . $currentPice; ?></td>
                  </tr>
                <?php
                }
                ?>
                <tr style="background-color: #ECEFF1;">
                  <td colspan="9" class="text-end"><strong>Total Price:</strong></td>
                  <td>
                    <?php echo "BHD " . $totalPrice; ?>
                  </td>
                </tr>
              </tbody>

            </table>
          </div>
        </div>

      </body>

      </html>
<?php
    } else {
      echo "No current order found.";
    }
    $db = null;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
} else {
  include "../Account/Login.php";
}
?>