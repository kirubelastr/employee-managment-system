
<!-- Styles for modal window -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

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
  height: 100vh;
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
  border-left-color: red;
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
 max-width: 600px;
 height: auto;
 margin: 10px;
 padding: 20px;
 background-color: #fff;
 box-shadow: 0 0 10px rgba(0,0,0,0.2);
  }
h3 {
  margin-top: 0;
 }
 hr {
 margin: 20px 0;
 border: none;
 border-top: 1px solid #ccc;
}

.employee-info {
            text-align: center;
            border-style: solid;
            border-width: 1px;
            border-color: #000000;
            background-color: #FFFFFF;
         }
         table {
        border-collapse: collapse;
        width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th {
            background-color: #4CAF50;
            color: white;
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

.form-container h2 {
    margin-top:0; 
    margin-bottom :10px; 
}

.form-section {
    margin-bottom :5px; 
    border :1px solid #ccc; 
    border-radius :4px; 
    padding :10px; 
    box-sizing :border-box; 
}
.form-section2{
    height :350px; 
    margin-bottom :5px; 
    border :1px solid #ccc; 
    border-radius :4px; 
    padding :10px; 
    box-sizing :border-box; 
    
}

.form-section h3 {
    margin-top :0; 
    margin-bottom :5px; 
}
form {
    display:block; 
    flex-wrap :wrap; 
    justify-content:left; 
    align-items:center; 
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
.today {
    background-color: #ffffcc;
}
.modal {
  display: none;
  position: floa;
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

#qr-modal-caption {
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

#print-button {
    display:block;
    margin:auto;
}
  </style>
</head>
<body>
<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>Sidebar</h3>
    <a  href="department_and_position.php">department and position</a>
    <a href="aproveleave.php">aprove leave</a>
    <a href="createusers.php">createusers</a>
    <a href="employee.php">add employee</a>
    <a href="manager.php">add manage</a>
    <a class="active"href="qrcode.php">qrcode</a>
  </div>
  <div class="rightofsidebar">
<div class="container">

<?php
// Require the connection file to connect to the database
require_once "connection.php";

// Function to convert base64-encoded data to a JPEG file
function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb"); 
    fwrite($ifp, base64_decode($base64_string)); 
    fclose($ifp); 
    return $output_file; 
}

// Query to select the employeeID and managerID from the employee and manager tables
$employee_query = "SELECT employeeID FROM employee WHERE employeeID NOT IN (SELECT employeeID FROM qrcode WHERE employeeID IS NOT NULL)";
$manager_query = "SELECT managerID FROM manager WHERE managerID NOT IN (SELECT managerID FROM qrcode WHERE managerID IS NOT NULL)";

// Execute the queries and store the results in variables
$employee_result = $conn->query($employee_query);
if ($employee_result === false) {
    die("Error executing query: " . $conn->error);
}
$manager_result = $conn->query($manager_query);
if ($manager_result === false) {
    die("Error executing query: " . $conn->error);
}

// Check if there are any employees or managers without a QR code
if ($employee_result->num_rows > 0 || $manager_result->num_rows > 0) {
    // There are employees or managers without a QR code
    // Generate a QR code for each employee or manager

    // Include the library to generate QR codes
    include "phpqrcode/qrlib.php";

    // Generate a QR code for each employee without one
    while($row = $employee_result->fetch_assoc()) {
        // Get the employee ID from the row
        $employeeID = $row['employeeID'];

        // Set the data to be encoded in the QR code
        $qr_data = "Employee ID: " . $employeeID;

        // Generate the QR code and save it to a variable
        ob_start();
        QRcode::png($qr_data);
        $qr_image = ob_get_contents();
        ob_end_clean();

        // Insert the data into the qrcode table
        $insert_query = "INSERT INTO qrcode (employeeID, qrimage) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        if ($insert_stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $insert_stmt->bind_param("is", $employeeID, $qr_image);
        if ($insert_stmt->execute() === false) {
            die("Error executing statement: " . $insert_stmt->error);
        }
        $insert_stmt->close();
    }

    // Generate a QR code for each manager without one
    while($row = $manager_result->fetch_assoc()) {
        // Get the manager ID from the row
        $managerID = $row['managerID'];

        // Set the data to be encoded in the QR code
        $qr_data = "Manager ID: " . $managerID;

        // Generate the QR code and save it to a variable
        ob_start();
        QRcode::png($qr_data);
        $qr_image = ob_get_contents();
        ob_end_clean();

        // Insert the data into the qrcode table
        $insert_query = "INSERT INTO qrcode (managerID, qrimage) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        if ($insert_stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        // Changed first parameter from "i" to "s" since managerID is now a string (varchar)
        $insert_stmt->bind_param("ss", $managerID, $qr_image);
        if ($insert_stmt->execute() === false) {
            die("Error executing statement: " . $insert_stmt->error);
        }
        $insert_stmt->close();
    }
}

// Save binary image data to a JPEG file using base64_to_jpeg() function

// Query to select a single row from qrcode table
$sql = "SELECT qrimage FROM qrcode WHERE id = 1";

// Execute query and store result in variable
$result = $conn->query($sql);

// Check if there is any row in result
if ($result->num_rows > 0) {
    // Get qrimage from row
    $row = $result->fetch_assoc();
    if (isset($row['qrimage'])) {
      // Save binary image data to a JPEG file using base64_to_jpeg() function
      $qr_image_base64 = base64_encode($row['qrimage']);
      base64_to_jpeg($qr_image_base64, "debug.jpg");
      echo "<p>Image saved to debug.jpg</p>";
    } else {
      echo "<p>No image data found in row</p>";
    }
} else {
}
// Display the values stored in the table for all employees and managers

// Query to select all data from qrcode table
$sql = "SELECT * FROM qrcode";

// Execute query and store result in variable
$result = $conn->query($sql);

// Check if there is any row in result
if ($result->num_rows > 0) {
    // Output data of each row

    echo "<h2>QR Codes</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Employee ID</th><th>Manager ID</th><th>QR Image</th></tr>";
    while($row = $result->fetch_assoc()) {
        // Get id, employeeID, managerID, and qrimage from row
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['employeeID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['managerID']) . "</td>";
        if (isset($row['qrimage'])) {
          echo "<td><img class='qr-image' src='data:image/png;base64," . base64_encode($row['qrimage']) . "' alt='QR Image'></td>";
        } else {
          echo "<td>No image data</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No rows found in qrcode table</p>";
}
?>

      <!-- Modal window for displaying QR code images -->
      <div id="qr-modal" class="modal">
        <span class="close">×</span>
        <img class="modal-content" id="qr-modal-image">
        <div id="qr-modal-caption"></div>
        <button id="print-button">Print</button>
      </div>



        <!-- JavaScript for displaying QR code images in modal window -->
        <script>
        // Get the modal
        var modal = document.getElementById("qr-modal");

        // Get the image and insert it inside the modal
        var modalImg = document.getElementById("qr-modal-image");
        var captionText = document.getElementById("qr-modal-caption");
        var qrImages = document.getElementsByClassName("qr-image");
        for (var i = 0; i < qrImages.length; i++) {
            qrImages[i].onclick = function(){
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

        // Get the print button
        var printButton = document.getElementById("print-button");

        // When the user clicks on the print button, print the QR code image
        printButton.onclick = function() {
            var printWindow = window.open("", "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
            printWindow.document.write("<img src='" + modalImg.src + "'/>");
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
        </script>
  </div></div></div>
</body>
</html>