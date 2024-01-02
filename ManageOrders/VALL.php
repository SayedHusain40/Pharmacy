<?php
// Fetch order details for multiple users
$orderDetailsQuery = "SELECT * FROM `OrderDetails` WHERE UserID IN (" . implode(",", $userIDs) . ")";
$orderDetailsStatement = $db->prepare($orderDetailsQuery);
$orderDetailsStatement->execute();
$orderDetails = $orderDetailsStatement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
$carouselCounter = 1;
foreach ($orderDetails as $userOrderDetails) {
    ?>
    <div id="carousel<?php echo $carouselCounter; ?>" class="owl-carousel">
        <h1>Pharmacy - Order Details Report</h1>
        <h3>Date: <?php echo $CurrentDate; ?></h3>
        <h3>Time: <?php echo $currentTime; ?></h3>

        <!-- Customer Details -->
        <table>
            <!-- ... customer details table rows ... -->
        </table>

        <!-- Order Details Report -->
        <table>
            <tr>
                <!-- ... order details table headers ... -->
            </tr>
            <?php foreach ($userOrderDetails as $row) { ?>
                <tr>
                    <!-- ... order details table rows ... -->
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
    $carouselCounter++;
}
?>

<script>
$(document).ready(function() {
    <?php for ($i = 1; $i <= $carouselCounter; $i++) { ?>
        $("#carousel<?php echo $i; ?>").owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            nav: true,
            dots: false
            // Add any other Owl Carousel options you want to customize
        });
    <?php } ?>
});
</script>