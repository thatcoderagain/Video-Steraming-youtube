<?php
	
	require_once './core.inc.php';
	require_once './dbconnect.inc.php';
	
	if(isset($_POST['view_trigger']) && isset($_POST['url']) && strlen($_POST['url']) == 32)
	{
		if(is_logged_in())
		{
			$user_id = user_id();
		} else {
			
			$address = get_mac_address();

			# QUERY
			$query = "SELECT `id`, `address` FROM `guests` WHERE `guests`.`address` = '" . mysqli_real_escape_string($dbconnection, $address) ."'";

			$result = mysqli_query($dbconnection, $query);
			$result_rows = mysqli_num_rows($result);

			if($result_rows == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$guest_id = $row['id'];

			} else {

				# QUERY
				$query = "INSERT INTO `guests` (`id`, `address`, `created_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $address) ."', CURRENT_TIMESTAMP)";

				$result = mysqli_query($dbconnection, $query);

				$guest_id = mysqli_insert_id($dbconnection);
			}
		}

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
		$viewed_by = isset($user_id) ? 'user' : 'guest';
		$user_id = isset($user_id) ? $user_id : 'NULL';
		$guest_id = isset($guest_id) ? $guest_id : 'NULL';

		# QUERY
		$query = "INSERT INTO `views` (`id`, `video_id`, `viewed_by`, `user_id`, `guest_id`, `viewed_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $video_id) ."', '" . mysqli_real_escape_string($dbconnection, $viewed_by) ."', " . mysqli_real_escape_string($dbconnection, $user_id) .", " . mysqli_real_escape_string($dbconnection, $guest_id) .", CURRENT_TIMESTAMP);";

		$result = mysqli_query($dbconnection, $query);

		echo '{"viewed":"true"}';

	} else {
		return NULL;
	}

?>