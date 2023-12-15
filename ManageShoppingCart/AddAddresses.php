<?php

try {
  session_start();
  include "../header.php";
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

    // Check for errors if not errors update address value for customer
    if (count($errors) === 0) {
      $stmt = $db->prepare("UPDATE `customer data` SET MobileNumber = ?, Email = ?, Area = ?, House = ?, Street = ?, Block = ? WHERE UserID = ?");
      $stmt->execute([$mobileNumber, $email, $area, $house, $street, $block, $userID]);

      $_SESSION['updateAddress_success'] = "true";
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
    <?php
    //for display Successfully messages
    if (isset($_SESSION['updateAddress_success'])) {
      echo '<div class="success-box" id="successBox">';
      echo '<div><i class="success-icon fa-solid fa-xmark" id="iconX"></i>Successfully Updated Your Address!</div>';
      echo '</div>';
      unset($_SESSION['updateAddress_success']);
    } ?>

    <div class="MainHeader">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="ViewShoppingCart.php">Shopping Cart</a></li>
          <li class="breadcrumb-item active" aria-current="page">Address</li>
        </ol>
      </nav>
      <h3>Confirm your delivery address</h3>
    </div>
    <div class="MainContent">
      <h4>Your addresses</h4>
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
          <p class="MainErrorSAddresses"><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['emailRequired']; ?></span></p>
        <?php elseif (isset($errors['emailErr'])) : ?>
          <p class="MainErrorSAddresses"><i class="fa-solid fa-circle-exclamation"></i><span><?php echo $errors['emailErr']; ?></span></p>
        <?php endif; ?>

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
          if ((isset($_POST['update-address-btn']) && count($errors) === 0) ||
            (!empty($result["MobileNumber"]) && !empty($result["Email"]) && !empty($result["Area"]) && !empty($result["House"]) && !empty($result["Street"]) && !empty($result["Block"]))
          ) {
            echo '<a class="mainLink" href="../Interface/PaymentPage.php">Continue Payment</a>';
          } else {
            echo '<button style="color: gray; cursor: not-allowed;" disabled>Continue Payment</button>';
          }
          ?>
        </div>
      </form>
    </div>
    <script>
      let iconX = document.getElementById('iconX');
      let successBox = document.getElementById('successBox');

      iconX.addEventListener('click', function() {
        hideSuccessBox();
      });

      // Function to hide the success box
      function hideSuccessBox() {
        successBox.style.display = 'none';
      }

      // Hide the success box after 3 seconds
      setTimeout(hideSuccessBox, 3000);
    </script>
  </body>

  </html>
<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>