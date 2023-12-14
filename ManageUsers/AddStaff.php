<?php
session_start();
include '../Connection/init.php';
$errors = [];
$fieldErrors = array();
$fname = $lname = $user = $password = $Cpassword = $email = $phone_code = $phone_number= $DOB = $Gender= $CPR = $ADegree = $House = $Area = $Street = $Block = $SPosition = $user_type ='';

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
    $CPR = test_input($_POST['CPR']);
    $ADegree = test_input($_POST['ADegree']);
    $House = test_input($_POST['House']);
    $Area = test_input($_POST['Area']);
    $Street = test_input($_POST['Street']);
    $Block = test_input($_POST['Block']);
    $SPosition = test_input($_POST['SPosition']);
    $user_type = test_input($_POST['user_type']);
   

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

    $area = test_input($_POST["Area"]);
  if (empty($area)) {
    $fieldErrors["Area"] = "Area is required";
  }
        // Validate Area
        $area = test_input($_POST["Area"]);
        if (empty($area)) {
          $errors[] = "Area is required";
        }
      
        // Validate House
        $house = test_input($_POST["House"]);
        if (empty($house)) {
          $errors[] = "House is required";
        }
      
        // Validate Street
        $street = test_input($_POST["Street"]);
        if (empty($street)) {
          $errors[] = "Street is required";
        }
      
        // Validate Block
        $block = test_input($_POST["Block"]);
        if (empty($block)) {
          $errors[] = "Block is required";
        }
      
        // Validate Gender
        $gender = test_input($_POST["Gender"]);
        if (empty($gender)) {
          $errors[] = "Gender is required";
        }
      
        // Validate DOB
        $dob = test_input($_POST["DOB"]);
        if (empty($dob)) {
          $errors[] = "Date of Birth is required";
        }
      
        // Validate CPR
        $cpr = test_input($_POST["CPR"]);
        if (empty($cpr)) {
          $errors[] = "CPR is required";
        } elseif (!preg_match('/^\d{9}$/', $cpr)) {
          $errors[] = "CPR must be a 9-digit number";
        }
      
        // Validate Academic Degree
        $academicDegree = test_input($_POST["ADegree"]);
        if (empty($academicDegree)) {
          $errors[] = "Academic Degree is required";
        }
      
        // Validate Staff Position
        $staffPosition = test_input($_POST["SPosition"]);
        if (empty($staffPosition)) {
          $errors[] = "Staff Position is required";
        }
      #for duplicated email & username 
      $stmt = $db->prepare("SELECT `Username`, `Email` FROM `user data` WHERE `Username` = ? OR `Email` = ?");
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
            $sql = $db->prepare("INSERT INTO `user data` (Username, Password, Type, Email) VALUES (?, ?, ?, ?)");
            $sql->execute([$user, $hps, $user_type, $email]);
            $user_data_id = $db->lastInsertId(); // Retrieve the generated ID

            if ($user_type == "Customer") {
                // Insert data into 'customer data' table
            $sql = $db->prepare("INSERT INTO `customer data` (CustomerID, UserID, FirstName, LastName, MobileNumber, Email, Area, House, Street, Block, Gender, DOB) VALUES (?, ?, ?, ?, ?,?,?, ?, ?, ?,?,?)");
            $sql->execute([$customerId, $user_data_id, $fname, $lname, $phone, $email, $Area, $House, $Street, $Block, $Gender, $DOB]);
    
            // Retrieve the generated customerId from the customer table
            $customerId = $db->lastInsertId();
            }
            else if ($user_type == "Staff") {
                 // Insert data into 'Staff data' table
                 $sql = $db->prepare("INSERT INTO `Staff data` (StaffID, UserID, FirstName, LastName, MobileNumber, Email, Area, House, Street, Block, Gender, DOB, CPR, AcademicDegree, StaffPosition) VALUES (?, ?, ?, ?, ?,?,?, ?, ?, ?,?,?,?,?,?)");
                 $sql->execute([$staffId, $user_data_id, $fname, $lname, $phone, $email, $Area, $House, $Street, $Block, $Gender, $DOB, $CPR, $ADegree, $SPosition]);
                  // Retrieve the generated staffId from the staff table
                  $staffId = $db->lastInsertId(); 
            }
            else if ($user_type == "Supplier") {
                // Insert data into 'Supplier data' table
                $sql = $db->prepare("INSERT INTO `Supplier data` (SupplierID, UserID, FirstName, LastName, MobileNumber, Email) VALUES (?, ?, ?, ?, ?,?)");
                $sql->execute([$supplierId, $user_data_id, $fname, $lname, $phone, $email]);  
                // Retrieve the generated supplierId from the supplier table
               $supplierId = $db->lastInsertId();      
            }
           
    
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
<!-- HTML part -->
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
        <link rel="stylesheet" href="../css/A.css" />
