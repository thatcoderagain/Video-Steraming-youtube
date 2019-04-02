<?php

	require_once './core.inc.php';
	
	if(!is_logged_in())
	{
		header('Location: ./login.php');
		die();
	}
	
?>

<?php

	if(isset($_GET['url']) && !empty($_GET['url']) && (strlen($_GET['url']) == 32))
	{
		require_once '/init.videoSetting.inc.php';

		if(isset($error))
			goto error;
	} else {

		error:

    	header('Location: ./userVideos.php');
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

		<!-- Enternal JS -->
		<script src="./js/videoSetting.js"></script>
		
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
			
			<!-- Video Setting Form-->
			<div class="container">
			
				<div class="col-xs-12 | col-sm-12 | col-md-12 col-lg-12 | centered"  id="form-box">
				
					<div class="row">
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>
					
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h4 class="help-block"><strong>Video Setting</strong></h4>
						</div>
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>
						
						<form action="videoSetting.inc.php" method="POST" enctype="multipart/form-data">
						
							<div class="form-group">
						
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<div class="alert alert-primary" role="alert">
										<strong>Your video is available at </strong>
										<input type="text" class="form-control help-block" 
										value="<?php
												echo htmlentities($domain.'watch.php?video='.$_GET['url']);
												?>"
										id="video_url" readonly>										
										</textarea>
									</div>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<input type="hidden" name="url" id="url" value="<?php if(isset($_GET['url'])) echo htmlentities($_GET['url']); ?>">
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="title">Title</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<input type="text" class="form-control" 
									placeholder="<?php 
													echo htmlentities($title);
												?>"
									maxlength="100" name="title" id="title">
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="description">Description</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<textarea class="form-control" 
									placeholder="<?php 
													echo htmlentities($description);
												?>"
									maxlength="1000" rows="3" name="description" id="description"></textarea>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="category">Category</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">									
									<select class="form-control" name="category" id="category">
										<option value="" <?php if($category == NULL) echo 'selected';?> disabled>-- NOT CHOSEN --</option>
										<option value="01" <?php if($category == '01') echo 'selected';?> >Autos & Vehicles</option>
										<option value="02" <?php if($category == '02') echo 'selected';?> >Comedy</option>
										<option value="03" <?php if($category == '03') echo 'selected';?> >Education</option>
										<option value="04" <?php if($category == '04') echo 'selected';?> >Entertainment</option>
										<option value="05" <?php if($category == '05') echo 'selected';?> >Film & Animation</option>
										<option value="06" <?php if($category == '06') echo 'selected';?> >Gaming</option>
										<option value="07" <?php if($category == '07') echo 'selected';?> >How to & Style</option>
										<option value="08" <?php if($category == '08') echo 'selected';?> >Music</option>
										<option value="09" <?php if($category == '09') echo 'selected';?> >News & Politics</option>
										<option value="10" <?php if($category == '10') echo 'selected';?> >Nonprofits & Activism</option>
										<option value="11" <?php if($category == '11') echo 'selected';?> >People & Blogs</option>
										<option value="12" <?php if($category == '12') echo 'selected';?> >Pets & Animals</option>
										<option value="13" <?php if($category == '13') echo 'selected';?> >Science & Technology</option>
										<option value="14" <?php if($category == '14') echo 'selected';?> >Sports</option>
										<option value="15" <?php if($category == '15') echo 'selected';?> >Travel & Events</option>
									</select>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="visibility">Visibility</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<select class="form-control" name="visibility" id="visibility">
										<option value="private" <?php if($visibility == 'private') echo 'selected';?> >Private</option>
										<option value="unlist" <?php if($visibility == 'unlist') echo 'selected';?> >Unlist</option>
										<option value="public" <?php if($visibility == 'public') echo 'selected';?> >Public</option>
									</select>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="thumbnail">Thumbnail Image</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<input type="file" accept=".jpeg, .jpg, .png" name="thumbnail" id="thumbnail">
									<p class="help-block">The image ratio should be 16:9. The image will be thumbnail for your video.</p>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>

								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label for="subtitle">Subtitle File</label>
								</div>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<input type="file" accept=".vtt, .srt" name="subtitle" id="subtitle">
									<p class="help-block">The Subtitle File should be vtt or srt format. The file will be added as subtitle for your this video.</p>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>

								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label class="checkbox help-block">
										<input type="checkbox" value="on" data-toggle="checkbox" name="votes" id="votes" <?php if($votes == 'on') echo 'checked';?> >&nbsp;
										Allow votes
									</label>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label class="checkbox help-block">
										<input type="checkbox" value="on" data-toggle="checkbox" name="comments" id="comments" <?php if($comments == 'on') echo 'checked';?> >&nbsp;
										Allow comments
									</label>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
<?php 

	if($audio_filename == NULL)
	{

?>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<button type="button" onclick="extractAudio()" class="btn btn-default">Generate Audio File</button>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
<?php
	
	}

?>
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<button type="button" onclick="extractThumbnail()" class="btn btn-default">Generate Automatic Thumbnail</button>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-center">
									<button type="submit" class="btn btn-primary" name="update_button">Save Changes</button>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
							</div>
							
						</form>
						
					</div>
					
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