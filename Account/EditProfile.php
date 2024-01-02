<?php
 session_start();
if (isset($_SESSION['username']))
  {
      header("location:Login.php");
  }
  elseif($_SESSION['Type']=='Admin')
  {
    header("location:Login.php");
  }

$host="localhost" ;
$user-"root"; $password="";
$db="pharmacy";
$data=mysqli_connect ($host, $user, $password,$db);
$name=$_SESSION['username'] ;
$sql="SELECT * FROM 'customer data'WHERE username='$name'";
$result=mysqli_quere($data,$sql);
$info=mysqli_fetch_assoc($result);

if(isset($_POST['Updatebtn']))
{
$s_fn=$_POST['fn']; 
$s_ln=$_POST['ln'];  
$s_email=$_POST['email'];
$s_phc=$_POST['phc'];
$s_phn=$_POST['phn'];
$_gender=$POST['gender'] 
$sql2="UPDATE 'user data' SET fn='$s_fn' ln='$s_ln' email='$s_email', phn= '$s_phn' ,phc='$s_phc' gender='$s_gender' WHERE username='$name' ";
$result2 mysqli_query($data,$sql2);

if($result2)
  {
    echo"update Success";
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
    <header>
    <div class="logo-container">
      <img class="logo" src="../Images/logo.png" alt="Pharmacy Logo">
    </div>
  </header>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 col-md-8 col-sm-10 col-12">
    <h1>Update Profile</h1>
      <form id="Signup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <fieldset class="fieldset-xl">
    </div>
    <div class="form-group">
            <label for="lname">First Name:</label> <br>
            <input type="text" class="form-control" id="lname" name="fn"  value="<?php echo {$info['FirstName']} ?>">
          </div>
          <div class="form-group">
            <label for="lname">Last Name:</label> <br>
            <input type="text" class="form-control" id="lname" name="ln"  value="<?php echo {$info['LastName']} ?>">
          </div>
          <div class="form-group">
            <label for="email">Email:</label> <br>
            <input type="text" class="form-control" id="email" name="e"  value="<?php echo {$info['Email']} ?>">
          </div>
          <div class="form-group">
          <label for="phone_number">Phone Number:</label> <br>                      
          <input type="text" class="form-control" id="phone_code" name="phc"  value="<?php echo {$info['phone_code']}; ?>">
          <input type="text" class="form-control" id="phone_number" name="phn"  value="<?php echo {$info['phone_number']}; ?>">
          </div>
          <div class="G form-group">
          <label for="gender">Gender:</label> <br>
          <input type="radio" id="male" name="gender" value="<?php echo {$info['Gender']} ?>">
          <label id="male" for="male">Male</label>
          <input type="radio" id="female" name="gender" value="<?php echo {$info['Gender']} ?>">
          <label id="female" for="female">Female</label> 
          </div>
          <div class="form-group">
          <label for="dob">Date of Birth:</label> <br>
          <input type="date" class="form-control" id="dob" name="dob" value="<?php echo {$info['DOB']} ?>">
          </div>
        <div class="form-button-wrapper1">
          <input type="submit" name="Updatebtn" value="Update"/>
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