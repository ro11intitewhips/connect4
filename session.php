<?php
	require_once('../../../../../dbInfo.inc');
	
	// Set user's IP, Server Request Time, and two random strings for added security in token
	$userIpAddr      = $_SERVER['REMOTE_ADDR'];
	$userRequestTime = $_SERVER['REQUEST_TIME'];
	$tempIds         = array(0, 1, 2, 3, 9, 10, 14, 25, 36, 47, 58, 69, 99, 100, 142412555);
	$alphaNum        = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$nonAlpha        = "`~!@#$%^&*()_+-={}|[]\:\";'<>?,./";
	
	// IP ADDRESS
	// Remove periods from IP address so original IP can be compared to un-converted IP
	// Convert IP to base defined in dbInfo.inc and pad with 0s until it's 10 chars long
	echo '<strong>IP (before): </strong>' .$userIpAddr.'<br />';
	$userIpAddrImp = implode(explode(".", $userIpAddr));
	$userIpAddrPad = number_pad(base_convert($userIpAddrImp, 10, IP_ADDRESS), 10);
	echo '<strong>IP (after): </strong>' .$userIpAddrPad.'<br /><br />';
	
	// REQUEST TIME
	// Convert request time to base defined in dbInfo.inc and pad with 0's until its 10 chars long
	echo '<strong>Time (before): </strong>' .$userRequestTime.'<br />';
	$userRequestTimePad = number_pad(base_convert($userRequestTime, 10, REQUEST_TIME), 10);
	echo '<strong>Time (after): </strong>' .$userRequestTime.'<br /><br />';

	// USER ID'S & TOKENS
	for($i = 0; $i < count($tempIds); $i++) {
		// Take temporary User ID's and pad them to 10 chars long to match other 10 char strings
		echo '<br /><strong>UserID (before): </strong>'.$tempIds[$i].'<br />';
		$tempIds[$i] = number_pad($tempIds[$i], 10);
		echo '<strong>UserID (after): </strong>'.$tempIds[$i].'<br />';
		
		// Shuffle both strings and take 5 chars from each shuffled string and concatenate them to make
		// a 10 char string to match other 10 char strings
		$randomShuffle = str_shuffle(substr(str_shuffle($alphaNum), 0, 5).
									 substr(str_shuffle($nonAlpha), 0, 5));
		echo '<strong>RANDOM STRING: </strong>'.$randomShuffle.' - '.strlen($randomShuffle);
		
		// Split all 10 char strings into string arrays to be used with zip function for interlacing
		$ipArray     = str_split($userIpAddrPad);
		$timeArray   = str_split($userRequestTimePad);
		$userIdArray = str_split($tempIds[$i]);
		$randomArray = str_split($randomShuffle);
		
		// Return string of all zipped arrays (userIP, userRequestTime, userId, and random)
		$zipped = zip($ipArray, $timeArray, $userIdArray, $randomArray);
		echo '<br /><strong>ZIPPED: </strong>'.$zipped.' - ' . strlen($zipped).'<br />';
		
		// Create actual token by taking a sha of the zipped up string
		$token = sha1($zipped);
		echo '<strong>TOKEN (SHA1): </strong>'.$token.' - ' . strlen($token).'<br />';
		
		// Combine both sha'd string and non-sha'd string
		$tokenFull = $token.$zipped;
		echo '<strong>FULL TOKEN: </strong>'.$tokenFull.'<br />';
		
		// Split the token up again to make sure the first 40 chars are the same (TOKEN)
		$splitToken = substr($tokenFull, 0, 40);
		echo '<strong>SPLIT TOKEN: </strong>'.$splitToken.'<br />';
		
		// Split the token up again to make sure the second 40 chars are the same (ZIPPED)
		$splitZipped = substr($tokenFull, 40, 80);
		echo '<strong>SPLIT ZIPPED: </strong>'.$splitZipped.'<br />';
		
		// Unzip the second 40 chars
		$result = unzip($splitZipped);
		
		// Check if the sha of the zipped portion matches the token.
		// If so, no one has messed with the token
		if(strcmp($token, sha1($zipped) == 0)) {
			echo '<br /><strong>TOKEN/ZIPPED : </strong>'.$token . ' == ' . sha1($zipped) . ' - SUCCESS!';
			
			// Grab all data from unzip
			$ip     = base_convert($result[0], IP_ADDRESS, 10);
			$time   = base_convert($result[1], REQUEST_TIME, 10);
			$user   = $result[2];
			$random = $result[3];
			
			// Check if userIp, userRequestTime, and userId's are the same as before
			if(strcmp($ip, $userIpAddrImp) == 0) {
				echo '<br /><strong>IP ADDRESS : </strong>'.$ip . ' == ' . $userIpAddrImp . ' - SUCCESS!';
			}
			if(strcmp($time, $userRequestTime) == 0) {
				echo '<br /><strong>TIME REQUEST : </strong>'.$time . ' == ' . $userRequestTime . ' - SUCCESS!';
			}
			if(strcmp($user, $tempIds[$i]) == 0) {
				echo '<br /><strong>USER ID : </strong>'.$user . ' == ' . $tempIds[$i] . ' - SUCCESS!<br /><br />';
			}
		}
		
		echo '----------------------------------------------------';
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
?>