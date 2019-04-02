<?php

    require_once './core.inc.php';
    
    if( isset($_GET['email']) && !empty($_GET['email']) &&
		isset($_GET['hash']) && !empty($_GET['hash']) && strlen($_GET['hash']) == 32)
	{
		$email = $_GET['email'];
		$hash = $_GET['hash'];
	} else {
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

		<script>
			function validator() {
				password1 = document.getElementById('password1').value;
				password2 = document.getElementById('password2').value;

				if(password1 == '' || password2 == '')
				{
					document.getElementById('model_heading').innerHTML = 'Password Reset';
					document.getElementById('model_message').innerHTML = 'Password can\'t be blank.';
					document.getElementById('popUpButton').click();
				}
				else
				if(password1 != password2)
				{
					document.getElementById('model_heading').innerHTML = 'Password Reset';
					document.getElementById('model_message').innerHTML = 'Password does not match.';
					document.getElementById('popUpButton').click();
				}
			}

		</script>
		
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
			
			<!-- Password Recovery Form-->
			<div class="container">
				<div class="col-xs-12 | col-sm-12 | col-md-8 col-md-offset-2 | col-md-8 col-md-offset-2 centered"  id="form-box">
					<div class="row">
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>
					
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 text-left">
							<h4 class="help-block"><strong>Reset Password</strong></h4>
						</div>
						
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>
						
						<div class="form-group">
						
							<form action="./passwordReset.inc.php" method="POST">

								<input type="hidden" name="email" value="<?php echo htmlentities($email);?>">
								<input type="hidden" name="hash" value="<?php echo htmlentities($hash);?>">
						
								<div class="col-xs-12 | col-sm-3 col-sm-offset-1 | col-md-3 col-md-offset-1 | col-lg-3 col-lg-offset-1 text-right">
									<label for="password1">Enter New Password</label>
								</div>
								<div class="col-xs-12 | col-sm-7 | col-md-7 | col-lg-7">
									<div class="form-group input-icon">
										<span class="fa fa-key"></span>
										<input type="password" class="form-control" placeholder="Enter New Password" name="password1" id="password1" required>
									</div>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>

								<div class="col-xs-12 | col-sm-3 col-sm-offset-1 | col-md-3 col-md-offset-1 | col-lg-3 col-lg-offset-1 text-right">
									<label for="password2">Re-Enter Password</label>
								</div>
								<div class="col-xs-12 | col-sm-7 | col-md-7 | col-lg-7">
									<div class="form-group input-icon">
										<span class="fa fa-key"></span>
										<input type="password" class="form-control" placeholder="Re-Enter New Password" name="password2" id="password2" required>
									</div>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
								
								<div class="col-xs-12 | col-sm-7 col-sm-offset-4 | col-md-7 col-md-offset-4 | col-lg-7 col-lg-offset-4">
									<button type="submit" onmouseenter="validator()" class="btn btn-primary" name="reset_button">Reset Password</button>
								</div>
								
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>
							
							</form>
							
						</div>
							
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

<?php
	
?>