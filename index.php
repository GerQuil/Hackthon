<?php
  date_default_timezone_set("Asia/Manila");
  $link = mysqli_connect("localhost", "root", "");
      
  if($link){
    mysqli_select_db($link, "employeetracker"); 
  }else{
    echo"error"; 
    die;
  }


  if(isset($_POST['login'])){
    $email =  $_POST['email'];
    $password =  $_POST['password'];
    $qSelect = mysqli_query($link,
        "SELECT * FROM teamlead WHERE leadEmail = '{$email}' AND leadPassword = '{$password}'"
    );
    if(mysqli_num_rows($qSelect) > 0){
        while($teamlead = mysqli_fetch_array($qSelect)){
            $_SESSION['leadid'] = $teamlead['leadID'];
            header('location: TeamLead/index.php');
            exit;
        }
    }


  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login Page</title>
</head>
<body>
    <center style="position:relative; top: 10rem;">
        <h2>Employee Tracker Login</h2><br>
        <form action="index.php" method="POST" action="login.php">
            <input type="text" name="email" placeholder="Email/Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button class="btn-primary" type="submit" name="login">Login</button>
        </form>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>