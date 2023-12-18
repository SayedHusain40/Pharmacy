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
  session_start();
  include "../header.php";

  if (isset($_SESSION['updateOffer_success'])) {
    echo '<div class="success-box" id="successBox">';
    echo '<div><i class="success-icon fa-solid fa-check" id="iconX"></i> Successfully Update Offer!</div>';
    echo '</div>';
    unset($_SESSION['updateOffer_success']);
  }
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
                  <input type="submit" value="Update" class="OfferUpdate-btn">
                </form>
                <button class="OfferDelete-btn" id="removeOffer" offer-ID="<?php echo $OfferID ?>">Remove</button>
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

<script>
  let removeOfferButtons = document.querySelectorAll("#removeOffer");

  removeOfferButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      event.preventDefault();

      const offerID = this.getAttribute('offer-ID');
      console.log(offerID);

      // Display confirmation dialog before deleting
      const confirmation = confirm("Are you sure you want to delete this offer?");
      if (confirmation) {
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", "DeleteOffer.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`OfferID=${offerID}`);
        xhttp.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
            // If deletion was successful, remove the row from the table
            const deletedOfferRow = button.closest('tr');
            deletedOfferRow.remove();
          }
        };
      } else {
        // Do nothing if the user clicks "Cancel" in the confirmation dialog
        console.log("Deletion canceled");
      }
    });
  });


  //for hiding susscfuly meesage
  let successBox = document.getElementById('successBox');

  //Function to hide the success box
  function hideSuccessBox() {
    successBox.style.display = 'none';
  }

  // Hide the success box after 3 seconds
  setTimeout(hideSuccessBox, 3000);
</script>

</body>

</html>