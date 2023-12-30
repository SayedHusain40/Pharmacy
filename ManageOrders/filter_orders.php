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
$stmt = $db->prepare("SELECT * FROM `order data` WHERE Status = 'Completed' ORDER BY OrderDate DESC");
$stmt->execute();
$completedData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to generate the status select dropdown options
function getStatusOptions($selectedStatus) {
    $statusOptions = array(
        'Confirmed', 'Processing', 'Ready to Pickup', 'Out for Delivery'
    );
    $options = '';
    foreach ($statusOptions as $status) {
        $selected = ($selectedStatus === $status) ? 'selected' : '';
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
$selectedSorting = isset($_SESSION['Sorting']) && in_array($_SESSION['Sorting'], $Allstatuses) ? $_SESSION['Sorting'] : null;
$sortedData = [];

// Check if a status is selected
if (isset($selectedSorting)) {
    $stmt = $db->prepare("SELECT * FROM `order data` WHERE Status = :status");
    $stmt->bindParam(':status', $selectedSorting);
    $stmt->execute();

    // Fetch the sorted data
    $sortedData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $db->prepare("SELECT * FROM `order data`");
    $stmt->execute();

    // Fetch all data
    $sortedData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Select tag for sorting -->
<label class="inline-elements" for="sorting">Sort by status:</label>
<select class="inline-elements" id="sorting" name="sorting">
  <option value="">All</option>
  <?php echo getStatusOptions($selectedSorting); ?>
</select>

<!-- Table to display data -->
<table>
  <tr>
    <th>Order ID</th>
    <th>Status</th>
    <th>Order Date</th>
    <th>Action</th>
  </tr>
  <?php
  foreach ($sortedData as $row) {
      echo "<tr>";
      echo "<td>" . $row['OrderID'] . "</td>";
      echo "<td>" . $row['Status'] . "</td>";
      echo "<td>" . $row['OrderDate'] . "</td>";
      echo "<td><button class='update-icon' onclick='updateStatus(" . $row['OrderID'] . ")'><i class='fas fa-edit'></i><span>Update</span></button></td>";
      echo "</tr>";
  }
  ?>
</table>

<!-- Script for AJAX request -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function updateStatus(orderID) {
      var newStatus = prompt("Enter the new status:");
      if (newStatus != null) {
          $.ajax({
              type: 'POST',
              url: 'update.php',
              data: { orderID: orderID, newStatus: newStatus },
              success: function(response) {
                  alert(response);
                  location.reload();
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText);
              }
          });
      }
  }

  $(document).ready(function() {
      $('#sorting').change(function() {
          var selectedStatus = $(this).val();
          $.ajax({
              type: 'POST',
              url: '../ManageOrders/filter.php',
              data: { selectedStatus: selectedStatus },
              success: function(response) {
                  $('#table-container').html(response);
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText);
              }
          });
      });
  });
</script>
</body>
</html>