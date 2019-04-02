<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	$user_id = user_id();

	# QUERY
	$query = "SELECT `name`  FROM `playlist` WHERE `playlist`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."' AND `playlist`.`video_id` IS NULL";

	$playlist_result = mysqli_query($dbconnection, $query);
	$number_of_playlist = mysqli_num_rows($playlist_result);

?>