</head>
<body>
<header>
    <div class="logo-container">
      <img class="logo" src="../Images/logo.png" alt="Pharmacy Logo">
    </div>
  </header>

<div class="container">
<div class="row justify-content-center">
    <div class="col-lg-12 col-md-8 col-sm-10 col-12">
    <h1>Add User:</h1>
              <!-- Display the validation errors -->
<?php if (count($errors) > 0) : ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error; ?></p>
            <?php endforeach; ?>
    </div>
<?php endif; ?>
      <form id="Signup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <fieldset class="fieldset-xl" id="staffFieldset">
        <label for="user_type">Select the user you want to add:</label>
        <select name="user_type" id="user_type" title="Choose a user type!">
        <option value="Admin">Admin</option>
        <option value="Staff">Staff</option>
        <option value="Customer">Customer</option>
        <option value="Supplier">Supplier</option>
        </select> <br>
        <div class="form-group">
            <label for="fname">First Name: <span class="required">*</span></label>
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
          <label for="phone_number">Phone Number:</label> <br>
          <input type="text" class="form-control" id="phone_code" name="phc" placeholder="Enter country code" title="Enter country code" value="<?php echo $phone_code; ?>">
          <input type="text" class="form-control" id="phone_number" name="phn" placeholder="Enter phone number" title="Enter phone number" value="<?php echo $phone_number; ?>">
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
          <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter your date of birth" title="Enter your date of birth" value="<?php echo $DOB; ?>">
          </div>
          <div class="form-group">
            <label for="CPR">CPR:</label> <br>
            <input type="text" class="form-control" id="CPR" name="CPR" placeholder="Enter CPR" title="Enter CPR" value="<?php echo $CPR; ?>">
          </div>
          <div class="form-group"> 
            <label for="ADegree">Academic Degree:</label> <br>
            <input type="text" class="form-control" id="ADegree" name="ADegree" placeholder="Enter academic degree" title="Enter academic degree" value="<?php echo $ADegree; ?>">
          </div>
          <div class="form-group">
      <label for="House">House:</label> <br>
      <input type="text" class="form-control" id="House" name="House" placeholder="Enter house" title="Enter house" value="<?php echo $House; ?>">
    </div>
    <div class="form-group">
      <label for="Area">Area:</label> <br>
      <input type="text" class="form-control" id="Area" name="Area" placeholder="Enter area" title="Enter area" value="<?php echo $Area; ?>">
      <span class="error" style="color: red;">
  <?php echo isset($fieldErrors['Area']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $fieldErrors['Area'] : ''; ?>
</span></div> 
    <div class="form-group">
      <label for="Street">Street:</label> <br>
      <input type="text" class="form-control" id="Street" name="Street" placeholder="Enter street" title="Enter street" value="<?php echo $Street; ?>">
    </div>
    <div class="form-group">
      <label for="Block">Block:</label> <br>
      <input type="text" class="form-control" id="Block" name="Block" placeholder="Enter block" title="Enter block" value="<?php echo $Block; ?>">
    </div>
          <div class="form-group">
            <label for="SPosition">Staff Position:</label> <br>
            <input type="text" class="form-control" id="SPosition" name="SPosition" placeholder="Enter staff position" title="Enter staff position" value="<?php echo $SPosition; ?>">
          </div>
          <div class="form-button-wrapper1">
          <input type="submit" name="Add User" value="Add User"/>
          </div>

        </fieldset>
      </form>
<!-- JavaScript part -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function handleRoleChange() {
    var selectedOption = document.getElementById("role").value;
    var fieldset = document.getElementById("staffFieldset");

    if (selectedOption === "Staff") {
      fieldset.style.columnCount = "3";
      fieldset.style.columnGap = "30px";
    }
  }
  $(document).ready(function() {
    $("#user_type").change(function() {
      var selectedOption = $(this).val();
      $("h1").text("Add " + selectedOption + ":");
    $('input[name="Add User"]').val("Add " + selectedOption);

      var form = $("#Signup");
      form.find("input").hide(); // Hide all form inputs initially
      form.find("label").hide(); // Hide all form labels initially

      if (selectedOption === "Staff") {
        form.find("#staffFieldset").css("columnCount", "3");
        form.find("#staffFieldset").css("columnGap", "10px");
        form.find('label[for="user_type"]').show();
        form.find('input[name="fn"]').show();
        form.find('input[name="fn"]').prev("label").show();
        form.find('input[name="ln"]').show();
        form.find('input[name="ln"]').prev("label").show();
        form.find('input[name="un"]').show();
        form.find('input[name="un"]').prev("label").show();
        form.find('input[name="ps"]').show();
        form.find('input[name="ps"]').prev("label").show();
        form.find('input[name="cps"]').show();
        form.find('input[name="cps"]').prev("label").show();
        form.find('input[name="phc"]').show();
        form.find('label[for="phone_code"]').show();
        form.find('input[name="phn"]').show();
        form.find('label[for="phone_number"]').show();
        form.find('input[name="e"]').show();
        form.find('input[name="e"]').prev("label").show();
        form.find('.G.form-group').show();
        form.find('input[name="gender"]').show();
        form.find('label[for="gender"]').show();
        form.find('label[for="male"]').show();
        form.find('label[for="female"]').show();
        form.find('input[name="dob"]').show();
        form.find('label[for="dob"]').show();
        form.find('label[for="CPR"]').show();
        form.find('input[name="CPR"]').show();
        form.find('label[for="ADegree"]').show();
        form.find('input[name="ADegree"]').show();
        form.find('label[for="House"]').show();
        form.find('input[name="House"]').show();
        form.find('label[for="Area"]').show();
        form.find('input[name="Area"]').show();
        form.find('label[for="Street"]').show();
        form.find('input[name="Street"]').show();
        form.find('label[for="Block"]').show();
        form.find('input[name="Block"]').show();
        form.find('label[for="SPosition"]').show();
        form.find('input[name="SPosition"]').show();
        form.find('input[name="Add User"]').show();
      } else if (selectedOption === "Customer") {
        form.find('label[for="user_type"]').show();
        form.find('input[name="fn"]').show();
        form.find('input[name="fn"]').prev("label").show();
        form.find('input[name="ln"]').show();
        form.find('input[name="ln"]').prev("label").show();
        form.find('input[name="un"]').show();
        form.find('input[name="un"]').prev("label").show();
        form.find('input[name="ps"]').show();
        form.find('input[name="ps"]').prev("label").show();
        form.find('input[name="cps"]').show();
        form.find('input[name="cps"]').prev("label").show();
        form.find('input[name="phc"]').show();
        form.find('label[for="phone_code"]').show();
        form.find('input[name="phn"]').show();
        form.find('label[for="phone_number"]').show();
        form.find('input[name="e"]').show();
        form.find('input[name="e"]').prev("label").show();
        form.find('.G.form-group').show();
        form.find('input[name="gender"]').show();
        form.find('label[for="gender"]').show();
        form.find('label[for="male"]').show();
        form.find('label[for="female"]').show();
        form.find('input[name="dob"]').show();
        form.find('label[for="dob"]').show();
        form.find('label[for="House"]').show();
        form.find('input[name="House"]').show();
        form.find('label[for="Area"]').show();
        form.find('input[name="Area"]').show();
        form.find('label[for="Street"]').show();
        form.find('input[name="Street"]').show();
        form.find('label[for="Block"]').show();
        form.find('input[name="Block"]').show();
        form.find('input[name="Add User"]').show();

      } else if (selectedOption === "Supplier") {
        form.find('label[for="user_type"]').show();
        form.find('input[name="fn"]').show();
        form.find('input[name="fn"]').prev("label").show();
        form.find('input[name="ln"]').show();
        form.find('input[name="ln"]').prev("label").show();
        form.find('input[name="un"]').show();
        form.find('input[name="un"]').prev("label").show();
        form.find('input[name="ps"]').show();
        form.find('input[name="ps"]').prev("label").show();
        form.find('input[name="cps"]').show();
        form.find('input[name="cps"]').prev("label").show();
        form.find('input[name="phc"]').show();
        form.find('label[for="phone_code"]').show();
        form.find('input[name="phn"]').show();
        form.find('label[for="phone_number"]').show();
        form.find('input[name="e"]').show();
        form.find('input[name="e"]').prev("label").show();
        form.find('input[name="Add User"]').show();
      }
    });
  });
</script>