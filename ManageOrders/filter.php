<?php
session_start();
include '../Connection/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected status from the AJAX request
    $selectedStatus = $_POST['selectedStatus'];

    // Check if a status is selected
    if (!empty($selectedStatus)) {
        // Prepare the statement to filter orders by the selected status
        $stmt = $db->prepare("SELECT * FROM `order data` WHERE Status = :selectedStatus");
        $stmt->bindParam(':selectedStatus', $selectedStatus);
        $stmt->execute();

        // Fetch the filtered data
        $filteredData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // If no status is selected, fetch all data
        $stmt = $db->prepare("SELECT * FROM `order data`");
        $stmt->execute();

        // Fetch all data
        $filteredData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Generate the HTML for the filtered data
    $html = '<table>
                <tr>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>';
    foreach ($filteredData as $row) {
        $html .= '<tr>';
        $html .= '<td>' . $row['OrderID'] . '</td>';
        $html .= '<td>' . $row['Status'] . '</td>';
        $html .= '<td>' . $row['OrderDate'] . '</td>';
        $html .= '<td><button class="update-icon" onclick="updateStatus(' . $row['OrderID'] . ')"><i class="fas fa-edit"></i><span>Update</span></button></td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    // Send the HTML response back to the AJAX request
    echo $html;
} else {
    echo "Invalid request.";
}