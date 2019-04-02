<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_POST['video']) && !empty($_POST['video']) && strlen($_POST['video']) == 32)
	{
		$url = $_POST['video'];
				
		# QUERY
		$query = "SELECT `video_filename` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			
			$video_filename = $row['video_filename'];

		} else {
			echo '{"thumbnail":"not extracted"}';
		}

		$thumbnail_filename = substr($video_filename, 0 , 124) . '.jpg';

		$ffmpeg = 'ffmpeg';

		$command = $ffmpeg . ' -i ' . $videosPath . $video_filename . ' -an -ss 00:01:00.000 -vframes 1 -s 1024x576 ' . $thumbnailPath . $thumbnail_filename;

		if(file_exists($thumbnailPath . $thumbnail_filename))
		{
			unlink($thumbnailPath . $thumbnail_filename);
		}

		exec($command);

		# QUERY
		$query = "UPDATE `videos` SET `videos`.`thumbnail_filename` = '" . mysqli_real_escape_string($dbconnection, $thumbnail_filename) ."' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

		$result = mysqli_query($dbconnection, $query);

		echo '{"thumbnail":"extracted"}';

	} else {

		echo '{"thumbnail":"not extracted"}';
	}

?>