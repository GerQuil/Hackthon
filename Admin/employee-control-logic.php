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
?>