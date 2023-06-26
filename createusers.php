<?php
require_once "connection.php";

// Check if the create form has been submitted
if (isset($_POST['create'])) {
    // Get the form data
    $employeeID = $_POST['employeeID'];
    $managerID = $_POST['managerID'];
    $userType = $_POST['userType'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the password and confirm password match
    if ($password != $confirmPassword) {
        // Display an error message
        echo "<script>alert('Error: Password and confirm password do not match!');</script>";
    } else {
        // Hash the password
        $hashedPassword = md5($password);

        // Validate the password
        function validate_password($password) {
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $symbol    = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$symbol || strlen($password) < 8) {

                return false;
            } else {
                return true;
            }
        }

        // Check if employeeID is set
        if (!empty($employeeID)) {
            // Get the employee's email from the employee table
            $employee_sql = "SELECT * FROM employee WHERE employeeID=?";
            $employee_stmt = $conn->prepare($employee_sql);
            $employee_stmt->bind_param("i", $employeeID);
            $employee_stmt->execute();
            $employee_result = $employee_stmt->get_result();

            // Check if there is any row in the result
            if ($employee_result->num_rows > 0) {
                // Get the employee's email from the row
                $employee_row = $employee_result->fetch_assoc();
                $username = $employee_row['email'];

                // Insert the user into the logins table if password is valid
                if (validate_password($password)) {
                    $insert_sql = "INSERT INTO login (username, password, role) VALUES (?, ?, ?)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("sss", $username, $hashedPassword, $userType);
                    $insert_stmt->execute();

                    $userID = $conn->insert_id;

                    $employee_sql = "UPDATE employee SET userID=? WHERE employeeID=?";
                    $employee_stmt = $conn->prepare($employee_sql);
                    $employee_stmt->bind_param("ii", $employeeID, $userID);
                    $employee_stmt->execute();


                    // Display a success message
                    echo "<script>alert('User created successfully!!');</script>";
                } else {
                    echo "<script>alert('Error: Password is not strong enough!');</script>";
                }
            } else {
                // Display an error message
                echo "<script>alert('Error: Invalid employee ID!!');</script>";
            }
        } elseif (!empty($managerID)) {
            // Get the manager's email from the manager table
            $manager_sql = "SELECT * FROM manager WHERE managerID=?";
            $manager_stmt = $conn->prepare($manager_sql);
            $manager_stmt->bind_param("s", $managerID);
            $manager_stmt->execute();
            $manager_result = $manager_stmt->get_result();

            // Check if there is any row in the result
            if ($manager_result->num_rows > 0) {
                // Get the manager's email from the row
                $manager_row = $manager_result->fetch_assoc();
                $username = $manager_row['email'];

                // Insert the user into the logins table if password is valid
                if (validate_password($password)) {
                  // Insert the new user into the login table
                        $insert_sql = "INSERT INTO login (username, password, role) VALUES (?, ?, ?)";
                        $insert_stmt = $conn->prepare($insert_sql);
                        $insert_stmt->bind_param("sss", $username, $hashedPassword, $userType);
                        $insert_stmt->execute();

                        // Get the ID of the newly inserted user
                        $userID = $conn->insert_id;

                        // Update the manager table with the specified managerID and userID
                        $manager_sql = "UPDATE manager SET userID=? WHERE managerID=?";
                        $manager_stmt = $conn->prepare($manager_sql);
                        $manager_stmt->bind_param("is", $userID, $managerID);
                        $manager_stmt->execute();


                    // Display a success message
                    
                    echo "<script>alert('User created successfully!!');</script>";
                } else {
                    echo "<script>alert('Error: Password is not strong enough!');</script>";
                }
            } else {
                // Display an error message
                 echo "<script>alert('Error: Invalid manager ID!!');</script>";
            }
        }
    }
}
// Check if the update form has been submitted
if (isset($_POST['update'])) {
    // Get the form data
    $loginID = $_POST['loginID'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType2'];

    // Hash the password
     $hashedPassword = md5($password);

     // Define the password requirements
     $requirements = "Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one number and one special character.";

     // Validate the password
     if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-z]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#\W+#", $password)) {
         echo "<script>alert('$requirements');</script>";
         echo "<script>window.location.href='createusers.php';</script>";
         exit;
     }

     // Check if the password contains text
     if (!preg_match("/[a-zA-Z]/", $password)) {
         $requirements = "Password must contain at least one letter.";
         echo "<script>alert('$requirements');</script>";
         echo "<script>window.location.href='createusers.php';</script>";
         exit;
     }

    // Update the user in the logins table
    $update_sql = "UPDATE login SET username=?, password=?, role=? WHERE userID=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $username, $hashedPassword, $userType, $loginID);
    $update_stmt->execute();

    // Display a success message
    echo "<script>alert('User updated successfully!');</script>";
    echo "<script>window.location.href='createusers.php';</script>";
}


