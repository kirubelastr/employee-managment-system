<?php
session_start();
require_once "connection.php";

// Set the default time zone to East Africa Time (EAT)
date_default_timezone_set('Africa/Addis_Ababa');

if (isset($_POST['text'])) {
    $text = $_POST['text'];
    $date = date('y-m-d');
    $time = date('m:i:s');

    // Check if employee exists in employee table
    $sql = "SELECT * FROM employee WHERE employeeID='$text'";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        // Employee exists, proceed with attendance
        $sql = "SELECT * FROM attendance WHERE employeeID='$text' AND logdate='$date' AND shifttype='1'";
        $query = $conn->query($sql);
        if ($query->num_rows > 0) {
            $_SESSION['exceptionexists'] = "Attendance already set";
        } else {
            $sql = "SELECT * FROM attendance WHERE employeeID='$text' AND logdate='$date' AND shifttype='0'";
            $query = $conn->query($sql);
            if ($query->num_rows > 0) {
                $sql = "UPDATE ATTENDANCE SET timeout=now(),shifttype='1' WHERE employeeID='$text' AND logdate='$date'";
                $query = $conn->query($sql);
                $_SESSION['success'] = 'successfully timed out';
            } else {
                $sql = "INSERT INTO attendance(employeeID,logdate,timein,shifttype) values('$text', '$date','$time', '0')";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['success'] = "successfully timed in";
                } else {
                    $_SESSION['error'] = $conn->error;
                }
            }
        }
    } else {
        $sql = "SELECT * FROM manager WHERE managerID='$text'";
        $query = $conn->query($sql);
        if ($query->num_rows > 0) {
            // Employee exists, proceed with attendance
            $sql = "SELECT * FROM attendance WHERE managerID='$text' AND logdate='$date' AND shifttype='1'";
            $query = $conn->query($sql);
            if ($query->num_rows > 0) {
                $_SESSION['exceptionexists'] = "Attendance already set";
            } else {
                $sql = "SELECT * FROM attendance WHERE managerID='$text' AND logdate='$date' AND shifttype='0'";
                $query = $conn->query($sql);
                if ($query->num_rows > 0) {
                    $sql = "UPDATE ATTENDANCE SET timeout=now(),shifttype='1' WHERE managerID='$text' AND logdate='$date'";
                    $query = $conn->query($sql);
                    $_SESSION['success'] = 'successfully timed out';
                } else {
                    $sql = "INSERT INTO attendance(managerID,logdate,timein,shifttype) values('$text', '$date','$time', '0')";
                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['success'] = "successfully timed in";
                    } else {
                        $_SESSION['error'] = $conn->error;
                    }
                }
            }
        } else {
            
            $_SESSION['error'] = 'this is not a valid identification does not exist';
        }
    }
} else {
    $_SESSION['initialization'] = 'please scan your qr code';
}
header("location: index.php");
$conn->close();
?>
