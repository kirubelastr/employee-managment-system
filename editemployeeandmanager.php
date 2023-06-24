<!DOCTYPE html>
<html>
<head>
  <title>manager Data Input Form</title>
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
  height: 100vh;
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
  border-left-color: #09f;
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
    height :350px; 
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
    <h3>branch manager</h3>
    <a href="managerdashboard.php">Home</a>
    <a href="managerleave.php">leave</a>
    <a href="managerattendance.php">attendance</a>
    <a class="active"href="editemployeeandmanager.php">details</a>
  </div>

  <div class="form-container">
    <h2>manager Data Input Form</h2>
    <form action="search.php" method="post";>
      <label for="firstname">search employee:</label>
        <input type="text" id="employee" name="employee">
        <label for="firstname">search manager:</label>
        <input type="text" id="manager" name="manager">
        <input type="submit" name="search" value="search">
        ...
</form>
        <script>
            const employeeInput = document.querySelector('#employee');
            const managerInput = document.querySelector('#manager');

            employeeInput.addEventListener('input', () => {
            if (employeeInput.value !== '') {
                managerInput.disabled = true;
            } else {
                managerInput.disabled = false;
            }
            });

            managerInput.addEventListener('input', () => {
            if (managerInput.value !== '') {
                employeeInput.disabled = true;
            } else {
                employeeInput.disabled = false;
            }
            });

        </script>
    <div class="form-section">
      <h3>Personal Information</h3>
      
      <form id="employeeForm" action="search.php" method="post"enctype="multipart/form-data">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname">
        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename">
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" style="width: fit-content;">
          <option value="">-choose an option-</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email">
        <label for="dateofbirth">Date of Birth:</label>
        <input type="date" id="dateofbirth" name="dateofbirth"><br>
        <label for="phone" class="phonestyle">primary Phone Number:</label>
        <input type="tel" id="phone" name="phonep">
        <label for="phone">secondary Phone Number:</label>
        <input type="tel" id="phone" name="phones">
        <label style="margin-top: -10px;"for="phone">address:</label>
        <textarea rows="1" cols="30" type="text" id="address" name="address">
        </textarea>
          <div class="form-section2">
            <h3>Employment Information</h3>

            <div id="employmentForm">
              <?php
              require_once "connection.php";
              // Query department table
              $sql = "SELECT departmentID, departmentname FROM department";
              $result = $conn->query($sql);

              // Generate department select element
              echo '<label for="department">Department:</label>';
              echo '<select style="margin-right: 80px;" name="department" id="department" onchange="updatePositionSelect()">';
              while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row['departmentID'] . '">' . $row['departmentname'] . '</option>';
              }
              echo '</select>';

              // Generate position select element
              echo '<label  style="margin-left:-55px"for="position">Position:</label>';
              echo '<select  name="position" id="position">';
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
              </script>

              <label  style="margin-left:55px"for="hiredate">Date of Hire:</label>
              <input type="date" id="hiredate" name="hiredate"><br>
              <label style="margin-left: -3px;" for="eduction">education:</label>
                <select id="status" name="educationstatus" >
                    <option value="">-- choose an option --</option>
                    <option value="msc">bsc</option>
                    <option value="bsc">bsc</option>
                    <option value="others">others</option>
                </select>
              
              <label style="margin-left:-45px"for="file-input">File(resume):</label>
                  <input type="file" id="file-input" name="file"onchange="updateFilePreview()">
                  <button id="preview-button" style="display: none;" onclick="openPreviewDialog()">Preview</button>
                  </div><br>
                <label for="others-photo">Photo:</label>
                  <input type="file" id="others-photo"name="photo" onchange="updatePhotoPreview()">
                  <img id="photo-preview" src="" style="display: none; max-width: 200px; max-height: 200px;">
                       
                
                  <script>
                      function updateFilePreview() {
                            // Get the selected file
                            var file = document.getElementById("file-input").files[0];
                            if (file) {
                                // Show the preview button
                                document.getElementById("preview-button").style.display = "inline-block";
                            } else {
                                // Hide the preview button
                                document.getElementById("preview-button").style.display = "none";
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
                          // Get photo file
                          let photoInput = document.getElementById("others-photo");
                          let photoFile = photoInput.files[0];

                          // Get photo preview element
                          let photoPreview = document.getElementById("photo-preview");

                          // Update photo preview
                          if (photoFile) {
                              let reader = new FileReader();
                              reader.onload = function(e) {
                                  photoPreview.src = e.target.result;
                                  photoPreview.style.display = "block";
                              }
                              reader.readAsDataURL(photoFile);
                          } else {
                              photoPreview.src = "";
                              photoPreview.style.display = "none";
                          }
                      }

                  </script>
            </div>
          </div>
        <input type="submit" value="update">
     </form>

    </div>
  </div>
</div>
</div>
</body>
</html>