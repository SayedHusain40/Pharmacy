<?php
/*
  include ""; 
*/

try {

  //Assume 
  $userID = 3; //$_SESSION["user_id"]

  $errors = [];
  $mobileNumber = $email = $area = $house = $street = $block = '';


  require("../Connection/init.php");

  // customer data 
  $stmt = $db->prepare("SELECT * FROM `customer data` WHERE UserID = ?");
  $stmt->execute([$userID]);
  $result = $stmt->fetch();

  // update new values in (customer data)
  if (isset($_POST['update-address-btn'])) {
    $mobileNumber = test_input($_POST['MobileNumber']);
    $email = test_input($_POST['Email']);
    $area = test_input($_POST['Area']);
    $house = test_input($_POST['House']);
    $street = test_input($_POST['Street']);
    $block = test_input($_POST['Block']);

    // Validation
    if (empty($mobileNumber)) {
      $errors['mobileNumberRequired'] = "Mobile number is required!";
    } else if (!preg_match("/^\+\d{1,3}\d{1,14}$/", $mobileNumber)) {
      $errors['mobileNumberErr'] = "Please enter a valid mobile number.";
    }

    if (empty($email)) {
      $errors['emailRequired'] = "Email is required!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['emailErr'] = "Please enter a valid email address.";
    }

    if (empty($area)) {
      $errors['areaRequired'] = "Area is required!";
    }

    if (empty($house)) {
      $errors['houseRequired'] = "House is required!";
    }

    if (empty($street)) {
      $errors['streetRequired'] = "Street is required!";
    }

    if (empty($block)) {
      $errors['blockRequired'] = "Block is required!";
    }

    // Check for errors before database operations
    if (count($errors) === 0) {
      $stmt = $db->prepare("UPDATE `customer data` SET MobileNumber = ?, Email = ?, Area = ?, House = ?, Street = ?, Block = ? WHERE UserID = ?");
      $stmt->execute([$mobileNumber, $email, $area, $house, $street, $block, $userID]);

      $totalPrice = $_GET['TotalPrice'];
      $paymentMethod = $_GET['paymentMethod'];

      header("Location: {$_SERVER['PHP_SELF']}?TotalPrice=$totalPrice&paymentMethod=$paymentMethod");
      exit();
    }
  }

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
  </head>

  <body>
    <h1>Confirm your delivery address</h1>
    <form action="" method="post">
      <label>Your Mobile Number</label>
      <input type="tel" name="MobileNumber" placeholder="Mobile Number" value="<?php echo $result["MobileNumber"] ?>"><br>
      <?php if (isset($errors['mobileNumberRequired'])) : ?>
        <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['mobileNumberRequired']; ?></span></p>
      <?php elseif (isset($errors['mobileNumberErr'])) : ?>
        <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['mobileNumberErr']; ?></span></p>
      <?php endif; ?>

      <label>Your Email</label>
      <input type="email" name="Email" placeholder="Email" value="<?php echo $result["Email"] ?>"><br>
      <?php if (isset($errors['emailRequired'])) : ?>
        <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['emailRequired']; ?></span></p>
      <?php elseif (isset($errors['emailErr'])) : ?>
        <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['emailErr']; ?></span></p>
      <?php endif; ?>

      <label>Area</label>
      <input type="text" name="Area" placeholder="Area" value="<?php echo $result["Area"] ?>"><br>
      <?php if (isset($errors['areaRequired'])) : ?>
        <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['areaRequired']; ?></span></p>
      <?php endif; ?>

      <label>House</label>
      <input type="text" name="House" placeholder="House" value="<?php echo $result["House"] ?>"><br>
      <?php if (isset($errors['houseRequired'])) : ?>
        <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['houseRequired']; ?></span></p>
      <?php endif; ?>

      <label>Street</label>
      <input type="text" name="Street" placeholder="Street" value="<?php echo $result["Street"] ?>"><br>
      <?php if (isset($errors['streetRequired'])) : ?>
        <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['streetRequired']; ?></span></p>
      <?php endif; ?>

      <label>Block</label>
      <input type="text" name="Block" placeholder="Block" value="<?php echo $result["Block"] ?>"><br>
      <?php if (isset($errors['blockRequired'])) : ?>
        <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['blockRequired']; ?></span></p>
      <?php endif; ?>

      <input type="submit" name="update-address-btn" value="Update">
    </form>
  </body>

  </html>



  <?php
  $TotalPrice = $_GET["TotalPrice"];
  $paymentMethod = $_GET["paymentMethod"];
  ?>
  <a href="../Interface/PaymentPage.php?TotalPrice=<?php echo $TotalPrice ?>&paymentMethod=<?php echo $paymentMethod ?>"><button>Continue Payment</button></a>

<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>