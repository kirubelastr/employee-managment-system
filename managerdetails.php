<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>employee Data Input Form</title>
  <style>
   body {
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: stretch;
 }
 .page-container {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: stretch;
    }

    .content-container {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: stretch;
    }
 .sidebar {
   width: 200px;
   height: 100%;
   background-color: #f0f0f0;
   padding: 20px;
   box-sizing: border-box;
   display: flex;
   flex-direction: column;
   justify-content: flex-start;
   align-items: center;
 }
 
 .sidebar h3 {
   margin-top: 0;
 }
 
 .sidebar a {
   display: block;
   margin-bottom: 10px;
   padding: 10px;
   width: 100%;
   text-align: center;
   text-decoration: none;
   color: #333;
   border-left: 5px solid transparent;
 }
 
 .sidebar a.active,
 .sidebar a:hover {
   background-color: #ddd;
   border-left-color: #09f;
 }
 .manager-media {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.manager-photo-container {
  width: 50%;
}

.manager-photo {
  max-width: 100%;
}

.manager-file-container {
  width: 50%;
}

 .form-container {
   flex: 1;
   padding: 20px;
   box-sizing: border-box;
   display: flex;
   flex-direction: column;
   justify-content: flex-start;
   align-items: stretch;
 }
 .employee {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 10px;
    }

    .employee img {
      max-width: 100%;
    }

    @media screen and (max-width: 768px) {
      .employee {
        display: flex;
        flex-direction: column;
      }
    }
    .form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width iframe */
.form-container iframe {
  width: 100%;
  height: 200px;
}

/* Style the submit button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
}

/* Style the close button */
.form-container .cancel {
  background-color: red;
}

/* Clear floats */
.form-container::after {
  content: "";
  clear: both;
  display: table;
}
 label {
     display:inline-block; 
     width :140px; 
     text-align:right; 
     margin-right :20px; 
 }
     
 input[type="submit"] {
       background-color:#09f ; 
       color:#fff ; 
       border:none ; 
       border-radius :4px ; 
       padding :10px ; 
       cursor:pointer ; 
       font-size :16px ; 
       margin-top :10px ;  
 }
 input,
 select,
 textarea {
       position :inherits ;  
       flex :1 ;  
       padding :10px ;  
       border :1px solid #ccc ;  
       border-radius :4px ;  
       box-sizing:border-box ;  
       margin-bottom :10px ;  
       font-size :16px ;  
 }
 
 input[type="file"] {
       padding :10 ;
 }
 
 input:focus,
 select:focus,
 textarea:focus {
       outline:none ;
       border-color:#09f ;
 }
 
 select {
       width :inherit ;
       padding-left: 20px;
       padding-right: 40px;
 }
 
 textarea {
       height :auto ;
 }
 
 input[type="submit"]:hover {
       background-color:#0077cc ;
 }
 

  </style>
</head>
<body>

<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
  <h3>Sidebar</h3>
    <a  href="employeedashboard.php">Home</a>
    <a href="employeeleave.php">leave</a>
    <a href="employeeattendance.php">attendance</a>
    <a class="active"href="employee.php">details</a>
  </div>
  <div class="form-container">
  <?php

// Check if the user is logged in
if (!isset($_SESSION['user_type'])) {

  // Redirect to the login page
  header('Location: login.php');
  exit;
}

// Connect to the database
require_once "connection.php";

// Prepare the SQL statement
$sql = "SELECT manager.managerID, manager.firstname, manager.middlename, manager.lastname, manager.dateofbirth, manager.gender, manager.address, manager.primary_phone, manager.secondary_phone, manager.dateofjoin, manager.education_status, manager.manager_photo, manager.email, manager.managerfile, manager.yearlyvacationdays,
login.username,
(SELECT departmentname FROM department WHERE department.departmentID = manager.departmentID) AS departmentname,
(SELECT positionname FROM position WHERE position.positionID = manager.positionID) AS positionname
FROM manager
LEFT JOIN login ON manager.userID = login.userID
WHERE manager.managerID = ?";

// Bind parameters to the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_type']);

// Execute the statement
if (!$stmt->execute()) {
  // Display an error message if the statement execution fails
  echo "<script>alert('Error executing the statement: " . $stmt->error . "');</script>";
} else {
  // Get the result set
  $result = $stmt->get_result();

  // Check if there are any results
  if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<div class='manager-container'>";
      echo "<div class='manager-details'>";
      echo "<h2>Manager Details</h2>";
      echo "<ul>";
      echo "<li>Manager ID: " . $row["managerID"] . "</li>";
      echo "<li>Name: " . $row["firstname"] . " " . $row["middlename"] . " " . $row["lastname"] . "</li>";
      echo "<li>Date of Birth: " . $row["dateofbirth"] . "</li>";
      echo "<li>Gender: " . $row["gender"] . "</li>";
      echo "<li>Address: " . $row["address"] . "</li>";
      echo "<li>Primary Phone: " . $row["primary_phone"] . "</li>";
      echo "<li>Secondary Phone: " . $row["secondary_phone"] . "</li>";
      echo "<li>Date of Join: " . $row["dateofjoin"] . "</li>";
      echo "<li>Education Status: " . $row["education_status"] . "</li>";
      echo "<li>Email: " . $row["email"] . "</li>";
      echo "<li>Yearly Vacation Days: " . $row["yearlyvacationdays"] . "</li>";
      echo "<li>Username: " . $row["username"] . "</li>";
      echo "<li>Department Name: " . $row["departmentname"] . "</li>";
      echo "<li>Position Name: " . $row["positionname"] . "</li>";
      echo "</ul>";
      echo "</div>";

      // Display the photo and file
      echo "<div class='manager-media'>";
      echo "<div class='manager-photo-container'>";
      echo "<img id='photo-preview' src='data:image/jpeg;base64," . base64_encode($row['manager_photo']) . "' alt='Manager Photo' class='manager-photo' style='max-width: 200px; max-height: 200px;'>";
      echo "</div>";
      echo "<div class='manager-file-container'>";
      echo "<a href='" . $row['managerfile'] . "' download>Download Manager File</a>";
      echo "</div>";
      echo "</div>";

      echo "</div>";
    }

    $conn->close();
  } else {
    // Display a message if there are no results
    echo "<script>alert('No results found for the specified manager ID.');</script>";
  }
}
?>


  </div>
  </div>
</div>
</body>
</html>

