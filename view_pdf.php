<?php
require_once "connection.php";

// Get the manager ID from the query string
$managerID = $_GET["managerID"];

// Retrieve the manager's PDF file from the database
$sql = "SELECT managerfile FROM manager WHERE managerID = '$managerID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pdf_content = $row["managerfile"];

    // Set the response headers for PDF display or download
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="file.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    echo base64_decode($pdf_content);
} else {
    echo "No results found.";
}

// Close database connection
$conn->close();
?>