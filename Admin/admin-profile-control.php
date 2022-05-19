<?php
    session_start();
    include('dbConnect.php');

    $actionID = $_POST["actionID"];

// logout
    if($actionID == 2) {
        session_start();
        session_destroy();
        header("location: login.php");
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

// Edit Session Basic Info
    if($actionID == 4){
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];

        $_SESSION["fName"] = $fname;
        $_SESSION["lName"] = $lname;
        $_SESSION["mName"] = $mname;
        $_SESSION["email"] = $email;

        $sql = "UPDATE admin SET adminFName = '".$fname."', adminMName = '".$mname."', adminLName = '".$lname."', adminEmail = '".$email."' WHERE adminID = '".$_SESSION['adminID']."'";
        mysqli_query($connect, $sql);
    }

// Validate Current Password
    if($actionID == 5) {
        $curpass = $_POST['curPass'];
        if($curpass != $_SESSION['pass']){
            echo "wrong";
        } else {
            echo "correct";
        }
    }

// Change password
    if($actionID == 6) {
        $newpass = $_POST['newPass'];
        $sql = "UPDATE admin set adminPassword = '".$newpass."' WHERE adminID = '".$_SESSION['adminID']."'";
        mysqli_query($connect, $sql);
        session_start();
        session_destroy();
    }

    if($actionID == 7) {
        $adminID = $_POST['adminIDselected'];
        $sql = "DELETE FROM admin WHERE adminID = '".$adminID."'";
        mysqli_query($connect, $sql);
        if($adminID == $_SESSION['adminID']){
            session_start();
            session_destroy();
        }
        
    }
?>