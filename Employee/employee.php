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
    $bonus = "";
    $hazard = 0;
    $hazardpay = 0;
    $ctr = 0;
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
                <option value="All">Show All Records</option>
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
            </select><br>
            
        </div>
        <?php 
            if($connect){
                $sql = "SELECT * from attendance 
                JOIN employee ON attendance.empID = employee.empID 
                JOIN department ON attendance.departmentID = department.departmentID
                JOIN team ON attendance.teamID = team.teamID
                JOIN teamlead ON attendance.leadID = teamlead.leadID
                JOIN paidtimeoff ON attendance.paidTimeOffID = paidtimeoff.paidTimeOffID
                JOIN hybridschedule ON attendance.hybridSchedID = hybridschedule.hybridScheduleID
                JOIN hazardpay ON attendance.workType = hazardpay.Area
                WHERE employee.empID = attendance.empID";
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
                        $shiftstart = date("h:i a", strtotime($r['start_time']));
                        $shiftend = date("h:i a", strtotime($r['end_time']));
                        $teamhybrid = $r['hybridName'];
                        $date = date("M j, Y", strtotime($r['attendanceStamp']));
                        if($worktype != "WFH"){
                            $ctr++;  
                            $hazard += $r['harzardPay'];  
                        }
                        
                        echo "<div class='employee-card' id='info-tile'>";
                            echo "<div style='display: flex'>";
                                echo "<div style='position: relative; margin: auto; top: 10px;  width:30%;'>";
                                    echo "<b>Department Name:</b>";
                                    echo "<p id='department'>$department</p>";
                                echo "</div>";
                                echo "<div style='position: relative; margin: auto; top: 10px;  width:30%;'>";
                                    echo "<b>Team Name:</b>";
                                    echo "<p id='team'>$team</p>";
                                echo "</div>";
                                echo "<div style='position: relative; margin: auto; top: 10px;  width:30%;'>";
                                    echo "<b>Lead Name:</b>";
                                    echo "<p id='lead'>$leadfirst $leadmid $leadlast</p>";
                                echo "</div>";
                                echo '<div style="position: relative; margin: auto; top: 10px;  width:30%;">';
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
                            echo "<td class='worktype'>$worktype</td>";
                            echo "<td>$pto</td>";
                            echo "<td>$holiday</td>";
                            echo "<td>$location</td>";
                            echo "</tr>";
                            echo "</tbody>";
                            echo "</table>";
                        echo "</div><br><br>";

                    }
                    $bonus = 1000 / 20 * $ctr;
                    $hazard *= $ctr;
                    //hazardpay *= $ctr;
                    
                    echo "<b>Accumulated Pro-Rated Attendance Bonus:</b>";
                    echo "<p class='bonus' style='color:green; font-weight:bold;'>Php $bonus.00</p>";
                    echo "<b>Accumulated Pro-Rated Hazard Pay:</b>";
                    echo "<p class='hazard'  style='color:green; font-weight:bold;'>Php $hazard.00</p>";
                }
            } 
        ?>
    </a>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).on("change", "#months", function(){
        mon=$(this).val();
        var sumofworkdays = 0;
        var monthbonus = 0;
        var monthhazard = 0;
        if(mon == 'All'){
            $('.employee-card').removeClass('d-none');
            location.reload();
        }else{
            $('.employee-card').removeClass('d-none');
            $('.employee-card').find('.date:not(:contains("'+mon+'"))').parent().parent().parent().addClass('d-none');
            
            $('.employee-card').find('.date:contains("'+mon+'")').parent().parent().parent().find('.worktype').each(function(){
            var worktypedata = $(this).html();
                if(worktypedata != 'WFH'){
                    sumofworkdays++; 
                } 
                if(worktypedata == 'Area 1'){
                    monthhazard += 50;
                }
                if(worktypedata == 'Area 2'){
                    monthhazard += 100;
                }
                if(worktypedata == 'Area 3'){
                    monthhazard += 125;
                }
                if(worktypedata == 'Area 4'){
                    monthhazard += 150;
                }
            });
            var totmonthhazard = monthhazard * sumofworkdays;
            $('.hazard').text('Php '+totmonthhazard+'.00');
            monthbonus = 1000/20 * sumofworkdays;
            $('.bonus').text('Php '+monthbonus+'.00');
        }
    });
</script>
</html>