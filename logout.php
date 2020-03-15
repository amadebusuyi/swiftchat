<?php
session_start();
require "link.php";
$uid = $_SESSION['swift-uid'];

  $query = mysqli_query($mysqli, "UPDATE users set status=0 where id='$uid'");
  if($query){
  	session_unset();
	session_destroy();
	header("Location: login.php");}
	else{
		echo "Query not executed";
	}

?>