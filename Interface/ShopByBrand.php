<?php
session_start();
include '../header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping By Brands</title>
  <link href="path/to/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .container p {
      background-color: #E0E0E0;
      text-align: center;
      margin: 10px 20px;
      padding: 20px;
      border-radius: 10px;
      font-size: 20px;
      color: black;
    }

    .container p:hover {
      box-shadow: rgba(255, 255, 255, 0.2) 0px 0px 0px 1px inset, rgba(0, 0, 0, 0.9) 0px 0px 0px 1px;
    }
  </style>
</head>

<body>

  <div class="HeaderTitle">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../Interface/HomePageCustomer.php">Home Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">Shopping By Brands</li>
      </ol>
    </nav>
    <h3>Shopping By Brands</h3>
  </div>

  <div style="max-width: 300px; margin-left: 20px; margin-bottom: 10px;">
    <span>
      <span class="SearchSpanG">
        <input type="search" id="searchInputG" placeholder="Search for Brands by name">
        <i class="fa-solid fa-magnifying-glass"></i>
      </span>
    </span>
  </div>

  <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-6 categoryContainer">
      <?php
      try {
        require("../Connection/init.php");

        $data = $db->prepare("SELECT DISTINCT Brand FROM `product data`");
        $data->execute();

        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
          $Brand = $row['Brand'];
      ?>
          <a href="ProductByBrand.php?Brand=<?php echo $Brand ?>" style="text-decoration: none; outline:none;">
            <p id="brand_<?php echo $Brand ?>"><?php echo $Brand ?></p>
          </a>
      <?php
        }
        $db = null;
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
  </div>

  <script src="path/to/bootstrap5/js/bootstrap.bundle.min.js"></script>
  <script>
    function searchBrands() {
      const input = document.getElementById('searchInputG');
      const filter = input.value.trim().toLowerCase(); // Convert search input to lowercase
      const brands = document.querySelectorAll('.categoryContainer a');

      brands.forEach(brand => {
        const brandName = brand.textContent.toLowerCase(); // Convert name of brand to lowercase

        if (brandName.includes(filter)) {
          brand.style.display = 'block';
        } else {
          brand.style.display = 'none';
        }
      });
    }

    document.getElementById('searchInputG').addEventListener('input', searchBrands);
  </script>
</body>

</html>