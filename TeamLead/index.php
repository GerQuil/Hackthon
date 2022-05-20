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
            $departmentID = $teamlead['departmentID'];
            $team = $teamlead['teamName'];
            $teamID = $teamlead['teamID'];
        }
    }

    if(isset($_POST['save'])){
        echo $_POST['save'];
    }

    function weekOfMonth($date) {
        // estract date parts
        list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));
        
        // current week, min 1
        $w = 1;
        
        // for each day since the start of the month
        for ($i = 1; $i < $d; ++$i) {
            // if that day was a sunday and is not the first day of month
            if ($i > 1 && date('w', strtotime("$y-$m-$i")) == 0) {
                // increment current week
                ++$w;
            }
        }
        
        // now return
        return $w;
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

        .wfh-select {
            display: none;
        }

        .example_wrapper{
            padding-top: 3rem;
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
                    <?php
                        $qSelect = mysqli_query($link,
                            "SELECT * 
                            FROM employee 
                            WHERE leadID = '{$leadid}' AND empStat = 'active';"
                        );
                        if(mysqli_num_rows($qSelect) > 0){
                            while($emp = mysqli_fetch_array($qSelect)){
                                $qcheck = mysqli_query($link, 
                                    "SELECT * FROM employee 
                                    JOIN attendance ON attendance.leadID = '{$leadid}' 
                                    WHERE attendance.leadID = '{$leadid}' 
                                    AND DAY(attendance.attendanceStamp) = DAY(CURRENT_DATE()) 
                                    AND MONTH(attendance.attendanceStamp) = MONTH(CURRENT_DATE()) 
                                    AND YEAR(attendance.attendanceStamp) = YEAR(CURRENT_DATE()) 
                                    AND attendance.empID = '{$emp['empID']}'"
                                );
                                if(mysqli_num_rows($qcheck) == 0){
                                    ?>
                                        <tr>
                                            <td><?= $emp['empFName'] . " ". $emp['empMName'] . " ". $emp['empLName'] ?> <input type="hidden" name="empID" value="<?= $emp['empID'] ?>"></td>
                                            <td>
                                                <select name="shift" class="shift edit-select" data-live-search="true" data-width="auto ">
                                                    <?php
                                                        $qShifts = mysqli_query($link,
                                                            "SELECT * 
                                                            FROM shiftschedule;"
                                                        );
                                                        while($shift = mysqli_fetch_array($qShifts)){
                                                            ?>
                                                                <option title="<?= date('h:i A', strtotime($shift['startTime'])) ?>-<?= date('h:i A', strtotime($shift['endTime'])) ?>" value="<?= $shift['scheduleID'] ?>"><?= date('h:i A', strtotime($shift['startTime'])) ?>-<?= date('h:i A', strtotime($shift['endTime'])) ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="team" class="team edit-select" data-live-search="true" data-width="auto">
                                                    <?php
                                                        $qTeams = mysqli_query($link,
                                                            "SELECT * 
                                                            FROM hybridschedule
                                                            WHERE hybridStatus = 'active';"
                                                        );
                                                        while($team = mysqli_fetch_array($qTeams)){
                                                            $schedweeks = explode(",", $team['inclusionDays']);
                                                            foreach($schedweeks as $wSched){
                                                                $removeRightParen = explode(")", $wSched);
                                                                $schedperweek = explode("(", $removeRightParen[0]);
                                                                $dayOfweek = $schedperweek[0];
                                                                $weeksofmonth = $schedperweek[1];
                                                                $weekofmonth = explode("-", $weeksofmonth);
                                                                foreach($weekofmonth as $week){
                                                                    
                                                                    echo $dayOfweek;
                                                                    if($dayOfweek == strtolower(date('l'))){
                                                                        if($week == weekOfMonth(date('Y-m-d')) ){
                                                                            ?>
                                                                                <option title="<?= $team['hybridName'] ?>" value="<?= $team['hybridScheduleID'] ?>"><?= $team['hybridName'] ?></option>
                                                                            <?php                                                                      
                                                                        }else if($week == 4 && $week < weekOfMonth(date('Y-m-d'))){
                                                                            ?>
                                                                                <option title="<?= $team['hybridName'] ?>" value="<?= $team['hybridScheduleID'] ?>"><?= $team['hybridName'] ?></option>
                                                                            <?php                                                          
                                                                        }
                                                                    }                                                                
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <!-- work type -->
                                                <input type="hidden" name="worktype-select" class="worktype-select" value="1">
                                                <div class="onsite-select">
                                                    <select name="onsite" class="worktype onsite edit-select" data-live-search="true" data-width="auto">
                                                        <?php
                                                            $qArea = mysqli_query($link,
                                                                "SELECT * 
                                                                FROM hazardPay
                                                                WHERE hazardPayStatus = 'active';"
                                                            );
                                                            while($area = mysqli_fetch_array($qArea)){
                                                                ?>
                                                                    <option title="ONSITE-<?= $area['Area'] ?>" value="<?= $area['Area'] ?>">ONSITE-<?= $area['Area'] ?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="wfh-select">
                                                    <select name="wfh" class="worktype wfh edit-select" data-width="auto" style="display: none;">
                                                        <option value="WFH">WFH</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="pto" class="pto edit-select" data-live-search="true" data-width="auto">
                                                    <option value="0">NO LEAVE</option>
                                                    <?php
                                                        $qPTO = mysqli_query($link,
                                                            "SELECT * 
                                                            FROM paidtimeoff;"
                                                        );
                                                        while($rPTO = mysqli_fetch_array($qPTO)){
                                                            ?>
                                                                <option value="<?= $rPTO['paidTimeOffID'] ?>"><?= $rPTO['paidTimeOffName'] ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><input type="checkbox" name="holiday" class="holiday" value="holiday"></td>
                                            <td>
                                                <select name="address" class="address edit-select" data-width="auto">
                                                    <option value="WITHIN CEBU">WITHIN CEBU</option>
                                                    <option value="OUTSIDE CEBU">OUTSIDE CEBU</option>
                                                </select>
                                            </td>
                                            <td><input type="submit" name="save" value="SAVE"></td>
                                        </tr>
                                    <?php   

                                }
                            }
                        }
                    ?>
                    
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

        var teamSel = null;
        $('select[name="team"]').on('change', function() {
            console.log( this.value );
            var teamid=this.value;
            teamSel = $(this);

            $.ajax({
                url:"checkWorkType.php",
                method:"POST",
                data:{
                    hybridScheduleID: teamid
                },
                success:function(data)
                {
                    console.log(data);
                    if(data == 'ONSITE'){
                        teamSel.closest('tr').find('.onsite-select').show();    
                        teamSel.closest('tr').find('.wfh-select').hide();                   
                        teamSel.closest('tr').find('.worktype-select').val('1');                   
                        // console.log(teamSel.closest('tr').find('.worktype-select').val());                   
                    }
                    if(data == 'WFH'){
                        teamSel.closest('tr').find('.onsite-select').hide();   
                        teamSel.closest('tr').find('.wfh-select').show();             
                        teamSel.closest('tr').find('.worktype-select').val('0');    
                        // console.log(teamSel.closest('tr').find('.worktype-select').val());    
                    }
                }
            });

        });

        // save click
        var selectedTR = null;
        $('input[type="submit"]').click(function(){
            selectedTR = $(this).closest('tr');
            var empID = $(this).closest('tr').find('input[name="empID"]').val();
            var shift = $(this).closest('tr').find('select[name="shift"]').val();
            var team = $(this).closest('tr').find('select[name="team"]').val();
            var worktype = null;
            if($(this).closest('tr').find('.worktype-select').val() == 1){
                worktype = $(this).closest('tr').find('select[name="onsite"]').val();                
            }else if($(this).closest('tr').find('.worktype-select').val() == 0){
                worktype = $(this).closest('tr').find('select[name="wfh"]').val();        
            }
            var pto = $(this).closest('tr').find('select[name="pto"]').val();
            var holiday = $(this).closest('tr').find('.holiday').prop("checked");
            if(holiday){
                holiday = 'YES'
            }else{
                holiday = 'NO'
            }
            var address = $(this).closest('tr').find('select[name="address"]').val();

            var dataForm = new FormData();
            dataForm.append("empID", empID);
            dataForm.append("shift", shift);
            dataForm.append("team", team);
            dataForm.append("worktype", worktype);
            dataForm.append("pto", pto);
            dataForm.append("holiday", holiday);
            dataForm.append("address", address);
            dataForm.append("departmentID", '<?= $departmentID ?>');
            dataForm.append("teamID", '<?= $teamID ?>');
            dataForm.append("leadID", '<?= $leadid ?>');
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "attendance.php");
            xhr.onload = function(){
                console.log(this.response);
                if(this.response == 'SUCCESS'){
                    selectedTR.remove();
                }
            }
            xhr.send(dataForm);
        })

    })
</script>
</html>