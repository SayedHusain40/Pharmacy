<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy System - Staff Portal</title>
    <link rel="stylesheet" href="../css/s.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Pharmacy System - Staff Portal</h1>
    </header>

    <!-- Product Request Form Section -->
    <section id="product-request">
        <h2>Product Request</h2>
        <form action="process_request.php" method="POST">
            <label for="product-name">Product Name:</label>
            <input type="text" id="product-name" name="product-name" required><br>

            <label for="supplier-name">Supplier Name:</label>
            <input type="text" id="supplier-name" name="supplier-name" required><br>

            <label for="product-description">Product Description:</label>
            <textarea id="product-description" name="product-description" required></textarea><br>

            <button type="submit">Submit Request</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 Pharmacy System. All rights reserved.</p>
    </footer>
</body>
</html>