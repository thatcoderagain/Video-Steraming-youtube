<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';
	
	if(isset($_GET['name']) && !empty($_GET['name']))
	{
		$user_id = user_id();
		$name = $_GET['name'];
		
		# QUERY
		$query = "SELECT `name`, `created_at`, `updated_at` FROM `playlist` WHERE `playlist`.`name` = '" .mysqli_real_escape_string($dbconnection, $name). "' AND `playlist`.`user_id` = '" .mysqli_real_escape_string($dbconnection, $user_id). "' AND `playlist`.`video_id` IS NULL";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			
			$name = $row['name'];
			$created_at = $row['created_at'];

			$query = "SELECT max(`updated_at`) FROM `playlist` WHERE `playlist`.`name` = '" .mysqli_real_escape_string($dbconnection, $name). "' AND `playlist`.`user_id` = '" .mysqli_real_escape_string($dbconnection, $user_id). "'";

			$result = mysqli_query($dbconnection, $query);
			$result_rows = mysqli_num_rows($result);

			if($result_rows == 1)
			{
				$row = mysqli_fetch_assoc($result);
				
				$updated_at = $row['max(`updated_at`)'];
			}

		} else {
			header('Location: ./userPlaylist.php');
		}
		
	} else {
		header('Location: ./userPlaylist.php');
	}

?>