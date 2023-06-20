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
  $search_employeeID = validate_input($_POST["search_employeeID"]);
  $search_managerID = validate_input($_POST["search_managerID"]);

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

  // Close database connection
  mysqli_close($conn);

}

// Function to validate input data
function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<!-- HTML form to search records -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <h2>Search Records</h2>
  <label for="search_employeeID">Employee ID:</label>
  <input type="text" name="search_employeeID" id="search_employeeID">
  <label for="search_managerID">Manager ID:</label>
  <input type="text" name="search_managerID" id="search_managerID">
  <button type="submit">Search</button>
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

<!-- HTML form to add record to deduction table -->
<h2>Add Record to Deduction Table</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="deduction_employeeID">Employee ID:</label>
  <input type="text" name="deduction_employeeID" id="deduction_employeeID" value="<?php echo $deduction_employeeID; ?>">
  <span class="error"><?php echo $deduction_employeeID_err; ?></span>
  <label for="deduction_managerID">Manager ID:</label>
  <input type="text" name="deduction_managerID" id="deduction_managerID" value="<?php echo $deduction_managerID; ?>">
  <span class="error"><?php echo $deduction_managerID_err; ?></span>
  <label for="deduction_taxrate">Tax Rate:</label>
  <input type="text" name="deduction_taxrate" id="deduction_taxrate" value="<?php echo $deduction_taxrate; ?>">
  <span class="error"><?php echo $deduction_taxrate_err; ?></span>
  <label for="deduction_pension">Pension:</label>
  <input type="text" name="deduction_pension" id="deduction_pension" value="<?php echo $deduction_pension; ?>">
  <span class="error"><?php echo $deduction_pension_err; ?></span>
  <label for="deduction_type">Deduction Type:</label>
  <input type="text" name="deduction_type" id="deduction_type" value="<?php echo $deduction_type; ?>">
  <span class="error"><?php echo $deduction_type_err; ?></span>
  <label for="deduction_amount">Deduction Amount:</label>
  <input type="text" name="deduction_amount" id="deduction_amount" value="<?php echo $deduction_amount; ?>">
  <span class="error"><?php echo $deduction_amount_err; ?></span>
  <button type="submit" name="deduction_submit">Add Record</button>
</form>

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

<!-- HTML form to add record to allowance table -->
<h2>Add Record to Allowance Table</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="allowance_employeeID">Employee ID:</label>
  <input type="text" name="allowance_employeeID" id="allowance_employeeID" value="<?php echo $allowance_employeeID; ?>">
  <span class="error"><?php echo $allowance_employeeID_err; ?></span>
  <label for="allowance_managerID">Manager ID:</label>
  <input type="text" name="allowance_managerID" id="allowance_managerID" value="<?php echo $allowance_managerID; ?>">
  <span class="error"><?php echo $allowance_managerID_err; ?></span>
  <label for="allowance_type">Allowance Type:</label>
  <input type="text" name="allowance_type" id="allowance_type" value="<?php echo $allowance_type; ?>">
  <span class="error"><?php echo $allowance_type_err; ?></span>
  <label for="allowance_amount">Allowance Amount:</label>
  <input type="text" name="allowance_amount" id="allowance_amount" value="<?php echo $allowance_amount; ?>">
  <span class="error"><?php echo $allowance_amount_err; ?></span>
  <button type="submit" name="allowance_submit">Add Record</button>
</form>

<!-- Display existing records in promotion table -->
<h2>Promotion Table</h2>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Employee ID</th>
      <th>Manager ID</th>
      <th>New Designation</th>
      <th>Date</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($promotion_result)) {
      while ($row = mysqli_fetch_assoc($promotion_result)) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["employeeID"] . "</td>";
        echo "<td>" . $row["managerID"] . "</td>";
        echo "<td>" . $row["newDesignation"] . "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "<td>";
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<button type='submit' name='promotion_delete' value='" . $row["id"] . "'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
      }
    }
    ?>
  </tbody>
</table>

<!-- HTML form to add record to promotion table -->
<h2>Add Record to Promotion Table</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="promotion_employeeID">Employee ID:</label>
  <input type="text" name="promotion_employeeID" id="promotion_employeeID" value="<?php echo $promotion_employeeID; ?>">
  <span class="error"><?php echo $promotion_employeeID_err; ?></span>
  <label for="promotion_managerID">Manager ID:</label>
  <input type="text" name="promotion_managerID" id="promotion_managerID" value="<?php echo $promotion_managerID; ?>">
  <span class="error"><?php echo $promotion_managerID_err; ?></span>
  <label for="promotion_newDesignation">New Designation:</label>
  <input type="text" name="promotion_newDesignation" id="promotion_newDesignation" value="<?php echo $promotion_newDesignation; ?>">
  <span class="error"><?php echo $promotion_newDesignation_err; ?></span>
  <label for="promotion_date">Date:</label>
  <input type="date" name="promotion_date" id="promotion_date" value="<?php echo $promotion_date; ?>">
  <span class="error"><?php echo $promotion_date_err; ?></span>
  <button type="submit" name="promotion_submit">Add Record</button>
</form>

