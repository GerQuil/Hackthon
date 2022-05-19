<?php
    session_start();
    include('dbConnect.php');

    $actionID = $_POST["actionID"];

// edit attendance bonus
    if($actionID == 1){
        $attendanceBonus = $_POST['attendanceBonus'];
        $sql = "UPDATE attendanceBonus SET bonusPrice = '".$attendanceBonus."' WHERE bonusID = '1'";
        mysqli_query($connect, $sql);
    }

// add hazard pay
    if($actionID == 2){
        $area = $_POST['area'];
        $pay = $_POST['pay'];

        $sql = "INSERT INTO hazardpay (Area, harzardPay) VALUES ('".$area."', '".$pay."')";
        mysqli_query($connect, $sql);
    }

// edit hazard pay
    if($actionID == 3) {
        $area = $_POST['area'];
        $pay = $_POST['pay'];
        $hazardID = $_POST['hazardID'];

        $sql = "UPDATE hazardpay SET Area = '".$area."', harzardPay = '".$pay."' WHERE hazardPayID = '".$hazardID."'";
        mysqli_query($connect, $sql);
    }

// delete hazard pay
    if($actionID == 4) {
        $hazardID = $_POST['hazardID'];

        $sql = "UPDATE hazardpay SET hazardPayStatus = 'deleted' WHERE hazardPayID = '".$hazardID."'";
        mysqli_query($connect, $sql);
    }
?>