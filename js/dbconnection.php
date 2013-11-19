<?php
	$hostname = "timsworld.db";
	$database = "atlas";
	$username = "atlas_user";
	$password = "atlaspass";
	$DBconn = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
	
?>