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
    <title>Document</title>
</head>
<body>
  <?php 
  # include '../header.php';
  ?>
  <br>
<div class="container">
  <div class="row justify-content-center">
  <div class="col-lg-6 col-md-8 col-sm-10 col-12">
            <form id="Login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
        <fieldset class="fieldset-xl">

        <h1> Log in </h1>

          <!-- Display the validation errors -->
        <?php if (count($errors) > 0) : ?>
        <div class="alert alert-danger">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error;?></p>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="form-group">
        <label for="username">Username:</label> 
        <input type="text" id="username" name="un" title="Enter an username!" value="<?php echo $user; ?>" class="form-control" />
        </div>
        <div class="form-group">
        <label for="password">Password:</label> 
        <input type="password" id="password" name="ps" title="Enter a password!" value="<?php echo $password; ?>" class="form-control" />
        </div>
        If You don't have an account?  <a href="Sign.php" style="text-decoration: underline;"> Sign up </a>
        </br><input type="submit" name="Loginbtn" value="Login"/>
    </fieldset> 
    </form>
</div>
          </div>
        </div>
    
</body>
</html>