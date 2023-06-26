<?php
// update_employee.php
if (isset($_POST['employeeID'])) {
    $employeeID = $_POST['employeeID'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $dateofbirth = $_POST['dateofbirth'];
    $gender = $_POST['gender'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $primary_phone = $_POST['primary_phone'];
    $secondary_phone = $_POST['secondary_phone'];
    $dateofjoin = $_POST['dateofjoin'];
    $education_status = $_POST['education_status'];
    $email = $_POST['email'];
    $employment_status = $_POST['employment_status'];
    $yearlyvacationdays = $_POST['yearlyvacationdays'];
    $basesalary = $_POST['basesalary'];

    // Assuming you have a database connection established
    try {
        $sql = "UPDATE employee SET firstname='$firstname', middlename='$middlename', lastname='$lastname', dateofbirth='$dateofbirth', gender='$gender', state='$state', city='$city', street='$street', primary_phone='$primary_phone', secondary_phone='$secondary_phone', dateofjoin='$dateofjoin', education_status='$education_status', email='$email', employment_status='$employment_status', yearlyvacationdays=$yearlyvacationdays, basesalary=$basesalary WHERE employeeID=$employeeID";
        if ($conn->query($sql) === TRUE) {
            echo "Employee updated successfully";
        } else {
            if ($conn->errno === 1452) {
                echo "Foreign key constraint error";
            } else {
                echo "Error updating employee: " . htmlspecialchars($conn->error);
            }
        }
    } catch (Exception $e) {
        echo "Error updating employee: " . htmlspecialchars($e->getMessage());
    }
    $conn->close();
}
?>

<script>
function saveRow(button) {
let row=button.parentNode.parentNode;
let inputs=row.querySelectorAll("input");

// Get employee data from inputs
let employeeID=row.querySelector("td:first-child").textContent;
let firstname=inputs[0].value;
let middlename=inputs[1].value;
let lastname=inputs[2].value;
let dateofbirth=inputs[3].value;
let gender=inputs[4].value;
let state=inputs[5].value;
let city=inputs[6].value;
let street=inputs[7].value;
let primary_phone=inputs[8].value;
let secondary_phone=inputs[9].value;
let dateofjoin=inputs[10].value;
let education_status=inputs[11].value;
let email=inputs[12].value;
let employment_status=inputs[13].value;
let yearlyvacationdays=inputs[14].value;
let basesalary=inputs[15].value;

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
</script>