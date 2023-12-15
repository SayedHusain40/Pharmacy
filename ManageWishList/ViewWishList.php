<?php
session_start();

try {
  include "../header.php";
  require("../Connection/init.php");

  //Assume 
  $userID = 6; //$_SESSION["user_id"]

  $sql = "SELECT 
  `product data`.Photo,
  `product data`.Name,
  `product data`.Price,
  `wish list data`.WID
  FROM 
    `wish list data`
  JOIN 
    `product data` 
  ON 
    `wish list data`.ProductID = `product data`.ProductID
  WHERE 
    `wish list data`.UserID = ?";

  $data = $db->prepare($sql);
  $data->execute([$userID]);
  $count = $data->rowCount();

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
  </head>

  <body>
    <?php
    if ($count > 0) {
    ?>
      <!-- <h1 class="title">Your Wish List</h1> -->
      <div class="HeaderTitle">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../Interface/HomePageCustomer.php">Home Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">Wish List</li>
          </ol>
        </nav>
        <h3>Your Wish List</h3>
      </div>
      <div class="containerWishList">
        <?php
        while ($row = $data->fetch()) {
        ?>
          <div class="boxWish">
            <div> <img src="../images/<?php echo $row['Photo']; ?>" width="100px" /></div>
            <h3>Name: <?php echo $row['Name']; ?></h3>
            <div>Price: <?php echo $row['Price']; ?> BHD</div>
            <span class="deleteItemsCart">
              <a href="./DeleteWishList.php?delete&WID=<?php echo $row["WID"]; ?>"> <i class="fa-solid fa-circle-xmark"></i> </a>
            </span>
          </div>
        <?php
        }
        ?>
      </div>
    <?php
    } else {
    ?>
      <h1 class='wishEmpty'>Your Wish List is Empty</h1>
      <div class="wish-image">
        <img src="../images/no-item-found-here.png" alt="" width="500px">
      </div>

      <div class="start-shopping">
        <a href="../Interface/HomePage.php"><button>Start Bowsing</button></a>
      </div>
    <?php
    }
    ?>
  </body>

  </html>
<?php
  $db = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>