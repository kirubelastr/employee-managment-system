<?php
require_once 'connection.php';

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
}?>