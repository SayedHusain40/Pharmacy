<?php
/*
  include ""; 
*/

try {
  session_start();

  //Assume 
  $userID = 6; //$_SESSION["user_id"]

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
    <div class="MainHeader">
      <h1>Confirm your delivery address</h1>
    </div>
    <div class="MainContent">
      <form action="" method="post">
        <label>Your Mobile Number</label>
        <input type="tel" name="MobileNumber" placeholder="Mobile Number" value="<?php echo $result["MobileNumber"] ?>"><br>
        <?php if (isset($errors['mobileNumberRequired'])) : ?>
          <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['mobileNumberRequired']; ?></span></p>
        <?php elseif (isset($errors['mobileNumberErr'])) : ?>
          <p><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['mobileNumberErr']; ?></span></p>
        <?php endif; ?>

        <br>

        <label>Your Email</label>
        <input type="email" name="Email" placeholder="Email" value="<?php echo $result["Email"] ?>"><br>
        <?php if (isset($errors['emailRequired'])) : ?>
          <p class="MainErrorSAddresses"><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['emailRequired']; ?></span></p>
        <?php elseif (isset($errors['emailErr'])) : ?>
          <p class="MainErrorSAddresses"><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['emailErr']; ?></span></p>
        <?php endif; ?>

        <br>

        <div class="parentDiv">
          <div>
            <label>Area</label>
            <input type="text" name="Area" placeholder="Area" value="<?php echo $result["Area"] ?>">
            <?php if (isset($errors['areaRequired'])) : ?>
              <p class="MainErrorSAddresses"><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['areaRequired']; ?></span></p>
            <?php endif; ?>
          </div>

          <div>
            <label>House</label>
            <input type="text" name="House" placeholder="House" value="<?php echo $result["House"] ?>">
            <?php if (isset($errors['houseRequired'])) : ?>
              <p class="MainErrorSAddresses"><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['houseRequired']; ?></span></p>
            <?php endif; ?>
          </div>
        </div>

        <br>

        <div class="parentDiv">
          <div>
            <label>Street</label>
            <input type="text" name="Street" placeholder="Street" value="<?php echo $result["Street"] ?>"><br>
            <?php if (isset($errors['streetRequired'])) : ?>
              <p class="MainErrorSAddresses">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?php echo $errors['streetRequired']; ?></span>
              </p>
            <?php endif; ?>

          </div>
          <div>
            <label>Block</label>
            <input type="text" name="Block" placeholder="Block" value="<?php echo $result["Block"] ?>">
            <?php if (isset($errors['blockRequired'])) : ?>
              <p class="MainErrorSAddresses"><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['blockRequired']; ?></span></p>
            <?php endif; ?>
          </div>
        </div>
        <br>
        <div class="MainSubmit">
          <input type="submit" name="update-address-btn" value="Update">
            <?php
            $TotalPrice = $_GET["TotalPrice"];
            $paymentMethod = $_GET["paymentMethod"];
            ?>
            <a class="mainLink" href="../Interface/PaymentPage.php?TotalPrice=<?php echo $TotalPrice ?>&paymentMethod=<?php echo $paymentMethod ?>">
              Continue Payment
            </a>
        </div>
      </form>
    </div>
  </body>

  </html>
<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>