// Check if the delete form has been submitted
if (isset($_POST['delete'])) {
    // Get the form data
    $loginID = $_POST['loginID'];

    // Delete the user from the logins table
    $delete_sql = "DELETE FROM login WHERE userID=?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $loginID);
    $delete_stmt->execute();

    // Display a success message
    echo "<script>alert('User deleted successfully!!');</script>";
    echo "<script>window.location.href='createusers.php';</script>";
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>creates users</title>
    <style>
    body {
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: stretch;
}
.page-container {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: stretch;
    }

    .content-container {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: stretch;
    }
.sidebar {
  width: 200px;
  height: 100vh;
  background-color: #f0f0f0;
  padding: 20px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
}

.sidebar h3 {
  margin-top: 0;
}

.sidebar a {
  display: block;
  margin-bottom: 10px;
  padding: 10px;
  width: 100%;
  text-align: center;
  text-decoration: none;
  color: #333;
  border-left: 5px solid transparent;
}

.sidebar a.active,
.sidebar a:hover {
  background-color: #ddd;
  border-left-color: red;
}

.form-container {
  flex: 1;
  padding: 20px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: stretch;
}

.form-container h2 {
    margin-top:0; 
    margin-bottom :10px; 
}

.form-section {
    margin-bottom :5px; 
    border :1px solid #ccc; 
    border-radius :4px; 
    padding :10px; 
    box-sizing :border-box; 
}
.form-section2{
    height :350px; 
    margin-bottom :5px; 
    border :1px solid #ccc; 
    border-radius :4px; 
    padding :10px; 
    box-sizing :border-box; 
    
}

.form-section h3 {
    margin-top :0; 
    margin-bottom :5px; 
}
form {
    display:block; 
    flex-wrap :wrap; 
    justify-content:left; 
    align-items:center; 
}

label {
    display:inline-block; 
    width :140px; 
    text-align:right; 
    margin-right :20px; 
}
    
input[type="submit"] {
      background-color:#09f ; 
      color:#fff ; 
      border:none ; 
      border-radius :4px ; 
      padding :10px ; 
      cursor:pointer ; 
      font-size :16px ; 
      margin-top :10px ;  
}
input,
select,
textarea {
      position :inherits ;  
      flex :1 ;  
      padding :10px ;  
      border :1px solid #ccc ;  
      border-radius :4px ;  
      box-sizing:border-box ;  
      margin-bottom :10px ;  
      font-size :16px ;  
}

input[type="file"] {
      padding :10 ;
}

input:focus,
select:focus,
textarea:focus {
      outline:none ;
      border-color:#09f ;
}

select {
      width :inherit ;
      padding-left: 20px;
      padding-right: 10px;
}

textarea {
      height :auto ;
}

input[type="submit"]:hover {
      background-color:#0077cc ;
}
</style>

</head>
<body>
<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>admin</h3>
    <a  href="department_and_position.php">department and position</a>
    <a href="aproveleave.php">aprove leave</a>
    <a class="active"href="createusers.php">createusers</a>
    <a href="employee.php">add employee</a>
    <a href="manager.php">add manage</a>
    <a href="deductionandallowance.php">deduction and allowance</a>
    <a href="adddeductionandallowance.php">add deduction and allowance</a>
    <a href="qrcode.php">qrcode</a>
    <a href="branchmanager.php">branch</a>
    <a href="everymonth.php">salary</a>
  </div>

  <div class="form-container">
<form method="post">
   
<!-- The create form -->
<form method="post">
    <h2>Create User</h2>

    <label for="employeeID">Employee:</label>
    <select name="employeeID" id="employeeID">
        <option value="">--Select Employee--</option>
        <?php
        // Query to get all employees from the employee table
        $sql = "SELECT * FROM employee";
        $result = $conn->query($sql);

        // Check if there is any row in the result
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Get the employee ID and name from the row
                $employeeID = $row['employeeID'];
                $name = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];

                // Output the employee as an option in the select element
                echo "<option value='$employeeID'>$name</option>";
            }
        }
        ?>
    </select><br>

    <label for="managerID">Manager:</label>
    <select name="managerID" id="managerID">
        <option value="">--Select Manager--</option>
        <?php
        // Query to get all managers from the manager table
        $sql = "SELECT * FROM manager";
        $result = $conn->query($sql);

        // Check if there is any row in the result
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Get the manager ID and name from the row
                $managerID = $row['managerID'];
                $name = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];

                // Output the manager as an option in the select element
                echo "<option value='$managerID'>$name</option>";
            }
        }
        ?>
    </select><br>

    <label for="createUserType">User Type:</label>
    <select name="userType" id="createUserType" required>
        <option value="">--Select User Type--</option>
        <option value="general manager(admin)">General Manager</option>
        <option value="manger(branch manager)">Regional Manager(branch)</option>
        <option value="employee">Employee</option>
    </select><br>

    <label for="createPassword">Password:</label>
    <input type="password" name="password" id="createPassword"required><br>

    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" name="confirmPassword" id="confirmPassword"required><br>

    <input type="submit" name="create" value="Create User">
