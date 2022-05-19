<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Login Page</title>
</head>
<body>
    <center style="position:relative; top: 10rem; ">
        <div class="shadow rounded p-3 m-auto w-25 bg-white">
            <h2>Employee Tracker Login</h2><br>
            <div class="d-flex flex-column">
                <input type="text" id="email" class="mb-2" name="email" placeholder="Email" required>
                <input type="password" id="password" class="mb-4" name="password" placeholder="Password" required>
                <button class="btn-primary button-primary" type="submit" name="login">Login</button>
            </div>
        </div>
    </center>
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(".button-primary").click(function(){
            var email = $("#email").val();
            var password = $("#password").val();

            if(email == "" || password == ""){
                alert("Please fill all the fields!");
            } else {
                $.ajax({
                    url: "sessionSetter.php",
                    type: "POST",
                    data: {
                        emailInput: email,
                        passwordInput: password
                    },
                    success: function(data){
                        alert(data);
                        if(data == "Login successful"){
                            window.location = 'employee.php';
                        }
                    }
                })
            }
        });

    </script>
</html>