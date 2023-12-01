<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div>
      <!-- Navigation Bar-->
      <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
      <a class="navbar-brand" href="../Account/Login.php"> <img src="images/logo.jpeg" class="logo" /> </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto float-none">
        <?php if (isset($_SESSION['un']))
      {  
        if ($_SESSION['user_role'] == 'Admin') {
          echo '<li class="nav-item active">
            <a class="nav-link" href="../Interface/HomePageAdmin.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown mr-5">
          <a class="nav-link dropdown-toggle" href="../Reports/Report.php" role="button" data-toggle="dropdown" aria-expanded="false">
            Reports
          </a>
          <div class="dropdown-menu">
          <a class="dropdown-item" href="../.php">Medicine Report</a>
          <a class="dropdown-item" href="../.php">Current Inventory Report</a>
          <a class="dropdown-item" href="../.php">Users Report</a>
          <a class="dropdown-item" href="../.php">Customer Information Report</a>
          <a class="dropdown-item" href="../.php">Staff Information Report</a>
          <a class="dropdown-item" href="../.php">Customer Order Details Report</a>
          <a class="dropdown-item" href="../.php">Top Selling Medicines Report</a>
          <a class="dropdown-item" href="../.php">Supplier Report</a>
          <a class="dropdown-item" href="../.php">Order Report</a>
          <a class="dropdown-item" href="../.php">Offers Report</a>
          </li>
          <li class="nav-item dropdown mr-5">
          <a class="nav-link dropdown-toggle" href="../ManageProduct/.php" role="button" data-toggle="dropdown" aria-expanded="false">
            Manage Items
          </a>
          <div class="dropdown-menu">
          <a class="dropdown-item" href="../ManageProduct/ViewProduct.php">View Products</a>
          <a class="dropdown-item" href="../ManageProduct/AddProduct.php">Add Product</a>
          <a class="dropdown-item" href="../ManageProduct/EditProduct.php">Edit Product</a>
          </li>
          ';
        }
    } 
    ?>
</body>
</html>