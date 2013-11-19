<?php
	
	require_once('dbconnection.php');

	switch($_GET['action'])
	{
		case 'getTileImg':
			getTileImg($_GET['id']);
			break;
		case 'getTileID':
			getTileID($_GET['col'], $_GET['row']);
			break;
		case 'getTileDetails':
			getTileDetails($_GET['id']);
			break;
		case 'getEmptyTile':
			getEmptyTile();
			break;
		case 'getUserDetails':
			getUserDetails($_GET['id']);
			break;
		default:
	}

	

	function getTileID($col, $row)
	{
		$DBH = db_connect();
		if($DBH)
		{
			
			$pos = "$col,$row";
			$STH = $DBH->prepare("SELECT `id` FROM `atlas`.`tiles` WHERE `position` = :pos AND `deleted` = FALSE AND `flagged` = '0000-00-00 00:00:00' LIMIT 1");
			$STH->bindParam(':pos', $pos, PDO::PARAM_STR,11);
			$STH->execute();
			$result = $STH->fetch(PDO::FETCH_ASSOC);
			if ($result)
				print json_encode($result);
			else
				print json_encode(['id'=>-1]);
			$DBH = null;
		}
	}

	function getTileDetails($col,$row)
	{
		$query = "SELECT `id`, `creator`, `createdon`, `rating`, `level` FROM `atlas`.`tiles` WHERE `position` = '$col,$row' AND `deleted` = FALSE AND `flagged` = '0000-00-00 00:00:00' LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		$row_count = mysql_num_rows($result);
		$results_arr = array();
		
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$results_arr['id'] = $row['id'];
		$results_arr['creator'] = $row['creator'];
		$results_arr['createdon']  = $row['createdon'];
		$results_arr['rating'] = $row['rating'];
		$results_arr['level'] = $row['level'];

		print json_encode($results_arr);
	}

	function getEmptyTile()
	{
		$query = "SELECT `data` FROM `atlas`.`tiles` WHERE `position` = 'blank' LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		list($data) = mysql_fetch_array($result);
		header('Content-type: image/png');
		print $data;
	}

	function getTileImg($id)
	{

		$query = "SELECT `data` FROM `atlas`.`tiles` WHERE `id` = $id";
		$result = mysql_query($query) or die(mysql_error());
		$row_count = mysql_num_rows($result);
		if ($row_count == 0)
		{
			getEmptyTile();
		}
		else
		{
			list($data) = mysql_fetch_array($result);
			header('Content-type: image/png');
			print $data;
		}
	}



?>