<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(is_logged_in() && isset($_POST['button']) && isset($_POST['url']))
	{
		$user_id = user_id();
		$button = $_POST['button'];
		$url = $_POST['url'];

		# QUERY
		$query = "SELECT `id` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			$video_id = $row['id'];
		}

		# QUERY
		$query = "SELECT `id`, `video_id`, `user_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) . "' AND `votes`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) . "'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			$vid = $row['id'];
			$PreVoted_as = $row['voted_as'];

			if($button == 'like_button')
			{
				$voted_as = 'like';
			}
			if($button == 'dislike_button')
			{                
				$voted_as = 'dislike';
			}

			if($PreVoted_as == $voted_as)
			{
				# QUERY
				$query = "DELETE FROM `votes` WHERE `votes`.`id` = '" . mysqli_real_escape_string($dbconnection, $vid) . "'";

				$result = mysqli_query($dbconnection, $query);

				# QUERY
				$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'like') ."'";

				$result = mysqli_query($dbconnection, $query);
				$likes = mysqli_num_rows($result);

				# QUERY
				$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'dislike') ."'";

				$result = mysqli_query($dbconnection, $query);
				$dislikes = mysqli_num_rows($result);

				echo '{"voted_as":"none", "likes":"'.$likes.'", "dislikes":"'.$dislikes.'"}';

			} 
			else {
				# QUERY
				$query = "UPDATE `votes` SET `voted_as` = '" . mysqli_real_escape_string($dbconnection ,$voted_as) . "' WHERE `votes`.`id` = '" . mysqli_real_escape_string($dbconnection ,$vid) . "'";

				$result = mysqli_query($dbconnection, $query);

				# QUERY
				$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'like') ."'";

				$result = mysqli_query($dbconnection, $query);
				$likes = mysqli_num_rows($result);

				# QUERY
				$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'dislike') ."'";

				$result = mysqli_query($dbconnection, $query);
				$dislikes = mysqli_num_rows($result);

				echo '{"voted_as":"'.$voted_as.'", "likes":"'.$likes.'", "dislikes":"'.$dislikes.'"}';

			}
		} 
		else {
			
			if($button == 'like_button')
			{
				$voted_as = 'like';
			}
			if($button == 'dislike_button')
			{ 
				$voted_as = 'dislike';
			}

			# QUERY
			$query = "INSERT INTO `votes` (`id`, `video_id`, `user_id`, `voted_as`, `voted_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $video_id) . "', '" . mysqli_real_escape_string($dbconnection, $user_id) . "', '" . mysqli_real_escape_string($dbconnection, $voted_as) . "', CURRENT_TIMESTAMP)";

			$result = mysqli_query($dbconnection, $query);

			# QUERY
			$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'like') ."'";

			$result = mysqli_query($dbconnection, $query);
			$likes = mysqli_num_rows($result);

			# QUERY
			$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'dislike') ."'";

			$result = mysqli_query($dbconnection, $query);
			$dislikes = mysqli_num_rows($result);

			echo '{"voted_as":"'.$voted_as.'", "likes":"'.$likes.'", "dislikes":"'.$dislikes.'"}';

		}

	} else {
		return NULL;
	}

?>