<?php
// Start a session
session_start();

// Connect to the database
require_once "connection.php";

// Check if the form has been submitted
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["role"])) {
  // Get the email, password, and role from the form
  $email = $_POST["email"];
  $password = $_POST["password"];
  $role = $_POST["role"];

  // Check if the email, password, and role exist in the login table
  $query = "SELECT * FROM login WHERE email='$email' AND password='$password' AND role='$role'";
  $result = mysqli_query($db, $query);

  if (mysqli_num_rows($result) == 1) {
    // Login successful
    $row = mysqli_fetch_assoc($result);
    $_SESSION["user_type"] = $row["user_type"];
    $_SESSION["user_id"] = $row["id"];
    $_SESSION["role"] = $role;

    // Check if the employee email exists in the employee table
    $query = "SELECT * FROM employee WHERE email='$email'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
      // Employee found in employee table
      $row = mysqli_fetch_assoc($result);
      $_SESSION["employee_id"] = $row["id"];
    } else {
      // Check if the user email exists in the manager table
      $query = "SELECT * FROM manager WHERE email='$email'";
      $result = mysqli_query($db, $query);

      if (mysqli_num_rows($result) == 1) {
        // user found in manager table
        $row = mysqli_fetch_assoc($result);
        $_SESSION["manager_id"] = $row["id"];
      }
    }

    // Redirect the user based on their role
    if ($role == "employee") {
      header("Location: employeedashboard.php");
    } elseif ($role == "branch manager") {
      header("Location: branch_manager.php");
    } elseif ($role == "manager") {
      header("Location: manager.php");
    }
  } else {
    // Login failed
    echo "Invalid email, password, or role";
  }
}
?>
