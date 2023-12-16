<?php
session_start();
//include '../Connection/init.php';
$errors = [];
$fname = $lname = $user =  $email = $phone_code = $phone_number ='';

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
    else if (!preg_match("/^(?=.[A-Z])(?=.[a-z])(?=.[0-9])[A-Za-z0-9_#@%\\-]{8,24}$/", $password)){
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
      #for duplicated email & username 
      $stmt = $db->prepare("SELECT Username, Email FROM user data WHERE Username = ? OR Email = ?");
      $stmt->execute([$user, $email]);
      $result = $stmt->fetch();

      if ($result) {
      if ($user === $result['Username']) {
      $errors['duplicateUser'] = "Username already exists!";
      }
      if ($email === $result['Email']) {
      $errors['duplicateEmail'] = "An account with this E-mail already exists!";
      }
      }
    
      if (count($errors) === 0) {
        try {
            require('../Connection/db.php');
            $hps = password_hash($password, PASSWORD_DEFAULT);
    
            // Insert data into 'user data' table
            $sql = $db->prepare("INSERT INTO 'user data' (Username, Password, Type, Email) VALUES (?, ?, 'Customer', ?)");
            $sql->execute([$user, $hps, $email]);
            $user_data_id = $db->lastInsertId(); // Retrieve the generated ID
    
            // Insert data into 'customer data' table
            $sql = $db->prepare("INSERT INTO customer data (CustomerID, UserID, FirstName, LastName, MobileNumber, Email) VALUES (?, ?, ?, ?, ?,?)");
            $sql->execute([$customerId, $user_data_id, $fname, $lname, $phone, $email]);
    
            // Retrieve the generated customerId from the customer table
            $customerId = $db->lastInsertId();
    
            if ($sql->rowCount() === 1) {
                header('Location: ../Account/Login.php');
                exit();
            } else {
                $errors['Err'] = "Something went wrong while inserting data";
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" 
        crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/76f78292cc.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/Account.css" />
</head>
<body>
<?php 
  # include '../header.php';
  ?>
    <header>
    <div class="logo-container">
      <img class="logo" src="../Images/logo.png" alt="Pharmacy Logo">
    </div>
  </header>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 col-md-8 col-sm-10 col-12">
    <h1>Edit Profile</h1>
      <form id="Signup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <fieldset class="fieldset-xl">
          <!-- Display the validation errors -->
<?php if (count($errors) > 0) : ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
                    <?php
                    if(!isset($_SESSION['username']))
                    {
                    header ("location:login.php");
                    }
                    elseif($_SESSION[ 'usertype ']== 'admin' )
                    {
                    header ("location:login.php");
                    }
                            include '../Connection/init.php';

                            //$stmt = $db->prepare("SELECT * FROM product data");
                            $stmt->execute();
                            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            //require('connection.php');
                            $rs=$dd->query("SELECT * FROM 'customer data'");
                            $dd=null;
                            //$_sql= ("SELECT * FROM 'user data' WHERE Usarname ");
                            //$data-mysqli_connect (host, Suser, $password, $db);
                            $name-$_SESSION['username'];
                            $sal="SELECT * FROM user WHERE username='$name' ";
                            $result=mysqli_query ($data,$sq1);
                            $info=mysali_fetch_assoc($result);

                    ?>
          <div class="form-group">
            <label for="fname">First Name:</label> <br>
            <input type="text" class="form-control" id="fname" name="fn" title="Enter your first name!" value="<?php echo "{$info['fname']}"; ?>">
          </div>
          <div class="form-group">
            <label for="lname">Last Name:</label> <br>
            <input type="text" class="form-control" id="lname" name="ln" placeholder="Enter your last name" title="Enter your last name!" value="<?php echo "{$info['lname']}"; ?>">
          </div>
          <div class="form-group">
            <label for="email">Email:</label> <br>
            <input type="text" class="form-control" id="email" name="e" placeholder="Enter an email" title="Enter an email!" value="<?php echo "{$info['email']}"; ?>">
          </div>
          
          <div class="form-group">
            <label for="username">Username:</label> <br>
            <input type="text" class="form-control" id="username" name="un" placeholder="Enter an username" title="Enter an username!" value="<?php echo "{$info['username']}"; ?>">
          </div>
          <div class="form-group">
          <label for="phone_number">Phone Number:</label> <br>
          <input type="text" class="form-control" id="phone_code" name="phc" placeholder="Enter code" title="Enter country code" value="<?php echo "{$info['phone_code']}"; ?>">
          <input type="text" class="form-control" id="phone_number" name="phn" placeholder="Enter phone number" title="Enter phone number" value="<?php echo "{$info['lname']}"; ?>">
          </div>
          <div class="G form-group">
          <label for="gender">Gender:</label> <br>
          <input type="radio" id="male" name="gender" value="male">
          <label id="male" for="male">Male</label>
          <input type="radio" id="female" name="gender" value="female">
          <label id="female" for="female">Female</label> 
          </div>
          <div class="form-group">
          <label for="dob">Date of Birth:</label> <br>
          <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter your date of birth" title="Enter your date of birth" value="<?php echo "{$info['lname']}"; ?>">
          </div>
          
        <div class="form-button-wrapper1">
          <input type="submit" name="Signupbtn" value="Uptate"/>
        </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>