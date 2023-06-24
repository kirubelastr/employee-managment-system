<?php
require_once 'connection.php';
include_once "header.php";
function getDepartments() {
    global $conn;
    $sql = "SELECT * FROM department";
    $result = $conn->query($sql);
    return $result;
}

function getPositionsByDepartment($departmentID) {
    global $conn;
    $sql = "SELECT * FROM position WHERE departmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $departmentID);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function insertDepartment($departmentName) {
    global $conn;
    $sql = "INSERT INTO department (departmentname) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $departmentName);
    $stmt->execute();
}

function insertPosition($positionName, $departmentID) {
    global $conn;
    $sql = "INSERT INTO position (departmentID, positionname) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $departmentID, $positionName);
    $stmt->execute();
}

function updateDepartment($departmentID, $departmentName) {
    global $conn;
    $sql = "UPDATE department SET departmentname = ? WHERE departmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $departmentName, $departmentID);
    $stmt->execute();
}

function updatePosition($positionID, $positionName, $departmentID) {
    global $conn;
    $sql = "UPDATE position SET positionname = ?, departmentID = ? WHERE positionID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $positionName, $departmentID, $positionID);
    $stmt->execute();
}

// Handle form submissions for adding or updating departments and positions.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submitDepartment'])) {
        if (isset($_POST['updateDepartment'])) {
            updateDepartment($_POST['updateDepartment'], $_POST['departmentName']);
        } else {
            insertDepartment($_POST['departmentName']);
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['submitPosition'])) {
        if (isset($_POST['updatePosition'])) {
            updatePosition($_POST['updatePosition'], $_POST['positionName'], $_POST['departmentID']);
        } else {
            insertPosition($_POST['positionName'], $_POST['departmentID']);
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

$departments = getDepartments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Department and Position Management</title>
  <style>
      body {
          font-family: Arial, sans-serif;
          line-height: 1.6;
          background-color: #f4f4f4;
      }.sidebar {
        float: left;
        width: 200px;
        height: 100%;
        background-color: #f0f0f0;
        padding: 20px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        }

        .container {
        float: left;
        width: calc(100% - 200px);
        overflow: hidden;
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
          float: right;
          width: 20%;
          background-color: #333;
          color: #fff;
          padding: 20px;
      }

      .main-content {
          float: left;
          width: 70%;
          padding: 20px;
      }

      .clearfix::after {
          content: "";
          display: table;
          clear: both;
      }

      h2 {
          margin-top: 0;
      }

      label,
      input[type="text"],
      select,
      input[type="submit"] {
          display: block;
          margin-bottom: 10px;
      }

      input[type="text"],
      select,
      input[type="submit"] {
          width: 100%;
          padding: 10px;
          box-sizing: border-box;
      }

      input[type="submit"] {
          background-color: #333;
          color: #fff;
          border: none;
          cursor:pointer
      }

      input[type="submit"]:hover {
          background-color:#555
      }

      table{
        width:100%;
        border-collapse:collapse
      }

      th,
      td{
        padding:10px;text-align:left;border-bottom:1px solid #ddd
      }
  </style>
</head>
<body>
    
  <div class="sidebar">
    <h3>admin</h3>
    <a  class="active"href="department_and_position.php">department and position</a>
    <a href="aproveleave.php">aprove leave</a>
    <a href="createusers.php">createusers</a>
    <a href="employee.php">add employee</a>
    <a href="manager.php">add manage</a>
    <a href="deductionandallowance.php">deduction and allowance</a>
    <a href="deductionandallowance.php">add deduction and allowance</a>
    <a href="qrcode.php">qrcode</a>
    <a href="branchmanager.php">branch</a>
    <a href="everymonth.php">salary</a>
  </div>
    <div class="container">
        <div class="main-content">
            <h2>Departments and Positions</h2>
            <table>
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($department = $departments->fetch_assoc()): ?>
                        <?php
                        $positions = getPositionsByDepartment($department['departmentID']);
                        $firstPosition = true;
                        while ($position = $positions->fetch_assoc()):
                        ?>
                            <tr>
                                <?php if ($firstPosition): ?>
                                    <td rowspan="<?php echo $positions->num_rows; ?>"><?php echo $department['departmentname']; ?></td>
                                    <?php $firstPosition = false; ?>
                                <?php endif; ?>
                                <td><?php echo $position['positionname']; ?></td>
                                <td><a href="?editPosition=<?php echo $position['positionID']; ?>">Edit</a></td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($firstPosition): ?>
                            <tr>
                                <td><?php echo $department['departmentname']; ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
                        </div><div>
            <?php
            if (isset($_GET['editDepartment'])) {
                $departmentID = $_GET['editDepartment'];
                $sql = "SELECT departmentname FROM department WHERE departmentID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $departmentID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $departmentName = $row['departmentname'];
                } else {
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            }

            if (isset($_GET['editPosition'])) {
                $positionID = $_GET['editPosition'];
                $sql = "SELECT positionname, departmentID FROM position WHERE positionID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $positionID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $positionName = $row['positionname'];
                    $positionDepartmentID = $row['departmentID'];
                } else {
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            }
            ?>
        </div>
        <div class="form-container">
            <h2>Add/Update Department</h2>
            <form action="" method="post">
                <label for="departmentName">Department Name:</label>
                <input type="text" name="departmentName" id="departmentName" value="<?php echo isset($departmentName) ? htmlspecialchars($departmentName) : ''; ?>" required>
                <?php if (isset($departmentID)): ?>
                    <input type="hidden" name="updateDepartment" value="<?php echo htmlspecialchars($departmentID); ?>">
                <?php endif; ?>
                <input type="submit" name="submitDepartment" value="<?php echo isset($departmentID) ? 'Update' : 'Add'; ?> Department">
            </form>

            <h2>Add/Update Position</h2>
            <form action="" method="post">
                <label for="departmentID">Department:</label>
                <select name="departmentID" id="positionDepartmentID" required>
                    <option value="" disabled selected>-- Select a department --</option>
                    <?php
                    $departments->data_seek(0);
                    while ($department = $departments->fetch_assoc()):
                    ?>
                        <option value="<?php echo htmlspecialchars($department['departmentID']); ?>"<?php echo isset($positionDepartmentID) && ($positionDepartmentID ==$department['departmentID']) ? ' selected' : ''; ?>><?php echo htmlspecialchars($department['departmentname']); ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="positionName">Position Name:</label>
                <input type="text" name="positionName" id="positionName" value="<?php echo isset($positionName) ? htmlspecialchars($positionName) : ''; ?>" required>

                <?php if (isset($positionID)): ?>
                    <input type="hidden" name="updatePosition" value="<?php echo htmlspecialchars($positionID); ?>">
                <?php endif; ?>

                <input type="submit" name="submitPosition" value="<?php echo isset($positionID) ? 'Update' : 'Add'; ?> Position">
            </form>
        </div>

        <div class="clearfix"></div>
    </div>
</body>
</html>
