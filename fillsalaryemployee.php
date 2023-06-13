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
