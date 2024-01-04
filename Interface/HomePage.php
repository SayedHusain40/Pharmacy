<?php
session_start();
include '../header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-image: url("../images/b1.jpg");
            background-repeat: no-repeat;
            background-size: cover; }
            .hidden {
    display: none;
}

#popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

#close-btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    margin-top: 20px;
    text-align: center;
    transition: background-color 0.3s;
}

#close-btn:hover {
    background-color: #45a049;
}

    
  .hidden {
    display: none;
  }

    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" crossorigin="anonymous" />
</head>
<body>
<button type="button" id="AddToCart" class="btn btn-outline-primary w-100 d-block mx-auto" data-bs-toggle="modal" data-bs-target="#cartModal">
  Add to Cart
</button>

<div id="popup" class="hidden">
  <div class="popup-content">
    <i class="far fa-times-circle"></i>
    <h2>Unauthorized Access!</h2>
    <p>Please login first!</p>
    <button id="close-btn">Login Now</button>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var popup = document.getElementById('popup');
    var closeBtn = document.getElementById('close-btn');
    var addToCartBtn = document.getElementById('AddToCart');

    // Function to display the pop-up message
    function showPopup() {
      popup.classList.remove('hidden');
    }

    // Function to close the pop-up message
    function closePopup() {
      popup.classList.add('hidden');
    }

    // Show the pop-up message when the "AddToCart" button is clicked
    addToCartBtn.addEventListener('click', function (event) {
      event.preventDefault(); // Prevents the default behavior of the button
      showPopup();
    });

    // Close the pop-up message when the "Login Now" button is clicked
    closeBtn.addEventListener('click', function () {
      closePopup();
    });
  });
</script>


</body>
</html>