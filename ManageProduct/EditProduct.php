<?php
// Okay If I have a button value ProductID from product data
session_start();
// SEditProduct.php
include '../Connection/init.php';
// Retrieve the product ID from the session
$productId = $_SESSION['productId'];



$stmt = $db->prepare("SELECT * FROM `product data` WHERE ProductID = :productId");
$stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Query the database or perform any necessary operations to retrieve the product details based on the product ID
// Replace this with your own logic to fetch the product details

// Convert the product data to JSON format
$response = json_encode($product);


echo $response;
?>
<form action="../ManageProduct/update_product.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo $product['name']; ?>" disabled>
    </div>

<div class="form-group">
    <label for="type">Type:</label>
    <input type="text" id="type" name="type" class="form-control" value="<?php echo $product['type']; ?>" disabled>
</div>

<div class="form-group">
    <label for="requires_prescription">Requires Prescription:</label>
    <input type="checkbox" id="requires_prescription" name="requires_prescription" <?php echo $product['requires_prescription'] ? 'checked' : ''; ?> disabled>
</div>

<div class="form-group">
    <label for="description">Description:</label>
    <textarea id="description" name="description" class="form-control" disabled><?php echo $product['description']; ?></textarea>
</div>

<div class="form-group">
    <label for="expire_date">Expiration Date:</label>
    <input type="date" id="expire_date" name="expire_date" class="form-control" value="<?php echo $product['expire_date']; ?>" disabled>
</div>

<div class="form-group">
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" class="form-control" required value="<?php echo $product['quantity']; ?>" disabled>
</div>

<div class="form-group">
    <label for="availability">Availability:</label>
    <input type="checkbox" id="availability" name="availability" <?php echo $product['availability'] ? 'checked' : ''; ?> disabled>
</div>

<div class="form-group">
    <label for="price">Price:</label>
    <input type="number" id="price" name="price" step="0.01" class="form-control" required value="<?php echo $product['price']; ?>" disabled>
</div>

<div class="form-group">
    <label for="points">Points:</label>
    <input type="number" id="points" name="points" class="form-control" value="<?php echo $product['points']; ?>" disabled>
</div>

<div class="form-group">
    <label for="brand">Brand:</label>
    <input type="text" id="brand" name="brand" class="form-control" value="<?php echo $product['brand']; ?>" disabled>
</div>

<div class="form-group">
    <label for="photo">Photo:</label>
    <input type="file" id="photo" name="photo" class="form-control" disabled>
</div>

<div class="form-group">
    <label for="alternate">Alternate:</label>
    <input type="text" id="alternate" name="alternate" class="form-control" required value="<?php echo $product['alternate']; ?>" disabled>
</div>

<button type="button" onclick="enableEditMode()" class="btn btn-primary">Edit</button>
    <button type="submit" id="updateBtn" class="btn btn-primary" style="display: none;">Update</button>
    <button type="button" onclick="cancelEdit()" class="btn btn-secondary" style="display: none;">Cancel</button>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function enableEditMode() {
        // Enable editing by removing the disabled attribute from all input fields
        const inputs = document.querySelectorAll('input, textarea');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].removeAttribute('disabled');
        }

        // Show the Update and Cancel buttons, hide the Edit button
        document.getElementById('updateBtn').style.display = 'block';
        document.getElementById('cancelBtn').style.display = 'block';
        document.getElementById('editBtn').style.display = 'none';
    }

    function cancelEdit() {
        // Reload the page to cancel changes
        location.reload();
    }
</script>