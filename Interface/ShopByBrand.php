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
  <link href="path/to/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .brandContainer {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-top: 20px;
    }

    .brandContainer p {
      width: fit-content;
      background-color: #E0E0E0;
      padding: 20px 0;
      width: 210px;
      border-radius: 10px;
      font-size: 20px;
      margin: 0;
      color: black;
      text-align: center;
    }

    .brandContainer p:hover {
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
    <div class="row">
      <div class="col-12">
        <div class="brandContainer">
          <?php
          try {
            require("../Connection/init.php");

            $data = $db->prepare("SELECT DISTINCT Brand FROM `product data`");
            $data->execute();

            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
          ?>
              <a href="" style="text-decoration: none;">
                <p id="brand_<?php echo $row['Brand']; ?>"><?php echo $row['Brand']; ?></p>
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
    </div>
  </div>

  <script>
    function searchBrands() {
      const input = document.getElementById('searchInputG');
      const filter = input.value.toLowerCase(); // Convert search input to lowercase
      const brands = document.querySelectorAll('.brandContainer a');

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