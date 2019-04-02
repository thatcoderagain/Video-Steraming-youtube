<?php

	require_once './core.inc.php';

	if(isset($_GET['subtitle']) && !empty($_GET['subtitle']))
	{
		$filename = $_GET['subtitle'];
		$file = fopen($subtitlesPath.$filename, 'r');	

		$data = fread($file, filesize($subtitlesPath.$filename));

		fclose($file);
		$file = fopen($subtitlesPath.$filename, 'w');

		$pattern = '/(\d)(\d):(\d)(\d):(\d)(\d)[,](\d)(\d)(\d)/i';
		$replacement = '$1$2:$3$4:$5$6.$7$8$9';

		$converted_data = 'WEBVTT' . "\n\n" . preg_replace($pattern, $replacement, $data);

		fwrite($file, $converted_data);

		fclose($file);
	}

	$loc = $_SERVER['HTTP_REFERER'];
    header("Location: $loc");

?>