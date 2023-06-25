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
    <h3>employee</h3>
    <a  href="employeedashboard.php">Home</a>
    <a href="employeeleave.php">leave</a>
    <a href="employeeattendance.php">attendance</a>
    <a class="active"href="employeedetails.php">details</a>
  </div>
    <div class="form-container">
    <?php
        require_once "connection.php";
        
        // Retrieve manager information from database
        $employeeID = $_SESSION['user_type'];
        $sql_manager = "SELECT * FROM employee WHERE employeeID = '$employeeID'";
        $result_manager = $conn->query($sql_manager);
        function base64_to_jpeg($base64_string, $output_file) {
          $ifp = fopen($output_file, "wb"); 
          fwrite($ifp, base64_decode($base64_string)); 
          fclose($ifp); 
          return $output_file; 
        }
        // Check if any results were returned
        if ($result_manager->num_rows > 0) {
            // Output data of each row
            while($row_employee = $result_manager->fetch_assoc()) {
                echo "<table>";
                echo "<tr><td>Employee ID:</td><td>".$row_employee["employeeID"]."</td></tr>";
                echo "<tr><td>First Name:</td><td>".$row_employee["firstname"]."</td></tr>";
                echo "<tr><td>Middle Name:</td><td>".$row_employee["middlename"]."</td></tr>";
                echo "<tr><td>Last Name:</td><td>".$row_employee["lastname"]."</td></tr>";
                echo "<tr><td>Date of Birth:</td><td>".$row_employee["dateofbirth"]."</td></tr>";
                echo "<tr><td>Gender:</td><td>".$row_employee["gender"]."</td></tr>";
                echo "<tr><td>state:</td><td>".$row_employee["state"]."</td></tr>";
                echo "<tr><td>city(sub city):</td><td>".$row_employee["city"]."</td></tr>";
                echo "<tr><td>street:</td><td>".$row_employee["street"]."</td></tr>";
                echo "<tr><td>Primary Phone:</td><td>".$row_employee["primary_phone"]."</td></tr>";
                echo "<tr><td>Secondary Phone:</td><td>".$row_employee["secondary_phone"]."</td></tr>";
                echo "<tr><td>Date of Join:</td><td>".$row_employee["dateofjoin"]."</td></tr>";
                echo "<tr><td>Education Status:</td><td>".$row_employee["education_status"]."</td></tr>";
                echo "<tr><td>Employee Photo:</td><td><img src='data:image/jpeg;base64,".base64_encode($row_employee["employee_photo"])."'/></td></tr>";
                echo "<tr><td>Email:</td><td>".$row_employee["email"]."</td></tr>";
                echo "<tr><td>Employment Status:</td><td>".$row_employee["employment_status"]."</td></tr>";
                echo "<tr><td>Employee File:</td><td><a href='data:application/pdf;base64,".base64_encode($row_employee["employeefile"])."'>View PDF</a></td></tr>";
                echo "<tr><td>yearly vaccation days:</td><td>".$row_employee["yearlyvacationdays"]."</td></tr>";
                echo "<tr><td>basesalary:</td><td>".$row_employee["basesalary"]."</td></tr>";
                echo "<tr><td>Branch:</td><td>".$row_employee["branchID"]."</td></tr>";
                // Retrieve branch information from database
               $branchID = $row_employee['branchID'];
               $sql_login = "SELECT branchname FROM branch WHERE branchID = '$branchID'";
               $result_login = $conn->query($sql_login);
               $row_branch = $result_login->fetch_assoc();
               echo "<tr><td>branch name:</td><td>".$row_branch["branchname"]."</td></tr>";
       
               // Retrieve login information from database
               $email = $row_employee['email'];
               $sql_login = "SELECT username FROM login WHERE username = '$email'";
               $result_login = $conn->query($sql_login);
               $row_login = $result_login->fetch_assoc();
               echo "<tr><td>User ID:</td><td>".$row_login["username"]."</td></tr>";
       
               // Retrieve department information from database
               $departmentID = $row_employee['departmentID'];
               $sql_department = "SELECT departmentname FROM department WHERE departmentID = '$departmentID'";
               $result_department = $conn->query($sql_department);
               $row_department = $result_department->fetch_assoc();
               echo "<tr><td>Department:</td><td>".$row_department["departmentname"]."</td></tr>";
       
               // Retrieve position information from database
               $positionID = $row_employee['positionID'];
               $sql_position = "SELECT positionname FROM position WHERE positionID = '$positionID'";
               $result_position = $conn->query($sql_position);
               $row_position = $result_position->fetch_assoc();
               echo "<tr><td>Position:</td><td>".$row_position["positionname"]."</td></tr>";
       
            }
        } else {
            echo "No results found.";
        }
        
        ?>
        <div class="container">
      
      <?php
          // Retrieve allowance information from database
  $employeeID = $_SESSION['user_type'];
  $sql_allowance = "SELECT * FROM allowance WHERE employeeID = '$employeeID'";
  $result_allowance = $conn->query($sql_allowance);
  
  // Check if any results were returned
  if ($result_allowance->num_rows > 0) {
      // Output data of each row
      while($row_allowance = $result_allowance->fetch_assoc()) {
          echo "<table>";
          echo "<tr><td>Allowance ID:</td><td>".$row_allowance["allowanceID"]."</td>";
          echo "<td>Allowance Type:</td><td>".$row_allowance["allowanceType"]."</td></tr>";
          echo "<tr><td>Allowance Amount:</td><td>".$row_allowance["allowanceAmount"]."</td></tr>";
          echo "</table>";
      }
  } else {
      echo "No allowance data found";
  }
  
  // Retrieve deduction information from database
  $employeeID = $_SESSION['user_type'];
  $sql_deduction = "SELECT * FROM deduction WHERE employeeID = '$employeeID'";
  $result_deduction = $conn->query($sql_deduction);
  
  // Check if any results were returned
  if ($result_deduction->num_rows > 0) {
      // Output data of each row
      while($row_deduction = $result_deduction->fetch_assoc()) {
          echo "<table>";
          echo "<tr><td>Deduction ID:</td><td>".$row_deduction["deductionID"]."</td>";
          echo "<td>Deduction Type:</td><td>".$row_deduction["deductionType"]."</td></tr>";
          echo "<tr><td>Deduction Amount:</td><td>".$row_deduction["deductionAmount"]."</td></tr>";
          echo "</table>";
      }
  } else {
      echo "No deduction data found";
  }
  
          ?>
      </div>
        <!-- Modal window for displaying manager photo -->
        <div id="photo-modal" class="modal">
          <span class="close">×</span>
          <img class="modal-content" id="photo-modal-image">
          <div id="photo-modal-caption"></div>
        </div>
        
        <!-- Styles for modal window -->
        <style>
        .modal {
          display: none;
          position: fixed;
          z-index: 1;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          overflow: auto;
          background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
          margin: auto;
          display: block;
          max-width: 700px;
        }
        
        #photo-modal-caption {
          margin: auto;
          display: block;
          width: 80%;
          text-align: center;
        }
        
        .close {
          position: absolute;
          top: 10px;
          right: 25px;
          color: #f1f1f1;
          font-size: 40px;
          font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
          color: #bbb;
          text-decoration: none;
          cursor:pointer;
        }
        </style>
        
        <!-- JavaScript for displaying manager photo in modal window -->
        <script>
        // Get the modal
        var modal = document.getElementById("photo-modal");
        
        // Get the image and insert it inside the modal
        var modalImg = document.getElementById("photo-modal-image");
        var captionText = document.getElementById("photo-modal-caption");
        var managerPhotos = document.getElementsByClassName("manager-photo");
        for (var i = 0; i < managerPhotos.length; i++) {
            managerPhotos[i].onclick = function(){
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            }
        }
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
            modal.style.display = "none";
        }
        </script>
        
            </div>
          </div>
        </div>
        </body>
        </html>
        