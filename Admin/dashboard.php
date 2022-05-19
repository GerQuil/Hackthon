<?php
session_start();
    include('dbConnect.php');
    if(! isset($_SESSION['adminID'])){
        header("location: login.php");
        exit();     
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard</title>
</head>
<body>
    <section>
        <div class="navigation d-flex flex-column align-items-center px-4">
            <div class="nav_title my-5">
                <h4>Employee Tracker</h4>
            </div>
            <div class="nav_directory mb-3 w-100 d-flex flex-column">
                <a href="dashboard.php" class="text-muted mb-2">Dashboard</a>
                <a href="users.php" class="text-muted mb-2">Users</a>
                <a href="department.php" class="text-muted mb-2">Departments</a>
                <a href="team.php" class="text-muted mb-2">Teams</a>
                <a href="schedule.php" class="text-muted mb-2">Scheduling</a>
                <a href="employees.php" class="text-muted mb-2">Employees</a>
                <a href="payInfo.php" class="text-muted mb-2">Pay Information</a>
            </div>
            <div class="logout">
                <p class="m-0 text-muted mb-2 logout-button">Logout</p>
            </div>
        </div>
    </section>
    <section class="main_content py-5">
        <div class="header">
            <h4>Dashboard</h4>
        </div>
        <div class="body">
        <div class="dash_table_wrap mt-5 rounded bg-white">
                <table class="dash_table w-100">
                    <thead>
                        <tr>
                            <th class="text-center">Department</th>
                            <th class="text-center">Employee name</th>
                            <th class="text-center">Shift Start</th>
                            <th class="text-center">Shift End</th>
                            <th class="text-center">Group/Team</th>
                            <th class="text-center">On PTO</th>
                            <th class="text-center">Holiday off</th>
                            <th class="text-center">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM attendance JOIN employee ON attendance.empID = employee.empID
                            JOIN department ON attendance.departmentID = department.departmentID
                            JOIN hybridschedule ON attendance.hybridSchedID = hybridschedule.hybridScheduleID ORDER BY department.departmentID ASC";
                            $query = mysqli_query($connect, $sql);
                            if(mysqli_num_rows($query) > 0) {
                                while($result = mysqli_fetch_assoc($query)){
                                    if($result['empStat'] == "active"){
                                        echo "
                                            <tr>
                                                
                                                <td>".$result['departmentName']."</td>
                                                <td>".$result['empFName']." ".$result['empLName']."</td>
                                                <td>".$result['start_time']."</td>
                                                <td>".$result['end_time']."</td>
                                                <td>".$result['hybridName']."</td>
                                            ";
                                        if($result["paidTimeOffID"] == 0){
                                            echo "<td>N/A</td>";
                                        } else if($result["paidTimeOffID"] == 1) {
                                            echo "<td>PLANNED LEAVE</td>";
                                        } else {
                                            echo "<td>UNPLANNED LEAVE</td>";
                                        }
                                        echo"
                                                <td>".$result['holiday']."</td>
                                                <td>".$result['location']."</td>
                                            </tr>
                                        ";
                                    }
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">

// Logout action
    $(".logout").click(function(){
        $.ajax({
            url: "admin-profile-control.php",
            type: "POST",
            data: {
                actionID: "2",
            },
            success: function(data){
                window.location = 'login.php';
            }
        })
    });

    </script>
</html>