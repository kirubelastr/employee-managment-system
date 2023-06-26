
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
    <a href="department_and_position.php">department and position</a>
    <a href="aproveleave.php">aprove leave</a>
    <a href="createusers.php">createusers</a>
    <a href="employee.php">add employee</a>
    <a href="manager.php">add manage</a>
    <a href="deductionandallowance.php">deduction and allowance</a>
    <a href="adddeductionandallowance.php">add deduction and allowance</a>
    <a href="qrcode.php">qrcode</a>
    <a href="branchmanager.php">branch</a>
    <a class="active" href="everymonth.php">salary</a>
  </div>

  <div class="form-container">
<!-- Your HTML code here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="end_date">Enter the end date :</label>
    <input type="date" id="end_date" name="end_date">
    <input type="submit" value="Submit">
</form>
<?php
// Check if the form has been submitted
if (isset($_POST['end_date'])) {
    // Get the end date from the form
    $end_date = $_POST['end_date'];
    // Set the start date to be 30 days before the end date
    $start_date = new DateTime($end_date);
    $start_date->modify('-30 days');
    $start_date = $start_date->format('Y-m-d');

    // Require the connection file to connect to the database
    require_once "connection.php";
    // Set the default time zone to East Africa Time (EAT)
    date_default_timezone_set('Africa/Addis_Ababa');

    // Query to calculate the present days, absent days, and late days for each employee and manager within the date range
    $sql = "SELECT employee.employeeID, manager.managerID,
                   COUNT(*) as total_entries,
                   SUM(CASE WHEN attendance.timein <= '8:30:00' THEN 1 ELSE 0 END) as present_days,
                   SUM(CASE WHEN attendance.timein > '8:30:00' THEN 1 ELSE 0 END) as late_days,
                   SUM(CASE WHEN attendance.timeout is null THEN 1 ELSE 0 END) as absent_days,
                   SUM(CASE WHEN attendance.timeout > '18:00:00'is null THEN 1 ELSE 0 END) as overtime
            FROM attendance 
            LEFT JOIN employee ON attendance.employeeID = employee.employeeID
            LEFT JOIN manager ON attendance.managerID = manager.managerID
            WHERE attendance.logdate BETWEEN '$start_date' AND '$end_date'
            GROUP BY employee.employeeID, manager.managerID";

    // Execute the query and store the result in a variable
    $result = $conn->query($sql);
      // Check if there is any row in the result
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Get the employee ID, manager ID, total entries, present days, late days, and absent days from the row
            $employeeID = $row['employeeID'];
            $managerID = $row['managerID'];
            $total_entries = $row['total_entries'];
            $present_days = $row['present_days'];
            $late_days = $row['late_days'];
            $absent_days = $row['absent_days'];
            $overtime = $row['overtime'];

            // Get the base salary from the employee/manager table
            if ($employeeID) {
                // Employee
                $salary_query = "SELECT baseSalary FROM employee WHERE employeeID = '$employeeID'";
                $salary_result = $conn->query($salary_query);
                if ($salary_result->num_rows > 0) {
                    while($salary_row = $salary_result->fetch_assoc()) {
                        $baseSalary = $salary_row['baseSalary'];
                    }
                }
                
                // Employee
                $allowance_query = "SELECT SUM(allowanceAmount) as total_allowance FROM allowance WHERE employeeID = '$employeeID'";
                $allowance_result = $conn->query($allowance_query);
                if ($allowance_result->num_rows > 0) {
                    while($allowance_row = $allowance_result->fetch_assoc()) {
                        $total_allowance = $allowance_row['total_allowance'];
                    }
                }
                
                // Get the deduction amount from the deduction table
                // Employee
                $deduction_query = "SELECT SUM(deductionAmount) as total_deduction FROM deduction WHERE employeeID = '$employeeID'";
                $deduction_result = $conn->query($deduction_query);
                if ($deduction_result->num_rows > 0) {
                    while($deduction_row = $deduction_result->fetch_assoc()) {
                        $total_deduction = $deduction_row['total_deduction'];
                    }
                }

              // Calculate net salary
              if ($present_days == 30) {
                  // Full attendance
                  if ($overtime > 0) {
                      // Added overtime
                      // Calculate the value of one overtime day
                      // Overtime value is calculated based on base salary and number of workdays in a month (30)
                      // Overtime value is calculated as base salary divided by number of workdays in a month (30)
                      // Overtime value is then multiplied by number of overtime days worked by employee/manager
                      // Overtime value is then added to net salary of employee/manager
                      //
                      // Example:
                      //
                      // Base salary: 3000 birr/month
                      // Number of workdays in a month: 30 days/month
                      //
                // Overtime value: (3000 birr/month) / (30 days/month) * (number of overtime days worked by employee/manager)
$overtime_value = ($baseSalary / 30) * $overtime;
$netSalary = $baseSalary + $total_allowance + $overtime_value - $total_deduction;
} else {
    // No overtime
    $netSalary = $baseSalary + $total_allowance - $total_deduction;
}
} else {
    // Not full attendance
    $netSalary = $baseSalary + $total_allowance - $total_deduction;
}

// Insert the net salary into the salary table
$insert_query = "INSERT INTO salary (employeeID, datefrom, dateto, workdays, present_days, absent_days, late_days, overtimedworkeddays, salary, allowance, deduction, net, date) VALUES ('$employeeID', '$start_date', '$end_date', 30, '$present_days', '$absent_days', '$late_days', '$overtime', '$baseSalary', '$total_allowance', '$total_deduction', '$netSalary', NOW())";
$conn->query($insert_query);
} else if ($managerID) {
    // Manager
    $salary_query = "SELECT baseSalary FROM manager WHERE managerID = '$managerID'";
    $salary_result = $conn->query($salary_query);
    if ($salary_result->num_rows > 0) {
        while($salary_row = $salary_result->fetch_assoc()) {
            $baseSalary = $salary_row['baseSalary'];
        }
    }
    
    // Manager
    $allowance_query = "SELECT SUM(allowanceAmount) as total_allowance FROM allowance WHERE managerID = '$managerID'";
    $allowance_result = $conn->query($allowance_query);
    if ($allowance_result->num_rows > 0) {
        while($allowance_row = $allowance_result->fetch_assoc()) {
            $total_allowance = $allowance_row['total_allowance'];
        }
    }

    // Get the deduction amount from the deduction table
    // Manager
    $deduction_query = "SELECT SUM(deductionAmount) as total_deduction FROM deduction WHERE managerID = '$managerID'";
    $deduction_result = $conn->query($deduction_query);
    if ($deduction_result->num_rows > 0) {
        while($deduction_row = $deduction_result->fetch_assoc()) {
            $total_deduction = $deduction_row['total_deduction'];
        }
    }

  // Calculate net salary
  if ($present_days == 30) {
      // Full attendance
      if ($overtime > 0) { $overtime_value = ($baseSalary / 30) *$overtime;
          $netSalary =$baseSalary +$total_allowance +$overtime_value -$total_deduction;
      } else {
          // No overtime
          $netSalary =$baseSalary +$total_allowance -$total_deduction;
      }
  } else {
      // Not full attendance
      $netSalary =$baseSalary +$total_allowance -$total_deduction;
  }

// Insert the net salary into the salary table
$insert_query ="INSERT INTO salary (managerID, datefrom, dateto, workdays, present_days, absent_days, late_days, overtimedworkeddays, salary, allowance, deduction, net, date) VALUES ('$managerID', '$start_date', '$end_date', 30, '$present_days', '$absent_days', '$late_days', '$overtime', '$baseSalary', '$total_allowance', '$total_deduction', '$netSalary', NOW())";
$conn->query($insert_query);
}
}
}

