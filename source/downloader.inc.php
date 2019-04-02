<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_GET['url']) && !empty($_GET['url']) && isset($_GET['type']) && !empty($_GET['type']))
	{
		$url = $_GET['url'];
		$type = $_GET['type'];

		# QUERY
		$query = "SELECT `video_filename`,`audio_filename` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			
			$video_filename = $row['video_filename'];
			$audio_filename = $row['audio_filename'];

		} else {
			header('Location: ./login.php');
			die();
		}

		$filename = ($type == 'video') ? $video_filename : $audio_filename;
		$path = ($type == 'video') ? $videosPath : $audiosPath;

		if(file_exists($path.$filename))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: inline; filename="'.$path.$filename.'"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($path.$filename));

			readfile($path.$filename);

		} else {
			header('Location: ./login.php');
			die();
		}
		
	}	else {
		header('Location: ./login.php');
		die();
	}	

?>