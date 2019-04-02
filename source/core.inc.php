<?php

	@session_start();
	error_reporting(0);

	require './config.inc.php';

	# GLOBAL VARIABLES

	$string = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789';

	$thumbnailPath = './files/images/thumbnail/';
	$defaultThumbnail = 'default_thumbnail.png';

	$profilePath = './files/images/profile/';
	$defaultProfile = 'default_profile.png';

	$channelPath = './files/images/channel/';
	$defaultChannel = 'default_channel.png';

	$subtitlesPath = './files/subtitles/';

	$videosPath = './files/videos/';

	$audiosPath = './files/audios/';

	# GLOBAL FUNCTIONS

	function logging_by_cookie()
	{
		if(isset($_COOKIE['e']) && !empty($_COOKIE['e']) && isset($_COOKIE['p']) && !empty($_COOKIE['p']))
		{

			if(!($dbconnection = @mysqli_connect($database_host,$database_user,$database_pass,$database_name)) || !(@mysqli_select_db($dbconnection, $database_name)))
			{
				die('Unable to connect to the server.');
			}

			$email = $_COOKIE['e'];
			$password = $_COOKIE['p'];
			$passwordhash = password_to_hash($password);

			#QUERY
			$query = "SELECT `id`, `status` FROM `users` WHERE `email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "' AND `password` = '" . mysqli_real_escape_string($dbconnection ,$passwordhash) . "'";

			$result = mysqli_query($dbconnection, $query);
			$result_rows = mysqli_num_rows($result);

			if($result_rows == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$user_id= $row['id'];
				$status = $row['status'];

				if($status == 'activated')
				{
					$_SESSION['user_id'] = $user_id;

					#QUERY
					$query = "SELECT `id` FROM `channel` WHERE `user_id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

					$result = mysqli_query($dbconnection, $query);
					$result_rows = mysqli_num_rows($result);

					$row = mysqli_fetch_assoc($result);
					$channel_id= $row['id'];
					$_SESSION['channel_id'] = $channel_id;

					if(true)
					{
						setcookie('e', $email, time()+(60*60*24*3));
						setcookie('p', $password, time()+(60*60*24*3));
					}

					$_SESSION['notification']['type'] = 'primary';
					$_SESSION['notification']['header'] = 'Logging In';
					$_SESSION['notification']['message'] = 'You have been logged in.';

				} else {

					$_SESSION['notification']['type'] = 'danger';
					$_SESSION['notification']['header'] = 'Logging In Failed';
					$_SESSION['notification']['message'] = 'Account needs to be activated first.';
				}
			}
		} else {
			return false;
		}
	}

	function is_logged_in()
	{
		if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
		{
			return true;
		} else {
			return false;
		}
	}

	function user_id()
	{
		if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
		{
			return $_SESSION['user_id'];
		} else {
			return false;
		}
	}

	function channel_id()
	{
		if(isset($_SESSION['channel_id']) && !empty($_SESSION['channel_id']))
		{
			return $_SESSION['channel_id'];
		} else {
			return false;
		}
	}

	function password_to_hash($password){
		require_once './crypt/fetchkey.inc.php';
		return md5($salt.$password.$salt);
	}

	function script_filename()
	{
		return substr($_SERVER['SCRIPT_NAME'], strripos($_SERVER['SCRIPT_NAME'], '/') + 1);
	}

	function get_mac_address()
	{
		ob_start();
		system('ipconfig /all');
		$mycomsys=ob_get_contents();
		ob_clean();
		$find_mac = "Physical";
		$pmac = strpos($mycomsys, $find_mac);
		$macaddress=substr($mycomsys,($pmac+36),17);
		return $macaddress;
	}

	function fetch_value($col, $table, $key, $value)
	{
		require_once './dbconnect.inc.php';
		$query = "SELECT `" . mysqli_real_escape_string($dbconnection, $col) . "` FROM `" . mysqli_real_escape_string($dbconnection, $table) . "` WHERE `" . mysqli_real_escape_string($dbconnection, $key) . "` = '" . mysqli_real_escape_string($dbconnection, $value) . "'";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			$value = $row[$col];
			return $value;
		} else {
			return false;
		}
	}

	if(!is_logged_in())
		logging_by_cookie();

	/*
	if(isset($application))
		die('Unable to connect to the server.');
	*/

	/*
	function imageResize($image, $new_width, $new_height)
	{
		return 0;

		header('Content-type: image/jpeg');

		$imageDimensions = getimagesize($image);
		$image_width = $imageDimensions[0];
		$image_height = $imageDimensions[1];

		$new_image = imagecreatetruecolor($new_width, $new_height);
		$old_image = imagecreatefromjpeg($image);

		imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);

		imagejpeg($new_image, $image);
	}
	*/

?>
