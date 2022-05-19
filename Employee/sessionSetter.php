<?php
     session_start();
     include('dbConnect.php');
 
     $_SESSION["empID"] = null;
     $_SESSION["fName"] = null;
     $_SESSION["lName"] = null;
     $_SESSION["MName"] = null;

     $email = $_POST['emailInput'];
        $password = $_POST['passwordInput'];
        $sql = "SELECT * FROM employee WHERE empEmail = '".$email."' AND empPassword = '".$password."'";
        $query = mysqli_query($connect, $sql);
        if(mysqli_num_rows($query)== 0) {
            echo "Incorrect email or password";
        } else {
            while($result = mysqli_fetch_assoc($query)){
                if($result["empEmail"] = $email && $result["empPassword"] = $password) {
                    $_SESSION["empID"] = $result['empID'];
                    $_SESSION["fName"] = $result['empFName'];
                    $_SESSION["lName"] = $result['empLName'];
                    $_SESSION["MName"] = $result['empMName'];

                    echo "Login successful";
                }
            }
        }
 
?>