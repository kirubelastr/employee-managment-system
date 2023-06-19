<?php
if (empty($_POST['firstname']) || empty($_POST['middlename']) || empty($_POST['yearlyvacationdays']) || empty($_POST['salary'])|| empty($_POST['lastname']) || empty($_POST['dateofbirth']) || empty($_POST['gender']) || empty($_POST['address']) || empty($_POST['phonep']) || empty($_POST['phones']) || empty($_POST['hiredate']) || empty($_POST['educationstatus']) || empty($_FILES['photo']) || empty($_POST['email']) || empty($_POST['employmentstatus']) || empty($_FILES['file']) || empty($_POST['department']) || empty($_POST['position'])) {
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
    $branchID = $_POST['branchID'];
    $departmentID = $_POST['department'];
    $positionID = $_POST['position'];
    $sql = "INSERT INTO `employee`(`firstname`, `middlename`, `lastname`, `dateofbirth`, `gender`, `address`, `primary_phone`, `secondary_phone`, `dateofjoin`, `education_status`, `employee_photo`, `email`,`employment_status`,`employeefile`, `yearlyvacationdays`,`basesalary`, `branchID`,`departmentID`,  `positionID`) 
        VALUES ( '$firstname', '$middlename', '$lastname', '$dateofbirth', '$gender', '$address', '$phonep', '$phones', '$hiredate', '$educationstatus', '$photo_contents', '$email', '$employmentstatus', '$file_contents', '$yearlyvacationdays', '$basesalary','$branchID',  '$departmentID', '$positionID')";
    $conn->query($sql);

    // Check if data was inserted successfully
    if ($conn->affected_rows > 0 && $conn->query($sql) === TRUE) {
        // Data inserted successfully
            // Data inserted successfully
            $employeeID = $conn->insert_id;

            // Calculate tax rate and deduction amount based on base salary
            if ($basesalary <= 600) {
                $taxRate = 0;
                $dAmount = 0;
            } elseif ($basesalary <= 1650) {
                $taxRate = 0.1;
                $dAmount = $basesalary * 0.1;
            } elseif ($basesalary <= 3200) {
                $taxRate = 0.15;
                $dAmount = $basesalary * 0.15;
            } elseif ($basesalary <= 5250) {
                $taxRate = 0.2;
                $dAmount = $basesalary * 0.2;
            } elseif ($basesalary <= 7800) {
                $taxRate = 0.25;
                $dAmount = $basesalary * 0.25;
            } elseif ($basesalary <= 10900) {
                $taxRate = 0.3;
                $dAmount = $basesalary * 0.3;
            } else {
                $taxRate = 0.35;
                $dAmount = $basesalary * 0.35;
            }
        
            // Calculate employee pension
            $employeePension = 0.07;
            $ePension =$basesalary * 0.07;
            $deductionAmount=$ePension+$dAmount;
            // Insert data into deduction table
            $sql = "INSERT INTO deduction (employeeID, taxRate, deductionAmount, Pension,deductionType)
            VALUES ($employeeID, $taxRate, $deductionAmount, $employeePension,'pension and tax')";
            $conn->query($sql);
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