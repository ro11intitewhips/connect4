<?php
	class Page {
		static function header($title='Connect4', $bootstrap, $stylesheet="css/style.css"){
			$header = '<!DOCTYPE html>
					  <html lang="en">
					  <head>
						 <meta charset="utf-8" />
						 <title>'.$title.'</title>
						 <link type="text/css" rel="stylesheet" media="screen" href="'.$bootstrap.'" />
						 <link type="text/css" rel="stylesheet" media="screen" href="'.$stylesheet.'" />
					  </head>
					  <body>
						 <div class="container">';
				   
			return $header;
		}
	   
		static function footer($author='') {
			$footer = 	'<script src="http://code.jquery.com/jquery.min.js"></script>
						 <script src="js/bootstrap.min.js" type="text/javascript"></script>
						 <footer class="text-info pad">'.$author.'</footer>
					  </div>
				   </body>
				   </html>';
				   
			return $footer;
		}
		
		static function show_login() {
			$login = '<form action="index.php" method="POST" class="form-signin" id="login">
						<h1>Connect4</h1>
						<input class="span4" type="text" placeholder="Username" name="username"><br />
						<input class="span4" type="password" placeholder="Password" name="password"><br />
						<button class="btn btn-large btn-primary" type="submit" name="submit">Sign in</button>
						<button class="btn btn-large" type="submit" name="register">Register</button>
					  </form>';
				
			return $login;
		}
		
		static function show_lobby() {
			$lobby = '<h1>Welcome to Connect4!</h1>
					  <article class="container-fluid">
						<section class="row-fluid">
							<section class="span9 size">GAME</section>
							<section class="span3 size">CHAT</section>
						</section>
					  </article>';
			
			return $lobby;
		}
	}
?>