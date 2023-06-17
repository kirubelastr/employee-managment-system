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
    <a  href="managerdashboard.php">Home</a>
    <a href="managerleave.php">leave</a>
    <a href="managerattendance.php">attendance</a>
    <a class="active"href="managerdetails.php">details</a>
  </div>
    <div class="form-container">
    <?php
require_once "connection.php";

// Retrieve manager information from database
$managerID = $_SESSION['user_type'];
$sql_manager = "SELECT * FROM manager WHERE managerID = '$managerID'";
$result_manager = $conn->query($sql_manager);

// Check if any results were returned
if ($result_manager->num_rows > 0) {
    // Output data of each row
    while($row_manager = $result_manager->fetch_assoc()) {
        echo "<table>";
        echo "<tr><td>Manager ID:</td><td>".$row_manager["managerID"]."</td></tr>";
        echo "<tr><td>First Name:</td><td>".$row_manager["firstname"]."</td></tr>";
        echo "<tr><td>Middle Name:</td><td>".$row_manager["middlename"]."</td></tr>";
        echo "<tr><td>Last Name:</td><td>".$row_manager["lastname"]."</td></tr>";
        echo "<tr><td>Date of Birth:</td><td>".$row_manager["dateofbirth"]."</td></tr>";
        echo "<tr><td>Gender:</td><td>".$row_manager["gender"]."</td></tr>";
        echo "<tr><td>Address:</td><td>".$row_manager["address"]."</td></tr>";
        echo "<tr><td>Primary Phone:</td><td>".$row_manager["primary_phone"]."</td></tr>";
        echo "<tr><td>Secondary Phone:</td><td>".$row_manager["secondary_phone"]."</td></tr>";
        echo "<tr><td>Date of Join:</td><td>".$row_manager["dateofjoin"]."</td></tr>";
        echo "<tr><td>Education Status:</td><td>".$row_manager["education_status"]."</td></tr>";
        echo "<tr><td>yearly vacation days:</td><td>".$row_manager["yearlyvacationdays"]."</td></tr>";
        echo "<tr><td>base salary:</td><td>".$row_manager["basesalary"]."</td></tr>";
        echo "<tr><td>Manager Photo:</td><td><img src='data:image/jpeg;base64,".base64_encode($row_manager["manager_photo"])."' style='max-width: 200px; max-height: 200px;'/></td></tr>";
        echo "<tr><td>Email:</td><td>".$row_manager["email"]."</td></tr>";
        echo "<tr><td>Manager File:</td><td><a href='view_pdf.php?managerID=".$row_manager["managerID"]."'>View PDF</a></td></tr>";
        echo "<tr><td>Yearly Vacation Days:</td><td>".$row_manager["yearlyvacationdays"]."</td></tr>";

        // Retrieve login information from database
        $userID = $row_manager['userID'];
        $sql_login = "SELECT username FROM login WHERE userID = '$userID'";
        $result_login = $conn->query($sql_login);
        $row_login = $result_login->fetch_assoc();
        echo "<tr><td>User ID:</td><td>".$row_login["username"]."</td></tr>";

        // Retrieve department information from database
        $departmentID = $row_manager['departmentID'];
        $sql_department = "SELECT departmentname FROM department WHERE departmentID = '$departmentID'";
        $result_department = $conn->query($sql_department);
        $row_department = $result_department->fetch_assoc();
        echo "<tr><td>Department:</td><td>".$row_department["departmentname"]."</td></tr>";

        // Retrieve position information from database
        $positionID = $row_manager['positionID'];
        $sql_position = "SELECT positionname FROM position WHERE positionID = '$positionID'";
        $result_position = $conn->query($sql_position);
        $row_position = $result_position->fetch_assoc();
        echo "<tr><td>Position:</td><td>".$row_position["positionname"]."</td></tr>";

        echo "</table>";
    }
} else {
    echo "No results found.";
}

// Close database connection
$conn->close();
?>
    </div>
  </div>
</div>
</body>
</html>
