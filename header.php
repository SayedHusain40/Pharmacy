<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/main.css" />
  <style>
    .logo {
      max-width: 100px;
    }

    .logo2 {
      max-width: 160px;
    }

    .navbar-brand {
      margin-left: 5px;
      margin-top: 5px;
      padding: 5px;
      background-color: rgba(255, 255, 255, 0.5);
    }
    .Logout-button {
  border: none;
  background-color: transparent;
  margin-left: 10px;
  padding: 0;
  cursor: pointer;
}
.Profile-button {
  border: none;
  background-color: transparent;
  margin-left: 10px;
  padding: 0;
  cursor: pointer;
}
  </style>
</head>

<body>
  <header>
    <div>
      <nav class="navbar navbar-expand-xl navbar-lightsticky-top">
        <a class="navbar-brand" href="../Account/Login.php"> <img src="../images/logo1.png" class="logo" /> <img src="../images/logo2.png" class="logo2" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto float-none">
            <?php if (isset($_SESSION['un'])) {
              if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Staff') {
                echo '<li class="nav-item active">
            <a class="nav-link" href="../Interface/HomePage' . $_SESSION['user_role'] . '.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown mr-5">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Reports
          </a>
          <div class="dropdown-menu">
          <a class="dropdown-item" href="../Reports/CurrentInventoryReport.php">Current Inventory Report</a>
          <a class="dropdown-item" href="../Reports/UsersReport.php">Users Report</a>
          <a class="dropdown-item" href="../Reports/CustomerInformationReport.php">Customer Information Report</a> 
          <a class="dropdown-item" href="../Reports/StaffInformationReport.php">Staff Information Report</a> 
          <a class="dropdown-item" href="../Reports/TopSellingMedicinesReport.php">Top Selling Medicines Report</a> 
          <a class="dropdown-item" href="../Reports/SupplierReport.php">Supplier Report</a>
          <a class="dropdown-item" href="../Reports/OrderReport.php">Order Report</a>
          <a class="dropdown-item" href="../Reports/OfferReport.php">Offers Report</a>
          </div>
          </li>
          <li class="nav-item dropdown mr-5">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Manage Items
          </a>
          <div class="dropdown-menu">
          <a class="dropdown-item" href="../ManageProduct/ViewItems.php">View Products</a>
          <a class="dropdown-item" href="../ManageProduct/AddProduct.php">Add Product</a>
          </div>
          </li>
          <li class="nav-item dropdown mr-5">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Manage Orders
          </a>
          <div class="dropdown-menu">
          <a class="dropdown-item" href="../ManageOrders/OrderStatus.php">Manage Orders</a>
          <a class="dropdown-item" href="../ManageOrders/ViewOrdersDetails.php">View Order</a>
          <a class="dropdown-item" href="../ManageOrders/AddOrder.php">Add Order</a>
          <a class="dropdown-item" href="../ManageOrders/EditOrder.php">Edit Order</a>
          </div>
          </li>
          <li class="nav-item dropdown mr-5">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Manage Users
          </a>
          <div class="dropdown-menu">
          <a class="dropdown-item" href="../ManageUsers/ViewUsers.php">View Users</a>
          <a class="dropdown-item" href="../ManageUsers/AddUsers.php">Add Users</a>
          <a class="dropdown-item" href="../ManageUsers/EditUsers.php">Edit Users</a>
          </div>
          </li>
          <li class="nav-item dropdown mr-5">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Manage Offers
          </a>
          <div class="dropdown-menu">
          <a class="dropdown-item" href="../ManageOffers/ViewOffer.php">View Offer</a>
          <a class="dropdown-item" href="../ManageOffers/AddOffer.php">Add Offer</a>
          <a class="dropdown-item" href="../ManageOffers/EditOffer.php">Edit Offer</a>
          </div>
          </li>
          <button class="Profile-button"><a href="../Account/EditAdmin.php?id="> <i class="fas fa-user"></i> </a> </button>
          <button class="Logout-button"><a href="../Account/logout.php"> <i class="fas fa-sign-out-alt"></i></a> </button>
          ';
              } else if ($_SESSION['user_role'] == 'Customer') {
                echo '
          <li class="nav-item active">
          <a class="nav-link" href="../Interface/HomePage' . $_SESSION['user_role'] . '.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../Account/Profile.php?id=">My Profile</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../ManageOrders/CViewOrder.php">My Orders</a>
        </li>
        <li class="nav-item dropdown mr-5">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          Products
        </a>
        <div class="dropdown-menu">
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Medicine">Medicine</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Minerals">Minerals</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Vitamins">Vitamins</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Supplements">Supplements</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Common Conditions">Common Conditions</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Skin Care">Skin Care</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Oral Care">Oral Care</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Bath & Shower">Bath & Shower</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Hair Wash & Care">Hair Wash & Care</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Body Supports">Body Supports</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Feminine Hygiene">Feminine Hygiene</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Mens Grooming">Mens Grooming</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Deodorants">Deodorants</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Health Accessories">Health Accessories</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=First Aid">First Aid</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Diagnostics & Monitoring">Diagnostics & Monitoring</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Baby Skin Care & Accessories">Baby Skin Care & Accessories</a>
        </div>
        </li>
        <li class="nav-item">
    <a class="nav-link" href="../Interface/ShopByCategories.php">Shop by Categories</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="../Interface/ShopByBrand.php">Shop by Brand</a>
    </li>

        <li class="nav-item">   
        <a class="nav-link" href="../Interface/OfferPage.php">Offers</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../Interface/AboutUs.php">About Us</a>
        </li>
        <button class="favorite-button"> <a href="../ManageWishList/ViewWishList.php"><i class="far fa-heart"></i></a> </button>
        <button class="shopping-cart-button"><a href="../ManageShoppingCart/ViewShoppingCart.php"> <i class="fas fa-shopping-cart"></i> </a> </button>
        <button class="Profile-button"><a href="../Account/Profile.php?id="> <i class="fas fa-user"></i> </a> </button>
        <button class="Logout-button"><a href="../Account/logout.php"> <i class="fas fa-sign-out-alt"></i></a> </button>
        ';
              } else if ($_SESSION['user_role'] == 'Supplier') {
                echo '
                <li class="nav-item active">
                <a class="nav-link" href="../Interface/HomePage' . $_SESSION['user_role'] . '.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="../Account/Profile.php">My Profile</a>
              </li>
              <li class="nav-item dropdown mr-5">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                Products
              </a>
              <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Medicine</a>
              <a class="dropdown-item" href="#">Minerals</a>
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
              </div>
              </li>
              <li class="nav-item">
          <a class="nav-link" href="../Interface/ShopByCategories.php">Shop by Categories</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="../Interface/ShopByBrand.php">Shop by Brand</a>
          </li>
              <li class="nav-item">
              <a class="nav-link" href="../ManageOrders/CViewOrder.php">My Orders</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="OfferPage.php"> Offers</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="../Interface/AboutUs.php">About Us</a>
              </li>
              <button class="favorite-button"> <a href="../ManageWishList/ViewWishList.php"><i class="far fa-heart"></i></a> </button>
              <button class="shopping-cart-button"><a href="../ManageShoppingCart/ViewShoppingCart.php"> <i class="fas fa-shopping-cart"></i> </a> </button>
              <button class="Profile-button"><a href="../Account/Profile.php?id="> <i class="fas fa-user"></i> </a> </button>
              <button class="Logout-button"><a href="../Account/logout.php"> <i class="fas fa-sign-out-alt"></i></a> </button>
              ';
              }
            } else {
              echo '<li class="nav-item active">
      <a class="nav-link" href="../Interface/HomePageCustomer.php">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item dropdown mr-5">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
      Products
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Medicine">Medicine</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Minerals">Minerals</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Vitamins">Vitamins</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Supplements">Supplements</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Common Conditions">Common Conditions</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Skin Care">Skin Care</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Oral Care">Oral Care</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Bath & Shower">Bath & Shower</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Hair Wash & Care">Hair Wash & Care</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Body Supports">Body Supports</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Feminine Hygiene">Feminine Hygiene</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Mens Grooming">Mens Grooming</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Deodorants">Deodorants</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Health Accessories">Health Accessories</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=First Aid">First Aid</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Diagnostics & Monitoring">Diagnostics & Monitoring</a>
        <a class="dropdown-item" href="./ProductByCategory.php?Category=Baby Skin Care & Accessories">Baby Skin Care & Accessories</a>
    </div>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="../Interface/ShopByCategories.php">Shop by Categories</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="../Interface/ShopByBrand.php">Shop by Brand</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="OfferPage.php">Offers</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="../Interface/AboutUs.php">About Us</a>
    </li>
    <button class="favorite-button"><i class="far fa-heart"></i></button>
    <button class="shopping-cart-button"><a href="../ManageShoppingCart/ViewShoppingCart.php"> <i class="fas fa-shopping-cart"></i> </a> </button>';
            }

            ?>
          </ul>
  </header>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>