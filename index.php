<?php
	if(!isset($_COOKIE['token'])) {
		header("Location: login.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect4 | Lobby</title>
	<link type="text/css" rel="stylesheet" media="screen" href="css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" media="screen" href="css/style.css" />
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<!--<script src="js/Objects/Cell.js" type="text/javascript"></script>
	<script src="js/Objects/Piece.js" type="text/javascript"></script>
	<script src="js/gameFunctions.js" type="text/javascript"></script>-->
	<script src="js/ajaxFunctions.js" type="text/javascript"></script>
</head> 
<body class="well noBorder">
	<div class="containter">
		<h2>Welcome to Connect4!</h2>
		<div class="btn-group">
			<a class="btn btn-inverse" href="#"><i class="icon-user icon-white"></i> User</a>
			<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
			<ul class="dropdown-menu">
				<!--<li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
				<li><a href="#"><i class="icon-trash"></i> Delete</a></li>
				<li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>-->
				<li class="divider"></li>
				<li><a href="logout.php"><i class="i"></i>Logout</a></li>
			</ul>
		</div>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span2">
					Online Users
				</div>
				<div class="span10">
					Chat
				</div>
			</div>
		</div>
	</div>
</body>
</html>