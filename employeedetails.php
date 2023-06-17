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
   border-left-color: green;
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
    <a class="active"href="employeedetails.php">details</a>
  </div>
    <div class="form-container">
    <?php
       require_once "connection.php";
       $_SESSION['employeeID']=1;
        // Retrieve employee information from database
        $employeeID = $_SESSION['user_type'];
        $sql = "SELECT e.employeeID, e.firstname, e.middlename, e.lastname, e.dateofbirth, e.gender, e.address, e.primary_phone, e.secondary_phone, e.dateofjoin, e.education_status, e.employee_photo, e.email, e.employment_status, e.employeefile, e.yearlyvacationdays, b.branchID, l.userID, d.departmentID, p.positionID
                FROM employee e 
                LEFT JOIN branch b ON e.branchID = b.branchID 
                LEFT JOIN login l ON e.userID = l.userID 
                LEFT JOIN department d ON e.departmentID = d.departmentID 
                LEFT JOIN position p ON e.positionID = p.positionID 
                WHERE e.employeeID = '$employeeID'";
        $result = $conn->query($sql);

        // Check if any results were returned
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<table>";
                echo "<tr><td>Employee ID:</td><td>".$row["employeeID"]."</td></tr>";
                echo "<tr><td>First Name:</td><td>".$row["firstname"]."</td></tr>";
                echo "<tr><td>Middle Name:</td><td>".$row["middlename"]."</td></tr>";
                echo "<tr><td>Last Name:</td><td>".$row["lastname"]."</td></tr>";
                echo "<tr><td>Date of Birth:</td><td>".$row["dateofbirth"]."</td></tr>";
                echo "<tr><td>Gender:</td><td>".$row["gender"]."</td></tr>";
                echo "<tr><td>Address:</td><td>".$row["address"]."</td></tr>";
                echo "<tr><td>Primary Phone:</td><td>".$row["primary_phone"]."</td></tr>";
                echo "<tr><td>Secondary Phone:</td><td>".$row["secondary_phone"]."</td></tr>";
                echo "<tr><td>Date of Join:</td><td>".$row["dateofjoin"]."</td></tr>";
                echo "<tr><td>Education Status:</td><td>".$row["education_status"]."</td></tr>";
                echo "<tr><td>Employee Photo:</td><td><img src='data:image/jpeg;base64,".base64_encode($row["employee_photo"])."'/></td></tr>";
                echo "<tr><td>Email:</td><td>".$row["email"]."</td></tr>";
                echo "<tr><td>Employment Status:</td><td>".$row["employment_status"]."</td></tr>";
                echo "<tr><td>Employee File:</td><td><a href='data:application/pdf;base64,".base64_encode($row["employeefile"])."'>View PDF</a></td></tr>";
                echo "<tr><td>yearly vaccation days:</td><td>".$row_manager["yearlyvacationdays"]."</td></tr>";
                echo "<tr><td>basesalary:</td><td>".$row_manager["basesalary"]."</td></tr>";
                echo "<tr><td>Branch:</td><td>".$row["branch_name"]."</td></tr>";
                echo "<tr><td>User ID:</td><td>".$row["username"]."</td></tr>";
                echo "<tr><td>Department:</td><td>".$row["department_name"]."</td></tr>";
                echo "<tr><td>Position:</td><td>".$row["position_name"]."</td></tr>";
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