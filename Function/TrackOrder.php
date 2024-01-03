<?php
session_start();

include '../Connection/init.php';

$orderId = null;
$orderData = null;
$trackData = null;

if (isset($_GET['OrderID'])) {
    $orderId = $_GET['OrderID'];

    $orderStmt = $db->prepare("SELECT * FROM `order data` WHERE OrderID = :orderId");
    $orderStmt->bindParam(':orderId', $orderId);
    $orderStmt->execute();
    $orderData = $orderStmt->fetch();

    $trackStmt = $db->prepare("SELECT * FROM `trackorder` WHERE OrderID = :orderId");
    $trackStmt->bindParam(':orderId', $orderId);
    $trackStmt->execute();
    $trackData = $trackStmt->fetch();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="../css/all.min.css" />
    <link rel="stylesheet" href="../css/TrackOrder.css">
    <style>
    .center {
        text-align: center;
    }
    .image-wrapper {
        display: inline-block;
        text-align: center;
        margin: 0px 70px;
    }
</style>
</head>
<body>
  
    <h1>Track Your Order</h1>
    <?php if ($orderId !== null) { ?>
        <h3>Tracked Order: <?php echo $orderId; ?></h3>
    <?php } ?>
    <h2>Order Data:</h2>
    <?php if ($orderData !== null) { ?>
        <ul>
            <li>Last Status: <?php echo $orderData['Status']; ?></li>
            <!-- Add more order data fields as needed -->
        </ul>
    <?php } ?>

    <div class="progress-bar">
    <div class="step <?php echo ($trackData['ConfirmedDate'] !== null) ? 'active' : ''; ?>">
    <div class="bullet <?php echo ($trackData['ConfirmedDate'] !== null) ? 'green' : ''; ?>">1</div>
    <div class="check fa fa-check"></div>
</div>
    <p>Confirmed</p>
    <div class="step <?php echo ($trackData['ProcessingDate'] !== null) ? 'active' : ''; ?>">
    <div class="bullet <?php echo ($trackData['ProcessingDate'] !== null) ? 'green' : ''; ?>">2</div>
    <div class="check fa fa-check"></div>
</div>
    <p>Processing</p>
    <div class="step <?php echo ($trackData['ReadyToPickUpDate'] !== null || $trackData['OutForDeliveryDate'] !== null) ? 'active' : ''; ?>">
        <div class="bullet <?php echo ($trackData['ReadyToPickUpDate'] !== null  || $trackData['OutForDeliveryDate'] !== null) ? 'green' : ''; ?>">3</div>
        <div class="check fa fa-check"></div>
    </div>
    <?php if ($trackData['ReadyToPickUpDate'] !== null) {
       echo '<p> Ready to Pick up </p>';
    } else if ($trackData['OutForDeliveryDate'] !== null){
       echo '<p> Out for Delivery </p>';
    }
    ?>
    <div class="step <?php echo ($trackData['CompleteOrderDate'] !== null) ? 'active' : ''; ?>">
    <div class="bullet <?php echo ($trackData['CompleteOrderDate'] !== null) ? 'green' : ''; ?>">4</div>
    <div class="check fa fa-check"></div>
        <p>Completed</p>
    </div>
</div>
<br> <br> <br>
<div class="center" style="margin: 0 auto;">
    <div class="image-wrapper">
        <img src="../images/Compliance_icon_on_white.jpg" alt="" height="150" width="150">
        <p>Order is Confirmed</p>
    </div>
    <div class="image-wrapper">
        <img src="../images/Order.gif" alt="" height="150" width="150">
        <p>Order in Process</p>
    </div>
    <?php if ($trackData['ReadyToPickUpDate'] !== null) { ?>
        <div class="image-wrapper">
            <img src="../images/2457279.jpg" alt="" height="150" width="150">
            <p>Order is Ready to pickup</p>
        </div>
    <?php } else if ($trackData['OutForDeliveryDate'] !== null) { ?>
        <div class="image-wrapper">
            <img src="../images/49461.jpg" alt="" height="150" width="150">
            <p>Order is out for Delivery</p>
        </div>
    <?php } ?>
    <div class="image-wrapper">
        <img src="../images/4946.jpg" alt="" height="150" width="150">
        <p>Order is Completed</p>
    </div>
</div>

    <h2>Track Order Data:</h2>
    <?php if ($trackData !== null) { ?>
    <ul style="list-style-type: none;">
        <li>
            <?php if ($orderData['OrderDate'] !== null) { ?>
                <?php echo $orderData['OrderDate']; ?> <i class="far fa-check-circle fa-circle-check" style="color: green;"></i>
            <?php } else { ?>
                <i class="far fa-clock fa-clock" style="color: orange;"></i>
            <?php } ?>
            Order Created
        </li>
        <li>
            <?php if ($trackData['ConfirmedDate'] !== null) { ?>
                <?php echo $trackData['ConfirmedDate']; ?> <i class="far fa-check-circle fa-circle-check" style="color: green;"></i>
            <?php } else { ?>
                <i class="far fa-clock fa-clock" style="color: orange;"></i>
            <?php } ?>
            Order is Confirmed
        </li>
        <li>
        <?php if ($trackData['ProcessingDate'] !== null) { ?>
                <?php echo $trackData['ProcessingDate']; ?> <i class="far fa-check-circle fa-circle-check" style="color: green;"></i>
            <?php } else { ?>
                <i class="far fa-clock fa-clock" style="color: orange;"></i>
            <?php } ?>
        Order in process!
        </li>
        <?php if ($trackData['ReadyToPickUpDate'] !== null) { ?>
            <li><?php echo $trackData['ReadyToPickUpDate']; ?> <i class="far fa-check-circle fa-circle-check" style="color: green;"></i> Order is Ready to pickup</li>
        <?php } else if ($trackData['OutForDeliveryDate'] !== null) { ?>
            <li><?php echo $trackData['OutForDeliveryDate']; ?> <i class="far fa-check-circle fa-circle-check" style="color: green;"></i> Order is out for Delivery</li>
        <?php } ?>
        <li>
        <?php if ($trackData['CompleteOrderDate'] !== null) { ?>
                <?php echo $trackData['CompleteOrderDate']; ?> <i class="far fa-check-circle fa-circle-check" style="color: green;"></i>
            <?php } else { ?>
                <i class="far fa-clock fa-clock" style="color: orange;"></i>
            <?php } ?>
             Order is Completed
        </li>
    </ul>
<?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>