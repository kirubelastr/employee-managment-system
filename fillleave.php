<?php
require_once "connection.php";
// Get form data
$employeeID = $_POST["employeeID"];
$managerID = $_POST["managerID"];
$leavetype = $_POST["leavetype"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];

// Determine whether to insert data into employeeID or managerID column
if ($userType === "manager") {
    $sql = "INSERT INTO employee_leave (managerID, leavetype, startdate, enddate, status) VALUES ('$userID', '$leavetype', '$startdate', '$enddate', 'pending')";
} else {
    $sql = "INSERT INTO employee_leave (employeeID, leavetype, startdate, enddate, status) VALUES ('$userID', '$leavetype', '$startdate', '$enddate', 'pending')";
}

// Insert data into database
if ($conn->query($sql) === TRUE) {
    echo "Leave request submitted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
