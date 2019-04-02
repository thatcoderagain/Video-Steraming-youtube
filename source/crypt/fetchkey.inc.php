<?php
	$key = fopen("./crypt/key", "r");
	$salt = fread($key,filesize("./crypt/key"));
	fclose($key);
?>