<?php
    session_start();
    include('dbConnect.php');

    $actionID = $_POST["actionID"];

// delete employee 
    if($actionID == 1){
        $empID = $_POST['empID'];
        $sql = "UPDATE employee SET empStat = 'deleted' WHERE empID = '".$empID."'";
        mysqli_query($connect, $sql);
    }

// add employee
    if($actionID == 2){
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $num = $_POST['num'];
        $email = $_POST['email'];
        $bday = $_POST['bday'];
        $pass = $_POST['pass'];
        $dept = $_POST['dept'];
        $team = $_POST['team'];
        $teamlead = $_POST['teamlead'];
        $designation = $_POST['designation'];
        $gender = $_POST['gender'];

        $sql = "INSERT into employee (leadID, departmentID, teamID, empFName, empMName, empLName, empEmail, 
        empPassword, empBdate, empGender, empNumber, designation) VALUES ('".$teamlead."', '".$dept."', '".$team."',
        '".$fname."', '".$mname."', '".$lname."', '".$email."', '".$pass."', '".$bday."', '".$gender."', '".$num."', '".$designation."')";

        mysqli_query($connect, $sql);
    }

// edit employee 
    if($actionID == 3){
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $num = $_POST['num'];
        $email = $_POST['email'];
        $bday = $_POST['bday'];
        $empID = $_POST['empID'];
        $dept = $_POST['dept'];
        $team = $_POST['team'];
        $teamlead = $_POST['teamlead'];
        $designation = $_POST['designation'];
        $gender = $_POST['gender'];

        $sql = "UPDATE employee SET 
            leadID = '".$teamlead."', 
            departmentID = '".$dept."',
            teamID = '".$team."',
            empFName = '".$fname."',
            empMName = '".$mname."',
            empLName = '".$lname."',
            empEmail = '".$email."',
            empBdate = '".$bday."',
            empGender = '".$gender."',
            empNumber = '".$num."',
            designation = '".$designation."'
                WHERE empID = '".$empID."'
            ";

        mysqli_query($connect, $sql);
    }
?>