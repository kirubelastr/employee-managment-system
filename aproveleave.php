<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>leave</title>
  <style>   body {
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
  </style>
</head>
<body>
<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>Sidebar</h3>
    <a href="department_and_position.php">department and position</a>
    <a class="active"href="aproveleave.php">aprove leave</a>
    <a href="createusers.php">createusers</a>
    <a href="qrcode.php">qrcode</a>
  </div>
  <div class="rightofsidebar">
<div class="container">
   <h4>Leave Request Form</h4>
   <?php
require_once "connection.php";

// get leave requests
$sql = "SELECT * FROM employee_leave";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table>";
    echo "<tr><th>Leave ID</th><th>Employee ID</th><th>Manager ID</th><th>Date</th><th>Leave Type</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Actions</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["leaveID"] . "</td>";
        echo "<td>" . $row["employeeID"] . "</td>";
        echo "<td>" . $row["managerID"] . "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "<td>" . $row["leavetype"] . "</td>";
        echo "<td>" . $row["startdate"] . "</td>";
        echo "<td>" . $row["enddate"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td>";
        if ($row["status"] == "pending") {
            // show approve and reject buttons
            echo '<form method="post" action="update.php">';
            echo '<input type="hidden" name="leaveID" value="' . $row["leaveID"] . '">';
            echo '<input type="submit" name="approve" value="Approve">';
            echo '<input type="submit" name="reject" value="Reject">';
            echo '</form>';
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>


         </tbody>
        </table>
    </div>
    </div>
    </div>
</body>
</html>