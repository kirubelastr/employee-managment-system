<?php
require_once "connection.php";

// Set the default time zone to East Africa Time (EAT)
date_default_timezone_set('Africa/Addis_Ababa');

$date = new DateTime();
$present_date = new DateTime();
$present_date = $present_date->format('Y-m-d');
$past_date = $date->modify('-30 days')->format('Y-m-d');

// Query to count the number of timely and late attendances and total entries for each employee within the date range
$sql = "SELECT employeeID, 
               COUNT(*) as total_entries,
               SUM(CASE WHEN timein <= '8:30:00' THEN 1 ELSE 0 END) as timely_attendances,
               SUM(CASE WHEN timein > '8:30:00' THEN 1 ELSE 0 END) as late_attendances
        FROM attendance 
        WHERE logdate BETWEEN '$past_date' AND '$present_date'
        GROUP BY employeeID";
        $result = $conn->query($sql);
                // Check if employee exists in employee table
                $employee_check_sql = "SELECT * FROM employee WHERE employeeID='employeeID'";
                $employee_check_result = $conn->query($employee_check_sql);

                if ($employee_check_result->num_rows > 0) {
                // Employee exists, proceed with inserting into salary table
                $sql = "SELECT * FROM salary WHERE employeeID='employeeID' AND datefrom='$past_date' AND dateto='$present_date'";
                $check_result = $conn->query($sql);
                if ($check_result->num_rows == 0) {
                        // Data does not exist, insert it
                        $sql = "INSERT INTO salary (employeeID, datefrom, dateto, present_days, late_days)
                                VALUES (employeeID, '$past_date', '$present_date', 'timely_attendances', 'late_attendances')";
                        $conn->query($sql);
                }
                } else {
                // Employee does not exist in employee table
                // Handle this case as appropriate for your application
                echo "employee doesnt exist";
                }
        
?>

<!-- HTML table to display the results -->
<table style="border: 1px solid black;">
    <tr>
        <th>Employee ID</th>
        <th>Total Entries</th>
        <th>Timely Attendances</th>
        <th>Late Attendances</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["employeeID"] . "</td>";
            echo "<td>" . $row["total_entries"] . "</td>";
            echo "<td>" . $row["timely_attendances"] . "</td>";
            echo "<td>" . $row["late_attendances"] . "</td>";
            echo "</tr>";

        }
    } else {
        echo "<tr><td colspan='4'>No results found</td></tr>";
    }

    ?>
</table>

<?php
$conn->close();
?>
