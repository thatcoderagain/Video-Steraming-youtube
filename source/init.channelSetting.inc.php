<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';
	
	$channel_id = channel_id();

	# QUERY
	$query = "SELECT `name`, `slug`, `description` FROM `channel` WHERE `channel`.`id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "'";

	$result = mysqli_query($dbconnection, $query);
	$result_rows = mysqli_num_rows($result);

	if($result_rows == 1)
	{
		$row = mysqli_fetch_assoc($result);

		$name = $row['name'];
		$slug = $row['slug'];
		$description = $row['description'];
	}

?>