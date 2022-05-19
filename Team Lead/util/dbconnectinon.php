<?php
    $link = mysqli_connect(
        "localhost", 
        "root", 
        ""
    );
        
    if($link){
        mysqli_select_db($link, "employeetracker"); 
    }else{
        echo"error"; // change this to this -->> header("Location: index.php");
        die;
    }
?>