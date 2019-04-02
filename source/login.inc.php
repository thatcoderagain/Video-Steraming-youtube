<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_POST['login_button']))
	{
		if(
			isset($_POST['email']) && !empty($_POST['email']) &&
			isset($_POST['password']) && !empty($_POST['password'])
			)
		{
			$email = $_POST['email'];
			$password = $_POST['password'];
			
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

					if(!empty($_POST['remember']))
					{
						setcookie('e', $email, time()+(60*60*24*3));
						setcookie('p', $password, time()+(60*60*24*3));
					}

					$_SESSION['notification']['type'] = 'primary';
					$_SESSION['notification']['header'] = 'Login';
					$_SESSION['notification']['message'] = 'You have been logged in.';

				} else {

					$_SESSION['notification']['type'] = 'warning';
					$_SESSION['notification']['header'] = 'Login';
					$_SESSION['notification']['message'] = 'Login failed. Account needs to be activated first.';

				}
			} else {

				$_SESSION['notification']['type'] = 'danger';
				$_SESSION['notification']['header'] = 'Login';
				$_SESSION['notification']['message'] = 'Email address or password does not match.';

			}
		}
	}
	
	$loc = $_SERVER['HTTP_REFERER'];
	header("Location: $loc");

?>