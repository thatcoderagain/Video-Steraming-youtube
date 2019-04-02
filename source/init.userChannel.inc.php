<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_GET['page']) && !empty($_GET['page']))
		$page = $_GET['page'];
	else
		$page = 1;

	if($page < 1)
		$page = 1;

	$limit = 5;
	$offset = $page * $limit - $limit;
	
	$channel_id = channel_id();

	# QUERY
	$query = "SELECT `name`, `image_filename`, `description`, `slug` FROM `channel` WHERE `channel`.`id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "'";

	$result = mysqli_query($dbconnection, $query);
	$result_rows = mysqli_num_rows($result);

	if($result_rows == 1)
	{
		$row = mysqli_fetch_assoc($result);

		$channel_name = $row['name'];
		$image_filename = $row['image_filename'];
		$description = $row['description'];
		$slug = $row['slug'];

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

		# QUERY
		$query = "SELECT `id`, `title`, `description`, `thumbnail_filename`, `published`, `url` FROM `videos` WHERE `videos`. `channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "' AND `videos`.`visibility` != 'private' ORDER BY `id` DESC LIMIT $offset, $limit";

		$result = mysqli_query($dbconnection, $query);
		$number_of_videos = mysqli_num_rows($result);

		$next = $number_of_videos < $limit ? 0 : 1;
	}
	
?>