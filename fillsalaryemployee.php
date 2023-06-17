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
        WHERE attendance.logdate BETWEEN ? AND ?
        GROUP BY employee.employeeID";

// Prepare and execute the SQL query
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

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

        // Query to get the base salary, allowance, and deduction for the employee
        $employee_sql = "SELECT * FROM employee WHERE employeeID=?";
        $employee_stmt = $conn->prepare($employee_sql);
        $employee_stmt->bind_param("i", $employeeID);
        $employee_stmt->execute();
        $employee_result = $employee_stmt->get_result();
        $employee_row = $employee_result->fetch_assoc();

        // Get the base salary, allowance, and deduction from the row
        $base_salary = $employee_row['base_salary'];
        $allowance = $employee_row['allowance'];
        $deduction = $employee_row['deduction'];

        // Calculate the net salary by adding the base salary and allowance, and subtracting the deduction
        $net_salary = $base_salary + $allowance - $deduction;

        // Check if the salary data already exists for the employee and month
        $check_sql = "SELECT * FROM salary WHERE employeeID=? AND datefrom=? AND dateto=?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("iss", $employeeID, $start_date, $end_date);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            // Data does not exist, insert it
            $insert_sql = "INSERT INTO salary (employeeID, datefrom, dateto, present_days, absent_days, late_days, base_salary, allowance, deduction, net_salary)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("issiiiiddd", 
                $employeeID,
                $start_date,
                $end_date,
                $present_days,
                $absent_days,
                $late_days,
                $base_salary,
                $allowance,
                $deduction,
                $net_salary
            );
            $insert_stmt->execute();
        } else {
            // Data exists, update it
            $update_sql = "UPDATE salary SET present_days=?, absent_days=?, late_days=?, base_salary=?, allowance=?, deduction=?, net_salary=?
                           WHERE employeeID=? AND datefrom=? AND dateto=?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("iiiidddiss",
                $present_days,
                $absent_days,
                $late_days,
                $base_salary,
                $allowance,
                $deduction,
                $net_salary,
                $employeeID,
                $start_date,
                $end_date
            );
            $update_stmt->execute();
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Salary Rates Update</title>
</head>
<body>
    <h1>Salary Rates Update</h1>

    <!-- Form to update the salary rates -->
    <h2>Update Salary Rates</h2>
    <form method="post" action="update_rates.php">
        <p>
            <label for="allowance_rate">Allowance Rate:</label>
            <input type="text" id="allowance_rate" name="allowance_rate" required>
        </p>
        <p>
            <label for="deduction_rate">Deduction Rate:</label>
            <input type="text" id="deduction_rate" name="deduction_rate" required>
        </p>
        <p>
            <input type="submit" value="Update Rates">
        </p>
    </form>

    <!-- Table to display the salary data for employees -->
    <h2>Employee Salary Data</h2>
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Present Days</th>
                <th>Absent Days</th>
                <th>Late Days</th>
                <th>Salary</th>
                <th>Allowance</th>
                <th>Deduction</th>
                <th>Net Salary</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "connection.php";

            // Query to get the salary data for employees
            $sql = "SELECT * FROM salary WHERE managerID IS NULL";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["employeeID"] . "</td>";
                    echo "<td>" . $row["datefrom"] . "</td>";
                    echo "<td>" . $row["dateto"] . "</td>";
                    echo "<td>" . $row["present_days"] . "</td>";
                    echo "<td>" . $row["absent_days"] . "</td>";
                    echo "<td>" . $row["late_days"] . "</td>";
                    echo "<td>" . $row["salary"] . "</td>";
                    echo "<td>" . $row["allowance"] . "</td>";
                    echo "<td>" . $row["deduction"] . "</td>";
                    echo "<td>" . $row["net_salary"] . "</td>";
                    echo "<td>" . $row["date"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No results found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <!-- Table to display the salary data for managers -->
    <h2>Manager Salary Data</h2>
    <table>
        <thead>
            <tr>
                <th>Manager ID</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Present Days</th>
                <th>Absent Days</th>
                <th>Late Days</th>
                <th>Salary</th>
                <th>Allowance</th>
                <th>Deduction</th>
                <th>Net Salary</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "connection.php";

            // Query to get the salary data for managers
            $sql = "SELECT * FROM salary WHERE managerID IS NOT NULL";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["managerID"] . "</td>";
                    echo "<td>" . $row["datefrom"] . "</td>";
                    echo "<td>" . $row["dateto"] . "</td>";
                    echo "<td>" . $row["present_days"] . "</td>";
                    echo "<td>" . $row["absent_days"] . "</td>";
                    echo "<td>" . $row["late_days"] . "</td>";
                    echo "<td>" . $row["salary"] . "</td>";
                    echo "<td>" . $row["allowance"] . "</td>";
                    echo "<td>" . $row["deduction"] . "</td>";
                    echo "<td>" . $row["net_salary"] . "</td>";
                    echo "<td>" . $row["date"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No results found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
