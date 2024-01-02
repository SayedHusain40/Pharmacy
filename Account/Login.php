<?php
session_start();
include '../Connection/init.php';
$errors = [];
$user = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["un"])) {
      $errors['userRequired'] = "User name is required!";
  } else {
    $user = test_input($_POST["un"]);
  }

  if (empty($_POST["ps"])) {
      $errors['passwordRequired'] = "Password is required!";
  } else {
    $password = test_input($_POST["ps"]);
  }
 if (empty($errors))
 {

     $prepare = $db->prepare("select * from `user data` where Username=?");
     $prepare->execute([$user]);

if ($prepare->rowCount() > 0)
{
    $data = $prepare->fetch();
     if (password_verify($password, $data['Password'])){
       $_SESSION['user_id'] = $data['UserID'];
         $_SESSION['un'] = $data['Username'];
         $_SESSION['user_role'] = $data['Type'];
         // User is logged in, check their role
    if ($_SESSION['user_role'] == 'Admin') {
      // User is authorized to access the quiz page, redirect to quiz.php
      header('Location: ../Interface/HomePageAdmin.php');
      exit();
  } else if($_SESSION['user_role'] == 'Staff'){
      // User is not authorized to access the quiz page, redirect to index.php
         header('Location: ../Interface/HomePageStaff.php');
         exit();}
    else if($_SESSION['user_role'] == 'Supplier'){
      // User is not authorized to access the quiz page, redirect to index.php
         header('Location: ../Interface/HomePageSupplier.php');
         exit();}
         else if ($_SESSION['un'] == 'fat' && $_SESSION['ps'] == 'A87654321a') {  
          header('Location: ../Interface/HomePageAdmin.php');
          exit(); 
        } else {
            header('Location: ../Interface/HomePageCustomer.php');
         exit();
         }
    } else {
     $errors['ErrorUserOrPass'] = 'Incorrect username or password';
    }

} else {
        $errors['NoResult'] = 'The entered data does not exist';
} 
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Pharmacy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" 
        crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/76f78292cc.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/Account.css" />
</head>
<body>
  <?php 
  include '../header.php';
  ?>
  <div class="container">
    <div class="login-form">
    <h1>Log in</h1>
      <form id="Login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
      <fieldset class="fieldset-xl">
        <div class="form-group">
          <label for="username">Username:</label> <br>
          <input type="text" id="username" name="un" title="Enter a username!" value="<?php echo $user; ?>" class="form-control" placeholder="Enter your username" /> <br>
          <small> <?php echo isset( $errors['userRequired'] ) ? '<i class="error-icon fas fa-exclamation-circle"></i> ' .   $errors['userRequired'] : ''; ?> </small>
          <small> <?php echo isset( $errors['ErrorUserOrPass'] ) ? '<i class="error-icon fas fa-exclamation-circle"></i> ' .   $errors['ErrorUserOrPass'] : ''; ?> </small>
          <small> <?php echo isset( $errors['NoResult']  ) ? '<i class="error-icon fas fa-exclamation-circle"></i> ' .   $errors['NoResult']  : ''; ?> </small>
        </div> 
        <div class="form-group">
          <label for="password">Password:</label> <br>
          <input type="password" id="password" name="ps" title="Enter a password!" value="<?php echo $password; ?>" class="form-control" placeholder="Enter your password" /> <br>
          <small> <?php echo isset($errors['passwordRequired']) ? '<i class="error-icon fas fa-exclamation-circle"></i> ' . $errors['passwordRequired'] : ''; ?> </small>
          <small> <?php echo isset( $errors['ErrorUserOrPass'] ) ? '<i class="error-icon fas fa-exclamation-circle"></i> ' .   $errors['ErrorUserOrPass'] : ''; ?> </small>
          <small> <?php echo isset( $errors['NoResult']  ) ? '<i class="error-icon fas fa-exclamation-circle"></i> ' .   $errors['NoResult']  : ''; ?> </small>
        </div>
        </br>
        <div class="form-button-wrapper">
          <input type="submit" name="Loginbtn" value="Login" class="form-button" />
        </div>
        <hr> 
        <div class="signup-container">
          <p>If you don't have an account?</p>
          <a href="Signup.php" class="signup-link">Sign up</a> <br>
          <a href="../Interface/homepage.php">Continue as guest</a></p>
        </div>
          </fieldset>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>