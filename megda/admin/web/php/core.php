<?php
// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Asia/Kolkata');

// variables used for jwt
$key = "KAVMS2021";
$iss = "http://techmh.com";
$aud = "http://techmh.com";
$iat = time();
$exp = $iat + (4* 60 * 60);
$nbf = $iat;
?>