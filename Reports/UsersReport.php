<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Users Report</title>
    <link rel="stylesheet" href="../css/Report.css" />
</head>
<body>
    <main>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `user data`");
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-x1-12">
            <h1 style="text-align: center">User Data Report</h1>
                <table>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User Type</th>
                        </tr>


        <tbody>
<?php

foreach ($user as $user) {
    $UserID = $user['UserID'];
    $Username = $user['Username'];
    $Email = $user['Email'];
    $Type = $user['Type'];

?>
        <tr>
            <td><?php echo $UserID ?></td>
            <td><?php echo $Username ?></td>
            <td><?php echo $Email ?></td>
            <td><?php echo $Type ?></td>

        <tr>
        <?php } ?>
        </tbody>
        </div>
    </div>
</div>
</table>
<button onclick="window.print()" class="Print">Print</button>
</div>

</main>
</html>

