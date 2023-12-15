<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
    <link rel="stylesheet" href="../css/Report.css" />
</head>
<body>
    <main>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `customer data`");
$stmt->execute();
$customer = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-x1-12">
            <h1>User Data</h1>
                <table>
                        <tr>
                            <th>Customer ID</th>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Mobile Number</th>
                            <th>Email</th>
                            <th>Date of Birth</th>
                        </tr>


        <tbody>
<?php

foreach ($customer as $customer) {
    $CustomerID = $customer['CustomerID'];
    $UserID = $customer['UserID'];
    $FirstName = $customer['FirstName'];
    $LastName = $customer['LastName'];
    $MobileNumber = $customer['MobileNumber'];
    $Email = $customer['Email'];
    $DOB = $customer['DOB'];
}
?>
        <tr>
            <td><?php echo $CustomerID ?></td>
            <td><?php echo $UserID ?></td>
            <td><?php echo $FirstName ?></td>
            <td><?php echo $LastName ?></td>
            <td><?php echo $MobileNumber ?></td>
            <td><?php echo $Email ?></td>
            <td><?php echo $DOB ?></td>

        <tr>
            

        </tbody>
        </div>
    </div>
</div>
</table>

<div class="Print">
<button onclick="window.print()">Print</button>
</div>

</main>
</html>

