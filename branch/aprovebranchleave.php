<?php 
require_once "connection.php";

// get pending leave requests for employees in the same branch as the branch manager
$sql = "SELECT el.*, IF(el.employeeID IS NOT NULL, e.yearlyvacationdays, m.yearlyvacationdays) AS vacationdays 
        FROM employee_leave el
        LEFT JOIN employee e ON el.employeeID = e.employeeID
        LEFT JOIN manager m ON el.managerID = m.managerID
        JOIN branch b ON e.branchID = b.branchID
        WHERE el.status = 'pending' AND b.managerID = " . $_SESSION['user_type'];
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
        WHERE el.status != 'pending' AND b.managerID = " . $_SESSION['user_type'];
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
      echo "<td></td>";
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
