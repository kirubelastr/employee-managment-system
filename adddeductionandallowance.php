<?php
// Include database connection file
require_once "connection.php";

// Define variables and initialize with empty values
$deduction_employeeID = $deduction_managerID = $deduction_taxrate = $deduction_pension = $deduction_type = $deduction_amount = "";
$allowance_employeeID = $allowance_managerID = $allowance_type = $allowance_amount = "";
$deduction_employeeID_err = $deduction_managerID_err = $deduction_taxrate_err = $deduction_pension_err = $deduction_type_err = $deduction_amount_err = "";
$allowance_employeeID_err = $allowance_managerID_err = $allowance_type_err = $allowance_amount_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Process deduction form data
  if (isset($_POST["deduction_submit"])) {
    // Validate input
    if (isset($_POST["deduction_employeeID"])) {
      $deduction_employeeID = $_POST["deduction_employeeID"];
    }
    if (isset($_POST["deduction_managerID"])) {
      $deduction_managerID = $_POST["deduction_managerID"];
    }
    $deduction_type = validate_input($_POST["deduction_type"]);
    if (empty($deduction_type)) {
      $deduction_type_err = "Please enter a deduction type.";
    }$deduction_amount = validate_input($_POST["deduction_amount"]);
    if (empty($deduction_amount)) {
      $deduction_amount_err = "Please enter an amount.";
    } elseif (!is_numeric($deduction_amount)) {
      $deduction_amount_err = "Please enter a valid amount.";
    }
    // Insert record into database if no errors
    if (empty($deduction_employeeID_err) && empty($deduction_managerID_err) && empty($deduction_type_err) && empty($deduction_amount_err)) {
      $deduction_sql = "INSERT INTO deduction (employeeID, managerID,  deductionType, deductionAmount) VALUES (?, ?, ?, ?)";
      if ($stmt = mysqli_prepare($conn, $deduction_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "issd", $param_employeeID, $param_managerID, $param_type, $param_amount);
        // Set parameters
        $param_employeeID = $deduction_employeeID;
        $param_managerID = $deduction_managerID;
        $param_type = $deduction_type;
        $param_amount = $deduction_amount;
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          // Redirect to current page to clear form
          header("Location: " . $_SERVER["PHP_SELF"]);
          exit();
        } else {
          echo "Error executing statement: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
      }
    }
  }

  // Process allowance form data
  if (isset($_POST["allowance_submit"])) {
    // Validate input
    if (isset($_POST["allowance_employeeID"])) {
      $allowance_employeeID = $_POST["allowance_employeeID"];
    }
    if (isset($_POST["allowance_managerID"])) {
      $allowance_managerID = $_POST["allowance_managerID"];
    }
    $allowance_type = validate_input($_POST["allowance_type"]);
    if (empty($allowance_type)) {
      $allowance_type_err = "Please enter an allowance type.";
    }
    $allowance_amount = validate_input($_POST["allowance_amount"]);
    if (empty($allowance_amount)) {
      $allowance_amount_err = "Please enter an amount.";
    } elseif (!is_numeric($allowance_amount)) {
      $allowance_amount_err = "Please enter a valid amount.";
    }
    // Insert record into database if no errors
    if (empty($allowance_employeeID_err) && empty($allowance_managerID_err) && empty($allowance_type_err) && empty($allowance_amount_err)) {
      $allowance_sql = "INSERT INTO allowance (employeeID, managerID, allowanceType, allowanceAmount) VALUES (?, ?, ?, ?)";
      if ($stmt = mysqli_prepare($conn, $allowance_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "issd", $param_employeeID, $param_managerID, $param_type, $param_amount);
        // Set parameters
        $param_employeeID = $allowance_employeeID;
        $param_managerID = $allowance_managerID;
        $param_type = $allowance_type;
        $param_amount = $allowance_amount;
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          // Redirect to current page to clear form
          header("Location: " . $_SERVER["PHP_SELF"]);
          exit();
        } else {
          echo "Error executing statement: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
      }
    }
  }
}

