<?php 
session_start();
require_once "../connection.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard</title>
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
                border-left-color: #09f;
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
                max-width: max-content;
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
            .table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;}
                    
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
                    width: inherit;
                    padding-left: 20px;
                    padding-right: 40px;
                }

                textarea {
                    height: auto;
                }

                input[type="submit"]:hover {
                    background-color: #0077cc;
                }

       </style>
</head>
<body>
    
<div class="page-container">
  <?php include '../header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>branch manager</h3>
    
    <a href="../managerdashboard.php">Home</a>
    <a href="../managerleave.php">leave</a>
    <a href="../managerattendance.php">attendance</a>
    <a href="../managerdetails.php">details</a>
    <a href="addbranchemployee.php">add branch employees</a>
    <a href="displayemployees.php">view branch employees</a>
    <a href="displaysalaryemployee.php">view employee salary</a>
    <a class="active"href="aprovebranchleave.php">aprove branch leave</a>
    </div>
  <div class="rightofsidebar">
<div class="container">
    <?php
// get manager's branch ID from branchmanager table
$sql = "SELECT branchID FROM branchmanager WHERE managerID = '" . $_SESSION['user_type'] . "'";
$result = $conn->query($sql);
$manager_branch_id = $result->fetch_assoc()['branchID'];


// get pending leave requests for employees in the same branch as the branch manager
$sql = "SELECT el.*, IF(el.employeeID IS NOT NULL, e.yearlyvacationdays, m.yearlyvacationdays) AS vacationdays 
        FROM employee_leave el
        LEFT JOIN employee e ON el.employeeID = e.employeeID
        LEFT JOIN manager m ON el.managerID = m.managerID
        JOIN branch b ON e.branchID = b.branchID
        WHERE el.status = 'pending' AND b.branchID = " . $manager_branch_id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output pending leave requests
    echo "<table>";
    echo "<tr><th>Leave ID</th><th>Employee ID</th><th>Manager ID</th><th>Date</th><th>Leave Type</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Vacation Days</th><th>Actions</th></tr>";
    while($row = $result->fetch_assoc()) {
        // get employee's or manager's yearly vacation days based on non-null value
        $vacationdays = $row["vacationdays"];

        echo "<tr>";
        echo "<td>" . $row["leaveID"] . "</td>";
        echo "<td>" . $row["employeeID"] . "</td>";
        echo "<td>" . $row["managerID"] . "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "<td>" . $row["leavetype"] . "</td>";
        echo "<td>" . $row["startdate"] . "</td>";
        echo "<td>" . $row["enddate"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td>" . $vacationdays . "</td>";
        echo "<td>";
        // show approve and reject buttons
        echo '<form method="post" action="update.php">';
        echo '<input type="hidden" name="leaveID" value="' . $row["leaveID"] . '">';
        echo '<input type="submit" name="approve" value="Approve">';
        echo '<input style="background-color: red;" type="submit" name="reject" value="Reject">';
        echo '</form>';
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No pending leave requests";
}
echo '<div class="container">';

// get approved/denied leave requests for employees in the same branch as the branch manager
$sql = "SELECT el.* FROM employee_leave el
        JOIN employee e ON el.employeeID = e.employeeID
        JOIN branch b ON e.branchID = b.branchID
        WHERE el.status != 'pending' AND b.branchID = " . $manager_branch_id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output approved/denied leave requests
    echo "<table>";
    echo "<tr><th>Leave ID</th><th>Employee ID</th><th>Manager ID</th><th>Date</th><th>Leave Type</th><th>Start Date</th><th>End Date</th><th>Status</th></tr>";
    while($row = $result->fetch_assoc()) {
      
        // set background color based on status
        if ($row['status'] == 'pending') {
          $bg_color = 'blue';
      } elseif ($row['status'] == 'approved') {
          $bg_color = 'green';
      } else {
          $bg_color = 'red';
      }
      echo "<tr>";
      echo "<td>" . $row["leaveID"] . "</td>";
      echo "<td>" . $row["employeeID"] . "</td>";
      echo "<td>" . $row["managerID"] . "</td>";
      echo "<td>" . $row["date"] . "</td>";
      echo "<td>" . $row["leavetype"] . "</td>";
      echo "<td>" . $row["startdate"] . "</td>";
      echo "<td>" . $row["enddate"] . "</td>";
      echo "<td style='background-color: " . $bg_color . ";'>" . $row["status"] . "</td>";
      echo "</tr>";
  }
  echo "</table>";
} else {
  echo "No approved/denied leave requests";
}
?>
</div>
</div>
</body>
</html>
