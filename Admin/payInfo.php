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
    <title>Pay Information</title>
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
            <h4>Pay Information</h4>
        </div>
        <div class="body">
            <div class="rounded bg-white p-3 mt-4 shadow d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6>Attendance Bonus</h6>
                    <?php
                        $sql = "SELECT * FROM attendancebonus";
                        $query = mysqli_query($connect, $sql);
                        if(mysqli_num_rows($query)){
                            while($result=mysqli_fetch_assoc($query)){
                                echo "<h5><strong>".$result['bonusPrice']."</strong></h5>";
                            }
                        }
                    ?>
                </div>
                <button class="btn btn-warning" data-toggle="modal" data-target="#editAttendanceBonus">Edit</button>
            </div>
            <div class="rounded bg-white p-3 mt-4 shadow d-flex flex-column">
                <div class="header d-flex justify-content-between align-items-center w-100 mb-3">
                    <h6>Hazard pay</h6>
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addHazardPayModal">Add hazard pay information</button>
                </div>
                <div class="hazard_table_wrap mt-2 rounded bg-white">
                    <table class="hybridsched_schedule w-100">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%;">Hazard Pay ID</th>
                                <th class="text-center" style="width: 15%;">Area</th>
                                <th class="text-center" style="width: 30%;">Hazard pay</th>
                                <th class="text-center" style="width: 30%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM hazardpay";
                                $query = mysqli_query($connect, $sql);
                                if(mysqli_num_rows($query) > 0) {
                                    while($result = mysqli_fetch_assoc($query)){
                                        if($result['hazardPayStatus'] == "active"){
                                            echo "
                                                <tr>
                                                    <td>".$result['hazardPayID']."</td>
                                                    <td>".$result['Area']."</td>
                                                    <td>".$result['harzardPay']."</td>
                                                    <td>
                                                        <button areaName='".$result['Area']."' hpID='".$result['hazardPayID']."' hpPay = '".$result['harzardPay']."' class='btn btn-sm btn-warning editHazard me-3' data-toggle='modal' data-target='#editHazardModal'>Edit</button>
                                                        <button hpID='".$result['hazardPayID']."' class='btn btn-sm btn-danger deleteHazard' data-toggle='modal' data-target='#deleteHazardModal'>Delete</button>
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
        </div>
    </section>

    <!-- Edit attendance bonus modal -->
    <div class="modal fade center" id="editAttendanceBonus">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit attendance bonus</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column w-100 pe-2">
                        <p class="label-modal text-muted mb-1">Bonus</p>
                        <input type="number" id="editBonusField" placeholder="12345">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="editBonusButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add hazard pay modal -->
    <div class="modal fade center" id="addHazardPayModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add hazard pay</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column w-100 pe-2 mb-3">
                        <p class="label-modal text-muted mb-1">Area</p>
                        <input type="text" id="addHazardArea" placeholder="Area ABC">
                    </div>
                    <div class="d-flex flex-column w-100 pe-2">
                        <p class="label-modal text-muted mb-1">Hazard Pay</p>
                        <input type="text" id="addHazardPayNum" placeholder="12345">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="addHazardPayButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit hazard pay modal -->
    <div class="modal fade center" id="editHazardModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit hazard pay</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column w-100 pe-2 mb-3">
                        <p class="label-modal text-muted mb-1">Area</p>
                        <input type="text" id="editHazardArea" placeholder="Area ABC">
                    </div>
                    <div class="d-flex flex-column w-100 pe-2">
                        <p class="label-modal text-muted mb-1">Hazard Pay</p>
                        <input type="text" id="editHazardPayNum" placeholder="12345">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="editHazardPayButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete hazard Modal toggled by #deleteAdmin -->
    <div class="modal fade center" id="deleteHazardModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Do you want to delete selected hazard pay information?</h5>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="deleteHazardButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
    var selectedHazardID;
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

// edit attendance bonus
    $("#editBonusButton").click(function(){
        var bonusEdit = $("#editBonusField").val();
        if(bonusEdit == ""){
            alert("Please fill in the field")
        } else {
            $.ajax({
                url: "pay-control-logic.php",
                type: "POST",
                data: {
                    actionID: "1",
                    attendanceBonus: bonusEdit
                },
                success: function(data){
                    location.reload();
                }
            })
        }
        
    });

// Add hazard pay
    $("#addHazardPayButton").click(function(){
        var hazardArea = $("#addHazardArea").val();
        var hazardPay = $("#addHazardPayNum").val();

        if(hazardArea == "" || hazardPay == ""){
            alert("Please fill in all the fields");
        } else {
            $.ajax({
                url: "pay-control-logic.php",
                type: "POST",
                data: {
                    actionID: "2",
                    area: hazardArea,
                    pay: hazardPay
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    });

// set Selected hazard ID
    $(".editHazard").click(function(){
        selectedHazardID = $(this).attr("hpID");
        var area = $(this).attr("areaName");
        var pay = $(this).attr("hpPay");

        $("#editHazardArea").val(area);
        $("#editHazardPayNum").val(pay);
    });

    $(".deleteHazard").click(function(){
        selectedHazardID = $(this).attr("hpID");
    });

// Edit Hazard info
    $("#editHazardPayButton").click(function(){
        var editArea = $("#editHazardArea").val();
        var editPay = $("#editHazardPayNum").val();

        if(editArea == "" || editPay == ""){
            alert("Please enter valid inputs in all fields");
        } else {
            $.ajax({
                url: "pay-control-logic.php",
                type: "POST",
                data: {
                    actionID: "3",
                    area: editArea,
                    pay: editPay,
                    hazardID: selectedHazardID
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    })

// Delete hazard info
    $("#deleteHazardButton").click(function(){
        $.ajax({
            url: "pay-control-logic.php",
            type: "POST",
            data: {
                actionID: "4",
                hazardID: selectedHazardID
            },
            success: function(data){
                location.reload();
            }
        })
        
    })
    </script>
</html>