// Function to validate input data
function validate_input($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!-- Styles for modal window -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

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
  height: auto;
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
.rightofsidebar{
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: baseline;
}
.container {
 min-width: 600px;
 max-width: 600px;
 height: auto;
 margin: 10px;
 padding: 20px;
 background-color: #fff;
 box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

 table {
border-collapse: collapse;
width: 100%;
}
th, td {
text-align: left;
padding: 8px;
}
tr:nth-child(even) {
background-color: #f2f2f2;
}
th {
background-color: #4CAF50;
color: white;
}
.modal {
  display: none;
  position: floa;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  margin: auto;
  display: block;
  max-width: 700px;
}

#qr-modal-caption {
  margin: auto;
  display: block;
  width: 80%;
  text-align: center;
}

.close {
  position: absolute;
  top: 10px;
  right: 25px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor:pointer;
}

#print-button {
    display:block;
    margin:auto;
}
form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: 0 auto;
  }
  label {
    font-weight: bold;
    margin-top: 10px;
  }
  input,
  select {
    padding: 5px;
    margin-bottom: 10px;
  }
  button {
    margin-top: 10px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
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
    <a href="createusers.php">createusers</a>
    <a href="employee.php">add employee</a>
    <a href="manager.php">add manage</a>
    <a href="deductionandallowance.php">deduction and allowance</a>
    <a class="active"href="deductionandallowance.php">add deduction and allowance</a>
    <a href="qrcode.php">qrcode</a>
    <a href="branchmanager.php">branch</a>
    <a href="everymonth.php">salary</a>
   
  </div>
  <div class="rightofsidebar">
<div class="container">
<h2>Add Record to Deduction Table</h2>
<?php
// Your PHP code here
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  <!-- Add a select element to let the user choose between employee and manager ID -->
  <label for="idType">ID Type:</label>
  <select name="idType" id="idType">
    <option value="employee">Employee</option>
    <option value="manager">Manager</option>
  </select>

  <!-- Add select element for employee ID -->
  <label for="deduction_employeeID">Employee ID:</label>
  <select name="deduction_employeeID" id="deduction_employeeID">
    <?php
    // Query employee table for employee ID and name
    // Use while loop to populate select options with employee data
    // Use htmlspecialchars() function to prevent XSS attacks
    $employee_sql = "SELECT employee.employeeID AS employeeID, employee.firstname AS firstname, employee.middlename AS middlename, employee.lastname AS lastname FROM employee";
    if ($employee_result = mysqli_query($conn, $employee_sql)) {
      while ($row = mysqli_fetch_assoc($employee_result)) {
        echo "<option value='" . htmlspecialchars($row["employeeID"]) . "'>" . htmlspecialchars($row["employeeID"]) . " :". htmlspecialchars($row["firstname"]) . " " . htmlspecialchars($row["middlename"]) . " " . htmlspecialchars($row["lastname"]) . "</option>";
      }
    }
    ?>
  </select>

  <!-- Add select element for manager ID -->
  <label for="deduction_managerID">Manager ID:</label>
  <select name="deduction_managerID" id="deduction_managerID">
    <?php
    // Query manager table for manager ID and name
    // Use while loop to populate select options with manager data
    // Use htmlspecialchars() function to prevent XSS attacks
    $manager_sql = "SELECT manager.managerID AS managerID, manager.firstname AS firstname, manager.middlename AS middlename, manager.lastname AS lastname FROM manager";
    if ($manager_result = mysqli_query($conn, $manager_sql)) {
      while ($row = mysqli_fetch_assoc($manager_result)) {
        echo "<option value='" . htmlspecialchars($row["managerID"]) . "'>" . htmlspecialchars($row["managerID"]) . " :". htmlspecialchars($row["firstname"]) . " " . htmlspecialchars($row["middlename"]) . " " . htmlspecialchars($row["lastname"]) . "</option>";
      }
    }
    ?>
  </select>

  <!-- Add the rest of your form elements here -->
  <label for="deduction_type">Deduction Type:</label>
  <input type="text" name="deduction_type" id="deduction_type" value="<?php echo $deduction_type; ?>">
  <label for="deduction_amount">Deduction Amount:</label>
  <input type="text" name="deduction_amount" id="deduction_amount" value="<?php echo $deduction_amount; ?>">
  <button type="submit" name="deduction_submit">Add Record</button>

  <!-- Add CSS to initially hide the manager ID select element -->
  <style>
  #deduction_managerID {
    display: none;
  }
  </style>

  <!-- Add JavaScript to show or hide the employee and manager select elements based on the selected option -->
  <script>
  document.getElementById('idType').addEventListener('change', function() {
    // Get the selected ID type
    var idType = this.value;

    // Show or hide the employee and manager select elements
    if (idType === 'employee') {
      document.getElementById('deduction_employeeID').style.display = 'block';
      document.getElementById('deduction_managerID').style.display = 'none';
    } else if (idType === 'manager') {
      document.getElementById('deduction_employeeID').style.display = 'none';
      document.getElementById('deduction_managerID').style.display = 'block';
    }
  });
  </script>
