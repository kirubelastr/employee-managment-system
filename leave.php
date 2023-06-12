
<!DOCTYPE html>
<html>
<head>
  <title>leave</title>
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
form {
  width: 300px;
  margin: 0 auto;
}
label {
display: block;
margin-bottom: 5px;
 }
input[type="text"], select {
width: 100%;
padding: 5px;
margin-bottom: 10px;
}
input[type="submit"] {
padding: 5px 10px;
background-color: #4CAF50;
color: white;
border: none;
cursor: pointer;
}
  </style>
</head>
<body>

  <div class="sidebar">
    <h3>Sidebar</h3>
    <a href="#home">Home</a>
    <a class="active"href="#leave">leave</a>
    <a href="#attendance">attendance</a>
    <a href="#details">details</a>
  </div>
<div>
   <h1>Leave Request Form</h1>
   <form action="submit_leave_request.php" method="post">
        <label for="userType">Are you a manager or an employee?</label>
        <select id="userType" name="userType" required>
            <option value="">--Please choose an option--</option>
            <option value="manager">Manager</option>
            <option value="employee">Employee</option>
        </select>

        <label for="userID">Your ID:</label>
        <input type="text" id="userID" name="userID" required>

        <label for="leavetype">Leave Type:</label>
        <select id="leavetype" name="leavetype" required>
            <option value="">--Please choose an option--</option>
            <option value="sick">Sick Leave</option>
            <option value="vacation">Vacation Leave</option>
            <option value="personal">Personal Leave</option>
        </select>

        <label for="startdate">Start Date:</label>
        <input type="date" id="startdate" name="startdate" required>

        <label for="enddate">End Date:</label>
        <input type="date" id="enddate" name="enddate" required>

        <input type="submit" value="Submit">
    </form>
]

</div>

</body>
</html>