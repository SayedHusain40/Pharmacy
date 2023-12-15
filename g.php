<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;dbname=groupwork;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Retrieve all tables dynamically
    $tables = array('Account', 'Interface', 'ManageOffers', 'ManageOrders', 'ManageProducts','Manageshoppingcart', 'ManageUsers', 'Managewishlist','Reports', 'Function');

    echo "<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        .member-name {
            font-weight: bold;
        }
        
        .task-status-done {
            color: green;
        }
        
        .task-status-not-done {
            color: red;
        }
        
        .back-button {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .back-button:hover {
            text-decoration: none;
        }
    </style>";

    echo "<table>";
    echo "<tr><th>Member</th>";

    foreach ($tables as $table) {
        echo "<th>$table</th>";
    }

    echo "</tr>";

    // Retrieve all members
    $stmt = $db->prepare("SELECT * FROM member");
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($members as $member) {
        $memberId = $member['Id'];
        $memberName = $member['name'];

        echo "<tr>";
        echo "<td class='member-name'>$memberName</td>";

        foreach ($tables as $table) {
            $stmt = $db->prepare("SELECT task_name, task_status FROM $table WHERE member_id = :member_id");
            $stmt->bindParam(':member_id', $memberId);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<td>";

            foreach ($tasks as $task) {
                $taskName = $task['task_name'];
                $taskStatus = $task['task_status'];

                $icon = ($taskStatus === 'Done') ? '✔️' : '❌';
                echo "$taskName $icon<br>";
            }

            echo "</td>";
        }

        echo "</tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<button class="back-button"> <a href="../Pharmacy/GroupWork.php"> Back To select other tasks! </a> </button>