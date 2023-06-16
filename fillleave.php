<?php
session_start();
require_once "connection.php";
// Get form data
$userID = $_POST["userID"];
$leavetype = $_POST["leavetype"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];

// Get current date
$date = date("Y-m-d");
// Determine whether to insert data into employeeID or managerID column
if ($_SESSION["role"] === "manger(branch manager)" || $_SESSION["role"] === "general manager(admin)") {
    $statmentsql = "INSERT INTO employee_leave (managerID, date, leavetype, startdate, enddate, status) VALUES ('$userID', '$date', '$leavetype', '$startdate', '$enddate', 'pending')";
} else {
    $statmentsql = "INSERT INTO employee_leave (employeeID, date, leavetype, startdate, enddate, status) VALUES ('$userID', '$date', '$leavetype', '$startdate', '$enddate', 'pending')";
}

// Insert data into database
if ($conn->query($statmentsql) === TRUE ) {
    if ($_SESSION["role"] === "manger(branch manager)" || $_SESSION["role"] === "general manager(admin)") {
        echo '<script>
        alert("Leave request submitted successfully.");
        </script>';
        $conn->close();
        echo '<script>
        window.location.href = "managerleave.php";
        </script>';
    } else {
        echo '<script>
        alert("Leave request submitted successfully.");
        </script>';
        $conn->close();
        echo '<script>
        window.location.href = "employeeleave.php";
        </script>';
    }
    
} else {
   
    echo ' echo "Error: " . $sql . "<br>" . $conn->error;<script>
    alert("error while inserting the data.");
    </script>';
    $conn->close();
    echo '<script>
    window.location.href = "manager.php";
    </script>';
}

$conn->close();
?>
