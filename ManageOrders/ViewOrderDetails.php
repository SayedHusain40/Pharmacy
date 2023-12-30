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
include '../Connection/init.php';
$sql = "SELECT od.OrderID, od.UserID, od.TotalPrice, GROUP_CONCAT(CONCAT(pd.Name, ' - ', oi.Qty, ' qty BD [', oi.TotalPrice, '] <br>')) AS Products, od.PaymentMethod, od.Status, od.OrderDate
          FROM `order data` AS od
          INNER JOIN `ordered item` AS oi ON od.OrderID = oi.OrderID
          INNER JOIN `product data` AS pd ON oi.ProductID = pd.ProductID
          GROUP BY od.OrderID
          ORDER BY od.OrderID";

try {
    // Execute the modified query
    $query = $db->query($sql);

    // Fetch and display the data
    echo "<table>
            <tr>
                <th>OrderID</th>
                <th>UserID</th>
                <th>TotalPrice</th>
                <th>Products</th>
                <th>PaymentMethod</th>
                <th>Status</th>
                <th>OrderDate</th>
                <th>Transaction</th>
            </tr>";

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        // Retrieve transaction details based on the order's TotalPrice
        $transaction = "No transaction";
        if ($row['TotalPrice'] > 0) {
            $transaction = "Paid BD " . $row['TotalPrice'] . " via " . $row['PaymentMethod'];
        }

        echo "<tr>
                <td>{$row['OrderID']}</td>
                <td>{$row['UserID']}</td>
                <td>BD {$row['TotalPrice']}</td>
                <td>{$row['Products']}</td>
                <td>{$row['PaymentMethod']}</td>
                <td>{$row['Status']}</td>
                <td>{$row['OrderDate']}</td>
                <td>$transaction</td>
              </tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
}

// Close the database connection
$db = null;
?>
