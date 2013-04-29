<?php
	$v_expire = time() - 3600;
	$v_path = "/~rgk8573/";
	$v_domain = "nova.it.rit.edu";
	$v_secure = false;
	
	setcookie("token", '', $v_expire, $v_path, $v_domain, $v_secure);
    unset($_COOKIE['token']);

    header("Location: index.php");
?>