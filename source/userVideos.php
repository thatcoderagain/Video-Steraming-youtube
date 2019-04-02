<?php

	require_once './core.inc.php';
	
	if(!is_logged_in())
	{
		header('Location: ./login.php');
		die();
	}

	require_once './init.userVideos.inc.php';

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
			
			<!-- Line Break div-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			
			<!-- Container div-->
			<div class="container">
				
				<!-- Container inner div-->
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 centered"  id="form-box">
				
					<!-- Container inner row div-->
					<div class="row">
						
						<!-- Line Break div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>

						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h4 class="help-block"><strong>Uploaded Videos</strong></h4>
						</div>

						<!-- Hor Row div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>
					
						<!-- One Video div-->
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<div class="row">

<?php
	
	if($result_rows > 0)
	while($row = mysqli_fetch_assoc($result))
        {
            $video_id = $row['id'];
            $title = $row['title'];
            $thumbnail_filename = $row['thumbnail_filename'];
            $published = $row['published'];
            $visibility = $row['visibility'];
            $url = $row['url'];

            # QUERY
			$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'like') ."'";

			$result1 = mysqli_query($dbconnection, $query);
			$likes = mysqli_num_rows($result1);

			# QUERY
			$query = "SELECT `video_id`, `voted_as` FROM `votes` WHERE `votes`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `votes`.`voted_as` = '" . mysqli_real_escape_string($dbconnection, 'dislike') ."'";

			$result2 = mysqli_query($dbconnection, $query);
			$dislikes = mysqli_num_rows($result2);

			# QUERY
			$query = "SELECT `video_id` FROM `views` WHERE `views`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."'";

			$result3 = mysqli_query($dbconnection, $query);
			$views = mysqli_num_rows($result3);

?>

								<!-- 1Row -->
								<div class="container-fluid">

									<!-- Video div -->
									<div class="col-xs-10 col-xs-offset-1 | col-sm-3 col-sm-offset-0 | col-md-3 | col-lg-3">
										<div class="embed-responsive embed-responsive-16by9">								
											<a href="<?php echo htmlentities('./watch.php?video='.$url); ?>">
												<img width="100%" height="auto" src="<?php echo ($thumbnail_filename != NULL)? htmlentities($thumbnailPath.$thumbnail_filename): htmlentities($thumbnailPath.$defaultThumbnail); ?>">
											</a>

										</div>
									</div>
									<!-- EO Video div -->

									<!-- Video Seting div -->
									<div class="col-xs-10 col-xs-offset-1 | col-sm-4 col-sm-offset-1 | col-md-4 | col-lg-4">
										<div class="row">

											<!-- Video Title -->
											<div class="col-xs-12 | col-md-12 | col-md-12 | col-md-12">
												<a class="btn-link" href="<?php echo htmlentities('./watch.php?video='.$url); ?>">
													<h5><?php echo htmlentities($title); ?></h5>
												</a>
											</div>

											<!-- Video Date & Time-->
											<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 text-nowrap">
												<h6 class="help-block"><?php echo htmlentities(date('jS M Y . g:ia', strtotime($published))); ?></h6>
											</div>

											<!-- Buttons -->
											<form action="./videoSetting.php" method="GET">
												<input type="hidden" name="url" value="<?php echo htmlentities($url); ?>">
												<button type="submit" class="col-xs-3 | col-sm-3 | col-md-3 | col-lg-3 btn btn-link btn-xs text-nowrap">Edit</button>
											</form>

											<form action="./videoDelete.php" method="GET">
												<input type="hidden" name="url" value="<?php echo htmlentities($url); ?>">
												<button class="btn-xs col-xs-3 | col-sm-3 | col-md-3 | col-lg-3 btn btn-link btn-xs text-nowrap">Delete</button>
											</form>

											<!-- Visibility -->
											<div class="col-xs-6 | col-md-6 | col-md-6 | col-md-6 text-right visible-xs">
												<h6 class="help-block">
												<span class="glyphicon 
												<?php if($visibility == 'public')
													echo 'glyphicon-eye-open';
													else 
														echo 'glyphicon-eye-close';
													?>">
												</span>
												&nbsp;<?php echo htmlentities($visibility); ?></h6>
											</div>

										</div>
									</div>
									<!-- EO Video Seting div -->

									<!-- Video Profile div -->
									<div class="col-xs-10 col-xs-offset-1 | col-sm-3 | col-md-3 | col-lg-3">
										<div class="row text-right">

											<!-- Visibility -->
											<div class="col-xs-12 | col-md-12 | col-md-12 | col-md-12 hidden-xs">
												<h6 class="help-block">
												<span class="glyphicon 
												<?php if($visibility == 'public')
													echo 'glyphicon-eye-open';
													else 
														echo 'glyphicon-eye-close';
													?>">
												</span>
												&nbsp;<?php echo htmlentities($visibility); ?></h6>
											</div>

											<!-- Views -->
											<div class="col-xs-5 | col-sm-12 | col-md-12 | col-lg-12 text-nowrap">
												<h5 class="help-block"><?php echo htmlentities($views); ?><small>&nbsp;views</small></h5>
											</div>

											<!-- Votes -->
											<div class="col-xs-7 | col-sm-12 | col-md-12 | col-lg-12">
												
												<div class="row">
													<div class="col-xs-6 | col-sm-6 | col-md-5 col-md-offset-2 | col-lg-5 col-lg-offset-2 text-nowrap">
														<h6 class="help-block">
															<span class="glyphicon glyphicon-thumbs-up"></span>
															&nbsp;<?php echo htmlentities($likes); ?>
														</h6>
													</div>
													<div class="col-xs-6 | col-sm-6 | col-md-5 | col-lg-5 text-nowrap">
														<h6 class="help-block">
															<span class="glyphicon glyphicon-thumbs-down"></span>
															&nbsp;<?php echo htmlentities($dislikes); ?>
														</h6>
													</div>
												</div>

											</div>
										</div>
										<!-- EO Video Profile div -->
									</div>

								</div>
								<!-- EO 1Row -->
								
								<!-- Line Break div-->
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<hr>
								</div>
<?php
		} else {
?>
							<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
								<br>
							</div>

							<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
								<h5 class="help-block">No video has been uploaded.</h5>
							</div>
<?php
		}
?>
							</div>

							<!-- Pagination Div -->
							<nav aria-label="Page navigation centered">
								<ul class="pagination">
									<li>
										<a href="<?php echo htmlentities('./userVideos.php?page='.($page-1)); ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
										</a>
									</li>
									<li <?php if($page == 1 || $page == 2) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./userVideos.php?page='.($page-2)); ?>"><?php echo $page-2; ?></a></li>
									<li <?php if($page == 1) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./userVideos.php?page='.($page-1)); ?>"><?php echo $page-1; ?></a></li>
									<li class="active"><a href="<?php echo htmlentities('./userVideos.php?page='.($page)); ?>"><?php echo $page; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./userVideos.php?page='.($page+1)); ?>"><?php echo $page+1; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./userVideos.php?page='.($page+2)); ?>"><?php echo $page+2; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>>
										<a href="<?php echo htmlentities('./userVideos.php?page='.($page+1)); ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
										</a>
									</li>
								</ul>
							</nav>
							<!-- End of Pagination Div -->
							
						</div>
						<!-- End of One Video div-->

						<!-- Line Break div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>					
					
					</div>
					<!-- End of Container inner row div -->
						
				</div>
				<!-- End of Container inner div -->
			
			</div>
			<!-- End of Container div -->

			<!-- Last line break-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			
		</div><!-- End of main div -->
	
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