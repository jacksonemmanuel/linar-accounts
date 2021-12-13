<?php

include 'config.php';

session_start();
if (!isset($_SESSION['username'])) {
	header('location:index.php');
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$studentRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `Students` WHERE `ID` = '$id'"));
$studentInvoiceRecord = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `StudentInvoice` WHERE `StudentID` = '$id'"));

if (isset($_POST['update'])) {
	$firstName = mysqli_real_escape_string($con, explode(' ', $_POST['name'])[0]);
	$lastName = mysqli_real_escape_string($con, explode(' ', $_POST['name'])[1]);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$course = mysqli_real_escape_string($con, $_POST['course']);
	$cost = mysqli_real_escape_string($con, $_POST['cost']);
	$credit = mysqli_real_escape_string($con, $_POST['credit']);
	$debt = mysqli_real_escape_string($con, $_POST['debt']);

	$studentQuery = mysqli_query($con, "UPDATE `Students` SET `FirstName` = '$firstName', `LastName` = '$lastName', `EmailAddress` = '$email', `Course` = '$course', `Cost` = '₦$cost' WHERE `ID` = '$id'");
	$studentInvoiceQuery = mysqli_query($con, "UPDATE `StudentInvoice` SET `Course` = '$course', `Cost` = '$cost', `AmountPaid` = '$credit', `Debt` = '$debt' WHERE `StudentID` = '$id'");

	if ($studentQuery && $studentInvoiceQuery) {
		echo "<div class='alert alert-success'>Invoice Updated Successfully</div>";
		header('refresh:1;url=listOfStudentInvoices.php');
	} else {
		echo "<div class='alert alert-danger'>Invoice Update failed</div>";
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Edit <?php echo $studentRecord['FirstName']; ?>'s Invoice</title>
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
				</ul>
				<li class="dropdown ml-auto mr-4">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Invoices
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="libraryUserInvoice.php">Library User Invoice</a></li>
					</ul>
				</li>
				<a href='index.php'><button class="btn btn-danger">Logout</button></a>
			</div>
		</div>
	</nav>

	<nav class="navbar navbar-expand-lg navbar-light bg-light2">
		<a class="navbar-brand" href="#" style="color: white; background: black; width: 100px;"><i class="fa fa-users"></i>Student Invoice</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</nav><br><br>



	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" style="border: 2px solid #6b2cff; border-radius: 10px; background-color: lightgray; padding-top: 1em;">
				<form method="POST">
					<div class="form-group">
						<input type="text" name="ID" placeholder="Student ID" value="STU0<?php echo $id; ?>" class="form-control" readonly>
					</div>

					<div class="form-group">
						<input type="text" name="name" placeholder="Student Name" value="<?php echo $studentRecord['FirstName'] . ' ' . $studentRecord['LastName']; ?>" class="form-control" required>
					</div>

					<div class="form-group">
						<input type="text" name="email" placeholder="Student Email Address" value="<?php echo $studentRecord['EmailAddress']; ?>" class="form-control" required>
					</div>

					<div class="form-group">
						<select class="form-control" name="course">
							<option>Web Design</option>
							<option>Graphics Design</option>
							<option>Python programming</option>
						</select>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="number" name="cost" placeholder="Course cost" value="<?php echo $studentInvoiceRecord['Cost']; ?>" class="form-control" readonly required>

							</div>

						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="number" name="credit" placeholder="Amount Paid" class="form-control" value="<?php echo $studentInvoiceRecord['AmountPaid']; ?>" required>

							</div>

						</div>

					</div>

					<input type="number" name="debt" placeholder="Amount owed" value="<?php echo $studentInvoiceRecord['Debt']; ?>" class="form-control" readonly required><br>

					<button class="btn btn-block" type="submit" name="update" style="margin-bottom: 20px; color: white; background-color: #6b2cff;">Update</button>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>

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
		var course = document.querySelector("select[name='course']");
		var cost = document.querySelector("input[name='cost']");

		document.getElementsByTagName('form')[0].addEventListener('change', () => {
            switch (course.value) {
                case course[0].value:
                    cost.value = "50000";
                    break;
                case course[1].value:
                    cost.value = "25000";
                    break;
                case course[2].value:
                    cost.value = "75000";
                    break;
            }
        });
	</script>

</body>

</html>