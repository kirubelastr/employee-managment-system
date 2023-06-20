<?php
    // Database connection
    require_once "connection.php";

    // Update a manager
    if (isset($_POST['update'])) {
        $managerID = $_POST['managerID'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $dateofbirth = $_POST['dateofbirth'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $primary_phone = $_POST['primary_phone'];
        $secondary_phone = $_POST['secondary_phone'];
        $dateofjoin = $_POST['dateofjoin'];
        $education_status = $_POST['education_status'];
        $manager_photo = file_get_contents($_FILES['manager_photo']['tmp_name']);
        $email = $_POST['email'];
        $managerfile = file_get_contents($_FILES['managerfile']['tmp_name']);
        $yearlyvacationdays = $_POST['yearlyvacationdays'];
        $basesalary = $_POST['basesalary'];
        $userID = $_POST['userID'];
        $departmentID = $_POST['departmentID'];
        $positionID = $_POST['positionID'];

        if ($stmt = mysqli_prepare($conn, "UPDATE manager SET firstname=?, middlename=?, lastname=?, dateofbirth=?, gender=?, address=?, primary_phone=?, secondary_phone=?, dateofjoin=?, education_status=?, manager_photo=?, email=?, managerfile=?, yearlyvacationdays=?, basesalary=?, userID=?, departmentID=?, positionID=? WHERE managerID=?")) {
            mysqli_stmt_bind_param($stmt, "sssssssssssssbidiiis", $firstname, $middlename, $lastname, $dateofbirth, $gender, $address, $primary_phone, $secondary_phone, $dateofjoin,$education_status,$manager_photo,$email,$managerfile,$yearlyvacationdays,$basesalary,$userID,$departmentID,$positionID,$managerID);
            if (mysqli_stmt_execute($stmt)) {
                echo "Manager updated successfully";
            } else {
                echo "Error: " . htmlspecialchars(mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . htmlspecialchars(mysqli_error($conn));
        }
    }

    // Delete a manager
    if (isset($_POST['delete'])) {
        $managerID = $_POST['managerID'];

        if ($stmt = mysqli_prepare($conn, "DELETE FROM manager WHERE managerID=?")) {
            mysqli_stmt_bind_param($stmt, 's', $managerID);
            if (mysqli_stmt_execute($stmt)) {
                echo "Manager deleted successfully";
            } else {
                // Handle foreign key constraint violation
                if (mysqli_errno($conn) == 1451) {
                    echo "Error: Cannot delete manager because it is referenced by other records";
                } else {
                    echo "Error: " . htmlspecialchars(mysqli_stmt_error($stmt));
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . htmlspecialchars(mysqli_error($conn));
        }
    }

    // Read all managers
    function readManagers() {
        global $conn;
        echo "<table>";
        echo "<tr>";
        echo "<th>Manager ID</th>";
        echo "<th>First Name</th>";
        echo "<th>Middle Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Date of Birth</th>";
        echo "<th>Gender</th>";
        echo "<th>Address</th>";
        echo "<th>Primary Phone</th>";
        echo "<th>Secondary Phone</th>";
        echo "<th>Date of Join</th>";
        echo "<th>Education Status</th>";
        // ...
        // Add more columns as needed
        // ...
        echo "<th>Email</th>";
        echo "<th>Yearly Vacation Days</th>";
        // Note: It is not recommended to display binary data (e.g. manager_photo, managerfile) directly in an HTML table
        // You can display a link to download the binary data instead
        // ...
        // Add code to display binary data as needed
        echo "</tr>";

        if ($result = mysqli_query($conn, "SELECT * FROM manager")) {
            while ($row = mysqli_fetch_assoc($result)) {
                $managerID = $row['managerID'];
                $firstname = $row['firstname'];
                $middlename = $row['middlename'];
                $lastname = $row['lastname'];
                $dateofbirth = $row['dateofbirth'];
                $gender = $row['gender'];
                $address = $row['address'];
                $primary_phone = $row['primary_phone'];
                $secondary_phone = $row['secondary_phone'];
                $dateofjoin = $row['dateofjoin'];
                $education_status = $row['education_status'];
                // ...
                // Add more fields as needed
                // ...
                $email = $row['email'];
                $yearlyvacationdays = $row['yearlyvacationdays'];

                // Display manager_photo and managerfile in a print page with a close button using JavaScript
                if (!empty($row['manager_photo'])) {
                    // Convert binary data to base64-encoded string
                    $manager_photo_base64 = base64_encode($row['manager_photo']);
                    // Create a JavaScript function to display the manager_photo in a print page with a close button
                    echo "<script>
                        function showManagerPhoto{$managerID}() {
                            var img = new Image();
                            img.src = 'data:image/jpeg;base64,{$manager_photo_base64}';
                            var w = window.open('', '_blank');
                            w.document.write(img.outerHTML);
                            w.document.write('<br><button onclick=\"window.close();\">Close</button>');
                            w.print();
                        }
                    </script>";
                    // Create a link to call the JavaScript function
                    $manager_photo_link = "<a href=\"#\" onclick=\"showManagerPhoto{$managerID}(); return false;\">View Photo</a>";
                } else {
                    $manager_photo_link = "N/A";
                }

                if (!empty($row['managerfile'])) {
                    // Convert binary data to base64-encoded string
                    $managerfile_base64 = base64_encode($row['managerfile']);
                    // Create a JavaScript function to display the managerfile in a print page with a close button
                    echo "<script>
                        function showManagerFile{$managerID}() {
                            var iframe = document.createElement('iframe');
                            iframe.srcdoc = atob('{$managerfile_base64}');
                            var w = window.open('', '_blank');
                            w.document.write(iframe.outerHTML);
                            w.document.write('<br><button onclick=\"window.close();\">Close</button>');
                            w.print();
                        }
                    </script>";
                    // Create a link to call the JavaScript function
                    $managerfile_link = "<a href=\"#\" onclick=\"showManagerFile{$managerID}(); return false;\">View File</a>";
                } else {
                    $managerfile_link = "N/A";
                }
                echo "<tr>";
                echo "<td>{$managerID}</td>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$middlename}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$dateofbirth}</td>";
                echo "<td>{$gender}</td>";
                echo "<td>{$address}</td>";
                echo "<td>{$primary_phone}</td>";
                echo "<td>{$secondary_phone}</td>";
                echo "<td>{$dateofjoin}</td>";
                echo "<td>{$education_status}</td>";
                // ...
                // Add more fields as needed
                // ...
                echo"<td>{$email}</td>";
                echo"<td>{$yearlyvacationdays}</td>";
                // Note: It is not recommended to display binary data (e.g. manager_photo, managerfile) directly in an HTML table
                // You can display a link to download the binary data instead
                // ...
                // Add code to display binary data as needed
                echo"<td>{$manager_photo_link}</td>";
                echo"<td>{$managerfile_link}</td>";
                // Add buttons to update and delete managers
                echo"<td><button onclick=\"updateManager({$managerID});\">Update</button></td>";
                echo"<td><form method=\"post\"><input type=\"hidden\" name=\"managerID\" value=\"{$managerID}\"><input type=\"submit\" name=\"delete\" value=\"Delete\"></form></td>";
                echo "</tr>";
            }
            mysqli_free_result($result);
        } else {
            echo "Error: " . htmlspecialchars(mysqli_error($conn));
        }
        echo "</table>";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager CRUD</title>
    <script>
        function updateManager(managerID) {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "");

            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "managerID");
            input.setAttribute("value", managerID);
            form.appendChild(input);

            var fields = ["firstname", "middlename", "lastname", "dateofbirth", "gender", "address", "primary_phone", "secondary_phone", "dateofjoin", "education_status", "email", "yearlyvacationdays", "basesalary"];
            for (var i = 0; i < fields.length; i++) {
                var label = document.createElement("label");
                label.innerHTML = fields[i] + ": ";
                form.appendChild(label);

                var input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("name", fields[i]);
                form.appendChild(input);

                form.appendChild(document.createElement("br"));
            }

            var submit = document.createElement("input");
            submit.setAttribute("type", "submit");
            submit.setAttribute("name", "update");
            submit.setAttribute("value", "Update");
            form.appendChild(submit);

            document.body.appendChild(form);
        }
    </script>
</head>
<body>
    <h1>Manager CRUD</h1>

    <h2>Read Managers</h2>
    <?php readManagers(); ?>

</body>
</html>
