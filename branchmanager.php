
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
 min-width: 600px;
 max-width: 600px;
 height: auto;
 margin: 10px;
 padding: 20px;
 background-color: #fff;
 box-shadow: 0 0 10px rgba(0,0,0,0.2);
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
form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: 0 auto;
  }
  label {
    font-weight: bold;
    margin-top: 10px;
  }
  input,
  select {
    padding: 5px;
    margin-bottom: 10px;
  }
  button {
    margin-top: 10px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
  }
       </style>
</head>
<body>
    
<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>admin</h3>
    <a href="department_and_position.php">department and position</a>
    <a href="aproveleave.php">aprove leave</a>
    <a href="createusers.php">createusers</a>
    <a href="employee.php">add employee</a>
    <a href="manager.php">add manage</a>
    <a href="deductionandallowance.php">deduction and allowance</a>
    <a href="adddeductionandallowance.php">add deduction and allowance</a>
    <a href="qrcode.php">qrcode</a>
    <a class="active" href="branchmanager.php">branch</a>
    <a href="everymonth.php">salary</a>
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
</select><br>
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
</select><br>
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