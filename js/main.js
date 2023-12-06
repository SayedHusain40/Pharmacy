/*======== Payment Start ========*/
const paymentForm = document.querySelector('.paymentForm');
const cardholderNameInput = document.getElementById('cardholder-name');
const cardNumberInput = document.getElementById('card-number');
const expirationDateInput = document.getElementById('expiration-date');
const cvvInput = document.getElementById('cvv');

// validate card Name
cardholderNameInput.addEventListener('input', function () {
  let cardName = this.value.replace(/[^A-Za-z\s]/g, '');
  this.value = cardName;
});

// validate card number
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

// validate expiration Date
expirationDateInput.addEventListener('input', function () {
  let date = this.value.replace(/\D/g, '').substring(0, 4);
  let month = date.substring(0, 2);

  if (month > 12) {
    document.querySelector('.expiration-error span').innerHTML = "invalid month";
    document.querySelector('.expiration-error').style.display = 'block';
    errors = true;
  } else {
    document.querySelector('.expiration-error').style.display = 'none';
  }

  if (date.length > 2) {
    date = date.substring(0, 2) + '/' + date.substring(2);
  }

  this.value = date;
});

//For Validate submit
paymentForm.addEventListener('submit', function (event) {

  event.preventDefault();

  let errors = false;

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
    document.querySelector('.card-error').style.display = 'none';
  }

  if (expirationDateInput.value === '') {
    document.querySelector('.expiration-error').style.display = 'block';
    errors = true;
  } else {
    document.querySelector('.expiration-error').style.display = 'none';
  }

  if (cvvInput.value === '') {
    document.querySelector('.cvv-error').style.display = 'block';
    errors = true;
  } else {
    document.querySelector('.cvv-error').style.display = 'none';
  }

  if (!errors) {
    form.submit();
  }
});

/*======== Payment End ========*/
