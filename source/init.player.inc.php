<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_GET['video']) && strlen($_GET['video']) == 32)
	{
		$url = $_GET['video'];

		$channel_id = is_logged_in() ? channel_id() : 'guest';
		
		$query = "SELECT `video_filename`,`audio_filename`,`thumbnail_filename`,`subtitle_filename` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."' AND (`videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) ."' OR `videos`.`visibility` != 'private')";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			
			$video_filename = $row['video_filename'];
			$audio_filename = $row['audio_filename'];
			$thumbnail_filename = $row['thumbnail_filename'];
			$subtitle_filename = $row['subtitle_filename'];
		} else {
			die('This video is private to the channel and not publicly accessible.');
		}
	}

?>