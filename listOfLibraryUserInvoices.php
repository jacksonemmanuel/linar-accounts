<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>List of Library Users' Invoices</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap1/css/bootstrap.css" />
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .bg-light {
            background-color: #FF00FF !important;

        }

        .navbar-brand {
            color: #fff !important;
            font-size: 35px;
        }

        .bg-light2 {
            background-color: black !important;

        }

        .dropdown {
            margin-right: 2em;
            color: white;
        }

        .dropdown>* {
            color: white;
        }

        .dropdown li {
            padding: 1em;
        }

        li {
            list-style-type: none;
        }

        form.filter {
            display: flex;
            margin-left: auto;
            margin-right: .5em;
        }

        .filter-button {
            margin-left: .5em;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="Dashboard.php">LINAR</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <form class="filter" method="POST">
            <select class="form-control" id="monthFilter" name="month">
                <option>January</option>
                <option>February</option>
                <option>March</option>
                <option>April</option>
                <option>May</option>
                <option>June</option>
                <option>July</option>
                <option>August</option>
                <option>September</option>
                <option>October</option>
                <option>November</option>
                <option>December</option>
            </select>
            <button type="submit" class="btn btn-success filter-button" title="Filter by month" name="filter">Search</button>
        </form>

        <a href='index.php' class="ml-2"><button class="btn btn-danger">Logout</button></a>
    </nav>

    <div class="container-fluid">
        <table class="table table-condensed table-bordered table-striped table-responsive table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Duration</th>
                    <th>Cost (₦)</th>
                    <th>Amount Paid (₦)</th>
                    <th>Debt (₦)</th>
                    <th>Date</th>
                    <th colspan=3>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $userQuery = mysqli_query($con, "SELECT * FROM `LibraryUsers`");

                if (isset($_POST['filter'])) {
                    switch ($_POST['month']) {
                        case "January":
                            $i = "01";
                            break;
                        case "February":
                            $i = "02";
                            break;
                        case "March":
                            $i = "03";
                            break;
                        case "April":
                            $i = "04";
                            break;
                        case "May":
                            $i = "05";
                            break;
                        case "June":
                            $i = "06";
                            break;
                        case "July":
                            $i = "07";
                            break;
                        case "August":
                            $i = "08";
                            break;
                        case "September":
                            $i = "09";
                            break;
                        case "October":
                            $i = "10";
                            break;
                        case "November":
                            $i = "11";
                            break;
                        case "December":
                            $i = "12";
                            break;
                    }
                    // header("location:listOfStudentInvoices.php?month=" . $_POST['month']);
                }

                if (isset($i)) {
                    $userQuery = mysqli_query($con, "SELECT * FROM `LibraryUsers` WHERE `RegistrationTime` LIKE '%-$i-%'");
                } else {
                    $userQuery = mysqli_query($con, "SELECT * FROM `LibraryUsers`");
                }

                while ($userRecord = mysqli_fetch_assoc($userQuery)) {
                    $id = $userRecord['ID'];
                    $invoiceRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `LibraryUserInvoice` WHERE `LibraryUserID` = '$id'"));
                    echo
                    "<tr>
                        <td>LIB0" . $userRecord['ID'] . "</td>
                        <td>" . $userRecord['FirstName'] . "</td>
                        <td>" . $userRecord['LastName'] . "</td>
                        <td>" . $invoiceRecord['Duration'] . "</td>
                        <td>" . $invoiceRecord['Cost'] . "</td>
                        <td>" . $invoiceRecord['AmountPaid'] . "</td>
                        <td>" . $invoiceRecord['Debt'] . "</td>
                        <td>" . substr($invoiceRecord['Timestamp'], 0, 10) . "</td>
                        <td><a href='libEdit.php?id=" . $userRecord['ID'] . "' class='btn btn-primary'>Edit</a></td>
                        <td><a href='printLibraryUserInvoice.php?id=" . $userRecord['ID'] . "' class='btn btn-success'>Print</a></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="bootstrap1/js/jqueryjs.js"></script>
    <script type="text/javascript" src="bootstrap1/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap1/js/popper.js"></script>
    <script type="text/javascript" src="notEmpty.js"></script>
    <script>
        var month = <?php echo $i; ?>;
        document.getElementById('monthFilter').selectedIndex = month - 1;
    </script>
</body>

</html>