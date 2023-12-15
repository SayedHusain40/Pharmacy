<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Staff Information Report</title>
    <link rel="stylesheet" href="../css/Report.css" />
</head>
<body>
    <main>
    <?php
    
include '../Connection/init.php';

$stmt = $db->prepare("SELECT * FROM `staff data`");
$stmt->execute();
$staff = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-x1-12">
            <h1 style="text-align: center">Staff Information Report</h1>
                <table>
                        <tr>
                            <th>Staff ID</th>
                            <th>User ID</th>
                            <th>CPR</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Academic Degree</th>
                            <th>Mobile Number</th>
                            <th>Email</th>
                            <th>Employee Position</th>
                        </tr>


        <tbody>
<?php

foreach ($staff as $staff) {
    $StaffID = $staff['StaffID'];
    $UserID = $staff['UserID'];
    $CPR = $staff['CPR'];
    $FirstName = $staff['FirstName'];
    $LastName = $staff['LastName'];
    $Gender = $staff['Gender'];
    $DOB = $staff['DOB'];
    $AcademicDegree = $staff['AcademicDegree'];
    $MobileNumber = $staff['MobileNumber'];
    $Email = $staff['Email'];
    $EmployeePosition = $staff['EmployeePosition'];

?>
        <tr>
            <td><?php echo $StaffID ?></td>
            <td><?php echo $UserID ?></td>
            <td><?php echo $CPR ?></td>
            <td><?php echo $FirstName ?></td>
            <td><?php echo $LastName ?></td>
            <td><?php echo $Gender ?></td>
            <td><?php echo $DOB ?></td>
            <td><?php echo $AcademicDegree ?></td>
            <td><?php echo $MobileNumber ?></td>
            <td><?php echo $Email ?></td>
            <td><?php echo $EmployeePosition ?></td>

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

