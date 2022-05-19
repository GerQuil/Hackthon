<?php
    session_start();
    include('dbConnect.php');
    
    $actionID = $_POST["actionID"];

// logout
    if($actionID == 2) {
        session_start();
        session_destroy();
    }

// Add Admin
    if($actionID == 3){
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $sql = "INSERT INTO admin(adminFName, adminMName, adminLName, adminEmail, adminPassword, adminStat) 
            VALUES ('".$fname."', '".$mname."', '".$lname."', '".$email."', '".$pass."', 'active' )";
        mysqli_query($connect, $sql);
    }
?>