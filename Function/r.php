<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .progress-bar {
            background-color: rgb(60, 109, 145);
            height: 2px;
            position: relative;
        }

        .step {
            position: absolute;
            width: 25%;
            height: 100%;
        }

        .bullet {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #ccc;
            color: white;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
        }

        .check {
            display: none;
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: #4caf50;
            color: white;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            top: -25px;
            left: 75px;
        }

        .step:hover .check {
            display: block;
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
        <div class="step">
            <div class="bullet">1</div>
            <div class="check fa fa-check"></div>
        </div>
        <p>Confirmed</p>
        <div class="step">
            <div class="bullet">2</div>
            <div class="check fa fa-check"></div>
        </div>
        <p>Processing</p>
        <div class="step">
            <div class="bullet">3</div>
            <div class="check fa fa-check"></div>
        </div>
        <p>Ready to Pick up OR out for Delivery</p>
        <div class="step">
            <div class="bullet">4</div>
            <div class="check fa fa-check"></div>
            <p>Completed</p>
        </div>
    </div>
</body>
</html>