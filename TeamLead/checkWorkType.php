<?php  
    date_default_timezone_set("Asia/Manila");
    $link = mysqli_connect("localhost", "root", "");
        
    if($link){
        mysqli_select_db($link, "employeetracker"); 
    }else{
        echo"error"; 
        die;
    }

    $hybridScheduleID = $_POST['hybridScheduleID'];

    $qArea = mysqli_query($link,
        "SELECT *
        FROM hybridschedule
        WHERE hybridScheduleID = '{$hybridScheduleID}';"
    );
    while($area = mysqli_fetch_array($qArea)){
        echo $area['cond'];
    }
