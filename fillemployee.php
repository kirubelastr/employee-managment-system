<?php
if (empty($_POST['firstname']) || empty($_POST['middlename']) || empty($_POST['lastname']) || empty($_POST['dateofbirth']) || empty($_POST['gender']) || empty($_POST['address']) || empty($_POST['phonep']) || empty($_POST['phones']) || empty($_POST['hiredate']) || empty($_POST['educationstatus']) || empty($_FILES['photo']) || empty($_POST['email']) || empty($_POST['employmentstatus']) || empty($_FILES['file']) || empty($_POST['department']) || empty($_POST['position'])) {
    // One or more inputs are empty
    echo '<script>
    alert("One or more inputs are empty. Please fill in all required fields.");
    window.location.href = "manager.php";
</script>';
} else {
    // All inputs are not empty
    require_once "connection.php";
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
    $employmentstatus = $_POST['employmentstatus'];
    if (isset($_FILES['photo'])) {
        $photo = $_FILES['photo']['name'];
        // ...
    }
    $email = $_POST['email'];
    if (isset($_FILES['file'])) {
        $file = $_FILES['file']['name'];
        // ...
    }
    $branchID = $_POST['branchID'];
    $departmentID = $_POST['department'];
    $positionID = $_POST['position'];
    $sql = "INSERT INTO `employee`(`firstname`, `middlename`, `lastname`, `dateofbirth`, `gender`, `address`, `primary_phone`, `secondary_phone`, `dateofjoin`, `education_status`, `employee_photo`, `email`,`employment_status`,`employeefile`,  `branchID`,`departmentID`,  `positionID`) 
        VALUES ('$new_value', '$firstname', '$middlename', '$lastname', '$dateofbirth', '$gender', '$address', '$phonep', '$phones', '$hiredate', '$educationstatus', '$photo', '$email', '$employmentstatus', '$file','$branchID',  '$departmentID', '$positionID')";
    $conn->query($sql);

    // Check if data was inserted successfully
    if ($conn->affected_rows > 0) {
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
