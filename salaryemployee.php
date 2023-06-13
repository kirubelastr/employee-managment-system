
<!DOCTYPE html>
<html>
<head>
  <title>salary</title>
  <style>
   body {
  margin: 0;
  padding: 0;
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
  </style>
</head>
<body>

  <div class="sidebar">
    <h3>Sidebar</h3>
    <a href="#home">Home</a>
    <a class="active"href="#leave">leave</a>
    <a href="#attendance">attendance</a>
    <a href="#details">details</a>
    
  </div>
<div>
   <h1>salary of employees</h1>
   <div >
   <?php
require_once "connection.php";

// Set the default time zone to East Africa Time (EAT)
date_default_timezone_set('Africa/Addis_Ababa');

$date = new DateTime();
$present_date = new DateTime();
$present_date = $present_date->format('Y-m-d');
$past_date = $date->modify('-30 days')->format('Y-m-d');

// Query to count the number of timely and late attendances and total entries for each employee within the date range
$sql = "SELECT employeeID, 
               COUNT(*) as total_entries,
               SUM(CASE WHEN timein <= '8:30:00' THEN 1 ELSE 0 END) as timely_attendances,
               SUM(CASE WHEN timein > '8:30:00' THEN 1 ELSE 0 END) as late_attendances
        FROM attendance 
        WHERE logdate BETWEEN '$past_date' AND '$present_date'
        GROUP BY employeeID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output HTML table headers
    ?>
    <table style="border: 1px solid black;">
        <tr>
            <th>Employee ID</th>
            <th>Total Entries</th>
            <th>Timely Attendances</th>
            <th>Late Attendances</th>
        </tr>
    <?php

    // Loop through each row of the result set
    while($row = $result->fetch_assoc()) {
        $employeeID = $row["employeeID"];
        $total_entries = $row["total_entries"];
        $timely_attendances = $row["timely_attendances"];
        $late_attendances = $row["late_attendances"];
        
        // Check if employee exists in employee table
        $employee_check_sql = "SELECT * FROM employee WHERE employeeID='$employeeID'";
        $employee_check_result = $conn->query($employee_check_sql);

        if ($employee_check_result->num_rows > 0) {
            // Employee exists, proceed with inserting into salary table
            $sql = "SELECT * FROM salary WHERE employeeID='$employeeID' AND datefrom='$past_date' AND dateto='$present_date'";
            $check_result = $conn->query($sql);
            if ($check_result->num_rows == 0) {
                // Data does not exist, insert it
                $sql = "INSERT INTO salary (employeeID, datefrom, dateto, present_days, late_days)
                        VALUES ('$employeeID', '$past_date', '$present_date', '$timely_attendances', '$late_attendances')";
                $conn->query($sql);
            }
        } else {
            // Employee does not exist in employee table
            echo "Employee with ID $employeeID does not exist";
        }
        
        // Output data of each row in an HTML table row
        echo "<tr>";
        echo "<td>" . $employeeID . "</td>";
        echo "<td>" . $total_entries . "</td>";
        echo "<td>" . $timely_attendances . "</td>";
        echo "<td>" . $late_attendances . "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    <?php
} else {
    echo "<tr><td colspan='4'>No results found</td></tr>";
}

$conn->close();
?>
</div>

</div>

</body>
</html>