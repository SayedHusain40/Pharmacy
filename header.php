<div>
      <!-- Navigation Bar-->
      <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
      <a class="navbar-brand" href="../Account/Login.php"> <img src="images/logo.jpeg" class="logo" /> </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto float-none">
          <li class="nav-item active">
            <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown mr-5">
            <a class="nav-link dropdown-toggle" href="../Account/Signup.php" role="button" data-toggle="dropdown" aria-expanded="false">
              Account
            </a>
            <div class="dropdown-menu">
            <?php     
      if (isset($_SESSION['un']))
      {  
        if ($_SESSION['user_role'] == 'Admin') {
          echo '<a class="dropdown-item" href="profile.php">profile</a>';
          echo '<a class="dropdown-item" href="QuizzesCreated.php">manage quizzes</a>';
          echo '<a class="dropdown-item" href="DisplayAllAccounts.php">manage accounts</a>';
          echo '<a class="dropdown-item" href="../Account/Logout.php">logout</a>';
        } else if ($_SESSION['user_role'] == 'Staff'){
            echo '<a class="dropdown-item" href="profile.php">profile</a>';
          echo '<a class="dropdown-item" href="QuizzesCreated.php">manage quizzes</a>';
          echo '<a class="dropdown-item" href="../Account/Logout.php">logout</a>';
        } else {
          echo '<a class="dropdown-item" href="profile.php">profile</a>';
          echo '<a class="dropdown-item" href="../Account/Logout.php">logout</a>';
        }
      }else{
          echo '<a class="dropdown-item" href="../Account/Login.php">Log in</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../Account/Signup.php">Create an account</a>
        ';
      }
      ?>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    </div>