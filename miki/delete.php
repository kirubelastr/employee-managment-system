<?php 
include 'connection.php';
if (isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];
    $sql="delete from `employee` where employeeID = $id";
    $result=mysqli_query($conn,$sql);
    if ($result){
      header('location: updateemployee.php');
    }else{
        echo "not deleted";
    }

}


?>