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
  try {
    require("../Connection/init.php");
    $stmt = $db->prepare("SELECT 
    `product data`.*,
    `offers data`.*
    FROM 
        `product data`
    JOIN 
        `offers data` 
        ON `offers data`.ProductID = `product data`.ProductID");
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
        <li class="breadcrumb-item active" aria-current="page">Offers</li>
      </ol>
    </nav>
    <h3>Offers</h3>
  </div>


  <div class="containerOfferTAble table-responsive">
    <div style="text-align: right;">
      <a href="AddOffer.php"> <button type="button" class="btn btn-outline-primary"> + Add New Offer</button></a>
    </div>
    <?php
    if ($count > 0) {
    ?>
      <table class="table table-hover mx-auto px-3">
        <thead>
          <tr>
            <th scope="col">Product Image</th>
            <th scope="col">Product Name</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Discounted Price</th>
            <th scope="col">Original Price</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = $stmt->fetch()) {
            $OfferID = $row["OfferID"];
            $image = $row["Photo"];
            $Name = $row["Name"];
            $StartDate = $row["StartDate"];
            $EndDate = $row["EndDate"];
            $DiscountedPrice = $row["DiscountedPrice"];
            $OriginalPrice = $row["Price"];
          ?>
            <tr>
              <td><img src="../images/<?php echo $image ?>" alt="" width="100px"></td>
              <td class="align-middle"><?php echo $Name ?></td>
              <td class="align-middle"><?php echo $StartDate ?></td>
              <td class="align-middle"><?php echo $EndDate ?></td>
              <td class="align-middle">BHD <?php echo $DiscountedPrice ?></td>
              <td class="align-middle">BHD <?php echo $OriginalPrice ?></td>
              <td class="align-middle">
                <form action="UpdateOffer.php" method="post">
                  <input type="hidden" name="OfferID" value="<?php echo $OfferID ?>">
                  <input type="hidden" name="Name" value="<?php echo $Name ?>">
                  <input type="submit" value="Update">
                </form>
                <a href="">Remove</a>
              </td>
            </tr>

          <?php
          }
          ?>
        </tbody>
      </table>
  </div>
<?php
    }
?>
</body>

</html>