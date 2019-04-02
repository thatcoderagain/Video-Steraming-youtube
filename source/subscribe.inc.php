<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if((isset($_POST['channel_id']) && !empty($_POST['channel_id']) ))
	{
		$user_id = user_id();
		$channel_id = $_POST['channel_id'];

		# QUERY
		$query = "SELECT `id` FROM `subscriber` WHERE `subscriber`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "' AND `subscriber`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) . "'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{			
			$row = mysqli_fetch_assoc($result);
			$cid = $row['id'];

			# QUERY
			$query = "DELETE FROM `subscriber` WHERE `subscriber`.`id` = '" . mysqli_real_escape_string($dbconnection ,$cid) . "'";

			$result = mysqli_query($dbconnection, $query);

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

			echo '{"subscribe":"false", "subscribers":"'.$subscribers.'"}';

		} else {

			if($channel_id != channel_id())
			{
				# QUERY
				$query = "INSERT INTO `subscriber` (`id`, `channel_id`, `user_id`, `subscribed_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "', '" . mysqli_real_escape_string($dbconnection ,$user_id) . "', CURRENT_TIMESTAMP)";

				$result = mysqli_query($dbconnection, $query);
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

			echo '{"subscribe":"true", "subscribers":"'.$subscribers.'"}';

		}
	} else {
		return NULL;
	}

?>