<?php
    session_start();
    include('dbConnect.php');

    $actionID = $_POST["actionID"];

// adding of team
    if($actionID == 1){
        $teamName = $_POST['teamName'];
        $sql = "INSERT INTO team(teamName) VALUES ('".$teamName."')";
        mysqli_query($connect, $sql);
    }
    
// editing of team name
    if($actionID == 2){
        $teamName = $_POST['teamName'];
        $teamID = $_POST['teamID'];
        $sql = "UPDATE team SET teamName = '".$teamName."' WHERE teamID = '".$teamID."'";
        mysqli_query($connect, $sql);
    }

// Delete a team 
    if($actionID == 3){
        $teamID = $_POST['teamID'];
        $sql = "UPDATE team SET teamStatus = 'deleted' WHERE teamID = '".$teamID."'";
        mysqli_query($connect, $sql);
    }
?>