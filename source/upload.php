<?php

	require_once './core.inc.php';
	
	if(!is_logged_in())
	{
		header('Location: ./login.php');
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
		
		<!-- External JS -->
		<script src="./js/uploaderAjax.js"></script>
		
	</head>
	<body>
	
		<!-- main div-->
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
			
			<!-- Channel Setting Form-->
			<div class="container">
			
				<!-- Notification Container -->
				<div class="col-xs-12 | col-sm-12 | col-md-8 col-md-offset-2 | centered"></div>
				<!-- End of Notification Container -->
				
				<!-- Upload Container -->
				<div class="col-xs-12 | col-sm-12 | col-md-8 col-md-offset-2 | centered"  id="form-box">
				
					<div class="row">
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>
					
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h4 class="help-block"><strong>Upload Video</strong></h4>
						</div>
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>
						
						<form method="POST" enctype="multipart/form-data">
						
							<div class="form-group" id="uploader">
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="videofile">Choose Video</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<input type="file" accept=".mp4" name="videofile" id="videofile">
									<p class="help-block">Site only support 'mp4' format video files.</p>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1" id="alert">
									<!-- Error Alert Box id="alert"-->
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<button type="button" class="btn btn-primary" onclick="uploadvideo();">
									Upload&nbsp;&nbsp;<i class="fa fa-upload"></i>
									</button>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
							</div>
						
						</form>						
						
						<form action="./upload.inc.php" method="POST" enctype="multipart/form-data">
						
							<div class="form-group hidden" id="form">
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<div class="alert alert-primary" id="uploading">
										<p class="help-block">Uploading video . . . <span id="percentage">0%</span>&nbsp;completed</p>
									</div>
								</div>
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<div class="progress">
										<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%" id="progressbar"></div>
									</div>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<div class="alert alert-success hidden" id="uploadcomplete">
										<p class="help-block">
											Upload Complete.
										</p>
									</div>
								</div>
								
								<!-- hidden attribute video_filename value -->
								<input type="hidden" name="video_filename" id="video_filename">
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="title">Title</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<input type="text" class="form-control" placeholder="Video Title" maxlength="100" name="title" id="title">
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="description">Description</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<textarea class="form-control" placeholder="About your video . . ." rows="3" maxlength="1000" name="description" id="description"></textarea>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<button type="submit" class="btn btn-primary disabled" name="upload_button" id="upload_button" disabled>Finish Upload</button>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
							</div>
							
						</form>
					
					</div>
					<!-- End of row -->
					
				</div>
				<!-- End of Upload Container -->
				
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
					<br>
				</div>
				
			</div>
			
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
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