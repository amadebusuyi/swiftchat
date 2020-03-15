<?php require 'link.php';
if(isset($_GET['ltm'])){
	$uid = $_GET['ltm'];
$query = mysqli_query($mysqli, "SELECT * from messages where rid = $uid");
$trmsg = $query->num_rows;
$query = mysqli_query($mysqli, "SELECT * from messages where sid = $uid");
$tsmsg = $query->num_rows;
echo "Received: $trmsg <br> Sent: $tsmsg";
}

if(isset($_GET['mc'])){
	$sid = $_GET['sid'];
	$uid = $_GET['uid'];

	$query = mysqli_query($mysqli, "SELECT * from messages where sid = $sid and rid = $uid and status = 0");
	$count = $query->num_rows;
	echo $count;
}

if(isset($_GET['uid'])){
	$uid = $_GET['uid'];
	//$query = mysqli_query($mysqli, "SELECT relid from relationship where type = 'friends' and sid = $uid or rid = $uid");
	$query = mysqli_query($mysqli, "SELECT distinct relid from messages where rid = $uid");
	$row = $query->num_rows;
	if($row<1){
		$val['err'] = "0";
	}
	else{
	while($row = $query->fetch_assoc()){
		$relid = $row['relid'];
		$get = mysqli_query($mysqli, "SELECT * from messages where status = 0 and rid = $uid and relid = '$relid'");
		$val["$relid"] = $get->num_rows;
	}
	}
	echo json_encode($val);

}
 ?>
