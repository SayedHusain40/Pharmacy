<?php
session_start();
try {
  require("../Connection/init.php");

  $userID = 6;
  if (isset($_GET["Category"])) {
    $categoryName = $_GET["Category"];
  }

  //query for view products
  $data = $db->prepare("SELECT * FROM `product data` WHERE Type = ?");
  $data->execute([$categoryName]);
  $count = $data->rowCount();

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
  </head>

  <body>
    <?php
    include "../header.php";

    if ($count > 0) {
    ?>
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="navContainerProducts">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="HomePageCustomer.php">Home Page</a></li>
          <li class="breadcrumb-item"><a href="ShopByCategories.php">Shopping By Category</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $categoryName ?></li>
        </ol>
      </nav>
      <div class="containerProducts">
        <div class="filter" id="showFilterDiv">
          <h5>Shopping by Category</h5>
          <div class=" dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $categoryName ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="ProductByCategory.php?Category=Medicine">Medicine</a>
              <a class="dropdown-item" href="ProductByCategory.php?Category=Personal care">Minerals</a>
              <a class="dropdown-item" href="#">Vitamins</a>
              <a class="dropdown-item" href="#">Supplements</a>
              <a class="dropdown-item" href="#">Common Conditions</a>
              <a class="dropdown-item" href="#">Skin Care</a>
              <a class="dropdown-item" href="#">Oral Care</a>
              <a class="dropdown-item" href="#">Bath & Shower</a>
              <a class="dropdown-item" href="#">Hair Wash & Care</a>
              <a class="dropdown-item" href="#">Body Supports</a>
              <a class="dropdown-item" href="#">Feminine Hygiene</a>
              <a class="dropdown-item" href="#">Mens Grooming</a>
              <a class="dropdown-item" href="#">Deodorants</a>
              <a class="dropdown-item" href="#">Health Accessories</a>
              <a class="dropdown-item" href="#">First Aid</a>
              <a class="dropdown-item" href="#">Diagnostics & Monitoring</a>
              <a class="dropdown-item" href="#">Baby Skin Care & Accessories</a>
            </ul>
          </div>

          <h5>Price</h5>

        </div>
        <div class="content">
          <div class="headerContainer">
            <h2 class="title"> <?php echo $categoryName ?></h2>
            <i class="fa-solid fa-sliders" id="filterIcon"></i>
          </div>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            while ($row = $data->fetch()) {
              $productID = $row["ProductID"];
              $name = $row["Name"];
              $price = $row["Price"];
              $Photo = $row["Photo"];
            ?>
              <div class="col">
                <div class="card card-color:red">
                  <div class="cartImag">
                    <img src="../images/<?php echo $Photo ?>" class="card-img-top w-50 mx-auto d-block">
                  </div>
                  <div class="card-body">
                    <div class="HeartDiv">
                      <?php
                      // check for if product already in wish list
                      $check = $db->prepare("SELECT * FROM `wish list data` WHERE ProductID = ? And UserID = ?");
                      $check->execute([$productID, $userID]);
                      $checkResult = $check->rowCount();
                      $dataWishList = $check->fetch();

                      // Insert and delete in wishlist
                      ?>
                      <a href="#" class="wishlist-action" data-product-id="<?php echo $productID; ?>" data-wishlist-id="<?php echo isset($dataWishList["WID"]) ? $dataWishList["WID"] : ''; ?>">
                        <i id="HeartIcon" class="<?php echo isset($dataWishList["WID"]) ? 'fa-solid' : 'fa-regular'; ?> fa-heart"></i>
                      </a>
                    </div>

                    <span><?php echo $categoryName ?></span>
                    <h5 class="card-title"><?php echo $name ?></h5>
                    <p class="card-text"><?php echo "Price: BHD " . $price ?></p>
                    <div class="inputQtyContainer">
                      <button class="btnMins" id="decreaseQty"><i class="fas fa-minus"></i></button>
                      <input type="number" class="custom-number-input" id="quantity" value="1" min="1" productID=<?php echo $productID ?>>
                      <button class="btnPlus" id="increaseQty"><i class="fas fa-plus"></i></button>
                    </div>
                    <button type="button" onclick="addToCart(<?php echo $productID ?>)" class="btn btn-outline-primary w-100 d-block mx-auto">Add to Cart</button>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    <?php
    } else {
    ?>
      <h1 class='cartEmpty'>Not Found</h1>
      <!-- <div class="cart-image">
        <img src="../images/cart.jpeg" alt="">
      </div>

      <div class="start-shopping">
        <a href="../Interface/HomePage.php"><button>Start Shopping</button></a>
      </div> -->
    <?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../js/editWishList.js"></script>
    <script>
      //for open filter div
      const filterDiv = document.getElementById('showFilterDiv');
      const filterIcon = document.getElementById('filterIcon');
      filterIcon.addEventListener('click', function() {
        filterDiv.classList.toggle('open');
      });

      const quantityInputs = document.querySelectorAll('.custom-number-input');
      const increaseQtyBtns = document.querySelectorAll('.btnPlus');
      const decreaseQtyBtns = document.querySelectorAll('.btnMins');

      // Function to increase quantity when the plus button is clicked
      increaseQtyBtns.forEach((button, index) => {
        button.addEventListener('click', () => {
          const currentValue = parseInt(quantityInputs[index].value);
          quantityInputs[index].value = currentValue + 1;
        });
      });

      // Function to decrease quantity when the minus button is clicked
      decreaseQtyBtns.forEach((button, index) => {
        button.addEventListener('click', () => {
          const currentValue = parseInt(quantityInputs[index].value);
          if (currentValue > 1) {
            quantityInputs[index].value = currentValue - 1;
          }
        });
      });

      //for hiding Successfully  message 
      let iconX = document.getElementById('iconX');
      let successBox = document.getElementById('successBox');

      // Hide the success box after 3 seconds
      setTimeout(hideSuccessBox, 3000);

      //display Success Message
      function displaySuccessMessage() {
        const successBox = document.createElement('div');
        successBox.className = 'success-box';
        successBox.id = 'successBox';

        const successMessage = document.createElement('div');
        successMessage.innerHTML = '<i class="success-icon fa-solid fa-check"></i> Successfully Added To Cart!';

        successBox.appendChild(successMessage);
        document.body.appendChild(successBox);

        // Hide the success box after 3 seconds
        setTimeout(() => {
          successBox.style.display = 'none';
        }, 3000);
      }

      //add To Cart
      function addToCart(productID) {
        const quantity = document.querySelector(`input[productID='${productID}']`).value;
        const xhr = new XMLHttpRequest();

        xhr.open("POST", "../ManageShoppingCart/AddToCart.php");
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        const data = `quantity=${quantity}&productID=${productID}`;
        xhr.send(data);

        // Call the displaySuccessMessage function after the item is added to the cart
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              displaySuccessMessage(); // Call the function to display the success message
            } else {
              console.error('Error adding to cart');
            }
          }
        };
      }
    </script>
  </body>

  </html>
<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>