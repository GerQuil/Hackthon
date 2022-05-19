<?php
    session_start();
    include('dbConnect.php');
    if(!isset($_SESSION['adminID'])){
        header("location: login.php");
        exit();     
    }

    $leadid = $_GET['leadid'];

    if(isset($_POST['update'])){
        mysqli_query($connect, 
            "UPDATE teamlead
            SET 
                leadFName = '{$_POST['fname']}',
                leadMName = '{$_POST['mname']}',
                leadLName = '{$_POST['lname']}',
                leadEmail = '{$_POST['email']}',
                leadPassword = '{$_POST['password']}',
                departmentID  = '{$_POST['editTeamLeadDepartment']}',
                teamID  = '{$_POST['editTeamLeadTeam']}'
            WHERE leadid = '{$leadid}'; ");
        header('location: users.php');
        exit;
    }

    $qSelect =  mysqli_query($connect, "SELECT * FROM teamlead  WHERE leadID = '{$leadid}';");
    $teamlead = mysqli_fetch_assoc($qSelect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit team lead</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
</head>
<body style="display: flex; justify-content: center; align-content: center; height: 100vh;">
    <a href="users.php" style="position: absolute; top: 15px; left: 15px; right: auto; bottom: auto; margin: auto;">back</a>
    <form action="editteamlead.php?leadid=<?= $leadid ?>" method="post" style="display: flex; flex-direction: column; justify-content: space-around; width: 400px; height: 750px; margin: 3rem; padding: 2rem; box-shadow: 0 3px 6px rgba(0,0,0,.25); position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: auto;">
        <h1 class="text-center mb-2">Update Team Lead</h1>
        <input type="text" name="fname" value="<?= $teamlead['leadFName'] ?>" placeholder="First Name" >
        <input type="text" name="mname" value="<?= $teamlead['leadMName'] ?>" placeholder="Middle Name" >
        <input type="text" name="lname" value="<?= $teamlead['leadLName'] ?>" placeholder="Last Name"  >
        <input type="text" name="email" value="<?= $teamlead['leadEmail'] ?>" placeholder="Email"  >
        <input type="text" name="password" value="" placeholder="Password"  >
        <div style="display: flex; justify-content: space-between;">
            <label class="">Department</label>
            <select name="editTeamLeadDepartment" id="" >
                <?php
                    $qSelect = mysqli_query($connect, 
                        "SELECT * FROM  department"
                    );
                    while($department = mysqli_fetch_array($qSelect)){
                        ?>
                            <option value="<?= $department['departmentID'] ?>" <?php if($teamlead['departmentID'] == $department['departmentID']) echo "selected"; ?>><?= $department['departmentName'] ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <label class="">Team</label>
            <select name="editTeamLeadTeam" id="" style="margin-bottom: 1rem;">
                <?php
                    $qSelect = mysqli_query($connect, 
                        "SELECT * FROM team"
                    );
                    while($department = mysqli_fetch_array($qSelect)){
                        ?>
                            <option value="<?= $department['teamID'] ?>" <?php if($teamlead['teamID'] == $department['teamID']) echo "selected"; ?>><?= $department['teamName'] ?></option>
                        <?php
                    }
                ?>
            </select>            
        </div>

        <button type="submit" name="update"  class="btn btn-secondary">UPDATE</button>
    </form>
</body>
</html>