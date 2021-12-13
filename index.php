<?php
include 'config.php';
session_start();
session_unset();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['pass']);

    $query = "SELECT * FROM `Administrators` WHERE `Username` = '$username'";
    $dbQuery = mysqli_query($con, $query);

    $valid = mysqli_num_rows($dbQuery);

    if ($valid > 0) {
        $user = mysqli_fetch_assoc($dbQuery);
        $dbPassword = $user['Password'];
        $verifyPassword = password_verify($password, $dbPassword);

        if ($verifyPassword) {
            $_SESSION['username'] = $username;
            header("Location:Dashboard.php");
        } else {
            echo "<div class='alert alert-danger'>Invalid username or password</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid username or password</div>";
    }
}



?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin login</title>
    <link rel="stylesheet" type="text/css" href="bootstrap1/css/bootstrapcss.css" />
    <style type="text/css">
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .myform {
            border: 1px solid grey;
            padding: 25px;
            border-radius: 10px;
            margin-top: 150px;
            background: transparent;
            box-shadow: 0px 0px 20px #000;
            width: 500px;
        }

        .navbar-brand {
            color: white !important;
            font-size: 35px;

        }

        .bg-light {
            background-color: lightseagreen !important;
        }

        body {
            background-image: url("img/code.jpg");
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">
            <h2>LINAR</h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="myform">
                    <h2 class="text-center">Admin login page</h2>
                    <hr>
                    <form method="POST">
                        <div class="form-group">
                            <input type="text" name="username" placeholder="Enter your username" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="pass" placeholder="Enter your Password" class="form-control">
                        </div>
                        <button class="btn btn-dark btn-block" type="submit" name="login">Login</button>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <script type="text/javascript" src="bootstrap1/js/jqueryjs.js"></script>
    <script type="text/javascript" src="bootstrap1/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap1/js/popper.js"></script>
    <script type="text/javascript" src="validate.js"></script>
</body>

</html>