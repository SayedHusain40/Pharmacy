<?php
session_start();

include '../Connection/init.php';

// Check if the product_id key exists in the POST data
if (isset($_POST['ProductID'])) {
    $productId = $_POST['ProductID'];

    // Retrieve the product details based on the product_id
    $stmt = $db->prepare("SELECT * FROM `sproduct data` WHERE ProductID = :productId");
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists
    if ($product) {
        // Retrieve the updated form data
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

        // Handle the uploaded photo
        $photo = $product['Photo']; // Use the existing photo as a fallback

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photoTmpPath = $_FILES['photo']['tmp_name'];
            $photoFileName = $_FILES['photo']['name'];
            $photoFileExt = strtolower(pathinfo($photoFileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            // Check if the file extension is allowed
            if (in_array($photoFileExt, $allowedExtensions)) {
                $newPhotoFileName = uniqid() . '.' . $photoFileExt;
                $photoDestination = '../Simages/' . $newPhotoFileName;

                // Move the uploaded file to the desired location
                if (move_uploaded_file($photoTmpPath, $photoDestination)) {
                    $photo = $photoDestination;
                }
            }
        }

        // Perform validation on the form data
        if (validateFormData($name, $type, $requiresPrescription, $description, $expireDate, $quantity, $availability, $price, $points, $brand, $photo, $alternate)) {
            // Update the product fields in the database
            $updateStmt = $db->prepare("UPDATE `sproduct data` SET Name = :name, Type = :type, RequiresPrescription = :requiresPrescription, Description = :description, ExpireDate = :expireDate, Quantity = :quantity, Availability = :availability, Price = :price, Points = :points, Brand = :brand, Photo = :photo, Alternate = :alternate WHERE ProductID = :productId");
            $updateStmt->bindParam(':name', $name);
            $updateStmt->bindParam(':type', $type);
            $updateStmt->bindParam(':requiresPrescription', $requiresPrescription);
            $updateStmt->bindParam(':description', $description);
            $updateStmt->bindParam(':expireDate', $expireDate);
            $updateStmt->bindParam(':quantity', $quantity);
            $updateStmt->bindParam(':availability', $availability);
            $updateStmt->bindParam(':price', $price);
            $updateStmt->bindParam(':points', $points);
            $updateStmt->bindParam(':brand', $brand);
            $updateStmt->bindParam(':photo', $photo);
            $updateStmt->bindParam(':alternate', $alternate);
            $updateStmt->bindParam(':productId', $productId);

            if ($updateStmt->execute()) {
                // Product update is successful
// Redirect back to the previous page with success parameter
$redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'default_url.php';
header('Location: ' . $redirectUrl);
exit();
            } else {
                // Failed to update product
                echo "Failed to update product.";
            }
        } else {
            // Invalid form data
            echo "Invalid form data.";
        }
    } else {
        // Product not found
        echo 'Product not found.';
    }
} else {
    // product_id key is missing in the POST data
    echo 'Invalid request.';
}

function validateFormData($name, $type, $requiresPrescription, $description, $expireDate, $quantity, $availability, $price, $points, $brand, $photo, $alternate) {
    // Check if requiredfields are not empty
    if (empty($name) || empty($type) || empty($quantity) || empty($price) || empty($brand) || empty($alternate)) {
        return false;
    }

    // Validate quantity
    if (!is_numeric($quantity) || $quantity <= 0) {
        return false;
    }

    // Validate price
    if (!is_numeric($price) || $price <= 0) {
        return false;
    }

    // Validate points (if provided)
    if (!empty($points) && (!is_numeric($points) || $points < 0)) {
        return false;
    }

    // Add more validation rules for other fields if needed

    return true;
}
?>