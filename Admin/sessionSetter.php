<?php
     session_start();
     include('dbConnect.php');
 
     $_SESSION["adminID"] = null;
     $_SESSION["fName"] = null;
     $_SESSION["lName"] = null;
     $_SESSION["mName"] = null;
     $_SESSION["email"] = null;
     $_SESSION["pass"] = null;

     $email = $_POST['emailInput'];
        $password = $_POST['passwordInput'];
        $sql = "SELECT * FROM admin WHERE adminEmail = '".$email."' AND adminPassword = '".$password."'";
        $query = mysqli_query($connect, $sql);
        if(mysqli_num_rows($query)== 0) {
            echo "Incorrect email or password";
        } else {
            while($result = mysqli_fetch_assoc($query)){
                if($result["adminEmail"] == $email && $result["adminPassword"] == $password) {
                    $_SESSION["adminID"] = $result['adminID'];
                    $_SESSION["fName"] = $result['adminFName'];
                    $_SESSION["lName"] = $result['adminLName'];
                    $_SESSION["mName"] = $result['adminMName'];
                    $_SESSION["email"] = $result['adminEmail'];
                    $_SESSION["pass"] = $result['adminPassword'];
                    echo "Login successful";
                }
            }
        }
 
?>