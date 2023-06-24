<?php
include('phpqrcode/qrlib.php');
require_once "connection.php";

// Query employees and managers
$result = $conn->query("SELECT employeeID FROM employee ");

while ($row = $result->fetch_assoc()) {
    $id = $row["employeeID"];

    // Check if employee/manager exists
    if (isset($row["employeeID"])) {
        $stmt = $conn->prepare("SELECT * FROM employee WHERE employeeID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows == 0) {
            continue;
        }
    } 

    // Check if QR code already exists
    if (isset($row["employeeID"])) {
        $stmt = $conn->prepare("SELECT * FROM qrcode WHERE employeeID = ?");
        $stmt->bind_param("s", $id);
    } 
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        // Generate QR code
        ob_start();
        QRcode::png($id, null, QR_ECLEVEL_L, 10);
        $qrCode = ob_get_contents();
        ob_end_clean();

        // Insert into qrcode table
        if (isset($row["employeeID"])) {
            // employeeID is an integer
            $employeeID = intval($id);
            $stmt = $conn->prepare("INSERT INTO qrcode (employeeID, qrimage) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "is", $employeeID, $qrCode);
            mysqli_stmt_execute($stmt);
        }
    }
}

$result = $conn->query("SELECT managerID FROM manager");

while ($row = $result->fetch_assoc()) {
    $id = $row["managerID"];

    // Check if manager exists
    $stmt = $conn->prepare("SELECT * FROM manager WHERE managerID = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        continue;
    }

    // Check if QR code already exists
    $stmt = $conn->prepare("SELECT * FROM qrcode WHERE managerID = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        // Generate QR code
        ob_start();
        QRcode::png($id, null, QR_ECLEVEL_L, 10);
        $qrCode = ob_get_contents();
        ob_end_clean();

        // Insert into qrcode table
        $stmt = $conn->prepare("INSERT INTO qrcode (managerID, qrimage) VALUES (?, ?)");
        $stmt->bind_param("ss", $id, $qrCode);
        mysqli_stmt_execute($stmt);
    }
}
// Store all data from the qrcode table in an array
$qrcodes = array();
$result = mysqli_query($conn, "SELECT * FROM qrcode");
while ($row = mysqli_fetch_assoc($result)) {
    array_push($qrcodes, array(
        "id" => ($row["employeeID"] ??$row["managerID"]),
        "qrimage" => base64_encode($row["qrimage"])
    ));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>QR Codes</title>
    <script>
        function showQRCode(img) {
            
            var printWindow = window.open("", "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
            printWindow.document.write(img.outerHTML);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
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
    <h3>admin</h3>
    <a href="department_and_position.php">department and position</a>
    <a href="aproveleave.php">aprove leave</a>
    <a href="createusers.php">createusers</a>
    <a href="employee.php">add employee</a>
    <a href="manager.php">add manage</a>
    <a href="deductionandallowance.php">deduction and allowance</a>
    <a href="adddeductionandallowance.php">add deduction and allowance</a>
    <a class="active" href="qrcode.php">qrcode</a>
    <a href="branchmanager.php">branch</a>
    <a href="everymonth.php">salary</a>
  </div>
  <div class="rightofsidebar">
<div class="container">
<style>
    /* Hide the image container initially */
    #qr-image-container {
        display: none;
    }
</style>

<form method="post">
    <label for="searchType">Search Type:</label>
    <select name="searchType" id="searchType">
        <option value="employee">Employee</option>
        <option value="manager">Manager</option>
    </select><br><br>
    <label for="searchID">ID:</label>
    <input type="text" name="searchID" id="searchID"><br><br>
    <input type="submit" value="Search">
</form>

<!-- Container for the searched image -->
<div id="qr-image-container">
    <img id="qr-image" onclick="showQRCode(this)">
</div>

<?php
if (isset($_POST["searchType"]) && isset($_POST["searchID"])) {
    $searchType = $_POST["searchType"];
    $searchID = $_POST["searchID"];
    require_once "connection.php";
    if ($searchType=="employee"){
        $query="select qrimage FROM qrcode where employeeID= ?";
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);
        // Bind the searchID parameter
        mysqli_stmt_bind_param($stmt, "s", $searchID);
        // Execute the statement
        mysqli_stmt_execute($stmt);
        // Fetch the result
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $qrimage = $row['qrimage'];
            $img = '<img src="data:image/png;base64,' . htmlspecialchars($qrimage) . '">';
            // Show the image in the container
            echo '<script>showQRImage(' . $img . ');</script>';
        } else {
            // Alert message if no data is found
            echo '<script>alert("No data found.");</script>';
        }
    } else if ($searchType=="manager"){
        $query="select qrimage FROM qrcode where managerID= ?";
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);
        // Bind the searchID parameter
        mysqli_stmt_bind_param($stmt, "s", $searchID);
        // Execute the statement
        mysqli_stmt_execute($stmt);
        // Fetch the result
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $qrimage = $row['qrimage'];
            $img = '<img src="data:image/png;base64,' . htmlspecialchars($qrimage) . '">';
            // Show the image in the container
            echo '<script>showQRImage(' . $img . ');</script>';
        } else {
            // Alert message if no data is found
            echo '<script>alert("No data found.");</script>';
        }
    }
}
?>

<!-- JavaScript function to show the image in the container -->
<script>
    function showQRImage(img) {
        // Display the container
        document.getElementById('qr-image-container').style.display = 'block';
        // Set the image source
        document.getElementById('qr-image').src = img.src;
    }
</script>

    <!-- QR code images section -->
    <div class="qr-images-container">
        <!-- Display all QR codes from the qrcodes array in a table with their employee/manager ID -->
        <table>
            <tr><th>ID</th><th>QR Code</th></tr>
            <?php
            foreach ($qrcodes as &$qrcode) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($qrcode["id"]) . "</td>";
                echo '<td><img src="data:image/png;base64,' . htmlspecialchars($qrcode["qrimage"]) . '" onclick="showQRCode(this)"/></td>';
                echo "</tr>";
            }
            ?>
        </table>

        <?php
        // Close database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
