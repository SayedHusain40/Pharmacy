// Show input error message
  if (isset($errors)) {
    var formControl = input.parentElement;
    formControl.className = 'form-control error';
    var small = formControl.querySelector('small');
    small.innerText = message;
  }
  
  // Show success outline
  if (!isset($errors))  {
    const formGroup = input.parentElement;
    formGroup.className = 'form-group success';
  }