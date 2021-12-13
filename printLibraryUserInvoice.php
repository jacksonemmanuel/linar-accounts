<?php

include 'config.php';

session_start();
if (!isset($_SESSION['username'])) {
	header('location:index.php');
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$libraryUserRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `LibraryUsers` WHERE `ID` = '$id'"));
$libraryUserInvoiceRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `LibraryUserInvoice` WHERE `LibraryUserID` = '$id'"));


?>

<!DOCTYPE html>
<html>

<head>
	<title>Print <?php echo $libraryUserRecord['FirstName']; ?>'s Invoice</title>
	<link rel="stylesheet" type="text/css" href="bootstrap1/css/bootstrapcss.css">
	<link rel="stylesheet" href="fontawesome/css/all.css">

	<style type="text/css">
		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
			margin-bottom: 2em;
		}

		.bg-light {
			background-color: #FF00FF !important;

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
			background-color: #FF00FF !important;

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
		<a class="navbar-brand" href="Dashboard.php" style="color: white; background: #FF00FF; width: 100px;"><i class="fa fa-user"></i>&nbsp;Linar Library User</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</nav><br><br>

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>Identification Number</h2>
				<p>LIB0<?php echo $libraryUserRecord['ID'] ?></p>
			</div>
			<div class="col-md-6">

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>First Name</h2>
				<p><?php echo $libraryUserRecord['FirstName']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>Last Name</h2>
				<p><?php echo $libraryUserRecord['LastName']; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>Email Address</h2>
				<p><?php echo $libraryUserRecord['EmailAddress']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>Duration</h2>
				<p><?php echo $libraryUserRecord['Duration']; ?></p>
			</div>
		</div>
        <div class="row">
			<div class="col-md-6">
				<h2>Begin Date</h2>
				<p><?php echo $libraryUserRecord['PlanBegin']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>End Date</h2>
				<p><?php echo $libraryUserRecord['PlanEnd']; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>Plan Cost</h2>
				<p>₦<?php echo $libraryUserInvoiceRecord['Cost']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>Amount Paid</h2>
				<p>₦<?php echo $libraryUserInvoiceRecord['AmountPaid']; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>Amount Owed</h2>
				<p>₦<?php echo $libraryUserInvoiceRecord['Debt']; ?></p>
			</div>
			<div class="col-md-6">
				<h2>Registration Date</h2>
				<p><?php echo substr($libraryUserInvoiceRecord['Timestamp'], 0, 10); ?></p>
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