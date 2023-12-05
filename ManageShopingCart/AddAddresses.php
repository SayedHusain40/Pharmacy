<?php
try {
  //assume
  $userID = 000000003;

  require("../Connection/init.php");
  $stmt = $db->prepare("SELECT * FROM `customer data` WHERE UserID = ?");
  $stmt->execute([$userID]);
  $rs = $stmt->fetch();

  //Insert order
  if (isset($_GET["checkout-submit"]) && $_GET["checkout-submit"] == "Checkout") {

    $sql = "SELECT * FROM `order data` WHERE UserID = ?";

    $stmt = $db->prepare($sql);
    $stmt->execute([$userID]);

    $count = $stmt->rowCount();

    //check if UserID Exit Or no

    if ($count == 0
    ) {
      $sql = "INSERT INTO `order data` (UserID) VALUES (?)";
      $data = $db->prepare($sql);
      $data->execute([$userID]);
    }
  }
  
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
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

<?php $totalPrice = $_GET["TotalPrice"]; ?>

<h3><a href="../Interface/PaymentPage.php?TotalPrice=<?php echo $totalPrice ?>"><button>Go to Payment</button></a> </h3>