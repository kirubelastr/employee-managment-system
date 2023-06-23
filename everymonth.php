<?php
// Require the connection file to connect to the database
require_once "connection.php";

// Set the default time zone to East Africa Time (EAT)
date_default_timezone_set('Africa/Addis_Ababa');

// Get the current date and the start date of the previous month
$present_date = new DateTime();
$present_date = $present_date->format('Y-m-d');
$start_date = new DateTime('first day of last month');
$start_date = $start_date->format('Y-m-d');

// Added user prompt to take the end date and set it
$end_date = readline("Enter the end date (YYYY-MM-DD): ");

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
        $overtimes = $row['overtimes'];
         $absent_days = $workDays - $present_days;

        // Get the base salary from the employee/manager table
        // Removed UNION operation and separated queries for employee and manager
        if ($employeeID) {
            // Employee
            $salary_query = "SELECT baseSalary FROM employee WHERE employeeID = ?";
            $salary_stmt = $conn->prepare($salary_query);
            // Changed second parameter from "ii" to "i" since only one parameter is used now
            $salary_stmt->bind_param("i", $employeeID);
            $salary_stmt->execute();
            $salary_stmt->bind_result($baseSalary);
            $salary_stmt->fetch();
            $salary_stmt->close();
        } else if ($managerID) {
            // Manager
            // Changed managerID to a string (varchar)
            $salary_query = "SELECT baseSalary FROM manager WHERE managerID = ?";
            $salary_stmt = $conn->prepare($salary_query);
           // Changed second parameter from "ii" to "s" since only one parameter is used now and managerID is a string (varchar)
$salary_stmt->bind_param("s", $managerID);
$salary_stmt->execute();
$salary_stmt->bind_result($baseSalary);
$salary_stmt->fetch();
$salary_stmt->close();
}

// Calculate deductions and net salary

// Insert the data into the salary table
if ($employeeID) {
    // Employee
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("issiiiiiiiiis", $employeeID, $start_date, $end_date, $workDays, $present_days, $absent_days, $late_days, $overtimes, $baseSalary, $allowance, $deduction, $netSalary,$present_date);
    $insert_stmt->execute();
    $insert_stmt->close();
} else if ($managerID) {
    // Manager
    // Changed managerID from int (i) to string (s) since managerID is now a string (varchar)
    $insert_query = "INSERT INTO salary (managerID,datefrom, dateto, workdays, present_days, absent_days, late_days,overtime_worked_days,salary ,allowance ,deduction ,net,date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
    $insert_stmt = $conn->prepare($insert_query);
    // Changed first parameter from "i" to "s" since managerID is now a string (varchar)
    $insert_stmt->bind_param("ssiiiiiiiiis", $managerID,$start_date,$end_date,$workDays,$present_days,$absent_days,$late_days,$overtimes,$baseSalary,$allowance,$deduction,$netSalary,$present_date);
    $insert_stmt->execute();
    $insert_stmt->close();
}
}
}

// Display the values stored in the table for a set of employees
// Added code to display employee salaries
echo "<h2>Employee Salaries</h2>";
echo "<table>";
echo "<tr><th>Employee ID</th><th>Date From</th><th>Date To</th><th>Work Days</th><th>Present Days</th><th>Absent Days</th><th>Late Days</th><th>Overtime Worked Days</th><th>Salary</th><th>Allowance</th><th>Deduction</th><th>Net Salary</th></tr>";
$employee_query = "SELECT * FROM salary WHERE employeeID IS NOT NULL";
$employee_result = $conn->query($employee_query);
if ($employee_result->num_rows > 0) {
while($row = $employee_result->fetch_assoc()) {
echo "<tr>";
echo "<td>" . htmlspecialchars($row['employeeID']) . "</td>";
echo "<td>" . htmlspecialchars($row['datefrom']) . "</td>";
echo "<td>" . htmlspecialchars($row['dateto']) . "</td>";
echo "<td>" . htmlspecialchars($row['workdays']) . "</td>";
echo "<td>" . htmlspecialchars($row['present_days']) . "</td>";
echo "<td>" . htmlspecialchars($row['absent_days']) . "</td>";
echo "<td>" . htmlspecialchars($row['late_days']) . "</td>";
echo "<td>" . htmlspecialchars($row['overtime_worked_days']) . "</td>";
echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
echo "<td>" . htmlspecialchars($row['allowance']) . "</td>";
echo "<td>" . htmlspecialchars($row['deduction']) . "</td>";
echo "<td>" . htmlspecialchars($row['net']) . "</td>";
echo "</tr>";
}
}
echo "</table>";

// Display the values stored in the table for a set of managers
// Added code to display manager salaries
echo "<h2>Manager Salaries</h2>";
echo "<table>";
echo "<tr><th>Manager ID</th><th>Date From</th><th>Date To</th><th>Work Days</th><th>Present Days</th><th>Absent Days</th><th>Late Days</th><th>Overtime Worked Days</th><th>Salary</th><th>Allowance</th><th>Deduction</th><th>Net Salary</th></tr>";
$manager_query = "SELECT * FROM salary WHERE managerID IS NOT NULL";
$manager_result = $conn->query($manager_query);
if ($manager_result->num_rows > 0) {
while($row = $manager_result->fetch_assoc()) {
echo "<tr>";
echo "<td>" . htmlspecialchars($row['managerID']) . "</td>";
echo "<td>" . htmlspecialchars($row['datefrom']) . "</td>";
echo "<td>" . htmlspecialchars($row['dateto']) . "</td>";
echo "<td>" . htmlspecialchars($row['workdays']) . "</td>";
echo "<td>" . htmlspecialchars($row['present_days']) . "</td>";
echo "<td>" . htmlspecialchars($row['absent_days']) . "</td>";
echo "<td>" . htmlspecialchars($row['late_days']) . "</td>";
echo "<td>" . htmlspecialchars($row['overtime_worked_days']) . "</td>";
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
$sum_query = "SELECT SUM(net) as total_net FROM salary";
$sum_result = $conn->query($sum_query);
if ($sum_result->num_rows > 0) {
while($row = $sum_result->fetch_assoc()) {
$total_net = $row['total_net'];
}
}
echo "<h2>Total Net Salaries: " . $total_net . "</h2>";

?>
