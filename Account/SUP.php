<?php 
session_start();
include '../Connection/init.php';
?>
<?php
$fname = $lname = $user = $password = $Cpassword = $email = $phone_code = $phone_number = $DOB = $Gender = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = test_input($_POST['fn']);
    $lname = test_input($_POST['ln']);
    $user = test_input($_POST['un']);
    $password = test_input($_POST['ps']);
    $Cpassword = test_input($_POST['cps']);
    $email = test_input($_POST['e']);
    $phone_code = test_input($_POST['phc']);
    $phone_number = test_input($_POST['phn']);
    $DOB =  test_input($_POST['dob']);
    $Gender = test_input($_POST['gender']);

    $phone = $phone_code . $phone_number;

        try {
            require('../Connection/db.php');
            $hps = password_hash($password, PASSWORD_DEFAULT);
    
            // Insert data into 'user data' table
            $sql = $db->prepare("INSERT INTO `user data` (Username, Password, Type, Email) VALUES (?, ?, 'Customer', ?)");
            $sql->execute([$user, $hps, $email]);
            $user_data_id = $db->lastInsertId(); // Retrieve the generated ID
    
            // Insert data into 'customer data' table
            $sql = $db->prepare("INSERT INTO `customer data` (CustomerID, UserID, FirstName, LastName, MobileNumber, Email, Gender, DOB) VALUES (?, ?, ?, ?, ?,?, ?,?)");
            $sql->execute([$customerId, $user_data_id, $fname, $lname, $phone, $email, $Gender, $DOB]);
    
            // Retrieve the generated customerId from the customer table
            $customerId = $db->lastInsertId();
    
            if ($sql->rowCount() === 1) {
                header('Location: ../Account/Login.php');
                exit();
            } else {
               echo "Something went wrong while inserting data";
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" 
        crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/76f78292cc.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="../css/Sup.css" />
    <title>Document</title>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 col-md-8 col-sm-10 col-12">
    <h1>Sign up</h1>
      <form id="Signup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <fieldset class="fieldset-xl">
          <div class="form-group">
            <label for="fname">First Name:</label> <br>
            <input type="text" class="form-control" id="fname" name="fn" placeholder="Enter your first name" title="Enter your first name!" value="<?php echo $fname; ?>">
            <small> Error message</small>  
        </div>
          <div class="form-group">
            <label for="lname">Last Name:</label> <br>
            <input type="text" class="form-control" id="lname" name="ln" placeholder="Enter your last name" title="Enter your last name!" value="<?php echo $lname; ?>">
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="email">Email:</label> <br>
            <input type="text" class="form-control" id="email" name="e" placeholder="Enter an email" title="Enter an email!" value="<?php echo $email; ?>"  onInput="emailValidation(this.value)" >
            <span id="check-email" style="color: red;">Email already exists, please choose another one.</span>
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="password">Password:</label> <br>
            <input type="password" class="form-control" id="password" name="ps" placeholder="Enter a password" title="Enter a password!" value="<?php echo $password; ?>">
            <small>Error message</small>
          </div>
          <div class="form-group">
            <label for="confirm-password">Confirm Password:</label> <br>
            <input type="password" class="form-control" id="confirm-password" name="cps" placeholder="Confirm the password" title="Confirm the password!" value="<?php echo $Cpassword; ?>">
            <small> Error message</small>
          </div>
          <div class="form-group">
            <label for="username">Username:</label> <br>
            <input type="text" class="form-control" id="username" name="un" placeholder="Enter an username" title="Enter an username!" value="<?php echo $user; ?>">
            <small>Error message</small>
            <span id="check-username" style="color: red;">Username already exists.</span>
          </div>
          <div class="form-group">
          <label for="phone_number">Phone Number:</label> <br>
          <input type="text" class="form-control" id="phone_code" name="phc" placeholder="Enter code" title="Enter country code" value="<?php echo $phone_code; ?>">
          <input type="text" class="form-control" id="phone_number" name="phn" placeholder="Enter phone number" title="Enter phone number" value="<?php echo $phone_number; ?>">
          <small>Error message</small>
          </div>
          <div class="G form-group">
          <label for="gender">Gender:</label> <br>
          <input type="radio" id="male" name="gender" value="male">
          <label for="male">Male</label>
          <input type="radio" id="female" name="gender" value="female">
          <label for="female">Female</label>
          <small> Error message</small>
          </div>
          <div class="form-group">
          <label for="dob">Date of Birth:</label> <br>
          <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter your date of birth" title="Enter your date of birth">
          <small>Error message</small>
          </div>
          <div class="login-container">
          <p> Already have an account?  <a href="login.php" class="login-link" style="text-decoration: underline;"> Log in </a> <br>
          <a href="index.php">Continue as quest</a> </p>
        </div>
        <div class="form-button-wrapper1">
    <input type="submit" name="Signupbtn" value="Signup" />
  </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

    <script src="Script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>