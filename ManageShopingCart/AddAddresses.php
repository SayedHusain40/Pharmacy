<?php
try {
  //assume
  $userID = 000000005;

  require("../Connection/init.php");

  // customer data
  $stmt = $db->prepare("SELECT * FROM `customer data` WHERE UserID = ?");
  $stmt->execute([$userID]);
  $rs = $stmt->fetch();

?>

  <h1>Confirm your delivery address</h1>
  <form action="" method="get">
    <input type="tel" name="MobileNumber" placeholder="Mobile Number" value="<?php echo $rs["MobileNumber"] ?>" required><br>
    <input type="email" name="Email" placeholder="Email" value="<?php echo $rs["Email"] ?>" required><br>
    <input type=" text" name="Area" placeholder="Area" value="<?php echo $rs["Area"] ?>" required><br>
    <input type="text" name="House" placeholder="House" value="<?php echo $rs["House"] ?>" required><br>
    <input type="text" name="Street" placeholder="Street" value="<?php echo $rs["Street"] ?>" required><br>
    <input type="text" name="Block" placeholder="Block" value="<?php echo $rs["Block"] ?>" required><br>
    <input type="submit" name="update-address-btn" value="Update">
  </form>

  <?php
  $TotalPrice = $_GET["TotalPrice"];
  $paymentMethod = $_GET["paymentMethod"];
  ?>

  <a href="../Interface/PaymentPage.php?TotalPrice=<?php echo $TotalPrice ?>&paymentMethod=<?php echo $paymentMethod?>"><button>Continue Payment</button></a>

<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>