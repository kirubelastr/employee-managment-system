
<?php
require_once "connection.php";
// Create a new manager
function createManager($managerID, $firstname, $middlename, $lastname, $dateofbirth, $gender, $address, $primary_phone, $secondary_phone, $dateofjoin, $education_status, $manager_photo, $email, $managerfile, $yearlyvacationdays, $basesalary, $userID, $departmentID, $positionID) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO manager (managerID, firstname, middlename, lastname, dateofbirth, gender, address, primary_phone, secondary_phone, dateofjoin, education_status, manager_photo, email, managerfile, yearlyvacationdays, basesalary, userID, departmentID, positionID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssssbidiii", $managerID, $firstname, $middlename, $lastname, $dateofbirth, $gender, $address, $primary_phone, $secondary_phone, $dateofjoin,$education_status,$manager_photo,$email,$managerfile,$yearlyvacationdays,$basesalary,$userID,$departmentID,$positionID);
    if ($stmt->execute() === TRUE) {
        echo "New manager created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Read all managers
function readManagers() {
    global $conn;
    $sql = "SELECT * FROM manager";
    if ($result = mysqli_query($conn,$sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Manager ID: " . htmlspecialchars($row["managerID"]) . "<br>";
            echo "First Name: " . htmlspecialchars($row["firstname"]) . "<br>";
            echo "Middle Name: " . htmlspecialchars($row["middlename"]) . "<br>";
            echo "Last Name: " . htmlspecialchars($row["lastname"]) . "<br>";
            // ...
        }
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Update a manager
function updateManager($managerID,$column_name,$new_value){
    global$conn;
    if ($column_name == 'manager_photo' ||$column_name == 'managerfile'){
        //update blob data
        if ($stmt = mysqli_prepare($conn,"UPDATE manager SET ".$column_name."=? WHERE managerID=?")){
            mysqli_stmt_bind_param($stmt,'bs',$new_value,$managerID);
            if (mysqli_stmt_execute($stmt)){
                echo"Manager updated successfully";
            }else{
                echo"Error:".mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        }else{
            echo"Error:".mysqli_error($conn);
        }
    }else{
        //update other data
        if ($stmt = mysqli_prepare($conn,"UPDATE manager SET ".$column_name."=? WHERE managerID=?")){
            mysqli_stmt_bind_param($stmt,'ss',$new_value,$managerID);
            if (mysqli_stmt_execute($stmt)){
                echo"Manager updated successfully";
            }else{
                echo"Error:".mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        }else{
            echo"Error:".mysqli_error($conn);
        }
    }
}

// Delete a manager
function deleteManager($managerID) {
    global$conn;
    if ($stmt = mysqli_prepare($conn,"DELETE FROM manager WHERE managerID=?")){
        mysqli_stmt_bind_param($stmt,'s',$managerID);
        if (mysqli_stmt_execute($stmt)){
            echo"Manager deleted successfully";
        }else{
            echo"Error:".mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }else{
        echo"Error:".mysqli_error($conn);
    }
}

?>
