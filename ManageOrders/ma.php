<?php
session_start();
include '../Connection/init.php';

// Fetch the orders from the database
$stmt = $db->prepare("SELECT * FROM `order data`");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Status</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
     .Container {
      display: flex;
      justify-content: center;
    }

    th {
      border-top: 2px solid #2E97A7;
      border-bottom: 2px solid #2E97A7;
    }

    table,
    th,
    tr,
    td {
      padding: 15px;
      text-align: center;
      color: #2E97A7;
    }

    h1,
    label {
      color: #2E97A7;
    }

    .inline-elements label,
    select {
      text-align: end;
    }

    .inline-elements {
      display: inline-block;
      margin-right: 10px; /* Adjust the margin as needed */
    }

    button.update-icon {
  background: none;
  border: none;
  padding: 0;
}

button.update-icon i {
  color: #2E97A7;
}
button.update-icon i:hover {
  color: #2E97;
}

button.update-icon span {
  display: none;
}
  </style>
</head>

<body>
  <div class="container">
    <div class="content">
      <?php
      $statuses = array('Pending', 'Processing', 'Completed'); // Add more statuses if needed
      foreach ($statuses as $status) {
        $filteredOrders = array_filter($orders, function ($order) use ($status) {
          return $order['Status'] === $status && $order['PaymentMethod'] !== '';
        });

        if (!empty($filteredOrders)) {
          echo '<h1 class="inline-elements">' . $status . '</h1>';
          echo '<table class="hidden" style="border-bottom: 2px solid #2E97A7;">';
          echo '<tr>
                  <th>Order ID</th>
                  <th>Order Details</th>
                  <th>Total Price</th>
                  <th>Payment Method</th>
                  <th>Status</th>
                  <th>Update</th>
                  <th>Order Date</th>
                  <th>Details</th>
                </tr>';
          echo '<tbody>';

          foreach ($filteredOrders as $order) {
            $OrderID = $order['OrderID'];
            $TotalPrice = $order['TotalPrice'];
            $paymentMethod = $order['PaymentMethod'];
            $Status = $order['Status'];
            $OrderDate = $order['OrderDate'];
            $OrderDetails = $order['OrderDetails'];
      ?>

            <tr>
              <td><?php echo $OrderID ?></td>
              <td><?php echo $OrderDetails ?></td>
              <td><?php echo "BHD $TotalPrice" ?></td>
              <td><?php echo $paymentMethod ?></td>
              <td>
                <select name="status" data-order-id="<?php echo $OrderID; ?>">
                  <option value="Pending" <?php echo ($Status === 'Pending') ? 'selected' : '' ?>>Pending</option>
                  <option value="Processing" <?php echo ($Status === 'Processing') ? 'selected' : '' ?>>Processing</option>
                  <option value="Completed" <?php echo ($Status === 'Completed') ? 'selected' : '' ?>>Completed</option>
                </select>
              </td>
              <td>
                <button class="update-icon" name="OrderID[]" data-order-id="<?php echo $order['OrderID']; ?>" onclick="updateStatus(this)">
                  <i class="fas fa-sync"></i>
                </button>
              </td>
              <td><?php echo $OrderDate ?></td>
              <td><i class="fas fa-info-circle"></i></td>
            </tr>

      <?php
          }

          echo '</tbody>';
          echo '</table>';
        }
      }
      ?>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function updateStatus(button) {
      var orderId = button.getAttribute("data-order-id");
      var selectElement = button.parentNode.parentNode.querySelector("select[name='status']");
      var status = selectElement.value;

      // Send an AJAX request to update the status
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "../ManageOrders/update_order.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Update the UI or perform any other necessary actions
          console.log(xhr.responseText);
        }
      };
      xhr.send("orderId=" + orderId + "&status=" + status);
    }
  </script>

</body>

</html>