<?php
    session_start();
    include('dbConnect.php');

    $actionID = $_POST["actionID"];

// adding a department
    if($actionID == 1){
        $departmentName = $_POST['departmentName'];
        $sql = "INSERT INTO department(departmentName) VALUES ('".$departmentName."')";
        mysqli_query($connect, $sql);
    }

// Editing a department name
    if($actionID == 2){
        $departmentName = $_POST['departmentName'];
        $deptID = $_POST['departmentID'];
        $sql = "UPDATE department SET departmentName = '".$departmentName."' WHERE departmentID = '".$deptID."'";
        mysqli_query($connect, $sql);
    }

// Delete a department 
    if($actionID == 3){
        $deptID = $_POST['departmentID'];
        $sql = "UPDATE department SET departmentStatus = 'deleted' WHERE departmentID = '".$deptID."'";
        mysqli_query($connect, $sql);
    }
?>