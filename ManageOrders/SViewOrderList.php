<?php
session_start();
include '../header.php';
include '../Connection/init.php';

// Function to sort the orders by date in descending order
function sortByDateDesc($a, $b) {
    $dateA = strtotime($a['OrderDate']);
    $dateB = strtotime($b['OrderDate']);
    return $dateB - $dateA;
}

$stmt = $db->prepare("SELECT * FROM `order data`");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sort the orders by date in descending order
usort($orders, 'sortByDateDesc');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    .hidden {
      display: none;
    }
  </style>
</head>
<body>
<div class="Container">
  <div class="row">
    <div class="col-xl-12">
    <label class="inline-elements" for="Sorting">Sort by:</label>
      <select class="inline-elements" name="Sorting" id="Sorting" onchange="toggleTable()">
        <option value="Processing">Processing</option>
        <option value="ProcessingDate">Processing & Latest Date</option> <!-- New option -->
        <option value="Completed">Completed</option>
        <option value="CompletedDate">Completed & Latest Date</option> <!-- New option -->
      </select><br>
      <h1 class="inline-elements" id="pendingHeading">+ Processing</h1>
      <table id="pendingTable" style="border-bottom: 2px solid #2E97A7;">
        <tr>
          <th>Order ID</th>
          <th>Order Details</th>
          <th>Total Price</th>
          <th>Payment Method</th>
          <th>Status</th>
          <th>Update</th>
          <th>Order Date</th>
          <th>Details</th>
        </tr>
        <tbody>
        <?php
        foreach ($orders as $order) {
          $OrderID = $order['OrderID'];
          $TotalPrice = $order['TotalPrice'];
          $paymentMethod = $order['PaymentMethod'];
          $Status = $order['Status'];
          $OrderDate = $order['OrderDate'];
          $OrderDetails = $order['OrderDetails'];

          if ($Status === 'Payment Pending' && $paymentMethod !== '') {
            ?>
            <tr>
              <td><?php echo $OrderID ?></td>
              <td><?php echo $OrderDetails ?></td>
              <td><?php echo "BHD $TotalPrice" ?></td>
              <td><?php echo $paymentMethod ?></td>
              <td><?php echo $Status ?></td>
              <td> <a href="#" class="update-icon" data-order-id="<?php echo $order['OrderID']; ?>">
            <i class="fas fa-sync"></i>
          </a></td>
              <td><?php echo $OrderDate ?></td>
              <td><i class="fas fa-info-circle"></i></td>
            </tr>
            <?php
          }
        }
        ?>
        </tbody>
      </table>
      <br>
      <h1 class="inline-elements" id="completedHeading">+ Completed</h1>
      <table id="completedTable" class="hidden" style="border-bottom: 2px solid #2E97A7;">
        <tr>
          <th>Order ID</th>
          <th>Order Details</th>
          <th>Total Price</th>
          <th>Payment Method</th>
          <th>Status</th>
          <th>Update</th>
          <th>Order Date</th>
          <th>Details</th>
        </tr>
        <tbody>
        <?php
        foreach ($orders as $order) {
          $OrderID = $order['OrderID'];
          $TotalPrice = $order['TotalPrice'];
          $paymentMethod = $order['PaymentMethod'];
          $Status = $order['Status'];
          $OrderDate = $order['OrderDate'];
          $OrderDetails = $order['OrderDetails'];

          if ($Status === 'Payment Confirmed' && $paymentMethod !== '') {
            ?>
            <tr>
              <td><?php echo $OrderID ?></td>
              <td><?php echo $OrderDetails ?></td>
              <td><?php echo "BHD $TotalPrice" ?></td>
              <td><?php echo $paymentMethod ?></td>
              <td><select name="status">
  <option value="Pending" <?php echo ($Status === 'Pending') ? 'selected' : '' ?>>Pending</option>
  <option value="Processing" <?php echo ($Status === 'Processing') ? 'selected' : '' ?>>Processing</option>
  <option value="Completed" <?php echo ($Status === 'Completed') ? 'selected' : '' ?>>Completed</option>
</select></td>
              <td> <a href="#" class="update-icon" data-order-id="<?php echo $order['OrderID']; ?>">
            <i class="fas fa-sync"></i>
          </a></td>
              <td><?php echo $OrderDate ?></td>
              <td><i class="fas fa-info-circle"></i></td>
            </tr>
            <?php
          }
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  // Add event listeners to update icons
  var updateIcons = document.getElementsByClassName('update-icon');
  for (var i = 0; i < updateIcons.length; i++) {
    updateIcons[i].addEventListener('click', updateOrder);
  }

  // Update order function
  function updateOrder(event) {
    event.preventDefault();
    var orderId = event.target.getAttribute('data-order-id');

    // Perform the update operation
    // You can implement the update logic here, such as making an AJAX request to a PHP script
    // that updates the order in the database. Below is an example of how to update using AJAX.

    // Make an AJAX request to update the order
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_order.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Update was successful
          console.log('Order with ID ' + orderId + ' updated successfully!');
        } else {
          // Update failed
          console.error('Error updating order with ID ' + orderId);
        }
      }
    };
    xhr.send('order_id=' + encodeURIComponent(orderId));
  }

  function toggleTable() {
    var sorting = document.getElementById("Sorting").value;

    if (sorting === "Processing") {
      document.getElementById("completedTable").classList.add("hidden");
      document.getElementById("completedHeading").classList.add("hidden");
      document.getElementById("pendingTable").classList.remove("hidden");
      document.getElementById("pendingHeading").classList.remove("hidden");
    } else if (sorting === "Completed") {
      document.getElementById("pendingTable").classList.add("hidden");
      document.getElementById("pendingHeading").classList.add("hidden");
      document.getElementById("completedTable").classList.remove("hidden");
      document.getElementById("completedHeading").classList.remove("hidden");
    } else if (sorting === "ProcessingDate") {
      document.getElementById("completedTable").classList.add("hidden");
      document.getElementById("completedHeading").classList.add("hidden");
      document.getElementById("pendingTable").classList.remove("hidden");
      document.getElementById("pendingHeading").classList.remove("hidden");
      sortTableByDate("pendingTable");
    } else if (sorting === "CompletedDate") {
      document.getElementById("pendingTable").classList.add("hidden");
      document.getElementById("pendingHeading").classList.add("hidden");
      document.getElementById("completedTable").classList.remove("hidden");
      document.getElementById("completedHeading").classList.remove("hidden");
      sortTableByDate("completedTable");
    }
  }

  function sortTableByDate(tableId) {
    var table = document.getElementById(tableId);
    var tbody = table.getElementsByTagName("tbody")[0];
    var rows = Array.from(tbody.getElementsByTagName("tr"));

    rows.sort(function (a, b) {
      var dateA = new Date(a.cells[6].textContent); // Assuming the Order Date is in the 7th cell (index 6)
      var dateB = new Date(b.cells[6].textContent);

      return dateB - dateA; // Sort in descending order
    });

    tbody.innerHTML = ""; // Clear the existing table rows

    rows.forEach(function (row) {
      tbody.appendChild(row); // Add the sorted rows back to the table
    });
  }

  // Show both tables initially
  document.getElementById("pendingTable").classList.remove("hidden");
  document.getElementById("pendingHeading").classList.remove("hidden");
  document.getElementById("completedTable").classList.remove("hidden");
  document.getElementById("completedHeading").classList.remove("hidden");
</script>

</body>
</html>