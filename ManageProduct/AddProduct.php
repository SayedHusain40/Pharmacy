<?php
session_start();
$errors = [];
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

        #for duplicated email & username 
        $stmt = $db->prepare("SELECT * FROM `product data` WHERE `Name` = ?");
        $stmt->execute([$name]);
        $result = $stmt->fetch();
  
        if ($result) {
        if ($name === $result['Name']) {
        $errors['duplicateName'] = "Product Name already exists!";
        }
        }

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
if (count($errors) === 0) {
    try {
        require('../Connection/db.php');
    // Insert the product data into the database
    $stmt = $db->prepare("INSERT INTO `product data` (Name, Type, RequiresPrescription, Description, ExpireDate, Quantity, Availability, Price, Points, Brand, Photo, Alternate)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $type, $requiresPrescription, $description, $expireDate, $quantity, $availability, $price, $points, $brand, $photo, $alternate]);

   
    if ($stmt->rowCount() === 1) {
         // Redirect to a success page or perform any other necessary actions
    header("Location: ../ManageProduct/ViewProduct.php");
    exit();
    } else {
        $errors['Err'] = "Something went wrong while inserting data";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="../css/product.css" />

    <style>
        small {
            margin-top: -26px;
            font-weight: bold;
            margin-left: 60px;
            color: #E51A92;
        }
    </style>
</head>
<body>
    <header>
        <?php include "../header.php"; ?>
        <h1>Add Product</h1>
    </header>
    <div class="container">
        <div class="form">
            <section>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" />
                        <small> <?php echo isset($errors['duplicateName']) ? '<i class="error-icon fas fa-exclamation-circle"></i> ' . $errors['duplicateName'] : ''; ?> </small>
                    </div>

    <div class="form-group">
        <label for="type">Type:</label>
        <select id="type" name="type" class="form-control" required>
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
        <input type="text" id="alternate" name="alternate" class="form-control">
        <select id="alternate" name="alternate" class="form-control">
    <?php
    try {
        $stmt = $db->prepare("SELECT * FROM `product data`");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($products) {
            foreach ($products as $product) {
                $productName = $product['Name'];
                $ProductID = $product['ProductID'];
                echo '<option value="'. $productName .'">' . $ProductID . ' - ' . $productName . '</option>';
            }
        } else {
            echo '<option value="">No products found</option>';
        }
    } catch (PDOException $e) {
        echo '<option value="">Error retrieving data: ' . $e->getMessage() . '</option>';
    }
    ?>
</select>
    </div>
    <div class="Add">
    <button type="submit">Add Product</button>
    </div>
</form>
    </section>

    

</body>
</html>
</div>
</div>