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
    <title>Teams</title>
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
        <div class="header d-flex justify-content-between align-items-center">
            <h4>Teams</h4>
            <div class="d-flex justify-content-between align-items-center" style="width: 305px;">
                <input id="addTeamName" type="text" placeholder="Team name" class="p-1">
                <button type="button" class="btn btn-primary" id="addTeamButton">Add Team</button>
            </div>
        </div>
        <div class="body">
            <div class="department_table_wrap mt-5 rounded bg-white">
                <table class="team_table w-100">
                    <thead>
                        <tr>
                            <th class="text-center">Team ID</th>
                            <th class="text-center">Team Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM team";
                            $query = mysqli_query($connect, $sql);
                            if(mysqli_num_rows($query) > 0) {
                                while($result = mysqli_fetch_assoc($query)){
                                    if($result['teamStatus'] == "active"){
                                        echo "
                                            <tr>
                                                <td>".$result['teamID']."</td>
                                                <td>".$result['teamName']."</td>
                                                <td>
                                                    <button teamID='".$result['teamID']."' teamName='".$result['teamName']."' class='btn btn-sm btn-warning editTeam me-3' data-toggle='modal' data-target='#editTeamModal'>Edit</button>
                                                    <button teamID='".$result['teamID']."' class='btn btn-sm btn-danger deleteTeam' data-toggle='modal' data-target='#deleteDepartmentModal'>Delete</button>
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
     <!-- edit team Modal toggled by .editTeam -->
     <div class="modal fade center" id="editTeamModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit team name</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Team name</p>
                        <input type="text" id="teamNameEdit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="editTeamButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete team Modal toggled by #deleteTeam -->
    <div class="modal fade center" id="deleteDepartmentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Do you want to delete selected team?</h5>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="deleteTeamButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
    var selectedTeamID;
        
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

// Add Team
    $("#addTeamButton").click(function(){
        var teamNameI = $("#addTeamName").val();
        if(teamNameI == ""){
            alert("Please input a valid team name");
        } else {
            $.ajax({
                url: "team-control-logic.php",
                type: "POST",
                data: {
                    actionID: "1",
                    teamName: teamNameI
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    })

// set selected TeamID 
    $(".editTeam").click(function(){
        selectedTeamID = $(this).attr("teamID");
        var selectedTeamName = $(this).attr("teamName");

        $("#teamNameEdit").val(selectedTeamName);
    })

    $(".deleteTeam").click(function(){
        selectedTeamID = $(this).attr("teamID");
    })

// edit team name
    $("#editTeamButton").click(function(){
        var newTeamName = $("#teamNameEdit").val().toUpperCase();
        if(newTeamName == ""){
            alert("Please input a valid name for the team")
        } else {
            $.ajax({
                url: "team-control-logic.php",
                type: "POST",
                data: {
                    actionID: "2",
                    teamName: newTeamName,
                    teamID: selectedTeamID
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    })

// delete team 
    $("#deleteTeamButton").click(function(){
        $.ajax({
                url: "team-control-logic.php",
                type: "POST",
                data: {
                    actionID: "3",
                    teamID: selectedTeamID
                },
                success: function(data){
                    location.reload();
                }
            })
    })
    </script>
</html>