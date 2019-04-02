<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(
		isset($_GET['email']) && !empty($_GET['email']) &&
		isset($_GET['hash']) && !empty($_GET['hash'])
		)
	{
		$email = $_GET['email'];
		$hash = $_GET['hash'];
			
		# QUERY
		$query = "SELECT `id` FROM `users` WHERE `users`.`email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "' AND `users`.`status` = 'deactivated' AND `users`.`hash` = '" . mysqli_real_escape_string($dbconnection ,$hash) . "'";
		
		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			# QUERY
			$query = "UPDATE `users` SET `status` = 'activated', `hash` = NULL WHERE `users`.`email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "'";

			$result = mysqli_query($dbconnection, $query);

			$_SESSION['notification']['type'] = 'primary';
			$_SESSION['notification']['header'] = 'Email verification';
			$_SESSION['notification']['message'] = 'Email verification completed successfully.';

		} else {

			# QUERY
			$query = "SELECT `id` FROM `users` WHERE `users`.`email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "' AND `users`.`status` = 'activated'";
			
			$result = mysqli_query($dbconnection, $query);
			$result_rows = mysqli_num_rows($result);

			if($result_rows == 1)
			{
				$_SESSION['notification']['type'] = 'warning';
				$_SESSION['notification']['header'] = 'Email verification';
				$_SESSION['notification']['message'] = 'Email verification has been done already.';

			} else {
				
				$_SESSION['notification']['type'] = 'danger';
				$_SESSION['notification']['header'] = 'Email verification';
				$_SESSION['notification']['message'] = 'Invalid request.';

			}
		}		
	}

	error:

	$loc = $_SERVER['HTTP_REFERER'] = './login.php';
	header("Location: $loc");
	
?>