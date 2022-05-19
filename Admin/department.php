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
    <title>Departments</title>
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
            <h4>Departments</h4>
            <div class="d-flex justify-content-between align-items-center" style="width: 350px;">
                <input id="addDeptName" type="text" placeholder="Dept name" class="p-1">
                <button type="button" class="btn btn-primary" id="addDepartmentButton">Add department</button>
            </div>
        </div>
        <div class="body">
            <div class="department_table_wrap mt-5 rounded bg-white">
                <table class="department_table w-100">
                    <thead>
                        <tr>
                            <th class="text-center">Deptartment ID</th>
                            <th class="text-center">Department Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM department";
                            $query = mysqli_query($connect, $sql);
                            if(mysqli_num_rows($query) > 0) {
                                while($result = mysqli_fetch_assoc($query)){
                                    if($result['departmentStatus'] == "active"){
                                        echo "
                                            <tr>
                                                <td>".$result['departmentID']."</td>
                                                <td>".$result['departmentName']."</td>
                                                <td>
                                                    <button deptID='".$result['departmentID']."' deptName='".$result['departmentName']."' class='btn btn-sm btn-warning editDepartment me-3' data-toggle='modal' data-target='#editDepartmentModal'>Edit</button>
                                                    <button deptID='".$result['departmentID']."' class='btn btn-sm btn-danger deleteDepartment' data-toggle='modal' data-target='#deleteDepartmentModal'>Delete</button>
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
    <!-- edit department Modal toggled by .editDepartment -->
    <div class="modal fade center" id="editDepartmentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit department name</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column mb-3">
                        <p class="label-modal text-muted mb-1">Department name</p>
                        <input type="text" id="deptNameEdit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="editDepartmentButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete department Modal toggled by #deleteAdmin -->
    <div class="modal fade center" id="deleteDepartmentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Do you want to delete selected account?</h5>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn">Cancel</button>
                    <button id="deleteDepartmentButton" class="btn btn-danger">Continue</button>
                </div>
            </div>
        </div>
    </div>

</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
    var selectedDeptID;

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

// Adding department
    $("#addDepartmentButton").click(function(){
        var deptName = $("#addDeptName").val();
        if(deptName == ""){
            alert("Please input a valid department name");
        } else {
            $.ajax({
                url: "department-control-logic.php",
                type: "POST",
                data: {
                    actionID: "1",
                    departmentName: deptName
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    })

// set selected departmentID 
    $(".editDepartment").click(function(){
        selectedDeptID = $(this).attr("deptID");
        var selectedeptName = $(this).attr("deptName");

        $("#deptNameEdit").val(selectedeptName);
    })

    $(".deleteDepartment").click(function(){
        selectedDeptID = $(this).attr("deptID");
    })

// edit department name
    $("#editDepartmentButton").click(function(){
        var newDeptName = $("#deptNameEdit").val().toUpperCase();
        if(newDeptName == ""){
            alert("Please input a valid name for the department")
        } else {
            $.ajax({
                url: "department-control-logic.php",
                type: "POST",
                data: {
                    actionID: "2",
                    departmentName: newDeptName,
                    departmentID: selectedDeptID
                },
                success: function(data){
                    location.reload();
                }
            })
        }
    })

// delete department 
    $("#deleteDepartmentButton").click(function(){
        $.ajax({
                url: "department-control-logic.php",
                type: "POST",
                data: {
                    actionID: "3",
                    departmentID: selectedDeptID
                },
                success: function(data){
                    location.reload();
                }
            })
    })
    </script>
</html>