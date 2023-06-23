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
            $stmt = $conn->prepare("INSERT INTO qrcode (employeeID, qrimage) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "is", intval($id), $qrCode);
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
        mysqli_stmt_bind_param($stmt, "ss", strval($id), $qrCode);
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

// Search for a specific employee/manager ID and display the corresponding QR code in a popup when clicked
if (isset($_POST["searchType"]) && isset($_POST["searchID"])) {
    // Get search type and ID from form data
    $searchType = $_POST["searchType"];
    $searchID = $_POST["searchID"];

    // Search for the specified ID in the qrcodes array
    foreach ($qrcodes as &$qrcode) {
        if (($searchType == "employee" && isset($qrcode["employeeID"]) && strval($qrcode["employeeID"]) == strval($searchID)) ||
            ($searchType == "manager" && isset($qrcode["managerID"]) && strval($qrcode["managerID"]) == strval($searchID))) {
            // Display the corresponding QR code in a popup when clicked
            echo '<img src="data:image/png;base64,' . htmlspecialchars($qrcode["qrimage"]) . '" onclick="showQRCode(this)"/>';
            // Display a print button
            echo '<button onclick="printQRCode(this)">Print</button>';
            break;
        }
    }
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
        }

        function printQRCode(button) {
            var img = button.previousSibling;
            var printWindow = window.open("", "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
            printWindow.document.write(img.outerHTML);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
</head>
<body>
    <!-- Search form -->
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
