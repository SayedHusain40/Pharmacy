<?php
session_start(); // Add session_start() to start the session

try {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $db = new PDO('mysql:host=localhost;dbname=groupwork;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tables = array('Account', 'Interface', 'ManageOffers', 'ManageOrders', 'ManageProducts', 'ManageUsers', 'Reports', 'Function');

    $success = false;
    $error = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($tables as $table) {
            if (isset($_POST[$table])) { // Check if the form field for $table exists in $_POST
                $memberId = test_input($_POST[$table]);
                $taskId = $_POST[$table]; // Get the selected member ID from the form data
                $stmt = $db->prepare("UPDATE $table SET member_id = :member_id WHERE task_name = :task_name");
                $stmt->bindParam(':member_id', $memberId);
                $stmt->bindParam(':task_name', $table);
                $stmt->execute();
            }
        }
        $success = true;
    }

    echo "<form name='R' method='POST'>";
    echo "<table border=1>";
    echo "<tr><th>Table Name</th><th>Task Name</th><th>Member</th></tr>";

    foreach ($tables as $table) {
        $stmt = $db->prepare("SELECT task_name, member_id FROM $table");
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<tr><td rowspan='" . count($tasks) . "'>$table</td>";

        $firstRow = true;
        foreach ($tasks as $task) {
            if (!$firstRow) {
                echo "<tr>";
            }

            $taskId = $task['member_id'];
            $taskName = $task['task_name'];

            echo "<td>$taskName</td>";
            echo "<td>";

            $stmt = $db->prepare("SELECT Id, name FROM member");
            $stmt->execute();
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<select name='$table' title='Choose a member'>";
            foreach ($members as $member) {
                $memberId = $member['Id'];
                $memberName = $member['name'];
                $selected = ($memberId == $taskId) ? 'selected' : '';
                echo "<option value='$memberId' $selected>$memberName</option>";
            }
            echo "</select>";

            echo "</td>";

            $firstRow = false;
        }
    }

    echo "</table>";
    echo "<button type='submit'>Save Changes</button>";
    echo "</form>";

    if ($success) {
        echo "<p>Changes saved successfully.</p>";
    } else if ($error) {
        echo "<p>An error occurred. Please try again.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>