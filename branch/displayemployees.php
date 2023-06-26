<?php
session_start();
require_once "../connection.php";
?>
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
                    height :auto; 
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
  <?php include '../header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>branch manager</h3>
    <a href="../managerdashboard.php">Home</a>
    <a href="../managerleave.php">leave</a>
    <a href="../managerattendance.php">attendance</a>
    <a href="../managerdetails.php">details</a>
    <a href="addbranchemployee.php">add branch employees</a>
    <a class="active"href="displayemployees.php">view branch employees</a>
    <a href="displaysalaryemployee.php">view employee salary</a>
    <a href="aprovebranchleave.php">aprove branch leave</a>
  </div>
<div class="rightofsidebar">
   
<div class="container">
<h3>employee informations</h3>
<?php
$sql = "SELECT employee.*, branch.branchname, department.departmentname 
FROM employee 
JOIN branch ON employee.branchID = branch.branchID 
JOIN department ON employee.departmentID = department.departmentID
WHERE employee.branchID IN (SELECT branchID FROM branchmanager WHERE managerID = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['user_type']);
$stmt->execute();
$result = $stmt->get_result();

?>
<table id="employeeTable">

    <tr>
        <th>Employee ID</th>
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Last Name</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>State</th>
        <th>City</th>
        <th>Street</th>
        <th>Primary Phone</th>
        <th>Secondary Phone</th>
        <th>Date of Join</th>
        <th>Education Status</th>
        <th>Email</th>
        <th>Employment Status</th>
        <th>Yearly Vacation Days</th>
        <th>Base Salary</th>
        <th>Branch</th>
        <th>Department</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr data-employee-id="<?= $row['employeeID'] ?>">
        <td><?= $row['employeeID'] ?></td>
        <td><?= $row['firstname'] ?></td>
        <td><?= $row['middlename'] ?></td>
        <td><?= $row['lastname'] ?></td>
        <td><?= $row['dateofbirth'] ?></td>
        <td><?= $row['gender'] ?></td>
        <td><?= $row['state'] ?></td>
        <td><?= $row['city'] ?></td>
        <td><?= $row['street'] ?></td>
        <td><?= $row['primary_phone'] ?></td>
        <td><?= $row['secondary_phone'] ?></td>
        <td><?= $row['dateofjoin'] ?></td>
        <td><?= $row['education_status'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['employment_status'] ?></td>
        <td><?= $row['yearlyvacationdays'] ?></td>
        <td><?= $row['basesalary'] ?></td>
        <td><?= $row['branchname'] ?></td>
        <td><?= $row['departmentname'] ?></td>
        <td><button onclick="editRow(this)">Edit</button></td>
        <td><button onclick="deleteRow(this)">Delete</button></td>
        </tr>
<?php endwhile; ?>
</table>

<script>
function editRow(button) {
    let row = button.parentNode.parentNode;
    let cells = row.querySelectorAll("td:not(:last-child):not(:nth-last-child(2))");
    cells.forEach(cell => {
        let input = document.createElement("input");
        input.type = "text";
        input.value = cell.textContent;
        cell.textContent = "";
        cell.appendChild(input);
    });
    button.textContent = "Save";
    button.onclick = saveRow;
}

function saveRow(button) {
    let row = button.parentNode.parentNode;
    let inputs = row.querySelectorAll("input");
    
    // Get employee data from inputs
    let employeeID = row.querySelector("td:first-child").textContent;
    let firstname = inputs[0].value;
    let middlename = inputs[1].value;
    let lastname = inputs[2].value;
    let dateofbirth = inputs[3].value;
    let gender = inputs[4].value;
    let state = inputs[5].value;
    let city = inputs[6].value;
    let street = inputs[7].value;
    let primary_phone = inputs[8].value;
    let secondary_phone = inputs[9].value;
    let dateofjoin = inputs[10].value;
    let education_status = inputs[11].value;
    let email = inputs[12].value;
    let employment_status = inputs[13].value;
    let yearlyvacationdays = inputs[14].value;
    let basesalary = inputs[15].value;

    
// Send employee data to server to update it
let xhr=new XMLHttpRequest();
xhr.open("POST","update_employee.php");
xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

xhr.onloadend=function(){
if(xhr.status==200){
alert(xhr.responseText);
}
else{
alert('An error occurred while updating the employee');
}
}
xhr.send(`employeeID=${employeeID}&firstname=${firstname}&middlename=${middlename}&lastname=${lastname}&dateofbirth=${dateofbirth}&gender=${gender}&state=${state}&city=${city}&street=${street}&primary_phone=${primary_phone}&secondary_phone=${secondary_phone}&dateofjoin=${dateofjoin}&education_status=${education_status}&email=${email}&employment_status=${employment_status}&yearlyvacationdays=${yearlyvacationdays}&basesalary=${basesalary}`);
    
inputs.forEach(input => {
let cell=input.parentNode;
cell.textContent=input.value;
cell.removeChild(input);
});
button.textContent="Edit";
button.onclick=editRow;
}


function deleteRow(button) {
let row=button.parentNode.parentNode;

// Get employee ID from row
let employeeID=row.getAttribute('data-employee-id');

// Check for constraints and delete constraints row that contains the employee's ID before deleting the employee row
let xhr=new XMLHttpRequest();
xhr.open("POST","delete_employee.php");
xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

xhr.onloadend=function(){
if(xhr.status==200){
alert(xhr.responseText);
row.parentNode.removeChild(row);
}
else{
alert('An error occurred while deleting the employee');
}
}
xhr.send(`employeeID=${employeeID}`);
}
</script>

</div></div></body></html>