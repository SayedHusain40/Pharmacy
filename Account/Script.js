const fname = document.getElementById('fname');
const lname = document.getElementById('lname');
const email = document.getElementById('email');
const password = document.getElementById('password');
const Cpassword = document.getElementById('confirm-password');
const username = document.getElementById('username');
const phone_code = document.getElementById('phone_code');
const phone_number = document.getElementById('phone_number');
const Mgender = document.getElementById('male');
const Fgender = document.getElementById('female');
const dob = document.getElementById('dob');

const phone = phone_code.value + phone_number.value;

//helper function
function GetXmlHttpObject() { 
  var xmlHttp=null; 
  try 
      {
      xmlHttp=new XMLHttpRequest(); 
      }
  catch (e) 
      { 
      // Internet Explorer 
      try 
          { xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); } 
      catch (e) 
          { xmlHttp=new ActiveXObject("Microsoft.XMLHTTP"); }
      } 
  return xmlHttp; 
}

// Show input error message
  function showError(input, message) {
    const formGroup = input.parentElement;
    formGroup.className = 'form-group error';
    const small = formGroup.querySelector('small');
    small.innerText = message;
  }

// Show success outline
function showSuccess(input) {
  const formGroup = input.parentElement;
  formGroup.className = 'form-group success';
}

 //check First name
 function checkFName(input) {
    let error = 0;
    const re = /^[a-zA-Z-' ]*$/;
    if (input.value.trim() === '') {
        showError(input, `First name is required!`);
        ++error;
      } else{
if (re.test(input.value.trim())) {
      showSuccess(input);
    } else {
      showError(input, 'Please enter a valid first name with only letters, spaces, hyphens, and apostrophes.');
      ++error;
    }
            
} 
    return error;
  }

   //check Last name
 function checkLName(input) {
    let error = 0;
    const re = /^[a-zA-Z-' ]*$/;
    if (input.value.trim() === '') {
        showError(input, `Last name is required!`);
        ++error;
      } else{
if (re.test(input.value.trim())) {
      showSuccess(input);
    } else {
      showError(input, 'Please enter a valid last name with only letters, spaces, hyphens, and apostrophes.');
      ++error;
    }} 
    return error;
  }

 //check user name
 function checkUserName(input) {
    let error = 0;
    const re = /^[A-Za-z0-9$\-_]+$/; // Updated regular expression
    const rel = /^.{3,50}$/; // Updated regular expression
  
    if (input.value.trim() === '') {
      showError(input, 'User name is required');
      error++;
    } else if (!rel.test(input.value.trim())) {
        showError(input, 'Username must be between 3 and 50 characters.');
        error++;
      } else {
      if (re.test(input.value.trim())) {
        showSuccess(input);
      } else {
        showError(input, 'Only letters, numbers, and special characters ($, -, _) are allowed for username.');
        error++;
      }
    }
  
    
  
    return error;
  }

   //check email
 function checkEmail(input) {
    let error = 0;
    const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (input.value.trim() === '') {
        showError(input, 'Email is required!');
        ++error;
      } else {
    if (re.test(input.value.trim())) {
      showSuccess(input);
    } else {
      showError(input, 'Please enter a valid email address.');
      ++error;
    } }
    return error;
  }  

  function checkPassword(input) {
    let error = 0;
    const re = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[_#@%*-]).+$/;
    const rel = /^.{8,255}$/;
  
    if (input.value.trim() === '') {
      showError(input, 'Password is required!');
      error++;
    } else if (!rel.test(input.value.trim())) {
      showError(input, 'Password must be between 8 and 255 characters.');
      error++;
    } else {
      if (re.test(input.value.trim())) {
        showSuccess(input);
      } else {
        showError(
          input,
          'Enter a strong password (at least 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character like _#@%*-).'
        );
        error++;
      }
    }
  
    return error;
  }
  
       //check Confirm password
 function checkCPassword(input) {
    let error = 0;
    if (input.value.trim() === '') {
        showError(input, `Confirm password is required!`);
        ++error;
      } else { 
        showSuccess(input);
      }
    return error;
  } 

    // Check passwords match
function checkPasswordsMatch(input1, input2) {
    let error = 0;
    if (input1.value !== input2.value) {
      showError(input2, 'Passwords do not match');
      ++error;
    }
    return error;
  }

       //check Phone number
       function checkPhone(input) {
        const reC = /^\+[1-9]\d{0,2}$/;
        const reN = /^\s?\d{1,14}$/;
      
        if (input.value.trim() === '') {
          showError(input, 'Phone number is required!');
          return 1; // Return 1 to indicate an error occurred
        }
      
        if (reC.test(input.value.trim()) || reN.test(input.value.trim())) {
          showSuccess(input);
          return 0; // Return 0 to indicate no error
        } else {
          showError(input, 'Please enter a valid phone number with country code.');
          return 1; // Return 1 to indicate an error occurred
        }
      }

   // Check Date of Birth
function checkDOB(input) {
    let errors = 0;
    
    if (input.value.trim() === '') {
      showError(input, 'Date of Birth is required');
      errors++;
    } else {
      const dob = new Date(input.value);
      const maxDate = new Date('2012-12-31');
  
      if (dob > maxDate) {
        showError(input, 'Customers cannot be born after 2012');
        errors++;
      } else {
        showSuccess(input); // Assuming you have a function to hide the error message
      }
    }
  
    return errors;
  }
      
// check username is unique
  function uniqueUserName(input) {
    var xmlHttp = new XMLHttpRequest();
    var url = "../Account/check-username.php";
    var params = "un=" + encodeURIComponent(input.value);
  
    xmlHttp.onreadystatechange = function() {
      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var response = xmlHttp.responseText;
        var checkUsername = document.getElementById("check-username");
  
        if (response === 'Not unique') {
          showError(input, "");
          checkUsername.style.display = "block";
        } else {
          checkUsername.style.display = "none";
        }
      }
    };
  
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.send(params);
  }

//check email is unique
function uniqueEmail(input) {
    var xmlHttp = new XMLHttpRequest();
    var url = "../Account/check-email.php";
    var params = "email=" + encodeURIComponent(input.value);
  
    xmlHttp.onreadystatechange = function() {
      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var response = xmlHttp.responseText;
        var checkEmail = document.getElementById("check-email");
  
        if (response === 'Not unique') {
          showError(input, "");
          checkEmail.style.display = "block";
        } else {
          checkEmail.style.display = "none";
        }
      }
    };
  
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.send(params);
  }

// Get fieldname
function getFieldName(input) {
  return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

    

const form = document.getElementById('Signup');

form.addEventListener('submit', function(e) {
  e.preventDefault(); // prevents auto-submit

  let allErrors = 0;
  allErrors += checkFName(fname);
  allErrors += checkLName(lname);
  allErrors += checkEmail(email);
  allErrors += checkUserName(username);
  allErrors += checkPassword(password);
  allErrors += checkCPassword(Cpassword);
  allErrors += checkPhone(phone_code, phone_number); // Pass both phone_code and phone_number as separate arguments
  allErrors += checkDOB(dob);
  allErrors += uniqueUserName(username);
  allErrors += uniqueEmail(email);
  allErrors += checkPasswordsMatch(password, Cpassword);

  // If all requirements are successful, submit the form
  if (allErrors === 0)
    form.submit();
});