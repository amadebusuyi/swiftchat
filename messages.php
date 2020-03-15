<?php require "link.php"; 
include 'functions.php';

if(isset($_POST['sendmsg'])){
	$sid = $_POST['sid'];
	$rid = $_POST['rid'];
	$msg = stripper($_POST['msg']);
	$msg = singleQuote($msg);
	$relid = $_POST['relid'];

	$query = mysqli_query($mysqli, "INSERT into messages (sid, rid, msg, relid) values($sid, $rid, '$msg', '$relid')");
	$del = mysqli_query($mysqli, "DELETE from msg_order where relid = '$relid'");
	$ins = mysqli_query($mysqli, "INSERT into msg_order (relid) values('$relid')");
	if($query){
		$que = mysqli_query($mysqli, "SELECT max(mid) from messages where sid = $sid and relid = '$relid' ");
		$mid = $que->fetch_row();
		$mid = $mid[0];
		$qu = mysqli_query($mysqli, "SELECT * from messages where mid = $mid ");
		$row = $qu->fetch_row();		
		$lid = "<span class='lmid hidden'>$row[0]</span>";
		if($row[5] == 0){
				echo "<div class='chat-out' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-right sent-time'>$row[7]<i class='fa fa-check not-read' id='no-$row[0]'><span class='hidden unread'>$row[0]</span></i></span>$lid</div>";}
			else {
				echo "<div class='chat-out' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-right sent-time'>$row[7]<i class='fa fa-check read' id='no-$row[0]'></i></span>$lid</div>"; 
			}
		
	}
	else{echo "2";}
}

if(isset($_POST['getmsg'])){	
	$sid = $_POST['sid'];
	$rid = $_POST['rid'];
	$relid = $_POST['relid'];
	if($relid == "" || $rid == "" || $sid == ""){
		echo '02';
	}

else{
	$query = mysqli_query($mysqli, "SELECT * from messages where relid='$relid' order by date");
	if($query){
		$num = $query->num_rows;
		if($num >= 1){
			$n=1;
	while($row = $query->fetch_row()){
		if($n == $num){
			$lid = "<span class='lmid hidden'>$row[0]</span>";
		}
		else{$lid="";}
		

		if ($rid == $row[2]){
		$msg = "<div class='chat-in' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-left sent-time'>$row[7]</span> $lid </div>\n";
		$update = mysqli_query($mysqli, "UPDATE messages set status = 1 where mid = $row[0] and relid = '$relid'");}

		else{
			if($row[5] == 0)
				$msg = "<div class='chat-out' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-right sent-time'>$row[7] <i class='fa fa-check not-read' id='no-$row[0]'><span class='hidden unread'>$row[0]</span></i></span> $lid </div>\n";
			else 
				$msg = "<div class='chat-out' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-right sent-time'>$row[7] <i class='fa fa-check read' id='no-$row[0]'></i></span> $lid </div>\n";
		}
		echo $msg;
		$n++;
	}
}
else{
	echo "00";	
}
}
else{
	echo '01';
}
}
}

if(isset($_POST['updatemsg'])){	
	$sid = $_POST['sid'];
	$rid = $_POST['rid'];
	$relid = $_POST['relid'];
	$lmid = $_POST['lmid'];

	$query = mysqli_query($mysqli, "SELECT max(mid) from messages where relid='$relid'");
	$num =$query->num_rows;
	if ($num > 0){
	$mid  = $query->fetch_row();
	$mid = $mid[0];
	$cid = $lmid + 1;

	if ($mid == $lmid){
		$update = mysqli_query($mysqli, "UPDATE messages set status = 1 where sid=$rid and relid = '$relid'");
		echo "00";
	}
	else{
	$query = mysqli_query($mysqli, "SELECT * from messages where relid = '$relid' and mid between $cid and $mid order by date");
	if($query){
	$num_rows = $query->num_rows;
		if($num_rows >= 1){
			$n=1;
	while($row = $query->fetch_row()){
		if($num_rows == $n){$nmid = "<span class='lmid hidden'>$row[0]</span>";}
		else{$nmid = "";}
		

		if ($rid == $row[2]){
		$msg = "<div class='chat-in' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-left sent-time'>$row[7]</span>$nmid</div>";
		$update = mysqli_query($mysqli, "UPDATE messages set status = 1 where sid=$rid and relid = '$relid'");}

		else{
			if($row[5] == 0)
				$msg = "<div class='chat-out' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-right sent-time'>$row[7] <i class='fa fa-check not-read' id='no-$row[0]'><span class='hidden unread'>$row[0]</span></i></span>$nmid</div>";
			else 
				$msg = "<div class='chat-out' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-right sent-time'>$row[7] <i class='fa fa-check read' id='no-$row[0]'></i></span>$nmid</div>";
		}
		echo $msg;
		$n++;
	}
}
else{
	echo '00';	
}
}
else{
	echo '01';
}
}
}
else{echo '02';}
}


if(isset($_GET['unread'])){
	$mid = $_GET['unread'];
	$query = mysqli_query($mysqli, "SELECT status from messages where mid = $mid");
	$mstat = $query->fetch_assoc();
	$mstat = $mstat['status'];
	if($mstat == 1){
		echo "1";
	}
	else{
		echo "Not read";
	}
}

if(isset($_POST['newMsg'])){
	$sid = $_POST['sid'];
	$uid = $_POST['uid'];
	$relid = $_POST['relid'];

	$query = mysqli_query($mysqli, "SELECT * from messages where relid = '$relid' and sid = $sid and status = 0 and catch = 0");
	$num = $query->num_rows;
		if($num >= 1){
			$n=1;
	while($row = $query->fetch_row()){
			$mid = $row[0];
		if($n == $num){
			$lid = "<span class='lmid hidden'>$row[0]</span>";
		}
		else{$lid="";}
		
				echo "<div class='chat-in' id='chat-$row[0]'><p>$row[1]</p><br><span class='pull-left sent-time'>$row[7]</span>$lid</div>\n";
		$que = mysqli_query($mysqli, "UPDATE messages set catch = 1 where mid = $mid");
	
		$n++;
	}
}
else{echo "null";}
}
?>