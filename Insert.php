<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=groupwork;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tables = array('Account', 'Interface', 'ManageOffers', 'ManageOrders', 'ManageProducts', 'ManageUsers', 'Reports', 'Function');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($tables as $table) {
            $taskId = $_POST[$table]; // Get the selected member ID from the form data
            $stmt = $db->prepare("UPDATE $table SET member_id = :member_id");
            $stmt->bindParam(':member_id', $taskId);
            $stmt->execute();
        }
    }
    
    echo "<form method='POST'>";
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
            echo "<select name='$table'>";
            
            $stmt = $db->prepare("SELECT Id, name FROM member");
            $stmt->execute();
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($members as $member) {
                $memberId = $member['Id'];
                $memberName = $member['name'];
                $selected = ($memberId == $taskId) ? 'selected' : '';
                echo "<option value='$memberId' $selected>$memberName</option>";
            }
            
            echo "</select>";
            echo "</td>";
            echo "</tr>";
            
            $firstRow = false;
        }
    }
    
    echo "</table>";
    echo "<button type='submit'>Save Changes</button>";
    echo "</form>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>