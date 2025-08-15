<?php

//$dbServername = "localhost";
//$dbUsername = "root";
//$dbPassword = "Megahard@123";
//$dbName = "MegDA";

$dbServername = "megda.local";
$dbUsername = "megdauser";
$dbPassword = "megdapass";
$dbName = "megda";


$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

date_default_timezone_set('Asia/Kolkata');

?>
