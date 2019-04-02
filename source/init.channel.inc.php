<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';
	
	$slug = $_GET['slug'];

	if(isset($_GET['page']) && !empty($_GET['page']))
		$page = $_GET['page'];
	else
		$page = 1;

	if($page < 1)
		$page = 1;

	$limit = 5;
	$offset = $page * $limit - $limit;

	# QUERY
	$query = "SELECT `id`, `name`, `image_filename`, `description` FROM `channel` WHERE `channel`.`slug` = '" . mysqli_real_escape_string($dbconnection, $slug) . "'";

	$result = mysqli_query($dbconnection, $query);
	$result_rows = mysqli_num_rows($result);

	if($result_rows == 1)
	{
		$row = mysqli_fetch_assoc($result);

		$channel_id = $row['id'];
		$channel_name = $row['name'];		
		$description = $row['description'];
		$image_filename = $row['image_filename'];
		$image_filename = $image_filename != NULL ? $image_filename : $defaultChannel;

		# QUERY
		$query = "SELECT `views`.`id` FROM `views`, `videos`, `channel` WHERE `channel`.`id` = `videos`.`channel_id` AND `videos`.`id` = `views`.`video_id` AND `channel`.`id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "'";

		$result = mysqli_query($dbconnection, $query);
		$video_views_num = mysqli_num_rows($result);

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

		if(is_logged_in())
		{
			$user_id = user_id();

			# QUERY
			$query = "SELECT `user_id` FROM `subscriber` WHERE `subscriber`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) ."' AND `subscriber`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

			$result = mysqli_query($dbconnection, $query);
			$is_subscribed = mysqli_num_rows($result);
		}

		# LAST QUERY
		$query = "SELECT `id`, `title`, `description`, `thumbnail_filename`, `published`, `url` FROM `videos` WHERE `videos`. `channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "' AND `videos`.`visibility` != 'private' ORDER BY `id` DESC LIMIT $offset, $limit";

		$result = mysqli_query($dbconnection, $query);
		$number_of_videos = mysqli_num_rows($result);

		$next = $number_of_videos < $limit ? 0 : 1;

	} else {
		header('Location: ./userChannel.php');
		die();
	}
	
?>