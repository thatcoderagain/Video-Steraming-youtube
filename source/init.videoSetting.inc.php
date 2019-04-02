<?php
	
	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	$loc = $_SERVER['HTTP_REFERER'];

	$channel_id = channel_id();
	$url = $_GET['url'];

	$query = "SELECT `id`, `title`, `description`, `category`, `visibility`, `votes`, `comments`, `audio_filename` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

	$result = mysqli_query($dbconnection, $query);
	$result_rows = mysqli_num_rows($result);

	if($result_rows == 0){
		$_SESSION['notification']['type'] = 'danger';
		$_SESSION['notification']['header'] = 'Invalid Request';
		$_SESSION['notification']['message'] = 'This video is not belongs from your channel.';
		
		# goto error;
		$error = true;
		
	} else {
		$row = mysqli_fetch_assoc($result);

		$title = $row['title'];
		$description = $row['description'];
		$category = $row['category'];
		$visibility = $row['visibility'];
		$votes = $row['votes'];
		$comments = $row['comments'];
		$audio_filename = $row['audio_filename'];		
	}

?>