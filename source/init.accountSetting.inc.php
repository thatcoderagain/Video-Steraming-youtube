<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';
	
	$user_id = user_id();

	# QUERY
	$query = "SELECT `name`, `dob`, `email` FROM `users` WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection, $user_id) . "'";

	$result = mysqli_query($dbconnection, $query);
	$result_rows = mysqli_num_rows($result);

	if($result_rows == 1)
	{
		$row = mysqli_fetch_assoc($result);

		$name = $row['name'];
		$dob = $row['dob'];
		$email = $row['email'];
	}

?>