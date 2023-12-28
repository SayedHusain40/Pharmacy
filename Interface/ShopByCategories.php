<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shopping By Categories</title>
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="../css/all.min.css" />
</head>

<body>
  <?php
  session_start();
  include "../header.php";

  ?>
  <div class="HeaderTitle">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../Interface/HomePageCustomer.php">Home Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">Shopping By Category</li>
      </ol>
    </nav>
    <h3>Shopping By Category</h3>
  </div>

  <div style="max-width: 300px; margin-left: 20px; margin-bottom: 10px;">
    <span>
      <span class="SearchSpanG">
        <input type="search" id="searchInputG" placeholder="Search for Categories by name">
        <i class="fa-solid fa-magnifying-glass"></i>
      </span>
    </span>
  </div>



  <div class="categoryContainer row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-7">
    <?php
    $categories = array(
      "Medicine" => "../images/Medicine.jpg",
      "Minerals" => "../images/Mineralspng.png",
      "Vitamins" => "../images/Vitamins.jpeg",
      "Supplements" => "../images/Supplementsjpeg.jpeg",
      "Common Conditions" => "../images/Common Conditions.jpg",
      "Skin Care" => "../images/Personal care.png",
      "Deodorants" => "../images/Deodorants.jpg",
      "Bath & Shower" => "../images/sh.png",
      "Hair Wash & Care" => "../images/hair wash.jpg",
      "Body Supports" => "../images/Body Supports.jpg",
      "Health Accessories" => "../images/Health Accessoriesjpeg.jpeg",
      "First Aid" => "../images/First Aid.png",
      "Diagnostics & Monitoring" => "../images/Diagnostics & Monitoring .webp",
      "Baby Skin Care & Accessories" => "../images/baby.jpg",
      "Oral Care" => "../images/oral care.jpeg",
      "Mens Grooming" => "../images/Mens Grooming.png",
      "Feminine Hygiene" => "../images/Feminine Hygiene.png"
    );

    foreach ($categories as $category => $imagePath) {
    ?>
      <div class="col">
        <a href="../Interface/ProductByCategory.php?Category=<?php echo $category ?>">
          <div class="card">
            <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="<?php echo $category; ?>" style="height: 200px; object-fit: cover;">
            <div class="card-body">
              <p class="card-text"><?php echo $category; ?></p>
            </div>
          </div>
        </a>
      </div>
    <?php
    }
    ?>
  </div>




  <script>
    function searchCategories() {
      const input = document.getElementById('searchInputG');
      const filter = input.value.trim().toLowerCase(); // Convert search input to lowercase
      const categories = document.querySelectorAll('.col');

      categories.forEach(category => {
        const categoryName = category.querySelector('p.card-text').textContent.toLowerCase(); // Convert name of category to lowercase
        if (categoryName.includes(filter)) {
          category.style.display = 'block';
        } else {
          category.style.display = 'none';
        }
      });
    }

    document.getElementById('searchInputG').addEventListener('input', searchCategories);
  </script>


</body>

</html>