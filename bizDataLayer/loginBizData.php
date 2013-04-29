<?php
	//include exceptions
	require_once('./bizDataLayer/exception.php');
	require_once('./classes/Database.class.php');
	require_once('./inc/library.php');
	//require_once('../../../../../dbInfo.inc');
	require_once('../../../../../generateToken.php');
	
	//if we have gotten here - we know:
	//-they have permissions to be here
	//-we are ready to do something with the database
	//-method calling these are in the svcLayer
	//-method calling specific method has same name droping 'Data' at end checkTurnData() here is called by checkTurn() in svcLayer
	
	
	/*************************
		startData
		
	*/
	function startLoginData($d) {
		$data = explode("|", $d);
		$username = sanitize($data[0]);
		$password = sha1(sanitize($data[1]));
		$errors = array();
		
		//var_dump($d);
		
		//if(empty($errors)) {
			$db = Database::getInstance();
			$query = 'SELECT * FROM connect4_user WHERE username = ? AND password = ?';
			$vars = array($username, $password);
			$types = array('s', 's');
			$db->doQuery($query, $vars, $types);  	  
			$numRows = $db->getAffectedRows();
			
			//echo $numRows;
			
			if($numRows == 1) {
				$row = $db->fetch_array();
				$userId = $row['user_id'];
				$v_expire = time() + 60 * 30; // 30 minutes from now
				$v_path = "/~rgk8573/";
				$v_domain = "nova.it.rit.edu";
				$v_secure = false;
				
				//$_COOKIE['token'] = setToken($userId);
				$token = setToken($userId);
				setcookie("token", $token, $v_expire, $v_path, $v_domain, $v_secure);
				
				//var_dump($_COOKIE);
				//header("Location: index.php");
				
				return '[{"success":"true"},{"user":'.json_encode($row).'}]';
			}
			else {
				$errors[] = 'Either your username or password is incorrect. Please try again.';
			}
		//}
		
		$db->close();
		//return array(false, $errors);
		return '[{"success":"false"},{"error":'.json_encode($errors).'}]';
		//return false;
	}

	/*
	 * Pads a integer into a string based on the number ($num)
	 * 
	 * @param $data The data to be padded
	 * @param $num The amount of padding needed with 0's
	 * @return $padded The padded number in string format
	 * @see http://php.net/manual/en/function.str-pad.php
	 */
	function number_pad($data, $num) {
		$padded = str_pad($data, $num, '0', STR_PAD_LEFT);
		return $padded;
	}
	
	/**
	 * This method is used to interlace arrays by pulling one character from each
	 * array passed in with the next array passed in.
	 *
	 * @param array(s) Any amount of arrays you would like to zip together
	 * @return $result The fully zipped string
	 * @see http://stackoverflow.com/questions/11082461/intersect-2-arrays-in-php
	 *
	 * @example 1a2a3a4a 1b2b3b4b 1c2c3c4c 1d2d3d4d
	 * 			|								  |
	 * 			-----------------------------------
	 * 							 |
	 * 							\/
	 * 			1a1b1c1d 2a2b2c2d 3a3b3c3d 4a4b4c4d
	 * 			
	 * @example 0000 1111 2222 3333
	 * 			|				  |
	 * 			-------------------
	 * 					 |
	 * 					\/
	 * 			0123 0123 0123 0123
	 */
	function zip() {
		// Grab all arrays from the parameters
		$arrays = func_get_args();
		$result = array();
	  
		// Count the length of the arrays to get the length of the longest
		$longest = array_reduce($arrays, function($old, $e) {
			return max($old, count($e));
		}, 0);
	  
		// Traverse the arrays, one element at a time
		for ($i = 0; $i < $longest; $i++) {
			foreach($arrays as $a) {
				if(isset($a[$i])) {
					$result[] = $a[$i];
				}
			}
		}
		
		// Turn string array into a full string (remove if string array needed) and return
		return implode($result);
	}
	
	/**
	 * This method is used to de-interlace strings by pulling out the pattern used by the
	 * zip function.
	 *
	 * @param $string The string you want to unzip
	 * @return array The array of strings unzipped
	 * @see http://stackoverflow.com/questions/11082461/intersect-2-arrays-in-php
	 *
	 * @example 1a1b1c1d 2a2b2c2d 3a3b3c3d 4a4b4c4d
	 * 			|								  |
	 * 			-----------------------------------
	 * 							 |
	 * 							\/
	 * 			1a2a3a4a 1b2b3b4b 1c2c3c4c 1d2d3d4d
	 * 			
	 * @example 0123 0123 0123 0123
	 * 			|				  |
	 * 			-------------------
	 * 					 |
	 * 					\/
	 * 			0000 1111 2222 3333
	 */
	function unzip($string) {
		$ip     = '';
		$time   = '';
		$user   = '';
		$random = '';
		$which  = 0;
		$values = array();
		
		// Run through the entire string and every 4th string, reset $which to 0
		// which starts over the loop for every 4th string
		for($i = 0; $i < strlen($string); $i++) {
			$values[$which] .= substr($string, $i, 1);
			$which = ($which == 3) ? 0 : $which + 1;
		}
		
		// Return an array of all unzipped strings
		return list($ip, $time, $user, $random) = $values;
	}

