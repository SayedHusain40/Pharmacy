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

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($tables as $table) {
            if (isset($_POST[$table])) { // Check if the form field for $table exists in $_POST
                $memberIds = $_POST[$table]; // Get the array of selected member IDs from the form data

                $stmt = $db->prepare("UPDATE $table SET member_id = :member_id, task_status = :task_status WHERE task_name = :task_name");
                $stmt->bindParam(':member_id', $memberId);
                $stmt->bindParam(':task_status', $taskStatus);
                $stmt->bindParam(':task_name', $taskName);

                foreach ($memberIds as $taskName => $selectedMemberIds) {
                    foreach ($selectedMemberIds as $memberId) {
                        $taskStatus = isset($_POST["{$table}_status"][$taskName][$memberId]) ? 'Done' : 'NotDone'; // Set task_status to 'Done' if checkbox is checked, 'NotDone' otherwise
                        $stmt->execute();
                    }
                }
            }
        }
    }

    echo "<style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        /* Styling checkboxes */

/* Hide the default checkbox */
input[type='checkbox'] {
  display: display;
}

/* Create a custom checkbox */
.custom-checkbox {
  display: inline-block;
  width: 20px;
  height: 20px;
  background-color: #4CAF;
  border-radius: 3px;
  cursor: pointer;
}

/* Style the checked state of the checkbox */
.custom-checkbox.checked {
  background-color: #4CAF;
}

/* Styling select elements */

/* Customize the appearance of the select box */
select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #fff;
  cursor: pointer;
}

/* Style the select element when it's open */
select:focus {
  outline: none;
  border-color: #2196F3;
  box-shadow: 0 0 0 1px #2196F3;
}
        
        button {
            margin-top: 10px;
            padding: 10px;
            background-color: #4CAF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        a {
            text-decoration: none;
            color: white;
        }
        
        button a:hover {
            text-decoration: none;
        }
    </style>";

    echo "<div class='container'>";
    echo "<form method='POST'>";
    echo "<table>";
    echo "<tr><th>Table Name</th><th>Task Name</th><th>Member ID</th><th>Task Status</th></tr>";

    foreach ($tables as $table) {
        $stmt = $db->prepare("SELECT task_name, member_id, task_status FROM $table");
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as $index => $task) {
            $taskName = $task['task_name'];
            $memberId = $task['member_id'];
            $taskStatus = $task['task_status'];

            echo "<tr>";
            if ($index === 0) {
                echo "<td rowspan='" . count($tasks) . "'>$table</td>";
            }
            echo "<td>$taskName</td>";
            echo "<td>";

            $stmt = $db->prepare("SELECT Id, name FROM member");
            $stmt->execute();
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<select name='{$table}[$taskName][]' multiple>"; // Enclose the array notation in curly braces to avoid parsing issues
            foreach ($members as $member) {
                $id = $member['Id'];
                $name = $member['name'];
                $selected = ($id == $memberId) ? 'selected' : '';
                echo "<option value='$id' $selected>$name</option>";
            }
            echo "</select>";

            echo "</td>";
            echo "<td>";

            echo "<input type='checkbox' name='{$table}_status[$taskName][$memberId]' value='Done' ";
            if ($taskStatus === 'Done'){
                echo "checked";
            }
            echo ">";

            echo "</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
    echo "<button type='submit'>Update</button> <hr>"; 
    echo "<button> <a href='../Pharmacy/g.php'> Track ! </a> </button>";
    echo "</form>";
    echo "</div>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
