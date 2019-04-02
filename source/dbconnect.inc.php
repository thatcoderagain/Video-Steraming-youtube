<?php

	require './config.inc.php';

	if(!($dbconnection = @mysqli_connect($database_host, $database_user, $database_pass, $database_name)) || !(@mysqli_select_db($dbconnection, $database_name)))
    {
        die('Unable to connect to the server.');
    }
    
?>