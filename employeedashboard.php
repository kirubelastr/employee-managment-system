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
  min-height: 100%;
  height: auto;
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

.form-container {
  flex: 1;
  padding: 20px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: stretch;
}
.vacation-days {
    position: relative;
    top: 0;
    left: 0;
    padding: 10px;
    background-color: lightblue;
    border-radius: 5px;
    font-size: 18px;
    font-weight: bold;
  }
  </style>
</head>
<body>

<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
<div class="sidebar">
    <h3>employee</h3>
    <a class="active"href="employeedashboard.php">Home</a>
    <a href="employeeleave.php">leave</a>
    <a href="employeeattendance.php">attendance</a>
    <a href="employeedetails.php">details</a>
  </div>
 
  <div class="form-container">
  <?php
  require_once "connection.php";
  $userID = $_SESSION['user_type']; // assuming the logged-in user's ID is stored in a session variable

// Select the yearly vacation days for the user
$sql = "SELECT yearlyvacationdays FROM employee WHERE employee = '$userID'";
$query = $conn->query($sql);
$row = $query->fetch_assoc();
$yearlyVacationDays = $row['yearlyvacationdays'];

// Get the salary data for the manager
$salary_data = array();
$salary_query = "SELECT * FROM salary WHERE employeeID = '$userID' ORDER BY datefrom ASC";
$salary_result = $conn->query($salary_query);
if ($salary_result->num_rows > 0) {
    while($salary_row = $salary_result->fetch_assoc()) {
        $datefrom = new DateTime($salary_row['datefrom']);
        $month_year = $datefrom->format('M Y');
        $net_salary = $salary_row['net'];
        $salary_data[$month_year] = $net_salary;
    }
}

// Display the salary graph for the manager
echo "<h2>Salary Graph for employee with ID: " .$userID. "</h2>";
echo "<div id='chart_div'></div>";

// Load the Google Charts API
echo '<script type="text/javascript" src="javascript/loader.js"></script>';

// Generate the JavaScript code to display the salary graph
echo '<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ["Month/Year", "Net Salary"],';
foreach ($salary_data as $month_year => $net_salary) {
    echo '["' .$month_year. '", ' .$net_salary. '],';
}
echo ']);
    var options = {
        title: "Salary Graph",
        hAxis: {title: "Month/Year"},
        vAxis: {title: "Net Salary"},
        legend: {position: "none"}
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
    chart.draw(data, options);
}
</script>';
?>

  <h1>Dashboard</h1>
  <?php
  require_once "connection.php";
  $userID = $_SESSION['user_type']; // assuming the logged-in user's ID is stored in a session variable

  // Get the current year
  $year = date('Y');

  // Select the attendance data for the current year and user
  $sql = "SELECT *, MONTH(logdate) AS month FROM attendance WHERE employeeID = '$userID' AND YEAR(logdate) = '$year'";
  $query = $conn->query($sql);

  // Create arrays for storing the time in and time out data
  $timeInData = [];
  $timeOutData = [];
  $labels = [];

  while($row = $query->fetch_assoc()){
    // Add the time in and time out data to the arrays
    $timeInData[$row['month']][] = strtotime($row['timein']);
    $timeOutData[$row['month']][] = strtotime($row['timeout']);
    $labels[$row['month']] = date('F', mktime(0, 0, 0, $row['month'], 10));
  }

  // Calculate the average time in and time out for each month
  foreach ($timeInData as $month => $times) {
    $timeInData[$month] = array_sum($times) / count($times);
    $timeOutData[$month] = array_sum($timeOutData[$month]) / count($timeOutData[$month]);
  }

  // Format the data for display on the chart
  foreach ($timeInData as &$time) {
    $time = date('H:i', $time);
  }
  foreach ($timeOutData as &$time) {
    $time = date('H:i', $time);
  }

  $conn->close();
?>

<!-- Use the data retrieved from the database to create the line graph using Chart.js -->

<div class="graph">
<div class="vacation-days">
Yearly Vacation Days: <?php echo $yearlyVacationDays; ?>
</div>
  <h2>Average Employee Attendance</h2>
  <canvas id="average-attendance-chart"></canvas>
 
</div>
<div class="container">
<script src="javascript/chart.js"></script>
<script>
  const timeInData = <?php echo json_encode(array_values($timeInData)); ?>;
  const timeOutData = <?php echo json_encode(array_values($timeOutData)); ?>;
  const labels = <?php echo json_encode(array_values($labels)); ?>;

  const ctx = document.getElementById('average-attendance-chart').getContext('2d');
  const attendanceChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Average Time In',
        data: timeInData,
        borderColor: 'blue',
        fill: false
      }, {
        label: 'Average Time Out',
        data: timeOutData,
        borderColor: 'green',
        fill: false
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Average Employee Attendance'
      },
      scales: {
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Month'
          }
        }],
        yAxes: [{
          type: 'time',
          time: {
            displayFormats: {
              hour: 'HH:mm'
            }
          },
          scaleLabel: {
            display: true,
            labelString: 'Time'
          }
        }]
      }
    }
  });
</script>
</div>
</div>
    </div>

  </div>
</div>
</body>
</html>
