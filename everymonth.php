<?php
require_once "connection.php";

// Set the default time zone to East Africa Time (EAT)
date_default_timezone_set('Africa/Addis_Ababa');

// Get the current date and the start date of the previous month
$present_date = new DateTime();
$present_date = $present_date->format('Y-m-d');
$start_date = new DateTime('first day of last month');
$start_date = $start_date->format('Y-m-d');

// Query to calculate the present days, absent days, and late days for each employee within the date range
$sql = "SELECT employee.employeeID, 
               COUNT(*) as total_entries,
               SUM(CASE WHEN attendance.timein <= '8:30:00' THEN 1 ELSE 0 END) as present_days,
               SUM(CASE WHEN attendance.timein > '8:30:00' THEN 1 ELSE 0 END) as late_days,
               SUM(CASE WHEN attendance.timeout is null THEN 1 ELSE 0 END) as absent_days
        FROM attendance 
        INNER JOIN employee ON attendance.employeeID = employee.employeeID
        WHERE attendance.logdate BETWEEN '$start_date' AND '$present_date'
        GROUP BY employee.employeeID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
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
            $salary = $employee_type_row['salary'];
            $allowance = $employee_type_row['allowance'];
            $late_deduction_percentage = 2;
        } else {
            $salary = $employee_type_row['salary'] * 2;
            $allowance = $employee_type_row['allowance'] * 2;
            $late_deduction_percentage = 1;
        }

        $late_deduction = round(($salary / 30) * $late_days * ($late_deduction_percentage / 100), 2);
        $net_salary = $salary + $allowance - $late_deduction;

        // Check if the salary data already exists for the employee and month
        $check_sql = "SELECT * FROM salary WHERE employeeID='$employeeID' AND datefrom='$start_date' AND dateto='$present_date'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows == 0) {
            // Data does not exist, insert it
            $insert_sql = "INSERT INTO salary (employeeID, datefrom, dateto, present_days, absent_days, late_days, salary, allowance, late_deduction, net_salary)
                           VALUES ('$employeeID', '$start_date', '$present_date', '$present_days', '$absent_days', '$late_days', '$salary', '$allowance', '$late_deduction', '$net_salary')";
            $conn->query($insert_sql);
        } else {
            // Data exists, update it
            $update_sql = "UPDATE salary SET present_days='$present_days', absent_days='$absent_days', late_days='$late_days', salary='$salary', allowance='$allowance', late_deduction='$late_deduction', net_salary='$net_salary'
                           WHERE employeeID='$employeeID' AND datefrom='$start_date' AND dateto='$present_date'";
            $conn->query($update_sql);
        }
    }
}

$conn->close();
?>