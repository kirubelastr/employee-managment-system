
<?php 
include 'connection.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="css/main.min.css" />
    <title>update employee</title>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container">
    <table class="table table-bordered">
  <thead class="thead-dark ">
    <tr>
      <th scope="col">employeeID</th>
      <th scope="col">First Name</th>
      <th scope="col">Middle Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Date of Birth</th>
      <th scope="col">Gender</th>
      <th scope="col">State</th>
      <th scope="col">City</th>
      <th scope="col">Street</th>
      <th scope="col">Primary Phone</th>
      <th scope="col">Secondary Phone</th>
      <th scope="col">Date of Join</th>
      <th scope="col">Education Status</th>
      <th scope="col">Email</th>
      <th scope="col">Employment Status</th>
      <th scope="col">Operation</th>
    </tr>
  </thead>
  <tbody>

  <?php 
  $sql = "Select * from `employee`";
  $result = mysqli_query($conn,$sql);
  if($result){
    while($row=mysqli_fetch_assoc($result)){
        $id = $row['employeeID'];
        $fname = $row['firstname'];
        $mname = $row['middlename'];
        $lname = $row['lastname'];
        $dateofbirth = $row['dateofbirth'];
        $gender = $row['gender'];
        $state = $row['state'];
        $city = $row['city'];
        $street = $row['street'];
        $pphone = $row['primary_phone'];
        $sphone = $row['secondary_phone'];
        $dateofjoin = $row['dateofjoin'];
        $education = $row['education_status'];
        $email = $row['email'];
        $employmet = $row['employment_status'];
        echo'
        <tr>
      <th scope="row">'.$id.'</th>
      <td>'.$fname.'</td>
      <td>'.$mname.'</td>
      <td>'.$lname.'</td>
      <td>'.$dateofbirth.'</td>
      <td>'.$gender.'</td>
      <td>'.$state.'</td>
      <td>'.$city.'</td>
      <td>'.$street.'</td>
      <td>'.$pphone.'</td>
      <td>'.$sphone.'</td>
      <td>'.$dateofjoin.'</td>
      <td>'.$education.'</td>
      <td>'.$email.'</td>
      <td>'.$employmet.'</td>
      <td>
    <button class = "btn btn-primary m-1"><a class = "text-light" href="employeeupdate.php?updateid='.$id.'">update</a></button>
    <button class="btn btn-danger m-1"><a class = "text-light" href="delete.php?deleteid='.$id.'">delete</a></button>
    </td>
    
      </tr>
        ';
    }
  }
  
  ?>
  </tbody>
</table>
<td>
<button><a href=""></a></button>
<button><a href=""></a></button>

</td>


    </div>


</body>
</html>