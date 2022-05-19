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

// adding hybrid schedule
    if($actionID == 4){
        $hybridName = $_POST['hybridN'];
        $condition = $_POST['condition'];
        $inclusiondays = $_POST['dayinclusion'];

        $sql = "INSERT INTO hybridschedule(hybridName, inclusionDays, cond) VALUES ('".$hybridName."', '".$inclusiondays."', '".$condition."')";
        mysqli_query($connect, $sql);
    }

// Deleting a hybrid schedule
    if($actionID == 5){
        $hybridID = $_POST['hybridID'];
        $sql = "UPDATE hybridschedule SET hybridStatus = 'deleted' WHERE hybridScheduleID = '".$hybridID."'";
        mysqli_query($connect, $sql);
    }

// edit a hybrid schedule
    if($actionID == 6){
        $hybridID = $_POST['hybridID'];
        $hybridName = $_POST['hybridN'];
        $condition = $_POST['condition'];
        $inclusiondays = $_POST['dayinclusion'];

        $sql = "UPDATE hybridschedule SET hybridName = '".$hybridName."', cond = '".$condition."', inclusionDays = '".$inclusiondays."' WHERE hybridScheduleID = '".$hybridID."'";
        mysqli_query($connect, $sql);
    }
?>