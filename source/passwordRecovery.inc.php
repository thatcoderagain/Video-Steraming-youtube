<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_POST['recovery_button']))
	{
		if( isset($_POST['email']) && !empty($_POST['email']) )
		{
			$email = $_POST['email'];

			# QUERY
			$query = "SELECT `email` FROM `users` WHERE `email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "'";
				
			$result = mysqli_query($dbconnection, $query);
			$result_rows = mysqli_num_rows($result);

			if($result_rows == 1)
			{
				$hash = md5(rand());


# SENDING EMAIL
$to = $email;

$subject = 'Password Recovery';

$message = 
"
Dear Play User

You have requested for password recovery in case you have forgot your password. 
To reset and receive a new password for accout $to, please click the link:

".$domain."passwordReset.php?email=$email&hash=$hash

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
				$query = "UPDATE `users` SET `hash` = '" . mysqli_real_escape_string($dbconnection ,$hash) . "' WHERE `users`.`email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "'";

				$result = mysqli_query($dbconnection, $query);
				
				$_SESSION['notification']['type'] = 'primary';
				$_SESSION['notification']['header'] = 'Password recovery';
				$_SESSION['notification']['message'] = 'Password Recovery Email has been sent to you account.';

			} else {
				$_SESSION['notification']['type'] = 'danger';
				$_SESSION['notification']['header'] = 'Password recovery';
				$_SESSION['notification']['message'] = 'Invalid request.';
			}
		}
	}

	error:

	$loc = $_SERVER['HTTP_REFERER'];
	header("Location: $loc");
	
?>