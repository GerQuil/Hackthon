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
    <title>Employees</title>
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
            <h4>Employees</h4>
            <button type="button" class="btn btn-primary" id="addEmployee" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</button>
        </div>
        <div class="body">
            <div class="employee_table_wrap mt-5 rounded bg-white">
                <table class="employee_table w-100">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Team Lead</th>
                            <th class="text-center">Team</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Number</th>
                            <th class="text-center">Designation</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM employee JOIN teamlead ON employee.leadID = teamlead.leadID
                            JOIN department ON employee.departmentID = department.departmentID
                            JOIN team ON employee.teamID = team.teamID";
                            $query = mysqli_query($connect, $sql);
                            if(mysqli_num_rows($query) > 0) {
                                while($result = mysqli_fetch_assoc($query)){
                                    if($result['empStat'] == "active"){
                                        echo "
                                            <tr>
                                                <td>".$result['empFName']." ".$result['empLName']."</td>
                                                <td>".$result['departmentName']."</td>
                                                <td>".$result['leadFName']." ".$result['leadLName']."</td>
                                                <td>".$result['teamName']."</td>
                                                <td>".$result['empEmail']."</td>
                                                <td>".$result['empNumber']."</td>
                                                <td>".$result['designation']."</td>
                                                <td>
                                                    <button empID='".$result['empID']."' deptName='".$result['departmentName']."' class='btn btn-sm btn-warning editDepartment me-3' data-toggle='modal' data-target='#editEmployeeModal'>Edit</button>
                                                    <button empID='".$result['empID']."' class='btn btn-sm btn-danger deleteEmployee' data-toggle='modal' data-target='#deleteEmployeeModal'>Delete</button>
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

    <!-- delete employee Modal  -->
    <div class="modal fade center" id="deleteEmployeeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Do you want to delete selected employee?</h5>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="deleteEmployeeButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add employee Modal toggled -->
    <div class="modal fade center" id="addEmployeeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Employee</h5>
                </div>
                <div class="modal-body">
                    
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">First name</p>
                        <input type="text" id="addEmpFname" placeholder="John">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Middle name</p>
                        <input type="text" id="addEmpMname" placeholder="Summer">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Last name</p>
                        <input type="text" id="addEmpLname" placeholder="Doe">
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-column mb-3 w-50">
                            <p class="label-modal text-muted mb-1 me-2">Number</p>
                            <input type="number" id="addEmpEmail" placeholder="09391785412">
                        </div>
                        <div class="d-flex flex-column mb-3 w-50 ms-2 p-1">
                            <p class="label-modal text-muted mb-1">Birthdate</p>
                            <input type="date" id="addEmpEmail" placeholder="09391785412">
                        </div>
                    </div>
                    
                    <hr>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">email</p>
                        <input type="email" id="addEmpEmail" placeholder="example123@email.com">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Password</p>
                        <input type="password" id="addEmpPass" placeholder="mypassword!">
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

    var selectedEmployeeID;
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

// Set seleected employee id
    $(".deleteEmployee").click(function(){
        selectedEmployeeID = $(this).attr("empID");
    })

// delete employee
    $('#deleteEmployeeButton').click(function(){
        $.ajax({
            url: "employee-control-logic.php",
            type: "POST",
            data: {
                actionID: "1",
                empID: selectedEmployeeID
            },
            success: function(data){
                location.reload();
            }
        })
    })
    </script>
</html>