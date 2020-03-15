<?php require "link.php";

session_start();

if(!isset($_SESSION["swift-uid"])){
	header("Location: login.php");
}

else{
$uid = $_SESSION["swift-uid"];
$uname = $_SESSION["swift-uname"];
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Swift</title>
	<link rel="stylesheet" type="text/css" href="swifter.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="body-container-100">
	<form>

	<div class="chat-box-default">
		
		<div class="chat-box-header">
			Swift Chatbox Engine | <?php echo $uname; ?>
			<a href="logout.php"><span class="pull-right fa fa-sign-out"> Logout</span></a>
		</div>

		<div class="chat-box-sidebar">
  				<div class="input-group" style="margin: 5px;">
    				<input type="text" class="form-control" placeholder="Search">
    				<div class="input-group-btn">
      					<button class="btn btn-default" type="submit">
        				<i class="fa fa-search"></i>
      					</button>
    				</div>
  				</div>
  				<p><h4 class="align-center">Active Chats</h4></p>
			<div class="display-active-chats">

			</div>
		</div>
		
		<div class="chat-box-body">
			<div class="chat-profile">
				<div class="profile-img"><i class="fa fa-user fa-2x"></i></div>
				<div class="profile-name"></div>
				<div class="profile-status"></div>
				<div style="display:none" class="profile-id"></div>
			</div>
			<div class="chat-messages">
				<h3 class="align-center">WELCOME TO SWIFT INSTANT MESSENGER</h4><br>
					<p class="align-center"><i class="fa fa-4x swift-logo"><i class="fa fa-bolt fa-2x" style="color:red"></i></i></p><br>
			<p style="text-align:center;">Select a contact to start messaging...</p>
			</div>
		</div>

		<div class="chat-box-footer">
			<div class="col-md-11 col-sm-10 col-xs-9">
			<textarea name="message" id="message" cols="80" onkeydown="if(event.keyCode == 13) sendMessage(<?php echo $uid; ?>)" rows="1" placeholder="enter message here..." class="form-control"></textarea>
			<span class="hidden uid"><?php echo $uid; ?></span>
			</div>
			<div class="col-md-1 col-sm-2 col-xs-3">
				<button type="button" class="btn btn-primary btn-lg" onclick="sendMessage(<?php echo $uid; ?>)"><i class="fa fa-send-o"></i></button>
			</div>
		</div>

	</div>
</div>
<?php include 'script.php'; ?>
</body>
</html>