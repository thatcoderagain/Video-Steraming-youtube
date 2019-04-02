<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';	

	if(is_logged_in())
	{
		$user_id = user_id();
	} else {
		
		$address = get_mac_address();

		$query = "SELECT `id`, `address` FROM `guests` WHERE `guests`.`address` = '" . mysqli_real_escape_string($dbconnection, $address) ."'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			$guest_id = $row['id'];
		} else {

			$query = "INSERT INTO `guests` (`id`, `address`, `created_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $address) ."', CURRENT_TIMESTAMP)";

			$result = mysqli_query($dbconnection, $query);

			$guest_id = mysqli_insert_id($dbconnection);
		}
	}

	if(isset($_GET['video']) && strlen($_GET['video']) == 32)
	{
		$url = $_GET['video'];

		$channel_id = is_logged_in() ? channel_id() : 'guest';

		# QUERY
		$query = "SELECT `video_filename`,`audio_filename`,`thumbnail_filename`,`subtitle_filename` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."' AND (`videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) ."' OR `videos`.`visibility` != 'private')";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 0)
		{
			header("Location: ./login.php");
			die();
		} else {
			$row = mysqli_fetch_assoc($result);
			$audio_filename = $row['audio_filename'];
		}
		
		# QUERY
		$query = "SELECT `id`, `channel_id`, `title`, `description`, `published`, `votes`, `comments` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);

			$video_id = $row['id'];
			$channel_id = $row['channel_id'];
			$title = $row['title'];
			$description = $row['description'];
			$published = $row['published'];

			/****************************/
			$votes = $row['votes'];
			$comments = $row['comments'];
			/****************************/

			# QUERY
			$query = "SELECT `name`,`slug`,`image_filename` FROM `channel` WHERE `channel`.`id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) ."'";

			$result = mysqli_query($dbconnection, $query);
			$result_rows = mysqli_num_rows($result);

			if($result_rows == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$channel_name = $row['name'];
				$slug = $row['slug'];
				$channel_image_filename = $row['image_filename'];
				$channel_image_filename = $channel_image_filename != NULL ? $channel_image_filename : $defaultChannel;
			}

			# QUERY
			$query = "SELECT `user_id` FROM `subscriber` WHERE `subscriber`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) ."'";

			$result = mysqli_query($dbconnection, $query);
			$subscribers = mysqli_num_rows($result);

			if($subscribers >= 999)
			{
				$subscribers = ($subscribers/1000);
				$subscribers = substr($subscribers, 0, strripos($subscribers, '.')+2);
				$subscribers = $subscribers . 'K';

				if($subscribers >= 999)
				{
					$subscribers = ($subscribers/1000);
					$subscribers = substr($subscribers, 0, strripos($subscribers, '.')+2);
					$subscribers = $subscribers . 'M';

					if($subscribers >= 999)
					{
						$subscribers = ($subscribers/1000);
						$subscribers = substr($subscribers, 0, strripos($subscribers, '.')+2);
						$subscribers = $subscribers . 'G';
					}
				}
			}

			# QUERY
			$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'like') ."'";

			$result = mysqli_query($dbconnection, $query);
			$likes = mysqli_num_rows($result);

			# QUERY
			$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'dislike') ."'";

			$result = mysqli_query($dbconnection, $query);
			$dislikes = mysqli_num_rows($result);

			# QUERY
			$query = "SELECT `video_id` FROM `views` WHERE `views`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."'";

			$result = mysqli_query($dbconnection, $query);
			$views = mysqli_num_rows($result);

			# QUERY
			if(is_logged_in())
			{
				# QUERY
				$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'like') ."' AND `votes`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

				$result = mysqli_query($dbconnection, $query);
				$is_liked = mysqli_num_rows($result);

				# QUERY
				$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'dislike') ."' AND `votes`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

				$result = mysqli_query($dbconnection, $query);
				$is_disliked = mysqli_num_rows($result);

				# QUERY
				$query = "SELECT `user_id` FROM `subscriber` WHERE `subscriber`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) ."' AND `subscriber`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

				$result = mysqli_query($dbconnection, $query);
				$is_subscribed = mysqli_num_rows($result);

				
				# QUERY
				$query = "SELECT DISTINCT `name` FROM `playlist` WHERE `playlist`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

				$result = mysqli_query($dbconnection, $query);
				$result_rows = mysqli_num_rows($result);
				$playlistNameArray = array();

				while($row = mysqli_fetch_assoc($result)){
					foreach ($row as $key => $value)
					{
						if($key == 'name')
							$playlistNameArray[] = $value;
					}
				}

				# QUERY
				$activePlaylistArray = array();

				$query = "SELECT `name` FROM `playlist` WHERE `playlist`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."' AND `playlist`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."'";

				$result = mysqli_query($dbconnection, $query);
				$result_rows = mysqli_num_rows($result);

				while($row = mysqli_fetch_assoc($result))
				{
					$name = $row['name'];
					$activePlaylistArray[] = $name;
				}
			}

		} else {
			header("Location: ./login.php");
		}
	} else {
		header("Location: ./login.php");
	}	
	
?>