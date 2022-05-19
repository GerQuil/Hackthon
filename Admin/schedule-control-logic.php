<?php
    session_start();
    include('dbConnect.php');

    $actionID = $_POST["actionID"];

// adding a shift schedule
    if($actionID == 1){
        $startTime = $_POST['startTimeAdd'];
        $endTime = $_POST['endTimeAdd'];
        $sql = "INSERT INTO shiftschedule(startTime, endTime) VALUES ('".$startTime."', '".$endTime."')";
        mysqli_query($connect, $sql);
    }

// editing a shift schedule
    if($actionID == 2){
        $shiftID = $_POST['shiftID'];
        $startTime = $_POST['startTimeEdit'];
        $endTime = $_POST['endTimeEdit'];
        $sql = "UPDATE shiftschedule SET startTime = '".$startTime."', endTime = '".$endTime."' WHERE scheduleID = '".$shiftID."'";
        mysqli_query($connect, $sql);
    }

// Deleting a shift schedule
    if($actionID == 3){
        $shiftID = $_POST['shiftID'];
        $sql = "UPDATE shiftschedule SET shiftStatus = 'deleted' WHERE scheduleID = '".$shiftID."'";
        mysqli_query($connect, $sql);
    }
?>