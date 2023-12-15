<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Supplier Report</title>
    <link rel="stylesheet" href="../css/Report.css" />
</head>
<body>
    <main>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `supplier data`");
$stmt->execute();
$supplier = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-x1-12">
            <h1 style="text-align: center">Supplier Information Report</h1>
                <table>
                        <tr>
                            <th>Supplier ID</th>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Mobile Number</th>
                            <th>Email</th>
                        </tr>


        <tbody>
<?php

foreach ($supplier as $supplier) {
    $SupplierID = $supplier['SupplierID'];
    $UserID = $supplier['UserID'];
    $FirstName = $supplier['FirstName'];
    $LastName = $supplier['LastName'];
    $MobileNumber = $supplier['MobileNumber'];
    $Email = $supplier['Email'];
?>
        <tr>
            <td><?php echo $SupplierID ?></td>
            <td><?php echo $UserID ?></td>
            <td><?php echo $FirstName ?></td>
            <td><?php echo $LastName ?></td>
            <td><?php echo $MobileNumber ?></td>
            <td><?php echo $Email ?></td>

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

