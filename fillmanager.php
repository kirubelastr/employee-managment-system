<?php

if (empty($_POST['firstname']) || empty($_POST['middlename']) || empty($_POST['lastname']) || empty($_POST['dateofbirth']) || empty($_POST['gender']) || empty($_POST['address']) || empty($_POST['phonep']) ||empty($_POST['yearlyvacationdays']) || empty($_POST['salary'])||  empty($_POST['phones']) || empty($_POST['hiredate']) || empty($_POST['educationstatus']) || empty($_FILES['photo']) || empty($_POST['email']) || empty($_FILES['file']) || empty($_POST['department']) || empty($_POST['position'])) {
    // One or more inputs are empty
    echo '<script>
    alert("One or more inputs are empty. Please fill in all required fields.");
    window.location.href = "manager.php";
    </script>';
} else {
    // All inputs are not empty
    require_once "connection.php";
    $result = mysqli_query($conn, "SELECT MAX(id) FROM manager");
    $row = mysqli_fetch_row($result);
    $last_id = $row[0];
    $new_value = "M" . $last_id + 1;
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $dateofbirth = $_POST['dateofbirth'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phonep = $_POST['phonep'];
    $phones = $_POST['phones'];
    $hiredate = $_POST['hiredate'];
    $educationstatus = $_POST['educationstatus'];
    $yearlyvacationdays = $_POST['yearlyvacationdays'];
    $basesalary = $_POST['salary'];
    if (isset($_FILES['photo'])) {
        $photo = $_FILES['photo']['name'];
        $photo_contents = file_get_contents($_FILES['photo']['tmp_name']);
        $photo_contents = mysqli_real_escape_string($conn, $photo_contents);
        // ...
    
    }
    $email = $_POST['email'];
    if (isset($_FILES['file'])) {
        
        $file = $_FILES['file']['name'];
        // ...
            $file_contents = file_get_contents($_FILES['file']['tmp_name']);
            $file_contents = mysqli_real_escape_string($conn, $file_contents);
            // ...
        
    }
    $departmentID = $_POST['department'];
    $positionID = $_POST['position'];

    $sql = "INSERT INTO `manager`(`managerID`,`firstname`, `middlename`, `lastname`, `dateofbirth`, `gender`, `address`, `primary_phone`, `secondary_phone`, `dateofjoin`, `education_status`, `manager_photo`, `email`,`managerfile`,`yearlyvacationdays`,`basesalary`, `departmentID`,  `positionID`) 
        VALUES ('$new_value', '$firstname', '$middlename', '$lastname', '$dateofbirth', '$gender', '$address', '$phonep', '$phones', '$hiredate', '$educationstatus', '$photo_contents', '$email',  '$file_contents', '$yearlyvacationdays', '$basesalary', '$departmentID', '$positionID')";
    
    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        echo '<script>
        alert("data inserted suucessfully.");
        </script>';
        $conn->close();
        echo '<script>
        window.location.href = "manager.php";
        </script>'; 
    } else {
        // Error inserting data
        echo '<script>
        alert("error inserting the data.");
        </script>';
        $conn->close();
        echo '<script>
        window.location.href = "manager.php";
        </script>';
    }
}
?>
