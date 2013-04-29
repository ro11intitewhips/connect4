<?php
	if(isset($_COOKIE['token'])) {
		header("Location: index.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect4 | Login</title>
	<!--<meta http-equiv="refresh" content="10">-->
	<link type="text/css" rel="stylesheet" media="screen" href="css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" media="screen" href="css/style.css" />
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<!--<script src="js/Objects/Cell.js" type="text/javascript"></script>
	<script src="js/Objects/Piece.js" type="text/javascript"></script>
	<script src="js/gameFunctions.js" type="text/javascript"></script>-->
	<script src="js/ajaxFunctions.js" type="text/javascript"></script>
	<script src="js/loginFunctions.js" type="text/javascript"></script>
	<script type="text/javascript">
		// grab both inputs, perform similar steps to making token and pass though as one string
		// index.php is the lobby with a check if the user is logged in
		// check in index.php if the session is there, if not, redirect to login.php
		// else, redirect from login to index.php (aka lobby)
		$(document).ready(function() {
			initLogin();
			//location.reload().delay(500000);
			
			//var gameId=<?php echo $_GET['gameId'] ?>;
			//var player="<?php echo $_GET['player']?>";
			////alert(playerId);
			//initGameAjax('start', gameId);
			
			//var token = "<?php echo $_COOKIE['token']; ?>";
			//alert(token);
		});
	</script>
</head> 
<body class="well noBorder">
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="formSignIn" id="loginForm">
            <h1>Connect4</h1>
            <input id="usernameField" class="span4" type="text" placeholder="Username" name="username" /><br />
            <input id="passwordField" class="span4" type="password" placeholder="Password" name="password" /><br />
			<button id="register" class="btn btn-large" type="button" name="register" href="#registerModal" data-toggle="modal">Register</button>
            <button id="signIn" class="btn btn-large btn-primary" type="button" name="submit">Sign in</button>
            <br /><br />
			<span class='alert alert-error'>Invalid username and/or password. Please try again.</span><br />
        </form>
        <footer class="text-info pad">Copyright &copy; 2013 | Robb Krasnow</footer>
	</div>
	<div id="registerModal" class="modal hide fade" aria-hidden="true" aria-labelledby="registerLabel" role="dialog" tabindex="-1">
		<div class="modal-header">
			<a class="close" data-dismiss="modal" href="#">X</a>
			<h1>Register</h1>
		</div>
		<div class="modal-body">
			<form action="index.php" method="post" id="registerModalForm">
				<h3>Username:</h3><input id="newUsernameField" class="span4 formHeadings" type="text" name="newUsername" placeholder="Enter new username (i.e. sobeLyfe)" /><br />
				<h3>Password:</h3><input id="newPasswordField" class="span4 formHeadings" type="password" name="newPassword" placeholder="Enter new password" /><br /><br />
				<span class='alert alert-error'>Invalid username and/or password. Please try again.</span><br />
			</form>
		</div>
		<div class="modal-footer">
			<a class="btn btn-large btn-danger" data-dismiss="modal">Cancel</a>
			<a id="registerButton" class="btn btn-large btn-primary">Sign Up!</a>
		</div>
	</div>
</body>
</html>