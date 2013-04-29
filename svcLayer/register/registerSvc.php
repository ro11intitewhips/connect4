<?php
	error_reporting (E_ALL);

	require_once("./bizDataLayer/registerBizData.php");
	require_once("../../../../../dbInfo.inc");
	
	function startRegister($d) {
		//echo $d;
		return startRegisterData($d);
	}
?>