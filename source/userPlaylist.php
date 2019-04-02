<?php

	require_once './core.inc.php';
	
	if(!is_logged_in())
	{
		header('Location: ./login.php');
		die();
	}

	require_once 'init.userPlaylist.inc.php';
	
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
				
				<!-- Container inner div-->
				<div class="col-xs-12 | col-sm-12 | col-md-8 col-md-offset-2 | col-lg-8 col-lg-offset-2 centered"  id="form-box">
				
					<!-- Container inner row div-->
					<div class="row">
						
						<!-- Line Break div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>

						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h4 class="help-block"><strong>Playlists</strong></h4>
						</div>

						<!-- Hor Row div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>
					
						<!-- One Video div-->
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<div class="row">

<?php

	if($number_of_playlist > 0)
	{
		$playlist_number = 1;
		while($row = mysqli_fetch_assoc($playlist_result))
		{
			$name = $row['name'];

?>

								<!-- Playlist div -->
								<div class="container-fluid">
									<h5 class="help-block">
										<a class="col-xs-10 | col-sm-11 | col-md-11 | col-lg-11 btn btn-warning" 	 data-toggle="collapse" aria-expanded="false"
											aria-controls=<?php
															echo '"playlist'.$playlist_number.'"';
														?>
											data-target=<?php
															echo '"#playlist'.$playlist_number.'"';
														?> >
											<strong><?php
														echo htmlentities($name);
													?>
													<span class="caret"></span>
											</strong>											
										</a>

										<a class="col-xs-2 | col-sm-1 | col-md-1 | col-lg-1 btn btn-danger" aria-expanded="false" 
											href="<?php
														echo htmlentities('./playlistDelete.php?name='.$name);
													?>" >
												<strong>
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</strong>
											
										</a>
									</h5>

									<!-- Video Link div -->
									<div class="col-xs-11 | col-sm-11 | col-md-11 | col-lg-11 text-left collapse"
										id=<?php
												echo '"playlist'.$playlist_number.'"';
											?>>

										<div class="row card card-block">

<?php

			$query = "SELECT `video_id`, `created_at` FROM `playlist` WHERE `playlist`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."' AND `playlist`.`name` = '" . mysqli_real_escape_string($dbconnection, $name) . "' AND `playlist`.`video_id` IS NOT NULL ORDER BY `created_at` DESC";

			$video_result = mysqli_query($dbconnection, $query);
			$number_of_videoes = mysqli_num_rows($video_result);

			if($number_of_videoes > 0)
			{
				while($row = mysqli_fetch_assoc($video_result))
				{
					$video_id = $row['video_id'];
					$created_at = $row['created_at'];

					$query = "SELECT `title`, `url` FROM `videos` WHERE `videos`.`id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."'";

					$result = mysqli_query($dbconnection, $query);
					$result_rows = mysqli_num_rows($result);

					if($result_rows == 1)
					{
						$row = mysqli_fetch_assoc($result);

						$url = $row['url'];
						$title= $row['title'];

?>
											<div class="col-xs-12 | col-sm-12 | col-md-6 | col-lg-6" >
												<h5 class="col-xs-12 | col-sm-12 | col-md-6 | col-lg-6" >
													<a 
													href="<?php
																echo htmlentities('./watch.php?video='.$url);
															?>"	>
														<?php
															echo htmlentities($title);
														?>
													</a>
													<h6 style="margin-top: -10px;margin-bottom: 15px;" class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 help-block">
														<small>
															<?php
																echo htmlentities('Added on '.date('jS M Y . g:ia', strtotime($created_at)));
															?>
														</small>
													</h6>
												</h5>
											</div>
<?php

					}
				}
			} else {
?>
											<h5 class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 help-block" style="padding-bottom: 15px;">
												No video has been added.
											</h5>
<?php
			}
?>
										</div>

									</div>
									<!-- End of Video Link div -->

									<!-- Line Break div-->
									<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
										<br>
									</div>

								</div>
								<!-- End of Playlist div -->
<?php
			$playlist_number += 1;
		}
	} else {

?>								<!-- Line Break div-->
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>

								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<h5 class="help-block">No Playlist has been created.</h5>
								</div>

<?php
	}
?>

							</div>
						</div>
						<!-- End of One Video div-->
											
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