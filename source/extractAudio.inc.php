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
			echo '{"audio":"not extracted"}';
		}

		$audio_filename = substr($video_filename, 0 , 124) . '.mp3';

		$ffmpeg = 'ffmpeg';

		$command = $ffmpeg . ' -i ' . $videosPath . $video_filename . ' -b:a 192K -vn ' . $audiosPath . $audio_filename;

		if(file_exists($audiosPath . $audio_filename))
		{
			unlink($audiosPath . $audio_filename);
		}

		exec($command);

		# QUERY
		$query = "UPDATE `videos` SET `videos`.`audio_filename` = '" . mysqli_real_escape_string($dbconnection, $audio_filename) ."' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

		$result = mysqli_query($dbconnection, $query);

        echo '{"audio":"extracted"}';

	} else {

        echo '{"audio":"not extracted"}';
	}

?>