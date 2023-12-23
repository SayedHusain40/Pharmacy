<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy System - Supplier Portal</title>
    <link rel="stylesheet" href="../css/s.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Pharmacy System - Supplier Portal</h1>
    </header>

    <!-- Product Submission Form Section -->
    <section id="product-submission">
        <h2>Product Submission</h2>
        <form action="process_submission.php" method="POST">
            <label for="product-name">Product Name:</label>
            <input type="text" id="product-name" name="product-name" required><br>

            <label for="product-description">Product Description:</label>
            <textarea id="product-description" name="product-description" required></textarea><br>

            <button type="submit">Submit Product</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 Pharmacy System. All rights reserved.</p>
    </footer>
</body>
</html>