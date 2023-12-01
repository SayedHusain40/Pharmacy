<?php 

  // Insert data into 'user data' table
  $stmt = $db->prepare("INSERT INTO `user data` (Username, Password, Type, Email) VALUES (?, ?,'Customer', ?)");
  $stmt->execute([$user, $hps, $email]);
  $user_data_id = $db->lastInsertId(); // Retrieve the generated ID
  
  if ($user_type == "Customer") {
    // Insert data into 'customer' table
    $stmt = $db->prepare("INSERT INTO customer (UserID, FirstName, LastName, Phone) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_data_id, $fname, $lname, $phone]);
  }
  

  ?>

<label for="user_type">User Type:</label>
  <select name="user_type" id="user_type">
    <option value="Admin">Admin</option>
    <option value="Staff">Staff</option>
    <option value="Customer">Customer</option>
    <option value="Supplier">Supplier</option>
  </select>

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