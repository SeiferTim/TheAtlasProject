<?php
	$hostname = "timsworld.db";
	$database = "atlas";
	$username = "SeiferTim";
	$password = "vulpix42";
	$DBconn = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
	
?>