// Get all employees who do not have attendance records within the date range
$employee_sql = "SELECT employee.employeeID FROM employee WHERE employee.employeeID NOT IN (SELECT DISTINCT employee.employeeID FROM attendance LEFT JOIN employee ON attendance.employeeID = employee.employeeID WHERE attendance.logdate BETWEEN '$start_date' AND '$end_date')";
$employee_result = $conn->query($employee_sql);
if ($employee_result->num_rows > 0) {
    while($employee_row = $employee_result->fetch_assoc()) {
        $employeeID = $employee_row['employeeID'];
        
        // Get the base salary, allowance, and deduction for the employee
        $salary_query = "SELECT baseSalary FROM employee WHERE employeeID = '$employeeID'";
        $salary_result = $conn->query($salary_query);
        if ($salary_result->num_rows > 0) {
            while($salary_row = $salary_result->fetch_assoc()) {
                $baseSalary = $salary_row['baseSalary'];
            }
        }
        
        $allowance_query = "SELECT SUM(allowanceAmount) as total_allowance FROM allowance WHERE employeeID = '$employeeID'";
        $allowance_result = $conn->query($allowance_query);
        if ($allowance_result->num_rows > 0) {
            while($allowance_row = $allowance_result->fetch_assoc()) {
                $total_allowance = $allowance_row['total_allowance'];
            }
        }
        
        $deduction_query = "SELECT SUM(deductionAmount) as total_deduction FROM deduction WHERE employeeID = '$employeeID'";
        $deduction_result = $conn->query($deduction_query);
        if ($deduction_result->num_rows > 0) {
            while($deduction_row = $deduction_result->fetch_assoc()) {
                $total_deduction = $deduction_row['total_deduction'];
            }
        } $netSalary = $baseSalary +$total_allowance -$total_deduction;
        
        // Insert the net salary into the salary table
        $insert_query ="INSERT INTO salary (employeeID, datefrom, dateto, workdays, present_days, absent_days, late_days, overtimedworkeddays, salary, allowance, deduction, net, date) VALUES ($employeeID, '$start_date', '$end_date', 30, 0, 0, 0, 0,'$baseSalary', '$total_allowance', '$total_deduction', '$netSalary', NOW())";
        $conn->query($insert_query);
    }
}