//	global $mysqli;
//	//return $gameId.'sdf';
//	//simple test for THIS 'game' - resets the last move and such to empty
//	$sql = "UPDATE checkers_games SET player0_pieceID=null, player0_boardI=null, player0_boardJ=null, player1_pieceID=null, player1_boardI=null, player1_boardJ=null WHERE game_id=?";
//	try{
//		if($stmt=$mysqli->prepare($sql)){
//			//bind parameters for the markers (s - string, i - int, d - double, b - blob)
//			$stmt->bind_param("i",$gameId);
//			$stmt->execute();
//			$stmt->close();
//		}else{
//        	throw new Exception("An error occurred while setting up data");
//        }
//	}catch (Exception $e) {
//        log_error($e, $sql, null);
//		return false;
//    }
//	//get the init of the game
//	$sql = "SELECT * FROM checkers_games WHERE game_id=?";
//	try{
//		if($stmt=$mysqli->prepare($sql)){
//			//bind parameters for the markers (s - string, i - int, d - double, b - blob)
//			$stmt->bind_param("i",$gameId);
//			$data=returnJson($stmt);
//			$mysqli->close();
//			return $data;
//		}else{
//            throw new Exception("An error occurred while fetching record data");
//        }
//	}catch (Exception $e) {
//        log_error($e, $sql, null);
//		return false;
//    }
//}

/*********************************Utilities*********************************/
/*************************
	returnJson
	takes: prepared statement
		-parameters already bound
	returns: json encoded multi-dimensional associative array
*/
//function returnJson ($stmt){
//	$stmt->execute();
//	$stmt->store_result();
// 	$meta = $stmt->result_metadata();
//    $bindVarsArray = array();
//	//using the stmt, get it's metadata (so we can get the name of the name=val pair for the associate array)!
//	while ($column = $meta->fetch_field()) {
//    	$bindVarsArray[] = &$results[$column->name];
//    }
//	//bind it!
//	call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);
//	//now, go through each row returned,
//	while($stmt->fetch()) {
//    	$clone = array();
//        foreach ($results as $k => $v) {
//        	$clone[$k] = $v;
//        }
//        $data[] = $clone;
//    }
//    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//	header("Cache-Control: no-store, no-cache, must-revalidate");
//	header("Cache-Control: post-check=0, pre-check=0", false);
//	header("Pragma: no-cache");
//	//MUST change the content-type
//	header("Content-Type:text/plain");
//	// This will become the response value for the XMLHttpRequest object
//    return json_encode($data);
//}
?>