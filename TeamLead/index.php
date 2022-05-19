<?php
    date_default_timezone_set("Asia/Manila");
    session_start();
    $link = mysqli_connect("localhost", "root", "");
        
    if($link){
        mysqli_select_db($link, "employeetracker"); 
    }else{
        echo"error"; 
        die;
    }

    if(isset($_GET['logout'])){
        session_destroy();
        header('location: ../index.php');
        exit;
    }

    if(isset($_SESSION['leadid'])){
        $leadid = $_SESSION['leadid'];
    }else{
        header('location: ../index.php');
        exit;
    }

    $qSelect = mysqli_query($link,
        "SELECT * 
        FROM teamlead 
        JOIN department
        ON department.departmentID = teamlead.departmentID
        JOIN  team
        ON team.teamID = teamlead.teamID
        WHERE leadID = '{$leadid}'"
    );
    if(mysqli_num_rows($qSelect) > 0){
        while($teamlead = mysqli_fetch_array($qSelect)){
            $name = $teamlead['leadFName'] . " " . $teamlead['leadMName'] . " " . $teamlead['leadLName'];
            $department = $teamlead['departmentName'];
            $team = $teamlead['teamName'];
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Lead Dashboard</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- select picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
    <style>
        .result {
            width: 90%; z-index: 100;
            max-height: 300px; overflow: auto;
        }
    </style>

    <!-- table extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

</head>
<body style="background-color: #f2f2f2;">
    
    <div class="teamleaninfo py-3">
        <div class="container">
            <div class="content-hbetween">
                <div class="flex-v">
                    <div class="department"><?= $department ?></div>
                    <div class="teamname"><?= $team ?></div>
                </div>

                <div class="flex-h">
                    <div class="content-right">
                        <div class="leadname"><?= $name ?></div>
                        <a href="index.php?logout=1">LOGOUT</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <section class="py-2">
        <div class="container overflow-auto">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>EMPLOYEE NAME</th>
                        <th>SHIFT SCHEDULE</th>
                        <th>GROUP/TEAM</th>
                        <th>WORK TYPE</th>
                        <th>ON PTO</th>
                        <th>HOLIDAY OFF</th>
                        <th>LOCATION</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="" method="post">
                        <tr>
                            <td>Tiger Nixon <input type="hidden" name="empID" value="1"></td>
                            <td>
                                <select name="shift" class="shift edit-select" data-live-search="true" data-width="auto ">
                                    <option title="shift1" value="shift1">shift1</option>
                                    <option title="shift2" value="shift2">shift2</option>
                                </select>
                            </td>
                            <td>
                                <select name="team" class="team edit-select" data-live-search="true" data-width="auto">
                                    <option title="Team1" value="Team1">Team1</option>
                                    <option title="Team2"  value="">Team2</option>
                                    <option  title="Team2Team2" value="">Team2Team2</option>
                                </select>
                            </td>
                            <td>
                                <select name="worktype">
                                    <option value="WFH">WFH</option>
                                    <option value="ONSITE">ONSITE</option>
                                </select>
                            </td>
                            <td>
                                <select name="pto">
                                    <option value="PLANNED LEAVE">PLANNED LEAVE</option>
                                    <option value="UNPLANNED LEAVE">UNPLANNED LEAVE</option>
                                </select>
                            </td>
                            <td><input type="checkbox" name="holiday" ></td>
                            <td><input type="text" name="address" placeholder="Address" required></td>
                            <td><button type="submit">SAVE</button></td>
                        </tr>
                    </form>
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </tfoot> -->
            </table>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
</body>
<script>
    $(document).ready(function(){
        $('.edit-select').selectpicker();
    })
</script>
</html>