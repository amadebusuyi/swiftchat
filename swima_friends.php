
<?php
require "link.php";

	if(isset($_POST['active'])){
				$uid = $_POST['active'];
				$lid = $_POST['lid'];
				$friends = [];
			
$clid = mysqli_query($mysqli, "SELECT MAX(msg_order.id) from relationship RIGHT JOIN msg_order ON relationship.relid = msg_order.relid where relationship.sid = $uid or relationship.rid = $uid ");
$cl = $clid->num_rows;
$clf = $clid->fetch_row();

if ($clf[0] == $lid){
	$result['error'] = "00";
	echo json_encode($result);
}

else{
$query = mysqli_query($mysqli, "SELECT relationship.sid, relationship.rid, relationship.relid, msg_order.id, msg_order.relid from relationship RIGHT JOIN msg_order ON relationship.relid = msg_order.relid where relationship.sid = $uid or relationship.rid = $uid order by msg_order.id desc");

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
			$res['display'] = "<a href='chats.html' class='chat-link list-group-item' onclick='getDetail($row[0], \"$row[1]\")' id='chat-$row[0]'><div class='friends-img pull-left'>&nbsp;</div><div class='friends-link'><span class='hidden chat-id'>$row[0]</span>
      <h4 class='list-group-item-heading'>$row[1]</h4>
      <p class='list-group-item-text'>Last message appears here</p></div>
    </a>";	
			$result['rid'] = $row[0];
			$result['rname'] = $row[1];
			$result['status'] = $row[2];
	}
	elseif($rows['sid'] != $uid){
			$user = $rows['sid'];
				$che = mysqli_query($mysqli, "SELECT * from users where id = $user");
				$ro = $che->fetch_row();
			$res['display'] = "<a href='chats.html' class='chat-link list-group-item' onclick='getDetail($ro[0], \"$ro[1]\")' id='chat-$ro[0]'><div class='friends-img pull-left'>&nbsp;</div><div class='friends-link'><span class='hidden chat-id'>$ro[0]</span>
      <h4 class='list-group-item-heading'>$ro[1]</h4>
      <p class='list-group-item-text'>Last message appears here</p></div>
    </a>";
			$result['rid'] = $ro[0];
			$result['rname'] = $ro[1];
			$result['status'] = $ro[2];
	}
	$n++;
	echo json_encode($result);
	echo "&";
			}
		}
	}
			 ?>