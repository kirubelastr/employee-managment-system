
<!DOCTYPE html>
<html>
<head>
  <title>employee Data Input Form</title>
  <style>
   body {
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: stretch;
 }
 .page-container {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: stretch;
    }

    .content-container {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: stretch;
    }
 .sidebar {
   width: 200px;
   height: auto;
   background-color: #f0f0f0;
   padding: 20px;
   box-sizing: border-box;
   display: flex;
   flex-direction: column;
   justify-content: flex-start;
   align-items: center;
 }
 
 .sidebar h3 {
   margin-top: 0;
 }
 
 .sidebar a {
   display: block;
   margin-bottom: 10px;
   padding: 10px;
   width: 100%;
   text-align: center;
   text-decoration: none;
   color: #333;
   border-left: 5px solid transparent;
 }
 
 .sidebar a.active,
 .sidebar a:hover {
   background-color: #ddd;
   border-left-color: red;
 }
 
 .form-container {
   flex: 1;
   padding: 20px;
   box-sizing: border-box;
   display: flex;
   flex-direction: column;
   justify-content: flex-start;
   align-items: stretch;
 }
 
 .form-container h2 {
     margin-top:0; 
     margin-bottom :10px; 
 }
 
 .form-section {
     margin-bottom :5px; 
     border :1px solid #ccc; 
     border-radius :4px; 
     padding :10px; 
     box-sizing :border-box; 
 }
 .form-section2{
     height :auto; 
     margin-bottom :5px; 
     border :1px solid #ccc; 
     border-radius :4px; 
     padding :10px; 
     box-sizing :border-box; 
     
 }
 
 .form-section h3 {
     margin-top :0; 
     margin-bottom :5px; 
 }
 form {
     display:block; 
     flex-wrap :wrap; 
     justify-content:left; 
     align-items:center; 
 }
 
 label {
     display:inline-block; 
     width :140px; 
     text-align:right; 
     margin-right :20px; 
 }
     
 input[type="submit"] {
       background-color:#09f ; 
       color:#fff ; 
       border:none ; 
       border-radius :4px ; 
       padding :10px ; 
       cursor:pointer ; 
       font-size :16px ; 
       margin-top :10px ;  
 }
 input,
 select,
 textarea {
       position :inherits ;  
       flex :1 ;  
       padding :10px ;  
       border :1px solid #ccc ;  
       border-radius :4px ;  
       box-sizing:border-box ;  
       margin-bottom :10px ;  
       font-size :16px ;  
 }
 
 input[type="file"] {
       padding :10 ;
 }
 
 input:focus,
 select:focus,
 textarea:focus {
       outline:none ;
       border-color:#09f ;
 }
 
 select {
       width :inherit ;
       padding-left: 20px;
       padding-right: 40px;
 }
 
 textarea {
       height :auto ;
 }
 
 input[type="submit"]:hover {
       background-color:#0077cc ;
 }
 

  </style>
