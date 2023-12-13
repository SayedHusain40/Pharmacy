<?php
session_start();
include '../header.php';
?>

<?php
try {
  require("/Connection/init.php");
} 
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
<?php

include '../Connection/init.php';

$sql = "SELECT * FROM product_data";
$all_product = $db->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylecus.css">
    <title>Document</title>
    <style>
        body {
            background-image: url("../images/b1.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <main>
<?php
          while($row = mysqli_fetch_assoc($all_product)){
       ?>
       <div class="card">
           <div class="image">
               <img src="<?php echo $row["product_image"]; ?>" alt="">
           </div>
           <div class="caption">
               <p class="product_name"><?php echo $row["Name"];  ?></p>
               <p class="price"><b>$<?php echo $row["Price"]; ?></b></p>
           </div>
           <button class="add" data-id="<?php echo $row["product_id"];  ?>">Add to cart</button>
       </div>
       <?php

          }
     ?>
     </main>
    
</body>
</html>