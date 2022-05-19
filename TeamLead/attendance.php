<?php  
    date_default_timezone_set("Asia/Manila");
    $link = mysqli_connect("localhost", "root", "");
        
    if($link){
        mysqli_select_db($link, "employeetracker"); 
    }else{
        echo"error"; 
        die;
    }

    $empID = $_POST['empID'];
    $shift = $_POST['shift'];
    $team = $_POST['team'];
    $worktype = $_POST['worktype'];
    $pto = $_POST['pto'];
    $holiday = $_POST['holiday'];
    $address = $_POST['address'];
    $departmentID = $_POST['departmentID'];
    $teamID = $_POST['teamID'];
    $leadID = $_POST['leadID'];

    $qSelect = mysqli_query($link, "SELECT * FROM shiftschedule WHERE scheduleID = '{$shift}'");
    $shiftSched = mysqli_fetch_assoc($qSelect);

    if($pto == 0){
        $ptoName = null; 
    }
    
    $qInsert = mysqli_query($link, 
        "INSERT INTO `attendance`
        (`departmentID`, `teamID`, `leadID`, `attendanceStamp`, `start_time`, `end_time`, 
        `empID`, `hybridSchedID`, `paidTimeOffID`, `workType`, `holiday`, `location`)
        VALUES ('{$departmentID}', '{$teamID}', '{$leadID}', NOW(), '{$shiftSched['startTime']}', '{$shiftSched['endTime']}',
        '{$empID}', '{$team}', '{$pto}', '{$worktype}', '{$holiday}', '{$address}');"
    );

    if($qInsert){
        echo "SUCCESS";
    }else{
        echo "FAILED";
    }