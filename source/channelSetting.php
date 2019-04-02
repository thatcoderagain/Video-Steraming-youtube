<?php

	require_once './core.inc.php';
	
	if(!is_logged_in())
	{
		header('Location: ./login.php');
		die();
	}

	require_once './init.channelSetting.inc.php';
	
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
		
		<!-- AJAX JS -->
		<script src="./js/uniqueUrlAjax.js"></script>
		
	</head>
	<body>
	
		<!-- main div -->
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
			
				<div class="col-xs-12 | col-sm-12 | col-md-8 col-md-offset-2 | col-lg-8 col-lg-offset-2 centered"  id="form-box">
				
					<div class="row">
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>
					
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h4 class="help-block"><strong>Channel Setting</strong></h4>
						</div>
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>
						
						<form action="./channelSetting.inc.php" method="POST" enctype="multipart/form-data">
						
							<div class="form-group">
						
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="name">Name</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<input type="text" class="form-control" name="name" id="name"
									placeholder="<?php
													echo htmlentities($name);
												?>">
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="slug">Unique URL</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">									
									<div class="input-group" id="slugInput">
									  	<div class="input-group-addon">http://www.play.com/channel/</div>
									  	<input type="text" class="form-control " name="slug" id="slug" onkeyup="slugAvailability()"
									  		placeholder="<?php
									  						echo htmlentities($slug);
									  					?>">
									  	<div class="input-group-addon" id="slugIcon">&nbsp;&nbsp;&nbsp;</div>
									</div>
								</div>

								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="description">Description</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">									
									<textarea class="form-control" rows="3" name="description" id="description"
									placeholder="<?php
													echo htmlentities($description);
												?>"></textarea>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="imagefile">Channel Image</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">									
									<input type="file" accept=".jpeg, .jpg, .png" name="imagefile" id="imagefile">
									<p class="help-block">The images ratio should be 1:1. The image will be logo for your channel.</p>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<button type="submit" class="btn btn-primary" name="update_button" id="update_button">Update</button>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
							</div>
							
						</form>
							
					</div>

				</div>
				
			</div>
			
			<!-- Line Break div-->
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