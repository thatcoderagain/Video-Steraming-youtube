<?php

	# AJAX ACCESSING SCRIPT

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_FILES['videofile']) && !empty($_FILES['videofile']))
	{
		$videoNAME = $_FILES['videofile']['name'];
		$videoTMPNAME = $_FILES['videofile']['tmp_name'];
		$videoSIZE = $_FILES['videofile']['size'];
		$videoTYPE = $_FILES['videofile']['type'];
		$videoEXTENSION = strtolower(substr($videoNAME, strripos($videoNAME, '.') + 1));

		if($videoEXTENSION == 'mp4')
		{
			if($videoTYPE == 'video/mp4')
			{
				video_filename:

				$filename = str_shuffle($string) . '.mp4';

				$query = "SELECT `video_filename` FROM `videos` Where `videos`.`video_filename` = '" . mysqli_real_escape_string($dbconnection ,$filename) . "'";

				$result = mysqli_query($dbconnection, $query);
				$result_rows = mysqli_num_rows($result);

				if($result_rows == 0)
				{
					if(move_uploaded_file($videoTMPNAME, $videosPath.$filename))
					{
						if(strlen($filename) == 128)
						{	
							echo '{"filename":"'.$filename.'"}';
						} else {
							echo '{"filename":"UPLOADING ERROR"}';
						}
					} else {
						echo '{"filename":"UPLOADING ERROR"}';						
					}
				} else {
					goto video_filename;
				}
			}
		}
	}
	
?>