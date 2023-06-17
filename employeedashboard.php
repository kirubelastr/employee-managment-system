<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  border-left-color: green;
}
.rightofsidebar{
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: baseline;
}
    .section {
      margin: 20px 0;
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 1s ease-in-out, transform 1s ease-in-out;
    }
    .section.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .section h2 {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
<div class="sidebar">
    <h3>Sidebar</h3>
    <a class="active"href="employeedashboard.php">Home</a>
    <a href="employeeleave.php">leave</a>
    <a href="employeeattendance.php">attendance</a>
    <a href="employeedetails.php">details</a>
  </div>
 
  <h1>Dashboard</h1>
  <?php
// Connect to the database
require_once "connection.php";

// Retrieve attendance data from the database
$query = "SELECT logdate, COUNT(*) as count FROM attendance GROUP BY logdate";
$result = mysqli_query($conn, $query);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
  // Initialize data arrays
  $attendanceLabels = [];
  $attendanceData = [];

  // Populate data arrays
  while ($row = mysqli_fetch_assoc($result)) {
    $attendanceLabels[] = $row["logdate"];
    $attendanceData[] = $row["count"];
  }
} else {
  // No rows returned
  echo "No attendance data found";
}

// Retrieve department data from the database
$query = "SELECT departmentname, COUNT(*) as count FROM employee JOIN department ON employee.departmentID = department.departmentID GROUP BY departmentname";
$result = mysqli_query($conn, $query);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
  // Initialize data arrays
  $departmentLabels = [];
  $departmentData = [];

  // Populate data arrays
  while ($row = mysqli_fetch_assoc($result)) {
    $departmentLabels[] = $row["departmentname"];
    $departmentData[] = $row["count"];
  }
} else {
  // No rows returned
  echo "No department data found";
}
?>
  <!-- Attendance section -->
  <div class="section" id="attendanceSection">
    <h2>Attendance</h2>
    <canvas id="attendanceChart"></canvas>
  </div>

  <!-- Department section -->
  <div class="section" id="departmentSection">
    <h2>Departments</h2>
    <canvas id="departmentChart"></canvas>
  </div>

  <script>
    // Attendance data
    var attendanceData = {
      labels: <?php echo json_encode($attendanceLabels); ?>,
      datasets: [{
        label: "Attendance",
        data: <?php echo json_encode($attendanceData); ?>,
        backgroundColor: "rgba(54,162,235,0.2)",
        borderColor: "rgba(54,162,235,1)",
        borderWidth: 1
      }]
    };

    // Attendance options
    var attendanceOptions = {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    };

    // Create attendance chart
    var ctx = document.getElementById("attendanceChart").getContext("2d");
    var attendanceChart = new Chart(ctx, {
      type: "bar",
      data: attendanceData,
      options: attendanceOptions
    });

    // Department data
    var departmentData = {
      labels: <?php echo json_encode($departmentLabels); ?>,
      datasets: [{
        label: "Employees",
        data: <?php echo json_encode($departmentData); ?>,
        backgroundColor: [
          "rgba(255,99,132,0.2)",
          "rgba(54,162,235,0.2)",
          "rgba(255,206,86,0.2)",
          "rgba(75,192,192,0.2)",
          "rgba(153,102,255,0.2)",
          "rgba(255,159,64,0.2)"
        ],
        borderColor: [
      "rgba(255,99,132,1)",
      "rgba(54,162,235,1)",
      "rgba(255,206,86,1)",
      "rgba(75,192,192,1)",
      "rgba(153,102,255,1)",
      "rgba(255,159,64,1)"
    ],
    borderWidth: 1
    }]
    };

    // Department options
    var departmentOptions = {
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Employees by Department'
        }
      }
    };

    // Create department chart
    var ctx = document.getElementById("departmentChart").getContext("2d");
    var departmentChart = new Chart(ctx, {
      type: "pie",
      data: departmentData,
      options: departmentOptions
    });

    // Animate sections on scroll
    window.addEventListener("scroll", function() {
      var sections = document.querySelectorAll(".section");
      sections.forEach(function(section) {
        var sectionTop = section.offsetTop;
        var sectionHeight = section.offsetHeight;
        var windowTop = window.pageYOffset;
        var windowHeight = window.innerHeight;
        if (windowTop + windowHeight > sectionTop + sectionHeight / 2) {
          section.classList.add("visible");
        }
      });
    });
</script>
  </div>
</div>
</body>
</html>
