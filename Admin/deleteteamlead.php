<?php
    session_start();
    include('dbConnect.php');
    if(!isset($_SESSION['adminID'])){
        header("location: login.php");
        exit();     
    }

    $leadid = $_GET['leadid'];
    mysqli_query($connect, 
    "UPDATE teamlead SET leadStat = 'deleted' WHERE leadid = '{$leadid}'; ");
    header('location: users.php');
    exit;
