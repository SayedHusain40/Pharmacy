<?php
session_start();

include '../Connection/init.php';

// Check if the productid parameter exists in the URL
if (isset($_GET['ProductID'])) {
    $productIds = $_GET['ProductID'];

    // Convert the product IDs into an array
    $productIds = explode(',', $productIds);

    // Iterate over the product IDs
    foreach ($productIds as $productId) {
        // Retrieve the product details based on the productid
        $stmt = $db->prepare("SELECT * FROM `product data` WHERE ProductID = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the product exists
        if ($product) {
            // Display the product details or perform any other desired actions
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

            // Display the product details on the page or perform any other desired actions
            echo '<form action="../ManageProduct/EditProduct.php" method="POST" enctype="multipart/form-data">
            <h1> #'. $productId ,$productName .' </h1> 
            <div class="form-group">
            <label for="photo">Photo:</label>
            <img src="../images/' . $photo . '" alt="Product Image" class="product-image" id="product-image" width="150px" height="170px">
            
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="' . $productName . '" disabled>
        </div>
        
        <div class="form-group">
        <label for="type">Type:</label>
        <select id="type" name="type" class="form-control" disabled>
    <option value="Medicine">Medicine</option>
    <option value="Minerals">Minerals</option>
    <option value="Vitamins">Vitamins</option>
    <option value="Supplements">Supplements</option>
    <option value="Common Conditions">Common Conditions</option>
    <option value="Skin Care">Skin Care</option>
    <option value="Oral Care">Oral Care</option>
    <option value="Bath & Shower">Bath & Shower</option>
    <option value="Hair Wash & Care">Hair Wash & Care</option>
    <option value="Body Supports">Body Supports</option>
    <option value="Feminine Hygiene">Feminine Hygiene</option>
    <option value="Mens Grooming">Mens Grooming</option>
    <option value="Deodorants">Deodorants</option>
    <option value="Health Accessories">Health Accessories</option>
    <option value="First Aid">First Aid</option>
    <option value="Diagnostics & Monitoring">Diagnostics & Monitoring</option>
    <option value="Baby Skin Care & Accessories">Baby Skin Care & Accessories</option>
    </select>
    </div>
        
        <div class="form-group">
            <label for="requires_prescription">Requires Prescription:</label>
            <input type="checkbox" id="requires_prescription" name="requires_prescription" ' . ($requiresPrescription ? 'checked' : '') . ' disabled>
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" disabled>' . $description . '</textarea>
        </div>
        
        <div class="form-group">
            <label for="expire_date">Expiration Date:</label>
            <input type="date" id="expire_date" name="expire_date" class="form-control" value="' . $expireDate . '" disabled>
        </div>
        
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required value="' . $quantity . '" disabled>
        </div>
        
        <div class="form-group">
            <label for="availability">Availability:</label>
            <input type="checkbox" id="availability" name="availability" ' . ($availability ? 'checked' : '') . ' disabled>
        </div>
        
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" class="form-control" required value="' . $price . '" disabled>
        </div>
        
        <div class="form-group">
            <label for="points">Points:</label>
            <input type="number" id="points" name="points" class="form-control" value="' . $points . '" disabled>
        </div>
        
        <div class="form-group">
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" class="form-control" value="' . $brand . '" disabled>
        </div>
        
        <div class="form-group">
            <label for="alternate">Alternate:</label>
            <input type="text" id="alternate" name="alternate" class="form-control" required value="' . $alternate . '" disabled>
        </div>
        
        
        </form>'; // Add a horizontal line between each product
        } else {
            // Product not found
            echo 'Product with ID ' . $productId . ' not found.<br>';
        }
    }
} else {
    // productid parameter is missing
    echo 'Invalid request.';
}
?>
