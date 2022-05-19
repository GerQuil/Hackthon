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
                <button id="displayAdminListButton" type="button" class="btn btn-secondary">Admins</button>
                <button id="displayTeamLeadListButton" type="button" class="btn">Team Leads</button>
            </div>
            <div class="admin_list">
                <div class="admin_table_wrap mt-5 rounded bg-white h-75">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Admin ID</th>
                                <th class="text-center">Admin Name</th>
                                <th class="text-center">Admin Email</th>
                                <th class="text-center">Account Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT * FROM admin";
                                $query = mysqli_query($connect, $sql);
                                if(mysqli_num_rows($query) > 0) {
                                    while($result = mysqli_fetch_assoc($query)){
                                        echo "
                                            <tr>
                                                <td>".$result['adminID']."</td>
                                        "; 
                                            if($result['adminID'] == $_SESSION['adminID']){
                                                echo "<td>".$result['adminFName']." ".$result['adminLName']." (You)</td>";
                                            } else {
                                                echo "<td>".$result['adminFName']." ".$result['adminLName']."</td>";
                                            }
                                        echo "
                                                <td>".$result['adminEmail']."</td>
                                                <td>
                                                <div class='d-flex align-items-center justify-content-center'>
                                                
                                                ";
                                        
                                        if($result['adminID'] == $_SESSION['adminID']) {
                                            echo "<button id='editBasic' class='btn btn-sm btn-warning me-3' data-toggle='modal' data-target='#editBasicAdminModal'>Edit Info</button>";
                                            echo "<button id='changePass' class='btn btn-sm btn-warning me-3' data-toggle='modal' data-target='#changePassAdminModal'>Change Pass</button>";
                                        }

                                        echo"
                                            <button adminID='".$result['adminID']."' class='btn btn-sm btn-danger deletePrompt' data-toggle='modal' data-target='#deleteAdminModal'>Delete Account</button>
                                                </div></td>
                                            </tr>
                                        ";
                                        
                                        
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
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

    <!-- edit admin Modal toggled by #editBasic -->
    <div class="modal fade center" id="editBasicAdminModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Basic Information</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">First name</p>
                        <input type="text" id="editAdminFname" placeholder="John" value="<?php echo $_SESSION['fName'];?>">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Middle name</p>
                        <input type="text" id="editAdminMname" placeholder="Summer" value="<?php echo $_SESSION['mName'];?>">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Last name</p>
                        <input type="text" id="editAdminLname" placeholder="Doe" value="<?php echo $_SESSION['lName'];?>">
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">email</p>
                        <input type="text" id="editAdminEmail" placeholder="example123@email.com" value="<?php echo $_SESSION['email'];?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="editAdminButton" class="btn btn-success">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit admin Modal toggled by #editBasic -->
    <div class="modal fade center" id="changePassAdminModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit password</h5>
                </div>
                <div class="modal-body">
                    <p class="mb-2">You will be logged out if you successfully changed your password</p>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Current Password</p>
                        <input type="password" id="curPass">
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">New password</p>
                        <input type="password" id="newPass">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Confirm password</p>
                        <input type="password" id="confirmPass">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="changePassAdminButton" class="btn btn-success">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete admin Modal toggled by #deleteAdmin -->
    <div class="modal fade center" id="deleteAdminModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Do you want to delete selected account?</h5>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="deleteAdminButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add team lead Modal toggled by #addTeamLeadTrigger -->
    
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
    var adminID;

// Set default view to display admin list
    $(document).ready(function(){
        $("#displayAdminListButton").trigger("click");
    });

// Switch page content from admin to team lead view vicec versa
    $("#displayAdminListButton").click(function(){
        $('.admin_list').show();
        $('.teamLead_list').hide();
        $('#displayAdminListButton').addClass("btn-secondary");
        $('#displayTeamLeadListButton').removeClass("btn-secondary");
    });

    $("#displayTeamLeadListButton").click(function(){
        $('.admin_list').hide();
        $('.teamLead_list').show();
        $('#displayAdminListButton').removeClass("btn-secondary");
        $('#displayTeamLeadListButton').addClass("btn-secondary");
    });
        
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

//edit session basic info
    $("#editAdminButton").click(function(){
        var aFname = $('#editAdminFname').val();
        var aMname = $('#editAdminMname').val();
        var aLname = $('#editAdminLname').val();
        var aEmail = $('#editAdminEmail').val();

        if(aFname == "" || aMname == "" || aLname == "" || aEmail == "") {
            alert("Please fill in all the fields");
        } else {
            $.ajax({
                url: "admin-profile-control.php",
                type: "POST",
                data: {
                    actionID: "4",
                    fname: aFname,
                    mname: aMname,
                    lname: aLname,
                    email: aEmail
                },
                success: function(data){
                    alert("Information saved!");
                    window.location =  'users.php';
                    
                }
            })
        }
    })

// change session password
    $("#changePassAdminButton").click(function(){
        var curpass = $("#curPass").val();
        var newpass = $("#newPass").val();
        var confirmpass = $("#confirmPass").val();

        if(curpass == "" || newpass == "" || confirmpass == ""){
            alert("Please fill in all the fields");
        } else {
            if(newpass != confirmpass){
                alert("Password does not match");
            } else {
                $.ajax({
                    url: "admin-profile-control.php",
                    type: "POST",
                    data: {
                        actionID: "5",
                        curPass: curpass
                    },
                    success: function(data){
                        if(data == "wrong"){
                            alert("Input on current password is incorrect");
                        } else {
                            $.ajax({
                                url: "admin-profile-control.php",
                                type: "POST",
                                data: {
                                    actionID: "6",
                                    newPass: newpass
                                },
                                success: function(data){
                                    window.location = 'login.php';
                                }
                            })
                        }
                    }
                })
            }
        }
    })

// Set selected adminId for deletion 
    $('.deletePrompt').click(function(){
        adminID = $(this).attr("adminID");
    })

// Delete admin account
    $("#deleteAdminButton").click(function(){
        $.ajax({
            url: "admin-profile-control.php",
            type: "POST",
            data: {
                actionID: "7",
                adminIDselected: adminID
            },
            success: function(data){
                location.reload();
            }
        })
    })
    </script>
</html>