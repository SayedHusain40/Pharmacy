To track orders in PHP, you can follow these general steps:

1. Database Setup: Set up a database to store order information. Create a table to store order details, such as order ID, customer information, order status, timestamps, and any other relevant information.

2. Order Placement: When a customer places an order, capture the necessary information, such as customer details, product details, and any additional order-related information. Insert this information into the database, assigning a unique order ID.

3. Order Status Updates: Provide a way to update the order status. This can be done through an admin panel or by integrating with a shipping service provider's API to receive real-time updates on the order status. Update the order status in the database accordingly.

4. Order Tracking Page: Create an order tracking page where customers can input their order ID or other required information to view the status of their order. Retrieve the order details from the database based on the provided information and display the current status to the customer.

Here's a simplified example of how you can implement order tracking in PHP:

```php
<?php
// Database connection details
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Function to get order status based on order ID
    function getOrderStatus($orderID) {
        global $conn;
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT status FROM orders WHERE order_id = :orderID");
        
        // Bind the parameter
        $stmt->bindParam(':orderID', $orderID);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch the status
        $status = $stmt->fetchColumn();
        
        return $status;
    }

    // Get the order ID from the user input
    $orderID = $_POST['order_id'];

    // Check if order ID is provided
    if (!empty($orderID)) {
        // Get the order status
        $status = getOrderStatus($orderID);
        
        // Display the order status
        if ($status) {
            echo "Order ID: " . $orderID . "<br>";
            echo "Status: " . $status;
        } else {
            echo "Order not found.";
        }
    } else {
        echo "Please provide an order ID.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>
```

In the above example, the `getOrderStatus` function retrieves the order status from the database based on the provided order ID. It prepares an SQL statement, binds the order ID parameter, executes the query, and fetches the status.

This is just a basic example to get you started. You may need to adapt and expand the code according to your specific requirements, database structure, and business logic.