<?php
session_start();
require_once "connection.php";

// Check if the form has been submitted
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["role"])) {
  // Get the email, password, and role from the form
  $email = $_POST["email"];
   // Hash the password
   $password = md5($_POST["password"]);
   $role = $_POST["role"];
   
   // Check if the email, password, and role exist in the login table
   $query = "SELECT * FROM login WHERE username='$email' AND password='$password' AND role='$role'";
   $result = mysqli_query($conn, $query);
   
   if (mysqli_num_rows($result) == 1) {
     // Login successful
     $row = mysqli_fetch_assoc($result);
     $_SESSION["role"] = $role;

    // Check if the user is an employee
    if ($role === "employee") {
      $query = "SELECT * FROM employee WHERE email='$email'";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) == 1) {
        // Employee found in employee table
        $row = mysqli_fetch_assoc($result);
        $_SESSION["user_type"] = $row['employeeID'];
        // Display employee ID using a script alert
      }
    } else {
      // Check if the user email exists in the manager table
      $query = "SELECT * FROM manager WHERE email='$email'";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) == 1) {
        // user found in manager table
        $row = mysqli_fetch_assoc($result);
        $_SESSION["user_type"] = $row["managerID"];
        
      }
    }

    // Display session values using a script alert
    echo "<script>alert('user_type: " . $_SESSION["user_type"] . ", role: " . $_SESSION["role"] . "');</script>";

    // Redirect the user based on their role using JavaScript
    if ($role == "employee") {
        echo "<script>window.location.href='employeedashboard.php';</script>";
    } elseif ($role == "manger(branch manager)") {
        echo "<script>window.location.href='managerdashboard.php';</script>";
    } elseif ($role == "general manager(admin)") {
        echo "<script>window.location.href='manager.php';</script>";
    }
  } else {
    // Login failed
    echo "<script>alert('Invalid email, password, or role');</script>";
    echo "<script>window.location.href='login.php';</script>";
  }
}
?>
