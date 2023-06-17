<?php
// Require the connection file to connect to the database
require_once "connection.php";

// Set the default time zone to East Africa Time (EAT)
date_default_timezone_set('Africa/Addis_Ababa');

// Prompt the user to input the start and end date of the salary calculation
$start_date = readline("Enter the start date (YYYY-MM-DD): ");
$end_date = readline("Enter the end date (YYYY-MM-DD): ");

// Query to calculate the present days, absent days, and late days for each employee within the date range
$sql = "SELECT employee.employeeID, 
               COUNT(*) as total_entries,
               SUM(CASE WHEN attendance.timein <= '8:30:00' THEN 1 ELSE 0 END) as present_days,
               SUM(CASE WHEN attendance.timein > '8:30:00' THEN 1 ELSE 0 END) as late_days,
               SUM(CASE WHEN attendance.timeout is null THEN 1 ELSE 0 END) as absent_days
        FROM attendance 
        INNER JOIN employee ON attendance.employeeID = employee.employeeID
        WHERE attendance.logdate BETWEEN '$start_date' AND '$end_date'
        GROUP BY employee.employeeID";

// Execute the query and store the result in a variable
$result = $conn->query($sql);

// Check if there is any row in the result
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Get the employee ID, total entries, present days, late days, and absent days from the row
        $employeeID = $row['employeeID'];
        $total_entries = $row['total_entries'];
        $present_days = $row['present_days'];
        $late_days = $row['late_days'];
        $absent_days = $row['absent_days'];

        // Calculate the salary, allowance, and deduction based on employee type (employee or manager)
        $employee_type_sql = "SELECT * FROM employee WHERE employeeID='$employeeID'";
        $employee_type_result = $conn->query($employee_type_sql);
        $employee_type_row = $employee_type_result->fetch_assoc();
        $employee_type = $employee_type_row['employee_type'];
        
        if ($employee_type == 'employee') {
            $salary = $employee_type_row['basesalary'];
            $allowance = $employee_type_row['allowance'];
            $late_deduction_percentage = 2;
        } else {
            $salary = $employee_type_row['basesalary'] * 2;
            $allowance = $employee_type_row['allowance'] * 2;
            $late_deduction_percentage = 1;
        }

        // Calculate the late deduction based on the salary and the number of late days
        $late_deduction = round(($salary / 30) * $late_days * ($late_deduction_percentage / 100), 2);

        // Calculate the net salary by subtracting the late deduction and adding the allowance
        $net_salary = $salary + $allowance - $late_deduction;

        // Check if the salary data already exists for the employee and month
        $check_sql = "SELECT * FROM salary WHERE employeeID='$employeeID' AND datefrom='$start_date' AND dateto='$end_date'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows == 0) {
            // Data does not exist, insert it
            $insert_sql = "INSERT INTO salary (employeeID, datefrom, dateto, present_days, absent_days, late_days, salary, allowance, late_deduction, net_salary)
                           VALUES ('$employeeID', '$start_date', '$end_date', '$present_days', '$absent_days', '$late_days', '$salary', '$allowance', '$late_deduction', '$net_salary')";
            $conn->query($insert_sql);
        } else {
            // Data exists, update it
            $update_sql = "UPDATE salary SET present_days='$present_days', absent_days='$absent_days', late_days='$late_days', salary='$salary', allowance='$allowance', late_deduction='$late_deduction', net_salary='$net_salary'
                           WHERE employeeID='$employeeID' AND datefrom='$start_date' AND dateto='$end_date'";
            $conn->query($update_sql);
        }
    }
}

// Close the database connection
$conn->close();
?>