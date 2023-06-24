<?php
// Include database connection file
require_once "connection.php";

// Define variables and initialize with empty values
$deduction_employeeID = $deduction_managerID = $deduction_amount = "";
$allowance_employeeID = $allowance_managerID = $allowance_amount = "";
$deduction_employeeID_err = $deduction_managerID_err = $deduction_amount_err = "";
$allowance_employeeID_err = $allowance_managerID_err = $allowance_amount_err = "";
$search_employeeID = $search_managerID = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate search input
  $search_employeeID = validate_input($_POST["searchID"]);
  $search_managerID = validate_input($_POST["searchID"]);

  // Prepare SQL statement for deduction table search
  $deduction_sql = "SELECT * FROM deduction WHERE employeeID = ? OR managerID = ?";
  if ($stmt = mysqli_prepare($conn, $deduction_sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "is", $param_employeeID, $param_managerID);
    // Set parameters
    $param_employeeID = $search_employeeID;
    $param_managerID = $search_managerID;
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
      $deduction_result = mysqli_stmt_get_result($stmt);
    } else {
      echo "Error executing statement: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
  }

  // Prepare SQL statement for allowance table search
  $allowance_sql = "SELECT * FROM allowance WHERE employeeID = ? OR managerID = ?";
  if ($stmt = mysqli_prepare($conn, $allowance_sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "is", $param_employeeID, $param_managerID);
    // Set parameters
    $param_employeeID = $search_employeeID;
    $param_managerID = $search_managerID;
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
      $allowance_result = mysqli_stmt_get_result($stmt);
    } else {
      echo "Error executing statement: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
  }

  // Process deduction form data
  if (isset($_POST["deduction_submit"])) {
    // Validate input
    $deduction_employeeID = validate_input($_POST["deduction_employeeID"]);
    $deduction_managerID = validate_input($_POST["deduction_managerID"]);
    $deduction_amount = validate_input($_POST["deduction_amount"]);
    if (!is_numeric($deduction_employeeID) || $deduction_employeeID <= 0) {
      $deduction_employeeID_err = "Please enter a valid employee ID.";
    }
    if (!is_numeric($deduction_managerID) || $deduction_managerID <= 0) {
      $deduction_managerID_err = "Please enter a valid manager ID.";
    }
    if (empty($deduction_amount)) {
      $deduction_amount_err = "Please enter an amount.";
    } elseif (!is_numeric($deduction_amount)) {
      $deduction_amount_err = "Please enter a valid amount.";
    }
    // Insert record into database if no errors
    if (empty($deduction_employeeID_err) && empty($deduction_managerID_err) && empty($deduction_amount_err)) {
      $deduction_sql = "INSERT INTO deduction (employeeID, managerID, amount) VALUES (?, ?, ?)";
      if ($stmt = mysqli_prepare($conn, $deduction_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "isi", $param_employeeID, $param_managerID, $param_amount);
        // Set parameters
        $param_employeeID = $deduction_employeeID;
        $param_managerID = $deduction_managerID;
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
    $allowance_employeeID = validate_input($_POST["allowance_employeeID"]);
    $allowance_managerID = validate_input($_POST["allowance_managerID"]);
    $allowance_amount = validate_input($_POST["allowance_amount"]);
    if (!is_numeric($allowance_employeeID) || $allowance_employeeID <= 0) {
      $allowance_employeeID_err = "Please enter a valid employee ID.";
    }
    if (!is_numeric($allowance_managerID) || $allowance_managerID <= 0) {
      $allowance_managerID_err = "Please enter a valid manager ID.";
    }
    if (empty($allowance_amount)) {
      $allowance_amount_err = "Please enter an amount.";
    } elseif (!is_numeric($allowance_amount)) {
      $allowance_amount_err = "Please enter a valid amount.";
    }
    // Insert record into database if no errors
    if (empty($allowance_employeeID_err) && empty($allowance_managerID_err) && empty($allowance_amount_err)) {
      $allowance_sql = "INSERT INTO allowance (employeeID, managerID, amount) VALUES (?, ?, ?)";
      if ($stmt = mysqli_prepare($conn, $allowance_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "isi", $param_employeeID, $param_managerID, $param_amount);
        // Set parameters
        $param_employeeID = $allowance_employeeID;
        $param_managerID = $allowance_managerID;
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

  // Process deduction delete
  if (isset($_POST["deduction_delete"])) {
    $id = $_POST["deduction_delete"];
    $delete_sql = "DELETE FROM deduction WHERE deductionID = ?";
    if ($stmt = mysqli_prepare($conn, $delete_sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "i", $param_id);
      // Set parameters
      $param_id = $id;
      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect to current page to update table
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
      } else {
        echo "Error executing statement: " . mysqli_error($conn);
      }
      mysqli_stmt_close($stmt);
    }
  }

  // Process allowance delete
  if (isset($_POST["allowance_delete"])) {
    $id = $_POST["allowance_delete"];
    $delete_sql = "DELETE FROM allowance WHERE allowanceID = ?";
    if ($stmt = mysqli_prepare($conn, $delete_sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "i", $param_id);
      // Set parameters
      $param_id = $id;
      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect to current page to update table
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
      } else {
        echo "Error executing statement: " . mysqli_error($conn);
      }
      mysqli_stmt_close($stmt);
    }
  }

  $conn->close();

}

// Function to validate input data
function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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
    <a class="active"href="deductionandallowance.php">deduction and allowance</a>
    <a href="adddeductionandallowance.php">add deduction and allowance</a>
    <a href="qrcode.php">qrcode</a>
    <a href="branchmanager.php">branch</a>
    <a href="everymonth.php">salary</a>
   
  </div>
  <div class="rightofsidebar">
<div class="container">
<!-- HTML form to search records -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Search Records</h2>
        <label for="searchType">Search Type:</label>
        <select name="searchType" id="searchType">
            <option value="employee">Employee</option>
            <option value="manager">Manager</option>
        </select><br><br>
        <label for="searchID">ID:</label>
        <input type="text" name="searchID" id="searchID"><br><br>
        <button type="submit">Search</button>
    </form>
</form>

<!-- Display existing records in deduction table -->
<h2>Deduction Table</h2>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Employee ID</th>
      <th>Manager ID</th>
      <th>Tax Rate</th>
      <th>Pension</th>
      <th>Deduction Type</th>
      <th>Deduction Amount</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($deduction_result)) {
      while ($row = mysqli_fetch_assoc($deduction_result)) {
        echo "<tr>";
        echo "<td>" . $row["deductionID"] . "</td>";
        echo "<td>" . $row["employeeID"] . "</td>";
        echo "<td>" . $row["managerID"] . "</td>";
        echo "<td>" . $row["taxrate"] . "</td>";
        echo "<td>" . $row["Pension"] . "</td>";
        echo "<td>" . $row["deductionType"] . "</td>";
        echo "<td>" . $row["deductionAmount"] . "</td>";
        echo "<td>";
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<button type='submit' name='deduction_delete' value='" . $row["deductionID"] . "'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
      }
    }
    ?>
  </tbody>
</table>
</div>

<div class="container">
<!-- Display existing records in allowance table -->
<h2>Allowance Table</h2>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Employee ID</th>
      <th>Manager ID</th>
      <th>Allowance Type</th>
      <th>Allowance Amount</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($allowance_result)) {
      while ($row = mysqli_fetch_assoc($allowance_result)) {
        echo "<tr>";
        echo "<td>" . $row["allowanceID"] . "</td>";
        echo "<td>" . $row["employeeID"] . "</td>";
        echo "<td>" . $row["managerID"] . "</td>";
        echo "<td>" . $row["allowanceType"] . "</td>";
        echo "<td>" . $row["allowanceAmount"] . "</td>";
        echo "<td>";
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<button type='submit' name='allowance_delete' value='" . $row["allowanceID"] . "'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
      }
    }
    ?>
  </tbody>
</table>
</div>
  </div>
  </div>

</body>
  </html>