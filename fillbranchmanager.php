<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branchID = $_POST['branchID'];
    $managerID = $_POST['managerID'];
    $managertype = $_POST['managertype'];

    $sql = "SELECT 1 FROM branch WHERE branchID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $branchID);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        echo "<script>alert('Error: branchID does not exist in branch table');</script>";
        echo "<script>window.location.href='branchmanager.php';</script>";
        exit;
    }

    $sql = "SELECT 1 FROM manager WHERE managerID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $managerID);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        echo "<script>alert('Error: managerID does not exist in manager table');</script>";
        echo "<script>window.location.href='branchmanager.php';</script>";
        exit;
    }

    if (isset($_POST['insert'])) {
        try {
            $sql = "INSERT INTO branchmanager (branchID, managerID, managertype) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $branchID, $managerID, $managertype);
            $stmt->execute();
            echo "<script>alert('Record inserted successfully');</script>";
            echo "<script>window.location.href='branchmanager.php';</script>";
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                echo "<script>alert('Error: Duplicate entry');</script>";
                echo "<script>window.location.href='branchmanager.php';</script>";
            } else {
                throw $e;
            }
        }
    } else if (isset($_POST['delete'])) {
        $sql = "DELETE FROM branchmanager WHERE branchID=? AND managerID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $branchID, $managerID);
        $stmt->execute();
        if ($stmt->affected_rows == 0) {
            echo "<script>alert('Error: No rows were deleted');</script>";
            echo "<script>window.location.href='branchmanager.php';</script>";
        } else {
            echo "<script>alert('Record deleted successfully');</script>";
            echo "<script>window.location.href='branchmanager.php';</script>";
        }
    }
    
}

$conn->close();
?>
