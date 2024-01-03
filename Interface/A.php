<script>
        //Step 4: Create a function to retrieve the low stock items.
function getLowStockItems($db) {
    $sql = "SELECT items.name, stock.quantity FROM items JOIN stock ON items.id = stock.item_id WHERE stock.quantity < 10";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Item: " . $row["name"]. " - Quantity: " . $row["quantity"]. "<br>";
        }
    } else {
        echo "No low stock items found.";
    }
}

//Step 5: Create a function to retrieve the total number of items sold today.
function getItemsSoldToday($db) {
    $today = date('Y-m-d');
    $sql = "SELECT SUM(quantity) as total_quantity FROM sales WHERE date = '$today'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Items sold today: " . $row["total_quantity"];
    } else {
        echo "No items sold today.";
    }
}

//Step 6: Create a function to retrieve the month's best seller.
function getMonthBestSeller($db) {
    $thisMonth = date('Y-m');
    $sql = "SELECT items.name, SUM(sales.quantity) as total_quantity FROM sales JOIN items ON sales.item_id = items.id WHERE DATE_FORMAT(sales.date, '%Y-%m') = '$thisMonth' GROUP BY sales.item_id ORDER BY total_quantity DESC LIMIT 1";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Month Best Seller: " . $row["name"]. " - Quantity: " . $row["total_quantity"]. "<br>";
    } else {
        echo "No month best seller found.";
    }
}

//Step 7: Call the functions in your PHP script.

getLowStockItems($db);
echo "<br>";
getItemsSoldToday($db);
echo "<br>";
getMonthBestSeller($db);

    </script>