// Get all employees who do not have attendance records within the date range
$manager_sql = "SELECT manager.managerID FROM manager WHERE manager.managerID NOT IN (SELECT DISTINCT manager.managerID FROM attendance LEFT JOIN manager ON attendance.managerID = manager.managerID WHERE attendance.logdate BETWEEN '$start_date' AND '$end_date')";
$manager_result = $conn->query($manager_sql);
if ($manager_result->num_rows > 0) {
    while($manager_row = $manager_result->fetch_assoc()) {
        $managerID = $manager_row['managerID'];
        
        // Get the base salary, allowance, and deduction for the employee
        $salary_query = "SELECT baseSalary FROM manager WHERE managerID = '$managerID'";
        $salary_result = $conn->query($salary_query);
        if ($salary_result->num_rows > 0) {
            while($salary_row = $salary_result->fetch_assoc()) {
                $baseSalary = $salary_row['baseSalary'];
            }
        }
        
        $allowance_query = "SELECT SUM(allowanceAmount) as total_allowance FROM allowance WHERE managerID = '$managerID'";
        $allowance_result = $conn->query($allowance_query);
        if ($allowance_result->num_rows > 0) {
            while($allowance_row = $allowance_result->fetch_assoc()) {
                $total_allowance = $allowance_row['total_allowance'];
            }
        }
        
        $deduction_query = "SELECT SUM(deductionAmount) as total_deduction FROM deduction WHERE managerID = '$managerID'";
        $deduction_result = $conn->query($deduction_query);
        if ($deduction_result->num_rows > 0) {
            while($deduction_row = $deduction_result->fetch_assoc()) {
                $total_deduction = $deduction_row['total_deduction'];
            }
        } $netSalary = $baseSalary +$total_allowance -$total_deduction;
        
        // Insert the net salary into the salary table
        $insert_query ="INSERT INTO salary (managerID, datefrom, dateto, workdays, present_days, absent_days, late_days, overtimedworkeddays, salary, allowance, deduction, net, date) VALUES ('$managerID', '$start_date', '$end_date', 30, 0, 0, 0, 0,'$baseSalary', '$total_allowance', '$total_deduction', '$netSalary', NOW())";
        $conn->query($insert_query);
    }
}

    echo "<h2>Employee Salaries</h2>";
    echo "<table>";
    echo "<tr><th>Employee ID</th><th>Date From</th><th>Date To</th><th>Work Days</th><th>Salary</th><th>Allowance</th><th>Deduction</th><th>Net Salary</th></tr>";
    $employee_query = "SELECT * FROM salary WHERE employeeID IS NOT NULL AND datefrom = '$start_date' AND dateto = '$end_date'";
    $employee_result = $conn->query($employee_query);
    if ($employee_result->num_rows > 0) {
        while($row = $employee_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['employeeID']) . "</td>";
            echo "<td>" . htmlspecialchars($row['datefrom']) . "</td>";
            echo "<td>" . htmlspecialchars($row['dateto']) . "</td>";
            echo "<td>" . htmlspecialchars($row['workdays']) . "</td>";
            echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
            echo "<td>" . htmlspecialchars($row['allowance']) . "</td>";
            echo "<td>" . htmlspecialchars($row['deduction']) . "</td>";
            echo "<td>" . htmlspecialchars($row['net']) . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    
// Calculate the sum of the net salaries for both employees and managers
// Added code to calculate and display the sum of net salaries
$sum_query = "SELECT SUM(net) as total_net FROM salary WHERE employeeID IS NOT NULL AND datefrom = '$start_date' AND dateto = '$end_date'";
$sum_result = $conn->query($sum_query);
if ($sum_result->num_rows > 0) {
    while($row = $sum_result->fetch_assoc()) {
        $total_net1 = $row['total_net'];
    }
}
echo "<h2>Total Net Salaries for employees: " .$total_net1. "</h2>";


    // Display the values stored in the table for a set of managers
    // Added code to display manager salaries
    echo "<h2>Manager Salaries</h2>";
echo "<table>";
echo "<tr><th>Manager ID</th><th>Date From</th><th>Date To</th><th>Work Days</th><th>Salary</th><th>Allowance</th><th>Deduction</th><th>Net Salary</th></tr>";
$manager_query = "SELECT * FROM salary WHERE managerID IS NOT NULL AND datefrom = '$start_date' AND dateto = '$end_date'";
$manager_result = $conn->query($manager_query);
if ($manager_result->num_rows > 0) {
    while($row = $manager_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['managerID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['datefrom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['dateto']) . "</td>";
        echo "<td>" . htmlspecialchars($row['workdays']) . "</td>";
        echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
        echo "<td>" . htmlspecialchars($row['allowance']) . "</td>";
        echo "<td>" . htmlspecialchars($row['deduction']) . "</td>";
        echo "<td>" . htmlspecialchars($row['net']) . "</td>";
        echo "</tr>";
    }
}
echo "</table>";

// Calculate the sum of the net salaries for both employees and managers
// Added code to calculate and display the sum of net salaries
$sum_query = "SELECT SUM(net) as total_net FROM salary WHERE managerID IS NOT NULL AND datefrom = '$start_date' AND dateto = '$end_date'";
$sum_result = $conn->query($sum_query);
if ($sum_result->num_rows > 0) {
    while($row = $sum_result->fetch_assoc()) {
        $total_net2 = $row['total_net'];
    }
}
echo "<h2>Total Net Salaries for managers: " .$total_net2. "</h2>";
echo "<h1>Total Net Salaries payed: " .$total_net2 +$total_net1 . "</h1>";
// Add style for latest month
echo '<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
table tr:last-child td {
  font-weight: bold;
}
table tr:last-child td:first-child {
  text-align: left;
}
</style>';
}
?>

  </div>
</div>
</div>
</body>
</html>
