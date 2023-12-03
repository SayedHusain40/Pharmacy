<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=groupwork;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tables = array('Account', 'Interface', 'ManageOffers', 'ManageOrders', 'ManageProducts', 'ManageUsers', 'Reports', 'Function');

    $success = false;
    $error = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($tables as $table) {
            $memberId = $_POST[$table] ?? null;
            if ($memberId !== null) {
                $stmt = $db->prepare("UPDATE $table SET member_id = :member_id WHERE task_name = :task_name");
                $stmt->bindParam(':member_id', $memberId);
                $stmt->bindParam(':task_name', $table);
                if ($stmt->execute()) {
                    $success = true;
                } else {
                    $error = true;
                    $errorInfo = $stmt->errorInfo();
                    echo "Error: " . $errorInfo[2];
                }
            }
        }
    }

    $stmt = $db->prepare("SELECT Id, name FROM member");
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <?php if ($success) : ?>
        <p>Update successful!</p>
    <?php elseif ($error) : ?>
        <p>Error occurred while updating the values.</p>
    <?php endif; ?>

    <form method="POST">
        <table border="1">
            <tr>
                <th>Table Name</th>
                <th>Task Name</th>
                <th>Member</th>
            </tr>
            <?php foreach ($tables as $table) : ?>
                <?php
                $stmt = $db->prepare("SELECT task_name, member_id FROM $table");
                $stmt->execute();
                $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <tr>
                    <td rowspan="<?= count($tasks) ?>"><?= $table ?></td>
                    <?php foreach ($tasks as $index => $task) : ?>
                        <?php
                        $taskId = $task['member_id'];
                        $taskName = $task['task_name'];
                        ?>
                        <?php if ($index !== 0) : ?>
                            <tr>
                        <?php endif; ?>
                        <td><?= $taskName ?></td>
                        <td>
                            <select name="<?= $table ?>">
                                <?php foreach ($members as $member) : ?>
                                    <?php
                                    $memberId = $member['Id'];
                                    $memberName = $member['name'];
                                    $selected = ($memberId == $taskId) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $memberId ?>" <?= $selected ?>><?= $memberName ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <?php if ($index === count($tasks) - 1) : ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Save Changes</button>
    </form>
<?php
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>