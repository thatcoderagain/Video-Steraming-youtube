<?php

	require_once './core.inc.php';

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

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

		<!-- Enternal JS 'files' -->
		<script src="./js/searchAjax.js"></script>
		
	</head>
	<body>

		<!-- Navigation Bar Logo -->
		<nav class="navbar navbar-default">
				
			<!-- CNavigation -->
			<div class="navbar-header">
			
				<!-- Site Logo -->
				<a class="navbar-brand" href=".">Play&nbsp;</a>
				
				<!-- Navigation Toggle Button -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
			</div>
			<!-- end of CNavigation -->
			
			<!-- Nav menu -->
			<div class="navbar-collapse collapse ">
				
				<!-- Search form -->
				<ul class="nav navbar-nav navbar-left">
					<li class="container-fluid ">

						<form class="navbar-form" action="searchResult.php" method="GET">
							<div class="input-group" id="playlist_maker">
								
								<input type="text" class="form-control" style="margin-top: 10px;" placeholder="Search for . . ." name="search_input" id="search_input" onkeyup="search()" autocomplete="off">

								<span class="input-group-btn">
									<button class="btn btn-primary" style="margin-top: 10px;" type="submit">
										<span class="glyphicon glyphicon-search"></span>
									</button>
								
								</span>
							</div>

							<div class="hidden col-md-12" id="suggestion_box"></div>
						</form>

					</li>
				</ul>
				
				<!-- Nav Options -->
				<ul class="nav navbar-nav navbar-right">
					<li class="
						<?php
							if(script_filename() == 'index.php')
								echo ' active';					
						?>">
						<a href="./index.php"><strong>Home</strong></a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'passwordRecovery.php')
								echo ' active';
                            else 
                                echo ' hidden';
							if(is_logged_in())
								echo ' hidden';
						?>">
						<a href="./passwordRecovery.php">Password Recovery</a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'login.php')
								echo ' active';
							if(is_logged_in())
								echo ' hidden';
						?>">
						<a href="./login.php">Login</a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'register.php')
								echo ' active';
							if(is_logged_in())
								echo ' hidden';
						?>">
						<a href="./register.php">Register</a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'userVideos.php')
								echo ' active';
                            else 
                                echo ' hidden';
							if(!is_logged_in())
								echo ' hidden';
						?>">
						<a href="./userVideos.php">Videos</a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'userPlaylist.php')
								echo ' active';
                            else 
                                echo ' hidden';
							if(!is_logged_in())
								echo ' hidden';
						?>">
						<a href="./userPlaylist.php">Playlists</a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'userChannel.php')
								echo ' active';
                            else 
                                echo ' hidden';
							if(!is_logged_in())
								echo ' hidden';
						?>">
						<a href="./userChannel.php">Channel</a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'videoSetting.php')
								echo ' active';
                            else 
                                echo ' hidden';
							if(!is_logged_in())
								echo ' hidden';
						?>">
						<a href="./videoSetting.php">Video Setting</a>
					</li>
					
					<li class="
						<?php
							if(script_filename() == 'channelSetting.php')
								echo ' active';
                            else 
                                echo ' hidden';
							if(!is_logged_in())
								echo ' hidden';
						?>">
						<a href="./channelSetting.php">Channel Setting</a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'accountSetting.php')
								echo ' active';
                            else 
                                echo ' hidden';
							if(!is_logged_in())
								echo ' hidden';
						?>">
						<a href="./accountSetting.php">Account Setting</a>
					</li>

					<li class="
						<?php
							if(script_filename() == 'upload.php')
								echo ' active';
                            else 
                                echo ' hidden';
							if(!is_logged_in())
								echo ' hidden';
						?>">
						<a href="./upload.php">Upload Video</a>
					</li>
					
					<!-- Dropdown menu -->
					<li class="dropdown
						<?php
							if(!is_logged_in())
								echo ' hidden';
						?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> &nbsp;Account<span class="caret"></span></a>
						
						<ul class="dropdown-menu dropdown-menu-right">
						
							<li>
								<a href="./upload.php"><span class="glyphicon glyphicon-open"></span> &nbsp; Upload Video</a>
							</li>							
							<li>
								<a href="./userVideos.php"><span class="glyphicon glyphicon-film"></span> &nbsp; Videos</a>
							</li>
							<li>
								<a href="./userChannel.php"><span class="glyphicon glyphicon-facetime-video"></span> &nbsp; Channel</a>
							</li>
							<li>
								<a href="./userPlaylist.php"><i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; Playlists</a>
							</li>
							<li>
								<a href="./channelSetting.php"><span class="glyphicon glyphicon-wrench"></span> &nbsp; Channel Setting</a>
							</li>
							<li>
								<a href="./accountSetting.php"><span class="glyphicon glyphicon-user"></span> &nbsp; Account Setting</a>
							</li>
								<li class="divider"></li>
							<li>
								<a href="./logout.inc.php" ><span class="glyphicon glyphicon-off"></span> &nbsp; Logout</a>
							</li>
						</ul>
					</li>
					<!-- Dropdown menu -->
				</ul>
			</div>
			
		</nav>
		<!-- End of Navigation Bar-->
	
		<!-- *************************************************************************** -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) ********************* -->
		<!-- ********* -><script src="./js/jquery.min.js"></script><!- *************** -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- ********* -><script src="./js/bootstrap.min.js"></script><!- ************ -->
		<!-- Include all compiled plugins for theme --><!-- **************************** -->
		<!-- ********* -><script src="./js/bootflat.min.js"></script><!- ************* -->
		<!-- ********* -><script src="./js/bootstrap-switch.js"></script><!- ********* -->
		<!-- ********* -><script src="./js/checkbox.js"></script><!- ***************** -->
		<!-- ********* -><script src="./js/html5shiv.js"></script><!- **************** -->
		<!-- ********* -><script src="./js/radio.js"></script><!- ******************** -->
		<!-- ********* -><script src="./js/switch.js"></script><!- ******************* -->
		<!-- ********* -><script src="./js/toolbar.js"></script><!- ****************** -->
		<!-- *************************************************************************** -->
		<!-- *************************************************************************** -->
	</body>
</html>