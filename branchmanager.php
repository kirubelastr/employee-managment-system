
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
  <?php include 'header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>Sidebar</h3>
    <a href="employeedashboard.php">Home</a>
    <a href="employeeleave.php">leave</a>
    <a class="active"href="employeeattendance.php">attendance</a>
    <a href="employee.php">details</a>
  </div>
<div class="rightofsidebar">
   
</div>
<div class="container">
    <form id="form" action="fillbranchmanager.php" method="post">
        <label for="branchID">Branch ID:</label><br>
        <select id="branchID" name="branchID">
          <?php
require_once "connection.php";

$sql = "SELECT branchID, branchname FROM branch";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $name);
while ($stmt->fetch()) {
    echo "<option value='$id'>$name</option>";
}
?>
</select><br><br>
<label for="managerID">Manager ID:</label><br>
<select id="managerID" name="managerID">
    <?php
    $sql = "SELECT managerID, CONCAT(firstname, ' ', middlename, ' ', lastname) as name FROM manager";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($id, $name);
    while ($stmt->fetch()) {
        echo "<option value='$id'>$name</option>";
    }
    ?>
</select><br><br>
<label for="managertype">Manager Type:</label><br>
<select id="managertype" name="managertype">
    <option value="General Manager">General Manager</option>
    <option value="Regional Manager">Regional Manager</option>
    <option value="Branch Manager">Branch Manager</option>
</select><br><br>
<input type="submit" name="insert" value="Insert">
</form>
</div>
<div class="container">
<!DOCTYPE html>
<html>
<head>
	<title>Delete Records</title>
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
		}
	</style>
</head>
<body>
	<?php
	// Database connection details
	

	// Check if a record was deleted
	if (isset($_GET['delete'])) {
		// Get the values of managerID, branchID, and managertype from the URL
		$managerID = $_GET['managerID'];
		$branchID = $_GET['branchID'];
		$managertype = $_GET['managertype'];

		// Delete the record from the database
		$sql = "DELETE FROM branchmanager WHERE managerID='$managerID' AND branchID='$branchID' AND managertype='$managertype'";
		$result = mysqli_query($conn, $sql);

		// Check if the record was deleted
		if ($result) {
			echo "<p>Record deleted successfully</p>";
		} else {
			echo "<p>Error deleting record: " . mysqli_error($conn) . "</p>";
		}
	}

	// Fetch records from the database
	$sql = "SELECT * FROM branchmanager";
	$result = mysqli_query($conn, $sql);

	// Check if any records were found
	if (mysqli_num_rows($result) > 0) {
		// Display records in a table
		echo "<table>";
		echo "<tr><th>Manager ID</th><th>Branch ID</th><th>Manager Type</th><th>Action</th></tr>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $row['managerID'] . "</td>";
			echo "<td>" . $row['branchID'] . "</td>";
			echo "<td>" . $row['managertype'] . "</td>";
			echo "<td><a href='?delete=1&managerID=" . $row['managerID'] . "&branchID=" . $row['branchID'] . "&managertype=" . $row['managertype'] . "'>Delete</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "<p>No records found</p>";
	}

	// Close database connection
	mysqli_close($conn);
	?>
</body>
</html>
    </div>
    </div>
    </div>
</body>
</html>