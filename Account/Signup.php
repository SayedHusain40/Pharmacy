<?php
session_start();
include '../Connection/init.php';
$errors = [];
$fname = $lname = $user = $password = $Cpassword = $email = $phone_code = $phone_number= $user_type ='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = test_input($_POST['fn']);
    $lname = test_input($_POST['ln']);
    $user = test_input($_POST['un']);
    $password = test_input($_POST['ps']);
    $Cpassword = test_input($_POST['cps']);
    $email = test_input($_POST['e']);
    $phone_code = test_input($_POST['phc']);
    $phone_number = test_input($_POST['phn']);

    $phone = $phone_code . $phone_number;
 
    //validation
    if (empty($fname)){
      $errors['fnameRequired'] = "First name is required!";
      } else if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
      $errors['fnameErr'] = "Please enter a valid first name with only letters, spaces, hyphens, and apostrophes.";
      }
      if (empty($lname)){
      $errors['lnameRequired'] = "Last name is required!";
      } else if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
      $errors['lnameErr'] = "Please enter a valid last name with only letters, spaces, hyphens, and apostrophes.";
      }
    if (empty($user)){
    $errors['userRequired'] = "User name is required!";
    } 
     //input format validations
     if (!preg_match("/^[a-zA-Z-']*$/", $user)){
        $errors['userErr'] = "Only letters and white space is allowed for username";
        }
        if (empty($email)) {
          $errors['emailRequired'] = "Email is required!";
      } else if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
          $errors['emailErr'] = "Please enter a valid email address.";
      }
    if (empty($password)){
        $errors['passwordRequired'] = "password is required!";}
    else if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%*\\-]{8,24}$/", $password)){
        $errors['passErr'] = "Please write a good password that includes at least 8 characters, a mixture of uppercase and lowercase letters, and a number. You can also use special characters like _#@%*-.";
    }
    if (empty($Cpassword)){
    $errors['CpasswordRequired'] = "Confirm password is required!";
    }
    if ($password != $Cpassword){
    $errors['CpassErr']="Passwords don't match";
    }
    if (empty($phone)){
      $errors['phoneRequired'] = "Phone number is required!";
    } else if (!preg_match("/^\+[1-9]\d{0,2}$/", $phone_code) || !preg_match("/^\s?\d{1,14}$/", $phone_number)) {
      $errors['phoneErr'] = "Please enter a valid phone number with country code.";
    }
    if (isset($_POST['Utype']) && !empty($_POST['Utype'])) {
          $user_type = test_input($_POST['Utype']);
          $_SESSION['user_role'] = $user_type;
      } else {
          $errors['userTypeRequired'] = "User type is required!";
      }
      #for duplicated email & username 
      $stmt = $db->prepare("SELECT `Username`, `Email` FROM `user data` WHERE `Username` = ? OR `Email` = ?");
      $stmt->execute([$user, $email]);
      $result = $stmt->fetch();

      if ($result) {
      if ($user === $result['username']) {
      $errors['duplicateUser'] = "Username already exists!";
      }
      if ($email === $result['Email']) {
      $errors['duplicateEmail'] = "An account with this E-mail already exists!";
      }
      }
    
if (count($errors) === 0) {
try{
    require('../Connection/db.php');
    $hps=password_hash($password,PASSWORD_DEFAULT);
    $sql = "insert into users value(id,'$user', '$hps', '$fname', '$lname', '$user_type', '$email', '$phone', '')";
    $r=$db->exec($sql); 
    if ($r==1) {
    header('Location: login.php');
    exit();
    }else {
        $errors['Err'] = "Something went wrong while inserting data";
    }
   }
   catch(PDOException $e){
    die("Error: ".$e->getMessage());
   }
}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-10">
      <form id="Signup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <fieldset class="fieldset-xl">
          <h1>Sign up</h1>
          <!-- Display the validation errors -->
<?php if (count($errors) > 0) : ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
          <div class="form-group">
            <label for="fname">First Name:</label>
            <input type="text" class="form-control" id="fname" name="fn" placeholder="Enter your first name" title="Enter your first name!" value="<?php echo $fname; ?>">
          </div>
          <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" class="form-control" id="lname" name="ln" placeholder="Enter your last name" title="Enter your last name!" value="<?php echo $lname; ?>">
          </div>
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="un" placeholder="Enter an username" title="Enter an username!" value="<?php echo $user; ?>">
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="e" placeholder="Enter an email" title="Enter an email!" value="<?php echo $email; ?>">
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="ps" placeholder="Enter a password" title="Enter a password!" value="<?php echo $password; ?>">
          </div>
          <div class="form-group">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm-password" name="cps" placeholder="Confirm the password" title="Confirm the password!" value="<?php echo $Cpassword; ?>">
          </div>
          <div class="form-group">
          <label for="phone_number">Phone Number:</label>
          <input type="text" class="form-control" id="phone_code" name="phc" placeholder="Enter country code" title="Enter country code" value="<?php echo $phone_code; ?>">
          <input type="text" class="form-control" id="phone_number" name="phn" placeholder="Enter phone number" title="Enter phone number" value="<?php echo $phone_number; ?>">
          </div>
          <p>Select your user type:</p>
      <label for="teacher" title="Enter an user type!">
      <input type="radio" class="teacher" id="teacher" name="Utype" value="teacher" title="Enter an user type!">
      Teacher
    </label><br>
    <label for="administrator" title="Enter an user type!">
      <input type="radio" class="administrator" id="administrator" name="Utype" value="administrator" title="Enter an user type!">
      Administrator
    </label><br>
    <label for="student" title="Enter an user type!"> <input type="radio" class="student" id="student" name="Utype" value="student" title="Enter an user type!">
      Student
    </label><br> 
    <label for="teacher" title="Enter an user type!"> <input type="radio" class="teacher" id="teacher" name="Utype" value="teacher" title="Enter an user type!">
      Teacher
    </label><br>
          Already have an account?  <a href="login.php" style="text-decoration: underline;"> Log in </a> <br>
          <input type="submit" name="Signupbtn" value="Signup"/>
        </fieldset>
      </form>
    </div>
  </div>
</div>
</body>
</html>