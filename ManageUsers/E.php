<label for="user_type">User Type:</label>
<select name="user_type" id="user_type" title="Select the user type you want to edit!" onchange="displayUserDropdown()">
  <?php
  if (isset($_SESSION['un']) && $_SESSION['user_role'] == 'Admin') {
    echo '<option value="Staff" selected>Staff</option>';
  }
  ?>
  <option value="Customer">Customer</option>
  <option value="Supplier">Supplier</option>
</select>
</div>
<?php
require('../Connection/db.php');

if (isset($_POST['user_type'])) {
    $user_type = $_POST['user_type'];
  
    if ($user_type === 'Staff' || $user_type === 'Customer' || $user_type === 'Supplier') {
      $stmt = $db->query("SELECT * FROM `user data` WHERE `Type`='$user_type'");
      $users = $stmt->fetchAll();
  
      echo '
      <div id="user_dropdown" style="display: none;">
      <label for="selected_user">' . $user_type  . '</label>';
      echo '<select  name="selected_user" id="selected_user" title="Select the user you want to edit!">';
  
      foreach ($users as $user) {
        echo '<option value="' . $user['UserID'] . '">';
        echo $user['UserID'] . ' - ' . $user['Username'] . ' - ' . $user['FirstName'] . ' ' . $user['LastName'];
        echo '</option>';
      }
  
      echo '</select> <br> <br>';
    }
  }
?>
<script>
function displayUserDropdown() {
  var userDropdown = document.getElementById("user_dropdown");
  var userTypeSelect = document.getElementById("user_type");
  var selectedUserType = userTypeSelect.value;

  if (selectedUserType === "Staff" || selectedUserType === "Customer" || selectedUserType === "Supplier") {
    userDropdown.style.display = "block";

    // Fetch users based on the selected user type using AJAX or any other method
    // Update the "selected_user" dropdown options dynamically with the fetched data
  } else {
    userDropdown.style.display = "none";
  }
}
</script>