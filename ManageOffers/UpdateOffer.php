<?php
require("../Connection/init.php");
session_start();

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["UpdateOffer-btn"])) {

//   $productID = $_POST['ProductID'];
//   $discountedPrice = $_POST['DiscountedPrice'];
//   $startDate = $_POST['StartDate'];
//   $endDate = $_POST['EndDate'];


//   $sql = "UPDATE `offers data` 
//           SET StartDate = ?, EndDate = ?, DiscountedPrice = ? 
//           WHERE OfferID = ?";

//   $stmt = $db->prepare($sql);
//   $result = $stmt->execute([$productID, $startDate, $endDate, $discountedPrice, $OriginalPrice]);

//   $_SESSION['updateOffer_success'] = "true";

//   header('Location: ' . $_SERVER['PHP_SELF']);
//   exit();
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Offers</title>
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="../css/all.min.css" />
</head>

<body>
  <?php
  include "../header.php";
  if (isset($_SESSION['updateOffer_success'])) {
    echo '<div class="success-box" id="successBox">';
    echo '<div><i class="success-icon fa-solid fa-check" id="iconX"></i> Successfully Update Offer!</div>';
    echo '</div>';
    unset($_SESSION['updateOffer_success']);
  }


  $OfferID = $_POST['OfferID'];
  $name = $_POST['Name'];

  try {
    $stmt = $db->prepare("SELECT * FROM `offers data` WHERE OfferID = ?");
    $stmt->execute([$OfferID]);
    $offer = $stmt->fetch();



    $db = null;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  ?>
  <div class="HeaderTitle">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../Interface/HomePageAdmin.php">Home Page</a></li>
        <li class="breadcrumb-item"><a href="ViewOffer.php">Offers</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Offers</li>
      </ol>
    </nav>
  </div>

  <div class="containerAddOffers">
    <h3 style="text-align: center; margin-bottom: 20px;">Update a Offer</h3>
    <h5 style="margin-bottom: 20px;">Product Name: <?php echo $name ?></h5>
    <h5 style="margin-bottom: 20px;">Product Original Price: <?php echo $offer["OriginalPrice"] ?></h5>
    <form class="row row-cols-lg-auto g-3 align-items-center" method="post">

      <div class="col-12">
        <label class="visually-hidden" for="inlineFormInputGroupUsername">Update Discount Price</label>
        <div class="input-group">
          <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Discount Price" name="DiscountedPrice" value="<?php echo $offer["DiscountedPrice"] ?>">
        </div>
        <p class="errorDiscountPrice text-danger"></p>
      </div>

      <div class="col-12 col-sm-5">
        <label for="startOfferDate" class="form-label">Update Start Offer Date</label>
        <input type="date" class="form-control" id="startOfferDate" name="StartDate" value="<?php echo $offer["StartDate"] ?>">
        <p class="errorStartOfferDate text-danger"></p>
      </div>

      <div class="col-12 col-sm-5">
        <label for="endOfferDate" class="form-label">Update End Offer Date</label>
        <input type="date" class="form-control" id="endOfferDate" name="EndDate" value="<?php echo $offer["EndDate"] ?>">
        <p class="errorEndOfferDate text-danger"></p>
      </div>

      <div class="col-12">
        <button type="submit" name="UpdateOffer" class="btn btn-primary">Update Offer</button>
      </div>
    </form>
  </div>

  <script>
    const form = document.querySelector('.containerAddOffers form');
    const errorDiscountPrice = document.querySelector('.errorDiscountPrice');
    const errorStartOfferDate = document.querySelector('.errorStartOfferDate');
    const errorEndOfferDate = document.querySelector('.errorEndOfferDate');

    form.addEventListener('submit', function(event) {
      const discountPriceInput = document.getElementById('inlineFormInputGroupUsername');
      const startOfferDate = document.getElementById('startOfferDate');
      const endOfferDate = document.getElementById('endOfferDate');

      // Reset error messages
      errorDiscountPrice.textContent = '';
      errorStartOfferDate.textContent = '';
      errorEndOfferDate.textContent = '';

      // Check if the discount price is empty or not a number
      if (discountPriceInput.value.trim() === '') {
        errorDiscountPrice.innerHTML = 'Please enter a discount price.';
        event.preventDefault();
      } else if (!/^\d+$/.test(discountPriceInput.value)) {
        errorDiscountPrice.innerHTML = 'Please enter a valid discount price (only numbers).';
        event.preventDefault();
      }

      // Check for the start and end offer dates
      const today = new Date().toLocaleDateString('en-CA', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
      }).split('/').reverse().join('-');

      if (startOfferDate.value === '' || startOfferDate.value < today) {
        errorStartOfferDate.innerHTML = 'Please select a valid start offer date.';
        event.preventDefault();
      }
      if (endOfferDate.value === '' || endOfferDate.value < today || endOfferDate.value < startOfferDate.value) {
        errorEndOfferDate.innerHTML = 'Please select a valid end offer date.';
        event.preventDefault();
      }
    });

    //for hiding Successfully message 
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