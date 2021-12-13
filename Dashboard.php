<?php
include 'config.php';

session_start();
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

$num_of_students = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `Students`"));
$num_of_library_users = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `LibraryUsers`"));
$num_of_admins = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `Administrators`"));

$student_debt = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(`Debt`) AS 'debt' FROM `StudentInvoice` WHERE `Debt` > 0"))['debt'];
$num_of_student_debtors = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `StudentInvoice` WHERE `Debt` > 0"));

$library_user_debt = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(`Debt`) AS 'debt' FROM `LibraryUserInvoice` WHERE `Debt` > 0"))['debt'];
$num_of_library_user_debtors = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `LibraryUserInvoice` WHERE `Debt` > 0"));

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="bootstrap1/css/bootstrapcss.css" />
    <link rel="stylesheet" href="fontawesome/css/all.css" />
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

        .notification-btn {
            color: #eeeeee !important;
            margin-left: auto;
            border: none;
            background-color: transparent;
            margin-right: 1em;
            font-size: 1.2rem;
        }
        .notification-btn:hover {
            color: white !important;
        } .notification-btn:focus {
            outline: none;
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

        .bg-light {
            background-color: lightseagreen !important;
        }

        .dropdown {
            color: white;
        }

        .dropdown>* {
            color: white;
        }

        .dropdown li {
            padding: 1em;
        }

        .dropdown-menu {
            color: black;
        }

        li {
            list-style-type: none;
        }

        body {
            background-image: url("img/code.jpg");
        }

        h4 {
            color: white;
        }

        .container {
            margin-top: 250px;
        }

        #box {
            border: 2px solid white;
            padding: 8px;
            background-color: black;
            text-decoration: none;
        }

        #box:hover {
            background-color: lightseagreen;
            transition: .3s;
        }

        h3 {
            text-align: center;
        }

        #bus {
            border: 2px solid white;
            padding: 8px;
            background-color: black;
            text-decoration: none;
        }

        #bus:hover {
            background-color: #6b2cff;
            transition: .3s;
        }

        #car {
            border: 2px solid white;
            padding: 8px;
            background-color: black;
            text-decoration: none;
        }

        #car:hover {
            background-color: #FF00FF;
            transition: .3s;
        }

        a {
            text-decoration: none;
        }

        .linarhover {
            transition: 1.5s;
        }

        .linarhover:hover {
            background-image: linear-gradient(45deg, #222b, #04e2f9);
            border: 2px solid #fff !important;
            color: #fff !important;
            box-shadow: 0px 0px 20px #000 !important;
            transform: translate(20px);
        }
        .stats {
            position: fixed;
            bottom: 0;
            left: 83vw;
            animation: blinking 2s linear infinite;
        }
        .stats p {
            margin-bottom: 0;
        }

        .grey {
            color: grey;
        }

        @keyframes blinking {
            0% {
                color: black;
            } 50% {
                color: transparent;
            } 100% {
                color: black;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="Dashboard.php">LINAR</a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item-active">
                <a class="nav-link" aria-current="page" href="listOfStudentInvoices.php">List of Students' Invoices</a>
            </li>
            <li>
                <a class="nav-link" aria-current="page" href="listOfLibraryUserInvoices.php">List of Library Users' Invoices</a>
            </li>
        </ul>
        <li class="dropdown ml-auto">
            <button class="notification-btn" data-toggle="dropdown"><i class="fas fa-bell"></i></button>
            <ul class="dropdown-menu">
                <?php 
                    $query = mysqli_query($con, "SELECT * FROM `LibraryUserInvoice` WHERE `Timestamp` < CURRENT_DATE - 25");
                    if (mysqli_num_rows($query) <= 0) {
                        echo "<li class='grey'>All caught up</li>";
                    } while ($record = mysqli_fetch_assoc($query)) {
                        $id = $record['LibraryUserID'];
                        echo "<li>" . mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `LibraryUsers` WHERE `ID` = '$id'"))['FirstName'] . "'s subscription is nearing expiration. Click <a href='libEdit.php?id=" . $id . "&renewal=1'>here</a> to renew.</li>";
                    }
                ?>
            </ul>
        </li>
        <li class="dropdown mr-4">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Invoices</a>
            <ul class="dropdown-menu">
                <li><a href="studentInvoice.php">Student Invoice</a></li>
                <li><a href="libraryUserInvoice.php">Library User Invoice</a></li>
            </ul>
        </li>
        <a href='index.php'><button class="btn btn-danger">Logout</button></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <h3 class="ml-3 mt-3" style="text-align: left;">Welcome, <?php echo $_SESSION['username']; ?></h3>
    <div class="container">
        <div class="row">
            <div class="col-md-3" id="box">
                <a href="adminReg.php">
                    <h4>Admin Registration</h4>
                </a>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3" id="bus">
                <a href="studentReg.php">
                    <h4>Student Registration</h4>
                </a>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3" id="car">
                <a href="libraryUserReg.php">
                    <h4>Library Registration</h4>
                </a>
            </div>
        </div>
        <div class="row stats">
            <p>Number of all users: <span><?php echo $num_of_admins + $num_of_library_users + $num_of_students; ?></span></p>
            <p>Number of students: <span><?php echo $num_of_students; ?></span></p>
            <p>Number of library users: <span><?php echo $num_of_library_users; ?></span></p>
            <p>Total number of debt: <span><?php echo $num_of_student_debtors + $num_of_library_user_debtors; ?></span></p>
            <p>Total amount of debt: <span>₦<?php echo $student_debt + $library_user_debt; ?></span></p>
        </div>
    </div>

    <script type="text/javascript" src="bootstrap1/js/jqueryjs.js"></script>
    <script type="text/javascript" src="bootstrap1/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap1/js/popper.js"></script>
    <script type="text/javascript" src="notEmpty.js"></script>
</body>

</html>