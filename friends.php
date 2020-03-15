<?php require "link.php";
			
			if(isset($_GET['active'])){
				$uid = $_GET['active'];
				$lid = $_GET['lid'];
			
$clid = mysqli_query($mysqli, "SELECT MAX(msg_order.id) from relationship RIGHT JOIN msg_order ON relationship.relid = msg_order.relid where relationship.sid = $uid or relationship.rid = $uid ");
$cl = $clid->num_rows;
$clf = $clid->fetch_row();

if ($clf[0] == $lid){
	echo "00";
}

else{
$query = mysqli_query($mysqli, "SELECT relationship.sid, relationship.rid, relationship.relid, msg_order.id, msg_order.relid from relationship LEFT JOIN msg_order ON relationship.relid = msg_order.relid where relationship.sid = $uid or relationship.rid = $uid order by msg_order.id desc");

	$no = $query->num_rows;
	$n = 1;
			while($rows = $query->fetch_assoc()){
			if($n == 1){
				$lastid = "<span id='last-fchat-id' class='hidden'>".$rows['id']."</span>";
			}
			else{
				$lastid = "";
			}

			if($rows['rid'] != $uid){
				$user = $rows['rid'];
				$check = mysqli_query($mysqli, "SELECT * from users where id = $user");
				$row = $check->fetch_row();
			echo "<p class='display-uname' id='name-$row[0]'><a href='#' onclick='getMessage($row[0], \"$row[1]\", $row[2])' class='chat-uname'>$row[1] 
		<span class='pull-right badge' id='mcount-$row[0]'></span></a> <span class='hidden uname-id'>$row[0]</span> $lastid</p>";	
	}
	elseif($rows['sid'] != $uid){
			$user = $rows['sid'];
				$che = mysqli_query($mysqli, "SELECT * from users where id = $user");
				$ro = $che->fetch_row();
			echo "<p class='display-uname' id='name-$ro[0]'><a href='#' onclick='getMessage($ro[0], \"$ro[1]\", $ro[2])' class='chat-uname'>$ro[1] 
		<span class='pull-right badge' id='mcount-$ro[0]'></span></a> <span class='hidden uname-id'>$ro[0]</span> $lastid</p>";
	}

	$n++;
			}
		}
	}			

?>