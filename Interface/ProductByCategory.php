<?php
session_start();
try {
  require("../Connection/init.php");

  if (isset($_GET["Category"])) {
    $categoryName = $_GET["Category"];
  }

  //query for view orders
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
      <div class="containerProducts">
        <div class="filter">
        </div>
        <div class="content">
          <div class="headerContainer">
            <h2 class="title"> <?php echo $categoryName ?></h2>
            <i class="fa-solid fa-filter"></i>
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

    <script>
      // Get all the quantity inputs and plus/minus buttons by their classes
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