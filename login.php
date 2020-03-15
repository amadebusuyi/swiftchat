<?php 
if(isset($_SESSION['swift-uid'])){
	header("Location: index.php");
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

    <!-- Sign in form goes here -->
    <div class="panel panel-default login-panel">
      <div class="panel-heading"><font><span style="margin-top: 10px; margin-right:20px;" class="glyphicon glyphicon-lock pull-right"></span>
        <h4> Login to Swift </h4></font></div>
      <form method="post" name="login_form" onsubmit="return access()" action="">
        <div class="panel-body">
          <p id="error"></p>
                  <div class="form-group username">
                    <label for="userName">Username</label>
                    <input class="form-control" placeholder="Username"  type="text" id="swift-u"  name="username"/>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" placeholder="Password"  type="password" id="swift-p"  name="psword"/>
                  </div>

                  <div style="background: white; padding: 0 5px; position: absolute; right: 30px">
                    <input type="submit" value="Login" class="btn btn-danger" id="swift-log" name="login"/>
                </div>                  
        </div>
    </form>
                
    </div>

    <?php include 'script.php'; ?>