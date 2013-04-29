<?
	/**
	 *
	 *
	 */
	function sanitize($val) {
		$val = trim($val);
		//$val = strip_tags($val, "<h1><h2><h3><p><img><a><strong><em><ol><ul><li>");
		$val = strip_tags($val);
		$val = htmlentities($val);
		$val = stripslashes($val);
		
		return $val;
	}
	
	/**
	 *
	 *
	 */
	function logout() {  
		
	}
?>