<?php

	require_once './core.inc.php';

	# INIT 

	if(isset($_GET['url']) && strlen($_GET['url']) == 32)
	{
		$url = $_GET['url'];
	} else {
		$loc = $_SERVER['HTTP_REFERER'];
		header('Locaton: '.$loc);
		die();
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
	
		<!--main div -->
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
			
			<!-- Line Break div-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			  
			<!-- Container div-->
			<div class="container">
					
				<div class='embed-responsive embed-responsive-16by9 centered col-md-10 col-md-offset-1'>
					<iframe style='min-width: 360px;min-height: 210px;' class='embed-responsive-item' src='player.php?video=<?php echo $url;?>' frameborder='0' scrolling='no' allowfullscreen></iframe>
				</div>

				<!-- Line Break div-->
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
					<br>
				</div>

				<div class="container">

					<form name="down_type" action="convertVideo.php" method="GET">
						<input type="hidden" name="url" 
						value="<?php echo htmlentities($url); ?>">
						<div class="text-center">
							<h2>Choose quality</h2>
							<input type="radio" value="240" name="quality" checked>240p
							<input type="radio" value="360" name="quality">360p
							<input type="radio" value="480" name="quality">480p
							<input type="radio" value="720" name="quality">720p
							<input type="radio" value="1080" name="quality">1080p
							<input type="radio" value="2k" name="quality">2k (experimental) dont use when your file is heavy!
						</div>
						<div class="text-center">
							<h2>Create download Link</h2>
							<button type="submit" name="mp4" class="btn btn-primary">mp4</button>
							<button type="submit" name="mkv" class="btn btn-primary">mkv</button>
							<button type="submit" name="flv" class="btn btn-primary">flv</button>
							<button type="submit" name="wmv" class="btn btn-primary">wmv</button>
							<button type="submit" name="avi" class="btn btn-primary">avi</button>
							<button type="submit" name="mpeg" class="btn btn-primary">mpeg</button>
							<button type="submit" name="webm" class="btn btn-primary">webM</button>
						</div>
					</form>

				</div>
			</div>
			<!-- End of Container div -->

			<!-- Last line break-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			
		</div>
		<!-- End of main div -->
	
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