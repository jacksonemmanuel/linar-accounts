<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

$record = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(`id`) AS id FROM `Students`"));

if (isset($_POST['register'])) {
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $cost = mysqli_real_escape_string($con, $_POST['cost']);

    $query = "INSERT INTO `Students` (`FirstName`, `LastName`, `EmailAddress`, `PhoneNumber`, `Course`, `Cost`) VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$course', '$cost')";

    $dbQuery = mysqli_query($con, $query);

    if ($dbQuery) {
        echo "<div class='alert alert-success'>Student Registered Successfully</div>";
        $_SESSION['student_id'] = $record['id'] + 1;
        $_SESSION['student_name'] = $firstName . ' ' . $lastName;
        $_SESSION['student_email'] = $email;
        $_SESSION['student_course'] = $course;
        $_SESSION['student_cost'] = $cost;
        header('refresh:1;url=studentInvoice.php');
    } else {
        echo "<div class='alert alert-danger'>Student Registration failed" . mysqli_error($con) . "</div>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Registration</title>
    <link rel="stylesheet" type="text/css" href="bootstrap1/css/bootstrapcss.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">

    <style type="text/css">
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .bg-light {
            background-color: #6b2cff !important;

        }

        .navbar-brand {
            color: #fff!important;
            font-size: 35px;
        }
        .nav-link {
            color: #eeeeee !important;
        }
        .nav-link:hover {
            color: white !important;
            text-decoration: underline;
        }

        .dropdown-toggle {
			color: #eeeeee !important;
		}
		.dropdown-toggle:hover {
			color: white !important;
		}

        .library-users {
            text-align: center;
            font-size: 35px;
            margin-top: -5px;
            color: #fff;
        }

        .bg-light2 {
            background-color: black !important;

        }

        .dropdown {
            color: white;
        }

        .dropdown > * {
            color: white;
        }

        .dropdown li {
            padding: 1em;
        }
        li {
            list-style-type: none;
        }
    </style>
</head>

<body style="background-color: lightgray;">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="Dashboard.php">
                <h2>LINAR</h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item-active">
                        <a class="nav-link" aria-current="page" href="Dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item-active">
                        <a class="nav-link" aria-current="page" href="libraryUserReg.php">Library User Registration</a>
                    </li>
                </ul>
                <li class="dropdown ml-auto mr-4">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Invoices
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="studentInvoice.php">Student Invoice</a></li>
                        <li><a href="libraryUserInvoice.php">Library User Invoice</a></li>
                    </ul>
                </li>
            </div>
            <a href='index.php'><button class="btn btn-danger">Logout</button></a>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light bg-light2">
        <a class="navbar-brand" href="#" style="color: white; background: black;"><i class="fa fa-users"></i>Students Registration Form</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav><br><br>



    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" style="border: 2px solid #6b2cff; border-radius: 10px; margin-top: -5px; margin-bottom: 20px; background-color: lightgray;">
                <form method="POST">
                    <div class="row" style="margin-top: 50px">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3><b>Student Registration Number</b></h3>
                                <input type="text" name="ID" value="STU0<?php echo $record['id'] + 1; ?>" class="form-control" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3><b>First Name</b></h3>
                                <input type="text" name="firstName" placeholder="Enter Your Firstname" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3><b>Last Name</b></h3>
                                <input type="text" name="lastName" placeholder="Enter Your Last Name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3><b>Email Address</b></h3>
                                <input type="email" name="email" placeholder="Enter Your Email Address" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3><b>Phone Number</b></h3>
                                <input type="number" name="phoneNumber" placeholder="Enter Your Phone Number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3><b>Course desired</b></h3>
                                <select class="form-control" name="course">
                                    <option>Web Design</option>
                                    <option>Graphics Design</option>
                                    <option>Python Programming</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3><b>Cost</b></h3>
                                <input type="text" name="cost" value="₦" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                                <h3><b>Duration</b></h3>
                                <select class="form-control" name="duration" disabled>
                                    <option>3-months</option>
                                    <option>6 months</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn" type="submit" style="width: 100%; margin-top: 40px; color: white; background-color: #6b2cff" type="submit" name="register">Register Student</button>
                        </div>
                    </div>
            </div>

            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
    </div>


    <script type="text/javascript" src="bootstrap1/js/jqueryjs.js"></script>
    <script type="text/javascript" src="bootstrap1/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap1/js/popper.js"></script>
    <script type="text/javascript" src="notEmpty.js"></script>
    <script>
        var course = document.querySelector("select[name='course']");
        var cost = document.querySelector("input[name='cost']");
        var duration = document.querySelector("select[name='duration']");

        cost.value = "₦50000";

        document.getElementsByTagName('form')[0].addEventListener('change', () => {
            switch (course.value) {
                case course[0].value:
                    cost.value = "₦50000";
                    duration.value = duration[0].value;
                    break;
                case course[1].value:
                    cost.value = "₦25000";
                    duration.value = duration[0].value;
                    break;
                case course[2].value:
                    cost.value = "₦75000";
                    duration.value = duration[1].value;
                    break;
            }
        });

    </script>



</body>

</html>