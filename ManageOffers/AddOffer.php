<?php
require("../Connection/init.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["AddOffer"])) {

  $productID = $_POST['ProductID'];
  $discountedPrice = $_POST['DiscountedPrice'];
  $startDate = $_POST['StartDate'];
  $endDate = $_POST['EndDate'];


  $select = $db->prepare("SELECT Price FROM `product data` WHERE ProductID = ?");
  $select->execute([$productID]);
  $result = $select->fetch();
  $OriginalPrice = $result["Price"];


  $sql = "INSERT INTO `offers data` (ProductID, StartDate, EndDate, DiscountedPrice, OriginalPrice) 
        VALUES (?, ?, ?, ?, ?)";


  $stmt = $db->prepare($sql);
  $result = $stmt->execute([$productID, $startDate, $endDate, $discountedPrice, $OriginalPrice]);

  $_SESSION['addOffer_success'] = "true";

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Offers</title>
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="../css/all.min.css" />
</head>

<body>
  <?php
  include "../header.php";
  if (isset($_SESSION['addOffer_success'])) {
    echo '<div class="success-box" id="successBox">';
    echo '<div><i class="success-icon fa-solid fa-check" id="iconX"></i> Successfully Add Offer!</div>';
    echo '</div>';
    unset($_SESSION['addOffer_success']);
  }
  try {
    $stmt = $db->prepare("SELECT 
    `product data`.* 
    FROM 
    `product data`
    LEFT JOIN 
        `offers data` 
        ON `offers data`.ProductID = `product data`.ProductID
    WHERE
        `offers data`.ProductID IS NULL");

    $stmt->execute();
    $count = $stmt->rowCount();

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
    <h3>Add Offers</h3>
  </div>

  <div class="containerAddOffers">
    <h3 style="text-align: center">Offer Info</h3>
    <form class="row row-cols-lg-auto g-3 align-items-center" method="post">
      <div class="col-12">
        <label class="visually-hidden" for="inlineFormSelectPref">Select a product that will have a discount:</label><br>
        <select class="form-select" id="inlineFormSelectPref" name="ProductID">
          <option selected disabled hidden>Select a product</option>
          <?php
          while ($row = $stmt->fetch()) {
            $name = $row["Name"];
            $Price = $row["Price"];
            $ProductID = $row["ProductID"];
          ?>
            <option value="<?php echo $ProductID ?>" data-price="<?php echo $Price ?>"><?php echo $name . " | Price BHD" . $Price ?></option>
          <?php
          }
          ?>
        </select>
        <p class="errorSelectProduct text-danger"></p>
      </div>

      <div class="col-12">
        <label class="visually-hidden" for="inlineFormInputGroupUsername">Enter Discount Price</label>
        <div class="input-group">
          <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Discount Price" name="DiscountedPrice">
        </div>
        <p class="errorDiscountPrice text-danger"></p>
      </div>

      <div class="col-12 col-sm-5">
        <label for="startOfferDate" class="form-label">Start Offer Date</label>
        <input type="date" class="form-control" id="startOfferDate" name="StartDate">
        <p class="errorStartOfferDate text-danger"></p>
      </div>

      <div class="col-12 col-sm-5">
        <label for="endOfferDate" class="form-label">End Offer Date</label>
        <input type="date" class="form-control" id="endOfferDate" name="EndDate">
        <p class="errorEndOfferDate text-danger"></p>
      </div>

      <div class="col-12">
        <button type="submit" name="AddOffer" class="btn btn-primary">Add Offer</button>
      </div>
    </form>
  </div>

  <script>
    const form = document.querySelector('.row-cols-lg-auto');
    const errorDiscountPrice = document.querySelector('.errorDiscountPrice');
    const errorSelectProduct = document.querySelector('.errorSelectProduct');
    const errorStartOfferDate = document.querySelector('.errorStartOfferDate');
    const errorEndOfferDate = document.querySelector('.errorEndOfferDate');

    form.addEventListener('submit', function(event) {
      const discountPriceInput = document.getElementById('inlineFormInputGroupUsername');
      const productSelect = document.getElementById('inlineFormSelectPref');
      const startOfferDate = document.getElementById('startOfferDate');
      const endOfferDate = document.getElementById('endOfferDate');

      // Reset error messages
      errorDiscountPrice.textContent = '';
      errorSelectProduct.textContent = '';
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

      if (productSelect.selectedIndex === 0) {
        errorSelectProduct.innerHTML = 'Please select a product.';
        event.preventDefault();
      }

      // Retrieve the original price of the selected product
      const selectedOption = productSelect.options[productSelect.selectedIndex];
      const originalPrice = parseFloat(selectedOption.dataset.price);

      // Check if discount price is less than the original price
      if (parseFloat(discountPriceInput.value.trim()) >= originalPrice) {
        errorDiscountPrice.innerHTML = 'Discount price must be less than the original price.';
        event.preventDefault();
      }

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