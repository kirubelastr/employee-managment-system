<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="javascript/instascan1.min.js"></script>
    <script type="text/javascript" src="javascript/adapter.min.js"></script>
    <script type="text/javascript" src="javascript/vue.min.js"></script>
    <title>QR Code Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .page-container {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: stretch;
            }

        .content-container {
            margin-left: 100px;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: stretch;
            }
        .container {
            
            margin-left: 100px;
            max-width: 800px;
            margin: 0;
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

        #preview {
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        input[type="submit"] {
            margin-left: 200px;
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 1pxsolid greenyellow;
            border-radius: 4px;
            background-color: orange;
        }
        input[type="text"] {
            width: 97%;
            padding: 10px;
            font-size: 16px;
            border: 1pxsolid #ccc;
            border-radius: 4px;
            background-color: #f0f0f0;
        }

        input[readonly] {
            background-color: #ddd;
        }
        .employee-info {
            float: right;
            width: 40%;
            text-align: center;
            margin-top: 0px;
            margin-left: 20px;
            margin-right: 0px;
            padding: 20px;
            border-style: solid;
            border-width: 1px;
            border-color: #000000;
            background-color: #FFFFFF;
         }
         table {
        border-collapse: collapse;
        width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
    <script src="javascript/instascan.min.js"></script>
</head>
<body>
<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
    <div class="container">
        <h3 class="text-center text-dark">QR Code Scanner</h3>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <video id="preview" width="100%"></video>
                <div>
                    <?php
                     if (isset($_SESSION['initialization'])) {
                        echo "
                            <div class='alert alert-exists' style='background:blue;color:black;'>
                                <h3>Exists</h3>
                                " . $_SESSION['initialization'] . "
                            </div>
                        ";
                    }
                        if (isset($_SESSION['error'])) {
                            echo "
                                <div class='alert alert-danger' style='background:red;color:black;'>
                                    <h3>Error</h3>
                                    " . $_SESSION['error'] . "
                                </div>
                            ";
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo "
                                <div class='alert alert-primary' style='background:green;color:white;'>
                                    <h3>Success</h3>
                                    " . $_SESSION['success'] . "
                                </div>
                            ";
                            unset($_SESSION['success']);
                        }
                        if (isset($_SESSION['exceptionexists'])) {
                            echo "
                                <div class='alert alert-exists' style='background:orange;color:black;'>
                                    <h3>Exists</h3>
                                    " . $_SESSION['exceptionexists'] . "
                                </div>
                            ";
                            unset($_SESSION['exceptionexists']);
                        }

                    ?>
                </div>

            </div>   
        </div>   
    </div>   
    <div class='employee-info'>
        <form  action="fillattendance.php" method="post" >
            <label>QR Code Value:</label>
            <input type="text" name="text" id="text" readonly placeholder="scanned qr code" class="form-control">
        </form>
        <table>
            <thead>
            <tr>
                <td>ID</td>
                <td>EMPLOYEE ID</td>
                <td>DATE</td>
                <td>TIMEIN</td>
                <td>TIMEOUT</td>
                <td>SHIFT NO</td>
            </tr>    
            </thead>
         <tbody>
            <?php
            require_once "connection.php";
            $sql = "SELECT * from attendance WHERE employeeID IS NOT NULL  AND logdate=CURDATE()";
            $query = $conn->query($sql);
            while($row = $query->fetch_assoc()){
            ?>
                <tr>
                    <td><?php echo $row['attendanceID']; ?></td>
                    <td><?php echo $row['employeeID']; ?></td>
                    <td><?php echo $row['logdate']; ?></td>
                    <td><?php echo $row['timein']; ?></td>
                    <td><?php echo $row['timeout']; ?></td>
                    <td><?php echo $row['shifttype']; ?></td>
                </tr>
            <?php
               }
            ?>
         </tbody>
        </table>
        <br><br>
        <table>
            <thead> <br><br>
            <tr>
                <td>ID</td>
                <td>MANAGER ID</td>
                <td>DATE</td>
                <td>TIMEIN</td>
                <td>TIMEOUT</td>
                <td>SHIFT NO</td>
            </tr>    
            </thead>
         <tbody>
            <?php
            require_once "connection.php";
            $sql = "SELECT * from attendance WHERE managerID IS NOT NULL  AND logdate=CURDATE()";
            $query = $conn->query($sql);
            while($row = $query->fetch_assoc()){
            ?>
                <tr>
                    <td><?php echo $row['attendanceID']; ?></td>
                    <td><?php echo $row['managerID']; ?></td>
                    <td><?php echo $row['logdate']; ?></td>
                    <td><?php echo $row['timein']; ?></td>
                    <td><?php echo $row['timeout']; ?></td>
                    <td><?php echo $row['shifttype']; ?></td>
                </tr>
            <?php
               }
            ?>
         </tbody>
        </table>
    </div> 
   
    <script type="text/javascript" src="javascript/instascan.min.js"></script>
    <script>
         const scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
         
         Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found.');
            }
         }).catch(function (e) {
            console.error(e);
            alert('Error: ' + e.message);
         });
         scanner.addListener('scan', function (content) {
                document.getElementById('text').value = content;
                document.forms[0].submit();
            }
        );
    </script>
  </div>
</div>
</body> 
</html>
<?php
?>