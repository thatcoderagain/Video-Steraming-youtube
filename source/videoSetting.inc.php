<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	$loc = $_SERVER['HTTP_REFERER'];
	
	if(isset($_POST['url']) && !empty(($_POST['url'])))
	{
		$channel_id = channel_id();
		$url = $_POST['url'];

		$query = "SELECT `id` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);
			$result_rows = mysqli_num_rows($result);

		if($result_rows == 0){
			$_SESSION['notification']['type'] = 'danger';
			$_SESSION['notification']['header'] = 'Invalid Request';
			$_SESSION['notification']['message'] = 'This video is not belongs from your channel.';
			goto error;
		}

		if(!empty($_POST['title']))
		{
			$title = $_POST['title'];

			$query = "UPDATE `videos` SET `title` = '" . mysqli_real_escape_string($dbconnection ,$title) . "' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);
		}

		if(!empty($_POST['description']))
		{
			$description = $_POST['description'];

			$query = "UPDATE `videos` SET `description` = '" . mysqli_real_escape_string($dbconnection ,$description) . "' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);
		}

		if(!empty($_POST['category']))
		{ 
			$category = $_POST['category'];

			$query = "UPDATE `videos` SET `category` = '" . mysqli_real_escape_string($dbconnection ,$category) . "' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);
		}

		if(!empty($_POST['visibility']))
		{ 
			$visibility = $_POST['visibility'];

			$query = "UPDATE `videos` SET `visibility` = '" . mysqli_real_escape_string($dbconnection ,$visibility) . "' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);

			# SENDING NOTIFICATION

			if($visibility == 'public')
			{
				# QUERY
				$query = "SELECT `name` FROM `channel` WHERE `channel`.`id` = '".mysqli_real_escape_string($dbconnection, $channel_id)."'";

				$result = mysqli_query($dbconnection, $query);
				
				$row = mysqli_fetch_assoc($result);
				$channel_name = $row['name'];

				# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # 

				# QUERY
				$query1 = "SELECT `user_id` FROM `subscriber` WHERE `subscriber`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) ."'";

				$result1 = mysqli_query($dbconnection, $query1);
				$subscribers = mysqli_num_rows($result);

				if($subscribers > 0)
				{
					while($row1 = mysqli_fetch_assoc($result1))
					{

						$subscriber_id = $row1['user_id'];

						# QUERY
						$query2 = "SELECT `name`, `email` FROM `users` WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection, $subscriber_id) ."'";

						$result2 = mysqli_query($dbconnection, $query2);

						$row2 = mysqli_fetch_assoc($result2);
						$fullname = $row2['name'];
						$email = $row2['email'];

						# QUERY
						$query2 = "SELECT `title`, `description` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

						$result2 = mysqli_query($dbconnection, $query2);

						$row2 = mysqli_fetch_assoc($result2);
						$title = $row2['title'];
						$description = $row2['description'];

# SENDING EMAIL
$to = "$fullname <$email>";

$subject = "New video released: $title";

$message = 
"
Dear $channel_name Subscriber

We just released a new video: $title.

".substr($description, 0,500)."

Watch now

".$domain."watch.php?video=$url

Stay Tunned with us,

$channel_name

Please note that this message was sent to $email.
If you have received it in error, please delete it, we apologize for the incovenience.
";

						$headers = $headerFrom . "\r\n";
						# $headers .= 'MIME-Version: 1.0' . "\r\n";
						# $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

						$sent = mail($to,$subject,$message,$headers);

						if(!$sent)
						{
							$_SESSION['notification']['type'] = 'danger';
							$_SESSION['notification']['header'] = 'Registration';
							$_SESSION['notification']['message'] = 'Registration failed. Mail Sending Failed.';
						}
					}
				}
			}
		}
		
		if(!empty($_FILES['thumbnail']) && ($_FILES['thumbnail']['size'] != 0))
		{
			$thumbnailNAME = $_FILES['thumbnail']['name'];
			$thumbnailTMPNAME = $_FILES['thumbnail']['tmp_name'];
			$thumbnailSIZE = $_FILES['thumbnail']['size'];
			$thumbnailTYPE = $_FILES['thumbnail']['type'];                
			$thumbnailEXTENSION = strtolower(substr($thumbnailNAME, strripos($thumbnailNAME, '.') + 1));

			if($thumbnailEXTENSION == 'jpg' || $thumbnailEXTENSION == 'jpeg' || $thumbnailEXTENSION == 'png')
			{
				if($thumbnailTYPE == 'image/jpeg' || $thumbnailTYPE == 'image/png')
				{
					if($thumbnailSIZE <= 5120000 )
					{
						$query = "SELECT `video_filename` FROM `videos` Where `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "'";

						$result = mysqli_query($dbconnection, $query);
						$result_rows = mysqli_num_rows($result);

						if($result_rows == 1)
						{
							$row = mysqli_fetch_assoc($result);

							$filename = $row['video_filename'];
							$filename = substr($filename, 0 , 124) . '.jpg';

							if(move_uploaded_file($thumbnailTMPNAME, $thumbnailPath.$filename))
							{
								$query = "UPDATE `videos` SET `thumbnail_filename` = '" . mysqli_real_escape_string($dbconnection ,$filename) . "' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

								$success = mysqli_query($dbconnection, $query);

								if($success)
								{
									# Scaling down image
									/*
									$image = $thumbnailPath.$filename;
									$new_width = 1024;
									$new_height = 576;
									imageResize($image, $new_width, $new_height);
									*/

								} else {
									$_SESSION['notification']['type'] = 'danger';
									$_SESSION['notification']['header'] = 'Thumbnail file Error.';
									$_SESSION['notification']['message'] = 'Thumbnail file uploading failed.';
									goto error;
								}
							}
						}

					} else {
						$_SESSION['notification']['type'] = 'danger';
						$_SESSION['notification']['header'] = 'Thumbnail file Error.';
						$_SESSION['notification']['message'] = 'File size should be less than or equals to 5MB.';
						goto error;
					}
				} else {
					$_SESSION['notification']['type'] = 'danger';
					$_SESSION['notification']['header'] = 'Thumbnail file Error.';
					$_SESSION['notification']['message'] = 'Invalid thumbnail file type.';
					goto error;
				}
			} else {
				$_SESSION['notification']['type'] = 'danger';
				$_SESSION['notification']['header'] = 'Thumbnail file Error.';
				$_SESSION['notification']['message'] = 'Invalid file extension.';
				goto error;
			}
		}

		if(!empty($_FILES['subtitle']) && ($_FILES['subtitle']['size'] != 0))
		{
			$subtitleNAME = $_FILES['subtitle']['name'];
			$subtitleTMPNAME = $_FILES['subtitle']['tmp_name'];
			$subtitleSIZE = $_FILES['subtitle']['size'];
			$subtitleTYPE = $_FILES['subtitle']['type'];                
			$subtitleEXTENSION = strtolower(substr($subtitleNAME, strripos($subtitleNAME, '.') + 1));

			if($subtitleEXTENSION == 'vtt' || $subtitleEXTENSION == 'srt')
			{
				if($subtitleTYPE == 'application/octet-stream')
				{
					if($subtitleSIZE <= 5120000 )
					{
						$query = "SELECT `video_filename` FROM `videos` Where `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "'";

						$result = mysqli_query($dbconnection, $query);
						$result_rows = mysqli_num_rows($result);

						if($result_rows == 1)
						{
							$row = mysqli_fetch_assoc($result);

							$filename = $row['video_filename'];
							$filename = substr($filename, 0 , 124) . '.vtt';

							$query = "SELECT `subtitle_filename` FROM `videos` Where `videos`.`subtitle_filename` = '" . mysqli_real_escape_string($dbconnection ,$filename) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

							$result = mysqli_query($dbconnection, $query);
							$result_rows = mysqli_num_rows($result);

							if(move_uploaded_file($subtitleTMPNAME, $subtitlesPath.$filename))
							{
								$query = "UPDATE `videos` SET `subtitle_filename` = '" . mysqli_real_escape_string($dbconnection ,$filename) . "' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

								$success = mysqli_query($dbconnection, $query);

								if($success)
								{
									if($subtitleEXTENSION == 'srt')
									{
										$subtitleEXTENSION = 'vtt';
										$loc = "./subtitleConvert.inc.php?subtitle=$filename";
										header("Location: $loc");
									}

								} else {
									$_SESSION['notification']['type'] = 'danger';
									$_SESSION['notification']['header'] = 'Subtitle file Error.';
									$_SESSION['notification']['message'] = 'Subtitle file uploading failed.';
								goto error;
								}
							}
						} else {
							$_SESSION['notification']['type'] = 'danger';
							$_SESSION['notification']['header'] = 'Subtitle file Error.';
							$_SESSION['notification']['message'] = 'File size should be less than or equals to 5MB.';
							goto error;
						}
					} else {
						$_SESSION['notification']['type'] = 'danger';
						$_SESSION['notification']['header'] = 'Subtitle file Error.';
						$_SESSION['notification']['message'] = 'Invalid subtitle file type.';
						goto error;
					}
				} else {
					$_SESSION['notification']['type'] = 'danger';
					$_SESSION['notification']['header'] = 'Subtitle file Error.';
					$_SESSION['notification']['message'] = 'Invalid file extension.';
					goto error;
				}
			}
		}

		if(!empty($_POST['votes']))
		{
			$query = "UPDATE `videos` SET `votes` = 'on' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);
		} else {
			$query = "UPDATE `videos` SET `votes` = 'off' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);
		}

		if(!empty($_POST['comments']))
		{
			$query = "UPDATE `videos` SET `comments` = 'on' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);
		} else {
			$query = "UPDATE `videos` SET `comments` = 'off' WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection ,$url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

			$result = mysqli_query($dbconnection, $query);
		}

		$_SESSION['notification']['type'] = 'primary';
		$_SESSION['notification']['header'] = 'Update Success';
		$_SESSION['notification']['message'] = 'Changes are updated successfully.';
	}  

	error:

	header("Location: $loc");
	
?>