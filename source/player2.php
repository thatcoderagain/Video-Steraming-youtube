<?php

	require_once './init.player.inc.php';

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
		<link rel="stylesheet" href="./css/player.css">

		<!-- External JS 'files' -->
		<script src="./js/player.js"></script>	
		
	</head>
	<body>

		<!-- Video Player -->
		<div id="player" class="fluid">

			<!-- Video Container -->
			<div id="video-container" class="embed-responsive embed-responsive-16by9">
				<video id="video" class="embed-responsive-item" 
					poster="<?php
								if($thumbnail_filename != NULL)
									echo htmlentities($thumbnailPath.$thumbnail_filename);
							?>"
					webkitAllowFullScreen mozallowfullscreen allowFullScreen>
					<source 
					src="<?php
							echo htmlentities($audiosPath.$audio_filename);
						?>" type="audio/mp3">
					<?php
						if($subtitle_filename != NULL)
							echo '<track src="./' . $subtitlesPath.$subtitle_filename . '" label="Subtitle" kind="captions" srclang="en" default>';
					?>
				</video>
			</div>

			<!-- Image Container -->
			<div id="layer_container" class="embed-responsive embed-responsive-16by9 padding-zero">
			</div>


			<!-- Progress Bar / Seek Bar -->
			<div id="progressbar_container">

				<!-- Buffer Bar -->
				<div id="bufferedbar">
				</div>
				<!-- Progress / Seek Bar -->
				<div id="progressbar">
				</div>
				
			</div>

			<!-- Button Container -->
			<div id="button_container" class="col-xs-12 | col sm-12 | col-md-12 | col-lg-12">
				<div class="pull-left">
					<!-- Play Pause Button -->
					<button type="button" class=" btn btn-sm btn-primary text-nowrap" id="play_pause_button">
						<span class="fa fa-play" aria-hidden="true"></span>
					</button>					
					<!-- Button Container -->
					<button type="button" class="btn btn-sm btn-primary text-nowrap" id="time_field">
						<span aria-hidden="true">000:00 / 000:00</span>
					</button>

					<!-- Sound Button -->
					<button type="button" class=" btn btn-sm btn-primary text-nowrap" id="sound_control_button">
						<i class="fa fa-volume-up" aria-hidden="true"></i>
					</button>
					<!-- Sound Bar Container -->
					<div id="volume_slider_container">						
						<!-- Sound Bar -->
						<div id="volume_slider"></div>
						<!-- Current Volume -->
						<div id="volume">100</div>
					</div>
				</div>
				<div class="pull-right">
					<!-- Audio switch Button -->
					<button type="button" onclick="window.location.href='player.php?video=<?php echo $url; ?>'" class=" btn btn-sm btn-primary text-nowrap" id="audio_button">
						<i class="fa fa-video-camera" aria-hidden="true"></i>
					</button>
					<!-- Speed Control Button -->
					<button type="button" class=" btn btn-sm btn-primary text-nowrap" id="speed_control_button">
						<div class="dropup">

							<!-- Speed Button Image -->
							<i class="fa fa-tachometer"  type="button" data-toggle="dropdown" aria-hidden="true"></i>

							<!-- Speed Button Dropdown -->
							<ul class="dropdown-menu">
								<li><a href="#" onclick="changeSpeed(0.50)">0.50</a></li>
								<li><a href="#" onclick="changeSpeed(0.75)">0.75</a></li>
								<li><a href="#" onclick="changeSpeed(1)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</a></li>
								<li><a href="#" onclick="changeSpeed(1.25)">1.25</a></li>
								<li><a href="#" onclick="changeSpeed(1.50)">1.50</a></li>
								<li><a href="#" onclick="changeSpeed(2)">2.00</a></li>
							</ul>
						</div>
					</button>
					<!-- Subtitle Toggle Button -->
					<button type="button" class=" btn btn-sm btn-primary text-nowrap" id="subtitle_button">
						<i class="fa fa-cc" aria-hidden="true" aria-hidden="true"></i>
					</button>
					<!-- Screen Toggle Button -->
					<button type="button" class=" btn btn-sm btn-primary text-nowrap" id="screen_toggle_button">
						<i class="fa fa-expand" aria-hidden="true"></i>
					</button>
					<input type="hidden" name="url" id="url"
					value="<?php
						echo htmlentities($url);
					?>">
				</div>
			</div>
		</div>

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