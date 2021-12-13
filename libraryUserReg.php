<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('location:index.php');
}

$record = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(`id`) AS id FROM `LibraryUsers`"));

if (isset($_POST['register'])) {
  $registrationMonth = mysqli_real_escape_string($con, $_POST['regMonth']);
  $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $phone = mysqli_real_escape_string($con, $_POST['phone']);
  $duration = mysqli_real_escape_string($con, $_POST['duration']);
  $beginPlan = mysqli_real_escape_string($con, $_POST['beginPlan']);
  $endPlan = mysqli_real_escape_string($con, $_POST['endPlan']);
  $cost = mysqli_real_escape_string($con, $_POST['cost']);

  $query = "INSERT INTO `LibraryUsers` (`RegistrationMonth`, `FirstName`, `LastName`, `EmailAddress`, `PhoneNumber`, `Duration`, `PlanBegin`, `PlanEnd`, `Cost`) VALUES ('$regMonth', '$firstName', '$lastName', '$email', '$phone', '$duration', '$beginPlan', '$endPlan', '$cost')";

  $dbQuery = mysqli_query($con, $query);

  if ($dbQuery) {
    echo "<div class='alert alert-success'>Library User successfully registered</div>";
    $_SESSION['user_id'] = $record['id'] + 1;
    $_SESSION['user_name'] = $firstName . ' ' . $lastName;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_duration'] = $duration;
    $_SESSION['user_cost'] = $cost;
    header('refresh:1;url=libraryUserInvoice.php');
  } else {
    echo "<div class='alert alert-danger'>Library User failed to register: " . mysqli_error($con) . "</div>";
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Library users registration</title>
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
          <li class="nav-item-active">
            <a class="nav-link" aria-current="page" href="studentReg.php">Student Registration</a>
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
    <a class="navbar-brand" href="#" style="color: white; background: black;"><i class="fa fa-users"></i>Library User Registration Form</a>
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
              <div class="form-group">
                <h5><b>Library Registration Number</b></h5>
                <h9>Copy the library registration number</h9>
                <input type="text" name="ID" value="LIB0<?php echo $record['id'] + 1; ?>" class="form-control" readonly required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-top: 24px;">
                <h5><b>Month Of Registration</b></h5>
                <select class="form-control" name="regMonth" disabled>
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
              </div>
            </div>
          </div>

          <div class="row" style="margin-top: 10px">
            <div class="col-md-6">
              <div class="form-group">
                <h5><b>First Name</b></h5>
                <input type="text" name="firstName" placeholder="Enter Your First Name" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h5><b>Last Name</b></h5>
                <input type="text" name="lastName" placeholder="Enter Your Last Name" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="row" style="margin-top: 10px">
            <div class="col-md-6">
              <div class="form-group">
                <h5><b>Email Address</b></h5>
                <input type="text" name="email" placeholder="Enter Your Email Address" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h5><b>Phone Number</b></h5>
                <input type="number" name="phone" placeholder="Enter Your Phone Number" class="form-control" required>

              </div>
            </div>
          </div>

          <div class="row" style="margin-top: 10px">
            <div class="col-md-6">
              <div>
                <h5><b>Duration</b></h5>
                <select class="form-control" name="duration">
                  <option>2 Weeks</option>
                  <option>1 Month</option>
                  <option>3 Months</option>
                  <option>6 Months</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h5><b>Cost</b></h5>
                <input type="text" name="cost" value="" class="form-control" readonly>
              </div>
            </div>
          </div>

          <div class="row" style="margin-top: 10px">
            <div class="col-md-6">
              <div class="form-group">
                <h5><b>Plan Begins</b></h5>
                <input type="date" name="beginPlan" placeholder="" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h5><b>Plan Ends</b></h5>
                <input type="date" name="endPlan" placeholder="" class="form-control" readonly>
              </div>
            </div>
          </div>


          <div class="row" style="margin-top: 10px">
            <div class="col-md-12">
              <div class="form-group">
                <button class="btn btn-block" style="color: white; background-color: #FF00FF;" type="submit" name="register">Register user</button>
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
  <script type="text/javascript" src="meaningfulDate.js"></script>
  <script type="text/javascript" src="notEmpty.js"></script>
  <script type="text/javascript">
    var duration = document.querySelector("select[name='duration']");
    var cost = document.querySelector("input[name='cost']");
    var start = document.querySelector("input[name='beginPlan']");
    var end = document.querySelector("input[name='endPlan']");
    var regMonth = document.querySelector("select[name='regMonth']");

    regMonth.value = regMonth[new Date().getMonth()].value;
    cost.value = "₦1000";

    document.getElementsByTagName('form')[0].addEventListener("change", () => {
      var arrayDate = start.value.split('-');
      switch (duration.value) {
        case duration[0].value:
          cost.value = "₦1000";
          end.value = meaningfulDate(arrayDate[0] + '-' + arrayDate[1] + '-' + (Number(arrayDate[2]) + 14).toString());
          break;
        case duration[1].value:
          cost.value = "₦1500";
          end.value = meaningfulDate(arrayDate[0] + '-' + (Number(arrayDate[1]) + 1).toString() + '-' + arrayDate[2]);
          break;
        case duration[2].value:
          cost.value = "₦2500";
          end.value = meaningfulDate(arrayDate[0] + '-' + (Number(arrayDate[1]) + 3).toString() + '-' + arrayDate[2]);
          break;
        case duration[3].value:
          cost.value = "₦4500";
          end.value = meaningfulDate(arrayDate[0] + '-' + (Number(arrayDate[1]) + 6).toString() + '-' + arrayDate[2]);
          break;
      }
    });
  </script>



</body>

</html>