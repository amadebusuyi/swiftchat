<?php 
require "link.php";
session_start();
if(isset($_POST["uname"])){
	$uname = strtolower($_POST["uname"]);
	$upass = $_POST["upass"];
$query = mysqli_query($mysqli, "SELECT * from users where uname = '$uname' and pass = '$upass'");
$num = $query->num_rows;
$ro = $query->fetch_assoc();
if($num === 1){
$_SESSION["swift-uid"] = $ro["id"];
$uid = $ro["id"];
$_SESSION["swift-uname"] = $ro["name"];
$query = mysqli_query($mysqli, "UPDATE users set status=1 where id='$uid'");
echo "true";
}
else{
	echo "false";
}
}
?>