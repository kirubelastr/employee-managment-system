<?php
require_once "connection.php";

if (isset($_POST['approve'])) {
    // update status to approved
    $sql = "UPDATE employee_leave SET status = 'approved' WHERE leaveID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['leaveID']);
    $stmt->execute();

    // update vacation days
    $sql = "SELECT startdate, enddate, employeeID, managerID FROM employee_leave WHERE leaveID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['leaveID']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $startdate = new DateTime($row["startdate"]);
        $enddate = new DateTime($row["enddate"]);
        $interval = date_diff($startdate, $enddate);
        $days_taken = intval($interval->format('%a'));

        if (isset($row["employeeID"])) {
            $sql = "UPDATE employee SET yearlyvacationdays = yearlyvacationdays - ? WHERE employeeID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $days_taken, $row["employeeID"]);
            $stmt->execute();
        } elseif (isset($row["managerID"])) {
            $sql = "UPDATE manager SET yearlyvacationdays = yearlyvacationdays - ? WHERE managerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $days_taken, $row["managerID"]);
            $stmt->execute();
        }
    }
} elseif (isset($_POST['reject'])) {
    // update status to rejected
    $sql = "UPDATE employee_leave SET status = 'denied' WHERE leaveID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['leaveID']);
    $stmt->execute();
    $result = $stmt->get_result();
}

header("Location: aproveleave.php"); // redirect back to index page
?>