</head>
<body>
<div class="page-container">
  <?php include 'header.php'; ?>

  <div class="content-container">
  <div class="sidebar">
    <h3>admin</h3>
    <a  href="department_and_position.php">department and position</a>
    <a href="aproveleave.php">aprove leave</a>
    <a href="createusers.php">createusers</a>
    <a  class="active"href="employee.php">add employee</a>
    <a href="manager.php">add manage</a>
    <a href="deductionandallowance.php">deduction and allowance</a>
    <a href="adddeductionandallowance.php">add deduction and allowance</a>
    <a href="qrcode.php">qrcode</a>
    <a href="branchmanager.php">branch</a>
    <a href="everymonth.php">salary</a>
  </div>

  <div class="form-container">
    <h2>employee Data Input Form</h2>

    <div class="form-section">
      <h3>Personal Information</h3>
      <form id="employeeForm" action="fillemployee.php" method="post"enctype="multipart/form-data">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname"required>
        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename"required>
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname"required>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" style="width: fit-content;"required>
          <option value="">-choose an option-</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email"required>
        <label for="dateofbirth">Date of Birth:</label>
        <input type="date" id="dateofbirth" name="dateofbirth"required><br>
        <label for="phone" class="phonestyle">primary Phone Number:</label>
        <input type="tel" id="phone" name="phonep"required>
        <label for="phone">secondary Phone Number:</label>
        <input type="tel" id="phone" name="phones"required>
        <label style="margin-top: -10px;"for="phone">state:</label>
        <select id="state" name="state" style="width: fit-content;"required>
            <option value="Afar">Afar</option>
            <option value="Amhara">Amhara</option>
            <option value="Benishangul/Gumaz">Benishangul/Gumaz</option>
            <option value="Gambela">Gambela</option>
            <option value="Harari">Harari</option>
            <option value="Oromia">Oromia</option>
            <option value="Somali">Somali</option>
            <option value="SNNPR">SNNPR</option>
            <option value="Tigray">Tigray</option>
            <option value="Sidama">Sidama</option>
            <option value="South West Ethiopia">South West Ethiopia</option>
            <option value="Addis Ababa">Addis Ababa</option>
            <option value="Dire Dawa">Dire Dawa</option>
          </select>

        <label style="margin-top: -10px;"for="city">city(sub city):</label>
        <input type="text" id="city" name="city"required>
          
        <label style="margin-top: -10px;"for="street">street:</label>
        <input type="text" id="street" name="street"required>
          <div class="form-section2">
            <h3>Employment Information</h3>

            <div id="employmentForm">
            <?php
              require_once "connection.php";
              //query the branch table
              $sql = "SELECT branchID,managerID,branchname FROM branch";
              $result = $conn->query($sql);

              // Generate branch select element
              echo '<label for="branch">branch:</label>';
              echo '<select  name="branchID" id="branch" onchange="updatePositionSelect()"required>';
              while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row['branchID'] . $row['managerID'] . '">' . $row['branchname'] . '</option>';
              }
              echo '</select>';
              // Query department table
              $sql = "SELECT departmentID, departmentname FROM department";
              $result = $conn->query($sql);

              // Generate department select element
              echo '<label style="margin-left:77px"for="department">Department:</label>';
              echo '<select  name="department" id="department" onchange="updatePositionSelect()"required>';
              while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row['departmentID'] . '">' . $row['departmentname'] . '</option>';
              }
              echo '</select>';

              // Generate position select element
              echo '<label  style="margin-left:67px"for="position">Position:</label>';
              echo '<select  name="position" id="position"required>';
              echo '</select>';
              // Generate positionsByDepartment object
              $positionsByDepartment = [];
              $sql = "SELECT departmentID, positionID, positionname FROM position";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                  $departmentID = $row['departmentID'];
                  $positionID = $row['positionID'];
                  $positionname = $row['positionname'];
                  if (!isset($positionsByDepartment[$departmentID])) {
                      $positionsByDepartment[$departmentID] = [];
                  }
                  $positionsByDepartment[$departmentID][] = ['id' => $positionID, 'name' => $positionname];
              }
              $conn->close();
              ?>

              <script>
                  // Object to store department-position relationships
                  let positionsByDepartment = <?php echo json_encode($positionsByDepartment); ?>;

                  function updatePositionSelect() {
                      // Get selected department
                      let departmentSelect = document.getElementById("department");
                      let selectedDepartmentID = departmentSelect.options[departmentSelect.selectedIndex].value;

                      // Get position select element
                      let positionSelect = document.getElementById("position");

                      // Clear position options
                      positionSelect.innerHTML = "";

                      // Add new position options based on selected department
                      let positions = positionsByDepartment[selectedDepartmentID];
                      for (let i = 0; i < positions.length; i++) {
                          let option = document.createElement("option");
                          option.value = positions[i].id; // Set value attribute to position ID
                          option.text = positions[i].name;
                          positionSelect.add(option);
                      }
                  }

                  // Call updatePositionSelect on page load to populate initial position options
                  updatePositionSelect();
              </script><br>


              <label style="margin-left:-3px"for="hiredate">Date of Hire:</label>
              <input type="date" id="hiredate" name="hiredate"required>
              <label style="margin-left: 85px;" for="eduction">education:</label>
                <select id="status" name="educationstatus" required>
                   <option value="msc">MSc</option>
                  <option value="bsc">BSc</option>
                  <option value="phd">PhD</option>
                  <option value="mba">MBA</option>
                  <option value="ba">BA</option>
                  <option value="ma">MA</option>
                  <option value="others">Others</option>
                </select>
                <label style="margin-left:0px"for="status">Employment Status:</label>
              <select id="status"name="employmentstatus"required>
                <option value="">--Please choose an option--</option>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Contract">Contract</option>
              </select><br>
              <label style="margin-left:0px"for="yearlyvacationdays">yearly vacation days:</label>
                <input type="number" id="yearlyvacationdays" name="yearlyvacationdays"required>
              <label style="margin-left:20px"for="file-input">base salary:</label>
                  <input type="number" id="salary" name="salary"required><br>
                  <label for="file-input">File (resume):</label>
<input type="file" id="file-input" name="file" onchange="updateFilePreview()" required>
<button id="preview-button" style="display: none;" onclick="openPreviewDialog()">Preview</button>

<label for="others-photo">Photo:</label>
<input type="file" id="others-photo" name="photo" onchange="updatePhotoPreview()" required>
<img id="photo-preview" src="" style="display: none; max-width: 200px; max-height: 200px;">

<script>
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

    function updateFilePreview() {
        const fileInput = document.getElementById('file-input');
        const file = fileInput.files[0];
        if (file.size > MAX_FILE_SIZE) {
            alert('This file is too large. Please choose a smaller file.');
            fileInput.value = '';
        } else if (file.type !== 'application/pdf') {
            alert('Please choose a PDF file.');
            fileInput.value = '';
        } else {
            // Show the preview button
            document.getElementById("preview-button").style.display = "inline-block";
        }
    }

    function openPreviewDialog() {
        // Get the selected file
        var file = document.getElementById("file-input").files[0];
        if (file) {
            // Create a URL for the file
            var fileURL = URL.createObjectURL(file);
            // Open the file in a new window
            var previewWindow = window.open(fileURL, "PDF Preview", "width=400,height=400");
        }
    }

    function updatePhotoPreview() {
        const photoInput = document.getElementById('others-photo');
        const photo = photoInput.files[0];
        if (photo.size > MAX_FILE_SIZE) {
            alert('This image is too large. Please choose a smaller image.');
            photoInput.value = '';
        } else if (!photo.type.startsWith('image/jpeg')) {
            alert('Please choose a JPG image.');
            photoInput.value = '';
        } else {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("photo-preview").src = e.target.result;
                document.getElementById("photo-preview").style.display = "block";
            }
            reader.readAsDataURL(photo);
        }
    }
</script>

            </div>
          </div>
        <input type="submit" value="Submit">
     </form>

    </div>
  </div>
</div>
</div>
</body>
</html>