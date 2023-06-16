<?php
session_start();
$_SESSION["userType"] = "employee";
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

  </style>
</head>
<body>
<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>Sidebar</h3>
    <a href="employeedashboard.php">Home</a>
    <a class="active"href="managerleave.php">leave</a>
    <a href="employeeattendance.php">attendance</a>
    <a href="employee.php">details</a>
  </div>
  <div class="rightofsidebar">
<div class="container">
   <h1>Leave Request Form</h1>
   <form action="fillleave.php" method="post"><label for="userID">Your ID:</label>
        <input type="text" id="userID" name="userID" value="<?php echo $_SESSION['user_type']; ?>" required><br>

        <label for="leavetype">Leave Type:</label>
        <select id="leavetype" name="leavetype" required>
            <option value="">--Please choose an option--</option>
            <option value="sick">Sick Leave</option>
            <option value="vacation">Vacation Leave</option>
            <option value="personal">Personal Leave</option>
        </select><br>

        <label for="startdate">Start Date:</label>
        <input type="date" id="startdate" name="startdate" required><br>

        <label for="enddate">End Date:</label>
        <input type="date" id="enddate" name="enddate" required>

        <input type="submit" value="apply">
    </form>
    </div>
    <div class="container">
     <div class="employee-info">
    <table>
            <thead> <br><br>
            <tr>
                <td>ID</td>
                <td>manager ID</td>
                <td>DATE</td>
                <td>leave type</td>
                <td>START DATE</td>
                <td>END DATE</td>
                <td>STATUS</td>
            </tr>    
            </thead>
         <tbody>
            <?php

            require_once "connection.php";
            $sql = "SELECT * from employee_leave WHERE managerID IS NOT NULL  AND date=CURDATE()";
            $query = $conn->query($sql);
            if ($query->num_rows > 0) {
              // Output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["leaveID"] . "</td>";
                  echo "<td>" . $row["managerID"] . "</td>";
                  echo "<td>" . $row["date"] . "</td>";
                  echo "<td>" . $row["leavetype"] . "</td>";
                  echo "<td>" . $row["startdate"] . "</td>";
                  echo "<td>" . $row["enddate"] . "</td>";
                  echo "<td>" . $row["status"] . "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='11'>No results found</td></tr>";
          }
            ?>

         </tbody>
        </table>
    </div>
    <div class="employee-info">
    <h5>yearly</h5>
    <div>
    <?php
        require_once "connection.php";
        $sql = "SELECT * from employee_leave WHERE managerID IS NOT NULL AND YEAR(date) = YEAR(CURDATE())";
        $query = $conn->query($sql);
        if ($query->num_rows > 0) {
            // Output data of each row
            while($row = $query->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["leaveID"] . "</td>";
                echo "<td>" . $row["managerID"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["leavetype"] . "</td>";
                echo "<td>" . $row["startdate"] . "</td>";
                echo "<td>" . $row["enddate"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No results found</td></tr>";
        }
        ?>
    </div>
    </div>
</div>
  </div>
  </div>
</body>
</html>