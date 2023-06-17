<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the employee or manager name from the form
  
  // Connect to the database
  require_once "connection.php";

  // Search for the employee or manager data in the database
  if (!empty($employee_name)) {
    $employeeID = $_POST["employee"];
    $sql = "SELECT * FROM employee WHERE employeeID='$employeeID'";
    echo "<script>alert('Emplasfasfasfasfasf ID: ');</script>";
    echo "<script>window.location.href='manager.php';</script>";
header("Location: edit.php");
  } else {
    $managerID = $_POST["manager"];
    $sql = "SELECT * FROM manager WHERE managerID='$managerID'";
    echo "<script>alert('lasmfm;lasmfmas;mf;l ID: ');</script>";
    echo "<script>window.location.href='manager.php';</script>";
header("Location: edit.php");
  }
  $result = $conn->query($sql);

  // If the data is found, fill the form fields with the fetched values
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<script>";
    echo "document.getElementById('firstname').value = '". $row["firstname"] ."';";
    echo "document.getElementById('middlename').value = '". $row["middlename"] ."';";
    echo "document.getElementById('lastname').value = '". $row["lastname"] ."';";
    echo "document.getElementById('gender').value = '". $row["gender"] ."';";
    echo "document.getElementById('email').value = '". $row["email"] ."';";
    echo "document.getElementById('dateofbirth').value = '". $row["dateofbirth"] ."';";
    echo "document.getElementById('phone').value = '". $row["phone"] ."';";
    echo "document.getElementById('address').value = '". $row["address"] ."';";
    echo "document.getElementById('department').value = '". $row["department"] ."';";
    echo "document.getElementById('hiredate').value = '". $row["hiredate"] ."';";
    echo "document.getElementById('educationstatus').value = '". $row["educationstatus"] ."';";
    echo "window.location.href = 'editemployeeandmanager.php';";
    echo "</script>";
    echo "<script>alert('asfas ID: ');</script>";
    echo "<script>window.location.href='manager.php';</script>";
header("Location: edit.php");
  } else {
    echo "No results found.";
  }

  // Close the database connection
  $conn->close();
} else {
        echo "<script>alert('Employee ID: ');</script>";
        echo "<script>window.location.href='manager.php';</script>";
  header("Location: edit.php");
}
?>