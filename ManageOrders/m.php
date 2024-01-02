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

// Fetch the orders from the database
$stmt = $db->prepare("SELECT * FROM `order data`");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sort the orders by date in descending order
usort($orders, 'sortByDateDesc');

// Fetch all unique statuses from the database
$stmt = $db->prepare("SELECT DISTINCT `Status` FROM `order data`");
$stmt->execute();
$statuses = $stmt->fetchAll(PDO::FETCH_COLUMN);
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
  <div class="row">
    <div class="col-xl-12">
    <label class="inline-elements" for="Sorting">Sort by:</label>
      <select class="inline-elements" name="Sorting" id="Sorting" onchange="toggleTable()">
        <option value="Processing">Processing</option>
        <option value="ProcessingDate">Processing & Latest Date</option> <!-- New option -->
        <option value="Completed">Completed</option>
        <option value="CompletedDate">Completed & Latest Date</option> <!-- New option -->
      </select><br>
    <div class="content">
      <?php
      foreach ($statuses as $status) {
        $filteredOrders = array_filter($orders, function ($order) use ($status) {
          return $order['Status'] === $status && $order['PaymentMethod'] !== '';
        });

        if (!empty($filteredOrders)) {
          echo '<h1 class="inline-elements" > + ' . $status . '</h1>';
          echo '<table style="border-bottom: 2px solid #2E97A7;">';
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
                  <?php
                  foreach ($statuses as $statusOption) {
                    echo '<option value="' . $statusOption . '" ' . ($Status === $statusOption ? 'selected' : '') . '>' . $statusOption . '</option>';
                  }
                  ?>
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
          echo '</table> 
          <br>';
        }
      }
      ?>
    </div>
  </div>
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