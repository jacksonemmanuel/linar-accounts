<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('location:index.php');
} //To create an admin account, comment out this if-statement. Don't forget to uncomment it out once you're done.

if (isset($_POST['register'])) {
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash(mysqli_real_escape_string($con, $_POST['pass']), PASSWORD_DEFAULT);

    $query = "INSERT INTO `Administrators` (`FirstName`, `LastName`, `Username`, `EmailAddress`, `Password`) VALUES('$firstName', '$lastName', '$username', '$email', '$password')";

    $dbQuery = mysqli_query($con, $query);

    if ($dbQuery) {
        echo "<div class='alert alert-success'>User registered successfully</div>";
        header('refresh:2;url=index.php');
    } else {
        echo "<div class='alert alert-danger'>User registration failed</div>" . mysqli_error($con);
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" type="text/css" href="bootstrap1/css/bootstrapcss.css" />
    <style>
        body {
                font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
        html {
            --brand-color: #48014b;
            --brand-color-light: #700174;
        }

        .navbar-brand {
            color: #fff !important;
            font-size: 35px;
            text-transform: uppercase;
            font-weight: 800;
        }

        .bg-light {
            background-color: lightseagreen !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="Dashboard.php">Linar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="text-center" style="margin-top: 5em; ">
                    <h2>Register Here</h2>
                    <hr />
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="firstName" class="form-control" placeholder="Enter your first name" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="lastName" class="form-control" placeholder="Enter your last name" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Choose a username" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email address" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="password" name="pass" class="form-control" placeholder="Choose a password" />
                        </div>
                        <div class="form-group">
                            <input type="password" name="confirmPass" class="form-control" placeholder="Confirm password" />
                            <div>
                                <button style="margin-top: 1em; " class="btn btn-outline-primary btn-block btn-lg" name="register">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h8><b>Already have an account? <a href="index.php">Login here.</a></b></h8>
            </div>
            <div class="col-md-2" class="col-md-2"></div>

        </div>
    </div>

    <script type="text/javascript" src="bootstrap1/js/jqueryjs.js"></script>
    <script type="text/javascript" src="bootstrap1/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap1/js/popper.js"></script>
    <script type="text/javascript" src="notEmpty.js"></script>

    <script type="text/javascript">
        var password = document.querySelector("input[name='pass']");
        var confirmPassword = document.querySelector("input[name='confirmPass']");

        confirmPassword.addEventListener('focus', () => {
            window.addEventListener('keyup', () => {
                if (password.value != confirmPassword.value) confirmPassword.style.borderColor = 'red';
                else confirmPassword.style.borderColor = '';
            });
        });
    </script>
</body>

</html>