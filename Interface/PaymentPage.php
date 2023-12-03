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
  <div class="payment-header">
    <h1>Complete Your Purchase</h1>
  </div>

  <div class="payment-content">
    <div class="payment">
      <h1>Payment</h1>
      <h3 class="Price">Total Price: <? $_POST["price"] ?></h3>
      <div class="credit-card">
        <h3>Credit Card</h3>
        <img src="../images/pay_by_cards.webp" alt="" />
      </div>

      <form action="">
        <label>Cardholder Name (exactly as shown on card)</label>
        <input type="text" placeholder="Enter Your Full Name" id="cardholder-name" />
        <p class="name-error payError"><i class="fa-solid fa-circle-exclamation"></i><span>Cardholder Name cannot be empty</span></p>

        <br /> <br>

        <label>Card number</label>
        <input type="text" placeholder="0000 0000 0000 0000" id="card-number" />
        <p class="card-error payError"><i class="fa-solid fa-circle-exclamation"></i><span>Card number cannot be empty</span></p>

        <br /><br>

        <div class="expCvv">
          <div>
            <label>Expiration date</label><br />
            <input type="text" placeholder="MM/YY" class="ExpDate" id="expiration-date" />
            <p class="expiration-error payError">
              <i class="fa-solid fa-circle-exclamation"></i><span>Expiration date cannot be empty</span>
            </p>
          </div>
          <div>
            <label>CVV</label><br />
            <input type="text" placeholder="CVV" id="cvv" />
            <p class="cvv-error payError">
              <i class="fa-solid fa-circle-exclamation"></i><span>CVV cannot be empty</span>
            </p>
          </div>
        </div>
        <div class="pay-cancel">
          <input type="submit" value="Pay" />
          <input type="submit" value="Cancel" onclick="goToPreviousPage()" />
        </div>
      </form>
    </div>
  </div>

  <script src="/js/main.js"></script>

</body>

</html>