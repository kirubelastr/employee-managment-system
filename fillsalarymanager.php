<?php
// Require the connection file to connect to the database
require_once "connection.php";

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $employeeID = $_POST['employeeID'];
    $managerID = $_POST['managerID'];
    $department = $_POST['department'];
    $branch = $_POST['branch'];
    $allowance = $_POST['allowance'];
    $deduction = $_POST['deduction'];

    // Initialize the SQL query
    $sql = "UPDATE salary SET allowance=?, deduction=? WHERE ";

    // Initialize the parameters array
    $params = array($allowance, $deduction);

    // Check if employeeID is set
    if (!empty($employeeID)) {
        // Add employeeID condition to the SQL query
        $sql .= "employeeID=?";
        $params[] = $employeeID;
    } elseif (!empty($managerID)) {
        // Add managerID condition to the SQL query
        $sql .= "managerID=?";
        $params[] = $managerID;
    } elseif (!empty($department)) {
        // Add department condition to the SQL query
        $sql .= "department=?";
        $params[] = $department;
    } elseif (!empty($branch)) {
        // Add branch condition to the SQL query
        $sql .= "branch=?";
        $params[] = $branch;
    }

    // Prepare and execute the SQL query
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // Display a success message
    echo "Allowance and deduction values updated successfully!";
}
?>

<!-- The HTML form -->
<form method="post">
    <label for="employeeID">Employee ID:</label>
    <input type="text" name="employeeID" id="employeeID"><br>

    <label for="managerID">Manager ID:</label>
    <input type="text" name="managerID" id="managerID"><br>

    <label for="department">Department:</label>
    <input type="text" name="department" id="department"><br>

    <label for="branch">Branch:</label>
    <input type="text" name="branch" id="branch"><br>

    <label for="allowance">Allowance:</label>
    <input type="number" name="allowance" id="allowance"><br>

    <label for="deduction">Deduction:</label>
    <input type="number" name="deduction" id="deduction"><br>

    <input type="submit" name="submit" value="Update">
</form>
