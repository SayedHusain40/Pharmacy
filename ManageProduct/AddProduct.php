<?php
session_start();

include '../Connection/init.php'; // Replace with your own database configuration file

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $name = $_POST['name'];
    $type = $_POST['type'];
    $requiresPrescription = isset($_POST['requires_prescription']) ? 1 : 0;
    $description = $_POST['description'];
    $expireDate = $_POST['expire_date'];
    $quantity = $_POST['quantity'];
    $availability = isset($_POST['availability']) ? 1 : 0;
    $price = $_POST['price'];
    $points = isset($_POST['points']) ? $_POST['points'] : null;
    $brand = isset($_POST['brand']) ? $_POST['brand'] : null;
    $photo = isset($_POST['photo']) ? $_POST['photo'] : null;
    $alternate = $_POST['alternate'];

    // Validate and sanitize the input (implement your own validation logic)

 // Handle the uploaded photo
$photo = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $photoTmpPath = $_FILES['photo']['tmp_name'];
    $photoFileName = $_FILES['photo']['name'];
    $photoFileExt = strtolower(pathinfo($photoFileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    // Check if the file extension is allowed
    if (in_array($photoFileExt, $allowedExtensions)) {
        $newPhotoFileName = uniqid() . '.' . $photoFileExt;
        $photoDestination = '../images/' . $newPhotoFileName;

        // Move the uploaded file to the desired location
        if (move_uploaded_file($photoTmpPath, $photoDestination)) {
            $photo = $photoDestination;
        }
    }
}

    // Insert the product data into the database
    $stmt = $db->prepare("INSERT INTO `product data` (Name, Type, RequiresPrescription, Description, ExpireDate, Quantity, Availability, Price, Points, Brand, Photo, Alternate)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $type, $requiresPrescription, $description, $expireDate, $quantity, $availability, $price, $points, $brand, $photo, $alternate]);

    // Redirect to a success page or perform any other necessary actions
    header("Location: ../ManageProduct/ViewProduct.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/.css">
</head>
<body>
    <header>
        <h1>Add Product</h1>
    </header>

    <section>
        <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="type">Type:</label>
        <input type="text" id="type" name="type" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="requires_prescription">Requires Prescription:</label>
        <input type="checkbox" id="requires_prescription" name="requires_prescription">
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label for="expire_date">Expiration Date:</label>
        <input type="date" id="expire_date" name="expire_date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="availability">Availability:</label>
        <input type="checkbox" id="availability" name="availability">
    </div>

    <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="points">Points:</label>
        <input type="number" id="points" name="points" class="form-control">
    </div>

    <div class="form-group">
        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand" class="form-control">
    </div>

    <div class="form-group">
        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo" class="form-control">
    </div>

    <div class="form-group">
        <label for="alternate">Alternate:</label>
        <input type="text" id="alternate" name="alternate" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Add Product</button>
</form>
    </section>
</body>
</html>