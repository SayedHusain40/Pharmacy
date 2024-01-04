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

</style>
<?php
session_start();
include '../header.php';
if (isset($_GET['OrderID'])) {
  $orderId = $_GET['OrderID'];
  try {
    include '../Connection/init.php';
  
    $sql = "SELECT od.OrderID, od.UserID, od.TotalPrice, GROUP_CONCAT(CONCAT(pd.Name, ' - ', oi.Qty, ' qty BD [', oi.TotalPrice, '] <br>')) AS Products, od.PaymentMethod, od.Status, od.OrderDate
            FROM `order data` AS od
            INNER JOIN `ordered item` AS oi ON od.OrderID = oi.OrderID
            INNER JOIN `product data` AS pd ON oi.ProductID = pd.ProductID WHERE od.OrderID = ?
            GROUP BY od.OrderID
            ORDER BY od.OrderID";
  
    $stmt = $db->prepare($sql);
    $stmt->execute([$orderId]);

    echo "
    <div class='Container'>
    <div class='row'>
    <div class='col-xl-12'>
    <table>
            <tr>
                <th>OrderID</th>
                <th>UserID</th>
                <th>TotalPrice</th>
                <th>Products</th>
                <th>PaymentMethod</th>
                <th>Status</th>
                <th>OrderDate</th>
            </tr>";
    if ($stmt->rowCount() > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['OrderID']}</td>
                <td>{$row['UserID']}</td>
                <td>BD {$row['TotalPrice']}</td>
                <td>{$row['Products']}</td>
                <td>{$row['PaymentMethod']}</td>
                <td>{$row['Status']}</td>
                <td>{$row['OrderDate']}</td>
              </tr>";
      }
    } else {
      echo '<p>No order data found.</p>';
    }
    echo "</table>";
    echo "</div>
    </div>
    </div>";

  } catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
  }

  // Close the database connection
  $db = null;
}
?>

