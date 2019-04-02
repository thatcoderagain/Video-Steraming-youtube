<?php
	
	require_once './core.inc.php';

	if(!is_logged_in())
	{
		header('Location: ./login.php');
		die();
	}

	require_once './init.playlistDelete.inc.php';

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
			
			<!-- Video Setting Form-->
			<div class="container">
			
				<div class="col-xs-12 | col-sm-12 | col-md-12 col-lg-12 | centered"  id="form-box">
				
					<div class="row">
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>
					
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h4 class="help-block"><strong>Delete Playlist</strong></h4>
						</div>
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>
						
						<form action="./playlistDelete.inc.php" method="POST" enctype="multipart/form-data">
						
							<div class="form-group">
						
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
								<input type="hidden" name="name" value="<?php echo htmlentities($name); ?>">
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<h4 class="help-block">
										<strong>
											<?php echo 'Playlist Name : '.htmlentities($name); ?>
										</strong>
									</h4>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>

								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<h6 class="help-block">
										<strong>
											<?php echo 'Created at : '.htmlentities(date('jS M,Y g:ia', strtotime($created_at))); ?>
										</strong>
									</h6>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>

								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<h6 class="help-block">
										<strong>
											<?php echo 'Last updated at : '.htmlentities(date('jS M,Y g:ia', strtotime($updated_at))); ?>
										</strong>
									</h6>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>

								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
									<label class="checkbox help-block">
										<input type="checkbox" value="confirm" data-toggle="checkbox" name="sure">&nbsp;
										Are you sure you want to delete this playlist.
									</label>
								</div>

								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-center">
									<button type="submit" class="btn btn-danger" name="delete_button">Delete playlist</button>
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
			
		</div><!-- end of main div-->
	
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