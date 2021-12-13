<?php

include 'config.php';

session_start();
if (!isset($_SESSION['username'])) {
	header('location:index.php');
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$renewal = mysqli_real_escape_string($con, $_GET['renewal']);
$libraryUserRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `LibraryUsers` WHERE `ID` = '$id'"));
$libraryUserInvoiceRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `LibraryUserInvoice` WHERE `LibraryUserID` = '$id'"));

if (isset($_POST['update'])) {
	$firstName = mysqli_real_escape_string($con, explode(' ', $_POST['name'])[0]);
	$lastName = mysqli_real_escape_string($con, explode(' ', $_POST['name'])[1]);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$duration = mysqli_real_escape_string($con, $_POST['duration']);
	$cost = mysqli_real_escape_string($con, $_POST['cost']);
	$credit = mysqli_real_escape_string($con, $_POST['credit']);
	$debt = mysqli_real_escape_string($con, $_POST['debt']);

	$libraryUserQuery = mysqli_query($con, "UPDATE `LibraryUsers` SET `FirstName` = '$firstName', `LastName` = '$lastName', `EmailAddress` = '$email', `Duration` = '$duration', `Cost` = '₦$cost' WHERE `ID` = '$id'");
	$libraryUserInvoiceQuery = mysqli_query($con, "UPDATE `LibraryUserInvoice` SET `Duration` = '$duration', `Cost` = '$cost', `AmountPaid` = '$credit', `Debt` = '$debt' WHERE `LibraryUserID` = '$id'");

	if ($libraryUserQuery && $libraryUserInvoiceQuery) {
		echo "<div class='alert alert-success'>Invoice Updated Successfully</div>";
		header('refresh:1;url=listOfLibraryUserInvoices.php');
	} else {
		echo "<div class='alert alert-danger'>Invoice Update failed</div>";
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Edit <?php echo $libraryUserRecord['FirstName']; ?>'s Invoice</title>
	<link rel="stylesheet" type="text/css" href="bootstrap1/css/bootstrapcss.css">
	<link rel="stylesheet" href="fontawesome/css/all.css">

	<style type="text/css">
		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
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

		.dropdown-toggle {
			color: #eeeeee !important;
		}

		.dropdown-toggle:hover {
			color: white !important;
		}

		.navbar-brand {
			color: #fff !important;
			font-size: 35px;
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
	</style>
</head>

<body style="background-color: lightgray;">

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="Dashboard.php">LINAR</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item-active">
						<a class="nav-link" aria-current="page" href="Dashboard.php">Dashboard</a>
					</li>
				</ul>
				<li class="dropdown ml-auto mr-4">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Invoices
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="studentInvoice.php">Student Invoice</a></li>
					</ul>
				</li>
				<a href='index.php'><button class="btn btn-danger">Logout</button></a>
			</div>
		</div>
	</nav>

	<nav class="navbar navbar-expand-lg navbar-light bg-light2">
		<a class="navbar-brand" href="#" style="color: white; background: black; width: 100px;"><i class="fa fa-book"></i>Library Users</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</nav><br><br>



	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" style="border: 2px solid #FF00FF; border-radius: 10px; padding-top: 1em; background-color: lightgray;">
				<form method="POST">
					<div class="form-group">
						<input type="text" name="ID" placeholder="Library User ID" class="form-control" value="LIB0<?php echo $id; ?>" readonly>
					</div>
					<div class="form-group">
						<input type="text" name="name" value="<?php echo $libraryUserRecord['FirstName'] . ' ' . $libraryUserRecord['LastName']; ?>" class="form-control" placeholder="Library User Name">
					</div>
					<div class="form-group">
						<input type="text" name="email" value="<?php echo $libraryUserRecord['EmailAddress']; ?>" placeholder="Library User Email Address" class="form-control">
					</div>
					<div class="form-group">
						<select class="form-control" name="duration">
							<option>2 Weeks</option>
							<option>1 Month</option>
							<option>3 Months</option>
							<option>6 Months</option>
						</select>
					</div>
					<div class="row">
						<div class="col-md-6 form-group">
							<input type="date" name="beginPlan" value="<?php echo !$renewal ? $libraryUserRecord['PlanBegin'] : ""; ?>" placeholder="" class="form-control" required>
						</div>
						<div class="col-md-6 form-group">
							<input type="date" name="endPlan" placeholder="" value="<?php echo !$renewal ? $libraryUserRecord['PlanEnd'] : ""; ?>" class="form-control" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="number" name="cost" value="<?php echo !$renewal ? $libraryUserInvoiceRecord['Cost'] : ""; ?>" placeholder="Subscription Cost" class="form-control" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="number" name="credit" value="<?php echo !$renewal ? $libraryUserInvoiceRecord['AmountPaid'] : ""; ?>" placeholder="Amount to be paid" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<input type="number" name="debt" value="<?php echo !$renewal ? $libraryUserInvoiceRecord['Debt'] : ""; ?>" class="form-control" placeholder="Amount owed" readonly>
					</div>
					<button class="btn btn-block" type="submit" name="update" style="margin-bottom: 20px; background-color: #FF00FF; color: white;">Update</button>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>

	<script type="text/javascript" src="meaningfulDate.js"></script>
	<script type="text/javascript" src="notEmpty.js"></script>
	<script type="text/javascript" src="bootstrap1/js/jqueryjs.js"></script>
	<script type="text/javascript" src="bootstrap1/js/bootstrap.js"></script>
	<script type="text/javascript" src="bootstrap1/js/popper.js"></script>
	<script>
		$(document).ready(() => {
			$("[name='credit']").on("keyup keydown", () => {
				var debt = document.querySelector("[name='debt']");
				var cost = document.querySelector("[name='cost']");
				var credit = document.querySelector("[name='credit']");

				debt.value = cost.value - credit.value;
			});
		});

		var cost = document.querySelector("input[name='cost']");
		var duration = document.querySelector("select[name='duration']");
		var start = document.querySelector("input[name='beginPlan']");
		var end = document.querySelector("input[name='endPlan']");
		
		cost.value = "1000";
		duration.selectedIndex = <?php echo $renewal ? 0 : -1 ?>;

		document.getElementsByTagName('form')[0].addEventListener("change", () => {
			var arrayDate = start.value.split('-');
			switch (duration.value) {
				case duration[0].value:
					cost.value = "1000";
					end.value = meaningfulDate(arrayDate[0] + '-' + arrayDate[1] + '-' + (Number(arrayDate[2]) + 14).toString());
					break;
				case duration[1].value:
					cost.value = "1500";
					end.value = meaningfulDate(arrayDate[0] + '-' + (Number(arrayDate[1]) + 1).toString() + '-' + arrayDate[2]);
					break;
				case duration[2].value:
					cost.value = "2500";
					end.value = meaningfulDate(arrayDate[0] + '-' + (Number(arrayDate[1]) + 3).toString() + '-' + arrayDate[2]);
					break;
				case duration[3].value:
					cost.value = "4500";
					end.value = meaningfulDate(arrayDate[0] + '-' + (Number(arrayDate[1]) + 6).toString() + '-' + arrayDate[2]);
					break;
			}
		});
	</script>