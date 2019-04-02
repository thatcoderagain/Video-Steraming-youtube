<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_GET['url']) && strlen($_GET['url']) == 32)
	{
		$url = $_GET['url'];

		$channel_id = is_logged_in() ? channel_id() : 'guest';
		
		$query = "SELECT `video_filename`,`audio_filename`,`thumbnail_filename`,`subtitle_filename` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."' AND (`videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) ."' OR `videos`.`visibility` != 'private')";

		$result = mysqli_query($dbconnection, $query);
		$result_rows = mysqli_num_rows($result);

		if($result_rows == 1)
		{
			$row = mysqli_fetch_assoc($result);
			
			$video_filename = $row['video_filename'];
			$audio_filename = $row['audio_filename'];
			$thumbnail_filename = $row['thumbnail_filename'];
			$subtitle_filename = $row['subtitle_filename'];
		} else {
			die('This video is private to the channel and not publicly accessible.');
		}
	}

   	$ffmpegCommand = "ffmpeg";
	$sourceVideo = $videosPath.$video_filename;
	$createdFile = 'files/converted/'.md5(time());
	$newfile = basename($createdFile);
    $quality = $_REQUEST['quality'];
    $size="";

    if(!file_exists("ffmpeg.exe"))
	{
		$_SESSION['notification']['type'] = 'primary';
		$_SESSION['notification']['header'] = 'Converting Video';
		$_SESSION['notification']['message'] = 'Process failed.';
		$loc = './index.php';
		header("Location: $loc");
		die();
	}
     
	if($quality=="240")
		$size="352x240";
	else if($quality=="360")
		$size="480x360";
	else if($quality=="480")
		$size="858x480";
	else if($quality=="720")
		$size="1280x720";
	else if($quality=="1080")
		$size="1920x1080";
	else if ($quality=="2k")
		$size="2048x1080";
	else
		$size="";
      
	if(isset($_REQUEST['mp4'])){
		$command = $ffmpegCommand.'  -i '.$sourceVideo.' -s '.$size.'  '.$createdFile.'.mp4';
		exec($command);
		$createdFile = $createdFile.".".mp4;
	}

	else if(isset($_REQUEST['mkv'])){
		$command = $ffmpegCommand.' -i '.$sourceVideo.' -s '.$size.'  '.$createdFile.'.mkv';
		exec($command);
		$createdFile = $createdFile.".".mkv;
	}

	else if(isset($_REQUEST['flv'])){
		$command = $ffmpegCommand.' -i '.$sourceVideo.' -s '.$size.'  '.$createdFile.'.flv';
		exec($command);
		$createdFile = $createdFile.".".flv;
	}

	else if(isset($_REQUEST['wmv'])){
		$command = $ffmpegCommand.' -i '.$sourceVideo.' -s '.$size.'  '.$createdFile.'.wmv';
		exec($command);
		$createdFile = $createdFile.".".wmv;
	}

	else if(isset($_REQUEST['avi'])){
		$command = $ffmpegCommand.' -i '.$sourceVideo.' -s '.$size.'  '.$createdFile.'.avi';
		exec($command);
		$createdFile = $createdFile.".".avi;
	}

	else if(isset($_REQUEST['mpeg'])){
		$createdFile = $createdFile.".".mpeg;
		$command = $ffmpegCommand.' -i '.$sourceVideo.' -s '.$size.'  '.$createdFile.'.mpeg';
		exec($command);
	}

	else if(isset($_REQUEST['webm'])){
		$command = $ffmpegCommand.' -i '.$sourceVideo.' -s '.$size.'  '.$createdFile.'.webm';
		exec($command);
		$createdFile = $createdFile.".".webm;
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Play</title>

		<!-- siteicon -->
		<link rel="shortcut icon" href="./images/siteicon.ico"/>
		<link rel="bookmark" href="./images/siteicon.ico"/>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="./css/bootstrap.css">

		<!-- Bootstrap theme -->
		<link rel="stylesheet" href="./css/drunken-parrot.css">

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="./css/font-awesome.min.css">

		<!-- Raleway Font CSS -->
		<link rel="stylesheet" href="./css/raleway.min.css">

		<!-- Enternal CSS 'files' -->
		<link rel="stylesheet" href="./css/style.css">
		
	</head>
	<body>
		<div class="container" id="main">			
			<!-- Navigation Bar-->
			<div class="container">
				<?php
					require_once './navbar.php';
					require_once './notificationModal.php';
					require_once './model.inc.php';
				?>              
			</div>
			<!-- End of Navigation Bar-->
			<h3 class="text-center fluid">Your download should start now, click link if it doesn't start . . .</h3>
			<div class="text-center fluid">
				<a class ="btn btn-link" 
					href="<?php echo $createdFile;
					?>"> download now! 
				</a>
			</div>
		</div>
		<!-- End of main div-->
	
		<!-- *************************************************************************** -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) ********************* -->
		<!-- ********* --><script src="./js/jquery.min.js"></script><!-- *************** -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- ********* --><script src="./js/bootstrap.min.js"></script><!-- ************ -->
		<!-- Include all compiled plugins for theme --><!-- **************************** -->
        <!-- ********* --><script src="./js/bootstrap-switch.js"></script><!-- ********* -->
        <!-- ********* --><script src="./js/checkbox.js"></script><!-- ***************** -->
        <!-- ********* --><script src="./js/html5shiv.js"></script><!-- **************** -->
        <!-- ********* --><script src="./js/radio.js"></script><!-- ******************** -->
        <!-- ********* --><script src="./js/switch.js"></script><!-- ******************* -->
        <!-- ********* --><script src="./js/toolbar.js"></script><!-- ****************** -->
		<!-- *************************************************************************** -->
		<!-- *************************************************************************** -->
	</body>
</html>