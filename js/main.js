/*======== Payment Start ========*/
const paymentForm = document.querySelector('.paymentForm');
const cardholderNameInput = document.getElementById('cardholder-name');
const cardNumberInput = document.getElementById('card-number');
const expirationDateInput = document.getElementById('expiration-date');
const cvvInput = document.getElementById('cvv');

// validate card Name user can inter only space and letters
cardholderNameInput.addEventListener('input', function () {
  let cardName = this.value.replace(/[^A-Za-z\s]/g, '');
  this.value = cardName;
});

// make space after every 4 digits
cardNumberInput.addEventListener('input', function () {
  let number = this.value.replace(/\D/g, '').substring(0, 16);

  if (number.length > 4) {
    number = number.substring(0, 4) + " " + number.substring(4);
  }
  if (number.length > 9) {
    number = number.substring(0, 9) + " " + number.substring(9);
  }
  if (number.length > 14) {
    number = number.substring(0, 14) + " " + number.substring(14);
  }

  this.value = number;
});

// add slash "/" for expiration Date and will take "return" only  4 digit with slash like 12/12 
expirationDateInput.addEventListener('input', function () {
  let date = this.value.replace(/\D/g, '').substring(0, 4);
  if (date.length > 2) {
    date = date.substring(0, 2) + '/' + date.substring(2);
  }
  this.value = date;
});

cvvInput.addEventListener('input', function () {
  let cvv = this.value.replace(/\D/g, '').substring(0, 4);
  this.value = cvv;
});


function goToPreviousPage() {
  window.location.href = "../ManageShopingCart/ViewShopingCar.php";
}
//For Validate submit
paymentForm.addEventListener('submit', function (event) {

  var errors = false;
  event.preventDefault();


  if (cardholderNameInput.value.trim() === '') {
    document.querySelector('.name-error').style.display = 'block';
    errors = true;
  } else {
    document.querySelector('.name-error').style.display = 'none';
  }

  if (cardNumberInput.value === '') {
    document.querySelector('.card-error').style.display = 'block';
    errors = true;
  } else {
    if (cardNumberInput.value.length * 1 < 19) {
      document.querySelector('.card-error span').innerHTML = 'Card number should be 16 digits.';
      errors = true;
    } else {
      document.querySelector('.card-error').style.display = 'none';
    }
  }

  if (expirationDateInput.value === '') {
    document.querySelector('.expiration-error').style.display = 'block';
    errors = true;
  } else {
    let date = expirationDateInput.value;
    if (date.length < 5) {
      document.querySelector('.expiration-error').style.display = 'block';
      document.querySelector('.expiration-error span').innerHTML = "invalid Date format is too short";
      errors = true;
    } else {
      let date = expirationDateInput.value;
      const dateParts = date.split('/');
      let expirationYear = parseInt(dateParts[1]);
      let expirationMonth = parseInt(dateParts[0]);
      const now = new Date();
      const currentYear = now.getFullYear() % 100;
      const currentMonth = now.getMonth() + 1;

      console.log(currentMonth);
      console.log(currentYear);
      console.log(expirationMonth);
      console.log(expirationYear);
      if (expirationMonth > 12) { 
        document.querySelector('.expiration-error').style.display = 'block';
        document.querySelector('.expiration-error span').innerHTML = "Invalid month";
        errors = true;
      }
      else if (expirationYear < currentYear || (expirationYear == currentYear && expirationMonth < currentMonth)) {
        document.querySelector('.expiration-error').style.display = 'block';
        document.querySelector('.expiration-error span').innerHTML = "Your cart has expired";
        errors = true;
      } 
      else {
        document.querySelector('.expiration-error').style.display = 'none';
      }
    }
  }
  if (cvvInput.value === '') {
    document.querySelector('.cvv-error').style.display = 'block';
    errors = true;
  } else {
    if (cvvInput.value.length <= 2) {
      console.log(cvvInput.value.length);
      document.querySelector('.cvv-error').style.display = 'block';
      document.querySelector('.cvv-error span').innerHTML = "invalid CVV is too short should be 3 or 4 digit";
      errors = true;
    }
    else {
      document.querySelector('.cvv-error').style.display = 'none';
    }
  }

  if (!errors) {
    paymentForm.submit();
  }
});

/*======== Payment End ========*/


