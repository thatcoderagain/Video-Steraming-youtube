<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_POST['upload_button']))
	{		
		$channel_id = channel_id();

		if(
			isset($_POST['video_filename']) &&
			isset($_POST['title']) &&
			isset($_POST['description'])
			)
		{
			echo $video_filename = substr($_POST['video_filename'],0,128);

			if(strlen($video_filename) == 128)
			{
				$video_filename = substr($_POST['video_filename'],0,128);
				$title = !empty($_POST['title']) ? $_POST['title'] : 'Untitled - '.$_SERVER['REQUEST_TIME'] ;
				$description = !empty($_POST['description']) ? $_POST['description'] : 'No description available.';

				# TRY AGAIN
				try_again_collision_resolved:

				$url = md5($video_filename);

				$query = "SELECT `video_filename` FROM `videos` Where `videos`.`video_filename` = '" . mysqli_real_escape_string($dbconnection ,$video_filename) . "'";

				$result = mysqli_query($dbconnection, $query);
				$result_rows = mysqli_num_rows($result);
				
				if($result_rows == 0)
				{
					$query = "SELECT `url` FROM `videos` Where `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "'";

					$result = mysqli_query($dbconnection, $query);
					$result_rows = mysqli_num_rows($result);

					if($result_rows == 0)
					{
						$query = "INSERT INTO `videos` (`id`, `channel_id`, `title`, `description`, `category`, `video_filename`, `audio_filename`, `subtitle_filename`, `thumbnail_filename`, `published`, `visibility`, `votes`, `comments`, `url`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "', '" . mysqli_real_escape_string($dbconnection ,$title) . "', '" . mysqli_real_escape_string($dbconnection ,$description) . "', NULL, '" . mysqli_real_escape_string($dbconnection ,$video_filename) . "', NULL, NULL, NULL, CURRENT_TIMESTAMP, 'private', 'on', 'on', '" . mysqli_real_escape_string($dbconnection ,$url) . "')";
						
						$success = mysqli_query($dbconnection, $query);
						
						if($success) {
							$_SESSION['notification']['type'] = 'primary';
							$_SESSION['notification']['header'] = 'Video Uploading';
							$_SESSION['notification']['message'] = 'Video has been uploaded.';
						} else {
							$_SESSION['notification']['type'] = 'danger';
							$_SESSION['notification']['header'] = 'Video Uploading';
							$_SESSION['notification']['message'] = 'Video uploading failed';
						}
					} else {
						goto resolve_video_filename_collision;
					}
				} else {
					# TRY Again
					resolve_video_filename_collision:

					$new_video_filename = str_shuffle($string) . '.mp4';

					$query = "SELECT `video_filename` FROM `videos` Where `videos`.`video_filename` = '" . mysqli_real_escape_string($dbconnection ,$new_video_filename) . "'";

					$result = mysqli_query($dbconnection, $query);
					$result_rows = mysqli_num_rows($result);
						
					if($result_rows == 0){
						rename ($videosPath.$video_filename, $videosPath.$new_video_filename);
						$video_filename = $new_video_filename;

						goto try_again_collision_resolved;
					} else {
						goto resolve_video_filename_collision;
					}
				}
			} else {
				$_SESSION['notification']['type'] = 'danger';
				$_SESSION['notification']['header'] = 'Uploading Video';
				$_SESSION['notification']['message'] = 'Video uploading failed.';
			}
		}
	}

	$loc = './videoSetting.php?url='.$url;
	header("Location: $loc");
	
?>