</form>

<!-- The update form -->
<form method="post" id="updateForm">
    <h2>Update User</h2>

    <input type="hidden" name="loginID" id="updateLoginID" >

    <label for="updateUsername">Username:</label>
    <input type="text" name="username" id="updateUsername" required><br>

    <label for="updatePassword">Password:</label>
    <input type="password" name="password" id="updatePassword" required><br>

    <label for="updateUserType">User Type:</label>
    <select name="userType2" id="updateUserType" required>
        <option value="">--Select User Type--</option>
        <option value="general manager(admin)">General Manager</option>
        <option value="manger(branch manager)">Regional Manager(branch)</option>
        <option value="employee">Employee</option>
    </select><br>
    <input type="submit" name="update" value="Update User">
</form>
    </div>
    <div class="form-container">
<!-- The HTML table -->
<table>
    <tr>
        <th>Login ID</th>
        <th>Username</th>
        <th>User Type</th>
        <th>Actions</th>
    </tr>
    <?php
    // Query to get all users from the logins table
    $sql = "SELECT * FROM login";
    $result = $conn->query($sql);

    // Check if there is any row in the result
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Get the login ID, username, and user type from the row
            $loginID = $row['userID'];
            $username = $row['username'];
            $userType = $row['role'];

            // Output the data as a row in the HTML table
            echo "<tr>";
            echo "<td>$loginID</td>";
            echo "<td>$username</td>";
            echo "<td>$userType</td>";
            echo "<td>";
            echo "<button onclick='editUser($loginID, \"$username\", \"$userType\")'>Edit</button>";
            echo "<form method='post' style='display:inline-block'>";
            echo "<input type='hidden' name='loginID' value='$loginID'>";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>

<!-- The JavaScript code -->
<script>
function editUser(loginID, username, userType) {
    // Set the form values
    document.getElementById('updateLoginID').value = loginID;
    document.getElementById('updateUsername').value = username;
    document.getElementById('updateUserType').value = userType;

    // Show the update form
    document.getElementById('updateForm').style.display = 'block';
}
</script>


    </div>
  </div>
</body>
</html>

