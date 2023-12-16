<?php
session_start();

include '../Connection/init.php';

$stmt = $db->prepare("
    SELECT DISTINCT ud.UserID, ud.Username, cd.FirstName, cd.LastName
    FROM `user data` ud
    LEFT JOIN `Customer data` cd ON ud.UserID = cd.UserID
    UNION
    SELECT DISTINCT ud.UserID, ud.Username, sd.FirstName, sd.LastName
    FROM `user data` ud
    LEFT JOIN `Staff data` sd ON ud.UserID = sd.UserID
    UNION
    SELECT DISTINCT ud.UserID, ud.Username, sd.FirstName, sd.LastName
    FROM `user data` ud
    LEFT JOIN `Supplier data` sd ON ud.UserID = sd.UserID
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $db->prepare("SELECT * FROM `product data`");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedProducts = $_POST['products'];
    $quantities = $_POST['quantities'];
    $totalPrice = 0;
    $totalPrices = 0;
    $totalPoint = 0;
    $totalPoints = 0;

    try {
        $db->beginTransaction();
        if (isset($_POST['users'])) {  //هالسطرين بس لصفحة الادمن و الستاف
            $selectedUserId = $_POST['users']; //هالسطرين بس لصفحة الادمن و الستاف
             
            //اذا بنشيل السطرين الي فوق بصير عندنا ايرور يمكن بسبب الكيرلي براكت فبسوي عليه ملاحظه 

        // Insert the order into the order data table
        $stmt = $db->prepare("INSERT INTO `order data` (`UserID`, `TotalPrice`, `Status`, `OrderDate`, `AccBalance`, `MembershipPoints`) VALUES (:userId, :totalPrice, 'Pending', CURDATE(), NULL, :totalPoints)");
        $stmt->bindParam(':userId', $selectedUserId); // for user page it will be  $_SESSION['user_id'] instead of $selectedUserId
        $stmt->bindParam(':totalPrice', $totalPrices);
        $stmt->bindParam(':totalPoints', $totalPoints);
        $stmt->execute();

        $orderId = $db->lastInsertId();

        // Insert the ordered items into the ordered item table
        for ($i = 0; $i < count($selectedProducts); $i++) {
            $productId = $selectedProducts[$i];
            $quantity = $quantities[$i];

            // Fetch the selected product details
            $stmt = $db->prepare("SELECT * FROM `product data` WHERE `ProductID` = :productId");
            $stmt->bindParam(':productId', $productId);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
                 // Calculate the total price and points
                 $totalPrice = $product['Price'] * $quantity;
                 $totalPoint = $product['Points'] * $quantity;

            // Insert the selected product into the ordered item table
            $stmt = $db->prepare("INSERT INTO `ordered item` (`OrderID`, `ProductID`, `Qty`, `TotalPrice`, `TotalPoints`) VALUES (:orderId, :productId, :quantity, :productPrice, :productPoints)");
            $stmt->bindParam(':orderId', $orderId);
            $stmt->bindParam(':productId', $productId);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':productPrice', $totalPrice);
            $stmt->bindParam(':productPoints', $totalPoint);
            $stmt->execute();

            $totalPrices += $product['Price'] * $quantity;
            $totalPoints += $product['Points'] * $quantity;
        }

        // Update the total price and points in the order data table
        $stmt = $db->prepare("UPDATE `order data` SET `TotalPrice` = :totalPrice, `MembershipPoints` = :totalPoints WHERE `OrderID` = :orderId");
        $stmt->bindParam(':totalPrice', $totalPrices);
        $stmt->bindParam(':totalPoints', $totalPoints);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();

        $db->commit();

        echo "Order placed successfully!";
        echo "Total Price: $totalPrices";
        echo "<p id='total-points'>Total Points: $totalPoints</p>";
    } // دا الي كنت اقصده فوق 
    } catch (PDOException $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
echo "<style>
    /* CSS styles for the table and other elements */
    /* ... */

    /* CSS styles for the multi-select element */
    .multi-select {
        width: 300px;
        height: 150px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 4px;
        overflow-y: auto;
    }
</style>";

echo "<form method='POST' id='order-form'>";
echo '<select name="users">';
foreach ($users as $user) {
  echo '<option value="' . $user['UserID'] . '">';
  echo $user['UserID'] . ' - ' . $user['Username'] . ' - ' . $user['FirstName'] . ' ' . $user['LastName'];
  echo '</option>';
}
echo '</select>';
echo "<table>";
echo "<tr>";
echo "<th>Product ID</th>";
echo "<th>Photo</th>";
echo "<th>Name</th>";
echo "<th>Type</th>";
echo "<th>Requires Prescription</th>";
echo "<th>Description</th>";
echo "<th>Expiration Date</th>";
echo "<th>Quantity</th>";
echo "<th>Availability</th>";
echo "<th>Price</th>";
echo "<th>Points</th>";
echo "<th>Brand</th>";
echo "<th>Alternate</th>";
echo "<th>Select</th>";
echo "</tr>";

foreach ($products as $product) {
    $productId = $product['ProductID'];
    $productName = $product['Name'];
    $productType = $product['Type'];
    $requiresPrescription = $product['RequiresPrescription'];
    $description = $product['Description'];
    $expireDate = $product['ExpireDate'];
    $quantity = $product['Quantity'];
    $availability = $product['Availability'];
    $price = $product['Price'];
    $points = $product['Points'];
    $brand = $product['Brand'];
    $photo = $product['Photo'];
    $alternate = $product['Alternate'];

    echo "<tr>";
    echo "<td>$productId</td>";
    echo '<td><img src="../images/'. $photo .'" alt="Product Image" width = "160px" height: "200px" class="product-image" id="product-image"></td>';
    echo "<td>$productName</td>";
    echo "<td>$productType</td>";
    echo "<td>$requiresPrescription</td>";
    echo "<td>$description</td>";
    echo "<td>$expireDate</td>";
    echo "<td>$quantity<br><select name='quantities[]' class='quantity-select'>";
   for ($i = 1; $i <= 10; $i++) { 
    echo"<option value='";
    echo $i;
    echo"'>";
    echo $i;
    echo"</option>";
    }
    echo"</select></td>";
    echo "<td>$availability</td>";
    echo "<td>$price</td>";
    echo "<td><span class='points'>$points</span></td>";
    echo "<td>$brand</td>";
    echo "<td>$alternate</td>";
    echo "<td><input type='checkbox' name='products[]' value='$productId'></td>";
    echo "</tr>";
}

echo "</table>";
echo "<button type='submit'>Place Order</button>";
echo "</form>";
echo "<a href='../Pharmacy/Interface/HomePageAdmin.php'> sd </a> ";
?>

<script>
// JavaScript code to update the total price and points based on selected quantities
// Get the form and quantity select elements
const form = document.getElementById('order-form');
const quantitySelects = form.getElementsByClassName('quantity-select');
const totalPriceElement = document.getElementById('total-price');
const totalPointsElement = document.getElementById('total-points');

// Add event listeners to quantity select elements
Array.from(quantitySelects).forEach(function (select) {
  select.addEventListener('change', updateTotalPriceAndPoints);
});

// Function to update the total price and points based on selected quantities
function updateTotalPriceAndPoints() {
  let totalPrice = 0;
  let totalPoints = 0;

  // Loop through the select elements and calculate the total price and points
  Array.from(quantitySelects).forEach(function (select) {
    const quantity = parseInt(select.value);
    const productPrice = parseFloat(select.parentNode.parentNode.querySelector('.price').textContent);
    const productPoints = parseInt(select.parentNode.parentNode.querySelector('.points').textContent);

    totalPrice += quantity * productPrice;
    totalPoints += quantity * productPoints;
  });

  // Display the updated total price and points
  totalPriceElement.textContent = 'Total Price: $' + totalPrice.toFixed(2);
  totalPointsElement.textContent = 'Total Points: ' + totalPoints;
}
</script>