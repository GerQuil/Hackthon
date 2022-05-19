<?php
session_start();
    include('dbConnect.php');
    if(!isset($_SESSION['adminID'])){
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
    <title>Users</title>
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
        <div class="header d-flex align-items-center justify-content-between">
            <h4>Users</h4>
            <div class="d-flex justify-content-between align-items-center" style="width: 250px;">
                <button type="button" class="btn btn-primary" id="addAdminTrigger" data-toggle="modal" data-target="#addAdminModal">Add Admin</button>
                <button type="button" class="btn btn-primary" id="addTeamLeadTrigger" data-toggle="modal" data-target="#addTeamLeadModal">Add Team Lead</button>
            </div>
        </div>
        <div class="body">
            <div class="user_nav mt-3" style="width: 250px;">
                <button type="button" class="btn btn-secondary">Admins</button>
                <button type="button" class="btn">Team Leads</button>
            </div>
            <div class="admin_list">
                <h1>ADmin</h1>
            </div>
            <div class="teamLead_list">
                <h1>TeamLead</h1>
            </div>
        </div>
    </section>

    <!-- add admin Modal toggled by #addAdminTrigger -->
    <div class="modal fade center" id="addAdminModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Admin</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">First name</p>
                        <input type="text" id="addAdminFname" placeholder="John">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Middle name</p>
                        <input type="text" id="addAdminMname" placeholder="Summer">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Last name</p>
                        <input type="text" id="addAdminLname" placeholder="Doe">
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">email</p>
                        <input type="email" id="addAdminEmail" placeholder="example123@email.com">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Password</p>
                        <input type="password" id="addAdminPass" placeholder="mypassword!">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="addAdminButton" class="btn btn-success">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add team lead Modal toggled by #addTeamLeadTrigger -->
    <div class="modal fade center" id="addTeamLeadModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Team Lead</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">First name</p>
                        <input type="text" id="addAdminFname" placeholder="John">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Middle name</p>
                        <input type="text" id="addAdminMname" placeholder="Summer">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Last name</p>
                        <input type="text" id="addAdminLname" placeholder="Doe">
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">email</p>
                        <input type="email" id="addAdminEmail" placeholder="example123@email.com">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Password</p>
                        <input type="password" id="addAdminPass" placeholder="mypassword!">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="addAdminButton" class="btn btn-success">Continue</button>
                </div>
            </div>
        </div>
    </div>
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

// Add admin
    $("#addAdminButton").click(function(){
        var aFname = $('#addAdminFname').val();
        var aMname = $('#addAdminMname').val();
        var aLname = $('#addAdminLname').val();
        var aEmail = $('#addAdminEmail').val();
        var aPass = $('#addAdminPass').val();

        if(aFname == "" || aMname == "" || aLname == "" || aEmail == "" || aPass == "") {
            alert("Please fill in all the fields");
        } else {
            $.ajax({
                url: "admin-profile-control.php",
                type: "POST",
                data: {
                    actionID: "3",
                    fname: aFname,
                    mname: aMname,
                    lname: aLname,
                    email: aEmail,
                    pass: aPass
                },
                success: function(data){
                    alert("Admin added");
                    window.location =  'users.php';
                    
                }
            })
        }
    });
    </script>
</html>