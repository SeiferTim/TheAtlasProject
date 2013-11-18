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
		case 'getEmptyTile':
			getEmptyTile();
			break;
		default:
	}


	function getTileID($col, $row)
	{
		$query = "SELECT `id` FROM `atlas`.`tiles` WHERE `position` = '$col,$row' AND `deleted` = FALSE AND `flagged` = '0000-00-00 00:00:00' LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		$row_count = mysql_num_rows($result);
		$result_arr = array();
		if ($row_count == 0)
		{
			$result_arr['id'] = -1;
		}
		else
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);

			$result_arr['id'] = $row['id'];
		}
		print json_encode($result_arr);
	}

	function getTileDetails($col,$row)
	{
		$query = "SELECT `id`, `creator`, `createdon`, `rating`, `level` FROM `atlas`.`tiles` WHERE `position` = '$col,$row' AND `deleted` = FALSE AND `flagged` = '0000-00-00 00:00:00' LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		$row_count = mysql_num_rows($result);
		$results_arr = array();
		
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$row_array['id'] = $row['id'];
		$row_array['creator'] = $row['creator'];
		$row_array['createdon']  = $row['createdon'];
		$row_array['rating'] = $row['rating'];
		$row_array['level'] = $row['level'];

		print json_encode($result_arr);
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