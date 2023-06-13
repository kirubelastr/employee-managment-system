<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["userType"])) {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

require_once "connection.php";
// Get form data
$employeeID = $_POST["employeeID"];
$managerID = $_POST["managerID"];
$leavetype = $_POST["leavetype"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];

// Get current date
$date = date("Y-m-d");

// Determine whether to insert data into employeeID or managerID column
if ($_SESSION["userType"] === "manager") {
    $sql = "INSERT INTO employee_leave (managerID, date, leavetype, startdate, enddate, status) VALUES ('$userID', '$date', '$leavetype', '$startdate', '$enddate', 'pending')";
} else {
    $sql = "INSERT INTO employee_leave (employeeID, date, leavetype, startdate, enddate, status) VALUES ('$userID', '$date', '$leavetype', '$startdate', '$enddate', 'pending')";
}

// Insert data into database
if ($conn->query($sql) === TRUE) {
    echo "Leave request submitted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

