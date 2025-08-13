<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Set connection variables
$username = "SADMIN";
$password = "SIEBEL";
$connect_string = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=linux)(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=pdb1.us.oracle.com)))";

// Try connecting
$conn = oci_connect($username, $password, $connect_string);

// Check connection
if (!$conn) {
    $e = oci_error();
    echo "Connection failed: " . $e['message'];
    exit;
}

echo "Connected to Oracle successfully!\n";




?>
