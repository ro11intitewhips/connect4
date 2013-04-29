<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect4 | Register</title>
        <link type="text/css" rel="stylesheet" media="screen" href="css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" media="screen" href="css/style.css" />
        <script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!--<script src="js/Objects/Cell.js" type="text/javascript"></script>
        <script src="js/Objects/Piece.js" type="text/javascript"></script>
        <script src="js/gameFunctions.js" type="text/javascript"></script>-->
        <script src="js/ajaxFunctions.js" type="text/javascript"></script>
        <script type="text/javascript">
			// grab both inputs, perform similar steps to making token and pass though as one string
			// index.php is the lobby with a check if the user is logged in
			// check in index.php if the session is there, if not, redirect to login.php
			// else, redirect from login to index.php (aka lobby)
			$(document).ready(function() {
			
			});
		</script>
</head> 
<body class="well noBorder">
    <div class="container">
        <form action="index.php" method="post" class="formSignIn" id="loginForm">
            <h1>Connect4 | Register</h1>
            <input id="usernameField" class="span4" type="text" placeholder="Username" name="username" /><br />
            <input id="passwordField" class="span4" type="password" placeholder="Password" name="password" /><br />
            <button id="signIn" class="btn btn-large btn-primary" type="button" name="submit">Sign in</button>
            <button id="register" class="btn btn-large" type="button" name="register">Register</button><br /><br />
			<span class='alert'>Invalid username and/or password. Please try again.</span><br />
        </form>
        <footer class="text-info pad">Copyright &copy; 2013 | Robb Krasnow</footer>
	</div>
	
</body>
</html>