<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shopping By Categories</title>
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="../css/all.min.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .SearchSpanG {
      position: relative;
    }

    .SearchSpanG i {
      position: absolute;
      left: 19px;
      top: 50%;
      transform: translate(-50%, -50%);
    }

    .SearchSpanG #searchInputG {
      border: 1px solid;
      border-radius: 12px;
      padding: 3px 0;
      padding-left: 33px;
      width: 100%;
      padding-right: 8px;
      outline: none;
    }
  </style>
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
  <div class="categoryContainer">
    <a href="../Interface/ProductByCategory.php?Category=Medicine">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg" alt="">
        </div>
        <p>Medicine</p>
      </div>
    </a>
    <a href="../Interface/ProductByCategory.php?Category=Personal care">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Personal care.png " alt="">
        </div>
        <p>Minerals</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Vitamins</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Supplements</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Personal care.png " alt="">
        </div>
        <p>Common Conditions</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Skin Care</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Oral Care</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Bath & Shower</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Hair Wash & Care</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Body Supports</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Feminine Hygiene</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Mens Grooming</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Deodorants</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Health Accessories</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>First Aid</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Diagnostics & Monitoring</p>
      </div>
    </a>
    <a href="">
      <div class="box">
        <div class="categoryBox">
          <img src="../images/Medicine.jpg " alt="">
        </div>
        <p>Baby Skin Care & Accessories</p>
      </div>
    </a>
  </div>

  <script>
    // for  category search
    function searchCategories() {
      const input = document.getElementById('searchInputG');
      const filter = input.value.toUpperCase();
      const categories = document.querySelectorAll('.categoryContainer a');

      categories.forEach(category => {
        const categoryName = category.querySelector('p').textContent.toUpperCase();
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