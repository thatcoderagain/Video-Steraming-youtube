<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_POST['register_button']))
	{
		if(
			isset($_POST['fullname']) && !empty($_POST['fullname']) &&
			isset($_POST['channelname']) && !empty($_POST['channelname']) &&
			isset($_POST['email']) && !empty($_POST['email']) &&
			isset($_POST['password1']) && !empty($_POST['password1']) &&
			isset($_POST['password2']) && !empty($_POST['password2']) 
			)
		{
			$fullname = $_POST['fullname'];
			$channelname = $_POST['channelname'];
			$email = $_POST['email'];
			$password1 = $_POST['password1'];
			$password2 = $_POST['password2'];

			if($password1 == $password2)
			{
				# QUERY
				$query = "SELECT `email` FROM `users` WHERE `email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "'";
				
				$result = mysqli_query($dbconnection, $query);
				$result_rows = mysqli_num_rows($result);

				if($result_rows == 0)
				{                        
					$passwordhash = password_to_hash($password1);

					$hash = md5(rand());


# SENDING EMAIL
$to = "$fullname <$email>";

$subject = 'Email Verification';

$message = 
"
Dear Play User

We have received a request to authorize an email address for use with Play.
To verify your e-mail address, please click this link:

".$domain."verifyEmail.inc.php?email=$email&hash=$hash

Sincerely,

Play team

Please note that this message was sent to $email.
If you have received it in error, please delete it, we apologize for the incovenience.
";

$headers = $headerFrom . "\r\n";
# $headers .= 'MIME-Version: 1.0' . "\r\n";
# $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$sent = mail($to,$subject,$message,$headers);

if(!$sent)
{
	goto error;
	$_SESSION['notification']['type'] = 'danger';
	$_SESSION['notification']['header'] = 'Registration';
	$_SESSION['notification']['message'] = 'Registration failed. Mail Sending Failed.';
}
					# QUERY
					$query = "INSERT INTO `users` (`id`, `name`, `dob`, `email`, `password`, `created_at`, `updated_at`, `hash`, `status`, `image_filename`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection ,$fullname) . "', NULL, '" . mysqli_real_escape_string($dbconnection ,$email) . "', '" .mysqli_real_escape_string($dbconnection ,$passwordhash) . "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '" . mysqli_real_escape_string($dbconnection ,$hash) . "', 'deactivated', NULL)";

					$success = mysqli_query($dbconnection, $query);

					if($success)
					{
						$user_id = mysqli_insert_id($dbconnection);

						# RETRY LABEL
						channel:                        

						$slug = substr(str_shuffle($string),0,32);

						# QUERY
						$query = "SELECT `slug` FROM `channel` WHERE `slug` = '" . mysqli_real_escape_string($dbconnection ,$slug) . "'";

						$result = mysqli_query($dbconnection, $query);
						$result_rows = mysqli_num_rows($result);                        

						if($result_rows == 0)
						{
							# QUERY
							$query = "INSERT INTO `channel` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `slug`, `image_filename`, `description`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection ,$user_id) . "', '" . mysqli_real_escape_string($dbconnection ,$channelname) . "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '" . mysqli_real_escape_string($dbconnection ,$slug) . "', NULL, 'No description available.')";

							$success = mysqli_query($dbconnection, $query);

							if($success)
							{
								# QUERY
								$query = "INSERT INTO `playlist` (`id`, `user_id`, `name`, `video_id`, `created_at`, `updated_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $user_id) ."', 'Watch Later', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

								$success = mysqli_query($dbconnection, $query);

								$_SESSION['notification']['type'] = 'primary';
								$_SESSION['notification']['header'] = 'Registration';
								$_SESSION['notification']['message'] = 'Registration completed. Now check your mail to activate your account.';

								$loc = './login.php';
								header("Location: $loc");
							} else {
								goto channel;
							}
						} else {
							goto channel;
						}
					}
				} else {
					$_SESSION['notification']['type'] = 'danger';
					$_SESSION['notification']['header'] = 'Registration';
					$_SESSION['notification']['message'] = 'Registration Failed. Email is already registered from another account.';
				}
			} else {
				$_SESSION['notification']['type'] = 'danger';
				$_SESSION['notification']['header'] = 'Registration';
				$_SESSION['notification']['message'] = 'Registration Failed. Passwords does not match.';
			}
		}
	}

	error:

	$loc = $_SERVER['HTTP_REFERER'];
	header("Location: $loc");
	
?>