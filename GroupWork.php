<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=groupwork;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tables = array('Account', 'Interface', 'ManageOffers', 'ManageOrders', 'ManageProducts', 'ManageUsers', 'Reports', 'Function');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($tables as $table) {
            $taskId = $_POST[$table]; // Get the selected member ID from the form data
            $stmt = $db->prepare("UPDATE $table SET member_id = :member_id WHERE task_name = :task_name");
            $stmt->bindParam(':member_id', $taskId);
            $stmt->bindParam(':task_name', $table);
            $stmt->execute();
        }
    }
    
    echo "<form method='POST'>";
    echo "<table>";
    echo "<tr><th>Table Name</th><th>Task Name</th><th>Member</th></tr>";
    
    foreach ($tables as $table) {
        $stmt = $db->prepare("SELECT task_name, member_id FROM $table");
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<tr><td rowspan='" . count($tasks) . "'>$table</td>";
        
        $firstRow = true;
        foreach ($tasks as $task) {
            if (!$firstRow) {
                echo "<tr>";
            }
            
            $taskId = $task['member_id'];
            $taskName = $task['task_name'];
            
            echo "<td>$taskName</td>";
            echo "<td>";
            echo "<select name='$table'>";
            
            $stmt = $db->prepare("SELECT id, name FROM member");
            $stmt->execute();
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($members as $member) {
              $memberId = $member['id'];
              $memberName = $member['name'];
              $selected = ($memberId == $taskId) ? 'selected' : '';
              echo "<option value='$memberId' $selected>$memberName</option>";
          }
            echo "</select>";
            echo "</td>";
            echo "</tr>";
            
            $firstRow = false;
        }
    }
    
    echo "</table>";
    echo "<button type='submit'>Save Changes</button>";
    echo "</form>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="">
    <h2>Account:</h2>
<ol>
  <li>
    Profile.php
    <select name="name" onchange="displayTask(this.value)">
      <option value="">Select a name</option>
      <option value="Fatima">Fatima</option>
      <option value="Karrar">Karrar</option>
      <option value="Elias">Elias</option>
      <option value="Sayed Hussain">Sayed Hussain</option>
    </select>
    <span id="taskDisplay"></span>
  </li>
  <li>
    EditProfile.php
    <select name="name" onchange="displayTask(this.value)">
      <option value="">Select a name</option>
      <option value="Fatima">Fatima</option>
      <option value="Karrar">Karrar</option>
      <option value="Elias">Elias</option>
      <option value="Sayed Hussain">Sayed Hussain</option>
    </select>
    <span id="taskDisplay"></span>
  </li>
  <li>
    Signup.php
    <select name="name" onchange="displayTask(this.value)">
      <option value="">Select a name</option>
      <option value="Fatima">Fatima</option>
      <option value="Karrar">Karrar</option>
      <option value="Elias">Elias</option>
      <option value="Sayed Hussain">Sayed Hussain</option>
    </select>
    <span id="taskDisplay"></span>
  </li>
  <li>
    Login.php
    <select name="name" onchange="displayTask(this.value)">
      <option value="">Select a name</option>
      <option value="Fatima">Fatima</option>
      <option value="Karrar">Karrar</option>
      <option value="Elias">Elias</option>
      <option value="Sayed Hussain">Sayed Hussain</option>
    </select>
    <span id="taskDisplay"></span>
  </li>
  <li>
    Logout.php
    <select name="name" onchange="displayTask(this.value)">
      <option value="">Select a name</option>
      <option value="Fatima">Fatima</option>
      <option value="Karrar">Karrar</option>
      <option value="Elias">Elias</option>
      <option value="Sayed Hussain">Sayed Hussain</option>
    </select>
    <span id="taskDisplay"></span>
  </li>
</ol>

<h2>Interface:</h2>
<ol>
  <li>HomePage.php</li>
  <li>HomePageCustomer.php</li>
  <li>HomePageStaff.php</li>
  <li>HomePageAdmin.php</li>
  <li>HomePageSupplier.php</li>
  <li>ShopByCategories.php</li>
  <li>ShopByBrand.php</li>
  <li>ShoppingCart.php</li>
  <li>AddToCart&Favourite.php</li>
  <li>ViewCart.php</li>
  <li>WishListPage.php</li>
  <li>PaymentPage.php</li>
  <li>Checkout.php</li>
  <li>AboutUs.php</li>
  <li>ContactUs.php</li>
  <li>FAQs.php</li>
</ol>

<h2>ManageOffers:</h2>
<ol>
  <li>AddOffer.php</li>
  <li>EditOffer.php</li>
  <li>ViewOffer.php</li>
</ol>

<h2>ManageOrders:</h2>
<ol>
  <li>AddOrder.php</li>
  <li>EditOrder.php</li>
  <li>ViewOrderList.php</li>
</ol>

<h2>ManageProduct:</h2>
<ol>
  <li>AddProduct.php</li>
  <li>EditProduct.php</li>
  <li>ViewProductList.php</li>
  <li>ProductDetails.php</li>
</ol>

<h2>ManageUsers:</h2>
<ol>
  <li>AddUsers.php</li>
  <li>EditUsers.php</li>
  <li>ViewUsers.php</li>
  <li>AddCustomer.php</li>
  <li>EditCustomer.php</li>
  <li>AddStaff.php</li>
  <li>EditStaff.php</li>
  <li>AddSupplier.php</li>
  <li>EditSupplier.php</li>
</ol>

<h2>Reports:</h2>
<ol>
  <li>CurrentInventoryReport.php</li>
  <li>MedicineReport.php</li>
  <li>UsersReport.php</li>
  <li>CustomerInformationReport.php</li>
  <li>StaffInformationReport.php</li>
  <li>CustomerOrderDetailsReport.php</li>
  <li>TopSellingMedicinesReport.php</li>
  <li>SupplierReport.php</li>
  <li>OrderReport.php</li>
  <li>OfferReport.php</li>
</ol>

<h2>Function:</h2>
<ol>
  <li>PayForOrder.php</li>
  <li>SearchItems</li>
  <li>Trackorder.php</li>
  <li>Rating.php</li>
  <li>Sorting.php</li>
  <li>PriceFilter.php</li>
</ol>
    </form>


    <script>
  function displayTask(name) {
    const taskDisplay = document.getElementById("taskDisplay");
    if (name === "Fatima") {
      taskDisplay.textContent = "Task for Fatima: ..."; // Replace ... with the actual task
    } else if (name === "Elias") {
      taskDisplay.textContent = "Task for Elias: ..."; // Replace ... with the actual task
    } else {
      taskDisplay.textContent = ""; // Clear task display if no name is selected
    }
  }
</script>
</body>
</html>