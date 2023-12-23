<?php
    // Process the contact form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        // Perform necessary actions (e.g., send email, store data, etc.)

        // Redirect to a thank you page
        header("Location: thank-you.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Pharmacy Supplier</title>
</head>
<body>
    <h1>Contact Us</h1>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea><br>
        <button type="submit">Send Message</button>
    </form>
</body>
</html>