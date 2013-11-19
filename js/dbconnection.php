<?php
	function db_connect() {
		$hostname = "timsworld.db";
		$database = "atlas";
		$username = "atlas_user";
		$password = "atlaspass";
		try {
			
			$DBH = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
			$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $DBH;
		}
		catch(PDOException $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return null;
		}
	}
	
?>