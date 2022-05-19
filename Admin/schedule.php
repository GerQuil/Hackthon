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
    <!-- delete department Modal toggled by #deleteAdmin -->
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

// bookmark
    // $("#addHybridButton").click(function(){
    //     var inlusionDays;
    //     var 
    //     if()
    // });


    </script>
</html>