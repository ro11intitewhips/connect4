<?php
	error_reporting (E_ALL);
	
	require_once("./bizDataLayer/exception.php");
	require_once("./classes/Database.class.php");
	require_once("./inc/library.php");
	require_once("../../../../../generateToken.php");
	
	function startRegisterData($d) {
		//var_dump($d);
		
		$data = explode("|", $d);
		$newUsername = sanitize($data[0]);
		$newPassword = sha1(sanitize($data[1]));
		$date = date("Y-m-d H:i:s");
		
		//echo $newUsername . ' - ' . $newPassword . ' - ' . $date;
		
		$db = Database::getInstance();
		$query = 'INSERT INTO connect4_user (username, password, last_login, account_created, num_wins) VALUES (?, ?, ?, ?, ?)';
		$vars = array($newUsername, $newPassword, $date, $date, 0);
		$types = array('s', 's', 's', 's', 'd');
		$db->doQuery($query, $vars, $types);  	  
		$numRows = $db->getAffectedRows();
		$insertRow = $db->getInsertId();
		
		//$db = Database::getInstance();
		//$query = 'INSERT INTO connect4_user (username, password) VALUES (?, ?)';
		//$vars = array($newUsername, $newPassword);
		//$types = array('s', 's');
		//$db->doQuery($query, $vars, $types);  	  
		//$numRows = $db->getAffectedRows();
		//
		
		//echo $numRows;
		
		if($numRows == 1) {
			//echo $newUsername + ' - ' + $newPassword;
			//echo $numRows;
			$row = $db->fetch_array();
			var_dump($row);
			//$userId = $row['user_id'];
			//$v_expire = time() + 60 * 30; // 30 minutes from now
			//$v_path = "/~rgk8573/";
			//$v_domain = "nova.it.rit.edu";
			//$v_secure = false;
			
			//$_COOKIE['token'] = setToken($userId);
			//$token = setToken($userId);
			//setcookie("token", $token, $v_expire, $v_path, $v_domain, $v_secure);
			
			//var_dump($_COOKIE);
			//header("Location: index.php");
			
			return '[{"success":"true"},{"user":'.json_encode($row).'}]';
		}
		
		return '[{"success":"false"},{"error":'.json_encode($db->getError()).'}]';
	}
?>