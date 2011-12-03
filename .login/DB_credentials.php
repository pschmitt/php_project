<?php
	$hostname="Math-Portable"; // MAY BE CHANGED TO SUIT YOUR HOSTNAME
	$server = $_SERVER['SERVER_NAME'];
	$table = "Recipes";

	if (($server === "localhost") || ($server === "127.0.0.1") || ($server === $hostname)){
		$db_host = "localhost";
		$db_name = "cooking";
		$db_user = "root";
		$db_password = "";	
	} else {
		$db_host = "XXXX";
		$db_name = "XXXX";
		$db_user = "XXXX";
		$db_password = "XXXX";
	}
?>
