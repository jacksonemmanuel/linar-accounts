<?php

$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    echo "Error connecting to host";
}

$db = mysqli_select_db($con, "linarAccounts");

if (!$db) {
    echo "Error selecting database: " . mysqli_error($con);
}

?>