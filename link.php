<?php 
$db_host  = "127.0.0.1";
$db_name ="swift";
$username = "root";
$db_pass = "";

$mysqli = new mysqli($db_host, $username, $db_pass, $db_name);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
    exit();
} 
?>