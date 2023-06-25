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
                max-width: auto;
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
    <a class="active"href="displaysalaryemployee.php">view employee salary</a>
    <a href="aprovebranchleave.php">aprove branch leave</a>
  </div>
<div class="rightofsidebar">
    <div class="container">
        <h1>employee salary under this branch </h1>
        <?php
$sql = "SELECT salary.*, branch.branchname, department.departmentname 
FROM salary 
JOIN employee ON salary.employeeID = employee.employeeID
JOIN branch ON employee.branchID = branch.branchID 
JOIN department ON employee.departmentID = department.departmentID
WHERE employee.branchID IN (SELECT branchID FROM branchmanager WHERE managerID = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['user_type']);
$stmt->execute();
$result = $stmt->get_result();

echo "<table>";
echo "<tr><th>Employee ID</th><th>Date From</th><th>Date To</th><th>Work Days</th><th>Salary</th><th>Allowance</th><th>Deduction</th><th>Net Salary</th><th>Branch Name</th><th>Department Name</th></tr>";
$total_net_salary = 0;
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['employeeID']) . "</td>";
    echo "<td>" . htmlspecialchars($row['datefrom']) . "</td>";
    echo "<td>" . htmlspecialchars($row['dateto']) . "</td>";
    echo "<td>" . htmlspecialchars($row['workdays']) . "</td>";
    echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
    echo "<td>" . htmlspecialchars($row['allowance']) . "</td>";
    echo "<td>" . htmlspecialchars($row['deduction']) . "</td>";
    echo "<td>" . htmlspecialchars($row['net']) . "</td>";
    echo "<td>" . htmlspecialchars($row['branchname']) . "</td>";
    echo "<td>" . htmlspecialchars($row['departmentname']) . "</td>";
    echo "</tr>";
    $total_net_salary += $row['net'];
}
echo "</table>";

echo "Total Net Salary: " .$total_net_salary;
$conn->close();
?>


    </div>
    
  </div></div></body></html>