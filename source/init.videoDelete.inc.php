<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';
	
	if(isset($_GET['url']) && strlen($_GET['url']) == 32)
	{
		$channel_id = channel_id();
		$url = $_GET['url'];

		# QUERY
		$query = "SELECT `title`, `published` FROM `videos` WHERE `videos`.`url` = '" .mysqli_real_escape_string($dbconnection, $url). "' AND `videos`.`channel_id` = '" .mysqli_real_escape_string($dbconnection, $channel_id). "'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			
			$title = $row['title'];
			$published = $row['published'];
		} else {
			header('Location: ./userVideos.php');
		}
	} else {
		header('Location: ./userVideos.php');
	}

?>