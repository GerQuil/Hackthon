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
    <title>Scheduling</title>
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
            <h4>Scheduling</h4>
        </div>
        <div class="body">
            <section class="d-flex justify-content-between mt-4">
                <div class="p-3 bg-white rounded w-50 me-2 shadow">
                    <div class="headerPanel d-flex justify-content-between align-items-center">
                        <h6>Shift Schedule</h6>
                        <button type="button" class="btn btn-sm btn-primary" id="addShift" data-toggle="modal" data-target="#addShiftSchedule">Add Shift Schedule</button>
                    </div>
                    <div class="shiftSched_table_wrap mt-2 rounded bg-white">
                        <table class="shiftSched_table w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">Shift Sched ID</th>
                                    <th class="text-center">Start time</th>
                                    <th class="text-center">End time</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM shiftschedule";
                                    $query = mysqli_query($connect, $sql);
                                    if(mysqli_num_rows($query) > 0) {
                                        while($result = mysqli_fetch_assoc($query)){
                                            if($result['shiftStatus'] == "active"){
                                                echo "
                                                    <tr>
                                                        <td>".$result['scheduleID']."</td>
                                                        <td>".date("h:i A", strtotime($result['startTime']))."</td>
                                                        <td>".date("h:i A", strtotime($result['endTime']))."</td>
                                                        <td>
                                                            <button shiftID='".$result['scheduleID']."' class='btn btn-sm btn-warning editShift me-3' data-toggle='modal' data-target='#editShiftModal'>Edit</button>
                                                            <button shiftID='".$result['scheduleID']."' class='btn btn-sm btn-danger deleteShift' data-toggle='modal' data-target='#deleteShiftModal'>Delete</button>
                                                        </td>
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
                <div class="p-3 bg-white rounded w-50 ms-2 shadow">
                    <div class="headerPanel d-flex justify-content-between align-items-center">
                        <h6>Hybrid Schedule</h6>
                        <button type="button" class="btn btn-sm btn-primary" id="addHybrid" data-toggle="modal" data-target="#addHybridSchedule">Add Hybrid Schedule</button>
                    </div>
                    <div class="hybridsched_table_wrap mt-2 rounded bg-white">
                        <table class="hybridsched_schedule w-100">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10%;">Hybrid Sched ID</th>
                                    <th class="text-center" style="width: 15%;">Hybrid name</th>
                                    <th class="text-center" style="width: 30%;">Inclusion days</th>
                                    <th class="text-center" style="width: 15%;">Condition</th>
                                    <th class="text-center" style="width: 30%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM hybridschedule";
                                    $query = mysqli_query($connect, $sql);
                                    if(mysqli_num_rows($query) > 0) {
                                        while($result = mysqli_fetch_assoc($query)){
                                            if($result['hybridStatus'] == "active"){
                                                echo "
                                                    <tr>
                                                        <td>".$result['hybridScheduleID']."</td>
                                                        <td>".$result['hybridName']."</td>
                                                        <td>".$result['inclusionDays']."</td>
                                                        <td>".$result['cond']."</td>
                                                        <td>
                                                            <button hybridName='".$result['hybridName']."' hybridID='".$result['hybridScheduleID']."' class='btn btn-sm btn-warning editHybrid me-3' data-toggle='modal' data-target='#editHybridSchedule'>Edit</button>
                                                            <button hybridID='".$result['hybridScheduleID']."' class='btn btn-sm btn-danger deleteHybrid' data-toggle='modal' data-target='#deleteHybridModal'>Delete</button>
                                                        </td>
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
        </div>
    </section>
<!-- SHIFT SCHEDULE MODALS -->
    <!-- Add shift schedule modal -->
    <div class="modal fade center" id="addShiftSchedule">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add a shift</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="d-flex flex-column w-50 pe-2">
                            <p class="label-modal text-muted mb-1">Start time</p>
                            <input type="time" id="startTimeAdd">
                        </div>
                        <div class="d-flex flex-column w-50 ps-2">
                            <p class="label-modal text-muted mb-1">End time</p>
                            <input type="time" id="endTimeAdd">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="addShiftButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit shift schedule modal -->
    <div class="modal fade center" id="editShiftModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add a shift</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="d-flex flex-column w-50 pe-2">
                            <p class="label-modal text-muted mb-1">Start time</p>
                            <input type="time" id="startTimeEdit">
                        </div>
                        <div class="d-flex flex-column w-50 ps-2">
                            <p class="label-modal text-muted mb-1">End time</p>
                            <input type="time" id="endTimeEdit">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="editShiftButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete shift Modal toggled by #deleteAdmin -->
    <div class="modal fade center" id="deleteShiftModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Do you want to delete selected shift schedule?</h5>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="deleteShiftButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

<!-- HYBRID SCHEDULE MODALS -->

     <!-- Add HYBRID schedule modal -->
     <div class="modal fade center" id="addHybridSchedule">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add a hybrid schedule</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex w-100 align-items-center justify-content-between">
                        <div class="d-flex flex-column mb-2 w-50 me-3">
                            <p class="label-modal text-muted mb-1 fs-6">Hybrid name convention</p>
                            <input type="text" id="hybridNameAdd" placeholder="Team ABC">
                        </div>
                        <div class="d-flex flex-column mb-2 w-50 ms-3">
                            <p class="label-modal text-muted mb-1 fs-6">Condition</p>
                            <select id="condition" class="w-100 p-1">
                                <option value="ONSITE">ONSITE</option>
                                <option value="WFH">WFH</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Monday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="mon_choice_first">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="mon_choice_second">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="mon_choice_third">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="mon_choice_4th">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Tuesday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="tue_choice_first">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="tue_choice_second">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="tue_choice_third">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="tue_choice_4th">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Wednesday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="wed_choice_first">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="wed_choice_second">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="wed_choice_third">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="wed_choice_4th">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Thursday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="thu_choice_first">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="thu_choice_second">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="thu_choice_third">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="thu_choice_4th">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Friday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="fri_choice_first">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="fri_choice_second">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="fri_choice_third">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="fri_choice_4th">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="addHybridButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit HYBRID schedule modal -->
    <div class="modal fade center" id="editHybridSchedule">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>edit a hybrid schedule</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex w-100 align-items-center justify-content-between">
                        <div class="d-flex flex-column mb-2 w-50 me-3">
                            <p class="label-modal text-muted mb-1 fs-6">Hybrid name convention</p>
                            <input type="text" id="hybridNameEdit" placeholder="Team ABC">
                        </div>
                        <div class="d-flex flex-column mb-2 w-50 ms-3">
                            <p class="label-modal text-muted mb-1 fs-6">Condition</p>
                            <select id="conditionEdit" class="w-100 p-1">
                                <option value="ONSITE">ONSITE</option>
                                <option value="WFH">WFH</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Monday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="mon_choice_first_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="mon_choice_second_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="mon_choice_third_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="mon_choice_4th_edit">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Tuesday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="tue_choice_first_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="tue_choice_second_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="tue_choice_third_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="tue_choice_4th_edit">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Wednesday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="wed_choice_first_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="wed_choice_second_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="wed_choice_third_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="wed_choice_4th_edit">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Thursday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="thu_choice_first_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="thu_choice_second_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="thu_choice_third_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="thu_choice_4th_edit">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1 fs-6 text-center">Friday</p>
                        <div class="choice_weekly d-flex justify-content-around align-items-center ms-2">
                            <div class="d-flex justify-content-center align-items-center  me-3">
                                <p class="label-modal text-muted mb-1 me-1">1st week</p>
                                <input type="checkbox" id="fri_choice_first_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">2st week</p>
                                <input type="checkbox" id="fri_choice_second_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">3rd week</p>
                                <input type="checkbox" id="fri_choice_third_edit">
                            </div>
                            <div class="d-flex justify-content-center align-items-center me-3">
                                <p class="label-modal text-muted mb-1 me-1">4th week</p>
                                <input type="checkbox" id="fri_choice_4th_edit">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="editHybridButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete hybrid Modal toggled by #deleteAdmin -->
    <div class="modal fade center" id="deleteHybridModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Do you want to delete selected hybrid schedule?</h5>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="deleteHybridButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
    var selectedShiftID, selectedHybridID;

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

// adding of schedule
    $('#addShiftButton').click(function(){
        var startTime = $('#startTimeAdd').val();
        var endTime = $('#endTimeAdd').val();

        if(startTime == "" || endTime == ""){
            alert("Please fill in all the fields");
        } else {
            $.ajax({
                url: "schedule-control-logic.php",
                type: "POST",
                data: {
                    actionID: "1",
                    startTimeAdd: startTime,
                    endTimeAdd: endTime
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    })

// set selected shiftID 
    $(".editShift").click(function(){
        selectedShiftID = $(this).attr("shiftID");
    })

    $(".deleteShift").click(function(){
        selectedShiftID = $(this).attr("shiftID");
    })

// Edit shift button
    $('#editShiftButton').click(function(){
        var startTime = $('#startTimeEdit').val();
        var endTime = $('#endTimeEdit').val();

        if(startTime == "" || endTime == ""){
            alert("Please fill in all the fields");
        } else {
            $.ajax({
                url: "schedule-control-logic.php",
                type: "POST",
                data: {
                    actionID: "2",
                    startTimeEdit: startTime,
                    endTimeEdit: endTime,
                    shiftID: selectedShiftID
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    })

// delete a schedule
    $("#deleteShiftButton").click(function(){
        $.ajax({
            url: "schedule-control-logic.php",
            type: "POST",
            data: {
                actionID: "3",
                shiftID: selectedShiftID
            },
            success: function(data){
                location.reload();
            }
        })
    })

// add a hybrid
    $("#addHybridButton").click(function(){
        var hybridName = $('#hybridNameAdd').val();
        var inclusionDays = [];
        var cond = $("#condition option:selected").val();
        var monchecked1 = $("#mon_choice_first").prop("checked");
        var monchecked2 = $("#mon_choice_second").prop("checked");
        var monchecked3 = $("#mon_choice_third").prop("checked");
        var monchecked4 = $("#mon_choice_4th").prop("checked");
        
        var tuechecked1 = $("#tue_choice_first").prop("checked");
        var tuechecked2 = $("#tue_choice_second").prop("checked");
        var tuechecked3 = $("#tue_choice_third").prop("checked");
        var tuechecked4 = $("#tue_choice_4th").prop("checked");

        var wedchecked1 = $("#wed_choice_first").prop("checked");
        var wedchecked2 = $("#wed_choice_second").prop("checked");
        var wedchecked3 = $("#wed_choice_third").prop("checked");
        var wedchecked4 = $("#wed_choice_4th").prop("checked");

        var thuchecked1 = $("#thu_choice_first").prop("checked");
        var thuchecked2 = $("#thu_choice_second").prop("checked");
        var thuchecked3 = $("#thu_choice_third").prop("checked");
        var thuchecked4 = $("#thu_choice_4th").prop("checked");

        var frichecked1 = $("#fri_choice_first").prop("checked");
        var frichecked2 = $("#fri_choice_second").prop("checked");
        var frichecked3 = $("#fri_choice_third").prop("checked");
        var frichecked4 = $("#fri_choice_4th").prop("checked");


        if(monchecked1 == false && monchecked2 == false && monchecked3 == false && monchecked4 == false){
            
        } else {
            var monVal = "monday(";
            if(monchecked1 == true){
                monVal = monVal+"1-";;
            }

            if(monchecked2 == true){
                monVal = monVal+"2-";
            }

            if(monchecked3 == true){
                monVal = monVal+"3-";
            }

            if(monchecked4 == true){
                monVal = monVal+"4";
            }

            monVal = monVal+")"
            inclusionDays.push(monVal);
        } 

        if(tuechecked1 == false && tuechecked2 == false && tuechecked3 == false && tuechecked4 == false){
            
        } else {
            var tueVal = "tuesday(";
            if(tuechecked1 == true){
                tueVal = tueVal+"1-";;
            }

            if(tuechecked2 == true){
                tueVal = tueVal+"2-";
            }

            if(tuechecked3 == true){
                tueVal = tueVal+"3-";
            }

            if(tuechecked4 == true){
                tueVal = tueVal+"4";
            }

            tueVal = tueVal+")"
            inclusionDays.push(tueVal);
        }

        if(wedchecked1 == false && wedchecked2 == false && wedchecked3 == false && wedchecked4 == false){
            
        } else {
            var wedVal = "tuesday(";
            if(wedchecked1 == true){
                wedVal = wedVal+"1-";;
            }

            if(wedchecked2 == true){
                wedVal = wedVal+"2-";
            }

            if(wedchecked3 == true){
                wedVal = wedVal+"3-";
            }

            if(wedchecked4 == true){
                wedVal = wedVal+"4";
            }

            wedVal = wedVal+")"
            inclusionDays.push(wedVal);
        }

        if(thuchecked1 == false && thuchecked2 == false && thuchecked3 == false && thuchecked4 == false){
            
        } else {
            var thuVal = "tuesday(";
            if(thuchecked1 == true){
                thuVal = thuVal+"1-";;
            }

            if(thuchecked2 == true){
                thuVal = thuVal+"2-";
            }

            if(thuchecked3 == true){
                thuVal = thuVal+"3-";
            }

            if(thuchecked4 == true){
                thuVal = thuVal+"4";
            }

            thuVal = thuVal+")"
            inclusionDays.push(thuVal);
        }

        if(frichecked1 == false && frichecked2 == false && frichecked3 == false && frichecked4 == false){
            
        } else {
            var friVal = "tuesday(";
            if(frichecked1 == true){
                friVal = friVal+"1-";;
            }

            if(frichecked2 == true){
                friVal = friVal+"2-";
            }

            if(frichecked3 == true){
                friVal = friVal+"3-";
            }

            if(frichecked4 == true){
                friVal = friVal+"4";
            }

            friVal = friVal+")"
            inclusionDays.push(friVal);
        }
        
        if(inclusionDays.length == 0 || hybridName == ""){
            alert("Please provide all the necessary details");
        } else {
            $.ajax({
                url: "schedule-control-logic.php",
                type: "POST",
                data: {
                    actionID: "4",
                    hybridN: hybridName,
                    condition: cond,
                    dayinclusion: ""+inclusionDays
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    });

// set selected hybridID 
    $(".editHybrid").click(function(){
        selectedHybridID = $(this).attr("hybridID");
        var hybridNameData = $(this).attr("hybridName")
        $('#hybridNameEdit').val(hybridNameData);
    })

    $(".deleteHybrid").click(function(){
        selectedHybridID = $(this).attr("hybridID");
    })

// update hybrid 
    $("#editHybridButton").click(function(){
        var hybridName = $('#hybridNameEdit').val();
        var inclusionDays = [];
        var cond = $("#conditionEdit option:selected").val();
        var monchecked1 = $("#mon_choice_first_edit").prop("checked");
        var monchecked2 = $("#mon_choice_second_edit").prop("checked");
        var monchecked3 = $("#mon_choice_third_edit").prop("checked");
        var monchecked4 = $("#mon_choice_4th_edit").prop("checked");
        
        var tuechecked1 = $("#tue_choice_first_edit").prop("checked");
        var tuechecked2 = $("#tue_choice_second_edit").prop("checked");
        var tuechecked3 = $("#tue_choice_third_edit").prop("checked");
        var tuechecked4 = $("#tue_choice_4th_edit").prop("checked");

        var wedchecked1 = $("#wed_choice_first_edit").prop("checked");
        var wedchecked2 = $("#wed_choice_second_edit").prop("checked");
        var wedchecked3 = $("#wed_choice_third_edit").prop("checked");
        var wedchecked4 = $("#wed_choice_4th_edit").prop("checked");

        var thuchecked1 = $("#thu_choice_first_edit").prop("checked");
        var thuchecked2 = $("#thu_choice_second_edit").prop("checked");
        var thuchecked3 = $("#thu_choice_third_edit").prop("checked");
        var thuchecked4 = $("#thu_choice_4th_edit").prop("checked");

        var frichecked1 = $("#fri_choice_first_edit").prop("checked");
        var frichecked2 = $("#fri_choice_second_edit").prop("checked");
        var frichecked3 = $("#fri_choice_third_edit").prop("checked");
        var frichecked4 = $("#fri_choice_4th_edit").prop("checked");


        if(monchecked1 == false && monchecked2 == false && monchecked3 == false && monchecked4 == false){
            
        } else {
            var monVal = "monday(";
            if(monchecked1 == true){
                monVal = monVal+"1-";;
            }

            if(monchecked2 == true){
                monVal = monVal+"2-";
            }

            if(monchecked3 == true){
                monVal = monVal+"3-";
            }

            if(monchecked4 == true){
                monVal = monVal+"4";
            }

            monVal = monVal+")"
            inclusionDays.push(monVal);
        } 

        if(tuechecked1 == false && tuechecked2 == false && tuechecked3 == false && tuechecked4 == false){
            
        } else {
            var tueVal = "tuesday(";
            if(tuechecked1 == true){
                tueVal = tueVal+"1-";;
            }

            if(tuechecked2 == true){
                tueVal = tueVal+"2-";
            }

            if(tuechecked3 == true){
                tueVal = tueVal+"3-";
            }

            if(tuechecked4 == true){
                tueVal = tueVal+"4";
            }

            tueVal = tueVal+")"
            inclusionDays.push(tueVal);
        }

        if(wedchecked1 == false && wedchecked2 == false && wedchecked3 == false && wedchecked4 == false){
            
        } else {
            var wedVal = "tuesday(";
            if(wedchecked1 == true){
                wedVal = wedVal+"1-";;
            }

            if(wedchecked2 == true){
                wedVal = wedVal+"2-";
            }

            if(wedchecked3 == true){
                wedVal = wedVal+"3-";
            }

            if(wedchecked4 == true){
                wedVal = wedVal+"4";
            }

            wedVal = wedVal+")"
            inclusionDays.push(wedVal);
        }

        if(thuchecked1 == false && thuchecked2 == false && thuchecked3 == false && thuchecked4 == false){
            
        } else {
            var thuVal = "tuesday(";
            if(thuchecked1 == true){
                thuVal = thuVal+"1-";;
            }

            if(thuchecked2 == true){
                thuVal = thuVal+"2-";
            }

            if(thuchecked3 == true){
                thuVal = thuVal+"3-";
            }

            if(thuchecked4 == true){
                thuVal = thuVal+"4";
            }

            thuVal = thuVal+")"
            inclusionDays.push(thuVal);
        }

        if(frichecked1 == false && frichecked2 == false && frichecked3 == false && frichecked4 == false){
            
        } else {
            var friVal = "tuesday(";
            if(frichecked1 == true){
                friVal = friVal+"1-";;
            }

            if(frichecked2 == true){
                friVal = friVal+"2-";
            }

            if(frichecked3 == true){
                friVal = friVal+"3-";
            }

            if(frichecked4 == true){
                friVal = friVal+"4";
            }

            friVal = friVal+")"
            inclusionDays.push(friVal);
        }
        
        if(inclusionDays.length == 0 || hybridName == ""){
            alert("Please provide all the necessary details");
        } else {
            $.ajax({
                url: "schedule-control-logic.php",
                type: "POST",
                data: {
                    actionID: "6",
                    hybridN: hybridName,
                    condition: cond,
                    dayinclusion: ""+inclusionDays,
                    hybridID: selectedHybridID
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    });

// delete hybrid
    $("#deleteHybridButton").click(function(){
        $.ajax({
            url: "schedule-control-logic.php",
            type: "POST",
            data: {
                actionID: "5",
                hybridID: selectedHybridID
            },
            success: function(data){
                location.reload();
            }
        })
    })

    </script>
</html>