
<!DOCTYPE html>
<html>
<head>
  <title>employee dashboard</title>
  <style>
   body {
  margin: 0;
  padding: 0;
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
.section {
      margin: 20px 0;
    }
    .section h2 {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h3>Sidebar</h3>
    <a class="active"href="#home">home</a>
    <a href="managerleave.php">leave</a>
    <a href="employeeattendance.php">attendance</a>
    <a href="manager.php">details</a>
  </div>

  <h1>Dashboard</h1>

  <!-- Attendance section -->
  <div class="section">
    <h2>Attendance</h2>
    <canvas id="attendanceChart"></canvas>
  </div>

  <script>
    // Attendance data
    var attendanceData = {
      labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      datasets: [{
        label: "Attendance",
        data: [8, 7, 9, 6, 8],
        backgroundColor: "rgba(54, 162, 235, 0.2)",
        borderColor: "rgba(54, 162, 235, 1)",
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
  </script>


</body>
</html>