<?php

	@session_start();
	session_destroy();
	setcookie('e',NULL, time()-1);
	setcookie('p',NULL, time()-1);
    @session_start();
    $_SESSION['notification']['type'] = 'primary';
    $_SESSION['notification']['header'] = 'Logging out';
    $_SESSION['notification']['message'] = 'You have been logged out.';

    header('Location: ./login.php');

?>