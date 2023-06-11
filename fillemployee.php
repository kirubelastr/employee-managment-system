<?php
require_once "connection.php";
$sql = "INSERT INTO `employee`(`firstname`, `middlename`, `lastname`, `dateofbirth`, `gender`, `address`, `primary_phone`, `secondary_phone`, `dateofjoin`, `education_status`, `employee_photo`, `email`, `employment_status`, `employeefile`, `branchID`,  `departmentID`,  `positionID`) 
                       VALUES ('firstname','middlename','lastname','dateofbirth','gender','address','phonep','phones','hiredate','educationstatus','photo','email','employmentstatus','file','branch','departmentID','positionID')";  

         


      
$conn->query($sql);


?>