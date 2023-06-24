<?php
require_once "../connection.php";
// check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get leaveID from form data
    $leaveID = $_POST['leaveID'];

    // check if approve button was clicked
    if (isset($_POST['approve'])) {
        // update leave status to approved in database
        $sql = "UPDATE employee_leave SET status = 'approved' WHERE leaveID = " . $leaveID;
        $result = $conn->query($sql);
        // display success message
        echo '<script>
        window.location.href = "aprovebranchleave.php";
        </script>';
    } elseif (isset($_POST['reject'])) {
        // update leave status to rejected in database
        $sql = "UPDATE employee_leave SET status = 'rejected' WHERE leaveID = " . $leaveID;
        $result = $conn->query($sql);
        // display success message
        echo '<script>
        window.location.href = "aprovebranchleave.php";
        </script>';
    }
}
?>
