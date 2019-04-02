<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	
	if( isset($_POST['email']) && !empty($_POST['email']) &&
		isset($_POST['hash']) && !empty($_POST['hash']) &&
		isset($_POST['password1']) && !empty($_POST['password1']) &&
		isset($_POST['password2']) && !empty($_POST['password2'])
		)
	{
		$email = $_POST['email'];
		$hash = $_POST['hash'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];

		if($password1 != $password2)
		{
			$_SESSION['notification']['type'] = 'danger';
			$_SESSION['notification']['header'] = 'Password recovery';
			$_SESSION['notification']['message'] = 'Password does not match.';

			goto error;
		}

		# QUERY
		$query = "SELECT `email` FROM `users` WHERE `users`.`email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "' AND `users`.`hash` = '" . mysqli_real_escape_string($dbconnection ,$hash) . "'";
			
		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$passwordhash = password_to_hash($password1);

# SENDING EMAIL
$to = $email;

$subject = 'New Password';

$message = 
"
Dear Play User

As you requested, your password has now been reset. Your new details are as follows:

Email:<$email>
Password:<$password1>

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
}

			# QUERY
			echo $query = "UPDATE `users` SET `password` = '" . mysqli_real_escape_string($dbconnection ,$passwordhash) . "', `hash` = NULL WHERE `users`.`email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "'";

			$result = mysqli_query($dbconnection, $query);
			
			$_SESSION['notification']['type'] = 'primary';
			$_SESSION['notification']['header'] = 'Password reset';
			$_SESSION['notification']['message'] = 'Password has now been reset.';

			$loc = './login.php';
			header("Location: $loc");
			die();

		} else {
			$_SESSION['notification']['type'] = 'danger';
			$_SESSION['notification']['header'] = 'Password recovery';
			$_SESSION['notification']['message'] = 'Invalid request.';
		}
	}

	error:

	$loc = $_SERVER['HTTP_REFERER'];
	header("Location: $loc");
	
?>