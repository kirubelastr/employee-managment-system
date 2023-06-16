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
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user-type'])) {
  // Redirect to the login page
  header('Location: login.php');
  exit;
}

// Connect to the database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$sql = "SELECT employee.employeeID, employee.firstname, employee.middlename, employee.lastname, employee.dateofbirth, employee.gender, employee.address, employee.primary_phone, employee.secondary_phone, employee.dateofjoin, employee.education_status, employee.employee_photo, employee.email, employee.employment_status, employee.employeefile, employee.yearlyvacationdays,
branch.branchName,
login.username,
department.departmentName,
position.positionName
FROM employee
LEFT JOIN branch ON employee.branchID = branch.branchID
LEFT JOIN login ON employee.userID = login.userID
LEFT JOIN department ON employee.departmentID = department.departmentID
LEFT JOIN position ON employee.positionID = position.positionID
WHERE employee.employeeID = ?";

// Bind parameters to the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user-type']);

// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows > 0) {
  // Output data of each row in an unordered list format.
  while($row = $result->fetch_assoc()) {
    echo "<ul class='employee'>";
    echo "<li>Employee ID: " . $row["employeeID"] . "</li>";
    echo "<li>Name: " . $row["firstname"] . " " . $row["middlename"] . " " . $row["lastname"] . "</li>";
    echo "<li>Date of Birth: " . $row["dateofbirth"] . "</li>";
    echo "<li>Gender: " . $row["gender"] . "</li>";
    echo "<li>Address: " . $row["address"] . "</li>";
    echo "<li>Primary Phone: " . $row["primary_phone"] . "</li>";
    echo "<li>Secondary Phone: " . $row["secondary_phone"] . "</li>";
    echo "<li>Date of Join: " . $row["dateofjoin"] . "</li>";
    echo "<li>Education Status: " . $row["education_status"] . "</li>";
    echo "<li>Email: " . $row["email"] . "</li>";
    echo "<li>Employment Status: " . $row["employment_status"] . "</li>";
    echo "<li>Yearly Vacation Days: " . $row["yearlyvacationdays"] . "</li>";
    echo "<li>Branch Name: " . $row["branchName"] . "</li>";
    echo "<li>Username: " . $row["username"] . "</li>";
    echo "<li>Department Name: " . $row["departmentName"] . "</li>";
    echo "<li>Position Name: " . $row["positionName"] . "</li>";
    echo "</ul>";

    // Display the photo and file as well.
    // Note that you need to modify this part based on your database structure.
    // You can use the following code as a reference:

    echo "<div class='employee-photo-container'>";
    echo "<img src='data:image/jpeg;base64," . base64_encode($row['employee_photo']) . "' alt='Employee Photo' class='employee-photo'>";
    }
    echo "</div>";
    $conn->close();
    ?>
    <!-- The button to open the modal form -->
    <button class="open-button" onclick="openForm()">Open Form</button>

    <!-- The modal form -->
    <div class="form-popup" id="myForm">
    <form action="/action_page.php" class="form-container">
    <h1>Login</h1>

    <!-- The iframe that displays the PDF file -->
    <iframe src="path/to/your/pdf/file.pdf"></iframe>

    <button type="submit" class="btn">Submit</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
    </form>
    </div>

    <script>
    function openForm() {
    document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
    document.getElementById("myForm").style.display = "none";
    }
    </script>
  </div>
  </div>
</div>
</body>
</html>