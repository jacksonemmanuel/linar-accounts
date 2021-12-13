<?php

include 'config.php';

session_start();
if (!isset($_SESSION['username'])) {
	header('location:index.php');
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$studentRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `Students` WHERE `ID` = '$id'"));
$studentInvoiceRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `StudentInvoice` WHERE `StudentID` = '$id'"));


?>

<!DOCTYPE html>
<html>

<head>
	<title>Print <?php echo $studentRecord['FirstName']; ?>'s Invoice</title>
	<link rel="stylesheet" type="text/css" href="bootstrap1/css/bootstrapcss.css">
	<link rel="stylesheet" href="fontawesome/css/all.css">

	<style type="text/css">
		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
		}

		.bg-light {
			background-color: #6b2cff !important;

		}

		.nav-link {
			color: #eeeeee !important;
		}

		.nav-link:hover {
			color: white !important;
			text-decoration: underline;
		}

		.navbar-brand {
			color: #fff !important;
			font-size: 35px;
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
			background-color: #6b2cff !important;

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
		.btn-round {
			border-radius: 50%;
			font-size: 1.2rem;
			float: right;
		}
	</style>
</head>

<body style="background-color: lightgray;">

	<nav class="navbar navbar-expand-lg navbar-light bg-light2">
		<a class="navbar-brand" href="Dashboard.php" style="color: white; background: #6b2cff; width: 100px;"><i class="fa fa-users"></i>&nbsp;Linar Student</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</nav><br><br>

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>Identification Number</h2>
				<p>STU0<?php echo $studentRecord['ID'] ?></p>
			</div>
			<div class="col-md-6">

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>First Name</h2>
				<p><?php echo $studentRecord['FirstName']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>Last Name</h2>
				<p><?php echo $studentRecord['LastName']; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>Email Address</h2>
				<p><?php echo $studentRecord['EmailAddress']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>Course</h2>
				<p><?php echo $studentRecord['Course']; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>Course Cost</h2>
				<p>₦<?php echo $studentInvoiceRecord['Cost']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>Amount Paid</h2>
				<p>₦<?php echo $studentInvoiceRecord['AmountPaid']; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>Amount Owed</h2>
				<p>₦<?php echo $studentInvoiceRecord['Debt']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>Date</h2>
				<p><?php echo substr($studentInvoiceRecord['Timestamp'], 0, 10); ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6"></div>
			<div class="col-md-6">
				<button class="btn btn-success btn-round" onclick="window.print()"><i class="fas fa-print"></i></button>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="bootstrap1/js/jqueryjs.js"></script>
	<script type="text/javascript" src="bootstrap1/js/bootstrap.js"></script>
	<script type="text/javascript" src="bootstrap1/js/popper.js"></script>

</body>

</html>