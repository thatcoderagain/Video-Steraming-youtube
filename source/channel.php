<?php

	require_once './core.inc.php';
	
	if(isset($_GET['slug']) && !empty($_GET['slug']))
	{
		require_once 'init.channel.inc.php';

	} else {
		header('Location: ./userChannel.php');
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
		<script src="./js/subscribeAjax.js"></script>
		
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
				
				<!-- Container inner div-->
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 centered"  id="form-box">
				
					<!-- Container inner row div-->
					<div class="row">
						
						<!-- Line Break div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>

						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">

							<div class="row">

								<div class="col-xs-4 | col-sm-3 | col-md-2 |col-lg-1">

									<input type="hidden" name="channel_id" id="channel_id"
									value="<?php
												echo htmlentities($channel_id);
											?>">

									<img class="img-thumbnail channel_image" 
										src="<?php 
											echo htmlentities($channelPath.$image_filename);
										?>">
										
								</div>

								<div class="col-xs-8 | col-sm-4 | col-md-5 | col-lg-5">

									<div class="row">
									
										<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
											<h5 class="help-block">
												<strong>
													<a class="btn-link" 
													href="<?php 
																echo htmlentities('./channel.php?slug='.$slug); 
															?>">
														<?php
															echo htmlentities($channel_name);
														?>
													</a>
												</strong>
											</h5>
										</div>

										<!-- Channel Subscribe button div-->
										<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
											<div class="input-group input-group-sm form-group-sm" id="subscriptionButtonDiv">
												<span class="input-group-btn">
													<button type="button" name="subscribe_button" id="subscribe_button"
														<?php
															if(is_logged_in())
															{
																if($channel_id == channel_id())
																{
																	echo ' class="btn btn-primary" disabled ';
																}
																else if($is_subscribed == 1)
																{
																	echo ' class="btn btn-default"';
																}
																else
																{
																	echo ' class="btn btn-primary"';
																}
															} else {
																echo ' class="btn btn-primary" disabled ';
															}
														?>
														onclick="subscribeUnsubscribe()">
														<i class="fa fa-video-camera" aria-hidden="true"></i>
														<?php
															if(isset($is_subscribed))
															{
																if($is_subscribed == 1)
																{
																	echo ' Unsubscribe';
																}
																else {
																	echo ' Subscribe';
																}
															} else {
																echo ' Subscribe';
															}
														?>
													</button>
												</span>
												<input type="text" class="btn form-control text-center" style="font-size: 10px; width:55px" placeholder="0" 
												value="<?php
															echo htmlentities($subscribers);
														?>"
												 name="subscriber_number" id="subscriber_number" readonly>
											</div>
										</div>
										<!-- End of Channel Subscribe button div-->
										<!-- Line Break div-->
										<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
											<br>
										</div>

										<div class="col-xs-6 | col-md-6">
											<h6 class="help-block">
												<?php
													echo htmlentities($subscribers);
													echo ($subscribers == 1) ? ' subscriber' : ' subscribers';
												?>
											</h6>
										</div>

										<div class="col-xs-6 | col-md-6">
											<h6 class="help-block">
												<?php
													echo htmlentities($video_views_num).' video views';
												?>
											</h6>
										</div>
									</div>
								</div>
							</div>

						</div>

						<!-- Hor Row div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>

						<!-- Description div-->
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h5 class="help-block">
								<?php
									echo htmlentities($description);
								?>
							</h5>
						</div>

						<!-- Line Break div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>

					</div>
					<!-- End of Container inner row div-->

				</div>
				<!-- End of Container inner div-->

				<!-- Line Break div-->
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
					<br>
				</div>

				<!-- Container inner div-->
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 centered"  id="form-box">
				
					<!-- Container inner row div-->
					<div class="row">
						
						<!-- Line Break div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>

						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h4 class="help-block"><strong>Channel Videos</strong></h4>
						</div>

						<!-- Hor Row div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>
					
						<!-- One Video div-->
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<div class="row">

<?php

	if($number_of_videos > 0)
	while($row = mysqli_fetch_assoc($result))
		{
			$video_id = $row['id'];
			$title = $row['title'];
			$description = $row['description'];            
			$thumbnail_filename = $row['thumbnail_filename'];
			$published = $row['published'];
			$url = $row['url'];

			$thumbnail_filename = $thumbnail_filename != NULL ? $thumbnail_filename : $defaultThumbnail;

			$query = "SELECT `video_id` FROM `views` WHERE `views`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."'";

			$result1 = mysqli_query($dbconnection, $query);
			$views = mysqli_num_rows($result1);

			if(strlen($description) > 160)
			{
				$description = substr($description, 0, 160).' . . .';
			}
?>

								<!-- 1Row -->
								<div class="container-fluid">

									<!-- Video div -->
									<div class="col-xs-10 col-xs-offset-1 | col-sm-4 col-sm-offset-0 | col-md-3 | col-lg-3">
										<div class="embed-responsive embed-responsive-16by9">
											<a href="<?php 
														echo htmlentities('./watch.php?video='.$url); 
													?>">
												<img width="100%" height="auto" 
													src="<?php 
														echo htmlentities($thumbnailPath.$thumbnail_filename); 
														?>">
											</a>
										</div>
									</div>
									<!-- End of Video div -->

									<!-- Video detail div -->
									<div class="col-xs-10 col-xs-offset-1 | col-sm-7 col-sm-offset-1 | col-md-8 col-md-offset-1 | col-lg-8 col-lg-offset-1">

										<div class="row">

											<!-- Video Title -->
											<div class="col-xs-12 | col-md-12 | col-md-12 | col-md-12">
												<a class="btn-link" 
													href="<?php 
																echo htmlentities('./watch.php?video='.$url); 
															?>">
													<h5>
														<?php 
															echo htmlentities($title); 
														?>
													</h5>
												</a>
											</div>

											<!-- Video DateTime div-->
											<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
												<h6 class="help-block">
													<?php 
														echo htmlentities($views . ' views') . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . htmlentities(date('jS M,Y . g:ia', strtotime($published))); 
													?>
												</h6>
											</div>

											<!-- Video DateTime div-->
											<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
												<h6 class="help-block">
													<?php 
														echo htmlentities($description); 
													?>
												</h6>
											</div>
											
										</div>

									</div>
									<!-- End of Video detail div -->

								</div>
								<!-- End of 1Row -->
								
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
										<a href="<?php echo htmlentities('./channel.php?slug='.$_GET['slug'].'&page='.($page-1)); ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
										</a>
									</li>
									<li <?php if($page == 1 || $page == 2) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./channel.php?slug='.$_GET['slug'].'&page='.($page-2)); ?>"><?php echo $page-2; ?></a></li>
									<li <?php if($page == 1) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./channel.php?slug='.$_GET['slug'].'&page='.($page-1)); ?>"><?php echo $page-1; ?></a></li>
									<li class="active"><a href="<?php echo htmlentities('./channel.php?slug='.$_GET['slug'].'&page='.($page)); ?>"><?php echo $page; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./channel.php?slug='.$_GET['slug'].'&page='.($page+1)); ?>"><?php echo $page+1; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./channel.php?slug='.$_GET['slug'].'&page='.($page+2)); ?>"><?php echo $page+2; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>>
										<a href="<?php echo htmlentities('./channel.php?slug='.$_GET['slug'].'&page='.($page+1)); ?>" aria-label="Next">
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