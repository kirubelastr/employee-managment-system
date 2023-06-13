
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

  <div class="sidebar">
    <h3>Sidebar</h3>
    <a href="employeedashboard.php">Home</a>
    <a class="active"href="employeeleave.php">leave</a>
    <a href="employeeattendance.php">attendance</a>
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