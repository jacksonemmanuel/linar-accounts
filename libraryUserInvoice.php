<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
	header('location:index.php');
}

if (isset($_POST['generate'])) {
	unset($_SESSION['user_id']); unset($_SESSION['user_name']); unset($_SESSION['user_email']); unset($_SESSION['user_duration']); unset($_SESSION['user_cost']);
	try {
		$id = mysqli_real_escape_string($con, substr($_POST['id'], 4));
		$query = mysqli_query($con, "SELECT * FROM `LibraryUsers` WHERE `ID` = '$id'");
		$record = mysqli_fetch_assoc($query);
		if (mysqli_num_rows($query) <= 0) {
			echo "<div class='alert alert-danger'>Student not found</div>";
		}
	} catch (Exception $e) {
		echo "<div class='alert alert-danger'>Student does not exist</div>";
	}
}

if (isset($_POST['submit'])) {
	$id = mysqli_real_escape_string($con, substr($_POST['ID'], 4));
	$duration = mysqli_real_escape_string($con, $_POST['duration']);
	$cost = mysqli_real_escape_string($con, $_POST['cost']);
	$credit = mysqli_real_escape_string($con, $_POST['credit']);
	$debt = mysqli_real_escape_string($con, $_POST['debt']);

	if (mysqli_num_rows(mysqli_query($con, "SELECT `LibraryUserID` FROM `LibraryUserInvoice` WHERE `LibraryUserID` = '$id'"))) {
		echo "<div class='alert alert-danger'>This library user's invoice already exists. Click <a href='libEdit.php?id=" . $id . "'>here</a> to edit it.</div>";

	} else {
		$query = mysqli_query($con, "INSERT INTO `LibraryUserInvoice` (`LibraryUserID`, `Duration`, `Cost`, `AmountPaid`, `Debt`) VALUES ('$id', '$duration', '$cost', '$credit', '$debt')");

		if ($query) {
			echo "<div class='alert alert-success'>Invoice created successfully</div>";
			header('refresh:1;url=Dashboard.php');
		} else {
			echo "<div class='alert alert-danger'>An error occurred while creating invoice</div>";
		}
	}

	
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Library User's Invoice</title>
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
					<li class="nav-item">
						<a class="nav-link" href="studentReg.php">Student Registration</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="libraryUserReg.php">Library User Registration</a>
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
			<div class="col-md-8" style="border: 2px solid #FF00FF; border-radius: 10px; margin-top: -5px; margin-bottom: 20px; background-color: lightgray;">
				<form method="POST">
					<div class="row" style="margin-top: 50px">
						<div class="col-md-6">
							<div class="form-group" style="margin-right: -100px">
								<input type="text" name="id" style="text-transform: uppercase;" placeholder="Library User ID" class="form-control" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<button class="btn" name="generate" style="width: 80%; margin-left: 80px; background-color: #FF00FF; color: white;">Generate Profile</button>
							</div>
						</div>
					</div>
				</form>

				<form method="POST">
					<div class="form-group">
						<input type="text" name="ID" placeholder="Library User ID" class="form-control" value="LIB0<?php echo($_SESSION['user_id'] ? $_SESSION['user_id'] : $record['ID']); ?>" readonly>
					</div>
					<div class="form-group">
						<input type="text" name="name" value="<?php echo ($_SESSION['user_name'] ? $_SESSION['user_name'] : $record['FirstName'] . ' ' . $record['LastName']); ?>" class="form-control" placeholder="Library User Name" readonly>
					</div>
					<div class="form-group">
						<input type="text" name="email" value="<?php echo ($_SESSION['user_email'] ? $_SESSION['user_email'] : $record['EmailAddress']); ?>" placeholder="Library User Email Address" class="form-control" readonly>
					</div>
					<div class="form-group">
						<input type="text" name="duration" value="<?php echo ($_SESSION['user_duration'] ? $_SESSION['user_duration'] : $record['Duration']); ?>" placeholder="Duration of Plan" class="form-control" readonly>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" style="margin-right: -13px">
								<input type="number" name="cost" value="<?php echo ($_SESSION['user_cost'] ? substr($_SESSION['user_cost'], 3) : substr($record['Cost'], 3)); ?>" placeholder="Subscription Cost" class="form-control" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" style="margin-left: -13px">
								<input type="number" name="credit" placeholder="Amount to be paid" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<input type="number" name="debt" class="form-control" placeholder="Amount owed" readonly>
					</div>
					<button class="btn btn-block" type="submit" name="submit" style="margin-bottom: 20px; background-color: #FF00FF; color: white;">Submit Now</button>
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
		document.querySelector("[name='generate']").addEventListener('click', event => {
			var generateId = document.querySelector("[name='id']");
			if (!(generateId.value.toUpperCase().startsWith("LIB0"))) {
				event.preventDefault();
				alert("Invalid Library User ID");
			}
		});

		$(document).ready(() => {
			$("[name='credit']").on("keyup keydown", () => {
				var debt = document.querySelector("[name='debt']");
				var cost = document.querySelector("[name='cost']");
				var credit = document.querySelector("[name='credit']");

				debt.value = cost.value - credit.value;
			});
		});

	</script>

</body>

</html>