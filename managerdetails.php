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

.rightofsidebar{
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: baseline;
}
.container {
 max-width: auto;
 height: auto;
 margin: 10px;
 padding: 20px;
 background-color: #fff;
 box-shadow: 0 0 10px rgba(0,0,0,0.2);
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
  <h3>branch manager</h3>
    <a  href="managerdashboard.php">Home</a>
    <a href="managerleave.php">leave</a>
    <a href="managerattendance.php">attendance</a>
    <a class="active"href="managerdetails.php">details</a>
    <a href="branch/addbranchemployee.php">add branch employees</a>
    <a href="branch/displayemployees.php">view branch employees</a>
    <a href="branch/displaysalaryemployee.php">view employee salary</a>
    <a href="branch/aprovebranchleave.php">aprove branch leave</a>
  </div>
  <div class="rightofsidebar">
  <div class="container">

    <?php
require_once "connection.php";

// Retrieve manager information from database
$managerID = $_SESSION['user_type'];
$sql_manager = "SELECT * FROM manager WHERE managerID = '$managerID'";
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
    while($row_manager = $result_manager->fetch_assoc()) {
        echo "<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {background-color: #f2f2f2;}
        </style>";
        echo "<table>";
        echo "<tr><td>Manager ID:</td><td>".$row_manager["managerID"]."</td>";
        echo "<td>First Name:</td><td>".$row_manager["firstname"]."</td></tr>";
        echo "<tr><td>Middle Name:</td><td>".$row_manager["middlename"]."</td>";
        echo "<td>Last Name:</td><td>".$row_manager["lastname"]."</td></tr>";
        echo "<tr><td>Date of Birth:</td><td>".$row_manager["dateofbirth"]."</td>";
    echo "<td>Gender:</td><td>".$row_manager["gender"]."</td></tr>";
    echo "<tr><td>state:</td><td>".$row_manager["state"]."</td>";
    echo "<td>city:</td><td>".$row_manager["city"]."</td></tr>";
    echo "<tr><td>street:</td><td>".$row_manager["street"]."</td>";
    echo "<td>Primary Phone:</td><<td>".$row_manager["primary_phone"]."</td></tr>";
    echo "<tr><td>Secondary Phone:</td><<td>".$row_manager["secondary_phone"]."</td>";
    echo "<td>Date of Join:</td><<td>".$row_manager["dateofjoin"]."</td></tr>";
    echo "<tr><td>Education Status:</td><td>".$row_manager["education_status"]."</td>";
    echo "<td>yearly vacation days:</td><td>".$row_manager["yearlyvacationdays"]."</td></tr>";
    echo "<tr><td>base salary:</td><td>".$row_manager["basesalary"]."</td></tr>";
    if (isset($row_manager['manager_photo'])) {
        // Save binary image data to a JPEG file using base64_to_jpeg() function
        $manager_photo_base64 = base64_encode($row_manager['manager_photo']);
        base64_to_jpeg($manager_photo_base64, "manager_photo.jpg");
        echo "<tr><td>Manager Photo:</td><td><img class='manager-photo' src='manager_photo.jpg' style='max-width: 200px; max-height: 200px;'/></td></tr>";
    } else {
        echo "<tr><td>Manager Photo:</td><td>No photo data</td></tr>";
    }
    echo "<tr><td>Email:</td><<td>".htmlspecialchars($row_manager["email"])."</td></tr>";
    if (isset($row_manager['manager_file'])) {
        // Save binary PDF data to a PDF file
        $pdf_file = "manager_file.pdf";
        file_put_contents($pdf_file, $row_manager['manager_file']);
        echo "<tr><td>Manager File:</td><td><button class='manager-file' onclick='printPDF()'>View PDF</button></td></tr>";
        } else {
            echo "<tr><td>Manager File:</td><td>No file data</td></tr>";
        }
        
        // JavaScript for displaying manager PDF file in new window and print modal
        echo "<script>
        function printPDF() {
            var w = window.open('manager_file.pdf');
            w.print();
        }
        </script>";
                // Get the managerID from the session user_type
$managerID = $_SESSION['user_type'];

// Query to get the userID from the manager table where managerID is set in session user_type
$manager_sql = "SELECT userID FROM manager WHERE managerID=?";
$manager_stmt = $conn->prepare($manager_sql);
$manager_stmt->bind_param("s", $managerID);
$manager_stmt->execute();
$manager_result = $manager_stmt->get_result();

// Check if there is any row in the result
if ($manager_result->num_rows > 0) {
    // Get the userID from the row
    $manager_row = $manager_result->fetch_assoc();
    $userID = $manager_row['userID'];

    // Query to get the username from the login table where userID is equal to userID from manager table
    $login_sql = "SELECT username FROM login WHERE userID=?";
    $login_stmt = $conn->prepare($login_sql);
    $login_stmt->bind_param("i", $userID);
    $login_stmt->execute();
    $login_result = $login_stmt->get_result();

    // Check if there is any row in the result
    if ($login_result->num_rows > 0) {
        // Get the username from the row
        $login_row = $login_result->fetch_assoc();
        $username = $login_row['username'];

        // Output the username in a table row
        echo "<tr><td>User ID:</td><td>$username</td></tr>";
    }
}

                // Retrieve department information from database
                $departmentID = $row_manager['departmentID'];
                $sql_department = "SELECT departmentname FROM department WHERE departmentID = '$departmentID'";
                $result_department = $conn->query($sql_department);
                $row_department = $result_department->fetch_assoc();
                echo "<tr><td>Department:</td><<td>".$row_department["departmentname"]."</td></tr>";
            }
        }
        ?>
    </div>
    </div></div>
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
<div class="container">
      
      <?php
          // Retrieve allowance information from database
  $managerID = $_SESSION['user_type'];
  $sql_allowance = "SELECT * FROM allowance WHERE managerID = '$managerID'";
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
  $managerID = $_SESSION['user_type'];
  $sql_deduction = "SELECT * FROM deduction WHERE managerID = '$managerID'";
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
