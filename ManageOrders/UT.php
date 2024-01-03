<?php
session_start();
include '../header.php';
include '../Connection/init.php';

// Retrieve data from the "Order" table for "Processing" status
// Define the desired statuses
$statuses = ['Processing', 'Confirmed', 'Ready to Pickup', 'Out for Delivery'];
// Build the placeholders for the IN clause
$statusPlaceholders = implode(',', array_fill(0, count($statuses), '?'));
// Prepare the statement
$stmt = $db->prepare("SELECT * FROM `order data` WHERE Status IN ($statusPlaceholders) ORDER BY OrderDate DESC");
// Bind the status values
$stmt->execute($statuses);

// Fetch the data
$processingData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve data from the "Order" table for "Completed" status
$completedData = [];
$stmt = $db->query("SELECT * FROM `order data` WHERE Status = 'Completed' ORDER BY OrderDate DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $completedData[] = $row;
}
// Function to generate the status select dropdown options
function getStatusOptions($selectedStatus) {
    $statusOptions = array(
        'Confirmed', 'Processing', 'Ready to Pickup', 'Out for Delivery', 'Completed'
    );
    $options = '';
    foreach ($statusOptions as $status) {
        $selected = ($selectedStatus == $status) ? 'selected' : '';
        $options .= "<option value='$status' $selected>$status</option>";
    }
    return $options;
}

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
    button.details-icon {
      background: none;
  border: none;
  padding: 0;
    }
    button.details-icon i {
  color: #2E97A7;
}
button.details-icon i:hover {
  color: #2E97;
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
    .hidden {
      display: none;
    }
  </style>
</head>
<body>
<div class="Container">
  <div class="row">
    <div class="col-xl-12">

    <?php
$Allstatuses = ['Processing', 'Confirmed', 'Ready to Pickup', 'Out for Delivery', 'Completed'];

// Check if a status is selected
if (isset($_GET['Sorting']) && in_array($_GET['Sorting'], $Allstatuses)) {
    $selectedSorting = $_GET['Sorting'];
    $stmt = $db->prepare("SELECT * FROM `order data` WHERE Status = :status");
    $stmt->bindParam(':status', $selectedSorting);
    $stmt->execute();
} else {
    $stmt = $db->prepare("SELECT * FROM `order data`");
    $stmt->execute();
}
?>

<!-- Select tag for sorting -->
<label class="inline-elements" for="Sorting">Sort by Status:</label>
<select class="inline-elements" name="Sorting" id="Sorting" onchange="toggleTable()">
    <option value="All">All</option>
    <?php foreach ($Allstatuses as $status): ?>
        <option value="<?php echo $status; ?>" <?php if (isset($selectedSorting) && $selectedSorting === $status) echo 'selected'; ?>><?php echo $status; ?></option>
    <?php endforeach; ?>
</select>
<br> <br>
<!-- Displaying "Processing" table data -->
<h1 class="inline-elements" id="processingHeading">+ Processing</h1>
      <table id="processingTable" class="hidden" style="border-bottom: 2px solid #2E97A7;">
    <thead>
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
    </thead>
    <tbody id="originalTbody">
            <tr>
            <?php 
            foreach ($processingData as $order): ?>
                <td><?php echo $order['OrderID']; ?></td>
                <td><?php echo $order['OrderDetails']; ?></td>
                <td><?php echo $order['TotalPrice']; ?></td>
                <td><?php echo $order['PaymentMethod']; ?></td>
                <td>
                    <select name="status">
                        <?php echo getStatusOptions($order['Status']); ?>
                    </select>
                </td>
                <td>       <button class="update-icon" name="OrderID[]" data-order-id="<?php echo $order['OrderID']; ?>" onclick="updateStatus(this)">
  <i class="fas fa-sync"></i>
</button></td>
                <td><?php echo $order['OrderDate']; ?></td>
                <td> <a href="../ManageOrders/ViewOrderDetails.php?OrderID=<?php echo $order['OrderID']; ?>"> <button class="details-icon" name="OrderID[]" data-order-id="<?php echo $order['OrderID']; ?>"> <i class="fas fa-info-circle"></i> </button>      </a></td>
                <td> <a href="../Function/Te.php?OrderID=<?php echo $order['OrderID']; ?>" name="TrackOrder"> <button class="details-icon" name="OrderID[]" data-order-id="<?php echo $order['OrderID']; ?>"><i class="fas fa-shipping-fast"></i> Track Order  </button> </a> </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Displaying "Completed" table data -->
<h1 class="inline-elements" id="completedHeading">+ Completed</h1>
      <table id="completedTable" class="hidden" style="border-bottom: 2px solid #2E97A7;">
    <thead>
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
    </thead>
    <tbody>
        <?php foreach ($completedData as $order): ?>
            <a href="../ManageOrders/ViewOrderDetails.php">  <tr>
                <td><?php echo $order['OrderID']; ?></td>
                <td><?php echo $order['OrderDetails']; ?></td>
                <td><?php echo $order['TotalPrice']; ?></td>
                <td><?php echo $order['PaymentMethod']; ?></td>
                <td>
                    <select name="status">
                        <?php echo getStatusOptions($order['Status']); ?>
                    </select>
                </td>
                <td>       <button class="update-icon" name="OrderID[]" data-order-id="<?php echo $order['OrderID']; ?>" onclick="updateStatus(this)">
  <i class="fas fa-sync"></i>
</button></td>
                <td><?php echo $order['OrderDate']; ?></td>
                <td> <a href="../ManageOrders/ViewOrderDetails.php?OrderID=<?php echo $order['OrderID']; ?>"> <button class="details-icon" name="OrderID[]" data-order-id="<?php echo $order['OrderID']; ?>"> <i class="fas fa-info-circle"></i> </button>      </a></td>
                <td> <a href="../Function/Te.php?OrderID=<?php echo $order['OrderID']; ?>" name="TrackOrder"> <button class="details-icon" name="OrderID[]" ><i class="fas fa-shipping-fast"></i> Track Order  </button> </a> </td>
            </tr> </a>
        <?php endforeach; ?>
    </tbody>
</table>
<br>
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
  xhr.open("POST", "../ManageOrders/Tupdate_order.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Update the UI or perform any other necessary actions
      console.log(xhr.responseText);
    }
  };
  xhr.send("orderId=" + orderId + "&status=" + status);
}
function toggleTable(processingData) {
  var sorting = document.getElementById("Sorting").value;

  if (
    sorting === "Processing" ||
    sorting === "Confirmed" ||
    sorting === "Ready to Pickup" ||
    sorting === "Out for Delivery"
  ) {
    document.getElementById("completedTable").classList.add("hidden");
    document.getElementById("completedHeading").classList.add("hidden");
    document.getElementById("processingTable").classList.remove("hidden");
    document.getElementById("processingHeading").classList.remove("hidden");
  } else if (sorting === "Completed") {
    document.getElementById("processingTable").classList.add("hidden");
    document.getElementById("processingHeading").classList.add("hidden");
    document.getElementById("completedTable").classList.remove("hidden");
    document.getElementById("completedHeading").classList.remove("hidden");
    document.getElementById("originalTbody").classList.remove("hidden");
  } else if (sorting === "All") {
    document.getElementById("processingTable").classList.remove("hidden");
    document.getElementById("processingHeading").classList.remove("hidden");
    document.getElementById("completedTable").classList.remove("hidden");
    document.getElementById("completedHeading").classList.remove("hidden");
    document.getElementById("originalTbody").classList.remove("hidden");
  }
}

// Show both tables initially
document.getElementById("processingTable").classList.remove("hidden");
document.getElementById("processingHeading").classList.remove("hidden");
document.getElementById("completedTable").classList.remove("hidden");
document.getElementById("completedHeading").classList.remove("hidden");
</script>

</body>
</html>