<!DOCTYPE html>
<html>
<head>
  <title>Employee Data Input Form</title>
  <style>
   body {
  margin: 0;
  padding: 0;
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
      width :auto ;
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

  <div class="sidebar">
    <h3>Sidebar</h3>
    <a class="active" href="#home">Home</a>
    <a href="#news">News</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a>
  </div>

  <div class="form-container">
    <h2>Employee Data Input Form</h2>

    <div class="form-section">
      <h3>Personal Information</h3>
      <form id="employeeForm">
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
        </form>

          <div class="form-section2">
            <h3>Employment Information</h3>

            <form id="employmentForm">
            <?php
              require_once "connection.php";

              // Query department table
              $sql = "SELECT departmentID, departmentname FROM department";
              $result = $conn->query($sql);

              // Generate department select element
              echo '<label for="department">Department:</label>';
              echo '<select name="department" id="department" onchange="updatePositionSelect()">';
              while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row['departmentID'] . '">' . $row['departmentname'] . '</option>';
              }
              echo '</select>';

              // Generate position select element
              echo '<label for="position">Position:</label>';
              echo '<select name="position" id="position">';
              echo '</select>';

              // Generate positionsByDepartment object
              $positionsByDepartment = [];
              $sql = "SELECT departmentID, positionname FROM position";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                  $departmentID = $row['departmentID'];
                  $positionname = $row['positionname'];
                  if (!isset($positionsByDepartment[$departmentID])) {
                      $positionsByDepartment[$departmentID] = [];
                  }
                  $positionsByDepartment[$departmentID][] = $positionname;
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
                          option.value = positions[i];
                          option.text = positions[i];
                          positionSelect.add(option);
                      }
                  }

                  // Call updatePositionSelect on page load to populate initial position options
                  updatePositionSelect();
              </script><br>
              <label for="hiredate">Date of Hire:</label>
              <input type="date" id="hiredate" name="hiredate">
              <label for="status">Employment Status:</label>
              <select id="status" style="margin-left: -10px;"name="status">
                <option value="">--Please choose an option--</option>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Contract">Contract</option>
              </select>
              <label for="salary">Salary:</label>
              <input type="number" id="salary" name="salary">
             
             
              <label for="eduction">education:</label>
                <select id="status" name="status" onchange="updateStatus()">
                    <option value="">--Please choose an option--</option>
                    <option value="msc">bsc</option>
                    <option value="bsc">bsc</option>
                    <option value="others">others</option>
                </select>

                <div id="others-container" style="display: none;">
                    <label for="others-text">Text:</label><br>
                    <textarea id="others-text"></textarea><br>
                </div><br>
                <label for="others-photo">Photo:</label>
                    <input type="file" id="others-photo" onchange="updatePhotoPreview()"><br>
                    <img id="photo-preview" src="" style="display: none; max-width: 200px; max-height: 200px;">
                <script>
                    function updateStatus() {
                        // Get selected status
                        let statusSelect = document.getElementById("status");
                        let selectedStatus = statusSelect.options[statusSelect.selectedIndex].value;

                        // Get others container element
                        let othersContainer = document.getElementById("others-container");

                        // Show or hide others container based on selected status
                        if (selectedStatus === "others") {
                            othersContainer.style.display = "block";
                        } else {
                            othersContainer.style.display = "none";
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
     </form>
    </div>

    <input type="submit" value="Submit">
  </div>

</body>
</html>