<?php
    session_start();
    include('dbConnect.php');
    $first = $_SESSION['fName'];
    $last = $_SESSION['lName'];

    $department = "";
    $team = "";
    $leadfirst = "";
    $leadmid = "";
    $leadlast = "";
    $shift = "";
    $teamhybrid = "";
    $worktype = "";
    $pto = "";
    $holiday = "";
    $location = "";
    $date = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="styles.css?v=2">
    <title>Employee Dashboard</title>
</head>
<body>
    <div class="container">
        <h3 style="position: relative; top: 20px;">Welcome, <?= $first; ?> <?= $last; ?> </h3><br>
        <a href="login.php?flag=logout"><span class="fa fa-sign-out"></span> Logout</a>
        <div class="text-end">
            <b style="position: relative; top: 20px;">Filter by Month:</b>
            <select name="months" id="months">
                <option value="Jan">January</option>
                <option value="Feb">February</option>
                <option value="Mar">March</option>
                <option value="Apr">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="Aug">August</option>
                <option value="Sept">September</option>
                <option value="Oct">October</option>
                <option value="Nov">November</option>
                <option value="Dec">December</option>
                <option value="All">Show All Records</option>
            </select>
        </div>
        <?php 
            if($connect){
                $sql = "SELECT * from attendance 
                JOIN employee ON attendance.empID = employee.empID 
                JOIN department ON attendance.departmentID = department.departmentID
                JOIN team ON attendance.teamID = team.teamID
                JOIN teamlead ON attendance.leadID = teamlead.leadID
                JOIN paidtimeoff ON attendance.paidTimeOffID = paidtimeoff.paidTimeOffID
                JOIN shiftschedule ON attendance.scheduleID = shiftschedule.scheduleID
                JOIN hybridschedule ON attendance.hybridSchedID = hybridschedule.hybridScheduleID";
                $query = mysqli_query($connect,$sql);
                if(mysqli_num_rows($query) > 0){
                    while($r = mysqli_fetch_assoc($query)){
                        $department = $r['departmentName'];
                        $team = $r['teamName'];
                        $leadfirst = $r['leadFName'];
                        $leadmid = $r['leadMName'];
                        $leadlast = $r['leadLName'];
                        $worktype = $r['workType'];
                        $pto = $r['paidTimeOffName'];
                        $holiday = $r['holiday'];
                        $location = $r['location'];
                        $shiftstart = date("h:i a", strtotime($r['startTime']));
                        $shiftend = date("h:i a", strtotime($r['endTime']));
                        $teamhybrid = $r['hybridName'];
                        $date = date("M j, Y", strtotime($r['attendanceStamp']));
                        
                        echo "<div class='employee-card' id='info-tile'>";
                            echo "<div style='display: flex'>";
                                echo "<div class='text-start' style='position: relative; margin: auto; top: 10px;  width:30%;'>";
                                    echo "<b>Department Name:</b>";
                                    echo "<p id='department'>$department</p>";
                                echo "</div>";
                                echo "<div class='text-center' style='position: relative; margin: auto; top: 10px;  width:30%;'>";
                                    echo "<b>Team Name:</b>";
                                    echo "<p id='team'>$team</p>";
                                echo "</div>";
                                echo "<div class='text-end' style='position: relative; margin: auto; top: 10px;  width:30%;'>";
                                    echo "<b>Lead Name:</b>";
                                    echo "<p id='lead'>$leadfirst $leadmid $leadlast</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div style='display: flex; margin-top: 50px;'>";
                                echo "<div class='text-start' style='position: relative; margin: auto; top: 10px; width:30%;'>";
                                    echo "<b>Accumulated Pro-Rated Attendance Bonus:</b>";
                                    echo "<p id='department'>$department</p>";
                                echo "</div>";
                                echo '<div class="text-center" style="position: relative; margin: auto; top: 10px; width:30%;">';
                                    echo '<b>Accumulated Pro-Rated Hazard Pay:</b>';
                                    echo "<p id='department'>$department</p>";
                                echo "</div>";
                                echo '<div class="text-end" style="position: relative; margin: auto; top: 10px;  width:30%;">';
                                    echo '<b>Date:</b>';
                                    echo "<p id='date' class='date''>$date</p>";
                                echo "</div>";
                            echo "</div><br>";
                            echo "<table class='table'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th scope='col'>Shift Scheduling</th>";
                            echo "<th scope='col'>Group/Team</th>";
                            echo "<th scope='col'>Work Type</th>";
                            echo "<th scope='col'>PTO</th>";
                            echo "<th scope='col'>Holiday Off</th>";
                            echo "<th scope='col'>Location</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            echo "<tr>";
                            echo "<td>$shiftstart - $shiftend</td>";
                            echo "<td>$teamhybrid</td>";
                            echo "<td>$worktype</td>";
                            echo "<td>$pto</td>";
                            echo "<td>$holiday</td>";
                            echo "<td>$location</td>";
                            echo "</tr>";
                            echo "</tbody>";
                            echo "</table>";
                        echo "</div><br>";
                    }
                }
            } 
        ?>
    </a>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).on("change", "#months", function(){
        mon=$(this).val();
        if(mon == 'All'){
            $('.employee-card').removeClass('d-none');
        }else{
            $('.employee-card').removeClass('d-none');
            $('.employee-card').find('.date:not(:contains("'+mon+'"))').parent().parent().parent().addClass('d-none');
        }
    });
</script>
</html>