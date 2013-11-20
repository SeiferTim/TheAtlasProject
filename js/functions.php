<?php
	
	require_once('dbconnection.php');

	switch($_GET['action'])
	{
		case 'getTileImg':
			getTileImg($_GET['id']);
			break;
		case 'getTileImgFromPos':
			getTileImgFromPos($_GET['col'],$_GET['row']);
		case 'getTileID':
			getTileID($_GET['col'], $_GET['row']);
			break;
		case 'getTileDetails':
			getTileDetails($_GET['id']);
			break;
		case 'getEmptyTile':
			getEmptyTile();
			break;
		case 'getUserName':
			getUserName($_GET['id']);
			break;
		default:
	}

	function getUserName($id)
	{
		$DBH = db_connect();
		if($DBH)
		{
			$STH = $DBH->prepare("SELECT `username` FROM `users` WHERE `id` = :id LIMIT 1");
			$STH->bindParam(':id', $id, PDO::PARAM_INT);
			$STH->execute();
			$result = $STH->fetch(PDO::FETCH_ASSOC);
			if ($result)
				print json_encode($result);
			else
				print json_encode(['error'=>'User not found']);
			$DBH = null;
		}
	}

	function getTileID($col, $row)
	{
		$DBH = db_connect();
		if($DBH)
		{
			
			$pos = "$col,$row";
			$STH = $DBH->prepare("SELECT `id` FROM `tiles` WHERE `position` = :pos AND `deleted` = FALSE AND `flagged` = '0000-00-00 00:00:00' ORDER BY `createdon` DESC LIMIT 1");
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

	function getTileDetails($id)
	{

		$DBH = db_connect();
		if ($DBH)
		{
			$STH = $DBH->prepare("SELECT `user_id`, `createdon`, `rating`, `level`, `position` FROM `tiles` WHERE `id` = :id LIMIT 1");
			$STH->bindParam(':id', $id, PDO::PARAM_INT);
			$STH->execute();
			$result = $STH->fetch(PDO::FETCH_ASSOC);
			if ($result)
				print json_encode($result);
			else
				print json_encode(['error'=>'Tile not found.']);
			$DBH = null;
		}
	}

	function getEmptyTile()
	{
		$DBH = db_connect();
		if ($DBH)
		{
			$STH = $DBH->query("SELECT `data` FROM `tiles` WHERE `id` = -1 LIMIT 1");
			$STH->bindColumn(1, $image, PDO::PARAM_LOB);
			$result = $STH->fetch(PDO::FETCH_BOUND);
			if($result)
			{
				header('Content-type: image/png');
				print $image;
			}
			$DBH = null;
		}
	}

	function getTileImgFromPos($col, $row)
	{
		$DBH = db_connect();
		if ($DBH)
		{
			$pos = "$col,$row";
			$STH = $DBH->prepare("SELECT `data` FROM `tiles` WHERE (`position` = :pos AND `deleted` = FALSE AND `flagged` = '0000-00-00 00:00:00') OR `id` = -1 ORDER BY `createdon` DESC LIMIT 1");
			$STH->bindParam(':pos', $pos, PDO::PARAM_STR,11);
			$STH->execute();
			$STH->bindColumn(1, $image, PDO::PARAM_LOB);
			$result = $STH->fetch(PDO::FETCH_BOUND);
			if ($result)
			{
				header('Content-type: image/png');
				header('Content-length: ' + strlen($image));
				print $image;
			}
			$DBH = null;
		}
	}

	function getTileImg($id)
	{

		$DBH = db_connect();
		if ($DBH)
		{
			$STH = $DBH->prepare("SELECT `data` FROM `tiles` WHERE `id` = :id");
			$STH->bindParam(":id", $id, PDO::PARAM_INT);
			$STH->execute();
			$STH->bindColumn(1, $image, PDO::PARAM_LOB);
			$result = $STH->fetch(PDO::FETCH_BOUND);
			if ($result)
			{
				header('Content-type: image/png');
				header('Content-length: ' + strlen($image));
				print $image;
			}
			$DBH = null;
		}
	}



?>