<?php
// Assuming you have a database connection established
$sql = "SELECT manager.*, branch.branchname, department.departmentname FROM manager JOIN branch ON manager.branchID = branch.branchID JOIN department ON manager.departmentID = department.departmentID";
$result = $conn->query($sql);
?>
<table id="managerTable">
    <tr>
        <th>Manager ID</th>
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
        <th>Yearly Vacation Days</th>
        <th>Base Salary</th>
        <th>Branch</th>
        <th>Department</th>
        <th>Edit</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['managerID'] ?></td>
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
<td><?= $row['yearlyvacationdays'] ?></td>
<td><?= $row['basesalary'] ?></td>
<td><?= $row['branchname'] ?></td>
<td><?= $row['departmentname'] ?></td>
<td><button onclick="editManagerRow(this)">Edit</button></td>
</tr>
<?php endwhile; ?>
</table>

<script>
function editManagerRow(button) {
    let row = button.parentNode.parentNode;
    let cells = row.querySelectorAll("td:not(:last-child)");
    cells.forEach(cell => {
        let input = document.createElement("input");
        input.type = "text";
        input.value = cell.textContent;
        cell.textContent = "";
        cell.appendChild(input);
    });
    button.textContent = "Save";
    button.onclick = saveManagerRow;
}

function saveManagerRow(button) {
    let row = button.parentNode.parentNode;
    let inputs = row.querySelectorAll("input");
    
    // Get manager data from inputs
    let managerID = row.querySelector("td:first-child").textContent;
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
    let yearlyvacationdays = inputs[13].value;
    let basesalary = inputs[14].value;

    
// Send manager data to server to update it
let xhr=new XMLHttpRequest();
xhr.open("POST","update_manager.php");
xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

xhr.onloadend=function(){
if(xhr.status==200){
alert(xhr.responseText);
}
else{
alert('An error occurred while updating the manager');
}
}
xhr.send(`managerID=${managerID}&firstname=${firstname}&middlename=${middlename}&lastname=${lastname}&dateofbirth=${dateofbirth}&gender=${gender}&state=${state}&city=${city}&street=${street}&primary_phone=${primary_phone}&secondary_phone=${secondary_phone}&dateofjoin=${dateofjoin}&education_status=${education_status}&email=${email}&yearlyvacationdays=${yearlyvacationdays}&basesalary=${basesalary}`);

inputs.forEach(input => {
let cell=input.parentNode;
cell.textContent=input.value;
cell.removeChild(input);
});
button.textContent="Edit";
button.onclick=editManagerRow;
}
</script>