</form>

<h2>Add Record to Allowance Table</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  <!-- Add a select element to let the user choose between employee and manager ID -->
  <label for="idTypes">ID Type:</label>
  <select name="idTypes" id="idTypes">
    <option value="employee">Employee</option>
    <option value="manager">Manager</option>
  </select>

  <!-- Add select element for employee ID -->
  <label for="allowance_employeeID">Employee ID:</label>
  <select name="allowance_employeeID" id="allowance_employeeID">
    <?php
    // Query employee table for employee ID and name
    // Use while loop to populate select options with employee data
    // Use htmlspecialchars() function to prevent XSS attacks
    $employee_sql = "SELECT employee.employeeID AS employeeID, employee.firstname AS firstname, employee.middlename AS middlename, employee.lastname AS lastname FROM employee";
    if ($employee_result = mysqli_query($conn, $employee_sql)) {
      while ($row = mysqli_fetch_assoc($employee_result)) {
        echo "<option value='" . htmlspecialchars($row["employeeID"]) . "'>" . htmlspecialchars($row["employeeID"]) . " : ". htmlspecialchars($row["firstname"]) . " " . htmlspecialchars($row["middlename"]) . " " . htmlspecialchars($row["lastname"]) . "</option>";
      }
    }
    ?>
  </select>

  <!-- Add select element for manager ID -->
  <label for="allowance_managerID">Manager ID:</label>
  <select name="allowance_managerID" id="allowance_managerID">
    <?php
    // Query manager table for manager ID and name
    // Use while loop to populate select options with manager data
    // Use htmlspecialchars() function to prevent XSS attacks
    $manager_sql = "SELECT manager.managerID AS managerID, manager.firstname AS firstname, manager.middlename AS middlename, manager.lastname AS lastname FROM manager";
    if ($manager_result = mysqli_query($conn, $manager_sql)) {
      while ($row = mysqli_fetch_assoc($manager_result)) {
        echo "<option value='" . htmlspecialchars($row["managerID"]) . "'>" . htmlspecialchars($row["managerID"]) . " : ". htmlspecialchars($row["firstname"]) . " " . htmlspecialchars($row["middlename"]) . " " . htmlspecialchars($row["lastname"]) . "</option>";
      }
    }
    ?>
  </select>

  <!-- Add the rest of your form elements here -->
  <label for="allowance_type">Allowance Type:</label>
  <input type="text" name="allowance_type" id="allowance_type" value="<?php echo $allowance_type; ?>">
  <label for="allowance_amount">Allowance Amount:</label>
  <input type="text" name="allowance_amount" id="allowance_amount" value="<?php echo $allowance_amount; ?>">
  <button type="submit" name="allowance_submit">Add Record</button>

  <!-- Add CSS to initially hide the manager ID select element -->
  <style>
  #allowance_managerID {
    display: none;
  }
  </style>

  <!-- Add JavaScript to show or hide the employee and manager select elements based on the selected option -->
  <script>
  document.getElementById('idTypes').addEventListener('change', function() {
    // Get the selected ID type
    var idType = this.value;

    // Show or hide the employee and manager select elements
    if (idType === 'employee') {
      document.getElementById('allowance_employeeID').style.display = 'block';
      document.getElementById('allowance_managerID').style.display = 'none';
    } else if (idType === 'manager') {
      document.getElementById('allowance_employeeID').style.display = 'none';
      document.getElementById('allowance_managerID').style.display = 'block';
    }
  });
  </script>
</form>

  
    </div></div></div></div></body></html>