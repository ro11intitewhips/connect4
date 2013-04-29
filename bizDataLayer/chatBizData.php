<?php
	function startChatData($d) {
		$db = Database::getInstance();
		$query = 'SELECT * FROM connect4_user WHERE username = ? AND password = ?';
		$vars = array($username, $password);
		$types = array('s', 's');
		$db->doQuery($query, $vars, $types);  	  
		$numRows = $db->getAffectedRows();
		
		if($numRows == 1) {
			$row = $db->fetch_array();
			$userId = $row['user_id'];
			$_COOKIE['token'] = setToken($userId);
			
			//var_dump($_COOKIE);
			
			return '[{"success":"true"},{"user":'.json_encode($row).'}]';
		}
		else {
			$errors[] = 'Either your username or password is incorrect. Please try again.';
		}
	}

?>