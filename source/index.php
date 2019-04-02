<?php

	require_once './init.index.inc.php';
	
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
			

				<!-- Container inner div-->
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 centered">
				
					<!-- Container inner row div-->
					<div class="row">

						<!-- One Video div-->
						<div class="col-xs-12 col-xs-offset-0 | col-sm-12 | col-md-12 | col-lg-12 text-left" id="form-box">

							<!-- Line Break div-->
							<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
								<br>
							</div>

							<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
								<h4 class="help-block"><strong>Videos</strong></h4>
							</div>

							<!-- Hor Row div-->
							<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
								<hr>
							</div>

							<div class="row">

<?php

	if(!isset($urlList))
		goto NORESULTS;
	if(count($urlList) >= 1)
	{
		foreach ($urlList as $key => $value)
		{			
			$url = $value;

			# QUERY
			$query = "SELECT `id`, `title`, `description`, `thumbnail_filename`, `published` FROM `videos` WHERE `videos`. `url` = '" . mysqli_real_escape_string($dbconnection, $url) . "'";

			$result = mysqli_query($dbconnection, $query);

			$row = mysqli_fetch_assoc($result);

			$video_id = $row['id'];
			$title = $row['title'];
			$description = $row['description'];            
			$thumbnail_filename = $row['thumbnail_filename'];
			$published = $row['published'];

			# QUERY
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
														echo ($thumbnail_filename != NULL)? htmlentities($thumbnailPath.$thumbnail_filename): htmlentities($thumbnailPath.$defaultThumbnail); 
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
		}
	} else {
		NORESULTS:
?>

								<div class="col-xs-10 col-xs-offset-1 | col-sm-7 col-sm-offset-1 | col-md-8 col-md-offset-1 | col-lg-8 col-lg-offset-1">
									<h5 class="help-block">No result found.</h5>
								</div>

								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
<?php
		}
?>
							</div>

							<!-- Pagination Div -->
							<nav aria-label="Page navigation centered">
								<ul class="pagination">
									<li>
										<a href="<?php echo htmlentities('./index.php?page='.($page-1)); ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
										</a>
									</li>
									<li <?php if($page == 1 || $page == 2) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./index.php?page='.($page-2)); ?>"><?php echo $page-2; ?></a></li>
									<li <?php if($page == 1) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./index.php?page='.($page-1)); ?>"><?php echo $page-1; ?></a></li>
									<li class="active"><a href="<?php echo htmlentities('./index.php?page='.($page)); ?>"><?php echo $page; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./index.php?page='.($page+1)); ?>"><?php echo $page+1; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>><a href="<?php echo htmlentities('./index.php?page='.($page+2)); ?>"><?php echo $page+2; ?></a></li>
									<li <?php if($next == 0) echo 'class="hidden"'; ?>>
										<a href="<?php echo htmlentities('./index.php?page='.($page+1)); ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
										</a>
									</li>
								</ul>
							</nav>
							<!-- End of Pagination Div -->

						</div>
						<!-- End of One Video div-->						
			
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